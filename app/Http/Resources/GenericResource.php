<?php
namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected $status;
    protected $message;
    protected $pagination;
    protected $statusCode;

    public function __construct(string $status, string $message, $resource = null, $pagination = null, int $statusCode = 200)
    {
        parent::__construct($resource);
        $this->status     = $status;
        $this->message    = $message;
        $this->pagination = $pagination;
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request): array
    {
        $response = [
            'status'  => $this->status,
            'message' => $this->message,
        ];
        if ($this->resource !== null) {
            $response['data'] = $this->resource;
        }
        if ($this->pagination !== null) {
            $response['pagination'] = [
                'current_page' => $this->pagination->currentPage(),
                'per_page'     => $this->pagination->perPage(),
                'total_page'   => $this->pagination->total(),
            ];
        }

        return $response;
    }

    public function toResponse($request): JsonResponse
    {
        return parent::toResponse($request)->setStatusCode($this->statusCode);
    }
}
