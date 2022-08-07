<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicQuestion extends Model
{
    //
     //use SoftDeletes;

    protected $table = 'topic_questions';
    protected $fillable = ['img_url','topic_id'];


    //English is default locale:en
    public function translation($locale = 'en')
    {   
    	return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('txt','correct_ans_exp')->first();
        if($translation){
            return $translation->toArray();
        }else{
            return ['txt' => null,'correct_ans_exp' => null];
        }

    }

    public function insertRecord($data)
    {
        $questionData = ['img_url' => $data['img_url'],'topic_id' => $data['topic_id']];
        $question = TopicQuestion::create($questionData);

        $translationData = ['txt' => $data['txt'],
                            'correct_ans_exp' => $data['correct_ans_exp'],
                            'topic_question_id' => $question->id];
        
	    TopicQuestionTranslation::create($translationData);
	    return $question;
    }
    public function updateRecord($data) {
        $locale = 'en';
        if(isset($data['locale']))
            $locale = $data['locale'];
        $questionData = ['img_url' => $data['img_url'],'topic_id' => $data['topic_id']];

        $translationData = ['txt' => $data['txt'],
                            'correct_ans_exp' => $data['correct_ans_exp']];
        $this->update($questionData);

        $key = [
                'locale' => $locale,
                'topic_question_id' =>  $this->id,
        ];


        $questionTranslation = TopicQuestionTranslation::updateOrCreate($key, $translationData);    
    }
    public static function storeValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:questions,txt',
            'txt' => 'max:65535|nullable',
            'correct_ans_exp' => 'max:65535|nullable',
            'topic_id' => 'required'
        ];
    }
    public static function updateValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:questions,txt,'.$request->route('question'),
            'txt' => 'max:65535|nullable',
            'correct_ans_exp' => 'max:65535|nullable',
            'topic_id' => 'required'
        ];
    }

    //********************relationship******************
    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }
    // public function answers()
    // {
    //     return $this->hasMany('App\Answer');
    // }
    public function delete()
    {
        $this->answers()->delete();
        $this->translations()->delete();
        return parent::delete();
    }
    public function translations()
    {
        return $this->hasMany('App\TopicQuestionTranslation');
    }
}
