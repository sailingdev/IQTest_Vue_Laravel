<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    //
    protected $table = 'test_results';
    protected $fillable = ['test_id', 'time', 'result', 'topic_key', 'mobile_number', 'user_name', 'pay_amount', 'extra_pay', 'token', 'pay_status'];

    public static function storeValidation($request)
    {
        return [
            'test_id'           =>  'required',
            'time'              =>  'required',
            'result'            =>  'max:65535|nullable',
            'topic_key'         =>  'max:65535|nullable',
            'mobile_number'     =>  'required',
            'user_name'         =>  'required'
        ];
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }
}