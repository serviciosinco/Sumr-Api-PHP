<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'eml_nm, eml_eml';
	$___Ls->img->dir = DMN_FLE_EML;
	$___Ls->new->w = 700;
	$___Ls->new->h = 750;
	$___Ls->edit->w = 850;
	$___Ls->edit->h = 550;
	$___Ls->tp = 'eml';
	$___Ls->_strt();
		
	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("
							SELECT *,
									AES_DECRYPT(eml_pss, '".ENCRYPT_PASSPHRASE."') AS __pss
							FROM "._BdStr(DBT).TB_THRD_EML." 
							WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
						);	
													
	}elseif($___Ls->_show_ls == 'ok'){ 	
		
		if(DB_CL_ID != '4'){
			$__tb_in = "
				INNER JOIN "._BdStr(DBM).TB_CL_EML." ON cleml_eml = id_eml
				INNER JOIN "._BdStr(DBM).TB_CL." ON cleml_cl = id_cl
			";
			$__tb_whr = " AND cl_enc = '".CL_ENC."' ";	
		}
		
		$Ls_Whr = " FROM "._BdStr(DBT).TB_THRD_EML." 
						 ".$__tb_in."
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eml_tp', 'als'=>'t' ])."	
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eml_avtr', 'als'=>'a' ])."	 
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." {$__tb_whr}
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "
						SELECT id_eml, eml_enc, eml_nm, eml_eml, eml_img,
							   "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
							   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ]).",
							   "._QrySisSlcF([ 'als'=>'a', 'als_n'=>'avatar' ]).",
							   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'avatar', 'als'=>'a' ]).",
							   (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
						$Ls_Whr"; 
		
	} 
	$___Ls->_bld(); //echo $___Ls->qrys;
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="48%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
		<th width="48%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
	<?php 
	  	do { 	  
		
			if(!isN( $___Ls->ls->rw['eml_img'] )){
				$__tt_img = fgr('<img src="'.DMN_FLE_EML.ctjTx($___Ls->ls->rw['eml_img'],'in').'">', '_o');
			}elseif(!isN( $___Ls->ls->rw['avatar_sisslc_img'] )){
				$__tt_img = fgr('<img src="'.DMN_FLE_SIS_SLC.ctjTx($___Ls->ls->rw['avatar_sisslc_img'],'in').'">', '_o');
			}else{
				$__tt_img = '';
			}
	?>
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="1%"><?php echo $__tt_img; ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['eml_nm'],'in'),40,'Pt', true); ?></td>
		<td width="48%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['eml_eml'],'in'),150,'Pt', true); ?></td>
		<td width="48%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['tipo_sisslc_tt'],'in'),150,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>

