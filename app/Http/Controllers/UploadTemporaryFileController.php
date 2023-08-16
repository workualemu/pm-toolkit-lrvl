<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadTemporaryFileController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid('file-', true);
            $file->storeAs('files/tmp/' . $folder, $fileName );

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $fileName,
            ]);
            return $folder;
        }
        return '';
    }
}
