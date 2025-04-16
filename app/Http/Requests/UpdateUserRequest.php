<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For now, allow anyone to attempt update.
        // Add authorization logic here (e.g., check if authenticated user matches $this->route('user'))
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

        // Get the user ID from the route parameter ('user') to ignore in unique check
        // $this->route('user') retrieves the User model instance via route model binding
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            // Unique email rule ignores the current user being updated
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'phone' => 'required|string|max:20',
            'country' => ['required', 'string', Rule::in($countryCodes)], // Use Rule::in
            'gender' => 'required|string', // Consider Rule::in later
            'password' => 'nullable|string|min:8|confirmed', // Password optional on update
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
