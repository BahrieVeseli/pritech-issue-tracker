<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageIssueMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        $issue = $this->route('issue');

        return $issue?->project ? $this->user()?->can('update', $issue->project) ?? false : false;
    }

    public function rules(): array
    {
        return [];
    }
}
