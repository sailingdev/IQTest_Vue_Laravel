<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Result
 *
 * @package App
 * @property integer $min_score
 * @property integer $max_score
 * @property text $description
 * @property string $img_url
 * @property string $file_url
*/
class Result extends Model
{
    //use SoftDeletes;
    protected $table = 'results';
    protected $fillable = ['min_score', 'max_score','img_url', 'file_url', 'test_id'];

    
    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {   
    	return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('description')->first();
        if($translation){
            return $translation->toArray();
        }else{
            return ['description' => null];
        }

    }

    public function insertRecord($data)
    {
        $resultData = [
                        'img_url'   =>  isset($data['img_url'])?$data['img_url']:null,
                        'test_id'   =>  isset($data['test_id'])?$data['test_id']:null,
                        'min_score' =>  isset($data['min_score'])?$data['min_score']:null,
                        'max_score' =>  isset($data['max_score'])?$data['max_score']:null
                    ];
        $result = Result::create($resultData);

        $translationData = [
                                'description'   =>  isset($data['description'])?$data['description']:null,
                                'result_id'     =>  $result->id
                            ];
        
	    ResultTranslation::create($translationData);
	    return $result;
    }
    public function updateRecord($data) {
        $locale = 'en';
        if(isset($data['locale']))
            $locale = $data['locale'];
        $resultData = [
                        'img_url'   =>  isset($data['img_url'])?$data['img_url']:null,
                        'test_id'   =>  isset($data['test_id'])?$data['test_id']:null,
                        'min_score' =>  isset($data['min_score'])?$data['min_score']:null,
                        'max_score' =>  isset($data['max_score'])?$data['max_score']:null
                    ];

        $translationData = [
                            'description' => isset($data['description'])?$data['description']:null
                        ];
        $this->update($resultData);

        $key = [
                    'locale'    =>  $locale,
                    'result_id' =>  $this->id,
                ];

        $resultTranslation = ResultTranslation::updateOrCreate($key, $translationData);    
    }
    public static function storeValidation($request)
    {
        return [
            'min_score'     =>  'required',
            'max_score'     =>  'required',
            'description'   =>  'max:65535',
            'test_id'       =>  'required'
        ];
    }
    public static function updateValidation($request)
    {
        return [
            'min_score'     =>  'required',
            'max_score'     =>  'required',
            'description'   =>  'max:65535',
            'test_id'       =>  'required'
        ];
    }
    //********************relationship******************
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
    public function translations()
    {
        return $this->hasMany('App\ResultTranslation');
    }

    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }

}
