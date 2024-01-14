<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use App\Models\Category;
use App\Models\CollectionCategory;

use DB;
use App\Events\AddCollectionEvent;
use App\Events\InRouteEvent;
use App\Events\GrabEvent;
use App\Events\CancelEvent;



class CollectionController extends Controller
{
    public function get(Request $request)
    {
        // Get collections for a specific user as a collector
        $result = Collection::get();

        return response()->json($result, 200);
    }

    public function getCategory(Request $request)
    {
        // Get collections for a specific user as a collector
        $result = Category::get();

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
            'categories'        => 'required|array',
            'address'           =>'required'
        ]);

        DB::beginTransaction();
        try {
            $client = auth()->user();


            $collection =  new Collection;
            $collection->title = $request->title;
            $collection->address = $request->address;
            $collection->description = $request->description;
            $collection->weight = $request->weight;
            $collection->seller_id = $client->id;
            $collection->seller_lat = $request->seller_lat;
            $collection->seller_lng = $request->seller_lng;

            $date = now()->format('Ymd_His');

            $imagePath = $request->image->storeAs(
                'collections', $date . '_'.'collection.png', 'public'
            );
            
            $collection->images = $imagePath;
            $collection->save();

            foreach($request->categories as $category)
            {
                $collectionCategory = new CollectionCategory;
                $collectionCategory->collection_id = $collection->id;
                $collectionCategory->category_id = $category;
                $collectionCategory->save();
            }

            $tokens = User::role('Collector')->pluck('fcm_token');

            event(new AddCollectionEvent($collection));

            $data = [
                "title" => 'A new collection has been added.',
                "body"  => "New Collection",
                "data"  => [
                    "type"                  => 'alarm',
                    "priority"              => 'high',
                ]
            ];

            $firebase  = sendToTokenArray($tokens, $data);
          
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

    public function grab(Request $request)
    {
        $this->validate($request, [
            'id'             => 'required',
        ]);

        $client = auth()->user();

        $collection = Collection::find($request->id);
        $collection->status_id =  5;
        $collection->save();

        event(new GrabEvent($collection));
    }

    public function cancel(Request $request)
    {
        $this->validate($request, [
            'id'             => 'required',
        ]);

        $client = auth()->user();

        $collection = Collection::find($request->id);
        $collection->status_id =  6;
        $collection->save();

        $collectionNew =  new Collection;
        $collectionNew->title = $collection->title;
        $collectionNew->description = $collection->description;
        $collectionNew->weight = $collection->weight;
        $collectionNew->seller_id = $collection->seller_id;
        $collectionNew->seller_lat = $collection->seller_lat;
        $collectionNew->seller_lng = $collection->seller_lng;
        $collectionNew->images = $collection->imageName;
        $collectionNew->save();

        event(new CancelEvent($collection));

        event(new AddCollectionEvent($collectionNew));

    }

    public function collectorSuccess(Request $request)
    {
        $client = auth()->user();

        $collection = Collection::where('collector_id', $client->id)->where('status_id', 5)->get();

        return response()->json(['collection'=>$collection], 200);

    }

    public function collectorCancel(Request $request)
    {
        $client = auth()->user();

        $collection = Collection::where('collector_id', $client->id)->where('status_id', 6)->get();

        return response()->json(['collection'=>$collection], 200);

    }

    public function sellerSuccess(Request $request)
    {
        $client = auth()->user();

        $collection = Collection::where('seller_id', $client->id)->where('status_id', 5)->get();

        return response()->json(['collection'=>$collection], 200);

    }

    public function sellerCancel(Request $request)
    {
        $client = auth()->user();

        $collection = Collection::where('seller_id', $client->id)->where('status_id', 6)->get();

        return response()->json(['collection'=>$collection], 200);

    }
    

}
