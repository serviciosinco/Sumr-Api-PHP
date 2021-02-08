<?php

class API_CRM_ec_Cmz extends API_CRM_ec{

	public function __construct($p=NULL){
		parent::__construct();
		$this->__crt_all = GtSisEcCrt_Ls();
		$this->_rnd = Gn_Rnd(10);
    }

	function __destruct() {
		parent::__destruct();
   	}

	function gtec_info($p=NULL){
		$this->__dteccmz = GtEcCmzDt([ 'cmz'=>$this->ec_cmz ]);
		$this->__dtec = GtEcDt($this->__dteccmz->ec, 'id');
		$this->__dtcl = __Cl([ 'id'=>$this->__dteccmz->cl ]);
		$this->__pfx = $this->gt_mdlstp([ 'id'=>$this->__dtec->id ]);
		$this->__beccmz = ChkEcCmzEc([  'eccmz'=>$this->__dteccmz->id, 'd'=>[ 'ec'=>'ok' ] ]);

	}

	function _bld_ec($p=NULL){

		$this->gtec_info();

		$_r['ginfo']['eccmz'] = $this->__dteccmz;
		$_r['ginfo']['ec'] = $this->__dtec;
		$_r['ginfo']['cl'] = $this->__dtcl;
		$_r['ginfo']['pfx'] = $this->__pfx;
		$_r['ginfo']['beccmz'] = $this->__beccmz;

		if(!isN($this->__dtec->id)){

			echo $this->_auto->h2('__Cl execute');

			if($this->g__fst != 'ok'){
				$this->_EcUpd_Fld([ 'id'=>$this->__dtec->id, 'f'=>'ec_upd_img', 'v'=>1 ]);
			}

			$_cdg_f = $this->__dtec->cod;

			if(!isN($_cdg_f)){

				if(strpos($_cdg_f, '<html ') !== false){ $tags_html = 'ok'; }
				if(strpos($_cdg_f, '<head ')){ $tags_head = 'ok'; }
				if(strpos($_cdg_f, '<body ')){ $tags_body = 'ok'; }

				if($tags_html=='ok' || $tags_head=='ok'){
					$this->ec_ahtml = 'ok'; // Has all estructure complete
				}

			}

			$__hdr_tp = $this->__dteccmz->rlc->hdr;

			if(!isN( $this->__dteccmz->are )){
				$__hdr = $this->__dteccmz->are;
			}

			$_sgm_dt = GtEcCmzSgmDt([ 'cmz'=>$this->__dteccmz->id ]);


			$_r['ginfo_tmp']['crtall'] = $this->__crt_all;

			foreach($this->__crt_all as $_crt_k=>$_crt_v){

				$_id_div = $_crt_v->id;
				$_dv_k = "_dv_k".$_id_div;

				$Chk_sgm = ChkEcEdtSgm([ 'bd'=>$this->__dtcl->bd, 'sgm'=>$_id_div, 'eccmz'=>$this->__dteccmz->id ]);
				$chr_e = GtEcCmzSgmChrLs([ 'sgm'=>$Chk_sgm->id ]);

				$_ch_f = '';

				if(!isN($chr_e)){
					foreach($chr_e as &$__chr){
						if($__chr->vle != ''){
							$_ch_f .= $__chr->css.' '.$__chr->vle.$__chr->end.';';
						}
					}
				}

				$_cdg_f = str_replace($_crt_v->key, '<span style="'.$_ch_f.'">'.$_sgm_dt->{$_id_div}->vle.'</span>', $_cdg_f);

				preg_match_all('/\[H.*?\]/', $_cdg_f, $_hdrs);

				foreach($_hdrs[0] as &$Key_hdrs){

					$__im_w = EcCmzImgTag($Key_hdrs, 'w');
					$__im_h = EcCmzImgTag($Key_hdrs, 'h');
					$_id_div_img = $__im_id->v;

					if(!isN($Key_hdrs)){

						if($__hdr_tp == 1){

							$_dt_are = GtClAreDt([ 'id'=>$__hdr ]);
							$_hdr_nw = '<img style="" align="left" src="'.$_dt_are->img->hdr->big.'?_rdm='.Gn_Rnd(10).'" '.$__im_w->t.' '.$__im_h->t.'>';

						}else{

							$_chk_hdr = ChkEcCmzHdr([ 'eccmz'=>$this->__dteccmz->id ]);

							if($_chk_hdr->r == 'ok'){

								if($_chk_hdr->img != ''){
									$_hdr_cd = '<img style="max-width:600px;" width="600" align="left" src="'.DMN_FLE_EC_CMZ.$_chk_hdr->img.'?_rdm='.Gn_Rnd(10).'">';
								}else{
									$_hdr_cd = '';
								}

								$_cdg_f = str_replace($Key_hdrs, $_hdr_cd, $_cdg_f);

							}

						}

						$_cdg_f = str_replace($Key_hdrs, $_hdr_nw, $_cdg_f);
						$_cdg_f = str_replace('[ARE_CLR]',$_dt_are->clr, $_cdg_f);

					}

				}

				//--------- Buscando imagenes para reemplazar ---------//

				preg_match_all('/\[I.*?\]/', $_cdg_f, $_img);

				foreach($_img[0] as &$Key_img){

					$__im_w = EcCmzImgTag($Key_img, 'w');
					$__im_id = EcCmzImgTag($Key_img, 'id');

					$_id_div_img = $__im_id->v;
					$_chk_img = ChkEcCmzImg([ 'eccmz'=>$this->__dteccmz->id, 'img'=>$_id_div_img ]);

					$Chk_img = ChkEcCmzImg([ 'img'=>$_id_div_img, 'eccmz'=>$this->__dteccmz->id ]);
					$chr_e_img = GtEcCmzImgChrLs([ 'img'=>$Chk_img->id ]);

					$_ch_f_i = '';

					if(!isN($chr_e_img)){
						foreach($chr_e_img as &$__chr_i){
							if(!isN($__chr_i->vle)){
								$_ch_f_i .= $__chr_i->css.' '.$__chr_i->vle.$__chr_i->end.';';
							}
						}
					}

					if($_chk_img->img->c != ''){
						$_img_cd = '<img style="'.$_ch_f_i.'" src="'.DMN_FLE_EC_CMZ.$_chk_img->img->c.'?_rdm='.Gn_Rnd(10).'" '.$__im_w->t.'>';
					}else{
						$_img_cd = '';
					}

					$_cdg_f = str_replace($Key_img, $_img_cd, $_cdg_f);

				}

				if(!isN($_crt_v->keyi)){
					$_r['tmpsgm'][ $_crt_v->keyi ] = [
						'crtv_id'=>$_crt_v->id,
						'id_div'=>$_id_div,
						'sgmdti_iddiv'=>$_sgm_dt->{$_id_div}
					];
				}

				if(!isN( $_sgm_dt->{$_id_div} )){
					if($_sgm_dt->{$_id_div}->hb == 'no'){
						$_cdg_f = str_replace([ '{IFS'.$_crt_v->keyi.'}', '{/IFS'.$_crt_v->keyi.'}' ], ['<!--','-->'], $_cdg_f);
					}else{
						$_cdg_f = str_replace([ '{IFS'.$_crt_v->keyi.'}', '{/IFS'.$_crt_v->keyi.'}' ], ['',''], $_cdg_f);
					}
				}else{
					$_cdg_f = str_replace([ '{IFS'.$_crt_v->keyi.'}', '{/IFS'.$_crt_v->keyi.'}' ], ['',''], $_cdg_f);
				}
			}

			echo $this->_auto->li('ChkEcCmzEc execute');

			$this->__beccmz = ChkEcCmzEc([  'eccmz'=>$this->__dteccmz->id, 'd'=>[ 'ec'=>'ok' ] ]);

			echo $this->_auto->li('ID for detail:'.$this->__dteccmz->id);

			$_usdt = GtUsDt($this->g__us, 'enc', [ 'cl_no'=>'ok' ]);

			//$_r['tmp_beccmz_d_1'] = $this->__beccmz;

			if(($this->__beccmz->cmzrlc != $this->__dteccmz->id)){

				$_ec_snd = new API_CRM_ec();

				$_ec_snd->ec_cl = $this->__dtcl->enc;
				$_ec_snd->ec_est = _CId('ID_SISEST_PRC');
				$_ec_snd->ec_cds = $this->__dtec->cds;
				$_ec_snd->ec_tt = $this->__dteccmz->nm;
				$_ec_snd->ec_sbt = $this->__dtec->sbt;
				$_ec_snd->ec_dsc = $this->__dtec->dsc;
				$_ec_snd->ec_cd = $_cdg_f;
				$_ec_snd->ec_fnd = $this->__dtec->fnd;
				$_ec_snd->ec_spn = $this->__dtec->spn;
				$_ec_snd->ec_w = $this->__dtec->w;
				$_ec_snd->ec_fm = $this->__dtec->fm;
				$_ec_snd->ec_pdf = $this->__dtec->pdf;
				$_ec_snd->ec_ord = $this->__dtec->ord;
				$_ec_snd->ec_pay = $this->__dtec->pay;
				$_ec_snd->ec_nmr = $this->__dtec->nmr;
				$_ec_snd->ec_frm = _CId('ID_SISECFRM_CDG');
				$_ec_snd->ec_frw = $this->__dtec->frw;
				$_ec_snd->ec_em = $this->__dtec->eml;
				$_ec_snd->ec_lnk = $this->__dtec->lnk;
				$_ec_snd->ec_lnk_nxt = $this->__dtec->lnk_nxt;
				$_ec_snd->ec_sbj = $this->__dtec->sbj;
				$_ec_snd->ec_pml = $this->__dtec->pml.'-'.Gn_Rnd(3);
				$_ec_snd->ec_sis = $this->__dtec->sis;
				$_ec_snd->ec_us = $this->__dteccmz->us->id;
				$_ec_snd->ec_act_frm = $this->__dtec->act_frm;
				$_ec_snd->ec_tp = $this->__pfx->id;
				$_ec_snd->ec_cmz = 2;
				$_ec_snd->ec_cmzrlc = $this->__dteccmz->id;
				$_ec_snd->ec_cmzest = 2;
				$_ec_snd->ec_usedt = $_usdt->id;
				$_ec_snd->ec_ahtml = $this->ec_ahtml;
				$Result = $_ec_snd->_EcSve();

				//print_r($Result);

				echo $this->_auto->h2('_bld execute');

				if($Result->e == 'ok'){

					$_r['e'] = 'ok';

					if(
						$this->__beccmz->d->est->id == ID_SISEST_PAPRB ||
						$this->__beccmz->d->est->id == ID_SISEST_APRB ||
						$this->__beccmz->d->est->id == ID_SISEST_OK
					){

						$__upd_rbld = $this->_EcCmzUpd_Fld([ 'id'=>$this->__dteccmz->id, 'f'=>'eccmz_rbld', 'v'=>2 ]);

						if($__upd_rbld->e == 'ok'){

							$__upd_est = $this->_EcCmzUpd_Fld([ 'id'=>$this->__dteccmz->id, 'f'=>'eccmz_est', 'v'=>2 ]);

							if($__upd_est->e == 'ok'){

								echo $this->_auto->scss('Updated Rebuild and Status Field OK');

							}

						}

						if($p['cche']=='ok'){

							//$__aws_cache = $this->_auto->_aws->_cfr_clr([ 'b'=>'frnt', 'fle'=>'html/'.$Result->i, 'all'=>'ok' ]);

							$_r['cfr'] = $__aws_cache;

							if($__aws_cache->e != 'ok'){
								echo $this->_auto->err('Aws Cache Error:'.print_r($__aws_cache, true) );
							}
						}

					}else{

						$_r['cfr'] = 'No status for cloudflare invalidation';

					}

				}

				echo $this->_auto->h2('Build on IF');

			}else{

				//$_r['tmp_beccmz_d_2'] = $this->__beccmz;

				if(!isN($this->__beccmz->d->id)){

					$_ec_snd = new API_CRM_ec();

					$_ec_snd->id_ec = $this->__beccmz->d->id;
					$_ec_snd->ec_enc = $this->__beccmz->d->enc;
					$_ec_snd->ec_cl = $this->__dtcl->enc;

					if( !isN($this->__beccmz->d->est->id) ){
						$_ec_snd->ec_est = $this->__beccmz->d->est->id;
					}else{
						$_ec_snd->ec_est = _CId('ID_SISEST_PRC');
					}

					$_ec_snd->ec_cds = $this->__dtec->cds;
					$_ec_snd->ec_tt = $this->__dteccmz->nm;
					$_ec_snd->ec_sbt = $this->__dtec->sbt;
					$_ec_snd->ec_dsc = $this->__dtec->dsc;
					$_ec_snd->ec_cd = $_cdg_f;
					$_ec_snd->ec_fnd = $this->__dtec->fnd;
					$_ec_snd->ec_dir = $this->__beccmz->dir;
					$_ec_snd->ec_spn = $this->__dtec->spn;
					$_ec_snd->ec_w = $this->__dtec->w;
					$_ec_snd->ec_fm = $this->__dtec->fm;
					$_ec_snd->ec_pdf = $this->__dtec->pdf;
					$_ec_snd->ec_ord = $this->__dtec->ord;
					$_ec_snd->ec_pay = $this->__dtec->pay;
					$_ec_snd->ec_nmr = $this->__dtec->nmr;
					$_ec_snd->ec_frw = $this->__dtec->frw;
					$_ec_snd->ec_em = $this->__dtec->eml;
					$_ec_snd->ec_lnk = $this->__dtec->lnk;
					$_ec_snd->ec_lnk_nxt = $this->__dtec->lnk_nxt;
					$_ec_snd->ec_sbj = $this->__dtec->sbj;

					$_ec_snd->ec_frm = _CId('ID_SISECFRM_CDG');
					$_ec_snd->ec_pml = $this->__dtec->pml.'-'.Gn_Rnd(3);

					$_ec_snd->ec_sis = $this->__dtec->sis;
					$_ec_snd->ec_us = $this->__dteccmz->us->id;
					$_ec_snd->ec_act_frm = $this->__dtec->act_frm;
					$_ec_snd->ec_tp = $this->__pfx->id;

					$_ec_snd->ec_cmz = 2;
					$_ec_snd->ec_cmzrlc = $this->__dteccmz->id;
					$_ec_snd->ec_ahtml = $this->ec_ahtml;

					$_ec_snd->ec_cmzest = 2;
					$_ec_snd->ec_usedt = $_usdt->id;

					$Result = $_ec_snd->_EcUpd();

					//$_r['tmp_EcUpd'] = $Result;

					//echo $_cdg_f;
					echo $this->_auto->li('Update Trck');

					echo $this->_auto->li('$Result:'.print_r($Result->e, true));


					//$_r['tmp_beccmz_d'] = $this->__beccmz->d;


					if($Result->e == 'ok'){

						if(
							$this->__beccmz->d->est->id == ID_SISEST_PAPRB ||
							$this->__beccmz->d->est->id == ID_SISEST_APRB ||
							$this->__beccmz->d->est->id == ID_SISEST_OK ||
							$this->__dteccmz->rbld == 'ok'
						){


							$__upd_rbld = $this->_EcCmzUpd_Fld([ 'id'=>$this->__dteccmz->id, 'f'=>'eccmz_rbld', 'v'=>2 ]);

							if($__upd_rbld->e == 'ok'){

								$__upd_est = $this->_EcCmzUpd_Fld([ 'id'=>$this->__dteccmz->id, 'f'=>'eccmz_est', 'v'=>2 ]);

								if($__upd_est->e == 'ok'){

									echo $this->_auto->scss('Updated Rebuild and Status Field OK');

								}else{

									echo $this->_auto->err( '$__upd_est->w:'.$__upd_est->w );

								}

							}else{

								echo $this->_auto->err( '$__upd_rbld->w:'.$__upd_rbld->w );

							}

							if($p['cche']=='ok'){

								//$__aws_cache = $this->_auto->_aws->_cfr_clr([ 'b'=>'frnt', 'fle'=>'html/'.$this->__beccmz->d->enc, 'all'=>'ok' ]);
								//$__aws_cache_a = $this->_auto->_aws->_cfr_clr([ 'b'=>'frnt', 'fle'=>'a/'.$this->__beccmz->d->enc, 'all'=>'ok' ]);

								$_r['cfr']['html'] = $__aws_cache;
								$_r['cfr']['htmla'] = $__aws_cache_a;

								echo $this->_auto->li('Aws Cache Clear:'.$__aws_cache->e );

								if($__aws_cache->e != 'ok'){
									echo $this->_auto->err('Aws Cache Error:'.print_r($__aws_cache, true) );
								}

							}



						}else{

							echo $this->_auto->err('No status allowed or rebuild '.$this->__dteccmz->rbld);
							$_r['cfr'] = 'No status for cloudflare invalidation';

						}

						//print_r($__body);
					}

				}else{

					echo $this->_auto->err('No EC ID');

				}


				echo $this->_auto->li('ECCMZ_Rlc:'. $this->__beccmz->cmzrlc.' != '.$this->__dteccmz->id );
				echo $this->_auto->li('Build on ELSE');

			}

			if($Result->e == 'ok'){
				$_r['i'] = $Result->i;
				$_r['e'] = 'ok';
				$_r['m'] = 1;
			}else{
				$_r['e'] = 'no';
				$_r['m'] = 2;
				$_r['ww'] = $Result->w;
			}

		}

		return _jEnc($_r);

	}

