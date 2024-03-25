<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class RequestAdv extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'name' => ['required','string','max:25'],
//            'description' => ['required','string'],
//            'price' => [ 'integer'],
//            'type' => ['string'],
//            'category_id' => ['integer'],
//          'sub_category_id' => ['integer'],
            'user_id' => ['integer'],
//            'city_id' => ['integer'],
//            'investment_sum_min' => ['integer'],
//            'investment_sum_max' => [ 'integer'],
//            'investment_size' => [ 'integer'],
        ];
    }
}
