<?php

namespace App\Http\Controllers;

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
