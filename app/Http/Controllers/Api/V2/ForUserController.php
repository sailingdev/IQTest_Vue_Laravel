<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Test as TestResource;
use App\Language;
use App\Test;
use App\Question;
use App\Answer;
use App\TestResult;
use App\Category;
use App\Http\Controllers\Api\V1\TestsController;
use App\Http\Requests\Admin\StoreTestResultsRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Stripe;
use Response;
use PDF;
use View;
use GuzzleHttp\Client;
use App\GlobalConstants;
use Dompdf\FrameDecorator\Image;
use function GuzzleHttp\json_decode;

class ForUserController extends Controller
{

    private $STRIPE_PK_KEY;
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->STRIPE_PK_KEY    =   \Config::get('values.stripe_pk_key');
    }

    public function getAllTests(Request $request)
    {
        $locale = $request->session()->get('locale', 'en');
        $tests = Test::all();
        return TestsController::convert($tests, $locale);
    }
    public function getTests(Request $request, $cId)
    {
        $locale = $request->session()->get('locale', 'en');
        $tests = Test::where('category_id', $cId)
            ->get();
        return TestsController::convert($tests, $locale);
    }
    public function getTest(Request $request, $id)
    {
        //$locale = isset($_GET['locale'])?$_GET['locale']:'en';

        //get locale from session
        $locale = $request->session()->get('locale', 'en');

        $test = Test::with([])->findOrFail($id);
        $otherInfo = [
            'question_cnt'      =>  $test->questions()->count(),
            'result_cnt'        =>  $test->results()->count(),
            'pre_question_cnt'  =>  $test->pageQuestionsCnt('pre'),
            'post_question_cnt' =>  $test->pageQuestionsCnt('post')
        ];

        $detail = array_merge($test->getTranslation($locale), $otherInfo);
        return new TestResource(array_merge($test->toArray(), $detail));
    }
    //**************************for user******************** */
    public function getFullTestData(Request $request, $id)
    {
        //$locale = isset($_GET['locale'])?$_GET['locale']:'en';

        //get locale from session
        $locale = $request->session()->get('locale', 'en');
        //return $locale;

        $test = Test::with([])->findOrFail($id);
        $tran = $test->getTranslation($locale);
        $fullTestData = [
            'id'                =>  $test->id,
            'test_type'         =>  $test->category->test_type,
            'title'             =>  $tran['title'],
            'pre_page_title'    =>  $tran['pre_page_title'],
            'pre_page_desc'     =>  $tran['pre_page_desc'],
            'post_page_title'   =>  $tran['post_page_title'],
            'post_page_desc'    =>  $tran['post_page_desc'],
            'time'              =>  $test->time,
            'question_cnt'      =>  $test->questions()->count(),
            'questions'         =>  $test->getQuestions($locale),
            'locale'              => $locale
        ];
        return new TestResource($fullTestData);
    }

    private function sendUserInfoToVictor($request)
    {

        $url = 'http://www.panelsms.com/registros/in.php?'
            . 'userIP=' . $request->user_ip
            . '&userName=' . $request->user_name
            . '&mobileNumber=' . $request->mobile_number
            . '&country=' . $request->country;
        $topics = json_decode($request->topic_key);
        foreach ($topics as $topic) {
            $url .= ('&' . $topic->topic . '=' . $topic->answer);
        }
        echo $url;
        exit();
        $client = new Client();
        $res = $client->get($url);
        // echo $res->getBody();
    }
    //****************************************************** */

    public function saveTestResult(StoreTestResultsRequest $request)
    {
        $result = TestResult::create($request->all());
        $token = md5(microtime(true) . mt_Rand());
        $result->token = $token;
        $result->save();

        //----send data to Victor's Database-----
        $this->sendUserInfoToVictor($request);
        //---------------------------------------

        return new JsonResource([
            'token' =>  $token,
            'id'    =>  $result->id
        ]);
    }
    public function getOrder(Request $request, $token)
    {
        $order = TestResult::where('token', $token)->first();
        if ($order == null) {
            return abort(404);
        }
        $testType = $order->test->category->test_type;
        //get locale from session
        $locale = $request->session()->get('locale', 'en');
        $test = Test::with([])->findOrFail($order->test_id);
        $tran = $test->getTranslation($locale);

        return new JsonResource([
            'token'         =>  $order->token,
            'id'            =>  $order->id,
            'title'         =>  $tran['title'],
            'eval_logo_img' =>  $test->evaluation_logo_img_url,
            'cert_logo_img' =>  $test->certific_logo_img_url,
            'extra_logo_img' =>  $test->extra_logo_img_url,
            'time'          =>  $testType == GlobalConstants::EXAM_TEST_TYPE ? $order->time : null,
            'initial_price' => ((float) number_format((float) $test->initial_price, 2, '.', '')) * 100,
            'extra_price'   => ((float) number_format((float) $test->extra_price, 2, '.', '')) * 100,
        ]);
    }

    public function stripePost(Request $request)
    {
        if (!isset($request['token']) || !isset($request['stripeToken'])) {
            return abort(404);
        }

        $testToken = $request->token;
        $testResult = TestResult::where('token', $testToken)->first();
        $test = Test::findOrFail($testResult->test_id);

        if ($testResult == null) {
            return abort(404);
        }

        Stripe\Stripe::setApiKey($this->STRIPE_PK_KEY);
        $amount = ((float) number_format((float) $test->initial_price, 2, '.', '')) * 100;
        $amount += $request->extra_pay == 1 ? ((float) number_format((float) $test->extra_price, 2, '.', '')) * 100 : 0;
        try {
            Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                //"source" => $request->stripeToken,
                "source" => 'tok_visa',
                "description" => "Test payment from yourowntest.com"
            ]);
        } catch (\Stripe\Error\Base $e) {
            // Code to do something with the $e exception object when an error occurs
            return new JsonResource([
                'status'    =>  'error',
                'message'   =>  $e->getMessage()
            ]);
        } catch (Exception $e) {
            // Catch any other non-Stripe exceptions
            return new JsonResource([
                'status'    =>  'error',
                'message'   =>  $e->getMessage()
            ]);
        }


        $testResult->pay_amount = $amount / 100;
        $testResult->pay_status = 1;
        $testResult->extra_pay = $request->extra_pay;
        $testResult->save();

        //send messsage
        //https://www.panelsms.com/httpinput/sendSms.php?user=testingP&password=wb7jk2cp&to=%2B34619771052&senderId=Verify&text=Hello+this+is+an+sms
        $resultUrl = 'https://yourowntest.com/user/main/' . $testToken . '/result';
        $mobileNumber = '%2B34619771052';
        //$mobileNumber = $testResult->mobile_number
        $message = 'You can check your test result! ' . $resultUrl . ' From yourowntest.com';
        $url = 'https://www.panelsms.com/httpinput/sendSms.php?user=testingP&password=wb7jk2cp&to=' . $mobileNumber . '&senderId=YourOwnTest&text=' . $message;

        //$client = new Client();
        //$res = $client->get($url);
        //echo $res->getStatusCode(); // 200
        //echo $res->getBody();


        //return $res->getBody();
        return "success";

        //   try{
        //         Stripe\Charge::create ([
        //             "amount" => 100 * 100,
        //             "currency" => "usd",
        //             //"source" => $request->stripeToken,
        //             "source" => 'tok_visa',
        //             "description" => "Test payment from itsolutionstuff.com." 
        //         ]);
        //   } catch (\Stripe\Error\Base $e) {
        //     // Code to do something with the $e exception object when an error occurs
        //     return new JsonResource([
        //         'status'    =>  'error',
        //         'message'   =>  $e->getMessage()
        //     ]);
        //   } catch (Exception $e) {
        //     // Catch any other non-Stripe exceptions
        //     return new JsonResource([
        //         'status'    =>  'error',
        //         'message'   =>  $e->getMessage()
        //     ]);
        //   }
        //   //Session::flash('success', 'Payment successful!');

        //   return new JsonResource([
        //     'status'    =>  'success',
        //     'message'   =>  'Payment success'
        // ]);
    }

    public function getTestType($token)
    {
        $testResult = TestResult::where('token', $token)->first();

        if ($testResult == null) {
            return abort(404);
        }
        if ($testResult->pay_status == 0) {
            return abort(404);
        }
        $test = Test::findOrFail($testResult->test_id);
        if ($test == null) {
            return abort(404);
        }
        return $test->category->test_type;
    }

    private function getExamResultData($testResult, $test)
    {
        $questions = json_decode($testResult->result);

        $totalQuestions = $test->getNormalQuestionsCnt();
        $successQuestions = 0;
        $failedQuestions = 0;
        $notAnswersQuestions = 0;

        foreach ($questions as $question) {
            $realQuestion = Question::findOrFail($question->questionId);
            if ($realQuestion == null || $realQuestion->getBestAnswer() == -1) {
                continue;
            }
            $correctAnsId = $realQuestion->getBestAnswer();
            if ($question->answerId == null) {
                $notAnswersQuestions++;
            } else if ($correctAnsId == $question->answerId) {
                $successQuestions++;
            } else {
                $failedQuestions++;
            }
        }
        $score = 100 * ($successQuestions / $totalQuestions);

        return new JsonResource([
            'score'                     =>  (int) $score,
            'totalQuestions'            =>  $totalQuestions,
            'successQuestions'          =>  $successQuestions,
            'failedQuestions'           =>  $failedQuestions,
            'notAnswersQuestions'       =>  $notAnswersQuestions,
            'canDownload'               =>  $testResult->extra_pay == 1
        ]);
    }

    private function getMultiFactorsResultData($testResult, $test, $locale)
    {


        $questions = json_decode($testResult->result);
        //get all factors
        $allFactors = $test
            ->factors()
            ->get();
        $factorArr = array();
        foreach ($allFactors as $factor) {
            $tran = $factor->getTranslation($locale);
            if (!$tran) {
                continue;
            }
            $info = $factor->getResults($locale);
            $factorArr[$factor->id] = [
                'id'                =>  $factor->id,
                'title'             =>  $tran['title'],
                'description'       =>  $tran['description'],
                'img_url'           =>  $factor->img_url,
                'results'           =>  $info['results'],
                'background_color'  =>  $info['background_color'],
                'formula'           =>  $factor->formula,
                'weight'            =>  0,
                'result_text'       =>  '',
                'correct_color'     =>  '#eb5c21',
            ];
        }
        foreach ($questions as $question) {
            if (!$question->answerId) {
                continue;
            }
            $answer = Answer::findOrFail($question->answerId);
            if (!$answer) {
                continue;
            }
            $relativeFactors = $answer->answerFactors()->get();
            foreach ($relativeFactors as $relFactor) {
                $factorArr[$relFactor->factor_id]['weight'] += $relFactor->weight;
                if ($factorArr[$relFactor->factor_id]['weight'] > 100) {
                    $factorArr[$relFactor->factor_id]['weight'] = 100;
                }
            }
        }


        foreach ($factorArr as $factor) {
            $weight = $factor['weight'];
            if ($factor['formula'] != 0) {
                $weight = pow(10, $weight);
            }
            if ($weight - (int) $weight != 0) {
                $weight = (float) number_format($weight, 1, '.', '');
            } else {
                $weight = (int) $weight;
            }
            $factorArr[$factor['id']]['weight'] = $weight;

            $index = 0;
            foreach ($factor['results'] as $result) {
                if ($weight >= $result['min_score'] && $weight <= $result['max_score']) {
                    $factorArr[$factor['id']]['result_text']   =   $result['title'];
                    $factorArr[$factor['id']]['correct_color']    =   $result['color'];
                    break;
                }
                $index++;
            }
        }

        return new JsonResource([
            'test_title'    =>  $test->getTranslation()['title'],
            'factors'       =>  $factorArr,
            'canDownload'   =>  $testResult->extra_pay == 1
        ]);
    }

    private function getSingleFactorResultData($testResult, $test)
    { }


    public function getResultData(Request $request, $token)
    {
        $testResult = TestResult::where('token', $token)->first();

        if ($testResult == null) {
            return abort(404);
        }
        if ($testResult->pay_status == 0) {
            return abort(404);
        }
        $test = Test::findOrFail($testResult->test_id);
        if ($test == null) {
            return abort(404);
        }
        $testType = $test->category->test_type;
        //get locale from session
        $locale = $request->session()->get('locale', 'en');

        switch ($testType) {
            case GlobalConstants::EXAM_TEST_TYPE:
                return $this->getExamResultData($testResult, $test);
                break;
            case GlobalConstants::SINGLE_FACTOR_TEST_TYPE:
                return $this->getSingleFactorResultData($testResult, $test);
                break;
            case GlobalConstants::MULTI_FACTOR_TEST_TYPE:
                return $this->getMultiFactorsResultData($testResult, $test, $locale);
                break;
        }
    }

    public function getCertificationFile(Request $request, $token)
    {

        $testResult = TestResult::where('token', $token)->first();

        if ($testResult == null) {
            return abort(404);
        }
        if ($testResult->pay_status == 0) {
            return abort(404);
        }
        $test = Test::findOrFail($testResult->test_id);
        if ($test == null) {
            return abort(404);
        }
        $testType = $test->category->test_type;
        //get locale from session
        $locale = $request->session()->get('locale', 'en');
        $resultData = null;
        switch ($testType) {
            case GlobalConstants::EXAM_TEST_TYPE:
                $resultData =  $this->getExamResultData($testResult, $test);
                break;
            case GlobalConstants::SINGLE_FACTOR_TEST_TYPE:
                $resultData = $this->getSingleFactorResultData($testResult, $test);
                break;
            case GlobalConstants::MULTI_FACTOR_TEST_TYPE:
                $resultData = $this->getMultiFactorsResultData($testResult, $test, $locale);
                break;
        }

        $strArr = \explode('.', $test->certification_file_url);
        if ($strArr < 3 || $resultData == null) {
            return new JsonResource([
                'status'    =>  'fail',
                'message'   =>  "Error!"
            ]);
        }


        $bladeFileName = $strArr[0];

        View::addLocation(public_path());
        $htmlContent = View::make(
            $bladeFileName,
            [
                'result'     => $resultData,
                'userName'   => $testResult->user_name,

            ]
        )->render();

        $HEAD_END_TAG = '</head>';
        $pos = strpos($htmlContent, $HEAD_END_TAG);
        if ($pos !== false) {
            $htmlContent = substr_replace(
                $htmlContent,
                '
                <style>
                    body {
                        background-image: url(' . $test->certification_img_url . ');
                        margin: 0px;
                        height: 100%;
                        background-position: center;
                        background-repeat: no-repeat;
                        -webkit-background-size: cover;
                        -moz-background-size: cover;
                        -o-background-size: cover;
                        background-size: auto auto;
                    }
                    @page {
                        margin: 0px;
                    }
                </style>',
                $pos + strlen($HEAD_END_TAG),
                0
            );
        };
        //        echo $htmlContent;

        //$pdf = PDF::loadView($bladeFileName, ['result' => $score])->setPaper('a4', 'landscape');
        $pdf = PDF::loadHTML($htmlContent)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->download('Certification' . $token . ".pdf");
    }

    public function getDownloadFile($token)
    {

        $testResult = TestResult::where('token', $token)->first();
        if ($testResult == null) {
            return new JsonResource([
                'status'    =>  'fail',
                'message'   =>  'There is result for this token'
            ]);
        }

        if ($testResult->pay_status == 0 || $testResult->extra_pay == 0) {
            return new JsonResource([
                'status'    =>  'fail',
                'message'   =>  "You didn't pay for this!"
            ]);
        }

        $file = public_path() . "/web_content/pdf/" . \Config::get('values.text_book_name');

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, \Config::get('values.text_book_name'), $headers);
    }
}