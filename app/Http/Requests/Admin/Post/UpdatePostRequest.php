<?php

namespace App\Http\Requests\Admin\Post;

use App\Enum\PostStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePostRequest extends FormRequest
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
            "post_id" => "required|exists:posts,id",
            "title" => "required|string",
            "description" => "required|string",
            "location" => "required|string",
            "price" => "required|string",
            "city" => "required|string",
            "rooms" => "required|integer",
            "kitchens" => "required|integer",
            "bedrooms" => "required|integer",
            "bathrooms" => "required|integer",
            "category" =>  ["nullable",new Enum(PostStatusEnum::class)],
            "images" => "nullable|array", // الصور يجب أن تكون مصفوفة
            "images.*" => "image|mimes:jpeg,png,jpg,gif|max:2048",
        ];
    }
}
