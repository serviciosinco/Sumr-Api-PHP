<?php 
	$_tp = Php_Ls_Cln($_POST['_tp']);
	$_id = Php_Ls_Cln($_POST['_id']);
	
	if($_POST['_tp'] == "_inf"){
		
		$_LrnVdLs = GtLrnVdDt(array("tp"=>"enc", "id"=>$_id));
		
		if($_LrnVdLs->id > 0){	
			
			$rsp['e'] = 'ok';
			$rsp['dsc'] = $_LrnVdLs->{$_LrnVdLs->id}->dsc;
			
		}else{
			$rsp['e'] = 'no';
		}
		
	}elseif($_POST['_tp'] == "_cmnt"){
		
		$_LrnVdLs = GtLrnVdDt(array("tp"=>"enc", "id"=>$_id));
		
		if($_LrnVdLs->id > 0){	
			
			$rsp['ls'] = $_LrnVdLs->cmnt;
			$rsp['e'] = 'ok';
			
		}else{
			$rsp['e'] = 'no';
		}
		
	}elseif($_POST['_tp'] == "_vd"){
		
		$_LrnVdLs = GtLrnVdDt(["tp"=>"enc", "id"=>$_id]);
		$rsp['e'] = $_LrnVdLs->e;
		$rsp['url'] = $_LrnVdLs->url;
		
	}elseif($_POST['_tp'] == "_cmnt_new"){
		
		$__enc = Enc_Rnd($_POST["_cmnt"].'-'.SISUS_ID);
		$_cmnt = $_POST["_cmnt"];
		
		if($_cmnt != "" && $_cmnt != NULL){
			
			$_LrnVdLs = GtLrnVdDt(array("tp"=>"enc", "id"=>$_id));
			$Ls_Qry = "INSERT INTO ".TB_LRN_VD_CMNT." (lrnvdcmnt_enc, lrnvdcmnt_lrnvd, lrnvdcmnt_cmnt, lrnvdcmnt_us) VALUES ('".$__enc."', ".$_LrnVdLs->id.", '".$_cmnt."', ".SISUS_ID.")";
			$Ls_Rg = $__cnx->_prc($Ls_Qry); 
			
			if($Ls_Rg){	
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
			}
			
			$_LrnVdLs = GtLrnVdDt(array("tp"=>"enc", "id"=>$_id));
			$rsp['ls'] = $_LrnVdLs->cmnt;
			
		}else{
			$rsp['e'] = 'no';
		}
		
	}elseif($_POST['_tp'] == "_act"){
			
			$_LrnVdLs = GtLrnVdDt(array("tp"=>"enc", "id"=>$_id));
			$__enc = Enc_Rnd($_LrnVdLs->id.'-'.SISUS_ID);
			
			$_tme = $_POST['_tme'];
			
			//Traer el id de la lista de sistema
			$__act_tp = __LsDt([ 'k'=>'lrnvdplay_tp' ]);
			foreach($__act_tp->ls->lrnvdplay_tp as $_k => $_v){
				if($_POST['_act'] == $_v->key->vl){
					$_act_tp = $_k;
				}
			}
			
			$Ls_Qry = "INSERT INTO ".TB_LRN_VD_PLAY." (lrnvdplay_enc, lrnvdplay_lrnvd, lrnvdplay_us, lrnvdplay_tp, lrnvdplay_tme) VALUES ('".$__enc."', ".$_LrnVdLs->id.",  ".SISUS_ID.", ".$_act_tp.", '".$_tme."')";
			$Ls_Rg = $__cnx->_prc($Ls_Qry); 
			
			if($Ls_Rg){	
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
			}
			
	}else{
		$rsp['e'] = 'no';
	}

?>