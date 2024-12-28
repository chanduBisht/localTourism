<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;
use App\Models\OrderDetail;

class CommonController extends Controller
{

    public static function generate_uuid()
    {
        $uuid = (string) Str::uuid();
        if (self::uuid_exists($uuid)) {
            return  self::generate_uuid();
        }
        return $uuid;
    }

    public static function uuid_exists($uuid)
    {
        return User::where('unique_id', $uuid)->exists();
    }

    public static function saveImage($image, $path, $filename)
    {
        $path  =  base_path($path);

        $image_extension    = $image->getClientOriginalExtension();
        $image_size         = $image->getSize();
        $type               = $image->getMimeType();

        $new_name           = rand(1111, 9999) . date('mdYHis') . uniqid() . '.' . $image_extension;
        $thumbnail_name     = 'thumbnail_' . rand(1111, 9999) . date('mdYHis') . uniqid() . '.' .  $image_extension;

        $image->move("storage/app/images/$filename", $new_name);

        $userImageUrl = "/storage/app/images/$filename/".$new_name;
        if($userImageUrl){
            return $userImageUrl;
        }else{
            return null;
        }
    }

    public static function allPermissions($type = '')
    {
        $query = Permission::all();
        return $query;
    }

    public static function getRolePermission($role_id)
    {
        if (!empty($role_id)) {
            $role = Role::find($role_id);
            return $role->permissions();
        } else {
            return null;
        }
    }

    public static function showRolePermission($role_id, $type = '')
    {

        // dd($type);
        #get all permission
        $allPermissionsLists  = self::allPermissions($type);

        #get role permission ids
        if ($role_id) {
            $rolePermissions    = self::getRolePermission($role_id);
            $rolePermissions    = !empty($rolePermissions) ? $rolePermissions->pluck('id')->toArray() : null;
        } else {
            $rolePermissions = [];
        }

        return [
            'allPermissionsLists' => !empty($allPermissionsLists) ? $allPermissionsLists : null,
            'allGroups'           => !empty($allPermissionsLists) ? array_values(array_unique($allPermissionsLists->pluck('group')->toArray())) : null,
            'rolePermissions'     => $rolePermissions,
        ];
    }
}
