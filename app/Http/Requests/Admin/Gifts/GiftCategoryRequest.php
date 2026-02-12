<?php

namespace App\Http\Requests\Admin\Gifts;

use App\Models\GiftCategories;
use Illuminate\Foundation\Http\FormRequest;

class GiftCategoryRequest extends FormRequest
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
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
        }
        $req += ['status' => 'nullable'];
        $req += ['sort' => 'nullable'];
        $req += ['parent_id' => 'nullable'];
        return $req;
    }

    
    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['level'] = updateLevel(@GiftCategories::find($data['parent_id']));
        
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
