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

use DataTables;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Hotel')) {
            abort(403, 'You do not have permission to add place.');
        }

        if(\request()->ajax()){
            $data = Hotels::with('place')->where('user_id',auth()->user()->id)->get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($place) {
                    // Edit Button
                    $editUrl = route('admin.hotels.edit', $place->id);
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

        return view('admin.hotels.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Hotel')) {
            abort(403, 'You do not have permission to add place.');
        }

        $data['places'] = Places::all();
        return view('admin.hotels.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required'],
            'check_in' => ['required'],
            'check_out' => ['required'],
            'image' => ['required'],
        ]);

        #save image
        $hotelImage = [];
        if ($request->image) {
            foreach($request->image as $image){
                $path  = config('image.profile_image_path_view');
                $hotel = CommonController::saveImage($image, $path , 'hotel');

                array_push($hotelImage, $hotel);
            }
        }

        $hotel = new Hotels();
        $hotel->user_id = Auth::user()->id;
        $hotel->place_id = $request->place_id;
        $hotel->name = $request->name;
        $hotel->description = $request->description;
        $hotel->facility =  implode(',',$request->facility);
        $hotel->location = $request->location;
        $hotel->check_in = $request->check_in;
        $hotel->check_out = $request->check_out;
        $hotel->image = implode(',',$hotelImage);
        $hotel->status = 1;
        $hotel->save();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel Created Successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotels::where('id',$id)->first();
        // #save image
        $hotelImage = explode(',',$hotel->image);
        if(count($hotelImage) > 0){
            foreach($hotelImage as $image){

                $path = parse_url($image, PHP_URL_PATH);
                $storagePos = strpos($path, '/storage');

                $pathurl = substr($path, $storagePos + strlen('/storage'));
                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }
            }
        }
        $hotel->destroy($id);
        return redirect()->back()->with('success', 'Hotel Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Hotel')) {
            abort(403, 'You do not have permission to add place.');
        }
        $data['hotel'] = Hotels::where('id',$id)->first();
        $data['places'] = Places::all();
        return view('admin.hotels.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required'],
            'check_in' => ['required'],
            'check_out' => ['required'],
        ]);

        $hotel = Hotels::where('id',$id)->first();
        // #save image
        $hotelImage = explode(',',$hotel->image);

        if ($request->image) {

            if(count($hotelImage) > 0){
                foreach($hotelImage as $image){

                    $path = parse_url($image, PHP_URL_PATH);
                    $storagePos = strpos($path, '/storage');

                    $pathurl = substr($path, $storagePos + strlen('/storage'));
                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }
                }
            }

            $hotelImage = [];

            foreach($request->image as $image){
                $path  = config('image.profile_image_path_view');
                $hotelimg = CommonController::saveImage($image, $path , 'hotel');

                array_push($hotelImage, $hotelimg);
            }
        }

        $hotel->place_id = $request->place_id;
        $hotel->name = $request->name;
        $hotel->description = $request->description;
        $hotel->facility =  implode(',',$request->facility);
        $hotel->location = $request->location;
        $hotel->check_in = $request->check_in;
        $hotel->check_out = $request->check_out;
        $hotel->image = implode(',',$hotelImage);
        $hotel->status = 1;
        $hotel->save();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('Delete Hotel')) {
            abort(403, 'You do not have permission to delete hotel.');
        }
        return $id;
    }
}
