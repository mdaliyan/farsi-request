<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mdaliyan\FarsiRequest\Traits\ReplaceNumbers;

class TestRequest extends FormRequest
{
    use ReplaceNumbers;

    private $mustHaveEnglishNumbers = ['phone_number'];
    private $mustHaveFarsiNumbers = ['post_content'];

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
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
