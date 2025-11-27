<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'author' => 'required|string|max:255',
            'content' => 'required|string|min:3',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'author.required' => 'Имя автора обязательно для заполнения',
            'author.max' => 'Имя автора не должно превышать 255 символов',
            'content.required' => 'Текст комментария обязателен для заполнения',
            'content.min' => 'Комментарий должен быть не менее 3 символов',
        ];
    }
}
