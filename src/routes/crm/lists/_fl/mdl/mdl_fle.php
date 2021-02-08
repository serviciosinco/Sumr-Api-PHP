<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tp = 'mdl_fle';

	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'sisps_tt';
	
	$___Ls->new->w = 400;
	$___Ls->new->h = 300;
	$___Ls->edit->w = 400;
	$___Ls->edit->h = 300;
		
	$___Ls->_strt();
	


	
	if(!isN($___Ls->gt->i)){	
 		$_Sub_Qry_Exc = ", (SELECT GROUP_CONCAT(fleusest_us) FROM "._BdStr(DBM).TB_FLE_US_EST." WHERE fleusest_fle = (SELECT mdlfle_fle FROM ".TB_MDL_FLE." WHERE mdlfle_enc = '".$___Ls->gt->i."') AND fleusest_est = 2) AS _us_exc";
		$_Sub_Qry_Inc = ", (SELECT GROUP_CONCAT(fleusest_us) FROM "._BdStr(DBM).TB_FLE_US_EST." WHERE fleusest_fle = (SELECT mdlfle_fle FROM ".TB_MDL_FLE." WHERE mdlfle_enc = '".$___Ls->gt->i."') AND fleusest_est = 1) AS _us_inc"; 
		$Ls_Whr = "FROM ".TB_MDL_FLE." INNER JOIN "._BdStr(DBM).TB_FLE." ON id_fle = mdlfle_fle INNER JOIN ".TB_MDL." ON id_mdl = mdlfle_mdl WHERE mdlfle_enc = ".GtSQLVlStr($___Ls->gt->i, "text");
		$___Ls->qrys = "SELECT * $_Sub_Qry_Exc $_Sub_Qry_Inc , (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr LIMIT 1";
		
	}elseif($___Ls->_show_ls == 'ok'){  
		

		$Ls_Whr = "FROM ".TB_MDL_FLE." INNER JOIN "._BdStr(DBM).TB_FLE." ON id_fle = mdlfle_fle INNER JOIN ".TB_MDL." ON id_mdl = mdlfle_mdl WHERE fle_est = 1 AND mdl_enc = ".GtSQLVlStr($___Ls->gt->isb, "text");

		/*$Ls_Whr = "	FROM ".TB_MDL_FLE." 
						INNER JOIN "._BdStr(DBM).TB_FLE." ON id_fle = mdlfle_fle 
						INNER JOIN ".TB_MDL." ON id_mdl = mdlfle_mdl 
					WHERE mdl_enc = ".GtSQLVlStr($___Ls->gt->isb, "text");*/
					

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php //$___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_ARCHVS ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
	<tr>    
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['fle_nm'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<div id="_upl_fle"></div>
<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_mdl',true))."', c:'_upl_fle', d: { __i: '".$___Ls->gt->isb."', _t: 'mdl_fle' } });"; ?>
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
	        	<?php echo HTML_inp_hd('id_fle', $___Ls->dt->rw['id_fle']); ?>	
	        	<?php echo HTML_textarea('fle_dsc', TX_DSC, ctjTx($___Ls->dt->rw['fle_dsc'],'in'), '', '', ''); ?>
				<?php echo h2(TX_KYW); ?>
				<?php echo HTML_inp_tx('fle_kyw', TX_KYW, ctjTx($___Ls->dt->rw['fle_kyw'],'in')); $CntWb .=	" SUMR_Main.kyw({id:'fle_kyw'});";  ?>	
        	</div>
        	<div class="col_2">
	        	
	        	<?php echo OLD_HTML_chck('fle_pbl', TX_PBL , $___Ls->dt->rw['fle_pbl'] ).HTML_BR; ?>
	        	<div class="_exc" style="<?php if($___Ls->dt->rw['fle_pbl'] == 2){ echo "display:none;"; } ?>">
            		<?php echo LsUs('fle_us_exc','id_us', explode(',',$___Ls->dt->rw['_us_exc']), TX_EXC_US, 2, 'ok'); $CntWb .= JQ_Ls('fle_us_exc', 'Incluir'); ?>
            	</div>
            	<div class="_inc" style="<?php if($___Ls->dt->rw['fle_pbl'] == 1){ echo "display:none;"; } ?>">
	            	<?php echo LsUs('fle_us_inc','id_us', explode(',',$___Ls->dt->rw['_us_inc']), TX_INC_US, 2, 'ok').HTML_BR; $CntWb .= JQ_Ls('fle_us_inc', 'Incluir'); ?>
            	</div>	
            	
            	<?php echo LsMdlSHrs('fle_sch','id_mdlssch', $___Ls->dt->rw['fle_sch'] , TX_PSG_HRA, 2, 'no' ); $CntWb .= JQ_Ls('fle_sch', FM_LS_SLFAC); ?>	
        	</div>
		
        </div>
        
      </div>
      
    </form>
    
  </div>
  
</div>
<?php } ?>

<?php } ?> 

<?php 
	$CntWb .= "
		$('#fle_pbl').change(function(){
			if ($(this).is(':checked')) {
				$('._exc').show('slow');
				$('._inc').hide('slow');
		 	}else{ 
			 	$('._exc').hide('slow');
				$('._inc').show('slow');
		 	}
		});
    "; 
?>