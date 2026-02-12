<?php

namespace App\Http\Requests\Admin\Products;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class AttributesSetRequest extends FormRequest
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

        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
        }
        $req += ['is_searchable' => 'nullable|'];
        $req += ['status' => 'nullable'];
        $req += ['sort' => 'nullable'];
        $req += ['feature' => 'nullable'];
        $req += ['display_layout' => 'required'];

        $req += ['updated_by' => 'nullable'];
        $req += ['created_by' => 'nullable'];


        return $req;
    }


    public function getSanitized()
    {

        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['is_searchable'] = isset($data['is_searchable']) ? true : false;

        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
