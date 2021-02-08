<?php
	$__f_n = date_create(SISUS_FN);
	$__f_h = date_create(SIS_F2);
	$__rnd = $___Dt->id_rnd;
?>    
<div class="_cvr _idx">
<?php 
	if(isMobile() || isIPad() || isTablet()){
		$_if_h = '350';
		$_if_h2 = '350px';
	}else{
		$_if_h = '350';
		$_if_h2 = 'auto';
	}
?>
	<iframe frameborder="0" scrolling="no" width="100%" height="<?php echo $_if_h2 ?>" style="max-height: <?php echo $_if_h ?>px; min-height: <?php echo $_if_h ?>px; " id="anm_crm_<?php echo $__rnd; ?>"></iframe>
    <div class="_qts"></div> 
    <div class="crm-ldr">
		<div class="loader">
			<div class="ball"></div>	
		</div>
		<div class="text"><?php echo TX_LDING ?> <br><span><?php echo TX_PNL.' '.TX_PC ?></span></div>
	</div>
</div>
<div class="indx _indx_grph" style="padding:0px!important;margin-left: 0px!important;margin-top: 0px!important;">	
	<?php include(GL_DSH.'dsh.php'); ?>
</div>
<div style="display:none;">
  <div id="_bx_nws_alrt">
  		<a class="__pop_alrt" href="<?php echo VoId() ?>" rel="us_myp">
        <img src="<?php echo DMN_IMG ?>sis/pop_nw_2.jpg" width="600" height="400" />
        </a>
  </div>
  <?php //$CntWb .= " SUMR_Main.glb.var('___a_nws', 'ok'); "; ?>
</div>

<?php if($__f_n->format('m-d') === $__f_h->format('m-d') && (SISUS_FN != '')){ ?>
<div style="display:none;">
  <div id="_bx_hb_alrt"><?php echo h1(SISUS_NM.Spn(TX_HBD)) ?><img src="<?php echo DMN_IMG ?>sis/pop_hb.jpg" width="900" height="540" /></div>
  <?php $CntWb .= " SUMR_Main.glb.var('___a_hb', 'ok'); "; ?>
</div>
<?php } ?>                       
<?php 	
	if(!isN($__snd_p)){ $CntWb .= "SUMR_Dsh.m.o.wdg = ".implode('|', $__snd_p).";"; }
	$CntWb .= "SUMR_Dsh.m.anm.rnd = '".$__rnd."';";
	$CntWb .= "SUMR_Dsh.m.ld.init();";
?>