<?php

class CRM_Cl{

    function __construct($p=NULL) {

	    global $__cnx;

		$this->_aud = new CRM_Aud();
		$this->_aws = new API_CRM_Aws();

		if(class_exists('API_CRM_ec')) {
			$this->_Crm_Ec = new API_CRM_ec([ 'cl'=>DB_CL_ID ]);
			$this->_Crm_Ec->frm = 'Ml';
			$this->_Crm_Ec->html = 'ok';
			$this->_Crm_Ec->ec_scl = 'no';
			$this->_Crm_Ec->ec_tll = 'no';
		}
    }

    function __destruct() {

   	}


    public function GtCl($p=NULL){
		if($p['t'] == 'enc'){
			if( !isN($p["enc"]) ){
				$_Cl = GtClDt($p["enc"], 'enc');
			}else{
				$_Cl = GtClDt(DB_CL_ENC, 'enc');
			}
		}else{
			$_Cl = GtClDt(Gt_SbDMN(), 'sbd');
		}

		return $_Cl;
    }

    public function ClGrpPrm_Dt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$c_DtRg = "-1";if(!isN($_p['id'])){$c_DtRg = $_p['id'];}

				if($_p['t'] == 'tp'){ $__f = 'clgrpprm_tp'; $__ft = 'text'; }
				elseif($_p['t'] == 'enc'){ $__f = 'clgrpprm_enc'; $__ft = 'text'; }
				else{ $__f = 'id_clgrpprm'; $__ft = 'int'; }

