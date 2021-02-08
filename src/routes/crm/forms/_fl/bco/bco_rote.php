<?php
	$_id_bco = Php_Ls_Cln($_GET['_i']);
	$bco_dt = GtBcoDt([ 'id'=>$_id_bco, 't'=>'enc' ]);
	
	if(!isN($bco_dt->img)){
		
		$_img_big = DMN_FLE_BCO_TH.'bg_'.$bco_dt->img."?".Gn_Rnd(20); 
?>

	<style>
		._rotate{ text-align: center; width: 80%; background: #252525; height: 55px; padding-top: 10px; position: fixed; bottom: 10%;left: 10%; }
		._left{ position: absolute; left: 42%; cursor:pointer; background-image: url(<?php echo DMN_IMG_CRM_ESTR_SVG."rote_left.svg" ?>); width: 35px; height: 35px; background-size: 35px;}
		._right{ position: absolute; right: 42%; cursor:pointer; background-image: url(<?php echo DMN_IMG_CRM_ESTR_SVG."rote_right.svg" ?>); width: 35px; height: 35px; background-size: 35px;}
		
		._left span{ position: relative; color: white; right: 125px; white-space: nowrap; top: 10px; }
		._right span{ position: relative; color: white; left: 70px; white-space: nowrap; top: 10px;}
		
		._left:Hover, ._right:Hover{ opacity: 0.5; }
		
	</style>
	
	<img class='cboxPhoto' src="<?php echo $_img_big; ?>" style='float: none;'>
	<div class="_rotate">
		<div class="_left" ><span>Girar Izquierda</span></div>
		<div class="_right"><span>Girar Derecha</span></div>
	</div>
	
	<?php
		
		$CntWb .= "
		
			$('._left').click(function(){
				rotate_bco({'rote':'left'});
			});
	
			$('._right').click(function(){
				rotate_bco({'rote':'right'})
			});
	
			function rotate_bco(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url:'".FL_JSON_GN.__t('bco_rote', true)."',
					data: { 
						'_rote':e.rote,
						'_i':'".$_id_bco."',
						'_img':'".$bco_dt->img."'
					},
					beforeSend: function() {
						
					},
					success: function(d) {
					    if(d.e == 'ok'){
						    ".JQ__ldCnt([ 
						    	'u'=>FL_FM_GN.__t('bco_rote',true).TXGN_ING.TXGN_POP.TXGN_BX.$__bxrld."&_i=".$_id_bco."", 
						    	'c'=>$__bxrld, 
						    	'p'=>'ok',
						    	'w'=>'80%', 
						    	'h'=>'80%' 
						    ])."
						 }else{
						    
					    }
					}
				});
			};
			
		";
		
		
	?>
	
<?php } ?>
	