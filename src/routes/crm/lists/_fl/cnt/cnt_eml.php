<?php 
	
	if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'cnt_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT * 
								FROM ".TB_CNT_EML." 
								INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "FROM ".TB_CNT_EML."
						 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt	
						 LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
						 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
				   	    ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cnteml_est', 'als'=>'est'])." 					
				   WHERE id_cnteml != '' $__fl ".$___Ls->sch->cod." 
				   ORDER BY cnteml_fi DESC";
				   
			$___Ls->qrys = "SELECT id_cnteml, cnteml_enc, cnteml_eml, cnteml_cld, cnteml_tp, cntplcy_sndi,
									(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
									"._QrySisSlcF([ 'als'=>'est', 'als_n'=>'estado' ]).",
									".GtSlc_QryExtra(['t'=>'fld', 'p'=>'estado', 'als'=>'est'])."
							$Ls_Whr";

		//echo $___Ls->qrys;
	}
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<style>
	.ls_plcy{list-style-type: none;margin: 5px 0;padding: 0; }
	.ls_plcy li{color: #a0a0a0;font-size: 11px;}
	.ls_plcy li.plcy_1 span,
	.ls_plcy li.plcy_2 span{ width: 15px;height: 15px;display: inline-block;vertical-align: middle;margin-right: 10px;margin-bottom: 5px; }
	.ls_plcy li.plcy_1 span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG; ?>cnt_sndi_ok.svg);}
	.ls_plcy li.plcy_2 span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG; ?>cnt_sndi_no.svg);}
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">	
  	<thead>
	    <tr>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_EST; ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_TP; ?></th>
	        <th width="85%" <?php echo NWRP ?>><?php echo TX_EML; ?></th>    
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_CLDEML; ?></th>
	        <th width="1%" <?php echo NWRP ?>></th>
	        <th width="1%" <?php echo NWRP ?>></th>
	    </tr>
  	</thead>
  	<tbody>
	<?php do { 
		
		$__ls_json[] = $___Ls->ls->rw['cnteml_enc'];
		
		if($___Ls->ls->rw['cnteml_tp'] == 1){
			$_eml_tp = "Personal";
		}else{
			$_eml_tp = "Corporativo";
		}	

		$__eml_nrml = 	_plcy_scre([ 
			't'=>'eml',
			'v'=>ctjTx($___Ls->ls->rw['cnteml_eml'],'in'),
			'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]  
		]);

	?>
    	<tr cnteml-id-no="<?php echo $___Ls->ls->rw['id_cnteml']; ?>">
	    	<td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['estado_sisslc_tt'],'in'),50); ?></td>
	        <td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($_eml_tp,'in'),50); ?></td>
	        <td width="85%" align="left" nowrap="nowrap">
		        <?php echo ShortTx($__eml_nrml,50); ?>
		        <?php echo bdiv([ 'cls'=>'bx_ul_plcy' ]) ?>
		    </td>
	        <td width="1%" align="left" nowrap="nowrap">
	        <?php       
		        $__sis_cld = LsSis_Cld([ 'id'=>'St_'.$___Ls->ls->rw[$___Ls->ino], 'v'=>'enc', 'va'=>$___Ls->ls->rw['cnteml_cld'], 'rq'=>2, 'dsbl'=>'ok' ]); 
		        echo $__sis_cld->html; $CntWb .= $__sis_cld->js;
	        ?>
	        </td>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo Spn(_Tme($___Ls->ls->rw['cnteml_fi'], 'sng')); ?></td> 
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>  
      </tr>
      <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
      <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>
</table>                                                                                                                                                                                                      
<?php 
	$CntJV .=	"

		function __getCntEml(){

			$.post('".Fl_Rnd(FL_JSON_GN.__t('cnt_eml_ext',true))."', { mdl_mdls:'".$___Ls->mdlstp->tp."', mdlcnt:'".implode(',', $__ls_json)."' },
            
            function(d, status){
               	if(d.e == 'ok'){
                    if( d.total > 0 ){
                        $.each(d.l, function(_k, _v) { 
                            if(!isN(_v.plcy)){
	                        	
		                        $('tr[cnteml-id-no='+_v.id+'] .bx_ul_plcy').html( '<ul class=\"ls_plcy\">'+_v.plcy+'</ul>' );	
	                        	
                            }
                        });
                    }  
                }
            }); 
        } 
	";
	
	$CntWb .= " setTimeout(function(){ __getCntEml(); ".$__grph_shw." }, 1000); ";
	
	
