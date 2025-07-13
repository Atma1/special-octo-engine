<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'token' => $this['token'],
            'admin' => [
                'id'       => $this['admin']['id'],
                'name'     => $this['admin']['name'],
                'username' => $this['admin']['username'],
                'phone'    => $this['admin']['phone'],
                'email'    => $this['admin']['email'],
            ],
        ];
    }
}
