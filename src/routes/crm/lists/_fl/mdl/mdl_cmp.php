<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdlcmp_cod, mdlcmp_keysch';
	$___Ls->_strt();
	
	$__lsgt_flt_cmp = 'mdlcmp_mdl, pro_fac, mdlcmp_md, mdlcmp_est, orderby, mdlcmpfl_f1, mdlcmpfl_f2';
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('mdlcmp_mdl', _SbLs_ID('i')); }
	
	
	$__fl .= " AND mdlstp_tp = '".$___Ls->mdlstp->tp."' ";
	

	
	if(_Chk_GET('fl_mdlcmppro')){ $__fl .= _AndSql('mdlcmp_mdl', $_GET['fl_mdlcmppro']); }
	//if(_Chk_GET('fl_mdlfac')){ $__fl .= _AndSql('pro_fac', $_GET['fl_mdlfac']); }
	if(_Chk_GET('fl_mdlcmpmd')){ $__fl .= _AndSql('mdlcmp_md', $_GET['fl_mdlcmpmd']); }
	if(_Chk_GET('fl_mdlcmpest')){ $__fl .= _AndSql('mdlcmp_est', $_GET['fl_mdlcmpest']); }
	if(_Chk_GET('fl_orderby')){ $__ob= $_GET['fl_orderby'];} else { $__ob = $__id;}
	
	
	if(_Chk_GET('fl_mdlcmpflf1') && _Chk_GET('fl_mdlcmpflf2')){ 
		$__fl .= ' AND mdlcmp_fi BETWEEN '.GtSQLVlStr($_GET['fl_mdlcmpflf1'], 'date').' AND '.GtSQLVlStr($_GET['fl_mdlcmpflf2'], 'date'); 
	}elseif(_Chk_GET('fl_mdlcmpflf1')){
		$__fl .= ' AND mdlcmp_fi  = '.GtSQLVlStr($_GET['fl_mdlcmpflf1'], 'date'); 
	}elseif(_Chk_GET('fl_mdlcmpflf2')){
		$__fl .= ' AND mdlcmp_fi  = '.GtSQLVlStr($_GET['fl_mdlcmpflf2'], 'date'); 
	}
	
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_CMP_BD.", "._BdStr(DBM).TB_SIS_MD." WHERE mdlcmp_md = id_sismd AND ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_SumPrs = "(SELECT SUM(mdlcmp_prs) FROM ".MDL_CMP_BD." WHERE mdlcmp_pay = 2) AS __nopay";
		$Ls_SumGst = "(SELECT SUM(mdlcmp_gst) FROM ".MDL_CMP_BD." WHERE mdlcmp_pay = 2) AS __gstd";
		$Ls_Whr = "FROM ".MDL_CMP_BD.", "._BdStr(DBM).TB_SIS_MD.", ".MDL_SIS_CMP_EST_BD.", ".TB_MDL_S_TP."
				   WHERE mdlcmp_tp = id_mdlstp AND mdlcmp_md = id_sismd AND mdlcmp_est = id_cmpest $__fl ".$___Ls->sch->cod." ORDER BY $__ob DESC";
				   
		$___Ls->qrys = "SELECT *, $Ls_SumPrs, $Ls_SumGst, DATEDIFF(mdlcmp_f_end, CURDATE()) AS __f_cmp_ds, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Tot_Cnt $Ls_Whr";	
		
	}
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php $_rsm_cmp = json_decode(_Rsm_Cmp([ 'nopay'=>$___Ls->ls->rw['__nopay'], 'gstd'=>$___Ls->ls->rw['__gstd']) ]); echo $_rsm_cmp->html; $CntWb .= $_rsm_cmp->js; ?>
<?php $CntWb .= " _ldCnt({ u:'".Fl_Rnd(FL_DT_GN.__t($__prfx->prfx2_c.'_grph',true).PgRgFl($__lsgt_flt_cmp.$__lsgt_flt_cmp_nd).$_adsch.$___Ls->ls->vrall)."&_w=1100&_h=300', c:'bx_grph' }); "; ?>

