<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = '';
	$___Ls->_strt();
	
	$__Rnd_Var = Gn_Rnd(20);
	
	if($___Ls->_show_ls == 'ok'){
		
		if($__t == "snd_ec_lsts_var"){
			
			$_Lsts_Enc = $___Ls->gt->isb;
			
			$Ls_Whr = "	FROM ".TB_EC_LSTS_VAR."
							
							INNER JOIN ".TB_EC_LSTS." ON eclstsvar_lsts = id_eclsts
							INNER JOIN ".TB_SIS_EC_SGM_VAR." ON eclstsvar_var = id_sisecsgmvar
							INNER JOIN ".TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp
							INNER JOIN ".TB_SIS_EC_SGM." ON sisecsgmvar_sgm = id_sisecsgm 
				   		
				   		WHERE
						eclsts_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")."
						ORDER BY eclstsvar_fi DESC";
						
			$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	
		}else{
		
			$Ls_Whr = "	FROM ".TB_EC_LSTS_SGM_VAR."
							 INNER JOIN ".TB_SIS_EC_SGM_VAR." ON eclstssgmvar_var = id_sisecsgmvar
							 INNER JOIN ".TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp
							 INNER JOIN ".TB_SIS_EC_SGM." ON sisecsgmvar_sgm = id_sisecsgm 
				   		
				   		WHERE 	eclstssgmvar_sgm = (
									SELECT
										id_eclstssgm
									FROM
										ec_lsts_sgm
									WHERE
										eclstssgm_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")."
								) 
								
						ORDER BY eclstssgmvar_fi DESC";
						
			$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
		}
		
	} 
	
	$___Ls->_bld();
	
	$___sis_sgm = GtSisEcSgmLs();
	
	//echo json_encode($___Ls); exit();
	
	do {
		
		
		$__id_sgm = $___Ls->ls->rw['sisecsgm_enc'];
		$__id_var = $___Ls->ls->rw['sisecsgmvar_enc'];	
		
		if($__t == "snd_ec_lsts_var"){
			$__id_var_vl = $___Ls->ls->rw['eclstsvar_enc'];
		}else{
			$__id_var_vl = $___Ls->ls->rw['eclstssgmvar_enc'];
		}
		
		//if(!isN($___Ls->ls->rw['eclstssgmvar_vl'])){
			
			$__now_var[] = $__id_var_vl;

			if($__t == "snd_ec_lsts_var"){
				$__now_var_ls[$__id_sgm][ $__id_var_vl ]['id'] = ctjTx($___Ls->ls->rw['id_eclstsvar'], 'in');
				$__now_var_ls[$__id_sgm][ $__id_var_vl ]['vle'] = ctjTx($___Ls->ls->rw['eclstsvar_vl'], 'in');
				$__now_var_ls[$__id_sgm][ $__id_var_vl ]['vle_sub'] = ctjTx($___Ls->ls->rw['eclstsvar_vl_sub'], 'in');
			}else{
				$__now_var_ls[$__id_sgm][ $__id_var_vl ]['id'] = ctjTx($___Ls->ls->rw['id_eclstssgmvar'], 'in');
				$__now_var_ls[$__id_sgm][ $__id_var_vl ]['vle'] = ctjTx($___Ls->ls->rw['eclstssgmvar_vl'], 'in');
				$__now_var_ls[$__id_sgm][ $__id_var_vl ]['vle_sub'] = ctjTx($___Ls->ls->rw['eclstssgmvar_vl_sub'], 'in');
			}

			
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['enc'] = $__id_var_vl;
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['nm'] = ctjTx($___Ls->ls->rw['sisecsgmvar_nm'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['ls'] = ctjTx($___Ls->ls->rw['sisecsgmvar_ls'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['dt'] = ctjTx($___Ls->ls->rw['sisecsgmvar_dt'], 'in');
			
			
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['sis']['id'] = ctjTx($___Ls->ls->rw['id_sisecsgmvar'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['sis']['enc'] = $__id_var;
			
			
			
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['tp']['id'] = ctjTx($___Ls->ls->rw['id_sisecsgmvartp'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['tp']['nm'] = ctjTx($___Ls->ls->rw['sisecsgmvartp_nm'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['tp']['gts'] = ctjTx($___Ls->ls->rw['sisecsgmvartp_gts'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['tp']['ls'] = ctjTx($___Ls->ls->rw['sisecsgmvar_ls'], 'in');
			$__now_var_ls[$__id_sgm][ $__id_var_vl ]['tp']['dt'] = ctjTx($___Ls->ls->rw['sisecsgmvar_dt'], 'in');			
					
		//}
		
		if(!isN($__id_sgm)){
			$__now_sgm[] = $__id_sgm;
		}
		
	} while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc());
	
	
	$__now_var_ls = _jEnc($__now_var_ls);
	
	if($___sis_sgm->tot > 0){
		
		echo '<ul class="ec_lsts_sgm_var_dsh">';
		
		if(SISUS_ID == 181){
			//echo json_encode($___sis_sgm->ls);
		}
		
		foreach($___sis_sgm->ls as $___sis_sgm_k=>$___sis_sgm_v){
			
			if(in_array($___sis_sgm_v->enc, $__now_sgm)){ $_cls_fsgm='on'; }else{ $_cls_fsgm='off'; }
			
			echo '<li class="'.$_cls_fsgm.'" id="li_sgm_'.$___sis_sgm_v->enc.'">';
			
			echo '<div class="f_nm _anm" alt="'.$___sis_sgm_v->nm.'" title="'.$___sis_sgm_v->nm.'" style="background-image:url('.$___sis_sgm_v->img->big.')"></div>';
			
			if(count($___sis_sgm_v->var) > 0){
				
				echo '<ul class="_itms">';
				
				echo li(h2($___sis_sgm_v->nm), '_nm');
				
				//echo json_encode($__now_var_ls->{$___sis_sgm_v->enc});
				
				foreach($__now_var_ls->{$___sis_sgm_v->enc} as $_sgm_var_k=>$_sgm_var_v){
					
					if(in_array($_sgm_var_v->enc, $__now_var)){ $_cls_fvar='on'; }else{ $_cls_fvar='off'; }
					
					if( !isN($_sgm_var_v->vle) && $___sis_sgm_v->key == "cnt_attr" ){
						
						$_Cnt_Attr_Dt = __LsDt(['k'=>'cnt_attr', 'id'=>$_sgm_var_v->vle, 'tp'=>'id', 'no_lmt'=>'ok' ]);
						$_sgm_var_tt = $_Cnt_Attr_Dt->d->tt;
						
					}else{
						
						$__opt_vle = __GtSisEcSgmVarTp_Slc([
										'id'=>Gn_Rnd(30),
										'tp'=>$_sgm_var_v->tp,
										'sgm-enc'=>$___Ls->gt->isb,
										'var-enc'=>$_sgm_var_v->enc,
										'sis-sgm-enc'=>$___sis_sgm_v->enc,
										'sis-var-enc'=>$_sgm_var_v->sis->enc,
										'va'=>$_sgm_var_v->vle,
										't_sub'=>$__t,
										'lsts'=>( (!isN($_Lsts_Enc))? $_Lsts_Enc : NULL )
									]);
						$_sgm_var_tt = $__opt_vle->html;
						
					}
					
					/* @@@@@ Valor Atributos de cnt @@@@@ */
					if( !isN($_sgm_var_v->vle) && $___sis_sgm_v->key == "cnt_attr" ){
						
						$l = LsDmc([
					    		'attr'=>$_sgm_var_v->vle,
					    		'id'=>'cntapplattr_vl_'.$_sgm_var_v->enc.$__Rnd_Var,
					    		'va'=>$_sgm_var_v->vle_sub,
					    		'tp'=>'ls',
					    		'ph'=>'Seleccione',
					    		'attr_tp'=>'cnt_attr'
				    		]);
				    	$_var_vl_sub = ( ($l->e == "ok")? $l->html : HTML_inp_tx('cntapplattr_vl_'.$_sgm_var_v->enc.$__Rnd_Var, TX_VLR, $_sgm_var_v->vle_sub, '') );
						
					
					}else{
						$_var_vl_sub = NULL;
					}
					
					echo li(
						'<div class="f_opt _anm"><button class="rmv _anm" var-enc="'.$_sgm_var_v->enc.'" sis-sgm-enc="'.$___sis_sgm_v->enc.'">x</button></div>'.
						'<div class="f_var _anm">'.$_sgm_var_v->nm.'</div>'.
						'<div class="f_var_vl _anm" id="f_var_vl_'.$_sgm_var_v->enc.'">'.$_sgm_var_tt.'</div>'.
						'<div class="f_var_vl_sub f_var_vl_sub_'.$_sgm_var_v->enc.' _anm" id="f_var_vl_sub'.$_sgm_var_v->enc.'">'.$_var_vl_sub.'</div>'
					, $_cls_fvar.' _item_var', '', 'li_sgm_var_'.$_sgm_var_v->enc);
					
					$CntWb .= $__opt_vle->js;
					
					if( !isN($_sgm_var_v->vle) && $___sis_sgm_v->key == "cnt_attr" ){
						
						$CntWb .= "
							function __upd_sub_".$_sgm_var_v->enc.$__Rnd_Var."(_p=null){
								_Rqu({	
									t:'ec_lsts_sgm',
									tp:'var_upd_sub',
									t_sub:'".$__t."',
									lsts:'".$_Lsts_Enc."',
									sgm:'".$___Ls->gt->isb."',
									sis_sgm:'".$___sis_sgm_v->enc."',
									eclstssgmvar_vl_sub:_p.vl,
									id_eclstssgmvar:".$_sgm_var_v->id.",
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.e) && _r.e == 'ok'){
												
												
												/*$('#_sgm_var_add_bx_".$___sis_sgm_v->enc.$__Rnd_Var."').removeClass('on');
												
												$(_r.html).insertBefore('#li_sgm_".$___sis_sgm_v->enc." ul li._new');
												eval( _r.js );
												
												__slc.val(null).trigger('change');*/
			
												
											}
										}
									}
								});
							}
						";
						
						if($l->e == "ok"){  /* @@@@@ Si el vl_sub es un select @@@@@ */
							$CntWb .= $l->js;
							$CntWb .= "
								$('#cntapplattr_vl_".$_sgm_var_v->enc.$__Rnd_Var."').change(function(){
									__upd_sub_".$_sgm_var_v->enc.$__Rnd_Var."({ vl:$(this).val() });
								});
							";
						}else{ /* @@@@@ Si el vl_sub es un input text @@@@@ */
							$CntWb .= "
							
								$('#cntapplattr_vl_".$_sgm_var_v->enc.$__Rnd_Var."').focusout(function() {  
									if( !isN( $(this).val() ) ){
										__upd_sub_".$_sgm_var_v->enc.$__Rnd_Var."({ vl:$(this).val() });
									}
							    });
							    
							    $('#cntapplattr_vl_".$_sgm_var_v->enc.$__Rnd_Var."').keypress(function(e) {  
									if (e.keyCode == 13){
										if( !isN( $(this).val() ) ){
											__upd_sub_".$_sgm_var_v->enc.$__Rnd_Var."({ vl:$(this).val() });
										}						    
									}
							    });
							
							";
						}
					}
					
				}
				
				

				echo li(
						'<div class="f_var_new _anm" id="_sgm_var_add_bx_'.$___sis_sgm_v->enc.$__Rnd_Var.'">
							<button class="_add _anm" id="_sgm_var_add_btn_'.$___sis_sgm_v->enc.$__Rnd_Var.'">Add</button>
							<div class="_slc_opt">
								<div class="f_var _anm">
									'.LsSisEcEgSgmVar([
											'id'=>'new_'.$___sis_sgm_v->enc.$__Rnd_Var, 
											'v'=>'sisecsgmvar_enc', 
											'sgm'=>$___sis_sgm_v->id, 
											'attr'=>[
												'sgm-enc'=>$___Ls->gt->isb,
												'sis-sgm-enc'=>$___sis_sgm_v->enc
											]
									]).'
								</div>
								<div class="f_var_vl">seleccione opción</div>
							</div>
						</div>'
					, $_cls_fvar.' _new');

				$CntWb .= JQ_Ls('new_'.$___sis_sgm_v->enc.$__Rnd_Var, FM_LS_SLPRC);
				
				$CntWb .= "
					
					$('#_sgm_var_add_bx_".$___sis_sgm_v->enc.$__Rnd_Var." button._add').off('click').click(function(e){
						event.preventDefault();
						$('#_sgm_var_add_bx_".$___sis_sgm_v->enc.$__Rnd_Var."').addClass('on');
					});
					
					$('#new_".$___sis_sgm_v->enc.$__Rnd_Var."').change(function(){
						
						var __slc = $(this);
						
						var _sgm = __slc.attr('sgm-enc');
				    		var _sis_sgm = __slc.attr('sis-sgm-enc');
				    		var _sis_var = __slc.val();
						
						if(!isN(_sgm) && !isN(_sis_var)){
							_Rqu({	
								t:'ec_lsts_sgm',
								t_sub:'".$__t."',
								lsts:'".$_Lsts_Enc."',
								tp:'var_in', 
								sgm:_sgm,
								sis_sgm:_sis_sgm,
								sis_var:_sis_var,
								_bs:function(){ 
									$('#_sgm_var_add_bx_".$___sis_sgm_v->enc.$__Rnd_Var."').addClass('_ld');
								},
								_cm:function(){
									$('#_sgm_var_add_bx_".$___sis_sgm_v->enc.$__Rnd_Var."').removeClass('_ld');
								},
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.e) && _r.e == 'ok'){
											
											
											$('#_sgm_var_add_bx_".$___sis_sgm_v->enc.$__Rnd_Var."').removeClass('on');
											
											$(_r.html).insertBefore('#li_sgm_".$___sis_sgm_v->enc." ul li._new');
											eval( _r.js );
											
											__slc.val(null).trigger('change');
											
											
										}
									}
								}
				
							});
						}
						
						
					});

				";
					
									
				echo '</ul>';
			}
			
			echo '</li>';
			
		}
		
		
		$CntJV .= "
			
			
			
			function LstsSgmVarDsh_Dom(_p=null){
				
				$('.ec_lsts_sgm_var_dsh .f_opt button.rmv').off('click').click(function(e){
					
					event.preventDefault();
					
					var _var = $(this).attr('var-enc');
					var _sis_sgm = $(this).attr('sis-sgm-enc');

					if(!isN(_var)){	
						
						swal({									  
							  title: '".TX_ETSGR."',              
							  text: 'Deseas borrar este registro?',  
							  type: 'warning',         
							  showLoaderOnConfirm: true,               
							  showCancelButton: true,                 
							  confirmButtonClass: 'btn-danger',       
							  confirmButtonText: '".TX_YESDLT."',      
							  confirmButtonColor: '#E1544A',          
							  cancelButtonText: '".TX_CNCLR."',           
							  closeOnConfirm: true                   
							},										  
						function(){  
							                             					
							_Rqu({
								t:'ec_lsts_sgm',
								tp:'var_del', 
								var:_var,
								t_sub:'".$__t."',
								lsts:'".$_Lsts_Enc."',
								sis_sgm:_sis_sgm,
								_bs:function(){ 
									$('#li_sgm_var_'+_var+' .f_var_vl').addClass('_ld');
								},
								_cm:function(){
									$('#li_sgm_var_'+_var+' .f_var_vl').removeClass('_ld');
								},
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.e) && _r.e == 'ok'){	
											
											$('#li_sgm_var_'+_var).remove();
											
											setTimeout(function(){  
												
												var _tot_itms = $('#li_sgm_'+_sis_sgm+' ul._itms li._item_var').length;	
												
												if(_tot_itms == 0){ 
													
													$('#li_sgm_'+_sis_sgm).removeClass('on').addClass('off');
													
												}

											}, 300);
											
											
										}
									}
								}
				
							});
						
						});
						
					}
					
					
				});
			
			}	
			
		";
		
		$CntWb .= " LstsSgmVarDsh_Dom(); ";	
			
		echo '</ul>';
	
	}

