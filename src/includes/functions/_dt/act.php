<?php

	function GtActDt($p=NULL){

		global $__cnx;

		if( $p['tp']=="enc"){ $_fl = " AND act_enc = '".$p['id']."' "; }else{ $_fl = " AND id_act = ".$p['id']." "; }
		if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }else{ $_bd = DB_CL; }

		$Dt_Qry = "	SELECT *,
							"._QrySisSlcF([ 'als'=>'l', 'als_n'=>'lugar' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'lugar', 'als'=>'l' ])."
					FROM "._BdStr(DBM).TB_ACT."
						 INNER JOIN "._BdStr(DBM).MDL_SIS_CD_BD." ON (id_siscd = act_cd)
						 INNER JOIN "._BdStr(DBM).TB_US." ON (id_us = act_us)
						 INNER JOIN "._BdStr(DBM).TB_CL." ON (act_cl = id_cl)
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'act_lgr', 'als'=>'l', 'l'=>'ok' ])."

						 LEFT JOIN "._BdStr(DBM).TB_SIS_MD." ON act_md = id_sismd
						 LEFT JOIN "._BdStr(DBM).TB_SIS_FNT." ON act_fnt = id_sisfnt

				   WHERE id_act != '' $_fl ";

		$Ls_Rg = $__cnx->_qry($Dt_Qry);

		if($Ls_Rg){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			if($Tot_Ls_Rg > 0){

				$_Dt_Tme = new DateTime ($row_Ls['act_fi']);

				$Vl['id'] = $row_Ls_Rg['id_act'];

				$Vl['enc'] = ctjTx($row_Ls_Rg['act_enc'], 'in');

				$Vl['cl']['id'] = ctjTx($row_Ls_Rg['act_cl'], 'in');
				$Vl['cl']['bd'] = DB_PRFX_CL.ctjTx($row_Ls_Rg['cl_sbd'],'in');
				$Vl['cl']['prfl'] = ctjTx($row_Ls_Rg['cl_prfl'], 'in');

				$Vl['tt'] = ctjTx($row_Ls_Rg['act_tt'].' - '.$row_Ls_Rg['act_fi'],'in');

				$Vl['tts'] = ctjTx($row_Ls_Rg['act_tt'],'in');

				$Vl['pml'] = ctjTx($row_Ls_Rg['act_pml'],'in');

				if(!isN($row_Ls['act_fi'])){
					$Vl['fi'] = FechaESP_OLD($row_Ls['act_fi']);
				}

				if(!isN($row_Ls['act_fn'])){
					$Vl['fn'] = FechaESP_OLD($row_Ls['act_fn']);
				}

				$Vl['h'] = $_Dt_Tme->format('h:i a');
				$Vl['cd'] = ctjTx($row_Ls_Rg['siscd_tt'],'in');
				$Vl['cod'] = ctjTx($row_Ls_Rg['act_cod'],'in');
				$Vl['cnt'] = ctjTx($row_Ls_Rg['us_nm'].' '. $row_Ls_Rg['us_ap'], 'in');

				$Vl['lgr']['id'] = ctjTx($row_Ls_Rg['act_lgr'], 'in');
				$Vl['lgr']['tt'] = ctjTx($row_Ls_Rg['lugar_sisslc_tt'], 'in');


				$Vl['fnt']['id'] = ctjTx($row_Ls_Rg['act_fnt'], 'in');
				$Vl['fnt']['enc'] = ctjTx($row_Ls_Rg['sisfnt_enc'], 'in');

				$Vl['md']['id'] = ctjTx($row_Ls_Rg['act_md'], 'in');
				$Vl['md']['enc'] = ctjTx($row_Ls_Rg['sismd_enc'], 'in');

				$Vl['mdlgen'] = GtMdlGenDt([ 'id'=>$row_Ls_Rg['act_mdlgen'], 'bd'=>$Vl['cl']['bd'] ]);

				$Vl['img'] = _ImVrs(['img'=>$row_Ls_Rg['act_img'], 'f'=>DMN_FLE_ACT ]);

				$Vl['dsc'] = ctjTx($row_Ls_Rg['act_dsc'], 'in');

				$Vl['tot'] = ctjTx($row_Ls_Rg['act_estd_tot'], 'in');
				$Vl['totA'] = ctjTx($row_Ls_Rg['act_acmp_tot'], 'in');

				$Vl['lgr'] = ctjTx($row_Ls_Rg['actlgr_tt'], 'in');
				$Vl['fctx'] = ctjTx($row_Ls_Rg['act_fctx'], 'in');
				$Vl['lgrtx'] = ctjTx($row_Ls_Rg['act_lgrtx'], 'in');

				$Vl['org'] = GtOrgSdsActLs([ 'tp'=>'enc', 'id'=>$row_Ls_Rg['act_enc'], 'bd'=>$_bd ]);

	        }

		}else{

			if(Dvlpr()){
				$Vl['w'][] = compress_code($Dt_Qry);
				$Vl['w'][] = $__cnx->c_r->error;
			}

		}

		$__cnx->_clsr($Ls_Rg);

		return(_jEnc($Vl));;
	}

	function GtOrgSdsActLs($p=NULL){

		global $__cnx;

		if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

		if($p['tp'] == 'enc'){ $_fl .= "AND act_enc = '".$p['id']."'"; }
		else{ $_fl .= "AND id_act = ".$p['id']." "; }

		$query_DtRg = sprintf('	SELECT orgsds_enc
								FROM '._BdStr(DBM).TB_ORG_SDS_ACT.'
									 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON id_orgsds = orgsdsact_orgsds
									 INNER JOIN '._BdStr(DBM).TB_ACT.' ON id_act = orgsdsact_act
								WHERE id_act != "" '.$_fl.'
								ORDER BY id_act ASC');

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['tot'] = $DtRg->num_rows;

				if($Vl['tot'] > 0){

					do{

						$ido=$row_DtRg['orgsds_enc'];
						$Vl['ls'][$ido] = GtOrgSdsDt([ 't'=>'enc', 'i'=>$ido, 'bd'=>$_bd ]);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}


	function GtActGrdLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['act'])){


			$Ls_Qry = "	SELECT id_sisslc, actgrd_enc, sisslc_tt
						FROM "._BdStr(DBM).TB_ACT."
							INNER JOIN "._BdStr(DBM).TB_ACT_GRD." ON actgrd_act = id_act
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON actgrd_grd = id_sisslc
						WHERE id_act != '' AND act_enc = '".$_p['act']."'
						ORDER BY sisslc_tt ASC";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Vl['tot'] = $Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){
					do {
						$ido=$row_Ls['actgrd_enc'];
						$Vl['ls'][$ido]['id'] = $row_Ls['id_sisslc'];
						$Vl['ls'][$ido]['tt'] = ctjTx($row_Ls['sisslc_tt'], 'in');
					} while ($row_Ls = $Ls->fetch_assoc());
				}

			}

			$__cnx->_clsr($Ls);

		}

		return(_jEnc($Vl));

	}


	function GtActGenGrdLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['mdlgen'])){

			$Ls_Qry = "	SELECT id_sisslc, mdlgengrd_enc, sisslc_tt
						FROM "._BdStr($_p['bd']).TB_MDL_GEN."
							INNER JOIN "._BdStr($_p['bd']).TB_MDL_GEN_GRD." ON mdlgengrd_mdlgen = id_mdlgen
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlgengrd_grd = id_sisslc
						WHERE mdlgen_enc = '".$_p['mdlgen']."'
						ORDER BY sisslc_tt ASC";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Vl['tot'] = $Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){
					do {
						$ido=$row_Ls['mdlgengrd_enc'];
						$Vl['ls'][$ido]['id'] = $row_Ls['id_sisslc'];
						$Vl['ls'][$ido]['tt'] = ctjTx($row_Ls['sisslc_tt'], 'in');
					} while ($row_Ls = $Ls->fetch_assoc());
				}

			}

			$__cnx->_clsr($Ls);

		}

		return(_jEnc($Vl));

	}


?>