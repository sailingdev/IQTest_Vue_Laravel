<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    //
    protected $table = 'question_translations';
    protected $fillable = ['question_id', 'locale', 'txt', 'correct_ans_exp'];
    
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
