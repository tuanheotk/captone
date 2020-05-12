<!DOCTYPE html>
<html>
<head>
	<title>TEST 2</title>
	<style>
		#container {
			margin: 100px auto;
			width: 400px;
			height: 400px;
			border: 10px #333 solid;
			background: #ccc;
		}

		#video {
			/*width: 400;
			height: 400px;*/
			/*background-color: #666;*/
		}
	</style>
</head>
<body>
	<div id="container">
		<video id="video" width="400px" height="400px" autoplay></video>
		<canvas id="canvas" width="400px" height="400px"></canvas>
		
	</div>

	<script src="js/jquery-latest.min.js"></script>
	<script>

		(function() {

			var canvas = document.getElementById('canvas'),
			context = canvas.getContext('2d'),
			video = document.getElementById('video'),
			vendorUrl = window.URL || window.webkitURL;

			navigator.getMedia =	navigator.getUserMedia ||
									navigator.webkitGetUserMedia ||
									navigator.mozGetUserMedia ||
									navigator.msGetUserMedia;

			navigator.getMedia({
				video: true,
				audio: false
			}, function(stream) {
				video.src = vendorUrl.createObjectURL(stream);
				video.play();

			}, function(error) {
				// 
			})
		})();

		// startVideo();
		// function startVideo(){
		// 	navigator.getUserMedia(
		// 		{video: {}},
		// 		stream => video.srcObject = stream,
		// 		err => console.error(err)
		// 	)
		// }
		
		// navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

		// if (navigator.getUserMedia) {
		// 	navigator.getUserMedia({video: true}, handleVideo, videoError);
		// }

		// function handleVideo(stream) {
		// 	video.attr('src', window.URL.createObjectURL(stream));
		// }

		// function videoError(e) {
		// 	alert("SOME PROBLEM");
		// }

		function stop(e) {
			var stream = video.srcObject;
			var tracks = stream.getTracks();
			for (var i = 0; i < tracks.length; i++) {
				var track = tracks[i];
				track.stop();
			}
			video.srcObject = null;
		}
	</script>

</body>
</html>