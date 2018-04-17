<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
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
            'id'             => 'required',
            'client_id'      => 'required',
            'validity'       => 'required',
            'quotation_date' => 'required',
            'quotation_no'   => 'required|unique:quotations,quotation_no,' . $this->id,
            'item'           => 'required',
        ];
    }

    private function deleteRules()
    {
        return $rules = [
            'id' => 'required'
        ];
    }
}
