<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です',
            // 'article.required' => '記事は必須です',
            'title.max' => 'タイトルは100文字以内です',
            // 'article.max' => '記事255文字以内です',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'message' => 'Failed validation',
            'errors' => $errors,
        ], 400, [], JSON_UNESCAPED_UNICODE));
    }




}
