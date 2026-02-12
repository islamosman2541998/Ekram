<?php

namespace App\Http\Requests\Admin\Gifts;

use Illuminate\Foundation\Http\FormRequest;

class GiftCardsRequest extends FormRequest
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
        $req = [];
        $req += ['category_id' => 'required'];
        $req += ['occasioins' => 'nullable|array'];
        $req += ['status' => 'nullable'];
        $req += ['price' => 'nullable'];
        $req += ['sort' => 'nullable'];

        if($this->isMethod('POST')){
            $req += ['image' =>'required|' . ImageValidate()];
        }
        else{ 
            $req += ['image' =>'nullable|' . ImageValidate()];
        }
        return $req;
    }


    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
