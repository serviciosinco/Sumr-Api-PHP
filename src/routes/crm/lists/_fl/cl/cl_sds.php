<?php 
if(class_exists('CRM_Cnx')){

    $___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT *		
								FROM "._BdStr(DBM).TB_CL_SDS."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_SDS."
					WHERE  id_clsds != '' AND clsds_cl = ".DB_CL_ID."
					ORDER BY id_clsds DESC";
				   
		$___Ls->qrys = "SELECT id_clsds, clsds_enc, clsds_nm, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
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
	        <th width="10%" <?php echo NWRP ?>><?php echo TX_NM?></th>  
	        <th width="1%" <?php echo NWRP ?>></th>
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clsds_nm'],'in'),50); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>  
      </tr>
      <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
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
                    <?php echo HTML_inp_tx('clsds_nm', TX_NM, ctjTx($___Ls->dt->rw['clsds_nm'],'in'), FMRQD); ?>  
                    <?php echo HTML_inp_tx('clsds_dir', TX_DIR, ctjTx($___Ls->dt->rw['clsds_dir'],'in')); ?> 
                </div>        
		    </div>              
	    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>