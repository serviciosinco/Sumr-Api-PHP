<?php

	function GtUsRolDt($_p){
		if(!isN($_p)){

			if($_p['ldr'] == 1){ $_r[] = TX_LDR; }
			if($_p['col'] == 1){ $_r[] = TX_CLBRDR; }
			if($_p['eje'] == 1){ $_r[] = TX_EJCTR; }
			if($_p['aud'] == 1){ $_r[] = TX_ADTR; }

			$rtrn = implode(',', $_r);
			return($rtrn);
		}
	}

	function GtLsUsAll(){

		global $__cnx;

            $Ls_Qry = "	SELECT *
            			FROM "._BdStr(DBM).TB_US."
            				 INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us
            				 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
            			WHERE id_us != '' AND cl_enc = '".DB_CL_ENC."' $_f
            			ORDER BY us_nm ASC";

            $DtRg = $__cnx->_qry($Ls_Qry);

            if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					do{

						$__id = $row_DtRg['id_us'];
						$Vl['ls'][$__id]['id'] = $row_DtRg['id_us'];
						$Vl['ls'][$__id]['nm'] = ctjTx($row_DtRg['us_nm'],'out');
					    $Vl['ls'][$__id]['user'] = ctjTx($row_DtRg['us_user'],'out');
						$Vl['ls'][$__id]['gnr'] = ctjTx($row_DtRg['us_gnr'],'in');

						if( !isN($row_DtRg['us_img']) ){

							$Vl['ls'][$__id]['img'] = _ImVrs(['img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

						}else{

							$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
							$Vl['ls'][$__id]['img']['sm_s'] = $_img;

						}

					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			$__cnx->_clsr($DtRg);

			}

            return(_jEnc($Vl));

    }

	function LsGrpUs($p=NULL){

		global $__cnx;


		if( !isN($p['cl']) ){ $_cl = $p['cl']."."; } /* Cliente de la conexion */

		if( !isN($p["us"]) ){
			$__fl .= " AND clgrpus_us = ".$p["us"]." ";
			$_a_i = "clgrpus_us";
		}else{
			$_a_i = "id_clgrpus";
		}

		$query_LsFld = " SELECT * FROM  "._BdStr(DBM).TB_CL_GRP_US."
								INNER JOIN  ".$_cl."".TB_MDL_GRP." ON mdlgrp_clgrp = clgrpus_clgrp
								WHERE id_clgrpus != ''
								$__fl ";
		$LsFld = $__cnx->_qry($query_LsFld);

		if($LsFld){

			$row_LsFld = $LsFld->fetch_assoc();
			$Tot_LsFld = $LsFld->num_rows;

			if($Tot_LsFld > 0){
				$Vl_Fld["e"] = "ok";

				$_mdl = [];

				do{
					array_push($_mdl, $row_LsFld['mdlgrp_mdl']);
					$Vl_Fld[$row_LsFld[$_a_i]]['mdl'] = $_mdl; /* Modulos relacionados al grupo */

				} while ($row_LsFld = $LsFld->fetch_assoc());
			}else{
				$Vl_Fld["e"] = "no";
			}
		}


		$__cnx->_clsr($LsFld);

		return _jEnc($Vl_Fld);

	}

	function GtUsDvcLs($p = NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p["us"])){

			if($p['t'] == 'enc'){
				$__f = 'us_enc'; $__ft = 'text';
			}else{
				$__f = 'id_us'; $__ft = 'int';
			}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_US_SES.'
										 INNER JOIN '._BdStr(DBM).TB_US_DVC.' ON uses_dvc = id_usdvc
								   		 INNER JOIN '._BdStr(DBM).TB_US.' ON usdvc_us = id_us
								   	WHERE '.$__f.' = %s ', GtSQLVlStr($p['us'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						$Vl['ls'][$row_DtRg['usdvc_enc']]['us'] = $row_DtRg['id_us'];
						$Vl['ls'][$row_DtRg['usdvc_enc']]['enc'] = ctjTx($row_DtRg['usdvc_enc'],'in');
						$Vl['ls'][$row_DtRg['usdvc_enc']]['ses']['id'] = ctjTx($row_DtRg['id_uses'],'in');
						$Vl['ls'][$row_DtRg['usdvc_enc']]['ses']['enc'] = ctjTx($row_DtRg['uses_enc'],'in');
						$Vl['ls'][$row_DtRg['usdvc_enc']]['aws']['id'] = ctjTx($row_DtRg['usdvc_aws_id'],'in');
						$Vl['ls'][$row_DtRg['usdvc_enc']]['web'] = mBln($row_DtRg['usdvc_web']);
						$Vl['ls'][$row_DtRg['usdvc_enc']]['android'] = mBln($row_DtRg['usdvc_android']);
						$Vl['ls'][$row_DtRg['usdvc_enc']]['ios'] = mBln($row_DtRg['usdvc_ios']);


					} while ($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['e'] = "no";
				}

			}

		}

		$__cnx->_clsr($DtRg);


		return(_jEnc($Vl));

	}









	function GtUsDvcDt($p = NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p["id"])){

			if($p['t'] == 'enc'){
				$__f = 'usdvc_enc'; $__ft = 'text';
			}elseif($p['t'] == 'ses'){
				$__f = 'uses_enc'; $__ft = 'text';
			}else{
				$__f = 'id_usdvc'; $__ft = 'int';
			}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_US_DVC.'
										  INNER JOIN '._BdStr(DBM).TB_US_SES.' ON uses_dvc = id_usdvc
								   		  INNER JOIN '._BdStr(DBM).TB_US.' ON usdvc_us = id_us
								   	WHERE '.$__f.' = %s
								   	LIMIT 1', GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';

				if($Tot_DtRg > 0){

                	$Vl['id'] = $row_DtRg['id_usdvc'];
					$Vl['us']['id'] = $row_DtRg['id_us'];
					$Vl['enc'] = ctjTx($row_DtRg['usdvc_enc'],'in');
					$Vl['ses']['id'] = ctjTx($row_DtRg['usdvc_enc'],'in');
					$Vl['ses']['enc'] = ctjTx($row_DtRg['usdvc_enc'],'in');
					$Vl['aws']['id'] = ctjTx($row_DtRg['usdvc_aws_id'],'in');
					$Vl['web'] = mBln($row_DtRg['usdvc_web']);
					$Vl['android'] = mBln($row_DtRg['usdvc_android']);
					$Vl['ios'] = mBln($row_DtRg['usdvc_ios']);

					if($Vl['ios'] == 'ok'){
						$Vl['ptfm'] = 'ios';
					}elseif($Vl['android'] == 'ok'){
						$Vl['ptfm'] = 'android';
					}

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtUsDt($Id, $Tp=NULL, $p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($Id)){

			if($Tp == 'enc'){
				$__f = 'us_enc'; $__ft = 'text';
			}elseif($Tp == 'usr'){
				$__f = 'us_user'; $__ft = 'text';
			}elseif($Tp == 'msv_usr'){
				$__f = 'us_msv_user'; $__ft = 'text';
			}elseif($Tp == 'chk_tck'){
				$__f = 'us_chk_tck'; $__ft = 'int';
			}elseif($Tp == 'chk_obs'){
				$__f = 'us_chk_obs'; $__ft = 'int';
			}else{
				$__f = 'id_us'; $__ft = 'int';
			}

			if(!isN($p['pass']) && !isN($p['pass'])){
				$__fl .= " AND us_pass = ".GtSQLVlStr($p['pass'], 'text')." ";
			}

			if($p['cl_no']!='ok'){

				$_slc = ', id_cl';
				$_innr = '	INNER JOIN '._BdStr(DBM).TB_US_CL.' ON uscl_us = id_us
							INNER JOIN '._BdStr(DBM).TB_CL.' ON uscl_cl = id_cl';

				$_grpby = ' GROUP BY uscl_cl ';
				$_orderby = ' ORDER BY cl_nm ASC ';

				if(isN($p['all'])){
					$__fl .= " AND cl_on = 1 ";
				}

			}

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

			$query_DtRg = sprintf('SELECT id_us, us_enc, us_user, us_nm, us_ap, us_img, us_fn, us_nivel, us_ntf, id_cl, us_est, usest_clr
								   FROM '._BdStr(DBM).TB_US.'
								   		INNER JOIN '._BdStr(DBM).TB_US_CL.' ON uscl_us = id_us
										INNER JOIN '._BdStr(DBM).TB_CL.' ON uscl_cl = id_cl
										INNER JOIN '._BdStr(DBM).TB_US_EST.' ON us_est = id_usest
								   WHERE '.$__f.' = %s AND cl_on = 1 '.$__fl.'
								   GROUP BY uscl_cl
								   ORDER BY cl_nm ASC', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$cl = [];

					do{

						$Vl['tot'] = $Tot_DtRg;
						$Vl['id'] = $row_DtRg['id_us'];
						$Vl['nm'] = ctjTx($row_DtRg['us_nm'],'in');
						$Vl['ap'] = ctjTx($row_DtRg['us_ap'],'in');
						$Vl['enc'] = ctjTx($row_DtRg['us_enc'],'in');
						$Vl['img_nm'] = ctjTx($row_DtRg['us_img'],'in');
						$Vl['fn'] = $row_DtRg['us_fn'];
						$Vl['lvl'] = $row_DtRg['us_nivel'];
						$Vl['ntf'] = mBln($row_DtRg['us_ntf']);
						$Vl['est'] = mBln($row_DtRg['us_est']);
						$Vl['est_clr'] = $row_DtRg['usest_clr'];

						$Vl['nm_fll'] = ctjTx($row_DtRg['us_nm'].' '.$row_DtRg['us_ap'],'in');
						if($p['prvt']!='ok'){ $Vl['eml'] = ctjTx($row_DtRg['us_user'],'in'); }

						if($p['cl_no']!='ok'){
							$_ob = GtClDt($row_DtRg['id_cl'],'',[ 'dtl'=>$p['cl_dtl'] ]);
							array_push($cl, $_ob);
						}

						$Vl['cl']['tot']++;

						if($row_DtRg['us_gnr'] == _CId('ID_SX_H')){
							$Vl['gnr'] = 'm';
						}elseif($row_DtRg['us_gnr'] == _CId('ID_SX_M')){
							$Vl['gnr'] = 'w';
						}else{
							$Vl['gnr'] = 'n';
						}

						if($p['prvt']!='ok'){ $Vl['e'] = "ok"; }
						if($p['prvt']!='ok'){ $Vl['mdl'] = $__sisusmdl->mdl; }

						$Vl['img'] = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);

						$Vl['msv_usr'] = ctjTx($row_DtRg['us_msv_user'],'in');

						//$Vl['sgn'] = GtUsSgn( array( 'b'=>ctjTx($row_DtRg['us_frm'],'in'), 'i'=>$Vl['img']->th_c_100p ));

					} while ($row_DtRg = $DtRg->fetch_assoc());


					$Vl['cl']['ls'] = $cl;

				}else{

					if(Dvlpr() || isWrkr()){ $Vl['q'] = $query_DtRg; }
					$Vl['e'] = "no";

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = "No id for query";

		}

		return(_jEnc($Vl));
	}



	function GtUsTknDt($p=NULL){

		global $__cnx;

		if(!isN($p["enc"])){ $_fl .= "AND ustkn_enc = '".$p["enc"]."' "; }

		$query_DtRg = sprintf('	SELECT *
								FROM '._BdStr(DBM).TB_US_TKN.'
									 INNER JOIN '._BdStr(DBM).TB_CL.' ON ustkn_cl = id_cl
									 INNER JOIN '._BdStr(DBM).TB_US.' ON ustkn_us = id_us
								WHERE id_ustkn != "" '.$_fl);

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['id'] = $row_DtRg['id_ustkn'];
			$Vl['enc'] = ctjTx($row_DtRg['ustkn_enc'],'in');
			$Vl['tt'] = ctjTx($row_DtRg['ustkn_tt'],'in');

			$Vl['us']['id'] = ctjTx($row_DtRg['id_us'],'in');
			$Vl['us']['user'] = ctjTx($row_DtRg['us_user'],'in');

			$Vl['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
			$Vl['cl']['prfl'] = ctjTx($row_DtRg['cl_prfl'],'in');

			$Vl['key'] = ctjTx($row_DtRg['ustkn_key'],'in');
			$Vl['pass'] = ctjTx($row_DtRg['ustkn_pass'],'in');

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}



	function GtUsTelDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).MDL_US_TEL_BD." WHERE id_ustel = %s", GtSQLVlStr($_p['id'], 'int'));
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_ustel'];
						$Vl['tel'] = $row_DtRg['ustel_tel'];
						$Vl['ext'] = $row_DtRg['ustel_ext'];
						$Vl['telf'] = $row_DtRg['ustel_ps'].$row_DtRg['ustel_tel'];
						$Vl['telc'] = '+'.$row_DtRg['ustel_ps'].$row_DtRg['ustel_tel'];
						$Vl['us'] = GtUsDt($row_DtRg['ustel_us']);
						$Vl['est'] = mBln( $row_DtRg['ustel_est']);
					}else{
						$Vl['e'] = 'no';
					}

				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}
	}

	function GtUsTelLs($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).MDL_US_TEL_BD." WHERE ustel_us = %s", GtSQLVlStr($_p['id'], 'int'));
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					do{

						if($Tot_DtRg > 0){

							$__id = $row_DtRg['ustel_enc'];

							$Vl['e'] = 'ok';

							$Vl['ls'][$__id]['id'] = $row_DtRg['id_ustel'];
							$Vl['ls'][$__id]['enc'] = $__id;
							$Vl['ls'][$__id]['tel'] = $row_DtRg['ustel_tel'];
							$Vl['ls'][$__id]['ext'] = $row_DtRg['ustel_ext'];
							$Vl['ls'][$__id]['telf'] = $row_DtRg['ustel_ps'].$row_DtRg['ustel_tel'];
							$Vl['ls'][$__id]['telc'] = '+'.$row_DtRg['ustel_ps'].$row_DtRg['ustel_tel'];
							$Vl['ls'][$__id]['est'] = mBln( $row_DtRg['ustel_est']);

							$Vl['ls'][$__id]['ntf']['sms'] = mBln( $row_DtRg['ustel_ntf_sms']);
							$Vl['ls'][$__id]['ntf']['whtsp'] = mBln( $row_DtRg['ustel_ntf_wthsp']);


						}else{

							$Vl['e'] = 'no';

						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

				$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
			}
		}
	}

?>