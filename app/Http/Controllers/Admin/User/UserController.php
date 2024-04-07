<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Mail\GreetingEmail;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = User::admins()->get();

        return view('admin.user.users.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $roles = RoleTypes::adminRolesList();
        $record = null;

        return view('admin.user.users.create-edit', compact('record', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $record = User::query()->create($data);
        $record->assignRole($request->role);

        $data['password'] = $request->password;
        Mail::to($record)->send(new GreetingEmail($record, $request->password));

        return Redirect::route('admin.users.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $roles = RoleTypes::adminRolesList();
        $record = User::query()->admins()->findOrFail($id);

        return view('admin.user.users.create-edit', compact('record', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): RedirectResponse
    {
        $record = User::query()->admins()->findOrFail($id);

        $data = $request->validated();

        $data['password'] = $request->password ? Hash::make($request->password) : $record->password;

        $record->update($data);
        $record->removeRole($record->getRoleNames()[0]);
        $record->assignRole($request->role);

        return Redirect::route('admin.users.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $record = User::query()->admins()->findOrFail($id);
        $record->delete();

        return back()->with('status', 'Removed successfully');
    }
}
