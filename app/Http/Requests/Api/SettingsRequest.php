<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'portal_name' => 'required',
            'logo' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'portal_name.required' => 'Portal Name is required!',
            'logo.required' => 'Logo is required!',
            'email.required' => 'Email is required!'
        ];
    }
}
