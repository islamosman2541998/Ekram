<?php

namespace App\Http\Requests\Admin\Products;

use Locale;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $req += ['logo' => 'nullable|' . ImageValidate()];
        $req += ['responsible_person' => 'required'];
        $req += ['sort' => 'nullable'];
        $req += ['feature' => 'nullable'];
        $req += ['status' => 'nullable'];

        if (!$this->has('account_id')) {
            $req += ['user_name' => 'required|min:3'];
            $req += ['email' => 'required|email|' . Rule::unique('accounts' , 'email')->ignore($this->get('id'))];
            $req += ['mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile|' . Rule::unique('accounts', 'mobile')->ignore($this->get('id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        }
        else{
            $req += ['account_id' => 'required|' . Rule::unique('vendors' , 'account_id')->ignore($this->get('id'))];
            $req += ['email' => 'required|email|' . Rule::unique('accounts' , 'email')->ignore($this->get('account_id'))];
            $req += ['user_name' => 'nullable|' . Rule::unique('accounts' , 'user_name')->ignore($this->get('account_id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        }
        return $req;
    }





    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['type'] = ['vendor'];
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
