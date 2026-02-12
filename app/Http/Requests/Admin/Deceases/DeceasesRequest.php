<?php

namespace App\Http\Requests\Admin\Deceases;

use Illuminate\Foundation\Http\FormRequest;

class DeceasesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->isMethod('POST') ?[

                'name' => ['required','string'],
                'email'=>['required' , 'email'],
                'mobile' =>['nullable','min:10'],
                'confirm_mobile' => ['nullable'],
                'image' => ['nullable'],
                'target_price' => ['nullable'],
                'description' => ['nullable'],
                'deceased_name' => ['required','string'],
                'relative_relation' => ['nullable'],
                'deceased_image' => ['nullable'],
                'status' => ['nullable'],
                'confirmed' => ['nullable'],
                'project_id' => ['required'],
                'created_by' => ['nullable'],
                'updated_by' => ['nullable'],



            ]:[
                'name' => ['required','string'],
                'email'=>['required' , 'email'],
                'mobile' =>['nullable','min:10'],
                'confirm_mobile' => ['nullable'],
                'image' => ['nullable'],
                'target_price' => ['nullable'],
                'description' => ['nullable'],
                'deceased_name' => ['required','string'],
                'relative_relation' => ['nullable'],
                'deceased_image' => ['nullable'],
                'status' => ['nullable'],
                'confirmed' => ['nullable'],
                'project_id' => ['required'],
                'created_by' => ['nullable'],
                'updated_by' => ['nullable'],

        ];
    }

    public function getSanitized(){
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['confirm_mobile'] = isset($data['confirm_mobile']) ? true : false;
        return $data;
    }
}
