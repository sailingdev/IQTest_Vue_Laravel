<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Question
 *
 * @package App
 * @property string $txt
 * @property string $img_url
 * @property text $correct_ans_exp
 * @property integer $test_id
 */
class Question extends Model
{

    //use SoftDeletes;

    protected $table = 'questions';
    protected $fillable = ['img_url', 'test_id', 'topic_id', 'page', 'question_type'];


    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {
        return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('txt', 'correct_ans_exp')->first();
        if ($translation) {
            return $translation->toArray();
        } else {
            return ['txt' => null, 'correct_ans_exp' => null];
        }
    }

    public function insertRecord($data)
    {
        $questionData = [
            'img_url'           =>  isset($data['img_url']) ? $data['img_url'] : null,
            'test_id'           =>  $data['test_id'],
            'page'              =>  isset($data['page']) ? $data['page'] : 'normal',
            'topic_id'          =>  isset($data['topic_id']) ? $data['topic_id'] : 0,
            'question_type'     =>  isset($data['question_type']) ? $data['question_type'] : 0,
        ];

        $question = Question::create($questionData);

        $translationData = [
            'txt'               =>  isset($data['txt']) ? $data['txt'] : null,
            'correct_ans_exp'   =>  isset($data['correct_ans_exp']) ? $data['correct_ans_exp'] : null,
            'question_id'       =>  $question->id
        ];

        QuestionTranslation::create($translationData);
        return $question;
    }
    public function updateRecord($data)
    {
        $locale = 'en';
        if (isset($data['locale']))
            $locale = $data['locale'];
        $questionData = [
            'img_url'           =>  isset($data['img_url']) ? $data['img_url'] : null,
            'test_id'           =>  $data['test_id'],
            'page'              =>  isset($data['page']) ? $data['page'] : 'normal',
            'topic_id'          =>  isset($data['topic_id']) ? $data['topic_id'] : 0,
            'question_type'     =>  isset($data['question_type']) ? $data['question_type'] : 0,
        ];

        $translationData = [
            'txt'               =>  isset($data['txt']) ? $data['txt'] : null,
            'correct_ans_exp'   =>  isset($data['correct_ans_exp']) ? $data['correct_ans_exp'] : null
        ];

        $this->update($questionData);

        $key = [
            'locale'        =>  $locale,
            'question_id'   =>  $this->id,
        ];


        $questionTranslation = QuestionTranslation::updateOrCreate($key, $translationData);
    }
    public static function storeValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:questions,txt',
            'txt'               =>  'max:65535|nullable',
            'correct_ans_exp'   =>  'max:65535|nullable',
            'test_id'           =>  'required',
            'topic_id'          =>  'required',
            'page'              =>  'required',
            'question_type'     =>  'required',
        ];
    }
    public static function updateValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:questions,txt,'.$request->route('question'),
            'txt'               =>  'max:65535|nullable',
            'correct_ans_exp'   =>  'max:65535|nullable',
            'test_id'           =>  'required',
            'topic_id'          =>  'required',
            'page'              =>  'required',
            'question_type'     =>  'required',
        ];
    }

    //********************relationship******************
    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function getAnswers($locale = 'en')
    {
        $answers = $this->answers()->get();
        $answerArr = array();
        foreach ($answers as $answer) {
            $tran = $answer->getTranslation($locale);
            if (!$tran) {
                continue;
            }
            array_push($answerArr, [
                'id'            =>  $answer->id,
                'txt'           =>  $tran['txt'],
                'img_url'       =>  $answer->img_url
            ]);
        }
        return $answerArr;
    }

    public function getBestAnswer()
    {
        $answers = $this->answers()->get();
        $maxScore = 0;
        $bestAnswer = -1;
        foreach ($answers as $answer) {
            if ($answer->score > $maxScore) {
                $maxScore = $answer->score;
                $bestAnswer = $answer->id;
            }
        }
        return $bestAnswer;
    }

    public function delete()
    {
        $answers = $this->answers()->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $this->translations()->delete();
        return parent::delete();
    }
    public function translations()
    {
        return $this->hasMany('App\QuestionTranslation');
    }
    public function topicName()
    {
        if ($this->topic_id == 0) {
            return "Normal";
        }
        return Topic::find($this->topic_id)->name;
    }
}