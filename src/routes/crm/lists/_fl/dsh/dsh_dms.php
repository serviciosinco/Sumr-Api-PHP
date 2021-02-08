<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = TX_DIMNS;
	$___Ls->sch->f = 'dshdms_tt, dshdms_fi';
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 350;
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){
		
		$_qry_sub = ", (SELECT GROUP_CONCAT(dshgrphdms_grph) FROM ".TB_DSH_GRPH_DMS." WHERE dshgrphdms_dms = id_dshdms) AS _grph";	
		$___Ls->qrys = sprintf("SELECT * $_qry_sub FROM ".TB_DSH_DMS." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$_qry_sub = ", (SELECT GROUP_CONCAT(grph_tt) FROM ".TB_DSH_GRPH_DMS.", _grph WHERE dshgrphdms_grph = id_grph AND dshgrphdms_dms = id_dshdms) AS _grph";
		$Ls_Whr = "FROM ".TB_DSH_DMS." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $_qry_sub $Ls_Whr"; 
		
	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<tr>	
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="49%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
	    <th width="49%" <?php echo NWRP ?>><?php echo TX_GRPH_TP ?></th>
	    <th width="49%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
	    <th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>    
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshdms_tt'],'in'),150,'Pt', true); ?></td>
	    <td width="49%" align="left" nowrap="nowrap">
		    <?php 
			    $_grph = explode(",", $___Ls->ls->rw['_grph']);
			    foreach($_grph as $_v){
				    echo Spn(ctjTx("( ".$_v,'in')." )",'','_f').HTML_BR;
			    }
			?>
		</td>
	    <td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['dshdms_fi'],'in'),150,'Pt', true); ?></td>
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
  <div id="<?php  echo DV_GNR_FM ?>">                        
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>         
      	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

        <div class="ln_1">
          
          	 <?php echo HTML_inp_tx('dshdms_tt', TX_TT, ctjTx($___Ls->dt->rw['dshdms_tt'],'in'), FMRQD); 
          	 ?>
		  <div id="test_g"></div>
          	 
	      	<?php  
		     	echo LsGrph('dshdms_grph','id_grph', $___Ls->dt->rw['_grph'], 'Tipo de dato', 1, 'ok'); $CntWb .= JQ_Ls('dshdms_grph',FM_LS_ASGNTRS);
	      	 ?>
          
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
