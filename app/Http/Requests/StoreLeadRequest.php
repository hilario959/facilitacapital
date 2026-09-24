<?php

namespace App\Http\Requests;

use App\Support\Finance;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $nit = strtoupper(trim((string) $this->input('nit')));
        $nit = str_replace([' ', '.'], '', $nit);

        $this->merge([
            'email' => strtolower(trim((string) $this->input('email'))),
            'whatsapp' => trim((string) $this->input('whatsapp')),
            'nit' => $nit,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:30', function (string $attribute, mixed $value, \Closure $fail): void {
                $digits = preg_replace('/\D/', '', (string) $value) ?? '';
                if (strlen($digits) < 8 || strlen($digits) > 15) {
                    $fail('Ingresa un WhatsApp válido, con código de país si hace falta.');
                }
            }],
            'nit' => ['required', 'string', 'max:20', 'regex:/^[0-9]{5,12}(-?[0-9K])?$/'],
            'amount' => ['required', 'numeric', 'min:0'],
            'days' => ['required', 'integer', 'in:'.implode(',', Finance::TERMS)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Ingresa tu correo.',
            'email.email' => 'Ingresa un correo válido.',
            'whatsapp.required' => 'Ingresa tu WhatsApp.',
            'nit.required' => 'Ingresa tu NIT.',
            'nit.regex' => 'Ingresa un NIT válido.',
            'amount.required' => 'Indica el monto de tus facturas.',
            'days.required' => 'Elige el plazo de pago.',
            'days.in' => 'Elige un plazo de 30, 60, 90 o 120 días.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422));
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
