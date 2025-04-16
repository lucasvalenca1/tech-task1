<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For now, allow anyone to attempt creation.
        // Add authorization logic here if needed (e.g., check user roles/permissions).
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get country codes from config for the 'in' rule
        $countryCodes = array_keys(config('countries', []));

        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Unique for creation
            'phone' => 'required|string|max:20',
            'country' => ['required', 'string', Rule::in($countryCodes)], // Use Rule::in
            'gender' => 'required|string', // Consider Rule::in(['Male', 'Female', ...]) later
            'password' => 'required|string|min:8|confirmed', // Required for creation
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom error messages for validator errors. (Optional)
     *
     * @return array<string, string>
     */
    // public function messages(): array
    // {
    //     return [
    //         'country.in' => 'Please select a valid country from the list.',
    //         // Add other custom messages if desired
    //     ];
    // }
}
