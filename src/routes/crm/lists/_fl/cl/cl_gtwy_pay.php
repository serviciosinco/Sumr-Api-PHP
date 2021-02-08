<?php
if(class_exists('CRM_Cnx')){

  $___Ls->ik = 'clgtwypay_enc';
	$___Ls->_strt(); 
	
	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("  SELECT *,
                                    AES_DECRYPT(clgtwypay_sndbx_key, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_sndbx_key,
                                    AES_DECRYPT(clgtwypay_sndbx_tkn, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_sndbx_tkn,
                                    AES_DECRYPT(clgtwypay_prd_key, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_prd_key,
                                    AES_DECRYPT(clgtwypay_prd_tkn, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_prd_tkn
                              FROM "._BdStr(DBM).TB_CL_GTWY_PAY." 
                              WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	

	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_GTWY_PAY."
                        INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = clgtwypay_cl
                        INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON id_sisslc = clgtwypay_gtwy
					WHERE cl_enc != '' AND cl_enc = '".$___Ls->gt->isb."' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_clgtwypay DESC";
				   
		$___Ls->qrys = "SELECT  *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	}
	
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_VL ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clgtwypay_nm'],'in'),100,'Pt', true); ?></td>
      <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),100,'Pt', true); ?></td>
		  <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
             
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	<?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
                <?php echo HTML_inp_hd('clgtwypay_cl', _SbLs_ID('i')); ?>
                <?php echo HTML_inp_tx('clgtwypay_nm', 'Nombre' , ctjTx($___Ls->dt->rw['clgtwypay_nm'],'in'), FMRQD); ?>

                <?php 
                
                    $l = __Ls(['k'=>'gtwy_pay', 'id'=>'clgtwypay_gtwy', 'va'=>$___Ls->dt->rw['clgtwypay_gtwy'] , 'ph'=>'Gateway Payment']); 
                    echo $l->html; $CntWb .= $l->js;
                
                ?>

                <?php echo HTML_inp_tx('clgtwypay_url_success', 'Url Success' , ctjTx($___Ls->dt->rw['clgtwypay_url_success'],'in')); ?>
                <?php echo HTML_inp_tx('clgtwypay_url_failure', 'Url Failure' , ctjTx($___Ls->dt->rw['clgtwypay_url_failure'],'in')); ?>
                <?php echo HTML_inp_tx('clgtwypay_url_pending', 'Url Pending' , ctjTx($___Ls->dt->rw['clgtwypay_url_pending'],'in')); ?> 
                
                <?php echo OLD_HTML_chck('clgtwypay_sndbx', 'Sandbox', $___Ls->dt->rw['clgtwypay_sndbx'], 'in'); ?>

          </div>
          <div class="col_2">

            <?php echo HTML_inp_tx('clgtwypay_sndbx_key', 'Sandbox Key' , ctjTx($___Ls->dt->rw['clgtwypay_sndbx_key'],'in')); ?>
            <?php echo HTML_inp_tx('clgtwypay_sndbx_tkn', 'Sandbox Token' , ctjTx($___Ls->dt->rw['clgtwypay_sndbx_tkn'],'in')); ?>
            <?php echo HTML_inp_tx('clgtwypay_prd_key', 'Production Key' , ctjTx($___Ls->dt->rw['clgtwypay_prd_key'],'in')); ?>
            <?php echo HTML_inp_tx('clgtwypay_prd_tkn', 'Production Token' , ctjTx($___Ls->dt->rw['clgtwypay_prd_tkn'],'in')); ?>
	          	
            <?php echo OLD_HTML_chck('clgtwypay_e', TX_ACTV, $___Ls->dt->rw['clgtwypay_e'], 'in'); ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
