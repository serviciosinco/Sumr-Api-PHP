<?php
	
class CRM_Aud{
     
	function __construct(){ 
			
    }
    
    function __destruct() {
		
   	}
	   	
    //Se ingresa la auditoría
    public function In_Aud($p=NULL){
        
		global $__cnx;
		
		if(!isN($p) && !isN($p['aud']) && !isN( GtSQLVlStr($p['aud'],'int') )){

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_AUD_BD." (aud_auddsc, aud_v, aud_db, aud_iddb, aud_dbrlc, aud_iddbrlc ,aud_us, aud_ses, aud_ip, aud_enc, aud_icn) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, "._BdStr(DBM)."f_Enc(), %s )",
					GtSQLVlStr($p['aud'], "int"),
					GtSQLVlStr(json_encode($p['post']), "text"),
					GtSQLVlStr($p['db'], "text"),
					GtSQLVlStr($p['iddb'], "int"),
					GtSQLVlStr($p['dbrlc'], "text"),
					GtSQLVlStr($p['iddbrlc'], "int"),
					GtSQLVlStr(SISUS_ID, "int"),
					GtSQLVlStr(SISUS_SES, "int"),
					GtSQLVlStr(KnIp("on"), "text"),
					GtSQLVlStr($p['icn'], "text"));
					
			$Result = $__cnx->_prc($insertSQL); 

			if($Result){
				$_id = $__cnx->c_p->insert_id;
				$_key = $this->Shw_Aud_Key([ "auddsc"=>$p["aud"] ]);
				foreach($_key as $_k => $_v){
					$this->In_Aud_Vl([ "aud"=>$_id, "key"=>$_v->key, "vl"=>$p['post'][$_v->post] ]);
				}   
			}
		
		}
	    
    }
    
    //Consulta las auditorias
    public function Shw_Aud($p=NULL){
    	
    	global $__cnx;
    	
    	if($p['key'] != '' && $p['key'] != NULL && is_array($p['key'])){
	    	
	    	$_count = 0;
			foreach($p['key'] as $_v){
				
				if($_count == 0){ $_or = ''; }else{ $_or = 'OR'; }
				$_fl .= "$_or sisslcf_vl = '{$_v}' ";
				$_count ++;
				
	    	}
	    	$_fl = "AND ( {$_fl} )";	
	    	
    	}elseif($p['key'] != '' && $p['key'] != NULL){
	    	
	    	$_fl .= " AND sisslcf_vl = '{$p['key']}' ";
	    
    	}
    	
    	if($p["iddb"] != '' && $p["iddb"] != NULL){ $_fl .= "AND aud_iddb = ".$p["iddb"]." "; }
    	
    	if($p["dbrlc"] != '' && $p["dbrlc"] != NULL){ 
	    	$_fl .= "
	    		OR id_aud != '' AND aud_us = id_us AND aud_auddsc = sisslcf_slc AND sisslcf_f = 38 AND(sisslcf_vl = '".$p["dbrlc"]."') AND aud_iddbrlc = ".$p["iddb"]."
	    	";
	    }
    	
    	for($i = 1; $i <= 5; $i++){
			$_fl_v .= ", ( SELECT audvl_vl FROM "._BdStr(DBM).MDL_AUD_VL_BD." WHERE audvl_key = '[v".$i."]' AND audvl_aud = id_aud ) AS _vl_".$i." ";
		}
		
		$_fl_aud .= ", ( SELECT sisslcf_vl FROM "._BdStr(DBM).TB_SIS_SLC_F." WHERE sisslcf_slc = aud_auddsc AND sisslcf_f = 39 ) AS _aud_dsc";
		
        $Ls_Qry = sprintf("SELECT * $_fl_aud $_fl_v FROM "._BdStr(DBM).MDL_AUD_BD.", "._BdStr(DBM).TB_US.", "._BdStr(DBM).TB_SIS_SLC_F." WHERE id_aud != '' AND aud_us = id_us AND aud_auddsc = sisslcf_slc AND sisslcf_f = 38 $_fl");
       
        
        
        $Ls_Rg = $__cnx->_qry($Ls_Qry); $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	    
	    
	    do{
		    if($row_Ls_Rg['id_aud'] != '' && $row_Ls_Rg['id_aud'] != NULL){
			    $Vl[$row_Ls_Rg['id_aud']]['id'] = ctjTx($row_Ls_Rg['id_aud'],'in');
			    $Vl[$row_Ls_Rg['id_aud']]['enc'] = ctjTx($row_Ls_Rg['aud_enc'],'in');
				$Vl[$row_Ls_Rg['id_aud']]['aud'] = ctjTx(strtr( $row_Ls_Rg['_aud_dsc'], array('[v1]'=>$row_Ls_Rg['_vl_1'], 
																							  '[v2]'=>$row_Ls_Rg['_vl_2'],
																							  '[v3]'=>$row_Ls_Rg['_vl_3'],
																							  '[v4]'=>$row_Ls_Rg['_vl_4'],
																							  '[v5]'=>$row_Ls_Rg['_vl_5']) ), 'in');
				$Vl[$row_Ls_Rg['id_aud']]['v1'] = ctjTx($row_Ls_Rg['_vl_1'],'in');
				$Vl[$row_Ls_Rg['id_aud']]['v2'] = ctjTx($row_Ls_Rg['_vl_2'],'in');
				$Vl[$row_Ls_Rg['id_aud']]['us'] = ctjTx($row_Ls_Rg['us_nm']." ".$row_Ls_Rg['us_ap'],'in');
				$Vl[$row_Ls_Rg['id_aud']]['fi'] = ctjTx($row_Ls_Rg['aud_fi'],'in');
				$Vl[$row_Ls_Rg['id_aud']]['icn'] = ctjTx($row_Ls_Rg['aud_icn'],'in'); 
				//$Vl[$row_Ls_Rg['id_aud']]['qry'] = $Ls_Qry; 
		    }
		} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	 
		$__cnx->_clsr($Ls_Rg);
		$rtrn = _jEnc($Vl);
		return($rtrn);
        
    }
    
    //Trae los key que se ingresarán en aud_vl con los POST, ejemplo id_us, us_nm etc. 
    private function Shw_Aud_Key($p=NULL){
       	
       	global $__cnx;
       	
        $Ls_Qry = sprintf("SELECT * FROM "._BdStr(DBM).MDL_AUD_KEY_BD." WHERE audkey_auddsc = %s ", $p["auddsc"]);
        $Ls_Rg = $__cnx->_qry($Ls_Qry); $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	    
	    do{
			$Vl[$row_Ls_Rg['id_audkey']]['post'] = ctjTx($row_Ls_Rg['audkey_post'],'in');
			$Vl[$row_Ls_Rg['id_audkey']]['key'] = ctjTx($row_Ls_Rg['audkey_key'],'in');
		} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
     
		$rtrn = _jEnc($Vl);
		return($rtrn);
        
    }
    
    //Ingresa los valores de [v1], [v2] etc.
    private function In_Aud_Vl($p=NULL){
       
       	global $__cnx;
       	
       	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_AUD_VL_BD." (audvl_aud, audvl_key, audvl_vl) VALUES (%s, %s, %s)",
       	 		   GtSQLVlStr($p['aud'], "int"),
                   GtSQLVlStr(ctjTx($p['key'],'out'), "text"),
				   GtSQLVlStr(ctjTx($p['vl'],'out'), "text") );			
		$Result = $__cnx->_prc($insertSQL);
        
    }
    
}
     
?>