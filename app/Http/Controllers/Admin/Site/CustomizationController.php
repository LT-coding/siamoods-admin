<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\FooterMenu;
use App\Models\FooterMenuItem;
use App\Models\Social;
use App\Services\MediaService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class CustomizationController extends Controller
{
    private MediaService $imageService;

    public function __construct(MediaService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $socials = Social::query()->get();
        $footerMenus = FooterMenu::query()->orderBy('order')->get();

        return view('admin.site.customization', compact('footerMenus','socials'));
    }

    /**
     * create the new footer menu resource.
     */
    public function storeFooterMenu(Request $request): RedirectResponse
    {
        $request->validate([
            'menu_title' => ['required', 'string', 'max:255']
        ]);

        $menu = FooterMenu::query()->create([
            'menu_title' => $request->menu_title,
            'order' => $request->order,
            'status' => $request->status
        ]);

        for ($j=0; $j<5; $j++) {
            if ($request->item_text[$j]) {
                FooterMenuItem::query()->create([
                    'footer_menu_id' => $menu->id,
                    'item_text' => $request->item_text[$j],
                    'item_link' => $request->item_link[$j],
                    'order' => $request->item_order[$j] ?? 0,
                ]);
            }
        }

        return Redirect::route('admin.customization.index')->with('status', 'Saved successfully!');
    }

    /**
     * create the new footer menu resource.
     */
    public function updateFooterMenu(Request $request): RedirectResponse
    {
        $request->validate([
            $request->id . '_menu_title' => ['required', 'string', 'max:255']
        ]);

        $title = $request->id . '_menu_title';
        $order = $request->id . '_order';
        $status = $request->id . '_status';
        $itemText = $request->id . '_item_text';
        $itemLink = $request->id . '_item_link';
        $itemOrder = $request->id . '_item_order';

        $menu = FooterMenu::query()->find($request->id);

        $menu->update([
            'menu_title' => $request->$title,
            'order' => $request->$order,
            'status' => $request->$status
        ]);

        $menu->items()->delete();

        for ($j=0; $j<5; $j++) {
            if ($request->$itemText[$j]) {
                FooterMenuItem::query()->create([
                    'footer_menu_id' => $menu->id,
                    'item_text' => $request->$itemText[$j],
                    'item_link' => $request->$itemLink[$j],
                    'order' => $request->$itemOrder[$j] ?? 0,
                ]);
            }
        }

        return Redirect::route('admin.customization.index')->with('status', 'Saved successfully!');
    }

    public function contactInfo(Request $request): RedirectResponse
    {
        foreach ($request->type as $k => $type) {
            Contact::query()->updateOrCreate([
                'type' => $request->type[$k]
            ],[
                'text' => $request->text[$k]
            ]);
        }

        return Redirect::route('admin.customization.index')->with('status', 'Saved successfully!')->withFragment('#contact');
    }

    public function socialLinks(Request $request): RedirectResponse
    {
        $title = $request->id ? $request->id . '_title' : 'title';
        $icon = $request->id ? $request->id . '_icon' : 'icon';
        $link = $request->id ? $request->id . '_link' : 'link';

        $request->validate([
            $title => ['required'],
            $icon => [Rule::requiredIf(fn () => !$request->id)],
            $link => ['required']
        ]);

        $imagePath = $request->$icon
            ? $this->imageService->dispatch($request->$icon)->upload('socials')->getUrl()
            : ($request->id && Social::query()->find($request->id) ? Social::query()->find($request->id)->icon : null);

        Social::query()->updateOrCreate([
            'id' => $request->id
        ],[
            'title' => $request->$title,
            'icon' => $imagePath,
            'link' => $request->$link
        ]);

        return Redirect::route('admin.customization.index')->with('status', 'Saved successfully!')->withFragment('#social');
    }

    public function destroySocial(string $id): RedirectResponse
    {
        $social = Social::query()->findOrFail($id);
        $social->delete();

        return Redirect::route('admin.customization.index')->with('status', 'Removed successfully!')->withFragment('#social');
    }

    public function destroyFooterMenu(string $id): RedirectResponse
    {
        $menu = FooterMenu::query()->findOrFail($id);
        $menu->delete();

        return Redirect::route('admin.customization.index')->with('status', 'Removed successfully!');
    }
}
