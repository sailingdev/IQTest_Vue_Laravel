<?php

namespace App\Http\Controllers\Api\V1;

use App\Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setting as SettingResource;
use App\Http\Requests\Admin\StoreSettingsRequest;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class SettingsController extends Controller
{
    public function index()
    {
        return new SettingResource(Setting::all());
    }
}
