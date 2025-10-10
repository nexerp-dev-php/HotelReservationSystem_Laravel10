<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function AllTeam() {
        $team = Team::latest()->get();

        return view('backend.team.all_team', compact('team'));
    }

    public function AddTeam() {
        return view('backend.team.add_team');
    } 
    
    public function StoreTeam(Request $request) {
        //Version two and import driver is not needed
        /*$image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //create an unique ID with the same image extension

        //Image intervention to resize
        Image::make($image)->resize(550, 670)->save('upload/team/'.$name_gen);
        $save_url = 'upload/team/'.$name_gen;*/

        //Version 3
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());
        $image2 = $manager->read($image);
        $image2->resize(550, 670);
        $image2->save(public_path('upload/team/').$name_gen);

        $save_url = 'upload/team/'.$name_gen;

        Team::insert([
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Team Profile created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.team')->with($notification);
    }     
}
