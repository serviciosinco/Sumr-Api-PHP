<?php

	class CRM_Forms extends CRM_Cl {

	    function __construct($p=NULL){
		    parent::__construct();
			$this->gt_cl = $this->GtCl([ 't'=>'enc', 'enc'=>$p['cl'] ]);
			$this->org_tp = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'org_tp' ]);
			if(!isN($p['bd'])){ $this->bd = _BdStr($p['bd']); }
	    }

		function __destruct() {
	       parent::__destruct();
	   	}

		function _fields($p=NULL){
			//$mdlcntattr_v->tt;
			//$mdlcntattr_v->get->vl;
			//$mdlcntattr_v->key->vl;
			//$mdlcntattr_v->url_track->vl;

			$__mdlcntattr = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'mdl_cnt_attr', 'cl'=>$this->gt_cl->id ]);

			if(!isN($__mdlcntattr->ls)){
				foreach($__mdlcntattr->ls->mdl_cnt_attr as $mdlcntattr_k=>$mdlcntattr_v){
					$__hd_on = mBln($mdlcntattr_v->url_track->vl);
					if($__hd_on == 'ok'){
						$d['hdn'] .= HTML_inp_hd('____ext_'.$this->_rnd.'[mdl_cnt]['.$mdlcntattr_v->key->vl.']', Php_Ls_Cln($_GET[ $mdlcntattr_v->get->vl ]) );
						$d['hdn_f']['mdl_cnt'][] = $mdlcntattr_v->key->vl;
					}
				}
			}

			return(_jEnc($d));
		}


		public function _sdata($_p=NULL){

			global $__cnx;

			$r['e'] = 'no';

			if(!isN($this->data)){

				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM)."post_data (postdata_data) VALUES (%s)",
								GtSQLVlStr( PHP_VERSION.' -> '.json_encode( $this->data, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR ) , "text"));

				$Result = $__cnx->_prc($insertSQL);

				if($Result){
					$r['i'] = $this->sess_id = $__cnx->c_p->insert_id;
				}else{
					$r['w'] = 'error __rg:'.$__cnx->c_p->error;
				}

			}else{

				$r['w'] = 'No data';

			}

			return _jEnc($r);
		}


		function _fdata(){
			$this->data = _jEnc($this->data, [ 's_in'=>'ok' ]);
			if($this->svep == 'ok'){
				$this->_sdata();
			}
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
				if(!isN( $this->data->{'Cnt_Cd'.$_k} )){ $d['cnt_cd'] = $this->data->{'Cnt_Cd'.$_k}; $d['cnt_cd_rel'] = _CId('ID_TPRLCC_VVE'); }
				if(!isN( $this->data->{'Cnt_Ps'.$_k} )){ $d['cnt_ps'] = $this->data->{'Cnt_Ps'.$_k}; }
				if(!isN( $this->data->{'Cnt_Tel'.$_k} )){ $d['cnt_tel'] = $this->data->{'Cnt_Tel'.$_k}; }
				if(!isN( $this->data->{'Cnt_Tel_Ps'.$_k} )){ $d['cnt_tel_ps'] = $this->data->{'Cnt_Tel_Ps'.$_k}; }
				if(!isN( $this->data->{'Cnt_Cmnt'.$_k} )){ $d['cnt_cmnt'] = $this->data->{'Cnt_Cmnt'.$_k}; }
				if(!isN( $this->data->{'Cnt_Sch'.$_k} )){ $d['cnt_sch'] = $this->data->{'Cnt_Sch'.$_k}; }
				if(!isN( $this->data->{'Cnt_Tp'.$_k} )){ $d['cnt_tp'] = $this->data->{'Cnt_Tp'.$_k}; }
				if(!isN( $this->data->{'Cnt_Crg'.$_k} )){ $d['cnt_crg'] = $this->data->{'Cnt_Crg'.$_k}; }
				if(!isN( $this->data->{'Org_Sds'.$_k} )){ $d['org_sds'] = $this->data->{'Org_Sds'.$_k}; }
				if(!isN( $this->data->{'Cnt_Cel'.$_k} )){ $d['cnt_cel'] = $this->data->{'Cnt_Cel'.$_k}; }
				if(!isN( $this->data->{'Cnt_Dir'.$_k} )){ $d['cnt_dir'] = $this->data->{'Cnt_Dir'.$_k}; }
				if(!isN( $this->data->{'Cnt_Rfd'.$_k} )){ $d['cnt_rfd'] = $this->data->{'Cnt_Rfd'.$_k}; }
				if(!isN( $this->data->{'Cnt_ClSds'.$_k} )){ $d['cnt_clsds'] = $this->data->{'Cnt_ClSds'.$_k}; }

			//------------------ VERIFICACIÓN LLAVES - START ------------------//


				if(!isN( $this->data->{'Cnt_Doc'.$_k} )){
					$d['cnt_dc'] = $this->data->{'Cnt_Doc'.$_k};
				}

				if(!isN( $this->data->{'Cnt_DocTp'.$_k} )){
					$d['cnt_dc_tp'] = $this->data->{'Cnt_DocTp'.$_k};
				}

				if(!isN( $this->data->{'Cnt_DocExp'.$_k} )){
					$d['cnt_dc_exp'] = $this->data->{'Cnt_DocExp'.$_k};
				}

				if(!isN( $this->data->{'Cnt_Eml'.$_k} )){
					if(filter_var($this->data->{'Cnt_Eml'.$_k}, FILTER_VALIDATE_EMAIL)){
						$d['cnt_eml'] = $this->data->{'Cnt_Eml'.$_k};
					}else{
						$d['cnt_eml']['w'] = TX_WRNGML;
					}
				}

				if(!isN( $this->data->{'Cnt_Eml_Org'.$_k} )){
					if(filter_var($this->data->{'Cnt_Eml_Org'.$_k}, FILTER_VALIDATE_EMAIL)){
						$d['cnt_eml_2'] = $this->data->{'Cnt_Eml_Org'.$_k};
					}else{
						$d['cnt_eml_2']['w'] = TX_WRNGML;
					}
				}

			//------------------ RELACIÓN A MODULO ------------------//

				if(!isN( $this->data->{'Cnt_Mdl'.$_k} )){
					$__mdl = GtMdlDt([ 'cnx'=>$__cnx->c_r, 't'=>'enc', 'id'=>$this->data->{'Cnt_Mdl'.$_k} ]);
					$d['mdl'] = $__mdl;
					if(!isN($__mdl->tp->id)){ $this->_get_mdlstp = $__mdl->tp->id; }
				}

				if(!isN( $this->data->{'Cnt_Prd'.$_k} )){
					$__dtprd = GtMdlSPrdDt([ 'id'=>$this->data->{'Cnt_Prd'.$_k}, 't'=>'enc' ]);
					$d['cnt_prd'] = $__dtprd->id;
				}

			//------------------ RELACIÓN A ACTIVIDAD ------------------//

				if(!isN( $this->data->{'Act'.$_k} )){
					$__act = GtActDt([ 'tp'=>'enc', 'id'=>$this->data->{'Act'.$_k} ]);
					$d['act'] = $__act;
				}

			//------------------ LANDING GENERAL ------------------//

				if(!isN( $this->data->{'MdlGen'.$_k} )){
					$__mdlgen = GtMdlGenDt([ 'cnx'=>$this->c_r, 't'=>'enc', 'id'=>$this->data->{'MdlGen'.$_k} ]);
					if(!isN( $__mdlgen )){
						$d['mdl_gen'] = $__mdlgen;
						if(!isN($__mdlgen->tp->id)){ $this->_get_mdlstp = $__mdlgen->tp->id; }
					}
				}

			//------------------ UBICACIÓN DEL LEAD ------------------//

				if(!isN($this->data->{'Plcy_Id'.$_k})){
					$__plcy = GtClPlcyDt([ 'cnx'=>$this->c_r, 't'=>'enc', 'id'=>$this->data->{'Plcy_Id'.$_k} ]);
					$d['plcy_id'] = $__plcy->id;
				}

			//------------------ RELACION CAMPAÑA VTEX ------------------//

				if(!isN( $this->data->{'Cnt_VtexCmpg'.$_k} )){
					$_vtex_cmpg_dt = GtVtexCmpgDt([ 'tp'=>'enc', 'id'=>$this->data->{'Cnt_VtexCmpg'.$_k}  ]);
					$d['vtex_cmpg'] = $_vtex_cmpg_dt;
				}

				if(!isN( $this->data->{'Cnt_VtexIns'.$_k} )){
					$_vtex_ins_dt = GtVtexCmpgInsDt([ 't'=>'enc', 'id'=>$this->data->{'Cnt_VtexIns'.$_k}  ]);
					$d['vtex_ins'] = $_vtex_ins_dt;
				}

				if(!isN( $this->data->{'cnt_ins'} )){
					foreach( $this->data->{'cnt_ins'} as $k => $v ){
						if( !isN($v->nm) && !isN($v->eml) ){
							$d['cnt_ins_t'][$k]['nm'] = $v->nm;
							$d['cnt_ins_t'][$k]['eml'] = $v->eml;
						}
					}

				}

			//------------------ RELACION TASK COLUMN ------------------//

				if(!isN( $this->data->{'TCol'.$_k} )){
					$_tra_col_dt = GtTraColDt(['id'=>$this->data->{'TCol'.$_k}, 't'=>'enc']);
					$d['tra_col'] = $_tra_col_dt;
				}

			//------------------ RELACION TASK COLUMN ------------------//

				if(!isN( $this->data->{'SBrnd'.$_k} )){
					$_store_brnd_dt = GtStoreBrndDt(['id'=>$this->data->{'SBrnd'.$_k}, 't'=>'enc' ]);
					$d['store_brnd'] = $_store_brnd_dt;
				}

			//------------------ ENVIO DE NOTIFICACIONES ------------------//


				if(!isN( $this->data->{'SndUs'.$_k} )){ $d['snd_us'] = $this->data->{'SndUs'.$_k}; }
				if(!isN( $this->data->{'SndEmad'.$_k} )){ $d['snd_adm'] = $this->data->{'SndEmad'.$_k}; }


			//------------------ MARKETING DIGITAL ------------------//


				if(!isN($this->data->{'CntChi'.$_k})){ $d['mdlcnt_chi'] = $this->data->{'CntChi'.$_k}; }

				if(!isN($this->data->{'SndFnt'.$_k})){
					$d['mdlcnt_fnt'] = $this->data->{'SndFnt'.$_k};
				}

				if(!isN($this->data->{'SndMed'.$_k})){
					$__md = GtSisMdDt([ 'cnx'=>$this->c_r, 'id'=>$this->data->{'SndMed'.$_k} ]);
					if(!isN( $__md )){ $d['mdlcnt_md'] = $__md->id; }
				}else{
					$__md = GtSisMdDt([ 'cnx'=>$this->c_r, 'dfl'=>$this->_get_mdlstp ]);
					if(!isN( $__md )){ $d['mdlcnt_md'] = $__md->id; }
				}

				if(!isN($this->data->{'KeyMed'.$_k})){ $d['mdlcnt_md_k'] = $this->data->{'KeyMed'.$_k}; }
				if(!isN($this->data->{'AdgMed'.$_k})){ $d['mdlcnt_md_adg'] = $this->data->{'AdgMed'.$_k}; }



			//------------------ DATA ANEXA ------------------//


				if(!isN( $this->data->{'____ext_'.$_k}->mdl_cnt )){

					$__mdlcntattr = __LsDt([ 'cnx'=>$this->c_r, 'k'=>'mdl_cnt_attr', 'cl'=>$__Forms->gt_cl->id ]);

					foreach($__mdlcntattr->ls->mdl_cnt_attr as $_ca_k=>$_ca_v){
						$__mca[$_ca_v->key->vl]= [ 'id'=>$_ca_k ];
					}

					foreach($this->data->{'____ext_'.$_k}->mdl_cnt as $_ext_k=>$_ext_v){
						if(!isN($_ext_v) && !isN($_ext_k)){
							$d['_ext_']['mdl_cnt'][$_ext_k]['id'] = $__mca[$_ext_k]['id'];
							$d['_ext_']['mdl_cnt'][$_ext_k]['vl'] = $_ext_v;
						}
					}

				}

				if(!isN( $this->data->{'Cnt_Mdl_Pos'.$_k} )){
					foreach($this->data->{'Cnt_Mdl_Pos'.$_k} as $_pos_k=>$_pos_v){
						if(!isN($_pos_v)){
							$d['cnt_tp_mdl']['pos'][$_pos_k] = $_pos_v;
						}
					}
				}

				if(!isN( $this->data->{'Cnt_Mdl_Pre'.$_k} )){
					foreach($this->data->{'Cnt_Mdl_Pre'.$_k} as $_pos_k=>$_pos_v){
						if(!isN($_pos_v)){
							$d['cnt_tp_mdl']['pre'][$_pos_k] = $_pos_v;
						}
					}
				}

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


			//------------------ DATOS ORGANIZACIONES ------------------//

				foreach($this->org_tp->ls->org_tp as $_org_k=>$_org_v){

					if(!isN( $this->data->{'OthWrt'.$_org_v->key->vl} )){

						$__Org = new CRM_Org();

						$__Org->org_nm = $this->data->{'OthWrt'.$_org_v->key->vl};
						$__Org->org_vrf = 2;

						if(!isN( $this->data->{'OthWrtOrg'.$_k} )){
							$__Cnt = new CRM_Cnt();
							$cd = $__Cnt->LsNewCd(['id'=> $this->data->{'OthWrtOrg'.$_k} , 'ps'=> $this->data->{'Cnt_Ps_Org'.$_k} ]);

							if($cd->e == 'ok'){
								$__Org->orgsds_cd = $cd->i;
								$__Org->org_cd = $cd->i;
							}
						}

						$Org = $__Org->_Org_In();

						if($Org->e == 'ok'){

							$__Org->_org->id = $Org->id;

							$__Org->id_org = $Org->enc;
							$__Org->org_tp = $_org_v->enc;

							if( !isN( $this->data->{'Org_Scec'.$_k} ) ){

								$__Org->org_enc = $Org->enc;
								$__Org->scec_enc = $this->data->{'Org_Scec'.$_k};
								$_Org_Scec = $__Org->OrgScec_In();

							}

							$_Org_tp = $__Org->GtOrgTpLs_In();
							$_Org = $__Org->_Org_Sds_In();

							if($_Org->e == 'ok'){ $_org_id = $_Org->enc; }
						}

					}else{

						$__Org = new CRM_Org();

						$_org_id = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).$_k};

						if(!isN($_org_id)){
							$_org_dt = GtOrgSdsDt([ 'i'=> $_org_id, 't'=>'enc' ]);
						}

						if( !isN( $this->data->{'Org_Scec'.$_k} ) && !isN($_org_id) ){

							$__Org->org_enc = $_org_dt->org->enc;
							$__Org->scec_enc = $this->data->{'Org_Scec'.$_k};

							$_Org_Scec_Chk = $__Org->OrgScec_Chk();

							if($_Org_Scec_Chk->e == 'no'){
								$_Org_Scec = $__Org->OrgScec_In();
							}

						}

						if(!isN( $this->data->{'OthWrtOrg'.$_k} ) && !isN($_org_id) ){

							$__Cnt = new CRM_Cnt();
							$cd = $__Cnt->LsNewCd(['id'=> $this->data->{'OthWrtOrg'.$_k} , 'ps'=> $this->data->{'Cnt_Ps_Org'.$_k} ]);

							if($cd->e == 'ok'){

								$__Org->_org->id = $_org_dt->org->id;
								$__Org->orgsds_nm = $this->data->{'OthWrtOrg'.$_k};
								$__Org->orgsds_cd = $cd->i;

								$_Org = $__Org->_Org_Sds_In();

								if($_Org->e == 'ok'){
									$_org_id = $_Org->enc;
								}

							}

						}elseif(!isN( $this->data->{'Cnt_Cd_Org'.$_k} ) && !isN($_org_id) ){

							if(isN($_org_dt->cd->id) || $_org_dt->cd->id != $this->data->{'Cnt_Cd_Org'.$_k}){

								$_cd = GtCdDt(['tp' => 'id', 'id' => $this->data->{'Cnt_Cd_Org'.$_k} ]);

								$__Org->_org->id = $_org_dt->org->id;
								$__Org->orgsds_nm = $_cd->tt;
								$__Org->orgsds_cd = $this->data->{'Cnt_Cd_Org'.$_k};

								$_Org = $__Org->_Org_Sds_In();

								if($_Org->e == 'ok'){
									$_org_id = $_Org->enc;
								}
							}
						}
					}

					$_org_tpr = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).'Tpr'.$_k};
					$_org_tpr_o = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).'TprO'.$_k};

					if(!isN($_org_id) && !isN($_org_tpr) && !isN($_org_dt->id)){

						if($_org_v->key->vl == 'clg' && !isN($this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).'Grd'.$_k}) ){
							$d['cnt_org'][$_org_id]['crs'] = $this->data->{'Cnt_Org'.ucfirst($_org_v->key->vl).'Grd'.$_k};
						}

						if( !isN( $this->data->{'Cnt_OrgEmpAre'.$_k} ) ){
							$d['cnt_org'][$_org_id]['are'] = $this->data->{'Cnt_OrgEmpAre'.$_k};
						}

						if( !isN( $this->data->{'Cnt_OrgEmpCrg'.$_k} ) ){
							$d['cnt_org'][$_org_id]['crg'] = $this->data->{'Cnt_OrgEmpCrg'.$_k};
						}

						$d['cnt_org'][$_org_id]['id'] = $_org_dt->id;
						$d['cnt_org'][$_org_id]['tpr'] = $_org_tpr;
						$d['cnt_org'][$_org_id]['tpr_o'] = $_org_tpr_o;

					}
				}

			//------------------ Ciudad Nueva Vive------------------------//

			if(!isN( $this->data->{'OthWrt'.$_k} )){

				$__Cnt = new CRM_Cnt();

				$cd = $__Cnt->LsNewCd(['id'=> $this->data->{'OthWrt'.$_k} , 'ps'=> $this->data->{'Cnt_Ps'.$_k} ]);

				$d['cd'] = $cd;

				if($cd->e == 'ok'){
					$d['cnt_cd'] = $cd->i;
					$d['cnt_cd_rel'] = _CId('ID_TPRLCC_VVE');
				}
			}

			//------------------ UBICACIÓN DEL LEAD ------------------//

				if(!isN($this->data->{'Lat'.$_k})){ $d['mdlcnt_lat'] = $this->data->{'Lat'.$_k}; }
				if(!isN($this->data->{'Lon'.$_k})){ $d['mdlcnt_lon'] = $this->data->{'Lon'.$_k}; }

			//------------------ CODIFICA Y RETORNA ------------------//

			return(_jEnc($d));

		}





		public function _mdlfm_qry($_p=NULL){

			global $__cnx;

			//-------------- MODULO SIMPLE --------------//

			if($this->mdlfm_lst=='ok'){ $_fl .= " AND mdlfm_est = 1"; $_ord=' ,id_mdlfm DESC '; }
			if(!isN($this->mdlfm_mdl)){ $_fl .= " AND mdlfm_mdl = '".$this->mdlfm_mdl."' "; }

			//-------------- MODULO LISTADO GENERAL --------------//

			if($this->mdlfmgen_lst=='ok'){ $_fl .= " AND mdlfmgen_est = 1"; $_ord=' ,id_mdlfmgen DESC '; }
			if(!isN($this->mdlfmgen_mdlgen)){ $_fl .= " AND mdlfmgen_mdlgen = '".$this->mdlfmgen_mdlgen."' "; $__gen='ok'; }

			if($__gen=='ok'){
				$_bd_main = $this->bd.TB_MDL_GEN_FM;
				$_id_main='id_mdlfmgen';
				$_id_r_1='mdlfmgen_mdlstpfm';
				$_id_r_2='mdlgenrowfld_mdlstpfmrow';
			}else{
				$_bd_main = $this->bd.TB_MDL_FM;
				$_id_main='id_mdlfm';
				$_id_r_1='mdlfm_mdlstpfm';
				$_id_r_2='mdlrowfld_mdlstpfmrow';
			}

			if($_p['t']=='cl'){

				if($__gen=='ok'){
					$_innr_row = " INNER JOIN ".$this->bd.TB_MDL_GEN_FM_FLD." ON {$_id_r_2} = id_mdlstpfmrow ";
					$_innr_col = "mdlgenrowfld_fld";
					$_innr_ord = "mdlgenrowfld_ord";
					$_innr_enc = "mdlgenrowfld_enc";
					$_innr_cl = "ok";

				}else{
					$_innr_row = " INNER JOIN ".$this->bd.TB_MDL_FM_FLD." ON {$_id_r_2} = id_mdlstpfmrow ";
					$_innr_col = "mdlrowfld_fld";
					$_innr_ord = "mdlrowfld_ord";
					$_innr_enc = "mdlrowfld_enc";
					$_innr_cl = "ok";
				}

			}else{

				$_innr_row = " INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." ON mdlstpfmrowfld_mdlstpfmrow = id_mdlstpfmrow ";
				$_innr_col = "mdlstpfmrowfld_fld";
				$_innr_ord = "mdlstpfmrowfld_ord";
				$_innr_enc = "mdlstpfmrowfld_enc";
			}


			$query_DtRg = "	SELECT *,
								  "._QrySisSlcF(['als'=>'f', 'cl'=>$_innr_cl, 'als_n'=>'field']).",
								  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'field', 'als'=>'f' ]).",
								  "._QrySisSlcF(['als'=>'t', 'als_n'=>'theme' ]).",
								  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'theme', 'als'=>'t' ])."
							FROM ".$_bd_main."
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_FM." ON {$_id_r_1} = id_mdlstpfm
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." ON mdlstpfmrow_mdlstpfm = id_mdlstpfm
								 INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON mdlstpfm_plcy = id_clplcy
								 {$_innr_row}
								 ".GtSlc_QryExtra(['t'=>'tb', 'cl'=>$_innr_cl, 'col'=>$_innr_col, 'als'=>'f'])."
								 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'mdlstpfm_thm', 'als'=>'t'])."
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." stp ON f.sisslc_tp = stp.id_sisslctp

							WHERE {$_id_main} != '' $_fl
							ORDER BY mdlstpfmrow_ord ASC, ".$_innr_ord." ASC $_ord";

			$DtRg = $__cnx->_qry($query_DtRg);

			if(!isN($_p['v'])){ $Vl=$_p['v']; }

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$Vl = $this->_mdlfm_dt_bld([ 'cl'=>$_innr_cl, 'v'=>$Vl, 'rw'=>$row_DtRg ]);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					if(isN($Vl['e'])){ $Vl['e'] = 'no'; }

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			return $Vl;
		}



		public function _mdlstp_fm_ps($_p=NULL){

			global $__cnx;

			if(is_array($_p) && !isN($_p['fm'])){

				$query_DtRg = sprintf('	SELECT mdlstpfmps_ps
										FROM '._BdStr(DBM).TB_MDL_S_TP_FM_PS.'
										WHERE mdlstpfmps_mdlstpfm = %s', GtSQLVlStr($_p['fm'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$Vl['e'] = 'ok';
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						do{
							$Vl['ls'][] = $row_DtRg['mdlstpfmps_ps'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL.' '.compress_code($query_DtRg);
				}

			}

			$__cnx->_clsr($DtRg);

			return( _jEnc($Vl) );

		}

		public function _mdlfm_dt_bld($_p=NULL){

			$_rw = $_p['rw'];
			$Vl = $_p['v'];

			$__field = GtSlcF_Attr([ 'id'=>$_rw['field_sisslc_enc'], 't'=>'enc' ]);
			$__rowdt = GtMdlSTpFmRowFldDt(['id'=>$_rw['id_mdlstpfmrowfld'] ]);

			if(!isN($__field->ls)){

			    foreach($__field->ls as $_attr_k=>$_attr_v){

					$__toa_attr[ $_attr_v->key ] = $_attr_v;

					if(
						(
							$_attr_v->key == 'ph' ||
							$_attr_v->key == 'rq'
						) &&
						$this->cnscnv=='ok'
					){
						$__toa_attr[ $_attr_v->key ]->vl = _cns($_attr_v->vl);
					}

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


			$Vl['id'] = ctjTx($_rw['id_mdlfm'], 'in');
			$Vl['enc'] = ctjTx($_rw['mdlfm_enc'], 'in');


			$Vl['plcy']['id'] = ctjTx($_rw['id_clplcy'], 'in');
			$Vl['plcy']['enc'] = ctjTx($_rw['clplcy_enc'], 'in');
			$Vl['plcy']['nm'] = ctjTx($_rw['clplcy_nm'], 'in');
			$Vl['plcy']['tx'] = ctjTx($_rw['clplcy_tx'], 'in');

			$Vl['plcy']['lnk']['url'] = ctjTx($_rw['clplcy_lnk'], 'in');
			$Vl['plcy']['lnk']['tt'] = ctjTx($_rw['clplcy_lnk_tt'], 'in');

			$Vl['plcy']['v'] = ctjTx($_rw['clplcy_v'], 'in');

			$Vl['cstm']['css'] = ctjTx($_rw['mdlstpfm_css'], 'in');
			$Vl['cstm']['font'] = ctjTx($_rw['mdlstpfm_fnt'], 'in');


			$Vl['thx']['top'] = mBln($_rw['mdlstpfm_thx_top']);
			$Vl['thx']['url'] = ctjTx($_rw['mdlstpfm_thx_url'], 'in');

			$Vl['thx']['tt'] = ctjTx($_rw['mdlstpfm_thx_tt'], 'in');
			$Vl['thx']['sbt'] = ctjTx($_rw['mdlstpfm_thx_sbt'], 'in');
			$Vl['thx']['dsc'] = ctjTx($_rw['mdlstpfm_thx_dsc'], 'in','', ['html'=>'ok','schr'=>'ok','nl2'=>'no']);


			//$Vl['plpcy']['tt'] = ctjTx($_rw['mdlstpfm_plcytt'], 'in');
			//$Vl['plpcy']['tx'] = ctjTx($_rw['mdlstpfm_plcytx'], 'in');
			//$Vl['plpcy']['lnk'] = ctjTx($_rw['mdlstpfm_plcylnk'], 'in');


			$Vl['thm']['id'] = $_rw['mdlstpfm_thm'];
			$Vl['thm']['attr'] = $__thm_attr;

			foreach($this->org_tp->ls->org_tp as $_k=>$_v){
				$Vl['shw']['org'][$_v->key->vl] = mBln($_rw['mdlstpfm_s_org_'.$_v->key->vl]);
			}

			$Vl['shw']['vst'] = mBln($_rw['mdlstpfm_s_vst']);
			$Vl['shw']['sch'] = mBln($_rw['mdlstpfm_s_sch']);

			$Vl['shw']['are'] = mBln($_rw['mdlstpfm_s_are']);
			$Vl['shw']['mdltp'] = mBln($_rw['mdlstpfm_s_mdltp']);
			$Vl['shw']['mdl_all'] = mBln($_rw['mdlstpfm_s_allmdl']);
			$Vl['shw']['mdl_s_tp'] = mBln($_rw['mdlstpfm_s_fltmdlstp']);
			$Vl['shw']['mlt'] = mBln($_rw['mdlstpfm_s_mlt']);
			$Vl['shw']['mdl_s_prd'] = mBln($_rw['mdlstpfm_s_prd']);
			$Vl['shw']['mdl_s_cmnt'] = mBln($_rw['mdlstpfm_s_cmnt']);
			$Vl['shw']['cl_sds'] = mBln($_rw['mdlstpfm_s_cl_sds']);

			$Vl['dft']['ps'] = $_rw['mdlstpfm_dft_ps'];

			if(!isN($_rw['mdlstpfm_clr_btn'])){
				$Vl['clr']['btn'] = $_rw['mdlstpfm_clr_btn'];
			}

			if($_rw['mdlstpfm_tot_ps']){
				$Vl['ps'] = $this->_mdlstp_fm_ps([ 'fm'=>$_rw['id_mdlstpfm'] ]);
			}

			$_row_id = $_rw['mdlstpfmrowfld_enc'];

			//if(!isN($_rw[$_innr_enc])){

				$_fld_id = 'fld-'.$_row_id;
				$_row_ord = 'row-'.$_rw['mdlstpfmrow_ord'];

				$Vl['row'][$_row_ord]['f'][$_fld_id]['id'] = ctjTx($_rw['id_mdlstpfmrowfld'], 'in');

				if($_p['cl']=='ok'){
					$Vl['row'][$_row_ord]['f'][$_fld_id]['cl'] = 'ok';
				}

				$Vl['row'][$_row_ord]['f'][$_fld_id]['attr'] = $__toa_attr;

				if(!isN($__rowdt->fld_attr->ls)){
					foreach($__rowdt->fld_attr->ls as $_fld_a_k => $_fld_a_v){
						$Vl['row'][$_row_ord]['f'][$_fld_id]['attr'][$_fld_a_v->attr] = $_fld_a_v->vl;
					}
				}

				if(!isN($__rowdt->tt)){
					$Vl['row'][$_row_ord]['f'][$_fld_id]['tt'] = $__rowdt->tt;
				}

				if(!isN($__field->ls->ls->vl)){

					if(!isN($__field->ls->rto->vl) && $__field->ls->rto->vl == 1) { $rto = 'rto'; }else { $rto = ''; }
					if(!isN($__field->ls->flt_cl->vl) && $__field->ls->flt_cl->vl == 1) { $fcl = 'ok'; }else { $fcl = ''; }
					if(!isN($__field->ls->ord_alf->vl) && $__field->ls->ord_alf->vl == 1) { $ord_alf = 'ok'; }else { $ord_alf = ''; }

					$Vl['row'][$_row_ord]['f'][$_fld_id]['ls'] = Ls_to_Json([
																	'cl'=>$_p['cl'],
																	'icl'=>$this->gt_cl->id,
																	'fcl'=>$fcl,
																	'idt'=>$__field->ls->ls->vl,
																	'lbl'=>'ok',
																	'f'=>$rto,
																	'id'=>$__f_id,
																	'ord'=>$ord_alf
																]);
				}

				if(!isN($_row_ord)){
					$Vl['row'][$_row_ord]['tot']++;
				}

			//}

			$Vl['fa'] = $_rw['mdlstpfm_fa'];


			return $Vl;
		}

		public function _mdlfm_dt($_p=NULL){

			$Vl = $this->_mdlfm_qry();
			$Vl = $this->_mdlfm_qry([ 't'=>'cl', 'v'=>$Vl ]);

			return(_jEnc($Vl));

		}

		public function _tagC(){

			$_tags = ['[ID_MDLCNT]', '[ID_MDL]'];
			$_tagc = [$this->tagc->id_mdlcnt, $this->tagc->id_mdl];

			if(!isN($this->tagc_url)){
				$_v = str_replace($_tags, $_tagc, $this->tagc_url);
				$this->tagc_url = $_v;
			}

		}




	}

?>