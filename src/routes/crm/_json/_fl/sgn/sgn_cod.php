<?php 
	
	try{
		
		$_tt = Php_Ls_Cln($_POST['_tt']);
		$_tp = Php_Ls_Cln($_POST['_tp']);
		$_enc = Php_Ls_Cln($_POST['_enc']);

		if($_tp != ''){ $__SgnIn = new CRM_Sgn(); $__SgnIn->post = $_POST; $__SgnIn->db = $_tp; }
		
		if($_tp == '_new_sgn'){
			
			$__SgnIn->_tt = $_tt;
			
			if(trim($__SgnIn->_tt) != ''){ $PrcDt = $__SgnIn->In_Sgn(); }
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $__SgnIn->rnd_enc;
				$rsp['tt'] = $_tt;
				
				
				$GtSgnCLs = GtSgnCLs();
				$rsp['_dt'] = $GtSgnCLs->ls;
				
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_tp == '_mod_sgn'){
			
			$__SgnIn->_tt = $_tt;
			$__SgnIn->_enc = $_enc;
			
			
			if(trim($__SgnIn->_tt) != ''){ $PrcDt = $__SgnIn->Mod_Sgn(); }
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['tt'] = $_tt;

				$GtSgnCLs = GtSgnCLs();
				$rsp['_dt'] = $GtSgnCLs->ls;
				
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_tp == '_asg_sgn'){
			
			$__sgn = Php_Ls_Cln($_POST['_sgn']);
			$__id_sgn = Php_Ls_Cln($_POST['_id_sgn']);
			
			$__SgnIn->sgn = $__sgn;
			$__SgnIn->id_sgn = $__id_sgn;
			
			$PrcDt = $__SgnIn->Asg_Sgn();
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['tt'] = $PrcDt->m;
				
				$GtSgnDt = GtSgnDt($__id_sgn,'enc');
				$rsp['_dt'] = $GtSgnDt;
				
				$GtSgnCLs = GtSgnCLs();
				$rsp['_dt1'] = $GtSgnCLs->ls;
				
				$__sng = new API_CRM_sgn();
				$__sng->id_sgn = $GtSgnDt->id; 
				$__sng->sgn_cd = $GtSgnDt->cd;
				$__sng->sgn_fl = $GtSgnDt->dir;
				$__sng->sgn_cod = $__sgn;
				
				$__body = $__sng->_bld();
				$__body1 = $__sng->_bld_s();
				
				$rsp['cd'] = $__body;
				$rsp['cd1'] = $__body1;
				
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_tp == '_shw_sgn'){
			
			$_enc = Php_Ls_Cln($_POST['_enc']);
			
			$GtSgnCLs = GtSgnCLs();
			$rsp['_dt'] = $GtSgnCLs->ls;
			$GtSgnDt = GtSgnDt($_enc,'enc');
			
			$rsp['e'] = 'ok';
			
			$__sng = new API_CRM_sgn();
			$__sng->id_sgn = $GtSgnDt->id; 
			$__sng->sgn_cd = $GtSgnDt->cd;
			$__sng->sgn_fl = $GtSgnDt->dir;
			$__sng->sgn_cod = Php_Ls_Cln($_POST['__id_cod']);
			$__body = $__sng->_bld();
			$__body1 = $__sng->_bld_s();
			
			$rsp['cd'] = $__body;
			$rsp['cd1'] = $__body1;
			
			$GtSgnCLs = GtSgnCLs();
			$rsp['_dt'] = $GtSgnCLs->ls;
			
			
		}elseif($_tp == 'ins_sgm'){
			
			$__SgnIn->id = Php_Ls_Cln($_POST['_id']);
			$__SgnIn->vle = Php_Ls_Cln($_POST['_vle']);
			$__enc = GtSgnCDt(Php_Ls_Cln($_POST['_enc']),'enc');
			
			$__SgnIn->enc = $__enc->id;
			
			
			$PrcDt = $__SgnIn->Ins_Sgn_Sgm();
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = $PrcDt->m;
				$rsp['vl'] = $PrcDt->vl;
				
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
			
		}elseif($_tp == 'upd_sgm'){
			
		
			$__SgnIn->id = Php_Ls_Cln($_POST['_id']);
			$__SgnIn->vle = Php_Ls_Cln($_POST['_vle']);
			$__enc = GtSgnCDt(Php_Ls_Cln($_POST['_enc']),'enc');
			
			$__SgnIn->enc = $__enc->id;
			
			
			$PrcDt = $__SgnIn->Upd_Sgn_Sgm();
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = $PrcDt->m;
				$rsp['vl'] = $PrcDt->vl;
				
				
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}	
			
		}elseif($_tp == '_eli_sgn'){
			
		
			$__SgnIn->id = Php_Ls_Cln($_POST['_id']);
			
			$PrcDt = $__SgnIn->Eli_Sgn();
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = $PrcDt->m;
				$rsp['vl'] = $PrcDt->vl;
				
				
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}else{
			throw new Exception((ChckSESS_superadm()) ? "- No existe post ".$_tp : "");
		}
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = "No se pudo procesar ".$e->getMessage();
	}
	
?>