<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Inertia\Inertia;
Use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Return Inertia::render('Employees/Index', [
            'employees' => Employee::all(), 
            //'employees' => Employee::select('id', 'nombre', 'email', 'posicion')->paginate(10), 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employees/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'posicion' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0'
        ]);
        Employee::create($request->all());
        return redirect()->route('employees.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'posicion' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0'
        ]);
        $employee->update($request->all());
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();   
        return Inertia::render('Employees/Index', [
            'employees' => Employee::all()
        ]);
    }
}
