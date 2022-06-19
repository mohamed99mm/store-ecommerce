<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Setting;
use App\Http\Requests\ShippingRequest;
use DB;
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

    public function updateShippingMethod(ShippingRequest $request,$id)
    {
      try {
          //validation


          DB::beginTransaction();
          //update database
          $shippingMethod = Setting::find($id);
          $shippingMethod->update(['plain_value' => $request->plain_value]);

          //save translation
          DB::commit();
          $shippingMethod->value = $request->value;
          $shippingMethod->save();
          return redirect() -> back() ->with(['success' => 'تم التحديث بنجاح']);
      }catch (\Exception $ex)
      {
          return redirect() -> back() ->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد ']);
        DB::rollback();
      }
    }
}
