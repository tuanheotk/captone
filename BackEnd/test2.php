<?php
// echo round(10/3, 2);
// echo count($_SESSION['user_email']);
?>
<input type="text" name="" id="test">
<button>send</button>

<p id="out"></p>


<script src="js/string.js"></script>
<script src="js/jquery-latest.min.js"></script>
<script type="text/javascript">



	// var txt_arr = new Array();

	// function readTextFile(file) {
	//     var rawFile = new XMLHttpRequest();
	//     rawFile.open("GET", file, false);
	//     rawFile.onreadystatechange = function () {
	//         if(rawFile.readyState === 4) {
	//             if(rawFile.status === 200 || rawFile.status == 0) {
	//                 var allText = rawFile.responseText;
	//                 // alert(allText);
	//                 // console.log(allText);
	//                 // txt_arr = allText.split(/\n|\r/g);
	//                 txt_arr = allText.split('\n');
	//             }
	//         }
	//     }
	//     rawFile.send(null);
	// }

	// readTextFile('temp/text.txt');
	// // txt_arr.length = 10;
	// // txt_arr = ["a", "ai", "am", "an", "ang", "anh", "ao", "au", "à", "ào", "á", "ác", "ách", "ái", "ám", "án", "áng", "ánh", "áo", "áp", "át", "áy", "âm", "ân"];
	// console.log(txt_arr);

	// $('#out').text(txt_arr);

	


	vi_arr = string_vi.split(',');
	obscene_arr = string_obscene.split(',');

	
	$('button').click(function() {
		content = $('#test').val().trim().replace(/  +/g, ' ');

		var r = check_question_content(content);
		console.log(r)
	})
	// console.log(txt_arr)

	function check_question_content(content) {
		// content = content.toLowerCase().trim();
		// content = content.replace(/  +/g, ' ');


		content = (content.replace(/[0123456789?,.:;"`~!@#$%^&*()\-_+={}\[\]><|\/\\\']+/g,'')).toLowerCase();
		var input_text_arr = content.split(' ');
		console.log(input_text_arr);

		var correct_word = 0;
		var valid = true;

		var no_obscene_word = true;
		var enough_correct_word = true;

		var error = null;
		var obscene_used = new Array();

		for (var i = 0; i < input_text_arr.length; i++) {
			if (vi_arr.includes(input_text_arr[i])) {
				correct_word++;
			}
			if (obscene_arr.includes(input_text_arr[i])) {
				no_obscene_word = false;
				obscene_used.push(input_text_arr[i]);
			}
		}

		console.log('correct words: ' + correct_word);
		console.log('obscene words: ' + no_obscene_word);

		if (correct_word/ input_text_arr.length <= 0.7) {
			enough_correct_word = false;
			error = 'Đặt câu hỏi hợp lý hơn';
		}

		if (!no_obscene_word) error = 'Bạn đã dùng từ cấm';

		if (!enough_correct_word || !no_obscene_word) valid = false;

		var result = {valid: valid, error: error, obscene_used: obscene_used};
		return result;
	}

</script>