<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'sometimes|required|unique:categories,name'
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
            'name' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required!'
        ];
    }
}
