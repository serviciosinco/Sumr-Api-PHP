<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdlcnthis_dsc';
	$___Ls->_strt();    

	$___Ls->gt->idtl = Php_Ls_Cln($_GET['_idtl']);
	$__m = Php_Ls_Cln($_GET['_m']);


	$___Ls->gt->inf_s = ['550px','400px'];
	
	if(_SbLs_ID('i')){	
		$__fl .= "mdlcnthis_mdlcnt = (SELECT id_mdlcnt FROM ".TB_MDL_CNT." WHERE mdlcnt_enc = ".GtSQLVlStr($___Ls->gt->isb, "text").")"; 
	}else{ 	
		$__fl .= " mdlstp_tp = '".$___Ls->mdlstp->tp."'";	
	}				
		
	if(!isN($___Ls->gt->i)){
 
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_CNT_HIS.", ".TB_MDL_CNT.", ".TB_MDL." 
						   WHERE mdlcnt_mdl = id_mdl AND
						   		 mdlcnthis_mdlcnt = id_mdlcnt AND 
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM ".TB_MDL_CNT_HIS."
						INNER JOIN ".TB_MDL_CNT." ON (mdlcnthis_mdlcnt = id_mdlcnt)
						INNER JOIN ".TB_MDL." ON (mdlcnt_mdl = id_mdl) 
						INNER JOIN "._BdStr(DBM).TB_US." ON (mdlcnthis_us = id_us)
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON (mdlcnthis_tp = id_sisslc)
						INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
				   WHERE id_mdlcnthis != '' AND $__fl ".$___Ls->sch->cod." 
				   ORDER BY mdlcnthis_fi DESC, mdlcnthis_hi DESC";
				   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

	} 
	
	$___Ls->_bld();
			
	if(!isN($___Ls->gt->isb)){ $__dt_cnt = GtMdlCntDt([ 'id'=>$___Ls->gt->isb, 'shw'=>[ 'cnt'=>'ok' ] ]); }

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php //$___Ls->_bld_l_hdr();?>

<br>
<?php if(_SbLs_ID('i')){ ?>
<div class="<?php echo ID_HDRLS ?> lead_history_list">
	<div class="btn">
		
		<button id="_INRG_Tel_SbCnt" class="_anm" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_his_tel.svg);" class="_tel"></button>
		<button id="_INRG_Mail_SbCnt" class="_anm" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_his_mail.svg);" class="_mail"></button> 
		<button id="_INRG_Vst_SbCnt" class="_anm" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_his_vst.svg);" class="_visit"></button>
	  
	</div>
  <?php 
	  	$CntWb .= '
			
			$("#_INRG_Mail_SbCnt").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
			    	e.stopPropagation(); return;
				}else{
					_ldCnt({ 
						u:\''.FL_LS_GN.__t($___Ls->tp, true)._SbLs_ID()._SbLs_Vst().TXGN_ING.Fl_i($___Ls->gt->i).'&_m=131&__rnd=bcf'.$___Ls->bx_rld.$___Ls->ls->vrall.'\',
						c:\''.$___Ls->bx_rld.'\',
						pop:\'ok\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					});
				} 

			});
			
			
			$("#_INRG_Tel_SbCnt").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
			    	e.stopPropagation(); return;
				}else{
					_ldCnt({
						u:\''.FL_LS_GN.__t($___Ls->tp, true)._SbLs_ID()._SbLs_Vst().TXGN_ING.Fl_i($___Ls->gt->i).'&_m=130&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'\',
						c:\''.$___Ls->bx_rld.'\',
						pop:\'ok\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					}); 
				}
					
			});
			
			$("#_INRG_Vst_SbCnt").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
			    	e.stopPropagation(); return;
				}else{
					_ldCnt({ 
						u:\''.FL_LS_GN.__t($___Ls->tp, true)._SbLs_ID()._SbLs_Vst().TXGN_ING.Fl_i($___Ls->gt->i).'&_m=132&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'&Rd=\'+Math.random(),
						c:\''.$___Ls->bx_rld.'\',
						pop:\'ok\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					}); 
				}	
				
			});
			
			$(".whtp").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
			    	e.stopPropagation(); return;
				}else{
					_ldCnt({ 
						u:\''.FL_DT_GN.__t('mdl_cnt_his_whtp', true)._SbLs_ID()._SbLs_Vst().TXGN_ING.Fl_i($___Ls->gt->i).'&_m=995&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'&Rd=\'+Math.random(),
						c:\''.$___Ls->bx_rld.'\',
						pop:\'ok\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					}); 
				}	
				
			});
		'; 

	?>
</div>
<style>
	
	.lead_history_list{}
	.lead_history_list .btn{ }
	.lead_history_list .btn button{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 2px solid #383e40; background-size: auto 50%; background-repeat: no-repeat; background-position: center center; width: 40px; height: 40px; opacity: 0.2; cursor: pointer; margin-right: 6px; }
	.lead_history_list .btn button:hover{ opacity: 0.5; }
	.whtp{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>whatsapp.svg);width: 15px;height: 15px;display: inline-block;vertical-align: middle;background-position: top center; }
</style>

<?php }else{
		$___Ls->_bld_l_hdr(); 
} ?>

