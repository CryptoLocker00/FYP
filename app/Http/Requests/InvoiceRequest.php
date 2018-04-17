<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            case 'POST': {
                return $this->IdOnlyRules();
            }

            case 'DELETE': {
                return $this->IdOnlyRules();
            }

            case 'PATCH': {
                return $this->patchRules();
            }

            default:
                break;
        }
    }

    private function patchRules()
    {
        return $rules = [
            'id'         => 'required',
            'invoice_no' => 'required|unique:invoice,invoice_no,' . $this->id,
        ];
    }

    private function IdOnlyRules()
    {
        return $rules = [
            'id' => 'required'
        ];
    }
}
