<?php

	//---------------- SETUP - START ----------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';
		$_r['tp_v_e']='no';

		$__pm_1 = PrmLnk('rtn', 1, 'ok');

		$__p_sch = Php_Ls_Cln($_POST['sch']); //icon=true
		$__mdl = Php_Ls_Cln($_POST['mdl']);
		$__mdl_g_chk = Php_Ls_Cln($_POST['mdl_gen_chk']);


	//---------------- SETUP - END ----------------//



		if(!isN($__p_sch)){

			$__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);
			$__cnt = new CRM_Cnt([ 'cl'=>$__cl->id ]);
			$__cnt->cnt_dc = filter_var($__p_sch, FILTER_SANITIZE_STRING);
			$__gcnt = $__cnt->_Cnt();


			if(!isN($__gcnt->i)){

				$__gcnt_dt = GtCntDt([  'bd'=>$__cl->bd.'.', 'id'=>$__gcnt->enc, 't'=>'enc' ]);

				if(!isN($__gcnt_dt->id)){

					if($__mdl_g_chk == "ok"){ //Valída si el modulo es general

						$CRM_Cnt = new CRM_Cnt();
						$CRM_Cnt->cnt_enc = $__gcnt_dt->enc;
						$_tp_v_ls = $CRM_Cnt->GtCntTpLs([ 'cl'=>$__cl->id, 'mdl_gen'=>$__mdl, 'bd'=>$__cl->bd ]);

						$__dtmdl = GtChkMdlGenCntTpV([ 'bd'=>$__cl->bd, 'cnt'=>$__gcnt_dt->id, 'mdl'=>$__mdl ]);
						$_r['tp_v_e'] = $__dtmdl->e;
						$_r['tp_v_ls'] = $_tp_v_ls;

					}else{
						$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$__mdl_enc ]);
					}

					$_r['e'] = 'ok';

					$_r['cnt'] = [
						'enc'=>$__gcnt_dt->enc,
						'nm'=>$__gcnt_dt->nm,
						'ap'=>$__gcnt_dt->ap,
						'sndi'=>$__gcnt_dt->sndi,
						'tot'=>[
							'eml'=>count($__gcnt_dt->eml_c),
							'tel'=>count($__gcnt_dt->tel_c)
						]
					];

				}else{

					$_r['e'] = 'no_exist';

				}

			}

		}else{

			$_r['e'] = 'no_data';

		}


	//-------------- PRINT RESULTS --------------//


	if(!isN($_r)){ echo json_encode($_r); }else{  }
	ob_end_flush();


?>