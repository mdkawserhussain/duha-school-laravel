<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends BaseController
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:5120'], // 5MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('media/quill', 'public');
        $url = Storage::disk('public')->url($path);

        return response()->json([
            'location' => $url,
        ]);
    }
}

