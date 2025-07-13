<?php
namespace App\Http\Controllers;

use App\Http\Requests\EmployeeIndexRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Employee;

/**
 * @group User management
 *
 * APIs for managing users
 */

class EmployeeController extends Controller
{
    /**
     * Get All Employees
     *
     * Retrieve a paginated list of employees with optional filtering by name and division.
     *
     * @authenticated
     *
     * @queryParam name string Filter employees by name (partial match). Example: John
     * @queryParam division_id string Filter employees by division ID. Example: uuid-division-id
     *
     * @response 200 scenario="Successful retrieval" {
     *   "status": "success",
     *   "message": "Employee fetched successfully.",
     *   "data": {
     *     "employees": [
     *       {
     *         "id": "uuid-employee-id",
     *         "image": "https://example.com/image.jpg",
     *         "name": "John Doe",
     *         "phone": "081234567890",
     *         "division": {
     *           "id": "uuid-division-id",
     *           "name": "Information Technology"
     *         },
     *         "position": "Software Developer"
     *       }
     *     ]
     *   },
     *   "pagination": {
     *     "current_page": 1,
     *     "per_page": 5,
     *     "total": 25
     *   }
     * }
     *
     * @response 422 scenario="Invalid request body" {
     *   "message": "The following field is required. (and n more errors)"
     *   "error":  errorArray
     * }
     */
    public function index(EmployeeIndexRequest $request)
    {
        $query = Employee::with('division');
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }
        $employees = $query->paginate(5);
        return new SuccessResource(
            'Employee fetched successfully.',
            ['employees' => EmployeeResource::collection($employees)],
            $employees
        );
    }

    /**
     * Create New Employee
     *
     * Create a new employee record with the provided information.
     *
     * @authenticated
     *
     * @bodyParam image string required URL of the employee's profile image. Example: https://example.com/image.jpg
     * @bodyParam name string required Full name of the employee. Example: John Doe
     * @bodyParam phone string required Phone number of the employee. Example: 081234567890
     * @bodyParam division string required UUID of the division. Example: uuid-division-id
     * @bodyParam position string required Job position of the employee. Example: Software Developer
     *
     * @response 201 scenario="Employee created successfully" {
     *   "status": "success",
     *   "message": "Employee created successfully."
     * }
     * @response 422 scenario="Invalid request body" {
     *   "message": "The following field is required. (and 4 more errors)"
     *   "error":  errorArray
     * }
     */
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create([
            'image'       => $request->image,
            'name'        => $request->name,
            'phone'       => $request->phone,
            'division_id' => $request->division,
            'position'    => $request->position,
        ]);
        return response(new SuccessResource('Employee created successfully.'), 201);
    }

    /**
     * Update Employee
     *
     * Update an existing employee's information by UUID.
     *
     * @authenticated
     *
     * @urlParam uuid string required The UUID of the employee to update. Example: uuid-employee-id
     *
     * @bodyParam image string required URL of the employee's profile image. Example: https://example.com/updated-image.jpg
     * @bodyParam name string required Full name of the employee. Example: Jane Doe
     * @bodyParam phone string required Phone number of the employee. Example: 081234567891
     * @bodyParam division string required UUID of the division. Example: uuid-division-id
     * @bodyParam position string required Job position of the employee. Example: Senior Developer
     *
     * @response 200 scenario="Employee updated successfully" {
     *   "status":: "success",
     *   "message": "Employee updated successfully."
     * }
     *
     * @response 404 scenario="Employee not found" {
     *   "status":: "error",
     *   "message": "Employee not found."
     * }
     * @response 422 scenario="Invalid request body" {
     *   "message": "The following field is required. (and 4 more errors)"
     *   "error":  errorArray
     * }
     */
    public function update(UpdateEmployeeRequest $request, $uuid)
    {
        $employee = Employee::where('id', $uuid)->first();
        if (! $employee) {
            return new ErrorResource('Employee not found.', 404);
        }
        $employee->update([
            'image'       => $request->image,
            'name'        => $request->name,
            'phone'       => $request->phone,
            'division_id' => $request->division,
            'position'    => $request->position,
        ]);
        return response(new SuccessResource('Employee updated successfully.'));
    }

    /**
     * Delete Employee
     *
     * Delete an employee record by UUID.
     *
     * @authenticated
     *
     * @urlParam uuid string required The UUID of the employee to delete. Example: uuid-employee-id
     *
     * @response 200 scenario="Employee deleted successfully" {
     *   "status": "success",
     *   "message": "Employee deleted successfully."
     * }
     *
     * @response 404 scenario="Employee not found" {
     *   "status": "error",
     *   "message": "Employee not found."
     * }
     *
     * @response 422 scenario="Invalid request body" {
     *   "message": "The image field is required. (and 4 more errors)"
     *   "error":  errorArray
     * }
     */
    public function destroy($uuid)
    {
        $employee = Employee::where('id', $uuid)->first();
        if (! $employee) {
            return new ErrorResource('Employee not found.', 404);
        }
        $employee->delete();
        return response(new SuccessResource('Employee deleted successfully.'));
    }
}
