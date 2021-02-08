<div class="ec_start">
	
	<div class="c1">
		<?php echo h1('Let´s '.Spn('Start')); ?>
		<p><?php echo TX_SLTPQDC ?></p>
	</div>
	<div class="c2">
		<div class="d1">
			<div class="icn ec_nw _anm" id="<?php echo 'start_new'.$__RndId; ?>">
				<?php echo h2(TX_COD); ?>
				<span></span>
			</div>
		</div>
		<div class="d2">
			<div class="icn ec_cmz _anm" id="<?php echo 'start_cmz'.$__RndId; ?>">
				<?php echo h2(TX_PLNTL); ?>
				<span></span>
			</div>
		</div>
	</div>
	
	<?php $CntWb .= '
			
			function __shw_cmz(){
				alert(3);
				'.JQ__ldCnt([ 'u'=>FL_LS_GN.__t($___Ls->mdlstp->tp.'_ec_cmz',true).TXGN_POP.TXGN_ING.$___Ls->ls->vrall, 'c'=>$___Ls->bx_rld, 'p'=>$__pop, 'w'=>'98%', 'h'=>'99%' ]).'
			}
			
			$("#start_new'.$__RndId.'").click(function() {
			   
			   	$.colorbox.resize({
		            width:95+"%",
					height:95+"%",
		        });
			   	
				$("#bld_strt'.$__RndId.'").fadeOut();
				$("#bld_ec'.$__RndId.'").fadeIn();
				
			});
			
			$("#x'.$__RndId.'").click(function() { __shw_cmz(); alert(2); });
			
		'; 
		
		if($__tmplflt == 'mycmz'){ $CntWb .= ' __shw_cmz(); '; }
		
	?>
		
</div>
