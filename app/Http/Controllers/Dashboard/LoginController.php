<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;
class LoginController extends Controller
{
    public function  login()
    {
        return view('dashboard.auth.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {

        //validate


        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('admin.dashboard');
        }
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    }
    public function logout()
    {
        $guard = $this->getGuard();
        $guard ->logout();
        return redirect()-> route('admin.login');
    }
    private function getGuard()
    {
        return auth('admin');
    }
}
