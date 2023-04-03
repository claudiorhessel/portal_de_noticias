<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'full_name' => 'sometimes|required|min:5',
            'nickname' => 'sometimes|required|unique:author,nickname',
            'birtdate' => 'sometimes|required|before:now|date_format:Y-m-d',
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
            'full_name' => 'required',
            'nickname' => 'required|unique:authors,nickname',
            'birtdate' => 'required|before:now|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full Name is required!',
            'nickname.required' => 'Nickname Name is required!',
            'nickname.unique' => 'Nickname must be unique!',
            'birtdate.required' => 'Birtdate is required!',
            'birtdate.before' => 'Birtdate must be a date before now!',
            'birtdate.required' => 'Birtdate must match the format Y-m-d!"',
        ];
    }
}
