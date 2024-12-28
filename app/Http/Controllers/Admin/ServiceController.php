<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Places;
use App\Models\Hotels;
use App\Models\Guide;
use App\Models\Blog;
use App\Models\Service;

use DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Service')) {
            abort(403, 'You do not have permission to view blog.');
        }

        if(\request()->ajax()){
            $data = Service::get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($service) {
                    // Edit Button
                    $editUrl = route('admin.service.edit', $service->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $service->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Service')) {
            abort(403, 'You do not have permission to service blog.');
        }

        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required'],
        ]);

        #save image
        $serviceImage = null;
        if ($request->image) {
            $path  = config('image.profile_image_path_view');
            $serviceImage = CommonController::saveImage($request->image, $path , 'service');
        }

        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->image = $serviceImage;
        $service->status = 1;
        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('Delete Service')) {
            abort(403, 'You do not have permission to delete service.');
        }

        $service = Service::where('id',$id)->first();
        // #save image
        if($service->image){
            $path = parse_url($service->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }
        }
        $service->destroy($id);
        return redirect()->back()->with('success', 'Service Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Service')) {
            abort(403, 'You do not have permission to edit service.');
        }
        $data['service'] = Service::where('id',$id)->first();
        return view('admin.service.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $service = Service::where('id',$id)->first();

        #save image
        $serviceImage = $service->image;
        if ($request->image) {
            $path = parse_url($service->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }

            $path  = config('image.profile_image_path_view');
            $serviceImage = CommonController::saveImage($request->image, $path , 'service');
        }

        $service->name = $request->name;
        $service->description = $request->description;
        $service->image = $serviceImage;
        $service->status = 1;
        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service Updated Successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
    }
}
