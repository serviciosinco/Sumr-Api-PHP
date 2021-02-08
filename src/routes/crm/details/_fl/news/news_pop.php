<?php 
	
	
	$_player_rnd = 'player_'.Gn_Rnd(30);
	
	
?>
<style type="text/css" media="screen">
	.new_video_pop{ 
		background-image: url(<?php echo DMN_HTTP.'myprc.'.DMN.'SUMR_Mantenimiento.jpg'; ?>);
	    background-position: center center;
	    background-size: 100% auto;
	    display: block;
	    width: 100%;
	    height: 100%;
	    background-repeat: no-repeat;
	}
</style>
<div class="new_video_pop" id="<?php echo $_player_rnd; ?>" data-video-id="z4xSemykA-I">

</div>

<?php 
	
	/*$CntJV .= "
		
		
		function createVideo(video) {
			
			try{

				SUMR_Main.blr = 'no';
	
				var __this = $('#'+video);
				
				var youtubeScriptId = 'youtube-api';
				var youtubeScript = document.getElementById(youtubeScriptId);
				var videoId = __this.attr('data-video-id');
			
				if (youtubeScript === null) {
			    	var tag = document.createElement('script');
					var firstScript = document.getElementsByTagName('script')[0];
					tag.src = 'https://www.youtube.com/iframe_api';
					tag.id = youtubeScriptId;
					firstScript.parentNode.insertBefore(tag, firstScript);
				}
			
			
				onYouTubeIframeAPIReady = function () {	
				   
				    window.player = new window.YT.Player(video, {
						videoId: videoId,
						width:'100%',
						height:'100%',				
						playerVars: {
							autoplay: 1,
							modestbranding: 1,
							rel: 0,
							loop: 1,
							playlist: videoId,
							controls: 0
						},
						events: {
				        	'onReady': onPlayerReady,
						    'onStateChange': onPlayerStateChange
						}
					});
				
				}
			
			
			}catch(e) {
		
				SUMR_Main.log.f({ m:e });
				
			}
			
		}
		

		function onPlayerReady(event) {
	        event.target.playVideo();
	    }
	
	    function onPlayerStateChange(event) {        
	        if(event.data === 0) {            
	            $.colorbox.close();
	        }
	    }		  	

		
		createVideo('".$_player_rnd."'); 
	
	";*/
	
	
?>



