<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function EditRoom($id) {
        $room = Room::findOrFail($id);
        $basic_facility = Facility::where('room_id', $id)->get();
        $gallery_images = MultiImage::where('room_id', $id)->get();

        return view('backend.room.edit_room', compact('room', 'basic_facility', 'gallery_images'));
    }

    public function StoreUpdatedRoom(Request $request, $id) {
        $room = Room::findOrFail($id);
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;
        $room->view = $request->view;
        $room->bed_type = $request->bed_type;
        $room->discount = $request->discount;
        $room->short_desc = $request->short_desc;
        $room->description = $request->description;

        //main image
        if($request->file('image')) {
            $img = $room->image;
            if(!empty($img)) {
                if(file_exists('upload/room/'.$img)) {
                    unlink('upload/room/'.$img);
                }
            }

            //Version 3
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $image2 = $manager->read($image);
            $image2->resize(550, 850);
            $image2->save(public_path('upload/room/').$name_gen);

            $room->image = $name_gen;
        }

        //Update Facility table
        if($request->facility_name == null) {
            $notification = array(
                'message' => 'Missing facility data. Request has been rejected.',
                'alert-type' => 'error'
            );      
            
            return redirect()->back()->with($notification);         
        } else {
            Facility::where('room_id', $id)->delete();

            $facilities = Count($request->facility_name);
            for($i=0; $i<$facilities; $i++) {
                $facility = new Facility();
                $facility->room_id = $room->id;
                $facility->facility_name = $request->facility_name[$i];
                $facility->save();
            }
        }

        //multi image table
        if($room->save()) {
            $files = $request->multi_img;
            if(!empty($files)) {
                $uploadedImages = MultiImage::where('room_id', $id)->get()->toArray();
                MultiImage::where('room_id', $id)->delete();

                if(!empty($uploadedImages)) {
                    foreach($uploadedImages as $image) {
                        if(file_exists('upload/room/'.$image['multi_img'])) {
                            unlink('upload/room/'.$image['multi_img']);
                        }
                    }
                }
            }

            if(!empty($files)) {
                foreach($files as $file) {
                    //Version 3
                    $image = $file;
                    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

                    $manager = new ImageManager(new Driver());
                    $image2 = $manager->read($image);
                    $image2->resize(1000, 700);
                    $image2->save('upload/room/'.$name_gen);

                    $multiImage = new MultiImage();
                    $multiImage->room_id = $room->id;
                    $multiImage->multi_img = $name_gen;

                    $multiImage->save();
                }
            }

            $notification = array(
                'message' => 'Room info updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.room.type')->with($notification);               
        }

    }

    public function DeleteRoomGalleryImage($id) {
        $multiImage = MultiImage::findOrFail($id);
        $img = $multiImage->multi_img;
        if(file_exists('upload/room/'.$img)) {
              unlink('upload/room/'.$img);
        }

        $multiImage->delete();

        $notification = array(
            'message' => 'Gallery image deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room.type')->with($notification);             
    }
}
