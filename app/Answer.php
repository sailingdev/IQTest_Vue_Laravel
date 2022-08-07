<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Answer
 *
 * @package App
 * @property string $txt
 * @property text $img_url
 * @property integer $score
 * @property text $instruction
 */
class Answer extends Model
{
    //use SoftDeletes;
    protected $table = 'answers';
    protected $fillable = ['img_url', 'score', 'question_id'];



    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {
        return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('txt', 'result_text')->first();
        if ($translation) {
            return $translation->toArray();
        } else {
            return ['txt' => null, 'result_text' => null];
        }
    }

    public function insertRecord($data)
    {
        $answerData = [
            'img_url'       =>  isset($data['img_url']) ? $data['img_url'] : null,
            'question_id'   =>  isset($data['question_id']) ? $data['question_id'] : null,
            'score'         =>  isset($data['score']) ? $data['score'] : 0
        ];
        $answer = Answer::create($answerData);

        $translationData = [
            'txt'           =>   isset($data['txt']) ? $data['txt'] : null,
            'result_text'   =>   isset($data['result_text']) ? $data['result_text'] : null,
            'answer_id'     =>   $answer->id
        ];

        AnswerTranslation::create($translationData);
        return $answer;
    }
    public function updateRecord($data)
    {
        $locale = 'en';
        if (isset($data['locale']))
            $locale = $data['locale'];
        $answerData = [
            'img_url'       =>  isset($data['img_url']) ? $data['img_url'] : null,
            'question_id'   =>  isset($data['question_id']) ? $data['question_id'] : null,
            'score'         =>  isset($data['score']) ? $data['score'] : 0
        ];

        $translationData = [
            'txt'           =>  isset($data['txt']) ? $data['txt'] : null,
            'result_text'   =>  isset($data['result_text']) ? $data['result_text'] : null
        ];

        //*************for factors********
        if (isset($data['factors'])) {
            $factors = json_decode($data['factors']);
            $factorData = array();
            foreach ($factors as $factor) {
                if ($factor->weight == 0) {
                    continue;
                }
                $factorData[$factor->id] = array('weight' => $factor->weight);
            }

            $this->factors()->sync($factorData);
        }
        //********************************
        $this->update($answerData);

        $key = [
            'locale'    =>  $locale,
            'answer_id' =>  $this->id,
        ];


        $answerTranslation = AnswerTranslation::updateOrCreate($key, $translationData);
    }

    public static function storeValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:answers,txt',
            'txt'           =>  'max:65535',
            // 'score'         =>  'required',
            'question_id'   =>  'required',
            'result_text'   =>  'max:65535'
        ];
    }
    public static function updateValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:answers,txt,'.$request->route('answer'),
            'txt'           =>  'max:65535',
            // 'score'         =>  'required',
            'question_id'   =>  'required',
            'result_text'   =>  'max:65535'
        ];
    }

    //********************relationship******************
    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function translations()
    {
        return $this->hasMany('App\AnswerTranslation');
    }

    public function factors()
    {
        return $this->belongsToMany('App\Factor')
            ->using('App\FactorAnswer')
            ->withPivot('weight')
            ->withTimestamps();
    }

    public function answerFactors()
    {
        return $this->hasMany('App\FactorAnswer', 'answer_id');
    }



    //delete function
    public function delete()
    {
        $this->translations()->delete();
        $this->factors()->detach();
        return parent::delete();
    }
}