<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class ExcelController extends Controller
{
    //Excel文件导出功能
    public function export()
    {

        $cellData = [
            ['学生','姓名','成绩'],
            ['10001','AAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];

//        $cellData = $this->arr($cellData);

        Excel::create('明天_你好',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
               $sheet->rows($cellData);
            });

        })->store('xls');
    }

    //Excel文件导入功能
//    public function import(){
//        $filePath = 'storage/exports/'.'学生成绩.xls';
//        Excel::load($filePath, function($reader) {
//            $data = $reader->all();
//
//            dd($data);
//        });
//    }

    public function import(){
        $filePath = 'storage/exports/'.'明天_你好.xls';
        Excel::load($filePath, function($reader) {
            $data = $reader->all();
            dd($data);
        });
    }


}
