<?php

namespace App\Http\Requests\Admin\Products;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class ProductProductRequest extends FormRequest
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

    public function rules() {
        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.description' => 'nullable'];

            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }

        $this->isMethod('POST') ?   $req += ['image' =>'nullable']  : $req += ['image' =>'nullable'];

        $this->isMethod('POST') ?  $req += ['cover_image' =>'nullable|' . ImageValidate()] :  $req += ['image' =>'nullable|' . ImageValidate()];

                // $req += ['quantity'         =>'required'];
        $req += ['sku'              =>'required'];
        $req += ['price'            =>'required|numeric|gte:vendor_price'];
        $req += ['vendor_price'     =>'required|numeric'];
        $req += ['start_at'         =>'nullable'];
        $req += ['end_at'           =>'nullable'];
        $req += ['status'           =>'nullable'];
        $req += ['sort'             =>'nullable'];
        $req += ['feature'          =>'nullable'];
        $req += ['is_cheacked'      =>'nullable'];
        $req += ['category_id'      =>'nullable'];
        $req += ['vendor_id'        =>'nullable'];
        $req += ['sale_price'       =>'nullable'];
        $req += ['cover_image'      =>'nullable'];
        $req += ['updated_by'       =>'nullable'];
        $req += ['created_by'       =>'nullable'];
        $req += ['attributes'       =>'nullable'];

        return $req;
    }

    public function getSanitized(){
        $data = $this->validated();
        foreach (config('translatable.locales') as $locale) {
            if(@$data[$locale]['slug'] != null) continue; 
            $data[$locale]['slug'] = slug($data[$locale]['title']);
        }
        $data['is_cheacked'] = isset($data['is_cheacked']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['is_variance'] = 0;
        if (request()->isMethod('PUT')){
            $data['updated_by']  = @auth()->user()->id;
        }
        else{
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
