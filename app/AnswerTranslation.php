<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerTranslation extends Model
{
    //
    protected $table = 'answer_translations';
    protected $fillable = ['answer_id', 'locale', 'txt','result_text'];
    
    public function answer()
    {
        return $this->belongsTo('App\Answer');
    }
}
