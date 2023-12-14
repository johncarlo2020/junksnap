<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function User(Request $request)
    {
        return $request->user();
    }

    public function EditProfile(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'mobile'  => 'required',
            'bday'  => 'required',
            'range'   => 'required',
            'address' => 'required',
            'image'   => 'required|image|mimes:jpeg,png,jpg',
        ]);
    
        $client = auth()->user();
    
        // Save the uploaded image to the storage
        $imagePath = $request->file('image')->storeAs(
            'user_profile', $client->id . '_profile.png', 'public'
        );
    
        // Update user data in the database
        $user = User::where('id', $client->id)->update([
            'name'    => $request->name,
            'mobile_number'   => $request->mobile,
            'bday'   => $request->bday,
            'range'   => $request->range,
            'address' => $request->address,
            'image'   => $imagePath,
        ]);
    }

    public function AddDocuments(Request $request)
    {
        $this->validate($request, [
            'images'   => 'required|array',
        ]);
        $client = auth()->user();

        $array = [];

        foreach($request->images as $key => $image)
        {
            $imagePath = $image->storeAs(
                'user_documents', $client->id . '_'.$key.'document.png', 'public'
            );

            $array[] = ['image'=> $imagePath,'user_id'=>$client->id];
        }

        UserDocument::insert($array);

    }

    public function Verify(Request $request)
    {
        
        $client = auth()->user();

        $user = User::where('id', $client->id)->update([
            'verified'   => true,
        ]);


    }
}