?>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ 
	
	$____plcy = GtCntEmlPlcyLs([ 'eml'=>$___Ls->dt->rw['id_cnteml'], 'e'=>'on' ]);
?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      	<?php $___Ls->_bld_f_hdr(); ?>

			<?php 
				$__tabs = [
					['n'=>'cnt_eml_sgm', 't'=>'cnt_eml_sgm', 'l'=> 'Segmentos']
				];
		
				$___Ls->_dvlsfl_all($__tabs);

				$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
				$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
				$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  
			?>
			<style>
				.data_cnt_eml .TabbedPanelsTabGroup li{ width: 40px !important; height: 40px; }
				.data_cnt_eml .TabbedPanelsContentGroup{width: calc(100% - 50px) !important;}
				.data_cnt_eml.VTabbedPanels .TabbedPanelsTab{background-position: center !important;background-repeat: no-repeat !important;background-size: 70% auto;}
				.data_cnt_eml.VTabbedPanels .TabbedPanelsTab._bsc { background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg);}
				.data_cnt_eml.VTabbedPanels .TabbedPanelsTabSelected._bsc { background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg);}
				.data_cnt_eml.VTabbedPanels .TabbedPanelsTab._cnt_eml_sgm { background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_ec_lsts_sgm.svg);}
				.data_cnt_eml.VTabbedPanels .TabbedPanelsTabSelected._cnt_eml_sgm { background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_ec_lsts_sgm_w.svg);}
			</style>
			<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny data_cnt_eml">
				<ul class="TabbedPanelsTabGroup" style="width: 50px !important;background-color: transparent !important;">
					<?php echo $___Ls->tab->bsc->l ?>
					<?php 
						if(_ChckMd('cnt_eml_sgm')){
							echo $___Ls->tab->cnt_eml_sgm->l; 	
						}
					?>
				</ul>
				<div class="TabbedPanelsContentGroup">
					<div class="TabbedPanelsContent">
						<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
							<div class="ln_1 dsh_cnt_eml <?php if(($___Ls->dt->tot == 0)){ echo '_new'; } ?>">
								<div class="col_1">	
									<?php echo HTML_inp_hd('cnteml_cnt', _SbLs_ID('i')); ?>
									<?php echo HTML_inp_tx('cnteml_eml', TT_FM_EML, ctjTx($___Ls->dt->rw['cnteml_eml'],'in'), FMRQD_EM); ?>                                                                                                                                                                                                                                                                                                                                                                
									<?php echo HTML_inp_hd('cnteml_eml_bfr',ctjTx($___Ls->dt->rw['cnteml_eml'],'in') ); ?> 
									
									<?php 
											if(($___Ls->dt->tot == 0)){ 
												echo LsPlcy('_cnt_plcy_eml', 'clplcy_enc', '', FM_LS_PLCY, 'ok', '', [ 'cl'=>CL_ENC ] ); $CntWb .= JQ_Ls('_cnt_plcy_eml', '');	
											} 
									?>
									
									<?php echo h2(TX_CLDEML); ?>
									<?php 	
										$__sis_cld = LsSis_Cld([ 'id'=>'cnteml_cld', 'v'=>'enc', 'va'=>$___Ls->dt->rw['cnteml_cld'], 'rq'=>2, 'dsbl'=>'ok' ]); 
										echo $__sis_cld->html; $CntWb .= $__sis_cld->js;
									?>
									
								</div>
								<div class="col_2">
									<?php echo h2(MDL_HBSDTA); ?>
									<?php 
										
										if($____plcy->tot > 0){
											
											foreach($____plcy->ls as $plcy_k=>$plcy_v){
												
												if($plcy_v->tot>0){ $cls='on'; $cls_v=1; }else{ $cls='off'; $cls_v=2; }
												$__dattr = ' data-cnteml="'.$___Ls->dt->rw['cnteml_enc'].'" data-plcy="'.$plcy_v->enc.'" ';
												
												$__plcy_li .= li(
																bdiv([
																	'cls'=>'wrp',
																	'c'=>
																		bdiv([
																			'c'=>$plcy_v->nm.Spn(TX_VRSN.' '.$plcy_v->v),
																			'cls'=>'tt'
																		]).
																		bdiv([
																			'c'=>'	<button class="on _anm" '.$__dattr.'>Recibir</button>
																					<button class="off _anm" '.$__dattr.'>No recibir</button>',
																			'cls'=>'opt' 
																		])
																]),
																$cls,
																'',
																'plcy_'.$___Ls->dt->rw['cnteml_enc'].'_'.$plcy_v->enc
															);
											}
											
											echo ul($__plcy_li, '_plcy_ls');
										}
										
									?>
									
								</div>	
							</div>           
						</div>
					</div>
					<?php if(_ChckMd('cnt_eml_sgm')){ ?>
						<div class="TabbedPanelsContent">
							<!-- Inicia Documentos -->
								<div class="ln">
									<?php echo $___Ls->tab->cnt_eml_sgm->d ?>
								</div>
							<!-- Finaliza Documentos -->
						</div>
					<?php } ?>
				</div>
			</div>           
	    </form>
  	</div>
