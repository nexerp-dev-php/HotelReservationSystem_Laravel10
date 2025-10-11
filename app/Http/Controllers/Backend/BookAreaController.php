<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookArea;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class BookAreaController extends Controller
{
    public function AllBookArea() {
        $bookareas = BookArea::latest()->get();

        return view('backend.bookarea.all_book_area', compact('bookareas'));
    }

    public function AddBookArea() {
        return view('backend.bookarea.add_book_area');
    } 
    
    public function StoreBookarea(Request $request) {
        //Version 3
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());
        $image2 = $manager->read($image);
        $image2->resize(1000, 1000);
        $image2->save(public_path('upload/bookarea/').$name_gen);

        $save_url = 'upload/bookarea/'.$name_gen;

        BookArea::insert([
            'short_title' => $request->short_title,
            'main_title' => $request->main_title,
            'short_desc' => $request->short_desc,
            'link_url' => $request->link_url,
            'image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Book Area created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.book.area')->with($notification);
    }  

    public function EditBookarea($id) {
        $bookarea = BookArea::findOrFail($id);

        return view('backend.bookarea.edit_book_area', compact('bookarea'));
    } 
    
   public function StoreUpdatedBookarea(Request $request) {
        $id = $request->id;
        
        if($request->file('image')) {
            //Version 3
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $image2 = $manager->read($image);
            $image2->resize(1000, 1000);
            $image2->save(public_path('upload/bookarea/').$name_gen);

            $save_url = 'upload/bookarea/'.$name_gen;

            BookArea::findOrFail($id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_desc' => $request->short_desc,
                'link_url' => $request->link_url,
                'image' => $save_url,
                'updated_at' => Carbon::now()                
            ]);

            $notification = array(
                'message' => 'Book Area updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.book.area')->with($notification);            
        } else {
            BookArea::findOrFail($id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_desc' => $request->short_desc,
                'link_url' => $request->link_url,
                'updated_at' => Carbon::now()                
            ]);

            $notification = array(
                'message' => 'Book Area updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.book.area')->with($notification);             
        }


    } 
    
    public function DeleteBookarea($id) {
        $bookarea = BookArea::findOrFail($id);
        $img = $bookarea->image;
        if(file_exists($img)) {
              unlink($img);
        }

        $bookarea->delete();

        $notification = array(
            'message' => 'Book Area deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.book.area')->with($notification);             
    }    
}
