<?php

namespace App\Http\Requests\webhook;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebhookSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You can add authorization logic here if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string|max:255',

            // Customer event toggles
            'enable_customer_create' => 'sometimes|boolean',
            'enable_customer_update' => 'sometimes|boolean',
            'enable_customer_delete' => 'sometimes|boolean',

            // Product event toggles
            'enable_product_create' => 'sometimes|boolean',
            'enable_product_update' => 'sometimes|boolean',
            'enable_product_delete' => 'sometimes|boolean',

            // Invoice event toggles
            'enable_invoice_create' => 'sometimes|boolean',
            'enable_invoice_update' => 'sometimes|boolean',
            'enable_invoice_delete' => 'sometimes|boolean',
        ];
    }

    /**
     * Convert checkbox fields to boolean before validation.
     */
    protected function prepareForValidation()
    {
        $checkboxes = [
            'enable_customer_create', 'enable_customer_update', 'enable_customer_delete',
            'enable_product_create', 'enable_product_update', 'enable_product_delete',
            'enable_invoice_create', 'enable_invoice_update', 'enable_invoice_delete',
        ];

        foreach ($checkboxes as $field) {
            $this->merge([
                $field => $this->has($field),
            ]);
        }
    }
}
