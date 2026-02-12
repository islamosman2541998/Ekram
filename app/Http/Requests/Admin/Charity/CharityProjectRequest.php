<?php

namespace App\Http\Requests\Admin\Charity;

use App\Enums\ProjectTypesEnum;
use App\Enums\LocationTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CharityProjectRequest extends FormRequest
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

    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title'         => 'required'];
            $req += [$locale . '.slug'          => 'required'];
            $req += [$locale . '.description'   => 'nullable'];
            $req += [$locale . '.meta_title'    => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key'      => 'nullable'];
            $req += [$locale . '.unit_price'    => 'nullable'];
        }
        $req += ['number'                       => 'nullable'];
        $req += ['beneficiary'                  => 'nullable'];
        $req += ['categories'                   => 'required'];
        $req += ['tags'                         => 'nullable'];
        $req += ['sort'                         => 'nullable'];
        $req += ['start_date'                   => 'nullable'];
        $req += ['end_date'                     => 'nullable'];
        $req += ['status'                       => 'nullable'];
        $req += ['most_sell'                       => 'nullable'];
        $req += ['featuer'                      => 'nullable'];
        $req += ['fast_donation'                => 'nullable'];
        $req += ['cashier_system'               => 'nullable'];
        $req += ['finished'                     => 'nullable'];
        $req += ['recurring'                    => 'nullable'];
        $req += ['location_type'                => 'required|' . Rule::in(LocationTypeEnum::values())];


        $req += ['donation_type'        => 'required'];
        if (request()->donation_type == "share") {
            $req += ['share_name'       => 'required'];
            $req += ['share_value'      => 'required'];
        } else if (request()->donation_type == "unit") {
            $req += ['donation_name'    => 'required'];
            $req += ['donation_value'   => 'required'];
        } else if (request()->donation_type == "fixed") {
            $req += ['fixed_value'      => 'required'];
        }

        $req += ['target_price'         => 'nullable'];
        $req += ['target_unit'          => 'nullable'];
        $req += ['fake_target'          => 'nullable'];
        $req += ['images'               => 'nullable|'];
        $req += ['cover_image'          => 'nullable|' . ImageValidate()];
        $req += ['background_image'     => 'nullable|' . ImageValidate()];
        $req += ['background_color'     => 'nullable'];

        return $req;
    }



    public function getSanitized()
    {
        $data = $this->validated();
        // $data['statistics'] = @$data['statistics'];
        $data['status'] = isset($data['status']) ? true : false;
        $data['most_sell'] = isset($data['most_sell']) ? $data['most_sell'] : 0;
        $data['featuer'] = isset($data['featuer']) ? true : false;
        $data['finished'] = isset($data['finished']) ? true : false;
        $data['recurring'] = isset($data['recurring']) ? true : false;
        $data['fast_donation'] = isset($data['fast_donation']) ? true : false;
        $data['project_types'] = ProjectTypesEnum::NORMAL;
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
