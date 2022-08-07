<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Topic
 *
 * @package App
 * @property string $name
 * @property string $value
 * @property integer $test_id
*/
class Topic extends Model
{
    //
    //use SoftDeletes;

    protected $fillable = ['name', 'value','description','test_id'];
    public static function storeValidation($request)
    {
        return [
                    'name'          =>  'max:255|unique:topics,name',
                    'description'   =>  'max:65535|nullable',
                    //'test_id'     =>  'required'
                    //'value'       =>  'max:65535|required',
            ];
    }
    public static function updateValidation($request)
    {
        return [
                    'name'          =>  'max:65535|unique:topics,name,'.$request->route('topic'),
                    'description'   =>  'max:65535|nullable',
                    //'test_id' => 'required'
                    //'value' => 'max:65535|required',
            ];
    }

    public function topicQuestions()
    {
        return $this->hasMany('App\TopicQuestion');
    }
}
