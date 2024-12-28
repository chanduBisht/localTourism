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
use App\Models\Rooms;
use App\Models\Taxi;
use App\Models\Traking;

use DataTables;

class TrakingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Traking')) {
            abort(403, 'You do not have permission to view traking.');
        }

        if(\request()->ajax()){
            $data = Traking::with('place')->where('user_id',auth()->user()->id)->get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($track) {
                    // Edit Button
                    $editUrl = route('admin.traking.edit', $track->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $track->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.traking.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Traking')) {
            abort(403, 'You do not have permission to add traking.');
        }

        $data['places'] = Places::all();

        return view('admin.traking.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'track_km' => ['required'],
            'track_price' => ['required'],
            'track_start_time' => ['required'],
            'track_days' => ['required'],
            'track_availability' => ['required'],
            'track_description' => ['required'],
            'image' => ['required'],
        ]);

        #save image
        $trackImage = [];
        if ($request->image) {
            foreach($request->image as $image){
                $path  = config('image.profile_image_path_view');
                $trackImg = CommonController::saveImage($image, $path , 'track');

                array_push($trackImage, $trackImg);
            }
        }

        $track = new Traking();
        $track->user_id = Auth::user()->id;
        $track->place_id = $request->place_id;
        $track->name = $request->name;
        $track->track_km = $request->track_km;
        $track->track_price = $request->track_price;
        $track->track_start_time = $request->track_start_time;
        $track->track_days = $request->track_days;
        $track->track_availability = $request->track_availability;
        $track->track_description = $request->track_description;
        $track->image = implode(',',$trackImage);
        $track->status = 1;
        $track->save();

        return redirect()->route('admin.traking.index')->with('success', 'Tracking Service Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $track = Traking::where('id',$id)->first();
        $trackImage = explode(',',$track->image);
        if(count($trackImage) > 0){
            foreach($trackImage as $image){

                $path = parse_url($image, PHP_URL_PATH);
                $storagePos = strpos($path, '/storage');

                $pathurl = substr($path, $storagePos + strlen('/storage'));
                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }
            }
        }
        $track->destroy($id);
        return redirect()->back()->with('success', 'Traking Service Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Traking')) {
            abort(403, 'You do not have permission to edit taxi.');
        }
        $data['traking'] = Traking::where('id',$id)->first();
        $data['places'] = Places::all();
        return view('admin.traking.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'track_km' => ['required'],
            'track_price' => ['required'],
            'track_start_time' => ['required'],
            'track_days' => ['required'],
            'track_availability' => ['required'],
            'track_description' => ['required'],
        ]);

        $track = Traking::where('id',$id)->first();

        // #save image
        $trackImage = explode(',',$track->image);

        if ($request->image) {

            if(count($trackImage) > 0){
                foreach($trackImage as $image){

                    $path = parse_url($image, PHP_URL_PATH);
                    $storagePos = strpos($path, '/storage');

                    $pathurl = substr($path, $storagePos + strlen('/storage'));
                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }
                }
            }

            $trackImage = [];
            foreach($request->image as $image){
            $path  = config('image.profile_image_path_view');
            $trackImg = CommonController::saveImage($image, $path , 'track');

            array_push($trackImage, $trackImg);
            }
        }

        $track->place_id = $request->place_id;
        $track->name = $request->name;
        $track->track_km = $request->track_km;
        $track->track_price = $request->track_price;
        $track->track_start_time = $request->track_start_time;
        $track->track_days = $request->track_days;
        $track->track_availability = $request->track_availability;
        $track->track_description = $request->track_description;
        $track->image = implode(',',$trackImage);
        $track->status = 1;
        $track->save();

        return redirect()->route('admin.traking.index')->with('success', 'Tracking Service Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('Delete Taxi')) {
            abort(403, 'You do not have permission to delete traking.');
        }
        return $id;
    }
}
