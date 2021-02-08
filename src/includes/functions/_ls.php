<?php 
	function __SchCd($Cmp='', $t=''){
		$Vl = Php_Ls_Cln($_GET[GT_SCH]);
		if (($Cmp !='')&&($Vl != ''))  {
			Aud_Sis(Aud_GtUs(), Aud_Dsc(41, $Vl), Aud_GtUsId());
			
			if($t==2){$_u = ' AND ';}else{$_u = ' WHERE ';}	
			$schGt = strtolower(MyMn(ctjTx($Vl,'in'))); 
			$schBsc = explode("*.",$schGt);
			$schBsc_2 = implode("%", $schBsc);
			$schBsc_sh = implode(" ", $schBsc);		
			$Flds = explode(',',$Cmp);
			$Flds_Tot = count($Flds);		
			for ($i = 0; $i <= $Flds_Tot; $i++) {
				$Nm = $i+1;
				if($Flds[$i] != ''){
						$Flds_Cd .= "(lower(".$Flds[$i].") LIKE '%".$schBsc_2."%')";
						$Cnct_Cd .= "lower(".$Flds[$i].")";
					if($Nm < $Flds_Tot){
						$Flds_Cd .=	" || ";
						$Cnct_Cd .=	",' ',";
					}
				}
			}
			$f_cnct = "(CONCAT(".$Cnct_Cd."))";
			$f_busq = $_u." (".$Flds_Cd." || (".$f_cnct." LIKE '%".$schBsc_2."%'))";
			return($f_busq);
		}
	}
	
	function HTML_Ls_Nr($_i){
		if ($_i == 0) {	$_r = '<div class="n_r">'.TX_NR.'</div>'; }else{ return false; exit;} return($_r);
	}
	
	function HTML_Ls_TpPr($Cn){
		if(($Cn != "")){$TxPr = TX_EDIT;}else{$TxPr = TX_NW;}
		return ' ('.Spn($TxPr).') ';
	}

	function HTML_Ls_Chck($_o , $_p=NULL, $_r=NULL, $_tot=NULL){
		if(GtSQLVlStr($_p, 'text')){ $_p2 = $_p;}
		if(GtSQLVlStr($_r, 'int')){ $_r2 = $_r; }
		
		if($_o == 'f'){
			if (($_p2 == "Dt") &&	($_r2!="")	&&	($_tot > 0) or ($_p2 == "Ing")) { return true; }else{ return false;}
		}elseif($_o == 'l'){
			if (($_tot == 0) && ($_p != 'Ing')){ return true; }else{ return false;}
		}else{
			return false;
		}
	}
	
		
	function HTML_Ls_Hdr_OLD($p=NULL){
		
		$___Ls = new CRM_Ls();
		$__flt_dt = $___Ls->_f_chk([ 't'=>Php_Ls_Cln($_GET['_t']), 't2'=>Php_Ls_Cln($_GET['_t2']) ]); 
		
		$_i_prfx = '_'.Gn_Rnd(10);
		$_s = 'Sch_Cnt'; //  Nombre de Input
		$_sch = _GPJ(['j'=>$__flt_dt->f,'v'=>GT_SCH ]);
		
		if(!isN($__mre['cls'])){ $___mre = $__mre['cls']; }else{ $___mre = ''; }
		
		if($p['tt'] != '' && $p['lssb'] != 'ok'){
			if($p['lssb'] != 'ok'){	 
					$_t = h2(TX_LSDE.' '.Spn($p['tt']), $p['tt_cls']);	
					if(!isN($p['tot']) && is_numeric($p['tot'])){ 
							$_t .= ' '.Spn( number_format($p['tot'], 0, '.', ',') ,'ok','_n'); 
					}
			}
			$_idbt = BTN_INRG.$_i_prfx;
			$_idup = BTN_UPL.$_i_prfx;
			$_ttbt = BTN_TX_NW; 
		}elseif($p['tt_sb'] != ''){
			$_t = h2($p['tt_sb'], $p['tt_cls']);	
			$_idbt = BTN_INRG.('_'.DV_SBCNT).$_i_prfx;
			$_ttbt = BTN_TX_NWSB;
		}else{ 
			$_idbt = BTN_INRG.('_'.DV_SBCNT).$_i_prfx;
			$_ttbt = BTN_TX_NWSB; 
		} 
		
		if(($p['tt'] != '' && $p['lssb'] != 'ok' && $p['sch'] == 'ok') || ($p['sch_e'] == 'ok')){ 
			
				$_c .= '<div class="sch">'.Inp_Sch([ 'v'=>$_sch, 'n'=>$_s, 'prfx'=>$_i_prfx ]) .	
							SchLs([
								'l'=>$p['ls'], 
								'inp'=>$_s, 
								'vl'=>$_sch, 
								'mre'=>__t($p['tp']).$p['othg'].TXGN_BX.$p['bxr'],
								'prfx'=>$_i_prfx,
								'bxr'=>$p['bxr'],
								'__i'=>$p['__i']
							]).	
						'</div>'; 
		}
		
		if($p['inf'] != '' || $p['inf_o'] != ''){ 
			$_c .= '<div class="inf">'.BtnInf().'</div>'; 
			$_inf_b = BTN_INF; 
			
			if(!isN($p['inf_o'])){ $__inf_u = $p['inf_o']; }else{ $__inf_u = FL_FM_GN.'?'.__t($p['tp']); }
			if(!isN($p['inf_s'])){ $__inf_s_w = $p['inf_s'][0]; $__inf_s_h = $p['inf_s'][1]; }else{ $__inf_s_w = '90%'; $__inf_s_h = '90%'; }
			$_inf_f = '$.colorbox({  width:"'.$__inf_s_w.'", height:"'.$__inf_s_h.'", trapFocus:false, iframe:false, href:"'.$__inf_u.'&__rnd="+Math.random() });'; 
		}
		
		if($p['up'] != ''){ 
			$_up .= "$.colorbox({href:\"".HTML_ClrBxImg($p['tp'], 'nw')."\", width:\"400px;\", trapFocus:false, height:\"500px\", transition:\"elastic\", overlayClose:false, escKey:false, onClosed:function(){ }}); "; 
		}
		
		if(_ChckMd($p['tp'].'_ing') || _ChckMd($p['tpg'].'_ing') || ($p['md_ing'] == true) || ChckSESS_superadm()){ 
				$_c .=	BtnInRg($_idbt,$_ttbt); 
		}
		
		if((_ChckMd($p['tp'].'_mod') || _ChckMd($p['tpg'].'_mod') || ($p['md_mod'] == true) || _ChckMd($__tp.'_upl') || ChckSESS_superadm()) && ($p['up'] != '')){ 
				$_c .=	BtnUpl($_idup); 
		}
		
		$_r .=  '<div class="'.ID_HDRLS.' '.$___mre.'" id="'.ID_HDRLS.'_'.strtoupper($p['tp']).'">'.$_t.'<div class="btn">'.$_c.'</div><script type="text/javascript"> '. __BtnFnc($_idbt, $p['in']). __BtnFnc($_inf_b, $_inf_f) . __BtnFnc($_idup, $_up) .' </script></div>';
		
		return($_r);
	}
	
	
	// BORRAR AL MIGRAR TODO
	
	function HTML_Fm_Hdr__OLD($_in=NULL, $_tot=NULL, $_im=NULL, $_fim=NULL, $_tt=NULL, $_bvl=NULL, $_p=NULL, $_r=NULL, $_sb=NULL, $_t=NULL, $_t_m=NULL, $_myprfx=NULL, $__ing=false, $__mod=false, $__pop=NULL, $__tpg=NULL, $__rfr=NULL, $p=NULL){
		
		if(GtSQLVlStr($_p, 'text')){ $_p2 = $_p; }
		if(GtSQLVlStr($_r, 'int')){ $_r2 = $_r; }
		
		if($__pop == 'ok'){ $_r_html_pop = '<div id="_m_ldr_pop" class="_m_ldr_pop" style="display:none;"></div> '; }
		
		$__blimg = json_decode(BlImg($_im, TPIMG_TH, $_fim, '../../', 1));
		$__v['js'] .= ClBx('',SIS_CLRBX_IMG_W,SIS_CLRBX_IMG_H,'','cd').';';
		
		if(($_in == 'si')&&($_tot > 0)){ $__r .= '<div class="img">'.$__blimg->img.'</div>';	}     
        
		if(!isN($_tt)){ 
			if($_sb != 'ok' || $p['bck']=='ok'){ $_r_vlv = '<a href="'.$_bvl.'" class="_bck">'.Spn('','','_icn').Spn(TX_VLVLSDE,'','_t').' '.ShortTx($_tt,80).'</a>'; }
			if(!isN($_t_m)){ $_r_mrett = ' '.Spn($_t_m); }
			$__r .= h2( ShortTx($_tt, 60, 'Pt', true) . $_r_mrett . HTML_Ls_TpPr($_r2). '<br>'.$_r_vlv );	
		}
		
		if(!isN($_myprfx)){ $_prfx .= $_myprfx; } 
        if($_sb == 'ok' || $__pop == 'ok'){ $_prfx .= DV_SBCNT; }
		
		
		if(ChckSESS_adm() || _ChckMd($_t.'_eli') || _ChckMd($_t.'_ing') || _ChckMd($_t.'_mod') || _ChckMd($__tpg.'_ing') || _ChckMd($__tpg.'_mod') || $__ing || $__mod){ 
			$__r .= '<div class="btn">';
				
				if(!isN($p['btnx'])){ $__r .= $p['btnx']['html']; $__v['js'] .= $p['btnx']['js']; }
			
			if(_ChckMd($_t.'_mod') || _ChckMd($_t.'_ing') || _ChckMd($__tpg.'_mod') || _ChckMd($__tpg.'_ing') || ($__ing) || ($__mod)){
					

					/*if($__rfr == 'ok'){*/ $__r .= '<div class="___rfrsh"><input id="'.ID_BTNRFR.$_t.$_prfx.'" name="'.ID_BTNRFR.$_t.$_prfx.'" type="button" class="btn_upd_view _anm" value="Actualizar"> </div>'; /*}*/
					
					
					if(!isN($_tt) && !isN($_tt) && $_sb != 'ok'){ $__grdr_tt = TXBT_GRDR; }else{ $__grdr_icn = 'icn_grd'; $_sve_tx = Spn(TXBT_GRDR); }
					$__r .= '<div class="___edt"><input id="'.ID_BTNSVE.$_t.$_prfx.'" name="'.ID_BTNSVE.$_t.$_prfx.'" type="button" class="s grd_blue '.$__grdr_icn.'" value="'.$__grdr_tt.'" '; 
					
					
					//if(HTML_Ls_Chck('f', $_p2, $_r2)){$__r .= HTML_Fm_Cnf(array('tp'=>'ed'));}else{$__r .= HTML_Fm_Cnf(array('tp'=>'in'));}	
					$__r .= '/>'.$_sve_tx.'</div>';

			}
			
			if (($_tot > 0) && (_ChckMd($_t.'_eli') || _ChckMd($__tpg.'_eli') || ($__ing) )) {	
				$__r .= '<input type="button" name="but_eli'.$_prfx.'" id="but_eli'.$_prfx.'" class="c grd_gray" value="'.TXBT_BRR.'"  />'; }
			$__r .= '</div>';
		}
		
		$_r_html .= '<div class="'.ID_HDRLS.'" id="'.ID_HDRLS.'_'.strtoupper( $_t ).'">'. $_r_html_pop.$__r.'</div>';  

		$__v['html'] = $_r_html;
		//$___r = json_encode($__v);
		$___r = _jEnc($__v);
		return($___r);
	}	
	
	
	function HTML_Fm_Cnf($p=NULL){ if (($p['tp']!="")) { $Var1 = "onClick='return SUMR_Main.btn_sve_c({tp:\"".$p['tp']."\"})'"; }return $Var1;} 
	
	function HTML_Fm_Del($_id=NULL, $_i=NULL, $_prc=NULL, $_nm=NULL, $p=NULL){
		$_r = '<form action="'.$_prc.'" method="POST" name="'.$_nm.'El" target="_self" id="'.$_nm.'El">';
		$_r .=			'<input name="MM_delete" type="hidden" id="MM_delete" value="'.$_nm.'" />	';
		$_r .= 			'<input name="'.$_id.'" type="hidden" id="'.$_id.'" value="'.$_i.'" />';
		if($p['key'] != NULL){ $_r .= 			'<input name="___key" type="hidden" id="___key" value="'.$p['key'].'" />'; }
		
		if($p['f1'] != NULL){
			$_r .= 			'<input name="'.$p['f1'].'" type="hidden" id="'.$p['f1'].'" value="'.$p['f1_v'].'" />';
		}
		
		$_r .=	' </form>';
		return($_r);
	}  
	
	function HTML_Fm_MMFM($_id=NULL, $_i=NULL, $_tot=NULL, $_nm=NULL){
		 $_r = '<input name="'.$_id.'" type="hidden" id="'.$_id.'" value="'.$_i.'" />';                     
		 if ($_tot > 0) { $_r .= '<input type="hidden" name="MM_update" value="'.$_nm.'" />';  }
         if ($_tot == 0) { $_r .= '<input type="hidden" name="MM_insert" value="'.$_nm.'" />';  }
		 return($_r);
	}
	
	function HTML_ClrBxImg($_b, $t=NULL){
		if($t=='nw'){$_t=TXGN_UPLNW;}else{$_t=TXGN_UPL;}
		$_r = FL_FM_GN.'?'.$_t.'_t2='.$_b.'&_i=';
		return($_r);
	}
	
	function _Ls_Lnk_Rw($p=NULL){
		if($p['sb'] == 'ok'){
			if(isMobile()){ $_wd_nw = '95%'; $_hg_nw = '95%'; }else{ if($p['w'] != NULL){ $_wd_nw = $p['w']; }else{ $_wd_nw = CLRBX_WD_POP;} if($p['h'] != null){ $_hg_nw = $p['h']; }else{ $_hg_nw = '90%'; } }
			if($p['jv'] != 'no'){$__jv = 'javascript:'; }
			
			if($p['scrl']!='ok'){ $__scrl = ", scrl:'".$p['scrl']."'"; }
			
			$_r = $__jv."_ldCnt({ u:'".$p['l'].TXGN_POP."', c:'".$p['r']."', pop:'ok', w:'".$_wd_nw."', h:'".$_hg_nw."' ".$__scrl." });";
			
		}else{
			$_r = JQ__ldCnt([ 'u'=>$p['l'], 'c'=>$p['r'], 'p'=>$p['p'], 'js'=>$p['j'] ]);
		}
		return($_r);
	}
	
	function _Rsm_Cmp($_p=NULL){
		if(ChckSESS_superadm() && defined('SISUS_ID') && ((SISUS_ID == 1) || (SISUS_ID == 24))){
				
				$__id = '_fltr_box_'.Gn_Rnd(3);
				
				$_h .= '<section class="_lsprvt">
						<div id="'.$__id.'" class="CollapsiblePanel">
						<div class="CollapsiblePanelTab" tabindex="0">'.TX_PRVT.'</div>
						<div class="CollapsiblePanelContent">';
						
						
							$_h .= '<div class="_admin_pay">';
							$_h .=  h2(TX_DTSSVIN);
							$_h .= '<div class="col col1">'.Strn(TX_PRPGR).cnVlrMon('', $_p['nopay']).'</div>';
							$_h .= '<div class="col col2">'.Strn(TX_PGD.Spn(TX_SVIN, 'ok')).cnVlrMon('', $_p['gstd']).'</div>';
							$_h .= '<div class="col col3">';
							   
									if($_p['nopay'] > 0){ $__rntbl = ($_p['nopay']-$_p['gstd'])/$_p['nopay']*100; } 
									if($__rntbl < 60 ){ $__spn_rnt = 'no'; }else{ $__spn_rnt = 'ok'; }
									
							$_h .= Strn(TX_PRRNT).Spn(_Nmb($__rntbl, 1),'',$__spn_rnt);     
							$_h .= '</div>';
							$_h .= '<div class="col col4">'; 
							  
									$__cmssvin = (($_p['nopay']-$_p['gstd'])*9)/100; 
									
							$_h .= Strn(TX_CMSNS).cnVlrMon('', $__cmssvin);
							$_h .= '</div>';
							$_h .= '</div>';
							
       			$_h .= '</div>
        				</div>
						</div>
						</section>';
				
				$_js = "var ".$__id." = new Spry.Widget.CollapsiblePanel('".$__id."', {contentIsOpen:false });";		
				
				$_v['html'] = $_h;
				$_v['js'] = $_js;
				 
				$rtrn = json_encode($_v);
				return($rtrn); 
	    }
	}
	
	function HTML_Ls_Btn($_p=NULL){
		
		if($_p['t'] == 'edt'){ 
			$_r_b = 'ls_edt.svg'; $_r_t = TX_EDT; 
		}elseif($_p['t'] == 'pgs'){ 
			$_r_b = 'ls_pgs.svg'; $_r_t = TX_CTZC; 
		}elseif($_p['t'] == 'rss'){ 
			$_r_b = 'ls_rss.svg'; $_r_t = TX_CDFC; 
		}elseif($_p['t'] == 'onl'){ 
			$_r_b = 'ls_onl.svg'; $_r_t = TX_ONLN; 
		}elseif($_p['t'] == 'md'){ 
			$_r_b = 'ls_md.svg'; $_r_t = TX_INFRM; 
		}elseif($_p['t'] == 'dwn'){ 
			$_r_b = 'ls_dwn.svg'; $_r_t = TX_DWNL; 
		}elseif($_p['t'] == 'rpr'){ 
			$_r_b = 'ls_rpr.svg'; $_r_t = TX_SND; 
		}elseif($_p['t'] == 'outl'){ 
			$_r_b = 'ls_outl.svg'; $_r_t = TT_FM_EML; 
		}elseif($_p['t'] == 'up'){ 
			$_r_b = 'ls_up.svg'; $_r_t = TT_FM_UP; 
		}elseif($_p['t'] == 'strt'){ 
			$_r_b = 'ls_play.svg'; $_r_t = 'play'; 
		}elseif($_p['t'] == 'psd'){ 
			$_r_b = 'ls_pause.svg'; $_r_t = TX_PS; 
		}elseif($_p['t'] == 'mdl_cnt'){ 
			$_r_b = 'cnt_lead.svg'; $_r_t = TX_PS; 
		}elseif($_p['t'] == 'inf'){ 
			$_r_b = 'ls_inf.svg'; $_r_t = TX_INFRM; 
		}elseif($_p['t'] == 'dtl'){ 
			$_r_b = 'ls_detail.svg'; $_r_t = TX_DTLL; 
		}elseif($_p['t'] == 'dsgn'){ 
			$_r_b = 'ec_edt.svg'; $_r_t = 'diseño'; 
		}elseif($_p['t'] == 'cmnt'){ 
			$_r_b = 'ec_cmnt.png'; $_r_t = 'comentarios'; 
		}elseif($_p['t'] == 'aprb'){ 
			$_r_b = 'ec_checked.svg'; $_r_t = 'aprobación';
		}elseif($_p['t'] == 'no_aprb'){ 
			$_r_b = 'ec_checked_no.svg'; $_r_t = 'no aprobado';
		}elseif($_p['t'] == 'aprb_sg'){ 
			$_r_b = 'ec_checked_sg.svg'; $_r_t = 'aprobación';
		}elseif($_p['t'] == 'eli'){ 
			$_r_b = 'delete.svg'; $_r_t = 'Eliminar';
		}elseif($_p['t'] == 'rote'){ 
			$_r_b = 'rotate.svg'; $_r_t = 'Rotar';
		}
		
		if($_p['id'] != ''){ $_r_id = ' id="'.$_p['id'].'" '; }
		if($_p['js'] == 'ok'){ $_r_js = 'javascript:'; }
		if($_p['trg'] != NULL){ $_r_trg = ' target="'.$_p['trg'].'" '; }
		if($_p['rel'] != NULL){ $_r_rel = ' rel="'.$_p['rel'].'" '; }
		
		if($_p['trg'] != '_blank'  && ($_p['cls'] == '' || $_p['cls'] == NULL)){ 
			$__lnk_a = ' href="'.Void().'" onclick="'.$_r_js.$_p['l'].'" '; 
		}elseif($_p['jq'] == 'ok'){ 
			$__lnk_a = ' href="'.Void().'" '; 
		}else{
			$__lnk_a = ' href="'.$_r_js.$_p['l'].'" '; 
		}
		
		if(!isN($_p['attr'])){ 
			foreach($_p['attr'] as $_attr_k=>$_attr_v){
				$__attr = $_attr_k.'='.$_attr_v;
			}
		}
		
		
		$_r = '<a '.$__lnk_a.' '.$_r_id.' class="ls_btn '.$_p['cls'].'" '.$_r_trg.$_r_rel.' '.$__attr.' style="background-image:url('.DMN_IMG_ESTR_SVG.$_r_b.');" ><span>'.$_r_t.'</span></a>';
		return($_r);
	}
	
	
	function __Ls_Chk_Icn($p=NULL){		
						  
		$_url_dt = FL_LS_GN.'?'.__t('mdl_cnt').ADM_LNK_DTVW.ADM_LNK_DT.$p['d']['mdlcnt_enc'];	
		
		if($p['d']['mdlcnt_gen']>1){ 
			$__gtgendt = GtMdlGenDt( 'pro', $p['d']['mdlcnt_gen']); 
			$nm_gen= Spn( '  ('.$__gtgendt->tt.')','','_f');
			$_h .= '<li title="'.TX_VLVLLR.'"> '._Cnt_G($p['d']['mdlcnt_gen'], $nm_gen).' </li>';
		}else{
			$nm_gen='';
		}
					
		if( $p['d']['___img'] != NULL ){
			$_h .= '<li > <a href="'.$p['d']['___img'].'" class="_dt3 chk_icn pht _anm" style="background-image:url('.$p['d']['___img'].');"></a> </li>';
		}
									   				   
		if( $p['d']['mdlcnt_chk_vll'] == 1 ){
			$_h .= '<li title="'.TX_VLVLLR.'"> <a href="'.$_url_dt.'" class="_dt2 chk_icn vll _anm"></a> </li>';
		}
		if( $p['d']['mdlcnt_chk_pin'] == 1 ){
			$_h .= '<li title="'.TX_CHK_PIN.'">'.Spn('','',' chk_icn pin').'</li>';
		}
		if( $p['d']['mdlcnt_chk_rvp'] == 1 ){
			$_h .= '<li title="'.TX_CHK_RVP.'">'.Spn('','',' chk_icn rvp').'</li>';
		}
		if( $p['d']['mdlcnt_chk_ner'] == 1 ){
			$_h .= '<li title="'.TX_CHK_NER.'">'.Spn('','',' chk_icn ner').'</li>';
		}
		if( $p['d']['mdlcnt_chk_spp'] == 1 ){
			$_h .= '<li title="'.TX_CHK_SPP.'">'.Spn('','',' chk_icn spp').'</li>';
		}
		if( $p['d']['mdlcnt_imk_svd'] == 2 && $p['tp'] != 'con'){
			$_h .= '<li title="'.TX_PNDIMMKT.'">'.Spn('','',' chk_icn imk').'</li>';
		}
		
		if(!isN($p['d']['__cnttp'])){
			
			$__tpcnt = json_decode($p['d']['__cnttp']);
			
			foreach ($__tpcnt as $k) {	
				if( $k->id != 7 ){
					$_h .= '<li title="'. ctjTx($k->tt,'in') .'">'.Spn('','',' chk_icn cnttp', 'background-color:'.$k->clr.'; background-image:url('.DB_CL_LGO.')').'</li>';
				}
			}
		}
				
		if(!isN($_h) || !isN($p['mre'])){
			return('<ul class="__cnk">'.$_h.$p['mre'].'</ul>');
		}
	}
	
?>