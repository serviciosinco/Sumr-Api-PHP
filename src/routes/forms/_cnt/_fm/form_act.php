Formulario de actividades
<div class="_ln cx1"> 
    <div class="_fd">
        <?php echo _HTML_Input('Cnt_Nm'.$__id_rnd, TT_FM_FLLNM, '', FMRQD, 'text', ['ac'=>'name']); ?>
    </div> 
</div>
<div class="_ln cx2 mdl">
	<?php $__get_city = KnGEO(); ?>
	<div class="_blq _c _c1">
    	<div class="_fd">
    		<?php echo _HTML_Input('Cnt_Eml'.$__id_rnd, TT_FM_EML, '', FMRQD_EM, 'email', ['ac'=>'email']); ?>
    	</div>
    </div>
	<div class="_blq _c _c2">
    	<div class="_fd">
        	<?php echo _HTML_Input('Cnt_Tel'.$__id_rnd, TX_CEL, '', FMRQD_NM.' minlength="10" maxlength="10" ', 'text'); ?>
        </div>
    </div>          
</div>

<div class="_ln cx2 mdl">
		<div class="_blq _c _c1">
  		<div class="_fd">
  			<?php 
				  
				if(!isN($__fm->dft->ps)){
					$_dft_ps = $__fm->dft->ps;
				}else{
					$_dft_ps = null;
				}

      			echo LsSis_PsOLD('Cnt_Ps'.$__id_rnd, 'id_sisps', $_dft_ps, 'Pais', 1); 
				  $_CntJQ_S2 .= JQ_Ls('Cnt_Ps'.$__id_rnd, '-', '', 'SUMR_Fm.f.ps.flg');
				  
  			?>
  		</div>
  	</div>
		<div class="_blq _c _c2">
  		<div class="_fd">
	  		<?php echo _HTML_Input('Cnt_Cd'.$__id_rnd, TT_FM_CD, /*$__get_city->city*/'', FMRQD, 'text', ['ac'=>'address-level2']); ?>	
  		</div>	
		</div>
</div>						

<div class="_ln cx2">
    <div class="_blq _c1"> 
        <div class="_fd">
            <?php 
                
                $l = __Ls([ 'k'=>'cnt_dc', 
                			'id'=>'Cnt_DocTp'.$__id_rnd, 
                			'opt_v'=>'itm-sg',
                			'va'=>177, 
                			'ph'=>_cns('FM_LS_TPDOC'),
                			'slc'=>[ 
									'opt'=>[
											'attr'=>[
												'itm-sg'=>'sg'
											]	
										] 
									] 
                		]); 
                		
                echo $l->html; $_CntJQ_S2 .= $l->js;
            ?>
        </div> 
    </div>
    <div class="_blq _c2">
        <div class="_fd">
            <?php echo _HTML_Input('Cnt_Doc'.$__id_rnd, TX_DCNMR, '', FMRQD_NM, 'text', ['ac'=>'off']); ?>
        </div>
    </div>
</div>
<div class="_ln cx1"> 
    <div class="_fd">
	    <?php if(!isN($__hro)){ echo $__hro; $_CntJQ_S2 .= JQ_Ls('Cnt_Sch'.$__id_rnd, '-', '', ''); } ?>
    </div> 
</div>