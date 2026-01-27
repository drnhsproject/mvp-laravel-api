<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{
    public function __construct($resource, public $message = 'Success')
    {
        parent::__construct($resource);
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message,
            'data' => $this->toArray($request),
        ]);
    }
}
