<?php

namespace App\Modules\Privilege\Presentation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivilegeResource extends JsonResource
{
    private string $message;

    public function __construct($resource, string $message = '')
    {
        parent::__construct($resource);
        $this->message = $message;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'module' => $this->module,
            'submodule' => $this->submodule,
            'action' => $this->action,
            'method' => $this->method,
            'uri' => $this->uri,
            'namespace' => $this->namespace,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
