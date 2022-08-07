<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorResultTranslation extends Model
{
    //
    protected $table = 'factor_result_translations';
    protected $fillable = ['factor_result_id', 'locale', 'description', 'title'];

    public function factorResult()
    {
        return $this->belongsTo('App\FactorResult');
    }
}