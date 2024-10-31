
	jQuery(function() {
		var mytrack = jQuery('#rs_mytrack').val();
		var duration = jQuery('#rs_fullDuration').val();
		var currentTime = jQuery('#rs_currentTime').val();
		var playButton = jQuery('#rs_playButton');
		jQuery( "#rs_playButton" ).click(function() {
			playOrPause();
		});
		jQuery( "#rs_audio_close" ).click(function() {
			audioOff();
		});
	});
	function audioOff() {
		mytrack.pause();
	}
	function playOrPause() {
		if (!mytrack.paused && !mytrack.ended) {
			mytrack.pause();
			jQuery('#rs_playButton').css('background-image',"url('"+templateUrl+"/audio/play-32.png')");
			window.clearInterval(updateTime);
		} else {
			mytrack.play();
			jQuery('#rs_playButton').css('background-image',"url('"+templateUrl+"/audio/pause-32.png')");
			updateTime = setInterval(update,500); 
		}
	}
	function myOnLoadedData() {
		var minutes = parseInt(mytrack.duration/60);
		var seconds = pad(parseInt(mytrack.duration%60));
		var duration = jQuery('#rs_fullDuration').val();
		var currentTime = jQuery('#rs_currentTime').val();
		jQuery("#rs_fullDuration").html(minutes + ':' + seconds);
	}
	function update() {
		if(!mytrack.ended)
		{
			var currentTime = jQuery('#rs_currentTime').val();
			var playedMinutes = parseInt(mytrack.currentTime/60);
			var playedSeconds = pad(parseInt(mytrack.currentTime%60));
			jQuery("#rs_currentTime").html(playedMinutes+':'+playedSeconds);
			var barSize = 1000;
			var bar = jQuery('#rs_defaultBar');
			var progressBar = jQuery('#rs_progressBar');
			var size = parseInt(mytrack.currentTime*barSize/mytrack.duration);
			jQuery('#rs_progressBar').css("width",size+"px");
			 

		}else
		{
			jQuery("#rs_currentTime").html("0:00");  
			jQuery('#rs_playButton').css('background-image',"url('"+templateUrl+"/audio/play-32.png')");
			window.clearInterval(updateTime);
			alert(111111);
			 
		}
	}
	function pad(d) {
		return (d<10) ? '0' + d.toString() : d.toString();
	}