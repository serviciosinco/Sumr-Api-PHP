<?php
if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'upfld_tt, upfld_vl';

	$___Ls->new->w = 600;
	$___Ls->new->h = 600;
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 600;

	$___Ls->_strt();


	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT * FROM ".DBP.".".TB_UP_FLD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){
		$Ls_Whr = "FROM ".DBP.".".TB_UP_FLD." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_VLE ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
   <tr>
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['upfld_tt'],'in'),40,'Pt', true); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['upfld_vl'],'in'),40,'Pt', true); ?></td>
    <td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php  echo DV_GNR_FM ?>">
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>
	  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	      <?php echo HTML_inp_hd('upfld_enc', $___Ls->dt->rw['upfld_enc']); ?>
          <?php echo HTML_inp_tx('upfld_tt', TX_NM, ctjTx($___Ls->dt->rw['upfld_tt'],'in'), FMRQD); ?>
          <?php echo HTML_inp_tx('upfld_vl', TX_VAR, ctjTx($___Ls->dt->rw['upfld_vl'],'in'), FMRQD); ?>

        <?php

          echo OLD_HTML_chck('upfld_fk', TX_FRGNK, $___Ls->dt->rw['upfld_fk'], 'in');
          echo OLD_HTML_chck('upfld_dte', TX_F, $___Ls->dt->rw['upfld_dte'], 'in');
          echo OLD_HTML_chck('upfld_cnt', TX_INFLD_CNT, $___Ls->dt->rw['upfld_cnt'], 'in');
		  echo OLD_HTML_chck('upfld_mdl_cnt', TX_INFLD_MDL_CNT, $___Ls->dt->rw['upfld_mdl_cnt'], 'in');
		  echo OLD_HTML_chck('upfld_mdl_cnt_tra', TX_INFLD_MDL_CNT_TRA, $___Ls->dt->rw['upfld_mdl_cnt_tra'], 'in');
          echo OLD_HTML_chck('upfld_snd_ec_lsts_up', TX_LDNGLSTSMSS, $___Ls->dt->rw['upfld_snd_ec_lsts_up'], 'in');
          echo OLD_HTML_chck('upfld_snd_sms_cmpg_up', TX_SMSLDNLSTSMSS, $___Ls->dt->rw['upfld_snd_sms_cmpg_up'], 'in');
          echo OLD_HTML_chck('upfld_ext_cnt', TX_ATRBTLD, $___Ls->dt->rw['upfld_ext_cnt'], 'in');
          echo OLD_HTML_chck('upfld_ext_mdlcnt', TX_ATRBTOPRTND, $___Ls->dt->rw['upfld_ext_mdlcnt'], 'in');
          echo OLD_HTML_chck('upfld_scl', 'Activo En Social', $___Ls->dt->rw['upfld_scl'], 'in');

        ?>

        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>