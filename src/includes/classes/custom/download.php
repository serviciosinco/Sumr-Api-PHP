<?php
	
	class CRM_Dwn {
         
	    function __construct($p=NULL) { 
	         
	        
	        
	    }
	    
	    
	    
	    public function _G_Col(){ // Get Columns
		    
		    $_r['mdlcnt']['est'] = $this->_G_Col_MdlCnt_Est();
		    $_r['mdlcnt']['his'] = $this->_G_Col_MdlCnt_His();
		    $_r['mdlcnt']['prd_a'] = $this->_G_Col_MdlCnt_PrdA();
		    $_r['mdlcnt']['noi'] = 5;
		    
		    
		    $_r['cnt']['org']['emp'] = $this->_G_Col_Cnt_Org([ 't'=>_Cns('ID_ORGTP_EMP') ]);
		    $_r['cnt']['org']['clg'] = $this->_G_Col_Cnt_Org([ 't'=>_Cns('ID_ORGTP_CLG') ]);
		    $_r['cnt']['org']['uni'] = $this->_G_Col_Cnt_Org([ 't'=>_Cns('ID_ORGTP_UNI') ]);
		    
		    $_r['cnt']['attr'] = $this->_G_Col_Cnt_Attr();
		    
		    
		    return _jEnc($_r);
		    
	    }
	    
	    
	    public function _G_Col_MdlCnt_Est($_p=NULL){
			
			global $__cnx;
				
			if(!isN($this->bd) && !isN($this->tab)){
				
				$__bd = _BdStr($this->bd);
				
				$qry_DRg = sprintf("	
				
						SELECT 
							COUNT(*) AS __tot
						FROM ".$__bd.TB_MDL_CNT_EST."
	                   		 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
	                   		 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
	                   		 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us
	                   		 
					   	WHERE mdlcntest_mdlcnt IN (	
					   								SELECT __dwn_i 
	                         						FROM "._BdStr(DBD).$this->tab."
	                         					) 
						
						GROUP BY mdlcntest_mdlcnt
						ORDER BY __tot DESC
						LIMIT 1"
						
					);
					
				$DRg = $__cnx->_qry($qry_DRg);
				
				if($DRg){
					
					$rwDRg = $DRg->fetch_assoc(); 
					$TotDRg = $DRg->num_rows;	
					
					if($TotDRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['tot'] = $rwDRg['__tot'];
					}else{
						$Vl['e'] = 'no';
					}
				}
			
				$__cnx->_clsr($DRg);
			
			}
			
			return _jEnc($Vl);
			
		}
	
	
	
	
	
		public function _G_Col_MdlCnt_His($_p=NULL){
			
			global $__cnx;
				
			if(!isN($this->bd) && !isN($this->tab)){
				
				$__bd = _BdStr($this->bd);
				
				$qry_DRg = sprintf("	
				
						SELECT 
							COUNT(*) AS __tot
						FROM ".$__bd.TB_MDL_CNT_HIS."	 
					   	WHERE mdlcnthis_mdlcnt IN (	
					   								SELECT __dwn_i 
	                         						FROM "._BdStr(DBD).$this->tab."
	                         					) 
						
						GROUP BY mdlcnthis_mdlcnt
						ORDER BY __tot DESC
						LIMIT 1"
						
					);
					
				$DRg = $__cnx->_qry($qry_DRg);
				
				if($DRg){
					
					$rwDRg = $DRg->fetch_assoc(); 
					$TotDRg = $DRg->num_rows;	
					
					if($TotDRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['tot'] = $rwDRg['__tot'];
					}else{
						$Vl['e'] = 'no';
					}
				}
			
				$__cnx->_clsr($DRg);
			
			}
			
			return _jEnc($Vl);
			
		}
	
	
		
		
		
		public function _G_Col_MdlCnt_PrdA($_p=NULL){
			
			global $__cnx;
				
			if(!isN($this->bd) && !isN($this->tab)){
				
				$__bd = _BdStr($this->bd);
				
				$qry_DRg = sprintf("	
				
						SELECT 
							COUNT(*) AS __tot
						FROM ".$__bd.TB_MDL_S_PRD."	 
					   	WHERE 	mdlcntprd_est = 1 AND
					   			mdlcntprd_mdlcnt IN (	
						   								SELECT __dwn_i 
		                         						FROM "._BdStr(DBD).$this->tab."
		                         					) 
							
						GROUP BY mdlcntprd_mdlcnt
						ORDER BY __tot DESC
						LIMIT 1"
						
					);
					
				$DRg = $__cnx->_qry($qry_DRg);
				
				if($DRg){
					
					$rwDRg = $DRg->fetch_assoc(); 
					$TotDRg = $DRg->num_rows;	
					
					if($TotDRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['tot'] = $rwDRg['__tot'];
					}else{
						$Vl['e'] = 'no';
					}
				}
			
				$__cnx->_clsr($DRg);
			
			}
			
			return _jEnc($Vl);
			
		}

	
		public function _G_Col_Cnt_Org($_p=NULL){
			
			global $__cnx;
				
			if(!isN($this->bd) && !isN($this->tab)){
				
				$__bd = _BdStr($this->bd);
				
				
				if($_p['t'] == _Cns('ID_ORGTP_EMP')){
					
					$__tpr = _CId('ID_ORGCNTRTP_TRB_PRST').' , '._CId('ID_ORGCNTRTP_TRB_PAS');
					
				}elseif( $_p['t'] == _Cns('ID_ORGTP_CLG') || $_p['t'] == _Cns('ID_ORGTP_UNI') ){
					
					$__tpr = _CId('ID_ORGCNTRTP_ESTD_PRST').' , '._CId('ID_ORGCNTRTP_ESTD_PAS');
					
				}
				
				$qry_DRg = sprintf("	
				
						SELECT 
							COUNT(*) AS __tot
						FROM ".$__bd.TB_ORG_SDS_CNT."	
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgsdscnt_tpr', 'als'=>'t'])."
							 INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
							 INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
							 INNER JOIN "._BdStr(DBM).TB_ORG_TP." ON orgtp_org = id_org
							 INNER JOIN ".$__bd.TB_CNT." ON orgsdscnt_cnt = id_cnt	
							 INNER JOIN ".$__bd.TB_MDL_CNT." ON mdlcnt_cnt = id_cnt	 

					   	WHERE 	orgtp_tp = '".$_p['t']."' AND
					   			orgsdscnt_tpr IN(".$__tpr.") AND
					   			id_mdlcnt IN (	
				   								SELECT __dwn_i 
		                 						FROM "._BdStr(DBD).$this->tab."
		                 					) 
					
						GROUP BY orgsdscnt_cnt
						ORDER BY __tot DESC
						LIMIT 1"
						
					);
					
				$DRg = $__cnx->_qry($qry_DRg);
				
				if($DRg){
					
					$rwDRg = $DRg->fetch_assoc(); 
					$TotDRg = $DRg->num_rows;	
					
					if($TotDRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['tot'] = $rwDRg['__tot'];
					}else{
						$Vl['e'] = 'no';
					}
				}
			
				$__cnx->_clsr($DRg);
			
			}
			
			return _jEnc($Vl);
			
		}
	
	
	
		public function _G_Col_Cnt_Attr($_p=NULL){
			
			global $__cnx;
				
			if(!isN($this->bd) && !isN($this->tab)){
				
				$__bd = _BdStr($this->bd);
				
				$qry_DRg = sprintf("	
				
						SELECT 
							COUNT(*) AS __tot
						FROM ".$__bd.TB_CNT_ATTR."	
							 INNER JOIN ".$__bd.TB_CNT." ON cntattr_cnt = id_cnt
							 INNER JOIN ".$_cl_dt->bd.".".TB_MDL_CNT." ON mdlcnt_cnt = id_cnt	 

					   	WHERE mdlcnthis_mdlcnt IN (	
					   								SELECT __dwn_i 
	                         						FROM "._BdStr(DBD).$this->tab."
	                         					) 
						
						GROUP BY cntattr_cnt
						ORDER BY __tot DESC
						LIMIT 1"
						
					);
					
				$DRg = $__cnx->_qry($qry_DRg);
				
				if($DRg){
					
					$rwDRg = $DRg->fetch_assoc(); 
					$TotDRg = $DRg->num_rows;	
					
					if($TotDRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['tot'] = $rwDRg['__tot'];
					}else{
						$Vl['e'] = 'no';
					}
				}
			
				$__cnx->_clsr($DRg);
			
			}
			
			return _jEnc($Vl);
			
		}
	
	
	
	
	
	
	
    
    }
    
 ?>