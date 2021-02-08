<?php


	try {


		//------- Set Main Vars or Reset -------//

			$qry_sgm = '';
			$qry_build_sgm = [];
			$sgm_dt = GtEcLstsDt([ 'id'=>$___datprcs_v['id_eclstssgm'] ]); print_r( $sgm_dt->var );

		//------- Start Process -------//


		$LstsSgmVarQry = "
						SELECT sisecsgmvar_qry, id_sisecsgmvartp, eclstssgmvar_vl, eclstssgmvar_opr, sisecsgmvartp_gts, eclstssgmvar_vl_sub, sisecsgmvar_key
						FROM "._BdStr(DBM).TB_EC_LSTS_SGM_VAR."
							 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR." ON eclstssgmvar_var = id_sisecsgmvar
							 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp
						WHERE eclstssgmvar_sgm = '".$___datprcs_v['id_eclstssgm']."'
					";

		//echo $this->li( compress_code($LstsSgmVarQry) );

		$LstsSgmVar = $__cnx->_qry($LstsSgmVarQry);

		if($LstsSgmVar){

			$rwLstsSgmVar = $LstsSgmVar->fetch_assoc();
			$TotLstsSgmVar = $LstsSgmVar->num_rows;

			if($TotLstsSgmVar > 0){

				do{


					echo $this->br(2);
					echo $this->h2($___datprcs_v['id_eclsts'].' - '.ctjTx($___datprcs_v['eclsts_nm'],'in'));
					echo $this->h2(ctjTx($___datprcs_v['eclstssgm_nm'],'in'));

					if(!isN($rwLstsSgmVar['sisecsgmvar_qry'])){

						if($_count_opr > 1){
							$_opr = ( ($rwLstsSgmVar['eclstssgmvar_opr'] == 1)? "AND" : "OR" );
						}

						if($rwLstsSgmVar['id_sisecsgmvartp'] == 9){
							$___vl_sqgtstr = $rwLstsSgmVar['eclstssgmvar_vl'];
						}else{
							$___vl_sqgtstr = GtSQLVlStr($rwLstsSgmVar['eclstssgmvar_vl'], $rwLstsSgmVar['sisecsgmvartp_gts']);
						}

						$_rplc_vl = str_replace('[vl]', $___vl_sqgtstr, $rwLstsSgmVar['sisecsgmvar_qry']); //Remplaza los [vl] por valores

						if( !isN($rwLstsSgmVar['eclstssgmvar_vl_sub']) ){
							$_rplc_vl = str_replace('[vl_sub]', GtSQLVlStr($rwLstsSgmVar['eclstssgmvar_vl_sub'], "text"), $_rplc_vl); //Remplaza los [vl_sub] por valores
						}

						if(	$rwLstsSgmVar['sisecsgmvar_key'] == "cty_lve" ||
							$rwLstsSgmVar['sisecsgmvar_key'] == "cty_nlve" ||
							$rwLstsSgmVar['sisecsgmvar_key'] == "cty_dp_lvez"){

							//Remplaza los [cns] por costantes
							$___vl_str_cns = _CId('ID_TPRLCC_VVE');

						}else if($rwLstsSgmVar['sisecsgmvar_key'] == "cty_nco"){

							$___vl_str_cns = _CId('ID_TPRLCC_NCO');

						}

						$_rplc_vl_2 = str_replace('[cns]', $___vl_str_cns, $_rplc_vl); //Remplaza los [cns] por costantes

						$qry_build_sgm[] = str_replace('[cl]', DB_PRFX_CL.$___datprcs_v['cl_sbd'], $_rplc_vl_2);

						$qry_sgm = ' AND ('.implode(' '.$_opr.' ', $qry_build_sgm).') ';

						$_count_opr++;

					}

				} while ($rwLstsSgmVar = $LstsSgmVar->fetch_assoc());

			}

		}else{

			echo $this->err($__cnx->c_r->error);

		}


		$__cnx->_clsr($LstsSgmVar);



	} catch (Exception $e) {


	}


?>