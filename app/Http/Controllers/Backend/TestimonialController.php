<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function AllTestimonials() {
        $testimonials = Testimonial::latest()->get();

        return view('backend.testimonial.all_testimonials', compact('testimonials'));
    }

    public function AddTestimonial() {
        return view('backend.testimonial.add_testimonial');
    }

    public function StoreTestimonial(Request $request) {
        Testimonial::insert([
            'name' => $request->name,
            'city' => $request->city,
            'email' => $request->email,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Testimonial created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);        
    }

    public function DeleteTestimonial($id) {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        $notification = array(
            'message' => 'Testimonial deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);          
    }

    public function EditTestimonial($id) {
        $testimonial = Testimonial::findOrFail($id);

        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
    }

    public function StoreUpdatedTestimonial(Request $request) {
        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->name = $request->name;
        $testimonial->city = $request->city;
        $testimonial->email = $request->email;
        $testimonial->message = $request->message;
        $testimonial->save();


        $notification = array(
            'message' => 'Testimonial updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);           
    }
}
