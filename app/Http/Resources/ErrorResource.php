<?php
namespace App\Http\Resources;

class ErrorResource extends GenericResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct(string $message, int $statusCode = 500, $resource = null, $pagination = null)
    {
        parent::__construct('error', $message, $resource, $pagination, $statusCode);
    }
}