<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
      	<tr>
        <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
        <th width="94%" <?php echo NWRP ?>><?php echo TX_COD ?></th>
        <th width="1%" <?php echo NWRP ?>><?php echo TX_PRSP ?></th>
        <th width="0%" <?php echo NWRP ?>><?php echo TX_SLCT ?></th>
        <th width="1%" <?php echo NWRP ?>><?php echo TX_PGD ?></th>
        <th width="1%" <?php echo NWRP ?>><?php echo MDL_PSG_CNT ?></th>
        <?php if(ChckSESS_superadm()){ ?>
        		<th width="1%" <?php echo NWRP ?>><?php echo TX_MTA ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_PCNVR ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_CPC ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_CPL ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_CTR ?></th>
        <?php } ?>
        <th width="1%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
      	</tr>
	</thead>
	<tbody>
		  <?php do { ?>
          <?php 
				
				if($___Ls->ls->rw['mdlcmp_clf'] == 2){
					$__gtcmpdt = GtMdlGenDt( $__prfx_tp, $___Ls->ls->rw['mdlcmp_mdl'],'', ['m'=>$___Ls->ls->rw['mdlcmp_md'], '_f1'=>$___Ls->ls->rw['mdlcmp_f_str'], '_f2'=>$___Ls->ls->rw['mdlcmp_f_end']]);
				}elseif($___Ls->ls->rw['mdlcmp_clf'] == 1){
					$__gtcmpdt = GtProAprDt(['tp'=>$__prfx_tp, 'id'=>$___Ls->ls->rw['mdlcmp_mdl'], 'm'=>$___Ls->ls->rw['mdlcmp_md'], '_f1'=>$___Ls->ls->rw['mdlcmp_f_str'], '_f2'=>$___Ls->ls->rw['mdlcmp_f_end'], '_qry'=>'si']);
				}
				$__gtcmpestdt = json_decode(GtCmpEstDt($___Ls->ls->rw['mdlcmp_est']));
				$_lnktr_l = FL_LS_GN.__t($__bdtp,true).PgRgFl($Flt_Cmp.$Flt_CmpND, 'get')._SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino].PgRgFl($Flt_Cmp.$Flt_CmpND, 'get').$___Ls->ls->vrall.$_adsch;
				$__gtusdt = GtUsDt($___Ls->ls->rw['mdlcmp_slc']);
				$__wrng = json_decode(__Cmp_wrn(['cnt_tot'=>$__gtcmpdt->tot_cnt, 'est'=>$___Ls->ls->rw['mdlcmp_est'], 'prs'=>$___Ls->ls->rw['mdlcmp_prs'], 'md_l_v'=>$___Ls->ls->rw['sismd_ld_v'], 'ds'=>$___Ls->ls->rw['__f_cmp_ds'] ]));
				$__rsl_cmp_ls = json_decode( __Cmp_c(['f_str'=>$___Ls->ls->rw['mdlcmp_f_str'], 
														   'f_end'=>$___Ls->ls->rw['mdlcmp_f_end'],
														   'prs'=>$___Ls->ls->rw['mdlcmp_prs'],
														   'gst'=>$___Ls->ls->rw['mdlcmp_gst'],
														   'gst_f'=>$___Ls->ls->rw['mdlcmp_gst_fnl'],
														   'utl'=>$___Ls->ls->rw['mdlcmp_utl'],
														   'lds'=>$__gtcmpdt->tot_cnt,
														   'clc'=>$___Ls->ls->rw['mdlcmp_rsl_clck'],
														   'alc'=>$___Ls->ls->rw['mdlcmp_rsl_alcn']		]));
				if($_GET['fl_mdlfac'] > 1){ $fl_fac= $__gtcmpdt->fac==$_GET['fl_mdlfac']; }else{ $fl_fac= $__gtcmpdt->fac > 0; }
				if($fl_fac){	
		  ?>
          <tr <?php echo $__wrng->est_sty ?>> <!-- title="<?php //echo $__gtcmpestdt->tt ?>"> -->
            <td width="1%" <?php echo NWRP.$__wrng->est_sty ?> class="_nombl"><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
            <td width="94%" align="left" <?php echo NWRP.$__wrng->est_sty ?> title="<?php echo $__gtcmpdt->tt ?>"><?php echo Spn(ctjTx($___Ls->ls->rw['mdlcmp_cod'],'in'), 'ok'); if($__lssb != 'ok'){ echo ShortTx($__gtcmpdt->tt,30,'Pt', true).HTML_BR; } echo Spn(ctjTx($___Ls->ls->rw['sismd_tt'],'in'),'ok',$__prfx_tp);  ?></td>
            <td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?>><?php $gstd = ''; if(ChckSESS_superadm()){ $gstd = $__rsl_cmp_ls->s_inv_p; }else{ $gstd = $__rsl_cmp_ls->c_inv_p; } echo cnVlrMon('', $___Ls->ls->rw['mdlcmp_prs']).Spn( _Nmb($gstd, 7), 'ok', $__prfx_tp); ?></td>
            <td width="0%" align="left" <?php echo NWRP.$__wrng->est_sty ?>><?php echo Spn($__gtusdt->nm_fll, '', $__prfx_tp).HTML_BR.Spn($___Ls->ls->rw['mdlcmp_fi'], '', $__prfx_tp); ?></td>
            <td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?>>
            <?php 
				echo _pay($___Ls->ls->rw['mdlcmp_pay'], ['r'=>'spn'] ).HTML_BR;
                if($___Ls->ls->rw['__f_cmp_ds'] > 5){ $__spn_days = 'ok'; }else{ $__spn_days = 'no'; }
                echo Spn($___Ls->ls->rw['mdlcmp_f_end'], '', '_f'); if($___Ls->ls->rw['__f_cmp_ds'] >= 0){ echo Spn($___Ls->ls->rw['__f_cmp_ds'],'ok',$__spn_days); } 

            ?>
            </td>
            <td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?>><?php echo Spn(MDL_PSG_CNT.': ','','_mbl').Spn($__gtcmpdt->tot_cnt,'',$__wrng->cnt_est); if($__wrng->prc != NULL){ echo HTML_BR.Spn(_Nmb($__wrng->prc, 1), 'ok', $__prfx_tp); } ?></td>
            <?php if(ChckSESS_superadm()){ ?>
            		<td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?>><?php echo Spn(TX_MTA.': ','','_mbl').Spn($__wrng->lds_aprx); ?></td>
                    <td width="1%" align="left"><?php echo Spn( _Nmb($__rsl_cmp_ls->c_cnv, 1), '', '_sbt'); ?></td>
                    <td width="1%" align="left"><?php echo Spn( cnVlrMon('', $__rsl_cmp_ls->c_cpc ) ); ?></td>
                    <td width="1%" align="left"><?php echo Spn( cnVlrMon('', $__rsl_cmp_ls->c_cpl ) ); ?></td>
                    <td width="1%" align="left"><?php echo Spn( _Nmb( $__rsl_cmp_ls->c_ctr, 1) ); ?></td>
            <?php } ?>
            <td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?> class="_btn" title="<?php echo $__gtcmpestdt->tt ?>"><div class="cmp_est <?php echo $__gtcmpestdt->cls ?>"><?php echo Spn() ?></div></td>

            <td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?> class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo 
	            HTML_Ls_Btn(['t'=>'md', 'l'=>_Cns('DMN_CMP_').$___Ls->ls->rw['mdlcmp_enc'].'/?'.ADM_LNK_CRM.LNK_RND.Gn_Rnd(20), 'cls'=>'_dtl']); ?></td>
            <td width="0%" align="left" nowrap="nowrap">
				<?php if(ChckSESS_superadm()){ ?>
                  		<?php echo HTML_Ls_Btn(['t'=>'rpr', 'l'=>Fl_Rnd(FL_FM_GN.__t('pro_cmp_rpr',true).Fl_i($___Ls->ls->rw[$___Ls->ino])), 'cls'=>'_rpr']); ?>
                <?php } ?>
            </td>
            <td width="1%" align="left" <?php echo NWRP.$__wrng->est_sty ?> class="_btn"><?php echo HTML_Ls_Btn(['t'=>'onl', 'l'=> _Cns('DMN_CMP_').$___Ls->ls->rw['mdlcmp_enc'], 'trg'=>'_blank']); ?></td>

          </tr>
          <?php 
					}
		  } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>

	</tbody>

  
  <?php $CntWb .= '	$("._rpr").colorbox({ width:"450px", height:"280px", overlayClose:false, escKey:false});
  					$("._dtl").colorbox({ iframe:true, width:"1000px", height:"550px", overlayClose:false, escKey:false}); '; ?>
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
	  	<div id="<?php echo DV_GNR_FM_CMP.Gn_Rnd(20) ?>" class="_DtRgClp">
			
                <?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
				<?php  
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_cod']; 
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_mdl'];
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_md'];
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_obj'];
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_dsc'];
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_url'];
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_aprb'];
					$___arr_1[] = $___Ls->dt->rw['mdlcmp_aprb_us'];

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_1) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_DTSBSC ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 
                                       <div class="col_1"> 
                                       		  <?php echo HTML_inp_hd('___t', $__prfx->prfx2_c); ?>
                                              <?php 

                                                    echo  h3(TX_FS).$___Ls->dt->rw['mdlcmp_fi'].' / '.$___Ls->dt->rw['mdlcmp_hi'];
													 
													if(($__lssb != 'ok' && ChckSESS_superadm()) || ($___Ls->dt->tot != 1)){
                                                       		echo LsCmpTp('mdlcmp_clf','id_cmptp', $___Ls->dt->rw['mdlcmp_clf'], FM_LS_SLTP, ''); $CntWb .= JQ_Ls('mdlcmp_clf',FM_LS_SLTP);

                                 										$CntWb .= "
																		$('#mdlcmp_clf').change(function() {
																			__id = $('#mdlcmp_mdl').val();
																			__tp_i = $(this).val();
																			SUMR_Main.ld.f.slc(__id, '{$__prfx_tp}', __tp_i, 'dpto_bx');	
                                                                		});"; 
															?>
                                                             <div id="dpto_bx" class="_sbls">

                                                              <?php  if($___Ls->dt->rw['mdlcmp_clf'] != ''){ $__t_s_i = $___Ls->dt->rw['mdlcmp_clf']; $__ts = $__prfx_tp; $__i = $___Ls->dt->rw['mdlcmp_mdl']; $__inc = 'ok'; include('_slc.php'); } ?>

                                                             </div>
															<? 
													}else{
														if($___Ls->dt->tot == 1){

                                                        	echo HTML_inp_hd('mdlcmp_mdl', $___Ls->dt->rw['mdlcmp_mdl']);

														}elseif($__lssb == 'ok'){
															echo HTML_inp_hd('mdlcmp_mdl', _SbLs_ID('i'));
														}else{

															echo LsCmpTp('mdlcmp_clf','id_cmptp', $___Ls->dt->rw['mdlcmp_clf'], FM_LS_SLTP, ''); $CntWb .= JQ_Ls('mdlcmp_clf',FM_LS_SLTP);

                                 
                                                                        $CntWb .= "
																		$('#mdlcmp_clf').change(function() {
																			__id = $('#mdlcmp_mdl').val();
																			__tp_i = $(this).val();
																			SUMR_Main.ld.f.slc(__id, '{$__prfx_tp}', __tp_i, 'dpto_bx');	
                                                                		});"; 
															?>
                                                             <div id="dpto_bx" class="_sbls">

                                                              <?php  if($___Ls->dt->rw['mdlcmp_clf'] != ''){ $__t_s_i = $___Ls->dt->rw['mdlcmp_clf']; $__ts = $__prfx_tp; $__i = $___Ls->dt->rw['mdlcmp_mdl']; $__inc = 'ok'; include('_slc.php'); } ?>

                                                             </div>
															<?
														}
                                                    }
       
											  		if(ChckSESS_superadm()){ 

														echo HTML_inp_tx('mdlcmp_cod', TX_COD, ctjTx($___Ls->dt->rw['mdlcmp_cod'],'in') ); 
														if($___Ls->dt->rw['mdlcmp_cod_bfr'] != ''){ echo Spn($___Ls->dt->rw['mdlcmp_cod_bfr'],'ok','_f').HTML_BR.HTML_BR; }
													}else{
														echo h3($___Ls->dt->rw['mdlcmp_cod']);
														if($___Ls->dt->rw['mdlcmp_cod_bfr'] != ''){ echo Spn($___Ls->dt->rw['mdlcmp_cod_bfr'],'ok','_f'); }
                                                        echo HTML_inp_hd('mdlcmp_cod', $___Ls->dt->rw['mdlcmp_cod']);
                                                    }
											  ?> 
                                              <?php echo HTML_inp_tx('mdlcmp_url', TX_URL, ctjTx($___Ls->dt->rw['mdlcmp_url'],'in'), FMRQD_URL); ?>
											  <?php echo LsSis_Md('mdlcmp_md','id_sismd', $___Ls->dt->rw['mdlcmp_md'], '', 2); $CntWb .= JQ_Ls('mdlcmp_md', FM_LS_SLTP); ?>  
                                              <?php 
											  		
													if($__lssb != 'ok' && ChckSESS_superadm()){
                                                       echo LsUs('mdlcmp_slc','id_us', $___Ls->dt->rw['mdlcmp_slc'], FM_LS_USSLCT, 2); $CntWb .= JQ_Ls('mdlcmp_slc',FM_LS_USSLCT);

                                                    }else{
													   echo HTML_inp_hd('mdlcmp_slc', SISUS_ID);	
                                                    }
											  
                                              
											  		if($___Ls->dt->tot == 1){	

														echo LsCmpEst('mdlcmp_est','id_cmpest', $___Ls->dt->rw['mdlcmp_est'], '', 2); $CntWb .= JQ_Ls('mdlcmp_est',FM_LS_SLEST);

                                              		}else{
                                                    	echo HTML_inp_hd('mdlcmp_est', 3);
                                                    }
											  
											  		if($___Ls->dt->tot == 1){
														

														echo LsSis_SiNo('mdlcmp_aprb','id_sissino', $___Ls->dt->rw['mdlcmp_aprb'], TX_APRBQ);  
														$CntWb .= JQ_Ls('mdlcmp_aprb', TX_GNTRA) . "
																	$('#mdlcmp_aprb').change(function(){

																		var __v = '';
																		__v = $(this).val();
																		
																		if(__v == 1){
																			$('#mdlcmp_aprb_us').removeClass('_hd');
																		}else{
																			$('#mdlcmp_aprb_us').addClass('_hd');
																		}
																		
																	}).change();
																	"; 
																	

														if($___Ls->dt->rw['mdlcmp_aprb'] == 2){
															$CntWb .= "$('#mdlcmp_aprb').delay(800).effect('shake').effect('highlight');";

														}
														
																	
													}else{
														echo HTML_inp_hd('mdlcmp_aprb', 2);		
													}
											  ?>  

                                              <?php echo HTML_inp_tx('mdlcmp_aprb_us', TX_APRBPOR, ctjTx($___Ls->dt->rw['mdlcmp_aprb_us'],'in'), '', '', '_hd'); ?> 
                                              <?php echo LsAgn('mdlcmp_agn','id_agn', $___Ls->dt->rw['mdlcmp_agn'], '', 2); $CntWb .= JQ_Ls('mdlcmp_agn',FM_LS_SLAGN); ?>
											  <?php if($___Ls->dt->rw['mdlcmp_md'] == 25 || $___Ls->dt->rw['mdlcmp_md'] == 259){ 
											  			if(ChckSESS_superadm()){
															echo HTML_inp_tx('mdlcmp_fb_id', TX_FBID, ctjTx($___Ls->dt->rw['mdlcmp_fb_id'],'in')); 
														}else{
															echo HTML_inp_hd('mdlcmp_fb_id', $___Ls->dt->rw['mdlcmp_fb_id']);
														}
													} 
											  ?>      
                                      		  <?php echo HTML_textarea('mdlcmp_obj', TX_OBJ, ctjTx($___Ls->dt->rw['mdlcmp_obj'],'in'), '', '', '', 2); ?> 
                                              <?php echo HTML_textarea('mdlcmp_dsc', TX_CON_DSC, ctjTx($___Ls->dt->rw['mdlcmp_dsc'],'in'), '', '', '', 2); ?> 
                                              <?php echo h2(TX_KEYDSC); echo HTML_inp_tx('mdlcmp_keysch', TX_KEYDSC, ctjTx($___Ls->dt->rw['mdlcmp_keysch'],'in')); $CntWb .=	"$('#mdlcmp_keysch').select2({ 	tags:[''], tokenSeparators: [',', ' ']	});"; ?>

                                      </div>
                                      <div class="col_2"> 
                                      		  
											   <?php 
													

													if($___Ls->dt->rw['mdlcmp_fb_id'] != ''){
														$__ls_ads_fb = _FB_Ad_Ls($___Ls->dt->rw['mdlcmp_fb_id']); 

													}
													
													if($__ls_ads_fb != NULL && $__ls_ads_fb != ''){
																		
															foreach($__ls_ads_fb as $row){
																if(ChckSESS_superadm()){
																	
																	$__dt_an = '<div class="__st">
																					<ul><li>'.Strn(TX_FCBKNM ).$row->name.'</li></ul>
																					<div class="_c1">
																						<ul>
																							<li>'.Strn(TX_GSTDH ).cnVlrMon('', $row->insights->today_spend).'</li>
																							<li>'.Strn(TX_GSTDTT ).cnVlrMon('', $row->insights->spend).'</li>
																							<li>'.Strn('Clics: ')._Nmb($row->insights->clicks, 3).'</li>
																							<li>'.Strn('CPM: ').cnVlrMon('', $row->insights->cpm).'</li>
																							<li>'.Strn('CPC: ').cnVlrMon('', $row->insights->cpc).'</li>
																							<li>'.Strn('CPP: ').cnVlrMon('', $row->insights->cpp).'</li>
																							<li>'.Strn('CTR: ')._Nmb($row->insights->ctr, 5).'</li>
																						</ul>
																					</div>
																					<div class="_c2">
																						<ul>
																							<li>'.Strn(TX_IMP.':' )._Nmb($row->insights->impressions, 3).'</li>
																							<li>'.Strn(TX_FRQ.':')._Nmb($row->insights->frequency, 5).'</li>
																							<li>'.Strn(TX_ALCNC.':')._Nmb($row->insights->reach, 3).'</li>
																							<li>'.Strn(TX_PNTCN.':' ).$row->insights->relevance_score->score.'</li>
																							<li>'.Strn(TX_PSTV.':' ).$row->insights->relevance_score->positive_feedback.'</li>
																							<li>'.Strn(TX_NGTV.':').$row->insights->relevance_score->negative_feedback.'</li>
																							<li>'.Strn(TX_S.':').$row->insights->relevance_score->status.'</li>
																						</ul>
																					</div>
																				</div>
																				';
																}
																
																$__dt_tt = h3($row->adcreatives->object_story_spec->link_data->name);
																$__dt_img = '<img src="'.$row->adcreatives->image_url.'">';
																$__dt_msg = '<p>'.$row->adcreatives->object_story_spec->link_data->message.'</p>';
																$__dt_img_viw = $__dt_tt.$__dt_msg.'<div class="_im">'.$__dt_img.'<ul class="_viw">	
																						<li class="_r _sc_'.$row->insights->relevance_score->score.'">'.$row->insights->relevance_score->score.'</li>	
																						<li><a href="'.URL_FB_FEED.$row->id.'" target="_blank">'.TX_ADS_NWS.'</a></li>	
																						<li><a href="'.URL_FB_AD.$row->id.'" target="_blank">'.TX_ADS_RGS.'</a></li>	
																						<li><a href="'.URL_FB_PST.$row->adcreatives->object_story_id.'" target="_blank">'.TX_ADS_PST.'</a></li>
																						<li class="_e '.$row->adgroup_status.'">'.$row->adgroup_status.'</li>	
																						<li><a href="'._Fb_Ad_Mod($row->adcampaign->id, $row->id).'" target="_blank">'.TX_EDT.'</a></li>
																				 </ul></div>'.$__dt_an;
																							 
																$__Crsl_Html .= '<div class="item">'.bdiv(['c'=>$__dt_img_viw, 'id'=>'dt_img', 'cls'=>'cmp_img']).'</div>';
															}  
															
															echo '<div class="_ads_crsl"><div id="__grph_crsl" class="owl-carousel">'.$__Crsl_Html.'</div></div>';
													}else{
																$__idtp_img = '_img'; 
																if(ChckSESS_superadm()){   $__dt_img_mod = HTML_Ls_Btn(['id'=>'dt_img_mod', 't'=>'edt', 'l'=>Void(), 'cls'=>'_mod']); }

																if($___Ls->dt->rw['mdlcmp_fb_id'] != ''){ $__dt_img_viw = '<ul class="_viw">	<li><a href="'.URL_FB_FEED.$___Ls->dt->rw['mdlcmp_fb_id'].'" target="_blank">Sección Noticias</a></li>	<li><a href="'.URL_FB_AD.$___Ls->dt->rw['mdlcmp_fb_id'].'" target="_blank">'.TX_ADS_RGS.'</a></li>	</ul>'; }
																
																 
																$__dt_img = BlImg(_Cns('DIR_IMG_WEB__CMP').$___Ls->dt->rw['mdlcmp_img'], '', $_fim, '../../../'); 

																if($__dt_img->e){ 
																	echo bdiv(['c'=>$__dt_img_mod.$__dt_img->img.$__dt_img_viw, 'id'=>'dt_img', 'cls'=>'cmp_img']); 
																	$__hd__ldimg = ' _hd';
																} 
																
																$CntWb .= "$('#dt_img_mod').click(function(){ $('#dt_img').hide(); $('#".DV_LSFL.$__idtp_img."').removeClass('_hd'); });";				
												?>  
                                                                <!-- Inicia Archivos -->
                                                                <?php if(ChckSESS_superadm()){  echo bdiv(['id'=>DV_LSFL.$__idtp_img, 'cls'=>'cmp_img'.$__hd__ldimg]); } ?>
                                                                <!-- Finaliza Archivos -->
                                                                
                                                                <?php 
                                                                    $___Ls->_dvlsfl_all([
																		['n'=>$__idtp_img, 't'=>'pro_cmp_img']
																	])	
                                                                    if(ChckSESS_superadm()){   $CntWb .= "_ldCnt({ u:_".DV_LSFL.$__idtp_img.", c:'".DV_LSFL.$__idtp_img."' });"; }
                                                                    
                                                                ?>
                                              <?php } ?>
                                      </div> 
                          </div>   
                    </div>
                </div>
                
                
                <?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <?php  

					$___arr_2[] = $___Ls->dt->rw['mdlcmp_f_str']; 
					$___arr_2[] = $___Ls->dt->rw['mdlcmp_f_end'];

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_2) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_CON_FCH ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 
                             <div class="col_1"> 

                                       		  <?php echo SlDt([ 'id'=>'mdlcmp_f_str', 'va'=>$___Ls->dt->rw['mdlcmp_f_str'], 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'lmt'=>'no']);
	                                       		    //echo SlDt('mdlcmp_f_str',$___Ls->dt->rw['mdlcmp_f_str'],'no','', TX_ORD_FIN,'no');  ?>          
                                      </div>
                                      <div class="col_2">
                                      		  <?php 
	                                      		echo SlDt([ 'id'=>'mdlcmp_f_end', 'va'=>$___Ls->dt->rw['mdlcmp_f_end'], 'rq'=>'no', 'ph'=>TX_ORD_FOU, 'lmt'=>'no']);
	                                      		   //SlDt('mdlcmp_f_end',$___Ls->dt->rw['mdlcmp_f_end'],'no','', TX_ORD_FOU,'no'); ?> 

                                      </div> 
                          </div>   
                    </div>
                </div>
                
                <?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <?php  

					$___arr_3[] = $___Ls->dt->rw['mdlcmp_prs']; 

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_3) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_PRSP ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 
                                    
                                  <div class="col_1"> 
										  <?php 
										  		if(ChckSESS_superadm() || $___Ls->dt->tot != 1){

													echo HTML_inp_tx('mdlcmp_prs', TX_PRSP, ctjTx($___Ls->dt->rw['mdlcmp_prs'],'in') );
												}else{
													echo h3(cnVlrMon('', $___Ls->dt->rw['mdlcmp_prs']));
													echo HTML_inp_hd('mdlcmp_prs', $___Ls->dt->rw['mdlcmp_prs']);
												}				
										  ?>
                                          <?php 
												if($___Ls->dt->rw['mdlcmp_utl'] != ''){ $___cmp_utl = $___Ls->dt->rw['mdlcmp_utl']; }else{ $___cmp_utl = SIS_P_UTLD; }
												if(ChckSESS_superadm()){
													echo HTML_inp_tx('mdlcmp_utl', TX_UTLD, ctjTx($___cmp_utl,'in') );
													echo LsSisPay('mdlcmp_pay','id_sispayest', $___Ls->dt->rw['mdlcmp_pay'], FM_LS_PAY, 2); $CntWb .= JQ_Ls('mdlcmp_pay',FM_LS_PAY);

												}else{
													echo HTML_inp_hd('mdlcmp_utl', $___cmp_utl);
													echo HTML_inp_hd('mdlcmp_pay', $___cmp_utl);
											    }		
											?>          
                                  </div>
                                  <div class="col_2">
                                          		<?php 	

													$__rsl_cmp = json_decode( __Cmp_c(['f_str'=>$___Ls->dt->rw['mdlcmp_f_str'], 
																			   'f_end'=>$___Ls->dt->rw['mdlcmp_f_end'],
																			   'prs'=>$___Ls->dt->rw['mdlcmp_prs'],
																			   'gst'=>$___Ls->dt->rw['mdlcmp_gst'],
																			   'gst_f'=>$___Ls->dt->rw['mdlcmp_gst_fnl'],

																			   'utl'=>$___cmp_utl]) );	
										 	 	?>
                                                   <div class="___cl_prvt">
                                                           <ul>
                                                                <li><?php echo TX_CMP_INVS_TOT. ':' . Strn(  cnVlrMon('', $__rsl_cmp->c_prs ) ) ; ?></li>
                                                                <li><?php echo TX_CMP_INVS_XD.' :' . Strn(  cnVlrMon('', $__rsl_cmp->c_prs_d ) ) ; ?></li>
                                                                <li><?php echo TX_CMP_INVS_DSON.': '.$__rsl_cmp->d ?></li>
                                                                <li><?php echo TX_GSTD.': '.Strn(  cnVlrMon('', $__rsl_cmp->c_gst) ) ; ?></li>
                                                           </ul>  
                                                           <div class="__p"><?php echo Strn(  _Nmb($__rsl_cmp->c_inv_p, 3).Spn('%') ) ; ?><?php echo TX_GSTD ?></div>   
                                                   </div>
                                        		<?php if(ChckSESS_superadm()){ ?>
                                                
                                                    <div class="___svin_prvt">
                                                                <?php echo h2(TX_SVIN); ?>
                                                                <ul>
                                                                    <li><?php echo TX_EVN_INVS.Spn('R','ok').TX_TOTS.': ' . Strn(  cnVlrMon('', $__rsl_cmp->s_inv) ) ; ?></li>
                                                                    <li><?php echo TX_EVN_INVS.Spn('R','ok').' por dia: ' . Strn(  cnVlrMon('', $__rsl_cmp->s_inv_d) ) ; ?></li>
                                                                </ul>

                                                                <ul>
                                                                	
                                                                    <li><?php echo TX_GSTD.': '.Strn(  cnVlrMon('', $__rsl_cmp->s_gst) ) ; ?></li>
                                                                    <li><?php echo TX_GSTD.Spn('%','ok').': '.Strn(  _Nmb($__rsl_cmp->s_inv_p, 7) ) ; ?></li>
                                                                    <li><?php echo TX_DRTNTS ?><?php echo Spn( $__rsl_cmp->d_rst, '',$__vlr_spn) ; ?></li>
                                                                    <li><?php echo TX_RSTNT ?><?php echo TX_EVN_INVS ?>: <?php if($__rsl_cmp->s_inv_rst > 0){ $__vlr_spn = 'ok'; }else{ $__vlr_spn = 'no'; } echo Spn(  cnVlrMon('', $__rsl_cmp->s_inv_rst), '',$__vlr_spn) ; ?></li>
                                                                    <li><?php echo TX_RSTNT ?><?php echo TX_EVN_INVS ?><?php echo TX_PD ?><?php echo Spn(  cnVlrMon('', $__rsl_cmp->s_inv_rst_d), '',$__vlr_spn) ; ?></li>
 
                                                                </ul>

                                                                <ul>
                                                                    <li><?php echo TX_GNC ?><?php echo Strn(  cnVlrMon('', $__rsl_cmp->s_gnc_p) ) ; ?></li>
                                                                    <li><?php echo TX_GNCRL ?><?php echo Strn(  cnVlrMon('', $__rsl_cmp->s_gnc_r) ) ; ?></li>
                                                                </ul>
                                                                
                                                                <div class="__p"><?php echo Strn(  _Nmb($__rsl_cmp->s_inv_p, 3).Spn('%') ) ; ?><?php echo TX_GSTD ?></div>  
                                                    </div>
                                                <?php } ?>
                                   </div> 
                      </div>   
                    </div>
                </div>
                

                <?php if($___Ls->dt->rw['mdlcmp_md'] == 26 || $___Ls->dt->rw['mdlcmp_md'] == 257 || $___Ls->dt->rw['mdlcmp_md'] == 265 || $___Ls->dt->rw['mdlcmp_md'] == 266){ ?>
                <?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <?php  
					$___arr_4[] = $___Ls->dt->rw['mdlcmp_go_kyw']; 
					$___arr_4[] = $___Ls->dt->rw['mdlcmp_dsc_dmg']; 
					$___arr_4[] = $___Ls->dt->rw['mdlcmp_dsc_psc'];

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_4) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_GOOKEYW ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 	
                                  <div class="col_1"> 

                                       <?php echo HTML_textarea('mdlcmp_go_kyw', '', ctjTx($___Ls->dt->rw['mdlcmp_go_kyw'],'in'), '', 'ok'); ?> 
                                  </div>
                                  <div class="col_2">      
                                       <?php echo HTML_textarea('mdlcmp_dsc_dmg', TX_DSC_DMG, ctjTx($___Ls->dt->rw['mdlcmp_dsc_dmg'],'in'), '', '', '', 3); ?> 
                                       <?php echo HTML_textarea('mdlcmp_dsc_psc', TX_DSC_PSC, ctjTx($___Ls->dt->rw['mdlcmp_dsc_psc'],'in'), '', '', '', 3); ?> 

                                  </div>              
                          </div>   
                    </div>
                </div>
                <?php } ?>
                

                <?php if($___Ls->dt->rw['mdlcmp_md'] == 25 || $___Ls->dt->rw['mdlcmp_md'] == 259){ ?>
				<?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <?php  
					$___arr_5[] = $___Ls->dt->rw['mdlcmp_fb_sgm']; 
					$___arr_5[] = $___Ls->dt->rw['mdlcmp_dsc_dmg']; 
					$___arr_5[] = $___Ls->dt->rw['mdlcmp_dsc_psc']; 

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_5) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_FBSGMN ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 
                                  <div class="col_1"> 

                                      <?php echo HTML_textarea('mdlcmp_fb_sgm', '', ctjTx($___Ls->dt->rw['mdlcmp_fb_sgm'],'in'), '', 'ok'); ?> 
                                  </div>
                                  <div class="col_2">      
                                       <?php echo HTML_textarea('mdlcmp_dsc_dmg', TX_DSC_DMG, ctjTx($___Ls->dt->rw['mdlcmp_dsc_dmg'],'in'), '', '', '', 3); ?> 
                                       <?php echo HTML_textarea('mdlcmp_dsc_psc', TX_DSC_PSC, ctjTx($___Ls->dt->rw['mdlcmp_dsc_psc'],'in'), '', '', '', 3); ?> 

                                  </div>       
                          </div>   
                    </div>
                </div>
                <?php } ?>
                
                <?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <?php  

					$___arr_6[] = $___Ls->dt->rw['mdlcmp_rsl_clck']; 
					$___arr_6[] = $___Ls->dt->rw['mdlcmp_rsl_alcn'];
					$___arr_6[] = $___Ls->dt->rw['mdlcmp_rsl_exp'];

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_6) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_RSLT ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 
                                      <div class="col_1"> 
                                              <?php 
													

													echo HTML_textarea('mdlcmp_rsl_exp', TX_RSLESPR, ctjTx($___Ls->dt->rw['mdlcmp_rsl_exp'],'in'), '', '', '', 3); 
													echo HTML_inp_tx('mdlcmp_rsl_clck', TX_CLCKS, ctjTx($___Ls->dt->rw['mdlcmp_rsl_clck'],'in') );
													echo HTML_inp_tx('mdlcmp_rsl_alcn', TX_ALCNC, ctjTx($___Ls->dt->rw['mdlcmp_rsl_alcn'],'in') );  
													
													
													if(ChckSESS_superadm()){
														if($___Ls->dt->rw['mdlcmp_fb_id'] != ''){ $_FB_Sta = __FB_Ing_Sta(['t'=>$__prfx_tp, 'c'=>$___Ls->dt->rw[$___Ls->ino], 'f'=>$___Ls->dt->rw['mdlcmp_fb_id']]) ;}
														if($_FB_Sta->spend != ''){ $_inp_gst = $_FB_Sta->spend; }else{ $_inp_gst = ctjTx($___Ls->dt->rw['mdlcmp_gst'],'in'); }
														echo HTML_inp_tx('mdlcmp_gst', TX_GSTD, $_inp_gst);
														echo HTML_inp_tx('mdlcmp_gst_fnl', TX_GSTD . (TX_FNLMD), ctjTx($___Ls->dt->rw['mdlcmp_gst_fnl'],'in') );
													}else{
														if($_FB_Sta->spend != ''){ $_inp_gst = $_FB_Sta->spend; }else{ $_inp_gst = ctjTx($___Ls->dt->rw['mdlcmp_gst'],'in'); }
														echo HTML_inp_hd('mdlcmp_gst', $___Ls->dt->rw['mdlcmp_gst']);
														echo HTML_inp_hd('mdlcmp_gst_fnl', $___Ls->dt->rw['mdlcmp_gst_fnl']);

													}		
											  ?>              
                                      </div>
                                      <div class="col_2"> 
                                                  		  <?php 
														  		if(ChckSESS_superadm()){

																		if($_FB_Sta->e == 'ok'){
	
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_ORD_FIN)).$_FB_Sta->date_start);
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_FF)).$_FB_Sta->date_stop);	
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CPR)).cnVlrMon('', $_FB_Sta->cost_per_result));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CPA)).cnVlrMon('', $_FB_Sta->cost_per_total_action));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CPC)).cnVlrMon('', $_FB_Sta->cpc));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CPUC)).cnVlrMon('', $_FB_Sta->cost_per_unique_click));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CPM)).cnVlrMon('', $_FB_Sta->cpm));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CPP)).cnVlrMon('', $_FB_Sta->cpp));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CTR)).cnVlrMon('', $_FB_Sta->ctr));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_CLCKS))._Nmb($_FB_Sta->clicks, 3));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_IMP))._Nmb($_FB_Sta->impressions, 3));
																			$_sta_dt['c1'] .= li(Strn(_dp(TX_FRQ))._Nmb($_FB_Sta->frequency, 5));
																			
																			
																			
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_CMTN)).$_FB_Sta->a_comment. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_comment),'ok','_cpa'));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_LKS)).$_FB_Sta->a_like. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_like),'ok','_cpa'));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_CLNK)).$_FB_Sta->a_link_click. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_link_click),'ok','_cpa'));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_OFFCNV)).$_FB_Sta->a_offsite_conversion. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_offsite_conversion),'ok','_cpa'));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_ADS_PST))._Nmb($_FB_Sta->a_post, 3). Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_post),'ok','_cpa') );
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_ADS_PST.' '.TX_LKS)).$_FB_Sta->a_post_like. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_post_like),'ok','_cpa'));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_PGENG)).$_FB_Sta->a_page_engagement. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_page_engagement),'ok','_cpa'));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_PSTENG)).$_FB_Sta->a_post_engagement. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->c_post_engagement),'ok','_cpa'));
	

																			
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_GSTD)).cnVlrMon('', $_FB_Sta->spend));
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_RLV_ANC)).$_FB_Sta->relevance_score->score);
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_RLV_PSTV)).$_FB_Sta->relevance_score->positive_feedback);
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_RLV_NGTV)).$_FB_Sta->relevance_score->negative_feedback);
																			$_sta_dt['c2'] .= li(Strn(_dp(TX_RLV_STTS)).$_FB_Sta->relevance_score->status);
																			
																			echo '<div class="__st_dt">
																						<div class="_c1"><ul>'.$_sta_dt['c1'].'</ul></div>
																						<div class="_c2"><ul>'.$_sta_dt['c2'].'</ul></div>
																				  </div>';
																		}
                                                                }
																
														  ?>
                                                  </div> 
                          </div>   
                    </div>
                </div>

				<?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <?php  

					$___arr_7[] = $___Ls->dt->rw['mdlcmp_obs']; 

					$___js_avnc = _Kn_Prcn([ 'id'=>$__id_clpp.'_avnc', 'v'=>_Kn_Prcn_n($___arr_7) ]); $CntWb .= $___js_avnc->js;  
				?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_OBS ?> <div class="__avnc"><?php echo $___js_avnc->html; ?></div></div>
                    <div class="CollapsiblePanelContent">
                           <div class="ln_1"> 

                                       <?php echo HTML_textarea('mdlcmp_obs', '', ctjTx($___Ls->dt->rw['mdlcmp_obs'],'in')); ?>          

                          </div>   
                    </div>
                </div>
                
                <?php 
				if($___Ls->dt->tot == 1){
				$__idtp_gst = '_gst'; ?>
                <?php $__id_clpp = 'Flc_'.Gn_Rnd(20); $CntWb .= " var ".$__id_clpp." = new Spry.Widget.CollapsiblePanel('".$__id_clpp."', {contentIsOpen:true }); "; ?>
                <div id="<?php echo $__id_clpp ?>" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0" id="<?php echo TBGRP.$__idtp_gst ?>"><?php echo TX_GSTN ?></div>
                    <div class="CollapsiblePanelContent _nopd">
                     		<!-- Inicia Gestión -->
                            <div class="ln">
                                <?php echo bdiv(['id'=>DV_LSFL.$__idtp_gst]) ?>
                            </div> 
                            <!-- Finaliza Gestión -->      
                    </div>
                </div>
				<?php       
						$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_gst, 't'=>'pro_cmp_gst']);		  
						$CntWb .= _DvLsFl(['i'=>$__idtp_gst])._DvLsFl(['i'=>$__idtp_gst]);
						$CntWb .= _DvLsFl(['i'=>$__idtp_gst, 't'=>'s']);
				?>
                <?php } ?>
                
      </div>
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>