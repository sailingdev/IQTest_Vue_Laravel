<?php

namespace App\Http\Controllers\Api\V1;

use App\Answer;
use App\Question;
use App\Http\Controllers\Controller;
use App\Http\Resources\Answer as AnswerResource;
use App\Http\Requests\Admin\StoreAnswersRequest;
use App\Http\Requests\Admin\UpdateAnswersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\GlobalConstants;

class AnswersController extends Controller
{


    public function index()
    {
        return new AnswerResource(Answer::all());
    }

    public function getAnswers($qId)
    {
        $question = Question::findOrFail($qId);
        $testType = $question->test->category->test_type;

        $answers = Answer::where('question_id', $qId)->get();
        $answerArr = array();
        foreach ($answers as $answer) {
            $tran = $answer->getTranslation();
            if (!$tran) {
                continue;
            }
            array_push($answerArr, [
                'id'            =>  $answer->id,
                'txt'           =>  $tran['txt'],
                'result_text'   => $tran['result_text'],
                'img_url'       => $answer->img_url,
                'score'         => $testType == GlobalConstants::MULTI_FACTOR_TEST_TYPE ? null : $answer->score,
            ]);
        }
        return new AnswerResource($answerArr);
    }

    private function saveImage($image)
    {
        $ext = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $ext = explode('+', $ext)[0];
        $name = time() . '.' . $ext;
        $url = public_path('uploads/images/answer/') . $name;

        $header = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($header, '', $image);
        $image = str_replace(' ', '+', $image);

        file_put_contents($url, base64_decode($image));
        return '/uploads/images/answer/' . $name;
    }

    public function store(StoreAnswersRequest $request)
    {
        if (Gate::denies('answer_create')) {
            return abort(401);
        }
        if ($request->get('img')) {
            $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
        } else if ($request->txt == null) {
            return response("Validation Error", 500);
        }
        //$answer = Answer::create($request->all());
        $answer = new Answer();
        $answer = $answer->insertRecord($request->all());

        return (new AnswerResource($answer))
            ->response()
            ->setStatusCode(201);
    }
    public function getAnswer($id, $locale)
    {
        $answer = Answer::findOrFail($id);
        $detail = $answer->getTranslation($locale);

        //*********test code********
        //$answer->factors()->sync([1 => ['weight' => 3], 2 => ['weight' => 3], 3 => ['weight' => 3]]);
        //**************************
        //get test Type
        $test = $answer->question()
            ->first()
            ->test()
            ->first();

        $testType = $test
            ->category
            ->test_type;

        //if test type is Exam or Multi factor, then Score has to be disable
        $answer->score = $testType == GlobalConstants::MULTI_FACTOR_TEST_TYPE ? null : $answer->score;
        //only for Multi Factors Test
        if ($testType == GlobalConstants::MULTI_FACTOR_TEST_TYPE) {
            //get all factors
            $allFactors = $test
                ->factors()
                ->get();
            //get relative factors
            $relativeFactors = $answer->answerFactors()->get();


            $factorArr = array();
            foreach ($allFactors as $factor) {
                $tran = $factor->getTranslation();
                if (!$tran) {
                    continue;
                }

                //$relFactor = $answer->answerFactors()->where('factor_id', '=', $factor->id)->first();
                //$factorWeight = $relFactor ? $relFactor->weight : 0;

                //fast speed
                $factorWeight = 0;
                foreach ($relativeFactors as $relFactor) {
                    if ($relFactor->factor_id == $factor->id) {
                        $factorWeight = $relFactor->weight;
                        break;
                    }
                }

                array_push($factorArr, [
                    'id'        =>  $factor->id,
                    'title'     =>  $tran['title'],
                    'weight'    =>  $factorWeight
                ]);
            }

            $detail = array_merge($detail, [
                'factors'   =>  $factorArr
            ]);
        }


        return new AnswerResource(array_merge($answer->toArray(), $detail));
    }

    public function show($id)
    {
        if (Gate::denies('answer_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';
        return $this->getAnswer($id, $locale);
    }

    public function update(UpdateAnswersRequest $request, $id)
    {
        if (Gate::denies('answer_edit')) {
            return abort(401);
        }

        if ($request->get('img')) {
            if (!$request->get('img_url') || $request->img != $request->img_url) {
                $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
            }
        } else {
            //delete file
            $request->merge(['img_url' => null]);
        }
        $answer = Answer::findOrFail($id);
        $answer->updateRecord($request->all());
        $locale = isset($request->locale) ? $request->locale : 'en';
        return ($this->getAnswer($id, $locale))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('answer_delete')) {
            return abort(401);
        }

        $answer = Answer::findOrFail($id);
        $answer->delete();

        return response(null, 204);
    }
}