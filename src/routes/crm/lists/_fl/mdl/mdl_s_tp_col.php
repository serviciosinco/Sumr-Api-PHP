<?php
if(class_exists('CRM_Cnx')){

	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_MDL_S_TP_COL." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$_mdlstp_dt = GtMdlSTpDt([ 'enc'=>$___Ls->gt->isb ]);

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_MDL_S_TP_COL." 
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlstpcol_col', 'als'=>'c' ])."
					WHERE 	".$___Ls->ino." != '' AND 
							mdlstpcol_cl = ".DB_CL_ID." AND
							mdlstpcol_mdlstp = '".$_mdlstp_dt->id."'
						".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";


		$___Ls->qrys = "SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
								"._QrySisSlcF([ 'als'=>'c', 'als_n'=>'column' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'column', 'als'=>'c' ])."
						$Ls_Whr"; 
	
	}  

	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="60%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
		<th width="60%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),150,'Pt', true); ?></td>
		<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo _sino($___Ls->ls->rw['mdlstpcol_e']); ?></td>
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
    	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      	<?php $___Ls->_bld_f_hdr(); ?>
	      	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		        <div class="ln_1">
		          	<div class="col_1">
                        <?php 

                            echo HTML_inp_hd('mdlstpcol_mdlstp', $___Ls->gt->isb);
							$l = __Ls([ 
										'k'=>'mdlstpcol_col', 
										'id'=>'mdlstpcol_col', 
										'va'=>$___Ls->dt->rw['mdlstpcol_col'], 
										'ph'=>FM_LS_COL,
										'rq'=>2
									]); 
									
							echo $l->html; $CntWb .= $l->js;    
						?>	
		          	</div>
				  	<div class="col_2">	   
						<?php 
							echo OLD_HTML_chck('mdlstpcol_e', TX_EST, $___Ls->dt->rw['mdlstpcol_e'] );
						?>
		          	</div>
		        </div>
      		</div>
    	</form>
  	</div>
</div>
<?php } ?>
<?php } ?>
