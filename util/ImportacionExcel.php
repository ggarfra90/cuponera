<?php

require_once __DIR__ . '/PHPExcel/PHPExcel.php';
require_once __DIR__ . '/PHPExcel/PHPExcel/IOFactory.php';

class ImportacionExcel {

    public static function parseExcelToXML($path, $usuario, $tipo) {
        $path = __DIR__ . "/" . $path;
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $tipo = strtolower($tipo);
        $xml = "";
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 2; $row <= $highestRow; $row++) {
                $content = "";
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $value = trim($worksheet->getCellByColumnAndRow($col, $row)->getValue());
                    $name = strtolower($worksheet->getCellByColumnAndRow($col, 1)->getValue());
                    if (strlen($name) > 0)
                        $content .= "<$name>$value</$name>";
                }
                $content .= "<usuario>$usuario</usuario>";
                $xml .= "<$tipo>$content</$tipo>";
            }
        }
        return $xml;
    }

    public static function getExcelwithErrors($path, $errors) {
        $path = __DIR__ . "/" . $path;
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $objPHPExcel->getActiveSheet()->getStyle("A$row:D$row")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        }
        foreach ($errors as $array) {
            $row = $array["row"];
            $cause = $array["cause"];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '   #ERROR #')
                    ->setCellValue('E' . $row, $cause);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:D$row")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getStyle('E1:E' . $objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path);
    }

}

?>