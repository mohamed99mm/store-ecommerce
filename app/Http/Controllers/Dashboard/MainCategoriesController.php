<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;


class MainCategoriesController extends Controller
{
    public function index()
    {
         $categories=Category::parent()->orderBy('id','DESC')->paginate(PaginationCount);
        return view('dashboard.categories.index',compact('categories'));
    }

    public function edit($id)
    {
     //get specific categories and its translations

        $mainCategory = Category::orderBy('id','DESC')->find($id);

        if(!$mainCategory)
        {
            return redirect()->route('admin.mainCategories')->with(['error'=> 'هذا القسم غير موجود']);
        }
        return view('dashboard.categories.edit',compact('mainCategory'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(MainCategoryRequest $request)
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

         //Category::create($request->except('_token'));

         //save translations لائن ال name فى جدول ال transations

         $category->name = $request->name;
         $category->slug = $request->slug;
         $category->is_active = $request->is_active;
         $category->save();


         //return success

         DB::commit();

         return redirect()->route('admin.mainCategories')->with(['success'=>'تم انشاء قسم رئيسى جديد بنجاح']);
     }catch (\Exception $ex)
        {
           DB::rollback();
            return redirect()->route('admin.mainCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
        }
    }

    public function update($id,MainCategoryRequest $request)
    {
       try{

           //validation

           //Update DB

           $category = Category::find($id);


           if(!$category) {
               return redirect()->route('admin.mainCategories')->with(['error' => 'هذا القسم غير موجود']);
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
           return redirect()->route('admin.mainCategories')->with(['success'=>'تم النحديث بنجاح']);
       }catch (\Exception $ex)
       {
           return redirect()->route('admin.mainCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
       }
    }


    public function destroy($id)
    {
        try {
            $category = Category::orderBy('id', 'DESC')->find($id);
            if (!$category) {
                return redirect()->route('admin.mainCategories')->with(['error' => 'هذا القسم غير موجود']);
            }
            $category->delete();

            return redirect()->route('admin.mainCategories')->with(['success' => 'تم الحذف بنجاح']);
        }catch(\Exception $ex)
        {
            return redirect()->route('admin.mainCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
        }
    }
}
