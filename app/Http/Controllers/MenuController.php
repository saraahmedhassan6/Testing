<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Harimayco\Menu\Models\Menus;
use Harimayco\Menu\Models\MenuItems;

class MenuController extends Controller
{
    public function getMenu()
    { 
        $menulist = Menus::all();

        return view('menu.menu-html', compact('menulist'));
    }

    public function store(Request $request)
    { 
        $menu = new Menus();
        $menu->name_en = $request->menu_name_en;
        $menu->name_ar = $request->menu_name_ar;
        $maxPosition = Menus::max('position');
        $menu->position = $maxPosition + 1;


        $menu->save();
        return redirect()->back();
    }
    public function store_sub(Request $request)
    {
        $menuId = $request->selected_menu_id;

        $maxPosition = MenuItems::max('position');

        $menuItems = new MenuItems();
        $menuItems->label_en = $request->label_en;
        $menuItems->label_ar = $request->label_ar;
        $menuItems->link = $request->url;
        $menuItems->menu = $menuId;
        $menuItems->position = $maxPosition + 1;

        $menuItems->save();
        
        return redirect()->back();
    }

    public function getDragMenu()
    { 
        $menus = Menus::orderBy('position')->get();
        $MenuItems = MenuItems::orderBy('position')->get();
        return view('menu.drag-menu',compact('menus','MenuItems') );
    }

    public function saveChanges(Request $request)
    {
        $menuPositions = $request->input('menu_positions');
        $submenuPositions = $request->input('submenu_positions');
        //dd($menuPositions,$submenuPositions);

        if ($menuPositions && $submenuPositions) {
            foreach ($menuPositions as $menuID => $menuPosition) {
                // Update the position of the Menu model
                Menus::where('id', $menuID)->update(['position' => $menuPosition]);
            }

            foreach ($submenuPositions as $menuItemID => $submenuPosition) {
                // Update the position of the MenuItem model
                MenuItems::where('id', $menuItemID)->update(['position' => $submenuPosition]);
            }
        }
        return redirect()->back();

    }

    


 


}
