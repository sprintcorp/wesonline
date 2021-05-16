<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\Models\Role;

class RoleManager extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
        $this->middleware('permission:Create group',['only' => ['permissionsIndex','rolesIndex']]);
//        $this->middleware('role:System');
    }
    public function permissionsIndex()
    {
        return Permission::all();
    }


    public function rolesIndex()
    {
//        return Role::all();
        return auth()->user()->user_permission->pluck('name');

    }


    /**
     * @param Request $request
     * @param Role $role
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesAddUser(Request $request, Role $role, User $user)
    {

        $user->assignRole($role);

        return response()->json([
            "message" => $role->name . " Role successfully assigned to User!"
        ], 200);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionAddUser(Request $request, Permission $permission, User $user)
    {

        $user->assignUserPermission($permission);

        return response()->json([
            "message" => $permission->name . " Permission successfully assigned to User!"
        ], 200);
    }


    /**
     * @param Request $request
     * @param Role $role
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesRemoveUser(Request $request, Role $role, User $user)
    {
        $user->removeRole($role);

        return response()->json([
            "message" => $role->name . " Role successfully removed from User"
        ], 200);
    }
}
