<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class FrontEndRoomController extends Controller
{
    public function ListAllRoom() {
        $rooms = Room::latest()->get();
        return view('frontend.room.all_rooms', compact('rooms'));
    }

    public function ShowRoom($id) {
        $room = Room::findOrFail($id);

        return view('frontend.room.show_room', compact('room'));
    }
}
