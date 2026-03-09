<?php

namespace App\Http\Requests;

use App\Models\Service;
 
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
