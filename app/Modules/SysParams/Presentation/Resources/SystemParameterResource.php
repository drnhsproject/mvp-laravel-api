<?php

namespace App\Modules\SysParams\Presentation\Resources;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Http\Request;

class SystemParameterResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'groups' => $this->groups,
            'key' => $this->key,
            'value' => $this->value,
            'ordering' => $this->ordering,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
