<?php 
	
	$_player_rnd = 'player_'.Gn_Rnd(30);
	
	$__rsllr_itm = __LsDt([ 'k'=>'sis_prc', 'tp'=>'enc', 'id'=>$___Dt->gt->i, 'no_lmt'=>'ok' ]);
?>
<div class="dsh_rsllr_detail">
	
	<h1><?php echo Spn('','','_icn','background-image:url('.$__rsllr_itm->d->img.');').$__rsllr_itm->d->tt; ?></h1>  
	
	<div class="dsc"><?php echo $__rsllr_itm->d->dsc->vl; ?></div>  
	
	<?php if(!isN($__rsllr_itm->d->ytb->vl)){ ?>
		
		<div class="vdeo_bx">
			<div class="vdeo" id="<?php echo $_player_rnd; ?>" data-video-id="z4xSemykA-I"></div>
		</div>
		
		<?php 
			
			$CntJV .= "

				
				SUMR_Ld.f.js({ 
					id:'youtube-api',
					u:'https://www.youtube.com/iframe_api', 
					c:function(){
						
						try{
							
							var __this = $('#".$_player_rnd."');
							var videoId = __this.attr('data-video-id');
							var player;
							
						    function onYouTubeIframeAPIReady() {
						        	player = new YT.Player('".$_player_rnd."', {
						          	height: '360',
						          	width:'100%',
						          	videoId: '".$__rsllr_itm->d->ytb->vl."',
						          	events: {
						            	'onReady': onPlayerReady,
						            	'onStateChange': onPlayerStateChange
									},
						          	playerVars: {
										autoplay: 0,
										modestbranding: 1,
										rel: 0,
										loop: 1,
										playlist: videoId,
										controls: 0,
										showinfo: 0
									}
						        });
						    }
							
							onYouTubeIframeAPIReady();
													
						}catch(e) {
					
							SUMR_Main.log.f({ m:e });
							
						}
				
					}
					
				});

			
			";
			
			
		?>


	<?php } ?>
					
</div>                                                                  
<style>
	
	.dsh_rsllr_detail *{ background-repeat: no-repeat; font-family: Roboto; }
	.dsh_rsllr_detail{ position: relative; min-height: 900px; }
	.dsh_rsllr_detail h1{ font-family: Source Sans Pro; text-transform: uppercase; font-size: 40px; display: block; text-align: center; margin-bottom: 50px; font-weight: 200; padding-top: 100px; }
	.dsh_rsllr_detail h1 span._icn { width: 35px; height: 35px; display: inline-block; margin-bottom: -3px; margin-right: 10px; background-size: auto 90%; background-position: center center; }
	.dsh_rsllr_detail .dsc{ padding: 20px 80px 20px 80px; font-family: Roboto; font-size: 14px; color: #a19c9c; margin-bottom: 50px; }

	.dsh_rsllr_detail::before{ display: block; width: 100%; height: 200px; position: absolute; left: 0; top: 0; z-index: -1; pointer-events: none; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>rsll_play_top.svg'); background-size: auto 100%; background-position: center top; }
	
	.dsh_rsllr_detail::after{ display: block; width: 100%; height: 400px; position: absolute; left: 0; bottom: 0; z-index: -1; pointer-events: none; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>rsll_play_bottom.svg'); background-size: auto 350px; background-position: center top; background-repeat: no-repeat; }
	
	
	.dsh_rsllr_detail .vdeo_bx{ width: 650px; height: 400px; margin-left: auto; margin-right: auto; position: relative; }
	.dsh_rsllr_detail .vdeo_bx::before{ display: block; width: 100%; height: 100%; position: absolute; left: 0; top: 0; z-index: -1; pointer-events: none; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>rsllr_play_tv.svg'); background-size: auto 100%; background-position: center top; background-repeat: no-repeat; z-index: 100; }
	
	.dsh_rsllr_detail .vdeo_bx .vdeo{ position: absolute; left:75px; top: 48px; width: 392px; height: 289px; }
	.dsh_rsllr_detail .vdeo_bx .vdeo:empty{ background-color: white; }
	
	
</style>
