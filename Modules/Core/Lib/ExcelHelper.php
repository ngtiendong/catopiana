<?php
/**
 * Created by PhpStorm.
 * User: khoinx
 * Date: 7/21/17
 * Time: 11:53 AM
 */

namespace Modules\Core\Lib;


use Illuminate\Support\Facades\Storage;

class ExcelHelper
{
    public $objPHPExcel;

    /**
     * Write excel
     * @param $data
     * @return string
     */
    public function writeExcel($data, $storagePage = 'exports/indon.xls', $fileName = "Indon.xls", $position = 0, $numDeleteRow = 0){

        $storagePage = storage_path($storagePage);

        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $this->objPHPExcel = $objReader->load($storagePage);
        if($position >= 0 && $numDeleteRow > 0){
            $this->objPHPExcel->getActiveSheet()->removeRow($position, $numDeleteRow);
        }

        foreach ($data as $key=>$value){
            $this->objPHPExcel->getActiveSheet()->setCellValue($key, $value);
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $result = "/app/public/{$fileName}";
        $objWriter->save(storage_path() . $result);

        Storage::disk('contract')->put($fileName, fopen(storage_path() . $result, 'r'));

        @unlink(storage_path() . $result);

        $result = Storage::disk('contract')->url($fileName);

        return $result;
    }

    /**
     * Read file excel
     * @param $path
     * @return array
     */
    public function readFileExcel($path, $sheetIndex = 0){
        $objectReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objectReader->setReadDataOnly(true);
        $objPHPExcel = $objectReader->load($path);
        $sheet = $objPHPExcel->getSheet($sheetIndex);
        return $sheet->toArray();
    }
}