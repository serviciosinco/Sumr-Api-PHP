<?php
if(class_exists('CRM_Cnx')){

	$___Ls->sch->f = 'sisecsgmvar_nm';	
	$___Ls->img->dir = DMN_FLE_SIS_EC_SGM_VAR;
	$___Ls->new->w = 550;
	$___Ls->new->h = 300;
	$___Ls->edit->w = 550;
	$___Ls->edit->h = 300;	
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_EC_SGM_VAR." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  
		 
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_SIS_EC_SGM_VAR." 
						 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM." ON sisecsgmvar_sgm = id_sisecsgm
					WHERE  ".$___Ls->ino." != '' ".$___Ls->sch->cod." 
					ORDER BY sisecsgm_nm ASC, sisecsgmvar_nm ASC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr ";
	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
	<tr>    
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisecsgmvar_nm'],'in'),40,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisecsgm_nm'],'in'),40,'Pt', true); ?></td>
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
      	
				<?php echo HTML_inp_tx('sisecsgmvar_nm', TX_NM , ctjTx($___Ls->dt->rw['sisecsgmvar_nm'],'in'), FMRQD); ?>
				<?php echo LsSisEcSgmVarTp('sisecsgmvar_tp','id_sisecsgmvartp', $___Ls->dt->rw['sisecsgmvar_tp'], '', 2); $CntWb .= JQ_Ls('sisecsgmvar_tp',FM_LS_SLTP); ?>    
				<?php echo LsSisEcSgm('sisecsgmvar_sgm','id_sisecsgm', $___Ls->dt->rw['sisecsgmvar_sgm'], '', 2); $CntWb .= JQ_Ls('sisecsgmvar_sgm',FM_LS_SLTP); ?> 
 					
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>

<?php } ?> 
