<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        return [
            'title'=>'required|min2|max:20',
            'desc'=>'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'title.min'=>'至少两个字',
            'title.required'=>'标题不能为空',
            'title.main'=>'最多20个字',
            'desc.required'=>'问题描述不为空',
            'desc.min'='问题描述最少两个字',

        ]
    }
}
