<?php

namespace App\Http\Requests\Admin\Badal;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubstituteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $req = [
            'full_name'     => 'required',
            'identity'      => 'required',
            'nationality'   => 'required',
            'gender'        => 'required',
            'image'         => 'required|' . ImageValidate(),
            'languages'     => 'required',
            'proportion'    => 'required',
            'status'        => 'nullable',
        ];

        if (!$this->has('account_id')) {
            $req += ['user_name' => 'required|min:3'];
            $req += ['email' => 'required|email|' . Rule::unique('accounts', 'email')->ignore($this->get('id'))];
            $req += ['mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile|' . Rule::unique('accounts', 'mobile')->ignore($this->get('id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        } else {
            $req += ['account_id' => 'required|' . Rule::unique('substitutes', 'account_id')->ignore($this->get('id'))];
            $req += ['email' => 'required|email|' . Rule::unique('accounts', 'email')->ignore($this->get('account_id'))];
            $req += ['user_name' => 'nullable|' . Rule::unique('accounts' , 'user_name')->ignore($this->get('account_id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        }

        $this->isMethod('POST') ? $req += ['password'  => 'required|' . ImageValidate()] :  $req += ['password'  => 'nullable|' . ImageValidate()];
           
        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['type'] = ['substitutes'];
        $data['languages'] = json_encode($data['languages']);
        return $data;
    }
}