?>
<style>
	
	.ec_lsts_sgm_var_dsh *{ list-style: none; padding: 0; margin: 0; background-repeat: no-repeat; background-position: center center; }
	.ec_lsts_sgm_var_dsh{ width: 100%; display: block; padding: 0; }
	.ec_lsts_sgm_var_dsh > li{ width: 100%; display: flex; border-bottom: 1px dotted #c6cbcf; padding-left: 20%; margin-bottom: 30px; padding-bottom: 40px; position: relative; overflow: hidden; }
	.ec_lsts_sgm_var_dsh > li .f_nm{ /*border: 1px solid #969596;*/ position: absolute; left: -20px; top: 0; width: 20%; height: 100px; display: block; border-radius:8px;-moz-border-radius:8px; -webkit-border-radius:8px; background-size: auto 60%; background-position: left center; -webkit-transform: rotate(-30deg); transform: rotate(-30deg); -webkit-filter: grayscale(100%); filter: grayscale(100%); opacity: 0.2; pointer-events: none; }
	.ec_lsts_sgm_var_dsh > li:hover .f_nm,
	.ec_lsts_sgm_var_dsh > li.on .f_nm{ -webkit-transform: rotate(0deg); transform: rotate(0deg); -webkit-filter: grayscale(0%); filter: grayscale(0%); opacity: 1; left: 20px; }
	

	
	
	.ec_lsts_sgm_var_dsh > li > ul{ display: inline-block; width: 100%; padding: 0; }
	
	.ec_lsts_sgm_var_dsh > li > ul > li{ width: 100%; display: flex; cursor: pointer; }
	
	
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new{ width: 100%; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new ._slc_opt{ display: none; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new.on ._slc_opt{ display: flex; }
	
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new._ld ._slc_opt{ pointer-events: none; position: relative; min-height: 60px; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new._ld ._slc_opt::before{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); display: block; height: 30px; width: 30px; background-repeat: no-repeat; background-position: center center; position: absolute; left: 50%; top: 50%; margin-left: -15px; margin-top: -19px; background-size: auto 100%; z-index: 10; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new._ld ._slc_opt .f_var,
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new._ld ._slc_opt .f_var_vl{ display: none; }
	

	
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new ._add{ text-indent: -2000px; overflow: hidden; background-color: transparent; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_add.svg'); height: 30px; width: 30px; background-size: auto 90%; border: none; margin-top: 5px; }

	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new ._add:hover{ background-size: auto 100%; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_new.on ._add{ display: none; }
	
	.ec_lsts_sgm_var_dsh > li > ul > li.off .f_var{ opacity: 0.3; }
	.ec_lsts_sgm_var_dsh > li > ul > li.off .f_var_vl{ opacity: 0.3; }
	
	
	.ec_lsts_sgm_var_dsh > li > ul > li.on .f_var, .ec_lsts_sgm_var_dsh > li > ul > li.on .f_var_vl{ border: 2px dashed var(--second-bg-color); }

	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_vl._ld{ pointer-events: none; position: relative; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_vl._ld::before{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); display: block; height: 30px; width: 30px; background-repeat: no-repeat; background-position: center center; position: absolute; left: 50%; top: 50%; margin-left: -15px; margin-top: -19px; background-size: auto 100%; z-index: 10; }
	
	.ec_lsts_sgm_var_dsh > li > ul > li:hover .f_opt{ display: block; }
	.ec_lsts_sgm_var_dsh > li > ul > li:hover .f_var{ opacity: 1 !important; width: 50%; }
	.ec_lsts_sgm_var_dsh > li > ul > li:hover .f_var_vl{ opacity: 1 !important; }
	
	
	.ec_lsts_sgm_var_dsh > li > ul > li._nm{ font-family: Economica; font-weight: 500; text-transform: uppercase; font-size: 14px; color: #abb4b6; }
	.ec_lsts_sgm_var_dsh > li > ul > li._nm h2{ font-size: 14px; width: 100%; margin-bottom: 20px; }
	
	
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var, .ec_lsts_sgm_var_dsh > li > ul > li .f_var_vl{ width: 60%; border-radius:8px;-moz-border-radius:8px; -webkit-border-radius:8px; background-color: #e5ebf0; padding: 10px 13px; margin-bottom: 5px; margin-right: 5%; font-size: 12px; font-family: Roboto; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_var_vl{ width: 35%; }
	
	
	.ec_lsts_sgm_var_dsh > li > ul > li .f_opt{ display: none; width: 10%; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_opt button.rmv{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'ec_img_rmv.svg') ?>); background-repeat: no-repeat; background-position: center center; background-size: auto 98%; background-color: transparent; border: 0; width: 30px; height: 30px; text-indent: -2000px; overflow: hidden; margin-right: 6px; margin-top: 4px; }
	.ec_lsts_sgm_var_dsh > li > ul > li .f_opt button.rmv:hover{ background-size: auto 70%; }



	.ec_lsts_sgm_var_dsh .__rtio{ display: flex; padding-top: 8px; }
	.ec_lsts_sgm_var_dsh .__rtio .star-rating-control{ margin-left: auto; margin-right: auto;}
	
	
	.ec_lsts_sgm_var_dsh input[type=text]{ text-align: center; }
	.ec_lsts_sgm_var_dsh input._clndr._fl,
	.ec_lsts_sgm_var_dsh input.__clndr._fl{ background-image: none !important; }
	
	
</style>
<?php } ?>