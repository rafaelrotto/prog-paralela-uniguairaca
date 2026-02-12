<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if (auth()->user()->type != 'admin' && $this->input('type') == 'admin') {
        //     return false;
        // }

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
            'name' => 'required|max:50|string',
            'email' => 'required|unique:users,email|max:100|string',
            'status' => [
                'required',
                'in:active,inactive'
            ],
            'type' => 'required|in:admin,manager,teacher,student',
            'password' => 'required|min:8|max:50|string',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome deve ter no máximo :max caracteres.',
            'name.string' => 'O campo nome deve ser uma string.',
            'email.required' => 'O campo email é obrigatório.',
            'email.unique' => 'O email informado já está em uso.',
            'email.max' => 'O campo email deve ter no máximo :max caracteres.',
            'email.string' => 'O campo email deve ser uma string.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O campo status deve ser "active" ou "inactive".',
            'type.required' => 'O campo tipo é obrigatório.',
            'type.in' => 'O campo tipo deve ser "admin", "manager", "teacher" ou "student".',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter no mínimo :min caracteres.',
            'password.max' => 'O campo senha deve ter no máximo :max caracteres.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password_confirmation.required' => 'O campo confirmação de senha é obrigatório.',
            'password_confirmation.same' => 'O campo confirmação de senha deve ser igual ao campo senha.'
        ];
    }
}
