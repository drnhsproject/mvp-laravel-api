<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseListResource extends ResourceCollection
{
    protected $message;
    protected $resourceClass;

    public function __construct($resource, $message = 'Success', $resourceClass = null)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->resourceClass = $resourceClass;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->collection;

        if ($this->resourceClass) {
            $data = $this->resourceClass::collection($this->collection);
        }

        return [
            'message' => $this->message,
            'data' => [
                'results' => $data,
                'total_item' => $this->resource->total(),
            ],
        ];
    }

    public function toResponse($request)
    {
        return response()->json($this->toArray($request));
    }
}
