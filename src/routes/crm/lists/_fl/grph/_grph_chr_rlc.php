<?php
if(class_exists('CRM_Cnx')){

	
	$___Ls->tt = TX_CRCT;
	$___Ls->sch->f = 'grphchr_tt';
	$___Ls->_strt();
	//$___Ls->ik = "id_grphchrrlc";
	 	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).MDL_GRPH_CHR_RLC_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){	
		if($__t == '_grph_chr_rlc'){ $__fl = " AND grphchrrlc_grph = ".$_GET['__i']."";}
		
		$Ls_Whr = "FROM ".MDL_GRPH_CHR_RLC_BD.", ".MDL_GRPH_CHR_BD.", ".MDL_GRPH_BD."
				   WHERE grphchrrlc_grph = id_grph AND grphchrrlc_chr = id_grphchr  $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>">
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	       <?php $___Ls->_bld_f_hdr(); ?>
		   <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		  
	        <div class="ln_1">
	          <div class="col_1"> 
		         	<?php 
						echo HTML_inp_hd('grphchrrlc_grph', $_GET['__i']);
						echo LsSisGrph('grphchrrlc_chr','id_grphchr', $___Ls->dt->rw['grphchrrlc_chr'], FM_LS_ASGNTRS, 2, ''); $CntWb .= JQ_Ls('grphchrrlc_chr',FM_LS_ASGNTRS);
					?>
			    </div>
				<div class="col_2"> 
				<?php $__lngall= GtLngLs(); ?>
				  <?php foreach ($__lngall->ls as $_l_k=>$_l_v) {   ?>
				    <div id="Fm_<?php echo $_l_v->cod ?>" class="CollapsiblePanel">
				      <div class="CollapsiblePanelTab"><?php echo $_l_v->nm ?></div>
				          <div class="CollapsiblePanelContent">
				            <?php echo HTML_textarea('grphchrrlc_vl_'.$_l_v->cod, '', ctjTx($___Ls->dt->rw['grphchrrlc_vl_'.$_l_v->cod],'in'), '', 'ok',$__jqte); ?>
				            </div>
				      </div>
				    <?php $CntWb .= 'var Fm_'.$_l_v->cod.' = new Spry.Widget.CollapsiblePanel("Fm_'.$_l_v->cod.'", {contentIsOpen:false});'; ?>
				  <?php } ?>
				</div>
	        </div>
	      </div>
	    </form>
  	</div>

</div>
<?php } ?>
<?php } ?>
