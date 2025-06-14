<?php


namespace ahmedWeb\LivePlatformManager\Http\Requests\Live;

use Illuminate\Foundation\Http\FormRequest;

class JoinLiveRequest extends FormRequest
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
            "session_id" => "required|exists:sessions,id",
            "platform_type" => "required|integer",
        ];
    }
}