</div>
<?php
	
	
	if(_ChckMd('chck_snd_i')){
		        
	
		$CntWb .= " 
		
			$('.dsh_cnt_eml ._plcy_ls > li .opt button').off('click').click(function(e){
					
				e.preventDefault();
				
				if(e.target != this){ 
					
			    	e.stopPropagation(); return false;
			    	
				}else{
					
					if( $(this).hasClass('off') ){ 
						var _tx = '¿El usuario no desea recibir mas información?';
						var _tp = 'warning'; 
						var _clr = '#a12424';
						var _e = 2;
						var _e_c = 'off';
					}else{ 
						var _tx='¿El usuario desea recibir nuestra información?'; 
						var _tp = 'info'; 
						var _clr = '#64b764';
						var _e = 1;
						var _e_c = 'on';
					}
					
					var _cnteml = $(this).attr('data-cnteml');
					var _plcy = $(this).attr('data-plcy');
						
					swal({
						title: '".TX_HBSACCPT."',
						text: _tx,
						type: _tp,
						showCancelButton: true,
						confirmButtonColor: _clr,
						confirmButtonText:'".TX_ACPT."',
						cancelButtonText:'".TX_CNCLR."',
						showLoaderOnConfirm: true,
						closeOnConfirm: false
					},
					function(){
						
						_Rqu({ 
							t:'cnt_eml_sndi', 
							plcy:_plcy,
							cnteml:_cnteml,
							est:_e,
							_bs:function(){  },
							_cm:function(){  },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.e) && _r.e=='ok'){
										console.log('Add class '+_e_c);
										swal('Cambio Exitoso', '".TX_APROEXT."', 'success');	
										$('#plcy_'+_cnteml+'_'+_plcy).removeClass('on off').addClass(_e_c);
									}else{
										swal('Error', '".TX_NSAPRB."','error');		
									}									
								}
							} 
						});	
						
					});
					
				}
				
			});	
			
				
		";
	
	
	}else{
					
					
		$CntWb .= " 

			$('.dsh_cnt_eml ._plcy_ls > li .opt button').off('click').click(function(e){
					
				e.preventDefault();
				
				if(e.target != this){ 	
			    		e.stopPropagation(); return false;
				}else{	
					swal({
						title: '".TX_HBSACCPT."',
						text: 'No cuenta con este permiso',
						type: 'warning',
						confirmButtonColor: '#a12424',
						confirmButtonText: 'Entendido',
						closeOnConfirm: true
					});	
				}	
			});	
			
				
		";
		
		
	}
		
    
?>
<style>
	
	.dsh_cnt_eml{ width: 95%; margin-left: auto; margin-right: auto; margin-top: 70px; }
	.dsh_cnt_eml h2{ padding-top: 0; margin-top: 0; }
	
	
	.dsh_cnt_eml._new .col_1{ display: block; width: 100%; border: none; }
	.dsh_cnt_eml._new .col_2,
	.dsh_cnt_eml._new .__rtio,
	.dsh_cnt_eml._new h2{ display: none; }
	

</style>

<?php } ?>
<?php } ?>
