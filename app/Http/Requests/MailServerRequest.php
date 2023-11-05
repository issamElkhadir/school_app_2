<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class MailServerRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'priority' => 'required|integer|min:1',
      'active' => 'required|boolean',
      'username' => 'required|string|max:255',
      'password' => 'required|string|max:255',
      'smtp_host' => 'required|string|max:255',
      'smtp_port' => 'required|int|min:1|max:65535',
      'smtp_encryption' => [
        'nullable',
        Rule::in(['tls', 'ssl']),
      ],
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => [
        'sometimes',

        Rule::unique('mail_servers', 'name')
          ->ignore($this->mail_server->id)
      ],

      'priority' => 'sometimes',
      'active' => 'sometimes',
      'username' => 'sometimes',
      'password' => 'sometimes',
      'smtp_host' => 'sometimes',
      'smtp_port' => 'sometimes',
      'smtp_encryption' => 'sometimes',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => Rule::unique('mail_servers', 'name'),
    ];
  }
}
