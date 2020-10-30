<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Setting;

class SettingsController extends Controller
{

    public function editShippingMethod($type)
    {

        //free , inner , outer for shipping methods

        if ($type === 'free')
             $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        elseif ($type === 'inner')
            $shippingMethod = Setting::where('key', 'local_label')->first();

        elseif ($type === 'outer')
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        else
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        return view('dashboard.settings.shippings.edit', compact('shippingMethod'));

    }

    public function updateShippingMethod(Request $request,$id)
    {

        //validation

        //update database

    }
}
