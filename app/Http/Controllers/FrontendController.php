<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class FrontendController extends Controller
{
  public function showModal()
  {
      $modal = 'show';

      $view = view('layouts.partials.modal.showForm')->render();

      $response = \Response::make($view, 200);
      $response->header('Content-Type', 'text/html');

      return $response;
  }
}
