<?php
require 'database-config.php';
require('vendor/PHPExcel/PHPExcel.php');
if (file_exists($_FILES["excel"]["tmp_name"])) {


	$sql = "SELECT email FROM `attendee` WHERE email like '%randat%'";
	$result = mysqli_query($conn, $sql);

	$mysql = array();
	$excel = array();

	while ($row = mysqli_fetch_assoc($result)) {
		$email = $row['email'];

		array_push($mysql, $email);
	}

	$file = $_FILES["excel"]["tmp_name"];
	  $objPHPExcel = PHPExcel_IOFactory::load($file);
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
	  {
	   $highestRow = $worksheet->getHighestRow();

	   for($row=1; $row<=$highestRow; $row++)
	   {
	    $email = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
	    array_push($excel, $email);
	    
	   }
	  }

	}

	$o = '<table>';
	for ($i=0; $i < 201; $i++) {
		$o.= '<tr><td>'.$i.'</td><td>'.$excel[$i].'</td><td>'.$mysql[$i].'</td>';
		if ($excel[$i] == $mysql[$i]) {
			$o.='<td>==</td>';
		} else {
			$o.='<td>!=</td>';
		}
		$o.='</tr>';
	}
	$o.= '</table>';

	echo $o;

?>

<form method="POST" enctype="multipart/form-data">
	<input type="file" name="excel" accept=".xls, .xlsx, .csv">
	<button type="submit" value="submit">Nhập</button>
</form>