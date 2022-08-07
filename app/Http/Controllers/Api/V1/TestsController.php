<?php

namespace App\Http\Controllers\Api\V1;

use App\Test;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Test as TestResource;
use App\Http\Requests\Admin\StoreTestsRequest;
use App\Http\Requests\Admin\UpdateTestsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Input;
use App\GlobalConstants;

class TestsController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return $this->convert($tests);
    }
    public static function getSubString($str)
    {
        $TEXT_LIMIT = 100;
        return $str;
        //return strlen($str) > $TEXT_LIMIT ? substr($str, 0, $TEXT_LIMIT) . '...' : $str;
    }
    public static function convert($tests, $locale = 'en')
    {
        $testArr = array();
        foreach ($tests as $test) {
            //get english value for default
            $tran = $test->getTranslation($locale);
            //added in 2019/05/31 for Test Type
            $testType = $test->category->test_type;
            //test time is for only Exam test
            $testTime = $testType == 1 ? $test->time : null;
            //result cnt is for only Assessment Single Factor
            $resultCnt = $testType == 2 ? $test->results()->count() : null;
            if (!$tran) {
                continue;
            }



            array_push($testArr, [
                'id' => $test->id,
                'title'             =>  $tran['title'],
                'time'              =>  $testTime,
                'description'       =>  TestsController::getSubString($tran['description']),
                'instruction'       =>  TestsController::getSubString($tran['instruction']),
                'question_cnt'      =>  $test->questions()->count(),
                'result_cnt'        =>  $resultCnt,
                'pre_question_cnt'  =>  $test->pageQuestionsCnt('pre'),
                'post_question_cnt' =>  $test->pageQuestionsCnt('post'),
                'category_title'    =>  $test->category->getTranslation()['title']
            ]);
        }
        return new TestResource($testArr);
    }

    public function getTests(Request $request, $cId)
    {

        //$request->session()->put('test_type', $testType);
        $tests = Test::where('category_id', $cId)
            ->get();
        return $this->convert($tests);
    }

    public function getTest($id, $locale = 'en')
    {
        if (!$locale) {
            $locale = 'en';
        }
        $test = Test::with([])->findOrFail($id);
        $testType = $test->category->test_type;
        //if test type isn't Exam
        if ($testType != 1) {
            $test->time = null;
        }
        $resultCnt = $testType == 2 ? $test->results()->count() : null;
        $factorCnt = $testType == 3 ? $test->factors()->count() : null;

        $otherInfo = [
            'question_cnt'      =>  $test->questions()->count(),
            'factor_cnt'        =>  $factorCnt,
            'result_cnt'        =>  $resultCnt,
            'pre_question_cnt'  =>  $test->pageQuestionsCnt('pre'),
            'post_question_cnt' =>  $test->pageQuestionsCnt('post'),
            //'certification_file_url' => $test->certification_file_url,
        ];

        $detail = array_merge($test->getTranslation($locale), $otherInfo);


        return new TestResource(array_merge($test->toArray(), $detail));
    }

    public function show($id)
    {
        if (Gate::denies('test_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';

        return $this->getTest($id, $locale);
    }
    public function getPageInfo($id)
    {
        if (Gate::denies('test_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';
        $test = Test::with([])->findOrFail($id);
        $translation = $test->getTranslation($locale);

        $data = [
            'id'                =>  $test['id'],
            'category_id'       =>  $test['category_id'],
            'pre_page_title'    =>  $translation['pre_page_title'],
            'pre_page_desc'     =>  $translation['pre_page_desc'],
            'post_page_title'   =>  $translation['post_page_title'],
            'post_page_desc'    =>  $translation['post_page_desc'],
            'pre_question_cnt'  =>  $test->pageQuestionsCnt('pre'),
            'post_question_cnt' =>  $test->pageQuestionsCnt('post')
        ];


        return new TestResource($data);
        //return $test;

    }

    public function store(StoreTestsRequest $request)
    {
        if (Gate::denies('test_create')) {
            return abort(401);
        }

        //save certification file
        if (isset($request->certification_file)) {
            $file = $request->file('certification_file');
            $path = public_path(GlobalConstants::CERTIFICATION_FILE_PATH);
            $fileName = random_int(0, 10000) . time() . $file->getClientOriginalName();
            $file->move($path,  $fileName);
            $request->merge(['certification_file_url' => GlobalConstants::CERTIFICATION_FILE_PATH . $fileName]);
        }
        //save extra pdf
        if (isset($request->extra_file)) {
            $file = $request->file('extra_file');
            $path = public_path(GlobalConstants::EXTRA_PDF_FILE_PATH);
            $fileName = random_int(0, 10000) . time() . $file->getClientOriginalName();
            $file->move($path,  $fileName);
            $request->merge(['extra_file_url' => GlobalConstants::EXTRA_PDF_FILE_PATH . $fileName]);
        }
        $imgURLStrArr = ['certification_img_url', 'certific_logo_img_url', 'evaluation_logo_img_url', 'extra_logo_img_url'];
        $imgStrArr = ['certification_img', 'certific_logo_img', 'evaluation_logo_img', 'extra_logo_img'];
        $urlArr = [GlobalConstants::CERTIFICATION_BACK_IMG_PATH, GlobalConstants::CERTIFICATION_LOGO_IMG_PATH, GlobalConstants::EVALUATION_LOGO_IMG_PATH, GlobalConstants::EXTRA_LOGO_IMG_PATH];

        for ($i = 0; $i < count($imgURLStrArr); $i++) {
            if ($request->get($imgStrArr[$i])) {
                $request->merge([$imgURLStrArr[$i] => GlobalConstants::saveBase64Image($urlArr[$i], $request->get($imgStrArr[$i]))]);
            }
        }

        $test = new Test();
        $test = $test->insertRecord($request->all());


        return (new TestResource($test))
            ->response()
            ->setStatusCode(201);
    }
    public function update(UpdateTestsRequest $request, $id)
    {
        if (Gate::denies('test_edit')) {
            return abort(401);
        }

        if (isset($request->certification_file)) {
            $file = $request->file('certification_file');
            $path = public_path(GlobalConstants::CERTIFICATION_FILE_PATH);
            $fileName = random_int(0, 10000) . time() . $file->getClientOriginalName();
            $file->move($path,  $fileName);
            $request->merge(['certification_file_url' => GlobalConstants::CERTIFICATION_FILE_PATH . $fileName]);
        }
        if (!isset($request->certification_file_url)) {
            $request->merge(['certification_file_url' => null]);
        }

        //save extra pdf file
        if (isset($request->extra_file)) {
            $file = $request->file('extra_file');
            $path = public_path(EXTRA_PDF_FILE_PATH);
            $fileName = random_int(0, 10000) . time() . $file->getClientOriginalName();
            $file->move($path,  $fileName);
            $request->merge(['extra_file_url' => EXTRA_PDF_FILE_PATH . $fileName]);
        }
        if (!isset($request->extra_file_url)) {
            $request->merge(['extra_file_url' => null]);
        }
        $imgURLStrArr = ['certification_img_url', 'certific_logo_img_url', 'evaluation_logo_img_url', 'extra_logo_img_url'];
        $imgStrArr = ['certification_img', 'certific_logo_img', 'evaluation_logo_img', 'extra_logo_img'];
        $urlArr = [GlobalConstants::CERTIFICATION_BACK_IMG_PATH, GlobalConstants::CERTIFICATION_LOGO_IMG_PATH, GlobalConstants::EVALUATION_LOGO_IMG_PATH, GlobalConstants::EXTRA_LOGO_IMG_PATH];


        for ($i = 0; $i < count($imgURLStrArr); $i++) {
            if ($request->get($imgStrArr[$i])) {
                if (!$request->get($imgURLStrArr[$i]) || $request->get($imgStrArr[$i]) != $request->get($imgURLStrArr[$i])) {
                    $request->merge([$imgURLStrArr[$i] => GlobalConstants::saveBase64Image($urlArr[$i], $request->get($imgStrArr[$i]))]);
                }
            } else {
                $request->merge([$imgURLStrArr[$i] => null]);
            }
        }


        $locale = isset($request->locale) ? $request->locale : 'en';

        $test = Test::findOrFail($id);
        //$test->update($request->all());
        $test->updateRecord($request->all());

        return ($this->getTest($id, $locale))
            ->response()
            ->setStatusCode(202);
    }
    public function destroy($id)
    {
        if (Gate::denies('test_delete')) {
            return abort(401);
        }

        $test = Test::findOrFail($id);
        $test->delete();

        return response(null, 204);
    }
}