<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use  App\Http\Requests\TagRequest;
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

            $tag = Tag::create($request->only('slug'));

            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم انشاء علامة جديده بنجاح']);

        } catch (\Exception $e) {

            return $e;
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' =>'حدث خطأ برجاء المحاوله لاحقا ']);

        }
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
//        $tag->makeVisible(['translations']);
//        return $tag;
        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => __('admin/tag.exists')]);

        return view('dashboard.tags.edit', compact('tag'));


    }

    public function update($id, TagRequest $request)
    {
        try {


            $tag = Tag::find($id);
            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => __('admin/tag.exists')]);

            DB::beginTransaction();


            $tag->update($request->only('slug'));

            //save translations

            $tag->name = $request->name;
            $tag->save();


            DB::commit();

            return redirect()->route('admin.tags')->with(['success' =>'تم  تعديل بيانات العلامة بنجاح']);


        } catch (\Exception $e) {

            return $e;
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطأ برجاء المحاوله لاحقا']);

        }
    }

    public function destroy($id)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => __('admin/tag.exists')]);

            $tag->translations()->delete();

            $tag->delete();
            return redirect()->route('admin.tags')->with(['success' => 'تم  حذف العلامة بنجاح']);

        } catch (\Exception $e) {
            return redirect()->route('admin.tags  ')->with(['error' =>'حدث خطأ برجاء المحاوله لاحقا']);

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
