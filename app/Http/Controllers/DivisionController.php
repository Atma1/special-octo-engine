<?php
namespace App\Http\Controllers;

use App\Http\Requests\FilterDivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\SuccessResource;
use App\Models\Division;

/**
 * @group Division management
 *
 * APIs for managing Division
 */

class DivisionController extends Controller
{
    /**
     * Get All Divisions
     *
     * Retrieve a paginated list of divisions with optional name filtering.
     *
     * @authenticated
     *
     * @queryParam name string Filter divisions by name (partial match). Example: IT
     *
     * @response 200 scenario="Successful retrieval" {
     *   "success": "success",
     *   "message": "Divisions fetched successfully.",
     *   "data": [
     *      "divisions": [
     *     {
     *       "id": "uuid-here",
     *       "name": "Information Technology"
     *     },
     *     {
     *       "id": "uuid-here-2",
     *       "name": "Human Resources"
     *     }
     *      ]
     *   ],
     *   "pagination": {
     *     "current_page": 1,
     *     "per_page": 5,
     *     "total": 10
     *   }
     * }
     */
    public function index(FilterDivisionRequest $request): SuccessResource
    {
        $query = Division::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $divisions = $query->paginate(5);
        return new SuccessResource('Divisions fetched successfully.',
            ['divisions' => DivisionResource::collection($divisions)], $divisions);
    }
}
