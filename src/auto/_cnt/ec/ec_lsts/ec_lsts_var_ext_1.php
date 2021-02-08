<?php


	try {

		echo $this->h2('Lista: '.$___datprcs_v['id_eclsts'].' - '.ctjTx($___datprcs_v['eclsts_nm'],'in') );




		$Ls_Lsts_Var_Qry = " 	SELECT *
								FROM "._BdStr(DBM).TB_EC_LSTS_VAR."
									 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR." ON id_sisecsgmvar = eclstsvar_var
									 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM." ON sisecsgmvar_sgm = id_sisecsgm
									 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp
								WHERE eclstsvar_lsts = ".$___datprcs_v['id_eclsts']."
							";

		//if($___datprcs_v['id_eclsts'] == 282){
			//echo $this->li('Query'.compress_code( $Ls_Lsts_Var_Qry ));
		//}

		$Ls_Lsts_Var = $__cnx->_qry($Ls_Lsts_Var_Qry);

		if($Ls_Lsts_Var){

			$row_Ls_Lsts_Var = $Ls_Lsts_Var->fetch_assoc();
			$Tot_Ls_Lsts_Var = $Ls_Lsts_Var->num_rows;

			if($Tot_Ls_Lsts_Var > 0){

				$_count_opr = 1; //En el primer operador no pone AND ni OR

				do{

					if( !isN($row_Ls_Lsts_Var['sisecsgmvar_qry']) ){ //Valida si es AND o OR
						if($_count_opr > 1){
							$_opr = ( ($row_Ls_Lsts_Var['eclstsvar_opr'] == 1)? "AND" : "OR" );
						}
						$_count_opr++;
					}else{
						$_opr = '';
					}


					if(!isN($row_Ls_Lsts_Var['sisecsgmvar_qry'])){

						if($row_Ls_Lsts_Var['id_sisecsgmvartp'] == 9){
							$___vl_sqgtstr = $row_Ls_Lsts_Var['eclstsvar_vl'];
						}else{
							$___vl_sqgtstr = GtSQLVlStr($row_Ls_Lsts_Var['eclstsvar_vl'], $row_Ls_Lsts_Var['sisecsgmvartp_gts']);
						}

						$_rplc_vl = str_replace('[vl]', $___vl_sqgtstr, $_opr." ".$row_Ls_Lsts_Var['sisecsgmvar_qry']); //Remplaza los [vl] por valores

						if( !isN($row_Ls_Lsts_Var['eclstsvar_vl_sub']) ){
							$_rplc_vl = str_replace('[vl_sub]', GtSQLVlStr($row_Ls_Lsts_Var['eclstsvar_vl_sub'], "text"), $_rplc_vl); //Remplaza los [vl_sub] por valores
						}

						if($row_Ls_Lsts_Var['sisecsgmvar_key'] == "cty_lve" || $row_Ls_Lsts_Var['sisecsgmvar_key'] == "cty_nlve" || $row_Ls_Lsts_Var['sisecsgmvar_key'] == "cty_dp_lvez"){ //Remplaza los [cns] por costantes
							$___vl_str_cns = _CId('ID_TPRLCC_VVE');
						}else if($row_Ls_Lsts_Var['sisecsgmvar_key'] == "cty_nco"){
							$___vl_str_cns = _CId('ID_TPRLCC_NCO');
						}

						$_rplc_vl_2 = str_replace('[cns]', $___vl_str_cns, $_rplc_vl); //Remplaza los [cns] por costantes

						$_rplc_vl_f[] = str_replace('[cl]', $_cl_v->bd, $_rplc_vl_2);

					}

					//if($___datprcs_v['id_eclsts'] == 282){
						//echo $this->h3(' - Lista Variable: '.$_opr." ".$row_Ls_Lsts_Var['sisecsgmvar_qry'] );
					//}

				}while($row_Ls_Lsts_Var = $Ls_Lsts_Var->fetch_assoc());


				foreach($_rplc_vl_f as $_rplc_vl_f_As){
					$_rplc_vl_f_Qry = $_rplc_vl_f_Qry." ".$_rplc_vl_f_As;
				}


				$__fl_innr = "
					INNER JOIN "._BdStr($_cl_v->bd).TB_MDL." ON id_mdl = mdlcnt_mdl
					INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
					INNER JOIN "._BdStr($_cl_v->bd).TB_MDL_ARE." ON mdlare_mdl = mdlcnt_mdl
					LEFT JOIN "._BdStr($_cl_v->bd).TB_CNT_CD." ON cntcd_cnt = id_cnt
					LEFT JOIN "._BdStr($_cl_v->bd).TB_CNT_ATTR." ON cntattr_cnt = id_cnt
				";

				$Ls_Lsts_Eml_Qry = "
					SELECT
							id_cnteml,
							cnteml_eml,
							cnteml_cnt

					FROM "._BdStr($_cl_v->bd).TB_CNT_EML."
						 INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON id_cnt = cnteml_cnt
						 INNER JOIN "._BdStr($_cl_v->bd).TB_MDL_CNT." ON id_cnt = mdlcnt_cnt
						 {$__fl_innr}
					WHERE ( {$_rplc_vl_f_Qry} ) AND
							id_cnteml NOT IN (
								SELECT eclstseml_eml
								FROM "._BdStr($_cl_v->bd).TB_EC_LSTS_EML."
								WHERE eclstseml_lsts = ".$___datprcs_v['id_eclsts']."
							) GROUP BY id_cnteml
					ORDER BY cnteml_cnt ASC
					LIMIT 50
				";

				//echo $Ls_Lsts_Eml_Qry;

				//if($___datprcs_v['id_eclsts'] == 282){
					//echo $this->li('Query Email FoundIt with Var'.compress_code( $Ls_Lsts_Eml_Qry ));
				//}

				$Ls_Lsts_Eml = $__cnx->_qry($Ls_Lsts_Eml_Qry);

				if($Ls_Lsts_Eml){

					$row_Ls_Eml = $Ls_Lsts_Eml->fetch_assoc();
					$Tot_Ls_Eml = $Ls_Lsts_Eml->num_rows;

					//if($___datprcs_v['id_eclsts'] == 282){
						echo $this->li("Total de correos: ".$Tot_Ls_Eml);
					//}

					if($Tot_Ls_Eml > 0){

						do{

							if( !isN($row_Ls_Eml['cnteml_eml']) ){

								$__CntIn->bd = _BdStr($_cl_v->bd);
								$__CntIn->ec_lsts_id = $___datprcs_v['id_eclsts'];
								$__CntIn->ec_lsts_up = 3;
								$__CntIn->ec_lsts_up_col = NULL;
								$__CntIn->ec_lsts_bdt = NULL;
								$__CntIn->ec_lsts_bdt_2 = NULL;
								$__CntIn->eclstseml_tp = _CId('ID_TPRELLSTSEML_AUTO');

								$this->ec_lsts_id = $___datprcs_v['id_eclsts']; // Arregla Camilo, esta insertando aun si existe, toca validar previamente
								$___exist = $this->CntEcLsts_Chk([ 'bd'=>$_cl_v->bd, 'eml'=>$row_Ls_Eml['cnteml_eml'] ]);

								print_r($___exist);

								if($___exist->e != 'ok'){

									$__CntIn_Prc = $__CntIn->InCntLsts([ 'e'=>$row_Ls_Eml['id_cnteml'] ]);

									if($__CntIn_Prc->e == 'ok'){
										echo $this->scss($row_Ls_Eml['cnteml_cnt']."  ".$row_Ls_Eml['cnteml_eml']);
									}

								}
							}

						}while($row_Ls_Eml = $Ls_Lsts_Eml->fetch_assoc());

					}

				}else{
					echo $this->err( $__cnx->c_r->error );
				}

				$__cnx->_clsr($Ls_Lsts_Eml);

				//echo " ------------------------------------- <br> ";
			}

		}else{

			echo $this->err( $__cnx->c_r->error );

		}


		$__cnx->_clsr($Ls_Lsts_Var);

		$_rplc_vl_f_Qry = NULL;
		$_rplc_vl_f = NULL;
		$_opr = NULL;



	} catch (Exception $e) {

		$this->Rqu([ 't'=>'ec_lsts_var', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

	}


?>