<div class="FmTb">
	
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?> dsh_eml" >
	    
	    <?php 
			  
		  	$__tabs = [ 
		  				[ 'n'=>'cl', 't'=>'eml_cl', 'l'=>TX_ACNTS ],
		  				[ 'n'=>'are', 't'=>'eml_are', 'l'=>MDL_CL_ARE ],
						[ 'n'=>'us', 't'=>'eml_us', 'l'=>TX_USRS ],
						[ 'n'=>'box', 't'=>'eml_box', 'l'=>'Buzones' ]
		  			];
		  	
			$___Ls->_dvlsfl_all($__tabs,[ 'idb'=>'ok' ]);
			  
	  	?>
		 
		<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
            <ul class="TabbedPanelsTabGroup">
	            <?php echo $___Ls->tab->bsc->l ?>
	            <?php if(ChckSESS_superadm()){ echo $___Ls->tab->cl->l; } ?>
	            <?php echo $___Ls->tab->are->l ?>
				<?php echo $___Ls->tab->us->l ?>
				<?php echo $___Ls->tab->box->l ?>
            </ul>
            <div class="TabbedPanelsContentGroup">
	              
                    <div class="TabbedPanelsContent _main">	
                    	
                    	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
					      	<?php $___Ls->_bld_f_hdr(); ?>      
					        <div class="ln_1">
						        <div class="col_1">	
									
									<?php $l = __Ls(['k'=>'sis_eml', 'id'=>'eml_tp', 'va'=>$___Ls->dt->rw['eml_tp'], 'ph'=> MDL_SIS_EC_SGM_VAR_TP ]); echo $l->html; $CntWb .= $l->js; ?>
									<?php echo HTML_inp_tx('eml_nm', TX_NM , ctjTx($___Ls->dt->rw['eml_nm'],'in'), FMRQD); ?>
									<?php echo HTML_inp_tx('eml_eml', TX_EML , ctjTx($___Ls->dt->rw['eml_eml'],'in')); ?>
									<?php echo HTML_inp_tx('eml_usr', TX_US , ctjTx($___Ls->dt->rw['eml_usr'],'in')); ?>
									<?php if($___Ls->c_r->affected_rows == 0){ echo HTML_inp_tx('eml_pss', TX_PSS , ctjTx($___Ls->dt->rw['__pss'],'in'),'','','','','','',['tp'=>'password']); } ?>
									<?php echo HTML_inp_tx('eml_srv_in', 'Servidor (Entrada)', ctjTx($___Ls->dt->rw['eml_srv_in'],'in')); ?>
									<?php echo HTML_inp_tx('eml_prt_in', 'Servidor (Puerto)' , ctjTx($___Ls->dt->rw['eml_prt_in'],'in')); ?>
									
									<?php echo HTML_inp_tx('eml_srv_out', "Servidor (Salida)" , ctjTx($___Ls->dt->rw['eml_srv_out'],'in')); ?>
									<?php echo HTML_inp_tx('eml_prt_out', "Puerto (Puerto)" , ctjTx($___Ls->dt->rw['eml_prt_out'],'in')); ?>
									
									<?php $l = __Ls([ 'k'=>'sis_avtrs', 'id'=>'eml_avtr', 'va'=>$___Ls->dt->rw['eml_avtr'], 'ph'=>TX_AVTR]); echo $l->html; $CntWb .= $l->js; ?>
									
						        </div>
						        <div class="col_2">
							        
							        <?php if( mBln($___Ls->dt->rw['eml_aws_ses']) == 'ok'){ ?>
							        	<button class="snd_vrf" id="snd_vrf_<?php echo $___Ls->id_rnd; ?>">Enviar Código de Verificación</button>
							        	<div class="snd_vrf_rsl" id="snd_vrf_rsl_<?php echo $___Ls->id_rnd; ?>">Mensaje Enviado</div>
							        <?php } ?>
							   		
									<?php echo OLD_HTML_chck('eml_ssl', TX_LBL_SSL, $___Ls->dt->rw['eml_ssl'], 'in'); ?>
									<?php echo OLD_HTML_chck('eml_dfl', 'Default', $___Ls->dt->rw['eml_dfl'], 'in'); ?>
									<?php echo OLD_HTML_chck('eml_onl', TX_ONLN, $___Ls->dt->rw['eml_onl'], 'in'); ?>
									<?php echo OLD_HTML_chck('eml_sndr', 'Enviar (Sender)', $___Ls->dt->rw['eml_sndr'], 'in'); ?>
									<?php 
										if(ChckSESS_superadm()){
											echo OLD_HTML_chck('eml_aws_ses', 'AWS', $___Ls->dt->rw['eml_aws_ses'], 'in'); 
										}else{
											echo HTML_inp_hd('eml_aws_ses', $___Ls->dt->rw['eml_aws_ses']);
										}
									?>
									<?php echo OLD_HTML_chck('eml_sac', 'SAC (Recepción)', $___Ls->dt->rw['eml_sac'], 'in'); ?>
									
									<?php if($___Ls->dt->tot > 0 && ChckSESS_superadm()){ ?>
										<button id="eml_test" class="eml_test">Probar Conexión</button>
										<?php 
			
											$CntJV .= "	
											

												function Dom_Eml_Rbld(){
													
													$('#eml_test').off('click').click(function(e){

														e.preventDefault();
												
														if(e.target != this){ 
															e.stopPropagation(); return false;
														}else{
															_ldCnt({
																u:'".FL_DT_GN.__t('my_eml_stup', true)."&_s=upd&_i=".$___Ls->dt->rw['eml_enc']."',
																c:'',
																pop:'ok',
																pnl:{
																	e:'ok',
																	s:'l',
																	tp:'h'
																}
															});
														}
													});	

												}
												
												Dom_Eml_Rbld();

											";

										?>
									<?php } ?>

						        </div>	
					      	</div>
					    </form>         
					</div>
					<?php if(ChckSESS_superadm()){ ?>
                    <div class="TabbedPanelsContent">
                        <?php echo $___Ls->tab->cl->d ?>          
					</div>  
					<?php } ?>
                    <div class="TabbedPanelsContent">
                        <?php echo $___Ls->tab->are->d ?>          
                    </div>  
                    <div class="TabbedPanelsContent">
                        <?php echo $___Ls->tab->us->d ?>          
					</div>     
					<div class="TabbedPanelsContent">
                        <?php echo $___Ls->tab->box->d ?>          
                    </div>                                                 
              	</div>           
        </div>  	
	    
  	</div>
