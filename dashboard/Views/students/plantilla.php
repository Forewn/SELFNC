<?php
require '../../Config/config.php';
require '../../../vendor/autoload.php'; // Ruta a la autoload de PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function calcularEdad($fecha_nacimiento) {
    $fecha_nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento);
    return $edad->y;
}

$sentencia = $connect->query("SELECT * FROM estudiantes");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$sheet->setCellValue('A1', 'Cédula');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Correo');
$sheet->setCellValue('D1', 'Edad');
$sheet->setCellValue('E1', 'Fecha de Nacimiento');
$sheet->setCellValue('F1', 'Genero');
$sheet->setCellValue('G1', 'Número de telefono');

$row = 2;
foreach ($productos as $producto) {
    $sheet->setCellValue('A' . $row, $producto->cedula_estudiante);
    $sheet->setCellValue('B' . $row, $producto->nombres);
    $sheet->setCellValue('C' . $row, $producto->correo);
    $sheet->setCellValue('D' . $row, calcularEdad($producto->fecha_nac));
    $sheet->setCellValue('E' . $row, $producto->fecha_nac);
    $sheet->setCellValue('F' . $row, $producto->genero == 'M' ? 'Masculino' : 'Femenino');
    $sheet->setCellValue('G' . $row, $producto->telefono);
    $row++;
}

// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="Estudiantes.xlsx"');
// header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
// $writer->save('php://output');
$writer->save('estudiantes.xlsx');
exit;
?>
