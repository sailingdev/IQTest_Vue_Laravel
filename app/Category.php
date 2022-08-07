<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @package App
 * @property string $title
 * @property text $description
 */
class Category extends Model
{
    //use SoftDeletes;

    protected $table = 'categories';
    //******there is no fillable data******************
    protected $fillable = ['test_type'];

    //*******static functions**************************
    public static function getAll($locale = 'en')
    {
        $categories = Category::get();
        $array = array();
        foreach ($categories as $category) {
            $tran = $category->getTranslation($locale);
            array_push($array, [
                'id'                    =>  $category->id,
                'title'                 =>  isset($tran['title']) ? $tran['title'] : '',
                'description'           =>  isset($tran['description']) ? $tran['description'] : '',
                'question'              =>  isset($tran['question']) ? $tran['question'] : '',
                'short_desc'            =>  isset($tran['short_desc']) ? $tran['short_desc'] : '',
                'test_type'             =>  $category->test_type,
                //'type_name'             =>  $category->type->name,
                'type_name'             =>  "category_type_name",
                'test_cnt'              =>  $category->tests()->count()
            ]);
        }
        return $array;
    }

    //*******English is default locale:en**************
    public function translation($locale = 'en')
    {
        return $this->translations()->where('locale', $locale);
    }

    public function getTranslation($locale = 'en')
    {
        $translation =  $this->translation($locale)->select('title', 'description', 'question', 'short_desc')->first();
        if ($translation) {
            return $translation->toArray();
        } else {
            return ['title' => null, 'description' => null, 'question' => null, 'short_desc' => null];
        }
    }

    public function insertRecord($data)
    {
        $categoryData = [
            'test_type'     =>  $data['test_type']
        ];
        $category = Category::create($categoryData);
        $data['category_id'] = $category->id;
        CategoryTranslation::create($data);
        return $category;
    }
    public function updateRecord($data)
    {
        $locale = 'en';
        if (isset($data['locale']))
            $locale = $data['locale'];
        $this->update($data);
        $key = [
            'locale'        =>  $locale,
            'category_id'   =>  $this->id,
        ];
        $categoryTranslation = CategoryTranslation::updateOrCreate($key, $data);
    }



    public static function storeValidation($request)
    {
        return [
            'title'         =>  'max:191|required|unique:category_translations,title',
            'description'   =>  'max:65535|nullable',
            'question'      =>  'max:65535|nullable',
            'short_desc'    =>  'max:65535|nullable',
            'test_type'     =>  'required'
            //'locale' => 'required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'title'         =>  'max:191|required', //|unique:category_translations,title,'.$request->route('category'),
            'description'   =>  'max:65535|nullable',
            'question'      =>  'max:65535|nullable',
            'short_desc'    =>  'max:65535|nullable',
            'test_type'     =>  'required'
            //'locale' => 'required'
        ];
    }

    public function delete()
    {
        $tests = $this->tests()->get();
        foreach ($tests as $test) {
            $test->delete();
        }
        $this->translations()->delete();
        return parent::delete();
    }

    //********************relationship******************
    public function tests()
    {
        return $this->hasMany('App\Test');
    }

    public function translations()
    {
        return $this->hasMany('App\CategoryTranslation');
    }

    public function type()
    {
        return $this->belongsTo('App\Type', 'test_type');
    }
}