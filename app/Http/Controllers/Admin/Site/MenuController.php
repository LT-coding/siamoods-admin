<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Site\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
        $headerMenusAll = Menu::headerMenu()->get();
        $footerMenusAll = Menu::footerMenu()->get();
        return view('admin.site.menu.index', compact('headerMenusAll','footerMenusAll'));
    }

    public function update(Request $request){
        foreach (Menu::get() as $menu) {
            if ($request->has('status_'.$menu->id)) {
                $menu->update([
                    'status' => $request["status_$menu->id"],
                    'position' => $request["position_$menu->id"],
                ]);
            }
        }
        return back();
    }
}
