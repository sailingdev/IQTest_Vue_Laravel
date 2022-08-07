<?php

namespace App\Http\Controllers\Api\V1;

use App\Language;
use App\Http\Controllers\Controller;
use App\Http\Resources\Language as LanguageResource;
use App\Http\Requests\Admin\StoreLanguagesRequest;
use App\Http\Requests\Admin\UpdateLanguagesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::with([])->get();
        return new LanguageResource($languages);
    }


    public function show($id)
    {
        if (Gate::denies('language_view')) {
            return abort(401);
        }

        $language = Language::with([])->findOrFail($id);

        return new LanguageResource($language);
    }

    public function store(StoreLanguagesRequest $request)
    {
        if (Gate::denies('language_create')) {
            return abort(401);
        }

        $language = Language::create($request->all());
        
        
        return (new LanguageResource($language))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateLanguagesRequest $request, $id)
    {
        if (Gate::denies('language_edit')) {
            return abort(401);
        }

        $language = Language::findOrFail($id);
        $language->update($request->all());

        return (new LanguageResource($language))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('language_delete')) {
            return abort(401);
        }

        $language = Language::findOrFail($id);
        $language->delete();

        return response(null, 204);
    }
}
