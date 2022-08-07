<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    //
    protected $table = 'factors';
    protected $fillable = ['img_url', 'test_id', 'formula'];


    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {
        return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('title', 'description')->first();
        if ($translation) {
            return $translation->toArray();
        } else {
            return ['title' => null, 'description' => null];
        }
    }

    public function insertRecord($data)
    {
        $factorData = [
            'img_url'   =>  isset($data['img_url']) ? $data['img_url'] : null,
            'test_id'   =>  $data['test_id'],
            'formula'   =>  isset($data['formula']) ? $data['formula'] : null,
        ];

        $factor = Factor::create($factorData);

        $translationData = [
            'title'                 =>  isset($data['title']) ? $data['title'] : null,
            'description'           =>  isset($data['description']) ? $data['description'] : null,
            'factor_id'           =>  $factor->id
        ];

        FactorTranslation::create($translationData);
        return $factor;
    }
    public function updateRecord($data)
    {
        $locale = 'en';
        if (isset($data['locale']))
            $locale = $data['locale'];
        $factorData = [
            'img_url'   =>  isset($data['img_url']) ? $data['img_url'] : null,
            'test_id'   =>  $data['test_id'],
            'formula'   =>  isset($data['formula']) ? $data['formula'] : null,
        ];

        $translationData = [
            'title'                 =>  isset($data['title']) ? $data['title'] : null,
            'description'           =>  isset($data['description']) ? $data['description'] : null,
        ];

        $this->update($factorData);

        $key = [
            'locale'        =>  $locale,
            'factor_id'   =>  $this->id,
        ];

        FactorTranslation::updateOrCreate($key, $translationData);
    }
    public static function storeValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:questions,txt',
            'title'             =>  'max:65535|nullable',
            'description'       =>  'max:65535|nullable',
            'test_id'           =>  'required',
            'formula'           =>  'required'
        ];
    }
    public static function updateValidation($request)
    {
        return [
            //'txt' => 'max:65535|unique:questions,txt,'.$request->route('question'),
            'txt'               =>  'max:65535|nullable',
            'description'       =>  'max:65535|nullable',
            'test_id'           =>  'required',
            'formula'           =>  'required'
        ];
    }

    //********************relationship******************
    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function answers()
    {
        return $this->belongsToMany('App\Answer')->using('App\FactorAnswer');
    }

    public function factorResults()
    {
        return $this->hasMany('App\FactorResult')->orderBy('min_score', 'asc');
    }

    public function getResults($locale = 'en')
    {
        $colors = ['#eb5c21', '#f89821',  '#9fc90f', '#578706'];

        $results = $this->factorResults()->get();

        $resultArr = array();
        $index = 0;
        $count = count($results);
        //$backgroundColor = 'linear-gradient(90deg, #eb5c21 45%, #f89821 0, #f89821 52%, #9fc90f 0, #178706 63%, #578706 0, #578706)';

        $backgroundColor = 'linear-gradient(90deg, ';
        if (count($results) == 0) {
            $backgroundColor = 'linear-gradient(90deg, #eb5c21 10%, #9fc90f)';
        }

        $percent = 0;
        foreach ($results as $result) {
            $tran = $result->getTranslation($locale);
            if (!$tran) {
                continue;
            }
            if ($index < $count / 2) {
                $color = $colors[$index];
            } else {
                $color = $colors[$index + (GlobalConstants::MAX_FACTOR_RESULT_CNT - $count)];
            }

            $backgroundColor .= (' ' . $color . ' 0,');
            if ($result->min_score > 0) {
                $percent += ($result->max_score - $result->min_score + 1);
            } else {
                $percent += ($result->max_score - $result->min_score);
            }

            if ($index == $count - 1) {
                $backgroundColor .= ($color . ')');
            } else {
                $backgroundColor .= ($color . ' ' . $percent . '%,');
            }
            array_push($resultArr, [
                'id'            =>  $result->id,
                'min_score'     =>  $result->min_score,
                'max_score'     =>  $result->max_score,
                'title'         =>  $tran['title'],
                'description'   =>  $tran['description'],
                'color'         =>  $color,

            ]);
            $index++;
        }
        return [
            'results'           =>  $resultArr,
            'background_color'   =>  $backgroundColor
        ];
    }

    public function translations()
    {
        return $this->hasMany('App\FactorTranslation');
    }

    public function delete()
    {
        $factorResults = $this->factorResults()->get();
        foreach ($factorResults as $factorResult) {
            $factorResult->delete();
        }
        $this->translations()->delete();
        return parent::delete();
    }
}