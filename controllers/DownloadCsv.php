<?php 
 
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

// Fetch records from database 
$data = array();
        $qr = mysqli_query($conn,"select * from users where role ='4'");

 
if($qr->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "members-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'GENDER', 'LEVEL', 'CREATED'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $qr->fetch_assoc()){ 
        $lineData = array($row['id'], $row['prénom'], $row['nom'], $row['email'], $row['genre'], $row['niveau'], $row['created_at']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>