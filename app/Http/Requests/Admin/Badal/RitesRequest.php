<?php

namespace App\Http\Requests\Admin\Badal;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class RitesRequest extends FormRequest
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
        }
        $this->isMethod('POST') ?
            $req += ['image' => 'required|' . ImageValidate()]
            :
            $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['project_id' => 'required'];
        $req += ['status' => 'nullable'];
        $req += ['sort' => 'nullable'];
        $req += ['proof' => 'nullable'];
        $req += ['updated_by' => 'nullable'];
        $req += ['created_by' => 'nullable'];

        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['proof'] = isset($data['proof']) ? true : false;
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
