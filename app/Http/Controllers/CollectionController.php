<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use DB;
use App\Events\AddCollectionEvent;
use App\Events\InRouteEvent;


class CollectionController extends Controller
{
    public function get(Request $request)
    {
        // Get collections for a specific user as a collector
        $result = Collection::where('status_id',1)->get();

        return response()->json($result, 200);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'image'             => 'required',
            'title'         => 'required',
            'description'         => 'required',
            'weight'          => 'required',
            'seller_lat'        => 'required',
            'seller_lng'        => 'required',
        ]);

        DB::beginTransaction();
        try {
            $client = auth()->user();


            $collection =  new Collection;
            $collection->title = $request->title;
            $collection->description = $request->description;
            $collection->weight = $request->weight;
            $collection->seller_id = $client->id;
            $collection->seller_lat = $request->seller_lat;

            $collection->seller_lng = $request->seller_lng;

            $date = now()->format('Ymd_His');

            // $path = 'app/public/collections/'; 
            
            // $file = $request->file('image');
            // $filename = $file->getClientOriginalName(); 
            // $file->storeAs($path, $filename); 
            // $collection->images = $filename;
            // $collection->save();

            $imagePath = $request->image->storeAs(
                'collections', $date . '_'.'collection.png', 'public'
            );
            
            $collection->images = $imagePath;
            $collection->save();

            event(new AddCollectionEvent($collection));
          
            DB::commit();
            return response()->json(['id'=>$collection->id], 201);

        } catch (ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function enRoute(Request $request)
    {
        $this->validate($request, [
            'id'             => 'required',
        ]);

        $client = auth()->user();

        $collection = Collection::find($request->id);
        $collection->collector_id =  $client->id;
        $collection->status_id =  2;
        $collection->save();

        event(new InRouteEvent($collection));
    }
    

}
