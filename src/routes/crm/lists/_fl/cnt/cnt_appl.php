<?php
if(class_exists('CRM_Cnx')){
	
	//Cnt_Appl

	$___Ls->sch->f = 'id_cntappl';
	
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 700;

	$___Ls->cnx->cl = 'ok';
	$___Ls->dwn = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT * FROM ".TB_CNT_APPL."
								WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		if( !isN($__i) ){ 
			$_fl .= " AND cntappl_cnt IN ( SELECT mdlcnt_cnt FROM ".TB_MDL_CNT." WHERE mdlcnt_enc = '".$__i."' ) "; 
			$_fl .= " AND cntappl_mdl IN ( SELECT mdlcnt_mdl FROM ".TB_MDL_CNT." WHERE mdlcnt_enc = '".$__i."' ) ";
		}

		$Ls_Whr = "FROM ".TB_CNT_APPL."
						/*".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplattr_attr', 'als'=>'t'])."*/
						INNER JOIN ".TB_CNT." ON cntappl_cnt = id_cnt
						INNER JOIN ".TB_MDL." ON cntappl_mdl = id_mdl
						WHERE id_cntappl != '' $_fl ".$___Ls->sch->cod."
						ORDER BY id_cntappl DESC";
		$___Ls->qrys = "SELECT *,
						/*".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t']).",*/
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
		//echo $___Ls->qrys;
	}

	$___Ls->_bld();
	
	//$___Ls->tp = "cnt_appl_attr";
	
?>

<?php if($___Ls->ls->chk=='ok'){

	$__blq = 'off'; ?>
	<?php $___Ls->_bld_l_hdr(); ?>

	<?php if(($___Ls->qry->tot > 0)){ ?>
		
		<?php 
			$CntJV .= "
		
				$('.chck_act').click(function() {  
					
					if($(this).is(':checked')) { var est = 'ok'; } else { var est = 'no'; }  
					var id_chck = $(this).attr('rel');

					swal({ 
						title: '".TX_ETSGR."',              
						text: '".TX_SWAL_SVE."!',  
						type: 'warning',                        
						showCancelButton: true,                 
						confirmButtonClass: 'btn-danger',       
						confirmButtonText: '".TX_YSV."',      
						confirmButtonColor: '#8fb360',          
						cancelButtonText: '".TX_CNCLR."',           
						closeOnConfirm: true 
					},
					function(isConfirm){ 
						if (isConfirm) {
							_Rqu({ 
								t:'cnt_appl_est', 
								d:'cnt_appl_est',
								est: est,
								_id_mdl : '".$___Ls->ls->rw['cntappl_mdl']."',
								_id_cnt : '".$___Ls->gt->isb."',
								_id_chck: id_chck,
								_cl:function(_r){
									if(!isN(_r)){	
										swal('Exitoso!', 'El proceso fue exitoso', 'success');	
										
										if(est == 'ok'){ 
											$('#RgTr_'+id_chck).removeClass('actv2'); 
										}else{ 
											$('#RgTr_'+id_chck).addClass('actv2');	
										}
									}
								} 
							}); 
						} else {
							$('#cntappl_chck'+id_chck).attr('checked',false);
						}
					});	    
				});	
			";	
		
		?>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<thead>
		        <tr>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_ID; ?></th>
					<th width="10%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>
					<th width="55%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
					<th width="10%" <?php echo NWRP ?>><?php echo 'ID Aplicación'; ?></th>
		            <th width="10%" <?php echo NWRP ?>><?php echo 'ID Contrato'; ?></th>
					<th width="10%" <?php echo NWRP ?>><?php echo 'Modulo'; ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_ACTV ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
		        </tr>
			</thead>
			<tbody>
				<?php do { ?>
		        <tr id="RgTr_<?php echo $___Ls->ls->rw[$___Ls->ik]; ?>" class="actv<?php echo $___Ls->ls->rw['cntappl_est']; ?>">
					<td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['id_cntappl'], 'in'); ?></td>
					<td width="10%" align="left" nowrap="nowrap"><?php echo Spn( ctjTx($___Ls->ls->rw['cntappl_fi'], 'in') ,'','_f'); ?></td>
					<td width="55%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['cnt_nm'].' '.$___Ls->ls->rw['cnt_ap'], 'in'); ?></td>
					<td width="10%" align="left" nowrap="nowrap"><?php echo Spn( ctjTx($___Ls->ls->rw['cntappl_idappl'], 'in') ,'','_f'); ?></td>
		        	<td width="10%" align="left" nowrap="nowrap"><?php echo Spn( ctjTx($___Ls->ls->rw['cntappl_idcntrc'], 'in') ,'','_f'); ?></td>
					<td width="10%" align="left" nowrap="nowrap"><?php echo Spn( ctjTx($___Ls->ls->rw['mdl_nm'], 'in') ,'','_f'); ?></td>
					<td width="1%" align="left" <?php echo $_clr_rw ?>>
						<?php 
							echo OLD_HTML_chck('cntappl_chck'.$___Ls->ls->rw[$___Ls->ik], '' , $___Ls->ls->rw['cntappl_est'], 'in', ['c'=>'chck_act', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik] ]] );  
						?> 	
					</td>
					<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
		        </tr>
		        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		        <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
		  	</tbody>
		</table>
		<style>
				tr.actv2 {
				    background-color: #fbcbcb !important;
				}
		</style>
		<?php $___Ls->_bld_l_pgs(); ?>
	
	
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
	
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>

