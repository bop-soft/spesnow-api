<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Models\User;
use App\Notifications\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends BaseController
{
    public function index(){

    } 

    public function show() {

    }

    public function store(Request $request) {
        $message = $request->validate([
            "message" => "required",
        ]);
        $users = User::all();
        Notification::sendNow($users, new General($message));
    }
}
