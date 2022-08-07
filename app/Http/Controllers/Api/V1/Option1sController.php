<?php

namespace App\Http\Controllers\Api\V1;

use App\Option1;
use App\Http\Controllers\Controller;
use App\Http\Resources\Option1 as Option1Resource;
use App\Http\Requests\Admin\StoreOption1sRequest;
use App\Http\Requests\Admin\UpdateOption1sRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class Option1sController extends Controller
{
    public function index()
    {
        return new Option1Resource(Option1::all());
    }
}
