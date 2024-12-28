<?php

namespace App\Http\Controllers;

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
use App\Models\Service;
use App\Models\Guide;
use App\Models\Blog;

use DataTables;

class FrontendController extends Controller
{
    public function index()
    {
        $data['places'] = Places::with('hotel','taxi','traking')->get();
        $data['services'] = Service::all();
        $data['guides'] = Guide::all();
        $data['blogs'] = Blog::all();

        // print_r($data['blogs']->toarray()); die;
        return view('index', $data);
    }

    public function about()
    {
        $data['guides'] = Guide::all();
        // print_r($data['blogs']->toarray()); die;
        return view('about', $data);
    }

    public function service()
    {
        $data['services'] = Service::all();
        // print_r($data['blogs']->toarray()); die;
        return view('service', $data);
    }

    public function blog()
    {
        $data['blogs'] = Blog::all();
        // print_r($data['blogs']->toarray()); die;
        return view('blog', $data);
    }

    public function blogdetail($blog)
    {
        $data['blog'] = Blog::find($blog);
        // print_r($data['blog']->toarray()); die;
        return view('blog-detail', $data);
    }

    public function guide()
    {
        $data['guides'] = Guide::all();
        // print_r($data['blogs']->toarray()); die;
        return view('guide', $data);
    }

    public function package()
    {
        $data['places'] = Places::with('hotel','taxi','traking')->get();
        // print_r($data['places']->toarray()); die;
        return view('package', $data);
    }

    public function destination()
    {
        $data['places'] = Places::with('hotel','taxi','traking')->get();
        // print_r($data['places']->toarray()); die;
        return view('destination', $data);
    }
}
