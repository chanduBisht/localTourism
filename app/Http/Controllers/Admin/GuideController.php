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

use DataTables;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Guide')) {
            abort(403, 'You do not have permission to add guide.');
        }

        if(\request()->ajax()){
            $data = Guide::where('user_id',auth()->user()->id)->get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($guide) {
                    // Edit Button
                    $editUrl = route('admin.guide.edit', $guide->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $guide->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.guide.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Guide')) {
            abort(403, 'You do not have permission to add guide.');
        }

        $data['places'] = Places::all();
        return view('admin.guide.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'designation' => ['required', 'string'],
            'image' => ['required'],
        ]);

        #save image
        $guideImage = null;
        if ($request->image) {
            $path  = config('image.profile_image_path_view');
            $guideImage = CommonController::saveImage($request->image, $path , 'guide');
        }

        $guide = new Guide();
        $guide->user_id = Auth::user()->id;
        $guide->place_id = $request->place_id;
        $guide->name = $request->name;
        $guide->designation = $request->designation;
        $guide->image = $guideImage;
        $guide->status = 1;
        $guide->save();

        return redirect()->route('admin.guide.index')->with('success', 'Guide Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('Delete Guide')) {
            abort(403, 'You do not have permission to delete guide.');
        }
        $guide = Guide::where('id',$id)->first();
        // #save image
        if($guide->image){
            $path = parse_url($guide->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }
        }
        $guide->destroy($id);
        return redirect()->back()->with('success', 'Guide Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Guide')) {
            abort(403, 'You do not have permission to add guide.');
        }
        $data['guide'] = Guide::where('id',$id)->first();
        $data['places'] = Places::all();
        return view('admin.guide.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'designation' => ['required', 'string'],
        ]);

        $guide = Guide::where('id',$id)->first();

        #save image
        $guideImage = $guide->image;
        if ($request->image) {
            $path = parse_url($guide->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }

            $path  = config('image.profile_image_path_view');
            $guideImage = CommonController::saveImage($request->image, $path , 'guide');
        }

        $guide->place_id = $request->place_id;
        $guide->name = $request->name;
        $guide->designation = $request->designation;
        $guide->image = $guideImage;
        $guide->status = 1;
        $guide->save();

        return redirect()->route('admin.guide.index')->with('success', 'Guide Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
    }
}
