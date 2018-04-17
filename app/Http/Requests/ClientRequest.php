<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        return $rules = [
            'name'         => 'required',
            'company_name' => 'required'
        ];
    }

    private function patchRules()
    {
        $rules = ['id' => 'required'];
        $rules = array_merge($rules, $this->postRules());

        return $rules;
    }

    private function deleteRules()
    {
        return $rules = ['id' => 'required'];
    }

    public function messages()
    {
        return [
            'id.required' => 'Please refresh the page and try again',
        ];
    }
}
