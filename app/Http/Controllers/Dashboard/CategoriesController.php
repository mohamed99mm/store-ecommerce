<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;;
use Illuminate\Support\Facades\DB;


class CategoriesController extends Controller
{
    public function index()
    {
         $categories=Category::orderBy('id','DESC')->paginate(PaginationCount);
        return view('dashboard.categories.index',compact('categories'));
    }

    public function edit($id)
    {
     //get specific categories and its translations

        $Category = Category::find($id);
        if(!$Category)
        {
            return redirect()->route('admin.mainCategories')->with(['error'=> 'هذا القسم غير موجود']);
        }
        return view('dashboard.categories.edit',compact('Category'));
    }

    public function create()
    {
         $categories = Category::select('id','parent_id')->get();
        return view('dashboard.categories.create',compact('categories'));
    }

    public function store(CategoryRequest $request)
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

         // if the user choose main category then we must remove parent id fromm the request

         if($request->type ==1)
             {
                 $request->request->add(['parent_id' => null]);
             }

         //if he choose sub category then we must add parent id in the request

         if($request->type == 2)
         {
             $request->request->add(['parent_id']);
         }

         $filename = "";
         if ($request->has('photo')) {
             $filename = uploadImage('categories', $request->photo);
         }
         $category = new Category($request->except('_token', 'photo'));

         //Category::create($request->except('_token'));

         //save translations لائن ال name فى جدول ال transations

         $category->name = $request->name;
         $category->slug = $request->slug;
         $category->photo = $filename;
         $category->is_active = $request->is_active;
         $category->parent_id = $request->parent_id;
         $category->save();


         //return success

         DB::commit();

         return redirect()->route('admin.Categories')->with(['success'=>'تم انشاء قسم جديد بنجاح']);
     }catch (\Exception $ex)
        {
            return $ex;
//           DB::rollback();
//            return redirect()->route('admin.mainCategories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
        }
    }

    public function update($id, CategoryRequest $request)
    {
       try{

           //validation

           //Update DB

           $category = Category::find($id);


           if(!$category) {
               return redirect()->route('admin.Categories')->with(['error' => 'هذا القسم غير موجود']);
           }

           if(!$request->has('is_active'))
           {
               $request->request->add(['is_active'=>0]);
           }else
           {
               $request->request->add(['is_active'=>1]);
           }

           $filename = "";
           if ($request->has('photo')) {
               $filename = uploadImage('categories', $request->photo);
           }

           $request->except('photo');
           $category->update($request->all());

           //save translations لائن ال name فى جدول ال transations

           $category->name = $request->name;
           $category->photo = $filename;
           $category->save();
           return redirect()->route('admin.Categories')->with(['success'=>'تم النحديث بنجاح']);
       }catch (\Exception $ex)
       {
           return redirect()->route('admin.Categories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
       }
    }


    public function destroy($id)
    {
        try {
            $category = Category::orderBy('id', 'DESC')->find($id);
            if (!$category) {
                return redirect()->route('admin.Categories')->with(['error' => 'هذا القسم غير موجود']);
            }
            $category->delete();

            return redirect()->route('admin.Categories')->with(['success' => 'تم الحذف بنجاح']);
        }catch(\Exception $ex)
        {
            return redirect()->route('admin.Categories')->with(['error'=>'حدث خطأ برجاء المحاوله لاحقا']);
        }
    }
}
