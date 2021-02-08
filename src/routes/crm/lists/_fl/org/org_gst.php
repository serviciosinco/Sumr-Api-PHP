<?php 
if(class_exists('CRM_Cnx')){
		
	$___Ls->tt = _Cns('TX_GST');
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'orggst_dsc';
	
	$___Ls->_strt();    
	$___Ls->gt->idtl = Php_Ls_Cln($_GET['_idtl']);
	$__m = Php_Ls_Cln($_GET['_m']);
	$___Ls->gt->inf_s = ['550px','400px'];


	if(!isN($___Ls->gt->i)){	
 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_ORG_GST."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){
		
		
		$_fl = "AND orggst_org IN(SELECT id_org FROM  "._BdStr(DBM).TB_ORG." WHERE org_enc = '{$__i}' )";
		$Ls_Whr = "FROM ".TB_ORG_GST." 
					".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orggst_tp', 'als'=>'t'])."
					INNER JOIN ".DBM.".	".TB_US." ON (id_us =  orggst_us)
					WHERE id_orggst != '' $_fl
				    ORDER BY  id_orggst DESC";
		$___Ls->qrys = "SELECT *,
					".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t']).", 
					(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
		
	} 

	$___Ls->_bld(); 
			
	if(!isN($___Ls->gt->isb)){ $__dt_cnt = GtMdlCntDt([ 'id'=>$___Ls->gt->isb ]); }

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
		'; 

	?>
</div>
<style>
	
	.lead_history_list{}
	.lead_history_list .btn{ }
	.lead_history_list .btn button{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 2px solid #383e40; background-size: auto 50%; background-repeat: no-repeat; background-position: center center; width: 40px; height: 40px; opacity: 0.2; cursor: pointer; margin-right: 6px; }
	.lead_history_list .btn button:hover{ opacity: 0.5; }
</style>

<?php }else{
		$___Ls->_bld_l_hdr(); 
} ?>

<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <thead>
        <tr>
            <th width="50%"><?php echo TX_DSCRIP ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_US?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_DTE ?></th>
        </tr>
  </thead>
  <tbody>

	 	<?php do { ?>
        <tr>    
	        <td width="50%" align="left" ><?php echo Spn($___Ls->ls->rw['orggst_dsc'],'','_f'); ?></td>  
	        <td width="15%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['us_nm']." ".$___Ls->ls->rw['us_ap'],'','_f'); ?></td>  
			<td width="15%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['tp_sisslc_tt'],'in'); ?></td>
			<td width="15%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['orggst_fi'],'','_f'); ?></td>
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
	            <div class="col_1">
	            </div>
	            <div class="col_2">
		            <?php
			            echo HTML_inp_hd('orggst_org', $__i);                                                  
						if($___Ls->dt->tot > 0){  $__f = $___Ls->dt->rw['mdlcnthis_fi']; $__h = $___Ls->dt->rw['mdlcnthis_hi']; }
						$l = __Ls([ 'k'=>'his_tp', 'id'=>'orggst_tp', 'va'=>(!isN($__m)?$__m:$___Ls->dt->rw['orggst_tp']), 'ph'=>TX_ACCN ]); 
						echo $l->html; $CntWb .= $l->js;				
						echo HTML_textarea('orggst_dsc', TX_CON_DSC, ctjTx($___Ls->dt->rw['orggst_dsc'],'in'), '', 'ok'); 
					?> 	
	            </div>
        	</div> 


        </div>
                    
    </form>
  </div>
</div>
<style>
	
	.lead_history_detail .ln_1:not(._shwd) .col_1{ display: none;}
	.lead_history_detail .ln_1:not(._shwd) .col_2{ width: 100%; }

</style>
<?php } ?>
<?php } ?>
