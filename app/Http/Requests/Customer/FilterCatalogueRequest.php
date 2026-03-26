<?php

namespace App\Http\Requests\Customer;

use App\Models\Burger;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterCatalogueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('view', Burger::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'prix_min' => 'nullable|numeric|min:0',
            'prix_max' => 'nullable|numeric|gte:prix_min',
            'libelle' => 'nullable|string|max:255',
        ];
    }
}
