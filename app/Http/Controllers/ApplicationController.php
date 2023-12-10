<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationImage;
use DB;
class ApplicationController extends Controller
{
    public function submit(Request $request)
    {
        $this->validate($request, [
            'images'   => 'required|array',
        ]);
        DB::beginTransaction();
            try {
            $client = auth()->user();

            $application = new Application;
            $application->user_id = $client->id;
            $application->status_id = 1;
            $application->save();
            $array = [];

            foreach($request->images as $key => $image)
            {
                $imagePath = $image->storeAs(
                    'application', $client->id . '_'.$key.'application.png', 'public'
                );
                $array[] = ['image'=> $imagePath,'application_id'=>$application->id];
            }
            ApplicationImage::insert($array);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Application Submitted Successfully',
                'application' => $application,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e], 500);
        }
    }
}
