<?php

require('database-config.php');
require('vendor/PHPExcel/PHPExcel.php');

if (isset($_GET['id'])) {
	# code...
	$event_id = $_GET['id'];

	$obj_excel = new PHPExcel;
	$obj_excel->setActiveSheetIndex(0);

	// Set column width
	$obj_excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$obj_excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$obj_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	$obj_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

	$obj_excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
	$obj_excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$obj_excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	$obj_excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

	// Set auto wordwrap
	// $obj_excel->getActiveSheet()->getStyle('D1:D'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

	// Set sheet name
	$sheet = $obj_excel->getActiveSheet()->setTitle('Danh sách câu hỏi');


	$sql_get_event_info = "SELECT title FROM event WHERE id = $event_id";
	$result_event_info = mysqli_query($conn, $sql_get_event_info);
	$row_event_info = mysqli_fetch_assoc($result_event_info);
	$event_name = $row_event_info['title'];

	$sheet->setCellValue('A1', 'Danh sách câu hỏi sự kiện: '.$event_name);
	$sheet->mergeCells('A1:I1');



	// Set row begin write
	$num_row = 3;

	// Set column name
	$sheet->setCellValue('A'.$num_row, 'ID câu hỏi');
	$sheet->setCellValue('B'.$num_row, 'ID người hỏi');
	$sheet->setCellValue('C'.$num_row, 'Tên người hỏi');
	$sheet->setCellValue('D'.$num_row, 'Nội dung câu hỏi');
	$sheet->setCellValue('E'.$num_row, 'Thời gian');
	$sheet->setCellValue('F'.$num_row, 'ID người trả lời');
	$sheet->setCellValue('G'.$num_row, 'Tên người trả lời');
	$sheet->setCellValue('H'.$num_row, 'Nội dung trả lời');
	$sheet->setCellValue('I'.$num_row, 'Thời gian');

	$sql_get_question = "SELECT * FROM question WHERE event_id = $event_id ORDER BY pinned DESC, id DESC";
	$result_question = mysqli_query($conn, $sql_get_question);


	// border style
	$border_question = array(
		'borders' => array(
			'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000'),
			),
		),
	);


	// Start write data
	while ($row_question = mysqli_fetch_assoc($result_question)) {
		$num_row++;

		$start_row = $num_row;


		// Write question
		$sheet->setCellValue('A'.$num_row, $row_question['id']);
		$sheet->setCellValue('B'.$num_row, $row_question['user_id']);
		$sheet->setCellValue('C'.$num_row, $row_question['user_fullname']);
		// $sheet->setCellValue('D'.$num_row, $tets);
		$sheet->setCellValue('D'.$num_row, $row_question['content']);
		$sheet->setCellValue('E'.$num_row, $row_question['create_at']);



		// Set height
		$count = strlen($row_question['content']);
		if ($count < 45) {
			$sheet->getRowDimension($num_row)->setRowHeight(20);
		} else {
			$sheet->getRowDimension($num_row)->setRowHeight($count/1.6);
		}



		// Write answer
		$sql_get_answer = "SELECT * FROM answer WHERE question_id = ".$row_question['id'];
		$result_answer = mysqli_query($conn, $sql_get_answer);
		while ($row_answer = mysqli_fetch_assoc($result_answer)) {

			$sheet->setCellValue('F'.$num_row, $row_answer['user_id']);
			$sheet->setCellValue('G'.$num_row, $row_answer['user_fullname']);
			$sheet->setCellValue('H'.$num_row, $row_answer['content']);
			// $sheet->setCellValue('H'.$num_row, $tets);
			$sheet->setCellValue('I'.$num_row, $row_answer['create_at']);


			// Set height
			$count = strlen($row_answer['content']);
			if ($count < 45) {
				$sheet->getRowDimension($num_row)->setRowHeight(20);
			} else {
				$sheet->getRowDimension($num_row)->setRowHeight($count/2.5);
			}
			

			$num_row++;
		}

		if (mysqli_num_rows($result_answer) > 0) $num_row--;


		// $count = strlen($row_answer['content']);


		// $sheet->getRowDimension($num_row)->setRowHeight($count/1.5);


		$end_row = $num_row;

		// Border 1 question
		// $sheet->getStyle('A'.$start_row.':E'.$end_row.'')->applyFromArray($border_question);
		// $sheet->getStyle('A'.$start_row.':I'.$end_row.'')->applyFromArray($border_question);
		
		// Merge
		$sheet->mergeCells('A'.$start_row.':A'.$end_row.'');
		$sheet->mergeCells('B'.$start_row.':B'.$end_row.'');
		$sheet->mergeCells('C'.$start_row.':C'.$end_row.'');
		$sheet->mergeCells('D'.$start_row.':D'.$end_row.'');
		$sheet->mergeCells('E'.$start_row.':E'.$end_row.'');

	}

	// Set word wrap for column D & H
	$sheet->getStyle('D1:D'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
	$sheet->getStyle('H1:H'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

	// Set auto height
	// foreach($obj_excel->getActiveSheet()->getRowDimensions() as $rd) { 
	//     $rd->setRowHeight(-1); 
	// }

	// test auto height
	// $obj_excel->getActiveSheet()->getRowDimension(8)->setRowHeight(160);
	// $sheet->getRowDimension(8)->setRowHeight(160);

	// Style event name 
	$sheet->getStyle('A1')->applyFromArray(
		array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14
			)
	    )
	);


	// Set border all cells
	$sheet->getStyle('A3:I'.$obj_excel->getActiveSheet()->getHighestRow())->applyFromArray(
	    array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '000000')
	            )
	        )
	    )
	);

	// Style column name table
	$sheet->getStyle('A3:I3')->applyFromArray(
	    array(
		    'borders' => array(
		        'outline' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THICK,
		            'color' => array('rgb' => '000000'),
		        ),
		    ),
		    'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'FB1717')
	        )
		)
	);

	// Style all table
	$sheet->getStyle('A4:I'.$obj_excel->getActiveSheet()->getHighestRow())->applyFromArray(
		array(
			// Border ouline
		    'borders' => array(
		        'outline' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THICK,
		            'color' => array('rgb' => '000000'),
		        ),
		        // 'allborders' => array(
	         //        'style' => PHPExcel_Style_Border::BORDER_THIN,
	         //        'color' => array('rgb' => '000000')
	         //    )
		    ),
		    // Vertical align center
		    'alignment' => array(
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        )
		)	
	);


	$obj_writer = new PHPExcel_Writer_Excel2007($obj_excel);
	// $file_name = 'export.xls';
	$file_name = 'export.xlsx';
	$obj_writer->save($file_name);

	// //header info for browser
	header('Content-Disposition: attachment; filename="'.$file_name.'"');

	// header("Content-Type: application/vnd.ms-excel");
	header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
	header('Content-Length: '.filesize($file_name));
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: no-cache');
	readfile($file_name);
	return;
} else {
	# code...
	die();
}





// header("Expires: 0");
?>