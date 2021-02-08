<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->ik = 'awsacc_enc';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("	SELECT *,
											AES_DECRYPT(awsacc_key, '".ENCRYPT_PASSPHRASE."') AS awsacc_key_v,
											AES_DECRYPT(awsacc_scrt, '".ENCRYPT_PASSPHRASE."') AS awsacc_scrt_v
									FROM "._BdStr(DBT).TB_AWS_ACC."
                                    	 INNER JOIN "._BdStr(DBM).TB_CL." ON awsacc_cl = id_cl
								    WHERE ".$___Ls->ik." = %s 
								    LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBT).TB_AWS_ACC."
						INNER JOIN "._BdStr(DBM).TB_CL." ON awsacc_cl = id_cl
					WHERE cl_enc != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_awsacc DESC";
				   
		$___Ls->qrys = "	SELECT  *, 
									(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
									AES_DECRYPT(awsacc_key, '".ENCRYPT_PASSPHRASE."') AS awsacc_key_v,
									AES_DECRYPT(awsacc_scrt, '".ENCRYPT_PASSPHRASE."') AS awsacc_scrt_v
							$Ls_Whr";
		
	}

	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
	    <tr>
	    	<th width="1%" <?php echo NWRP ?>></th>
	        <th width="20%" <?php echo NWRP ?>><?php echo TX_ID?></th>   
            <th width="20%" <?php echo NWRP ?>><?php echo TX_KEY_API?></th> 
	        <th width="20%" <?php echo NWRP ?>><?php echo TX_SCRT?></th>
	        <th width="1%" <?php echo NWRP ?>></th>
	        
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['awsacc_id'],'in'),50); ?></td>
            <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['awsacc_key_v'],'in'),50); ?></td>
            <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['awsacc_scrt_v'],'in'),50); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>  
      </tr>
      <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
      <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      	<?php $___Ls->_bld_f_hdr(); ?>
		  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
				<div class="ln_1">
                    <div class="col_1">  	
						<?php echo HTML_inp_tx('awsacc_id', TX_ID, ctjTx($___Ls->dt->rw['awsacc_id'],'in'), FMRQD); ?>      
                        <?php echo HTML_inp_tx('awsacc_key', TX_KEY_API, ctjTx($___Ls->dt->rw['awsacc_key_v'],'in'), FMRQD); ?> 
	          	    </div>
					<div class="col_2">
                        <?php echo HTML_inp_tx('awsacc_scrt', TX_SCRT, ctjTx($___Ls->dt->rw['awsacc_scrt_v'],'in'), FMRQD); ?> 
                        <?php echo HTML_inp_hd('awsacc_cl', $___Ls->gt->isb); ?>
					</div>
                </div>        
		    </div>              
	    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>