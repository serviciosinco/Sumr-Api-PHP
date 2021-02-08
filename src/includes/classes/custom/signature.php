<?php  	
class API_CRM_sgn{
	
	private $key='74b830af515a1000af241f0df00e83c1816fbd04';

	public function __construct(){	
     	
     	
    }

	public function _bld(){
		$this->_FxC();	
		$this->_Sgm();
		return $this->__cod_nw;						
	}
	
	public function _bld_s(){
		$this->_FxC();
		$this->_Sgm_vst();
		return $this->__cod_nw;						
	}
	
	//Direccion de Imagenes
	public function _FxC($_p=NULL){
		
		$browser = new Browser();

		if($this->id_sgn != NULL){
			
			
			$doc = new DOMDocument('1.0', 'UTF-8');
			$doc->recover = true;
			$doc->strictErrorChecking = false;
			@$doc->loadHTML(mb_convert_encoding($this->sgn_cd, 'HTML-ENTITIES', 'UTF-8'));
			
			
			
			// Obtener Etiquetas IMG
			$tags = $doc->getElementsByTagName('img');
			foreach ($tags as $tag) {
				$old_src = $tag->getAttribute('src');
				$new_src_url = DMN_SGN.'fl/'.$this->sgn_fl.'/'.$old_src;
				if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
					$tag->setAttribute('src', $new_src_url);
					
				}
			}
			
			
			$this->__cod_src = $doc->saveHTML();
			$Lnk_2 = $this->__cod_src;
			
			$Md = str_replace('display: inline-table;', 'display: inline-table; cellpadding:0px; cellspacing:0px; border-style: hidden; border-collapse:collapse; line-height:1px;', $Lnk_2);
			$Md = str_replace('<img', '<img style="display:block;" border="0" ', $Md);
			$Md = str_replace('<br />', '', $Md);
			$Md = str_replace('/>td>', '/></td>', $Md);
		}
		
		$this->__cod_nw = $Md;
	}

	private function _Sgm(){
		
		$__sgm = __LsDt([ 'k'=>'sgm' ]);
		
		$r .= $this->__cod_nw;
		$__cod_c = $this->__cod_nw;
		
		foreach($__sgm->ls->sgm as $_k => $_v){	
			$_s_acrt[$_v->id] = $_v->key->vl;
			$_c_acrt[$_v->id] = '<div id="'.$_v->id.'" class="_c_p"> 
										<div class="_tt val_0">'.$_v->tt.'</div>
								</div>';		
		}
				
		$r = str_replace($_s_acrt,$_c_acrt, $__cod_c);

		$this->__dtsgn = GtSgnSgmLs($this->sgn_cod,'enc');

		if($this->__dtsgn){
			foreach($this->__dtsgn as $_k => $_v){
			
				$r = str_replace($_c_acrt[$_k], '<div class="_c_p" id="'.ctjTx($_k,'out','',array('html'=>'ok')).'"> 
														<div class="_tt val_1">'.$_v->tt.'</div>
												 </div>', $r);	
							
			}	
		}

		$this->__cod_nw = $r.$this->__dtsgn->val;		
	}
	
	private function _Sgm_vst(){
		
		$__sgm = __LsDt(array('k'=>'sgm'));
		
		$r .= $this->__cod_nw;
		$__cod_c = $this->__cod_nw;
		
		foreach($__sgm->ls->sgm as $_k => $_v){

			
				$_s_acrt[$_v->id] = $_v->key->vl;
				$_c_acrt[$_v->id] = '<div id="'.$_v->id.'" class=""> 
											<div class="val_0"></div>
									</div>';
					
		}
				
		$r = str_replace($_s_acrt,$_c_acrt, $__cod_c);

		$this->__dtsgn = GtSgnSgmLs($this->sgn_cod,'enc');
		
	
		if($this->__dtsgn){
			foreach($this->__dtsgn as $_k => $_v){
			
				if($_k == 487){ $a = '<a style="text-decoration: none;color: black;" href="mailto:'.$_v->tt.'">'.$_v->tt.'</a>'; }
				elseif($_k == 488 || $_k == 491){ $a = '<a style="text-decoration: none;color: black;" href="tel:'.$_v->tt.'">'.$_v->tt.'</a>';  }
				elseif($_k == 490){ $a = '<a style="text-decoration: none;color: black;" target="_blank" href="http://'.$_v->tt.'">'.$_v->tt.'</a>';  }
				else{ $a = $_v->tt; }
				
				$r = str_replace($_c_acrt[$_k], '<div class="" id="'.ctjTx($_k,'out','',array('html'=>'ok')).'"> 
														<div class="val_1">'.$a.'</div>
												 </div>', $r);	
							
			}	
		}

		$this->__cod_nw = $r;		
	}
	
		
	public function _SgnSve(){
		
		global $__cnx;
		
		if($this->sgn_dir != NULL){ $_dir = $this->sgn_dir; }else{ $_dir = SIS_Y.'_'.Gn_Rnd(10); }
		
		$insertSQL = sprintf("INSERT INTO sgn (sgn_enc, sgn_est, sgn_tt, sgn_cd, sgn_dir, sgn_fi) VALUES (%s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr(enCad($_dir), "text"),
					   GtSQLVlStr($this->sgn_est, "int"),
					   GtSQLVlStr(ctjTx($this->sgn_tt,'out'), "text"),
					   GtSQLVlStr(ctjTx($this->sgn_cd,'out','',array('html'=>'ok','nl2'=>'no')), "text"),
					   GtSQLVlStr(ctjTx($_dir,'out'), "text"),
					   GtSQLVlStr(SIS_F, "date"));	
					   
		$Result = $__cnx->_prc($insertSQL); 
 		
 		if($Result){
	 		
	 		$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			
			$this->id_sgn = $rsp['i'];	
			
			$Update_IMG = sprintf("UPDATE sgn SET sgn_img=%s WHERE id_sgn=%s",
			                       GtSQLVlStr('sgn_'.$rsp['i'].'.jpg', "text"),
			                       GtSQLVlStr($rsp['i'], "int"));
                       
			$Update_IMG = $__cnx->_prc($Update_IMG);

		}else{
			
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_r->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_r->error]);
			
		}
		
		
		return _jEnc($rsp);	
	
	
	}
	
	
	public function _SgnUpd(){
				
		global $__cnx;
		
		$updateSQL = sprintf("UPDATE sgn 
									SET 
									sgn_est=%s, sgn_tt=%s, sgn_cd=%s WHERE id_sgn=%s",						
									GtSQLVlStr($this->sgn_est, "int"),
									GtSQLVlStr(ctjTx($this->sgn_tt,'out'), "text"),	
									GtSQLVlStr(ctjTx($this->sgn_cd,'out','',array('html'=>'ok','nl2'=>'no')), "text"),	
									GtSQLVlStr($this->id_sgn, "int"));				   

		$Result = $__cnx->_prc($updateSQL);
		
		if($Result){
			
			$rsp['i'] = $this->id_sgn;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['upd'] = $updateSQL;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}
		
		return _jEnc($rsp);
	
	}
	
	
}
?>