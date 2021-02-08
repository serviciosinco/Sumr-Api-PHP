<?php 
	
	
if(class_exists('CRM_Cnx')){

	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'_cl.cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT *, 
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'flj', 'als'=>'t']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t1'])."
								FROM "._BdStr(DBM).TB_CL_FLJ."
									 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'clflj_flj', 'als'=>'t'])."
									 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'clflj_tp', 'als'=>'t1'])."
									 INNER JOIN "._BdStr(DBM).TB_CL." ON _cl.id_cl = clflj_cl
									 LEFT JOIN "._BdStr(DBM).TB_US." ON clflj_us = id_us
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_FLJ."	
						INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = clflj_cl
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." AS _fl ON _fl.id_sisslc = clflj_flj
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." AS _tp ON _tp.id_sisslc = clflj_tp
						LEFT JOIN "._BdStr(DBM).TB_US." ON clflj_us = id_us
					WHERE _cl.cl_enc != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY _tp.sisslc_tt ASC, _fl.sisslc_tt ASC, id_clflj DESC";
					
		$___Ls->qrys = "SELECT *, _tp.sisslc_tt, _fl.sisslc_tt,(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.", _tp.sisslc_tt as tp_nm, _fl.sisslc_tt as fl_nm $Ls_Whr";
	}
		
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
	    <tr>
	    	<th width="1%" <?php echo NWRP ?>></th>
	        <th width="10%" <?php echo NWRP ?>><?php echo TX_NM ?></th>   
	        <th width="30%" <?php echo NWRP ?>><?php echo TX_TP ?></th>	
	        <th width="30%" <?php echo NWRP ?>><?php echo TX_EMAIL ?></th>
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_US ?></th>
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_ACTV ?></th>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_SMS ?></th>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_WHTSP ?></th>
	        <th width="1%" <?php echo NWRP ?>></th>
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['tp_nm'],'in'),50); ?></td>
	        <td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['fl_nm'],'in'),50); ?></td>
	        <td width="1%" align="left" nowrap="nowrap">
		        <?php 
			    	if($___Ls->ls->rw['clflj_user'] != 1){ 
			        	echo ShortTx(ctjTx($___Ls->ls->rw['us_user'],'in'),50); 
			       	}else{
				       	echo '-- envio a usuario --';
			       	}
			    ?>
		    </td>
	        <td width="1%" align="left" nowrap="nowrap"><?php $_e = mBln($___Ls->ls->rw['clflj_user']); echo Spn($_e,'',$_e); ?></td>
	        <td width="1%" align="left" nowrap="nowrap"><?php $_e = mBln($___Ls->ls->rw['clflj_on']); echo Spn($_e,'',$_e); ?></td>
			<td width="1%" align="left" nowrap="nowrap"><?php $_e = mBln($___Ls->ls->rw['clflj_ntf_eml']); echo Spn($_e,'',$_e); ?></td>
			<td width="1%" align="left" nowrap="nowrap"><?php $_e = mBln($___Ls->ls->rw['clflj_ntf_sms']); echo Spn($_e,'',$_e); ?></td>
			<td width="1%" align="left" nowrap="nowrap"><?php $_e = mBln($___Ls->ls->rw['clflj_ntf_whtsp']); echo Spn($_e,'',$_e); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>  
      	</tr>
    <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
    <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>	
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
		                <?php echo HTML_inp_hd('Ftp', _SbLs_ID('i')); ?>	
						<?php    
	                        
					        $l = __Ls([ 'k'=>'sis_cl_flj_tp',                   
										'id'=>'clflj_tp',
										'v'=>'sisslc_enc',   
										'ph'=>TX_TP,
										'va'=>$___Ls->dt->rw['tp_sisslc_enc'],                             
										'cls'=>'sis_cl_flj_tp'.$___Ls->gt->tsb,
										'slc'=>[ 
											'opt'=>[
													'attr'=>[
														'itm-key'=>'key'                                                                                                                                                                                  
													]	
												] 
											]
								]);	
								
							echo $l->html; $CntWb .= $l->js;                                                                                                                                                                                                                                                                                                                                                                                                                                 
							//$CntWb .= JQ_Ls('sis_cl_flj_tp'.$___Ls->gt->tsb, TX_TP, '', '', ["cls"=>"ok"]);	    
	                        
					        $l = __Ls([ 'k'=>'sis_cl_flj',                   
										'id'=>'clflj_flj',
										'v'=>'sisslc_enc',   
										'ph'=>TX_TRA_COL_ACC,
										'va'=>$___Ls->dt->rw['flj_sisslc_enc'],                             
										'cls'=>'sis_cl_flj'.$___Ls->gt->tsb,
										'ttb'=>[
											'trgr'=>[
												'p'=>'ok'
											]
										],
										'slc'=>[ 
											'opt'=>	[
													'attr'=>[
														'itm-key'=>'key',
														'itm-trgr'=>'trgr'
													]	
												] 
											]
								]);	
								
							echo $l->html; $CntWb .= $l->js;                                                                                                                                                                                                                                                                                                                                                                                                                                
							
							//$CntWb .= JQ_Ls('sis_cl_flj'.$___Ls->gt->tsb, TX_TRA_COL_ACC, '', '', ["cls"=>"ok"]);
							echo LsUs('clflj_us','us_enc', $___Ls->dt->rw['us_enc'], '', 2); $CntWb .= JQ_Ls('clflj_us','');	
						
						?>

	          		</div>
				    <div class="col_2">
					    
						<?php echo OLD_HTML_chck('clflj_user', TX_US, $___Ls->dt->rw['clflj_user'], 'in'); ?>
						<?php echo OLD_HTML_chck('clflj_on', TX_ACTV, $___Ls->dt->rw['clflj_on'], 'in'); ?>
						<?php echo OLD_HTML_chck('clflj_ntf_eml', 'Notificación (Email)', $___Ls->dt->rw['clflj_ntf_eml'], 'in'); ?>
						<?php echo OLD_HTML_chck('clflj_ntf_sms', 'Notificación (SMS)', $___Ls->dt->rw['clflj_ntf_sms'], 'in'); ?>
						<?php echo OLD_HTML_chck('clflj_ntf_whtsp', 'Notificación (Whatsapp)', $___Ls->dt->rw['clflj_ntf_whtsp'], 'in'); ?>

				    </div>
                </div>        
		    </div>              
	    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>
