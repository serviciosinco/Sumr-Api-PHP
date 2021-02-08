<?php

	include('../includes/incc.php');

	//---------------- SETUP - START ----------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';
		$_r['tp_v_e']='no';

		$__pm_1 = PrmLnk('rtn', 1, 'ok');

		$__p_sch = Php_Ls_Cln($_POST['sch']); //icon=true
		$__mdl = Php_Ls_Cln($_POST['mdl']);
		$__mdl_g_chk = Php_Ls_Cln($_POST['mdl_gen_chk']);
		$__tp = Php_Ls_Cln($_POST['tp']);
		$__tel = Php_Ls_Cln($_POST['tel']);
		$__eml = Php_Ls_Cln($_POST['eml']);
		$__cnt = Php_Ls_Cln($_POST['cnt']);

	//---------------- SETUP - END ----------------//



		if(!isN($__p_sch)){

			$__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);
			$__cnt = new CRM_Cnt([ 'cl'=>$__cl->id ]);
			$__cnt->cnt_dc = filter_var($__p_sch, FILTER_SANITIZE_STRING);
			$__gcnt = $__cnt->_Cnt();

			$CRM_Cnt = new CRM_Cnt();
			$CRM_Cnt->cnt_enc = NULL;

			if($__mdl_g_chk == "ok"){
				$_tp_v_ls = $CRM_Cnt->GtCntTpLs([ 'cl'=>$__cl->id, 'mdl_gen'=>$__mdl, 'bd'=>$__cl->bd ]);
			}else{
				$_tp_v_ls = $CRM_Cnt->GtCntTpLs([ 'cl'=>$__cl->id, 'mdl'=>$__mdl, 'bd'=>$__cl->bd ]);
			}

			$_r['tp_v_ls'] = $_tp_v_ls;

			if(!isN($__gcnt->i)){

				$__gcnt_dt = GtCntDt([  'bd'=>$__cl->bd.'.', 'id'=>$__gcnt->enc, 't'=>'enc', 'scre'=>'ok' ]);

				if(!isN($__gcnt_dt->id)){

					$CRM_Cnt->cnt_enc = $__gcnt_dt->enc;

					if($__mdl_g_chk == "ok"){ //Valída si el modulo es general

						$_tp_v_ls = $CRM_Cnt->GtCntTpLs([ 'cl'=>$__cl->id, 'mdl_gen'=>$__mdl, 'bd'=>$__cl->bd ]);
						$__dtmdl = GtChkMdlGenCntTpV([ 'bd'=>$__cl->bd, 'cnt'=>$__gcnt_dt->id, 'mdl'=>$__mdl ]);
						$_r['tp_v_e'] = $__dtmdl->e;

					}else{

						$_tp_v_ls = $CRM_Cnt->GtCntTpLs([ 'cl'=>$__cl->id, 'mdl'=>$__mdl, 'bd'=>$__cl->bd ]);
						$__dtmdl = GtChkMdlCntTpV([ 'bd'=>$__cl->bd, 'cnt'=>$__gcnt_dt->id, 'mdl'=>$__mdl ]);
						$_r['tp_v_e'] = $__dtmdl->e;

					}

					$_r['tp_v_ls'] = $_tp_v_ls;

					$_r['e'] = 'ok';

					$_r['cnt'] = [
						'enc'=>$__gcnt_dt->enc,
						'nm'=>$__gcnt_dt->nm,
						'ap'=>$__gcnt_dt->ap,
						'sndi'=>$__gcnt_dt->sndi,
						'tot'=>[
							'eml'=>count($__gcnt_dt->eml_c),
							'tel'=>count($__gcnt_dt->tel_c)
						],
						'tel'=>$__gcnt_dt->tel,
						'eml'=>$__gcnt_dt->eml
					];

				}else{

					$_r['e'] = 'no_exist';

				}

			}else{
				$_r['e'] = 'no';
			}

		}elseif(!isN($__tel) && $__tp == "_new_tel"){

			global $__cnx;

			$__gcnt_dt = GtCntDt([  'bd'=>$__cl->bd.'.', 'id'=>$__cnt, 't'=>'enc' ]);
			$__dttel = _ChckCntTel([ 'id'=>$__tel, 'cnt'=>$_POST['cnttel_cnt'] ]);
			$__enc = Enc_Rnd($__tel.'-'.$__mdl);

			if($__dttel->e == 'ok' && isN($__dttel->id)){
				$insertSQL = sprintf("INSERT INTO ".$__cl->bd.".".TB_CNT_TEL." (cnttel_enc, cnttel_tel, cnttel_cnt) VALUES (%s, %s, %s)",
		                       GtSQLVlStr($__enc, "text"),
		                       GtSQLVlStr(ctjTx($__tel,'out'), "text"),
							   GtSQLVlStr($__gcnt_dt->id, "int"));

				$Result = $__cnx->_prc($insertSQL);

				if($Result){
			 		$_r['e'] = 'ok';
				}else{
					$_r['e'] = 'no';
					$_r['m'] = 2;
				}
			}else{
				$_r['e'] = 'no';
				$_r['w'] = 'Este número ya existe en el sistema';
			}

			$__cnx->_clsr($Result);

		}elseif(!isN($__eml) && $__tp == "_new_eml"){

			global $__cnx;

			$__gcnt_dt = GtCntDt([  'bd'=>$__cl->bd.'.', 'id'=>$__cnt, 't'=>'enc' ]);
			$__dteml = _ChckCntEml([ 'id'=>$__eml ]);
			$__enc = Enc_Rnd($__eml.'-'.$__mdl);

			if($__dteml->e == 'no'){

				$insertSQL = sprintf("INSERT INTO ".$__cl->bd.".".TB_CNT_EML." (cnteml_enc, cnteml_eml, cnteml_tp, cnteml_cnt, cnteml_cld, cnteml_est) VALUES (%s, %s, %s, %s, %s, %s)",
		                       GtSQLVlStr($__enc, "text"),
		                       GtSQLVlStr(ctjTx($__eml,'out'), "text"),
							   GtSQLVlStr($__dteml->chk->tp, "int"),
							   GtSQLVlStr($__gcnt_dt->id, "int"),
							   GtSQLVlStr(_CId('ID_CLD_RGLR'), "int"),
							   GtSQLVlStr(_CId('ID_SISEMLEST_NOCHCK'), "int"));

				$Result = $__cnx->_prc($insertSQL);

				if($Result){
			 		$_r['e'] = 'ok';
				}else{
					$_r['e'] = 'no';
					$_r['m'] = 2;
				}

				$__cnx->_clsr($Result);

			}else{
				$_r['e'] = 'no';
				$_r['w'] = 'Este correo ya existe en el sistema';
			}

		}else{

			$_r['e'] = 'no_data';

		}


	//-------------- PRINT RESULTS --------------//


	if(!isN($_r)){ echo json_encode($_r); }else{  }
	ob_end_flush();


?>