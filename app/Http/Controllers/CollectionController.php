<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;


class CollectionController extends Controller
{
    public function get(Request $request)
    {
        // Get collections for a specific user as a collector
        $result = Collection::get();

        return response()->json($result, 200);

    }
}
