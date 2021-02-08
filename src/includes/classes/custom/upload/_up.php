<?php 

class CRM_Up {
	
	function __construct($p=NULL) {   
		
		global $__cnx;    
        
        if(!isN($p['cl'])){ $this->cl = GtClDt($p['cl'],'',['cnx'=>$this->c_r]); }
        
        $this->_Ntf = new CRM_Ntf();
    }

	function __destruct() {

   	}
   		
	public function _InUpW($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['u']) && !isN($p['m'])){ 

			$Qry = sprintf("INSERT INTO ".DB_PRC.".up_w (upw_up, upw_qry, upw_msj, upw_fi, upw_hi) VALUES (%s, %s, %s, %s, %s)",
							   GtSQLVlStr($p['u'], "int"),
							   GtSQLVlStr(ctjTx($p['q'],'out'), "text"),
							   GtSQLVlStr(ctjTx($p['m'],'out'), "text"),
							   GtSQLVlStr(SIS_F, "date"),
							   GtSQLVlStr(SIS_H2, "date"));	
				
								   
			$insertSQL = $Qry; 
			$Result1 = $__cnx->_prc($insertSQL);
			if($Result1){ $Vl['e'] = true;}else{ $Vl['e'] = false; }
	
		}
		
		return(_jEnc($Vl));
	}
	
	
	
	public function _InUpCol($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';

		if(!isN($p['up'])){ 
			
			for ($i = 0; $i <= count($p['d']); $i++) { 
				//if(!isN($p['d'][$i])){
					$_f[] = 'upcol_'.$i; 
					$_v[] = GtSQLVlStr(
								ctjTx(	
									trim(
										strip_tags($p['d'][$i])
									),
									'out'
								), "text", '', '', [ 'cnx'=>$this->c_p ]
							);
				//}
			}
			
			
			$_campos = implode(',',$_f);
			$_valores = implode(',',$_v);
		
			if(!isN($p['up']) && !isN($p['row']) && !isN($_valores)){
				
					$Qry = "INSERT INTO ".DB_PRC.".".MDL_UP_COL_BD." (upcol_up, upcol_row, {$_campos}) 
								        VALUES (".GtSQLVlStr($p['up'], "int", '', '', [ 'cnx'=>$this->c_p ]).", ".
								        			 GtSQLVlStr($p['row'], "int", '', '', [ 'cnx'=>$this->c_p ]).", ".$_valores.")"; 

					$Result1 = $__cnx->_prc($Qry); 
					$Vl['q'] = $Qry;
					$Vl['w2'] = $__cnx->c_p->error.HTML_BR;
					
					if($Result1){ 
						
						$Vl['e'] = 'ok'; $Vl['i'] = $__cnx->c_p->insert_id; 
						$this->_InUp_LRw([ 'id'=>$p['up'], 'n'=>$p['row'] ]);
						
					}else{ 
						
						$Vl['e'] = 'no'; $Vl['w'] = _InUpW([ 'u'=>$p['up'], 'q'=>$insertSQL,'m'=>$__cnx->c_p->error ]);
						
					}
					
			}else{
				
				$Vl['e'] = 'no';
				$Vl['w']['m'] = 'faltan datos';
				$Vl['w']['up'] = $p['up'];
				$Vl['w']['row'] = $p['row'];
				$Vl['w']['val'] = $_valores;
				
			}
		}
		
		return(_jEnc($Vl));
	}
	
	
		
	public function _InUp_W($p=NULL){
		
		global $__cnx;
				
		if(!isN($p['id'])){	
			
			$updateSQL = sprintf("UPDATE ".DB_PRC.".".MDL_UP_BD." SET up_w=%s WHERE id_up=%s",
					   GtSQLVlStr($p['w'], "text"),
					   GtSQLVlStr($p['id'], "int"));
					   
			$Result_UPD = $__cnx->_prc($updateSQL);
			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }

			return _jEnc($rsp);
		}
	}

	
	public function _InUp_Rd($p=NULL){	
		
		global $__cnx;
		
		if(!isN($p['id'])){	
			
			if($p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }
			
			$updateSQL = sprintf("UPDATE ".DB_PRC.".".MDL_UP_BD." SET up_rd=%s, up_rd_f=%s WHERE id_up=%s",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D2, "date"),
					   GtSQLVlStr($p['id'], "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);
			
			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }
			
			return _jEnc($rsp);
		}
	}
	
	
	public function _InUp_LRw($p=NULL){	
		
		global $__cnx;
		
		if(!isN($p['id']) && !isN($p['n'])){	
			
			$updateSQL = sprintf("UPDATE ".DB_PRC.".".MDL_UP_BD." SET up_lrow=%s WHERE id_up=%s",
					   GtSQLVlStr($p['n'], "int"),
					   GtSQLVlStr($p['id'], "int"));
			
			$Result_UPD = $__cnx->_prc($updateSQL);
			
			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }
			
			return _jEnc($rsp);
		}
		
	}
	
	
	public function _InUpRow_Rd($p=NULL){
		
		global $__cnx;
			
		if(!isN($p['id'])){	
			
			if($p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }
			
			$updateSQL = sprintf("UPDATE ".DB_PRC.".".MDL_UP_COL_BD." SET upcol_rd=%s, upcol_rd_f=%s WHERE id_upcol=%s",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($p['id'], "int"));
					   
			$Result_UPD = $__cnx->_prc($updateSQL);
			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }
			
			
			return _jEnc($rsp);
		}
	}

	
	
	public function _UpLstNo_U($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		$__ordby = 'id_up ASC';

		if(!isN($p['id'])){ 
			
			if($p['t'] == 'enc'){
				$_idf='up_enc';
			}else{	
				$_idf='id_up';
			}
			
			$__f_f = " AND ".$_idf." = '".$p['id']."' "; 
			
		}else{ 

			$__f_f = ' AND (up_est != '._CId('ID_UPEST_ON').' AND up_est != '._CId('ID_UPEST_W').') '; 
			if($p['rnd']=='ok'){ $__ordby = 'RAND()'; }

		}
		
		if(!isN($p['tp'])){ $__f_tp = ' AND up_tp = "'.$p['tp'].'"'; }else{$__f_tp = '';}
		if(!isN($p['f'])){ $__f = $p['f']; }
		
		
		$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

		$query_DtRg = sprintf("SELECT *,
									  (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." AS _u WHERE _u.upcol_up = id_up AND upcol_est = 352) AS __tot_up,
									  (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." AS _u WHERE _u.upcol_up = id_up AND upcol_est = 615) AS __tot_w,
									  (SELECT COUNT(*) FROM ".DB_PRC.".".MDL_UP_COL_BD." AS _u WHERE _u.upcol_up = id_up) AS __tot 
							   FROM ".DB_PRC.".".MDL_UP_BD." 
							   WHERE id_up != '' {$__f} {$__f_f} {$__f_tp} 
							   ORDER BY {$__ordby}
							   LIMIT 1");
						   				   
		$DtRg = $__cnx->_qry($query_DtRg); 
		
		//echo $Vl['q'] = $query_DtRg;
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc(); 
			$Tot_DtRg = $DtRg->num_rows;	
			
			$Vl['e'] = 'ok';
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
					
				$Vl['id'] = $row_DtRg['id_up'];
				$Vl['enc'] = ctjTx($row_DtRg['up_enc'],'in');
				$Vl['fle'] = $row_DtRg['up_fle'];
				$Vl['r_tot_up'] = $row_DtRg['__tot_up'];
				$Vl['r_tot'] = $row_DtRg['__tot'];
				$Vl['r_tot_w'] = $row_DtRg['__tot_w'];
				//$Vl['qry'] = $query_DtRg;
			}
		
		}else{
			
			$Vl['w'] = 'Err _UpLstNo_U:'.$this->c_r->error;
			
		}
		
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}
	
	
	public function _InUp_Est($p=NULL){
		
		global $__cnx;
				
		if(!isN($p['id'])){	
			
			if($p['t']=='enc'){	$_id_f='up_enc'; $_id_f_t='text'; }else{ $_id_f='id_up'; $_id_f_t='int'; }
			
			$updateSQL = sprintf("UPDATE ".DB_PRC.".".MDL_UP_BD." SET up_est=%s WHERE ".$_id_f."=%s",
					   GtSQLVlStr($p['e'], "int"),
					   GtSQLVlStr($p['id'], $_id_f_t));
			
			$Result_UPD = $__cnx->_prc($updateSQL);	
				
			if($Result_UPD){ 
				
				$rsp['e'] = 'ok'; 
				
				if($p['e'] == _CId('ID_UPEST_ON')){
					
					$___up = GtUpDt([ 'id'=>$p['id'], 't'=>$p['t'] ]);
								
					$this->_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_UPDRDY'), 'v1'=>$___up->id ];
					$this->_Ntf->ntf_tp  = _CId('ID_NTFTP_UPD');
					$this->_Ntf->ntf_sub = $this->tp;
					$this->_Ntf->cl = $this->cl->id;
					$this->_Ntf->ntf_id_enc = $___up->enc;
					$this->_Ntf->ntf_id = $___up->id;
					$this->_Ntf->ntf_us = $___up->us->id;
					$__pntf = $this->_Ntf->Prc();
					
				}		
						
			}else{ 
				$rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; 
			}
		
			$rtrn = json_encode($rsp);
			return($rtrn);
		}
	}
	
	public function _InUpCol_Chk($_p=NULL){
		
		global $__cnx;
		
		if(is_array($_p)){
			
			if(!isN($_p['up']) && !isN($_p['row'])){	

				$query_DtRg = sprintf("	SELECT * 
										FROM ".DB_PRC.".".MDL_UP_COL_BD." 
										WHERE upcol_row=%s AND upcol_up=%s 
										LIMIT 1", GtSQLVlStr($_p['row'], 'text'), GtSQLVlStr($_p['up'], 'text'));
				
				$DtRg = $__cnx->_qry($query_DtRg);
				
				if($DtRg){
					
					$row_DtRg = $DtRg->fetch_assoc(); 
					$Tot_DtRg = $DtRg->num_rows;	
					
					if($Tot_DtRg > 0){	
						$Vl['e'] = 'ok';
					}else{
						$Vl['e'] = 'no';
					}
				
				}
				$__cnx->_clsr($DtRg);	
				return(_jEnc($Vl));
			}
		}
	}

}


if (class_exists('PHPExcel')) {

	class CRM_Up_RdrFltr implements PHPExcel_Reader_IReadFilter {
	
	    public function readCell($column, $row, $worksheetName = '') {
	        // Read title row and rows 20 - 30
	        if ($row == 1 || ($row >= 2 && $row <= 30)) {
	            return true;
	        }
	        return false;
	    }
	    
	}

}
	
?>