<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FactorAnswer extends Pivot
{
    //
    protected $table = 'answer_factor';
    protected $hidden = ['id', 'created_at', 'updated_at'];
}