<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Type;
use App\Language;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Requests\Admin\StoreCategoriesRequest;
use App\Http\Requests\Admin\UpdateCategoriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Resources\Json\JsonResource;


class CategoriesController extends Controller
{
    public function getInitialData()
    {
        $languages = Language::with([])->get();
        $types = Type::with([])->get();
        return new JsonResource([
            'language'  =>  $languages,
            'type'     =>  $types
        ]);
    }
    public function getTestType($id)
    {
        $category = Category::with(['type'])->findOrFail($id);
        return new JsonResource([$category->test_type]);
    }

    public function index()
    {
        $categories = Category::with([])->get();
        $categoryArr = array();
        foreach ($categories as $category) {
            //get english value for default
            $tran = $category->getTranslation();
            if (!$tran) {
                continue;
            }

            array_push($categoryArr, [
                'id'            =>  $category->id,
                'title'         =>  $tran['title'],
                'description'   =>  $tran['description'],
                'question'      =>  $tran['question'],
                'short_desc'    =>  $tran['short_desc'],
                'test_type'     =>  $category->test_type,
                'type_name'     =>  $category->type->name,
                'test_cnt'      =>  $category->tests()->count()
            ]);
        }
        return new CategoryResource($categoryArr);
    }
    public function indexTile()
    {
        $categories = Category::with([])->get();
        $categoryArr = array();
        foreach ($categories as $category) {
            //get english value for default
            $tran = $category->getTranslation();
            if (!$tran) {
                continue;
            }
            array_push($categoryArr, [
                'id'            =>  $category->id,
                'title'         =>  $tran['title'],
                'description'   =>  $tran['description'],
                'question'      =>  $tran['question'],
                'short_desc'    =>  $tran['short_desc'],
                'test_type'     =>  $category->test_type,
                'test_cnt'      =>  $category->tests()->count()
            ]);
        }
        return new CategoryResource($categoryArr);
    }
    public function getCategory($id, $locale)
    {
        $category = Category::with(['type'])->findOrFail($id);
        $info = [
            'id'        =>  $category->id,
            'test_type' =>  $category->type->id,
            'type_name' =>  $category->type->name,
        ];

        $detail = $category->getTranslation($locale);
        return new CategoryResource(array_merge($info, $detail));
    }
    public function show($id)
    {
        if (Gate::denies('category_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';

        return $this->getCategory($id, $locale);
    }

    public function store(StoreCategoriesRequest $request)
    {
        if (Gate::denies('category_create')) {
            return abort(401);
        }

        //$category = Category::create($request->all());
        $category = new Category();
        $category = $category->insertRecord($request->all());



        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCategoriesRequest $request, $id)
    {
        if (Gate::denies('category_edit')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        //$category->update($request->all());
        $category->updateRecord($request->all());

        $locale = isset($request->locale) ? $request->locale : 'en';
        return ($this->getCategory($id, $locale))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('category_delete')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return response(null, 204);
    }
}