<div class="ec_start" style="display:none;">
	
	<div class="c1">
		<?php echo h1('Let´s '.Spn('Start')); ?>
		<p><?php echo TX_SLECCDG?></p>
	</div>
	
	<div class="c2">
		<div class="d1">
			<div class="icn ec_nw _anm" id="<?php echo 'start_new'.$___Ls->fm->id; ?>">
				<?php echo h2(TX_CDG); ?>
				<span class="_anm"></span>
			</div>
		</div>
		<div class="d2">
			<div class="icn ec_cmz _anm" id="<?php echo 'start_cmz'.$___Ls->fm->id; ?>">
				<?php echo h2(TX_PLNTL); ?>
				<span class="_anm"></span>
			</div>
		</div>
	</div>
	
	<?php 
		
		if(!isN($__new_cod_w) && !isN($__new_cod_h)){
			$_pop_rsze = '
				$.colorbox.resize({
					width:"'.$__new_cod_w.'",
					height:"'.$__new_cod_h.'",
				});
			';
		}
		
		$CntWb .= '
			
			function __shw_cmz(){
				
				_ldCnt({ 
					u:"'.FL_LS_GN.__t('snd_ec_cmz',true).TXGN_POP.TXGN_ING.$___Ls->ls->vrall.'",
					pop:"ok",
					w:"'.$__new_cmz_cod_w.'", 
					h:"350",
					scrl:"no"
				});
			}
			
			function __shw_cod(){
				'.$_pop_rsze.'
				$("#bld_strt'.$___Ls->fm->id.'").fadeOut();
				$("#bld_ec'.$___Ls->fm->id.'").fadeIn();		
			}
			
			$("#start_new'.$___Ls->fm->id.'").off(\'click\').click(function() {   
				__shw_cod();
			});
			
			$("#start_cmz'.$___Ls->fm->id.'").off(\'click\').click(function() { 
				__shw_cmz(); 
			});
			
		'; 
		
		if($___Ls->gt->tmpl != 'mycmz'){
			$CntWb .= ' __shw_cod(); '; 
		}else{ 
			if(_ChckMd('ec_ing') || _ChckMd('snd_ec_ing')){
				$CntWb .= " $('.ec_start').fadeIn(); ";
			}else{	
				$CntWb .= " __shw_cmz(); "; 
			}
		}
		
	?>
	
</div>
