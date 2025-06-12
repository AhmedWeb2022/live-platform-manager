<?php

namespace ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\LiveAccount;

use Illuminate\Foundation\Http\FormRequest;

class StoreLiveAccountRequest extends FormRequest
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
            // 'platform_id' => 'required|exists:platforms,id',
            'integeration_type' => 'required',
            'name' => 'required_if:integeration_type,1,2',
            'client_id' => 'required_if:integeration_type,1,2',
            'client_secret' => 'required_if:integeration_type,1,2',
            'account_id' => 'required_if:integeration_type,1',
            'sdk_key' => 'required_if:integeration_type,1',
            'sdk_secret' => 'required_if:integeration_type,1',
            'join_url' => 'required_if:integeration_type,1,2,3',
        ];
    }
}
