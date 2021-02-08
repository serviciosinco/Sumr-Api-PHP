<div class="ln_1 _cmpg_dtl">
		<?php if($__prfx->prfx3_c == 'sms_cmpg' || $__prfx->prfx3_c == 'psg_sms_cmpg' || $__prfx->prfx3_c == 'prg_sms_cmpg' || $__prfx->prfx3_c == 'con_sms_cmpg' || $__prfx->prfx3_c == 'evn_sms_cmpg'){
			$icn = '_tt_icn_sms_tmpl';
			$est = 'smscmpg_est';
			
		}elseif($__prfx->prfx3_c == 'ec_cmpg' || $__prfx->prfx3_c == 'psg_ec_cmpg' || $__prfx->prfx3_c == 'prg_ec_cmpg' || $__prfx->prfx3_c == 'con_ec_cmpg'){
			$icn = '_tt_icn_cmpg';
			$est = 'ecmpg_est';
			
		} ?>
		<?php echo h2( Spn('','','_tt_icn '.$icn.'') . TX_ESTD ); ?>
	    
	    
	    <?php if($___Ls->dt->rw[$est] == 1){ ?> 
	    <div id="__grph_crsl" class="owl-carousel">
	        <div class="item">	
		        <div id="bx_grph" class="__bl"></div>	
		    </div>
	    </div>
	    <?php }else{ ?>
							    
	    <div class="todo_icn"></div>
	    
	    <?php } ?>
</div>
	
	<?php 
		
		$_grph_m = '&_h=400&_i='.$__cmpg_dt->id;
		
		$CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_DT_GN.__t($__prfx->prfx2_c.'_grph',true))."{$_grph_m}', c:'bx_grph', trs:false });";
		
?>