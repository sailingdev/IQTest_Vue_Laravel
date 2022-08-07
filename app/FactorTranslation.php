<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorTranslation extends Model
{
    //
    protected $table = 'factor_translations';
    protected $fillable = ['factor_id', 'locale', 'title', 'description'];

    public function factor()
    {
        return $this->belongsTo('App\Factor');
    }
}