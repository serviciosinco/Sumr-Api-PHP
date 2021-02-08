<?php 
	
	class CRM_Api{
		
		public $new_rqu_id = '';

		function __construct($p=NULL) {      
	    
	    }
	    
	    function __destruct() {
			
	   	}

		
		//--------------------- Connect API Session ---------------------//

		public function _Cnx($p=NULL){
		
			global $__cnx;
			
			$Vl['e'] = false;
			
			$LgAPI_a = _GetPost('__a');
			$LgAPI_k = _GetPost('__k');
			$LgAPI_p = _GetPost('__p');
			$LgAPI_u = _GetPost('__u');
			  
			  
			if(!isN($LgAPI_a) && !isN($LgAPI_k) && !isN($LgAPI_p) && !isN($LgAPI_u)){
	
				$LgAPI__query = sprintf(" SELECT id_cl 
										  FROM ".TB_CL." 
										  WHERE cl_prfl=%s
										  LIMIT 1", GtSQLVlStr($LgAPI_a, "text"));
											
				$LgAPI = $__cnx->_qry($LgAPI__query);
				
				
				if($LgAPI){
					
					$row_LgAPI = $LgAPI->fetch_assoc(); 
					$LgAPI_FU = $LgAPI->num_rows;
		
					$Vl['rq'] = $this->_Rq([ 'p1'=>$p['p1'], 'p2'=>$p['p2'], 'p3'=>$p['p3'] ]);
				
					if($LgAPI_FU == 1){ 	
						
						$__cl_dt = GtClDt($row_LgAPI['id_cl']);
						$Vl['cl'] = $__cl_dt;
						
						if(!isN($__cl_dt->sbd)){
							
							$LgAPI_tkn__query = sprintf("SELECT id_us 
														 FROM "._BdStr(DBM).TB_US_TKN." 
															   INNER JOIN "._BdStr(DBM).TB_US." ON ustkn_us = id_us
															   INNER JOIN "._BdStr(DBM).TB_CL." ON ustkn_cl = id_cl
														 WHERE ustkn_key=%s AND ustkn_pass=%s AND us_user=%s AND cl_enc=%s 
														 LIMIT 1", 
														 
														 GtSQLVlStr($LgAPI_k, "text"), 
														 GtSQLVlStr($LgAPI_p, "text"), 
														 GtSQLVlStr($LgAPI_u, "text"),
														 GtSQLVlStr($__cl_dt->enc, "text"));
														 
							$LgAPI_tkn = $__cnx->_qry( $LgAPI_tkn__query );
							
							if($LgAPI_tkn){
								
								$row_LgAPI_tkn = $LgAPI_tkn->fetch_assoc(); 
								$LgAPI_FU_tkn = $LgAPI_tkn->num_rows;
								
								//$__us_dt = GtUsDt($row_LgAPI_tkn['id_us']);
								$Vl['us']['id'] = $row_LgAPI_tkn['id_us'];
								
							}else{
								//$Vl['w'] = $__cnx->c_r->error;
							}
							
							$__cnx->_clsr($LgAPI);
							
						}
						
						if($LgAPI_FU_tkn == 1){
							$Vl['e'] = true;
						}else{ 
							$Vl['e'] = false; 	 
						}
						
					}else{ 
						$Vl['e'] = false;
					}
				
				}
				
				$__cnx->_clsr($LgAPI_tkn);
			
			}else{
				
				if(isN($LgAPI_a)){ $Vl['w'][] = 'No envia ID de cuenta'; }
				if(isN($LgAPI_k)){ $Vl['w'][] = 'No envia Key'; } 
				if(isN($LgAPI_p)){ $Vl['w'][] = 'No envia Password'; } 
				if(isN($LgAPI_u)){ $Vl['w'][] = 'No envia Usuario'; }
				
			}
	
			
			return(_jEnc($Vl)); 
		}
		
		
		//--------------------- Validate JSON ---------------------//

		public function jVldt($string) {
			
			if (is_string($string)) {
				
				@json_encode($string);
				
				$__w = json_last_error();
				
				if($__w == JSON_ERROR_NONE){
					$Vl['e'] = 'ok';
				}else{
					$Vl['e'] = 'no'; 
					$Vl['w'] = $__w; 
				}
			}
			
			$rtrn = json_decode(json_encode($Vl)); 
			return($rtrn); 
		}
		
		
		//--------------------- Save each API Request ---------------------//

		public function _Rq($p=NULL){
			
			global $__cnx;
			
			$rsp['e'] = 'no';
			
			$IpUs = KnIp("on");	
			
			$j_dataj  = json_encode(_PostR_JData()) ;
			$__jw[] = print_r( $this->jVldt($j_dataj) , true) ;
			$j_urw  = json_encode( _PostRw() );
			$__jw[] = print_r( $this->jVldt($j_urw) , true);
			$j_post = json_encode($_POST);
			$__jw[] = print_r( $this->jVldt($j_post) , true);
			$j_get = json_encode($_GET);
			$__jw[] = print_r( $this->jVldt($j_get) , true);
			$j_srv = json_encode($_SERVER);
			$__jw[] = print_r( $this->jVldt($j_srv) , true);
			
			$__enc = Enc_Rnd($j_post);
			
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_API_RQ." (apirq_enc, apirq_p1, apirq_p2, apirq_p3, apirq_p4, apirq_p5, apirq_datajson, apirq_raw, apirq_post, apirq_get, apirq_server, apirq_ip, apirq_tp, apirq_w, apirq_us) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
							   GtSQLVlStr( $__enc, "text"),
							   GtSQLVlStr( $p['p1'], "text"),
							   GtSQLVlStr( $p['p2'], "text"),
							   GtSQLVlStr( $p['p3'], "text"),
							   GtSQLVlStr( $p['p4'], "text"),
							   GtSQLVlStr( $p['p5'], "text"),
							   GtSQLVlStr( $j_dataj, "text"),
							   GtSQLVlStr( $j_urw, "text"),
							   GtSQLVlStr( $j_post, "text"),
							   GtSQLVlStr( $j_get, "text"),
							   GtSQLVlStr( $j_srv, "text"),
							   GtSQLVlStr( $IpUs, "text"),
							   GtSQLVlStr( $_SERVER['REQUEST_METHOD'], "text"),
							   GtSQLVlStr( print_r($__jw, true), "text"),
							   GtSQLVlStr( !isN($p['us'])?$p['us']:1, "int"));
	
			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$this->new_rqu_id = $rsp['enc'] = $__enc;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1; 
			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp);

			$rsp['e'] = 'ok';
			
		}
		
		
		//--------------------- Connect API ---------------------//

        public function _RqDt($p=NULL){
        
            global $__cnx; 
            
            $Vl['e'] = 'no';
            
            if(!isN($p['id'])){

                if($p['t'] == 'enc'){ $__f = 'apirq_enc'; $__ft = 'text'; }
                else{ $__f = 'id_apirq'; $__ft = 'int'; }
            
                $DtQry = sprintf("  SELECT *
                                    FROM "._BdStr(DBM).TB_API_RQ."
                                    WHERE ".$__f."=%s
                                    LIMIT 1",
									GtSQLVlStr($p['id'], $__ft)
								);
                                            
                $QryR = $__cnx->_qry($DtQry);
                
                if($QryR){

					$Vl['e'] = 'ok';
					
                    $rowQry = $QryR->fetch_assoc(); 
                    $totQry = $QryR->num_rows;
                
                    if($totQry == 1){ 
						$Vl['id'] = $rowQry['id_apirq'];
						$Vl['next']['v'] = $rowQry['apirq_next_v'];
                    }
                }
                
                $__cnx->_clsr($QryR);
            
            }else{
                
                if(isN($p['id'])){ $Vl['w'][] = 'No ID de request'; }
                
            }

            
            return(_jEnc($Vl)); 
		}
		
		
		//--------------------- Update Fields of Request ---------------------//
		
		public function _Rq_Upd($p=NULL){
			
			global $__cnx; 
			
			if(!isN($this->new_rqu_id)){
				
				if(!isN($p['rsp'])){ $_upd[] = sprintf('apirq_rsp=%s', GtSQLVlStr(json_encode($p['rsp']), "text")); }
				if(!isN($p['nxt_v'])){ $_upd[] = sprintf('apirq_next_v=%s', GtSQLVlStr($p['nxt_v'], "text")); }
				if(!isN($p['e'])){ $_upd[] = sprintf('apirq_e=%s', GtSQLVlStr($p['e'], "text")); }

				if(count($_upd) > 0){
					
					try {	
						
						$updateSQL = "UPDATE "._BdStr(DBM).TB_API_RQ." SET ".implode(',', $_upd)." WHERE apirq_enc=".GtSQLVlStr( $this->new_rqu_id , "text")." LIMIT 1"; 
						$ResultUPD = $__cnx->_prc($updateSQL);
						//$rsp['upd'] = $updateSQL;
						
					} catch (Exception $e) {
				
						$rsp['w'] = $e->getMessage();
			
					}
				
				}
				
				if($ResultUPD){
					$rsp['e'] = 'ok';
					$rsp['enc'] = $this->new_rqu_id;
				}else{
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['e'] = 'no';
				}
				
			}else{
				
				$rsp['e'] = 'no';
				$rsp['w'] = 'no all data';
				
			}
				
			return _jEnc($rsp);	
		}
		

		//--------------------- Save Ses and Next Ids ---------------------//

        public function _Nxt($p=NULL){
			
			return $this->_Rq_Upd([ 'nxt_v'=>$p['nxt_v'] ]);

		}
		
	}
	
?>