<?php

namespace App\Http\Controllers\Api\V1;

use App\Question;
use App\Test;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question as QuestionResource;
use App\Http\Requests\Admin\StoreQuestionsRequest;
use App\Http\Requests\Admin\UpdateQuestionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class QuestionsController extends Controller
{
    public function index()
    {
        return new QuestionResource(Test::all());
    }
    public function getQuestions($tId)
    {

        $page = isset($_GET['page']) ? $_GET['page'] : 'all';

        if ($page == 'all') {
            $questions = Question::where('test_id', $tId)
                ->get();
        } else {
            $questions = Question::where('test_id', $tId)
                ->where('page', $page)
                ->get();
        }



        $test = Test::find($tId);
        $questionArr = array();
        foreach ($questions as $question) {
            //get english value for default
            $tran = $question->getTranslation();
            if (!$tran) {
                continue;
            }
            array_push($questionArr, [
                'id' => $question->id,
                'txt' => $tran['txt'],
                'img_url' => $question->img_url,
                'topic_name' => $question->topicName(),
                'topic_id' => $question->topic_id,
                'page' => $question->page,
                'question_type' =>  $question->question_type == 0 ? "Single Choice" : "Multiple Choice",
                'correct_ans_exp' => $tran['correct_ans_exp'],
                'answer_cnt' => $question->answers()->count()
            ]);
        }
        //return new QuestionResource($questionArr);
        return new QuestionResource([
            'items' => $questionArr,
            'test' => ['id' => $tId, 'title' => $test->getTranslation()['title']]
        ]);
    }
    private function saveImage($image)
    {
        $ext = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $ext = explode('+', $ext)[0];
        $name = time() . '.' . $ext;
        $url = public_path('uploads/images/question/') . $name;


        $header = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($header, '', $image);
        $image = str_replace(' ', '+', $image);

        file_put_contents($url, base64_decode($image));
        return '/uploads/images/question/' . $name;
    }
    public function store(StoreQuestionsRequest $request)
    {
        if (Gate::denies('question_create')) {
            return abort(401);
        }
        if ($request->topic_id > 0) {
            $cnt = Question::where('topic_id', $request->topic_id)
                ->where('test_id', $request->test_id)
                ->count();
            if ($cnt > 0) {
                //there is also topic in this test
                return response(['message' => "This key topic is already set!"], 422)
                    ->header('Content-Type', 'text/json');
            }
        }


        if ($request->get('img')) {
            $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
        } else if ($request->txt == null) {
            return response("Validation Error", 500);
        }
        //$question = Question::create($request->all());
        $question = new Question();
        $question = $question->insertRecord($request->all());


        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(201);
    }
    public function getQuestion($id, $locale)
    {
        if (!$locale) {
            $locale = 'en';
        }
        $question = Question::with([])->findOrFail($id);
        $otherInfo = [
            'answer_cnt' => $question->answers()->count(),
            'img' => $question->img_url,
            'topic_name' => $question->topicName()
        ];

        $detail = array_merge($question->getTranslation($locale), $otherInfo);

        return new QuestionResource(array_merge($question->toArray(), $detail));
    }
    public function show($id)
    {
        if (Gate::denies('question_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';

        return $this->getQuestion($id, $locale);
    }
    public function update(UpdateQuestionsRequest $request, $id)
    {
        if (Gate::denies('question_edit')) {
            return abort(401);
        }
        $question = Question::findOrFail($id);
        if ($request->topic_id > 0) {
            $cnt = Question::where('topic_id', $request->topic_id)
                ->where('test_id', $request->test_id)
                ->count();
            if ($cnt > 0 && $question->topic_id != $request->topic_id) {
                //there is also topic in this test
                return response(['message' => "This key topic is already set!"], 422)
                    ->header('Content-Type', 'text/json');
            }
        }
        if ($request->get('img')) {
            if (!$request->get('img_url') || $request->img != $request->img_url) {
                $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
            }
        } else {
            //delete file
            $request->merge(['img_url' => null]);
        }

        //$question->update($request->all());
        $question->updateRecord($request->all());
        $locale = isset($request->locale) ? $request->locale : 'en';

        return ($this->getQuestion($id, $locale))
            ->response()
            ->setStatusCode(202);
    }
    public function destroy($id)
    {
        if (Gate::denies('question_delete')) {
            return abort(401);
        }

        $question = Question::findOrFail($id);
        $question->delete();

        return response(null, 204);
    }
}