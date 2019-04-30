<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'share_name' => 'required',
            'share_price' => 'required|integer',
            'share_qty' => 'required|integer',
            'image'=>'sometimes|file|image|max:5000'
        ];
    }
}
