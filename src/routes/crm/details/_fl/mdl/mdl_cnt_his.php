<?php
if(class_exists('CRM_Cnx')){

	
	if(!isN($___Dt->gt->i)){ $__fl .= sprintf(" AND mdlcnthis_enc = %s ", GtSQLVlStr($___Dt->gt->i, "text")); }
	if(!isN($___Dt->gt->isb)){ $__fl .= sprintf(" AND mdlcnt_enc = %s ", GtSQLVlStr($___Dt->gt->isb, "text")); }
	
	
	$Dt_Qry = sprintf("	SELECT * 
						FROM ".TB_MDL_CNT_HIS."
							 INNER JOIN ".TB_MDL_CNT." ON mdlcnthis_mdlcnt = id_mdlcnt
							 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnthis_us = id_us
						WHERE id_mdlcnthis != '' $__fl
						ORDER BY id_mdlcnthis DESC");
						
	$Ls_Rg = $__cnx->_qry($Dt_Qry); 
	
	if($Ls_Rg){
		
		$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
		
		if($Tot_Ls_Rg > 0){
?>

			<?php do { $_dtl_dte = '';?>
				
				<?php $__cll_dt = GtMdlCntCll([ 'id'=>$row_Ls_Rg['id_mdlcnthis'],'tp'=>'his' ]); ?>
				
				<div class="__ls_pop">
				    <p><?php echo strip_tags(ctjTx($row_Ls_Rg['mdlcnthis_dsc'],'in')); ?></p>
					<?php 
						
						$_dtl_dte .= li(Spn('','','_pnl_icn _pnl_icn_us'). Strn(ctjTx($row_Ls_Rg['us_nm'].' '.$row_Ls_Rg['us_ap'],'in')));
				    	$_dtl_dte .= li(Spn('','','_pnl_icn _pnl_icn_tme'). Spn($row_Ls_Rg['mdlcnthis_fi']).' / '. Spn($row_Ls_Rg['mdlcnthis_hi'],'','_f')); 
				    	  	
				    	if($row_Ls_Rg['mdlcnthis_fa'] != ''){ 
					    
					    	$_dtl_dte .= li(TX_FA.': '. Spn($row_Ls_Rg['mdlcnthis_fa']).' / '. Spn($row_Ls_Rg['mdlcnthis_ha'])); 
					   	
					   	}
					    	
						echo ul($_dtl_dte);
					?> 
					
					
					<?php if($__cll_dt->call->audio->e == 1 &&_ChckMd('call_chk')){ ?>
						<audio preload="auto" id="audio-1" class="phis_audio" controls>
							<source src="<?php echo $__cll_dt->call->audio->f ?>">
						</audio>
						<?php 
							$CntWb .= '
								SUMR_Main.ld.f.mp3(function(){
									$(\'.phis_audio\').audioPlayer();
								});
										
							';
						?>
					<?php } ?>
				
				</div>
			
			<?php } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); ?>
		
		<?php } ?>
		
	<?php } ?> 
	
	
	<style>
		
		.__ls_pop{ width:80%; }
		.__ls_pop .audioplayer{ margin-top: 20px; }
		
			
	</style>
		
		
<?php $Ls_Rg->free; 
} 
?>