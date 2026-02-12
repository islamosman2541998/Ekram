<?php

namespace App\Http\Requests\Admin\Charity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BeneficiariesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd(request()->all());
        $req = [];
        // Beneficiary-specific fields
        $req += ['first_name' => 'required|string|max:255|min:3'];
        $req += ['middle_name' => 'required|string|max:255|min:3'];
        $req += ['last_name' => 'required|string|max:255|min:3'];
        $req += ['gender' => 'required|in:male,female'];
        $req += ['nationality' => 'required|string'];
        $req += ['marital_status' => 'required|in:single,married,divorced,widowed'];
        $req += ['phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9'];
        $req += ['date_of_birth' => 'required|date'];
        $req += ['family_members' => 'required|in:1,2,3,4,5,6,7,8,9,10+'];
        // $req += ['education_level' => 'required|in:none,elementary,middle,high,bachelor,master,phd'];
        $req += ['education_level' => 'required|min:3'];
        $req += ['city' => 'required|string'];
        $req += ['district' => 'required|string'];
        $req += ['id_number' => 'required|string'];
        $req += ['civil_register' => 'required|string'];
        $req += ['email' => 'required|email'];
        $req += ['housing_status' => 'required|in:owned,rented,company,other'];
        // $req += ['job_type' => 'nullable|in:government,private,freelance,retired,unemployed,employee'];                             
        $req += ['job_type' => 'nullable|min:3'];                             
        // $req += ['monthly_income' => 'required|in:less5000,5000-10000,10000-15000,more15000'];
        $req += ['monthly_income' => 'required'];
        $req += ['previous_registration' => 'required|in:yes,no,نعم,لا'];
        $req += ['chronic_diseases' => 'required|in:yes,no,نعم,لا'];
        $req += ['special_needs' => 'required|in:yes,no,نعم,لا'];
        $req += ['other_income' => 'nullable|string'];
        $req += ['additional_notes' => 'nullable|string'];
        $req += ['status' => 'nullable'];

        // Account-related fields
        if (!$this->has('account_id')) {
            // Creating a new account
            $req += ['user_name' => 'required|min:3|unique:accounts,user_name'];
            $req += ['email' => 'required|email|unique:accounts,email'];
            $req += ['phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile'];
            $req += ['password' => 'required|string|min:8|max:250'];
        } else {
            // Updating an existing account
            $req += ['account_id' => 'required|exists:accounts,id'];
            $req += ['email' => 'required|email|unique:accounts,email,' . $this->account_id];
            $req += ['user_name' => 'nullable|unique:accounts,user_name,' . $this->account_id];
            $req += ['phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:accounts,mobile,' . $this->account_id];
            $req += ['password' => 'nullable|string|min:8|max:250'];
        }

        // dd($req);

        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();
        
        // Convert Arabic yes/no to English for database
        $booleanFields = ['previous_registration', 'chronic_diseases', 'special_needs'];
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = in_array(strtolower($data[$field]), ['yes', 'نعم']) ? 'yes' : 'no';
            }
        }
        
        $data['status'] = isset($data['status']) ? true : false;
        $data['type_login'] = ['beneficiaries'];
        return $data;
    }
}