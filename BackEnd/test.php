<?php  
  $title = "TEST";
  include 'header.php';
?>
	<h2>
		xin chào
	</h2>
	<?php

	$text = "1 2 3 4 5 6 7 8 9 10 11 12 13 14";
	echo md5($text);



	function shortTitle($title)
    {
        $space = 0;
        $end = 0;
        $shorted = "";
        $num_of_words = 10;

        for ($i = 0; $i < strlen($title); $i++) {
            if ($title[$i] == " ")
                $space++;
            if ($space == $num_of_words) {
                $end = $i;
                break;
            }
        }
        
        if ($space < $num_of_words) {
            return $title;
        } else {
	        $shorted = substr($title, 0, $end).'...';
	        return $shorted;
        }

    }

	?>
<?php  
  include 'footer.php';
?>