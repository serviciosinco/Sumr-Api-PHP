<?php
if(class_exists('CRM_Cnx')){

	
	$___Ls->sch->f = 'grphchr_tt, grphchr_key';
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 350;
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		
		 $___Ls->qrys = sprintf("SELECT * FROM ".MDL_GRPH_CHR_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Whr = "FROM ".MDL_GRPH_CHR_BD." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
		<th width="49%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo 'Key' ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
	</tr>
	<?php do { ?>
	<tr>    
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['grphchr_tt'],'in'),150,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['grphchr_key'],'in'),150,'Pt', true); ?></td>
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
		          <div class="col_1">
		          	 <?php echo HTML_inp_tx('grphchr_tt', TX_TT, ctjTx($___Ls->dt->rw['grphchr_tt'],'in'), FMRQD); 
			          	   echo HTML_inp_tx('grphchr_key', 'Key', ctjTx($___Ls->dt->rw['grphchr_key'],'in'), FMRQD); 
		          	 ?>
				  <div id="test_g"></div>
		          	 
		          </div>
		          <div class="col_2">
			      	<?php 
				      	  echo HTML_inp_tx('grphchr_dfl', TX_VLRDFCT, ctjTx($___Ls->dt->rw['grphchr_dfl'],'in')); 
				      	  echo LsSisTpDt('grphchr_tp','id_sistpdt', $___Ls->dt->rw['grphchr_tp'], Datatype, 2, ''); $CntWb .= JQ_Ls('grphchr_tp',FM_LS_ASGNTRS);
			      	 ?>
		          </div>
		        </div>
	      	</div>
	    </form>
  	</div>

</div>
<?php } ?>
<?php } ?>
