<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    public function trackRequest()
    {
        $requestData = ModelsRequest::orderBy('created_at', 'desc')
            ->limit(15)
            ->get()
            ->reverse() // To display in chronological order
            ->values();
        return response()->json($requestData);
    }
}
