<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 *
 * @package App
 */
class Type extends Model
{
    protected $fillable = ['name', 'description'];



    public static function storeValidation($request)
    {
        return [
            'name'  =>  'max:20|required|unique:types,name',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'language'  =>  'max:20|required|unique:types,name,' . $request->route('type'),
        ];
    }

    public function categories()
    {
        return $this->hasMany('App\Category', 'test_type');
    }
}