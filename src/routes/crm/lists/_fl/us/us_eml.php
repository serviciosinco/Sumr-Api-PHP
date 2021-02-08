<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'useml_tel, sisps_tt';
	$___Ls->ino = 'id_eml';
	$___Ls->ik = 'eml_enc';
	$___Ls->edit->w = 850;
	$___Ls->edit->h = 800;
	$___Ls->_strt();

	if(!ChckSESS_superadm()){ $__fl .= _AndSql('id_us', SISUS_ID); }
	
	if(!isN($___Ls->gt->i)){
		
		 $___Ls->qrys = sprintf("SELECT *,
		 								AES_DECRYPT(eml_api_key, '".ENCRYPT_PASSPHRASE."') AS eml_api_key_v
								  FROM  "._BdStr(DBM).TB_US_EML." 
								  		INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON useml_eml = id_eml
								  WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		 
		$Ls_Whr = "FROM "._BdStr(DBM).TB_US_EML."
						INNER JOIN "._BdStr(DBM).TB_US." ON useml_us = id_us
						INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON useml_eml = id_eml 
				   WHERE useml_cl = '".$__dt_cl->id."' $__fl ".$___Ls->sch->cod." ";
		
		$___Ls->qrys = "	SELECT *,
							(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
							$Ls_Whr
						"; 
		
	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<section class="_cvr" style="background-color:#83cfc8;">
	<iframe src="<?php echo DMN_ANM; ?>mis_correos/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
</section>	

<div style="padding:20px;">
	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<tr>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="98%" <?php echo NWRP ?>><?php echo TT_FM_EML ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
	</tr>
	<?php do { ?>

	<tr>
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw['id_eml']); ?></td>
		<td width="98%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['eml_eml'],'in'),150,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['useml_fi'],'in'),150,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
	</tr>
	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	</table>
	<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>

	<?php $___Ls->_h_ls_nr(); ?>
</div>	
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">


  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
	          	<?php echo HTML_inp_hd('useml_cl', ($___Ls->dt->rw['useml_cl']?$___Ls->dt->rw['useml_cl']:$__dt_cl->id) ); ?>	
				<?php echo HTML_inp_hd('useml_us', SISUS_ID ); ?>	
				<?php echo HTML_inp_tx('eml_nm', TT_FM_NM, ctjTx($___Ls->dt->rw['eml_nm'],'in'), FMRQD); ?>			
				<?php echo HTML_inp_tx('eml_eml', TT_FM_EML, ctjTx($___Ls->dt->rw['eml_eml'],'in'), FMRQD_EM); ?>
          </div>
          <div class="col_2">
	          	<?php 
	                $l = __Ls([ 'k'=>'sis_eml', 'id'=>'eml_tp', 'va'=>$___Ls->dt->rw['eml_tp'], 'ph'=>TX_SLUSCLNEML ]); 
	                echo $l->html; $CntWb .= $l->js;    
                ?> 
	        	<?php echo HTML_inp_tx('eml_srv_in', TX_SRVR, ctjTx($___Ls->dt->rw['eml_srv_in'],'in')); ?>
	        	<?php echo HTML_inp_tx('eml_usr', TX_USR, ctjTx($___Ls->dt->rw['eml_usr'],'in')); ?>
	        	<?php if($___Ls->dt->tot == 0){ echo HTML_inp_tx('useml_pss', TX_PSSW, ctjTx($___Ls->dt->rw['useml_pss'],'in'),'','','','','','',['tp'=>'password']); } ?>
				<?php echo HTML_inp_tx('eml_prt_in', TX_PRTO, ctjTx($___Ls->dt->rw['eml_prt_in'],'in')); ?>
				<?php echo HTML_inp_tx('eml_api_key', TX_KEY_API, ctjTx($___Ls->dt->rw['eml_api_key_v'],'in')); ?>
				<?php echo OLD_HTML_chck('eml_ssl', TX_SSL, $___Ls->dt->rw['eml_ssl']); ?>
				
	        <?php if($___Ls->dt->rw['eml_tp'] == _Cns('ID_SISEML_GMAIL')){ ?>
	        
	        	<a href="<?php echo Void(); ?>" class="___onl_btn _anm" id="google_token"><?php echo TX_OBT_TKN?></a>
				<?php 
					
					$CntWb .= "
						$('#google_token').off('click').click(function() {		
							SUMR_Main.wopn({
								trg:'SUMR - OAuth',
								href:'".DMN_OAUTH."google/?_cl=".$__dt_cl->enc."&_us=".SISUS_ENC."&_eml=".$___Ls->dt->rw['eml_enc']."&Rnd='+Math.random(),
								w:'500',
								h:'600'
							});	
						});
					";
					
				?>
	        <?php } ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
