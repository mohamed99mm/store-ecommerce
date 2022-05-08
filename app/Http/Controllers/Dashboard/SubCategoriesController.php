<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;


class SubCategoriesController extends Controller
{
    public function index()
    {
         $categories=Category::child()->orderBy('id','DESC')->paginate(PaginationCount);
        return view('dashboard.subCategories.index',compact('categories'));
    }

    public function edit($id)
    {
     //get specific categories and its translations

        $category = Category::orderBy('id','DESC')->find($id);

        if(!$category)
        {
            return redirect()->route('admin.subCategories')->with(['error'=> 'هذا القسم غير موجود']);
        }
        $categories = Category::parent()->orderBy('id','DESC')->get();
        return view('dashboard.subCategories.edit',compact('category', 'categories'));
    }

    public function create()
    {
         $SubCategories = Category::parent()->orderBy('id','DESC')->get();

        return view('dashboard.subCategories.create',compact('SubCategories'));
    }

    public function store(SubCategoryRequest $request)
    {


       // return $request;

     try{



         DB::beginTransaction();

         //validation

         //store
         if(!$request->has('is_active'))
         {
             $request->request->add(['is_active'=>0]);
         }else
         {
             $request->request->add(['is_active'=>1]);
         }

       $category = new Category();

        // $category = Category::create($request->except('_token'));

         //save translations لائن ال name فى جدول ال transations

         $category->name = $request->name;
         $category->slug = $request->slug;
         $category->is_active = $request->is_active;
         $category->parent_id = $request->parent_id;
         $category->save();


         //return success

         DB::commit();

         return redirect()->route('admin.subCategories')->with(['success'=>'تم انشاء قسم فرعى  جديد بنجاح']);
     }catch (\Exception $ex)
        {
           DB::rollback();
            return redirect()->route('admin.subCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
        }
    }

    public function update($id,SubCategoryRequest $request)
    {
       try{

           //validation

           //Update DB

           $category = Category::find($id);


           if(!$category) {
               return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
           }

           if(!$request->has('is_active'))
           {
               $request->request->add(['is_active'=>0]);
           }else
           {
               $request->request->add(['is_active'=>1]);
           }

           $category->update($request->all());

           //save translations لائن ال name فى جدول ال transations

           $category->name = $request->name;
           $category->save();
           return redirect()->route('admin.subCategories')->with(['success'=>'تم النحديث بنجاح']);
       }catch (\Exception $ex)
       {
           return redirect()->route('admin.subCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
       }
    }


    public function destroy($id)
    {
        try {
            $category = Category::orderBy('id', 'DESC')->find($id);
            if (!$category) {
                return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
            }
            $category->delete();

            return redirect()->route('admin.subCategories')->with(['success' => 'تم الحذف بنجاح']);
        }catch(\Exception $ex)
        {
            return redirect()->route('admin.subCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
        }
    }
}
