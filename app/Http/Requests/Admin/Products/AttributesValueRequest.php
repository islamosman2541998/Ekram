<?php

namespace App\Http\Requests\Admin\Products;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class AttributesValueRequest extends FormRequest
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
            // $req += [$locale . '.slug' => 'required'];
        }
        $req += ['color' => 'nullable|'];
        $req += ['status' => 'nullable'];
        $req += ['sort' => 'nullable'];
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['attribute_set_id' => 'nullable'];
        $req += ['updated_by' => 'nullable'];
        $req += ['created_by' => 'nullable'];
        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['title']);
        }
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
