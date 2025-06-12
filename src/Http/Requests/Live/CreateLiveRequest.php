<?php

namespace ahmedWeb\LivePlatformManager\Http\Requests\Live;

use Illuminate\Foundation\Http\FormRequest;

class CreateLiveRequest extends FormRequest
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
            'platform_code' => 'required|exists:platforms,code',
            'live_account_id' => 'required|exists:live_accounts,id',
            'platform_session' => 'required|array',
            'platform_session.id' => 'required|integer',
            'platform_session.name' => 'required|string',
            'platform_session.description' => 'required|string',
            'platform_session.start_time' => 'required|date_format:H:i',
            'platform_session.end_time' => 'required|date_format:H:i',
            'platform_session.start_date' => 'required|date',
            'platform_session.end_date' => 'required|date',
            'platform_session.duration' => 'required|integer',
            'platform_session.platform_session_related_data' => 'nullable|json',
            'platform_type' => 'required|integer',
        ];
    }
}
