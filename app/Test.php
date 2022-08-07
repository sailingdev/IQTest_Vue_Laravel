<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Question as QuestionResource;


/**
 * Class Test
 *
 * @package App
 * @property string $title
 * @property text $description
 * @property integer $time
 * @property text $instruction
 */
class Test extends Model
{
    //use SoftDeletes;

    protected $table = 'tests';
    protected $fillable = [
        'time',
        'category_id',
        'initial_price',
        'extra_price',
        'certification_file_url',
        'extra_file_url',
        'certification_img_url',
        'certific_logo_img_url',
        'evaluation_logo_img_url',
        'extra_logo_img_url'
    ];

    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {
        return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select(
            'title',
            'description',
            'instruction',
            'pre_page_title',
            'pre_page_desc',
            'post_page_title',
            'post_page_desc'
        )->first();
        if ($translation) {
            return $translation->toArray();
        } else {
            return [
                'title'             =>  null,
                'description'       =>  null,
                'instruction'       =>  null,
                'pre_page_title'    =>  null,
                'pre_page_desc'     =>  null,
                'post_page_title'   =>  null,
                'post_page_desc'    =>  null
            ];
        }
    }

    public function insertRecord($data)
    {
        $testData = [
            'time'                      =>  isset($data['time']) ? $data['time'] : 0,
            'initial_price'             =>  isset($data['initial_price']) ? $data['initial_price'] : 0,
            'extra_price'               =>  isset($data['extra_price']) ? $data['extra_price'] : 0,
            'category_id'               =>  $data['category_id'],
            'certification_file_url'    =>  isset($data['certification_file_url']) ? $data['certification_file_url'] : null,
            'certification_img_url'     =>  isset($data['certification_img_url']) ? $data['certification_img_url'] : null,
            'certific_logo_img_url'     =>  isset($data['certific_logo_img_url']) ? $data['certific_logo_img_url'] : null,
            'evaluation_logo_img_url'   =>  isset($data['evaluation_logo_img_url']) ? $data['evaluation_logo_img_url'] : null,
            'extra_logo_img_url'        =>  isset($data['extra_logo_img_url']) ? $data['extra_logo_img_url'] : null,
            'extra_file_url'            =>  isset($data['extra_file_url']) ? $data['extra_file_url'] : null
        ];
        $test = Test::create($testData);

        $translationData = [
            'title'         =>  isset($data['title']) ? $data['title'] : null,
            'description'   =>  isset($data['description']) ? $data['description'] : null,
            'instruction'   =>  isset($data['instruction']) ? $data['instruction'] : null,
            'test_id'       =>  $test->id
        ];

        TestTranslation::create($translationData);
        return $test;
    }
    public function updateRecord($data)
    {
        $locale = 'en';
        if (isset($data['locale']))
            $locale = $data['locale'];
        $testData = [
            'time'                      => isset($data['time']) ? $data['time'] : $this->time,
            'initial_price'             =>  isset($data['initial_price']) ? $data['initial_price'] : 0,
            'extra_price'               =>  isset($data['extra_price']) ? $data['extra_price'] : 0,
            'certification_file_url'    =>  isset($data['certification_file_url']) ? $data['certification_file_url'] : null,
            'certification_img_url'     =>  isset($data['certification_img_url']) ? $data['certification_img_url'] : null,
            'certific_logo_img_url'     =>  isset($data['certific_logo_img_url']) ? $data['certific_logo_img_url'] : null,
            'evaluation_logo_img_url'   =>  isset($data['evaluation_logo_img_url']) ? $data['evaluation_logo_img_url'] : null,
            'extra_logo_img_url'        =>  isset($data['extra_logo_img_url']) ? $data['extra_logo_img_url'] : null,
            'extra_file_url'            =>  isset($data['extra_file_url']) ? $data['extra_file_url'] : null
        ];

        $fieldArr = [
            'title',
            'description',
            'instruction',
            'pre_page_title',
            'pre_page_desc',
            'post_page_title',
            'post_page_desc'
        ];
        $translationData = array();
        foreach ($fieldArr as $field) {
            if (isset($data[$field])) {
                $translationData[$field] = $data[$field];
            }
        }
        $this->update($testData);

        $key = [
            'locale'    =>  $locale,
            'test_id'   =>  $this->id,
        ];

        $testTranslation = TestTranslation::updateOrCreate($key, $translationData);
    }


    public static function storeValidation($request)
    {
        return [
            'title'             =>  'max:191|nullable',
            'description'       =>  'max:65535|nullable',
            //'time'              =>  'required',
            'instruction'       =>  'max:65535|nullable',
            'pre_page_title'    =>  'max:65535|nullable',
            'pre_page_desc'     =>  'max:65535|nullable',
            'post_page_title'   =>  'max:65535|nullable',
            'post_page_desc'    =>  'max:65535|nullable',
            'category_id'       =>  'required',
            'initial_price'     =>  'required'
            //'certification_file'=>  'required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'title'             =>  'max:191|nullable',
            'description'       =>  'max:65535|nullable',
            'instruction'       =>  'max:65535|nullable',
            'pre_page_title'    =>  'max:65535|nullable',
            'pre_page_desc'     =>  'max:65535|nullable',
            'post_page_title'   =>  'max:65535|nullable',
            'post_page_desc'    =>  'max:65535|nullable',
            // 'initial_price'     =>  'required'
            //'time'            =>  'required',
            //'category_id'     =>  'required'
        ];
    }

    public function delete()
    {
        $questions = $this->questions()->get();
        foreach ($questions as $question) {
            $question->delete();
        }
        $results = $this->results()->get();
        foreach ($results as $result) {
            $result->delete();
        }
        $factors = $this->factors()->get();
        foreach ($factors as $factor) {
            $factor->delete();
        }

        $this->translations()->delete();
        return parent::delete();
    }

    //********************relationship******************
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
    public function factors()
    {
        return $this->hasMany('App\Factor');
    }
    public function getQuestions($locale = 'en')
    {
        $questions = $this->questions()->get();
        $questionArr = array();
        $i = 0;
        foreach ($questions as $question) {
            //get english value for default
            $tran = $question->getTranslation($locale);
            array_push(
                $questionArr,
                [
                    'id'               =>  $question->id,
                    'question_type'    =>  $question->question_type,
                    'txt'              =>  isset($tran['txt']) ? $tran['txt'] : null,
                    'img_url'          =>  $question->img_url,
                    'topic_name'       =>  $question->topicName(),
                    'page'             =>  $question->page,
                    'answers'          =>  $question->getAnswers($locale),
                    'user_answer'      =>  null
                    //'correct_ans_exp'  =>  isset($tran['correct_ans_exp']),
                ]
            );
        }
        return $questionArr;
        //return new QuestionResource($questionArr);
    }
    public function pageQuestionsCnt($page)
    {
        return $this->questions()->where('page', '=', $page)->count();
    }
    public function getNormalQuestionsCnt()
    {
        return $this->questions()->where('page', '=', 'normal')->count();
    }
    public function results()
    {
        return $this->hasMany('App\Result');
    }
    public function translations()
    {
        return $this->hasMany('App\TestTranslation');
    }
    public function testResult()
    {
        return $this->hasMany('App\TestResult');
    }
}