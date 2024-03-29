<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Site\NotificationRequest;
use App\Mail\SendCustomMail;
use App\Models\Notification;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function index(){
        $notifications = Notification::all();
        $types = Notification::TYPES;
        return view('admin.marketing.notification.index',compact(['notifications','types']));
    }

    public function edit($id){
        $notification = Notification::query()->find($id);
        $types = Notification::TYPES;
        return view('admin.marketing.notification.edit',compact(['notification','types']));
    }

    public function update(NotificationRequest $notificationRequest,$id){
        $notification = Notification::query()->find($id);
        $notification->update($notificationRequest->validated());
        if($notificationRequest->send){
            $subscribers = Subscriber::query()->where('status',Subscriber::ACTIVE)->get();
            foreach ($subscribers as $sub){
                Mail::to($sub->email)->send(new SendCustomMail());
            }
        }
        return redirect()->route('admin.notifications.index');
    }
}
