<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return match($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy()
        };
    }

    /**
     * Get the validation rules that apply to the put/patch request.
     *
     * @return array
     */
    public function update(): array
    {
        return [
            'title' => 'sometimes|required|unique:news,title',
            'author_id' => 'sometimes|required',
            'wysiwyg_content' => 'sometimes|required',
        ];
    }

    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store(): array
    {
        return [
            'title' => 'required|unique:news,title',
            'author_id' => 'required',
            'wysiwyg_content' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required!',
            'title.unique' => 'Title must be unique!',
            'author_id.required' => 'Author ID is required!',
            'wysiwyg_content.required' => 'Wysiwyg Content is required!'
        ];
    }
}
