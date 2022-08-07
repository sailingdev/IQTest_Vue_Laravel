<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactorResult extends Model
{
    //
    //use SoftDeletes;
    protected $table = 'factor_results';
    protected $fillable = ['min_score', 'max_score', 'img_url', 'factor_id'];


    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {
        return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('description', 'title')->first();
        if ($translation) {
            return $translation->toArray();
        } else {
            return ['description' => null, 'title' => null];
        }
    }

    public function insertRecord($data)
    {
        $resultData = [
            'img_url'   =>  isset($data['img_url']) ? $data['img_url'] : null,
            'factor_id' =>  isset($data['factor_id']) ? $data['factor_id'] : null,
            'min_score' =>  isset($data['min_score']) ? $data['min_score'] : null,
            'max_score' =>  isset($data['max_score']) ? $data['max_score'] : null
        ];
        $result = FactorResult::create($resultData);

        $translationData = [
            'description'   =>  isset($data['description']) ? $data['description'] : null,
            'title'         =>  isset($data['title']) ? $data['title'] : null,
            'factor_result_id'     =>  $result->id
        ];

        FactorResultTranslation::create($translationData);
        return $result;
    }
    public function updateRecord($data)
    {
        $locale = 'en';
        if (isset($data['locale']))
            $locale = $data['locale'];
        $resultData = [
            'img_url'   =>  isset($data['img_url']) ? $data['img_url'] : null,
            'factor_id' =>  isset($data['factor_id']) ? $data['factor_id'] : null,
            'min_score' =>  isset($data['min_score']) ? $data['min_score'] : null,
            'max_score' =>  isset($data['max_score']) ? $data['max_score'] : null
        ];

        $translationData = [
            'description' =>  isset($data['description']) ? $data['description'] : null,
            'title'       =>  isset($data['title']) ? $data['title'] : null,
        ];
        $this->update($resultData);

        $key = [
            'locale'    =>  $locale,
            'factor_result_id' =>  $this->id,
        ];

        $resultTranslation = FactorResultTranslation::updateOrCreate($key, $translationData);
    }
    public static function storeValidation($request)
    {
        return [
            'min_score'     =>  'required',
            'max_score'     =>  'required',
            'description'   =>  'max:65535',
            'title'         =>  'required',
            'factor_id'     =>  'required',
        ];
    }
    public static function updateValidation($request)
    {
        return [
            'min_score'     =>  'required',
            'max_score'     =>  'required',
            'description'   =>  'max:65535',
            'title'         =>  'required',
            'factor_id'     =>  'required'
        ];
    }
    //********************relationship******************
    public function factor()
    {
        return $this->belongsTo('App\Factor');
    }
    public function translations()
    {
        return $this->hasMany('App\FactorResultTranslation');
    }

    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }
}