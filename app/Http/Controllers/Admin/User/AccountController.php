<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $accounts = User::accounts();

        if ($request->new) {
            $accounts->whereDate('created_at', Carbon::now());
        }

        $records = $accounts->get();

        return view('admin.user.accounts.index', compact('records'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = User::accounts()->findOrFail($id);

        return view('admin.user.accounts.show', compact('record'));
    }
}
