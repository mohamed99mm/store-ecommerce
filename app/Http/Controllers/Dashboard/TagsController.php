<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index()
    {
         $tags = Tag::orderBy('id', 'DESC')->paginate(PaginationCount);
        return view('dashboard.tags.index', compact('tags'));

    }

    public function create()
    {
        return view('dashboard.tags.create');

    }


    public function store(TagRequest $request)
    {


        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);

            $filename = "";
            if ($request->has('photo')) {
                $filename = uploadImage('brands', $request->photo);
            }
            $brand = Brand::create($request->except('_token', 'photo'));
            $brand->name = $request->name;
            $brand->photo = $filename;
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم انشاء ماركه جديده بنجاح']);

        } catch (\Exception $e) {

            return $e;
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' =>'حدث خطأ برجاء المحاوله لاحقا ']);

        }
    }


    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => __('admin/brand.exists')]);

        return view('dashboard.brands.edit', compact('brand'));

    }

    public function update($id, BrandRequest $request)
    {
        try {


            $brand = Brand::find($id);
            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => __('admin/brand.exists')]);

            DB::beginTransaction();

            if ($request->has('photo')) {
                $image = Str::after($brand->photo, 'assets/');
                $image = base_path('public/assets/' . $image);
                 unlink($image); //delete from folder

                $filename = uploadImage('brands', $request->photo);
                Brand::where('id',$id)->update(['photo'=>$filename]);
            }

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);


            $brand->update($request->except('_token','id','photo'));

            //save translations

            $brand->name = $request->name;
            $brand->save();


            DB::commit();

            return redirect()->route('admin.brands')->with(['success' =>'تم  تعديل بيانات الماركه بنجاح']);


        } catch (\Exception $e) {

            return $e;
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطأ برجاء المحاوله لاحقا']);

        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => __('admin/brand.exists')]);

            $image = Str::after($brand->photo, 'assets/');
            $image = base_path('public/assets/' . $image);
            unlink($image); //delete from folder

            $brand->translations()->delete();

            $brand->delete();
            return redirect()->route('admin.brands')->with(['success' => 'تم  حذف الماركه بنجاح']);

        } catch (\Exception $e) {
            return redirect()->route('admin.brands')->with(['error' =>'حدث خطأ برجاء المحاوله لاحقا']);

        }
    }

    public function changestatus($id)
    {
        try {


            $brand = Brand::find($id);

            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => __('admin/brand.exists')]);


            DB::beginTransaction();

            $status = $brand-> is_active == false ? true : false;

            $brand->update(['is_active'=>$status]);



            DB::commit();

            return redirect()->route('admin.brands')->with(['success' => 'تم  تعديل حاله الماركه بنجاح']);


        } catch (\Exception $e) {
            return $e;
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطأ برجاء المحاوله لاحقا']);

        }


    }

}
