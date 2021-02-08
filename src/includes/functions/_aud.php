<?php 
	function Aud_GtUsId(){ $_r = SISUS_ID; return($_r); }
	
	function Aud_Dsc($_id=NULL, $val1=NULL, $val2=NULL, $val3=NULL){
		
		global $__cnx;
		
		if(!isN($_id)){
			
			$c_DtRg = "-1";if (isset($_id)){$c_DtRg = $_id;}
			$Qry = sprintf('SELECT * FROM '._BdStr(DBM).MDL_SIS_AUD_BD.' WHERE id_audtx = %s', GtSQLVlStr($c_DtRg,'int')); 
			$Dt = $__cnx->_qry($Qry); 
			
			if($Dt){
				
				$RowDt = $Dt->fetch_assoc(); 
				$TotDt = $Dt->num_rows;
					
				if($TotDt > 0){
					$__s  = array('[v1]', '[v2]', '[v3]');
					$__r = array($val1, $val2, $val3);
					$DscAud = str_replace($__s, $__r, ctjTx($RowDt['audtx_dsc'],'in'));
				}

			}
			$__cnx->_clsr($Dt);
		}
		
		return($DscAud);
		
	}
	
	function Aud_Sis($DscPrc=NULL, $_vr=NULL){
		
		global $__cnx;
		
		if(!isN($DscPrc) && !isN(Aud_GtUsId()) ){	
	
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_US_RG_BD." (usrg_dsc, usrg_v, usrg_us, usrg_f, usrg_h, usrg_ip, usrg_ses) VALUES (%s, %s, %s, %s, %s, %s, %s)",
								   GtSQLVlStr(ctjTx($DscPrc,'out'), "text"),
								   GtSQLVlStr(json_encode($_vr), "text"),
								   GtSQLVlStr(Aud_GtUsId(), "int"),
								   GtSQLVlStr(SIS_F, "date"),
								   GtSQLVlStr(SIS_H2, "date"),
								   GtSQLVlStr(KnIp("on"), "text"),
								   GtSQLVlStr(SISUS_SES, "int"));
								   		   
			$Result1 = $__cnx->_prc($insertSQL);
			
			if($Result1){ $Vl['e'] = true;}else{ $Vl['e'] = false; $Vl['w'] = $__cnx->c_p->error; }
			
		}else{
			$Vl['e'] = false;
			//$Vl['d'] = $insertSQL;
		}
		
		return json_encode($Vl);
	}
	
?>