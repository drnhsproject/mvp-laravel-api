<?php

namespace App\Modules\Role\Presentation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'is_active' => $this->is_active,
            // Include privileges? Usually needed for editing.
            'privileges' => $this->whenLoaded('privileges', function () {
                return $this->privileges->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'module' => $p->module,
                        'action' => $p->action,
                        // 'namespace' => $p->namespace,
                    ];
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ];
    }
}