	public function gt_mdlstp($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_EC_TP."
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON ecmdlstp_mdlstp = id_mdlstp
									WHERE ecmdlstp_ec=%s
									LIMIT 1", GtSQLVlStr($p['id'],'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlstp'];
				}else{
					$Vl['tot'] = $Tot_DtRg;
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No get ID';

		}

		return _jEnc($Vl);

	}


	public function gt_hdr($p=null){

		$_r = $p['c'];

		if(!isN($p) && !isN($p['c'])){

			//---------- Search header for replace it ----------//

			preg_match_all('/\[H.*?\]/', $_r, $_hdrs);

			foreach($_hdrs[0] as &$Key_hdrs){

				$__im_w = EcCmzImgTag($Key_hdrs, 'w');
				$__im_h = EcCmzImgTag($Key_hdrs, 'h');
				$_id_div_img = $__im_id->v;

				if(!isN($__im_w)){ $Vl['w'] = $__im_w->v; }
				if(!isN($__im_h)){ $Vl['h'] = $__im_h->v; }

				//$_sch_hdr = strpos($_r, '[H1]');
				if($p['intv']=='ok'){ $_elmn=' sumr-hdr="ok" '; }

				$_hdr_upld = '<div class="_edt_hdr _anm _empty">
								<div class="e_btn _anm">
									<div class="_btn _up" hdr-id="'.$p['id'].'" hdr-tp="'.$p['tp'].'" eccmz-id="'.$p['eccmz'].'" eccmz-dir="'.$p['dir'].'"></div>
								</div>
							</div>';

				if(!isN($Key_hdrs)){

					if(isN($p['id']) && isN($p['tp'] || $p['tp'] == 2)){

						$_chk_hdr = ChkEcCmzHdr([ 'eccmz'=>$p['eccmz'] ]);

						if($_chk_hdr->r != 'ok'){
							if(_ChckMd('ec_hdr_up')){
								$_hdr_nw = $_hdr_upld;
							}
							$_r = str_replace($Key_hdrs, $_hdr_nw, $_r);
						}else{

							$_r = str_replace($Key_hdrs, '

									<div class="_edt_hdr _anm">
										<img style="max-width:600px;" width="600" align="left" src="'.DMN_FLE_EC_CMZ.$_chk_hdr->img.'?_rdm='.Gn_Rnd(10).'">
										<div class="e_btn _anm">
											<div class="_btn _up" hdr-id="'.$p['id'].'" hdr-tp="'.$p['tp'].'" eccmz-id="'.$p['eccmz'].'" eccmz-dir="'.$p['dir'].'" title="Cargar"></div>
											<div class="_btn _rmv" eccmz-id="'.$p['eccmz'].'" title="Ocultar"></div>
										</div>
									</div>

									', $_r);
						}

					}else{

						if($p['tp'] == 1){
							if(!isN($__im_w->t)){ $_wt = $__im_w->t; }else{ $_wt = 'style="max-width:600px;"'; }
							$_dt_are = GtClAreDt([ 'id'=>$p['id'] ]);
							$_hdr_nw = '<img align="left" src="'.$_dt_are->img->hdr->big.'?_rdm='.Gn_Rnd(10).'" '.$_elmn.' '.$_wt.' '.$__im_h->t.'>';
						}elseif($p['tp'] == 2 && !_ChckMd('ec_hdr_up')){
							$_hdr_nw = "<div style='font-family:Roboto,Arial,Verdana,Geneva,sans-serif; font-size:11px; text-align:center; padding:20px 30px;' '.$_elmn.'>".$__dt_cl->tag->txt->no_area->v."</div>";
						}elseif(_ChckMd('ec_hdr_up')){
							$_hdr_nw = $_hdr_upld;
						}

						$_r = str_replace($Key_hdrs, $_hdr_nw, $_r);
						$_r = str_replace('[ARE_CLR]',$_dt_are->clr, $_r);

					}

				}

			}

		}

		$Vl['cod'] = /*compress_code(*/$_r/*)*/; // No compress cause affects pharagraph format
		return _jEnc($Vl);

	}


}

?>