<?php

namespace App\Http\Controllers\Api\V1;

use App\FactorResult;
use App\Factor;
use App\Http\Controllers\Controller;
use App\Http\Resources\FactorResult as FactorResultResource;
use App\Http\Requests\Admin\StoreFactorResultsRequest;
use App\Http\Requests\Admin\UpdateFactorResultsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\GlobalConstants;

class FactorResultsController extends Controller
{
    public function index()
    {
        return new FactorResultResource(Test::all());
    }
    public function getFactorResults($fId)
    {
        $results = FactorResult::where('factor_id', $fId)
            ->get();
        $factor = Factor::find($fId);
        $resultArr = array();
        foreach ($results as $result) {
            //get english value for default
            $tran = $result->getTranslation();
            if (!$tran) {
                continue;
            }
            array_push($resultArr, [
                'id'            =>  $result->id,
                'title'         =>  $tran['title'],
                'description'   =>  $tran['description'],
                'img_url'       =>  $result->img_url,
                'min_score'     =>  $result->min_score,
                'max_score'     =>  $result->max_score,
            ]);
        }
        //return new QuestionResource($questionArr);
        return new FactorResultResource([
            'items' => $resultArr,
            'factor' => ['id' => $fId, 'title' => $factor->getTranslation()['title']]
        ]);
    }
    private function saveImage($image)
    {
        $ext = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $ext = explode('+', $ext)[0];
        $name = time() . '.' . $ext;
        $url = public_path('uploads/images/factorResult/') . $name;

        $header = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($header, '', $image);
        $image = str_replace(' ', '+', $image);

        file_put_contents($url, base64_decode($image));
        return '/uploads/images/factorResult/' . $name;
    }
    public function store(StoreFactorResultsRequest $request)
    {
        if (Gate::denies('factor_result_create')) {
            return abort(401);
        }

        $results = FactorResult::where('factor_id', $request->factor_id)
            ->get();
        if (count($results) >= GlobalConstants::MAX_FACTOR_RESULT_CNT) {
            return abort(401);
        }

        if ($request->get('img')) {
            $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
        } else if ($request->title == null) {
            return response("Validation Error", 500);
        }
        if ($request->get('min_score') >= $request->get('max_score')) {
            return response("Validation Error", 500);
        }
        //$result = Result::create($request->all());
        $result = new FactorResult();
        $result = $result->insertRecord($request->all());


        return (new FactorResultResource($result))
            ->response()
            ->setStatusCode(201);
    }
    public function getFactorResult($id, $locale)
    {
        $result = FactorResult::with([])->findOrFail($id);
        $otherInfo = ['img' => $result->img_url];

        $detail = array_merge($result->getTranslation($locale), $otherInfo);

        return new FactorResultResource(array_merge($result->toArray(), $detail));
    }

    public function show($id)
    {
        if (Gate::denies('factor_result_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';

        return $this->getFactorResult($id, $locale);
    }
    public function update(UpdateFactorResultsRequest $request, $id)
    {
        if (Gate::denies('factor_result_edit')) {
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
        $result = FactorResult::findOrFail($id);
        //$result->update($request->all());
        $result->updateRecord($request->all());
        $locale = isset($request->locale) ? $request->locale : 'en';
        return ($this->getFactorResult($id, $locale))
            ->response()
            ->setStatusCode(202);
    }
    public function destroy($id)
    {
        if (Gate::denies('factor_result_delete')) {
            return abort(401);
        }

        $result = FactorResult::findOrFail($id);
        $result->delete();

        return response(null, 204);
    }
}