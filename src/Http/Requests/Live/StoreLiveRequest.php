<?php

namespace ahmedWeb\LivePlatformManager\Http\Requests\Live;

use Illuminate\Foundation\Http\FormRequest;

class StoreLiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True if the user is authorized, false otherwise.
     * This method can be used to restrict access to the request based on user permissions.
     */
    public function authorize(): bool
    {
        return true; // Allowing all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * This method defines the validation rules for the incoming request data.
     */
    public function rules(): array
    {
        return [
            "session_id" => "required|exists:sessions,id", // 'session_id' field is required and must exist in the 'sessions' table 'id' column
            "platform_type" => "required|integer", // 'platform_type' field is required and must be an integer
        ];
    }
}
