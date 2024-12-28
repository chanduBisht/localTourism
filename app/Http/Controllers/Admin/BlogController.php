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

use DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Blog')) {
            abort(403, 'You do not have permission to view blog.');
        }

        if(\request()->ajax()){
            $data = Blog::get();
            return DataTables::of($data)
                // Generate edit button link dynamically
                ->addColumn('action', function ($blog) {
                    // Edit Button
                    $editUrl = route('admin.blog.edit', $blog->id);
                    $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i>
                                  </a>';

                    // Delete Button
                    $deleteButton = '<a href="javascript:void(0);"
                                        class="btn btn-sm btn-danger delete-role" id="remove"
                                        data-id="' . $blog->id . '">
                                        <i class="fa fa-trash"></i>
                                     </a>';

                    // Combine Edit and Delete buttons
                    return $editButton. ' '. $deleteButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('Add Blog')) {
            abort(403, 'You do not have permission to add blog.');
        }

        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'detail_content' => ['required', 'string'],
            'image' => ['required'],
        ]);

        #save image
        $blogImage = null;
        if ($request->image) {
            $path  = config('image.profile_image_path_view');
            $blogImage = CommonController::saveImage($request->image, $path , 'blog');
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->short_description = $request->short_description;
        $blog->detail_content = $request->detail_content;
        $blog->image = $blogImage;
        $blog->status = 1;
        $blog->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->can('Delete Guide')) {
            abort(403, 'You do not have permission to delete guide.');
        }
        $blog = Blog::where('id',$id)->first();
        // #save image
        if($blog->image){
            $path = parse_url($blog->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }
        }
        $blog->destroy($id);
        return redirect()->back()->with('success', 'Blog Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->can('Edit Blog')) {
            abort(403, 'You do not have permission to edit blod.');
        }
        $data['blog'] = Blog::where('id',$id)->first();
        return view('admin.blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'detail_content' => ['required', 'string'],
        ]);

        $blog = Blog::where('id',$id)->first();

        #save image
        $blogImage = $blog->image;
        if ($request->image) {
            $path = parse_url($blog->image, PHP_URL_PATH);
            $storagePos = strpos($path, '/storage');

            $pathurl = substr($path, $storagePos + strlen('/storage'));
            if(File::exists('storage'.$pathurl))
            {
                File::delete('storage'.$pathurl);
            }

            $path  = config('image.profile_image_path_view');
            $blogImage = CommonController::saveImage($request->image, $path , 'blog');
        }

        $blog->title = $request->title;
        $blog->short_description = $request->short_description;
        $blog->detail_content = $request->detail_content;
        $blog->image = $blogImage;
        $blog->status = 1;
        $blog->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
    }


    public function editorImageAdd(Request $request)
    {
        $path  = config('image.profile_image_path_view');
        $link = CommonController::saveImage($request->image, $path , 'editorImages');
        $link = url($link);
        return response()->json(['url' => $link]);
    }

    public function editorImageDelete(Request $request)
    {
        $find = url('/storage');
        $pathurl = str_replace($find, "", $request->url);

        if(File::exists('storage'.$pathurl))
        {
            File::delete('storage'.$pathurl);
        }
        return response()->json(['status' => true, 'msg' => 'Image delete from storage.']);
    }

}
