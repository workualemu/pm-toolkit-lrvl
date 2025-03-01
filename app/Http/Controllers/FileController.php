<?php

namespace App\Http\Controllers;

use App\Models\TaskFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function download($id)
    {
        $file = TaskFile::find($id);
        logger($file);
        logger(Storage::disk('private')->exists($file->file_path));
        if (!$file || !Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'File not found.');
        }

        return response()->download(storage_path('app/private/' . $file->file_path), $file->file_name);
    }

    public function view($id)
    {
        $file = TaskFile::find($id);

        if (!$file || !Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'File not found.');
        }

        return response()->file(storage_path('app/private/' . $file->file_path));
    }
}
