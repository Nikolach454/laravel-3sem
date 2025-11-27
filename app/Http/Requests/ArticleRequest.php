<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
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
            'title.required' => 'Заголовок обязателен для заполнения',
            'title.max' => 'Заголовок не должен превышать 255 символов',
            'content.required' => 'Содержание обязательно для заполнения',
            'content.min' => 'Содержание должно быть не менее 10 символов',
            'author.required' => 'Автор обязателен для заполнения',
            'author.max' => 'Имя автора не должно превышать 255 символов',
            'published_at.required' => 'Дата публикации обязательна',
            'published_at.date' => 'Некорректный формат даты',
        ];
    }
}
