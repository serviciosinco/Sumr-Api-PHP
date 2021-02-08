<?php 
	
	class CRM_Appl extends CRM_Cl {
	         
	    function __construct($p=NULL) {
		    
		    global $__cnx;    
			$this->c_r = $__cnx->c_r;
			$this->c_p = $__cnx->c_p;


			$this->gt_cl = $this->GtCl([ 't'=>'enc' ]);
			$this->org_tp = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'org_tp' ]);
	    }
	
		function __destruct() {
			parent::__destruct();
		}

		function _fields($p=NULL){
		
			$__mdlcntattr = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'appl_attr', 'cl'=>$this->gt_cl->id ]); 
			
			if(!isN($__mdlcntattr->ls)){	
				foreach($__mdlcntattr->ls->mdl_cnt_attr as $mdlcntattr_k=>$mdlcntattr_v){
					$__hd_on = mBln($mdlcntattr_v->url_track->vl);	
					if($__hd_on == 'ok'){	
						$d['hdn'] .= HTML_inp_hd('____ext_'.$this->_rnd.'[appl]['.$mdlcntattr_v->key->vl.']', Php_Ls_Cln($_GET[ $mdlcntattr_v->get->vl ]) );	
					}
				}
			}
			
			return(_jEnc($d));
		}

		function _fdata(){
			$this->data = _jEnc($this->data, [ 's_in'=>'ok' ]);
		}

		function _pdata(){
			
			$this->_fdata();
			
			$_k = Php_Ls_Cln($this->data->____key);

			//------------------ DATOS BASE - START ------------------//
				
				if(!isN( $this->data->{'Cnt_Mdl'.$_k} )){ $d['cnt_mdl'] = $this->data->{'Cnt_Mdl'.$_k}; }
				if(!isN( $this->data->{'Cnt_Mdl_Rel'.$_k} )){ $d['cnt_mdl_rel'] = $this->data->{'Cnt_Mdl_Rel'.$_k}; }
				if(!isN( $this->data->{'Cnt_Nm'.$_k} )){ $d['cnt_nm'] = $this->data->{'Cnt_Nm'.$_k}; }
				if(!isN( $this->data->{'Cnt_Ap'.$_k} )){ $d['cnt_ap'] = $this->data->{'Cnt_Ap'.$_k}; }
				if(!isN( $this->data->{'Cnt_Fn'.$_k} )){ $d['cnt_fn'] = $this->data->{'Cnt_Fn'.$_k}; }
				if(!isN( $this->data->{'Cnt_Cd'.$_k} )){ $d['cnt_cd'] = $this->data->{'Cnt_Cd'.$_k}; }
				if(!isN( $this->data->{'Cnt_Ps'.$_k} )){ $d['cnt_ps'] = $this->data->{'Cnt_Ps'.$_k}; }
				if(!isN( $this->data->{'Cnt_Tel'.$_k} )){ $d['cnt_tel'] = $this->data->{'Cnt_Tel'.$_k}; }
				if(!isN( $this->data->{'Cnt_Cel'.$_k} )){ $d['cnt_cel'] = $this->data->{'Cnt_Cel'.$_k}; }
				if(!isN( $this->data->{'Cnt_Tel_Ps'.$_k} )){ $d['cnt_tel_ps'] = $this->data->{'Cnt_Tel_Ps'.$_k}; }	
				if(!isN( $this->data->{'Cnt_Cmnt'.$_k} )){ $d['cnt_cmnt'] = $this->data->{'Cnt_Cmnt'.$_k}; }
				if(!isN( $this->data->{'Cnt_Sch'.$_k} )){ $d['cnt_sch'] = $this->data->{'Cnt_Sch'.$_k}; } 
				if(!isN( $this->data->{'Cnt_Dir'.$_k} )){ $d['cnt_dir'] = $this->data->{'Cnt_Dir'.$_k}; } 
				if(!isN( $this->data->{'Appl_Fm'.$_k} )){ $d['appl_fm'] = $this->data->{'Appl_Fm'.$_k}; } 
				if(!isN( $this->data->{'Cnt_Sx'.$_k} )){ $d['cnt_sx'] = $this->data->{'Cnt_Sx'.$_k}; }
				if(!isN( $this->data->{'Cd_Rds'.$_k} )){ $d['cnt_rds'] = $this->data->{'Cd_Rds'.$_k}; $d['cnt_rds_rel'] = _CId('ID_TPRLCC_VVE'); }
				if(!isN( $this->data->{'Cd_Nac'.$_k} )){ $d['cnt_nac'] = $this->data->{'Cd_Nac'.$_k}; $d['cnt_nac_rel'] = _CId('ID_TPRLCC_NCO'); }
				
			
			
			//------------------ VERIFICACIÓN LLAVES - START ------------------//

				if(!isN( $this->data->{'Cnt_Doc'.$_k} )){ $d['cnt_dc'] = $this->data->{'Cnt_Doc'.$_k}; } 
				
				if(!isN( $this->data->{'Cnt_DocTp'.$_k} )){ $d['cnt_dc_tp'] = $this->data->{'Cnt_DocTp'.$_k}; }
				
				if(!isN( $this->data->{'Cnt_DocExp'.$_k} )){ $d['cnt_dc_exp'] = $this->data->{'Cnt_DocExp'.$_k}; }
				
				if(!isN( $this->data->{'Cnt_Eml'.$_k} )){ 
					if(filter_var($this->data->{'Cnt_Eml'.$_k}, FILTER_VALIDATE_EMAIL)){
						$d['cnt_eml'] = $this->data->{'Cnt_Eml'.$_k}; 
					}else{
						$d['cnt_eml']['w'] = TX_WRNGML;	
					}
				} 	

			//------------------ RELACIÓN A MODULO ------------------//

				if(!isN( $this->data->{'Cnt_Mdl'.$_k} )){ 
					$__mdl = GtMdlDt([ 't'=>'enc', 'id'=>$this->data->{'Cnt_Mdl'.$_k} ]);
					$d['mdl'] = $__mdl; 
					if(!isN($__mdl->tp->id)){ $this->_get_mdlstp = $__mdl->tp->id; }
				}
	

			//------------------ DATA ANEXA APLICACION ------------------//

				if(!isN( $this->data->{'____ext_'.$_k}->appl )){ 
					
					$__mdlcntattr = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'appl_attr', 'cl'=>$__Forms->gt_cl->id ]);
					
					foreach($__mdlcntattr->ls->appl_attr as $_ca_k=>$_ca_v){
						$__mca[$_ca_v->key->vl]= [ 'id'=>$_ca_k ];		
					}
					
					foreach($this->data->{'____ext_'.$_k}->appl as $_ext_k=>$_ext_v){	
						if(!isN($_ext_v)){
							$d['_ext_']['appl'][$_ext_k]['id'] = $__mca[$_ext_k]['id'];
							$d['_ext_']['appl'][$_ext_k]['vl'] = $_ext_v;	
						}
					}
	
				}
			
			//------------------ DATA POLITICA DE PRIVACIDAD ------------------//
				
				if(!isN($this->data->{'Plcy_Id'.$_k})){
					$__plcy = GtClPlcyDt([ 'cnx'=>$this->c_r, 't'=>'enc', 'id'=>$this->data->{'Plcy_Id'.$_k} ]); 
					$d['plcy_id'] = $__plcy->id;
				}
				
			//------------------ DATA CONTACTO ------------------//	
				if(!isN( $this->data->{'____ext_'.$_k}->cnt )){ 

					$__cntattr = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'cnt_attr', 'cl'=>$__Forms->gt_cl->id ]);
					
					foreach($__cntattr->ls->cnt_attr as $_ca_k=>$_ca_v){
						$__mca[$_ca_v->key->vl]= [ 'id'=>$_ca_k ];		
					}
					
					foreach($this->data->{'____ext_'.$_k}->cnt as $_ext_k=>$_ext_v){	
						if(!isN($_ext_v)){
							$d['_ext_']['cnt'][$_ext_k]['id'] = $__mca[$_ext_k]['id'];
							$d['_ext_']['cnt'][$_ext_k]['vl'] = $_ext_v;
						}
					}	
				}

			//------------------ DATA TOPIC ------------------//	
				if(!isN( $this->data->{'__ext'}->appl->cs_no_tlr )){ 

					foreach($this->data->{'__ext'}->appl->cs_no_tlr as $_ext_k=>$_ext_v){	
						if(!isN($_ext_v)){
							$d['_ext_']['cs_no_tlr'][$_ext_k]['enc'] =$_ext_k;
							$d['_ext_']['cs_no_tlr'][$_ext_k]['vl'] = $_ext_v;
						}
					}	
				}
			
			//------------------ DATA ROOMMATES ------------------//	
				if(!isN( $this->data->{'romt_cnt'} )){ 

					foreach($this->data->{'romt_cnt'} as $_ext_k=>$_ext_v){	
						if(!isN($_ext_v)){
							$d['_ext_']['romt'][$_ext_k]['cnt'] = $_ext_v->cnt;
							$d['_ext_']['romt'][$_ext_k]['vl'] = $_ext_v->tp;
						}
					}	
				}
			
			//------------------ DATA FINANCIEROS ------------------//	
				if(!isN( $this->data->{'____ext_'.$_k}->resp_finan )){ 

					foreach($this->data->{'____ext_'.$_k}->resp_finan as $_ext_k=>$_ext_v){	
						if(!isN($_ext_v)){
							$d['_ext_']['resp_finan'][$_ext_k]['id'] = $_ext_k;
							$d['_ext_']['resp_finan'][$_ext_k]['vl'] = $_ext_v;
						}
					}	
					
					foreach($this->data->{'____ext_'.$_k}->resp_finan->appl as $_ext_k_a=>$_ext_v_a){	
						if(!isN($_ext_v_a)){
							$d['_ext_']['resp_finan_app'][$_ext_k_a]['id'] = $_ext_k_a;
							$d['_ext_']['resp_finan_app'][$_ext_k_a]['vl'] = $_ext_v_a;
						}
					}
				}
		
				//------------------ DATA FINANCIEROS 2 ------------------//	
				
				
				if(!isN( $this->data->{'____ext_'.$_k}->resp_finan2 )){ 
					
					foreach($this->data->{'____ext_'.$_k}->resp_finan2 as $_ext__k=>$_ext__v){	
						if(!isN($_ext_v)){
							$d['_ext_']['resp_finan2'][$_ext__k]['id'] = $_ext__k;
							$d['_ext_']['resp_finan2'][$_ext__k]['vl'] = $_ext__v;
						}
					}	
					
					foreach($this->data->{'____ext_'.$_k}->resp_finan2->appl as $_ext__k_a=>$_ext__v_a){	
						if(!isN($_ext_v_a)){
							$d['_ext_']['resp_finan2_app'][$_ext__k_a]['id'] = $_ext__k_a;
							$d['_ext_']['resp_finan2_app'][$_ext__k_a]['vl'] = $_ext__v_a;
						}
					}
				}
				
			// -----------------  DATOS QUE SE INSERTAN EN LAS TABLAS  ----------------- //	
			
				$__mdlcntattr = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'appl_attr', 'cl'=>$__Forms->gt_cl->id ]);
				foreach($__mdlcntattr->ls->appl_attr as $_ca_k=>$_ca_v){
					$__mca[$_ca_v->key->vl]= [ 'id'=>$_ca_k ];		
				}
			
				if(!isN( $this->data->{'OthWrtCd_Nac'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtCd_Nac'.$_k}]);

					if($cd->e == 'ok'){
						$d['cnt_nac'] = $cd->i;
						$d['cnt_nac_rel'] = _CId('ID_TPRLCC_NCO');	
					}
				}
				
				if(!isN( $this->data->{'OthWrtCd_Rds'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtCd_Rds'.$_k}]);
					if($cd->e == 'ok'){
						$d['cnt_rds'] = $cd->i;	
						$d['cnt_rds_rel'] = _CId('ID_TPRLCC_VVE');	
					}
				}
				
				if(!isN( $this->data->{'OthWrtcd_uni'.$_k} )){ 
					
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd_uni'.$_k}]);		
					
					if($cd->e == 'ok'){
						$d['_ext_']['appl']['cd_uni']['id'] = $__mca['cd_uni']['id'];
						$d['_ext_']['appl']['cd_uni']['vl'] = $cd->i;
					}
				}
				
				if(!isN( $this->data->{'OthWrtcd_nac_resp_finan'.$_k} )){ 
					
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd_nac_resp_finan'.$_k}]);
					if($cd->e == 'ok'){
						
						$d['_ext_']['resp_finan']['cd_nac_resp_finan']['id'] = $__mca['cd_nac_resp_finan']['id'];
						$d['_ext_']['resp_finan']['cd_nac_resp_finan']['vl'] = $cd->i;
						$d['cnt_nac_rel'] = _CId('ID_TPRLCC_NCO');	
					}				
					
					
				}
				
				if(!isN( $this->data->{'OthWrtcd_res_resp_finan'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd_res_resp_finan'.$_k}]);		
					
					if($cd->e == 'ok'){

						
						$d['_ext_']['resp_finan']['cd_res_resp_finan']['id'] = $__mca['cd_res_resp_finan']['id'];
						$d['_ext_']['resp_finan']['cd_res_resp_finan']['vl'] = $cd->i;
						$d['cnt_rds_rel'] = _CId('ID_TPRLCC_VVE');
					}
				}
				
				if(!isN( $this->data->{'OthWrtcd_org_resp_finan'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd_org_resp_finan'.$_k}]);	
					if($cd->e == 'ok'){	
						
						$d['_ext_']['resp_finan_app']['cd_org_resp_finan']['id'] = $__mca['cd_org_resp_finan']['id'];
						$d['_ext_']['resp_finan_app']['cd_org_resp_finan']['vl'] = $cd->i;
					}
				}

				if(!isN( $this->data->{'OthWrtcd2_nac_resp_finan'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd2_nac_resp_finan'.$_k}]);				

					if($cd->e == 'ok'){	
						$d['_ext_']['resp_finan2']['cd2_nac_resp_finan']['id'] = $__mca['cd2_nac_resp_finan']['id'];
						$d['_ext_']['resp_finan2']['cd2_nac_resp_finan']['vl'] = $cd->i;
						$d['cnt_nac_rel'] = _CId('ID_TPRLCC_NCO');
					}
				}
				
				if(!isN( $this->data->{'OthWrtcd2_res_resp_finan'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd2_res_resp_finan'.$_k}]);				
					
					if($cd->e == 'ok'){	
						$d['_ext_']['resp_finan2']['cd2_res_resp_finan']['id'] = $__mca['cd2_res_resp_finan']['id'];
						$d['_ext_']['resp_finan2']['cd2_res_resp_finan']['vl'] = $cd->i;
						$d['cnt_rds_rel'] = _CId('ID_TPRLCC_VVE');
					}
				}
				
				if(!isN( $this->data->{'OthWrtcd2_org_resp_finan'.$_k} )){ 
					$cd = $this->LsNewCd(['id'=> $this->data->{'OthWrtcd2_org_resp_finan'.$_k}]);	
								
					if($cd->e == 'ok'){	
						$d['_ext_']['resp_finan2_app']['cd2_org_resp_finan']['id'] = $__mca['cd2_org_resp_finan']['id'];
						$d['_ext_']['resp_finan2_app']['cd2_org_resp_finan']['vl'] = $cd->i;
					}
				}

			//------------------ DATOS ORGANIZACIONES ------------------//

				foreach($this->org_tp->ls->org_tp as $_org_k=>$_org_v){ 
					
					$_org_id = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).$_k};
					$_org_tpr = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).'Tpr'.$_k};
					$_org_tpr_o = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).'TprO'.$_k};
						
					if(!isN($_org_id) && !isN($_org_tpr)){ 
						$d['cnt_org'][] = [
							'id'=>$_org_id,
							'tpr'=>$_org_tpr,
							'tpr_o'=>$_org_tpr_o
						];
					}
				}

			//------------------ CODIFICA Y RETORNA ------------------//

			return(_jEnc($d, [ 's_in'=>'ok' ]));
			
		}	

		public function _mdlfm_qry($_p=NULL){	
			
			global $__cnx;					

			//-------------- MODULO SIMPLE --------------//

			//-------------- MODULO LISTADO GENERAL --------------//
			
			if(!isN($this->fm_id)){ $_fl .= " AND applfm_enc = '".$this->fm_id."' ";}

				$_bd_main = _BdStr(DBM).TB_APPL_FM; 
				$_id_main='id_applfm';

				$_innr_row = " INNER JOIN "._BdStr(DBM).TB_APPL_FM_ROW_FLD." ON applfmrowfld_applfmrow = id_applfmrow ";
				$_innr_col = "applfmrowfld_fld";
				$_innr_ord = "applfmrowfld_ord";	
				$_innr_enc = "applfmrowfld_enc";

			$query_DtRg = "	SELECT *,
								  "._QrySisSlcF(['als'=>'f', 'cl'=>$_innr_cl, 'als_n'=>'field']).",
								  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'field', 'als'=>'f' ])."
							FROM ".$_bd_main." 
								 INNER JOIN "._BdStr(DBM).TB_APPL_FM_ROW." ON applfmrow_applfm = id_applfm
								 INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON applfm_plcy = id_clplcy 
								 {$_innr_row}
								 ".GtSlc_QryExtra(['t'=>'tb', 'cl'=>$_innr_cl, 'col'=>$_innr_col, 'als'=>'f'])."
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." stp ON f.sisslc_tp = stp.id_sisslctp
								 
							WHERE {$_id_main} != '' $_fl 
							ORDER BY applfmrow_ord ASC, ".$_innr_ord." ASC $_ord";
			
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if(!isN($_p['v'])){ $Vl=$_p['v']; }
				
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;					
				
				if($Tot_DtRg > 0){ 
						
					$Vl['e'] = 'ok';
					$Vl['tot'] = $_slc_glbl['tot'];
					
					do{	
						
						$Vl = $this->_mdlfm_dt_bld([ 'cnx'=>$this->c_r, 'cl'=>$_innr_cl, 'v'=>$Vl, 'rw'=>$row_DtRg ]);
															
					}while($row_DtRg = $DtRg->fetch_assoc());
					
				}else{
					
					if(isN($Vl['e'])){ $Vl['e'] = 'no'; }
					
				}	
			
			}else{
				
				$Vl['wsd'] = $query_DtRg;
				$Vl['w'] = $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($DtRg);

			return $Vl;
		}
		
		public function LsNewCd($_p=NULL){ 
			
			global $__cnx;
			
			$__enc = Enc_Rnd($_p['id'].' Ciudad'); 
			
			$query = sprintf("INSERT INTO "._BdStr(DBM).MDL_SIS_CD_BD." (siscd_enc, siscd_tt, siscd_dp, siscd_vrf) VALUES (%s, %s, %s, %s)",
			                               GtSQLVlStr($__enc, "text"),
			                               GtSQLVlStr($_p['id'], "text"),
			                               GtSQLVlStr(89, "int"),
			                               GtSQLVlStr(2, "int")); 

										   
	        if(!isN($query)){ 
		        $Result = $__cnx->_prc($query);
		        if($Result){ 
			        $_r['e'] = 'ok';
			        $_r['i'] = $__cnx->c_p->insert_id; 
			    }else{
				    $_r['e'] = 'no';
				    $_r['qry'] = $$__cnx->c_p->error;
		        }
	        }else{
		    	$_r['w'] = 'No query string';
	        }	

	        return(_jEnc($_r));
			
		}

		public function _mdlfm_dt_bld($_p=NULL){
		
			$_rw = $_p['rw'];
			$Vl = $_p['v'];
			
			$__field = GtSlcF_Attr([ 'id'=>$_rw['field_sisslc_enc'], 't'=>'enc' ]);
			
			if(!isN($__field->ls)){
			    
			    $__toa_attr[ 'id_sisslc' ] = $_rw['field_id_sisslc'];
			    foreach($__field->ls as $_attr_k=>$_attr_v){
				    $__toa_attr[ $_attr_v->key ] = $_attr_v;
			    }
			    
		    }else{
			    
			    $__toa_attr = NULL;
			    
		    }

		    if(!isN($_rw['___theme'])){

			    $__theme_attr = json_decode($_rw['___theme']);
			    
			    if(!isN($__theme_attr) && is_array($__theme_attr)){
				    foreach($__theme_attr as $_attr_k=>$_attr_v){
					    $__thm_attr[ $_attr_v->key ] = $_attr_v;
				    }
			    }

		    }else{  
			    $__thm_attr = NULL;	    
		    }

			$Vl['id'] = ctjTx($_rw['id_applfm'], 'in');
			$Vl['enc'] = ctjTx($_rw['applfm_enc'], 'in');
			
			$Vl['thx']['top'] = mBln($_rw['applfm_thx_top']);
			$Vl['thx']['url'] = ctjTx($_rw['applfm_thx_url'], 'in');
			
			
			$Vl['plcy']['id'] = ctjTx($_rw['id_clplcy'], 'in');
			$Vl['plcy']['enc'] = ctjTx($_rw['clplcy_enc'], 'in');
			$Vl['plcy']['nm'] = ctjTx($_rw['clplcy_nm'], 'in');
			$Vl['plcy']['tx'] = ctjTx($_rw['clplcy_tx'], 'in');
			
			$Vl['plcy']['v'] = ctjTx($_rw['clplcy_v'], 'in');
			
			
			$Vl['thx']['top'] = mBln($_rw['applfm_thx_top']);
			$Vl['thx']['url'] = ctjTx($_rw['applfm_thx_url'], 'in');
			
			/*$Vl['plcy']['lnk']['url'] = ctjTx($_rw['clplcy_lnk'], 'in');
			$Vl['plcy']['lnk']['tt'] = ctjTx($_rw['clplcy_lnk_tt'], 'in');*/
			

			/*$Vl['plpcy']['lnk']['tt'] = ctjTx($_rw['applfm_plcytt'], 'in');
			$Vl['plpcy']['lnk']['tx'] = ctjTx($_rw['applfm_plcytx'], 'in');
			$Vl['plpcy']['lnk']['url'] = ctjTx($_rw['applfm_plcylnk'], 'in');*/
			
			$Vl['thm']['id'] = $_rw['applfm_thm'];
			$Vl['thm']['attr'] = $__thm_attr;

			foreach($this->org_tp->ls->org_tp as $_k=>$_v){ 
				$Vl['shw']['org'][$_v->key->vl] = mBln($_rw['applfm_s_org_'.$_v->key->vl]);
			}
			
			$Vl['shw']['vst'] = mBln($_rw['applfm_s_vst']);					
			$Vl['shw']['sch'] = mBln($_rw['applfm_s_sch']);
			
			
			$_row_id = $_rw['applfmrowfld_enc'];

			//if(!isN($_rw[$_innr_enc])){
				
				$_fld_id = 'fld-'.$_row_id;
				$_row_ord = 'row-'.$_rw['applfmrow_ord'];
				
				$Vl['row'][$_row_ord]['f'][$_fld_id]['id'] = ctjTx($_rw['id_applfmrowfld'], 'in');
				
				if($_p['cl']=='ok'){ $Vl['row'][$_row_ord]['f'][$_fld_id]['cl'] = 'ok'; }
				
				$Vl['row'][$_row_ord]['f'][$_fld_id]['attr'] = $__toa_attr;
				$Vl['row'][$_row_ord]['tot']++;
			
			//}
			
			return $Vl;			
		}

		public function _mdlfm_dt($_p=NULL){			

			$Vl = $this->_mdlfm_qry();
			$Vl = $this->_mdlfm_qry([ 't'=>'cl', 'v'=>$Vl ]); 

			return(_jEnc($Vl));
		}
		
		
	// ------- I - Contacto Aplicacion  ------ //
    
		public function CntAppl($p=NULL){
			
			global $__cnx;

			if(!isN($this->id_cnt)){
				
				$__enc = Enc_Rnd($this->appl.'-'.$this->id_cnt); 
				 
				$query = sprintf("INSERT INTO ".$this->gt_cl->bd.".".TB_CNT_APPL." (cntappl_enc, cntappl_cnt, cntappl_appl, cntappl_mdl, cntappl_est) VALUES (%s, %s, (SELECT id_applfm FROM "._BdStr(DBM).TB_APPL_FM." WHERE applfm_enc = %s ), (SELECT id_mdl FROM ".$this->gt_cl->bd.".".TB_MDL." WHERE mdl_enc = %s), %s)",
				                               GtSQLVlStr($__enc, "text"),
				                               GtSQLVlStr($this->id_cnt, 'int'),
				                               GtSQLVlStr($this->appl, "text"),
											   GtSQLVlStr($this->mdl, "text"),
											   GtSQLVlStr(2, 'int'));
			}        
			              
			if(!isN($query)){ 

		        $Result = $__cnx->_prc($query);
		      
		        if($Result){ 
			        
			        $_r['e'] = 'ok';
			        
			        $query_DtRg = '	SELECT * FROM '.$this->gt_cl->bd.'.'.TB_CNT_APPL.' WHERE id_cntappl != "" AND id_cntappl = "'.$__cnx->c_p->insert_id.'" ';
					$DtRg = $__cnx->_qry($query_DtRg); 
	
					if($DtRg){
						$row_DtRg = $DtRg->fetch_assoc(); 
						$Tot_DtRg = $DtRg->num_rows;	
						if($Tot_DtRg > 0){
							
							$_r['id'] = $row_DtRg['id_cntappl'];
							$_r['id_appl'] = $row_DtRg['cntappl_enc'];
							
						}
					}

					$__cnx->_clsr($DtRg);
			        
			        $_r['extall'] = $this->ExtAllAppl(['id'=>$__cnx->c_p->insert_id]);

			    }else{ $_r['ws'][] = $__cnx->c_p->error; $_r['w3'][] = $this->c_r->error; }
		        
	        }else{ $_r['w'] = 'No query string';  }
	        
	        return _jEnc($_r);             			
		}

		public function ExtPrntAllAppl($_p=NULL){ 
	
			global $__cnx;

	        if(!isN($this->id_cnt) && (!isN($this->ext_all_prnt))){

	           foreach($this->ext_all_prnt as $ext_k=>$ext_v){

		            $query = sprintf("SELECT * FROM ".DBM."._sis_slc_f WHERE sisslcf_vl = %s ", GtSQLVlStr($ext_k, "text"));

		            if(!isN($query)){

						$DtRg = $__cnx->_qry($query);
						
						$row_DtRg = $DtRg->fetch_assoc(); 
						$Tot_DtRg = $DtRg->num_rows;
						
						if($Tot_DtRg > 0){ 

							do{	
								
								$__v[$ext_k]['id'] = $row_DtRg['sisslcf_slc'];
								$__v[$ext_k]['vl'] = $ext_v->vl;

								$_pr = $this->ExtInAppl([
						        	't'=>'cnt',
						        	'v'=>_jEnc($__v),
						        	'id'=>$this->id_cnt
					        	]);
					        	
					        	
					        	$_r['v'][$ext_k] = $_pr;
					        	
								if(!isN($_pr->w)){ $_r['w'][] = $_pr->w; }
								if(!isN($_pr->q)){ $_r['q'][] = $_pr->q; }
								
																
							}while($row_DtRg = $DtRg->fetch_assoc());
						}else{
							if(isN($Vl['e'])){ $Vl['e'] = 'no'; }
						}
						
						$__cnx->_clsr($DtRg);
					}
	            }  
	            
	        }
	        return _jEnc($_r); 
	    }
	    
		public function ExtAllAppl($_p=NULL){ 
             
	        if(!isN($_p['id']) && (!isN($this->ext_all))){
	            
	            foreach($this->ext_all as $ext_k=>$ext_v){
		        	$_pr = $this->ExtInAppl([
					        	't'=>$ext_k,
					        	'v'=>$ext_v,
					        	'id'=>$_p['id']
				        	]);	
				        	
				        	$_r['v'][$ext_k] = $_pr;
				        	
		        	if(!isN($_pr->w)){ $_r['w'][] = $_pr->w; }
		        	if(!isN($_pr->q)){ $_r['q'][] = $_pr->q; }
	            }
	            
	            
	            $_r['e'] = 'ok';
	        }
	        
	        return _jEnc($_r); 
	    }
	    
		public function ExtInAppl($p=NULL){ 
			
			global $__cnx;

		    foreach($p['v'] as $_v_k=>$_v_v){

		    	$chk = $this->ExtChkAppl([ 't'=>$p['t'], 'v'=>$_v_v, 'id' => $p['id'] ]);
				$relmain = $this->id_cnt;
if($p['t'] == 'cnt'){
					$prfx = 'cnt';
					$tb = $this->bd.TB_CNT_ATTR;
				}elseif($p['t'] == 'appl'){
					$prfx = 'cntappl';
					$tb = $this->bd.TB_CNT_APPL_ATTR;
				}elseif($p['t'] == 'romt'){
					$prfx = 'cntapplromt';
					$tb = $this->bd.TB_CNT_ROMT;
				}elseif($p['t'] == 'cs_no_tlr'){
					$prfx = 'cntappltpc';
					$tb = $this->bd.TB_CNT_APPL_TPC;
				}
	
				if($p['t'] == 'cs_no_tlr'){
					
					if($chk->e != 'ok'){
						
						$__enc = Enc_Rnd($_v_v->vl.'-'.$relmain);
	 
						if($_v_v->vl == 1){
							$query = sprintf("INSERT INTO ".$this->gt_cl->bd.".".TB_CNT_APPL_TPC." (cntappltpc_enc, cntappltpc_cntappl, cntappltpc_tpc) VALUES (%s, %s, (SELECT id_tpc FROM "._BdStr(DBM).TB_TPC." WHERE tpc_enc = %s ))",
			                               GtSQLVlStr($__enc, "text"),
			                               GtSQLVlStr($p['id'], "int"),
			                               GtSQLVlStr($_v_v->enc, "text"));	
						}					
					}  
					   	
				}elseif($p['t'] == 'romt'){
					
					if($chk->e != 'ok'){
						$__enc = Enc_Rnd($_v_v->cnt.'-'.$relmain);
		 
			            $query = sprintf("INSERT INTO ".$this->gt_cl->bd.".".TB_CNT_APPL_ROMT."(cntapplromt_enc, cntapplromt_cntappl, cntapplromt_nm, cntapplromt_wtlve) VALUES (%s, %s, %s, %s)",
			                               GtSQLVlStr($__enc, "text"),
			                               GtSQLVlStr($p['id'], "int"),
			                               GtSQLVlStr(ctjTx($_v_v->cnt,'out'), "text"),
			                               GtSQLVlStr($_v_v->vl, "int"));
					}					   
											   
				}else{
					
					if($chk->e == 'ok' && !isN($chk->enc)){
			    		
				    	$query = sprintf("UPDATE ".$this->gt_cl->bd.".".$tb." SET ".$prfx."attr_attr=%s, ".$prfx."attr_".$prfx."=%s, ".$prfx."attr_vl=%s WHERE ".$prfx."attr_enc=%s",
		                               	GtSQLVlStr($_v_v->id, "int"),
			                            GtSQLVlStr($p['id'], "int"),
			                            GtSQLVlStr(ctjTx($_v_v->vl,'out'), "text"),
			                            GtSQLVlStr($chk->enc, "text")
			                         );
			            
				    }else{  
					  
					    $__enc = Enc_Rnd($_v_v->id.'-'.$relmain);
					         
			            $query = sprintf("INSERT INTO ".$this->gt_cl->bd.".".$tb." (".$prfx."attr_enc, ".$prfx."attr_attr, ".$prfx."attr_".$prfx.", ".$prfx."attr_vl) VALUES (%s, %s, %s, %s)",
			                               GtSQLVlStr($__enc, "text"),
			                               GtSQLVlStr($_v_v->id, "int"),
			                               GtSQLVlStr($p['id'], "int"),
			                               GtSQLVlStr(ctjTx($_v_v->vl,'out'), "text")); 
			        }	
				}
	
		        if(!isN($query)){ 
			        
			        $Result = $__cnx->_prc($query);
			        
			        if($Result){ 
				        $_r['e'] = 'ok'; 
				    }else{
				    	$_r['w'] = $_v_v->id;
			        }
		        }else{
			    	$_r['w'] = 'No query string';
		        }
		        
		    }  
		    
	        return _jEnc($_r);  
	    }
	    
		public function ExtChkAppl($p=NULL){

			global $__cnx;

			if(!isN($p) && !isN($p['t'])){
				
				$Vl['e'] = 'no';
				
			 
				if($p['t'] == 'cnt'){
					
					$prfx='cnt';
					if(!isN($this->id_cnt)){ $__f .= sprintf(' AND cntattr_cnt=%s ', GtSQLVlStr($this->id_cnt, 'int')); }
					if(!isN($p['v']->id)){ $__f .= sprintf(' AND cntattr_attr=%s ', GtSQLVlStr($p['v']->id, 'int')); }
					$tb = $this->bd.TB_CNT_ATTR;
					
				}elseif($p['t'] == 'appl'){
					
					$prfx='cntappl';
					if(!isN($this->id_cnt)){ $__f .= sprintf(' AND cntapplattr_cntappl=%s ', GtSQLVlStr($p['id'], 'int')); }
					if(!isN($p['v']->id)){ $__f .= sprintf(' AND cntapplattr_attr=%s ', GtSQLVlStr($p['v']->id, 'int')); }
					$tb = $this->bd.TB_CNT_APPL_ATTR;
					
				}elseif($p['t'] == 'romt'){
					
					$prfx='cntapplromt';
					if(!isN($this->id_cnt)){ $__f .= sprintf(' AND cntapplromt_main=%s ', GtSQLVlStr($this->id_cnt, 'int')); }
					if(!isN($p['v']->cnt)){ $__f .= sprintf(' AND cntapplromt_nm=%s ', GtSQLVlStr($p['v']->cnt, 'text')); }
					$tb = $this->bd.TB_CNT_APPL_ROMT;
					
				}elseif($p['t'] == 'cs_no_tlr'){
					
					$prfx='cntappltpc';
					if(!isN($this->id_cnt)){ $__f .= sprintf(' AND cntappltpc_cntappl=%s ', GtSQLVlStr($this->id_cnt, 'int')); }
					if(!isN($p['v']->enc)){ $__f .= sprintf(' AND cntappltpc_tpc= (SELECT id_tpc FROM '._BdStr(DBM).TB_TPC.' WHERE tpc_enc = %s)', GtSQLVlStr($p['v']->enc, 'text')); }
					$tb = $this->bd.TB_CNT_TPC;
					
				}
	
				
	
				// ---------- Contacto con los Roomates ---------- //
				if($p['t'] == 'romt'){
					$query_DtRg = '	SELECT * FROM '.$this->gt_cl->bd.'.'.TB_CNT_ROMT.' WHERE id_'.$prfx.' != "" '.$__f;
					
					$DtRg = $__cnx->_qry($query_DtRg);
					
					if($DtRg){
						$row_DtRg = $DtRg->fetch_assoc(); 
						$Tot_DtRg = $DtRg->num_rows;	
						if($Tot_DtRg > 0){
							$Vl['e'] = 'ok';
							$Vl['id'] = $row_DtRg['id_cntapplromt'];
							$Vl['enc'] = $row_DtRg['cntapplromt_enc'];
							$Vl['qry'] = $query_DtRg;
						}else{
							$Vl['id'] = $query_DtRg;	
						}
					}
					
				// ---------- Contacto con cosas de no interes ---------- //	
				}elseif($p['t'] == 'cs_no_tlr'){
					$query_DtRg = '	SELECT * FROM '.$this->gt_cl->bd.'.'.TB_CNT_APPL_TPC.' WHERE id_'.$prfx.' != "" '.$__f;
					$DtRg = $__cnx->_qry($query_DtRg);
	
					if($DtRg){
						$row_DtRg = $DtRg->fetch_assoc(); 
						$Tot_DtRg = $DtRg->num_rows;	
						if($Tot_DtRg > 0){
							$Vl['e'] = 'ok';
							$Vl['id'] = $row_DtRg['id_cntappltpc'];
							$Vl['enc'] = $row_DtRg['cntappltpc_enc'];
							$Vl['qry'] = $query_DtRg;
						}else{
							$Vl['id'] = $query_DtRg;	
						}
					}
							
				// ---------- Contacto atributos ---------- //		
				}else{
					
					$query_DtRg = '	SELECT * FROM '.$this->gt_cl->bd.'.'.$tb.' WHERE id_'.$prfx.'attr != "" '.$__f;
					$DtRg = $__cnx->_qry($query_DtRg); 
					
					if($DtRg){
						$row_DtRg = $DtRg->fetch_assoc(); 
						$Tot_DtRg = $DtRg->num_rows;	
						if($Tot_DtRg > 0){
							$Vl['e'] = 'ok';
							$Vl['id'] = $row_DtRg['id_'.$prfx.'attr'];
							$Vl['enc'] = $row_DtRg[$prfx.'attr_enc'];
							$Vl['qry'] = $query_DtRg;
						}
					}
						
				}
				
				$__cnx->_clsr($DtRg);
				
				return _jEnc($Vl);
			}
		}
    
	// ------- F - Contacto Aplicacion  ------ //
	
	// ------- I - Contrato ------------------ //
	
		public function CntrcHtml($p=NULL){
			
			$s[0] = '[LEAD_NOMBRE_CONTACTO]';
			$s[1] = '[LEAD_DOCUMENTO_CONTACTO_TIPO]';
			$s[2] = '[LEAD_DOCUMENTO_CONTACTO]';	
			$s[3] = '[APLICACION_NOMBRE_RESPONSABLE_FINANCIERO]';
			$s[4] = '[APLICACION_DOCUMENTO_RESPONSABLE_FINANCIERO_TIPO]';
			$s[5] = '[APLICACION_DOCUMENTO_RESPONSABLE_FINANCIERO]';	
			$s[6] = '[APLICACION_UNIVERSIDAD_CONTACTO_ESTUDIA]';	
			$s[7] = '[NUMERO_CONTRATO]';
			$s[8] = '[APLICACION_CIUDAD_RESPONSABLE_FINANCIERO]';
			
			$c[0] = $this->cnt_nm.' '.$this->cnt_ap;
			$c[1] = $this->cnt_dc_tp;
			$c[2] = $this->cnt_dc;
			$c[3] = $this->fnc_act_nm.' '.$this->fnc_act_ap;
			$c[4] = $this->fnc_act_dc_tp;
			$c[5] = $this->fnc_act_dc;	
			$c[6] = $this->uni_v_est;	
			$c[7] = $this->id_cntrc;
			$c[8] = $this->prnt_cd_vve;
			
			$new_bd = str_replace($s, $c, $p);
			return ($new_bd);
				
		}
	
	// ------- F - Contrato ------------------ //
	} 
?>