<?php
namespace App\Http\Resources;

class SuccessResource extends GenericResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function __construct(string $message, $resource = null, $pagination = null, $statusCode = 200)
    {
        parent::__construct('success', $message, $resource, $pagination, $statusCode);
    }

}
