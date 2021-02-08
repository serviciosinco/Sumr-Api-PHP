<?php 

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdBco")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_BCO." SET bco_dsc=%s, bco_fa=%s WHERE id_bco=%s",
					   GtSQLVlStr(ctjTx($_POST['bco_dsc'],'out'), "text"),
					   GtSQLVlStr(SIS_F, "date"),
                       GtSQLVlStr($_POST['id_bco'], "int"));
	
	$Result = $__cnx->_prc($updateSQL); 
	 
	
	if($Result){
		$rsp['a'] = Aud_Sis(Aud_Dsc(3, $_POST['id_bco'], $_POST['bco_dsc']), $rsp['v']);

		//Departamento
		if($_POST['bcoare_are'] != NULL && $_POST['bcoare_are'] != ''){  
			$_bco_are =  implode(',', $_POST['bcoare_are']);
			$_fl = "AND bcoare_are NOT IN (".$_bco_are.")";
		}
		
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_ARE." WHERE bcoare_bco=%s $_fl",
	                       GtSQLVlStr($_POST['id_bco'], "int"));
		$Result = $__cnx->_prc($deleteSQL); 
		
	
		if(!isN($_POST['bcoare_are'])){
			
			
			
			if($Result){
				
				
				foreach($_POST['bcoare_are'] as $_v){
				
					$bcoAre = GtBcoAreDt(array("bco"=>$_POST['id_bco'], "are"=>$_v));
					$__enc = Enc_Rnd($_POST['id_bco'].'-'.$_POST['bcoare_are']);
					
					if($bcoAre->e == 'no'){
							
						$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_ARE." (bcoare_enc, bcoare_bco, bcoare_are) VALUES (%s, %s, %s)",
						   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
	                       GtSQLVlStr($_POST['id_bco'], "int"),
	                       GtSQLVlStr($_v, "int"));
	                
	                    
						$Result = $__cnx->_prc($insertSQL); 
					}
					
				}
			}
		
		}
		
		
		//Ciudad
		if($_POST['bco_cd'] != NULL && $_POST['bco_cd'] != ''){  
			$_bco_cd =  implode(',', $_POST['bco_cd']);
			$_fl = "AND bcocd_cd NOT IN (".$_bco_cd.")";
		}
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_CD." WHERE bcocd_bco=%s $_fl",
	                       GtSQLVlStr($_POST['id_bco'], "int"));
		$Result = $__cnx->_prc($deleteSQL); 
		
		if($_POST['bco_cd'] != NULL && $_POST['bco_cd'] != ''){
			
			if($Result){
				foreach($_POST['bco_cd'] as $_v){
					
					$bcoCd = GtBcoCdDt(array("bco"=>$_POST['id_bco'], "cd"=>$_v));
					$__enc = Enc_Rnd($_POST['id_bco'].'-'.$_v);

					if($bcoCd->e == 'no'){
						$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_CD." (bcocd_enc, bcocd_bco, bcocd_cd) VALUES (%s, %s, %s)",
							GtSQLVlStr(ctjTx($__enc,'out'), "text"),
	                       	GtSQLVlStr($_POST['id_bco'], "int"),
	                       	GtSQLVlStr($_v, "int"));
						$Result = $__cnx->_prc($insertSQL); 
					}
					
				}
			}
		}
		
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['m123'] = $deleteSQL;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(187, $_POST['bco_dsc'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdBco'))) { 


	$_GtDt_Bco = GtBcoDt([ 'id'=>$_POST['uid'], 't'=>'enc' ]);
	
	if(!isN($_GtDt_Bco->id)){
			
		$deleteSQL = sprintf('UPDATE '._BdStr(DBM).TB_BCO.' SET bco_est = %s WHERE id_bco = %s ', _CId('ID_SISBCOEST_INCTV'), GtSQLVlStr($_GtDt_Bco->id, 'int'));
		
		$Result = $__cnx->_prc($deleteSQL); 
		if($Result){
			$rsp['e'] = 'ok'; $rsp['m'] = 1;
			unlink($_GtDt_Bco->img);
			$_Crm_Aud->In_Aud([ 'aud'=>_CId('ID_AUDDSC_BCO_ELI'), "db"=>'bco', "iddb"=>$_POST['uid'], "post"=>$_POST]);
		}else{
			$rsp['e'] = 'no';$rsp['m'] = 2;
			_ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error));		
		}
			
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2;
	}
}
?>