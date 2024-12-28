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

use DataTables;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Room')) {
            abort(403, 'You do not have permission to view room.');
        }

        if(\request()->ajax()){
            $data = Rooms::with('hotel')->where('user_id',auth()->user()->id)->get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($room) {
                    // Edit Button
                    $editUrl = route('admin.rooms.edit', $room->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $room->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.rooms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Room')) {
            abort(403, 'You do not have permission to add room.');
        }

        $data['hotels'] = Hotels::all();

        return view('admin.rooms.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'room_price' => ['required'],
            'room_availability' => ['required'],
            'room_description' => ['required'],
            'image' => ['required'],
        ]);

        #save image
        $roomImage = [];
        if ($request->image) {
            foreach($request->image as $image){
                $path  = config('image.profile_image_path_view');
                $roomImg = CommonController::saveImage($image, $path , 'room');

                array_push($roomImage, $roomImg);
            }
        }

        $room = new Rooms();
        $room->user_id = Auth::user()->id;
        $room->hotel_id = $request->hotel_id;
        $room->name = $request->name;
        $room->room_price = $request->room_price;
        $room->room_availability = $request->room_availability;
        $room->room_description = $request->room_description;
        $room->image = implode(',',$roomImage);
        $room->status = 1;
        $room->save();

        return redirect()->route('admin.rooms.index')->with('success', 'Room Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Rooms::where('id',$id)->first();
        $roomImage = explode(',',$room->image);
        if(count($roomImage) > 0){
            foreach($roomImage as $image){

                $path = parse_url($image, PHP_URL_PATH);
                $storagePos = strpos($path, '/storage');

                $pathurl = substr($path, $storagePos + strlen('/storage'));
                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }
            }
        }
        $room->destroy($id);
        return redirect()->back()->with('success', 'Room Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Room')) {
            abort(403, 'You do not have permission to edit place.');
        }
        $data['room'] = Rooms::where('id',$id)->first();
        $data['hotels'] = Hotels::all();
        return view('admin.rooms.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'hotel_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'room_price' => ['required'],
            'room_availability' => ['required'],
            'room_description' => ['required'],
        ]);

        $room = Rooms::where('id',$id)->first();

        // #save image
        $roomImage = explode(',',$room->image);

        if ($request->image) {

            if(count($roomImage) > 0){
                foreach($roomImage as $image){

                    $path = parse_url($image, PHP_URL_PATH);
                    $storagePos = strpos($path, '/storage');

                    $pathurl = substr($path, $storagePos + strlen('/storage'));
                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }
                }
            }

            $roomImage = [];
            foreach($request->image as $image){
                $path  = config('image.profile_image_path_view');
                $roomImg = CommonController::saveImage($image, $path , 'room');

                array_push($roomImage, $roomImg);
            }
        }

        $room->user_id = Auth::user()->id;
        $room->hotel_id = $request->hotel_id;
        $room->name = $request->name;
        $room->room_price = $request->room_price;
        $room->room_availability = $request->room_availability;
        $room->room_description = $request->room_description;
        $room->image = implode(',',$roomImage);
        $room->status = 1;
        $room->save();

        return redirect()->route('admin.rooms.index')->with('success', 'Room Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('Delete Room')) {
            abort(403, 'You do not have permission to delete room.');
        }
        return $id;
    }
}