</div>
<?php	
	
	$CntJV .= " 
		
		var _btn_vrfc = $('#snd_vrf_".$___Ls->id_rnd."');
		var _btn_vrfc_rsl = $('#snd_vrf_rsl_".$___Ls->id_rnd."');
		
		_btn_vrfc.off('click').click(function(e){
			
			e.preventDefault();
			
			if(e.target != this){
		    	
		    	e.stopPropagation(); return;
		    	
			}else{

				_Rqu({ 
					t:'eml_vrfc', 
					_eml:'".$___Ls->dt->rw['eml_enc']."',
					_bs:function(){ _btn_vrfc.addClass('_ldn'); },
					_cm:function(){ _btn_vrfc.removeClass('_ldn'); },
					_cl:function(_r){ 
						if(!isN(_r)){ 
							if(_r.e == 'ok'){
								_btn_vrfc.fadeOut();	
								_btn_vrfc_rsl.fadeIn();
							}
						}
					} 
				});
				
			}
			
		});
					
	";

?>						

<style>
	
	
	.dsh_eml *{ background-repeat: no-repeat; background-position: center center; }
	.dsh_eml .snd_vrf{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>eml_vrfc.svg'); background-size: auto 60%; background-position: left 10px center; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; padding: 10px 15px 10px 45px; font-family: Economica; text-transform: uppercase; font-size: 16px; margin-left: auto; margin-right: auto; margin-bottom: 60px; display:block; margin-top: 40px; border: 1px solid #b3bbbe; cursor: pointer; }
	.dsh_eml .snd_vrf:hover{ background-color: #d9e1e3; }
	.dsh_eml .snd_vrf._ldn{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg'); background-size: auto 50%;  }
	
	.dsh_eml .snd_vrf_rsl{ display: none; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border:none; background-color:#e8eced; font-family: Economica; font-size: 16px; text-align: center; padding: 10px 15px; width: 100%; margin: 20px 0 30px; color: #3d6c12; }
	
	
	
	.dsh_eml .VTabbedPanels.mny._new > ul.TabbedPanelsTabGroup{ display: none; }
	.dsh_eml .VTabbedPanels.mny._new > div.TabbedPanelsContentGroup{ width: 100%; border: none; }
  	
  	.dsh_eml .VTabbedPanels.mny{ display: flex; }	
    .dsh_eml .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width:45px !important; }
    .dsh_eml .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
    .dsh_eml .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; }
    .dsh_eml .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent._main{ padding-top: 0; }
    
    
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 35px; min-width: 35px; max-width: 35px; background-repeat: no-repeat; opacity: 0.3; } 
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTabSelected,
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
    
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_eml.svg); }
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTab._cl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl.svg); }
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTab._are{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are.svg); }
    .dsh_eml .VTabbedPanels.mny .TabbedPanelsTab._us{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_us.svg); }
	.dsh_eml .VTabbedPanels.mny .TabbedPanelsTab._box{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_box.svg); }


    .dsh_eml .Tt_Tb{ padding-left: 20px; }
	
	.dsh_eml .eml_test{ display: block; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border: 1px solid #ccc; background-color:#fff; padding: 10px 15px; margin-left:auto; margin-right:auto; font-family:Economica; margin-top:30px; }
	.dsh_eml .eml_test::before{ width:20px; height:20px; display:inline-block; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_up.svg); background-repeat:no-repeat; background-size: auto 80%; background-position:center center; margin-bottom:-4px; margin-right:5px; }
	.dsh_eml .eml_test._ld{ opacity:0.5; pointer-events:none; }
	.dsh_eml .eml_test._ld::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg); }	
	.dsh_eml .eml_test.rdy{ border-color:green; color:green; }
			        
</style>
	

<?php } ?>
<?php } ?>