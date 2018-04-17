<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'DELETE': {
                return $this->deleteRules();
            }
            case 'POST': {
                return $this->postRules();
            }
            case 'PATCH': {
                return $this->patchRules();
            }
            default:
                break;
        }
    }

    private function postRules()
    {
        return [
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required',
            'cfm-password' => 'required|same:password',
        ];
    }

    private function patchRules()
    {
        $input = $this->all();
        $rules = [
            'id'    => 'required',
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
        ];

        if ($input['password'] || $input['cfm-password']) {
            $addRules = [
                'password'     => 'required',
                'cfm-password' => 'required|same:password',
            ];
            $rules = array_merge($rules, $addRules);
        }

        return $rules;
    }

    private function deleteRules()
    {
        return [
            'id' => 'required'
        ];
    }

    /**
     * custom message for validation
     *
     * @return array
     * todo change to lang
     */
    public function messages()
    {
        return [
            'id.required'           => 'Please refresh the page and try again',
            'cfm-password.same'     => 'The password and confirm password does not match',
            'cfm-password.required' => 'The confirm password field is required'
        ];
    }
}
