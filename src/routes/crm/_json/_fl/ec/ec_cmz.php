<?php 
	
	$__ec_cmz = new API_CRM_ec_Cmz();

	$_id_eccmz = $_POST['id_eccmz'];
	$__cdg = $_POST['cdg'];
	$__w = $_POST['w'];
	$__dir = $_POST['_dir'];
	$__hdr = $_POST['_hdr'];
	$__hdr_tp = $_POST['_hdr_tp'];
	$__clr = $_POST['_clr'];
	$__sgm_id = $_POST['sgm'];
	
	$__crt_all = GtSisEcCrt_Ls();
	
	if($_POST['chr'] == 'ok'){
		
		$_id_div = $__sgm_id;
		$Chk_sgm = ChkEcEdtSgm([ 'sgm'=>$_id_div, 'eccmz'=>$_id_eccmz ]);
		$chr_e = GtEcCmzSgmChrLs([ 'sgm'=>$Chk_sgm->id, 'arr'=>'ok' ]);
		//$rsp['c'] = $_id_eccmz.' sgm-> '.$_id_div.'arr->'.print_r($chr_e, true);
		
		function EcCmzChr($_p=NULL){
			
			global $__cnx;
			 
			$Ls_Qry = "	SELECT * 
						FROM ".TB_SIS_EC_CHR."
							 INNER JOIN ".TB_SIS_EC_CHR_GRP." ON sisecchr_grp = id_sisecchrgrp
						WHERE sisecchr_sgm = 1 
						ORDER BY sisecchrgrp_tt ASC, sisecchr_grp ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
			
				$i = 0;
					
				do {
					if(!isN($_p['chr_v'])){
						$Vl[$i]['vlrs'] = $_p['chr_v'];
					}else{
						$Vl[$i]['vlrs'] = 'si';
					}
					
					$Vl['tp'] = $row_Ls['sisecchr_tp'];
					$Vl[$i]['grp'] = $row_Ls['sisecchr_grp'];
					$Vl[$i]['cls'] = $row_Ls['sisecchrgrp_cls'];
					$Vl[$i]['tt'] = ctjTx($row_Ls['sisecchrgrp_tt'],'in');
					
					if($row_Ls['sisecchr_tp'] == 10){
						$Vl[$i]['html'] .= '<div class="__inp_chr" style="position:relative; padding: 5px;">';
						$Vl[$i]['html'] .= HTML_inp_clr('eccmzsgmchr_vle_'.$row_Ls['id_sisecchr'], ctjTx($row_Ls['sisecchr_tt'],'in') , '','','','_clr _inp_chr');
						$Vl[$i]['html'] .= '<label>'.ctjTx($row_Ls['sisecchr_tt'],'in').'</label>';
						$Vl[$i]['html'] .= '</div>';
						$Vl[$i]['html'] .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css" />';
						if($_p['_clr'] != ''){ $_add_clr = ", '".$_p['_clr']."'"; }else{ $_add_clr = ""; }
						$Vl[$i]['js'] .=" 
						
						
								$('#eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."').spectrum({
									
									color: '".$_p['chr_v'][$row_Ls['id_sisecchr']]['vle']."',
								    showPaletteOnly: true,
								    showPalette:true,
								    hideAfterPaletteSelect:true,
								    palette: [
								        ['#000','#444','#666','#999','#ccc','#eee','#f3f3f3','#fff'],
								        ['#d9ead3','#b6d7a8','#93c47d','#6aa84f','#38761d','#274e13','#0f0' ".$_add_clr."]
								    ],
								    change: function(color){
									   			var _vle_chr_".$row_Ls['id_sisecchr']." = color.toHexString();
												var _chr_sgm = $('#eccmzsgm_sgm').val();
												var _id_eccmz = $('#id_eccmz').val();
												SUMR_Ec.f.edt_sve({
														'_t':'snd_ec_cmz',
														'_d':{
															'MM_insert_chr':'EdEcCmz',
															'eccmzsgm_sgm': _chr_sgm,
															'eccmzsgmchr_chr': '".$row_Ls['id_sisecchr']."',
															'id_eccmz': _id_eccmz,
															'eccmzsgmchr_vle': _vle_chr_".$row_Ls['id_sisecchr']."
														}, 
														'_dvs': 'eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."'
												});
								    }
								});";
							
		
					}elseif($row_Ls['sisecchr_tp'] == 1){
						
						$Vl[$i]['html'] .= '<div class="__inp_chr">';
						$Vl[$i]['html'] .= HTML_inp_tx('eccmzsgmchr_vle_'.$row_Ls['id_sisecchr'], ctjTx($row_Ls['sisecchr_tt'],'in'), $_p['chr_v'][$row_Ls['id_sisecchr']]['vle'],'','','_inp_chr');
						$Vl[$i]['html'] .= '</div>';
						$Vl[$i]['js'] .= "$('#eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."').off('focusout').blur(function() {
												var _vle_chr_".$row_Ls['id_sisecchr']." = $('#eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."').val();
												var _chr_sgm = $('#eccmzsgm_sgm').val();
												var _id_eccmz = $('#id_eccmz').val();
												SUMR_Ec.f.edt_sve({
														'_t':'snd_ec_cmz',
														'_d':{
															'MM_insert_chr':'EdEcCmz',
															'eccmzsgm_sgm': _chr_sgm,
															'eccmzsgmchr_chr': '".$row_Ls['id_sisecchr']."',
															'id_eccmz': _id_eccmz,
															'eccmzsgmchr_vle': _vle_chr_".$row_Ls['id_sisecchr']."
														}, 
														'_dvs': 'eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."'
												});	
											});";
						
						
					}elseif($row_Ls['sisecchr_tp'] == 7){
						$Vl[$i]['html'] .= '<div class="__inp_chr">';
						$Vl[$i]['html'] .= LsSisEcChr('eccmzsgmchr_vle_'.$row_Ls['id_sisecchr'], 'sisecchrls_css', $_p['chr_v'][$row_Ls['id_sisecchr']]['vle'] , ctjTx($row_Ls['sisecchr_tt'],'in'), 1, '', array('fl'=>$row_Ls['id_sisecchr']));
						$Vl[$i]['js'] .= JQ_Ls('eccmzsgmchr_vle_'.$row_Ls['id_sisecchr'], ctjTx($row_Ls['sisecchr_tt'],'in'));
						$Vl[$i]['html'] .= '</div>';
						$Vl[$i]['js'] .= "$('#eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."').change(function() {
												var _vle_chr_".$row_Ls['id_sisecchr']." = $('#eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."').val();
												var _chr_sgm = $('#eccmzsgm_sgm').val();
												var _id_eccmz = $('#id_eccmz').val();
												SUMR_Ec.f.edt_sve({
														'_t':'snd_ec_cmz',
														'_d':{
															'MM_insert_chr':'EdEcCmz',
															'eccmzsgm_sgm': _chr_sgm,
															'eccmzsgmchr_chr': '".$row_Ls['id_sisecchr']."',
															'id_eccmz': _id_eccmz,
															'eccmzsgmchr_vle': _vle_chr_".$row_Ls['id_sisecchr']."
														}, 
														'_dvs': 'eccmzsgmchr_vle_".$row_Ls['id_sisecchr']."'
												});	
											});";
						
						
					}else{
						$Vl[$i]['html'] .= 'no tiene tipo el campo';
					}
						
					
				$i ++;
				
				} while ($row_Ls = $Ls->fetch_assoc());
			
			}
			
			$__cnx->_clsr($Ls);
					
			return _jEnc($Vl);	
			
		}
		
		$_ls_chr = EcCmzChr([ 'chr_v'=>$chr_e, '_clr'=>$__clr ]);
		
		foreach($_ls_chr as $_k => $_v){ 
			$_chrs[$_v->grp]['tt'] = $_v->tt;
			$_chrs[$_v->grp]['cls'] = $_v->cls;
			$_chrs[$_v->grp]['html'] .= $_v->html;
			$js_chrs .= $_v->js;
		}

		foreach($_chrs as $_k => $_v){
			/*if($_v['html'] != NULL){
				$_id_cllp = 'CP_'.Gn_Rnd(20);
				$_chrf .= bdiv(array('c'=>'<div id="'.$_id_cllp.'" class="CollapsiblePanel _anm '.$_v['cls'].'">
												<div class="CollapsiblePanelTab _anm">
													<p class="fld_tt">'.$_v['tt'].'</p>
												</div>
												<div class="CollapsiblePanelContent _anm">
													'.$_v['html'].'
												</div>', 
									'sty'=>''));
				$_js_pnl .= 'var '.$_id_cllp.' = new Spry.Widget.CollapsiblePanel("'.$_id_cllp.'", {contentIsOpen:false});';
			}*/
		}
		
		$_gt_ec_cmzlsts = ChkEcCmzLsts([ 'eccmz'=>$_id_eccmz, 'up'=>'ok' ]);	
		
		if($_gt_ec_cmzlsts->col != ''){
			$_obj_col = json_decode($_gt_ec_cmzlsts->col);
			$_col_bd .= '<ul id="EcTagList" class="_anm ls_ec_tag _li_lsts_bd">';
			foreach($_obj_col as $_k => $_v){
				if(substr($_v,0,1) == '[' && substr($_v, -1) == ']'){
					$_col_bd .= '<li>'.$_v.'</li>';
					//print_r($_v);
				}
			}
			$_col_bd .= '</ul>';
			$_col_bd_js .= "SUMR_Main.ld.f.html(function(){ SUMR_Ec.f.tags({ id:'#EcTagList li' }); });";
		}
		
		
		$rsp['c'] = $_col_bd.$_chrf;//print_r($_obj_col, true);
		$rsp['e'] = 'ok';//$_col_bd.$_chrf;
		$rsp['j'] = $js_chrs.$_js_pnl.$_col_bd_js;
		
		
		
	}elseif($_POST['chr'] == 'img'){
		
		
		$_id_div = $_POST['img'];
		$Chk_img = ChkEcCmzImg(array('img'=>$_id_div, 'eccmz'=>$_id_eccmz));
		$chr_e_i = GtEcCmzImgChrLs(array('img'=>$Chk_img->id));
		//$rsp['c'] = $_id_eccmz.' sgm-> '.$_id_div.'arr->'.print_r($chr_e_i_i, true);
		
		function EcCmzChr($_p=NULL){
			
			global $__cnx;
			
			$Ls_Qry = "SELECT * FROM ".TB_SIS_EC_CHR." WHERE sisecchr_img = 1 ORDER BY id_sisecchr ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			
				$i = 0;
					
				do {
					
					if(!isN($_p['chr_v'])){
						$Vl[$i]['vlrs'] = $_p['chr_v'];
					}else{
						$Vl[$i]['vlrs'] = 'si';
					}
					
					//print_r($chr_e_i);
					
					$Vl['tp'] = $row_Ls['sisecchr_tp'];
					 
					if($row_Ls['sisecchr_tp'] == 10){
						$Vl[$i]['html'] .= '<div class="__inp_chr">';
						$Vl[$i]['html'] .= HTML_inp_clr('eccmzimgchr_vle_'.$row_Ls['id_sisecchr'], ctjTx($row_Ls['sisecchr_tt'],'in') , $_p['chr_v'][$i]->vle,'','','_clr _inp_chr');
						$Vl[$i]['html'] .= '</div>';
						
		
					}elseif($row_Ls['sisecchr_tp'] == 1){
						$Vl[$i]['html'] .= '<div class="__inp_chr">';
						$Vl[$i]['html'] .= HTML_inp_tx('eccmzimgchr_vle_'.$row_Ls['id_sisecchr'], ctjTx($row_Ls['sisecchr_tt'],'in'), $_p['chr_v'][$i]->vle,'','','_inp_chr');
						$Vl[$i]['html'] .= '</div>';
						
						
					}else{
						$Vl[$i]['html'] .= 'no tiene tipo el campo';
					}
						$Vl[$i]['js'] .= "$('#eccmzimgchr_vle_".$row_Ls['id_sisecchr']."').off('focusout').blur(function() {
										
												var _vle_chr_".$row_Ls['id_sisecchr']." = $('#eccmzimgchr_vle_".$row_Ls['id_sisecchr']."').val();
												var _chr_img = $('#eccmzimg_img').val();
												var _id_eccmz = $('#id_eccmz').val();
												SUMR_Ec.f.edt_sve({
														'_t':'snd_ec_cmz',
														'_d':{
															'MM_insert_chrimg':'EdEcCmz',
															'eccmzimg_img': _chr_img,
															'eccmzimgchr_chr': '".$row_Ls['id_sisecchr']."',
															'id_eccmz': _id_eccmz,
															'eccmzimgchr_vle': _vle_chr_".$row_Ls['id_sisecchr']."
														}, 
														'_dvs': 'eccmzimgchr_vle_".$row_Ls['id_sisecchr']."'
												});	
											});";
					
				$i ++;
				} while ($row_Ls = $Ls->fetch_assoc());
			
			
			$__cnx->_clsr($Ls);
			
				
			$rtrn = json_decode(json_encode($Vl)); 
			return($rtrn);	
		}
		
		$_ls_chr = EcCmzChr(array('chr_v'=>$chr_e_i));
		
		
		foreach($_ls_chr as &$_v_chr){
			$_chrs .= $_v_chr->html;
			$js_chrs .= $_v_chr->js;
		}

		$rsp['c'] = $_chrs;
		$rsp['e'] = 'ok';//$_chrs;
		$rsp['j'] = $js_chrs;
	
	
	}elseif($_POST['_prc'] == 'cmnt_new'){
		
		
		$c_DtRg = "-1";if (isset($__i)){$c_DtRg = preg_replace('/\s+/','',$__i);}
		
		$query_DtRg = sprintf('INSERT INTO '._BdStr(DBM).TB_EC_CMNT.' (eccmnt_ec, eccmnt_cmnt, eccmnt_us) VALUES (%s, %s, %s)', 
								GtSQLVlStr(ctjTx($_POST['_ec'],'out'), 'int'),
								GtSQLVlStr(ctjTx($_POST['_cmnt'],'out'), 'text'),
								GtSQLVlStr(ctjTx($_POST['_us'],'out'), 'int'));
		
		$DtRg = $__cnx->_prc($query_DtRg); 
		
		if($DtRg){
			
			$Tot_DtRg = $DtRg->num_rows;	
			
			if($DtRg){		
				$rsp['e'] = 'ok';	
			}else{	
				$rsp['e'] = 'no';
				$rsp['qry'] = $query_DtRg;
				$rsp['error'] = $__cnx->c_p->error;		
			}
			
		}
		
		$Dt_Rg->free; 
			
	}else{
		
		$_sgm_dt = GtEcCmzSgmDt([ 'cmz'=>$_id_eccmz ]); 		
		$_cdg_f = $__cdg;

		foreach($__crt_all as $_k=>$_v){
			
			$_sty='';
			$_id_div = $_v->id;
			$_dv_k = "_dv_k".$_id_div; 
			
			if($_sgm_dt->{$_id_div}->hb == 'no'){ 
				$__cls_empt = ' _nouse '; 
			}else{ 
				if(isN($_sgm_dt->{$_id_div}->vle)){
					$__cls_empt = ' __empty ';
				}else{
					$__cls_empt = '';
				} 
			}
			
			if(!isN($__w)){ $_sty .= 'max-width:'.$__w.'px;'; }

			$_cdg_f = str_replace([ '{IFS'.$_v->keyi.'}', '{/IFS'.$_v->keyi.'}'], ['', ''], $_cdg_f);
			
			$_cdg_f = str_replace($_v->key, '<div id="'.$_dv_k.'" class="_c_p _anm '.$__cls_empt.'" sgm-id="'.$_id_div.'" eccmz-id="'.$_id_eccmz.'" style="'.$_sty.'">
												<div class="e_tags _anm"><div class="_wp"><span class="nsve">Sin guardar</span></div></div>
												<div class="e_btn _anm">
													<div id="__txt_edt_'.$_dv_k.'" class="_btn _edt _anm" sgm-id="'.$_id_div.'" eccmz-id="'.$_id_eccmz.'" title="Editar"></div>
													<div id="__txt_his_'.$_dv_k.'" class="_btn _his _anm" sgm-id="'.$_id_div.'" eccmz-id="'.$_id_eccmz.'" title="Versiones"></div>
													<div id="__txt_sve_'.$_dv_k.'" class="_btn _sve _anm" sgm-id="'.$_id_div.'" eccmz-id="'.$_id_eccmz.'" title="Guardar"></div>
													<div id="__txt_opt_'.$_dv_k.'" class="_btn _opt _anm" sgm-id="'.$_id_div.'" eccmz-id="'.$_id_eccmz.'" title="Opciones"></div>
													<div id="__sgm_del_'.$_dv_k.'" class="_btn _rmv _anm" sgm-id="'.$_id_div.'" eccmz-id="'.$_id_eccmz.'" title="Ocultar"></div>
												</div>
												'./*<!--<span class="_tt">Ingrese su contenido aquí</span>-->*/'
												<div class="__c">'.$_sgm_dt->{$_id_div}->vle.'</div> 
											</div>', $_cdg_f);

			$Chk_sgm = ChkEcEdtSgm([ 'sgm'=>$_id_div, 'eccmz'=>$_id_eccmz ]);
			$chr_e = GtEcCmzSgmChrLs([ 'sgm'=>$Chk_sgm->id ]);
			
			if(!isN($chr_e)){

				$rsp['c'] .= '<style> #'.$_dv_k.' .__c{';
					
					foreach($chr_e as &$__chr){
						if($__chr->vle != ''){	
							$_ch_f = $__chr->css.' '.$__chr->vle.$__chr->end.';';
							$rsp['c'] .=  $_ch_f;	
						}
					}
					
				$rsp['c'] .= '}</style>';

			}
			
		}
		
		
		//--------------- TRATAMIENTO IMAGENES ---------------//	

			$doc = new DOMDocument('1.0', 'UTF-8');
			$doc->recover = true;
			$doc->strictErrorChecking = false;
			@$doc->loadHTML(mb_convert_encoding($_cdg_f, 'HTML-ENTITIES', 'UTF-8'));
			
			// Obtener Etiquetas IMG
			$tags = $doc->getElementsByTagName('img');
			foreach ($tags as $tag) {
				$old_src = $tag->getAttribute('src');
				$new_src_url = DMN_FLE_EC_HTML.$__dir.'/'.$old_src;
				if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
					$tag->setAttribute('src', $new_src_url);
				}
			}

			$_cdg_f = $doc->saveHTML();

		//--------------- GET HEADER ---------------//		
		
			/*Buscando header para reemplazar*/
			
			$_cdg_h = $__ec_cmz->gt_hdr([
						'c'=>$_cdg_f, //Code
						'id'=>$__hdr, //Id Header
						'tp'=>$__hdr_tp, //Type Header
						'eccmz'=>$_id_eccmz,  // Id Pushmail,
						'dir'=>$__dir, // S3Folder Pushmail
						'intv'=>'ok' // Interactive Mode - Id for JS replace
					]);

			$_cdg_f = $_cdg_h->cod;

			if(!isN($_cdg_h->w)){ $rsp['hdr']['w'] = $_cdg_h->w; }
			if(!isN($_cdg_h->h)){ $rsp['hdr']['h'] = $_cdg_h->h; }


		//--------------- REPLACE IMAGES ---------------//

		preg_match_all('/\[I.*?\]/', $_cdg_f, $_img);
		
		foreach($_img[0] as &$Key_img){
			
			$__im_w = EcCmzImgTag($Key_img, 'w');
			$__im_h = EcCmzImgTag($Key_img, 'h');
			$__im_id = EcCmzImgTag($Key_img, 'id'); 
			$__im_cut = EcCmzImgTag($Key_img, 'cut');
			$__im_dm = EcCmzImgTag($Key_img, 'dm');
			
			//$rsp['k_I'] .= $Key_img.'->'.$__im_id->v.'->'.$__im_w->t;
			
			$_id_div_img = $__im_id->v;
			$_dv_k_img = "_dv_img".$_id_div_img;
			
			$_chk_img = ChkEcCmzImg([ 'eccmz'=>$_id_eccmz, 'img'=>$_id_div_img ]);	
			
			$_img_srcs = $_chk_img->img->c;
			$_img_src = DMN_FLE_EC_CMZ.$_img_srcs;
			$_img_srco = DMN_FLE_EC_CMZ.$_chk_img->img->o;
			$_img_srcf = DIR_FLE_EC_CMZ.$_img_srcs;

			$_img_id = $_chk_img->id;
			
			$_img_attr = ' img-div-id="'.$_id_div_img.'" img-rtio="'.urlencode($__im_cut->v).'" img-max-w="'.$__im_w->v.'" img-max-h="'.$__im_h->v.'" img-max-d="'.$__im_dm->v.'" eccmz-id="'.$_id_eccmz.'" ec-id="'.$_gt_ec->id.'" eccmz-dir="'.$__dir.'" ';
			$_btn_opt = '	<div id="__img_up_'.$_dv_k_img.'" class="_btn _up" '.$_img_attr.' title="Cargar"></div>
							<div id="__img_uprc_'.$_dv_k_img.'" class="_btn _uprc" img-id="'.$_img_id.'" img-div-id="'.$_id_div_img.'" eccmz-id="'.$_id_eccmz.'" img-rtio="'.urlencode($__im_cut->v).'" img-src="'.urlencode($_img_src).'" img-src-f="'.urlencode($_img_srcf).'" img-src-o="'.urlencode($_img_srco).'" img-max-w="'.$__im_w->v.'" img-max-h="'.$__im_h->v.'" img-max-d="'.$__im_dm->v.'" ></div>
							<!--<div id="__img_dsgn_'.$_dv_k_img.'" class="_btn _dsgn"></div>-->
							<div id="__img_del_'.$_dv_k_img.'" class="_btn _rmv" img-div-id="'.$_id_div_img.'" eccmz-id="'.$_id_eccmz.'" title="Ocultar"></div>';


			if($_chk_img->r != 'ok'){
				
				$__img = '<div id="'.$_dv_k_img.'" class="_c_p_img _empty">								
							<div id="_cnt_up_'.$_id_div_img.'"></div>
							<div class="e_btn _anm">'.$_btn_opt.'</div>
						</div>';
						
			}else{

				$__img ='<div id="'.$_dv_k_img.'" class="_c_p_img"> 
							<img src="'.$_img_src.'?_rdm='.Gn_Rnd(10).'" '.$__im_w->t.' './*$__im_h->t.*/'>
							<div class="e_btn _anm">'.$_btn_opt.'</div>
						</div>
					';
			}
			
			$_gt_ec = ChkEcCmzEc([ 'eccmz'=>$_id_eccmz ]);
			$_cdg_f = str_replace($Key_img, $__img, $_cdg_f);		
			$Chk_img = ChkEcCmzImg([ 'img'=>$_id_div_img, 'eccmz'=>$_id_eccmz ]);
			$chr_e_img = GtEcCmzImgChrLs([ 'img'=>$Chk_img->id ]);
			
			$rsp['c'] .= '<style>#'.$_dv_k_img.'{ width: 100%; } /*#'.$_dv_k_img.' img{ width: 100%;*/ ';
			
				foreach($chr_e_img as &$__chr_i){
					if($__chr_i->vle != ''){	
						$_ch_f_i = $__chr_i->css.' '.$__chr_i->vle.$__chr_i->end.';';
						$rsp['c'] .=  $_ch_f_i;
					}
				}
				
			$rsp['c'] .= '}</style>';								
				
		}
		
		$__sch_f = [ '[MEN]', '[FTR]' ];
		$__chg_f = [ "<p style='font-family: Calibri, Arial, Helvetica, sans-serif; font-size:11px; line-height:12px;text-align: center '>Institución de educación superior sujeta a la inspección y vigilancia del MEN</p>", '<a href="http://u---../index.html"><img style="margin:auto; display:block;" src="'.DMN_EC.'fl/cmz/footer.jpg?_rdm='.Gn_Rnd(10).'"></a>' ];
		
		$_cdg_f = str_replace($__sch_f, $__chg_f, $_cdg_f);
		
		$rsp['e'] = 'ok';
		
	    if(!isN($_cdg_f)){ 
			$rsp['m'] = $_cdg_f; 
		}
	    
	}
	
	if(!isN($rsp['j'])){ 
		$rsp['j'] = cmpr_js($rsp['j']);
	}
	
	$__cmprss = 'no';
	
?>