				$query_DtRg = sprintf("	SELECT *,
												".GtSlc_QryExtra(array('t'=>'fld', 'p'=>'icon', 'als'=>'i'))."
										FROM "._BdStr(DBM).TB_CL_GRP_PRM."
											 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_PRM." ON clgrpprm_prm = id_mdlstpprm
											 ".GtSlc_QryExtra(array('t'=>'tb', 'col'=>'mdlstpprm_tp', 'als'=>'i'))."
										WHERE {$__f} = %s", GtSQLVlStr($c_DtRg, $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['id'] = $row_DtRg['id_clgrpprm'];
					$Vl['prm']['tt'] = ctjTx($row_DtRg['clgrpprm_nm'],'in');
					$Vl['prm']['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['i.sisslc_img'],'in');

				}else{
					$Vl['w'] = $__cnx->c_r->error;
					$rsp['w_n'] = $__cnx->c_r->errno;
				}

				$__cnx->_clsr($DtRg);

			}
		}

		return _jEnc($Vl);
	}


	public function Cl_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p['on'])){ $__fl .= sprintf(" AND cl_on = %s ", GtSQLVlStr($p['on'], "int")); }
		if(!isN($this->mdlstp_id)){ $__fl1 .= sprintf(" AND mdlstpcl_mdlstp = %s ", GtSQLVlStr($this->mdlstp_id, "int")); }
		if(!isN($this->sisslccl_sisslc)){ $__fl2 .= sprintf(" AND sisslccl_sisslc = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) ", GtSQLVlStr($this->sisslccl_sisslc, "text")); }

		$query_DtRg = "
				SELECT *,

				(SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = "._CId('ID_SISTAG_CLR_MAIN')." AND cltag_cl = id_cl ) AS _cl_clr,

				(	SELECT COUNT(*)
					FROM "._BdStr(DBM).TB_MDL_S_TP_CL."
					WHERE mdlstpcl_cl = id_cl {$__fl1}
				) AS tot_mdls_tp,


				(	SELECT COUNT(*)
					FROM "._BdStr(DBM).TB_SIS_SLC_CL."
					WHERE sisslccl_cl = id_cl {$__fl2}
				) AS tot_sisslc

		FROM "._BdStr(DBM).TB_CL."
		WHERE id_cl != '' {$__fl}
		ORDER BY cl_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_o = $row_DtRg['cl_enc'];

					$Vl['ls'][$id_o]['enc'] = $id_o;
					$Vl['ls'][$id_o]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$Vl['ls'][$id_o]['tot']['mdsl_tp'] = $row_DtRg['tot_mdls_tp'];
					$Vl['ls'][$id_o]['tot']['sisslc'] = $row_DtRg['tot_sisslc'];

					//$Vl['ls'][$id_o]['qry'] = $query_DtRg;

					if( !isN($row_DtRg['cl_img']) ){
						$Vl['ls'][$id_o]['img'] = _ImVrs([ 'img'=>$row_DtRg['cl_img'], 'f'=>DMN_FLE_CL ]);
					}

					if($p['adm']){ $Vl['ls'][$id_o]['bd'] = DB_PRFX_CL.ctjTx($row_DtRg['cl_sbd'],'in'); }

					$Vl['ls'][$id_o]['clr'] = $row_DtRg['_cl_clr'];


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}


		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


	public function SisSlc_Mdl($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					*,(
						SELECT
							COUNT(*)
						FROM
							"._BdStr(DBM).TB_SIS_SLC_MDLSTP.",
							"._BdStr(DBM).TB_SIS_SLC."
						WHERE
							sisslcmdlstp_sisslc = id_sisslc
						AND id_mdlstp = sisslcmdlstp_mdlstp
						AND sisslc_enc = '".$this->sisslccl_sisslc."'
					) as __est
				FROM
					"._BdStr(DBM).TB_MDL_S_TP."
				INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON mdlstpcl_mdlstp = id_mdlstp
				INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
				WHERE
					mdlstpcl_cl =(
						SELECT
							id_cl
						FROM
							"._BdStr(DBM).TB_CL."
						WHERE
							cl_enc = '".CL_ENC."'
					)
				ORDER BY
					mdlstp_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_o = $row_DtRg['mdlstp_enc'];

					$Vl['ls'][$id_o]['enc'] = $id_o;
					$Vl['ls'][$id_o]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$Vl['ls'][$id_o]['__est'] = ctjTx($row_DtRg['__est'],'in');



				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }

	public function SisSlc_Mdl_In($p=NULL){

		global $__cnx;

		if(	!isN($this->sisslccl_mdlstp) && !isN($this->sisslccl_sisslc)){

			$__enc = Enc_Rnd($this->sisslccl_mdlstp.'-'.$this->sisslccl_sisslc);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_SLC_MDLSTP." (sisslcmdlstp_enc, sisslcmdlstp_sisslc, sisslcmdlstp_mdlstp) VALUES (%s, (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s), (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s))",
						   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr($this->sisslccl_sisslc, "text"),
		                   GtSQLVlStr($this->sisslccl_mdlstp, "text"));

			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $__cnx->c_p->insert_id;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function SisSlc_Mdl_Del($p=NULL){

		global $__cnx;

		if(	!isN($this->sisslccl_mdlstp) && !isN($this->sisslccl_sisslc)){

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_SIS_SLC_MDLSTP." WHERE sisslcmdlstp_sisslc=(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) AND sisslcmdlstp_mdlstp=(SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s)",
								GtSQLVlStr($this->sisslccl_sisslc, "text"),
								GtSQLVlStr($this->sisslccl_mdlstp, "text"));

			$Result = $__cnx->_prc($query_DtRg);

		}

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

    public function SisSlcTpCl($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['on'])){ $__fl .= sprintf(" AND cl_on = %s ", GtSQLVlStr($p['on'], "int")); }

		$query_DtRg = "
				SELECT *,

				(SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = "._CId('ID_SISTAG_CLR_MAIN')." AND cltag_cl = id_cl ) AS _cl_clr,
				(SELECT COUNT(*) FROM "._BdStr(DBM).TB_SIS_SLC_TP_CL." INNER JOIN ".TB_SIS_SLC_TP." ON id_sisslctp = sisslctpcl_sisslctp AND sisslctp_enc = '".$this->sisslccl_sisslc."' WHERE id_cl = sisslctpcl_cl ) as _tot

				FROM "._BdStr(DBM).TB_CL." WHERE id_cl != '' {$__fl} ORDER BY cl_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_o = $row_DtRg['cl_enc'];

					$Vl['ls'][$id_o]['enc'] = $id_o;
					$Vl['ls'][$id_o]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$Vl['ls'][$id_o]['tot'] = ctjTx($row_DtRg['_tot'],'in');

					//$Vl['ls'][$id_o]['qry'] = $query_DtRg;

					if( !isN($row_DtRg['cl_img']) ){
						$Vl['ls'][$id_o]['img'] = _ImVrs([ 'img'=>$row_DtRg['cl_img'], 'f'=>DMN_FLE_CL ]);
					}

					$Vl['ls'][$id_o]['clr'] = $row_DtRg['_cl_clr'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }


	public function SisSlcTpCl_In($p=NULL){

		global $__cnx;

		if(	!isN($this->sisslccl_cl) && !isN($this->sisslccl_sisslc)){

			$__enc = Enc_Rnd($this->sisslccl_cl.'-'.$this->sisslccl_sisslc);

			$insertSQL = sprintf("INSERT INTO ".TB_SIS_SLC_TP_CL." (sisslctpcl_enc, sisslctpcl_cl, sisslctpcl_sisslctp) VALUES (%s, (SELECT id_cl FROM ".TB_CL." WHERE cl_enc = %s), (SELECT id_sisslctp FROM ".TB_SIS_SLC_TP." WHERE sisslctp_enc = %s))",
						   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr($this->sisslccl_cl, "text"),
		                   GtSQLVlStr($this->sisslccl_sisslc, "text"));

			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $__cnx->c_p->insert_id;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}


	public function SisSlcTpCl_Del($p=NULL){

		global $__cnx;

		if(	!isN($this->sisslccl_cl) && !isN($this->sisslccl_sisslc)){

			$query_DtRg = sprintf("DELETE FROM ".TB_SIS_SLC_TP_CL." WHERE sisslctpcl_cl = (SELECT id_cl FROM ".TB_CL." WHERE cl_enc = %s) AND sisslctpcl_sisslctp=(SELECT id_sisslctp FROM ".TB_SIS_SLC_TP." WHERE sisslctp_enc = %s)",
								GtSQLVlStr($this->sisslccl_cl, "text"),
								GtSQLVlStr($this->sisslccl_sisslc, "text"));

			$Result = $__cnx->_prc($query_DtRg);

		}

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

    public function UsMdl_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$query_DtRg = "SELECT *,( SELECT COUNT(*) FROM "._BdStr(DBM).TB_US_PRM." WHERE usprm_us =( SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$this->grp_id."' ) AND usprm_prm = id_mdlstpprm ) AS tot
							FROM
								"._BdStr(DBM).TB_MDL_S_TP_PRM."
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = mdlstpprm_mdlstp
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
							INNER JOIN "._BdStr(DBM).TB_CL."  ON id_cl = mdlstpcl_cl
							WHERE
								cl_enc = '".DB_CL_ENC."' ORDER BY mdlstp_nm ASC, mdlstpprm_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['qry'] = $query_DtRg;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						//id_siscntesttp
						//cntesttp_tt

						if(isN( $Vl['ls'][$row_DtRg['mdlstp_enc']]['ls'] )){
							$Vl['ls'][$row_DtRg['mdlstp_enc']]['ls'] = array();
						}

						$Vl['ls'][$row_DtRg['mdlstp_enc']]['enc'] = $row_DtRg['mdlstp_enc'];
						$Vl['ls'][$row_DtRg['mdlstp_enc']]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');

						$__ob = [
							'enc'=>$row_DtRg['mdlstpprm_enc'],
							'nm'=>ctjTx($row_DtRg['mdlstpprm_nm'],'in'),
							'clr'=>ctjTx($row_DtRg['mdlstp_clr'],'in'),
							'tot'=>$row_DtRg['tot'],
							'vl'=>ctjTx($row_DtRg['mdlstpprm_vl'],'in')
						];

						array_push( $Vl['ls'][$row_DtRg['mdlstp_enc']]['ls'], $__ob);


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
    }

    public function UsCl_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){
			$query_DtRg = "SELECT *,( SELECT COUNT(*) FROM "._BdStr(DBM).TB_US_CL." WHERE uscl_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$this->grp_id."') AND uscl_cl = id_cl ) AS tot FROM "._BdStr(DBM).TB_CL." ORDER BY tot DESC ";
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				//$Vl['qry'] = $query_DtRg;


				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['cl_enc']]['enc'] = $row_DtRg['cl_enc'];
						$Vl['ls'][$row_DtRg['cl_enc']]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
						$Vl['ls'][$row_DtRg['cl_enc']]['tot'] = $row_DtRg['tot'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
    }



	public function UsAre_Ls($p=NULL){

    	global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$query_DtRg = "SELECT *,(
								SELECT
									COUNT(*)
								FROM
									"._BdStr(DBM).TB_US_ARE." ,
									"._BdStr(DBM).TB_US."
								WHERE
									usare_clare = id_clare
								AND id_us = usare_us
								AND id_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$this->grp_id."')
							) as __est

							FROM
								"._BdStr(DBM).TB_CL_ARE."
							WHERE
								clare_cl =(
									SELECT
										id_cl
									FROM
										"._BdStr(DBM).TB_CL."
									WHERE
										cl_enc = '".CL_ENC."'
								) AND clare_est = 1 ORDER BY __est DESC, clare_tt ASC ";

			 $DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['clare_enc']]['enc'] = $row_DtRg['clare_enc'];
						$Vl['ls'][$row_DtRg['clare_enc']]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
						$Vl['ls'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
    }

	public function UsMdls_Ls($p=NULL){

    	global $__cnx;

	    $Vl['e'] = 'no';

	    $Vl['es'] = $this->grp_id;

	    $_cl = $this->GtCl();

	    if(!isN($this->grp_id)){

			$query_DtRg = "SELECT *,(
								SELECT
									COUNT(*)
								FROM
									".TB_MDL_US." ,
									"._BdStr(DBM).TB_US."
								WHERE
									mdlus_mdl = id_mdl
								AND id_us = mdlus_us
								AND id_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$this->grp_id."')
							) as __est FROM
								".TB_MDL."
							ORDER BY mdl_nm ASC ";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['ed'] = $query_DtRg;
					do{
						$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
						$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
						$Vl['ls'][$row_DtRg['mdl_enc']]['tot'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
    }

    public function UsMdls_In($p=NULL){

	    global $__cnx;

        $_cl = $this->GtCl();

		$__enc = Enc_Rnd($this->__mdl.'-'.$this->__us);
		$query_DtRg = sprintf("INSERT INTO ".TB_MDL_US." (mdlus_enc, mdlus_us, mdlus_mdl) VALUES ( %s,
								(SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s),
								(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s))",

						GtSQLVlStr(ctjTx($__enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->__us,'out'), "text"),
						GtSQLVlStr(ctjTx($this->__mdl,'out'), "text"));

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

	public function UsMdls_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		$query_DtRg = sprintf("DELETE FROM ".TB_MDL_US." WHERE
							mdlus_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) AND
							mdlus_mdl = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s)",
							GtSQLVlStr(ctjTx($this->__us,'out'), "text"),
						    GtSQLVlStr(ctjTx($this->__mdl,'out'), "text"));

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

    public function UsPlcy_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$query_DtRg = "SELECT *,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_US_PLCY.",
										"._BdStr(DBM).TB_US."
									WHERE
										usplcy_plcy = id_clplcy
									AND id_us = usplcy_us
									AND id_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$this->grp_id."')
								) as __est
							FROM
								"._BdStr(DBM).TB_CL_PLCY."
							WHERE clplcy_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."')
							ORDER BY clplcy_nm ASC ";

			$DtRg = $__cnx->_qry($query_DtRg);
			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['clplcy_enc']]['enc'] = $row_DtRg['clplcy_enc'];
						$Vl['ls'][$row_DtRg['clplcy_enc']]['nm'] = ctjTx($row_DtRg['clplcy_nm'],'in');
						$Vl['ls'][$row_DtRg['clplcy_enc']]['tot'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
    }

    public function UsPlcy_In($p=NULL){

	    global $__cnx;

        $_cl = $this->GtCl();

		$__enc = Enc_Rnd($this->__plcy.'-'.$this->__us);
		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_US_PLCY." (usplcy_enc, usplcy_us, usplcy_plcy) VALUES ( %s,
								(SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s),
								(SELECT id_clplcy FROM "._BdStr(DBM).TB_CL_PLCY." WHERE clplcy_enc = %s))",

						GtSQLVlStr(ctjTx($__enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->__us,'out'), "text"),
						GtSQLVlStr(ctjTx($this->__plcy,'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <--> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}


		return _jEnc($rsp);
	}

	public function UsPlcy_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_US_PLCY." WHERE
							usplcy_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) AND
							usplcy_plcy = (SELECT id_clplcy FROM "._BdStr(DBM).TB_CL_PLCY." WHERE clplcy_enc = %s)",

							GtSQLVlStr(ctjTx($this->__us,'out'), "text"),
						    GtSQLVlStr(ctjTx($this->__plcy,'out'), "text"));

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

    public function ClGrpPlcy_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$query_DtRg = "SELECT *,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_CL_GRP_PLCY.",
										"._BdStr(DBM).TB_CL_GRP."
									WHERE
										clgrpplcy_clplcy = id_clplcy
									AND id_clgrp = clgrpplcy_clgrp
									AND id_clgrp = (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."')
								) as __est
							FROM
								"._BdStr(DBM).TB_CL_PLCY."
							WHERE clplcy_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."')
							ORDER BY clplcy_nm ASC ";

			$DtRg = $__cnx->_qry($query_DtRg);
			$Vl['es'] = $query_DtRg;
			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['clplcy_enc']]['enc'] = $row_DtRg['clplcy_enc'];
						$Vl['ls'][$row_DtRg['clplcy_enc']]['nm'] = ctjTx($row_DtRg['clplcy_nm'],'in');
						$Vl['ls'][$row_DtRg['clplcy_enc']]['tot'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
    }

    public function ClGrpPlcy_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->cl_grp.'-'.$this->cl_plcy);

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_GRP_PLCY." (clgrpplcy_enc, clgrpplcy_clgrp, clgrpplcy_clplcy) VALUES ( %s,
								(SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s),
								(SELECT id_clplcy FROM "._BdStr(DBM).TB_CL_PLCY." WHERE clplcy_enc = %s))",

						GtSQLVlStr(ctjTx($__enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->cl_grp,'out'), "text"),
						GtSQLVlStr(ctjTx($this->cl_plcy,'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <--> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}

	public function ClGrpPlcy_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_GRP_PLCY." WHERE
							clgrpplcy_clgrp = (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s) AND
							clgrpplcy_clplcy = (SELECT id_clplcy FROM "._BdStr(DBM).TB_CL_PLCY." WHERE clplcy_enc = %s)",

							GtSQLVlStr(ctjTx($this->cl_grp,'out'), "text"),
						    GtSQLVlStr(ctjTx($this->cl_plcy,'out'), "text"));

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


    public function ClGrpUs_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$query_DtRg = "
					SELECT *,
					(	SELECT COUNT(*)
						FROM "._BdStr(DBM).TB_CL_GRP_US."
						WHERE id_us = clgrpus_us AND clgrpus_clgrp = (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."')
					) AS tot
			FROM "._BdStr(DBM).TB_US."
				 INNER JOIN "._BdStr(DBM).TB_US_CL." ON id_us = uscl_us
				 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
			WHERE cl_enc = '".DB_CL_ENC."'
			ORDER BY tot DESC, us_ap ASC, us_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						//$Vl['ls'][$row_DtRg['us_enc']]['id'] = $row_DtRg['id_us'];
						$Vl['ls'][$row_DtRg['us_enc']]['enc'] = $row_DtRg['us_enc'];
						$Vl['ls'][$row_DtRg['us_enc']]['nm'] = ctjTx($row_DtRg['us_nm'],'out').' '.ctjTx($row_DtRg['us_ap'],'out');
						$Vl['ls'][$row_DtRg['us_enc']]['user'] = ctjTx($row_DtRg['us_user'],'out');
						$Vl['ls'][$row_DtRg['us_enc']]['tot'] = $row_DtRg['tot'];

						if( !isN($row_DtRg['us_img']) ){

							$Vl['ls'][$row_DtRg['us_enc']]['img'] = _ImVrs([ 'img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

						}else{

							$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
							$Vl['ls'][$row_DtRg['us_enc']]['img'] = $_img;
						}


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}

	public function UsClGrp_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->us_id)){

			$query_DtRg = "
					SELECT *,
					(	SELECT COUNT(*)
						FROM "._BdStr(DBM).TB_CL_GRP_US."
						WHERE id_clgrp = clgrpus_clgrp AND clgrpus_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$this->us_id."')
					) AS tot
			FROM "._BdStr(DBM).TB_CL_GRP."
			WHERE clgrp_cl = '".DB_CL_ID."'
			ORDER BY tot DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						$Vl['ls'][$row_DtRg['clgrp_enc']]['enc'] = $row_DtRg['clgrp_enc'];
						$Vl['ls'][$row_DtRg['clgrp_enc']]['nm'] = ctjTx($row_DtRg['clgrp_nm'],'out');
						$Vl['ls'][$row_DtRg['clgrp_enc']]['tot'] = $row_DtRg['tot'];


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
    }


    public function SisCntEstAre_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->est_id)){

			$Vl['e'] = 'no';

		    if(!isN($this->est_id)){

				$query_DtRg = "SELECT
								*,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_SIS_CNT_EST_ARE." ,
										"._BdStr(DBM).TB_SIS_CNT_EST."
									WHERE
										siscntestare_are = id_clare
									AND id_siscntest = siscntestare_est
									AND siscntestare_est =(
										SELECT
											id_siscntest
										FROM
											"._BdStr(DBM).TB_SIS_CNT_EST."
										WHERE
											siscntest_enc = '".$this->est_id."'

									)
								) as __est
							FROM
								"._BdStr(DBM).TB_CL_ARE."
							WHERE
								clare_cl =(
									SELECT
										id_cl
									FROM
										"._BdStr(DBM).TB_CL."
									WHERE
										cl_enc = '".DB_CL_ENC."'
								) AND clare_est = 1
							ORDER BY
								clare_tt ASC
							";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['clare_enc']]['enc'] = $row_DtRg['clare_enc'];
							$Vl['ls'][$row_DtRg['clare_enc']]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
							$Vl['ls'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }

    public function SisFntCl_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		    if(!isN($this->fnt_id)){

				$query_DtRg = "SELECT
								*, (SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = "._CId('ID_SISTAG_CLR_MAIN')." AND cltag_cl = id_cl ) AS _cl_clr, (
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_SIS_FNT_CL." ,
										"._BdStr(DBM).TB_SIS_FNT."
									WHERE
										sisfntcl_sisfnt = id_sisfnt
									AND sisfntcl_cl = id_cl
									AND sisfnt_enc = '".$this->fnt_id."'
									) as __est
							FROM
								"._BdStr(DBM).TB_CL."
							ORDER BY
								cl_nm ASC
							";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['cl_enc']]['enc'] = $row_DtRg['cl_enc'];
							$Vl['ls'][$row_DtRg['cl_enc']]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');

							$Vl['ls'][$row_DtRg['cl_enc']]['clr'] = ctjTx($row_DtRg['_cl_clr'],'in');

							$Vl['ls'][$row_DtRg['cl_enc']]['tot'] = $row_DtRg['__est'];

							if( !isN($row_DtRg['cl_img']) ){
								$Vl['ls'][$row_DtRg['cl_enc']]['img'] = _ImVrs([ 'img'=>$row_DtRg['cl_img'], 'f'=>DMN_FLE_CL ]);
							}

						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
				$__cnx->_clsr($DtRg);
			}

		return _jEnc($Vl);
    }


    public function SisFntCl_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_FNT_CL." (sisfntcl_sisfnt, sisfntcl_cl) VALUES
								(
									(SELECT id_sisfnt FROM "._BdStr(DBM).TB_SIS_FNT." WHERE sisfnt_enc = %s),
									(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s)
								)",
					GtSQLVlStr(ctjTx($this->fnt_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->cl_id,'out'), "text"));

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


    public function SisFntCl_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_SIS_FNT_CL."  WHERE

		sisfntcl_sisfnt IN (SELECT id_sisfnt FROM "._BdStr(DBM).TB_SIS_FNT." WHERE sisfnt_enc = %s) AND
		sisfntcl_cl IN (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s)",

							GtSQLVlStr(ctjTx($this->fnt_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->cl_id,'out'), "text"));

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


    public function SisCntNoiAre_Ls($p=NULL){

	    global $__cnx;

	    if(!isN($this->cntnoi_id)){

			$Vl['e'] = 'no';

		    if(!isN($this->cntnoi_id)){

				$query_DtRg = "SELECT
								*,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_SIS_CNT_NOI_ARE." ,
										"._BdStr(DBM).TB_SIS_CNT_NOI."
									WHERE
										siscntnoiare_clare = id_clare
									AND id_siscntnoi = siscntnoiare_cntnoi
									AND siscntnoiare_cntnoi =(
										SELECT
											id_siscntnoi
										FROM
											"._BdStr(DBM).TB_SIS_CNT_NOI."
										WHERE
											siscntnoi_enc = '".$this->cntnoi_id."'

									)
								) as __est
							FROM
								"._BdStr(DBM).TB_CL_ARE."
							WHERE
								clare_cl =(
									SELECT
										id_cl
									FROM
										"._BdStr(DBM).TB_CL."
									WHERE
										cl_enc = '".DB_CL_ENC."'
								)
							ORDER BY
								__est DESC
							";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['clare_enc']]['enc'] = $row_DtRg['clare_enc'];
							$Vl['ls'][$row_DtRg['clare_enc']]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
							$Vl['ls'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }


    public function SisCntNoiAre_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO ".TB_SIS_CNT_NOI_ARE." (siscntnoiare_clare, siscntnoiare_cntnoi) VALUES
								(
									(SELECT id_clare FROM ".TB_CL_ARE." WHERE clare_enc = %s LIMIT 1),
									(SELECT id_siscntnoi FROM ".TB_SIS_CNT_NOI." WHERE siscntnoi_enc = %s LIMIT 1)
								)",
					GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->cntnoi_id,'out'), "text"));

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

    public function SisCntNoiAre_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".TB_SIS_CNT_NOI_ARE."  WHERE

		siscntnoiare_clare IN (SELECT id_clare FROM ".TB_CL_ARE." WHERE clare_enc = %s) AND
		siscntnoiare_cntnoi IN (SELECT id_siscntnoi FROM ".TB_SIS_CNT_NOI." WHERE siscntnoi_enc = %s)",

							GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->cntnoi_id,'out'), "text"));

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

    public function EcTp_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no'.$this->ec_id.'dddd';

	    if(!isN($this->ec_id)){

			$Vl['e'] = 'no';

		    if(!isN($this->ec_id)){

				$query_DtRg = "SELECT
							*,(
								SELECT
									COUNT(*)
								FROM
									"._BdStr(DBM).TB_EC_TP." ,
									"._BdStr(DBM).TB_EC."
								WHERE
										ecmdlstp_mdlstp = id_mdlstp
									AND id_ec = ecmdlstp_ec
									AND ecmdlstp_ec =(
										SELECT
											id_ec
										FROM
											"._BdStr(DBM).TB_EC."
										WHERE
											ec_enc = '".$this->ec_id."'
										LIMIT 1
									)
								LIMIT 1
							) as __est

						FROM
							"._BdStr(DBM).TB_MDL_S_TP."
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
						WHERE
							mdlstpcl_cl =(
								SELECT
									id_cl
								FROM
									"._BdStr(DBM).TB_CL."
								WHERE
									cl_enc = '".DB_CL_ENC."'
							)
						ORDER BY
							mdlstp_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['mdlstp_enc']]['enc'] = $row_DtRg['mdlstp_enc'];
							$Vl['ls'][$row_DtRg['mdlstp_enc']]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
							$Vl['ls'][$row_DtRg['mdlstp_enc']]['tot'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }


    public function EcTp_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_EC_TP."
		(ecmdlstp_ec, ecmdlstp_mdlstp) VALUES
		(
			(SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = %s),
			(SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s)
		)",
					GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->mdl_id,'out'), "text"));

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


    public function EcTp_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_TP."  WHERE

		ecmdlstp_ec IN (SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = %s) AND
		ecmdlstp_mdlstp IN (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s)",

							GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->mdl_id,'out'), "text"));

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


    public function EcLsts_Ls($p=NULL){

	    global $__cnx;

		if(!isN($this->ec_id)){

			$Vl['e'] = 'no';

		    if(!isN($this->ec_id)){

				$query_DtRg = "SELECT
							*,(
								SELECT
									COUNT(*)
								FROM
									"._BdStr(DBM).TB_EC_CMPG_LSTS.",
									"._BdStr(DBM).TB_EC_CMPG."
								WHERE
										eccmpglsts_cmpg = id_eccmpg
									AND id_eclsts = eccmpglsts_lsts
									AND eccmpglsts_cmpg =(
										SELECT
											id_eccmpg
										FROM
											"._BdStr(DBM).TB_EC_CMPG."
									WHERE
											eccmpg_enc = '".$this->ec_id."'
										LIMIT 1
									)
								LIMIT 1
							) as __est

						FROM
							"._BdStr(DBM).TB_EC_LSTS."
							INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = eclsts_cl
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON id_sisslc = eclsts_sndr
						WHERE
							eclsts_cl =(
								SELECT
									id_cl
								FROM
									"._BdStr(DBM).TB_CL."
								WHERE
									cl_enc = '".DB_CL_ENC."'
							)
						ORDER BY
							__est DESC, eclsts_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['eclsts_enc']]['enc'] = $row_DtRg['eclsts_enc'];
							$Vl['ls'][$row_DtRg['eclsts_enc']]['nm'] = ctjTx($row_DtRg['eclsts_nm'],'in');
							$Vl['ls'][$row_DtRg['eclsts_enc']]['tot'] = $row_DtRg['__est'];

							if( !isN($row_DtRg['sisslc_img']) ){
								$Vl['ls'][$row_DtRg['eclsts_enc']]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['sisslc_img'],'in');
							}else{
								$Vl['ls'][$row_DtRg['eclsts_enc']]['img'] = "";
							}

						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }


    public function EcLsts_In($p=NULL){

        global $__cnx;

        $__enc = Enc_Rnd($this->lsts_id.'-'.$this->ec_id);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_LSTS."
		(eccmpglsts_enc, eccmpglsts_cmpg, eccmpglsts_lsts) VALUES
		(
			%s ,
			(SELECT id_eccmpg FROM "._BdStr(DBM).TB_EC_CMPG." WHERE eccmpg_enc = %s),
			(SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc = %s)
		)",
					GtSQLVlStr(ctjTx($__enc,'out'), "text"),
					GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->lsts_id,'out'), "text"));

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


    public function EcLsts_Del($p=NULL){

		global $__cnx;


		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_CMPG_LSTS."   WHERE

		eccmpglsts_cmpg IN (SELECT id_eccmpg FROM "._BdStr(DBM).TB_EC_CMPG." WHERE eccmpg_enc = %s) AND
		eccmpglsts_lsts IN (SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc = %s) ",

							GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->lsts_id,'out'), "text"));

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


    // ------  Relacion de Campaña con Segmentos ------ //


    public function EcSgm_Ls($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

	    if(!isN($this->ec_id)){

			$query_DtRg = "SELECT
						*,(
							SELECT
								COUNT(*)
							FROM
								"._BdStr(DBM).TB_EC_CMPG_SGM.",
								"._BdStr(DBM).TB_EC_CMPG."
							WHERE
									eccmpgsgm_cmpg = id_eccmpg
								AND id_eclstssgm = eccmpgsgm_sgm
								AND eccmpgsgm_cmpg =(
									SELECT
										id_eccmpg
									FROM
										"._BdStr(DBM).TB_EC_CMPG."
									WHERE
										eccmpg_enc = '".$this->ec_id."'
									LIMIT 1
								)
							LIMIT 1
						) as __est

					FROM
						"._BdStr(DBM).TB_EC_LSTS_SGM."
						INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON id_eclsts = eclstssgm_lsts
						INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = eclsts_cl
					WHERE
						eclsts_cl = (
							SELECT
								id_cl
							FROM
								"._BdStr(DBM).TB_CL."
							WHERE
								cl_enc = '".DB_CL_ENC."'
						)
					ORDER BY
						__est DESC, eclstssgm_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['eclstssgm_enc']]['enc'] = $row_DtRg['eclstssgm_enc'];
						$Vl['ls'][$row_DtRg['eclstssgm_enc']]['nm'] = ctjTx($row_DtRg['eclstssgm_nm'],'in');
						$Vl['ls'][$row_DtRg['eclstssgm_enc']]['html'] = Strn(ctjTx($row_DtRg['eclsts_nm'],'in')).HTML_BR.ctjTx($row_DtRg['eclstssgm_nm'],'in');
						$Vl['ls'][$row_DtRg['eclstssgm_enc']]['fi'] = $row_DtRg['eclstssgm_fi'];
						$Vl['ls'][$row_DtRg['eclstssgm_enc']]['tot'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}
			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);

	}


	public function EcSgm_In($p=NULL){

        global $__cnx;

        $__enc = Enc_Rnd($this->sgm_id.'-'.$this->ec_id);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_SGM."
		(eccmpgsgm_enc, eccmpgsgm_cmpg, eccmpgsgm_sgm) VALUES
		(
			%s ,
			(SELECT id_eccmpg FROM "._BdStr(DBM).TB_EC_CMPG." WHERE eccmpg_enc = %s),
			(SELECT id_eclstssgm FROM "._BdStr(DBM).TB_EC_LSTS_SGM." WHERE eclstssgm_enc = %s)
		)",
					GtSQLVlStr(ctjTx($__enc,'out'), "text"),
					GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->sgm_id,'out'), "text"));

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


	public function EcSgm_Del($p=NULL){


		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_CMPG_SGM."   WHERE

		eccmpgsgm_cmpg IN (SELECT id_eccmpg FROM "._BdStr(DBM).TB_EC_CMPG." WHERE eccmpg_enc = %s) AND
		eccmpgsgm_sgm IN (SELECT id_eclstssgm FROM "._BdStr(DBM).TB_EC_LSTS_SGM." WHERE eclstssgm_enc = %s) ",

							GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->sgm_id,'out'), "text"));

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

    public function EcLstsAre_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					*, (SELECT
							COUNT(*)
						FROM
							"._BdStr(DBM).TB_EC_LSTS_ARE."
						INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON id_eclsts = eclstsare_eclsts
						WHERE
							eclstsare_clare = id_clare
						AND eclsts_enc = '".$this->ec_lsts_id."' ) as __est
				FROM
					"._BdStr(DBM).TB_CL_ARE."
				WHERE
					clare_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".DB_CL_ENC."')
				ORDER BY
					__est DESC, clare_tt ASC";


		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['qry'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['clare_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
					$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


    public function EcLstsAre_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->id_are.'-'.$this->ec_lsts_id);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_ARE."
		(eclstsare_enc, eclstsare_eclsts, eclstsare_clare) VALUES
		(
			%s,
			(SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc = %s),
			(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s)
		)",
					GtSQLVlStr(ctjTx($__enc,'out'), "text"),
					GtSQLVlStr(ctjTx($this->ec_lsts_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->id_are,'out'), "text"));

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


    public function EcLstsAre_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_LSTS_ARE."  WHERE

		eclstsare_eclsts IN (SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc = %s) AND
		eclstsare_clare IN (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s)",

							GtSQLVlStr(ctjTx($this->ec_lsts_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->id_are,'out'), "text"));

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


    public function EcAre_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no'.$this->ec_id.'dddd';

	    if(!isN($this->ec_id)){

			$Vl['e'] = 'no';

		    if(!isN($this->ec_id)){

				$query_DtRg = "SELECT
								*,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_EC_ARE." ,
										"._BdStr(DBM).TB_EC."
									WHERE
										ecare_are = id_clare
										AND id_ec = ecare_ec
										AND ecare_ec =(
											SELECT
												id_ec
											FROM
												"._BdStr(DBM).TB_EC."
											WHERE
												ec_enc = '".$this->ec_id."'
											LIMIT 1
										)
									LIMIT 1
								) as __est
							FROM
								"._BdStr(DBM).TB_CL_ARE."
							WHERE
								clare_cl =(
									SELECT
										id_cl
									FROM
										"._BdStr(DBM).TB_CL."
									WHERE
										cl_enc = '".CL_ENC."'
								)
							ORDER BY
								clare_tt ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['clare_enc']]['enc'] = $row_DtRg['clare_enc'];
							$Vl['ls'][$row_DtRg['clare_enc']]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
							$Vl['ls'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }

    public function EcAre_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_EC_ARE."
		(ecare_ec, ecare_are) VALUES
		(
			(SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = %s),
			(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s)
		)",
					GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->mdl_id,'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['mw'] = $query_DtRg;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

    public function EcAre_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_ARE."  WHERE

		ecare_ec IN (SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = %s) AND
		ecare_are IN (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s)",

							GtSQLVlStr(ctjTx($this->ec_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->mdl_id,'out'), "text"));


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


    public function ClGrpAre_Ls($p=NULL){

	    global $__cnx;

	    if(!isN($this->grp_id)){



		    if(!isN($this->grp_id)){

				$query_DtRg = "SELECT *,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_CL_GRP_ARE." ,
										"._BdStr(DBM).TB_CL_GRP."
									WHERE
										clgrpare_clare = id_clare
										AND id_clgrp = clgrpare_clgrp
										AND clgrpare_clgrp =(SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."')
								) as __est FROM
									"._BdStr(DBM).TB_CL_ARE."
								WHERE
									clare_cl =(
										SELECT
											id_cl
										FROM
											"._BdStr(DBM).TB_CL."
										WHERE
											cl_enc = '".CL_ENC."'
									) ORDER BY clare_tt ASC ";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['clare_enc']]['enc'] = $row_DtRg['clare_enc'];
							$Vl['ls'][$row_DtRg['clare_enc']]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
							$Vl['ls'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }


    public function ClGrpCol_Prnt($p=NULL){

        global $__cnx;

        if( !isN($p['cl_enc']) ){
	        $_cl = $this->GtCl([ "t"=>"enc", "enc"=>$p['cl_enc'] ]);
        }else{
	        $_cl = $this->GtCl();
        }

	    if( !isN($p['id']) ){ $_fl .= " AND id_clgrp = ".$p['id']." "; }
	    if( !isN($p['us']) ){ $_fl .= " AND clgrpus_us = ".$p['us']." "; }

	    $query_DtRg = " SELECT id_clgrp, clgrp_nm, clgrp_prnt
						FROM
							"._BdStr(DBM).TB_CL_GRP."
							INNER JOIN "._BdStr(DBM).TB_TRA_COL_GRP." ON tracolgrp_grp = id_clgrp
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON id_tracol = tracolgrp_tracol
							INNER JOIN "._BdStr(DBM).TB_CL_GRP_US." ON clgrpus_clgrp = id_clgrp
						WHERE id_clgrp != '' $_fl ";

		$DtRg = $__cnx->_qry($query_DtRg);

		$Vl['q'] = compress_code($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$Vl['ls'][$row_DtRg['id_clgrp']]['id'] = $row_DtRg['id_clgrp'];
					$Vl['ls'][$row_DtRg['id_clgrp']]['nm'] = $row_DtRg['clgrp_nm'];

					$Vl['all'][] = $row_DtRg['id_clgrp'];

					if( !isN($row_DtRg['clgrp_prnt']) ){
						$__get_sub = $this->ClGrpCol_Prnt([ "id"=>$row_DtRg['clgrp_prnt'], 'all'=>$Vl['all'], "cl_enc"=>$p["cl_enc"] ]);
						$Vl['ls'][$row_DtRg['id_clgrp']]['prnt'] = $__get_sub;
						if(!isN($__get_sub->all)){ $Vl['all'] = array_unique( array_merge($Vl['all'], $__get_sub->all) ); }
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['qrys'] = $query_DtRg;
				if(!isN( $Vl['all'] )){ $Vl['qry'] = implode(',', array_unique($Vl['all']) ); }

			}else{
				$Vl['e'] = 'no';
			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


    public function ClGrpMdl_Ls($p=NULL){

        global $__cnx;

	    $_cl = $this->GtCl();
	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$Vl['e'] = 'no';

		    if(!isN($this->grp_id)){

				$query_DtRg = "SELECT *,(
									SELECT
										COUNT(*)
									FROM
										".TB_CLGRP_MDL." ,
										"._BdStr(DBM).TB_CL_GRP."
									WHERE
										mdlgrp_mdl = id_mdl
										AND id_clgrp = mdlgrp_clgrp
										AND mdlgrp_clgrp =(SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."')
								) as __est FROM
									".TB_MDL."";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
							$Vl['ls'][$row_DtRg['mdl_enc']]['tot'] = $row_DtRg['__est'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		return _jEnc($Vl);
    }

    public function ClGrpEst_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->grp_id)){

			$query_DtRg = "
					SELECT *,
							(	SELECT COUNT(*)
								FROM "._BdStr(DBM).TB_CL_GRP_EST."
								WHERE id_siscntest = clgrpest_est AND clgrpest_clgrp = '".$this->grp_id."'
							) AS tot
					FROM "._BdStr(DBM).TB_SIS_CNT_EST."
						 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntest_cl = id_cl
						 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
					WHERE cl_enc = '".DB_CL_ENC."'
					ORDER BY siscntesttp_ord ASC, siscntest_tt ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						//id_siscntesttp
						//cntesttp_tt

						if(isN( $Vl['ls'][$row_DtRg['siscntesttp_enc']]['ls'] )){
							$Vl['ls'][$row_DtRg['siscntesttp_enc']]['ls'] = array();
						}

						$Vl['ls'][$row_DtRg['siscntesttp_enc']]['enc'] = $row_DtRg['siscntesttp_enc'];
						$Vl['ls'][$row_DtRg['siscntesttp_enc']]['nm'] = ctjTx($row_DtRg['siscntesttp_tt'],'in');

						$__ob = [
							'enc'=>$row_DtRg['siscntest_enc'],
							'nm'=>ctjTx($row_DtRg['siscntest_tt'],'in'),
							'clr'=>ctjTx($row_DtRg['siscntest_clr_bck'],'in'),
							'tot'=>$row_DtRg['tot']
						];

						array_push( $Vl['ls'][$row_DtRg['siscntesttp_enc']]['ls'], $__ob);


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
    }


    public function ClGrpTra_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';


		    $_cl = $this->GtCl();

			$query_DtRg = "
					SELECT
						*,(
							SELECT COUNT(*) FROM "._BdStr(DBM).TB_TRA_COL." WHERE
								id_tracol != ''
							AND id_tracol IN(
								SELECT
									tracolgrp_tracol
								FROM
									"._BdStr(DBM).TB_TRA_COL_GRP."
								WHERE
									tracolgrp_grp IN( SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."' ) ) ORDER BY id_tracol DESC ) AS __rgtot
					FROM
						"._BdStr(DBM).TB_TRA_COL."
					WHERE
						id_tracol != ''
					AND id_tracol IN( SELECT tracolgrp_tracol FROM "._BdStr(DBM).TB_TRA_COL_GRP." WHERE tracolgrp_grp IN( SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."' ) )
					ORDER BY
						id_tracol DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

			}
			$__cnx->_clsr($DtRg);


		return _jEnc($Vl);
    }

	public function ClGrpPrm_Ls($p=NULL){

      	global $__cnx;

      	$Vl['e'] = 'no';

  		if(!isN($this->grp_id)){
      		$__tot_grp = "
      			, (
					SELECT COUNT(*)
					FROM "._BdStr(DBM).TB_CL_GRP_PRM."
						  INNER JOIN "._BdStr(DBM).TB_CL_GRP." ON clgrpprm_clgrp = id_clgrp
					WHERE clgrpprm_clgrp = (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->grp_id."') AND clgrpprm_prm = id_mdlstpprm


				) AS tot_grp

      		";
      		$__tot_grp_ord = " tot_grp DESC, ";
  		}

  		if(!isN( $this->mdlstp_id )){
      		$__fl .= sprintf(" AND mdlstpprm_mdlstp = %s ", GtSQLVlStr($this->mdlstp_id, "int"));
  		}


		$query_DtRg = "

			SELECT *,

				".GtSlc_QryExtra(array('t'=>'fld', 'p'=>'icon', 'als'=>'i'))."
				".$__tot_grp."

			FROM "._BdStr(DBM).TB_MDL_S_TP_PRM."
				 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlstpprm_mdlstp = id_mdlstp
				 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlstpprm_tp', 'als'=>'i' ])."

			WHERE

				mdlstpprm_mdlstp IN (
					SELECT
						id_mdlstp
					FROM "._BdStr(DBM).TB_MDL_S_TP_CL."
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlstpcl_mdlstp = id_mdlstp
						 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
					WHERE cl_enc = '".DB_CL_ENC."'
				)

				{$__fl}

			ORDER BY mdlstp_nm ASC, {$__tot_grp_ord} mdlstpprm_nm ASC
		";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
			$Vl['e'] = 'ok';

			if($Tot_DtRg > 0){

				do{

					$_igrp = $row_DtRg['mdlstp_enc'];
					$__ob = array();

					if(!isN($row_DtRg['mdlstp_nm'])){

						if(isN( $Vl['ls'][$_igrp]['ls'] )){
							$Vl['ls'][$_igrp]['ls'] = array();
						}

						$Vl['ls'][$_igrp]['enc'] = $_igrp;
						$Vl['ls'][$_igrp]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');

						$__ob = [
							'enc'=>$row_DtRg['mdlstpprm_enc'],
							'nm'=>ctjTx($row_DtRg['mdlstpprm_nm'],'in'),
							'sbt'=>ctjTx($row_DtRg['mdlstpprm_vl'],'in'),
							'clr'=>ctjTx($row_DtRg['siscntest_clr_bck'],'in'),
							'img'=>DMN_FLE_SIS_SLC.ctjTx($row_DtRg['icon_sisslc_img'],'in')
						];


						if(!isN($row_DtRg['tot_grp'])){ $__ob['tot']['grp'] = $row_DtRg['tot_grp']; }

						if(!isN($__ob) && !isN($_igrp)){ array_push( $Vl['ls'][$_igrp]['ls'], $__ob); }

					}

				}while($row_DtRg = $DtRg->fetch_assoc());
			}


		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
    }

	public function MdlCntPrd_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

	    if(!isN($p['mdl'])){ $__f_sub = sprintf(" AND mdlcntprd_mdlcnt = %s ", GtSQLVlStr($p['mdl'], "int"));	 }

		$query_DtRg = "
				SELECT mdlsprd_enc, mdlsprd_nm, mdlsprd_y, mdlsprd_s,

					 (	SELECT

					 		CONCAT(

					 			JSON_OBJECT(
						 			'id', IF(id_mdlcntprd IS NULL, '', id_mdlcntprd),
						 			'est', IF(mdlcntprd_est IS NULL, '', mdlcntprd_est)
					 			)

					 		) AS __o

					 	FROM ".TB_MDL_CNT_PRD."
					 	WHERE mdlcntprd_mdlsprd = id_mdlsprd {$__f_sub}
					 ) AS __o

				FROM "._BdStr(DBM).TB_MDL_S_PRD."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlsprd_cl = id_cl
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD_TP." ON mdlsprdtp_prd = id_mdlsprd
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlsprdtp_tp = id_mdlstp
				WHERE cl_enc = '".DB_CL_ENC."' AND mdlstp_tp = '".$p['tp']."' AND mdlsprd_est = 1 ORDER BY mdlsprd_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['tod'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlsprd_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlsprd_nm'],'in');
					$Vl['ls'][$id_ob]['y'] = ctjTx($row_DtRg['mdlsprd_y'],'in');
					$Vl['ls'][$id_ob]['s'] = ctjTx($row_DtRg['mdlsprd_s'],'in');

					if(!isN($row_DtRg['__o'])){
						$___col = json_decode($row_DtRg['__o']);
						$Vl['ls'][$id_ob]['in']['id'] = $___col->id;
						$Vl['ls'][$id_ob]['in']['est'] = mBln($___col->est);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function MdlCntHCntc_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

		$query_DtRg = "
					SELECT clhcntc_enc, clhcntc_nm,
							(	SELECT COUNT(*)
								FROM ".$this->bd.TB_CNT_H_CNTC."
								WHERE cnthcntc_clhcntc = id_clhcntc AND cnthcntc_cnt = '".$p['mdl']."'
							) AS tot
					FROM "._BdStr(DBM).TB_CL_H_CNTC."
					WHERE id_clhcntc != ''
					AND clhcntc_cl = '".$_cl->id."'
					ORDER BY clhcntc_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['tod'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['shw'] = 'no';

				do{

					$id_ob = $row_DtRg['clhcntc_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['clhcntc_nm'],'in');
					$Vl['ls'][$id_ob]['est'] = mBln($row_DtRg['tot']);

					if($row_DtRg['tot'] > 0){ $Vl['shw'] = 'ok'; }


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

    public function MdlSPrd_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

	    if(!isN($p['mdl'])){ $__f_sub = sprintf(" AND mdlprd_mdl = %s ", GtSQLVlStr($p['mdl'], "int"));	 }

		$query_DtRg = "
				SELECT *,

					 (	SELECT

					 		JSON_OBJECT(
					 			'id', IF(id_mdlprd IS NULL, '', id_mdlprd),
					 			'est', IF(mdlprd_est IS NULL, '', mdlprd_est)
				 			) AS __o

					 	FROM ".TB_MDL_PRD."
					 	WHERE mdlprd_prd = id_mdlsprd {$__f_sub}
					 ) AS __o

				FROM "._BdStr(DBM).TB_MDL_S_PRD."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlsprd_cl = id_cl
				WHERE cl_enc = '".DB_CL_ENC."' ORDER BY mdlsprd_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlsprd_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlsprd_nm'],'in');
					$Vl['ls'][$id_ob]['y'] = ctjTx($row_DtRg['mdlsprd_y'],'in');
					$Vl['ls'][$id_ob]['s'] = ctjTx($row_DtRg['mdlsprd_s'],'in');

					if(!isN($row_DtRg['__o'])){
						$___col = json_decode($row_DtRg['__o']);
						$Vl['ls'][$id_ob]['in']['id'] = $___col->id;
						$Vl['ls'][$id_ob]['in']['est'] = mBln($___col->est);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


    public function MdlSAre_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					*, (SELECT
							COUNT(*)
						FROM
							".TB_MDL_ARE.", ".TB_MDL."
						WHERE
							mdlare_are = id_clare
						AND id_mdl = mdlare_mdl
						AND id_mdl = ".$p['mdl']." ) as __est
				FROM
					"._BdStr(DBM).TB_CL_ARE."
				WHERE
					clare_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".DB_CL_ENC."') AND clare_est = 1
				ORDER BY
					__est DESC, clare_tt ASC";


		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['qry'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['clare_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
					$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

    public function MdlUs_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					*, (SELECT
							COUNT(*)
						FROM
							".TB_MDL_US_SND.", ".TB_MDL."
						WHERE
							mdlussnd_us = id_us
						AND id_mdl = mdlussnd_mdl
						AND id_mdl = ".$p['mdl']." ) as __est
				FROM
					"._BdStr(DBM).TB_US."
					INNER JOIN "._BdStr(DBM).TB_US_CL." ON id_us = uscl_us
					INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = uscl_cl
				WHERE
					uscl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".DB_CL_ENC."')
				ORDER BY
					__est DESC, us_nm ASC";


		$DtRg = $__cnx->_qry($query_DtRg);



		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				 $Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['us_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');
					$Vl['ls'][$id_ob]['user'] = ctjTx($row_DtRg['us_user'],'in');
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['us_nm'],'out').' '.ctjTx($row_DtRg['us_ap'],'out');

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


    public function MdlMdl_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					*, ( SELECT
							COUNT(*)
						FROM
							".TB_MDL_MDL."
						WHERE
							id_mdl = mdlmdl_mdl AND
							mdlmdl_main = ".$p['mdl']."

						) as __est

					FROM ".TB_MDL."
					WHERE mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
					ORDER BY __est DESC
				";


		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				 $Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdl_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;

					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
					$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


    public function MdlSTpAttr_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

	    if(!isN($this->mdlstp_id)){ $__f_sub = " AND mdlstpattr_mdlstp = '".$this->mdlstp_id."' "; }

		$query_DtRg = "
				SELECT *,
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'attr', 'als'=>'a' ])."
				FROM "._BdStr(DBM).TB_MDL_S_TP_ATTR."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpattr_cl = id_cl
					 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlstpattr_attr', 'als'=>'a' ])."
				WHERE cl_enc = '".DB_CL_ENC."' {$__f_sub}
				ORDER BY attr_sisslc_tt ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstpattr_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['attr_sisslc_tt'],'in');

					$___col = json_decode($row_DtRg['__o']);

					if($___col['id']){
						$Vl['ls'][$id_ob]['in'] = print_r($___col, true);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function MdlSTpFm_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

		$query_DtRg = "
				SELECT mdlstpfm_enc, id_mdlstpfm, mdlstpfm_nm
				FROM "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE id_mdlstpfm != '' AND mdlstpfm_enc = '".$this->fm_id."'
				AND mdlstpfm_cl = '".$_cl->id."'
				ORDER BY mdlstpfm_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);



		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstpfm_enc'];
					$Vl['enc'] = $id_ob;
					$Vl['nm'] = ctjTx($row_DtRg['mdlstpfm_nm'],'in');
					$Vl['row'] = $this->MdlSTpFmRow_Ls(['id'=>$row_DtRg['id_mdlstpfm']]);
					$Vl['fld'] = $this->MdlSTpFmFld_Ls(['id'=>$row_DtRg['id_mdlstpfm']]);
					$Vl['cnt_tp'] = $this->MdlSTpFmCntTp_Ls(['id'=>$row_DtRg['id_mdlstpfm']]);

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

    public function MdlSTpFmRow_Dt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['enc'])){ $_fl = 'mdlstpfmrow_mdlstpfm = (SELECT id_mdlstpfm FROM '._BdStr(DBM).TB_MDL_S_TP_FM.' WHERE mdlstpfm_enc = "'.$_p['enc'].'")';  }
		else{
			$_fl = 'id_mdlstpfmrow = '.$_p['id'].'';
		}

		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE $_fl ORDER BY mdlstpfmrow_ord DESC LIMIT 1";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['id'] = $row_DtRg['id_mdlstpfmrow'];
			$Vl['ord'] = $row_DtRg['mdlstpfmrow_ord'];

		}
		$__cnx->_clsr($DtRg);

		$Vl['e'] = $query_DtRg;

		return _jEnc($Vl);
	}

	public function MdlSTpFmFld_Ls($p=NULL){

		global $__cnx;

		$query_DtRg = "SELECT
						*
					FROM
						"._BdStr(DBM).TB_SIS_SLC."
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_CL." ON id_sisslc = sisslccl_sisslc
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON id_sisslctp = sisslc_tp
					WHERE
						id_sisslc NOT IN(
							SELECT
								mdlstpfmrowfld_fld
							FROM
								"._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD."
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." ON id_mdlstpfmrow = mdlstpfmrowfld_mdlstpfmrow
							WHERE mdlstpfmrow_mdlstpfm = '".$p['id']."'

						)
					AND sisslctp_key IN('mdl_cnt_attr','cnt_attr')
					AND sisslccl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."')";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['sisslc_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}

	public function MdlSTpFmRowFldAttr_Ls($p=NULL){

	    global $__cnx;

		$query_DtRg = "SELECT
							mdlstpfmrowfldattr_attr, mdlstpfmrowfldattr_fld, mdlstpfmrowfldattr_vl, mdlstpfmrowfldattr_enc, mdlstpfmrowfld_enc
						FROM
							"._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD_ATTR."
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." ON mdlstpfmrowfldattr_fld = id_mdlstpfmrowfld
						WHERE
							mdlstpfmrowfld_enc = '".$this->fld."' ";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstpfmrowfldattr_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['attr'] = ctjTx($row_DtRg['mdlstpfmrowfldattr_attr'],'in');
					$Vl['ls'][$id_ob]['fld'] = ctjTx($row_DtRg['mdlstpfmrowfldattr_fld'],'in');
					$Vl['ls'][$id_ob]['vl'] = ctjTx($row_DtRg['mdlstpfmrowfldattr_vl'],'in');
					$Vl['ls'][$id_ob]['enc_fld'] = ctjTx($row_DtRg['mdlstpfmrowfld_enc'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());

			}
		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}

	public function MdlSTpFmRowFldAttr_In($p=NULL){

	    global $__cnx;

		$__enc = Enc_Rnd($this->attr.'-'.$this->vl);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD_ATTR." (mdlstpfmrowfldattr_enc, mdlstpfmrowfldattr_attr, mdlstpfmrowfldattr_vl, mdlstpfmrowfldattr_fld) VALUES (%s, %s, %s, (SELECT id_mdlstpfmrowfld FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." WHERE mdlstpfmrowfld_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->attr, "text"),
							GtSQLVlStr($this->vl, "text"),
							GtSQLVlStr($this->fld, "int"));

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

	public function MdlSTpFmRowFldAttr_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD_ATTR." WHERE
											mdlstpfmrowfldattr_enc = %s AND
											mdlstpfmrowfldattr_fld = (SELECT id_mdlstpfmrowfld FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." WHERE mdlstpfmrowfld_enc = %s)",
											GtSQLVlStr($this->enc, "text"),
											GtSQLVlStr($this->fld, "text"));
		$Result = $__cnx->_prc($query_DtRg);

		$rsp['defff'] = $query_DtRg;

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}

	public function MdlSTpFmRowFldAttr_Edt($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD_ATTR." SET mdlstpfmrowfldattr_attr = %s, mdlstpfmrowfldattr_vl = %s WHERE mdlstpfmrowfldattr_enc = %s",
								GtSQLVlStr($this->attr, "text"),
								GtSQLVlStr($this->vl, "text"),
								GtSQLVlStr($this->enc, "text")
							);
		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['err'] = $__cnx->c_p->error.' '.$updateSQL;


		return _jEnc($rsp);
    }

    public function MdlSTpCtg($p=NULL){

        global $__cnx;

        $__ctg = __LsDt([ 'k'=>'crmt_ctg' ]);

        foreach($__ctg->ls->crmt_ctg as $__ctg_k=>$__ctg_v){
        	$__id[] = $__ctg_v->id;
        }

		$query_DtRg = "SELECT
					*,	(SELECT
						COUNT(*)
					FROM
						"._BdStr(DBM).TB_MDL_S_TP_CTG."
					WHERE
						id_sisslc = mdlstpctg_ctg
					AND mdlstpctg_mdlstp = '".$this->mdlstp_id."' ) __est
					FROM
					    "._BdStr(DBM).TB_SIS_SLC."
					WHERE id_sisslc IN (".implode(',',$__id)." )
					";


		$DtRg = $__cnx->_qry($query_DtRg);

		$Vl['ed'] = $__cnx->c_r->error;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['sisslc_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'],'in');
					$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }

    public function MdlSTpCtg_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_CTG." WHERE
											mdlstpctg_mdlstp = %s AND
											mdlstpctg_ctg = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)",

											GtSQLVlStr($this->mdlstp_id, "text"),
											GtSQLVlStr($this->id_ctg, "text"));
		$Result = $__cnx->_prc($query_DtRg);

		$rsp['defff'] = $query_DtRg;

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}

	public function MdlSTpCtg_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->mdlstp_id.'-'.$this->id_ctg);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_CTG." (mdlstpctg_enc, mdlstpctg_mdlstp, mdlstpctg_ctg) VALUES (%s, %s, (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlstp_id, "text"),
							GtSQLVlStr($this->id_ctg, "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['error'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}

	/* --------------------------------------------- */

	public function MdlSTpFmRow_Ls($p=NULL){

		global $__cnx;

		$query_DtRg = "
				SELECT mdlstpfmrow_enc, mdlstpfmrow_cols, mdlstpfmrow_ord, id_mdlstpfmrow
				FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE id_mdlstpfmrow != '' AND mdlstpfmrow_mdlstpfm = '".$p['id']."'
				ORDER BY mdlstpfmrow_ord ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['mdlstpfmrow_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['cols'] = ctjTx($row_DtRg['mdlstpfmrow_cols'],'in');
					$Vl['ls'][$id_ob]['ord'] = ctjTx($row_DtRg['mdlstpfmrow_ord'],'in');
					$Vl['ls'][$id_ob]['fld'] = $this->MdlSTpFmRowFld_Ls(['id'=>$row_DtRg['id_mdlstpfmrow']]);

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function MdlSTpFmRowFld_Ls($p=NULL){

		global $__cnx;

		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlstpfmrowfld_fld = id_sisslc WHERE id_mdlstpfmrowfld != '' AND mdlstpfmrowfld_mdlstpfmrow = '".$p['id']."'
				ORDER BY mdlstpfmrowfld_ord ASC";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					$id_ob = $row_DtRg['sisslc_enc'];

					if(!isN($row_DtRg['mdlstpfmrowfld_tt']) ||
							$row_DtRg['mdlstpfmrowfld_fld'] == _CId('ID_CNTATTR_TT') ||
							$row_DtRg['mdlstpfmrowfld_fld'] == _CId('ID_CNTATTR_SB_TT')||
							$row_DtRg['mdlstpfmrowfld_fld'] == _CId('ID_CNTATTR_SB_TT_2') )
					{

						$Vl['ls'][$id_ob]['tp'] = 'tt';
						$_tt = ' - '.$row_DtRg['mdlstpfmrowfld_tt'];
						$Vl['ls'][$id_ob]['tt_edt'] = 'ok';

					}

					$Vl['ls'][$id_ob]['cmps'] = $this->MdlSTpFmRowFld_LsRel([ 'id' => $row_DtRg['mdlstpfmrowfld_fld'] ]);

					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['fld'] = $row_DtRg['mdlstpfmrowfld_fld'];
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'].$_tt,'in');
					$Vl['ls'][$id_ob]['enc_fldrow'] = ctjTx($row_DtRg['mdlstpfmrowfld_enc'],'in');
					$Vl['ls'][$id_ob]['tt_d'] = ctjTx($row_DtRg['mdlstpfmrowfld_tt'],'in');



				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
	}

	public function MdlSTpFmRowFld_LsRel($p=NULL){

		global $__cnx;

		$query_DtRg = "
				SELECT sisslctpf_key, sisslcf_vl
					FROM "._BdStr(DBM).TB_SIS_SLC."
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_F." ON sisslcf_slc = id_sisslc
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP_F." ON sisslcf_f = id_sisslctpf
					WHERE id_sisslc != '' AND id_sisslc = '".$p['id']."' ";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['sisslctpf_key'];
					$Vl['ls'][$id_ob] = ctjTx($row_DtRg['sisslcf_vl'].$_tt,'in');

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
    }
	public function MdlSTpFmRow_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->fm_id.'-'.$this->dt);
		$_ord = $this->MdlSTpFmRow_Dt([ 'enc' => $this->fm_id]);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." (

		mdlstpfmrow_enc, mdlstpfmrow_mdlstpfm, mdlstpfmrow_cols, mdlstpfmrow_ord) VALUES (%s, (SELECT id_mdlstpfm FROM "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s), %s, %s) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->fm_id, "text"),
							GtSQLVlStr(1,"int"),
							GtSQLVlStr($_ord->ord + 1, "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno.' <-< '.$query_DtRg;
		}

		return _jEnc($rsp);

	}

	public function MdlSTpFmRowFld_Edt($p=NULL){

		global $__cnx;

		$tp = ctjTx($this->tt, 'out');


		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." SET mdlstpfmrowfld_tt = %s WHERE mdlstpfmrowfld_enc = %s",
                             GtSQLVlStr($tp, "text"),
                             GtSQLVlStr($this->fld, "text"));
		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['err'] = $__cnx->c_p->error.' '.$updateSQL;


		return _jEnc($rsp);
    }

	public function MdlSTpFmRowFld_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." WHERE mdlstpfmrowfld_enc = %s",
							GtSQLVlStr($p['enc'], "text"));
		$Result = $__cnx->_prc($query_DtRg);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function MdlSTpFmRow_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE mdlstpfmrow_enc = %s",
							GtSQLVlStr($p['enc'], "text"));
		$Result = $__cnx->_prc($query_DtRg);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}

	/* ---  Relacion del vinculo con el formulario  --- */
	public function MdlSTpFmCntTp_Ls($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		$query_DtRg = "SELECT
					*, ( SELECT
							COUNT(*)
						FROM
							"._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP."
						WHERE
							id_siscnttp = mdlstpfmcnttp_siscnttp
						AND mdlstpfmcnttp_mdlstpfm = '".$p['id']."'	) __est
					FROM
					    "._BdStr(DBM).TB_SIS_CNT_TP." WHERE siscnttp_cl = '".$_cl->id."' ORDER BY __est DESC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['siscnttp_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['siscnttp_nm'],'in');
					$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }
	public function MdlSTpFmCntTp_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP." WHERE
											mdlstpfmcnttp_mdlstpfm = (SELECT id_mdlstpfm FROM "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s) AND
											mdlstpfmcnttp_siscnttp = (SELECT id_siscnttp FROM "._BdStr(DBM).TB_SIS_CNT_TP." WHERE siscnttp_enc = %s)",

											GtSQLVlStr($p['id_fm'], "text"),
											GtSQLVlStr($p['id_cnttp'], "text"));
		$Result = $__cnx->_prc($query_DtRg);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function MdlSTpFmCntTp_In($p=NULL){

		$__enc = Enc_Rnd($p['id_fm'].'-'.$p['id_cnttp']);

		$query_DtRg =   sprintf("INSERT INTO  "._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP." (
							mdlstpfmcnttp_enc, mdlstpfmcnttp_mdlstpfm, mdlstpfmcnttp_siscnttp) VALUES
							(%s, (SELECT id_mdlstpfm FROM "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s),
							(SELECT id_siscnttp FROM ".TB_SIS_CNT_TP." WHERE siscnttp_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p['id_fm'], "text"),
							GtSQLVlStr($p['id_cnttp'], "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['error'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}
	// --- Aplicacion --- //
	public function ApplFm_Ls($p=NULL){

		global $__cnx;

	    $_cl = $this->GtCl();

	    if(!isN($this->cl_id)){ $cl = $this->cl_id; }else{ $cl = $_cl->id; }


		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_APPL_FM." WHERE id_applfm != '' AND applfm_enc = '".$this->fm_id."'
				AND applfm_cl = '".$cl."'
				ORDER BY applfm_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['applfm_enc'];
					$Vl['enc'] = $id_ob;
					$Vl['nm'] = ctjTx($row_DtRg['applfm_nm'],'in');
					$Vl['row'] = $this->ApplFmRow_Ls(['id'=>$row_DtRg['id_applfm']]);
					$Vl['fld'] = $this->ApplFmFld_Ls(['id'=>$row_DtRg['id_applfm']]);

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }
    public function ApplFmRow_Ls($p=NULL){

	    global $__cnx;

		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE id_applfmrow != '' AND applfmrow_applfm = '".$p['id']."'
				ORDER BY applfmrow_ord ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['applfmrow_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['cols'] = ctjTx($row_DtRg['applfmrow_cols'],'in');
					$Vl['ls'][$id_ob]['ord'] = ctjTx($row_DtRg['applfmrow_ord'],'in');
					$Vl['ls'][$id_ob]['fld'] = $this->ApplFmRowFld_Ls(['id'=>$row_DtRg['id_applfmrow']]);

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }
    public function ApplFmFld_Ls($p=NULL){

		global $__cnx;

		$query_DtRg = "SELECT
						*
					FROM
						"._BdStr(DBM).TB_SIS_SLC."
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_CL." ON id_sisslc = sisslccl_sisslc
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON id_sisslctp = sisslc_tp
					WHERE
						id_sisslc NOT IN(
							SELECT
								applfmrowfld_fld
							FROM
								"._BdStr(DBM).TB_APPL_FM_ROW_FLD."
							INNER JOIN "._BdStr(DBM).TB_APPL_FM_ROW." ON id_applfmrow = applfmrowfld_applfmrow
							WHERE applfmrow_applfm = '".$p['id']."'
							AND applfmrowfld_fld != "._CId('ID_APPLATTR_TT')." AND applfmrowfld_fld != "._CId('ID_APPLATTR_SB_TT')." AND applfmrowfld_fld != "._CId('ID_APPLATTR_SB_TT_2')."
						)
					AND sisslctp_key IN('appl_attr','cnt_attr')
					AND sisslccl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."')";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['sisslc_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }
    public function ApplFmRowFld_Ls($p=NULL){

		global $__cnx;

		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_APPL_FM_ROW_FLD." INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON applfmrowfld_fld = id_sisslc WHERE id_applfmrowfld != '' AND applfmrowfld_applfmrow = '".$p['id']."'
				ORDER BY applfmrowfld_ord ASC";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					$id_ob = $row_DtRg['sisslc_enc'];
					if(!isN($row_DtRg['applfmrowfld_tt']) ||
							$row_DtRg['applfmrowfld_fld'] == _CId('ID_APPLATTR_HDR') ||
							$row_DtRg['applfmrowfld_fld'] == _CId('ID_APPLATTR_TT') ||
							$row_DtRg['applfmrowfld_fld'] == _CId('ID_APPLATTR_SB_TT') ||
							$row_DtRg['applfmrowfld_fld'] == _CId('ID_APPLATTR_SB_TT_2'))
					{

						if($row_DtRg['applfmrowfld_fld'] == _CId('ID_APPLATTR_HDR')){
							$Vl['ls'][$id_ob]['tp'] = 'hrd';
						}else{
							$Vl['ls'][$id_ob]['tp'] = 'tt';
						}

						$_tt = ' - '.$row_DtRg['applfmrowfld_tt'];
						$Vl['ls'][$id_ob]['tt_edt'] = 'ok';
					}


					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['fld'] = $row_DtRg['applfmrowfld_fld'];
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'].$_tt,'in');
					$Vl['ls'][$id_ob]['tt_d'] = ctjTx($row_DtRg['applfmrowfld_tt'],'in');
					$Vl['ls'][$id_ob]['enc_fldrow'] = ctjTx($row_DtRg['applfmrowfld_enc'],'in');
					$Vl['ls'][$id_ob]['rqd'] = ctjTx($row_DtRg['applfmrowfld_rqd'],'in');
					$Vl['ls'][$id_ob]['flt_exc'] = ctjTx($row_DtRg['applfmrowfld_fltexc'],'in');
					$Vl['ls'][$id_ob]['flt_tp'] = ctjTx($row_DtRg['applfmrowfld_flttp'],'in');
					$Vl['ls'][$id_ob]['val_adc'] = ctjTx($row_DtRg['applfmrowfld_vladc'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
    }
    public function ApplFmRow_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->fm_id.'-'.$this->dt);
		$_ord = $this->ApplFmRow_Dt([ 'enc' => $this->fm_id]);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_APPL_FM_ROW." (

		applfmrow_enc, applfmrow_applfm, applfmrow_cols, applfmrow_ord) VALUES (%s, (SELECT id_applfm FROM "._BdStr(DBM).TB_APPL_FM." WHERE applfm_enc = %s), %s, %s) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->fm_id, "text"),
							GtSQLVlStr(1,"int"),
							GtSQLVlStr($_ord->ord + 1, "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['dqw'] = $_ord;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno.' <-< '.$query_DtRg;
		}

		return _jEnc($rsp);

	}

	public function ApplFmRow_Dt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['enc'])){ $_fl = 'applfmrow_applfm = (SELECT id_applfm FROM '._BdStr(DBM).TB_APPL_FM.' WHERE applfm_enc = "'.$_p['enc'].'")';  }
		else{
			$_fl = 'id_applfmrow = '.$_p['id'].'';
		}

		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE $_fl ORDER BY applfmrow_ord DESC LIMIT 1";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['id'] = $row_DtRg['id_applfmrow'];
			$Vl['ord'] = $row_DtRg['applfmrow_ord'];

		}

		$__cnx->_clsr($DtRg);

		$Vl['e'] = $query_DtRg;

		return _jEnc($Vl);
	}

	public function ApplFmRowFldOrd_Mod($p=NULL){

		global $__cnx;

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfld_ord = NULL WHERE
			applfmrowfld_applfmrow =( SELECT id_applfmrow FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE applfmrow_enc = %s )",
                                GtSQLVlStr($p['row'], "text"));

			$Result = $__cnx->_prc($updateSQL);

			$rsp['e'] = $Result;
			$rsp['err'] = $__cnx->c_p->error.' '.$updateSQL;

			$rtrn = _jEnc($rsp);
			return($rtrn);
    }
    public function ApplFmRowFld_Mod($p=NULL){

		global $__cnx;

		if($p['ord'] == 'NULL'){ $ord = 'NULL'; $tx = 'text'; }else{ $ord = $p['ord'];  $tx = 'int'; }
		if(!isN($p['old'])){ $row = $p['old']; }else{ $row = $p['row'];  }

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfld_ord = %s,
		applfmrowfld_applfmrow = (SELECT id_applfmrow FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE applfmrow_enc = %s) WHERE applfmrowfld_fld = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) AND applfmrowfld_applfmrow =( SELECT id_applfmrow FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE applfmrow_enc = %s )",
                             GtSQLVlStr($p['ord'], $tx),
                             GtSQLVlStr($p['row'], "text"),
                             GtSQLVlStr($p['enc'], "text"),
                             GtSQLVlStr($row, "text"));
		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['err'] = $__cnx->c_p->error.' '.$updateSQL;


		return _jEnc($rsp);
    }

    public function ApplFmRowFld_Edt($p=NULL){

		global $__cnx;

		if($this->tp == 'hrd'){ $tp = ctjTx($this->tt, 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ); }else{ $tp = ctjTx($this->tt, 'out'); }


		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfld_tt = %s WHERE applfmrowfld_enc = %s",
                             GtSQLVlStr($tp, "text"),
                             GtSQLVlStr($this->fld, "text"));
		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['err'] = $__cnx->c_p->error.' '.$updateSQL;


		return _jEnc($rsp);
    }


    public function ApplFmRow_ModCols($p=NULL){

		global $__cnx;

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW." SET applfmrow_cols = ".$p['col']." WHERE applfmrow_enc = %s",
                                 GtSQLVlStr($p['row'], "text"));

			$Result = $__cnx->_prc($updateSQL);

			$rsp['e'] = $Result;
			$rsp['error'] = $__cnx->c_p->error;

			$rtrn = _jEnc($rsp);
			return($rtrn);
    }
    public function ApplFmRowCol_Dt($p=NULL){

		global $__cnx;

			$query_DtRg = sprintf("SELECT COUNT(*) as _tot FROM "._BdStr(DBM).TB_APPL_FM_ROW_FLD." WHERE applfmrowfld_applfmrow = ( SELECT id_applfmrow FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE applfmrow_enc = %s )",
                                GtSQLVlStr($p['row'], "text"));

				$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$rsp['e'] = 'ok';
					$rsp['tot'] = $row_DtRg['_tot'];

				}

			}
			$__cnx->_clsr($DtRg);
			$rtrn = _jEnc($rsp);
			return($rtrn);
    }
    public function ApplFmRowFld_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->fm_id.'-'.$this->dt);
		$_ord = $this->ApplFmRow_Dt([ 'enc' => $this->fm_id]);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_APPL_FM_ROW_FLD." (
							applfmrowfld_enc, applfmrowfld_applfmrow, applfmrowfld_fld) VALUES
							(%s, (SELECT id_applfmrow FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE applfmrow_enc = %s),
							(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p['row'], "text"),
							GtSQLVlStr($p['enc'], "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['error'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}
    public function ApplFmRow_Mod($p=NULL){

		global $__cnx;

			if($p['tp']=='ord_null'){
				$ord = 'NULL';
			}else{
				$ord = $p['ord'];
				$fl .= sprintf('AND applfmrow_enc = %s',GtSQLVlStr($p['row'], "text"));
			}

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW." SET applfmrow_ord = $ord
							WHERE applfmrow_applfm = (SELECT id_applfm FROM "._BdStr(DBM).TB_APPL_FM." WHERE applfm_enc = %s) $fl",
                                 GtSQLVlStr($p['enc'], "text"));

			$Result = $__cnx->_prc($updateSQL);

			$rsp['e'] = $Result;

			$rsp['error'] = $__cnx->c_p->error;

			$rtrn = _jEnc($rsp);
			return($rtrn);
    }
    public function ApplFmRowFld_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_APPL_FM_ROW_FLD." WHERE applfmrowfld_enc = %s",
							GtSQLVlStr($p['enc'], "text"));
		$Result = $__cnx->_prc($query_DtRg);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function ApplFmRow_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_APPL_FM_ROW." WHERE applfmrow_enc = %s",
							GtSQLVlStr($p['enc'], "text"));
		$Result = $__cnx->_prc($query_DtRg);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function ApplFmRqd_Upd($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfld_rqd = ".$this->id_rqd."
							WHERE applfmrowfld_enc = %s",
                                 GtSQLVlStr($this->id_fld, "text"));
		$Result = $__cnx->_prc($updateSQL);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function ApplFmExc_Upd($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfld_fltexc = '".$this->val_inpt."' WHERE applfmrowfld_enc = %s",
                                 GtSQLVlStr($this->id_fld, "text"));
		$Result = $__cnx->_prc($updateSQL);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function ApplFmTp_Upd($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfld_flttp = '".$this->val_inpt."' WHERE applfmrowfld_enc = %s",
                                 GtSQLVlStr($this->id_fld, "text"));
		$Result = $__cnx->_prc($updateSQL);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	public function ApplFmval_Upd($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM_ROW_FLD." SET applfmrowfls_vladc = '".$this->val_inpt."' WHERE applfmrowfld_enc = %s",
                                 GtSQLVlStr($this->id_fld, "text"));
		$Result = $__cnx->_prc($updateSQL);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['w_nd'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}
	// --- Contrato --- //
	public function CntrcSht_Ls($p=NULL){

	    global $__cnx;

		$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_CNTRC_SHT." WHERE cntrcsht_cntrc = %s ORDER BY cntrcsht_ord ASC", GtSQLVlStr($this->cntrc, "text"), GtSQLVlStr($this->cntrc, "text"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['cntrcsht_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['ord'] = $row_DtRg['cntrcsht_ord'];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function CntrcFrst_Ls($p=NULL){

		global $__cnx;
		$query_DtRg = sprintf("
									SELECT
										*
									FROM
										"._BdStr(DBM).TB_CNTRC_SHT."
									WHERE
										cntrcsht_cntrc = %s
									AND cntrcsht_ord = 1
								", GtSQLVlStr($this->cntrc, "text"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['cntrcsht_enc'];
					$Vl['enc'] = $id_ob;
					$Vl['ord'] = $row_DtRg['cntrcsht_ord'];
					$Vl['html'] = ctjTx($row_DtRg['cntrcsht_html'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function CntrcSht_Html($p=NULL){

	    global $__cnx;
		$query_DtRg = sprintf("SELECT *,( SELECT COUNT(*) FROM "._BdStr(DBM).TB_CNTRC_SHT." WHERE cntrcsht_cntrc = %s ) as __tot FROM "._BdStr(DBM).TB_CNTRC_SHT." WHERE cntrcsht_enc = %s ",

									GtSQLVlStr($this->cntrc, "text"),
									GtSQLVlStr($this->cntrc_sht, "text"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['cntrcsht_enc'];
					$Vl['enc'] = $id_ob;

					if(isN($p)){
						$Vl['html'] = ctjTx($row_DtRg['cntrcsht_html'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
					}

					$Vl['ord'] = $row_DtRg['cntrcsht_ord'];
					$Vl['_tot'] = $row_DtRg['__tot'];


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function CntrcSht_Upd($p=NULL){

        	global $__cnx;

        	$_vle = ctjTx($this->sgm_vle, 'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CNTRC_SHT." SET cntrcsht_html = %s WHERE cntrcsht_enc = %s AND cntrcsht_cntrc = %s",
							GtSQLVlStr($_vle, "text"),
							GtSQLVlStr($this->cntrc_sht, "text"),
							GtSQLVlStr($this->cntrc, "int"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				/*$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;*/
				$rsp['error'] = $updateSQL;
			}

			//$__cnx->_clsr($Result);

			$rtrn = _jEnc($rsp);
			return($rtrn);
    }

	public function CntrcSht_New($p=NULL){

        global $__cnx;

        $__enc = Enc_Rnd($this->cntrc);

		$updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CNTRC_SHT." (cntrcsht_enc, cntrcsht_cntrc, cntrcsht_ord) VALUES (%s,  %s,  (SELECT c.cntrcsht_ord + 1 FROM "._BdStr(DBM).TB_CNTRC_SHT." AS c WHERE c.cntrcsht_cntrc = %s ORDER by c.cntrcsht_ord DESC limit 1))",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->cntrc, "int"),
						GtSQLVlStr($this->cntrc, "int"));
		$Result = $__cnx->_prc($updateSQL);


		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['enc'] = $__enc;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['error'] = $updateSQL;
		}

		$__cnx->_clsr($Result);
		return _jEnc($rsp);

    }

	public function CntrcSht_Eli($p=NULL){

		global $__cnx;
		$ShtDt = $this->CntrcSht_Html(['dt'=>'ok']);

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CNTRC_SHT." WHERE cntrcsht_cntrc = %s AND cntrcsht_enc = %s",
							GtSQLVlStr($this->cntrc, "text"),
							GtSQLVlStr($this->cntrc_sht, "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$Vl['e'] = 'ok';

			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_CNTRC_SHT." WHERE cntrcsht_cntrc = %s AND cntrcsht_ord > %s ",
							GtSQLVlStr($this->cntrc, "int"),
							GtSQLVlStr($ShtDt->ord, "int"));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$id_ob = $row_DtRg['cntrcsht_enc'];
						$Vl['ls'][$id_ob]['enc'] = $id_ob;
						$Vl['ls'][$id_ob]['ord'] = $row_DtRg['cntrcsht_ord'];

						$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CNTRC_SHT." SET cntrcsht_ord = %s WHERE cntrcsht_enc = %s",
							GtSQLVlStr(($row_DtRg['cntrcsht_ord'] - 1), "int"),
							GtSQLVlStr($row_DtRg['cntrcsht_enc'], "text"));

						$Result = $__cnx->_prc($updateSQL);

						if($Result){
							$rsp['e'] = 'ok';
							$rsp['m'] = 1;
						}else{
							$rsp['e'] = 'no';
							$rsp['m'] = 2;
							$rsp['w'] = $__cnx->c_p->error;
							$rsp['w_n'] = $__cnx->c_p->errno;
						}
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}

			$__cnx->_clsr($DtRg);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($Vl);
    }

	public function CntrcSht_Ord($p=NULL){

		global $__cnx;

		$i = 1;

		foreach($this->ord as $k){

			$updateSQL = "UPDATE "._BdStr(DBM).TB_CNTRC_SHT." SET cntrcsht_ord = ".$i++." WHERE cntrcsht_enc = '".$k."'";
			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}

		}

		return _jEnc($Vl);

	}
	// --- Contrato --- //
	public function CntPrntEst_Chk($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_CNT_PRNT_EST."
						WHERE cntprntest_cntprnt = (SELECT id_cntprnt FROM "._BdStr(DBM).TB_CNT_PRNT." WHERE cntprnt_enc = '".$this->id_prnt."')";
		$DtRg = $__cnx->_qry($query_DtRg);
		$Vl['e'] =  $query_DtRg;
		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['cntprntest_enc'];
					$Vl['ls'][$id_ob]['enc'] = $row_DtRg['cntprntest_enc'];
					$Vl['ls'][$id_ob]['cnt_prnt'] = $row_DtRg['cntprntest_cntprnt'];
					$Vl['ls'][$id_ob]['est'] = $row_DtRg['cntprntest_est'];
					$Vl['ls'][$id_ob]['fi'] = $row_DtRg['cntprntest_fi'];
					$Vl['ls'][$id_ob]['fa'] = $row_DtRg['cntprntest_fa'];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}

	public function CntPrntEst_In($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
		$__enc = Enc_Rnd($this->id_prnt.'-'.$this->dt);

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_CNT_PRNT_EST." (
							cntprntest_enc, cntprntest_cntprnt, cntprntest_est) VALUES
							(%s, (SELECT id_cntprnt FROM "._BdStr(DBM).TB_CNT_PRNT." WHERE cntprnt_enc = '".$this->id_prnt."'), 1) ",
							GtSQLVlStr($__enc, "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['est'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['error'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}

	public function CntPrntEst_Upd($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CNT_PRNT_EST." SET cntprntest_est = %s WHERE
			cntprntest_cntprnt = (SELECT id_cntprnt FROM "._BdStr(DBM).TB_CNT_PRNT." WHERE cntprnt_enc = '".$this->id_prnt."')",
                                GtSQLVlStr($this->id_est, "int"));

		$Result = $__cnx->_prc($updateSQL);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['est'] = $this->id_est;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}

		return _jEnc($rsp);
	}

	// --- Lista de Contrato por aplicacion  --- //
    public function CntApplCntrc_Ls($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					* ,
					(
						SELECT
							COUNT(*)
						FROM
							".TB_CNTRC_APPL."
						INNER JOIN ".TB_CNT_APPL." ON id_cntappl = cntrcappl_cntappl
						WHERE cntappl_enc = '".$this->cntappl."'
						AND id_cntrc = cntrcappl_cntrc
						AND cntrcappl_est = 1

					) AS __tot
				FROM
					"._BdStr(DBM).TB_CNTRC."
				INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = cntrc_cl
				WHERE
					cl_enc = '".CL_ENC."' ";

		$DtRg = $__cnx->_qry($query_DtRg);

		$Vl['ed'] = $query_DtRg;

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_o = $row_DtRg['cntrc_enc'];

					$Vl['ls'][$id_o]['enc'] = $id_o;
					$Vl['ls'][$id_o]['nm'] = ctjTx($row_DtRg['cntrc_nm'],'in');
					$Vl['ls'][$id_o]['tot'] = ctjTx($row_DtRg['__tot'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }



	public function CntApplCntrc_In($p=NULL){

		global $__cnx;

		if(	!isN($this->cntappl) && !isN($this->cntrc)){

			$_cl = $this->GtCl();

			$query_DtRg = sprintf("SELECT * FROM ".TB_CNTRC_APPL." WHERE cntrcappl_cntrc = (SELECT id_cntrc FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc = %s) AND cntrcappl_cntappl = (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s)",
										GtSQLVlStr($this->cntrc, "text"),
										GtSQLVlStr($this->cntappl, "text"));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if( $Tot_DtRg > 0 ){

					$query_DtRg = sprintf("UPDATE ".TB_CNTRC_APPL." SET cntrcappl_est = 1 WHERE cntrcappl_cntrc = (SELECT id_cntrc FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc = %s) AND cntrcappl_cntappl = (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s)",
										GtSQLVlStr($this->cntrc, "text"),
										GtSQLVlStr($this->cntappl, "text"));

				}else{
					$__enc = Enc_Rnd($this->cntappl.'-'.$this->cntrc);

					$query_DtRg = sprintf("INSERT INTO ".TB_CNTRC_APPL." (cntrcappl_enc, cntrcappl_cntrc, cntrcappl_cntappl)
										VALUES (%s,
										(SELECT id_cntrc FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc = %s),
										(SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s))",
							   GtSQLVlStr($__enc, "text"),
							   GtSQLVlStr($this->cntrc, "text"),
			                   GtSQLVlStr($this->cntappl, "text"));

				}

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$rsp['i'] = $__cnx->c_p->insert_id;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}
			$__cnx->_clsr($DtRg);

		}



		return _jEnc($rsp);

	}

	public function CntApplCntrc_Chk($p=NULL){

   		global $__cnx;

   		$Vl['e'] = 'no';
   		$_cl = $this->GtCl();
		$query_DtRg = sprintf("SELECT * FROM ".TB_CNTRC_APPL." WHERE cntrcappl_cntrc = (SELECT id_cntrc FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc = %s) AND cntrcappl_cntappl = (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s)",
									GtSQLVlStr($this->cntrc, "text"),
									GtSQLVlStr($this->cntappl, "text"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function CntApplCntrc_Del($p=NULL){

		global $__cnx;

		if(	!isN($this->cntappl) && !isN($this->cntrc)){

			$_cl = $this->GtCl();

			$query_DtRg = sprintf("UPDATE ".TB_CNTRC_APPL." SET cntrcappl_est = 2 WHERE cntrcappl_cntrc = (SELECT id_cntrc FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc = %s) AND cntrcappl_cntappl = (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s)",
									GtSQLVlStr($this->cntrc, "text"),
									GtSQLVlStr($this->cntappl, "text"));

			$Result = $__cnx->_prc($query_DtRg);

		}

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

	public function CntApplCntrc_Dt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = "
				SELECT
					*
				FROM
					".TB_CNTRC_APPL."
				WHERE
					cntrcappl_cntappl = (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = '".$this->cntappl."') AND
					cntrcappl_cntrc = (SELECT id_cntrc FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc = '".$this->cntrc."')
				";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$id_o = $row_DtRg['cntrcappl_enc'];
				$Vl['enc'] = $id_o;

			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function MdlSTpFmRowFld_Mod($p=NULL){

		global $__cnx;

		if($p['ord'] == 'NULL'){ $ord = 'NULL'; $tx = 'text'; }else{ $ord = $p['ord'];  $tx = 'int'; }
		if(!isN($p['old'])){ $row = $p['old']; }else{ $row = $p['row'];  }

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." SET mdlstpfmrowfld_ord = %s,
		mdlstpfmrowfld_mdlstpfmrow = (SELECT id_mdlstpfmrow FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE mdlstpfmrow_enc = %s) WHERE mdlstpfmrowfld_fld = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) AND mdlstpfmrowfld_mdlstpfmrow =( SELECT id_mdlstpfmrow FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE mdlstpfmrow_enc = %s )",
                             GtSQLVlStr($p['ord'], $tx),
                             GtSQLVlStr($p['row'], "text"),
                             GtSQLVlStr($p['enc'], "text"),
                             GtSQLVlStr($row, "text"));
		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['err'] = $__cnx->c_p->error;

		$rtrn = _jEnc($rsp);
		return($rtrn);
    }


    public function MdlSTpFmRowFldOrd_Mod($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." SET mdlstpfmrowfld_ord = NULL WHERE
		mdlstpfmrowfld_mdlstpfmrow =( SELECT id_mdlstpfmrow FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE mdlstpfmrow_enc = %s )",
                            GtSQLVlStr($p['row'], "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['err'] = $__cnx->c_p->error;

		$rtrn = _jEnc($rsp);
		return($rtrn);
    }


    public function MdlSTpFmRowCol_Dt($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("SELECT COUNT(*) as _tot FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." WHERE mdlstpfmrowfld_mdlstpfmrow = ( SELECT id_mdlstpfmrow FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE mdlstpfmrow_enc = %s )",
                            GtSQLVlStr($p['row'], "text"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$rsp['e'] = 'ok';
				$rsp['tot'] = $row_DtRg['_tot'];

			}

		}

		$__cnx->_clsr($DtRg);
		$rtrn = _jEnc($rsp);
		return($rtrn);
    }

    public function MdlSTpFmRowFld_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->fm_id.'-'.$this->dt);
		$_ord = $this->MdlSTpFmRow_Dt([ 'enc' => $this->fm_id]);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." (
							mdlstpfmrowfld_enc, mdlstpfmrowfld_mdlstpfmrow, mdlstpfmrowfld_fld) VALUES
							(%s, (SELECT id_mdlstpfmrow FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." WHERE mdlstpfmrow_enc = %s),
							(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p['row'], "text"),
							GtSQLVlStr($p['enc'], "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
			$rsp['error'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}

    public function MdlSTpFmRow_Mod($p=NULL){

		global $__cnx;

		if($p['tp']=='ord_null'){
			$ord = 'NULL';
		}else{
			$ord = $p['ord'];
			$fl .= sprintf('AND mdlstpfmrow_enc = %s',GtSQLVlStr($p['row'], "text"));
		}

		$updateSQL = sprintf("UPDATE  "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." SET mdlstpfmrow_ord = $ord
						WHERE mdlstpfmrow_mdlstpfm = (SELECT id_mdlstpfm FROM  "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s) $fl",
                             GtSQLVlStr($p['enc'], "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;

		$rsp['error'] = $__cnx->c_p->error;

		$rtrn = _jEnc($rsp);
		return($rtrn);
    }

    public function MdlSTpFmRow_ModCols($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE  "._BdStr(DBM).TB_MDL_S_TP_FM_ROW." SET mdlstpfmrow_cols = ".$p['col']." WHERE mdlstpfmrow_enc = %s",
                             GtSQLVlStr($p['row'], "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;

		$rtrn = _jEnc($rsp);
		return($rtrn);
    }


    public function ClRow_Ls($p=NULL){

        global $__cnx;

        if($p['ult']=='ok'){
	    	$_fl = 'ORDER BY clrow_ord DESC LIMIT 1';
        }else{
	   		$_fl = 'ORDER BY clrow_ord ASC';
        }

	    $_cl = $this->GtCl();

		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_CL_ROW." WHERE id_clrow != '' AND clrow_id = (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = '".$this->mdlstp."') AND clrow_cl = '".$_cl->id."' $_fl";
		$DtRg = $__cnx->_qry($query_DtRg);
		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
			$Vl['tots'] = $query_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['clrow_enc'];
					$Vl['ls'][$id_ob]['enc'] = $row_DtRg['clrow_enc'];
					$Vl['ls'][$id_ob]['tp'] = $row_DtRg['clrow_tp'];
					$Vl['ls'][$id_ob]['cols'] = $row_DtRg['clrow_cols'];
					$Vl['ls'][$id_ob]['ord'] = $row_DtRg['clrow_ord'];
					$Vl['ls'][$id_ob]['fld'] = $this->ClRowFld_Ls(['id'=>$row_DtRg['id_clrow'],'mdl'=>'']);
					$Vl['ord'] = $row_DtRg['clrow_ord'];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }


    public function ClRowFld_Ls($p=NULL){

		global $__cnx;

		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_CL_ROW_FLD." INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON clrowfld_fld = id_sisslc WHERE id_clrowfld != '' AND clrowfld_clrow = '".$p['id']."'
				ORDER BY clrowfld_ord ASC";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['sisslc_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['fld'] = $row_DtRg['clrowfld_fld'];
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'],'in');
					$Vl['ls'][$id_ob]['enc_fldrow'] = ctjTx($row_DtRg['clrowfld_enc'],'in');
					if(!isN($p['mdl'])){

						$Vl['ls'][$id_ob]['vl_mdl'] = $this->Mdl_Attr(['id'=>$row_DtRg['id_sisslc'], 'mdl'=>$p['mdl'] ]);

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);


		return _jEnc($Vl);
    }

	public function Mdl_Attr($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
		$query_DtRg = "SELECT * FROM ".TB_MDL_ATTR." WHERE mdlattr_mdl = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = '".$p['mdl']."') AND mdlattr_attr = '".$p['id']."' ";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['vl'] = ctjTx($row_DtRg['mdlattr_vl'],'in');
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

    public function ClRowAttr($p=NULL){

        global $__cnx;


        $_cl = $this->GtCl();

		$query_DtRg = "SELECT
							*
						FROM
							"._BdStr(DBM).TB_SIS_SLC."
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_MDLSTP." ON id_sisslc = sisslcmdlstp_sisslc
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = sisslcmdlstp_mdlstp
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC_CL." ON id_sisslc = sisslccl_sisslc
						WHERE
							id_sisslc NOT IN(
								SELECT
									clrowfld_fld
								FROM
									"._BdStr(DBM).TB_CL_ROW_FLD."
								INNER JOIN "._BdStr(DBM).TB_CL_ROW." ON id_clrow = clrowfld_clrow
								WHERE clrow_cl = '".$_cl->id."' AND clrow_id = (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = '".$this->mdlstp."')

							)
						AND sisslc_tp = 59 AND sisslccl_cl = '".$_cl->id."' AND sisslcmdlstp_mdlstp = (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = '".$this->mdlstp."')" ;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{
					$id_ob = $row_DtRg['sisslc_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['tt'] = ctjTx($row_DtRg['sisslc_tt'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }


    public function ClRow_Mod($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		if($p['tp']=='ord_null'){
			$ord = 'NULL';
		}else{
			$ord = $p['ord'];
			$fl .= sprintf('AND clrow_enc = %s',GtSQLVlStr($p['row'], "text"));
		}

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_ROW." SET clrow_ord = $ord
						WHERE clrow_cl = '".$_cl->id."' AND clrow_id = (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = '".$this->mdlstp."') $fl");

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;

		$rtrn = _jEnc($rsp);
		return($rtrn);

    }

    public function ClRowFld_Mod($p=NULL){

		global $__cnx;

		if($p['tp']=='ord_null'){
			$ord = 'NULL';
		}else{
			$ord = $p['ord'];
			$fl .= sprintf('AND clrowfld_fld = (SELECT id_sisslc FROM '.DBM.'.'.TB_SIS_SLC.' WHERE sisslc_enc = %s)',GtSQLVlStr($p['row'], "text"));
		}

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_ROW_FLD." SET clrowfld_ord = $ord
						WHERE clrowfld_clrow = (SELECT id_clrow FROM "._BdStr(DBM).TB_CL_ROW." WHERE clrow_enc = %s) $fl",GtSQLVlStr($p['enc'], "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;
		$rsp['w'] = $updateSQL;

		$rtrn = _jEnc($rsp);
		return($rtrn);

    }

    public function ClRowFld_ModOth($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_ROW_FLD." SET clrowfld_clrow = (SELECT id_clrow FROM "._BdStr(DBM).TB_CL_ROW." WHERE clrow_enc = %s)
						WHERE clrowfld_clrow = (SELECT id_clrow FROM "._BdStr(DBM).TB_CL_ROW." WHERE clrow_enc = %s) AND clrowfld_enc = %s ",
						GtSQLVlStr($p['_id_row'], "text"),
						GtSQLVlStr($p['old'], "text"),
						GtSQLVlStr($p['_id'], "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;
		$rsp['w'] = $updateSQL;

		$rtrn = _jEnc($rsp);
		return($rtrn);

    }

    public function ClRowCol_Mod($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_ROW." SET clrow_cols = %s
						WHERE clrow_enc = %s ",
						GtSQLVlStr($p['cols'], "text"),
						GtSQLVlStr($p['enc'], "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;
		$rsp['w'] = $updateSQL;

		$rtrn = _jEnc($rsp);
		return($rtrn);

    }

    public function ClRow_In($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
		$ult = $this->ClRow_Ls([ 'ult'=>'ok' ]);

		$__enc = Enc_Rnd($p['id'].'-'.$_cl->sbd);

		$updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_ROW." (clrow_enc, clrow_cl, clrow_tp, clrow_id, clrow_cols, clrow_ord) VALUES( %s,%s,%s,%s,%s,%s )",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($_cl->id, "text"),
						GtSQLVlStr('mdl_s_tp', "text"),
						GtSQLVlStr($p['id'], "text"),
						GtSQLVlStr(1, "text"),
						GtSQLVlStr(($ult->ord)+1, "int"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;

		$rtrn = _jEnc($rsp);
		return($rtrn);

    }


    public function ClRowFld_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd('ClRowFld'.'-'.$_cl->sbd);

		$updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_ROW_FLD." (clrowfld_enc, clrowfld_clrow, clrowfld_fld) VALUES( %s,(SELECT id_clrow FROM "._BdStr(DBM).TB_CL_ROW." WHERE clrow_enc = %s),(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc =  %s))",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->clrow_enc, "text"),
						GtSQLVlStr($this->fld_enc, "text"));

		$Result = $__cnx->_prc($updateSQL);

		$rsp['e'] = $Result;
		$rsp['error'] = $__cnx->c_p->error;



		$rtrn = _jEnc($rsp);
		return($rtrn);

    }

    public function ClRow_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_ROW." WHERE clrow_enc = %s",
							GtSQLVlStr($this->enc_eli, "text"));

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

    public function ClRowFld_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_ROW_FLD." WHERE clrowfld_enc = %s",
							GtSQLVlStr($this->enc_eli, "text"));

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

	public function MdlGenRel_Ls($p=NULL){


		$Vl['$p'] = $p['dt']->tp->act->ls;

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

	    if(!isN($this->mdlgen_id)){ $__f_gen = " AND mdlgenrel_mdlgen = '".$this->mdlgen_id."' "; }

	    if(!isN($p['dt']->tp->act->ls->ids)){
			if(is_array($p['dt']->tp->act->ls->ids)){
				$__f = sprintf(' AND mdls_tp IN(%s) ',  implode(',',$p['dt']->tp->act->ls->ids) );
			}else{
				$__f = sprintf(' AND mdls_tp = %s ', GtSQLVlStr($p['dt']->tp->act->ls->ids, "int"));
			}
	    }elseif(!isN($p['t'])){
		    $__f = sprintf(" AND mdlstp_tp = %s ", GtSQLVlStr($p['t'], "text"));
		}

		$query_DtRg = "
				SELECT *,

					(
						SELECT COUNT(*)
						FROM ".TB_MDL_GEN_REL."
							 INNER JOIN ".TB_MDL_GEN." ON mdlgenrel_mdlgen = id_mdlgen
						WHERE mdlgenrel_mdl = id_mdl {$__f_gen}
					) AS __tot_gen

				FROM ".TB_MDL."
					 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
				WHERE id_mdl != '' {$__f}
				ORDER BY __tot_gen DESC, mdl_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
			$Vl['qry'] = $query_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdl_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
					$Vl['ls'][$id_ob]['tot'] = $row_DtRg['__tot_gen'];

					if(!isN($row_DtRg['mdlstp_img'])){
	                		$Vl['ls'][$id_ob]['tp']['icn'] = DMN_FLE_MDL_TP.ctjTx($row_DtRg['mdlstp_img'],'in');
                  	}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }

	public function MdlGenRel_In($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$__enc = Enc_Rnd($this->mdl_id.'-'.$this->mdlgen_id);

		$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_GEN_REL." (mdlgenrel_enc, mdlgenrel_mdl, mdlgenrel_mdlgen) VALUES (%s, (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s), %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdl_id, "text"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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

	public function MdlGenRel_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM ".TB_MDL_GEN_REL." WHERE mdlgenrel_mdl=(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s) AND mdlgenrel_mdlgen=%s",
							GtSQLVlStr($this->mdl_id, "text"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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

	public function MdlGenTp_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->mdlgen_id)){ $__f_gen = " AND mdlgentp_mdlgen = '".$this->mdlgen_id."' "; }

		$query_DtRg = "
						SELECT
						*,(
							SELECT
								COUNT(*)
							FROM
								".TB_MDL_GEN_TP."
							INNER JOIN ".TB_MDL_GEN." ON mdlgentp_mdlgen = id_mdlgen
							WHERE
								mdlgentp_mdlstp = id_mdlstp $__f_gen
						) as __tot
					FROM
						"._BdStr(DBM).TB_MDL_S_TP."
					INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
					WHERE
						mdlstpcl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."' ) ORDER BY __tot DESC, mdlstp_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
			$Vl['qry'] = $query_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstp_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$Vl['ls'][$id_ob]['tot'] = $row_DtRg['__tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function MdlGenTp_In($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$__enc = Enc_Rnd($this->tp_id.'-'.$this->mdlgen_id);

		$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_GEN_TP." (mdlgentp_enc, mdlgentp_mdlstp, mdlgentp_mdlgen )
										VALUES (%s, (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s), %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($this->tp_id, "text"),
								GtSQLVlStr($this->mdlgen_id, "int"));

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

	public function MdlGenTp_Del($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM ".TB_MDL_GEN_TP." WHERE mdlgentp_mdlstp = (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s) AND mdlgentp_mdlgen=%s",
							GtSQLVlStr($this->tp_id, "text"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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

	public function ClMdl_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

	    if(!isN($this->mdlgen_id)){ $__f_gen = " AND mdlgenmdl_gen = '".$this->mdlgen_id."' "; }
	    if(!isN($p['t'])){ $__f = sprintf(" AND mdlstp_tp = %s ", GtSQLVlStr($p['t'], "text")); }

		$query_DtRg = "
				SELECT *,

					(
						SELECT COUNT(*)
						FROM ".TB_MDL_GEN_MDL."
							 INNER JOIN ".TB_MDL_GEN." ON mdlgenmdl_gen = id_mdlgen
						WHERE mdlgenmdl_mdl = id_mdl {$__f_gen}
					) AS __tot_gen

				FROM ".TB_MDL."
					 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
				WHERE id_mdl != '' {$__f}
				ORDER BY __tot_gen DESC, mdl_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdl_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
					$Vl['ls'][$id_ob]['tot']['gen'] = $row_DtRg['__tot_gen'];

					if(!isN($row_DtRg['mdlstp_img'])){
                		$Vl['ls'][$id_ob]['tp']['icn'] = DMN_FLE_MDL_TP.ctjTx($row_DtRg['mdlstp_img'],'in');
                  	}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
    }


    public function MdlGenFm_In($p=NULL){

		global $__cnx;


		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$__enc = Enc_Rnd($this->fm_id.'-'.$this->mdlgen_id);

		$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_GEN_FM." (mdlfmgen_enc, mdlfmgen_mdlstpfm, mdlfmgen_mdlgen) VALUES (%s, (SELECT id_mdlstpfm FROM  "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s), %s )",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlfm_id, "text"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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


	public function MdlGenFm_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM ".TB_MDL_GEN_FM." WHERE mdlfmgen_mdlstpfm=(SELECT id_mdlstpfm FROM  "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s) AND mdlfmgen_mdlgen=%s",
							GtSQLVlStr($this->mdlfm_id, "text"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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


	public function TpcCl_Ls($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = "
				SELECT * ,
						(SELECT cltag_vl FROM ".TB_CL_TAG." WHERE cltag_sistag = "._CId('ID_SISTAG_CLR_MAIN')." AND cltag_cl = id_cl ) AS _cl_clr,
						(
							SELECT
								COUNT(*)
							FROM
								".TB_TPC_CL."
							INNER JOIN ".TB_TPC." ON id_tpc = tpccl_tpc
							WHERE tpc_enc = '".$this->id_tpc."' AND id_cl = tpccl_cl
						) as tot
				FROM
					".TB_CL." ORDER BY tot DESC ";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{

					$Vl['ls'][$row_DtRg['cl_enc']]['enc'] = $row_DtRg['cl_enc'];
					$Vl['ls'][$row_DtRg['cl_enc']]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$Vl['ls'][$row_DtRg['cl_enc']]['img'] = _ImVrs(['img'=>$row_DtRg['cl_img'], 'f'=>DMN_FLE_CL]);
					$Vl['ls'][$row_DtRg['cl_enc']]['clr'] = $row_DtRg['_cl_clr'];
					$Vl['ls'][$row_DtRg['cl_enc']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }

	public function TpcCl_In($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$__enc = Enc_Rnd($this->id_cl.'-'.$this->id_tpc);

		$query_DtRg =   sprintf("INSERT INTO ".TB_TPC_CL." (tpccl_enc, tpccl_tpc, tpccl_cl) VALUES (%s, (SELECT id_tpc FROM ".TB_TPC." WHERE tpc_enc = %s), (SELECT id_cl FROM ".TB_CL." WHERE cl_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->id_tpc, "text"),
							GtSQLVlStr($this->id_cl, "text"));

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


	public function TpcCl_Del($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM ".TB_TPC_CL." WHERE tpccl_tpc=(SELECT id_tpc FROM ".TB_TPC." WHERE tpc_enc = %s) AND tpccl_cl=(SELECT id_cl FROM ".TB_CL." WHERE cl_enc = %s)",
							GtSQLVlStr($this->id_tpc, "text"),
							GtSQLVlStr($this->id_cl, "text"));

		$Result = $__cnx->_prc($query_DtRg);
		$rsp['sssm'] = $query_DtRg;
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

	public function ClMdlFmGen_Ls($p=NULL){

	    global $__cnx;

	 	$_cl = $this->GtCl();

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = "
				SELECT * ,
					(
						SELECT COUNT(*) FROM ".TB_MDL_GEN_FM." WHERE id_mdlstpfm = mdlfmgen_mdlstpfm AND mdlfmgen_mdlgen = ".$this->mdlgen_id."
					) as _est
				FROM
					 "._BdStr(DBM).TB_MDL_S_TP_FM."
				WHERE
					mdlstpfm_cl = ".$_cl->id;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
				do{

					$id_ob = $row_DtRg['mdlstpfm_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlstpfm_nm'],'in');
					$Vl['ls'][$id_ob]['est'] = $row_DtRg['_est'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

    }

	public function MdlFm_Ls($p=NULL){

	    global $__cnx;

	 	$_cl = $this->GtCl();

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = "
				SELECT * ,
					(
						SELECT COUNT(*) FROM ".TB_MDL_FM." WHERE id_mdlstpfm = mdlfm_mdlstpfm AND mdlfm_mdl = ".$p['mdl']."
					) as _est
				FROM
					"._BdStr(DBM).TB_MDL_S_TP_FM."
				WHERE
					mdlstpfm_cl = ".$_cl->id;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstpfm_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlstpfm_nm'],'in');
					$Vl['ls'][$id_ob]['est'] = $row_DtRg['_est'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}


		return _jEnc($Vl);
    }


    /* - - - - Formulario Modulo - - - - */

    public function ClMdlSTpEst_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

	    if(!isN($p['mdlstp'])){ $__f = sprintf(" AND mdlstpest_mdlstp = %s ", GtSQLVlStr($p['mdlstp'], "int")); }

		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_MDL_S_TP_EST."
					 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlstpest_cntest = id_siscntest
				WHERE id_mdlstpest != '' {$__f}
				ORDER BY siscntest_tt ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstpest_enc'];

					$Vl['ls'][$id_ob]['id'] = ctjTx($row_DtRg['id_siscntest'],'in');
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['siscntest_tt'],'in');
					$Vl['ls'][$id_ob]['clr'] = ctjTx($row_DtRg['siscntest_clr_bck'],'in');
					$Vl['ls'][$id_ob]['noi'] = mBln($row_DtRg['siscntest_noi']);

					$Vl['ls'][$id_ob]['mdlstp']['id'] = ctjTx($row_DtRg['mdlstpest_mdlstp'],'in');
					$Vl['ls'][$id_ob]['mdlstp']['est'] = mBln($row_DtRg['mdlstpest_est']);
					$Vl['ls'][$id_ob]['mdlstp']['dfl'] = mBln($row_DtRg['mdlstpest_dfl']);



				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return( _jEnc($Vl) );
    }


    public function ClMdlSTp_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

	    if(!isN($p['cl'])){ $__f .= sprintf(" AND mdlstpcl_cl = %s ", GtSQLVlStr($p['cl'], "int")); }
	    if(!isN($p['sis'])){ $__f .= sprintf(" AND mdlstp_sis = %s ", GtSQLVlStr($p['sis'], "int")); }

		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_MDL_S_TP_CL."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlstpcl_mdlstp = id_mdlstp
				WHERE id_mdlstp != '' {$__f}
				ORDER BY mdlstp_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlstp_enc'];

					$Vl['ls'][$id_ob]['id'] = ctjTx($row_DtRg['id_mdlstp'],'in');
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$Vl['ls'][$id_ob]['tp'] = ctjTx($row_DtRg['mdlstp_tp'],'in');
					$Vl['ls'][$id_ob]['cntest'] = $this->ClMdlSTpEst_Ls([ 'mdlstp'=>$row_DtRg['id_mdlstp'] ]);

					if(!isN($row_DtRg['mdlstp_img'])){
                		$Vl['ls'][$id_ob]['icn'] = DMN_FLE_MDL_TP.ctjTx($row_DtRg['mdlstp_img'],'in');
                  	}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}
		$__cnx->_clsr($DtRg);
		return( _jEnc($Vl) );
    }



    public function MdlGenMdl_In($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$__enc = Enc_Rnd($this->mdl_id.'-'.$this->mdlgen_id);

		$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_GEN_MDL." (mdlgenmdl_enc, mdlgenmdl_mdl, mdlgenmdl_gen) VALUES (%s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdl_id, "int"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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

	public function MdlGenMdl_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();
	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM ".TB_MDL_GEN_MDL." WHERE mdlgenmdl_mdl=%s AND mdlgenmdl_gen=%s",
							GtSQLVlStr($this->mdl_id, "int"),
							GtSQLVlStr($this->mdlgen_id, "int"));

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

    public function ClGrpAre_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_CL_GRP_ARE."
		(clgrpare_clare, clgrpare_clgrp) VALUES
		(
			(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s),
			(SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s)
		)",
					GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

    public function ClGrpAre_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_GRP_ARE." WHERE

		clgrpare_clare IN (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s) AND
		clgrpare_clgrp IN (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s)",

							GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

    public function SisCntEstAre_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CNT_EST_ARE." (siscntestare_are, siscntestare_est) VALUES
								(
									(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s LIMIT 1),
									(SELECT id_siscntest FROM "._BdStr(DBM).TB_SIS_CNT_EST." WHERE siscntest_enc = %s LIMIT 1)
								)",
					GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->est_id,'out'), "text"));

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

    public function SisCntEstAre_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."  WHERE

		siscntestare_are IN (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s) AND
		siscntestare_est IN (SELECT id_siscntest FROM "._BdStr(DBM).TB_SIS_CNT_EST." WHERE siscntest_enc = %s)",

							GtSQLVlStr(ctjTx($this->are_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->est_id,'out'), "text"));

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

    public function ClGrpMdl_In($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		$query_DtRg =   sprintf("INSERT INTO ".TB_CLGRP_MDL."
		(mdlgrp_mdl, mdlgrp_clgrp) VALUES
		(
			(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s),
			(SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s)
		)",
					GtSQLVlStr(ctjTx($this->mdl_id,'out'), "text"),
					GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

    public function ClGrpMdl_Del($p=NULL){

		global $__cnx;
		$_cl = $this->GtCl();
		$query_DtRg = sprintf("DELETE FROM ".TB_CLGRP_MDL." WHERE

		mdlgrp_mdl IN (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s) AND
		mdlgrp_clgrp IN (SELECT id_clgrp FROM ".TB_CL_GRP." WHERE clgrp_enc = %s)",

							GtSQLVlStr(ctjTx($this->mdl_id,'out'), "text"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

	public function UsGrp_In($p=NULL){

		global $__cnx;

		$__dtus = GtUsDt($this->us_id, 'enc', ['cnx'=>$__cnx->c_r] );

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_CL_GRP_US." (clgrpus_us, clgrpus_clgrp) VALUES ( %s, (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s) )",
					GtSQLVlStr($__dtus->id, "int"),
					GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
			_ErrSis(['p'=>$query_DtRg, 'd'=>$__cnx->c_p->error]);
		}

		return _jEnc($rsp);

	}

	public function UsGrp_Del($p=NULL){

		global $__cnx;

		$__dtus = GtUsDt($this->us_id, 'enc', ['cnx'=>$__cnx->c_r] );

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_GRP_US." WHERE clgrpus_us=%s AND clgrpus_clgrp IN (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s)",
							GtSQLVlStr($__dtus->id, "int"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

	public function CntAnx($p=NULL){

		global $__cnx;

		$__dtcl = GtClDt($this->cl, 'enc');

		$Vl['e'] = 'no';

		$query_DtRg = "SELECT
							*,(
								SELECT
									COUNT(*)
								FROM
									".$__dtcl->bd.".".TB_CNT_APPL_ANX."
								INNER JOIN ".$__dtcl->bd.".".TB_CNT_APPL." ON id_cntappl = cntapplanx_cntappl
								WHERE
									id_sisslc = cntapplanx_attr
								AND cntappl_enc = '".$this->cntappl."'
							) as _est
						FROM
							"._BdStr(DBM).TB_SIS_SLC."
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON id_sisslctp = sisslc_tp
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP_F." ON id_sisslctp = sisslctpf_tp
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC_F." ON id_sisslctpf = sisslcf_f
						WHERE
							id_sisslc = sisslcf_slc AND sisslc_tp = (SELECT id_sisslctp FROM "._BdStr(DBM).TB_SIS_SLC_TP." WHERE sisslctp_key = 'ls_anx')";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;
			$Vl['dtot'] = $query_DtRg;
			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_o = $row_DtRg['sisslc_enc'];
					$Vl['ls'][$id_o]['enc'] = $id_o;
					$Vl['ls'][$id_o]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
					$Vl['ls'][$id_o]['est'] = ctjTx($row_DtRg['_est'],'in');
					$Vl['ls'][$id_o]['vl'] = ctjTx($row_DtRg['sisslcf_vl'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}
		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}

	public function UsCl_In($p=NULL){

		global $__cnx;

		$__dtus = GtClDt($this->us_id, 'enc');

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_US_CL." (uscl_cl, uscl_us) VALUES ( %s, (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) )",
					GtSQLVlStr($__dtus->id, "int"),
					GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

	public function UsCl_Del($p=NULL){

		global $__cnx;

		$__dtus = GtClDt($this->us_id, 'enc');

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_US_CL." WHERE uscl_cl=%s AND uscl_us IN (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s)",
							GtSQLVlStr($__dtus->id, "int"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

	public function UsPrm_In($p=NULL){

		global $__cnx;

		$__dtprm = GtMdlSTpPrmDt([ 'id'=>$this->prm_id, 't'=>'enc' ]);

		if(!isN($__dtprm->id)){
			$__enc = Enc_Rnd($__dtprm->id.' - '.$this->grp_id);
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_US_PRM." (usprm_enc, usprm_cl, usprm_prm, usprm_us) VALUES ( %s, %s, %s, (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) )",
							GtSQLVlStr(ctjTx($__enc,'out'), "text"),
							GtSQLVlStr(DB_CL_ID, "int"),
							GtSQLVlStr($__dtprm->id, "int"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <--> '.$query_DtRg;

			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function UsPrm_Del($p=NULL){

		global $__cnx;

		$__dtprm = GtMdlSTpPrmDt([ 'id'=>$this->prm_id, 't'=>'enc' ]);

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_US_PRM." WHERE usprm_prm=%s AND usprm_us IN (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s)",
							GtSQLVlStr($__dtprm->id, "int"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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

	public function UsAre_In($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_US_ARE." (usare_us, usare_clare) VALUES (
								(SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s),
								(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s))",

						GtSQLVlStr(ctjTx($this->__us,'out'), "text"),
						GtSQLVlStr(ctjTx($this->__are,'out'), "text"));

		//$rsp['q'] =	$query_DtRg;

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <--> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}

	public function UsAre_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_US_ARE." WHERE
							usare_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) AND
							usare_clare = (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s)",

							GtSQLVlStr(ctjTx($this->__us,'out'), "text"),
						    GtSQLVlStr(ctjTx($this->__are,'out'), "text"));

		$rsp['are'] = $this->__are;
		$rsp['us'] = $this->__us;
		//$rsp['q'] =	$query_DtRg;

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


	public function GrpPrm_In($p=NULL){

		global $__cnx;

		$__dtprm = GtMdlSTpPrmDt([ 'id'=>$this->prm_id, 't'=>'enc' ]);

		if(!isN($__dtprm->id)){
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_GRP_PRM." (clgrpprm_enc, clgrpprm_prm, clgrpprm_clgrp) VALUES ( %s, %s, (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s) )",
							GtSQLVlStr(ctjTx(Enc_Rnd($this->prm_id.'-'.$this->grp_id),'out'), "text"),
							GtSQLVlStr($__dtprm->id, "int"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <--> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function GrpPrm_Del($p=NULL){

		global $__cnx;

		$__dtprm = GtMdlSTpPrmDt([ 'id'=>$this->prm_id, 't'=>'enc' ]);

		if(!isN($__dtprm->id)){

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_GRP_PRM." WHERE clgrpprm_prm = %s AND clgrpprm_clgrp = (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s)",
								GtSQLVlStr($__dtprm->id, "text"),
								GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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
		}

		return _jEnc($rsp);

	}

	public function GrpEst_In($p=NULL){

		global $__cnx;

		$__dtest = GtCntEstDt([ 'id'=>$this->est_id, 't'=>'enc' ]);

		if(!isN($__dtest->id)){
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_GRP_EST." (clgrpest_enc, clgrpest_est, clgrpest_clgrp) VALUES ( %s, %s, %s )",
							GtSQLVlStr(ctjTx(Enc_Rnd($this->est_id.'-'.$this->grp_id),'out'), "text"),
							GtSQLVlStr($__dtest->id, "int"),
							GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_r->errno;
		}

		return _jEnc($rsp);

	}

	public function GrpEst_Del($p=NULL){

		global $__cnx;

		$__dtest = GtCntEstDt([ 'id'=>$this->est_id, 't'=>'enc' ]);

		if(!isN($__dtest->id)){

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_GRP_EST." WHERE clgrpest_est=%s AND clgrpest_clgrp=%s",
								GtSQLVlStr($__dtest->id, "text"),
								GtSQLVlStr(ctjTx($this->grp_id,'out'), "text"));

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
		}

		return _jEnc($rsp);

	}

	public function MdlSTpPrm_In($p=NULL){

		global $__cnx;

		if(	!isN($this->mdlstpprm_nm) &&
			!isN($this->mdlstpprm_vl) &&
			!isN($this->mdlstpprm_tp) &&
			!isN($this->mdlstpprm_mdlstp)){

			$__enc = Enc_Rnd($this->mdlstpprm_vl);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_PRM." (mdlstpprm_enc, mdlstpprm_nm, mdlstpprm_vl, mdlstpprm_tp, mdlstpprm_mdlstp) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($this->mdlstpprm_nm,'out'), "text"),
				   GtSQLVlStr(ctjTx($this->mdlstpprm_vl,'out'), "text"),
				   GtSQLVlStr($this->mdlstpprm_tp, "int"),
				   GtSQLVlStr($this->mdlstpprm_mdlstp, "int"));

			$Result = $__cnx->_prc($insertSQL);

		}else{

			$rsp['w2'] = 'No data';

		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $__cnx->c_p->insert_id;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}



	public function MdlSTpCl_In($p=NULL){

		global $__cnx;

		if(	!isN($this->mdlstpcl_mdlstp) &&
			!isN($this->mdlstpcl_cl) ){

			$__enc = Enc_Rnd($this->mdlstpcl_mdlstp.'-'.$this->mdlstpcl_cl);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_CL." (mdlstpcl_enc, mdlstpcl_mdlstp, mdlstpcl_cl) VALUES (%s, %s, %s)",
						   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr($this->mdlstpcl_mdlstp, "int"),
		                   GtSQLVlStr($this->mdlstpcl_cl, "int"));

			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $__cnx->c_p->insert_id;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function MdlSTpCl_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_CL." WHERE mdlstpcl_mdlstp=%s AND mdlstpcl_cl=%s",
							GtSQLVlStr($this->mdlstpcl_mdlstp, "int"),
							GtSQLVlStr($this->mdlstpcl_cl, "int"));

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



	public function ClCntEst_In($p=NULL){

		global $__cnx;

		if(	!isN($this->cntest_tt) &&
			!isN($this->cntest_clr_bck) &&
			!isN($this->cntest_tp)){

			$_cl = $this->GtCl();
			$__enc = Enc_Rnd( $_cl->id.'-'.$this->cntest_tt.'-'.$this->cntest_tp );

			if(!isN($this->cntest_usnvl)){ $_nvl = $this->cntest_usnvl; }else{ $_nvl=3;}

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CNT_EST." (siscntest_enc, siscntest_cl, siscntest_tt, siscntest_clr_bck, siscntest_clr_fnt, siscntest_noi, siscntest_dsc, siscntest_tp, siscntest_usnvl, siscntest_asis, siscntest_tra_archv, siscntest_tra_cncl, siscntest_tra_cmpl, siscntest_tra_eli, siscntest_tra_prc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_cl->id, "int"),
                   GtSQLVlStr(ctjTx($this->cntest_tt,'out'), "text"),
				   GtSQLVlStr(ctjTx($this->cntest_clr_bck,'out'), "text"),
				   GtSQLVlStr(ctjTx($this->cntest_clr_fnt,'out'), "text"),
				   GtSQLVlStr($this->cntest_noi, "int"),
				   GtSQLVlStr(ctjTx($this->cntest_dsc,'out'), "text"),
				   GtSQLVlStr(ctjTx($this->cntest_tp,'out'), "int"),
				   GtSQLVlStr($_nvl, "int"),
				   GtSQLVlStr(Html_chck_vl($this->cntest_asis), "int"),
				   GtSQLVlStr(Html_chck_vl($this->cntest_tra_archv), "int"),
				   GtSQLVlStr(Html_chck_vl($this->cntest_tra_cncl), "int"),
				   GtSQLVlStr(Html_chck_vl($this->cntest_tra_cmpl), "int"),
				   GtSQLVlStr(Html_chck_vl($this->cntest_tra_eli), "int"),
				   GtSQLVlStr(Html_chck_vl($this->cntest_tra_prc), "int")
				);


			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $this->c_p->$__enc;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}



	public function MdlSTpAttr_In($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$_cl = $this->GtCl();
		$__enc = Enc_Rnd( $_cl->id.'-'.$this->mdlstp_id.'-'.$this->mdlstpattr_attr );

		$query_DtRg = sprintf("INSERT INTO ".TB_MDL_S_TP_ATTR." (mdlstpattr_enc, mdlstpattr_cl, mdlstpattr_mdlstp, mdlstpattr_attr) VALUES (%s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($_cl->id, "int"),
						GtSQLVlStr($this->mdlstp_id, "int"),
						GtSQLVlStr($this->mdlstpattr_attr, "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{

			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function MdlSTpAttr_Del($p=NULL){

		global $__cnx;

		$_cl = $this->GtCl();

		$query_DtRg = sprintf("DELETE FROM ".TB_MDL_S_TP_ATTR." WHERE mdlstpattr_cl=%s AND mdlstpattr_mdlstp=%s AND mdlstpattr_attr=%s",
							GtSQLVlStr($_cl->id, "int"),
							GtSQLVlStr($this->mdlstp_id, "int"),
							GtSQLVlStr($this->mdlstpattr_attr, "int"));

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

	public function SisSlcCl_In($p=NULL){

		global $__cnx;

		if(	!isN($this->sisslccl_sisslc) &&
			!isN($this->sisslccl_cl) ){

			$__enc = Enc_Rnd($this->mdlstpcl_mdlstp.'-'.$this->mdlstpcl_cl);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_SLC_CL." (sisslccl_enc, sisslccl_sisslc, sisslccl_cl) VALUES (%s, (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s), %s)",
						   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr($this->sisslccl_sisslc, "text"),
		                   GtSQLVlStr($this->sisslccl_cl, "int"));

			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $__cnx->c_p->insert_id;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;			}

		return _jEnc($rsp);

	}

	public function SisSlcCl_Del($p=NULL){

		global $__cnx;

		if(	!isN($this->sisslccl_sisslc) &&
			!isN($this->sisslccl_cl) ){

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_SIS_SLC_CL." WHERE sisslccl_sisslc=(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s) AND sisslccl_cl=%s",
								GtSQLVlStr($this->sisslccl_sisslc, "text"),
								GtSQLVlStr($this->sisslccl_cl, "int"));

			$Result = $__cnx->_prc($query_DtRg);

		}

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}
		$rsp['w_sn'] = $query_DtRg;
		return _jEnc($rsp);

	}

	public function MdlSTpEst($p=NULL){

		$Vl['e'] = 'no';
		$__chk = $this->MdlSTpEst_Chk();

		if(isN($__chk->id)){
			$__in = $this->MdlSTpEst_In();
			if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
		}
		if(!isN($__in) || !isN($__chk->id)){
			$__upd = $this->MdlSTpEst_Upd();
			if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
		}

		return(_jEnc($Vl));
	}

	public function MdlSTpEst_Chk($p=NULL){

		global $__cnx;

		if( !isN($this->mdlstpest_mdlstp) && !isN($this->mdlstpest_cntest) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf('SELECT *
								   FROM '._BdStr(DBM).TB_MDL_S_TP_EST.'
								   WHERE mdlstpest_mdlstp = %s AND mdlstpest_cntest = %s
								   LIMIT 1', GtSQLVlStr($this->mdlstpest_mdlstp,'int'), GtSQLVlStr($this->mdlstpest_cntest,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $this->gt_id_mdlstpest =$row_DtRg['id_mdlstpest'];
					$Vl['enc'] = ctjTx($row_DtRg['mdlstpest_enc'],'in').$icn;
					$Vl['est'] = mBln($row_DtRg['mdlstpest_est']);
				}
			}
			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function MdlSTpEst_In($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$__enc = Enc_Rnd( $this->mdlstpest_mdlstp.'-'.$this->mdlstpest_cntest );

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_EST." (mdlstpest_enc, mdlstpest_mdlstp, mdlstpest_cntest) VALUES (%s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->mdlstpest_mdlstp, "int"),
						GtSQLVlStr($this->mdlstpest_cntest, "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $this->gt_id_mdlstpest = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}


	public function MdlSTpEst_Upd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->gt_id_mdlstpest)){

			if(!isN($this->mdlstpest_dfl)){
				$upd_f[] = sprintf('mdlstpest_dfl=%s', GtSQLVlStr($this->mdlstpest_dfl, "int"));
			}
			if(!isN($this->mdlstpest_est)){
				$upd_f[] = sprintf('mdlstpest_est=%s', GtSQLVlStr($this->mdlstpest_est, "int"));
			}

			if(!isN($upd_f)){
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_EST." SET ".implode(',', $upd_f)." WHERE id_mdlstpest=%s",
	                                 GtSQLVlStr($this->gt_id_mdlstpest, "int"));

				$Result = $__cnx->_prc($updateSQL);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}

		}

		return _jEnc($rsp);

	}

	public function ClCntTag_In($p=NULL){

		global $__cnx;

		if(	!isN($this->cnttag_nm) &&
			!isN($this->cnttag_clr)){

			$_cl = $this->GtCl();
			$__enc = Enc_Rnd( $_cl->id.'-'.$this->cnttag_nm.'-'.$this->cnttag_clr );

			$insertSQL = sprintf("INSERT INTO ".TB_SIS_CNT_TAG." (siscnttag_enc, siscnttag_cl, siscnttag_nm, siscnttag_clr) VALUES (%s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_cl->id, "int"),
                   GtSQLVlStr(ctjTx($this->cnttag_nm,'out'), "text"),
				   GtSQLVlStr(ctjTx($this->cnttag_clr,'out'), "text"));

			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $this->c_p->$__enc;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function ClCntTp_In($p=NULL){

		global $__cnx;

		if(	!isN($this->cnttp_nm) &&
			!isN($this->cnttp_clr)){

			$_cl = $this->GtCl();
			$__enc = Enc_Rnd( $_cl->id.'-'.$this->cnttp_nm.'-'.$this->cnttp_clr );

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CNT_TP." (siscnttp_enc, siscnttp_cl, siscnttp_nm, siscnttp_key, siscnttp_grp, siscnttp_clr) VALUES (%s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_cl->id, "int"),
                   GtSQLVlStr(ctjTx($this->cnttp_nm,'out'), "text"),
                   GtSQLVlStr(ctjTx($this->cnttp_key,'out'), "text"),
                   GtSQLVlStr($this->cnttp_grp, "int"),
				   GtSQLVlStr(ctjTx($this->cnttp_clr,'out'), "text"));

			$Result = $__cnx->_prc($insertSQL);
		}

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i'] = $this->c_p->$__enc;

			$_chk = SisCntTp_Opt_Chk([ 'tp' => 'enc', 'id' => $__enc ]);

			if($_chk->e == 'ok'){
				$rsp['wm'] = 1;
				$rsp['wdddm'] = $_chk;
			}else{
				$rsp['wm'] = 2;
				$rsp['wdddm'] = $_chk;
			}

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function SisCntTp_Opt_Chk($p = NULL){
		global $__cnx;

		if( !isN($p['id']) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf("SELECT *
								   FROM ".DBM."._sis_cnt_tp_opt
								   WHERE siscnttpopt_siscnttp = (SELECT id_siscnttp FROM _sis_cnt_tp WHERE siscnttp_enc = %s)
								   LIMIT 1", GtSQLVlStr($p['id'],'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_siscnttpopt'];
					$Vl['enc'] = ctjTx($row_DtRg['siscnttpopt_enc'],'in');
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function MdlCntSch_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

	    if(!isN($p['mdl'])){ $__f_sub = sprintf(" AND mdlcntsch_mdlcnt = %s ", GtSQLVlStr($p['mdl'], "int"));	 }

		$query_DtRg = "
				SELECT

					 (	SELECT

					 		JSON_OBJECT(
					 			'id', IF(id_mdlcntsch IS NULL, '', id_mdlcntsch),
					 			'est', IF(mdlcntsch_est IS NULL, '', mdlcntsch_est)
				 			) AS __o

					 	FROM ".TB_MDL_CNT_SCH."
					 	WHERE mdlcntsch_mdlssch = id_mdlssch {$__f_sub}
					 ) AS __o,

					 mdlssch_enc, mdlssch_nm

				FROM "._BdStr(DBM).TB_MDL_S_SCH."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlssch_cl = id_cl
					 INNER JOIN ".TB_MDL_SCH." ON mdlsch_sch = id_mdlssch
				WHERE cl_enc = '".DB_CL_ENC."' AND mdlsch_mdl = '".$this->mdlsch_mdlsch."'
				ORDER BY mdlssch_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['tod'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlssch_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlssch_nm'],'in');

					if(!isN($row_DtRg['__o'])){
						$___col = json_decode($row_DtRg['__o']);
						$Vl['ls'][$id_ob]['in']['id'] = $___col->id;
						$Vl['ls'][$id_ob]['in']['est'] = mBln($___col->est);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
    }

	public function MdlSSch_Ls($p=NULL){

	    global $__cnx;

	    $_cl = $this->GtCl();

	    $Vl['e'] = 'no';

	    if(!isN($p['mdl'])){ $__f_sub = sprintf(" AND mdlsch_mdl = %s ", GtSQLVlStr($p['mdl'], "int"));	 }

		$query_DtRg = "
				SELECT *,

					 (	SELECT

					 		JSON_OBJECT(
					 			'id', IF(id_mdlsch IS NULL, '', id_mdlsch),
					 			'est', IF(mdlsch_est IS NULL, '', mdlsch_est)
				 			) AS __o

					 	FROM ".TB_MDL_SCH."
					 	WHERE mdlsch_sch = id_mdlssch {$__f_sub}
					 ) AS __o

				FROM "._BdStr(DBM).TB_MDL_S_SCH."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlssch_cl = id_cl
				WHERE cl_enc = '".DB_CL_ENC."' ORDER BY mdlssch_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$id_ob = $row_DtRg['mdlssch_enc'];
					$Vl['ls'][$id_ob]['enc'] = $id_ob;
					$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlssch_nm'],'in');
					$Vl['ls'][$id_ob]['y'] = ctjTx($row_DtRg['mdlssch_y'],'in');
					$Vl['ls'][$id_ob]['s'] = ctjTx($row_DtRg['mdlssch_s'],'in');

					if(!isN($row_DtRg['__o'])){
						$___col = json_decode($row_DtRg['__o']);
						$Vl['ls'][$id_ob]['in']['id'] = $___col->id;
						$Vl['ls'][$id_ob]['in']['est'] = mBln($___col->est);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
    }

	public function MdlSch($p=NULL){

		$Vl['e'] = 'no';
		$__chk = $this->MdlSch_Chk();

		if(isN($__chk->id)){
			$__in = $this->MdlSch_In();
			if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
		}
		if(!isN($__in) || !isN($__chk->id)){
			$__upd = $this->MdlSch_Upd();
			if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
		}

		return(_jEnc($Vl));
	}


	public function MdlSch_Chk($p=NULL){

		global $__cnx;

		if( !isN($this->mdlsch_sch) && !isN($this->mdlsch_mdl) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf('SELECT *
								   FROM '.TB_MDL_SCH.'
								   WHERE mdlsch_sch = %s AND mdlsch_mdl = %s
								   LIMIT 1', GtSQLVlStr($this->mdlsch_sch,'int'), GtSQLVlStr($this->mdlsch_mdl,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $this->gt_id_mdlsch =$row_DtRg['id_mdlsch'];
					$Vl['enc'] = ctjTx($row_DtRg['mdlsch_enc'],'in').$icn;
					$Vl['est'] = mBln($row_DtRg['mdlsch_est']);
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function MdlSch_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->mdlsch_sch.'-'.$this->mdlsch_mdl);

		$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_SCH." (mdlsch_enc, mdlsch_sch, mdlsch_mdl, mdlsch_est) VALUES (%s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->mdlsch_sch, "int"),
						GtSQLVlStr($this->mdlsch_mdl, "int"),
						GtSQLVlStr($this->mdlsch_est, "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $this->gt_id_mdlsch = $__cnx->c_p->insert_id;
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


	public function MdlSch_Upd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->gt_id_mdlsch)){

			if(!isN($this->mdlsch_est)){
				$upd_f[] = sprintf('mdlsch_est=%s', GtSQLVlStr($this->mdlsch_est, "int"));
			}

			if(!isN($upd_f)){

				$updateSQL = sprintf("UPDATE ".TB_MDL_SCH." SET ".implode(',', $upd_f)." WHERE id_mdlsch=%s",
	                                 GtSQLVlStr($this->gt_id_mdlsch, "int"));
				$Result = $__cnx->_prc($updateSQL);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
			}

		}

		return _jEnc($rsp);

	}

    public function UsNtf($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->us_ntf)){


			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_ntf=%s WHERE us_enc=%s",
                                 GtSQLVlStr($this->us_ntf, "int"),
                                 GtSQLVlStr(SISUS_ENC, "text"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

		}

		return _jEnc($rsp);

	}

    public function __flj(){

        $r['cmpg'] = $this->__flj_cmpg();
        $r['ec'] = $this->__flj_ec();
        $r['mdlcnt'] = $this->__flj_mdlcnt();
        $r['appl'] = $this->__flj_appl();

        return _jEnc($r);
    }

    public function __flj_cmpg(){


        if($this->clflj_t == 'cmpg_new'){

	        if(!isN($this->clflj_mre->ec_cmpg)){

				$__cmpg_dt = GtEcCmpgDt([ "id"=>$this->clflj_mre->ec_cmpg, 'us'=>'ok', 't'=>'enc', 'sgm'=>['e'=>'ok'], 'lsts'=>['e'=>'ok'] ]);

		        $__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_SLCTD_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_CMPG') ]);

				if($__flj->tot > 0){

					foreach($__flj->ls as $__flj_k=>$__flj_v){

						if(!isN($__flj_v->us->usr) || ($__flj_v->flj->user == 'ok' && !isN($__cmpg_dt->us->eml) )){

							if($__flj_v->flj->user == 'ok'){

								if($__flj_v->flj->ntf->eml == 'ok'){

									$__genc = Enc_Rnd(_CId('EC_NEWECCMPGUSR').'-'.$__cmpg_dt->us->eml.'-eml');

									$this->_Crm_Ec->id = _CId('EC_NEWECCMPGUSR');
									$this->_Crm_Ec->clfljsnd_enc = $__genc;
									$this->_Crm_Ec->ctj->id_eccmpg = CODNM_EC_CMPG.$__cmpg_dt->id;
									//$this->_Crm_Ec->btrck = 'ok';
									$__us_msj = $this->_Crm_Ec->_bld();

									if(!isN($__us_msj)){

										$_p_sve = $this->__flj_snd_ntf([
													'ntp'=>'eml',
													'enc'=>$__genc,
													'flj'=>$__flj_v->flj->id,
													'cid'=>$__cmpg_dt->id,
													'us'=>$__cmpg_dt->us->id,
													'emlortel'=>$__cmpg_dt->us->eml,
													'ec'=>_CId('EC_NEWECCMPGUSR'),
													'html'=>$__us_msj,
													'sbj'=>'Campaña ['.CODNM_EC_CMPG.$this->_Crm_Ec->ctj->id_eccmpg.'] en revisión'
												]);

										$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

										if($_p_sve->e == 'ok'){
											$r['e'] = 'ok';
										}else{
											$r['w'][] = 'Not created email on cmpg_new cl flj';
										}

									}

								}

								if($__flj_v->flj->ntf->sms == 'ok'){



								}

								if($__flj_v->flj->ntf->whtsp == 'ok'){

									$___us_tel = GtUsTelLs([ 'id'=>$__cmpg_dt->us->id ]);

									if(!isN($___us_tel) && !isN($___us_tel->ls)){

										foreach($___us_tel->ls as $_ustel_k=>$_ustel_v){

											if($_ustel_v->ntf->whtsp == 'ok'){

												$_whtsp_msg = '';
												$_whtsp_msg .= 'Tu Campaña ['.CODNM_EC_CMPG.$this->_Crm_Ec->ctj->id_eccmpg.'] esta en revisión.'."\n\n";
												$_whtsp_msg .= 'SUMR Team';

												$_whtsp_snd = Whtsp_Snd([
																	'to'=>$_ustel_v->telf,
																	'msg'=>$_whtsp_msg
																]);

												$__genc = Enc_Rnd(_CId('EC_NEWECCMPGUSR').'-'.$__cmpg_dt->us->eml.'-whtsp');

												if(!isN($_whtsp_snd->sid)){

													$_p_sve = $this->__flj_snd_ntf([
																'ntp'=>'whtsp',
																'enc'=>$__genc,
																'flj'=>$__flj_v->flj->id,
																'cid'=>$__cmpg_dt->id,
																'id'=>$_whtsp_snd->sid,
																'us'=>$__cmpg_dt->us->id,
																'emlortel'=>$_ustel_v->telf,
																'ec'=>_CId('EC_NEWECCMPGUSR'),
																'est'=>_CId('ID_SNDEST_SNDAPI'),
																'sbj'=>$_whtsp_msg
															]);

													if($_p_sve->e == 'ok'){
														$r['e'] = 'ok';
													}else{
														$r['w'][] = 'Not created whatsapp on cmpg_new cl flj';
														$r['w'][] = $_p_sve;
													}

												}

											}

										}

									}

								}

							}else{

								if($__flj_v->flj->ntf->eml == 'ok'){

									$__genc = Enc_Rnd(_CId('EC_NEWECCMPG').'-'.$__flj_v->us->usr);

									$this->_Crm_Ec->id = _CId('EC_NEWECCMPG');
									$this->_Crm_Ec->clfljsnd_enc = $__genc;
									$this->_Crm_Ec->ctj->id_eccmpg = CODNM_EC_CMPG.$__cmpg_dt->id;
									//$this->_Crm_Ec->btrck = 'ok';
									$__us_msj = $this->_Crm_Ec->_bld();


									if(!isN($__us_msj)){

										$_p_sve = $this->__flj_snd_ntf([
														'ntp'=>'eml',
														'enc'=>$__genc,
														'flj'=>$__flj_v->flj->id,
														'cid'=>$__cmpg_dt->id,
														'us'=>$__flj_v->us->id,
														'emlortel'=>$__flj_v->us->usr,
														'ec'=>_CId('EC_NEWECCMPG'),
														'html'=>$__us_msj,
														'sbj'=>'Campaña ['.CODNM_EC_CMPG.$__cmpg_dt->id.'] para aprobación'
													]);

										$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

										$_CRM_Ntf = new CRM_Ntf();
										$_CRM_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_ECCMPGAPRB'), 'v1'=>CODNM_EC_CMPG.$__cmpg_dt->id ];
										$_CRM_Ntf->ntf_tp = _CId('ID_NTFTP_EC_CMPG');
										$_CRM_Ntf->ntf_sub = "new_cmpg";
										$_CRM_Ntf->ntf_id_enc = $__cmpg_dt->enc;
										$_CRM_Ntf->ntf_id = $__cmpg_dt->id;
										$_CRM_Ntf->ntf_us = $__flj_v->us->id;
										$_ntf = $_CRM_Ntf->Prc();

										$r['ntf'][] = $_ntf;

										if($_ntf->e == 'ok' && $_p_sve->e == 'ok'){
											$r['e'] = 'ok';
										}else{
											$r['w'][] = 'Not created email on cmpg_new cl flj';
										}

									}else{

										$r['w'][] = 'No usmsj cmpg_new cl flj';

									}

								}

								if($__flj_v->flj->ntf->whtsp == 'ok'){

									$___us_tel = GtUsTelLs([ 'id'=>$__flj_v->us->id ]);

									$r['tmp1245']['telsof'.$__flj_v->us->id][] = $___us_tel;

									if(!isN($___us_tel) && !isN($___us_tel->ls)){

										foreach($___us_tel->ls as $_ustel_k=>$_ustel_v){

											if($_ustel_v->ntf->whtsp == 'ok'){

												$_whtsp_msg = '';
												$_whtsp_msg .= 'Hola '.$__flj_v->us->nm.', la campaña ['.CODNM_EC_CMPG.$__cmpg_dt->id.'] fue enviada para tu aprobación. Ingresa ahora a SUMR e inicia el correspondiente proceso.'."\n\n";
												$_whtsp_msg .= 'SUMR Team';

												$_whtsp_snd = Whtsp_Snd([
													'to'=>$_ustel_v->telf,
													'msg'=>$_whtsp_msg
												]);

												$__genc = Enc_Rnd(_CId('EC_NEWECCMPGUSR').'-'.$__cmpg_dt->us->eml.'-whtsp');


												$r['tmp1245']['snd'][] = $_whtsp_snd;

												if(!isN($_whtsp_snd->sid)){

													$_p_sve = $this->__flj_snd_ntf([
																'ntp'=>'whtsp',
																'enc'=>$__genc,
																'flj'=>$__flj_v->flj->id,
																'cid'=>$__cmpg_dt->id,
																'id'=>$_whtsp_snd->sid,
																'us'=>$__flj_v->us->id,
																'emlortel'=>$_ustel_v->telf,
																'ec'=>_CId('EC_NEWECCMPG'),
																'est'=>_CId('ID_SNDEST_SNDAPI'),
																'sbj'=>$_whtsp_msg
															]);

													$r['tmp1245']['sve'][] = $_p_sve;

													if($_p_sve->e == 'ok'){
														$r['e'] = 'ok';
													}else{
														$r['w'][] = 'Not created whatsapp on cmpg_new cl flj';
														$r['w'][] = $_p_sve;
													}

												}else{
													$r['w'][] = 'No id of whatsapp sended';
													$r['w'][] = $_whtsp_snd;
												}

											}

										}

									}

								}

							}

						}else{

							$r['w'][] = 'Not all data on cmpg_new cl flj';

						}

					}

				}

			}

		}elseif($this->clflj_t == 'cmpg_aprb'){


			if(!isN($this->clflj_mre->ec_cmpg)){

				$__cmpg_dt = GtEcCmpgDt([ "id"=>$this->clflj_mre->ec_cmpg, 't'=>'enc', 'us'=>'ok', 'ec'=>'ok', 'sgm'=>['e'=>'ok'], 'lsts'=>['e'=>'ok'] ]);

				$__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_APRB_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_CMPG') ]);

				if($__flj->tot > 0){

						foreach($__flj->ls as $__flj_k=>$__flj_v){

							if(!isN($__flj_v->us->usr) || ($__flj_v->flj->user == 'ok' && !isN($__cmpg_dt->us->eml) )){

								if($__flj_v->flj->user == 'ok'){

									$__genc = Enc_Rnd(_CId('EC_APRBECCMPGUSR').'-'.$__cmpg_dt->us->eml);

									$this->_Crm_Ec->id = _CId('EC_APRBECCMPGUSR');
									$this->_Crm_Ec->clfljsnd_enc = $__genc;
									$this->_Crm_Ec->ctj->id_eccmpg = CODNM_EC_CMPG.$__cmpg_dt->id;
									//$this->_Crm_Ec->btrck = 'ok';
									$__us_msj = $this->_Crm_Ec->_bld();

									if(!isN($__us_msj)){

										$_p_sve = $this->__flj_snd_ntf([
														'ntp'=>'eml',
														'enc'=>$__genc,
														'flj'=>$__flj_v->flj->id,
														'cid'=>$__cmpg_dt->id,
														'us'=>$__cmpg_dt->us->id,
														'emlortel'=>$__cmpg_dt->us->eml,
														'ec'=>_CId('EC_APRBECCMPGUSR'),
														'html'=>$__us_msj,
														'sbj'=>'Campaña ['.CODNM_EC_CMPG.$this->_Crm_Ec->ctj->id_eccmpg.'] aprobada'
													]);

										$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

										if($_p_sve->e == 'ok'){
											$r['e'] = 'ok';
										}else{
											$r['w'][] = 'Not created email on cmpg_aprb cl flj';
										}

									}

								}else{

									$__genc = Enc_Rnd(_CId('EC_APRBECCMPG').'-'.$__flj_v->us->usr);

									$this->_Crm_Ec->clfljsnd_enc = $__genc;
									$this->_Crm_Ec->id = _CId('EC_APRBECCMPG');
									$this->_Crm_Ec->ctj->id_eccmpg = CODNM_EC_CMPG.$__cmpg_dt->id;
									$this->_Crm_Ec->ctj->eccmpg_frm = $__cmpg_dt->frm;
									$this->_Crm_Ec->ctj->eccmpg_sndr = $__cmpg_dt->sndr->tt;
									$this->_Crm_Ec->ctj->eccmpg_prhdr = $__cmpg_dt->prhdr;
									$this->_Crm_Ec->ctj->eccmpg_rply = $__cmpg_dt->rply;
									$this->_Crm_Ec->ctj->eccmpg_sbj = $__cmpg_dt->sbj;
									$this->_Crm_Ec->ctj->eccmpg_p_f = $__cmpg_dt->p_f;
									$this->_Crm_Ec->ctj->eccmpg_p_h = $__cmpg_dt->p_h;
									$this->_Crm_Ec->ctj->eccmpg_nprb_dsc = $__cmpg_dt->nprb_dsc;

									$this->_Crm_Ec->ctj->lnk_acton = "<a href='".DMN_EC.LNK_HTML.'/'.$__cmpg_dt->ec->enc.'/'."' target='_blank' style='color:#FFF; text-decoration:none; margin-top:20px; background-color:#000; color:#FFF; padding-left:15px; padding-right:15px; padding-top:10px; padding-bottom:10px; display:block; width:100px;'>VER PUSHMAIL</a>";

									if(!isN($__cmpg_dt->lsts->html)){
										$this->_Crm_Ec->ctj->eccmpg_lsts = $__cmpg_dt->lsts->html;
									}elseif(!isN($__cmpg_dt->out_lsts)){
										$this->_Crm_Ec->ctj->eccmpg_lsts = $__cmpg_dt->out_lsts;
									}

									$this->_Crm_Ec->ctj->eccmpg_sgm = $__cmpg_dt->sgm->html;
									//$this->_Crm_Ec->btrck = 'ok';

									$__us_msj = $this->_Crm_Ec->_bld();

									if(!isN($__us_msj)){

										$_p_sve = $this->__flj_snd_ntf([
														'ntp'=>'eml',
														'enc'=>$__genc,
														'flj'=>$__flj_v->flj->id,
														'cid'=>$__cmpg_dt->id,
														'us'=>$__flj_v->us->id,
														'emlortel'=>$__flj_v->us->usr,
														'ec'=>_CId('EC_APRBECCMPG'),
														'html'=>$__us_msj,
														'sbj'=>'Campaña ['.CODNM_EC_CMPG.$this->_Crm_Ec->ctj->id_eccmpg.'] aprobada'
													]);

										$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

										if($_p_sve->e == 'ok'){
											$r['e'] = 'ok';
										}else{
											$r['w'][] = 'Not created email on cmpg_aprb cl flj';
										}

									}else{

										$r['w'][] = 'Not msj on cmpg_aprb cl flj';

									}

								}

							}else{

								$r['w'][] = 'Not all data on cmpg_aprb cl flj';

							}

						}

				}

			}

		}elseif($this->clflj_t == 'cmpg_aprb_no'){

			if(!isN($this->clflj_mre->ec_cmpg)){

				$__cmpg_dt = GtEcCmpgDt([ "id"=>$this->clflj_mre->ec_cmpg, 'us'=>'ok', 't'=>'enc', 'sgm'=>['e'=>'ok'], 'lsts'=>['e'=>'ok'] ]);

				$__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_APRB_NO_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_CMPG') ]);

				$r['flj_snd'] = $__flj;

				if($__flj->tot > 0){

					foreach($__flj->ls as $__flj_k=>$__flj_v){

						if(!isN($__flj_v->us->usr) || ($__flj_v->flj->user == 'ok' && !isN($__cmpg_dt->us->eml) )){

							if($__flj_v->flj->user == 'ok'){

								$__genc = Enc_Rnd(_CId('EC_NOAPRBECCMPGUSR').'-'.$__cmpg_dt->us->eml);
								$this->_Crm_Ec->clfljsnd_enc = $__genc;
								$this->_Crm_Ec->id = _CId('EC_NOAPRBECCMPGUSR');
								$this->_Crm_Ec->ctj->id_eccmpg = CODNM_EC_CMPG.$__cmpg_dt->id;
								//$this->_Crm_Ec->btrck = 'ok';
								$__us_msj = $this->_Crm_Ec->_bld();


								if(!isN($__us_msj)){

									$_p_sve = $this->__flj_snd_ntf([
													'ntp'=>'eml',
													'enc'=>$__genc,
													'flj'=>$__flj_v->flj->id,
													'cid'=>$__cmpg_dt->id,
													'us'=>$__cmpg_dt->us->id,
													'emlortel'=>$__cmpg_dt->us->eml,
													'ec'=>_CId('EC_NOAPRBECCMPGUSR'),
													'html'=>$__us_msj,
													'sbj'=>'Campaña ['.$this->_Crm_Ec->ctj->id_eccmpg.'] no aprobada'
												]);

									$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

									if($_p_sve->e == 'ok'){
										$r['e'] = 'ok';
									}else{
										$r['w'][] = 'Not created email on cmpg_aprb_no cl flj';
									}

								}

							}else{

								$__genc = Enc_Rnd(_CId('EC_APRBECCMPG').'-'.$__flj_v->us->usr);
								$this->_Crm_Ec->clfljsnd_enc = $__genc;
								$this->_Crm_Ec->id = _CId('EC_APRBECCMPG');
								$this->_Crm_Ec->ctj->id_eccmpg = CODNM_EC_CMPG.$__cmpg_dt->id;
								//$this->_Crm_Ec->btrck = 'ok';
								$__us_msj = $this->_Crm_Ec->_bld();

								if(!isN($__us_msj)){

									$_p_sve = $this->__flj_snd_ntf([
												'ntp'=>'eml',
												'enc'=>$__genc,
												'flj'=>$__flj_v->flj->id,
												'cid'=>$__cmpg_dt->id,
												'us'=>$__flj_v->us->id,
												'emlortel'=>$__flj_v->us->usr,
												'ec'=>_CId('EC_APRBECCMPG'),
												'html'=>$__us_msj,
												'sbj'=>'Campaña ['.$this->_Crm_Ec->ctj->id_eccmpg.'] no aprobada'
											]);

									$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

									if($_p_sve->e == 'ok'){
										$r['e'] = 'ok';
									}else{
										$r['w'][] = 'Not created email on cmpg_aprb_no cl flj';
									}

								}else{

									$r['w'][] = 'No mesaje on cmpg_aprb_no cl flj';

								}

							}

						}else{

							$r['w'][] = 'No all data on cmpg_aprb_no cl flj';

						}

					}

				}

			}

		}

        return _jEnc($r);

    }

    public function __flj_ec(){

		$r['e'] = 'no';

        if($this->clflj_t == 'ec_cmz_new'){

			$__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_SLCTD_APRB_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_EC_CMZ') ]);

			if(!isN($this->clflj_mre->ec_cmz)){

				$_gt_ec = ChkEcCmzEc([ 'eccmz'=>$this->clflj_mre->ec_cmz ]);
				//$r['_______eccmz'][] = $_gt_ec;

				if($__flj->tot > 0){

					foreach($__flj->ls as $__flj_k=>$__flj_v){

						$this->_Crm_Ec->ctj->lnk_acton = "<a href='".DMN_EC.'a/'.$_gt_ec->enc.'/'.$__flj_v->us->enc."' target='_blank' style='color:#FFF; text-decoration:none; margin-top:20px; background-color:#000; color:#FFF; padding-left:15px; padding-right:15px; padding-top:10px; padding-bottom:10px; display:block; width:100px;'>APROBAR</a>";

						$__genc = Enc_Rnd(_CId('EC_NEWEC').'-'.$__flj_v->us->usr);
						$this->_Crm_Ec->clfljsnd_enc = $__genc;
						$this->_Crm_Ec->id = _CId('EC_NEWEC');
						$this->_Crm_Ec->ctj->id_ec = CODNM_EC.$_gt_ec->id;
						//$this->_Crm_Ec->btrck = 'ok';
						$__us_msj = $this->_Crm_Ec->_bld();

						if(!isN($__us_msj)){

							if(!isN($__flj_v->us->usr)){

								$_CRM_Ntf = new CRM_Ntf();
								$_CRM_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_ECCMZAPRB'), 'v1'=>CODNM_EC.$_gt_ec->id ];
								$_CRM_Ntf->ntf_tp = _CId('ID_NTFTP_EC_CMZ');
								$_CRM_Ntf->ntf_sub = "new_aprb";
								$_CRM_Ntf->ntf_id_enc = $_gt_ec->enc;
								$_CRM_Ntf->ntf_id = $_gt_ec->id;
								$_CRM_Ntf->ntf_us = $__flj_v->us->id;
								$r['ntf'][] = $_ntf = $_CRM_Ntf->Prc();


								$_p_sve = $this->__flj_snd_ntf([
												'ntp'=>'eml',
												'enc'=>$__genc,
												'flj'=>$__flj_v->flj->id,
												'cid'=>$_gt_ec->id,
												'us'=>$__flj_v->us->id,
												'emlortel'=>$__flj_v->us->usr,
												'ec'=>_CId('EC_NEWEC'),
												'html'=>$__us_msj,
												'sbj'=>'Pushmail ['.$this->_Crm_Ec->ctj->id_ec.'] para aprobación'
											]);

								$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

								if($_ntf->e == 'ok' && $_p_sve->e == 'ok'){
									$r['e'] = 'ok';
								}else{
									$r['w'][] = 'Not created email on ec_cmz_new cl flj | '.$_p_sve->w.' | '.$_ntf->in->w.' | Us:'.$__flj_v->us->id.' ';
									$r['w2'][] = $_p_sve;
								}

							}else{

								$r['w'][] = 'No $__flj_v->us->usr on ec_cmz_new cl flj';

							}

						}else{

							$r['w'][] = 'No $__us_msj on ec_cmz_new cl flj';

						}

					}

				}

			}

		}elseif($this->clflj_t == 'ec_cmz_aprb'){

			$__dtec = GtEcDt($this->clflj_mre->ec_cmz, 'enc', ['cmz'=>'ok'] );

			if(!isN($__dtec->id) && !isN($__dtec->cmzrlc->us->user)){

				$__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_APRB_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_EC_CMZ') ]);

				//$r['___tmp'] = $__flj;

					foreach($__flj->ls as $__flj_k=>$__flj_v){

						if($__flj_v->flj->user == 'ok'){


							$__genc = Enc_Rnd(_CId('EC_APRBECCMZ').'-'.$__dtec->cmzrlc->us->user);
							$this->_Crm_Ec->clfljsnd_enc = $__genc;
							$this->_Crm_Ec->id = _CId('EC_APRBECCMZ');
							$this->_Crm_Ec->ctj->id_ec = CODNM_EC.$__dtec->id;
							//$this->_Crm_Ec->btrck = 'ok';
							$__us_msj = $this->_Crm_Ec->_bld();

							if(!isN($__us_msj) && !isN($__dtec->id) && !isN(_CId('EC_APRBECCMZ'))){

								$_p_sve = $this->__flj_snd_ntf([
											'ntp'=>'eml',
											'enc'=>$__genc,
											'flj'=>$__flj_v->flj->id,
											'cid'=>$__dtec->id,
											'us'=>$__dtec->cmzrlc->us->id,
											'emlortel'=>$__dtec->cmzrlc->us->user,
											'ec'=>_CId('EC_APRBECCMZ'),
											'html'=>$__us_msj,
											'sbj'=>'Pushmail ['.$this->_Crm_Ec->ctj->id_ec.'] aprobado'
										]);

								$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

								if($_p_sve->e == 'ok'){
									$r['e'] = 'ok';
								}else{
									$r['w'][] = 'Not created email on ec_cmz_aprb cl flj';
								}

							}else{

								$r['w'][] = 'Not all data on ec_cmz_aprb cl flj';

							}

						}elseif(!isN($__flj_v->us->usr)){

							$__genc = Enc_Rnd(_CId('EC_APRBECCMZ').'-'.$__flj_v->us->usr);
							$this->_Crm_Ec->clfljsnd_enc = $__genc;
							$this->_Crm_Ec->id = _CId('EC_APRBECCMZ');
							$this->_Crm_Ec->ctj->id_ec = CODNM_EC.$__dtec->id;
							//$this->_Crm_Ec->btrck = 'ok';
							$__us_msj = $this->_Crm_Ec->_bld();

							if(!isN($__us_msj) && !isN($__dtec->id) && !isN(_CId('EC_APRBECCMZ'))){

								$_p_sve = $this->__flj_snd_ntf([
												'ntp'=>'eml',
												'enc'=>$__genc,
												'flj'=>$__flj_v->flj->id,
												'cid'=>$__dtec->id,
												'us'=>$__flj_v->us->id,
												'emlortel'=>$__flj_v->us->usr,
												'ec'=>_CId('EC_APRBECCMZ'),
												'html'=>$__us_msj,
												'sbj'=>'Pushmail ['.$this->_Crm_Ec->ctj->id_ec.'] aprobado'
											]);

								$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

								if($_p_sve->e == 'ok'){
									$r['e'] = 'ok';
								}else{
									$r['w'][] = 'Not created email on ec_cmz_aprb cl flj';
								}

							}else{

								$r['w'][] = 'Not all data on ec_cmz_aprb cl flj';

							}

						}

					}

			}

		}

        return _jEnc($r);

    }

    public function __flj_mdlcnt(){

        if($this->clflj_t == 'mdl_cnt_new'){

			$__dtmdlcnt = GtMdlCntDt([ 'id'=>$this->clflj_mre->mdlcnt_enc, 't'=>'enc', 'shw'=>['eml'=>'ok'] ]);

			$r['___tmp___flj_mdlcnt_mdlcnt'] = $__dtmdlcnt;


			if(!isN($__dtmdlcnt->id) && !isN($__dtmdlcnt->mdl->eml->tot) && $__dtmdlcnt->mdl->eml->tot > 0){

				$__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_IN_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_CNT_IN') ]);

				//$r['___tmp_GtClFljLs'] = $__flj;

				$__genc = Enc_Rnd(_CId('EC_NEWLEAD').'-'.$__eml_v->us->user);

				$this->_Crm_Ec->clfljsnd_enc = $__genc;
				$this->_Crm_Ec->id = _CId('EC_NEWLEAD');
				$this->_Crm_Ec->ctj->cnt_nm = $__dtmdlcnt->cnt->nm;
				$this->_Crm_Ec->ctj->cnt_ap = $__dtmdlcnt->cnt->ap;
				$this->_Crm_Ec->ctj->mdl_nm = $__dtmdlcnt->mdl->nm;
				//$this->_Crm_Ec->btrck = 'ok';

				$__us_msj = $this->_Crm_Ec->_bld();

				if(!isN($__us_msj) && !isN($__flj->ls) && $__flj->tot > 0){

					foreach($__dtmdlcnt->mdl->eml->ls as $__eml_k=>$__eml_v){

						$r['snd______'][] = $__eml_v->us->user;

						$_p_sve = $this->__flj_snd_ntf([
									'ntp'=>'eml',
									'enc'=>$__genc,
									'flj'=>$__flj->ls[0]->flj->id,
									'cid'=>$__dtmdlcnt->id,
									'us'=>$__eml_v->us->id,
									'emlortel'=>$__eml_v->us->user,
									'ec'=>_CId('EC_NEWLEAD'),
									'html'=>$__us_msj,
									'sbj'=>'Nuevo Lead en CRM - '.$__dtmdlcnt->cnt->nm.' '.$__dtmdlcnt->cnt->ap
								]);

						$r['snd'][] = [ 'id'=>$__flj->ls[0], 'p'=>$_p_sve ];

						if($_p_sve->e == 'ok'){
							$r['e'] = 'ok';
						}else{
							$r['w'][] = 'Not created email on mdl_cnt_new cl flj';
						}

					}

				}

			}

		}

        return _jEnc($r);

    }

    public function __flj_appl(){

        if($this->clflj_t == 'appl_new'){

			$__flj = GtClFljLs([ 'flj'=>_CId('ID_SISCLFLJ_SLCTD_APPL_NTF'), 'tp'=>_CId('ID_SISCLFLJTP_CNT_IN') ]);

			$_cl = $this->GtCl([ 't' => 'enc' ]);

			if(!isN($this->clflj_mre->appl_enc)){

				$__dtapplcnt = GtCntApplDt([ 'id'=>$this->clflj_mre->appl_enc, 't'=>'enc', 'shw'=>['eml'=>'ok'] ]);
				//$r['_______eccmz'][] = $_gt_ec;

				if($__flj->tot > 0){

					foreach($__flj->ls as $__flj_k=>$__flj_v){

						$__genc = Enc_Rnd(_CId('EC_NEWAPPLCNT').'-'.$__flj_v->us->usr);
						$this->_Crm_Ec->clfljsnd_enc = $__genc;
						$this->_Crm_Ec->id = _CId('EC_NEWAPPLCNT');
						$this->_Crm_Ec->ctj->id_ec = CODNM_EC.$_gt_ec->id;

						$__us_msj = $this->_Crm_Ec->_bld();

						if(!isN($__us_msj)){

							if(!isN($__flj_v->us->usr)){

								$_CRM_Ntf = new CRM_Ntf();
								$_CRM_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_NW_LD') ];
								$_CRM_Ntf->ntf_tp = _CId('ID_NTFTP_APPL');
								$_CRM_Ntf->ntf_sub = "appl_new";
								$_CRM_Ntf->cl = $_cl->id;
								$_CRM_Ntf->ntf_id_enc = $__dtapplcnt->enc;
								$_CRM_Ntf->ntf_id = $__dtapplcnt->id;
								$_CRM_Ntf->ntf_us = $__flj_v->us->id;
								$_ntf = $_CRM_Ntf->Prc();


								$r['ntf'][] = $_ntf;

								$_p_sve = $this->__flj_snd_ntf([
													'ntp'=>'eml',
													'enc'=>$__genc,
													'flj'=>$__flj_v->flj->id,
													'cid'=>$__dtapplcnt->id,
													'us'=>$__flj_v->us->id,
													'emlortel'=>$__flj_v->us->usr,
													'ec'=>_CId('EC_NEWAPPLCNT'),
													'html'=>$__us_msj,
													'sbj'=>'Nuevo Lead de aplicación'
												]);

								$r['snd'][] = [ 'id'=>$__flj_v, 'p'=>$_p_sve ];

								if($_ntf->e == 'ok' && $_p_sve->e == 'ok'){
									$r['e'] = 'ok';
								}else{
									$r['w'][] = 'Not created email on mdl_cnt_new cl flj';
								}

							}

						}

					}

				}

			}

		}

        return _jEnc($r);

    }

    public function __flj_snd_ntf($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($p['f'])){ $_f=$p['f']; }else{ $_f=SIS_F2; }
		if(!isN($p['h'])){ $_h=$p['h']; }else{ $_h=SIS_H2; }
		if(!isN($p['tp'])){ $_tp=$p['tp']; }else{ $_tp = $this->clflj_t; }
		if(!isN($p['ntp'])){ $_ntp=$p['ntp']; }else{ $_ntp = $this->clflj_ntp; }

		if(!isN($p['cid']) && !isN($p['us']) && !isN($p['flj']) && !isN($_tp) && !isN($p['emlortel'])){

			$__chk = $this->__flj_snd_chk([ 'cid'=>$p['cid'], 'us'=>$p['us'], 'flj'=>$p['flj'], 'ntp'=>$_ntp, 'tp'=>$_tp ]);

			//$rsp['chk'] = $__chk;

			if($__chk->e == 'ok' && ($__chk->tot == 0 && isN($__chk->id))){

				if(
					(
						filter_var($p['emlortel'], FILTER_VALIDATE_EMAIL) ||
						filter_var($p['emlortel'], FILTER_VALIDATE_INT)
					) &&
					!isN($p['cid']) &&
					!isN($p['ec'])
				){

					if(!isN($p['enc'])){
						$__enc = $p['enc'];
					}else{
						$__enc = Enc_Rnd($_f.'-'.$_h.'-'.$p['ec'].'-'.$p['emlortel'].'-'.$p['ntp']);
					}

					if(!isN($p['est'])){
						$__est = $p['est'];
					}else{
						$__est = _CId('ID_SNDEST_PRG');
					}

					$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_FLJ_SND." (clfljsnd_enc, clfljsnd_tp, clfljsnd_ntp, clfljsnd_cid, clfljsnd_id, clfljsnd_est, clfljsnd_f, clfljsnd_h, clfljsnd_sbj, clfljsnd_ec, clfljsnd_emlortel, clfljsnd_us, clfljsnd_clflj, clfljsnd_test, clfljsnd_html) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($_tp, "text"),
								GtSQLVlStr($_ntp, "text"),
								GtSQLVlStr($p['cid'], "text"),
								GtSQLVlStr($p['id'], "text"),
								GtSQLVlStr($__est, "int"),
								GtSQLVlStr($_f, "date"),
								GtSQLVlStr($_h, "date"),
								GtSQLVlStr(ctjTx($p['sbj'],'out'), "text"),
								GtSQLVlStr($p['ec'], "int"),
								GtSQLVlStr($p['emlortel'], "text"),
								GtSQLVlStr($p['us'], "int"),
								GtSQLVlStr($p['flj'], "int"),
								GtSQLVlStr($__test, "int"),
								GtSQLVlStr(ctjTx($p['html'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'] ), "text"));

					//$rsp['q'] = $insertSQL;
					$Result = $__cnx->_prc($insertSQL);

				}

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_r->error]);
				}

			}else{

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['id'] = $__chk->id;

			}

		}else{

			$rsp['w'] = 'No all data | cid:'.$p['cid'].' | us:'.$p['us'].' | flj:'.$p['flj'].' | tp:'.$_tp.' | emlortel:'.$p['emlortel'].' ';

		}

        return _jEnc($rsp);

    }

    public function __flj_snd_dt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				$c_DtRg = "-1";if(!isN($_p['id'])){$c_DtRg = $_p['id'];}

				if($_p['t'] == 'enc'){ $__f = 'clfljsnd_enc'; $__ft = 'text'; }
				elseif($_p['t'] == 'id'){ $__f = 'clfljsnd_id'; $__ft = 'text'; }
				else{ $__f = 'id_clfljsnd'; $__ft = 'int'; }

				$query_DtRg = sprintf("	SELECT *
										FROM "._BdStr(DBM).TB_CL_FLJ_SND."
											 INNER JOIN "._BdStr(DBM).TB_CL_FLJ." ON clfljsnd_clflj = id_clflj
										WHERE {$__f} = %s", GtSQLVlStr($c_DtRg, $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['id'] = $row_DtRg['id_clfljsnd'];
					$Vl['enc'] = ctjTx($row_DtRg['clfljsnd_enc'],'in');

				}else{

					$Vl['w'] = $__cnx->c_r->error;
					$rsp['w_n'] = $__cnx->c_r->errno;

				}

				$__cnx->_clsr($DtRg);

			}
		}

		return _jEnc($Vl);
	}




	public function __flj_snd_chk($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['cid']) && !isN($_p['tp']) && !isN($_p['ntp']) && !isN($_p['flj']) && !isN($_p['flj']) && !isN($_p['us'])){

				$query_DtRg = sprintf("	SELECT id_clfljsnd, clfljsnd_enc
										FROM "._BdStr(DBM).TB_CL_FLJ_SND."
											 INNER JOIN "._BdStr(DBM).TB_CL_FLJ." ON clfljsnd_clflj = id_clflj
										WHERE 	clfljsnd_clflj=%s AND
												clfljsnd_tp=%s AND
												clfljsnd_ntp=%s AND
												clfljsnd_cid=%s AND
												clfljsnd_us=%s
										LIMIT 1",
										GtSQLVlStr($_p['flj'], 'int'),
										GtSQLVlStr($_p['tp'], 'text'),
										GtSQLVlStr($_p['ntp'], 'text'),
										GtSQLVlStr($_p['cid'], 'text'),
										GtSQLVlStr($_p['us'], 'int')
									);

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['tmp_q'] = compress_code($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg == 1){
						$Vl['id'] = $row_DtRg['id_clfljsnd'];
						$Vl['enc'] = ctjTx($row_DtRg['clfljsnd_enc'],'in');
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;
					$rsp['w_n'] = $__cnx->c_r->errno;

				}

				$__cnx->_clsr($DtRg);

			}
		}

		return _jEnc($Vl);
	}



    // Lista De Clientes para relacion con videos de centro de aprendizaje...
	public function GtLrnVdClLs($p=NULL){

		global $__cnx;
		global $__dt_cl;

	    $Vl['e'] = 'no';

	    if(!isN($this->lrn_enc)){

		    if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		    $query_DtRg = "
						SELECT *,

								(SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = "._CId('ID_SISTAG_CLR_MAIN')." AND cltag_cl = id_cl ) AS _cl_clr,

								(	SELECT COUNT(*)
									FROM "._BdStr(DBM).TB_LRN_VD_CL."
									WHERE id_cl = lrnvdcl_cl
									AND lrnvdcl_lrnvd = (SELECT id_lrnvd FROM "._BdStr(DBM).TB_LRN_VD." WHERE lrnvd_enc = '".$this->lrn_enc."')
								) AS tot

						FROM "._BdStr(DBM).MDL_CL_BD."
						WHERE id_cl != ''

						ORDER BY tot DESC, cl_nm ASC
						";
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{
						$Vl['ls'][$row_DtRg['cl_enc']]['enc'] = $row_DtRg['cl_enc'];
						$Vl['ls'][$row_DtRg['cl_enc']]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
						$Vl['ls'][$row_DtRg['cl_enc']]['img'] = _ImVrs(['img'=>$row_DtRg['cl_img'], 'f'=>DMN_FLE_CL]);
						$Vl['ls'][$row_DtRg['cl_enc']]['clr'] = $row_DtRg['_cl_clr'];
						$Vl['ls'][$row_DtRg['cl_enc']]['tot'] = $row_DtRg['tot'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}

			$__cnx->_clsr($DtRg);
		}

		return(_jEnc($Vl));

    }

	public function _LrnVd_Cl_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->lrn_enc.'-'.'lrnvd_cl_');

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_LRN_VD_CL." ( lrnvdcl_enc, lrnvdcl_lrnvd, lrnvdcl_cl )
							VALUES
							(
								%s,
								(SELECT id_lrnvd FROM "._BdStr(DBM).TB_LRN_VD." WHERE lrnvd_enc = %s),
								(SELECT id_cl FROM "._BdStr(DBM).MDL_CL_BD." WHERE cl_enc = %s)
							)
							",
							GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->lrn_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cl_enc, 'out'), "text"));

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

	public function _LrnVd_Cl_Eli($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".TB_LRN_VD_CL." WHERE
															lrnvdcl_lrnvd = (SELECT id_lrnvd FROM "._BdStr(DBM).TB_LRN_VD." WHERE lrnvd_enc = %s) AND
															lrnvdcl_cl = (SELECT id_cl FROM "._BdStr(DBM).MDL_CL_BD." WHERE cl_enc = %s)
							",
							GtSQLVlStr(ctjTx($this->lrn_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->cl_enc, 'out'), "text"));

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


	public function __flj_snd_upd($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['html'])){ $_upd[] = sprintf('clfljsnd_html=%s', GtSQLVlStr(ctjTx($p['html'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'] ), "text")); }
			if(!isN($p['snd_id'])){ $_upd[] = sprintf('clfljsnd_id=%s', GtSQLVlStr($p['snd_id'], "text")); }
			if(!isN($p['est'])){ $_upd[] = sprintf('clfljsnd_est=%s', GtSQLVlStr($p['est'], "text")); }
			if(!isN($p['bnc'])){ $_upd[] = sprintf('clfljsnd_bnc=%s', GtSQLVlStr($p['bnc'], "text")); }
			if(!isN($p['bnc_sbj'])){ $_upd[] = sprintf('clfljsnd_bnc_sbj=%s', GtSQLVlStr($p['bnc_sbj'], "text")); }
			if(!isN($p['bnc_msg'])){ $_upd[] = sprintf('clfljsnd_bnc_msg=%s', GtSQLVlStr($p['bnc_msg'], "text")); }
			if(!isN($p['bnc_tp'])){ $_upd[] = sprintf('clfljsnd_bnc_tp=%s', GtSQLVlStr($p['bnc_tp'], "text")); }
			if(!isN($p['bnc_tp_sub'])){ $_upd[] = sprintf('clfljsnd_bnc_tp_sub=%s', GtSQLVlStr($p['bnc_tp_sub'], "text")); }
			if(!isN($p['bnc_rpr'])){ $_upd[] = sprintf('clfljsnd_bnc_rpr=%s', GtSQLVlStr($p['bnc_rpr'], "text")); }
			if(!isN($p['bnc_rule'])){ $_upd[] = sprintf('clfljsnd_bnc_rule=%s', GtSQLVlStr($p['bnc_rule'], "text")); }

			if(count($_upd) > 0){

				try {

					$updateSQL = "UPDATE "._BdStr(DBM).TB_CL_FLJ_SND." SET ".implode(',', $_upd)." WHERE clfljsnd_enc=".GtSQLVlStr( $p['id'] , "text");

				} catch (Exception $e) {

					$rsp['w'] = $e->getMessage();

				}

			}

			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_r->error;
				$rsp['e'] = 'no';
			}

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = 'no all data';

		}

		return _jEnc($rsp);
	}

	public function __flj_snd_us($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['dnc'])){ $_upd[] = sprintf('us_eml_dnc=%s', GtSQLVlStr($p['dnc'], "text")); }
			if(!isN($p['rjct'])){ $_upd[] = sprintf('us_eml_rjct=%s', GtSQLVlStr($p['rjct'], "int")); }
			if(!isN($p['sndi'])){ $_upd[] = sprintf('us_eml_sndi=%s', GtSQLVlStr($p['sndi'], "int")); }

			if(count($_upd) > 0){

				try {

					$updateSQL = "UPDATE "._BdStr(DBM).TB_US." SET ".implode(',', $_upd)." WHERE us_enc=".GtSQLVlStr( $p['id'] , "text");

				} catch (Exception $e) {

					$rsp['w'] = $e->getMessage();

				}

			}

			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_r->error;
				$rsp['e'] = 'no';
			}

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = 'no all data';

		}

		return _jEnc($rsp);
	}

	public function plcy_main($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['cl'])){

				$query_DtRg = sprintf("	SELECT *
										FROM "._BdStr(DBM).TB_CL_PLCY."
										WHERE clplcy_cl=%s AND clplcy_main=1 AND clplcy_e=1
										ORDER BY clplcy_fi DESC", GtSQLVlStr($_p['cl'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_clplcy'];
						$Vl['enc'] = ctjTx($row_DtRg['clplcy_enc'],'in');
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;
					$rsp['w_n'] = $__cnx->c_r->errno;

				}

				$__cnx->_clsr($DtRg);

			}
		}

		return _jEnc($Vl);
	}

	public function AutoCl_Ls($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($this->id_auto)){

			$query_DtRg = "SELECT
								*,(
									SELECT
										autocl_e
									FROM
										"._BdStr(DBA).TB_AUTO_CL."
										INNER JOIN "._BdStr(DBA).TB_AUTO_TP." ON id_autotp = autocl_tp
									WHERE
										id_cl= autocl_cl
									AND autotp_enc = '".$this->id_auto."'
								) AS __est
							FROM
								"._BdStr(DBM).TB_CL."
							WHERE
								cl_on = '1'
							ORDER BY
								id_cl DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['qry'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{
						$Vl['ls'][$row_DtRg['cl_enc']]['enc'] = $row_DtRg['cl_enc'];
						$Vl['ls'][$row_DtRg['cl_enc']]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
						$Vl['ls'][$row_DtRg['cl_enc']]['img'] = ctjTx($row_DtRg['cl_img'],'in');
						$Vl['ls'][$row_DtRg['cl_enc']]['est'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			}else{

				$Vl['w'] = $this->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}

	public function AutoCl($p=NULL){

		$Vl['e'] = 'no';
		$__chk = $this->AutoCl_Chk();
		$Vl['sse'] = $__chk;
		if(isN($__chk->id)){
			$__in = $this->AutoCl_In();
			if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }else{ $Vl['er'] = $__in; }
		}elseif(!isN($__in) || !isN($__chk->id)){
			$__upd = $this->AutoCl_Upd([ 'est' => $__chk->est ]);
			$Vl['_upd']=$__upd;
			if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
		}

		return(_jEnc($Vl));
	}

	public function AutoCl_Chk($p=NULL){

		global $__cnx;

		if( !isN($this->id_cl) && !isN($this->id_auto) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBA).TB_AUTO_CL."
									WHERE autocl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s) AND
										  autocl_tp = (SELECT id_autotp FROM "._BdStr(DBA).TB_AUTO_TP." WHERE autotp_enc = %s)
								   LIMIT 1", GtSQLVlStr($this->id_cl,'text'), GtSQLVlStr($this->id_auto,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $query_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_autocl'];
					$Vl['est'] = $row_DtRg['autocl_e'];
				}
			}
			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function AutoCl_In($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBA).TB_AUTO_CL." ( autocl_cl, autocl_tp, autocl_e)
									VALUES ( (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s),
												(SELECT id_autotp FROM "._BdStr(DBA).TB_AUTO_TP." WHERE autotp_enc = %s), 1)",
						GtSQLVlStr($this->id_cl, "text"),
						GtSQLVlStr($this->id_auto, "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['er'] = $query_DtRg;
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function AutoCl_Upd($p=NULL){

		global $__cnx;

		if($p['est'] == 1){ $_est = 2; }else{ $_est = 1; }

		$query_DtRg = sprintf("UPDATE "._BdStr(DBA).TB_AUTO_CL." SET
									autocl_e = ".$_est."
								WHERE
									autocl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s) AND
									autocl_tp = (SELECT id_autotp FROM "._BdStr(DBA).TB_AUTO_TP." WHERE autotp_enc = %s)",
									GtSQLVlStr($this->id_cl, "text"),
									GtSQLVlStr($this->id_auto, "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['sssm'] = $query_DtRg;

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;

		}

		return _jEnc($rsp);

	}


	function bld_json(){

		if(!isN($this->id_cl)){
			$this->_cl_d = GtClDt($this->id_cl, 'enc', [ 'dtl'=>[ 'tag'=>'ok' ]]);
		}

		if(!isN( $this->_cl_d->id )){

			$__tag = __LsDt([ 'k'=>'tra_tag', 'cl'=>$this->_cl_d->id, 'prvt'=>'ok' ]);
			$__ord = __LsDt([ 'k'=>'tra_ord', 'prvt'=>'ok' ]);
			$__anm = __LsDt([ 'k'=>'dsh_anm', 'cl'=>$this->_cl_d->id, 'prvt'=>'ok' ]);
			$__api = __LsDt([ 'k'=>'api_thrd', 'cl'=>$this->_cl_d->id, 'prvt'=>'ok' ]);

			$tag_tot=0;

			foreach($__tag->ls->tra_tag as $__tag_k=>$__tag_v){
				$tag[ $__tag_v->enc ]['nm'] = $__tag_v->tt;
				$tag[ $__tag_v->enc ]['enc'] = $__tag_v->enc;
				$tag[ $__tag_v->enc ]['clr'] = $__tag_v->clr_tag->vl;
				$tag_tot++;
			}

			$anm_tot=0;

			foreach($__anm->ls->dsh_anm as $__anm_k=>$__anm_v){
				$anm[ $anm_tot ]['nm'] = $__anm_v->tt;
				$anm[ $anm_tot ]['enc'] = $__anm_v->enc;
				$anm[ $anm_tot ]['dir'] = $__anm_v->dir->vl;
				$anm[ $anm_tot ]['drk'] = $__anm_v->drk->vl==1?'ok':'no';
				$anm_tot++;
			}

			$org_tot=0;

			foreach($__ord->ls->tra_ord as $__org_k=>$__org_v){
				$ord[ $__org_v->enc ]['nm'] = $__org_v->tt;
				$ord[ $__org_v->enc ]['enc'] = $__org_v->enc;
				$ord[ $__org_v->enc ]['cmp'] = $__org_v->cmp->vl;
				$ord[ $__org_v->enc ]['asc'] = $__org_v->asc->vl;
				$ord_tot++;
			}

			$api_tot=0;

			foreach($__api->ls->api_thrd as $__api_k=>$__api_v){
				if(mBln($__api_v->login->vl) == 'ok'){
					$api[ $__api_v->enc ]['nm'] = $__api_v->tt;
					$api[ $__api_v->enc ]['enc'] = $__api_v->enc;
					$api[ $__api_v->enc ]['cls'] = $__api_v->cns;
					$api[ $__api_v->enc ]['img'] = $__api_v->img;
					$api_tot++;
				}
			}


			$r['e'] = 'ok';

			$r['data']['id'] = $this->_cl_d->enc;
			$r['data']['name'] = $this->_cl_d->nm;
			$r['data']['subdomain'] = $this->_cl_d->sbd;
			$r['data']['assets']['logo'] = $this->_cl_d->lgo;
			$r['data']['assets']['back'] = $this->_cl_d->bck;
			$r['data']['assets']['anm']['ls'] = $anm;
			$r['data']['assets']['anm']['tot'] = $anm_tot;

			$r['data']['fonts'] = __font();

			$r['data']['login']['opt'] = $api;

			$r['data']['tasks']['tags']['ls'] = $tag;
			$r['data']['tasks']['tags']['tot'] = $tag_tot;
			$r['data']['tasks']['ord']['ls'] = $ord;
			$r['data']['tasks']['ord']['tot'] = $ord_tot;

			if(!Dvlpr()){
				$r['data']['dvlpr'] = 'no';
			}else{
				$r['data']['dvlpr'] = 'ok';
			}



			$__cl_tag = $this->_cl_d->tag;
			$__cl_clr = $__cl_tag->clr;
			$__cl_lgin = $__cl_tag->login;
			$__cl_menu = $__cl_tag->menu;
			$__cl_lnks = $__cl_tag->lnk;

			$__rsllr_tag = $__dt_cl->rsllr->tag;
			$__rsllr_lgin = $__rsllr_tag->login;


			if(!isN($__cl_lnks->rcvr->v)){ $r['data']['links']['recover'] = $__cl_lnks->rcvr->v; }

			if(!isN($__cl_clr->main->v)){ $__root_v .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__root_v .= ' --main-bg-color:#4f006f;'; }
			if(!isN($__cl_clr->second->v)){ $__root_v .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__root_v .= ' --second-bg-color:#de86d4; '; }
			if(!isN($__cl_clr->login->v)){ $__root_v .= ' --login-bg-color: '.$__cl_clr->login->v.'; '; }
			if(!isN($__cl_clr->menu->v)){ $__root_v .= ' --menu-bg-color: '.$__cl_clr->menu->v.'; '; }else{ $__root_v .= ' --menu-bg-color:#0b0b0b; '; }
			if(!isN($__cl_clr->menu_h->v)){ $__root_v .= ' --menuh-bg-color: '.$__cl_clr->menu_h->v.'; '; }
			if(!isN($__cl_clr->menu_s->v)){ $__root_v .= ' --menus-bg-color: '.$__cl_clr->menu_s->v.'; '; }
			if(!isN($__cl_clr->{'dvlpr-tab'}->v)){ $__root_v .= ' --dvlprtab-bg-color: '.$__cl_clr->{'dvlpr-tab'}->v.'; '; }else{ $__root_v .= ' --dvlprtab-bg-color: #0CF'; }

			if(!isN($__cl_clr->placeholder->v)){ $__root_v .= ' --placeholder-color: '.$__cl_clr->placeholder->v.'; '; }

			if(!isN($__cl_clr->tabs_back->v)){
				$__root_v .= ' --tabs-bg-color: '.$__cl_clr->tabs_back->v.'; ';
			}else{
				$__root_v .= ' --tabs-bg-color: #d0f6ff; ';
			}

			if(!isN($__cl_lgin->{'login-logo-sze'}->v)){
				$__root_v .= ' --login-logo-size: '.$__cl_lgin->{'login-logo-sze'}->v.'; ';
			}else{
				$__root_v .= ' --login-logo-size: 70% auto; ';
			}

			if(!isN($__cl_lgin->{'login-logo-h'}->v)){
				$__root_v .= ' --login-logo-h: '.$__cl_lgin->{'login-logo-h'}->v.'; ';
			}else{
				$__root_v .= ' --login-logo-h:100px; ';
			}

			if(!isN($__cl_lgin->{'login-logo-btm'}->v)){
				$__root_v .= ' --login-logo-bottom: '.$__cl_lgin->{'login-logo-btm'}->v.'px; ';
			}else{
				$__root_v .= ' --login-logo-bottom: 60px; ';
			}

			if(!isN($__rsllr_lgin->{'login-reseller-logo-sze'}->v)){
				$__root_v .= ' --login-reseller-logo-sze: '.$__rsllr_lgin->{'login-reseller-logo-sze'}->v.'; ';
			}else{
				$__root_v .= ' --login-reseller-logo-sze: 100px auto; ';
			}

			if(!isN($__rsllr_lgin->{'login-reseller-logo-box-w'}->v)){
				$__root_v .= ' --login-reseller-logo-box-w: '.$__rsllr_lgin->{'login-reseller-logo-box-w'}->v.'; ';
			}else{
				$__root_v .= ' --login-reseller-logo-box-w: 120px;';
			}

			if(!isN($__cl_menu->{'menu-logo-sze'}->v)){
				$__root_v .= ' --menu-logo-sze: '.$__cl_menu->{'menu-logo-sze'}->v.'; ';
			}else{
				$__root_v .= ' --menu-logo-sze:100% 100%; ';
			}

			if(!isN($__cl_menu->{'menu-logo-pst'}->v)){
				$__root_v .= ' --menu-logo-pst: '.$__cl_menu->{'menu-logo-pst'}->v.'; ';
			}else{
				$__root_v .= ' --menu-logo-pst:center center; ';
			}

			$r['css'] = ':root {'.$__root_v.'}';

		}

		return _jEnc( $r );

	}


	function sve_json(){

		$__json = $this->bld_json();

		if(!isN( $this->_cl_d->id )){

			$_json = 'sumrJson('.cmpr_fm( json_encode( $__json->data ) ).')';
			$_css = cmpr_css( $__json->css );

			$_r['data']['json'] = $__json->data;

			$_r['s']['json'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'cl/'.$this->_cl_d->enc.'.json', 'cbdy'=>$_json, 'ctp'=>'application/json', 'cfr'=>'ok' ]);
			$_r['s']['css'] = $_sve_css = $this->_aws->_s3_put([ 'b'=>'css', 'fle'=>'cl/'.$this->_cl_d->enc.'.css', 'cbdy'=>$_css, 'ctp'=>'text/css', 'cfr'=>'ok' ]);

			if($_sve_json->e == 'ok' && $_sve_css->e == 'ok'){
				$_r['e'] = 'ok';
			}
		}

		return _jEnc($_r);

	}

	public function UsEst_Upd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->id_us)){

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_est = %s WHERE id_us = %s",
									GtSQLVlStr($this->us_est, "int"),
									GtSQLVlStr($this->id_us, "int"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

		}

		return _jEnc($rsp);

	}


}
?>