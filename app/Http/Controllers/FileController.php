<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FileController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome');
    }

    public function update(StoreFileRequest $request)
    {
        global $lists;
        global $newArray;
        global $result;

        if ($request->hasFile('file')) {

//            dd($request->file('file'));
//            $templatesDocPath = storage_path('app/public/').'test.docx';
            $templatesDocPath = $request->file('file');
            $phpWord = \PhpOffice\PhpWord\IOFactory::createReader('Word2007')->load($templatesDocPath);

            foreach ($phpWord->getSections() as $section) {
                $arrays = $section->getElements();

                foreach ($arrays as $e) {
                    if (get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
                        foreach ($e->getElements() as $text) {
                            $lists[] = $text->getText() . '<br>';
                        }
                    }
                }
            }
            foreach ($lists as $value) {
                if (str_contains($value, '')) {
                    $newArray[] = str_replace('<br>', '', $value);
                }
            }
            $newString = implode(' ', $newArray);
            $formattedString = str_replace([' -', ' , ', ','], ['-', ' ', ' '], $newString);
            $dataInArray = (explode(" ", $formattedString));

            foreach ($dataInArray as $value) {
                if (str_contains($value, "-")) {
                    $result[] = str_replace(',', '', $value);
                }
            }
            sort($result);
            //        print_r ($result);
//        dd(json_encode($result));

            return Inertia::render('Welcome', [
                'result' => $result,
            ]);
//        return Inertia::render('Welcome', ['data' => json_encode($result)]);
//        dd($result);

//            foreach($result as $value){
//                echo $value;
//            }
        }
        return Inertia::render('Welcome', [
            'notFound' => 'First, upload your file!',
        ]);
    }
}




