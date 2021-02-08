<?php
	
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'us_nm, us_ap, usrg_dsc, usrg_v';
	$___Ls->_strt();
	$__lsgt_flt_cmp = 'usrg_us';

	if(_Chk_GET('fl_usrgus')){ $__fl .= _AndSql('usrg_us', $_GET['fl_usrgus']); }
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_US_RG_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		for($i = 1; $i <= 5; $i++){ $_fl_v .= ", ( SELECT audvl_vl FROM ".MDL_AUD_VL_BD." WHERE audvl_key = '[v".$i."]' AND audvl_aud = id_aud ) AS _vl_".$i." "; }
			
		$_fl_aud .= ", ( SELECT sisslcf_vl FROM ".TB_SIS_SLC_F." WHERE sisslcf_slc = aud_auddsc AND sisslcf_f = 39 ) AS _aud_dsc";
		$Ls_Whr = "  FROM 	".MDL_AUD_BD."
						  	INNER JOIN ".TB_US." ON aud_us = id_us
							INNER JOIN ".TB_SIS_SLC_F." ON aud_auddsc = sisslcf_slc
					 WHERE id_aud != '' AND sisslcf_f = 38 
					 ORDER BY id_aud DESC ";

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $_fl_aud $_fl_v $Ls_Whr";
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="30%" <?php echo NWRP ?>><?php echo TX_USR ?></th>
	    <th width="51%" <?php echo NWRP ?>><?php echo TX_PRC ?></th>
	    <th width="9%" <?php echo NWRP ?>><?php echo TX_F ?></th>
  	</tr>
  	<?php do { ?>
  	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw['id_aud']); ?></td>
	    <td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'),100,'Pt', true); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx(strtr( $___Ls->ls->rw['_aud_dsc'], ['[v1]'=>$___Ls->ls->rw['_vl_1'],
		    																							   '[v2]'=>$___Ls->ls->rw['_vl_2'],
		    																							   '[v3]'=>$___Ls->ls->rw['_vl_3'],
		    																							   '[v4]'=>$___Ls->ls->rw['_vl_4'],
		    																							   '[v5]'=>$___Ls->ls->rw['_vl_5']] ),'in'); ?></td>
	    <td width="9%" align="left" nowrap="nowrap"><?php echo Spn(ShortTx(ctjTx($___Ls->ls->rw['aud_fi'],'in'),40,'Pt', true),'','_f'); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<? 
/* Formulario ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
		  <?php echo HTML_inp_tx('audtx_dsc', TX_MSJ, ctjTx($___Ls->dt->rw['audtx_dsc'],'in'), FMRQD); ?></div>
          <div class="col_2">
		  <?php echo HTML_inp_tx('obs_audtx', TX_PRC, ctjTx($___Ls->dt->rw['obs_audtx'],'in'), FMRQD); ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<? Formulario */ ?>
<?php } ?>
