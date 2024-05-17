<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationToUserJob;
use App\Models\User;
use App\Models\UserDoc;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function index()
    {
        return view('admin.docs.index');
    }
}
