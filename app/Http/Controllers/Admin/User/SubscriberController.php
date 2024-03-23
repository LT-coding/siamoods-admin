<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $subscribers = Subscriber::query();

        if ($request->active) {
            $subscribers->active();
        }

        $records = $subscribers->get();
        $statuses = Status::statusNames();

        return view('admin.user.subscribers.index', compact('records','statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $record = Subscriber::query()->findOrFail($id);
        $record->update([
            'status' => $request->status
        ]);
        if($request->ajax()){
            return response()->json([
                'status' => 'success',
            ], 200);
        }

        return Redirect::route('admin.subscribers.index')->with('status', 'Տվյալները հաջողությամբ պահպանված են');
    }
}
