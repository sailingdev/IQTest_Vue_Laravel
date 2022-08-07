<?php

namespace App\Http\Controllers\Api\V1;

use App\Result;
use App\Test;
use App\Http\Controllers\Controller;
use App\Http\Resources\Result as ResultResource;
use App\Http\Requests\Admin\StoreResultsRequest;
use App\Http\Requests\Admin\UpdateResultsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ResultsController extends Controller
{
    public function index()
    {
        return new ResultResource(Test::all());
    }
    public function getResults($tId)
    {
        $results = Result::where('test_id', $tId)
            ->get();
        $test = Test::find($tId);
        $resultArr = array();
        foreach ($results as $result) {
            //get english value for default
            $tran = $result->getTranslation();
            if (!$tran) {
                continue;
            }
            array_push($resultArr, [
                'id'            =>  $result->id,
                'description'   =>  $tran['description'],
                'img_url'       =>  $result->img_url,
                'file'          =>  $result->img_url,
                'min_score'     =>  $result->min_score,
                'max_score'     =>  $result->max_score,
            ]);
        }
        //return new QuestionResource($questionArr);
        return new ResultResource([
            'items' => $resultArr,
            'test' => ['id' => $tId, 'title' => $test->getTranslation()['title']]
        ]);
    }
    private function saveImage($image)
    {
        $ext = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $ext = explode('+', $ext)[0];
        $name = time() . '.' . $ext;
        $url = public_path('uploads/images/result/') . $name;

        $header = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($header, '', $image);
        $image = str_replace(' ', '+', $image);

        file_put_contents($url, base64_decode($image));
        return '/uploads/images/result/' . $name;
    }
    public function store(StoreResultsRequest $request)
    {
        if (Gate::denies('result_create')) {
            return abort(401);
        }

        if ($request->get('img')) {
            $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
        } else if ($request->description == null) {
            return response("Validation Error", 500);
        }
        //$result = Result::create($request->all());
        $result = new Result();
        $result = $result->insertRecord($request->all());


        return (new ResultResource($result))
            ->response()
            ->setStatusCode(201);
    }
    public function getResult($id, $locale)
    {
        $result = Result::with([])->findOrFail($id);
        $otherInfo = ['img' => $result->img_url];

        $detail = array_merge($result->getTranslation($locale), $otherInfo);

        return new ResultResource(array_merge($result->toArray(), $detail));
    }

    public function show($id)
    {
        if (Gate::denies('result_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';

        return $this->getResult($id, $locale);
    }
    public function update(UpdateResultsRequest $request, $id)
    {
        if (Gate::denies('result_edit')) {
            return abort(401);
        }


        if ($request->get('img')) {
            if (!$request->get('img_url') || $request->img != $request->img_url) {
                $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
            }
        } else {
            //delete file
            $request->merge(['img_url' => null]);
        }
        $result = Result::findOrFail($id);
        //$result->update($request->all());
        $result->updateRecord($request->all());
        $locale = isset($request->locale) ? $request->locale : 'en';
        return ($this->getResult($id, $locale))
            ->response()
            ->setStatusCode(202);
    }
    public function destroy($id)
    {
        if (Gate::denies('result_delete')) {
            return abort(401);
        }

        $result = Result::findOrFail($id);
        $result->delete();

        return response(null, 204);
    }
}