<?php 
	
	$__appl_g = $___Ls->_dvls([ 'id'=>'sgm_var', 'i'=>$_GET['_i'], 't'=>'cnt_appl_attr' ]);
	
?>
<div class="FmTb __cnt_appl_detail">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >

	<?php 

		$__tabs_appl_tabs = __LsDt([ 'k'=>'tabs_appl', 'cl'=>$___Ls->cl->id ]);
	
		foreach($__tabs_appl_tabs->ls->tabs_appl as $_k_tabs_ord => $_v_tabs_ord){
			$_org_tabs_ord[$_v_tabs_ord->ord->vl] = $_v_tabs_ord;
		}
		
		ksort($_org_tabs_ord); //Ordenar tabs

		$__tabs = array();	
       		
   		if(!isN($_org_tabs_ord)){
			
			$__tabs[] = ['n'=>'bsc', 'l'=>TX_INIC];
			$__tabs[] = ['n'=>'cntrc', 'l'=>'PDFs', 't'=>'cnt_appl_cntrc'];
				
			foreach($_org_tabs_ord as $_k_tabs => $_v_tabs){
				
				$__tabs[] = ['n'=>$_v_tabs->key->vl, 'l'=>$_v_tabs->tt, 't'=>$_v_tabs->rel->vl, 't3'=>$_v_tabs->key->vl, 'bimg'=>$_v_tabs->img];
				
			}
		}


		$___Ls->_dvlsfl_all($__tabs,[ 'idb'=>'ok'  ]);
		$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
		$CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";  
		
	?> 
	
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      	<?php $___Ls->_bld_f_hdr(); ?>

	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php //echo DV_GNR_FM_CMP ?>">
			
			<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
				
				<ul class="TabbedPanelsTabGroup">
		            <?php echo $___Ls->tab->bsc->l; ?>
		            <?php 
			            
				        	if(!isN($_org_tabs_ord)){
							
							foreach($_org_tabs_ord as $_k_tabs => $_v_tabs){
								if($_v_tabs->est->vl == 1){
									echo $___Ls->tab->{$_v_tabs->key->vl}->l;
								}	
							}
						
						}
			        
			        ?>
			        <?php echo $___Ls->tab->cntrc->l; ?>
	            </ul>
	            
	            <div class="TabbedPanelsContentGroup">
					<div class="TabbedPanelsContent _main">			
						<div class="ln_1 lft">
					        <div class="col_1">
						    	<?php echo HTML_inp_tx('cntappl_idappl', 'ID Aplicación', ctjTx($___Ls->dt->rw['cntappl_idappl'],'in'), ''); ?>    
						    	<?php echo HTML_inp_tx('cntappl_idcntrc', 'ID Contrato', ctjTx($___Ls->dt->rw['cntappl_idcntrc'],'in'), ''); ?>
					        </div>	
					        <div class="col_2">
								<?php echo OLD_HTML_chck('cntappl_est', TX_ACTV, $___Ls->dt->rw['cntappl_est'], 'in'); ?>
							</div>		
						</div>
					</div>
					
					<?php 
						if(!isN($_org_tabs_ord)){	
							foreach($_org_tabs_ord as $_k_tabs => $_v_tabs){
								if($_v_tabs->est->vl == 1){
									echo "<div class='TabbedPanelsContent'>".$___Ls->tab->{$_v_tabs->key->vl}->d."</div>";
								}
							}
		                }  
		            ?>   
		            
		            <div class="TabbedPanelsContent _main">			
						<div class="ln_1 lft">
					        <?php echo $___Ls->tab->cntrc->d; ?>	
						</div>
					</div> 
		             
	            </div>
				
			</div>
            
            <style>
							  		
		  		.__cnt_appl_detail button._fll{ width: 20px; height: 20px; background-color: transparent; border: none; margin-right: 10px; }
		  		.__cnt_appl_detail button._fll{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_fll_off.svg); }
		  		.__cnt_appl_detail.flls button._fll{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_fll_on.svg); }
		  		
		  		
		  		.__cnt_appl_detail .VTabbedPanels.mny._new > ul.TabbedPanelsTabGroup{ display: none; }
		  		.__cnt_appl_detail .VTabbedPanels.mny._new > div.TabbedPanelsContentGroup{ width: 100%; border: none; }
			  	
			  	.__cnt_appl_detail .VTabbedPanels.mny{ display: flex; }	
		        .__cnt_appl_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width:45px !important; }
		        .__cnt_appl_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
		        .__cnt_appl_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 0px; }
		        .__cnt_appl_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent._main{ padding-top: 0; }
		        .__cnt_appl_detail .VTabbedPanels.mny:not(._new) > div.TabbedPanelsContentGroup .TabbedPanelsContent .ln_1{ padding-left: 20px; text-align: left; }
		        .__cnt_appl_detail .VTabbedPanels.mny:not(._new) > div.TabbedPanelsContentGroup .TabbedPanelsContent .ln_1 h2{ padding: 0; border: none; }
		        
		        
		        .__cnt_appl_detail .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto !important; background-position: center center !important; min-height: 35px; min-width: 35px; max-width: 35px; background-repeat: no-repeat; opacity: 0.3; } 
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTabSelected,
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
		        
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd.svg); }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._cod_html{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_html.svg); }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._cod_js{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_js.svg); }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._cod_css{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_css.svg); }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._up{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_up.svg); }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._cdn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_cdn.svg); }
		         .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._tp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tipo.svg); }
		        .__cnt_appl_detail .VTabbedPanels .TabbedPanelsTab._font{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>font.svg); }
		        
		        .__cnt_appl_detail .__slc_ok{ border: none; padding-top: 20px; }
				
				.__cnt_appl_detail .Tt_Tb{ padding-left: 10px; }
				
				.__cnt_appl_detail .CollapsiblePanelTab {background-color: #ececec;padding: 9px;cursor: pointer;margin: 4px 0;border-radius: 6px;}
		        
		        
	        </style>
            
            <!-- Inicia Atributos -->
	            <!--<div class="ln _nowrp">
	                <?php echo $__appl_g->html ?>
	            </div>--> 
		    <!-- Finaliza Atributos -->  
	    
	  	</div>  
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
