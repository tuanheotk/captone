<?php

require('database-config.php');
require('vendor/PHPExcel/PHPExcel.php');

if (isset($_GET['id'])) {
	$event_id = $_GET['id'];

	$obj_excel = new PHPExcel;
	$obj_excel->setActiveSheetIndex(0);


	// Set column width
	$obj_excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$obj_excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


	// Set sheet name
	$sheet = $obj_excel->getActiveSheet()->setTitle('Danh người tham dự');


	$sql_get_event_info = "SELECT title FROM event WHERE id = $event_id";
	$result_event_info = mysqli_query($conn, $sql_get_event_info);

	if (mysqli_num_rows($result_event_info) == 0) die();

	$row_event_info = mysqli_fetch_assoc($result_event_info);
	$event_name = $row_event_info['title'];

	$sheet->setCellValue('A1', 'Danh sách người tham dự sự kiện: '.$event_name);
	$sheet->mergeCells('A1:G1');

	// Set row begin write
	$num_row = 3;
	$order = 0;

	// Set column name
	$sheet->setCellValue('A'.$num_row, '#');
	$sheet->setCellValue('B'.$num_row, 'Email người tham dự/ Mã sinh viên');
	$sheet->setCellValue('C'.$num_row, 'Thời gian điểm danh');


	$sql_get_attendee = "SELECT email, check_in_at FROM attendee WHERE event_id = $event_id AND status = 1";
	$result_attendee = mysqli_query($conn, $sql_get_attendee);


	// Start write poll data
	while ($row_attendee = mysqli_fetch_assoc($result_attendee)) {
		$num_row++;
		$order++;

		// $start_row = $num_row;


		// Write info
		$sheet->setCellValue('A'.$num_row, $order);
		$sheet->setCellValue('B'.$num_row, $row_attendee['email']);
		$sheet->setCellValue('C'.$num_row, $row_attendee['check_in_at']);
	}

	// Set word wrap for column D & E
	// $sheet->getStyle('D1:E'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
	// $sheet->getStyle('H1:E'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

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
	$sheet->getStyle('A3:C'.$obj_excel->getActiveSheet()->getHighestRow())->applyFromArray(
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
	$sheet->getStyle('A3:C3')->applyFromArray(
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
	$sheet->getStyle('A4:C'.$obj_excel->getActiveSheet()->getHighestRow())->applyFromArray(
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
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	        )
		)	
	);



	

	$obj_writer = new PHPExcel_Writer_Excel2007($obj_excel);
	// $file_name = 'export.xls';
	$file_name = 'export-attendee.xlsx';
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
	die();
}





// header("Expires: 0");
?>