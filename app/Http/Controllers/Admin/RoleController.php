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

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View All Roles')) {
            abort(403, 'You do not have permission to view all roles.');
        }
        $data = Role::get();

        if(\request()->ajax()){
            $data = Role::get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($role) {
                    // Edit Button
                    $editUrl = route('admin.roles.edit', $role->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    // $deleteButton = '<a href="javascript:void(0);"
                    //                     class="btn btn-sm btn-danger delete-role"
                    //                     data-id="' . $role->id . '">
                    //                     <i class="fa fa-trash"></i>
                    //                  </a>';

                    // Combine Edit and Delete buttons
                    return $editButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Roles')) {
            abort(403, 'You do not have permission to add the roles.');
        }
        $data['permissions'] = CommonController::showRolePermission(null);
        return view('admin.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|unique:roles',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if($request->permissions){
                $permissions = Permission::whereIn('id',$request->permissions)->get()->pluck('id');
            }else{
                $permissions = array();
            }

            $role->syncPermissions($permissions);
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Role added successfully');
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
        $role = Role::where('id', $id)->first();
        $permissions = CommonController::showRolePermission($role->id);

        return view('admin.role.edit', compact('permissions','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|unique:roles,name,'.$id,
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $role = Role::where('id', $id)->first();
            $role->name       = $request->name;
            $role->guard_name = 'web';
            $role->save();

            if($request->permissions){
                $permissions = Permission::whereIn('id',$request->permissions)->get()->pluck('id');
            }else{
                $permissions = array();
            }

            $role->syncPermissions($permissions);

            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
