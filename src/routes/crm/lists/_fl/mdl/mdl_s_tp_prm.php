<?php
if(class_exists('CRM_Cnx')){

	$___Ls->sch->f = 'mdlstpprm_nm';
	$___Ls->_strt();
	
	if(!isN($__i)){ $___mdlstpdt = GtMdlSTpDt([ 'id'=>$__i ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_S_TP_PRM.", ".TB_MDL_S_TP." WHERE mdlstpprm_mdlstp = id_mdlstp AND ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  

		if(!isN($__i)){ $__fl = " AND mdlstpprm_mdlstp = ".GtSQLVlStr($___Ls->gt->isb, "int")." "; }
		 
		$Ls_Whr = " FROM ".TB_MDL_S_TP_PRM."
						 INNER JOIN ".TB_MDL_S_TP." ON mdlstpprm_mdlstp = id_mdlstp 
					WHERE ".$___Ls->ino." != '' {$__fl} ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";			
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
    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_CLS ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>

  <tr>
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstpprm_nm'],'in'),150,'Pt', true); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstpprm_vl'],'in'),150,'Pt', true); ?></td>
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
    
    
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
	        <div class="col_1">
	            <?php echo HTML_inp_tx('mdlstpprm_nm', TX_NM , ctjTx($___Ls->dt->rw['mdlstpprm_nm'],'in'), FMRQD); ?>
	        </div>
	        <div class="col_2">
				
				<div class="colx2">
					<div class="_c1">
						<h2><?php echo $___mdlstpdt->tp ; ?></h2>
					</div>
					<div class="_c2">
						<?php echo HTML_inp_tx('mdlstpprm_vl', TX_KEY , ctjTx($___Ls->dt->rw['mdlstpprm_vl'],'in'), FMRQD); ?>
						<?php echo HTML_inp_hd('mdlstpprm_mdlstp', (!isN($___Ls->dt->rw['mdlstpprm_mdlstp'])?$___Ls->dt->rw['mdlstpprm_mdlstp']:$__i) ); ?>
					</div>
				</div>	
				
		        
		        
		        
		        <?php $l = __Ls([ 'k'=>'mdls_tp_prm', 'id'=>'mdlstpprm_tp', 'va'=>$___Ls->dt->rw['mdlstpprm_tp'] , 'ph'=>'-' ]); 
						echo $l->html; $CntWb .= $l->js; ?>
	        </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
