<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = TX_TAGS;
	$___Ls->sch->f = 'siscnttpgrp_nm';
	$___Ls->new->h = 300;
	
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_CNT_TP_GRP." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "	FROM ".TB_SIS_CNT_TP_GRP."
				   	ORDER BY siscnttpgrp_nm ASC";
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
	    <th width="50%" <?php echo NWRP ?>><?php echo TX_TT ?></th> 
	    <th width="1%" <?php echo NWRP ?>></th>
	</tr>
	<?php do { ?>
  	<tr>    
	    <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	    <td width="90%" align="left" <?php echo $_clr_rw ?>>		    
		    <?php 
			    echo 	Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['siscnttpgrp_clr'].'; ') . 
			    		ctjTx($___Ls->ls->rw['siscnttpgrp_nm'],'in').HTML_BR.
			    		Spn(ctjTx($___Ls->ls->rw['siscnttpgrp_clr'],'in'),'ok','_f'); 
			?>
		</td>   
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
			  		<?php echo HTML_inp_tx('siscnttpgrp_nm', TX_NM , ctjTx($___Ls->dt->rw['siscnttpgrp_nm'],'in'), FMRQD); ?>
			  		<?php echo HTML_inp_tx('siscnttpgrp_key', TX_KEY , ctjTx($___Ls->dt->rw['siscnttpgrp_key'],'in'), FMRQD); ?>
			  		<?php echo HTML_inp_clr([ 'id'=>'siscnttpgrp_clr', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['siscnttpgrp_clr'],'in') ]); ?> 
		        </div>
      		</div>
    	</form>
  	</div>
</div>
<?php } ?>
<?php } ?>