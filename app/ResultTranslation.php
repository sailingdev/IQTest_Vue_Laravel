<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultTranslation extends Model
{
    //
    protected $table = 'result_translations';
    protected $fillable = ['result_id', 'locale', 'description'];
    
    public function result()
    {
        return $this->belongsTo('App\Result');
    }
}
