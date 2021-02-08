<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'_cl.cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT *,
										AES_DECRYPT(clftp_pssw, '".ENCRYPT_PASSPHRASE."') AS __pss
										
								FROM ".TB_CL_FTP."
									INNER JOIN "._BdStr(DBM).TB_CL." ON _cl.id_cl = clftp_cl
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM ".TB_CL_FTP."
						INNER JOIN "._BdStr(DBM).TB_CL." ON _cl.id_cl = clftp_cl
					WHERE _cl.cl_enc != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_clftp DESC";
				   
		$___Ls->qrys = "SELECT  *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
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
	        <th width="10%" <?php echo NWRP ?>><?php echo TX_NM?></th>   
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_TP?></th>
	        <!--<th width="1%" <?php echo NWRP ?>><?php echo TX_TP?></th>-->
	        <th width="1%" <?php echo NWRP ?>></th>
	        
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clftp_nm'],'in'),50); ?></td>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['clftp_hst'],'','_f'); ?></td> 
	        <!---<td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['clftpsvc_rmte'],'','_f'); ?></td> -->
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
						<?php echo HTML_inp_tx('nm', TX_NM, ctjTx($___Ls->dt->rw['clftp_nm'],'in'), FMRQD); ?>      
                        <?php echo HTML_inp_tx('hst',TX_HST, ctjTx($___Ls->dt->rw['clftp_hst'],'in'), FMRQD); ?> 
                        <?php echo HTML_inp_tx('prt', TX_PRTO, ctjTx($___Ls->dt->rw['clftp_prt'],'in'), FMRQD); ?>
                        <?php echo HTML_inp_tx('psv', TX_PRTO, ctjTx($___Ls->dt->rw['clftp_psv'],'in'), FMRQD); ?> 
                        <?php echo HTML_inp_tx('tmout', TX_TMOT, ctjTx($___Ls->dt->rw['clftp_tmout'],'in'), FMRQD);?> 
                        <?php    
	       		        
							/*	       		        
					        $l = __Ls([ 'k'=>'cl_ftp_svc',                   
										'id'=>'ftp_svc',
										'v'=>'sisslc_enc',   
										'ph'=>TX_TPR,
										'va'=>$___Ls->dt->rw['clftpsvc_tp'],                             
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
							
							*/
						?>
						<?php //echo HTML_inp_tx('pth', TX_RTA, ctjTx($___Ls->dt->rw['clftpsvc_pth'],'in'), FMRQD);?> 
						<?php //echo HTML_inp_tx('rmte', TX_RMT, ctjTx($___Ls->dt->rw['clftpsvc_rmte'],'in'), FMRQD);?> 
	          	    </div>
					<div class="col_2">
						<?php echo HTML_inp_tx('usr', TX_USR, ctjTx($___Ls->dt->rw['clftp_usr'],'in'), FMRQD); ?> 
						<input id="pssw" name="pssw" autocomplete="off" type="password" placeholder="<?php echo TX_PSSW; ?>" value="<?php echo ctjTx($___Ls->dt->rw['__pss'],'in'); ?>" class="<?php echo FMRQD; ?>" />
						
					</div>
                </div>        
		    </div>              
	    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>
