<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'nullable'];
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.mission_title' => 'nullable'];
            $req += [$locale . '.mission_description' => 'nullable'];
            $req += [$locale . '.vision_title' => 'nullable'];
            $req += [$locale . '.vision_description' => 'nullable'];
            $req += [$locale . '.values_title' => 'nullable'];
            $req += [$locale . '.values_description' => 'nullable'];
        }
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['mission_image' => 'nullable|' . ImageValidate()];
        $req += ['vision_image' => 'nullable|' . ImageValidate()];
        $req += ['values_image' => 'nullable|' . ImageValidate()];

        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();

        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @auth()->user()->id;
        } else {
            $data['created_by'] = @auth()->user()->id;
        }

        return $data;
    }
}