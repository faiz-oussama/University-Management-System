<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
require $_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['exporter'])) {
    if (isset($_SESSION['user_data']) && $_SESSION['user_data']['role'] == 2) {
        $level = $_POST['level'];
        $filiere = $_SESSION['fil_nom'];

        $modules_query = mysqli_query($conn, "
            SELECT DISTINCT m.id, m.name
            FROM module m
            WHERE m.niveau = '$level' 
            and m.nom_filiere = '$filiere'
        ");

        $modules = [];
        while ($row = mysqli_fetch_assoc($modules_query)) {
            $modules[] = $row;
        }

        $students_query = mysqli_query($conn, "
            SELECT u.CNE, u.nom, u.prénom, n.id_module, n.value
            FROM users u
            LEFT JOIN notes n ON u.CNE = n.cne
            LEFT JOIN module m ON n.id_module = m.id
            WHERE m.niveau = '$level' AND n.valideProf = 1
        ");

        $students = [];
        while ($row = mysqli_fetch_assoc($students_query)) {
            $students[$row['CNE']]['info'] = ['nom' => $row['nom'], 'prénom' => $row['prénom']];
            $students[$row['CNE']]['grades'][$row['id_module']] = $row['value'];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $header = array_merge(['Name', 'CNE'], array_column($modules, 'name'), ['Moyenne', 'Status']);
        $sheet->fromArray($header, NULL, 'A1');

        // Data rows
        $rowNum = 2;
        foreach ($students as $CNE => $student) {
            $row = [
                ucfirst($student['info']['nom']) . " " . ucfirst($student['info']['prénom']),
                $CNE
            ];

            $totalGrade = 0;
            $numModules = count($modules);

            foreach ($modules as $module) {
                $grade = $student['grades'][$module['id']] ?? '';
                $row[] = $grade;
                $totalGrade += $grade ? floatval($grade) : 0;
            }

            $averageGrade = $totalGrade / $numModules;
            $row[] = number_format($averageGrade, 2);
            $row[] = $averageGrade >= 12 ? 'Validé' : 'Non Validé';

            $sheet->fromArray($row, NULL, 'A' . $rowNum);
            $rowNum++;
        }

        $filename = 'grades.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    } else {
        header("Location: /ENSAHify/index.php?error=UnAuthorized Access");
        exit();
    }
} else {
    header("Location: /ENSAHify/index.php?error=UnAuthorized Access");
    exit();
}
?>
