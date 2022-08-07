<?php

namespace App\Http\Controllers\Api\V1;

use App\Option2;
use App\Http\Controllers\Controller;
use App\Http\Resources\Option2 as Option2Resource;
use App\Http\Requests\Admin\StoreOption2sRequest;
use App\Http\Requests\Admin\UpdateOption2sRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class Option2sController extends Controller
{
    public function index()
    {
        return new Option2Resource(Option2::all());
    }
}
