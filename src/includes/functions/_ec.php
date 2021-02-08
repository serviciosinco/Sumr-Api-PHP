<?php
	
	
	
	
	
	function DelEcLstsAuto($_p=NULL){
		
		global $__cnx;
		
		if($_p['lsts'] != NULL){
				
			$deleteSQL = sprintf('DELETE FROM ec_lsts_auto WHERE eclstsauto_eclsts=%s', GtSQLVlStr($_p['lsts'], 'int'));
			$Result1 = $__cnx->_prc($deleteSQL);
			
			if($Result1){ 
				$Vl['e'] = 'ok';
			}else{ 
				$Vl['e'] = false; 
				$Vl['w'] = $__cnx->c_p->error; 
			}
			
		}else{
			$Vl['e'] = false;
		}
		
		$rtrn = json_decode(json_encode($Vl));
		return($rtrn);
	}
	
	function _ecimg_u($_v=NULL){

		$_u_c = explode('?', $_v['u']);
		$_u_m = $_v['m1'];
		
		if($_u_c[1] != ''){ 
			$__u_r = $_v['u'].'&'.$_u_m; 
		}else{ 
			$__u_r = $_v['u'].'?'.$_u_m;  
		}
		return $__u_r;
	}
	
	function _ecimg($_p = NULL){
		

		if($_p['bd'] != '' && $_p['bd'] != NULL){
			
			$__dtec = GtEcDt($_p['i'], 'enc');
			$browser = new Browser();
			
			if($__dtec->id != NULL){
				
				if($_p['cnt'] == 'Ml'){ 
					$Cd_Cntc= DMN_EC.PrmLnk('bld', $__dtec->pml).'?'.DMN_EC_C; 
					$Cd_Lnk = _ecimg_u(array('u'=>$__dtec->lnk, 'm1'=>'_s='.$_p['enc'] )); 
				}else{
					$Cd_Cntc='javascript:__cnt(\''.$__dtec->enc.'\', \''. $__dtec->eml .'\',\''. $__dtec->tt .'\'); '; 
					if(($browser->getBrowser() == 'Internet Explorer') && ($browser->getVersion() < 9)){
						$Cd_Lnk = $__dtec->lnk.'&'.$_p['enc'];
					}else{
						$Cd_Lnk = 'javascript:__lnk("'.urlencode($__dtec->lnk).'"); ';
					}
				}
					
				$doc = new DOMDocument();
				$doc->loadHTML(mb_convert_encoding($_p['bd'], 'HTML-ENTITIES', 'UTF-8'));
				$tags = $doc->getElementsByTagName('img');
				foreach ($tags as $tag) {
					$old_src = $tag->getAttribute('src');
					$new_src_url = DMN_FLE_EC_HTML.$_p['fld'].'/'.$old_src;
					if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
						$tag->setAttribute('src', $new_src_url);
					}
				}
				
				$__go = $doc->saveHTML();
				$Sch_2 = array('.jpg', '.gif', 'SvCntc', 'SvLnk', '<td><img' , '<td colspan="2"><img','<br />');
				$Chn_2 = array('.jpg?Rnd='.Gn_Rnd(5), '.gif?Rnd='.Gn_Rnd(5), $Cd_Cntc, $Cd_Lnk, '<td style="line-height:1px;"><img' , '<td style="line-height:1px;" colspan="2"><img','');
				$Lnk_2 = str_replace($Sch_2,$Chn_2,$__go);
				$Md = str_replace('valign="top"', '  ', $Lnk_2);
				$Md = str_replace('display: inline-table;', 'display: inline-table; cellpadding:0px; cellspacing:0px; border-style: hidden; border-collapse:collapse; line-height:1px;', $Md);
				$Md = str_replace('<img', '<img style="display:block;" border="0" ', $Md);
				$Md = str_replace('<br />', '', $Md);
				$Md = str_replace('<td', '<td valign="top" ', $Md);
				$Md = str_replace('/>td>', '/></td>', $Md);
			
			
				
				return ($Md);
			}
			
		}
		
	}
	

	
	function _SveEcImg($_p=NULL){
		
		try{
			
			if($_p['id'] != NULL){
				
				$url = DMN_GOO.'save/ec/'.$_p['id'].'/?rnd='.Enc_Rnd();
				$_v['url'] = $url;
				
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
				
				$__c_r = json_decode( curl_exec($ch) ); print_r( $__c_r);
				curl_close($ch);
				
				_SveEcImg_iFo([ 'id'=>$_p['id'] ]);
				
				if($__c_r->e == 'ok'){
					$_v['e'] = 'ok';
				}
					
				//$__Srv = new API_CRM_Cdn();
				//$__Srv_r = $__Srv->_CFR_Prg([ 'f'=>[$__c_r->process->thumb->url->th, $__c_r->process->thumb->url->bg] ]);
				
				if(!isN($__Srv_r->id)){
					$_v['cche']['e'] = 'ok';
					$_v['cche']['i'] = $__Srv_r->id;
				}
				
			}else{
				
				$_v['e'] = 'no';
				$_v['w'] = 'No envia ID';		
				
			}
			
		}catch (Exception $e) {
			$_v['e'] = 'no';
		    $_v['w'] = $e->getMessage();
		}
		
		return _jEnc($_v);
	}
	
	
	
	function _SveEcImg_iFo($_p=NULL){
		
		try{
			if($_p['id'] != NULL){
				$url = DMN_EC.LNK_HTML.'/'.$_p['id'].'/?__l=ok&__edit=ok';
				 
				$_v['url'] = $url;
				
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
				curl_setopt($ch, CURLOPT_TIMEOUT, 60);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$__c_r = json_decode( curl_exec($ch) );
				curl_close($ch);
				
				if($__c_r->e == 'ok'){
					$_v['e'] = 'ok';
				}
			}else{
				$_v['e'] = 'no';
				$_v['w'] = 'No envia ID';		
			}
		}catch (Exception $e) {
			$_v['e'] = 'no';
		    $_v['w'] = $e->getMessage();
		}
		
		return _jEnc($_v);
	}
	
	
	
	function _GtDfVleEcLstAuto($obj, $key, $chk){
		if($obj != '' && $key != ''){
			foreach($obj AS $_v){
				if($_v->cpo == $key){
					if($chk != 'ok'){
						$_df = $_v->cnd;
					}else{
						$_df = $_v->chk;
					}
				}else{
					if($chk == 'ok' && $_df == ''){
						$_df = 1;
					}
				}
			}
			return $_df;
		}		
	}
	
	
	function __EcLstsAuto_Flt_Bx($_p=NULL){
		
		$__bx = '<div class="_fop">
				    <div class="_fld">'.$_p['f'].'</div>	
					<div class="_chk">'.$_p['c'].'</div>	
				 </div>';
		return $__bx;
		
	}
	
	
	function _SpclChng($t=NULL){

		if(!isN($t)){
			
			$_s = array('<div></div>', 'MsoNormal', '\n', 'class="table table-bordered"');
			$_c = array('<br>', '', '');
			$t = str_replace($_s, $_c, $t);
			
			$_s = array('<div>','</div>', /*'<p', '/p>'*/);
			$_c = array('<span style="width:100%;display:block;">','</span>', /*'<span', '/span>'*/);
			$t = str_replace($_s, $_c, $t);
			
		}

		return $t;
	}
	
	
	function _EcCln($v=NULL){
		
		$_v['domp'] = $v;
		
		if(!isN($v['cod'])){
			
			$_ec_bld = new API_CRM_ec();
			//$_ec_bld->btrck = 'ok';
			$_ec_html = $_ec_bld->_GtNLn([ 'v'=>$v['cod'], 'bsc'=>'ok', 'tags'=>['img'], 'pst'=>$v['pst'], 'no_mso'=>$v['no_mso'] ]); 
			
			$_breaks_1 = array("\r\n");
			$_breaks_2 = array("\n");
			$_breaks_3 = array("\r");
			
			$_v['dom'] = $_ec_html;
			
			if(!isN($_ec_html->cod)){
				
				$__b1 = str_replace($_breaks_1, '</br>', $_ec_html->cod);
				$__b1 = str_replace($_breaks_2, '', $__b1);
				$__b1 = str_replace($_breaks_3, '&nbsp;', $__b1);
				$_v['cod'] = $__b1;
							 
			}
			
			$_v['e'] = 'ok';
			
		}else{
			
			$_v['e'] = 'no';
			
		}
		
		$_r = json_decode(json_encode($_v));
		return $_r;
		
	} 
	
?>