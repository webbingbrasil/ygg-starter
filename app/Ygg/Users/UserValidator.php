<?php

namespace App\Ygg\Users;

use Ygg\Form\Validator\FormRequest;

class UserValidator extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $id = request()->route('instanceId');
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($id ? ','.$id.',id' : ''),
            'password' => ($id ? 'nullable|' : 'required|').'min:8|confirmed'
        ];
    }
}
