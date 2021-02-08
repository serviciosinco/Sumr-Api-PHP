<?php 
	
	function GtSmsDt($p=NULL){ //$Id, $tp=NULL, $p=NULL
		
		global $__cnx;
		
		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__fl = 'sms_enc'; }
			else{ $__fl = 'id_sms'; }
			
			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			
			$query_DtRg = sprintf('	SELECT *,
										   '._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).',
										   '.GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ]).'
									FROM '._BdStr(DBM).TB_SMS.'
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON sms_cl = id_cl
										 '.GtSlc_QryExtra([ 't'=>'tb', 'col'=>'sms_est', 'als'=>'e' ]).'
									WHERE '.$__fl.' = %s 
									LIMIT 1', GtSQLVlStr($c_DtRg,'text'));
			
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				
				if($Tot_DtRg > 0){
					
					$Vl['e'] = 'ok';
					
					$Vl['id'] = $row_DtRg['id_sms'];
					$Vl['enc'] = $row_DtRg['sms_enc'];
					$Vl['tt'] = ctjTx($row_DtRg['sms_tt'],'in');
					$Vl['msj'] = ctjTx($row_DtRg['sms_msj'],'in');
					$Vl['fi'] = $row_DtRg['sms_fi'];
					$Vl['fa'] = $row_DtRg['sms_fa'];
					
					$Vl['est']['id'] = $row_DtRg['sms_est'];
					$Vl['est']['tt'] = $row_DtRg['Estado_sisslc_tt'];
					
					$__formato_go = __LsDt([ 'id'=>$row_DtRg['sms_frm'], 'no_lmt'=>'ok' ]);
					$Vl['frm'] = $__formato_go->d;
					
					$Vl['cl'] = GtClDt($row_DtRg['sms_cl']);
					
				}
	
			}else{
			
				$Vl['w'] = $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);	

		}else{
			
			$Vl['w'] = 'No get ID';
			
		}
		
		return _jEnc($Vl);
		
	}
	
	
	
	function GtSmsSndDt($_p=NULL){
		
		$Vl['e'] = 'no';
		//$Vl['p'] = $_p;
		
		if(!isN($_p['id'])){
			
			if($_p['tp'] == 'enc'){ $__f = 'smssnd_enc'; $__ft = 'text'; }
			elseif($_p['tp'] == 'id'){ $__f = 'smssnd_id'; $__ft = 'text'; }
			else{ $__f = 'id_smssnd'; $__ft = 'int'; }
			
			if(!isN($_p['bd'])){ $_bd = $_p['bd']; }else{ $_bd = ''; }
			
			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			
			 
			
			$query_DtRg = sprintf('	SELECT *,
									    (	
									    	SELECT mdlcntsnd_mdlcnt 
									    	FROM '.$_bd.TB_CNT_SND.' 
									    	WHERE mdlcntsnd_smssnd = id_smssnd 
									    	LIMIT 1
									    ) AS __mdlcnt
								    
								    FROM '.$_bd.TB_SMS_SND.' 
								    WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));
			   	 
							   
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				//$Vl['q'] = $query_DtRg;
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){
					
					$Vl['id'] = $row_DtRg['id_smssnd'];
					$Vl['enc'] = $row_DtRg['smssnd_enc'];
					$Vl['enc1'] = $row_DtRg['smssnd_eml'];
					
					$Vl['cel'] = $row_DtRg['smssnd_cel']; 
					$Vl['sms'] = GtSmsDt([ 'id'=>$row_DtRg['smssnd_sms'] ]);
					
					
					if(!isN($row_DtRg['__mdlcnt'])){ 
						$Vl['mdlcnt'] = GtMdlCntDt([ 'id'=>$row_DtRg['__mdlcnt'], 'bd'=>$_bd ]); 
					}
					
				}
			
			}else{
				
				$Vl['w'] = $__cnx->c_r->error;
				
			}

		}else{
				
			$Vl['w'] = 'No all data';
			
		}
		
		$__cnx->_clsr($DtRg);
		if(isN($_p["cnx"])){  }		
		return(_jEnc($Vl));
			
	}
	
	


?>