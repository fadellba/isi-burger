<?php

namespace App\Http\Requests\Customer;

use App\Models\Order;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'items' => 'required|array|min:1',
            'items.*.burger_id' => 'required|exists:burgers,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
