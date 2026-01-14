<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function showOrderMap($id)
    {
        $order = Order::findOrFail($id);

        // نتأكد من وجود حقل location بصيغة "lat,lng"
        if (!$order->location) {
            abort(404, 'Location not found for this order');
        }

        $coordinates = explode(',', $order->location);
        // العرض
        $latitude = trim($coordinates[0]);
        // $latitude = 33.5136;
        // الطول
        $longitude = trim($coordinates[1]);
        // $longitude = 36.3153;
        // dd( $coordinates);
        return view('map.show', compact('latitude', 'longitude'));
    }
}
