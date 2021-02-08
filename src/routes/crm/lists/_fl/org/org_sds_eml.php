<?php

if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = _Cns('TX_EML');
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_ORG_SDS_EML."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){
		
	
		$Ls_Whr = "	FROM ".TB_ORG_SDS_EML."	
		
					INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdseml_orgsds = id_orgsds
					INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
					WHERE ".$___Ls->ino." != '' 
					AND org_enc = '{$__i}'
					
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
				   		(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	} 	

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_EML ?></th>	
			     <th width="5%" <?php echo NWRP ?>><?php echo TX_SDS ?></th>	
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['orgsdseml_eml'],'in'); ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['orgsds_nm'],'in'); ?></td>
				    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
		
	}
	$___Ls->_h_ls_nr(); 
} ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	    <div class="ln_1">
		   	<?php echo LsOrgSds([ /*'cl'=>'ok',*/ 'id'=>'orgsdseml_orgsds', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdseml_orgsds'], 'rq'=>1, 'org'=>$__i ]);
					$CntWb .= JQ_Ls('orgsdseml_orgsds'); ?>
		    <?php echo HTML_inp_hd('orgeml_org', $__i); ?>
			<?php echo HTML_inp_tx('orgsdseml_eml', TX_EML , ctjTx($___Ls->dt->rw['orgsdseml_eml'],'in'), FMRQD); ?>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
