<?php
		
		
		$__cll = Php_Ls_Cln($_GET['_cll']);
		$__mydvc = Php_Ls_Cln($_GET['_mydvc']);
		
				
		if(!isN($__cll)){

			 
			$Ls_Qry = ' SELECT *,
								(	SELECT mdlcntcall_his 
									FROM '.TB_CALL_MDL_CNT.' 
									WHERE mdlcntcall_call = id_call
								) AS _mdlcnt_his	
									 
					    FROM '._BdStr(DBT).TB_CALL.' 
					    WHERE call_sid = '.GtSQLVlStr($__cll, 'text').' LIMIT 1';
					    
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;
				
				if($Tot_Ls > 0){
					
					$__dt = GtMdlCntHisDt([ 'id'=>$row_Ls['_mdlcnt_his'] ]);
					
					$rsp['call'] = $row_Ls['id_call'];
					$rsp['his'] = $__dt;
					
					$rsp['e'] = 'ok';	
					
				}else{
					$rsp['e'] = 'no';	
				}
			
			}else{
				
				$rsp['w'] = $__cnx->c_r->error;
				
			}
		
		}elseif(!isN($__mydvc)){
		
			if(!is_numeric($_POST['SUMR_MdlCnt'])){ $__mdlcnt_dt = GtMdlCntDt([ 'id'=>$_POST['SUMR_MdlCnt'], 't'=>'enc' ]); }
			if(!isN($_POST['SUMR_UserTel'])){ $__UsTelDt = GtUsTelDt(['id'=>$_POST['SUMR_UserTel']]); }
			if(!isN($_POST['PhoneNumber_Id'])){ $__TelDt = GtCntTelDt(['id'=>$_POST['PhoneNumber_Id'], 't'=>'enc']); }
			if(!isN($_POST['SUMR_Cl'])){ $__ClDt = $_POST['SUMR_Cl']; }
			
			if($__UsTelDt->telc != NULL){
				
				$cll_d = _CallMyDvc([ 	'cl'=>$__ClDt, 
										'cnt_t'=>$_POST['PhoneNumber_Id'], 
										'cnt_n'=>$__TelDt->telc, 
										'us_n'=>$__UsTelDt->telc, 
										'us_t'=>$_POST['SUMR_UserTel']
									]);
									
				
				if($cll_d->c->sid != NULL){
					
					$__CallIn = new CRM_Call();
					$__CallIn->tel = $__TelDt->id;
					$__CallIn->sid = $cll_d->c->sid;
					$__CallIn->appsid = NULL;
					$__CallIn->apiversion = $cll_d->c->apiVersion;
					$__CallIn->caller = $cll_d->c->callerName;
					$__CallIn->callstatus = $cll_d->c->status;
					$__CallIn->phonenumber = $__UsTelDt->telf;
					$__CallIn->duration = $cll_d->c->duration;
					$__CallIn->callduration = NULL;
					
					$__CallIn->cnt = $_POST['SUMR_Cnt'];
					$__CallIn->mdlcnt = $__mdlcnt_dt->enc;
					
					$__CallIn->user = $_POST['SUMR_User'];
					$__CallIn->userTel = $_POST['SUMR_UserTel'];
					$__CallIn->userDvc = $_POST['SUMR_UserDvc'];
					$PrcDt = $__CallIn->Sve();

					$rsp['e'] = 'ok';
					$rsp['d'] = $cll_d;
					$rsp['sid'] = $cll_d->c->sid;
				
				}else{
					
					$rsp['e'] = 'no';
						
				}
			}
			
		}else{
			
			$rsp['e'] = 'no';
			
		}
	$Ls->free; 
?>
