<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'invoice_number' => 'required|string',
			'product' => 'required|string',
			'section_id' => 'required',
			'Amount_Commission' => 'required',
			'Discount' => 'required',
			'Value_VAT' => 'required',
			'Rate_VAT' => 'required|string',
			'Total' => 'required',
			'Status' => 'required|string',
			'Value_Status' => 'required',
			'note' => 'string',
        ];
    }
}
