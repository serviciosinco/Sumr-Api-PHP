<?php
if(class_exists('CRM_Cnx')){
	
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->tt = _Cns('TX_VST');
	$___Ls->_strt();
	$___Ls->ino = "id_vst";
	$___Ls->ik = "vst_enc";
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_VST."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
									
	}elseif($___Ls->_show_ls == 'ok'){
		
		//$_fl = "AND vst_cnt IN(SELECT id_cnt FROM ".TB_CNT." WHERE org_enc = '{$__i}' )";
		$Ls_Whr = "	FROM  ".TB_VST."
					INNER JOIN ".TB_CNT." ON (id_cnt = vst_cnt) 
					INNER JOIN "._BdStr(DBM).TB_US."  ON (id_us = vst_us)
					WHERE ".$___Ls->ino." != '' 
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
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_OBS ?></th>
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			
			<?php do {  ?>
			
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cnt_nm'],'in'); ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['us_nm'],'in'); ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['vst_obs'],'in'); ?></td>
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
	  	<?php echo HTML_inp_hd('mdlcntvst_mdlcnt', $__i); ?>
     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	    <div class="ln_1">
          <div class="col_1">
	          <?php
		      	echo SlDt([ 'id'=>'vst_f', 'va'=>$___Ls->dt->rw['vst_f'], 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
			  	echo SlDt([ 'id'=>'vst_h', 'va'=>$___Ls->dt->rw['vst_h'], 'rq'=>'no', 'ph'=>TX_HR_FI, 'lmt'=>'no', 't'=>'hr', 'cls'=>CLS_CLND ]);    
			  	echo LsUs('vst_us','id_us', $___Ls->dt->rw['vst_us'], '', 2); $CntWb .= JQ_Ls('vst_us','');
			  
			  
			  	$l = __Ls(['k'=>'vst_est',
										'id'=>'vst_est',
										'ph'=>	TX_SLCEST,
										'va'=>$___Ls->dt->rw['vst_est']
									]);
					echo $l->html; $CntWb .= $l->js;
 
				$l1 = __Ls(['k'=>'vst_tp',
										'id'=>'vst_tp',
										'ph'=>	TX_SLCTP,
										'va'=>$___Ls->dt->rw['vst_tp']
									]);
					echo $l1->html; $CntWb .= $l1->js;
			
				$l2 = __Ls(['k'=>'Sis_SiNo',
											'id'=>'vst_rxc',
											'ph'=>	TX_RXC	,
											'va'=>$___Ls->dt->rw['vst_rxc']
									]);
					echo $l2->html; $CntWb .= $l2->js;		

				echo HTML_inp_tx('vst_dir', TX_WHR."  ".TX, ctjTx($___Ls->dt->rw['vst_dir'], 'in'));
				
				echo HTML_textarea('vst_obs', 'Observaciones', ctjTx($___Ls->dt->rw['vst_obs'], 'in'));

	          ?>
	          
          </div>
          <div class="col_2">
	      </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
