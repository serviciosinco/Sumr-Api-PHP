<?php


	try {


		//------- Set Main Vars or Reset -------//



		//------- Start Process -------//


			if(!isN($qry_sgm)){


				$LstsSgmEmlQry = sprintf("

										SELECT
												id_eclstseml,
												eclstseml_eml,
												id_cnteml,
												cntemlplcy_cnteml,
												id_cnteml,
												cnteml_enc,
												cnteml_eml,
												cnteml_cnt,
												id_cnt,
												cnt_nm,
												cnt_ap,
												cnt_test,
												cntplcy_cnt,
												cntemlplcy_plcy,
												id_clplcy,
												eclstsplcy_eclsts,
												eclstseml_lsts,
												clplcy_e,
												cntplcy_plcy,
												cntplcy_sndi,
												cntemlplcy_sndi,
												cnteml_rjct,
												cnteml_est

								   		FROM "._BdStr($_cl_v->bd).TB_EC_LSTS_EML."
								   			INNER JOIN "._BdStr($_cl_v->bd).TB_CNT_EML." ON eclstseml_eml = id_cnteml
								   			INNER JOIN "._BdStr($_cl_v->bd).TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
								   			INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON cnteml_cnt = id_cnt
								   			INNER JOIN "._BdStr($_cl_v->bd).TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
								   			INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
								   			INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = eclstseml_lsts

								   			INNER JOIN "._BdStr($_cl_v->bd).TB_MDL_CNT." ON mdlcnt_cnt = id_cnt
											INNER JOIN "._BdStr($_cl_v->bd).TB_MDL." ON id_mdl = mdlcnt_mdl
											INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
											INNER JOIN "._BdStr($_cl_v->bd).TB_MDL_ARE." ON mdlare_mdl = mdlcnt_mdl
											LEFT JOIN "._BdStr($_cl_v->bd).TB_CNT_CD." ON cntcd_cnt = id_cnt
											LEFT JOIN "._BdStr($_cl_v->bd).TB_CNT_ATTR." ON cntattr_cnt = id_cnt

								   		WHERE eclstseml_lsts=%s AND
								   			  clplcy_e = 1 AND
								   			  cntplcy_sndi = 1 AND
								   			  cntemlplcy_sndi = 1 AND
								   			  cnteml_rjct=2 AND
								   			  cnteml_est="._CId('ID_SISEMLEST_ACT')." AND

								   			  NOT EXISTS (
									   			  SELECT eclstsemlsgm_eml
									   			  FROM "._BdStr($_cl_v->bd).TB_EC_LSTS_EML_SGM."
									   			  WHERE eclstsemlsgm_eml = id_cnteml AND eclstsemlsgm_lstssgm=%s
								   			  )

								   			  {$qry_sgm}

										GROUP BY id_eclstseml
										LIMIT 50

								   	",
								   	GtSQLVlStr($___datprcs_v['id_eclsts'], 'int'),
								   	GtSQLVlStr($___datprcs_v['id_eclstssgm'], 'int'));

				$LstsSgmEmlQry_Go = str_replace('[pcnt]', '%', $LstsSgmEmlQry);
				$LstsSgmEml = $__cnx->_qry($LstsSgmEmlQry_Go, ['cmps'=>'ok']);

				//echo $this->h2('Query search emails to match');
				//echo $this->li( compress_code($LstsSgmEmlQry_Go) );

				if($LstsSgmEml){

					$rwLstsSgmEml = $LstsSgmEml->fetch_assoc();
					$TotLstsSgmEml = $LstsSgmEml->num_rows;

					echo $this->h2('Total de Leads '.$this->Spn($TotLstsSgmEml) );

					if($TotLstsSgmEml > 0){

						do{

							$__CntIn->bd = _BdStr($_cl_v->bd);
							$__CntIn->ec_lstssgm_id = $___datprcs_v['id_eclstssgm'];
							$__CntIn->ec_lstssgm_eml = $rwLstsSgmEml['id_cnteml'];
							$___exist = $this->EcLstsEmlSgm_Chk([ 'bd'=>$_cl_v->bd, 'sgm'=>$__CntIn->ec_lstssgm_id, 'eml'=>$__CntIn->ec_lstssgm_eml ]);

							if($___exist->e != 'ok'){

								$__CntIn_Prc = $__CntIn->InEcLstsEmlSgm();

								if($__CntIn_Prc->e == 'ok'){
									echo $this->scss('Saved '.$rwLstsSgmEml['id_cnteml'].' with segment '.$___datprcs_v['id_eclstssgm'] );
								}else{
									echo $this->err('Not saved');
								}

							}

						} while ($rwLstsSgmEml = $LstsSgmEml->fetch_assoc());

					}

				}else{

					echo $this->err($__cnx->c_r->error);

				}


				$__cnx->_clsr($LstsSgmEml);


			}



	} catch (Exception $e) {


	}


?>