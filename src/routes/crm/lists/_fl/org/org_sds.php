<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = _Cns('TX_SDS');
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_ORG_SDS."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
									
	}elseif($___Ls->_show_ls == 'ok'){
		
		$_fl = "AND orgsds_org IN(SELECT id_org FROM ".TB_ORG." WHERE org_enc = '{$__i}' )";

		$Ls_Whr = "	FROM ".TB_ORG_SDS." 
						 INNER JOIN ".TB_ORG." ON id_org = orgsds_org 
					     INNER JOIN ".MDL_SIS_CD_BD." ON  id_siscd = orgsds_cd 
					WHERE ".$___Ls->ino." != '' $_fl ".$___Ls->sch->cod." 
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
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_SDS ?></th>
			       <th width="5%" <?php echo NWRP ?>><?php echo TT_FM_CD ?></th>
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
			    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['orgsds_nm'],'in'); ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['siscd_tt'],'in'); ?></td>
				    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
	}
	$___Ls->_h_ls_nr(); 
} ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb organization_sedes">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	<?php 
	  	$___Ls->_dvlsfl_all([
			['n'=>'etd', 't'=>'org_sds_etd', 'l'=>TX_ETDS],
			['n'=>'zna', 't'=>'org_sds_zna', 'l'=>TX_ZNS]
		],[
			'idb'=>'ok'
		]);
	?>
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		 	
		 	
		 	
		<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels TbGnrl mny  <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
          	<ul class="TabbedPanelsTabGroup">
	            <?php echo $___Ls->tab->bsc->l ?>
	            <?php if($___Ls->gt->tsb == 'clg'){ echo $___Ls->tab->etd->l; } ?>
	            <?php echo $___Ls->tab->zna->l ?>
          	</ul>
		  	<div class="TabbedPanelsContentGroup">
            	<div class="TabbedPanelsContent">
					<div class="ln_1">  	
					
						<div class="col_1">
							<?php echo HTML_inp_hd('orgsds_org', $__i); ?>
							<?php echo HTML_inp_tx('orgsds_nm', TX_NM , ctjTx($___Ls->dt->rw['orgsds_nm'],'in'), FMRQD); ?>
							<?php echo HTML_inp_tx('orgsds_dir', TX_DIRC , ctjTx($___Ls->dt->rw['orgsds_dir'],'in'), ''); ?>
							<?php 
								echo LsCdOld(['id'=>'orgsds_cd', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['orgsds_cd'], 'rq'=>1 ]);
								$CntWb .= JQ_Ls('orgsds_cd',FM_LS_SLCD);  
								
								echo LsUs('orgsds_rsp','id_us', $___Ls->dt->rw['orgsds_rsp'], '', 2); 
								$CntWb .= JQ_Ls('orgsds_rsp','');
								
								
								 
								
								if($___Ls->gt->tsb == 'clg'){ 
									
									echo h2(Spn('','','_tt_icn _tt_icn_chck' ).MDL_CHCK.HTML_BR.HTML_BR.HTML_BR. TX_JRND);
									                                          
									echo OLD_HTML_chck('orgsds_jrd_mna', TX_MRNG, $___Ls->dt->rw['orgsds_jrd_mna'] );
									echo OLD_HTML_chck('orgsds_jrd_trd', TX_EVNG, $___Ls->dt->rw['orgsds_jrd_trd'] );
									echo OLD_HTML_chck('orgsds_jrd_nch', TX_NGHT, $___Ls->dt->rw['orgsds_jrd_nch'] );
									echo OLD_HTML_chck('orgsds_jrd_cmp', TX_CMPLT, $___Ls->dt->rw['orgsds_jrd_cmp'] );
									echo OLD_HTML_chck('orgsds_jrd_sbt', TX_STRD, $___Ls->dt->rw['orgsds_jrd_sbt'] );
									echo OLD_HTML_chck('orgsds_jrd_unc', TX_ONLY, $___Ls->dt->rw['orgsds_jrd_unc'] );
									echo OLD_HTML_chck('orgsds_jrd_con', TX_CNTNS, $___Ls->dt->rw['orgsds_jrd_con'] );
									
								}
							?>
			            </div>
						<div class="col_2">
				          
				        <?php 
					           
					        	if($___Ls->gt->tsb == 'clg'){ 
						        	                                          
									echo OLD_HTML_chck('orgsds_jrd_mna', TX_MRNG, $___Ls->dt->rw['orgsds_jrd_mna'] );
								

					           
						           echo LsOrgSdsCln(['id'=>'orgsds_cln', 'v'=>'id_orgsdscln', 'va'=>$___Ls->dt->rw['orgsds_cln'], 'rq'=>1 ]);
								   $CntWb .= JQ_Ls('orgsds_cln',FM_LS_SLCD);
						           
						           
						           echo LsOrgSdsSx(['id'=>'orgsds_sx', 'v'=>'id_orgsdssx', 'va'=>$___Ls->dt->rw['orgsds_sx'], 'rq'=>1 ]);
								   $CntWb .= JQ_Ls('orgsds_sx',FM_LS_SLCD);
								   
								   echo Ls_Grd('orgsds_grd', 'unikey', $___Ls->dt->rw['orgsds_grd'], '- Seleccione ultimo grado -','2'); 
								   $CntWb .= JQ_Ls('orgsds_grd','');
					            }
					           
					           
								echo LsOrgSdsEst(['id'=>'orgsds_est', 'v'=>'id_orgsdsest', 'va'=>$___Ls->dt->rw['orgsds_est'], 'rq'=>1 ]);
								$CntWb .= JQ_Ls('orgsds_est',FM_LS_SLCD);
						
							   
								echo h2(HTML_BR.HTML_BR.HTML_BR. TX_GLCTN);
							   
								echo HTML_inp_tx('orgsds_g_lat', 'Latitud' , ctjTx($___Ls->dt->rw['orgsds_g_lat'],'in'), '');
								echo HTML_inp_tx('orgsds_g_lng', 'Longitud' , ctjTx($___Ls->dt->rw['orgsds_g_lng'],'in'), '');
								echo HTML_inp_tx('orgsds_g_zom', 'Zoom' , ctjTx($___Ls->dt->rw['orgsds_g_zom'],'in'), '');
								echo HTML_inp_tx('orgsds_g_pov_lat', 'Streetview Latitud' , ctjTx($___Ls->dt->rw['orgsds_g_pov_lat'],'in'), '');
								echo HTML_inp_tx('orgsds_g_pov_lon', 'Streetview Longitud' , ctjTx($___Ls->dt->rw['orgsds_g_pov_lon'],'in'), '');
								echo HTML_inp_tx('orgsds_g_pov_hed', 'Streetview Head' , ctjTx($___Ls->dt->rw['orgsds_g_pov_hed'],'in'), '');
								echo HTML_inp_tx('orgsds_g_pov_ptc', 'Streetview Pitch' , ctjTx($___Ls->dt->rw['orgsds_g_pov_ptc'],'in'), '');
								echo HTML_inp_tx('orgsds_g_pov_zom', 'Streetview Zoom' , ctjTx($___Ls->dt->rw['orgsds_g_pov_zom'],'in'), '');
							  
							   
							?>
			
			          	</div>
					
					</div>    
            	</div>
				
				<?php if($___Ls->gt->tsb == 'clg'){ ?>
					
				<div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->etd->d ?>
	            </div>
	            
	            <?php } ?>
	            
	            <div class="TabbedPanelsContent">
					<?php echo $___Ls->tab->zna->d ?>
	            </div> 

          	</div>
          
          <?php include(DIR_EXT.'org_sds_css.php'); ?> 
        </div>
		
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
