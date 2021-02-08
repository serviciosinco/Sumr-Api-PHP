<?php 

	$__CntIn = new CRM_Cnt();
	$__CntIn->cnt_cnt = $_POST['cnt_cnt'];
	$__CntIn->cnt_rlc = $_POST['cnt_cnt_rlc'];
	$__CntIn->cnt_prnt = $_POST['cnt_prnt2'];	

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntPrnt")) { 

		if($_POST['___tp'] == 'new_prnt'){
			$__dtcnt = $__CntIn->CntPrntIn();

			if($__dtcnt->e == 'ok'){
				$__CntIn->cnt_cnt = $_POST['cnt_cnt_rlc'];
				$__CntIn->cnt_rlc = $_POST['cnt_cnt'];
				$__CntIn->cnt_prnt = $_POST['cnt_prnt1'];
				$__dtcnt = $__CntIn->CntPrntIn();	
			
				if($__dtcnt->e == 'ok'){
					$rsp['e'] = 'ok';
				}else{
					$rsp['e'] = $__dtcnt;	
				}	
			}else{
				$rsp['e'] = $__dtcnt;	
			}	
			
		}elseif($_POST['___tp'] == 'new_cnt'){
				
			$__plcy = GtClPlcyDt([ 't'=>'enc', 'id'=>$_POST['cl_plcy'] ]); 	
				
			$__CntIn->cnt_nm = $_POST['cnt_nm1'];
			$__CntIn->cnt_ap = $_POST['cnt_ap1'];
			$__CntIn->cnt_dc = $_POST['cnt_dc1'];
			$__CntIn->cnt_dc_tp = $_POST['cnt_dctp1'];
			$__CntIn->cnt_eml = ctjTx($_POST['cnt_eml1'],'out');

			$__CntIn->cnt_tel = [
									'no'=>ctjTx($_POST['cnt_tel1'],'out'),
									'tp'=>ctjTx($_POST['cnt_tel_tp1'],'out'),
									'ext'=>ctjTx($_POST['cnt_tel_ext1'],'out'),
									'ps'=>ctjTx($_POST['cnt_tel_ps1'],'out')
								];

			$__CntIn->cnt_nw = 'ok';
			$__CntIn->rgs = 2;
			
			$__CntIn->snd->eml->adm = 'no';
			$__CntIn->snd->eml->us = 'no';
			$__CntIn->ck_in = 'ok';
			
			$__CntIn->plcy_id = $__plcy->id;
			$__CntIn->invk->by = _CId('ID_SISINVK_CRM');
			
			$PrcDt = $__CntIn->MdlCnt();
			
			$rsp['dde'] = $PrcDt;
			
			if(!isN($PrcDt->cnt->i)){ 
				$rsp['enc'] = $PrcDt->cnt->enc;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['a'] = Aud_Sis(Aud_Dsc(326, $_POST['cnt_nm1'], $PrcDt->i), $rsp['v']);
				
				$__CntIn->cnt_cnt = $_POST['cnt_cnt'];
				$__CntIn->cnt_rlc = $PrcDt->cnt->enc;
				$__CntIn->cnt_prnt = $_POST['cnt_prnt2'];
				$__dtcnt = $__CntIn->CntPrntIn();
				
				$rsp['es'] = $__dtcnt;
				if($__dtcnt->e == 'ok'){
					$__CntIn->cnt_cnt = $PrcDt->cnt->enc;
					$__CntIn->cnt_rlc = $_POST['cnt_cnt'];
					$__CntIn->cnt_prnt = $_POST['cnt_prnt1'];
					$__dtcnt = $__CntIn->CntPrntIn();	
					$rsp['est'] = $__dtcnt;
					if($__dtcnt->e == 'ok'){
						$rsp['e'] = 'ok';	
					}	
				}
				
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				
				if(ChckSESS_superadm()){
					$rsp['prc'] = $PrcDt;
					$rsp['chk']['mdl'] = $__dtmdl;
					$rsp['chk']['est'] = $__dtest;
				}
				
			}

		}
		
	}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntPrnt")) { 
		$__CntIn->cnt_enc = $_POST['cntprnt_enc'];
		$__CntIn->cnt_prnt = $_POST['cnt_prnt1'];
		$__dtcnt = $__CntIn->CntPrntMod();
		
		
		$rsp['es'] = $__dtcnt;
		if($__dtcnt->e == 'ok'){
			$__CntIn->cnt_prnt = $_POST['cnt_prnt2'];
			$__CntIn->cnt_enc = $_POST['_cnt_enc'];			
			$__dtcnt = $__CntIn->CntPrntMod();	
			
			$rsp['es1'] = $__dtcnt;
			if($__dtcnt->e == 'ok'){
				$rsp['e'] = 'ok';	
			}	
		}
		
	}
?>