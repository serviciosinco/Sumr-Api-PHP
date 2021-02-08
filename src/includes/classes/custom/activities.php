<?php 
	
	class CRM_Act{
		
		function __construct($p=NULL) {      
			
			global $__cnx;
			$this->cl = GtClDt(Gt_SbDMN(), "sbd");
			$this->_aws = new API_CRM_Aws();
	    
	    }
	    
	    function __destruct() {
			
	   	}
		
		public function GtMdlActSLs($p=NULL){
			
			global $__cnx;
			   
			$query_DtRg =  sprintf("
									SELECT *,(
										SELECT COUNT(*)
										FROM "._BdStr(DBM).TB_ACT_SUB_RL."
										WHERE  id_actsub = actsubrl_sub
										AND actsubrl_grd = ".$p['grd']."
										AND actsubrl_act IN(
											SELECT
												id_act
											FROM
												"._BdStr(DBM).TB_ACT."
											WHERE
												act_enc = %s
										)
									) AS tot
									FROM "._BdStr(DBM).TB_ACT_SUB."
						
						",
						
						GtSQLVlStr(ctjTx($this->actenc,'out'), "text"));
			
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				
				//$Vl['qry'] = $query_DtRg;
				
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['actsub_enc']]['enc'] = $row_DtRg['actsub_enc'];
						$Vl['ls'][$row_DtRg['actsub_enc']]['nm'] = ctjTx($row_DtRg['actsub_tt'],'in');	
						$Vl['ls'][$row_DtRg['actsub_enc']]['tot'] = $row_DtRg['tot']; 
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);
			
		}
		
		
		public function _ActS_In($p=NULL){
			
			global $__cnx;
				
			$query_DtRg = sprintf("INSERT INTO ".TB_ACT_SUB_RL." (actsubrl_act, actsubrl_sub, actsubrl_grd) VALUES (  
								(SELECT id_act FROM ".TB_ACT." WHERE act_enc = %s),
								(SELECT id_actsub FROM ".TB_ACT_SUB." WHERE actsub_enc = %s), %s )",	
								GtSQLVlStr(ctjTx($this->act,'out'), "text"),
								GtSQLVlStr(ctjTx($this->actsub,'out'), "text"),
								GtSQLVlStr(ctjTx($this->grd,'out'), "text"));	

			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		}
		
		public function _ActS_Eli($p=NULL){
			
			global $__cnx;
			
			$query_DtRg = sprintf("DELETE FROM ".TB_ACT_SUB_RL." WHERE 
								actsubrl_act=(SELECT id_act FROM ".TB_ACT." WHERE act_enc = %s) AND 
								actsubrl_sub=(SELECT id_actsub FROM ".TB_ACT_SUB." WHERE actsub_enc = %s) AND 
								actsubrl_grd=%s" ,
								
								GtSQLVlStr(ctjTx($this->act,'out'), "text"),
								GtSQLVlStr(ctjTx($this->actsub,'out'), "text"),
								GtSQLVlStr(ctjTx($this->grd,'out'), "text"));		
			
			
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		}
		
		 
        public function In($p=NULL){
	        
	        global $__cnx;
	        
	        $__enc = Enc_Rnd($this->act_tt.' '.$this->act_pml);
			if(!isN($this->act_cl)){ $_cl=$this->act_cl; }else{ $_cl=DB_CL_ID; }
			if(!isN($this->act_pml)){ $_pml=$this->act_pml; }else{ $_pml=$__enc; }
			if(!isN($this->act_cd)){ $_cd=$this->act_cd; }else{ $_cd=1; }
			
			
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_ACT." 
													(
														act_enc, act_cl, act_tt, act_pml, 
														act_f_start, act_f_end, act_est, 
														act_dsc, act_fctx, act_us, act_cd, 	
														act_estd_tot, act_acmp_tot, act_lgr, act_lgrtx, 	
														act_lat, act_lng, act_mdlgen, act_fnt, act_md
												    )
													VALUES
													(
														%s, %s, %s, %s, 
														%s, %s, %s,
														%s, %s, %s, %s, 
														%s, %s, %s, %s, 
														%s, %s, %s, %s, %s
													)
											",								
									GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
									GtSQLVlStr($_cl, "int"),
									GtSQLVlStr(ctjTx($this->act_tt, 'out'), "text"),
									GtSQLVlStr(ctjTx($_pml, 'out'), "text"),
									GtSQLVlStr($this->act_f_start.' '.$this->act_h_start, "date"),
									GtSQLVlStr($this->act_f_end.' '.$this->act_h_end, "date"),
									GtSQLVlStr($this->act_est, "int"),
									GtSQLVlStr(ctjTx($this->act_dsc, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_fctx, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_us, 'out'), "text"),
									GtSQLVlStr(ctjTx($_cd, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_estd_tot, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_acmp_tot, 'out'), "text"),
									GtSQLVlStr($this->act_lgr, "int"),
									GtSQLVlStr(ctjTx($this->act_lgrtx, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_lat, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_lng, 'out'), "text"),

									GtSQLVlStr(ctjTx($this->act_mdlgen, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_fnt, 'out'), "text"),
									GtSQLVlStr(ctjTx($this->act_md, 'out'), "text")
				        );  									
													
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){
						
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['i'] = $this->nw_id_act = $__cnx->c_p->insert_id;
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ACT." SET act_cod=%s WHERE act_enc=%s",
									GtSQLVlStr('E'.$this->nw_id_act, "text"),
									GtSQLVlStr($__enc, "text")
								);
				$Result = $__cnx->_prc($updateSQL);
				
				if(!isN( $this->orgsdsact_orgsds )){ $rsp['org'] = $this->ActOrg(); }
								
			}else{
				
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' -> '.$query_DtRg;
				
			}
			
			return _jEnc($rsp); 			
	        
		}
		
		public function ActTpIn($p=NULL){
	        
	        global $__cnx;
	        
			$__enc = Enc_Rnd($this->id_act.' '.$this->tp);
			$__tp = GtMdlSTpDt([ 'tp'=>$this->tp, 't'=>'tp' ]);
			
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_ACT_TP." ( acttp_enc, acttp_act, acttp_mdlstp ) VALUES ( %s, %s, %s ) ",								
									GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
									GtSQLVlStr($this->id_act, "int"),
									GtSQLVlStr(ctjTx($__tp->id, 'out'), "text")
						);  	
													
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){
						
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				
			}
			
			return _jEnc($rsp); 			 
        }
        
        
        
        public function ActOrg($p=NULL){
	        
	        global $__cnx;
	        
	        $__enc = Enc_Rnd($this->nw_id_act.' '.$this->act_pml);
			
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ACT." (orgsdsact_enc, orgsdsact_act, orgsdsact_orgsds) VALUES (%s, %s, %s) ",					
									GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
									GtSQLVlStr($this->nw_id_act, "int"),
									GtSQLVlStr($this->orgsdsact_orgsds, "int")
				        );  				$rsp['q'] =	$query_DtRg;			
													
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){		
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
			}
			
			return _jEnc($rsp); 			
	        
		}
		
		public function ActUpdEst($p=NULL){
	        
	        global $__cnx;
	        
			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ACT." SET act_est=%s WHERE act_enc=%s",
									GtSQLVlStr($this->est, "int"),
									GtSQLVlStr(ctjTx($this->enc, 'out'), "text")
								);
			$Result = $__cnx->_prc($updateSQL);
					
			if($Result){
						
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
								
			}else{
				
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' -> '.$query_DtRg;
				
			}
			
			return _jEnc($rsp); 			
	        
		}






		function bld_json(){

			if(!isN($this->id_act)){ 

				$this->_act_d = GtActDt([ 'bd'=>$this->bd, 'id'=>$this->id_act, 'fm'=>'ok', 'sbd'=>$this->cl->sbd ]);

				if(!isN( $this->_act_d->id )){

					$r['data']['id'] = $this->_act_d->enc;
					if(!isN($this->_act_d->org)){
						$r['data']['org']['tot'] = $this->_act_d->org->tot;
						$r['data']['org']['ls'] = $this->_act_d->org->ls;
					}

					$__grd = GtActGrdLs([ 'act'=>$this->_act_d->enc ]);
					if(!isN($__grd->ls)){
						$r['data']['grd'] = $__grd;
					}

				}

			}
			
			return _jEnc( $r );
			
		}


		function sve_json($p=NULL){

			if($p['t'] == 'act'){

				$__json = $this->bld_json();
		
				if(!isN( $this->_act_d->id )){
					
					if(!isN($this->_act_d->enc)){

						$_json_lite_b = $__json->data;
						$_json_lite = cmpr_fm( json_encode( $_json_lite_b  ) );
						$_r['s']['json']['lte'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'act/'.$this->cl->sbd.'/'.$this->_act_d->enc.'.json', 'cbdy'=>$_json_lite, 'ctp'=>'application/json', 'cfr'=>'ok' ]);

						if($_sve_json->e == 'ok'){
							$_r['e'] = 'ok';
						}
					}

				}else{
					$_r['w'][] = 'No data on act_d'; 
					$_r['w'][] = $this->_act_d; 
				}

			}
	
			return _jEnc($_r);
	
		}

		
	}
	
?>