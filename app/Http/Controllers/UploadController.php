<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $path = $request->file('file')->store('uploads');

        return response()->json([
            'pesan' => 'File berhasil di unggah !',
            'path' => $path,
        ]);
    }
}
