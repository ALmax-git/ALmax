<?php

namespace App\Helpers;

use App\Models\Request;
use Carbon\Carbon;

class RequestTracker
{
    public static function track()
    {
        // Get current timestamp rounded down to the nearest 2-minute interval
        $roundedTime = Carbon::now()->startOfMinute()->subMinutes(Carbon::now()->minute % 2);

        // Check if a record already exists for the current 2-minute interval
        $requestData = Request::where('rounded_at', $roundedTime)->first();

        if (!$requestData) {
            // If no record exists, create a new one with count = 1
            $requestData = new Request();
            $requestData->rounded_at = $roundedTime;
            $requestData->count = 1;
            $requestData->save();
        } else {
            // If record exists, increment the count
            $requestData->increment('count');
        }



        // Increment request count
        // Optionally, you can log the request or perform other actions here    
        // Log::info('Request tracked at ' . $roundedTime . ' with count: ' . $requestData->count);
        // Return the request data if needed
        return $requestData;
    }
}
