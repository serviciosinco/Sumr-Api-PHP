<?php 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL);
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['_tp']);
		$_accid = Php_Ls_Cln($_POST['_accid']);
		$_cnvid = Php_Ls_Cln($_POST['_cnvid']);
		$_cnvest = Php_Ls_Cln($_POST['_cnvest']);
		$_nxt = Php_Ls_Cln($_POST['_nxt']);
		
		if($_tp == '_acc_cnv_post'){
			
			if($_cnvest == 'inbx'){ $_est = 385; }elseif($_cnvest == 'rdy'){ $_est = 386; }elseif($_cnvest == 'spm'){ $_est = 387; }
			
			$_acc_dt = GtSclAccDt([ 'enc'=>$_accid ]);
			$rsp['e'] = 'ok';
			
			if(!isN($_acc_dt->id)){
				$rsp['cnv'] = GtSclAccCnvLs([ 'scl_acc'=>$_acc_dt->id, 'est'=>$_est, 'lmt'=>20 ]);
				$rsp['post'] = GtSclAccPostLs([ 'scl_acc'=>$_acc_dt->id, 'lmt'=>20 ]);
			}
		
		}elseif($_tp == '_acc_cnv_nxt'){
			
			$_acc_dt = GtSclAccDt([ 'enc'=>$_accid ]);
			$_cnv_dt = GtSclAccCnvDt(['enc'=>$_nxt]);
			$rsp['e'] = 'ok';
			$rsp['cnv'] = GtSclAccCnvLs(['scl_acc'=>$_acc_dt->id, 'nxt'=>$_cnv_dt->upd, 'lmt'=>20]);
		
		}elseif($_tp == '_acc_cnv_msg'){
			
			$_cnv_dt = GtSclAccCnvDt(['enc'=>$_cnvid]);
			$rsp['e'] = 'ok';
			$rsp['msg'] = GtSclAccCnvMsgLs(['scl_acc_cnv'=>$_cnv_dt->id, 'ord'=>'a']);
		
		}elseif($_tp == '_acc_post_scan'){
			
			$_txt = Php_Ls_Cln($_POST['_txt']);
			$_first_url = Scl_F_URL(['txt'=>$_txt]);
			$rsp['url'] = $_first_url->url->url1;
			$rsp['tags'] = setcan(['url'=>$_first_url->url->url1]);
		
		}elseif($_tp == '_acc_post_nxt'){
			
			$_acc_dt = GtSclAccDt(['enc'=>$_accid]);
			$_post_dt = GtSclAccPostDt(['enc'=>$_nxt]);
			$rsp['e'] = 'ok';
			$rsp['post'] = GtSclAccPostLs(['scl_acc'=>$_acc_dt->id, 'nxt'=>$_post_dt->crtd, 'lmt'=>20]);
		
		}elseif($_tp == 'scl_dsh'){

			$_fnc = Php_Ls_Cln($_POST['_fnc']);

			if(!isN($_fnc) && $_fnc == 'forms' || !isN($_fnc) && $_fnc == 'search'){

				$_vl = Php_Ls_Cln($_POST['_vl']);	
				$_pg = Php_Ls_Cln($_POST['_pg']);

				$rsp['f'] = GtSclDshForms(['vl'=>$_vl, 'pag'=>$_pg ]); 

			}else{
				$rsp['d'] = GtSclDshDayDt();
				$rsp['f'] = GtSclDshForms();
				$rsp['md'] = GtSclDshLdScr();
				$rsp['fac'] = GtSclDshFac();
			}
		
		}elseif($_tp == 'emlbox_chk'){

			$_est = Php_Ls_Cln($_POST['est']);
			$_enc = Php_Ls_Cln($_POST['_id_chck']);
			$_id = Php_Ls_Cln($_POST['_id']);
			$_cmp = Php_Ls_Cln($_POST['_cmp']);

			$__Form = new CRM_Thrd();
		
			$__Form->est = $_est;
			$__Form->enc = $_enc;
			$__Form->cmp = $_cmp;

			$Prc = $__Form->EmlBoxEstChck_Upd();

			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['es'] = $Prc;
			}

		}else{

			throw new Exception((ChckSESS_superadm()) ? "-".TX_NEXTP .$_tp : "");
			
		}
		
		
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
?>