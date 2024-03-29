<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Harimayco\Menu\Models\Menus;
use Harimayco\Menu\Models\MenuItems;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
        {
            return view('admin.index');
        }

    }

    public function welcome()
    {
        $menus=Menus::orderBy('position')->get();
        $menuItems=MenuItems::orderBy('position')->get();
        return view('welcome',compact('menus','menuItems'));
    }

}
