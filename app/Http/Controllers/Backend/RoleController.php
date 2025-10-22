<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class RoleController extends Controller
{
    public function AllPermission() {
        $permissions = Permission::latest()->get();

        return view('backend.spatie.permission.all_permission', compact('permissions'));
    }

    public function AddPermission() {
        return view('backend.spatie.permission.add_permission');
    }

    public function StorePermission(Request $request) {
        Permission::insert([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Permission created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);        
    }

    public function DeletePermission($id) {
        $permission = Permission::find($id);

        if (!$permission) {
            return redirect()->back()->with([
                'message' => 'Permission not found',
                'alert-type' => 'error'
            ]);
        }

        try {
            $permission->roles()->detach(); // Optional: manually detach roles
            $permission->delete();
        } catch(\Exception $e) {
            dd($e->getTraceAsString());
        }
        return redirect()->back()->with([
            'message' => 'Permission deleted successfully',
            'alert-type' => 'success'
        ]);        
    }

    public function EditPermission($id) {
        $permission = Permission::findOrFail($id);

        return view('backend.spatie.permission.edit_permission', compact('permission'));        
    }

    public function StoreUpdatedPermission(Request $request) {
        $id = $request->id;
        
        Permission::findOrFail($id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'updated_at' => Carbon::now()                
        ]);

        $notification = array(
            'message' => 'Permission updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);    
    }
}
