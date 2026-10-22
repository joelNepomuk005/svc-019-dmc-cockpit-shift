<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class ModalController extends Controller
{
    public function loadModal (Request $request, User $user) {
        return 'hello-world';
    }

    public function renderModal ($data) {

    }
}
