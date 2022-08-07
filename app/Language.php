<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 *
 * @package App
 * @property string $language
 * @property string $locale
*/
class Language extends Model
{
    protected $fillable = ['language', 'locale'];
    
    

    public static function storeValidation($request)
    {
        return [
            'language'  =>  'max:20|required|unique:languages,language',
            'locale'    =>  'max:4|required|unique:languages,locale'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'language'  =>  'max:20|required|unique:languages,language,'.$request->route('language'),
            'locale'    =>  'max:4|required|unique:languages,locale,'.$request->route('language'),
        ];
    }
}
