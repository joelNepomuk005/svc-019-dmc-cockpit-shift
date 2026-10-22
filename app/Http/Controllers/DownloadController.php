<?php

namespace App\Http\Controllers;

use App\Models\CustomerProject;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function downloadFile (Request $request, File $file) {
        return Storage::disk('s3_local')->download(
            'files/' . $file->name,
            basename($file->name)
        );
    }

    public function destroy (Request $request, File $file) {
        try {
            $file->delete();

            return response()->json('file deleted');
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
