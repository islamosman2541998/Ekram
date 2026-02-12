<?php

namespace App\Http\Requests\Admin\Charity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VolunteersRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(){

        $req = [];
        
        $req += ['name' => 'required|string|max:255|min:3'];
        $req += ['identity' => 'required|string|min:3'];
        $req += ['type' => 'required'];
        $req += ['team_name' => 'nullable'];
        $req += ['team_logo' => 'nullable|' . ImageValidate()];
        $req += ['nationality' => 'required'];
        $req += ['gender' => 'required'];
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['medal' => 'nullable'];
        $req += ['working_hours' => 'nullable'];
        $req += ['effective' => 'nullable'];
        $req += ['status' => 'nullable'];
        $req += ['activity' => 'nullable'];

        
        if (!$this->has('account_id')) {
            $req += ['user_name' => 'required|min:3'];
            $req += ['email' => 'required|email|' . Rule::unique('accounts', 'email')->ignore($this->get('id'))];
            $req += ['mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile|' . Rule::unique('accounts', 'mobile')->ignore($this->get('id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];

        } else {
            $req += ['account_id' => 'required|' . Rule::unique('volunteers', 'account_id')->ignore($this->get('id'))];
            $req += ['email' => 'required|email|' . Rule::unique('accounts', 'email')->ignore($this->get('account_id'))];
            $req += ['user_name' => 'nullable|' . Rule::unique('accounts' , 'user_name')->ignore($this->get('account_id'))];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        }
        return $req;
    }

    public function getSanitized(){
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['type_login'] = ['volunteers'];
        return $data;
    }
    
}
