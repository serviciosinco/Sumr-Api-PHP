<?php
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();	

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'clapp_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_CL_APP_ICN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_APP_ICN."
						 INNER JOIN "._BdStr(DBM).TB_CL_APP." ON clappicn_clapp = id_clapp
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clappicn_icn', 'als'=>'icn' ])."
					WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
								"._QrySisSlcF([ 'als'=>'icn', 'als_n'=>'icon' ]).", 
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'icon', 'als'=>'icn' ])."
						$Ls_Whr"; 
	
	}
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<div
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clappicn_tt'],'in'),40,'Pt', true); ?></td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
				  	<?php echo HTML_inp_hd('clappicn_clapp', $__i); ?>
				  	<?php 
						$l = __Ls(['k'=>'app_mdls', 'id'=>'clappicn_icn', 'va'=>$___Ls->dt->rw['clappicn_icn'] , 'ph'=>TX_MDL ]); 
						echo $l->html; $CntWb .= $l->js;
					?>
					<?php echo HTML_inp_tx('clappicn_tt', TX_NM, ctjTx($___Ls->dt->rw['clappicn_tt'],'in')); ?>
					<?php echo OLD_HTML_chck('clappicn_e', TX_ACTV, $___Ls->dt->rw['clappicn_e'], 'in'); ?>
				</div>
				<div class="col_2">		
					<?php echo HTML_inp_tx('clappicn_lnk', TX_LNK, ctjTx($___Ls->dt->rw['clappicn_lnk'],'in')); ?>
					<?php echo HTML_inp_tx('clappicn_ord', TX_ORD, ctjTx($___Ls->dt->rw['clappicn_ord'],'in')); ?>
				</div>
			</div>
			
	      </div>
	    </form>
	  </div>
	</div>   
<?php } ?>
<?php } ?>