<?php

	class CRM_Main{

	    function __construct($p=NULL) {

			global $__no_sbdmn;

	        $this->id_rnd = '_'.Gn_Rnd(20);
	        $this->id_ldr = '_m_ldr_pop'.$this->id_rnd;
	        $this->n_try = 20;

			if($__no_sbdmn != 'ok'){
				$__sbdmn = Gt_SbDMN();
				$this->cl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);
			}

	        if(Php_Ls_Cln($_GET['_pop'])=='ok'){ $this->gt->pop = 'ok'; }
	        if(Php_Ls_Cln($_GET['_fpop'])=='ok'){ $this->gt->fpop = 'ok'; }

	        if(!isN( Php_Ls_Cln($_GET['Pr']) )){ $this->gt->pr=Php_Ls_Cln($_GET['Pr']); }
	        if(!isN( Php_Ls_Cln($_GET['_i']) )){ $this->gt->i=Php_Ls_Cln($_GET['_i']); }
			if(!isN( Php_Ls_Cln($_GET['_tmpl']) )){ $this->gt->tmpl=Php_Ls_Cln($_GET['_tmpl']); }


			if(!isN( Php_Ls_Cln($_GET['_pnl']) )){

				$_pnl=_jEnc( Php_Ls_Cln($_GET['_pnl']) );

				if($_pnl->e == 'ok'){
					$this->gt->pnl->e = 'ok';
					if(!isN( $_pnl->i )){ $this->gt->pnl->id = $_pnl->i; }
					if(!isN( $_pnl->s )){ $this->gt->pnl->sty = $_pnl->s; }
					if(!isN( $_pnl->tp )){ $this->gt->pnl->tp = $_pnl->tp; }
				}

			}


	        if(!isN( _GPJ([ 'v'=>'sch' ]) )){
		        $this->gt->sch=_GPJ([ 'v'=>'sch' ]);
		    }

	        if(!isN( Php_Ls_Cln($_GET["pgN"]) )){ $this->gt->pgn=Php_Ls_Cln($_GET['pgN']); }
			if(!isN( Php_Ls_Cln($_GET['totRws']) )){ $this->gt->totrws=Php_Ls_Cln($_GET['totRws']); }

			if(!isN( Php_Ls_Cln($_GET['plct']) )){ $this->gt->plct=Php_Ls_Cln($_GET['plct']); } // Place To
			if(!isN( Php_Ls_Cln($_GET['plcf']) )){ $this->gt->plcf=Php_Ls_Cln($_GET['plcf']); } // Place From


	        if(!isN( Php_Ls_Cln($_GET['__i']) )){ $this->gt->isb=Php_Ls_Cln($_GET['__i']); }
	        if(!isN( Php_Ls_Cln($_GET['_op']) )){ $this->gt->op=Php_Ls_Cln($_GET['_op']); }

	        if(!isN( Php_Ls_Cln($_GET["_t"]) )){ $this->gt->t=Php_Ls_Cln($_GET['_t']); }

	        if(!isN( Php_Ls_Cln($_GET["_t2"]) )){
		        $this->gt->tsb = Php_Ls_Cln($_GET['_t2']);
				$this->mdlstp = GtMdlSTpDt([ 'tp'=>$this->gt->tsb ]);
				if(isN($this->tpg)){ $this->tpg = $this->gt->tsb; }
		    }

		    if(!isN( Php_Ls_Cln($_GET["_t3"]) )){
		        $this->gt->tsb_m = Php_Ls_Cln($_GET['_t3']);
				$this->mdlstp_m = GtMdlSTpDt([ 'tp'=>$this->gt->tsb_m ]);
				if(isN($this->tpg_m)){ $this->tpg_m = $this->gt->tsb_m; }
		    }

		    if(!isN( Php_Ls_Cln($_GET["_t4"]) )){
		        $this->gt->tsb_d = Php_Ls_Cln($_GET['_t4']);
		    }

	        if(!isN( Php_Ls_Cln($_GET['_tsis']) )){ $this->gt->tsis=Php_Ls_Cln($_GET['_tsis']); }
	        if(!isN( Php_Ls_Cln($_GET['_opnw']) )){ $this->gt->opnw=Php_Ls_Cln($_GET['_opnw']); }
	        if(!isN( Php_Ls_Cln($_GET['_m']) )){ $this->gt->m=Php_Ls_Cln($_GET['_m']); }
			if(!isN( Php_Ls_Cln($_GET['__etp']) )){ $this->gt->etp=Php_Ls_Cln($_GET['__etp']); }
			if(!isN( Php_Ls_Cln($_GET['_ntf']) )){ $this->gt->ntf=Php_Ls_Cln($_GET['_ntf']); }
			if(!isN( Php_Ls_Cln($_GET['_bld']) )){ $this->gt->bld=Php_Ls_Cln($_GET['_bld']); }
			if(!isN( Php_Ls_Cln($_GET['__cll']) )){ $this->gt->cll=Php_Ls_Cln($_GET['__cll']); }
			if(!isN( Php_Ls_Cln($_GET['_wrp']) )){ $this->gt->wrp=Php_Ls_Cln($_GET['_wrp']); }
			if(!isN( Php_Ls_Cln($_GET['tra_col']) )){ $this->gt->tra_col=Php_Ls_Cln($_GET['tra_col']); }
			if(!isN( Php_Ls_Cln($_GET['main_cnv']) )){ $this->gt->main_cnv = _jEnc( Php_Ls_Cln($_GET['main_cnv']) ); }


	        if($this->gt->pr != "Dt" && $this->gt->pr != "Ing"){ $this->_show_ls='ok'; }
			if(!isN($this->gt->t)){ $this->tp = $this->gt->t; }
			$this->id_hdr = ID_HDRLS.'_'.strtoupper( $this->tp ).$this->id_rnd;

			if(!isN($this->tp)){
				$_expl = explode('_', $this->tp);
				if($_expl[0]!='mdl' /*&& count($_expl) > 1*/){ $_prfx = 'MDL_'; }
				if($this->tp != 'mdl'){ $_tt_rg = $this->tp; }

				if($this->mdlstp->ctg->tot > 0){
					if(!isN($this->mdlstp->ctg->main->attr->cns)){
						$_tt_rg = 'MDL_CTG_'.$this->mdlstp->ctg->main->attr->cns;
					}
				}

				if(!isN($_tt_rg)){ $this->tt .= _Cns($_prfx.strtoupper($_tt_rg)); }

			}

			if(!isN($this->gt->tsb)){
				if(strpos($this->tp, 'mdl') !== false){
					$this->tt .= ' '._Cns('MDL_S_TP_'.strtoupper($this->gt->tsb));
				}
			}


			$_adsch = __AdSch();

			if(!isN( $this->gt->tsb )){ $this->ls->vrall .= __t2($this->gt->tsb); }
			if(!isN( $this->gt->tsb_m )){ $this->ls->vrall .= __t3($this->gt->tsb_m); }

			if(!isN( $this->gt->isb )){ $this->ls->vrall .= ADM_LNK_SB.$this->gt->isb; }
			if(!isN( $this->gt->tmpl )){ $this->ls->vrall .= '&_tmpl='.$this->gt->tmpl; }
			if(!isN( $this->gt->etp )){ $this->ls->vrall .= '&__etp='.$this->gt->etp; }

			if($this->gt->pop == 'ok'){ $this->ls->vrall .= TXGN_POP; }

			if(!isN( $_adsch )){ $this->ls->vrall .= $_adsch; }

			$this->bx_rld = _BxRld_ID();


			if(!isN( $this->bx_rld )){ $this->ls->vrall .= TXGN_BX.$this->bx_rld; }
	    }

		function __destruct() {

			if(!isN($this->sql)){ $this->sql->free; }

	   	}

	   	public function sbl(){
		   	if(!isN($this->gt->isb)){ return true; }else{ return false; }
	   	}

		public function pnl(){
			if($this->gt->pnl->e == 'ok'){ return true; }else{ return false; }
		}

		public function pnl_i(){
			return $this->gt->pnl->id;
	 	}

	   	public function pop(){
		   	if($this->gt->pop == 'ok'){ return true; }else{ return false; }
	   	}

	   	public function fpop(){
		   	if($this->gt->fpop == 'ok'){ return true; }else{ return false; }
	   	}


		public function _gpj($v=NULL){
			return _GPJ([ 'j'=>$this->c_f_g, 'v'=>$v ]);
		}

		public function _tme($t=NULL){
		   	if($t != NULL && $t != ''){
				$dt = new DateTime($t, new DateTimeZone('UTC'));
				//$dt->setTimezone(new DateTimeZone('America/Bogota'));
				$_hra = $dt->format('H:i a');
				return Spn($_hra,'','__time');
			}
	    }

	    function _dte($t=NULL){
		   	if($t != NULL && $t != ''){
				$dt = new DateTime($t, new DateTimeZone('UTC'));
				//$dt->setTimezone(new DateTimeZone('America/Bogota'));
				$_dte = FechaESP_OLD($dt->format('Y-m-d'), 'yrdy');
				return Spn($_dte,'','__date');
			}
	    }


		public function _var_clr($_p,$_v){

			$_p_e = explode('?', $_p);
			$_p_del = $_v;

			if(count($_p_e) > 1){ $_url=$_p_e[1]; }else{ $_url=$_p_e[0]; }

			$__par = explode('&', $_url);

			foreach($__par as $_v_k=>$_v_v){
				if(!isN($_v_v)){
					$_g_vle = explode('=', $_v_v);
					if(!isN($_g_vle[0]) && !isN($_g_vle[1])){
						if(!in_array($_g_vle[0], $_p_del)){
							$url_get[ $_g_vle[0] ] = $_g_vle[0].'='.$_g_vle[1];
						}
					}
				}
			}

			if(!isN($url_get)){
				$_url_r = implode('&', $url_get );
			}else{
				$_url_r = $_p;
			}

			return $_url_r;
		}


		public function _eNo($p=NULL){

			$rsp = $p['r'];
			$rsp['m'] = 2;
			$rsp['w'] = $p['c']->error;
			$rsp['w_n'] = $p['c']->errno;

			return $rsp;
		}


		public function _dvlsfl_vr($p=NULL){

			$_fld = FL_LS_GN;

			if($p['f'] == 'dt'){ $_fld = FL_DT_GN; }
			if($p['f'] == 'fm'){ $_fld = FL_FM_GN; }
			if($p['f'] == 'inf'){ $_fld = FL_INF_GN; }
			if($p['f'] == 'up'){ $_fld = FL_UP_GN; }

			if(!isN($p['t2'])){
				$_t2 = __t2($p['t2']);
			}elseif(!isN($this->gt->tsb)){
				$_t2 = __t2($this->gt->tsb);
			}

			if(!isN($p['t3'])){ $_t2 .= __t3($p['t3']); }
			if(!isN($p['t4'])){ $_t2 .= __t4($p['t4']); }

			if(!isN($this->ls->vrall) && $p['vrall']=='ok'){
				if(!isN($p['i'])){
					$_m .= $this->_var_clr($this->ls->vrall, ['__i']);
				}else{
					$_m .= $this->ls->vrall;
				}
			}

			if(!isN($p['m'])){ $_m .= $p['m']; }
			if($this->pop()){ $_m .= TXGN_POP; }
			if($this->pnl()/* && $this->sbl()*/){ $_m .= TXGN_PNL; }
			if(!isN($p['wrp'])){ $_m .= '&_wrp='.$p['wrp']; }

			$_id = '_'.$p['n'];
			$_idv = DV_LSFL.$_id.$this->id_rnd;

			if($this->dt->tot==0 && $p['hd']!='no'){ $_hdo='_hd'; }

			if($p['is']=='bsc'){
				$_icn = Spn('','','_tt_icn _tt_icn'.$_id);
			}elseif($p['is']=='d2'){
				$_tabcls = ' _tt_icn'.$_id.' ';
			}

			$this->tab->{$p['n']}->t = TBGRP.$_id.$this->id_rnd;

			if(!isN($p['bimg'])){ $_sty .= "background-image:url(".$p['bimg'].")"; }

			$this->tab->{$p['n']}->l = '<li class="TabbedPanelsTab '.$_id.' '.$_hdo.$_tabcls.' '.$p['cls'].'" id="'.$this->tab->{$p['n']}->t.'" '.(!isN($_sty)? 'style="'.$_sty.'"' :'').'>'.$_icn.Spn($p['l'],'','_tx').'</li>';

			$this->tab->{$p['n']}->c = $_idv;
			$this->tab->{$p['n']}->d = bdiv([ 'id'=>$this->tab->{$p['n']}->c, 'cls'=>'dv__sub' ]);
			$this->tab->{$p['n']}->f = TBGRP.'_'.$p['n'].$this->id_rnd."_go";

			if(!isN($p['t'])){
				if(!isN($_idv) && $this->pnl()){ $_m = '&'.$this->_var_clr($_m, ['_bx']); }
				$__r = " SUMR_Main.bxajx._".$_idv." = '".Fl_Rnd($_fld.__t($p['t'],true).$_t2.Fl_i($p['i']).TXGN_BX.$_idv.$_m)."'; ";
			}

			$this->_dvlsfl([ 'i'=>$_id, 'b'=>$p['b'], 'rld'=>$p['rld'] ]);
			if($p['s']=='ok'){ $this->_dvlsfl([ 'i'=>$_id, 's'=>'ok', 's_click'=>$p['s_click'] ]); }
			if($p['get']=='ok'){ return($__r); }else{ $this->jv .= $__r; }

		}

		public function _dvlsfl($p=NULL){

			if(!isN($p['g'])){ $_got = $p['g']; }else{ $_got = $p['i']; }
			if(!isN($this->id_ldr)){ $_ldr=$this->id_ldr; }

			$_idb = TBGRP.$p['i'].$this->id_rnd;
			$_idv = DV_LSFL.$_got.$this->id_rnd;

			if($p['s'] == 'ok'){

				if($p['s_click'] == 'ok'){
					$__r = "$('#".$_idb."').click();";
				}else{
					$__r = " _ldCnt({ u:SUMR_Main.bxajx._".$_idv.", c:'".$_idv."', ldr:'".$_ldr."' }); " ;
				}

 			}else{

				if(!isN($p['h'])){

					$__go = " window.open('".$p['h']."'); ";

				}else{

					if($p['ldr']!='no'){
						$__go_ldr_on = " $('#".$_idb."').addClass('_ldp'); ";
						$__go_ldr_off = " 	setTimeout(function(){

												$('#".$_idb."').removeClass('_ldp');

											}, 1000);  ";
					}

					$__go = "

						if( !isN( SUMR_Main.bxajx._".$_idv." ) ){

							".$__go_ldr_on."

							_ldCnt({
								u:SUMR_Main.bxajx._".$_idv." + __mre,
								c:'".$_idv."',
								ldr:'".$_ldr."',
								_cl:function(){
									if(!isN(__clc)){ __clc.removeClass('_ldp'); }
									".$__go_ldr_off."
								}
							});

						}

					";
				}

				if($p['tomny']){
					$this->tab->id;
				}


				if($this->tab->tomny=='ok' && !isN($this->tab->id)){
					$_mnycls = '$("#'.$this->tab->id.'").addClass(\'mny\');';
				}


				if($this->bsve!='no'){
					if($p['b']=='ok'){
						$__hdr_hide = " $('#".$this->id_hdr."').removeClass('_disabled'); ";
					}else{
						$__hdr_hide = $_mnycls." $('#".$this->id_hdr."').addClass('_disabled'); ";
					}
				}

				if($p['rld']!='no'){
					$_clk_action = "{$_idb}_go({ o:$(this) });";
				}else{
					$_clk_action = "
						if( $('#$_idv').is(':empty') ){
							{$_idb}_go({ o:$(this) });
						}
					";
				}

				$__r = "

					function {$_idb}_go(p){

						var __mre = '';

						if(!isN(p) && !isN(p.mre)){ var __mre = p.mre; }
						if(!isN(p) && !isN(p.o)){ var __clc = p.o; }else{ var __clc = ''; }

						".$__go."
						".$__hdr_hide."

						if( !isN(SUMR_Main.bxajx.".$this->tab->id."__cvr)){
							if(SUMR_Main.bxajx.".$this->tab->id."__cvr.length > 0){
								SUMR_Main.bxajx.".$this->tab->id."__cvr.delay(300).show();
								$('#".$this->tab->id."').addClass('_cmpct');
								if( SUMR_Main.bxajx.".$this->tab->id."__cvr_if.length){
									SUMR_Main.bxajx.".$this->tab->id."__cvr_if.height(130);
								}
							}
						}

					}

					$('#".$_idb."').off('click').on('click', function(e){
						e.preventDefault();
						{$_clk_action}
					});

				" ;
			}

			if($p['r']=='ok'){ return($__r); }else{ $this->js .= $__r; }
		}

		public function _dvls($p=NULL){

			$__id = '_'.$p['id'];

	        $r['html'] = bdiv([ 'id'=>DV_LSFL.$__id.$this->id_rnd ]);

	        $this->_dvlsfl_vr([ 'i'=>$p['i'], 'n'=>$p['id'], 't'=>$p['t'], 't2'=>$p['t2'], 'vrall'=>'ok' ]);
			$this->_dvlsfl([ 'i'=>$__id, 's'=>'ok' ]);

			return(_jEnc($r));

		}


		public function _dvlsfl_all($p=NULL, $op=NULL){

 			if(!isN($p)){

				$this->js .= "SUMR_Main.bxajx.".$this->tab->id."__cvr=null;";

				if($op['idb']=='ok'){

					$this->tab->id = 'TabPnl_'.Gn_Rnd(20);

					if(!isN($op['dtb'])){ $_dtb=$op['dtb']; }else{ $_dtb=0; }

					$this->js .= " SUMR_Main.bxajx.".$this->tab->id." = new Spry.Widget.TabbedPanels('".$this->tab->id."', { defaultTab:".$_dtb." }); ";

					$this->js .= "

						SUMR_Main.bxajx.".$this->tab->id."__cvr = $('#".$this->tab->id." > .TabbedPanelsContentGroup > ._cvr');
						SUMR_Main.bxajx.".$this->tab->id."__cvr_if = $('#".$this->tab->id." > .TabbedPanelsContentGroup > ._cvr iframe');

						if( SUMR_Main.bxajx.".$this->tab->id."__cvr.length){
							SUMR_Main.bxajx.".$this->tab->id."__cvr.delay(300).show();
						}
					";

				}

				if($op['tomny']=='ok'){
					$this->tab->tomny='ok';
				}

				if($op['sng']!='ok'){
					$this->_dvlsfl_vr([ 'i'=>$this->dt->rw[$this->ik], 'l'=>TX_DTSBSC, 'b'=>'ok', 'n'=>'bsc', 'tomny'=>$p['tomny'] ]);
				}

				if(!isN($op['bsve'])){ $this->bsve = $op['bsve']; }
				if(!isN($op['id'])){ $__i_go=$op['id']; }else{ $__i_go=$this->dt->rw[$this->ik]; }

				foreach($p AS $k=>$v){
					$this->_dvlsfl_vr([
						'i'=>$__i_go,
						'b'=>$_bsc,
						'l'=>$v['l'],
						'n'=>$v['n'],
						'f'=>$v['f'],
						'bimg'=>$v['bimg'],
						'hd'=>($op['sng']=='ok'?'no':''),
						'is'=>$op['icn_sty'],
						'cls'=>$v['cls'],
						't'=>$v['t'],
						't2'=>$v['t2'],
						't3'=>$v['t3'],
						't4'=>$v['t4'],
						'wrp'=>$v['wrp'],
						'rld'=>$v['rld'],
						's'=>$v['s'],
						's_click'=>$v['s_click'],
						'm'=>$v['m']
					]);
				}
			}

		}


		public function _andsql($p=NULL){

			if(!isN($p['f']) && !isN($p['v'])){

				$_r = implode(',', explode(',', $p['v']));

				if($p['in']){
					$_sql = ' AND '.$p['f'].' NOT IN ('.$_r.')';
				}elseif($p['no']){
					$_sql = ' AND '.$p['f'].' NOT IN ('.$_r.')';
				}else{
					$_sql = ' AND '.$p['f'].' = '.GtSQLVlStr($p['v'], "text").' ';
				}

				return($_sql);
			}

		}

		public function _sch_acs($p=NULL){

			$_acs = ['á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ'];
			$_wrd = ctjTx($p,'out');

			foreach($_acs as $_acs_k=>$_acs_v){
				$__wrds_ex = explode($_acs_v, $_wrd);
				if(count($__wrds_ex) > 1){
					foreach($__wrds_ex as $__wrds_ex_k=>$__wrds_ex_v){
						if(strlen($__wrds_ex_v) > 3){ $_wrd_nw[] = $__wrds_ex_v; }
					}
				}

			}

			if(!isN($_wrd_nw)){ return $_wrd_nw; }

		}

		public function _sch($p=NULL){

			$__flt_dt = $this->_f_chk([ 't'=>$this->gt->t, 't2'=>$this->gt->tsb ]);
			$this->gbd->sch = $__flt_dt->sch;

			if (!isN($this->sch->f) && (!isN($this->gt->sch) || !isN($this->gbd->sch))){

				if($p['t']=='w'){ $_u = ' WHERE ';}elseif($p['t']!='no'){$_u = ' AND ';}

				if(!isN($this->gbd->sch)){
					$_t_sch = $this->gbd->sch;
				}elseif(!isN($this->gt->sch)){
					$_t_sch = $this->gt->sch;
				}

				$schGt = strtolower(MyMn(ctjTx($_t_sch,'in')));
				$schBsc = explode(' ',$schGt);

				$Flds = explode(',',$this->sch->f);
				$Flds_Tot = count($Flds);

				foreach($schBsc as $schBsc_k=>$schBsc_v){
					$__mre_wrds = $this->_sch_acs($schBsc_v);
					if(!isN($__mre_wrds)){ $schBsc = array_merge($schBsc, $__mre_wrds); }
				}

				for ($i=0; $i<=$Flds_Tot; $i++) {

					$Flds_Cd = [];

					foreach($schBsc as $schBsc_k=>$schBsc_v){

						$Nm = $i+1;
						if(!isN($Flds[$i])){
							if(!isN($schBsc_v)){
								$Flds_Cd[] = "(lower(".$Flds[$i].") LIKE '%".ctjTx($schBsc_v,'out')."%')";
								$Cnct_Cd[] = "lower(".$Flds[$i].")"; // Concat All Fields
								$this->f_on = 'ok';
							}
						}

					}

					if(!isN($Flds_Cd)){ $Flds_Cd_Blq[] = " (".implode(' && ',$Flds_Cd).") "; }

				}

				if(!isN($Cnct_Cd) && count($Cnct_Cd) > 0){ $f_cnct = "(CONCAT(".implode(',',$Cnct_Cd)."))"; }
				if(!isN($schGt)){ $f_cnct_q = " || (".$f_cnct." LIKE '%".ctjTx($schGt,'out')."%')"; }
				if(!isN($schGt)){ $f_cnct_q .= " || (".$f_cnct." LIKE '%".str_replace(' ','',ctjTx($schGt,'out'))."%')"; }

				if(!isN($this->sch->m)){
					$__sch_m=str_replace('[-SCH-]',$this->gbd->sch,$this->sch->m);
				}

				$f_busq = $_u." (".implode('||',$Flds_Cd_Blq)." ".$f_cnct_q." ".$__sch_m.") ";

				$this->sch->cod = $f_busq;

			}

		}



		public function _f_chk($p){

			global $__cnx;

			$Vl['e']='no';
			$Vl['p']=$p;

			if(!isN($p['t'])){

				if(isN($p['cl'])){
					$__sbdmn = Gt_SbDMN();
					$__dtcl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);
					$__cl = $__dt_cl->id;
				}else{
					$__cl = $p['cl'];
				}

				if(!isN($p['t2'])){ $__fl .= sprintf(' AND usflt_sub=%s ', GtSQLVlStr($p['t2'],'text')); }

				$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).MDL_US_FLT_BD.' WHERE usflt_cl=%s AND usflt_us=%s AND usflt_tp=%s'.$__fl,
							 GtSQLVlStr($__dtcl->id,'int'),
							 GtSQLVlStr(SISUS_ID,'int'),
							 GtSQLVlStr($p['t'],'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg == 1){
						$Vl['e']='ok';
						$Vl['id']=$row_DtRg['id_usflt'];
						$Vl['f']= json_decode($row_DtRg['usflt_flt'], true);
						$Vl['sch']=ctjTx($row_DtRg['usflt_sch'],'in');
					}else{
						$Vl['e']='no';
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}


		public function _f_sve($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			if(!isN($p['t'])){

				$__sbdmn = Gt_SbDMN();
				$__dtcl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);
				$__g_flt = $this->_f_gt();
				$__g_sch = $this->_s_gt();

				$__chk = $this->_f_chk([ 'cl'=>$__dt_cl->id, 't'=>$p['t'], 't2'=>$p['t2'] ]);

				if(!isN($__dtcl->id) && $__chk->e == 'ok' && !isN($__chk->id)){

					$Qry = sprintf("UPDATE "._BdStr(DBM).MDL_US_FLT_BD." SET usflt_flt=%s, usflt_sch=%s WHERE id_usflt=%s",
								  GtSQLVlStr($__g_flt, "text"),
								  GtSQLVlStr(ctjTx($__g_sch,'out'), "text"),
								  GtSQLVlStr($__chk->id, "int"));

				}elseif($p['cln'] == 'ok'){

					$Qry = sprintf("UPDATE "._BdStr(DBM).MDL_US_FLT_BD." SET usflt_flt=%s, usflt_sch=%s WHERE id_usflt=%s",
									GtSQLVlStr(NULL, "text"),
									GtSQLVlStr(NULL, "text"),
									GtSQLVlStr($__chk->id, "int"));

				}else{

					if( !isN($__dtcl->id) ){

						$Qry = sprintf("INSERT INTO "._BdStr(DBM).MDL_US_FLT_BD	." (usflt_cl, usflt_us, usflt_flt, usflt_sch, usflt_tp, usflt_sub) VALUES (%s, %s, %s, %s, %s, %s)",
								  GtSQLVlStr($__dtcl->id, "int"),
								  GtSQLVlStr(SISUS_ID, "int"),
								  GtSQLVlStr($__g_flt, "text"),
								  GtSQLVlStr(ctjTx($__g_sch,'out'), "text"),
								  GtSQLVlStr(ctjTx($p['t'],'out'), "text"),
								  GtSQLVlStr(ctjTx($p['t2'],'out'), "text"));

					}
				}

				if(!isN($Qry)){ $Result1 = $__cnx->_prc($Qry); $__chk = $this->fl->rst='ok'; $this->gt->pgn=0; }


				if($Result1){
					$Vl['e'] = 'ok';
					$g = $this->_f_gt();
					$__chk = $this->_f_chk([ 'cl'=>$__dt_cl->id, 't'=>$p['t'], 't2'=>$p['t2'] ]);
					$Vl['d'] = $__chk->f;

				}else{
					$Vl['e'] = 'no';
					$Vl['w'] = $__cnx->c_p->error;
				}



			}

			return(_jEnc($Vl));
		}



		public function _c_flt_dte($p=NULL){

			$html .= SlDt([
						'id'=>'_f1'.$this->id_rnd,
						'va'=>_GPJ([ 'j'=>$this->c_f_g, 'v'=>'f1' ]),
						'rq'=>'ok',
						'ph'=>TX_ORD_FIN,
						'lmt'=>'no',
						'yr'=>'ok',
						'cls'=>CLS_CLND,
						'attr'=>['send-id'=>'f1']
					]);


			$html .= SlDt([
						'id'=>'_f2'.$this->id_rnd,
						'va'=>_GPJ([ 'j'=>$this->c_f_g, 'v'=>'f2' ]),
						'rq'=>'ok',
						'ph'=>TX_ORD_FOU,
						'lmt'=>'no',
						'yr'=>'ok',
						'cls'=>CLS_CLND,
						'attr'=>['send-id'=>'f2']
					]);

			return $html;
		}






		public function _c_flt($p=NULL){

			if($p['dte']!='no'){ $_dte = $this->_c_flt_dte(); }

			$this->html = '	<div id="Fl_Bx_'.$this->id_rnd.'" class="FilterPanel _anm">
								<div class="FilterPanelBtn _anm" tabindex="0">'.Spn('','','_tt_icn _tt_icn_flt _anm').TX_TTMN_FL.'</div>
							</div> ';

			$this->js .= "	SUMR_Main.pnlf.f.btn({
								rnd:'".$this->id_rnd."',
								id:'#Fl_Bx_".$this->id_rnd."',
								bxrld:'".$this->bx_rld."',
								plc:'".$this->gt->plct."',
								sch:'Sch_Cnt".$this->id_rnd."',
								t:'".$this->gt->t."',
								t2:'".$this->gt->tsb."',
								_c:function(){  }
							}); ";

			echo $this->html;

		}

		public function _bld_f_q($p=NULL){

			if(!isN($this->c_f_g)){

				foreach($this->c_f_g as $_p_k=>$_p_v){

					$this->_fl->{$_p_k} = $_p_v;

					if(is_array($_p_v)){
						$__vl = $_p_v[0];
					}else{
						$__vl = $_p_v;
					}

					if(!isN($_p_v)){

						if(is_array($_p_v)){

							$_nv_go = [];

							foreach($_p_v as $_nv_k=>$_nv_v){
								if(!isN($_nv_v)){
									$_nv_go[] = '"'.$_nv_v.'"';
								}
							}

							$_nv = implode(',', $_nv_go);

							if(!isN($_nv)){ $__f .= ' AND '.$_p_k.' IN ('.$_nv.') '; $this->f_on = 'ok'; }

						}elseif($_p_k =='org'){

							foreach($_p_v as $_org_k=>$_org_v){
								foreach($_org_v as $_id_k=>$_id_v){
									if(!isN($_id_v)){
										$_org_go[] = '"'.$_id_v.'"';
										$this->f_on = 'ok';
									}
								}
							}

							$this->_fl->org = $_org_go;

						}elseif($_p_k =='chk'){

							$Ls_Chk = __LsDt(['k'=>'sis_chk', 'cl'=>DB_CL_ID ]);

							foreach($_p_v as $_chk_k=>$_chk_v){
								if(!isN($_chk_k) && $_chk_v == '1'){
									foreach($Ls_Chk->ls->sis_chk as $_chkd_k=>$_chkd_v){
										if($_chk_k == $_chkd_v->cns){
											$_chk_go[] = $_chkd_v->id;
										}
									}
									$this->f_on = 'ok';
								}
							}

							if(!isN($_chk_go)){ $this->_fl->chk = implode(',', $_chk_go); }else{ $this->_fl->chk = ''; }

						}elseif($_p_k=='fk'){

							foreach($_p_v as $_fk_k=>$_fl_v){

								if(!is_array($_fl_v)){

									$_fk_go[$_fk_k] = $_fl_v;

								}else{

									foreach($_fl_v as $_id_k=>$_id_v){
										if(!isN($_id_v)){
											$_fk_go[$_fk_k][] = '"'.$_id_v.'"';
											$this->f_on = 'ok';
										}
									}

								}


							}

							$this->_fl->fk = _jEnc($_fk_go);

						}else{

							if($_p_k!='f1' && $_p_k!='f2' && $_p_k!='fu1' && $_p_k!='fu2' && $_p_k!='fk' && $_p_k!='fu2' && $_p_k!='fs1'){

								$__f .= ' AND '.$_p_k.' = "'.$_p_v.'" ';
								$this->f_on = 'ok';

							}

						}
					}
				}
			}

			$this->qry_f .= $__f;

		}



		public function _data_his($_p=NULL){

			global $__cnx;

			$r['e'] = 'no';
			$r['get'] = $_p;

			if(!isN($_p['tp']) && !isN($_p['id']) && !isN($_p['f'])){

				if(!isN($_p['us'])){ $_q_us = $_p['us']; }
				elseif(defined('SISUS_ID')){ $_q_us = SISUS_ID; }
				elseif(!isN($this->datahis_us)){ $_q_us = $this->datahis_us; }
				else{ $_q_us = 3; }

				$__enc = Enc_Rnd($_p['tp'].'-'.$_p['id'].'-'.$_p['f']);
				if(!isN($_p['bd'])){ $_bd = $_p['bd']; }else{ $_bd = $this->bd; }

				$insertSQL = sprintf("INSERT INTO ".$_bd.TB_DATA_HIS ." (datahis_enc, datahis_tp, datahis_id, datahis_f, datahis_v, datahis_us) VALUES (%s, %s, %s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($_p['tp'], "text"),
							GtSQLVlStr($_p['id'], "text"),
							GtSQLVlStr($_p['f'], "text"),
							GtSQLVlStr(ctjTx($_p['v'],'out'), "text"),
							GtSQLVlStr($_q_us, "int"));

				if(!isN($insertSQL)){
		            $_ntry = 0;
					do{ $Result_IN = $__cnx->_prc($insertSQL); $_ntry++; if($Result_IN){ break; } } while($_ntry == $this->n_try);
		        }


				if($Result_IN){
					$r['e'] = 'ok';
				}else{
					$r['w'] = $__cnx->c_p->error;
				}

			}

			return(_jEnc($r));

		}

		public function _inp_tx($p=NULL){	//$_id=NULL, $_plc=NULL, $_vl=NULL, $_rq=NULL, $_mr=NULL, $_cls=NULL, $_mx=NULL, $_auc=NULL, $_rel=NULL

			if(!isN($p['rq'])){ $__cls .= $p['rq'].' '; }
			if(!isN($p['cls'])){ $__cls .= $p['cls'].' '; }

			if(!isN($p['rel'])){ $__rel =  ' rel="'.$p['rel'].'" '; }
			if($p['mx']!=NULL){ $_mxln = 'maxlength="'.$p['mx'].'"'; }
			if($p['auc']!=NULL){ $_autoc = 'autocomplete="'.$p['auc'].'"'; }
			if($p['vl']!=NULL && $p['ph']!=NULL){ $_ph = '<label for="'.$p['id'].'" '.$__cls.' '.$__rel.'>'.$p['ph'].'</label>'; }


			$_r .= '<div class="___txar _anm">'.
						'<input name="'.$p['id'].'" class="'.$__cls.'" '.$__rel.' '.$_autoc.' type="text" id="'.$p['id'].'" '.HTML_attr([ 'a'=>$p['attr'] ]).' placeholder="'.$p['ph'].'" value="'.$p['vl'].'" ' . $_mxln .' '.$_mr.' />
						'. $_ph .'
					</div>';
			return($_r);
		}


		public function _ntf_on(){

			$_id = 'ntf_callto_';
			$this->js .= " SUMR_Push._NtfCallTo_Btn({ id:'".$_id.$this->id_rnd."', rnd:'".$this->id_rnd."' }); ";
			echo '<div id="'.$_id.$this->id_rnd.'"></div>';

		}


	}
?>