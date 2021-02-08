<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'mdlsprd_nm, mdlstp_nm';
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 700;
	$___Ls->edit->h = 750;
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_S_PRD." INNER JOIN "._BdStr(DBM).TB_SIS_SLC." AS t1 ON (mdlsprd_tp = t1.id_sisslc) WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Whr = "FROM ".TB_MDL_S_PRD."  
		".GtSlc_QryExtra(['t'=>'tb', 'col'=>'mdlsprd_tp', 'als'=>'t','l'=>'ok'])."
		WHERE  ".$___Ls->ino." != '' AND mdlsprd_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." where cl_enc = '".DB_CL_ENC."') ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
		".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t','l'=>'ok']).",
		 (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
		
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
 	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="40%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
	    <th width="40%" <?php echo NWRP ?>><?php echo TX_YR ?></th>
		<th width="40%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
	    <th width="40%" <?php echo NWRP ?>><?php echo TX_SMSTR ?></th>
	    <th width="10%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
	    <th width="10%" <?php echo NWRP ?>><?php echo TX_FA ?></th> 
	    <th width="1%" <?php echo NWRP ?>></th> 
  	</tr>
  	<?php do { $__ls_json[] = $___Ls->ls->rw['mdlsprd_enc']; ?>
    <tr mdlsprd-id-no="<?php echo $___Ls->ls->rw['mdlsprd_enc']; ?>">    	   
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="40%" align="left" nowrap="nowrap">
			<?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlsprd_nm'],'in'),150,'Pt', true); ?>
			<?php echo bdiv([ 'cls'=>'bx_tp' ]) ?>
		</td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlsprd_y'],'in'); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['tp_sisslc_tt'],'in'); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlsprd_s'],'in'); ?></td>
	    <td width="10%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlsprd_fi'],'in'); ?></td>
	    <td width="10%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlsprd_fa'],'in'); ?></td>
	    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod']); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>

<?php 

$CntJV .=	"

	function __getMdlSPrdJs(){

		$.post('".Fl_Rnd(FL_JSON_GN.__t('mdl_s_prd_ext',true))."', { mdl_s_prd:'".implode(',', $__ls_json)."' },
		
		function(d, status){
			if(d.e == 'ok'){

				if( d.total > 0 ){
					$.each(d.l, function(_k, _v) {  

						$('tr[mdlsprd-id-no='+_v.id+'] .bx_tp').html( _v.ls_icns );
						
					});
				}
			}
		});       	
	}";

	$CntWb .= " setTimeout(function(){ __getMdlSPrdJs(); }, 1000); "; 
?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>

<div class="FmTb">
  <div id="<?php  echo DV_GNR_FM ?>">

	                              
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?>      

	  
      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> mdl_s_prd_tp">
	  
        <div class="ln_1">
	        
	        	
					<?php
				
						$__tabs = [
							['n'=>'tp', 't'=>'mdl_s_prd_tp', 'l'=>'Tipo de Modulo']
						];
						
						$___Ls->_dvlsfl_all($__tabs);
					?>
					<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
					
					<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny mdl_s_prd_tp">
							
							<ul class="TabbedPanelsTabGroup">						
					            <?php echo $___Ls->tab->bsc->l ?>
								<?php echo $___Ls->tab->tp->l ?>								            
				          	</ul>
				          	
						  	<div class="TabbedPanelsContentGroup">
					        	<div class="TabbedPanelsContent">
						        	<?php echo HTML_inp_tx('mdlsprd_nm', TX_NM , ctjTx($___Ls->dt->rw['mdlsprd_nm'],'in'), FMRQD); ?>
						            <?php echo Ls_Vl_Year('mdlsprd_y', 'mdlsprd_y', $___Ls->dt->rw['mdlsprd_y'],TX_YR,'2'); $CntWb .= JQ_Ls('mdlsprd_y'); ?>		
									<?php $l = __Ls(['k'=>'sis_prd',
														'id'=>'mdlsprd_tp',
														'v'=>'id_sisslc',
														'ph'=>FM_LS_PRD,
														'va'=>$___Ls->dt->rw['mdlsprd_tp']
													]);
													
													echo $l->html; $CntWb .= $l->js; ?>
									
									<?php echo HTML_inp_tx('mdlsprd_s', TX_SMSTR , ctjTx($___Ls->dt->rw['mdlsprd_s'],'in')); ?>
									<?php echo OLD_HTML_chck('mdlsprd_est', TX_EST, $___Ls->dt->rw['mdlsprd_est'], 'in'); ?>
					        	</div>
					        	<div class="TabbedPanelsContent">
						        	<?php echo $___Ls->tab->tp->d; ?>
					        	</div> 
						  	</div>
					</div>

        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
<style>					        
	:root{--cl-dt-clr:<?php echo $___Ls->dt->rw['act']; ?>;}
	.mdl_s_prd_tp .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width: 9% !important; list-style-type: none; }
	.mdl_s_prd_tp .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
	.mdl_s_prd_tp .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding: 30px !important; }
	.mdl_s_prd_tp .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
	.mdl_s_prd_tp .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 40px; min-width: 40px; max-width: 40px; background-repeat: no-repeat; opacity: 0.3; } 
	.lead_data .VTabbedPanels .TabbedPanelsTabSelected,
	.lead_data .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
	.mdl_s_prd_tp .VTabbedPanels .TabbedPanelsTab:first-child{ background-color:var(--cl-dt-clr) !important; background-image: url(<?php echo $__cl_logo->th_400; ?>); background-size: 100% auto; opacity: 1; }
	.mdl_s_prd_tp .VTabbedPanels .TabbedPanelsTab._tt_icn_tag{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_tag.svg); }
	.mdl_s_prd_tp .VTabbedPanels .TabbedPanelsTab._tt_icn_are{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are.svg); }
	.mdl_s_prd_tp .VTabbedPanels .TabbedPanelsTab._tt_icn_mdlstp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_mdlstp.svg); }
	span.icn_chck_tp {width: 20px;height: 20px;display: block;background-position: center;background-repeat: no-repeat;background-size: 100% auto;border-radius: 14px;margin: 3px;opacity: 0.8;}

</style>
