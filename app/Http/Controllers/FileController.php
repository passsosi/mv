<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Documents;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{

    public function fileConvert($id)
    {
        $doc = Documents::find($id);
        $format = $doc->format;

        if($format == 'pdf'){
            $blobData = $doc->file; // Получение longblob данных из базы данных
    
            // Сохранение временного файла с longblob данными
            $tempFilePath = resource_path('/temp/file.pdf');
            file_put_contents($tempFilePath, $blobData);
    
            // Возвращение файла в качестве ответа
            return response()->download($tempFilePath, $doc->name, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        if($format == 'docx'){
            $blobData = $doc->file;
    
            $tempFilePath = resource_path('/temp/file.docx');
            file_put_contents($tempFilePath, $blobData);
    
            return response()->download($tempFilePath, $doc->name, [
                'Content-Type' => 'application/docx',
            ]);
        }

        if($format == 'mp4'){
            $blobData = $doc->file;
    
            $tempFilePath = resource_path('/temp/file.mp4');
            file_put_contents($tempFilePath, $blobData);
    
            return response()->download($tempFilePath, $doc->name, [
                'Content-Type' => 'application/mp4',
            ]);
        }

        if($format == 'ppt'){
            $blobData = $doc->file;
    
            $tempFilePath = resource_path('/temp/file.ppt');
            file_put_contents($tempFilePath, $blobData);
    
            return response()->download($tempFilePath, $doc->name, [
                'Content-Type' => 'application/ppt',
            ]);
        }
    }

}