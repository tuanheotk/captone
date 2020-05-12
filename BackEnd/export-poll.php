<?php

require('database-config.php');
require('vendor/PHPExcel/PHPExcel.php');

if (isset($_GET['id'])) {
	$event_id = $_GET['id'];

	$obj_excel = new PHPExcel;
	$obj_excel->setActiveSheetIndex(0);


	// Set column width
	$obj_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	$obj_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);


	// Set sheet name
	$sheet = $obj_excel->getActiveSheet()->setTitle('Danh sách bầu chọn');


	$sql_get_event_info = "SELECT title FROM event WHERE id = $event_id";
	$result_event_info = mysqli_query($conn, $sql_get_event_info);

	if (mysqli_num_rows($result_event_info) == 0) die();

	$row_event_info = mysqli_fetch_assoc($result_event_info);
	$event_name = $row_event_info['title'];

	$sheet->setCellValue('A1', 'Danh sách bầu chọn sự kiện: '.$event_name);
	$sheet->mergeCells('A1:G1');

	// Set row begin write
	$num_row = 3;
	$order = 0;

	// Set column name
	$sheet->setCellValue('A'.$num_row, '#');
	$sheet->setCellValue('B'.$num_row, 'Tổng phiếu bầu');
	$sheet->setCellValue('C'.$num_row, 'Số lựa chọn tối đa');
	$sheet->setCellValue('D'.$num_row, 'Nội dung bầu chọn');
	$sheet->setCellValue('E'.$num_row, 'Lựa chọn');
	$sheet->setCellValue('F'.$num_row, 'Số người chọn');
	$sheet->setCellValue('G'.$num_row, '%');


	$sql_get_poll = "SELECT p.*, COUNT(DISTINCT(user_id)) AS votes, COUNT(pv.option_id) AS total_vote FROM poll p
	LEFT JOIN poll_option po ON p.id = po.poll_id
	LEFT JOIN poll_vote pv ON po.id = pv.option_id
	WHERE event_id = $event_id
	GROUP BY p.id ORDER BY p.id DESC";
	$result_poll = mysqli_query($conn, $sql_get_poll);


	// Start write poll data
	while ($row_poll = mysqli_fetch_assoc($result_poll)) {
		$num_row++;
		$order++;

		$start_row = $num_row;


		// Write question
		$sheet->setCellValue('A'.$num_row, $order);
		// $sheet->setCellValue('A'.$num_row, $row_poll['id']);
		$sheet->setCellValue('B'.$num_row, $row_poll['votes']);
		$sheet->setCellValue('C'.$num_row, $row_poll['max_choice']);
		$sheet->setCellValue('D'.$num_row, $row_poll['title']);

		// $sheet->getRowDimension($num_row)->setRowHeight(30);

		// Write list option
		$sql_get_option = "SELECT po.*, COUNT(pv.user_id) AS num_votes FROM poll_option po LEFT JOIN poll_vote pv ON po.id = pv.option_id WHERE po.poll_id = ".$row_poll['id']." GROUP BY po.id";

		$result_option = mysqli_query($conn, $sql_get_option);

		$total_vote = $row_poll['total_vote'];

		while ($row_option = mysqli_fetch_assoc($result_option)) {

			if ($total_vote == 0) {
				$percent = 0;
			} else {
				$percent = round($row_option['num_votes']/$total_vote*100, 2);
			}
			

			$sheet->setCellValue('E'.$num_row, $row_option['content']);
			$sheet->setCellValue('F'.$num_row, $row_option['num_votes']);
			$sheet->setCellValue('G'.$num_row, $percent.' %');
			$num_row++;
		}
		if (mysqli_num_rows($result_option) > 0) $num_row--;

		$end_row = $num_row;
		
		// Merge
		$sheet->mergeCells('A'.$start_row.':A'.$end_row.'');
		$sheet->mergeCells('B'.$start_row.':B'.$end_row.'');
		$sheet->mergeCells('C'.$start_row.':C'.$end_row.'');
		$sheet->mergeCells('D'.$start_row.':D'.$end_row.'');
	}

	// Set word wrap for column D & E
	$sheet->getStyle('D1:E'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
	$sheet->getStyle('H1:E'.$obj_excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

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
	$sheet->getStyle('A3:G'.$obj_excel->getActiveSheet()->getHighestRow())->applyFromArray(
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
	$sheet->getStyle('A3:G3')->applyFromArray(
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
	$sheet->getStyle('A4:G'.$obj_excel->getActiveSheet()->getHighestRow())->applyFromArray(
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
	$file_name = 'export-poll.xlsx';
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