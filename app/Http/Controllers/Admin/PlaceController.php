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
use DataTables;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Place')) {
            abort(403, 'You do not have permission to add place.');
        }
        if(\request()->ajax()){
            $data = Places::get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($place) {
                    // Edit Button
                    $editUrl = route('admin.places.edit', $place->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $place->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.places.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Place')) {
            abort(403, 'You do not have permission to add place.');
        }
        return view('admin.places.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'image' => ['required'],
        ]);

        #save image
        $placeImage = null;
        if ($request->image) {
            $path  = config('image.profile_image_path_view');
            $placeImage = CommonController::saveImage($request->image, $path , 'place');
        }

        $place = Places::create([
            'name' => $request->name,
            'image'  => $placeImage,
        ]);

        return redirect()->route('admin.places.index')->with('success', 'Place Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $place = Places::where('id',$id)->first();
        if($place->image)
        {
            $path = parse_url($place->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }
        }
        $place->destroy($id);
        return response()->json(['status' => true,'message' => 'Place Deleted successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Place')) {
            abort(403, 'You do not have permission to add place.');
        }
        $data['place'] = Places::where('id',$id)->first();
        return view('admin.places.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $place = Places::where('id',$id)->first();

        #save image
        $placeImage = $place->image;
        if ($request->image) {
            $path = parse_url($place->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }

            $path  = config('image.profile_image_path_view');
            $placeImage = CommonController::saveImage($request->image, $path , 'place');
        }

        $place->name = $request->name;
        $place->image = $placeImage;
        $place->save();

        return redirect()->route('admin.places.index')->with('success', 'Place Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('Delete Place')) {
            abort(403, 'You do not have permission to delete place.');
        }
        return $id;
    }
}
