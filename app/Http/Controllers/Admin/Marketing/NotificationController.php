<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marketing\NotificationRequest;
use App\Models\Notification;
use App\Models\Subscriber;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $records = Notification::query()->get();
        $types = Notification::TYPES;

        return view('admin.marketing.notifications.index', compact('records', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $record = Notification::query()->findOrFail($id);
        $types = Notification::TYPES;

        return view('admin.marketing.notifications.create-edit', compact('record', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();
        $record = Notification::query()->findOrFail($id);
        $record->update(array_except($data,['send']));

        if($request->send){
            $subscribers = Subscriber::query()->where('status',StatusTypes::active)->get();
            foreach ($subscribers as $sub){
                Mail::to($sub->email)->send(new SendCustomMail());
            }
        }

        return Redirect::route('admin.notifications.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }
}
