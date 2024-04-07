<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $headerMenusAll = Menu::headerMenu()->get();
        $footerMenusAll = Menu::footerMenu()->get();
        return view('admin.site.menu.index', compact('headerMenusAll','footerMenusAll'));
    }

    public function update(Request $request): RedirectResponse
    {
        foreach (Menu::query()->get() as $menu) {
            if ($request->has('status_'.$menu->id)) {
                $menu->update([
                    'status' => $request["status_$menu->id"],
                    'position' => $request["position_$menu->id"],
                ]);
            }
        }
        return back()->with('status', 'Տվյալները հաջողությամբ պահպանված են')->withFragment('#tab-'.$request->page);
    }
}
