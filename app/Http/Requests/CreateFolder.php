<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * リクエストの内容に基づいた権限チェックを行うメソッド
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *バリデーションルールを定義するメソッド
     * 
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:20',
            //
        ];
    }


    /**
     * リクエストのnameなどの属性名を再定義するメソッド
     *
     * @return array<string>
     */
    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }
}
