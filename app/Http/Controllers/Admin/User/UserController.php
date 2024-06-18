<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Mail\GreetingEmail;
use App\Models\User;
use App\Traits\GetRecordsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    use GetRecordsTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.user.users.index');
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

        return back()->with('status', 'Հաջողությամբ հեռացված է');
    }

    public function getRecords(Request $request): JsonResponse
    {
        $query = User::query()->admins();

        $columns = ['id', 'name', 'lastname', 'email', 'role', 'status'];
        $orderColumns = ['id', 'name', 'email', 'role', 'status'];
        $this->searchAndSort($request,$query,$columns,$orderColumns);

        $totalRecords = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $records = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($records as $item) {
            $email = '<a href="mailto:"'.$item->email.'>'.$item->email.'</a>';
            $btnDetails = '<a href="'.route('admin.users.edit',['user'=>$item->id]).'" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
            $btnDelete = '<a href="#" data-action="'.route('admin.users.destroy',['user'=>$item->id]).'" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
            $row = [$item->id, $item->full_name, $email, $item->status_text, $item->role_name, $btnDetails.$btnDelete];
            $data[] = $row;
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
}
