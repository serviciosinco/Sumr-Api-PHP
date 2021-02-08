<?php
	
$rsp['e'] = 'no';

// Ingreso de Registro
if ((isset($_POST["MM_process"])) && ($_POST["MM_process"] == "UpMMProcess")) {
					
	$__p__col = Php_Ls_Cln($_POST['__col']);
	$__p__rws = Php_Ls_Cln($_POST['__rws']);													
	$___fle = GtUpDt([ 'id'=>Php_Ls_Cln($_POST['__i']), 't'=>'enc' ]);
	$___hdr = Php_Ls_Cln($_POST['__hdr']);
	$___hdr_f = GtUpFld_Js()->ls;
	
	if(!isN($___fle->id)){	
			
		$__r_col = array();
		
		for ($__c = 0; $__c<$__p__col; $__c++) {
			if(($_POST['tt_xls_'.$__c] != NULL) && ($_POST['tt_xls_'.$__c] != '')){ 
				$__r_col['c_'.$__c] = $_POST['tt_xls_'.$__c];
				
				$id_fld = $_POST['tt_xls_'.$__c]['id'];
				
				if(!isN($id_fld)){
					$__r_col['c_'.$__c]['ext'] = $___hdr_f->{$id_fld}->ext;
				}
				
			}
		}
		
		$__r_col_q .= json_encode( $__r_col );
		
		
		 try {
	        
			//$___fle_pth = '../../../'.DIR_PRVT_UP.$___fle->fle;    
			

			$_aws = new API_CRM_Aws();
			$_pth = $_aws->_s3_get([ 'b'=>'prvt', 'lcl'=>'ok', 'fle'=>DIR_PRVT_UP.$___fle->fle ]);
			if($_pth->tmp){ $___fle_pth = $_pth->tmp; }
		
	                
            $inputFileType = PHPExcel_IOFactory::identify($___fle_pth); 
            $objReader_b = PHPExcel_IOFactory::createReader($inputFileType);
		 	$objReader_b->setReadDataOnly(true);
		 	$worksheetData = $objReader_b->listWorksheetInfo($___fle_pth);

		 	$nameFle = $worksheetData[0]['worksheetName'];
		 	$highestRow = $worksheetData[0]['totalRows']; 
         	
         	if(!isN($highestRow) && !isN($__p__col)){
		
				$updateSQL = sprintf("UPDATE ".DBP.".up SET up_nm=%s, up_fld=%s, up_est=%s, up_hdr=%s, up_row=%s, up_max=%s, up_col=%s WHERE id_up=%s",			  							
						GtSQLVlStr($nameFle, "text"),
						GtSQLVlStr($__r_col_q, "text"),
						GtSQLVlStr(_CId('ID_UPEST_LD'), "int"), 
						GtSQLVlStr($___hdr, "text"),
						GtSQLVlStr(($highestRow-1), "int"), 
						GtSQLVlStr($highestRow, "int"),                						 			
						GtSQLVlStr($__p__col, "int"),
						GtSQLVlStr($___fle->id, "int"));

				$Result_Upd = $__cnx->_prc($updateSQL);

				$rsp['n']['est'] = _CId('ID_UPEST_LD');
				
				if($Result_Upd){
					$rsp['e'] = 'ok';	
				}else{
					$rsp['e'] = 'no';	
				}  
			
			} 
            
        } catch (Exception $e) {
            
            $rsp['w'] = $e->getMessage();
            
        }
		
	}
                    
}

	// Resultado POST

		foreach ($_POST['__rw'] as &$pst) {
			
			if ($pst['id_field'] < 3){
				$rsp['n_ok'][] = $pst['id_field'];
			}elseif($pst['id_field'] < 4){
				$rsp['n_no'][] = $pst['id_field'];
			}
			
			$rsp['e'] = 'ok';
		}
		
		
	//

Hdr_JSON(); $rtrn = json_encode($rsp); echo $rtrn;
?>
