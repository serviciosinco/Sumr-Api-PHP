<?php
	
class CRM_Wdgt {
		
	function __construct($p=NULL) {  
		
		$this->_aws = new API_CRM_Aws();

	}	

	function get_info($p=NULL){
		if(!isN($this->id_clwdgt)){ $this->_wdgt_d = GtClWdgtDt([ 'id'=>$this->id_clwdgt, 't'=>'enc' ]); }
	}

	function bld_json(){

		$this->get_info();
		$this->days_week = _WkDays();

		if(!isN( $this->_wdgt_d->id )){
			$r['e'] = 'ok';
			$r['v'] = E_TAG;
		}

		if(!isN($this->_wdgt_d->act)){
	
			foreach($this->_wdgt_d->act as $_act_k=>$_act_v){
				if(!isN($_act_v)){
					foreach($_act_v as $_lne_k=>$_lne_v){
						if($_lne_v->e == 'ok'){
							$_srv[ $_act_k ]['lines'][$_lne_v->id] = $_lne_v;
						}
					}
				}
			}
			
			$r['services'] = $_srv;
		
		}
		
		if($this->_wdgt_d->pst->top->e == 'ok'){ $r['class'] .= 'smr-dsk_top '; }
		if($this->_wdgt_d->pst->right->e == 'ok'){ $r['class'] .= 'smr_dsk_right '; }
		if($this->_wdgt_d->pst->bottom->e == 'ok'){ $r['class'] .= 'smr_dsk_bottom '; }
		if($this->_wdgt_d->pst->left->e == 'ok'){ $r['class'] .= 'smr_dsk_left '; }
		
		if(!isN($this->_wdgt_d->pst->top->v)){ $r['root']['dsk'] .= '--sumr-dsk-left:'.$this->_wdgt_d->pst->top->v.'px;'; }
		if(!isN($this->_wdgt_d->pst->right->v)){ $r['root']['dsk'] .= '--sumr-dsk-right:'.$this->_wdgt_d->pst->right->v.'px;'; }
		if(!isN($this->_wdgt_d->pst->bottom->v)){ 
			$r['root']['dsk'] .= '--sumr-dsk-bottom:'.$this->_wdgt_d->pst->bottom->v.'px;';
			$r['root']['dsk'] .= '--sumr-dsk-opt-bottom:'.($this->_wdgt_d->pst->bottom->v + 60).'px;'; 
		}

		if(!isN($this->_wdgt_d->pst->left->v)){ $r['root']['dsk'] .= '--sumr-dsk-left:'.$this->_wdgt_d->pst->left->v.'px;'; }
		
		if($this->_wdgt_d->pst->mbl->top->e == 'ok'){ $r['class'] .= 'smr_mbl_top '; }
		if($this->_wdgt_d->pst->mbl->right->e == 'ok'){ $r['class'] .= 'smr_mbl_right '; }
		if($this->_wdgt_d->pst->mbl->bottom->e == 'ok'){ $r['class'] .= 'smr_mbl_bottom '; }
		if($this->_wdgt_d->pst->mbl->left->e == 'ok'){ $r['class'] .= 'smr_mbl_left '; }
		
		if(!isN($this->_wdgt_d->pst->mbl->top->v)){ $r['root']['mbl'] .= '--sumr-mbl-left:'.$this->_wdgt_d->pst->mbl->top->v.'px;'; }
		if(!isN($this->_wdgt_d->pst->mbl->right->v)){ $r['root']['mbl'] .= '--sumr-mbl-right:'.$this->_wdgt_d->pst->mbl->right->v.'px;'; }
		if(!isN($this->_wdgt_d->pst->mbl->bottom->v)){ 
			$r['root']['mbl'] .= '--sumr-mbl-bottom:'.$this->_wdgt_d->pst->mbl->bottom->v.'px;'; 
			$r['root']['mbl'] .= '--sumr-mbl-opt-bottom:'.($this->_wdgt_d->pst->mbl->bottom->v + 60).'px;'; 
		}
		if(!isN($this->_wdgt_d->pst->mbl->left->v)){ $r['root']['mbl'] .= '--sumr-mbl-left:'.$this->_wdgt_d->pst->mbl->left->v.'px;'; }
		
		if($this->_wdgt_d->puff == 'ok'){ $r['class'] .= 'smr_dsk_puff '; } 
		if($this->_wdgt_d->mbl->puff == 'ok'){ $r['class'] .= 'smr_mbl_puff '; }
		
		if($this->_wdgt_d->shwtt == 'ok'){ $r['class'] .= 'smr_dsk_shwtt '; } 
		if($this->_wdgt_d->mbl->shwtt == 'ok'){ $r['class'] .= 'smr_mbl_shwtt '; }
		
		$r['powered'] = $this->_wdgt_d->pwd;
		$r['puff'] = $this->_wdgt_d->puff;
		$r['shwtt'] = $this->_wdgt_d->shwtt;
		$r['env'] = Dvlpr()?'dev':'prd'; //Environment
		
		$r['mbl']['powered'] = $this->_wdgt_d->mbl->pwd;
		$r['mbl']['puff'] = $this->_wdgt_d->mbl->puff;
		$r['mbl']['shwtt'] = $this->_wdgt_d->mbl->shwtt;
		
		$r['account']['nm'] = $this->_wdgt_d->cl->nm;
		$r['account']['sbd'] = $this->_wdgt_d->cl->sbd;
		$r['account']['prfl'] = $this->_wdgt_d->cl->prfl;

		$r['reseller'] = $this->_wdgt_d->rsllr;

		$r['img']['start'] = $this->_wdgt_d->img->big;
		
		if(!isN($this->_wdgt_d->clr)){		
			$r['clr']['start'] = $this->_wdgt_d->clr->strt;
			$r['clr']['header'] = $this->_wdgt_d->clr->hdr;
		}
		
		if(!isN($this->_wdgt_d->tx)){	
			$r['tx']['button_title'] = $this->_wdgt_d->tx->btn_tt;
			$r['tx']['popup_title'] = $this->_wdgt_d->tx->pop_tt;
			$r['tx']['popup_intro'] = $this->_wdgt_d->tx->pop_intro;
			$r['tx']['callme_placeholder'] = $this->_wdgt_d->tx->call_ph;
		}
		
		//--------------- General Text From System ---------------//
	
		$r['tx']['success']['call'] = _Cns('TX_PRCEXT');
		$r['tx']['success']['callv'] = _Cns('TX_CALLV_SCSS');
		$r['tx']['success']['whtsp'] = _Cns('TX_WHTSP_SCSS');
		$r['tx']['go']['callv']['s'] = _Cns('TX_CALLV_GO_S');
		$r['tx']['go']['callv']['c'] = _Cns('TX_CALLV_GO_C');
		$r['tx']['go']['whtsp']['c'] = _Cns('TX_WHTSP_GO_C');

		$r['tx']['back'] = _Cns('TX_VLVR');
		$r['tx']['name'] = _Cns('TT_FM_FLLNM');
		$r['tx']['email'] = _Cns('TT_FM_EML');

		foreach($this->days_week as $_k=>$_v){
			$r['sch']['day'][$_v->id] = $this->_wdgt_d->sch->d->{$_v->id};
			$r['mbl']['sch']['day'][$_v->id] = $this->_wdgt_d->sch->mbl->d->{$_v->id};
		}
		
		return _jEnc( $r );
		
	}


	
	function sve_json(){

		$__json = $this->bld_json();

		if(!isN( $this->_wdgt_d->id )){

			$_json = 'sumrJson_'.$this->_wdgt_d->enc.'('.cmpr_fm( json_encode( $__json ) ).')';
			$_r['sve']['data'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'wdgt', 'fle'=>$this->_wdgt_d->enc.'.json', 'cbdy'=>$_json, 'ctp'=>'application/json', 'cfr'=>'ok' ]);

			$_r['csspath'] = $_css_pth = dirname(__FILE__, 3).'/_sty/_fl/sb/wdgt/main.css';
			$_css = cmpr_css( file_get_contents( $_css_pth ), [ 'rnd'=>$this->_wdgt_d->enc ] );

			if(!isN($this->_wdgt_d->thm->key->vl) && $this->_wdgt_d->thm->key->vl != 'bsc'){
				$_r['csspath_theme'] = $_css_thm_pth = dirname(__FILE__, 3).'/_sty/_fl/sb/wdgt/themes/'.$this->_wdgt_d->thm->key->vl.'.css';
				$_css .= cmpr_css( file_get_contents( $_css_thm_pth ), [ 'rnd'=>$this->_wdgt_d->enc ] );
			}

			$__usch = [ '[FESTR]', '[FSVG]', '[FWDGT]', '[FESTRICN]', '[FEC]', '[FFNT]', '[LOGO_MAIN]', '[CSSNOTY]', '[CL_IMG_ESTR]' ];
			$__uchn = [ DMN_IMG_ESTR, DMN_IMG_ESTR_SVG, DMN_IMG_ESTR_WDGT, DMN_IMG_ESTR_ICN, DMN_EC, DMN_FONT, LOGO_MAIN, $__noty_css, CL_IMG_ESTR ];

			$_css = str_replace($__usch, $__uchn, $_css);

			$_sve_css = $this->_aws->_s3_put([ 'b'=>'css', 'fle'=>'sb/wdgt/'.$this->_wdgt_d->enc.'.css', 'cbdy'=>$_css, 'ctp'=>'text/css', 'cfr'=>'ok' ]);

			$_r['sve']['css'] = $_sve_css;
			$_r['sve']['js'] = $this->_aws->_cfr_clr([ 'b'=>'fle', 'fle'=>'main.js?id='.$this->_wdgt_d->enc ]);

			if($_sve_json->e == 'ok'){
				$_r['e'] = 'ok';
			}
		}