<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <thead>
        <tr>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_GSTN ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_ACCN?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_HUR; ?></th>
            <th width="5%" <?php echo NWRP ?>><?php echo TX_DSCRIP ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
            
        </tr>
  </thead>
  <tbody>

	 	<?php do { ?>
        <tr>    
	        <td width="1%" align="left"><?php echo ShortTx(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'),10,'Pt', true) ; ?></td>
	        <td width="15%" align="left">
		        <?php  if($___Ls->ls->rw['id_sisslc'] == 995 ){ ?><span class="whtp"></span><?php }; ?>
		        <?php echo ctjTx($___Ls->ls->rw['sisslc_tt'],'in'); ?>
		    </td>
	        <td width="15%" align="left"><?php echo Spn($___Ls->ls->rw['mdlcnthis_fi'],'','_f').HTML_BR.Spn($___Ls->ls->rw['mdlcnthis_hi'],'','_h'); ?></td>
	        <td width="15%" align="left"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlcnthis_dsc'],'in'),70,'Pt', true); ?></td>
	        <td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl' ]); ?></td>
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
  <div id="<?php  echo DV_GNR_FM ?>" class="<?php echo DV_GNR_FM_BX ?> lead_history_detail">

    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?>   

	  	
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  	
		  	<div class="ln_1 <?php if($___Ls->gt->idtl=='ok'){ echo '_shwd'; } ?>">
			  	
			  	
			  	<?php if($___Ls->gt->cll == 'ok'){ ?>
					<div class="__gst_rmbm"> <span class="_icn"></span> Ingresa las conclusiones o el resumen de tu llamada</div>
					<?php $CntWb .= " $('.__gst_rmbm').fadeIn().delay(10000).toggle('drop'); "; ?>
				<?php } ?>
								
								
	            <div class="col_1">
	          		<ul class="__dt">
	                	<li><?php echo Strn(TX_PRG).': '.$__dt_cnt->apr->tt; ?></li>
	                    <li><?php echo Strn(TT_FM_NM).': '.$__dt_cnt->cnt->nm.' '.$__dt_cnt->cnt->ap; ?></li>
	                    <li><?php echo Strn(TT_FM_ID).': '.$__dt_cnt->cnt->dc; ?></li>
	                    <li><?php //echo Strn(TT_FM_EML).': '.$__dt_cnt->cnt->eml[0]; ?></li>
	                    <li><?php //echo Strn(TT_FM_TEL).': '.$__dt_cnt->cnt->tel[0]; ?></li>
	                    <li><?php echo Strn(TT_FM_CRG).': '.$__dt_cnt->cnt->crg; ?></li>
	                    <li><?php echo Strn(TT_FM_EMP).': '.$__dt_cnt->cnt->em; ?></li>
	                    <li><?php echo Strn(TT_FM_PRF).': '.$__dt_cnt->cnt->prf; ?></li>
	                    <li><?php echo Strn(TX_F).': '.$__dt_cnt->cnt->fi; ?></li>
	                    <li><?php echo Strn(TX_HR).': '.$__dt_cnt->cnt->hi.HTML_BR; ?></li>
	                    <li><?php echo Strn(TT_FM_CMN).': '.HTML_BR.$__dt_cnt->cnt->cmn; ?></li>
	               </ul>
	            </div>
	            <div class="col_2">
					<?php echo HTML_inp_hd('___t', $__prfx->prfx3_c); ?>                                                    
	                <input id="mdlcnthis_mdlcnt" name="mdlcnthis_mdlcnt" type="hidden" value="<?php echo $___Ls->gt->isb; ?>" />
	                <?php if($___Ls->dt->tot > 0){  $__f = $___Ls->dt->rw['mdlcnthis_fi']; $__h = $___Ls->dt->rw['mdlcnthis_hi']; }else{ $__f = date('Y-m-d'); $__h = date('H:i:s'); }  ?>
	                <?php if($___Ls->dt->rw['mdlcnthis_tp'] != ''){ $__m = $___Ls->dt->rw['mdlcnthis_tp']; }else{ $__m = Php_Ls_Cln($_GET['_m']); } ?>
	                
					<?php 
						$l = __Ls([ 'k'=>'his_tp', 'id'=>'mdlcnthis_tp', 'va'=>(!isN($__m)?$__m:$___Ls->dt->rw['mdlcnthis_tp']) , 'ph'=>TX_ACCN ]); 
						echo $l->html; $CntWb .= $l->js; ?> 						
					<?php 
						
						if($___Ls->dt->tot > 0 && $___Ls->gt->cll != 'ok'){ 
							$_dsc = $___Ls->dt->rw['mdlcnthis_dsc'];
						}else{
							$_dsc = '';
						}
							
						echo HTML_textarea('mdlcnthis_dsc', TX_CON_DSC, ctjTx($_dsc,'in'), '', 'ok'); 
						
						$CntWb .= "	
									if(jQuery().SUMR_Record){	
										$('#mdlcnthis_dsc').SUMR_Record(); 
									}";
						
						
						
					?> 	
											
											
	            </div>
        	</div> 


        </div>
                    
    </form>
  </div>

</div>
<style>
	
	.lead_history_detail .ln_1:not(._shwd) .col_1{ display: none; }
	.lead_history_detail .ln_1:not(._shwd) .col_2{ width: 100%; }

</style>
<?php } ?>
<?php } ?>
