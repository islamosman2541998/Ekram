<?php

namespace App\Http\Requests\Admin\Charity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReferRequest extends FormRequest
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
            'slug'                  => 'required|string',
            'name'                  => 'required|string|min:3|',
            'employee_name'         => 'nullable|string|min:3',
            'employee_number'       => 'nullable|string',
            'employee_image'        => 'nullable|' . ImageValidate(),
            'employee_department'   => 'nullable|string',
            'ax_store_name'         => 'nullable|string',
            'job'                   => 'nullable|string',
            'whatsapp'              => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'location'              => 'nullable|string',
            'details'               => 'nullable|string',
            'status'               => 'nullable|string',
            'children'   => ['sometimes', 'array'],
            'children.*' => ['integer', 'exists:refers,id'],
            'manager_id' => 'nullable|integer|exists:managers,id',

            'is_group_manager' => 'nullable|boolean',
            
        ];

        if (!$this->has('account_id')) {
            $req += ['user_name' => 'required|min:3'];
            $req += ['email' => 'required|email|' . Rule::unique('accounts', 'email')->ignore($this->get('id'))];
            $req += ['mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile|' . Rule::unique('accounts', 'mobile')->ignore($this->get('id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        } else {
            $req += ['account_id' => 'required|' . Rule::unique('refers', 'account_id')->ignore($this->get('id'))];
            $req += ['email' => 'required|email|' . Rule::unique('accounts', 'email')->ignore($this->get('account_id'))];
            $req += ['user_name' => 'nullable|' . Rule::unique('accounts', 'user_name')->ignore($this->get('account_id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        }
        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['type'] = ['refer'];
        return $data;
    }
}