		return _jEnc($_r);

	}



	function sve_main(){

		if(!isN( $this->_wdgt_d->id )){

			$_js_pth = dirname(__FILE__, 3).'/_js/sb/wdgt/main.js';
			
			if(!isN($_js_pth)){

				$_js = cmpr_js( file_get_contents( $_js_pth ), [ 'rnd'=>$this->_wdgt_d->enc ] );

				if(!isN($_js)){

					$__usch = [ '[ID]', '[PWD]', '[PWD_LNK]', '[DOMAIN]' ];
					$__uchn = [ $this->_wdgt_d->enc, 'SUMR', 'https://agenciadigital.servicios.in', DMN_S ];
					$__js = str_replace($__usch, $__uchn, $_js);

					if(Dvlpr()){
						$__js = str_replace('[ENV]', 'dev', $__js);
					}else{
						$__js = str_replace('[ENV]', 'prd', $__js);
					}

					$_sve_js = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'wdgt/'.$this->_wdgt_d->enc.'.js', 'cbdy'=>$__js ]);

					$_r['sve']['js'] = $this->_aws->_cfr_clr([ 'b'=>'js', 'fle'=>'wdgt/'.$this->_wdgt_d->enc.'.js' ]);

					if($_sve_js->e == 'ok'){
						$_r['e'] = 'ok';
					}

				}

			}
			
		}

		return _jEnc($_r);

	}



}
    
 ?>