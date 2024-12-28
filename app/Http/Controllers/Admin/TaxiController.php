<?php

namespace App\Http\Controllers\Admin;


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

use DataTables;

class TaxiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Taxi')) {
            abort(403, 'You do not have permission to add view.');
        }

        if(\request()->ajax()){
            $data = Taxi::with('place')->where('user_id',auth()->user()->id)->get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($taxi) {
                    // Edit Button
                    $editUrl = route('admin.taxi.edit', $taxi->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $taxi->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.taxi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Taxi')) {
            abort(403, 'You do not have permission to add taxi.');
        }

        $data['places'] = Places::all();

        return view('admin.taxi.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'car_number' => ['required'],
            'car_price' => ['required'],
            'car_availability' => ['required'],
            'car_description' => ['required'],
            'image' => ['required'],
        ]);

        #save image
        $carImage = [];
        if ($request->image) {
            foreach($request->image as $image){
                $path  = config('image.profile_image_path_view');
                $carImg = CommonController::saveImage($image, $path , 'car');

                array_push($carImage, $carImg);
            }
        }

        $car = new Taxi();
        $car->user_id = Auth::user()->id;
        $car->place_id = $request->place_id;
        $car->name = $request->name;
        $car->car_number = $request->car_number;
        $car->car_price = $request->car_price;
        $car->car_availability = $request->car_availability;
        $car->car_description = $request->car_description;
        $car->image = implode(',',$carImage);
        $car->status = 1;
        $car->save();

        return redirect()->route('admin.taxi.index')->with('success', 'Taxi Service Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Taxi::where('id',$id)->first();
        $carImage = explode(',',$car->image);
        if(count($carImage) > 0){
            foreach($carImage as $image){

                $path = parse_url($image, PHP_URL_PATH);
                $storagePos = strpos($path, '/storage');

                $pathurl = substr($path, $storagePos + strlen('/storage'));
                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }
            }
        }
        $car->destroy($id);
        return redirect()->back()->with('success', 'Car Service Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Taxi')) {
            abort(403, 'You do not have permission to edit taxi.');
        }
        $data['taxi'] = Taxi::where('id',$id)->first();
        $data['places'] = Places::all();
        return view('admin.taxi.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'place_id' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'car_number' => ['required'],
            'car_price' => ['required'],
            'car_availability' => ['required'],
            'car_description' => ['required'],
        ]);

        $car = Taxi::where('id',$id)->first();

        // #save image
        $carImage = explode(',',$car->image);

        if ($request->image) {

            if(count($carImage) > 0){
                foreach($carImage as $image){

                    $path = parse_url($image, PHP_URL_PATH);
                    $storagePos = strpos($path, '/storage');

                    $pathurl = substr($path, $storagePos + strlen('/storage'));
                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }
                }
            }

            $carImage = [];

            foreach($request->image as $image){
            $path  = config('image.profile_image_path_view');
            $carImg = CommonController::saveImage($image, $path , 'car');

            array_push($carImage, $carImg);
            }
        }

        $car->place_id = $request->place_id;
        $car->name = $request->name;
        $car->car_number = $request->car_number;
        $car->car_price = $request->car_price;
        $car->car_availability = $request->car_availability;
        $car->car_description = $request->car_description;
        $car->image = implode(',',$carImage);
        $car->status = 1;
        $car->save();

        return redirect()->route('admin.taxi.index')->with('success', 'Taxi Service Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('Delete Taxi')) {
            abort(403, 'You do not have permission to delete taxi.');
        }
        return $id;
    }
}
