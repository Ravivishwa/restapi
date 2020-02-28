<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class PdfToTextController extends Controller
{

    public function create(Request $request)
    {
        $pdfName = $request->file('pdf')->getClientOriginalName();
        $pdfName = uniqid() . '_' . $pdfName;
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'user_files' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR;
        $destinationPath = $this->public_path($path); // upload path
        File::makeDirectory($destinationPath, 0777, true, true);
        $request->file('pdf')->move($destinationPath, $pdfName);

        $text = (new Pdf('C:\wamp64\www\restapi\vendor\bin\poppler\bin\pdftotext.exe'))
            ->setPdf($destinationPath.$pdfName)
            ->text();
        Storage::put('public/file.txt', $text);
//        $url = Storage::url('file.txt');

//        $author = Author::create($request->all());
return $text;
    }

    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}
