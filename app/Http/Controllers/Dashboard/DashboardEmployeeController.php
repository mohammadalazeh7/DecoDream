<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardEmployeeRequest;
use App\Services\DashboardEmployeeService;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;


class DashboardEmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(DashboardEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        $query = $this->employeeService->getAll();

        if ($request->filled('user_search')) {
            $query->where('name', 'like', '%' . $request->user_search . '%');
        }

        if ($request->filled('email_search')) {
            $query->where('email', 'like', '%' . $request->email_search . '%');
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('user_search')) {
            return redirect()->route('employees.index')
                ->with('error', 'No results found according to your search');
        }

        if ($request->filled('email_search')) {
            return redirect()->route('employees.index')
                ->with('error', 'No results found according to your search');
        }

        $employees = $query->paginate(10)
            ->appends($request->except('page'));

        $roles = Role::where('id', '!=', 1)->orderBy('role_name')->get();

        return view('admin.employees.index', compact('employees', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.employees.create', compact('roles'));
    }

    public function store(DashboardEmployeeRequest $request)
    {
        $this->employeeService->create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $roles = Role::all();
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

    public function update(DashboardEmployeeRequest $request, Employee $employee)
    {
        $this->employeeService->update($request->validated(), $employee);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $this->employeeService->delete($employee);

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function delete(Employee $employee)
    {
        return view('admin.employees.delete', compact('employee'));
    }
}






