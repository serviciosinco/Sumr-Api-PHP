<?php
if(class_exists('CRM_Cnx')){
	
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->tt = _Cns('TT_FM_CD');
	$___Ls->_strt();
	$___Ls->ino = "id_cntcd";
	$___Ls->ik = "cntcd_enc";
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *,
									  "._QrySisSlcF([ 'als'=>'r', 'als_n'=>'relacion' ]).",
									  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'relacion', 'als'=>'r' ])."
								FROM  ".TB_CNT_CD."
									  ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cntcd_rel', 'als'=>'r' ])."
								WHERE ".$___Ls->ik." = %s
								LIMIT 1" , GtSQLVlStr($___Ls->gt->i, "text"));
																
	}elseif($___Ls->_show_ls == 'ok'){
		
				//$_fl = "AND vst_cnt IN(SELECT id_cnt FROM ".TB_CNT." WHERE org_enc = '{$__i}' )";
		$Ls_Whr = "	FROM  ".TB_CNT_CD."
		
						INNER JOIN ".TB_CNT." ON id_cnt = cntcd_cnt
						
						INNER JOIN "._BdStr(DBM).MDL_SIS_CD_BD." ON id_siscd = cntcd_cd
						INNER JOIN "._BdStr(DBM).MDL_SIS_CD_DP_BD." ON id_siscddp = siscd_dp
						INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON id_sisps = siscddp_ps
						
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON id_sisslc = cntcd_rel

					WHERE ".$___Ls->ino." != ''  AND cnt_enc = '".$__i."'
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
			    <th width="20%" <?php echo NWRP ?>><?php echo TX_PSS1?></th>
			    <th width="20%" <?php echo NWRP ?>><?php echo TX_DEPTO?></th>
			    <th width="20%" <?php echo NWRP ?>><?php echo TT_FM_CD ?></th>
			    <th width="20%" <?php echo NWRP ?>><?php echo TX_TPR ?></th>
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			
			<?php do {  ?>
			
		  		<tr>  
					<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
					<td width="20%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['sisps_tt'],'in'); ?></td>
					<td width="20%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['siscddp_tt'],'in'); ?></td>
				    <td width="20%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['siscd_tt'],'in'); ?></td>
				    <td width="20%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['sisslc_tt'],'in'); ?></td>
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
	  	
	  	<?php echo HTML_inp_hd('cntcd_cnt', $___Ls->gt->isb); ?>
	  	
     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	    <div class="ln_1">
          <div class="col_1">
			  	
			  	<?php
		        	echo LsCdOld([ 'id'=>'cntcd_cd', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['cntcd_cd'], 'rq'=>2, 'mlt'=>'no' ]);
					$CntWb .= JQ_Ls('cntcd_cd',FM_LS_SLCD); 
				?>
	          
          </div>
          <div class="col_2">
	          
	          <?php
		          
		        $__tprl = json_decode($___Ls->dt->rw['___relacion']);
		        
		        if($__tprl->vl != 'nco'){  
		        
			        $l = __Ls(['k'=>'tprlcc',
								'id'=>'cntcd_rel',
								'ph'=>TX_TPR,
								'va'=>$___Ls->dt->rw['cntcd_rel'],
								'cls'=>'cntcd_rel'.$___Ls->gt->tsb,
								'slc'=>[ 
									'opt'=>[
											'attr'=>[
												'itm-key'=>'key'
											]	
										] 
									]
						]);
										
					echo $l->html;
					
					$CntWb .= JQ_Ls('cntcd_rel'.$___Ls->gt->tsb, TX_SLC_CLG, '', '', ["cls"=>"ok"]);
				
				} else{
					
					echo HTML_inp_hd('cntcd_rel', $___Ls->dt->rw['cntcd_rel']);
				}
		          
	          ?>
	          
	            
			
	      </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>

