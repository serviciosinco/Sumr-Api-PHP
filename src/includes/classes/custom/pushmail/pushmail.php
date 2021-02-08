<?php
define('RDS_IC_1', 'ic1.jpg');
define('RDS_IC_2', 'ic2.jpg');
define('RDS_IC_3', 'ic3.jpg');
define('RDS_IC_4', 'ic4.jpg');
define('RDS_IC_5', 'ic5.jpg');
define('RDS_IC_6', 'ic6.jpg');
define('RDS_IC_7', 'ic7.jpg');
define('RDS_IC_PDF', 'pdf.jpg');

class API_CRM_ec{

	private $key='74b830af515a1000af241f0df00e83c1816fbd04';

	public function __construct($p=NULL){

     	global $__cnx;
     	global $__dt_cl;
     	global $__argv;

     	$this->id_rnd = '_'.Gn_Rnd(20);

     	if(isN($this->ec_w)){ $this->ec_w = '600'; }

     	if(!isN($__dt_cl) && !isN($__dt_cl->id)){
			$this->cl = $__dt_cl;
		}elseif(!isN($p['cl'])){
			$this->cl = GtClDt($p['cl'],'');
		}

		$this->_stCl();

		$this->_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);

    }


	function __destruct() {

   	}



   	public function _stCl(){
		if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
		if(!isN($this->cl->enc)){ $this->c->enc = $this->cl->enc; }
		if(!isN($this->cl->sbd)){ $this->c->sbd = $this->cl->sbd; }
   	}


	public function _reset(){

		$this->ec_ahtml = NULL;
		$this->d_mdlcnt = NULL;
		$this->d_cnt = NULL;
		$this->d_mdl = NULL;
		$this->d_cnt = NULL;
		$this->d_cntdvrf = NULL;

		$this->ec_id = NULL;
		$this->ec_enc = NULL;
		$this->ec_cod = NULL;
		$this->ec_fld = NULL;
		$this->ec_fnd = NULL;
		$this->ec_pml = NULL;
		$this->ec_lnk = NULL;
		$this->ec_eml = NULL;
		$this->ec_tt = NULL;
		$this->ec_w = NULL;
		$this->ec_img = NULL;
		$this->ec_shr = NULL;
		$this->ec_pdf = NULL;
		$this->ec_spn = NULL;
		$this->ec_sis = NULL;
		$this->ec_sign = NULL;
		$this->ec_sign_on = NULL;
		$this->ec_sbj = NULL;
		$this->ec_prhdr = NULL;
		$this->ec_dir = NULL;


		$this->mdl_id = NULL;
		$this->mdl_nm = NULL;
		$this->mdl_pay_dsc = NULL;
		$this->mdl_pay_on = NULL;
		$this->mdl_sgn_on = NULL;
		$this->mdl_img = NULL;
		$this->mdl_lnk_pln_est = NULL;
		$this->mdl_eml = NULL;
		$this->mdl_fle = NULL;
		$this->mdl_are = NULL;
		$this->mdl_attr = NULL;


		$this->ctj->cnt_enc = NULL;
		$this->ctj->cnt_nm = NULL;
		$this->ctj->cnt_ap = NULL;
		$this->ctj->cnt_dc = NULL;

		$this->ctj->id_eccmpg = NULL;
		$this->ctj->eccmpg_frm = NULL;
		$this->ctj->eccmpg_sndr = NULL;
		$this->ctj->eccmpg_prhdr = NULL;
		$this->ctj->eccmpg_rply = NULL;
		$this->ctj->eccmpg_sbj = NULL;
		$this->ctj->eccmpg_p_f = NULL;
		$this->ctj->eccmpg_p_h = NULL;
		$this->ctj->eccmpg_lsts = NULL;
		$this->ctj->eccmpg_sgm = NULL;
		$this->ctj->eccmpg_nprb_dsc = NULL;
		$this->ctj->lnk_acton = NULL;
		$this->ctj->id_ec = NULL;



		$this->mdlcnt_attr = NULL;
		$this->cnt_attr = NULL;


		$this->mdl_eml = NULL;
		$this->nm_cnt = NULL;
		$this->ap_cnt = NULL;
		$this->md_cnt = NULL;
		$this->md_c = NULL;
		$this->eml_cnt = NULL;

		$this->eml_c = NULL;
		$this->doc_cnt = NULL;
		$this->tel_cnt = NULL;
		$this->tel_c = NULL;
		$this->cd_cnt = NULL;
		$this->cd_c = NULL;
		$this->msj_cnt = NULL;
		$this->ref = NULL;
		$this->ref_c = NULL;

		$this->pss_dwn_url = $__mdlcnt_rlc->pss_dwn_url;
		$this->pss_prn_url = $__mdlcnt_rlc->pss_prn_url;
		$this->html_pxl = NULL;
		$this->w_all = NULL;
		$this->fle = NULL;

		$this->d_mainr = NULL;

	}


	public function _bld($p=NULL){

		$this->_GtInfo($p['info']); if(isWrkr()){ echo $this->_auto->li(' _GtInfo '); }
		$this->_Prhdr(); if(isWrkr()){ echo $this->_auto->li(' _Prhdr '); }
		$this->_FxC(); if(isWrkr()){ echo $this->_auto->li(' _FxC '); }
		$this->_Lnk(); if(isWrkr()){ echo $this->_auto->li(' _Lnk '); }
		$this->_Html($p); if(isWrkr()){ echo $this->_auto->li(' _Html '); }
		$this->_Fle(); if(isWrkr()){ echo $this->_auto->li(' _Fle '); }

		return $this->__cod_nw;

	}

	public function _bld_url(){

		$this->_GtInfo();
		$__dt_lnk = GtEcLnkDt([ 'id'=>$this->id_l, 'tp'=>'enc', 'd'=>['ec'=>'ok', 'lnk'=>'ok'] ]);
		if(isN($this->cl) && !isN( $__dt_lnk->ec->cl->id )){  $this->cl = GtClDt($__dt_lnk->ec->cl->id,''); }
		//if($_GET['Camilo']=='ok'){ echo h1( $this->id_l ); print_r( $__dt_lnk->ec ); echo 'SomeHere'; exit(); }

		if(!isN($__dt_lnk->lnk)){

			$this->lnk_go = $__dt_lnk->lnk;
			$this->id = $__dt_lnk->ec->enc;
			$this->_GtInfo();
			$this->_FxC();
			$this->__cod_nw = $this->lnk_go;
			$this->_Lnk();

			if($this->sve_t == 'ok'){
				$_sve = $this->_TrckSve([ 'bd'=>$this->bd, 'lnk'=>$__dt_lnk->id, 'snd'=>$this->mdlcnt_ec_id ]);
				if($_sve->e!='ok'){
					//print_r($_sve);
				}
			}else{
				$_sve = 'ok';
			}

			//if($_sve == 'ok'){
				return preg_replace('/\s+/', '',  strip_tags( $this->__cod_nw ) );
			/*}else{
				return false;
			}*/

		}

	}


	public function _sbj($_p=NULL){

		$this->ec_sbj = NULL;

		if(!isN($_p['t'])){
			$this->ec_sbj = $_p['t'];
			$this->_Lnk();
		}

		if(!isN($this->ec_sbj_nw)){ $_r = $this->ec_sbj_nw; }else{ $_r = $_p['t']; }
		return $_r;

	}


	public function _GtInfo($p=NULL){

		if($this->btrck != 'ok'){ $__cod_trck='ok'; }else{ $__cod_trck='no'; }

		if(!isN($p['ec']) && !isN($p['ec']->id)){
			$this->__dtec = $p['ec'];
		}else{
			if(isWrkr()){ echo $this->_auto->li(' > _GtEcDt '); }
			$this->__dtec = GtEcDt($this->id, $this->id_t, [ 'dtl'=>[ 'cl'=>'ok', 'us'=>'ok', 'tp'=>'ok', 'are'=>'ok', 'cod_trck'=>$__cod_trck ] ]);
		}

		if($this->btrck != 'ok' || !isN($this->snd_i) || $this->isAwsT()){
			$__cod_to_work = $this->__dtec->cod_trck;
			if(isWrkr()){ echo $this->_auto->li(' > _cod_trck '); }
		}else{
			$__cod_to_work = $this->__dtec->cod;
			if(isWrkr()){ echo $this->_auto->li(' > _cod '); }
		}

		if(!isN($__cod_to_work)){

			if(strpos($__cod_to_work, '<html') !== false){ $tags_html = 'ok'; }
			if(strpos($__cod_to_work, '<head')){ $tags_head = 'ok'; }
			if(strpos($__cod_to_work, '<body')){ $tags_body = 'ok'; }

			if(strpos($__cod_to_work, '<!DOCTYPE') !== false){ $this->ec_html5 = 'no'; }else{ $this->ec_html5 = 'ok';}

			if($tags_html=='ok' || $tags_head=='ok'){
				$this->ec_ahtml = 'ok'; // Has all estructure complete
			}

		}

		if(isN($this->cl) && !isN($this->__dtec->cl)){
			$this->cl = $this->__dtec->cl;
			$this->_stCl();
		}

		if(isN($this->bd) && !isN($this->__dtec->cl->bd)){ $this->bd = _BdStr($this->__dtec->cl->bd); }

		if(!isN($this->snd_i)){

			if(isWrkr()){ echo $this->_auto->li(' > _GtEcSndDt '); }

			if($this->btrck != 'ok'){ $__dt_snd_i_d_eml='ok'; }else{ $__dt_snd_i_d_eml=''; }

			$this->__dt_snd_i = GtEcSndDt([ 'id'=>$this->snd_i, 'tp'=>'enc', 'bd'=>$this->bd, 'dtl'=>[ 'eml'=>$__dt_snd_i_d_eml, 'cnt'=>'ok', 'mdlcnt'=>'ok' ] ]);

			if(!isN($__mdlcnt_rlc->w)){ /*echo 'Sndi:'.$__mdlcnt_rlc->w;*/ exit(); }

			if(!isN($this->__dt_snd_i->mdlcnt)){

				if(!isN($this->__dt_snd_i->mdlcnt)){
					$__mdlcnt_rlc = $this->__dt_snd_i->mdlcnt;
					$this->d_mdlcnt = $__mdlcnt_rlc;
					$this->d_cnt = $__mdlcnt_rlc->cnt;

					if(!isN($this->d_mdlcnt->w)){ /*echo 'Sndi:'.$__mdlcnt_rlc->w;*/ exit(); }

				}

				if($this->btrck != 'ok'){
					if($this->eml_cld == 'ok' && !isN($this->__dt_snd_i->eml->enc)){
						UPDCntEml_Cld([ 'id'=>$this->__dt_snd_i->eml->enc, 'cld'=>_CId('ID_CLD_MDM') ]);
						if(isWrkr()){ echo $this->_auto->li(' > UPDCntEml_Cld '); }
					}
				}

			}

		}


		if(!isN($this->mdlc)){

			if(isN($this->d_mdlcnt) && isN($this->d_cnt)){

				if(isWrkr()){ echo $this->_auto->li(' > _GtMdlCntDt '); }
				$__mdlcnt_rlc = GtMdlCntDt([ 'id'=>$this->mdlc, 'bd'=>str_replace('.','',$this->bd), 'shw'=>[ 'attr'=>'ok', 'cnt'=>'ok' ] ]);
				$this->d_mdlcnt = $__mdlcnt_rlc;
				$this->d_cnt = $__mdlcnt_rlc->cnt;

			}else{

				$__mdlcnt_rlc = $this->d_mdlcnt;

			}

			if(!isN($__mdlcnt_rlc->mdl->id)){ $this->mdli = $__mdlcnt_rlc->mdl->enc; }
			if(!isN($__mdlcnt_rlc->w)){ /*echo 'R_GtMdlCntDt:'.$__mdlcnt_rlc->w;*/ exit(); }

		}


		if(!isN($this->mdli)){
			//if(SISUS_ID==1){ echo '$this->mdli:'.$this->mdli; }

			if(isWrkr()){ echo $this->_auto->li(' > _GtMdlDt '); }

			$__mdl_rlc = GtMdlDt([
									'bd'=>str_replace('.','',$this->bd),
									'id'=>$this->mdli,
									't'=>'enc',
									'cl'=>$this->cl->id,
									'ec_crt'=>'ok',
									'ec_fle'=>'ok',
									'ec_crt_id'=>$this->__dtec->id
								]);

			$this->d_mdl = $__mdl_rlc;
			if(!isN($__mdl_rlc->w)){ /*echo 'Mdl:'.print_r($__mdl_rlc->w, true);*/ exit(); }

		}


		if(!isN($this->dvrf)){
			if(isWrkr()){ echo $this->_auto->li(' > _GtCntDvrfDt '); }
			$__dvrf_rlc = GtCntDvrfDt([ 'id'=>$this->dvrf, 'bd'=>$this->bd ]);
			$this->d_cntdvrf = $__dvrf_rlc;
		}

		if(!isN($this->rlcm)){

			if(isWrkr()){ echo $this->_auto->li(' > _GtEcSndR '); }
			$__main_rlc = GtEcSndRDt([ 'id'=>$this->rlcm, 'bd'=>$this->bd ]);

			$this->d_mainr = $__main_rlc;

			if(!isN($this->d_mainr->w)){
				echo 'd_mainr w:'.$this->d_mainr->w;
				exit();
			}
		}


		if( !isN($this->__dtec->id) ){

			$this->ec_id = $this->__dtec->id;
			$this->ec_enc = $this->__dtec->enc;

			if($this->btrck == 'ok' && isN($this->__dt_snd_i->id)){
				$this->ec_cod = $this->__dtec->cod;
			}else{
				$this->ec_cod = $this->__dtec->cod_trck;
			}


			$this->ec_fld = $this->__dtec->fld;
			$this->ec_fnd = $this->__dtec->fnd;
			$this->ec_pml = $this->__dtec->pml;
			$this->ec_lnk = $this->__dtec->lnk;
			$this->ec_eml = $this->__dtec->eml;
			$this->ec_tt = $this->__dtec->tt;
			$this->ec_w = $this->__dtec->w;
			$this->ec_img = $this->__dtec->img;
			$this->ec_shr = $this->__dtec->shr;
			$this->ec_pdf = $this->__dtec->pdf;
			$this->ec_spn = $this->__dtec->spn;
			$this->ec_sis = $this->__dtec->sis;
			//$this->ec_sign = $this->__dtec->us->sgn;
			$this->ec_sign_on = $this->__dtec->sgn_on;
			$this->ec_sbj = $this->__dtec->sbj;
			$this->ec_prhdr = $this->__dtec->prhdr;
			$this->ec_dir = $this->__dtec->dir;

		}



		if(!isN($__mdlcnt_rlc->id) || !isN($__mdl_rlc)){

			if(!isN($__mdlcnt_rlc->cnt->enc)){ $this->ctj->cnt_enc = $__mdlcnt_rlc->cnt->enc; }
			if(!isN($__mdlcnt_rlc->cnt->nm)){ $this->ctj->cnt_nm = $__mdlcnt_rlc->cnt->nm; }
			if(!isN($__mdlcnt_rlc->cnt->ap)){ $this->ctj->cnt_ap = $__mdlcnt_rlc->cnt->ap; }
			if(!isN($__mdlcnt_rlc->cnt->dc)){ $this->ctj->cnt_dc = $__mdlcnt_rlc->cnt->dc; }

			if(!isN($this->d_mdlcnt->attr_o)){ $this->mdlcnt_attr = $this->d_mdlcnt->attr_o; }
			if(!isN($this->d_cnt->attr_o)){ $this->cnt_attr = $this->d_cnt->attr_o; }

			if(!isN($this->mdli) && !isN($this->d_mdl)){

				$this->mdl_id = $this->d_mdl->id;
				$this->mdl_nm = $this->d_mdl->tt;
				$this->mdl_pay_dsc = $this->d_mdl->mdl_pay_dsc;
				$this->mdl_pay_on = $this->d_mdl->chk_act_btnp;
				$this->mdl_sgn_on = $this->d_mdl->chk_act_frma;
				$this->mdl_img = $this->d_mdl->img;
				$this->mdl_lnk_pln_est = $this->d_mdl->lnk_pln_est;
				$this->mdl_eml = $this->d_mdl->eml;
				$this->mdl_fle = $this->d_mdl->mdl_fle;
				$this->mdl_are = $this->d_mdl->are;
				$this->mdl_attr = $this->d_mdl->attr_o;

			}else{

				$this->mdl_eml = $__mdlcnt_rlc->eml;
				$this->nm_cnt = $rs->nombre;
				$this->ap_cnt = $rs->apellido;
				$this->md_cnt = GtSisMdDt([ 'id'=>$rs->SndMed ]);	if(isWrkr()){ echo $this->_auto->li(' > _GtSisMdDt '); }
				$this->md_c = GtSisMdDt([ 'id'=>$__mdlcnt_rlc->m ]); if(isWrkr()){ echo $this->_auto->li(' > _GtSisMdDt '); }
				$this->eml_cnt = $rs->correoElectronico;

				if(!isN( $__mdlcnt_rlc->cnt->eml->{0} )){
					$__eml_0 = $__mdlcnt_rlc->cnt->eml->{0}->v;
				}else{
					$__eml_0 = $__mdlcnt_rlc->cnt->eml[0]->v;
				}

				$this->eml_c = $__eml_0;
				$this->doc_cnt = $rs->documento;
				$this->tel_cnt = $rs->telefonos;
				$this->tel_c = $__mdlcnt_rlc->cnt->tel[0];
				$this->cd_cnt = $rs->ciudad;
				$this->cd_c = $__mdlcnt_rlc->cnt->cd;
				$this->msj_cnt = $rs->comentarios;
				$this->ref = $ref->pag;
				$this->ref_c = $ref->pag;

			}

			$this->pss_dwn_url = $__mdlcnt_rlc->pss_dwn_url;
			$this->pss_prn_url = $__mdlcnt_rlc->pss_prn_url;

		}else{

			if(!isN($this->__dt_snd_i->cnt->enc)){ $this->ctj->cnt_enc = $this->__dt_snd_i->cnt->enc; }
			if(!isN($this->__dt_snd_i->cnt->nm)){ $this->ctj->cnt_nm = $this->__dt_snd_i->cnt->nm; }
			if(!isN($this->__dt_snd_i->cnt->ap)){ $this->ctj->cnt_ap = $this->__dt_snd_i->cnt->ap; }
			if(!isN($this->__dt_snd_i->cnt->dc)){ $this->ctj->cnt_dc = $this->__dt_snd_i->cnt->dc; }

		}

		if(!isN($this->plcy_id)){
			$__plcy_rlc = GtClPlcyDt([ 'id'=>$this->plcy_id ]);
			$this->d_clplcy = $__plcy_rlc;
		}else{
			$this->d_clplcy = NULL;
		}

		if(!isN($this->plcy_id)){
			$__plcy_rlc = GtClPlcyDt([ 'id'=>$this->plcy_id ]);
			$this->d_clplcy = $__plcy_rlc;
		}else{
			$this->d_clplcy = NULL;
		}

		$this->mdlcnt_ec_id = $this->__dt_snd_i->id;
		$this->mdlcnt_ec_enc = $this->__dt_snd_i->enc;

	}


	public function _Lnk($p=NULL){

		$__p_html = Cod_Btw([ 'tag'=>'IFPAY', 'cod'=>$this->__cod_nw ]);
		$__cod_c = $this->__cod_nw;

		//--------------- Modifica Segmentos Si esta en modo Edicion ---------------//

			if($this->edit == 'ok'){

				if(isWrkr()){ echo $this->_auto->li(' > GtSisEcCrt_Ls '); }

				$__crt_all = GtSisEcCrt_Ls(); /*echo h3(date("Y-m-d H:i:s").' GtSisEcCrt_Ls ');*/

				foreach($__crt_all as $_k=>$_v){

					$_id_div = $_v->id;
					$_dv_k = "_dv_k".$_id_div;

					if($_v->tp == 1){
						$_s_acrt[$_v->id] = $_v->key;
						$_c_acrt[$_v->id] = '<div id="'.$_dv_k.'" class="_c_p _anm" sgm-id="'.$_id_div.'">
												<div class="e_btn">
													<div id="__txt_edt_'.$_dv_k.'" class="_btn _edt" sgm-id="'.$_id_div.'"></div>
													<div id="__txt_his_'.$_dv_k.'" class="_btn _his" sgm-id="'.$_id_div.'"></div>
													<div id="__txt_sve_'.$_dv_k.'" class="_btn _sve" sgm-id="'.$_id_div.'"></div>
													<div id="__sgm_del_'.$_dv_k.'" class="_btn _rmv" sgm-id="'.$_id_div.'"></div>
												</div>
												<div class="__c">'.$_v->key.'</div>
												'./*<span class="_tt">'.$_v->tt.'</span>*/'
											</div>';
					}elseif($_v->tp == 2){

						$__cod_c = str_replace($_v->key, '<div id="'.$_dv_k.'" class="_c_p c-btn">
													<div class="__c">'.$_v->key.'</div>
													'./*<span class="_tt">'.$_v->tt.'</span>*/'', $__cod_c);

						$__cod_c = str_replace($_v->keyc, '</div>', $__cod_c);

					}
				}

				$__cod_c = str_replace($_s_acrt,$_c_acrt, $__cod_c);
			}

		//--------------- Modifica Textos ---------------//

			if(!isN($this->d_mdl->ec_crt)){

				foreach($this->d_mdl->ec_crt as $_k=>$_v){

					if($_v->tp == 1){
						$_s_bcrt[$_v->id] = $_v->key;
						$_c_bcrt[$_v->id] = $_v->vl;
					}else{

						if($this->edit != 'ok'){
							$__cod_c = str_replace($_v->key, '<a href="'.$_v->vl.'">', $__cod_c);
							$__cod_c = str_replace($_v->keyc, '</a>', $__cod_c);
						}else{
							$__cod_c = str_replace($_v->key, $_v->vl, $__cod_c);
							$__cod_c = str_replace($_v->keyc, '', $__cod_c);
						}
					}

					if(!isN($_v->vl)){
						$_key_open = str_replace(['[',']'],['{IF','}'],$_v->key);
						$_key_close = str_replace(['[',']'],['{/IF','}'],$_v->key);
						$__cod_c = str_replace([ $_key_open, $_key_close ], ['', ''], $__cod_c);
					}

				}

				$__cod_c = str_replace($_s_bcrt,$_c_bcrt, $__cod_c);

			}

		//--------------- Modifica Segmentos Si esta en modo Edicion ---------------//

			if($this->edit == 'ok'){
				foreach($__crt_all as $_k=>$_v){
						$_s_ccrt[$_v->id] = $_v->key;
				}
				$__cod_c = str_replace($_s_ccrt,'', $__cod_c);
			}

		//--------------- Modifica Campos Personalizados ---------------//

			if($this->__dt_snd_i->hdr->tot > 0){
				foreach($this->__dt_snd_i->hdr->tags as $_k=>$_v){
					$__cod_c = str_replace($_v->t,$_v->v, $__cod_c);
				}
			}

		//--------------- Modifica Etiquetas Base - Tags a Buscar ---------------//

			$_s[0] = '[NOMBRE]';
			$_s[1] = '[APELLIDO]';
			$_s[2] = '[MODULO_FIRMA]';
			$_s[3] = '[MODULO_NOMBRE]';
			$_s[4] = $__p_html->sch;
			$_s[5] = '[MODULO_IMAGEN]';
			$_s[6] = '[MODULO_EMAIL]';
			$_s[7] = '[MODULO RESPUESTA]';
			$_s[8] = '[PREHEADER]';
			$_s[9] = '[MODULO_PAGO_DESCRIPCION]';
			$_s[10] = '@@@MODULO_ID@@@';
			$_s[11] = '';
			$_s[12] = '[PUSHMAIL_FIRMA]';
			$_s[15] = '[PUSHMAIL_CODIGO]';
			$_s[16] = '[NOMBRE_USUARIO]';
			$_s[17] = '[MODULO_COLOR]';
			$_s[18] = '[ARE_COLOR]';
			$_s[19] = '[IMG_MDL]';
			$_s[20] = '[EC_CMPG_ID]';
			$_s[21] = '[EC_CMPG_FRM]';
			$_s[22] = '[EC_CMPG_SNDR]';
			$_s[23] = '[EC_CMPG_PRHDR]';
			$_s[24] = '[EC_CMPG_RPLY]';
			$_s[25] = '[EC_CMPG_SBJ]';
			$_s[26] = '[EC_CMPG_F]';
			$_s[27] = '[EC_CMPG_H]';
			$_s[28] = '[EC_CMPG_LST]';
			$_s[29] = '[EC_CMPG_SGM]';
			$_s[30] = '[EC_CMPG_NPRB_DSC]';
			$_s[31] = '[LINK_ACTON]';
			$_s[32] = '[EC_ID]';
			$_s[33] = '[DOCUMENTO]';
			$_s[34] = '[MODULO]';
			$_s[35] = '[MODULO_IMAGEN_BN]';
			$_s[36] = '[LEAD_ENC]';
			$_s[50] = '[DVRF_COD]';
			$_s[51] = '[SOLICITUD_ID]';
			$_s[52] = '[DOCUMENTO_LEAD]';
			$_s[53] = '[VTEX_INS_PASS]';
			$_s[54] = '[VTEX_INS_NOMBRE]';
			$_s[55] = '[VTEX_INS_APELLIDO]';
			$_s[56] = '[VTEX_RFD_NOMBRE]';
			$_s[57] = '[VTEX_RFD_APELLIDO]';
			$_s[58] = '@@@VTEX_RFD_ID@@@';
			$_s[59] = '[VTEX_INS_COUP]';
			$_s[60] = '@@@VTEX_INS_ID@@@';
			$_s[61] = '[VTEX_INS_RFD_COUP]';
			$_s[62] = '[TCKT_ID]';
			$_s[63] = '{{PLCY_ID}}';
			$_s[64] = '{{SND_ID}}';


		//--------------- Modifica Etiquetas Base - Tags a Reemplazar ---------------//

			if($this->isAwsT()){

				$_c=[];

				foreach($_s as $_sk=>$_sv){
					if($_sv == '@@@VTEX_RFD_ID@@@'){
						$_c[$_sk] = '{{vtex_rfd_id}}';
					}elseif($_sv == '@@@VTEX_INS_ID@@@'){
						$_c[$_sk] = '{{vtex_ins_id}}';
					}else{
						$_c[$_sk] = str_replace(['[',']'], ['{{','}}'], strtolower($_sv));
					}
				}

			}else{

				$_c[0] = ucfirst($this->ctj->cnt_nm);
				$_c[1] = ucfirst($this->ctj->cnt_ap);

				if($this->mdl_sgn_on == 'ok'){  $_c[2] = $this->mdl_sgn; }else{ $_c[2] = ''; }
				$_c[3] = $this->mdl_nm;

				if(!isN($this->mdl_pay_url) && $this->mdl_pay_on == 'ok'){
					$_c[4] = $__p_html->nw;
				}else{
					$_c[4] = '';
				}

				$_c[5] = "<img src='".$this->mdl_img->th_800."' width='100%' height='auto' alt='".$this->mdl_nm."' />";
				$_c[6] = $this->mdl_eml;
				$_c[7] = $this->mdl_rsp;


				if(!isN($this->cmpg_prhdr)){
					$__prhdr_tx = $this->cmpg_prhdr;
				}elseif(!isN($this->cmpg_prhdr_nw)){
					$__prhdr_tx = $this->cmpg_prhdr_nw;
				}else{
					$__prhdr_tx = '';
				}

				if(!isN($__prhdr_tx)){
					$__prhdr = $this->_Prhd_Wrp($__prhdr_tx);
				}else{
					$__prhdr = '';
				}

				$_c[8] = $__prhdr;

				if($this->mdl_pay_dsc == 'ok'){  $_c[9] = $this->mdl_pay_dsc; }else{ $_c[9] = ''; }
				if(!isN($this->mdl_id)){ $_c[10] = $this->mdl_id; }else{ $_c[10] = ''; }

				$_c[11] = '';
				if($this->ec_sign_on == 'ok'){ $_c[12] = $this->ec_sign; }else{ $_c[12] = '';}

				$_c[15] = $this->myec_cod;
				$_c[16] = $this->us_nm;
				$_c[17] = !isN($this->mdl_clr)?$this->mdl_clr : '#000';
				$_c[18] = '<tr><td style="font-family:tahoma,geneva,sans-serif;font-size:12px;text-align:center;padding:10px 35px;background-color:'.$this->are_clr.';color:white" valign="top">'.$this->mdl_nm.'</td></tr>';
				$_c[19] = $this->d_img;
				$_c[20] = $this->ctj->id_eccmpg;
				$_c[21] = $this->ctj->eccmpg_frm;
				$_c[22] = $this->ctj->eccmpg_sndr;
				$_c[23] = $this->ctj->eccmpg_prhdr;
				$_c[24] = $this->ctj->eccmpg_rply;
				$_c[25] = $this->ctj->eccmpg_sbj;
				$_c[26] = $this->ctj->eccmpg_p_f;
				$_c[27] = $this->ctj->eccmpg_p_h;
				$_c[28] = $this->ctj->eccmpg_lsts;
				$_c[29] = $this->ctj->eccmpg_sgm;
				$_c[30] = $this->ctj->eccmpg_nprb_dsc;
				$_c[31] = $this->ctj->lnk_acton;
				$_c[32] = $this->ctj->id_ec;
				$_c[33] = base64_encode($this->cnt_dc);
				$_c[34] = base64_encode($this->mdl_cdc);


				if(!isN($this->mdl_img->bn_800)){
					$_c[35] = "<img src='".$this->mdl_img->bn_800."' width='100%' height='auto' alt='".$this->mdl_nm."' />";
				}else{
					$_c[35] = '';
				}

				$_c[36] = $this->ctj->cnt_enc;
				$_c[50] = $this->d_cntdvrf->cod;

				if( !isN($this->id_cntappl) ){
					$_c[51] = $this->id_cntappl;
					$_c[52] = $this->cnt_dc;
				}else{
					$_c[51] = '';
					$_c[52] = '';
				}

				if( !isN($this->d_mainr->vtex) ){
					$_c[53] = $this->d_mainr->vtex->ins->cnt->vtex->pss;
					$_c[54] = !isN($this->d_mainr->vtex->ins->cnt->nm)?$this->d_mainr->vtex->ins->cnt->nm:$this->d_mainr->vtex->ins_rfd->ins->cnt->nm;
					$_c[55] = !isN($this->d_mainr->vtex->ins->cnt->ap)?$this->d_mainr->vtex->ins->cnt->ap:$this->d_mainr->vtex->ins_rfd->ins->cnt->ap;
					$_c[56] = $this->d_mainr->vtex->ins_rfd->cnt->nm;
					$_c[57] = $this->d_mainr->vtex->ins_rfd->cnt->ap;
					$_c[58] = $this->d_mainr->vtex->ins_rfd->enc;
					$_c[59] = $this->d_mainr->vtex->ins->coup->v;
					$_c[60] = $this->d_mainr->vtex->ins->enc;
					$_c[60] = $this->d_mainr->vtex->ins->enc;
					$_c[61] = $this->d_mainr->vtex->ins_rfd->coup->rfd->v;
				}else{
					$_c[53] = '';
					$_c[54] = '';
					$_c[55] = '';
					$_c[56] = '';
					$_c[57] = '';
					$_c[58] = '';
					$_c[59] = '';
					$_c[60] = '';
					$_c[61] = '';
				}

				if( !isN($this->d_mdlcnt->id) ){
					$_c[62] = $this->d_mdlcnt->id;
				}else{
					$_c[62] = '';
				}

				if( !isN($this->d_clplcy->id) ){
					$_c[63] = $this->d_mdlcnt->id;
				}else{
					$_c[63] = '';
				}

				if( !isN($this->mdlcnt_ec_enc) ){
					$_c[64] = $this->mdlcnt_ec_enc;
				}else{
					$_c[64] = '';
				}

			}

			//if(SISUS_ID==1){ echo $_s[10].'->'.$_c[10]; }

		//--------------- Setea la variable r con el codigo ---------------//

			$new__cod = $__cod_c;
			$this->ec_sbj_nw = $this->ec_sbj;

			if($this->crplc != 'no'){
				for($i=0; $i<=10; $i++){
					$new__cod = str_replace($_s,$_c,$new__cod); // Cambia el Codigo del Cuerpo HTML
				}
			}

			//if($this->btrck != 'ok'){
				for($i=0; $i<=10; $i++){
					$this->ec_sbj_nw = str_replace($_s,$_c,$this->ec_sbj_nw); // Cambia campos en Asunto
				}
			//}

		//--------------- Cambia el Codigo Desde el DOM ---------------//

			$__lnd = $this->_GtNLn([ 'v'=>$new__cod ]); if(isWrkr()){ echo $this->_auto->li(' > _GtNLn '); }
			$new__cod = $__lnd->cod;

		//--------------- Cambia el Codigo del Cuerpo HTML ---------------//

			$new__cod = $this->_Lnk_Fx([ 'r'=>$new__cod ]); if(isWrkr()){ echo $this->_auto->li(' > _Lnk_Fx '); }

			if($this->btrck == 'ok'){
				$new__cod = $this->_FxC_Img([ 'v'=>$new__cod ]); if(isWrkr()){ echo $this->_auto->li(' > _FxC_Img '); }
				$new__cod = $this->_FxS_Sgm([ 'v'=>$new__cod ]); if(isWrkr()){ echo $this->_auto->li(' > _FxS_Sgm '); }
				$new__cod = $this->_FxA_Attr([ 'v'=>$new__cod ]); if(isWrkr()){ echo $this->_auto->li(' > _FxA_Attr '); }
			}else{
				$new__cod = $this->_FxP_Clr([ 'v'=>$new__cod ]); if(isWrkr()){ echo $this->_auto->li(' > _FxP_Clr '); }
			}

			if($this->if_hde == 'ok'){
				$new__cod = $this->_FxS_Sgm_iF($new__cod);
			}

		//--------------- Cambia Ultimos Parametros del HTML ---------------//

			if($this->ec_ahtml != 'ok'){
				$s1 = ['<td><img' , '<td colspan="2"><img','<br />'];
				$c1 = ['<td style="line-height:1px;"><img' , '<td style="line-height:1px;" colspan="2"><img',''];
				$new__cod = str_replace($s1,$c1,$new__cod);
			}

		//--------------- Seteo el codigo final ---------------//

			$this->__cod_nw = $new__cod;

	}


	public function _Lnk_Fx($_p=NULL){

		/* Cambio de Codigos con URL Descarga Pass */
		$_s4[1] = 'SvProPay';
		$_s4[2] = 'SvPssDwn';
		$_s4[3] = 'SvPssPrn';
		$_s4[4] = 'SvFleDwn';
		$_s4[5] = 'SvCntc';
		$_s4[6] = 'SvLnk';

		$_c4[1] = $this->mdl_pay_url;
		$_c4[2] = $this->pss_dwn_url;
		$_c4[3] = $this->pss_prn_url;
		$_c4[4] = $this->fle_dwn;
		$_c4[5] = $this->Cd_Cntc;
		$_c4[6] = $this->Cd_Lnk;

		$rsp = str_replace($_s4,$_c4, $_p['r']);

		return $rsp;
	}

	public function _GtNLnSve($_p=NULL){

		global $__cnx;

		if(!isN($_p['lnk']) && (filter_var($_p['lnk'], FILTER_VALIDATE_URL) || in_array($_p['lnk'], ['SvLnk','SvCntc']) || strpos($a, 'mailto') !== false)) {

			$_enc = Enc_Rnd($_p['ec'].$_p['lnk']);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LNK." (eclnk_enc, eclnk_ec, eclnk_lnk, eclnk_lnk_c) VALUES (%s, %s, %s, %s)",
						GtSQLVlStr($_enc, "text"),
						GtSQLVlStr($_p['ec'], "int"),
						GtSQLVlStr(enCad($_p['lnk']), "text"),
						GtSQLVlStr($_p['lnk'], "text"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['enc'] = $_enc;
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = '_GtNLnSve error:'.$__cnx->c_p->error;
			}

		}

		return _jEnc($rsp);

	}

	private function _GtNLnUrl($_p=NULL){

		$_gtec = GtEcLnkChk([ 'ec'=>$_p['ec'], 'lnk'=>$_p['lnk'] ]); if(isWrkr()){ echo $this->_auto->li(' >  _GtNLn - _GtNLnUrl - GtEcLnkDt '); }

		if(!isN($_gtec->enc)){

			if($this->isAwsT()){

				return '{{link_'.$_gtec->id.'}}';

			}else{

				$_pml = DMN_TRCK.PrmLnk('bld', 'ec').PrmLnk('bld', 'url');

				if($this->btrck == 'ok' && isN($this->__dt_snd_i->id)){
					$__pc_enc = '@@@sumr_trck_mre@@@';
				}elseif(!isN($this->mdlcnt_ec_enc)){
					$__pc_enc = '&_s='.$this->mdlcnt_ec_enc.'&_c='.$this->c->enc/*.'&_Rnd='.Gn_Rnd(5)*/;
				}

				$Cod = $_pml.'?_i='.$_gtec->enc.$__pc_enc;
				return $Cod;
			}

		}else{

			if(!isN($_gtec->w)){
				if(isWrkr()){ echo $this->_auto->err('GtEcLnkChk error:'.$_gtec->w); }
			}

		}

	}



	private function _GtUrlMreTrck($_p=NULL){

		$__pc_enc='';

		if(!isN($this->mdlcnt_ec_enc)){
			$__pc_enc .= '&_s='.$this->mdlcnt_ec_enc;
		}
		if(!isN($this->c->enc)){
			$__pc_enc .= '&_c='.$this->c->enc;
		}

		if(!isN($__pc_enc)){
			//$__pc_enc .= '&_Rnd='.Gn_Rnd(5);
		}

		$this->sumr_trck_mre = $__pc_enc;

	}

	private function removeElementsByTagName($tagName, $document) {
	  	$nodeList = $document->getElementsByTagName($tagName);
	  	for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
	    	$node = $nodeList->item($nodeIdx);
	    	$node->parentNode->removeChild($node);
	  	}
	}

	private function remove_html_comments($content = '') {
		if($this->ec_ahtml != 'ok'){
			return preg_replace('/<!--(.|\s)*?-->/', '', $content);
		}else{
			return $content;
		}
	}


	function _stripPhpComments($code){
		if($this->ec_ahtml != 'ok'){
	    	$content = preg_replace('/<\!--.*-->/Us', '', $code);
		}else{
			$content = $code;
		}
		return $content;
	}

	function _TagNamec($p=NULL){
		if($this->ec_ahtml != 'ok'){
			$s = preg_replace("/<".$p['t1']."\s(.+?)>(.+?)<\/".$p['t1'].">/is", "<".$p['t2'].">$2</".$p['t2'].">", $p['s']);
		}else{
			$s = $p['s'];
		}
		return $s;
	}


	public function DOMRemove(DOMNode $from) {
		$sibling = $from->firstChild;
		do {
			$next = $sibling->nextSibling;
			$from->parentNode->insertBefore($sibling, $from);
		} while ($sibling = $next);
		$from->parentNode->removeChild($from);
	}

	public function _GtNLn($_r=NULL){

		try {

				if($this->btrck == 'ok'){

					$html_c = mb_convert_encoding($_r['v'], 'HTML-ENTITIES', 'UTF-8');
					$html_c = $this->_TagNamec([ 's'=>$html_c, 't1'=>'div', 't2'=>'p' ]);
					$html_c = $this->_TagNamec([ 's'=>$html_c, 't1'=>'b', 't2'=>'strong' ]);

					if(isWrkr()){ echo $this->_auto->li(' > LoadDOM '); }

					$doc = new DOMDocument('1.0', 'UTF-8');
					$doc->recover = true;
					$doc->strictErrorChecking = false;


					if(!$doc->loadHTML($html_c)){
						if(isWrkr()){
							echo $this->_auto->err(' HTML Not Created ');
							print_r(error_get_last());
							exit();
						}
					}

					//echo h3(date("Y-m-d H:i:s").' _GtNLn - loadHTML').PHP_EOL;

				}

			//---------------- START A TAGS ----------------//


				/*if($this->btrck == 'ok'){

					if(isWrkr()){ echo $this->_auto->li(' > Get <a> Tags '); }

					if($this->ec_ahtml != 'ok' || !isN($this->__dt_snd_i->id) || $this->isAwsT()){

						$tags_h = $doc->getElementsByTagName('a');

						foreach ($tags_h as $tag) {

							$old_src = $tag->getAttribute('href');

							if(!in_array($old_src, ['SvFleDwn'] ) && strpos($old_src, DMN_TRCK) === false){

								if($this->sve_url == 'ok' || !isN($this->__dt_snd_i->id)){

									$_dt_ec = GtEcLnkDt([ 'cmmt'=>'ok', 'ec'=>$this->ec_id, 'lnk'=>enCad($old_src) ]); if(isWrkr()){ echo $this->_auto->li(' >  _GtNLn - GtEcLnkDt '); }

									if($_dt_ec->e == 'ok' && isN($_dt_ec->id)){
										$_lnk_sve = $this->_GtNLnSve([ 'ec'=>$this->ec_id, 'lnk'=>$old_src ]); if(isWrkr()){ echo $this->_auto->li(' >  _GtNLn - _GtNLnSve '); }
										if(isWrkr()){ echo $this->_auto->li(' >  _GtNLnSve '); }
										if(!isN($_lnk_sve->w)){ $this->w[] = $_lnk_sve->w; }
									}else{
										if(!isN($_dt_ec->w)){
											$this->w[] = $_dt_ec->w;
											if(isWrkr()){ echo $this->_auto->err('GtEcLnkDt error:'.$_dt_ec->w); }
										}
									}

								}else{
									//echo 'Has not to save url';
								}

								$_nw_u = $this->_GtNLnUrl([ 'ec'=>$this->ec_id, 'lnk'=>enCad($old_src) ]); if(isWrkr()){ echo $this->_auto->li(' >  _GtNLn - _GtNLnUrl '.$_nw_u); }

								if(!isN($_nw_u->w)){ $this->w[] = $_nw_u->w; }

								if(!isN($_nw_u)){
									$tag->setAttribute('href', $_nw_u);
								}

							}

						}

					}

				}*/


			//---------------- START P TAGS ----------------//


				if($this->btrck == 'ok'){

					if(isWrkr()){ echo $this->_auto->li(' > Get <p> Tags '); }

					if($this->ec_ahtml != 'ok'){

						$tags_p = $doc->getElementsByTagName('p');

						foreach ($tags_p as $tag) {
							$old_src = $tag->getAttribute('style');
							$tag->setAttribute('style', str_replace('margin:0;padding:0;','',$old_src).';margin:0;padding:0;');
							if($tag->nodeValue == ''){
								$tag->parentNode->removeChild($tag);
							}
						}

					}

				}

			//---------------- START TABLE TAGS ----------------//

				//if($this->btrck == 'ok'){

					if(isWrkr()){ echo $this->_auto->li(' > Get <table> Tags '); }

					if($this->ec_ahtml != 'ok' && !isN( $doc )){

						$tags_table = $doc->getElementsByTagName('table');

						foreach ($tags_table as $tag) {

							$old_cid = $tag->getAttribute('id');
							$old_class = $tag->getAttribute('class');
							$old_style = $tag->getAttribute('style');
							$old_width = $tag->getAttribute('width');

							$old_border = $tag->getAttribute('border');
							$old_align = $tag->getAttribute('align');
							$old_cellp = $tag->getAttribute('cellpadding');
							$old_cells = $tag->getAttribute('cellspacing');

							if(isN($old_border)){ $tag->setAttribute('border', 0); }
							if(isN($old_align)){ $tag->setAttribute('align', 0); }
							if(isN($old_cellp)){ $tag->setAttribute('cellpadding', 0); }
							if(isN($old_cells)){ $tag->setAttribute('cellspacing', 0); }

							if($_r['pst'] == 'ok'){
								$tag->setAttribute('width', '100%');
							}

							$__style_t = explode(';', str_replace(' ','',$old_style) );

							foreach($__style_t as $_k){

								$__style_u = explode(':', str_replace(' ','',$_k) );
								$_r_n['nodes']['style'][] = $__style_u[0];

								$__propt = strtolower($__style_u[0]);

								if(	$__propt == 'width'){

									$__f_n = str_replace([ '%', ' '],'',$__style_u[1]);
									$__f_r = str_replace([' '],'',$__style_u[1]);

									//if($__f_n > 100){ $old_style = str_replace($__f_r,'100%', $old_style); }
									if(isN($__f_n)){ $old_style = str_replace($__f_r,'100%', $old_style); }

								}
							}


							if($old_class == 'table table-bordered'){

								$sty_b = 'border-collapse:collapse; border-spacing: 0px;';
								$new_style_td = '';

								foreach ($tag->getElementsByTagName('td') as $tagtd) {

									$old_style_td = $tagtd->getAttribute('style');

									$__style_f = explode(';', str_replace(' ','',$old_style_td) );

									if(count($__style_f) > 0){
										foreach($__style_f as $_k){
											if($_k != ''){
												$__style_k = explode(':', str_replace(' ','',$_k) );
												$_r_n['nodes']['style'][] = $__style_k[0];

												$__prop = strtolower($__style_k[0]);

												if(	$__prop != 'font-family'){

													if (strpos($__prop,'themecolor') == false) {
														$new_style_td[ $__prop ] = strtolower($__style_k[0]).':'.strtolower($__style_k[1]);
													}

												}
											}
										}
									}

									if(is_array($new_style_td)){ $___sty_i = implode(';',$new_style_td); }else{ $___sty_i = ''; }
									$tagtd->setAttribute('style', strip_tags( $___sty_i ).'; border: 1px solid #d4d4d4;' );


								}

							}

							if(isN($old_width)){ $sty_w = 'width:100%;'; }else{ $sty_w=''; }


							$sty_w .= " ; border-spacing:0; border-collapse:collapse; ";

							$tag->setAttribute('style', $old_style.$sty_w.$sty_b);
							//$tag->removeAttribute('class'); Now allowed

						}

					}

				//}

			//---------------- START TD TAGS ----------------//

				if($this->btrck == 'ok'){

					if(isWrkr()){ echo $this->_auto->li(' > Get <td> Tags '); }

					if($this->ec_ahtml != 'ok'){

						$tags_table_td = $doc->getElementsByTagName('td');

						foreach ($tags_table_td as $tag) {

							$old_style = $tag->getAttribute('style');
							$old_valign = $tag->getAttribute('valign');
							$new_style_td = '';

							if($old_valign == ''){
								//$tag->setAttribute('valign', 'top');
							}


							$__style_f = explode(';', /*str_replace(' ','',*/$old_style/*)*/ );

							if(count($__style_f) > 0){

								foreach($__style_f as $_k){
									if($_k != ''){
										$__style_k = explode(':', /*str_replace(' ','',*/$_k/*)*/ );
										$_r_n['nodes']['style'][] = $__style_k[0];

										$__prop = strtolower($__style_k[0]);

										if (strpos($__prop,'themecolor') == false && strpos($__prop,'mso-') == false) {
											$new_style_td[ $__prop ] = strtolower($__style_k[0]).':'.strtolower($__style_k[1]);
										}

									}
								}

							}

							if(is_array($new_style_td)){ $___sty_i = implode(';',$new_style_td); }else{ $___sty_i = $old_style; }

							if(strpos($___sty_i, 'padding') == false){

								//$___sty_i .= '; padding:0; ';

							}

							$tag->setAttribute('style', strip_tags( $___sty_i ) );

						}

					}

				}



			//---------------- START SPAN TAGS ----------------//


				if($this->btrck == 'ok'){

					if(isWrkr()){ echo $this->_auto->li(' > Get <span> Tags '); }

					if($this->ec_ahtml != 'ok'){

						$tags_span = $doc->getElementsByTagName('span');

						foreach ($tags_span as $tag) {
							$old_style = $tag->getAttribute('style');
							$tag->setAttribute('style', strip_tags($old_style) );

							$__style_f = explode(';', str_replace(' ','',$old_style) );
							$new_style = '';

							if(count($__style_f) > 0){
								foreach($__style_f as $_k){
									if($_k != ''){
										$__style_k = explode(':', str_replace(' ','',$_k) );
										$_r_n['nodes']['style'][] = $__style_k[0];

										$_prop = strtolower($__style_k[0]);

										if($_prop != 'font-family'){
											$new_style[ $_prop ] = strtolower($__style_k[0]).':'.strtolower($__style_k[1]);
										}
									}
								}
							}

							if(is_array($new_style)){
								$tag->setAttribute('style', strip_tags( implode(';',$new_style) ) );
							}
						}

					}

				}


			//---------------- START SPAN TAGS ----------------//


				if($this->btrck == 'ok'){

					if(isWrkr()){ echo $this->_auto->li(' > Get <img> Tags '); }

					if($this->ec_ahtml != 'ok'){

						$tags_img = $doc->getElementsByTagName('img');

						foreach ($tags_img as $tag) {

							$old_style = $tag->getAttribute('style');
							$tag->setAttribute('style', strip_tags($old_style) );

							$__style_f = explode(';', str_replace(' ','',$old_style) );
							$new_style = '';

							$new_style['display'] = 'display:block';

							if(count($__style_f) > 0){
								foreach($__style_f as $_k){
									if($_k != ''){
										$__style_k = explode(':', str_replace(' ','',$_k) );
										$_r_n['nodes']['style'][] = $__style_k[0];

										$_prop = strtolower($__style_k[0]);

										if($_prop != 'font-family'){
											$new_style[ $_prop ] = strtolower($__style_k[0]).':'.strtolower($__style_k[1]);
										}
									}
								}
							}

							if(is_array($new_style)){
								$tag->setAttribute('style', strip_tags( implode(';',$new_style) ) );
							}
						}

					}

				}

			/*
			foreach( $dom->getElementsByTagName("p") as $pnode ) {
			    $divnode->createElement("div");
			    $divnode->nodeValue = $pnode->nodeValue;
			    $pnode->appendChild($divnode);
			    $pnode->parentNode->removeChild($pnode);
			}
			*/

			if($this->btrck == 'ok'){
				if(isWrkr()){ echo $this->_auto->li(' > Remove <script> Tags '); }
				$this->removeElementsByTagName('script', $doc);
				if(isWrkr()){ echo $this->_auto->li(' > Remove <xml> Tags '); }
				$this->removeElementsByTagName('xml', $doc);
			}

			if($this->ec_ahtml != 'ok'){

				if($this->btrck == 'ok'){

					//$this->removeElementsByTagName('style', $doc); // allowed now
					$this->removeElementsByTagName('link', $doc);

					//echo '---------- $html saveHTML222222222 START--------------'; echo $doc->saveHTML(); echo '--------- $html save HTML2222222 END ---------';
					//$this->removeElementsByTagName('div', $doc);

					if($_r['tags'] != NULL){
						foreach($_r['tags'] as $_k){
							$this->removeElementsByTagName($_k, $doc);
						}
					}

					if($_r['bsc'] == 'ok'){
						echo $this->_auto->li(' > BSC OK ');
						$html = $this->DomRmvHtml( $this->_stripPhpComments( $this->sveHTML($doc) ) );
					}else{
						echo $this->_auto->li(' > SaveHTML ');
						$html = $this->sveHTML($doc);
					}

					//echo '---------- $html saveHTML START--------------'; echo $html; echo '--------- $html save HTML END ---------';

					if($_r['no_mso'] != 'ok' && isN($this->__dt_snd_i->id)){

						$html .= "
							<!--[if gte mso 7]><xml>
								<o:OfficeDocumentSettings>
								<o:AllowPNG/>
								<o:PixelsPerInch>96</o:PixelsPerInch>
								</o:OfficeDocumentSettings>
							</xml><![endif]-->
						";

					}

					echo $this->_auto->li(' > BTRCK 1 ');

				}else{

					$html = $_r['v'];
					echo $this->_auto->li(' > NO BTRCK ');

				}

			}else{

				if($this->btrck == 'ok'){

					$html = $this->sveHTML($doc); //echo h3(date("Y-m-d H:i:s").' _GtNLn - saveHTML').PHP_EOL;

				}else{

					$html = $_r['v'];
				}

			}

			$_r_n['cod'] = $html;

		} catch (Exception $e) {

			$_r_n['w'] = $e->getMessage();

		}

		//$_r_n = $this->remove_html_comments($_r_n);

		return json_decode(json_encode($_r_n));
	}


	public function sveHTML($c=NULL){
		if($this->ec_ahtml == 'ok' && $this->ec_html5 == 'ok'){
			$t = preg_replace('/^<!DOCTYPE.+?>/', '', $c->saveHTML());
		}else{
			$t = $c->saveHTML();
		}

		$t = str_replace(['%7B','%7D'],['{','}'],$t);

		return $t;
	}

	private function _FxC_Img($_r=NULL){


		if($this->btrck == 'ok'){

			$doc = new DOMDocument();
			$doc->loadHTML(mb_convert_encoding($_r['v'], 'HTML-ENTITIES', 'UTF-8'));
			$tags_h = $doc->getElementsByTagName('img');

			if($this->ec_ahtml != 'ok'){
				foreach ($tags_h as $tag) {
					$old_src = $tag->getAttribute('src');
					if (strpos($old_src, '?') !== false) {
					    $_r_i = $old_src;
					}else{
						$_r_i = $old_src.'?'.Gn_Rnd(5);
					}
					$tag->setAttribute('src', $_r_i);
				}
			}

			$_r_n = $this->sveHTML($doc);

		}else{

			$_r_n = $_r['v'];

		}


		return $_r_n;
	}


	//Direccion de Imagenes
	private function _FxC($_p=NULL){

		if($this->btrck == 'ok'){

			$browser = new Browser();

			if(!isN($this->ec_id)){

				if($this->frm == 'Ml'){
					$this->Cd_Cntc = DMN_EC.PrmLnk('bld', $this->ec_pml).'?'.DMN_EC_C; $this->Cd_Lnk= $this->ec_lnk;
				}else{
					$this->Cd_Cntc ='javascript:__cnt(\''.$this->ec_enc.'\', \''. $this->ec_eml .'\',\''. $this->ec_tt .'\'); ';
					if(($browser->getBrowser() == 'Internet Explorer') && ($browser->getVersion() < 9)){
						$this->Cd_Lnk=$this->ec_lnk;
					}else{
						$this->Cd_Lnk='javascript:__lnk(\''.urlencode($this->ec_lnk).'\'); ';
					}
				}


				if(isWrkr()){ echo $this->_auto->li(' > LoadDOM '); }

				$doc = new DOMDocument('1.0', 'UTF-8');
				$doc->recover = true;
				$doc->strictErrorChecking = false;
				@$doc->loadHTML(mb_convert_encoding($this->ec_cod, 'HTML-ENTITIES', 'UTF-8'));

				;
				//---------------- ETIQUETAS IMG SRC ----------------//

					$tags = $doc->getElementsByTagName('img');

					foreach ($tags as $tag) {

						$old_src = $tag->getAttribute('src');
						$old_sty = $tag->getAttribute('style');

						$new_src_url = DMN_FLE_EC.'html/'.$this->ec_fld.'/'.$old_src;

						if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
							$tag->setAttribute('src', $new_src_url);
							$tag->setAttribute('style', $old_sty.';display:block;');
						}

					}

				//---------------- SEARCH BACKGROUND IMAGE URL ----------------//

					if($this->ec_ahtml != 'ok'){

						$tags_d = $doc->getElementsByTagName('div');

						foreach ($tags_d as $tag) {
							$old_src = $tag->getAttribute('style');
							$tag->setAttribute('style', str_replace('margin:0;padding:0;','',$old_src).';margin:0;padding:0;');
							if($tag->nodeValue == ''){
								$tag->parentNode->removeChild($tag);
							}
						}

					}

				//---------------- SAVE HTML ----------------//

				$this->__cod_src = $this->sveHTML($doc);
				$Lnk_2 = $this->__cod_src;

				if($this->ec_ahtml != 'ok'){

					$Md = str_replace('display: inline-table;', 'display: inline-table; cellpadding:0px; cellspacing:0px; border-style: hidden; border-collapse:collapse; line-height:1px;', $Lnk_2);

					//$Md = str_replace('<img', '<img style="display:block;" border="0" ', $Md);

					$Md = str_replace('<br /> ', '', $Md);
					$Md = str_replace('<br> ', '', $Md);
					$Md = str_replace('/>td>', '/></td>', $Md);

				}else{

					$Md = $Lnk_2;

				}
			}

		}else{

			$Md = $this->ec_cod;

		}

		$this->__cod_nw = $Md;

	}

	private function _FxS_Sgm_iF($_v=NULL){

		$_r = $_v;

		//--------------- Get all Segment List ---------------//

		$__crt_all = GtSisEcCrt_Ls();

		//--------------- Get Value and Replace ---------------//

		if($this->if_clr != 'ok'){

			if($this->if_hde == 'ok'){
				$_cnhg = ['', ''];
			}else{
				$_cnhg = ['<!-- Segment Hidden Start ', ' Segment Hidden End -->'];
			}

			foreach($__crt_all as $_k=>$_v){
				$_r = str_replace([ '{IFS'.$_v->keyi.'}', '{/IFS'.$_v->keyi.'}' ], $_cnhg, $_r);
			}
		}

		return $_r;

	}

	private function _FxS_Sgm($_r=NULL){

		$_r_n = $this->_FxS_Sgm_iF($_r['v']);

		//--------------- Search Header Of Area ---------------//

		preg_match_all('/\[H.*?\]/', $_r_n, $_hdrs);

		foreach($_hdrs[0] as &$Key_hdrs){

			$__im_w = EcCmzImgTag($Key_hdrs, 'w');
			$__im_h = EcCmzImgTag($Key_hdrs, 'h');
			$_id_div_img = $__im_id->v;

			if(!isN($Key_hdrs)){

				if(!isN( $this->__dtec->are ) && $this->__dtec->are->tot > 0){

					foreach($this->__dtec->are->ls as $_k=>$_v){

						if(!isN( $_v->img->hdr->big )){
							$_hdr_cd = '<img style="" align="left" src="'.$_v->img->hdr->big.'?_rdm='.Gn_Rnd(10).'" '.$__im_w->t.' '.$__im_h->t.'>';
						}else{
							$_hdr_cd = '';
						}

						$_r_n = str_replace($Key_hdrs, $_hdr_cd, $_r_n);

					}

				}else{

					$_r_n = str_replace($Key_hdrs, '', $_r_n);

				}

			}

		}

		return $_r_n;
	}


	private function _FxP_Clr($_r=NULL){

		$_r_n = $_r['v'];

		/*
		if(!isN( $this->__dtec->are ) && $this->__dtec->are->tot > 0){

			foreach($this->__dtec->are->ls as $_k=>$_v){
				if(!isN($_v->clr)){
					$_r_n = str_replace('[ARE_CLR]', 'first', $_r_n);
					$_r_n = str_replace(['[ARE_CLR]','[are_clr]'], $_v->clr, $_r_n);
				}
			}

		}else{

			if($this->mdl_are->tot > 0){
				foreach($this->mdl_are->ls as $_mdl_are_k=>$_mdl_are_v){
					if(!isN($_mdl_are_v->are->clr)){
						$_r_n = str_replace(['[ARE_CLR]','[are_clr]'], $_mdl_are_v->are->clr, $_r_n);
					}
				}
			}

		}
		*/



		if(!isN($this->mdl_are) && !isN($this->mdl_are->tot) && $this->mdl_are->tot > 0){
			foreach($this->mdl_are->ls as $_mdl_are_k=>$_mdl_are_v){
				if(!isN($_mdl_are_v->are->clr)){
					$_r_n = str_replace(['[ARE_CLR]','[are_clr]'], $_mdl_are_v->are->clr, $_r_n);
				}
			}
		}elseif(!isN( $this->__dtec->are ) && $this->__dtec->are->tot > 0){

			foreach($this->__dtec->are->ls as $_k=>$_v){
				if(!isN($_v->clr)){
					$_r_n = str_replace('[ARE_CLR]', 'first', $_r_n);
					$_r_n = str_replace(['[ARE_CLR]','[are_clr]'], $_v->clr, $_r_n);
				}
			}

		}


		return $_r_n;

	}


	private function _FxA_Attr($_r=NULL){

		$_r_n = $_r['v'];


		//--------------- Find Values of Attributes Module - Saved ---------------//

			foreach($this->mdl_attr as $_attr_k=>$_attr_v){
				if(!isN( $_attr_v->all->cnct->vl )){
					if(mBln($_attr_v->all->date->vl) == 'ok'){
						$_v_go = FechaESP_OLD($_attr_v->vl, 'all');
					}elseif(!isN($_attr_v->vl)){
						$_v_go = $_attr_v->vl;
					}else{
						$_v_go = '';
					}
					$_r_n = str_replace('[MODULO_'.strtoupper($_attr_v->all->cnct->vl).']', $_v_go, $_r_n);
				}

			}

		//--------------- Clean all tags of sistem attribute module without value ---------------//

			$__mdl_attr_sis = __LsDt([ 'k'=>'mdls_tp_attr' ]);

			foreach($__mdl_attr_sis->ls->mdls_tp_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_r_n = str_replace('[MODULO_'.strtoupper($_sis_v->cnct->vl).']', '', $_r_n);
				}
			}


		//--------------- Find Values of Attributes Oportunity Saved ---------------//

			foreach($this->mdlcnt_attr as $_attr_k=>$_attr_v){
				if(!isN( $_attr_v->all->cnct->vl )){
					if(mBln($_attr_v->all->date->vl) == 'ok'){
						$_v_go = FechaESP_OLD($_attr_v->vl, 'all');
					}elseif(!isN($_attr_v->vl)){
						$_v_go = $_attr_v->vl;
					}else{
						$_v_go = '';
					}
					$_r_n = str_replace('[OPORTUNIDAD_'.strtoupper($_attr_v->all->cnct->vl).']', $_v_go, $_r_n);
				}

			}

		//--------------- Clean all tags of sistem attribute oportunity without value ---------------//

			$__mdl_attr_sis = __LsDt([ 'k'=>'mdl_cnt_attr' ]);

			foreach($__mdl_attr_sis->ls->mdl_cnt_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_r_n = str_replace('[OPORTUNIDAD_'.strtoupper($_sis_v->cnct->vl).']', '', $_r_n);
				}
			}


		//--------------- Find Values of Attributes Lead Saved ---------------//


			foreach($this->cnt_attr as $_attr_k=>$_attr_v){
				if(!isN( $_attr_v->all->cnct->vl )){
					if(mBln($_attr_v->all->date->vl) == 'ok'){
						$_v_go = FechaESP_OLD($_attr_v->vl, 'all');
					}elseif(!isN($_attr_v->vl)){
						$_v_go = $_attr_v->vl;
					}else{
						$_v_go = '';
					}
					$_r_n = str_replace('[LEAD_'.strtoupper($_attr_v->all->cnct->vl).']', $_v_go, $_r_n);
				}

			}

		//--------------- Clean all tags of sistem attribute lead without value ---------------//

			$__mdl_attr_sis = __LsDt([ 'k'=>'cnt_attr' ]);

			foreach($__mdl_attr_sis->ls->cnt_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_r_n = str_replace('[LEAD_'.strtoupper($_sis_v->cnct->vl).']', '', $_r_n);
				}
			}

		//--------------- Return HTML element ---------------//

		return $_r_n;

	}


	public function _Prhdr($_p=NULL){
		if(!isN($_p['t'])){ $this->cmpg_prhdr = $_p['t']; }
		if(!isN($this->cmpg_prhdr_nw)){ $_r = $this->cmpg_prhdr_nw; }else{ $_r = $_p['t']; }
		return $_r;
	}

	public function _Prhd_Wrp($t=NULL){
		$r = '	<span class="preheader" style="color:transparent; display:none!important; height:0; opacity:0; visibility:hidden; width:0">'.$t.'</span>
				<span style="display: none; max-height: 0px; overflow: hidden;">&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;</span>';
		return $r;
	}

	private function _Html($p=NULL){

		if($this->html == 'ok'){

			if((
				$this->__dtec->est->id != _CId('ID_SISEST_OK') &&
				$this->__dtec->est->id != _CId('ID_SISEST_APRB')
			) /*&& $this->frm != 'Ml'*/){

				$this->_Html_NoAct(); if(isWrkr()){ echo $this->_auto->li(' > _Html_NoAct '); }

				$__nocacheonline = '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
									<meta http-equiv="Pragma" content="no-cache" />
									<meta http-equiv="Expires" content="0" />';

			}else{

				$__nocacheonline = '';

			}

			if($this->__dtec->chk->hdr == 'no'){ $this->ec_hdr='no'; }else{ $this->ec_hdr='ok'; }
			if($this->__dtec->chk->ftr == 'no'){ $this->ec_ftr='no'; }else{ $this->ec_ftr='ok'; }

			$this->_Html_NoMore(); if(isWrkr()){ echo $this->_auto->li(' > _Html_NoMore '); }
			$this->_Html_Head(); if(isWrkr()){ echo $this->_auto->li(' > _Html_Head '); }
			$this->_Html_Pxl(); if(isWrkr()){ echo $this->_auto->li(' > _Html_Pxl '); }
			$this->_GtUrlMreTrck(); if(isWrkr()){ echo $this->_auto->li(' > _GtUrlMreTrck '); }

			if(!isN($this->cmpg_prhdr)){
				$__prhdr_tx = $this->cmpg_prhdr;
			}elseif(!isN($this->cmpg_prhdr_nw)){
				$__prhdr_tx = $this->cmpg_prhdr_nw;
			}

			if(!isN($__prhdr_tx)){
				$__prhdr = $this->_Prhd_Wrp($__prhdr_tx);
			}else{
				if($this->isAwsT()){
					$__prhdr = '{{preheader}}';
				}elseif(isN($this->__dt_snd_i->id)){
					$__prhdr = '[PREHEADER]';
				}
			}

			if(isWrkr()){ echo $this->_auto->li(' > There is Preheader? '.$__prhdr_tx); }


			if($this->ec_ahtml == 'ok'){

				$_r = $this->_Html_Wrp([ 'wrp'=>'no', 'prhdr'=>$__prhdr ]);
				if(isWrkr()){ echo $this->_auto->li(' > _Html_Wrp '); }

			}else{

				if($this->btrck == 'ok'){

					//echo '$__prhdr:'.$__prhdr;

					$_r = compress_code('<!DOCTYPE html>
							<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<title>'.$this->ec_tt.'</title>
								<meta name="viewport" content="width=device-width"/>
								<meta property="fb:app_id" content="'.APP_FB_ID.'"/>
								<meta property="og:title" content="'.$this->ec_tt.'"/>
								<meta property="og:type" content="website" />
								<meta property="og:url" content="'.DMN_EC.PrmLnk('bld', $this->ec_pml).'" />
								<meta property="og:image" content="'.DMN_FLE_EC_IMG.$this->ec_img.'"/>
								<meta property="og:site_name" content="'.$this->ec_tt.'" />
								<meta property="og:description" content="'.strip_tags($this->ec_dsc).'" />
								'.$__nocacheonline.'


									<style>

										table {border-collapse:separate;}
										a, a:link, a:visited {text-decoration: none; color: #00788a;}
										a:hover {text-decoration: underline;}
										h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5,h6,.t_cht {color:#000!important;}
										.ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%;}
										.ExternalClass {width: 100%;}

										table {
											border-spacing:0px!important; border-collapse:collapse!important;
										}

										.Svin_Table_Main table { border-spacing:0px!important; border-collapse:collapse!important; }
										.Svin_Table_Main table td p span,
										.Svin_Table_Main table td p,
										.Svin_Table_Main table td image{ display:block; line-height:1px; }


									</style>

							</head>
							<body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px; background-color:#').$this->ec_fnd.'">
							'.$__prhdr.$this->_Html_Wrp().'
							</body>
							</html>';

					//if(isWrkr()){ echo $this->_auto->li(' > Worker build this html: '.$_r); }

				}else{

					$_r = $this->_Html_Wrp([ 'prhdr'=>$__prhdr ]);

				}

				if(isWrkr()){ echo $this->_auto->li(' > Return HTML Main Estructure '); }

			}

			$_r = $_r;

			if($p['norplc'] !='ok' || !isN($this->__dt_snd_i->enc) || $this->isAwsT()){

				$_r = str_replace(
							['@@@sumr_hdr@@@', '@@@sumr_pxl@@@', '@@@sumr_no_more@@@', '@@@sumr_trck_mre@@@'],
							[$this->html_head, $this->html_pxl, $this->html_no_more, $this->sumr_trck_mre],
							$_r
						);
			}


		}else{

			$_r = $this->__cod_nw;

			if($p['norplc']!='ok'){

				$_r = str_replace(
							['@@@sumr_hdr@@@', '@@@sumr_pxl@@@', '@@@sumr_no_more@@@', '@@@sumr_trck_mre@@@'],
							[$this->html_head, $this->html_pxl, $this->html_no_more, $this->sumr_trck_mre],
							$_r
						);

			}

		}

		$this->__cod_nw = $_r;
		//echo '$this->ec_ahtml:'.$this->ec_ahtml.'->'.$this->__cod_nw;

	}


	//No Activo
	private function _Html_NoAct(){

		$_prvw = Php_Ls_Cln($_GET['_prvw']);

		$_pml = DMN_EC.PrmLnk('bld', $this->ec_pml);

		$Cod = '<div id="_noaprbd_bx" style="background-color:#ff0000; width:100%; min-width:600px; padding-top:10px; padding-bottom:10px; text-align:center; font-family: Tahoma, Geneva, sans-serif;font-size: 11px; color:#fff; font-weight:bold; text-transform:uppercase; ">No aprobada <a href="javascript:void(0);" onClick="__rfrsh();" style="border-radius:10px;
-moz-border-radius:10px; -webkit-border-radius:10px; background-color:white; text-decoration:none; color:#ff0000; font-weight:bolder; text-transform:uppercase; padding:5px 10px; margin-left:10px;">Recargar página</a> </div> <div class="_mrk" id="_mrk_bx" style="position:fixed; background-image:url('.DMN_IMG_ESTR_SVG.'ec_mrk.svg);background-repeat:repeat;  width:100%; height:100%; left:0; top:32px; z-index:9999999; background-position:center 80px; opacity: 0.3; -webkit-background-size: 150px, 150px;-moz-background-size: 150px, 150px;-o-background-size: 150px, 150px; background-size: 150px, 150px;"></div>
			<script>

				function __rfrsh(){
					var url = window.location.href.split(\'?\')[0];
					window.location.href = url+\'?_r=\'+Math.random();;
				}

				console.log("%cDesarrollado por SUMR", "color: red; font-size: 20px; font-weight:bolder; font-family:Calibri, Tahoma;");

				console.log("%cEsta funcion del navegador esta pensada para desarrolladores. Si alguien te indicp que copiaras y pegaras algo aqui para habilitar una funcion o para modificar el diseno, puedes estar incurriendo en un acto ilegal.", "color:#9e9e9e; font-size: 10px; font-weight:300; font-family: Roboto; ");

			</script>';

		if($_prvw != 'ok' && $this->no_act_dspl != 'ok'){ $this->html_no_act = $Cod; }
	}



	//No Deseado
	private function _Html_NoMore(){

		$__pc_enc = '';
		$_pml = DMN_EC.PrmLnk('bld', $this->ec_pml);

		if(!isN($this->mdlcnt_ec_enc)){ $__pc_enc .= '&_s='.$this->mdlcnt_ec_enc; }
		if(!isN($this->c->enc)){ $__pc_enc .= '&_c='.$this->c->enc; }
		if(!isN($__pc_enc)){ /*$__pc_enc .= '&_Rnd='.Gn_Rnd(5);*/ }
		if($this->ec_ahtml == 'ok'){ $_tb_w = '100%'; }else{ $_tb_w = $this->ec_w.'px'; }

		if(!isN($__pc_enc)){

			$Cod = '<table style="align: center; width:'.$_tb_w.'!important; border-spacing:0px; border-collapse:collapse; " width="'.$_tb_w.'; border-spacing:0px;border-collapse:collapse">
						<tr>
							<td style="text-align:center; vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 10px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;">&nbsp;</td>
						</tr>
						<tr>
							<td style="text-align: justify;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;line-height: normal;font-weight: normal;color: #999999;">'.TX_ECHBSDT.'</td>
						</tr>
						<tr>
							<td style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 9px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;">&nbsp;</td>
						</tr>
						<tr>
							<td style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;"><a href="'.DMN_EC.$this->c->sbd.'/'.LNK_DEL.'/?'.$__pc_enc.'" style="color:#'.$sp.'">'.TX_CNDLLST.'(Remove)</a> | <a href="'.DMN_EC.$this->c->sbd.'/'.LNK_UPD.'/?'.$__pc_enc.'" style="color:#'.$sp.'">Actualizar mis Datos</a> | <a href="'.$_pml.'?'.DMN_EC_TLL.'" style="color:#'.$sp.'">'.TX_FRWRD.' '.TX_FRND.'</a></td>
						</tr>
					</table>';

		}else{

			$Cod = '<table style="align: center; width:'.$_tb_w.'!important; border-spacing:0px; border-collapse:collapse; " width="'.$_tb_w.'; border-spacing:0px;border-collapse:collapse">
						<tr>
							<td style="text-align:center; vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 10px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;">&nbsp;</td>
						</tr>
						<tr>
							<td style="text-align: justify;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;line-height: normal;font-weight: normal;color: #999999;">'.TX_ECHBSDT.'</td>
						</tr>
						<tr>
							<td style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 9px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;">&nbsp;</td>
						</tr>
						<tr>
							<td style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;"><a href="'.DMN_EC.$this->c->sbd.'/'.LNK_DEL.'/?'.$__pc_enc.'" style="color:#'.$sp.'">'.TX_CNDLLST.'(Remove)</a> | <a href="'.DMN_EC.$this->c->sbd.'/'.LNK_UPD.'/?'.$__pc_enc.'" style="color:#'.$sp.'">Actualizar mis Datos</a> | <a href="'.$_pml.'?'.DMN_EC_TLL.'" style="color:#'.$sp.'">'.TX_FRWRD.' '.TX_FRND.'</a></td>
						</tr>
					</table>';

		}

		if($this->ec_ftr != 'no'){
			if($this->btrck == 'ok' && isN($this->__dt_snd_i->id) && !$this->isAwsT()){
				$this->html_no_more = '@@@sumr_no_more@@@';
			}else{
				$this->html_no_more = $Cod;
			}
		}

	}

	// Encabezado HTML Mails
	private function _Html_Head(){

		$__spn = '#00482B';

		if($this->isAwsT()){
			$__shr_lnk = '{{share_link}}';
		}else{
			if(!isN($this->ec_shr)){
				$__shr_lnk = urlencode($this->ec_shr);
			}else{
				$__shr_lnk = urlencode(DMN_EC.$this->ec_pml);
			}
		}

	    $__shr_tt = urlencode($this->ec_tt);
		$_shr_fb = "https://www.facebook.com/sharer/sharer.php?u=".$__shr_lnk."&display=popup";
	    $_shr_tw = "https://twitter.com/intent/tweet?text=".$__shr_tt."&tw_p=&url=".$__shr_lnk."&via=sumr";
	    $_shr_ld = "http://www.linkedin.com/shareArticle?mini=true&url=".$__shr_lnk."&title=".$__shr_tt."&source=sumr";
	    $_shr_go = "https://plus.google.com/share?url=".$__shr_lnk;
	    $_shr_pn = "http://pinterest.com/pin/create/button/?url=".$__shr_lnk."&media=".urlencode(DMN_FLE_EC.$this->ec_img)."&description=".$__shr_tt;
		$_pml = DMN_EC.PrmLnk('bld', $this->ec_pml);

		if($this->ec_pdf == 1 && $this->ec_sis != 'ok'){
			$_pdf .= '<td><a title="Pdf" href="'.DMN_FLE_EC_HTML.$this->ec_dir.'/src.pdf" target="_blank"><img title="Pdf" alt="Pdf" src="'.DMN_IMG_ESTR_EC.RDS_IC_6.'" width="25" height="25"></a></td>';
		}

		if($this->ec_sis == 'ok'){
			$_onl_break = ' ';
		}else{
			$_onl_break = '<br>';
		}

		$_onl = '&iquest;'.TX_CNTML.'<b>'.$_onl_break.'<a title="On-Line" href="'.$_pml.'" target="_blank" style="font-family: Tahoma, Geneva, sans-serif;	font-size: 11px;font-style: normal;	font-weight: 300;	color:#'.$this->ec_spn.'; text-decoration: none;">Ver Online</a></b>';

		if($this->ec_sis != 'ok'){

			if($this->ec_scl != 'no'){

				$_rds = '<td style="padding-left: 15px; /*padding-right: 15px; border-right: 1px solid #CCC;*/ border-left: 1px solid #CCC;">
						<table cellspacing="0" cellpadding="4" style="margin-left:auto;margin-right:auto;">
								<tbody><tr> <td><a href="'.$_shr_fb.'" target="_blank"><img src="'.DMN_IMG_ESTR_EC.RDS_IC_1.'" width="25" height="25"></a></td> <td><a href="'.$_shr_tw.'" target="_blank"><img src="'.DMN_IMG_ESTR_EC.RDS_IC_2.'" width="25" height="25"></a></td> <td><a href="'.$_shr_ld.'" target="_blank"><img src="'.DMN_IMG_ESTR_EC.RDS_IC_3.'" width="25" height="25"></a></td> <td><a href="'.$_shr_go.'" target="_blank"><img src="'.DMN_IMG_ESTR_EC.RDS_IC_4.'" width="25" height="25"></a></td><td><a href="'.$_shr_pn.'" target="_blank"><img src="'.DMN_IMG_ESTR_EC.RDS_IC_5.'" width="25" height="25"></a></td>'.$_pdf.'</tr>
								</tbody>
						</table>
					</td>';

			}

			if($this->ec_tll != 'no'){

				/*$_tll = '<table cellspacing="0" cellpadding="4" style="margin-left:auto;margin-right:auto;">
							<tbody>
								<tr>
									<td nowrap style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;	font-weight: normal; color: #999;"><b><a href="'.$_pml.'?'.DMN_EC_TLL.'" target="_blank" style="font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;font-weight:300;color:#'.$__spn.'; text-decoration: none; line-height:10px;">'.TX_FRWRD.'<br>'.TX_FRND.'</a></b></td>
									<td nowrap ><img src="'.DMN_IMG_ESTR_EC.RDS_IC_7.'" width="25" height="25"></td>
								</tr>
							</tbody>
						</table>';*/

			}
		}

		if($this->ec_ahtml == 'ok'){
			$_tb_w = '600px';
		}else{
			$_tb_w = $this->ec_w.'px';
		}

		if($this->ec_hdr != 'no'){
			$Cod = '<table width="'.$_tb_w.'" border="0" cellspacing="0" cellpadding="0" style="margin-left:auto;margin-right:auto;border-spacing:0px;border-collapse:collapse"><tr> <td style=" padding-top: 4px; padding-bottom: 15px; "><table cellspacing="0" cellpadding="0" style="border-spacing:0px;border-collapse:collapse;margin-left:auto;margin-right:auto;"><tbody><tr><td nowrap style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;	font-size: 11px;font-style: normal;font-weight: normal; color: #999; padding-right:15px;">'.$_onl.'</td>'.$_rds.'<td vstyle="padding-left:15px;">'.$_tll.'</td></tr></tbody> </table></td></tr></table>';
		}else{
			$Cod = '';
		}

		//border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #999;

		if($this->btrck=='ok' && isN($this->__dt_snd_i->id) && !$this->isAwsT()){
			$this->html_head = '@@@sumr_hdr@@@';
		}else{
			$this->html_head = $Cod;
		}

	}

	public function DomRmvHtml($html=null){
		return preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $html));
	}

	public function _Html_Wrp_C($element, $html){
	    $fragment = $element->ownerDocument->createDocumentFragment();
	    $fragment->appendXML($html);
	    $clone = $element->cloneNode(); // Get element copy without children
	    $clone->appendChild($fragment);
	    $element->parentNode->replaceChild($clone, $element);
	}


	// Construccion de Tabla
	public function _Html_Wrp($_p=NULL){

		if($this->frm == 'Ml'){ $StyMl = ' style="width: 100%; border-spacing:0px;border-collapse:collapse;" '; }
		if(!isN( $_p['prhdr'] )){ $_prhdr = $_p['prhdr']; }

		if($_p['wrp'] == 'no'){

			if(
				$this->ec_ahtml == 'ok' &&
				$this->svsrce == 'ok'
			){

				$html_c = mb_convert_encoding($this->__cod_nw, 'HTML-ENTITIES', 'UTF-8');

				$doc = new DOMDocument('1.0', 'UTF-8');
				$doc->recover = true;
				$doc->strictErrorChecking = false;
				@$doc->loadHTML( $html_c );

				$_body = $doc->getElementsByTagName('body')->item(0);
				$_body_f = $_body->firstChild;

				$_scl = $doc->createTextNode($_prhdr.$this->html_head);
				$_bsc = $doc->createTextNode($this->html_pxl.$this->html_no_more.$this->html_mre);

				$_body->insertBefore($_scl, $_body_f);
				$_body->appendChild($_bsc);

				$NwBod .= $this->sveHTML($doc);
				//$NwBod .= $this->__cod_nw;

			}else{

				$NwBod .= $this->__cod_nw;

			}

		}else{

			//$NwBod .= $this->html_no_act.$this->html_head.$this->__cod_nw.$this->html_no_more.$this->html_pxl.$this->html_mre;

			if(!isN($this->__cod_nw) && $this->btrck == 'ok'){

				$NwBod .= $_prhdr;
				$NwBod .= $this->html_no_act.
						"
						<!--[if (gte mso 9)|(IE)]>
						<center class=\"Svin_Table_Main\">
						<table><tr><td width=\"580\">
						<![endif]-->

						<!--[if !mso]>-->
						<table ".$StyMl." align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td align=\"center\">
						<!--<![endif]-->".
									$this->html_head. $this->DomRmvHtml($this->__cod_nw) .$this->html_no_more
						."<!--[if !mso]>-->
								</td>
							</tr>
						</table>
						<!--<![endif]-->

						<!--[if (gte mso 9)|(IE)]>
						</td></tr></table>
						</center>
						<![endif]-->
						".$this->html_pxl.$this->html_mre;

			}else{

				$NwBod .= $_prhdr;
				$NwBod .= $this->__cod_nw;

			}

		}

		if($this->btrck != 'ok'){

			$NwBod = str_replace(
						['@@@sumr_hdr@@@', '@@@sumr_pxl@@@', '@@@sumr_no_more@@@', '@@@sumr_trck_mre@@@'],
						[$this->html_head, $this->html_pxl, $this->html_no_more, $this->sumr_trck_mre],
						$NwBod
					);

		}

		return($NwBod);

	}

	// Tracking Mail
	private function _Html_Pxl(){

		if($this->btrck == 'ok' && isN($this->__dt_snd_i->id)){
			if($this->isAwsT()){
				$_pml = DMN_TRCK;
				$Cod = '<img src="'.$_pml.PXLNM.'cnt/{{cl_id}}/{{send_id}/" width="1" height="1" border="0" alt="SUMR_Pxl">';
				$this->html_pxl .= $Cod;
			}else{
				$this->html_pxl .= '@@@sumr_pxl@@@';
			}
		}elseif(!isN($this->mdlcnt_ec_enc)){
			$_pml = DMN_TRCK;
			$Cod = '<img src="'.$_pml.PXLNM.'cnt/'.$this->c->enc.'/'.$this->mdlcnt_ec_enc.'/" width="1" height="1" border="0" alt="SUMR_Pxl">';
			$this->html_pxl .= $Cod;
		}elseif(!isN($this->clfljsnd_enc)){
			$_pml = DMN_TRCK;
			$Cod = '<img src="'.$_pml.PXLNM."cl/".$this->c->enc.$this->clfljsnd_enc.'/" width="1" height="1" border="0" alt="SUMR_Pxl">';
			$this->html_pxl .= $Cod;
		}else{
			$this->html_pxl = '';
		}

	}



	public function _SndEc_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($this->snd_f) && !isN($this->snd_h) && !isN($this->snd_ec) && !isN($this->snd_cnt) && !isN($this->snd_eml) ){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }


			if($p['t'] == 'r'){

				$__innr = 'INNER JOIN '.$__bd.TB_EC_SND_R.' ON ecsndr_ecsnd = id_ecsnd';
				$__wflt = sprintf(' AND ecsndr_tp=%s AND ecsndr_id=%s', GtSQLVlStr($this->sndr_tp, 'int'), GtSQLVlStr($this->sndr_id, 'int'));

			}elseif($p['t'] == 'mdl'){

				$__innr = 'INNER JOIN '.$__bd.TB_MDL_CNT_EC.' ON mdlcntec_ecsnd = id_ecsnd';
				$__wflt = sprintf(' AND mdlcntec_mdlcnt=%s', GtSQLVlStr($this->snd_mdlcnt, 'int'));

			}elseif($p['t'] == 'cmpg'){

				$__slmre = ', ecsndcmpg_cmpg';
				$__innr = sprintf('LEFT JOIN '.$__bd.TB_EC_SND_CMPG.' ON ecsndcmpg_snd = id_ecsnd AND ecsndcmpg_cmpg=%s', GtSQLVlStr($this->snd_cmpg, 'int'));

			}elseif($p['t'] == 'dvrf'){

				$__innr = 'INNER JOIN '.$__bd.TB_CNT_DVRF.' ON cntdvrf_eml_snd = id_ecsnd';

			}

			$query_DtRg = sprintf('	SELECT id_ecsnd, ecsnd_enc '.$__slmre.'
									FROM '.$__bd.TB_MDL_EC_SND.'
										 '.$__innr.'
								   	WHERE ecsnd_f=%s AND ecsnd_h=%s AND ecsnd_ec=%s AND ecsnd_cnt=%s AND ecsnd_eml=%s '.$__wflt.'
								   	LIMIT 1',
								   	GtSQLVlStr($this->snd_f, 'date'),
								   	GtSQLVlStr($this->snd_h, 'date'),
								   	GtSQLVlStr($this->snd_ec, 'int'),
								   	GtSQLVlStr($this->snd_cnt, 'int'),
								   	GtSQLVlStr(strtolower($this->snd_eml), 'text')
								);

			$DtRg = $__cnx->_prc($query_DtRg);

			if(isWrkr()){
				$Vl['q'] = $query_DtRg;
			}

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_ecsnd'];
					$Vl['enc'] = $row_DtRg['ecsnd_enc'];

					if($p['t'] == 'cmpg'){
						$Vl['cmpg']['id'] = $row_DtRg['ecsndcmpg_cmpg'];
					}

				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['m'] = 'No id';

		}


		return _jEnc($Vl);

	}



	public function _MdlCntEc_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['mdlcnt']) && !isN($p['ecsnd']) ){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			$query_DtRg = sprintf('	SELECT *
								   	FROM '.$__bd.TB_MDL_CNT_EC.'
								   	WHERE mdlcntec_mdlcnt = %s AND mdlcntec_ecsnd = %s
								   	LIMIT 1',
								   	GtSQLVlStr($p['mdlcnt'], 'int'),
								   	GtSQLVlStr($p['ecsnd'], 'int')
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlcntec'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

		}else{

			$Vl['m'] = 'No id';

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}




	public function _EcSndCmpg_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['cmpg']) && !isN($p['ecsnd']) ){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			$query_DtRg = sprintf('	SELECT *
								   	FROM '.$__bd.TB_EC_SND_CMPG.'
								   	WHERE ecsndcmpg_cmpg=%s AND ecsndcmpg_snd=%s
								   	LIMIT 1',
								   	GtSQLVlStr($p['cmpg'], 'int'),
								   	GtSQLVlStr($p['ecsnd'], 'int')
								);

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_ecsndcmpg'];
				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

		}else{

			$Vl['m'] = 'No id';

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}



	public function _SndEcR_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['tp']) && !isN($p['ecsnd']) ){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			$query_DtRg = sprintf('	SELECT *
								   	FROM '.$__bd.TB_EC_SND_R.'
								   	WHERE ecsndr_tp = %s AND ecsndr_ecsnd = %s
								   	LIMIT 1',
								   	GtSQLVlStr($p['tp'], 'int'),
								   	GtSQLVlStr($p['ecsnd'], 'int')
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_ecsndr'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

		}else{

			$Vl['m'] = 'No id';

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}

	public function _SndEc($p=NULL){

		global $__cnx;
		$_prc_e = 'ok';
		$__cnx->c_p->autocommit(FALSE);

		if($this->snd_test == 'ok'){ $__test = 1; }else{ $__test = 2; }

		if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

		if(!isN($this->snd_f) && !isN($this->snd_h) && filter_var($this->snd_eml, FILTER_VALIDATE_EMAIL)){

			$rsp = [];
			$__chk = $this->_SndEc_Chk($p);

			if($__chk->e == 'ok'){

				if(!isN($__chk->id)){

					$rsp['i'] = $__chk->id;
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;

				}else{

					$__enc = Enc_Rnd($this->snd_f.'-'.$this->snd_h.'-'.$this->snd_ec.'-'.$this->snd_eml);

					if(!isN($this->snd_est)){ $_est = $this->snd_est; }else{ $_est = _CId('ID_SNDEST_PRG'); }
					if(!isN($this->snd_prty)){ $_prty = $this->snd_prty; }else{ $_prty = 2; }
					if(!isN($this->snd_plcy) && !isN($this->snd_plcy->e)){ $_plcy = $this->snd_plcy->e; }else{ $_plcy = 1; }
					if(!isN($this->snd_plcy) && !isN($this->snd_plcy->id)){ $_plcy_id = $this->snd_plcy->id; }else{ $_plcy_id = NULL; }
					if(!isN($this->snd_cleml)){
						$_cleml = $this->snd_cleml;
						$_qry_f = ', ecsnd_cleml';
						$_qry_v = sprintf(",%s", GtSQLVlStr($_cleml, "int"));
					}else{
						$_qry_f = '';
						$_qry_v = '';
					}

					$insertSQL = sprintf("INSERT INTO ".$__bd.TB_EC_SND." (ecsnd_enc, ecsnd_est, ecsnd_f, ecsnd_h, ecsnd_ec, ecsnd_eml, ecsnd_cnt, ecsnd_snd, ecsnd_test, ecsnd_prty, ecsnd_up_col, ecsnd_tll, ecsnd_plcy, ecsnd_plcy_id {$_qry_f}) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s {$_qry_v})",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($_est, "int"),
								GtSQLVlStr($this->snd_f, "date"),
								GtSQLVlStr($this->snd_h, "date"),
								GtSQLVlStr($this->snd_ec, "int"),
								GtSQLVlStr(strtolower($this->snd_eml), "text"),
								GtSQLVlStr($this->snd_cnt, "int"),
								GtSQLVlStr($this->snd_us, "int"),
								GtSQLVlStr($__test, "int"),
								GtSQLVlStr($_prty, "int"),
								GtSQLVlStr($this->snd_upcol, "int"),
								GtSQLVlStr($this->snd_tll, "int"),
								GtSQLVlStr($_plcy, "int"),
								GtSQLVlStr($_plcy_id, "int"));

					$Result = $__cnx->_prc($insertSQL);

					if($Result){
						$rsp['i'] = $__cnx->c_p->insert_id;
					}else{
						$_prc_e = 'no';
						$rsp['wmain'] = $__cnx->c_p->error;
						$rsp['chkt'] = $__chk;
						$rsp['w'][] = 'insertSQL error '.$__cnx->c_p->error;
					}

				}

				if(!isN($rsp['i'])){

					if($p['t'] == 'r'){

						$__chk = $this->_SndEcR_Chk([ 'tp'=>$this->sndr_tp, 'ecsnd'=>$rsp['i'] ]);

						if(isN($__chk->id)){

							$__enc = Enc_Rnd($this->sndr_id.'-'.$this->sndr_tp);

							$insertSQL_Rlc = sprintf("INSERT INTO ".$__bd.TB_EC_SND_R." (ecsndr_enc, ecsndr_tp, ecsndr_id, ecsndr_ecsnd) VALUES (%s, %s, %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($this->sndr_tp, "text"),
								GtSQLVlStr($this->sndr_id, "int"),
								GtSQLVlStr($rsp['i'], "int"));

						}

					}elseif($p['t'] == 'mdl'){

						$__chk = $this->_MdlCntEc_Chk([ 'mdlcnt'=>$this->snd_mdlcnt, 'ecsnd'=>$rsp['i'] ]);

						if(isN($__chk->id)){

							$__enc = Enc_Rnd($this->snd_mdlcnt.'-'.$rsp['i']);

							$insertSQL_Rlc = sprintf("INSERT INTO ".$__bd.TB_MDL_CNT_EC." (mdlcntec_enc, mdlcntec_mdlcnt, mdlcntec_ecsnd) VALUES (%s, %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($this->snd_mdlcnt, "int"),
								GtSQLVlStr($rsp['i'], "int"));

						}

					}elseif($p['t'] == 'cmpg'){

						$__chk = $this->_EcSndCmpg_Chk([ 'cmpg'=>$this->snd_cmpg, 'ecsnd'=>$rsp['i'] ]);

						if(isN($__chk->id) && (isN($__chk->cmpg) || isN($__chk->cmpg->id))){

							$__enc = Enc_Rnd($this->snd_mdlcnt.'-'.$rsp['i']);

							$insertSQL_Rlc = sprintf("INSERT INTO ".$__bd.TB_EC_SND_CMPG." (ecsndcmpg_cmpg, ecsndcmpg_snd) VALUES (%s, %s)",
								GtSQLVlStr($this->snd_cmpg, "int"),
								GtSQLVlStr($rsp['i'], "int"));

						}

					}elseif($p['t'] == 'dvrf'){

						if(!isN($this->snd_eml_dvrf)){

							$insertSQL_Rlc = sprintf("UPDATE ".$__bd.TB_CNT_DVRF." SET cntdvrf_eml_snd=%s WHERE id_cntdvrf=%s",
													GtSQLVlStr( $rsp['i'] , "int"),
													GtSQLVlStr( $this->snd_eml_dvrf , "int"));

						}

					}

					if(!isN($insertSQL_Rlc)){

						$Result_Rlc = $__cnx->_prc($insertSQL_Rlc);

						if(!$Result_Rlc){
							$rsp['e'] = 'no';
							$_prc_e = 'no';
							$rsp['w'][] = $__bd.' - '.$__cnx->c_p->error.' on '.$insertSQL_Rlc;
						}

					}

					if($p['auto']=='ok'){ $rsp['u_o'] = __AutoRUN([ 't'=>'snd' ]); }

				}else{

					$rsp['e'] = 'no';
					$rsp['m'] = 2;

					$rsp['w'][] = 'NO ID on $rsp[i]';
					$rsp['w'][] = $__cnx->c_p->error;

					$_prc_e = 'no';
					_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);

				}

				if($_prc_e == 'ok'){
					if($__cnx->c_p->commit()){
						$rsp['e'] = 'ok';
					}else{
						$rsp['w'][] = $__cnx->c_p->error;
						$rsp['w'][] = 'Commit not success, has to do rollback';
						$__cnx->c_p->rollback();
					}
				}else{
					$rsp['w'][] = 'There are errors before, has to do rollback';
					$__cnx->c_p->rollback();
				}

			}

		}else{

			if(isN($this->snd_f)){ $_w_m .= 'Not date to send'; }
			if(isN($this->snd_h)){ $_w_m .= 'Not hour to send'; }
			if(!filter_var($this->snd_eml, FILTER_VALIDATE_EMAIL)){ $_w_m .= 'Not validate email '.$this->snd_eml; }

			$rsp['w'] = 'First filter not passing | '.$_w_m;

		}

		$__cnx->c_p->autocommit(TRUE);
		return _jEnc($rsp);

	}




	public function _SndEc_UPD($p=NULL){

		global $__cnx;

		if(!isN($p['enc'])){

			if(!isN($p['sbj'])){ $_upd[] = sprintf('ecsnd_sbj=%s', GtSQLVlStr(ctjTx($p['sbj'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'] ), "text")); }

			if(!isN($p['snd_id'])){ $_upd[] = sprintf('ecsnd_id=%s', GtSQLVlStr($p['snd_id'], "text")); }
			if(!isN($p['srv_id'])){ $_upd[] = sprintf('ecsnd_srv=%s', GtSQLVlStr($p['srv_id'], "text")); }

			if(!isN($p['est'])){ $_upd[] = sprintf('ecsnd_est=%s', GtSQLVlStr($p['est'], "text")); }
			if(!isN($p['bnc'])){ $_upd[] = sprintf('ecsnd_bnc=%s', GtSQLVlStr($p['bnc'], "text")); }
			if(!isN($p['bnc_sbj'])){ $_upd[] = sprintf('ecsnd_bnc_sbj=%s', GtSQLVlStr($p['bnc_sbj'], "text")); }
			if(!isN($p['bnc_msg'])){ $_upd[] = sprintf('ecsnd_bnc_msg=%s', GtSQLVlStr($p['bnc_msg'], "text")); }
			if(!isN($p['bnc_tp'])){ $_upd[] = sprintf('ecsnd_bnc_tp=%s', GtSQLVlStr($p['bnc_tp'], "text")); }
			if(!isN($p['bnc_tp_sub'])){ $_upd[] = sprintf('ecsnd_bnc_tp_sub=%s', GtSQLVlStr($p['bnc_tp_sub'], "text")); }
			if(!isN($p['bnc_rpr'])){ $_upd[] = sprintf('ecsnd_bnc_rpr=%s', GtSQLVlStr($p['bnc_rpr'], "text")); }
			if(!isN($p['bnc_rule'])){ $_upd[] = sprintf('ecsnd_bnc_rule=%s', GtSQLVlStr($p['bnc_rule'], "text")); }

			if(!isN($p['dlvry_tmmls'])){ $_upd[] = sprintf('ecsnd_dlvry_tmmls=%s', GtSQLVlStr($p['dlvry_tmmls'], "text")); }
			if(!isN($p['dlvry_tmstmp'])){ $_upd[] = sprintf('ecsnd_dlvry_tmstmp=%s', GtSQLVlStr($p['dlvry_tmstmp'], "text")); }
			if(!isN($p['dlvry_smtrsp'])){ $_upd[] = sprintf('ecsnd_dlvry_smtrsp=%s', GtSQLVlStr($p['dlvry_smtrsp'], "text")); }
			if(!isN($p['dlvry_rmtmta'])){ $_upd[] = sprintf('ecsnd_dlvry_rmtmta=%s', GtSQLVlStr($p['dlvry_rmtmta'], "text")); }
			if(!isN($p['dlvry_rmtmta_ip'])){ $_upd[] = sprintf('ecsnd_dlvry_rmtmta_ip=%s', GtSQLVlStr($p['dlvry_rmtmta_ip'], "text")); }

			if(!isN($p['rply_eml'])){ $_upd[] = sprintf('ecsnd_rply_eml=%s', GtSQLVlStr($p['rply_eml'], "text")); }
			if(!isN($p['rply_nm'])){ $_upd[] = sprintf('ecsnd_rply_nm=%s', GtSQLVlStr($p['rply_nm'], "text")); }

			if(!isN($p['html'])){ $_upd[] = sprintf('ecsnd_html=%s', GtSQLVlStr($p['html'], "text")); }

			if(!isN($p['rdy'])){ $_upd[] = sprintf('ecsnd_rdy=%s', GtSQLVlStr($p['rdy'], "int")); }



			if(count($_upd) > 0){

				try {

					$updateSQL = "UPDATE ".$this->bd.TB_MDL_EC_SND." SET ".implode(',', $_upd)." WHERE ecsnd_enc=".GtSQLVlStr( $p['enc'] , "text")." LIMIT 1";
					$ResultUPD = $__cnx->_prc($updateSQL);

					if($ResultUPD){

						$ecsnd = GtEcSndDt([ 'id'=>$p['enc'], 'tp'=>'enc', 'bd'=>$this->bd ]);

						//$html_all['d'] = $ecsnd;

						if(!isN($ecsnd->id) && !isN($p['html'])){
							$__uhtml = $this->_SndEcHtml([ 'id'=>$ecsnd->id, 'html'=>$p['html'], 'invk'=>'_SndEc_UPD' ]);
						}

						/*
						$html_all['u'] = $__uhtml;

						$usql = sprintf("	UPDATE ".$this->bd.TB_MDL_EC_SND."
											SET ecsnd_note=%s
											WHERE ecsnd_enc=".GtSQLVlStr( $p['enc'], "text")."
											LIMIT 1",
											GtSQLVlStr(print_r($html_all, true), "text")
										);

						$ResultUPD = $__cnx->_prc($usql);
						*/

					}else{

						$rsp['w'] = '$ResultUPD error:'.$__cnx->c_p->error;

					}

				} catch (Exception $e) {

					$rsp['w'] = $e->getMessage();

				}

				if($ResultUPD){
					$rsp['e'] = 'ok';
				}else{
					$rsp['w'] = 'Error:'.$__cnx->c_p->error;
					$rsp['e'] = 'no';
				}

			}else{

				$rsp['w'] = 'No $_upd fields count to update';

			}

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = 'no all data';

		}

		return _jEnc($rsp);
	}





	function _SndEcHtml($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$rsp['invk'] = $p['invk'];

		if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

		$__chk = $this->_SndEcHtml_Chk([ 'cmmt'=>$p['cmmt'], 'bd'=>$__bd, 'id'=>$p['id'] ]);

		$rsp['chk'] = $__chk;

		if($__chk->e == 'ok'){

			$_aws = new API_CRM_Aws();

			if(!isN($p['html'])){
				$_html = ctjTx( trim($p['html']), 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] );
			}

			if(!isN($_html) && !isN($p['id']) && strlen($_html) > 50){

				if(!isN($__chk->id)){

					echo $this->_auto->li('Lets update HTML');

					$_sql = sprintf("UPDATE ".$__bd.TB_EC_SND_HTML." SET ecsndhtml_s3=%s WHERE id_ecsndhtml=%s",
									   GtSQLVlStr( 1, "int"),
									   GtSQLVlStr( $__chk->id , "int"));

					$_enc_s3 = $__chk->enc;

				}else{

					echo $this->_auto->li('Lets insert HTML');

					$__enc = Enc_Rnd($p['id'].'-'.$_html);

					$_sql = sprintf("INSERT INTO ".$__bd.TB_EC_SND_HTML." (ecsndhtml_enc, ecsndhtml_ecsnd, ecsndhtml_s3) VALUES (%s, %s, %s)",
			              			GtSQLVlStr( $__enc , "text"),
			              			GtSQLVlStr( $p['id'] , "int"),
						  			GtSQLVlStr( 1, "int"));

					$_enc_s3 = $__enc;

				}

				echo $this->_auto->li('Execute:'.compress_code( $_sql ));


			}else{

				$rsp['w'][] = 'No html to save';

			}

			if(!isN( $p['html'] )){

				echo $this->_auto->li('Try save on s3');

				$_html_s3 = ctjTx($_html, 'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] );

				if(!isN( $_html_s3 )){

					$_sve = $_aws->_s3_put([
								'b'=>'fle',
								'fle'=>_TmpFixDir(DIR_FLE_EC_SND.$_enc_s3.'.html'),
								'cbdy'=>$_html_s3,
								'ctp'=>'text/html'
							]);

				}

			}

			if(!isN($_sql) && $_sve->e == 'ok'){

				$Result = $__cnx->_prc($_sql);

				if($Result){

					$rsp['e'] = 'ok';

				}else{

					echo $this->_auto->err('Try save on s3 error:'.$__cnx->c_p->error);
					$rsp['w'] = $__cnx->c_p->error;

				}

			}else{

				$rsp['w'][] = 'No query to execute';

			}


		}else{

			$rsp['w'] = 'Bad request on check '.print_r($__chk, true);

		}

		return _jEnc($rsp);

	}


	public function _SndEcHtml_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['id']) ){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			$query_DtRg = sprintf('	SELECT *
								   	FROM '.$__bd.TB_EC_SND_HTML.'
								   	WHERE ecsndhtml_ecsnd=%s
								   	LIMIT 1',
								   	GtSQLVlStr($p['id'], 'int')
								);

			if($p['cmmt'] == 'ok'){
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_ecsndhtml'];
					$Vl['enc'] = $row_DtRg['ecsndhtml_enc'];
				}

			}else{

				if($p['cmmt'] == 'ok'){
					$Vl['w'] = $__cnx->c_p->error;
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['m'] = 'No id';

		}

		return _jEnc($Vl);

	}





	public function _TrckSve($_p=NULL){

		global $__cnx;

		if(!isN($_p['lnk']) && !isN($_p['snd'])){

			$browser = new Browser();
			$_brws_p = $browser->getPlatform();
			$_brws_t = $browser->getBrowser();
			$_brws_v = $browser->getVersion();
			$_brws_d = LgnDsp();

			if(!isN($_p['bd'])){ $_bd=$_p['bd']; }
			elseif(!isN($this->bd)){ $_bd=$this->bd; }

			$insertSQL = sprintf("INSERT INTO "._BdStr($_bd).TB_EC_TRCK." (ectrck_lnk, ectrck_snd, ectrck_f, ectrck_h, ectrck_m, ectrck_brw_t, ectrck_brw_v, ectrck_brw_p) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
			               GtSQLVlStr($_p['lnk'], "int"),
						   GtSQLVlStr($_p['snd'], "text"),
						   GtSQLVlStr(SIS_F, "date"),
						   GtSQLVlStr(SIS_H2, "date"),
						   GtSQLVlStr($_brws_d, "int"),
						   GtSQLVlStr($_brws_t, "text"),
						   GtSQLVlStr($_brws_v, "text"),
						   GtSQLVlStr($_brws_p, "text"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}

		}

		return _jEnc($rsp);

	}


	public function _EcCmpg_UPD($p=NULL){

		global $__cnx;

		if(!isN($p['est']) && !isN($p['id'])){

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_est=%s WHERE id_eccmpg=%s",
							   GtSQLVlStr( $p['est'] , "int"),
							   GtSQLVlStr( $p['id'] , "int"));

			$ResultUPD = $__cnx->_prc($updateSQL);

			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_p->error;
			}

		}else{
			$rsp['e'] = 'no';
		}

		return _jEnc($rsp);
	}


	public function EcCmpgHtmlTot($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['cmpg'])){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			$query_DtRg = sprintf('	SELECT COUNT(*) AS _tot
									FROM '._BdStr($__bd).TB_EC_SND_CMPG.'
										  INNER JOIN '._BdStr($__bd).TB_EC_SND.' ON ecsndcmpg_snd = id_ecsnd
									WHERE 	ecsndcmpg_cmpg=%s AND
											(ecsnd_html=1 OR ecsnd_id IS NOT NULL) AND
											ecsnd_test=2',
									GtSQLVlStr($p['cmpg'], 'int')); //echo compress_code($query_DtRg);

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg==1){
					$_r['e']='ok';
					$_r['tot']=$row_DtRg['_tot'];
				}

			}else{

				$_r['w'] = $__cnx->c_p->error;

			}

		}else{

			$_r['w']='no data';

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}


	public function EcCmpgQueuTot($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['cmpg'])){

			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			$query_DtRg = sprintf('	SELECT COUNT(*) AS _tot
									FROM '._BdStr($__bd).TB_EC_SND_CMPG.'
										  INNER JOIN '._BdStr($__bd).TB_EC_SND.' ON ecsndcmpg_snd = id_ecsnd
									WHERE 	ecsndcmpg_cmpg=%s AND
											ecsnd_test=2',
									GtSQLVlStr($p['cmpg'], 'int')); //echo compress_code($query_DtRg);

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg==1){
					$_r['e']='ok';
					$_r['tot']=$row_DtRg['_tot'];
				}

			}else{

				$_r['w'] = $__cnx->c_p->error;

			}

		}else{

			$_r['w']='no data';

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	public function _EcCmpgUpd_Fld($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($p) && !isN($p['f']) && !isN($p['v']) && !isN($p['id'])){

			$Update = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET ".$p['f']."=%s WHERE id_eccmpg=%s",
	                   GtSQLVlStr($p['v'], "text"),
	                   GtSQLVlStr($p['id'], "int"));

			$Update = $__cnx->_prc($Update);

			if($Update){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);
	}



	public function _EcCmzUpd_Fld($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($p) && !isN($p['f']) && !isN($p['v']) && !isN($p['id'])){

			$Update = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET ".$p['f']."=%s WHERE id_eccmz=%s",
	                   GtSQLVlStr($p['v'], "text"),
	                   GtSQLVlStr($p['id'], "int"));

			$Result = $__cnx->_prc($Update);

			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error.' on '.compress_code( $Update );
			}
		}

		return _jEnc($rsp);
	}




	public function _EcHis(){

		global $__cnx;

		if(!isN($this->id_ec) && !isN($this->ec_cd) && !isN($this->ec_usedt)){

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_HIS." (echis_enc, echis_ec, echis_cd, echis_us) VALUES (%s, %s, %s, %s)",
						   GtSQLVlStr(enCad($this->id_ec.SIS_F_D), "text"),
						   GtSQLVlStr($this->id_ec, "int"),
						   GtSQLVlStr(ctjTx($this->ec_cd,'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"),
						   GtSQLVlStr($this->ec_usedt, "int"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
		 		$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			return _jEnc($rsp);
		}
	}


	public function _EcSve($p=NULL){

		global $__cnx;

		if(_ChckPml('ec', PmLn_Cl($this->ec_pml)) == true){
			$__pml = PmLn_Cl($this->ec_pml.'_'.SIS_F);
		}else{
			$__pml = PmLn_Cl($this->ec_pml);
		}

		$_shrt = new CRM_Shrt();
		$__shrt = $_shrt->get([ 'url'=> DMN_EC.$__pml ])->url;

		if(!isN($this->ec_sis)){ $_sis = Php_Ls_Cln($this->ec_sis); }else{ $_sis = 2; }

		if(!isN($this->ec_flj)){ $_flj = $this->ec_flj; }else{ $_flj = 2; }
		if(!isN($this->ec_cmz)){ $_cmz = $this->ec_cmz; }else{ $_cmz = 2; }
		if(!isN($this->ec_dir)){ $_dir = $this->ec_dir; }else{ $_dir = SIS_Y.'_'.strtolower(DMN_SB).'_'.Gn_Rnd(10); }
		if(!isN($this->ec_oth)){ $_oth = $this->ec_oth; }else{ if($_frm==_CId('ID_SISECFRM_CDG')){ $_oth = 1; }else{ $_oth = 2; } }
		if(!isN($this->ec_frm)){ $_frm = $this->ec_frm; }else{ $_frm = _CId('ID_SISECFRM_CDG'); }
		if(!isN($this->ec_pdf)){ $_pdf = $this->ec_pdf; }else{ $_pdf = 2; }
		if(!isN($this->ec_chk_hdr)){ $_chk_hdr = _NoNll(Html_chck_vl($this->ec_chk_hdr)); }else{ $_chk_hdr = 1; }
		if(!isN($this->ec_chk_ftr)){ $_chk_ftr = _NoNll(Html_chck_vl($this->ec_chk_ftr)); }else{ $_chk_ftr = 1; }
		if(!isN($this->ec_w)){ $_sze_w = $this->ec_w; }else{ $_sze_w = 0; }

		$__enc = Enc_Rnd($this->ec_dir.'-'.$this->ec_tt);

		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC." (ec_enc, ec_est, ec_cds, ec_tt, ec_sbt, ec_dsc, ec_cd, ec_fnd, ec_spn, ec_w, ec_fm, ec_pdf, ec_ord, ec_pay, ec_nmr, ec_frw, ec_key, ec_em, ec_lnk, ec_lnk_nxt, ec_sbj, ec_prhdr, ec_pml, ec_shr, ec_sis, ec_us, ec_act_frm, ec_fi, ec_fa, ec_flj, ec_cmz, ec_cmzrlc, ec_oth, ec_frm, ec_cl, ec_dir, ec_dmo, ec_chk_hdr, ec_chk_ftr) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s)",
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr($this->ec_est, "int"),
					   GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_cds)), "int"),
					   GtSQLVlStr(ctjTx($this->ec_tt,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_sbt,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_dsc,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_cd, 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					   GtSQLVlStr(ctjTx($this->ec_fnd,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_spn,'out'), "text"),
					   GtSQLVlStr($_sze_w, "int"),
					   GtSQLVlStr(ctjMlt($this->ec_fm), "text"),
					   GtSQLVlStr($_pdf, "int"),
					   GtSQLVlStr(ctjTx($this->ec_ord,'out'), "text"),
					   GtSQLVlStr($this->ec_pay, "int"),
					   GtSQLVlStr(ctjTx($this->ec_nmr,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_frw,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_key,'out'), "text"),
					   GtSQLVlStr($this->ec_em, "text"),
					   GtSQLVlStr($this->ec_lnk, "text"),
					   GtSQLVlStr($this->ec_lnk_nxt, "text"),
					   GtSQLVlStr(ctjTx($this->ec_sbj,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->ec_prhdr,'out'), "text"),
					   GtSQLVlStr($__pml, "text"),
					   GtSQLVlStr($__shrt, "text"),
					   GtSQLVlStr($_sis, "int"),
					   GtSQLVlStr($this->ec_us, "int"),
					   GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_act_frm)), "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($_flj, "text"),
					   GtSQLVlStr($_cmz, "text"),
					   GtSQLVlStr($this->ec_cmzrlc, "text"),
					   GtSQLVlStr(_NoNll(Html_chck_vl($_oth)), "int"),
					   GtSQLVlStr($_frm, "int"),
					   GtSQLVlStr($this->ec_cl, "text"),
					   GtSQLVlStr($_dir, "text"),
					   GtSQLVlStr($this->ec_dmo, "text"),
					   GtSQLVlStr($_chk_hdr, "int"),
					   GtSQLVlStr($_chk_ftr, "int"));


		$Result = $__cnx->_prc($insertSQL);

 		if($Result){

	 		$rsp['i'] = $__enc;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

			$this->id_ec = $rsp['i'];

			$rsp['his'] = $this->_EcHis();

			$rsp['a'] = Aud_Sis(Aud_Dsc(49, $this->ec_tt, $__cnx->c_p->insert_id), $rsp['v']);

			$Update_IMG = sprintf("UPDATE "._BdStr(DBM).TB_EC." SET ec_img=%s WHERE ec_enc = %s",
                       GtSQLVlStr('ec_'.$rsp['i'].'.jpg', "text"),
                       GtSQLVlStr($rsp['i'], "text"));

			$Update_IMG = $__cnx->_prc($Update_IMG);


			if(!isN($this->ec_tp)){
				$insertSQL_RLC = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_TP." (ecmdlstp_mdlstp, ecmdlstp_ec) VALUES (%s, (SELECT id_ec FROM ec WHERE ec_enc = %s))",
	                       GtSQLVlStr($this->ec_tp, "int"),
	                       GtSQLVlStr($rsp['i'], "text"));
				$Result_RLC = $__cnx->_prc($insertSQL_RLC); $rsp['w'] = $__cnx->c_p->error;
			}


			if(!isN($this->ec_cmzest)){
				$Update_RLC = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_est=%s WHERE id_eccmz=%s",
	                       GtSQLVlStr($this->ec_cmzest, "int"),
	                       GtSQLVlStr($this->ec_cmzrlc, "int"));
				$Update_RLC = $__cnx->_prc($Update_RLC);
			}


			$this->id = $__enc;
			$this->id_t = 'enc';
			$this->frm = 'Ml';
			$this->html = 'ok';
			$this->btrck = 'ok';
			$this->crplc = 'no';
			$this->no_act_dspl = 'ok';

			$__cod_trck = $this->_bld([ 'norplc'=>$p['norplc'] ]);

			$__upd_trck = $this->_EcUpd_Fld([
									'id'=>$__enc,
									't'=>'enc',
									'f'=>'ec_cd_trck',
									'v'=>trim(ctjTx($__cod_trck, 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ))
								]);

			if($__upd_trck->e != 'ok'){
				$rsp['e'] = 'no';
			}

		}else{

			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);

		}

		return _jEnc($rsp);

	}


	public function _EcUpd_Fld($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if($p['t'] == 'enc'){ $__f = 'ec_enc'; $__ft = 'text'; }else{ $__f = 'id_ec'; $__ft = 'int'; }

		if(!isN($p) && !isN($p['f']) && !isN($p['v']) && !isN($p['id'])){

			$Update = sprintf("UPDATE "._BdStr(DBM).TB_EC." SET ".$p['f']."=%s WHERE {$__f}=%s",
	                   GtSQLVlStr($p['v'], "text"),
	                   GtSQLVlStr($p['id'], $__ft));

			$Update = $__cnx->_prc($Update);

			if($Update){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);
	}





	public function _EcUpd(){

		global $__cnx;

		$_shrt = new CRM_Shrt();

		if(PmLn_Cl($this->ec_pml) != PmLn_Cl($this->ec_pml_upd) ){
			if(_ChckPml('ec', PmLn_Cl($this->ec_pml)) == true){ $__pml = PmLn_Cl($this->ec_pml.'_'.SIS_F); }else{ $__pml = PmLn_Cl($this->ec_pml
			); }
		}else{
			$__pml = PmLn_Cl($this->ec_pml);
		}

		$__dt = GtEcDt($this->ec_enc, 'enc');

		if($__dt->lnk != $this->ec_lnk || ($__dt->shr == NULL) || ($__dt->shr == '') || empty($__dt->shr)){
			$__shrt = $_shrt->get([ 'url'=> DMN_EC.$__pml ])->url;
		}else{
			$__shrt = $__dt->shr;
		}


		if($__dt->lnk != $this->ec_lnk || ($__dt->shr == NULL) || ($__dt->shr == '') || empty($__dt->shr)){
			$__shrt = $_shrt->get([ 'url'=> DMN_EC.$__pml ])->url;
		}else{
			$__shrt = $__dt->shr;
		}

		if(!isN($__dt->sis)){ $_sis = Php_Ls_Cln($__dt->sis); }else{ $_sis = 2; }


		if(!isN($this->ec_frm)){ $_frm = Php_Ls_Cln($this->ec_frm); }elseif(!isN($__dt->frm)){ $_frm = Php_Ls_Cln($__dt->frm); }else{ $_frm = _CId('ID_SISECFRM_CDG'); }

		if(!isN($__dt->dir)){ $_dir = Php_Ls_Cln($__dt->dir); }else{ $_dir = SIS_Y.'_'.strtolower(DMN_SB).'_'.Gn_Rnd(10); }
		if(!isN($__dt->pml) != $__dt->pml){ $__pml = Php_Ls_Cln($this->ec_pml); }else{ $__pml = $__dt->pml; }


		if(!isN($this->ec_enc)){

			$rsp['tmp']['ec_est'] = $this->ec_est;

			if(!isN( $this->ec_tt )){ $_upd[] = sprintf( 'ec_tt=%s', GtSQLVlStr(ctjTx($this->ec_tt,'out'), "text") ); }
			if(!isN( $this->ec_sbt )){ $_upd[] = sprintf( 'ec_sbt=%s', GtSQLVlStr(ctjTx($this->ec_sbt,'out'), "text") ); }
			if(!isN( $this->ec_est )){ $_upd[] = sprintf( 'ec_est=%s', GtSQLVlStr($this->ec_est, "int") ); }
			if(!isN( $this->ec_cds )){ $_upd[] = sprintf( 'ec_cds=%s', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_cds)), "int") ); }
			if(!isN( $this->ec_oth )){ $_upd[] = sprintf( 'ec_oth=%s', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_oth)), "int") ); }
			if(!isN( $this->ec_dsc )){ $_upd[] = sprintf( 'ec_dsc=%s', GtSQLVlStr(ctjTx($this->ec_dsc,'out'), "text") ); }
			if(!isN( $this->ec_cd )){ $_upd[] = sprintf( 'ec_cd=%s', GtSQLVlStr(ctjTx($this->ec_cd, 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text") ); }
			if(!isN( $_dir )){ $_upd[] = sprintf( 'ec_dir=%s', GtSQLVlStr(ctjTx($_dir,'out'), "text") ); }
			if(!isN( $this->ec_dmo )){ $_upd[] = sprintf( 'ec_dmo=%s', GtSQLVlStr(ctjTx($this->ec_dmo,'out'), "text") ); }
			if(!isN( $this->ec_fnd )){ $_upd[] = sprintf( 'ec_fnd=%s', GtSQLVlStr(ctjTx($this->ec_fnd,'out'), "text") ); }
			if(!isN( $this->ec_spn )){ $_upd[] = sprintf( 'ec_spn=%s', GtSQLVlStr(ctjTx($this->ec_spn,'out'), "text") ); }
			if(!isN( $this->ec_w )){ $_upd[] = sprintf( 'ec_w=%s', GtSQLVlStr($this->ec_w, "int") ); }
			if(!isN( $this->ec_fm )){ $_upd[] = sprintf( 'ec_fm=%s', GtSQLVlStr(ctjMlt($this->ec_fm), "text") ); }
			if(!isN( $this->ec_pdf )){ $_upd[] = sprintf( 'ec_pdf=%s', GtSQLVlStr($this->ec_pdf, "int") ); }
			if(!isN( $this->ec_ord )){ $_upd[] = sprintf( 'ec_ord=%s', GtSQLVlStr(ctjTx($this->ec_ord,'out'), "text") ); }
			if(!isN( $this->ec_pay )){ $_upd[] = sprintf( 'ec_pay=%s', GtSQLVlStr($this->ec_pay, "int") ); }
			if(!isN( $this->ec_nmr )){ $_upd[] = sprintf( 'ec_nmr=%s', GtSQLVlStr(ctjTx($this->ec_nmr,'out'), "text") ); }
			if(!isN( $this->ec_frw )){ $_upd[] = sprintf( 'ec_frw=%s', GtSQLVlStr(ctjTx($this->ec_frw,'out'), "text") ); }
			if(!isN( $this->ec_key )){ $_upd[] = sprintf( 'ec_key=%s', GtSQLVlStr(ctjTx($this->ec_key,'out'), "text") ); }
			if(!isN( $_frm )){ $_upd[] = sprintf( 'ec_frm=%s', GtSQLVlStr($_frm, "int")  ); }
			if(!isN( $this->ec_em )){ $_upd[] = sprintf( 'ec_em=%s', GtSQLVlStr(ctjTx($this->ec_em,'out'), "text") ); }
			if(!isN( $this->ec_lnk )){ $_upd[] = sprintf( 'ec_lnk=%s', GtSQLVlStr(ctjTx($this->ec_lnk,'out'), "text")  ); }
			if(!isN( $this->ec_lnk_nxt )){ $_upd[] = sprintf( 'ec_lnk_nxt=%s', GtSQLVlStr(ctjTx($this->ec_lnk_nxt,'out'), "text")  ); }
			if(!isN( $this->ec_sbj )){ $_upd[] = sprintf( 'ec_sbj=%s', GtSQLVlStr(ctjTx($this->ec_sbj,'out'), "text")  ); }
			if(!isN( $this->ec_prhdr )){ $_upd[] = sprintf( 'ec_prhdr=%s', GtSQLVlStr(ctjTx($this->ec_prhdr,'out'), "text")  ); }
			if(!isN( $__pml )){ $_upd[] = sprintf( 'ec_pml=%s', GtSQLVlStr($__pml, "text") ); }
			if(!isN( $__shrt )){ $_upd[] = sprintf( 'ec_shr=%s', GtSQLVlStr($__shrt, "text") ); }
			if(!isN( $_sis )){ $_upd[] = sprintf( 'ec_sis=%s', GtSQLVlStr($_sis, "int") ); }
			if(!isN( $this->ec_us )){ $_upd[] = sprintf( 'ec_us=%s', GtSQLVlStr($this->ec_us, "int") ); }
			if(!isN( $this->ec_act_frm )){ $_upd[] = sprintf( 'ec_act_frm=%s', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_act_frm)), "int") ); }
			if(!isN( SIS_F )){ $_upd[] = sprintf( 'ec_fa=%s', GtSQLVlStr(SIS_F, "date") ); }
			if(!isN( $this->ec_cmz )){ $_upd[] = sprintf( 'ec_cmz=%s', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_cmz)), "int") ); }
			if(!isN( $this->ec_flj )){ $_upd[] = sprintf( 'ec_flj=%s ', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_flj)), "int") ); }
			if(!isN( $this->ec_pst_fb )){ $_upd[] = sprintf( 'ec_pst_fb=%s ', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_pst_fb)), "int") ); }

			if(!isN( $this->ec_chk_hdr )){ $_upd[] = sprintf( 'ec_chk_hdr=%s ', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_chk_hdr)), "int") ); }
			if(!isN( $this->ec_chk_ftr )){ $_upd[] = sprintf( 'ec_chk_ftr=%s ', GtSQLVlStr(_NoNll(Html_chck_vl($this->ec_chk_ftr)), "int") ); }

			$updateSQL = "UPDATE "._BdStr(DBM).TB_EC." SET ".implode(',', $_upd)." WHERE ec_enc='".$this->ec_enc."' ";

			$rsp['sql'] = $updateSQL;

			$Result = $__cnx->_prc($updateSQL);

		}


		if($Result){

			//echo $updateSQL;

			$rsp['his'] = $this->_EcHis();
			/*
			if($this->ec_est == _CId('ID_SISEST_PAPRB')){
				$updateSQL_All = sprintf("UPDATE "._BdStr(DBM).MDL_EC_ITM_BD." SET orditm_est=%s, orditm_fa=%s WHERE orditm_ec=%s",
						   GtSQLVlStr($this->ec_est, "int"),
						   GtSQLVlStr(SIS_F, "date"),
						   GtSQLVlStr($this->id_ec, "int"));
				$Result_All = $__cnx->_prc($updateSQL_All);
			}*/

			if($this->ec_cmzest != NULL){
				$Update_RLC = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_est=%s WHERE id_eccmz=%s",
	                       GtSQLVlStr($this->ec_cmzest, "int"),
	                       GtSQLVlStr($this->ec_cmzrlc, "int"));
				$Update_RLC = $__cnx->_prc($Update_RLC);
			}

			$rsp['i'] = $this->ec_enc;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

			$this->id = $this->ec_enc;
			$this->id_t = 'enc';
			$this->frm = 'Ml';
			$this->html = 'ok';
			$this->btrck = 'ok';
			$this->crplc = 'no';
			$this->no_act_dspl = 'ok';
			$this->if_clr = 'ok';
			$__cod_trck = $this->_bld();

			$rsp['tmp_cd_trck'] = $__cod_trck;

			$__upd_trck = $rsp['upd_cd_trck'] = $this->_EcUpd_Fld([
																'id'=>$this->ec_enc,
																't'=>'enc',
																'f'=>'ec_cd_trck',
																'v'=>trim(ctjTx($__cod_trck, 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ))
														]);

			if($__upd_trck->e != 'ok'){
				$rsp['e'] = 'no';
			}



		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			//$rsp['w_update'] = $__cnx->c_r->error.$updateSQL;
		}

		return _jEnc($rsp);
	}



	public function _EcCmzSgmHis(){

		global $__cnx;

		if(!isN($this->id_eccmzsgm) && !isN($this->eccmzsgm_vle)){

			$__enc = Enc_Rnd($this->id_eccmzsgm.'-'.$this->eccmzsgm_vle.'-'.SISUS_ID);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_SGM_HIS." (eccmzsgmhis_enc, eccmzsgmhis_eccmzsgm, eccmzsgmhis_vle, eccmzsgmhis_us) VALUES (%s, %s, %s, %s)",
						   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr($this->id_eccmzsgm, "int"),
						   GtSQLVlStr(ctjTx( $this->eccmzsgm_vle ,'out','',['html'=>'ok','schr'=>'no','nl2'=>'no']), "text"),
						   GtSQLVlStr(SISUS_ID, "int"));
			$Result = $__cnx->_prc($insertSQL);

			if($Result){
		 		$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			return _jEnc($rsp);
		}
	}




	public function EcLstsPlcyChk($p=NULL){

	    global $__cnx;

	    $_r['e']='no';

		if(!isN($p['eclsts']) && !isN($p['plcy'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_EC_LSTS_PLCY.'
									WHERE eclstsplcy_plcy=%s AND eclstsplcy_eclsts=%s',
											GtSQLVlStr($p['plcy'], 'int'),
											GtSQLVlStr($p['eclsts'], 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['tot']=$Tot_DtRg;

				if($Tot_DtRg==1){
					$_r['e']='ok';
					$_r['id']=$row_DtRg['id_eclstsplcy'];
					$_r['enc']=$row_DtRg['eclstsplcy_enc'];
				}

			}else{

				$_r['w'] = $__cnx->c_p->error;

			}

		}else{

			$_r['w']='no data';

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}




    public function InEcLsts_Plcy($p=NULL){

	    global $__cnx;
	    //$_r['p'] = $p;

        if( !isN($this->plcy_id) && !isN($p['eclsts']) ){

            if(!isN($this->cnteml_sndi)){ $__qry_e= $this->cnteml_sndi; }else{ $__qry_e = 1; }

            $__enc = Enc_Rnd($this->plcy_id.'-'.$p['eclsts']);

            $insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_PLCY." (eclstsplcy_enc, eclstsplcy_plcy, eclstsplcy_eclsts, eclstsplcy_e) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->plcy_id, "int"),
                       GtSQLVlStr($p['eclsts'], "int"),
                       GtSQLVlStr($__qry_e, "int"));

            if(!isN($insertSQL)){
	            $_ntry = 0;
				do{ $Result = $__cnx->_prc($insertSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
	        }

            if($Result){
                $_r['e'] = 'ok';
                $_r['enc'] = $__enc;
            }else{
	            $_r['w'] = $__cnx->c_p->error;
            }

        }else{

	        $_r['data'] = 'no';

        }

        return _jEnc($_r);
    }



	public function UpdEcLsts_Plcy($_p=NULL){

	    global $__cnx;

	    $_r['e'] = 'no';

        if(!isN($_p['id'])){

           	if(!isN($_p['e'])){ $_upd[] = sprintf('eclstsplcy_e=%s', GtSQLVlStr($_p['e'], "int")); }

           	if(count($_upd) > 0){

	            $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS_PLCY." SET ".implode(',', $_upd)." WHERE id_eclstsplcy=%s",
				                               GtSQLVlStr($_p['id'], "int"));

	            if(!isN($updateSQL)){
		            $_ntry = 0;
					do{ $Result = $__cnx->_prc($updateSQL); $_ntry++; if($Result){ break; } } while($_ntry == $this->n_try);
		        }

				if($Result){

		            $_r['e'] = 'ok';

		        }else{

		            $this->w_all .= $_r['w'] = $__cnx->c_p->error;

		        }

            }

        }

        return _jEnc($_r);

    }



	public function _ctj($p=NULL){


		//--------------- Modifica Etiquetas Base - Tags a Buscar ---------------//

			$_s[0] = '[NOMBRE]';
			$_s[1] = '[APELLIDO]';
			$_s[2] = '[LEAD_ENC]';
			$_s[3] = '[VTEX_INS_NOMBRE]';
			$_s[4] = '[VTEX_INS_APELLIDO]';
			$_s[5] = '[VTEX_RFD_NOMBRE]';
			$_s[6] = '[VTEX_RFD_APELLIDO]';

		//--------------- Modifica Etiquetas Base - Tags a Reemplazar ---------------//

			$_c[0] = $this->ctj->cnt_nm;
			$_c[1] = $this->ctj->cnt_ap;
			$_c[2] = $this->ctj->cnt_enc;
			$_c[3] = !isN($this->d_mainr->vtex->ins->cnt->nm)?$this->d_mainr->vtex->ins->cnt->nm:$this->d_mainr->vtex->ins_rfd->ins->cnt->nm;
			$_c[4] = !isN($this->d_mainr->vtex->ins->cnt->ap)?$this->d_mainr->vtex->ins->cnt->ap:$this->d_mainr->vtex->ins_rfd->ins->cnt->ap;
			$_c[5] = $this->d_mainr->vtex->ins_rfd->cnt->nm;
			$_c[6] = $this->d_mainr->vtex->ins_rfd->cnt->ap;

		//--------------- Setea la variable r con el codigo ---------------//

			$new__cod = str_replace($_s,$_c,$p['v']);

		//--------------- Seteo el codigo final ---------------//

			return $new__cod;

	}


	public function _Fle($p=NULL){

		//--------------- Modifica Textos ---------------//

		if(!isN($this->d_mdl->ec_fle)){
			foreach($this->d_mdl->ec_fle as $_k=>$_v){
				$this->fle->{ 'f_'.$_v->id } = $_v;

			}
		}

	}


	public function isAwsT(){ // Is Aws Template
		if($this->aws=='ok' && Dvlpr()){ return true; }else{ return false; }
	}

}

?>