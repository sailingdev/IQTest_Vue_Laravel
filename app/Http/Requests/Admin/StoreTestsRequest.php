<?php
namespace App\Http\Requests\Admin;

use App\Test;
use Illuminate\Foundation\Http\FormRequest;

class StoreTestsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Test::storeValidation($this);
    }
}
