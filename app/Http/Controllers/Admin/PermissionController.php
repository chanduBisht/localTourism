<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Permissions')) {
            abort(403, 'You do not have permission to view all permission.');
        }
        if(\request()->ajax()){
            $data = Permission::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Permissions')) {
            abort(403, 'You do not have permission to add permission.');
        }
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|unique:permissions',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $role = Permission::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);
            DB::commit();
            return redirect()->route('admin.permissions.index')->with('success', 'Permission added successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
