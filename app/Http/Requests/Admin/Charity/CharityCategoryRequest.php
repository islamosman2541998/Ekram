<?php

namespace App\Http\Requests\Admin\Charity;

use Locale;
use App\Models\CategoryProjects;
use App\Enums\ProjectTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharityCategoryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.content' => 'nullable'];

            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['background_image' => 'nullable|' . ImageValidate()];
        $req += ['background_color' => 'nullable'];
        $req += ['statistics' => 'nullable'];
        $req += ['status' => 'nullable'];
        $req += ['main_home' => 'nullable'];
        $req += ['sort' => 'nullable'];
        $req += ['feature' => 'nullable'];
        $req += ['fast_donation' => 'nullable'];
        $req += ['cashier_system' => 'nullable'];
        $req += ['parent_id' => 'nullable'];
        $req += ['project_types' => 'nullable|' . Rule::in(ProjectTypesEnum::values())];
        return $req;
    }


    public function getSanitized()
    {

        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['statistics'] = @$data['statistics'];
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['cashier_system'] = isset($data['cashier_system']) ? true : false;
        $data['fast_donation'] = isset($data['fast_donation']) ? true : false;
        $data['main_home'] = isset($data['main_home']) ? true : false;
        $data['level'] = updateLevel(@CategoryProjects::find($data['parent_id']));
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
