<?php

namespace App\Http\Requests;

use App\Models\Admin\Employee;
 
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
