<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class RoomTypeController extends Controller
{
    public function AllRoomType() {
        $roomtypes = RoomType::latest()->get();

        return view('backend.roomtype.all_room_type', compact('roomtypes'));
    }

    public function AddRoomType() {
        return view('backend.roomtype.add_room_type');
    }
    
    public function StoreRoomType(Request $request) {
        $roomtype_id = RoomType::insertGetId([
            'name' => $request->name,
            'created_at' => Carbon::now()
        ]);

        Room::insert([
            'roomtype_id' => $roomtype_id,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Room Type created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room.type')->with($notification);
    }    
    
    public function EditRoomType($id) {
        $roomtype = RoomType::findOrFail($id);

        return view('backend.roomtype.edit_room_type', compact('roomtype'));
    }  
    
   public function StoreUpdatedRoomtype(Request $request) {
        $id = $request->id;
        
        RoomType::findOrFail($id)->update([
            'name' => $request->name,
            'updated_at' => Carbon::now()                
        ]);

        $notification = array(
            'message' => 'Room Type updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room.type')->with($notification);             
    }     

    public function DeleteRoomtype($id) {
        $roomtype = RoomType::findOrFail($id)->delete();
 
        $notification = array(
            'message' => 'Room Type deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room.type')->with($notification);             
    }    
}
