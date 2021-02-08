<?php
if(class_exists('CRM_Cnx')){

	$___Ls->new->w = 600;
	$___Ls->new->h = 420;
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 420;
	
    $___Ls->_strt(); 
    
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBT).TB_SCL_LD_FLDS." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = " FROM "._BdStr(DBT).TB_SCL_LD_FLDS."
						INNER JOIN "._BdStr(DBM).TB_CL." ON sclldflds_cl = id_cl
						INNER JOIN "._BdStr(DBP).TB_UP_FLD." ON sclldflds_fld = id_upfld
			 
                    WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".CL_ENC."' ORDER BY ".$___Ls->ino." DESC";
                    
		$___Ls->qrys = "SELECT id_sclldflds, sclldflds_enc, upfld_tt, sclldflds_est,
		
                        (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
			
	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
        <th width="80%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
        <th width="10%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
    	<th width="5%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?> 
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
        <td width="80%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['upfld_tt'],'in'); ?></td>
        <td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo _sino($___Ls->ls->rw['sclldflds_est']); ?></td>
		<td width="5%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
                            <?php 
                                echo LsUpPrc([ 'id'=>'sclldflds_fld', 'v'=>'id_upfld', 'va'=>$___Ls->dt->rw['sclldflds_fld'], 'rq'=>'ok' ]); 
                                $CntWb .= JQ_Ls('sclldflds_fld', 'Seleccione campo');    
                            ?>	
                    </div>
                    <div class="col_2">	   
                            <?php 
                                echo OLD_HTML_chck('sclldflds_est', TX_EST, $___Ls->dt->rw['sclldflds_est'] );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
  	</div>
</div>
<?php } ?>
<?php } ?>