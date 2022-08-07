<?php

namespace App\Http\Controllers\Api\V1;

use App\Factor;
use App\Test;
use App\Http\Controllers\Controller;
use App\Http\Resources\Factor as FactorResource;
use App\Http\Requests\Admin\StoreFactorsRequest;
use App\Http\Requests\Admin\UpdateFactorsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class FactorsController extends Controller
{
    public function index()
    {
        return new FactorResource(Test::all());
    }
    public function getFactors($tId)
    {


        $factors = Factor::where('test_id', $tId)
            ->get();


        $test = Test::find($tId);
        $factorArr = array();
        foreach ($factors as $factor) {
            //get english value for default
            $tran = $factor->getTranslation();
            if (!$tran) {
                continue;
            }
            array_push($factorArr, [
                'id'                    =>  $factor->id,
                'title'                 =>  $tran['title'],
                'factor_result_cnt'     =>  $factor->factorResults()->count(),
                'img_url'               =>  $factor->img_url,
                'description'           =>  $tran['description'],
            ]);
        }

        return new FactorResource([
            'items' => $factorArr,
            'test' => ['id' => $tId, 'title' => $test->getTranslation()['title']]
        ]);
    }
    private function saveImage($image)
    {
        $ext = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $ext = explode('+', $ext)[0];
        $name = time() . '.' . $ext;
        $url = public_path('uploads/images/factor/') . $name;


        $header = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($header, '', $image);
        $image = str_replace(' ', '+', $image);

        file_put_contents($url, base64_decode($image));
        return '/uploads/images/factor/' . $name;
    }
    public function store(StoreFactorsRequest $request)
    {
        if (Gate::denies('factor_create')) {
            return abort(401);
        }

        if ($request->get('img')) {
            $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
        }
        // } else if ($request->title == null) {
        //     return response("Validation Error", 500);
        // }

        $factor = new Factor();
        $factor = $factor->insertRecord($request->all());


        return (new FactorResource($factor))
            ->response()
            ->setStatusCode(201);
    }
    public function getFactor($id, $locale = 'en')
    {
        if (!$locale) {
            $locale = 'en';
        }
        $factor = Factor::with([])->findOrFail($id);
        $otherInfo = [
            'img'                   =>  $factor->img_url,
            'factor_result_cnt'     =>  $factor->factorResults()->count(),
        ];

        $detail = array_merge($factor->getTranslation($locale), $otherInfo);

        return new FactorResource(array_merge($factor->toArray(), $detail));
    }
    public function show($id)
    {
        if (Gate::denies('factor_view')) {
            return abort(401);
        }

        $locale = isset($_GET['locale']) ? $_GET['locale'] : 'en';

        return $this->getFactor($id, $locale);
    }
    public function update(UpdateFactorsRequest $request, $id)
    {
        if (Gate::denies('factor_edit')) {
            return abort(401);
        }
        $factor = Factor::findOrFail($id);

        if ($request->get('img')) {
            if (!$request->get('img_url') || $request->img != $request->img_url) {
                $request->merge(['img_url' => $this->saveImage($request->get('img'))]);
            }
        } else {
            //delete file
            $request->merge(['img_url' => null]);
        }

        $locale = isset($request->locale) ? $request->locale : 'en';

        $factor->updateRecord($request->all());


        return ($this->getFactor($id, $locale))
            ->response()
            ->setStatusCode(202);
    }
    public function destroy($id)
    {
        if (Gate::denies('factor_delete')) {
            return abort(401);
        }

        $factor = Factor::findOrFail($id);
        $factor->delete();

        return response(null, 204);
    }
}