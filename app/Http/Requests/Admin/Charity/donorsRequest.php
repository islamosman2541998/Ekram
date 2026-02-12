<?php

namespace App\Http\Requests\Admin\Charity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class donorsRequest extends FormRequest
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
        $req += ['full_name' => 'required|string'];
        $req += ['refer_id' => 'nullable'];
        $req += ['mobile_confirm' => 'nullable'];
        $req += ['status' => 'nullable'];
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['addressList' => 'nullable'];
        $req += ['old_id' => 'nullable'];
        

        if (!$this->has('account_id')) {
            $req += ['user_name' => 'required|min:3'];
            $req += ['email' => 'required|email|' . Rule::unique('accounts' , 'email')->ignore($this->get('account_id'))];
            $req += ['mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile|' . Rule::unique('accounts', 'mobile')->ignore($this->get('id'))];
        }
        else{
            $req += ['account_id' => 'required|' . Rule::unique('donors' , 'account_id')->ignore($this->get('id'))];
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
        $data['mobile_confirm'] = isset($data['mobile_confirm']) ? true : false;
        $data['type'] = ['donor'];
        return $data;
    }
}
