<?php

	$__li_clr = '#00d7d4';
    $__li .= $this->li('Inicia procesa registro '.$__dwn_dt->id);

	$__dwntot = GtDwnTotDt([ 'id'=>$__dwn_dt->id ]);
    UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'3', 'tot'=>$__dwntot ]);

    if($__dwn_dt->est == 3){ $__c_prcs = '1000'; }else{ $__c_prcs = '500'; }

    $Ls_Qry = " SELECT ID, id_dwnprc
    			FROM "._BdStr(DBD).$__dwn_dt->tab."
    			WHERE __dwn_e = 3
    			/*ORDER BY id_dwnprc ASC*/
    			ORDER BY RAND()
    			LIMIT $__c_prcs
				/*FOR UPDATE*/";

	if($__dwn_dt->col->ls->his->e == 'ok'){

		$Ls_Qry_His = "SELECT id_mdlcnthis, mdlcnthis_mdlcnt, mdlcnthis_dsc, mdlcnthis_fi, us_nm, us_ap
					FROM "._BdStr($_cl_dt->bd).TB_MDL_CNT_HIS."
							INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnthis_us = id_us
							INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = mdlcnthis_mdlcnt
					WHERE __dwn_e = 3
					ORDER BY id_dwnprc
					ASC";

	}

    $Ls_Qry_Est = "
    				SELECT id_mdlcntest, mdlcntest_mdlcnt, siscntest_tt, us_nm, us_ap
					FROM "._BdStr($_cl_dt->bd).TB_MDL_CNT_EST."
                   		 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
                   		 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
                   		 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us

				   	WHERE EXISTS (	SELECT __dwn_i
									FROM "._BdStr(DBD).$__dwn_dt->tab."
									WHERE mdlcntest_mdlcnt = __dwn_i AND __dwn_e = 3
								)
					ORDER BY mdlcntest_fi ASC /*, mdlcntest_hi ASC*/ ";


	if($__dwn_dt->col->ls->prda->e == 'ok'){

		//-------------------- Periodo que aplica  --------------------//

		$Ls_Qry_Prd_A = "SELECT id_mdlcntprd, mdlsprd_nm, mdlcntprd_mdlcnt, mdlsprd_nm
					FROM ".$_cl_dt->bd.".".TB_MDL_CNT_PRD."
					INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlcntprd_mdlsprd = id_mdlsprd
					INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = mdlcntprd_mdlcnt
					WHERE __dwn_e = 3 AND mdlcntprd_est = 1
					ORDER BY id_dwnprc ASC";

	}


	if($__dwn_dt->col->ls->org->e == 'ok'){

		//-------------------- Lista de Organizaciones --------------------//

		$Ls_Qry_Org = "SELECT org_nm, orgsds_nm, id_mdlcnt, id_orgsds, orgsdscnt_tpr,
							(SELECT GROUP_CONCAT(orgtp_tp SEPARATOR ',') FROM "._BdStr(DBM).TB_ORG_TP." WHERE orgtp_org = id_org ) as __tp,
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t'])."
					FROM ".$_cl_dt->bd.".".TB_ORG_SDS_CNT."
							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgsdscnt_tpr', 'als'=>'t'])."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON (id_orgsds = orgsdscnt_orgsds)
								INNER JOIN "._BdStr(DBM).TB_ORG." ON(id_org = orgsds_org)
								INNER JOIN ".$_cl_dt->bd.".".TB_CNT." ON (orgsdscnt_cnt = id_cnt)
								INNER JOIN ".$_cl_dt->bd.".".TB_MDL_CNT." ON (id_cnt = mdlcnt_cnt)
								INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = id_mdlcnt

					WHERE __dwn_e = 3
					ORDER BY id_dwnprc ASC";

	}

	if($__dwn_dt->col->ls->noi->e == 'ok'){

		//-------------------- Motivo de no interes --------------------//

		$Ls_Qry_Noi = "SELECT
							id_mdlcnt ,
							mdlcnt_noi AS _noi,
							( SELECT siscntnoi_nm FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi ) AS _noi_tt,
							( SELECT siscntnoi_prnt FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi ) AS _noi_prnt, /* Motivo de no interes 1 */

							( SELECT siscntnoi_nm FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi_prnt ) AS _noi_tt_sub_1,
							( SELECT siscntnoi_prnt FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi_prnt ) AS _noi_prnt_sub_1, /* Motivo de no interes 2 */

							( SELECT siscntnoi_nm FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi_prnt_sub_1 ) AS _noi_tt_sub_2,
							( SELECT siscntnoi_prnt FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi_prnt_sub_1 ) AS _noi_prnt_sub_2, /* Motivo de no interes 3 */

							( SELECT siscntnoi_nm FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi = _noi_prnt_sub_2 ) AS _noi_tt_sub_3 /* Motivo de no interes 4 */
						FROM ".$_cl_dt->bd.".".TB_MDL_CNT."
						INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = id_mdlcnt
						WHERE __dwn_e = 3
						ORDER BY id_dwnprc ASC
						";

	}

	if($__dwn_dt->col->ls->actv->e == 'ok'){

		//-------------------- Actividad del cnt --------------------//

		$Ls_Qry_Actv = "
						SELECT mdlcntmdl_mdlcnt, mdl_nm
						FROM ".$_cl_dt->bd.".".TB_MDL_CNT_MDL."
							 INNER JOIN ".$_cl_dt->bd.".".TB_MDL." ON mdlcntmdl_mdl = id_mdl
							 INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = mdlcntmdl_mdlcnt
						WHERE __dwn_e = 3
						ORDER BY mdlcntmdl_fi ASC
					";

	}

	if($__dwn_dt->col->ls->sbrnd->e == 'ok'){

		//-------------------- Marcas del mdl_cnt --------------------//

		$Ls_Qry_Sbrnd = "
						SELECT id_mdlcnttra, mdlcnttra_mdlcnt, storebrnd_nm
						FROM ".$_cl_dt->bd.".".TB_MDL_CNT_TRA."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							 LEFT JOIN "._BdStr(DBS).TB_STORE_BRND." ON tra_sbrnd = id_storebrnd
							 INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = mdlcnttra_mdlcnt
						WHERE __dwn_e = 3
						ORDER BY id_dwnprc ASC
					";

	}

	if($__dwn_dt->col->ls->cnt_attr->e == 'ok'){
		//-------------------- Atributos del cnt --------------------//

		$Ls_Qry_Attr_MdlCnt = "
						SELECT *,
							(SELECT ".DBD.".ctjTx(sisslc_tt) FROM "._BdStr(DBM).TB_SIS_SLC." WHERE id_sisslc = mdlcntattr_attr) AS _attr_cnt_tt,
							"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'attr', 'no_enc'=>'ok' ]).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t'])."
						FROM ".$_cl_dt->bd.".".TB_MDL_CNT_ATTR."
						INNER JOIN ".$_cl_dt->bd.".".TB_MDL_CNT." ON id_mdlcnt = mdlcntattr_mdlcnt
								".GtSlc_QryExtra(['t'=>'tb', 'col'=>'mdlcntattr_attr', 'als'=>'t'])."
						WHERE id_mdlcntattr != ''
							AND id_mdlcnt IN ( SELECT __dwn_i
													FROM "._BdStr(DBD).$__dwn_dt->tab."
													WHERE __dwn_e = 3
												)
						ORDER BY attr_sisslc_tt ASC
					";

	}

	if($__dwn_dt->col->ls->tag->e == 'ok'){

		//-------------------- Marcas del mdl_cnt --------------------//

		$Ls_Qry_Tag = "
						SELECT id_mdlcnttra, mdlcnttra_mdlcnt,
						(
							SELECT
								GROUP_CONCAT( sisslc_tt SEPARATOR ',' )
							FROM
								"._BdStr(DBM).TB_SIS_SLC."
								INNER JOIN "._BdStr(DBM).TB_TRA_TAG." ON tratag_tag = id_sisslc
							WHERE
								tratag_tag = id_sisslc AND tratag_tra = id_tra ) AS tags
						FROM ".$_cl_dt->bd.".".TB_MDL_CNT_TRA."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							 INNER JOIN "._BdStr(DBD).$__dwn_dt->tab." ON __dwn_i = mdlcnttra_mdlcnt
						WHERE __dwn_e = 3
						ORDER BY id_dwnprc ASC
					";

	}



	//-------------------- Main Query --------------------//
    echo $this->h3(date("Y-m-d H:i:s").' Consulta a tabla '.$__dwn_dt->tab);

    $Ls_Rg = $__cnx->_prc($Ls_Qry);

    if($Ls_Rg){

	    $row_Ls_Rg = $Ls_Rg->fetch_assoc();
	    $Tot_Ls_Rg = $Ls_Rg->num_rows;

	    //-------------------- History Query --------------------//
	    echo $this->h3(date("Y-m-d H:i:s").' Consulta gestiones');

		/* >>>>> MySql */
		$Ls_Rg_His = $__cnx->_qry($Ls_Qry_His);

		if($Ls_Rg_His){
			$Tot_Ls_Rg_His = $Ls_Rg_His->num_rows;
		}
		/* <<<<< MySql */

		/* >>>>> PDO */
		/*$Ls_Rg_His = $pdo->prepare($Ls_Qry_His);

	    if($Ls_Rg_His){
		    if($Ls_Rg_His->execute()){
			    $Ls_Rg_His_Fx = Pdo_Fix_RwTot($Ls_Rg_His);
			    $Tot_Ls_Rg_His = $Ls_Rg_His_Fx['tot'];
			    $row_Ls_Rg_His = $Ls_Rg_His_Fx['row'];
		    }else{
			    echo $this->err('nPDO::errorInfo() '.print_r($pdo->errorInfo(), true) ); exit();
		    }
	    }else{
		    echo $this->err('nPDO::errorInfo() '.print_r($pdo->errorInfo(), true) ); exit();
		}*/
		/* <<<<< PDO */

	    //-------------------- Statuses Query --------------------//
	    echo $this->h3(date("Y-m-d H:i:s").' Consulta estados');

		/* >>>>> MySql */
		$Ls_Rg_Est = $__cnx->_qry($Ls_Qry_Est);
		if($Ls_Rg_Est){
			$Tot_Ls_Rg_Est = $Ls_Rg_Est->num_rows;
		}
		/* <<<<< MySql */

	    //-------------------- Periodo que aplica --------------------//
	    echo $this->h3(date("Y-m-d H:i:s").' Consulta periodos');

		if(!isN($Ls_Qry_Prd_A)){ $Ls_Rg_Prd_A = $__cnx->_qry($Ls_Qry_Prd_A); }
		if($Ls_Rg_Prd_A){ $Tot_Ls_Rg_Prd_A = $Ls_Rg_Prd_A->num_rows; }
		/* <<<<< MySql */

	    //-------------------- Lista Organizaciones --------------------//
	    echo $this->h3(date("Y-m-d H:i:s").' Consulta organizaciones');

		if(!isN($Ls_Qry_Org)){ $Ls_Rg_Org = $__cnx->_qry($Ls_Qry_Org); }
		if($Ls_Rg_Org){ $Tot_Ls_Rg_Org = $Ls_Rg_Org->num_rows; }

	    //-------------------- Motivo de no interes --------------------//
	    echo $this->h3(date("Y-m-d H:i:s").' Consulta motivo de no interes');

		if(!isN($Ls_Qry_Noi)){ $Ls_Rg_Noi = $__cnx->_qry($Ls_Qry_Noi); }
		if($Ls_Rg_Noi){ $Tot_Ls_Rg_Noi = $Ls_Rg_Noi->num_rows; }

		//-------------------- Atributos Mdl_Cnt --------------------//

		echo $this->h3(date("Y-m-d H:i:s").' Consulta atributos mdl_cnt');

		if(!isN($Ls_Qry_Attr_MdlCnt)){ $Ls_Rg_Attr_MdlCnt = $__cnx->_qry($Ls_Qry_Attr_MdlCnt); }
		if($Ls_Rg_Attr_MdlCnt){ $Tot_Ls_Rg_Attr_MdlCnt = $Ls_Rg_Attr_MdlCnt->num_rows; }

		//-------------------- Actividades --------------------//

		echo $this->h3(date("Y-m-d H:i:s").' Consulta actividades relacionadas');

		if(!isN($Ls_Qry_Actv)){ $Ls_Rg_MdlCnt_Actv = $__cnx->_qry($Ls_Qry_Actv); }
		if($Ls_Rg_MdlCnt_Actv){ $Tot_Ls_Rg_MdlCnt_Actv = $Ls_Rg_MdlCnt_Actv->num_rows; }else{ echo $Ls_Qry_Actv; echo $__cnx->c_r->error; $this->Dwn_Rd(); }

		//-------------------- Marcas --------------------//

		echo $this->h3(date("Y-m-d H:i:s").' Consulta marcas relacionadas');

		if(!isN($Ls_Qry_Sbrnd)){ $Ls_Rg_MdlCnt_Sbrnd = $__cnx->_qry($Ls_Qry_Sbrnd); }
		if($Ls_Rg_MdlCnt_Sbrnd){ $Tot_Ls_Rg_MdlCnt_Sbrnd = $Ls_Rg_MdlCnt_Sbrnd->num_rows; }else{ echo $Ls_Qry_Sbrnd; echo $__cnx->c_r->error; $this->Dwn_Rd(); }

		//-------------------- Tags --------------------//

		echo $this->h3(date("Y-m-d H:i:s").' Consulta tags relacionadas');

		if(!isN($Ls_Qry_Tag)){ $Ls_Rg_MdlCnt_Tags = $__cnx->_qry($Ls_Qry_Tag); }
		if($Ls_Rg_MdlCnt_Tags){ $Tot_Ls_Rg_MdlCnt_Tags = $Ls_Rg_MdlCnt_Tags->num_rows; }else{ echo $Ls_Qry_Tag; echo $__cnx->c_r->error; $this->Dwn_Rd(); }

	    //-------------------- Busca Gestiones del Lead --------------------//

	        $__li .= $this->li('Total Gestiones:'.$Tot_Ls_Rg_His);

	        if($Tot_Ls_Rg_His > 0){

				while($rc_Ls_Rg_His = $Ls_Rg_His->fetch_assoc()){

			        if(!isN($rc_Ls_Rg_His['mdlcnthis_dsc'])){
	                    $_i_p = $rc_Ls_Rg_His['mdlcnthis_mdlcnt'];
	                    $_i_p_h = $rc_Ls_Rg_His['id_mdlcnthis'];
	                    $__col_his[ $_i_p ][] = ['id'=>$_i_p_h,
	                                             'f'=>strip_tags( html_entity_decode(   /*ctjTx(*/$rc_Ls_Rg_His['mdlcnthis_fi']/*,'in')*/  ) ),
												  	't'=>$rc_Ls_Rg_His['mdlcnthis_dsc'],
												  	'u'=>$rc_Ls_Rg_His['us_nm'].' '.$rc_Ls_Rg_His['us_ap']
												 ];
	                }

	                //echo $this->li(date("Y-m-d H:i:s").' '.$Tot_Ls_Rg_His.' / Gestion '.$_i_p_h);

			    }

	            foreach ($__col_his as $k => $v) { if(count($v) > $__mdl_th_his){ $__mdl_th_his = count($v); } }

	        }else{

		        echo $this->err(' $Tot_Ls_Rg_His Cpml: '. $Tot_Ls_Rg_His);

	        }


	    //-------------------- Busca Cambios de Estado del Lead --------------------//

	        $__li .= $this->li('Total Estados:'.$Tot_Ls_Rg_Est);

	        if($Tot_Ls_Rg_Est > 0){
				while($rc_Ls_Rg_Est = $Ls_Rg_Est->fetch_assoc()){
	            //foreach ($row_Ls_Rg_Est as $rc_Ls_Rg_Est) {
	                if(!isN($row_Ls_Rg_Est['siscntest_tt'])){

	                    $_i_p = $rc_Ls_Rg_Est['mdlcntest_mdlcnt'];
						$_i_p_e = $rc_Ls_Rg_Est['id_mdlcntest'];
	                    $__col_est[ $_i_p ][] = ['id'=>$_i_p_e,
	                                                'f'=>strip_tags( html_entity_decode(   /*ctjTx(*/$rc_Ls_Rg_Est['mdlcntest_fi']/*,'in')*/  ) ),
	                                                't'=>$rc_Ls_Rg_Est['siscntest_tt'],
	                                                'u'=>$rc_Ls_Rg_Est['us_nm'].' '.$rc_Ls_Rg_Est['us_ap']
												 ];
						//echo $this->li(date("Y-m-d H:i:s").' '.$Tot_Ls_Rg_Est.' / Estados '.$_i_p_e.' - '.$rc_Ls_Rg_Est['id_mdlcntest']." -- ");
					}
				}
	            foreach ($__col_est as $k => $v) { if(count($v) > $__mdl_th_est){ $__mdl_th_est = count($v); } }
	        }



	    //-------------------- Periodo que aplica --------------------//

	        $__li .= $this->li('Total Periodos:'.$Tot_Ls_Rg_Prd_A);

	        if($Tot_Ls_Rg_Prd_A > 0){

				while($rc_Ls_Rg_Prd_A = $Ls_Rg_Prd_A->fetch_assoc()){
	            //foreach ($row_Ls_Rg_Prd_A as $rc_Ls_Rg_Prd_A) {

	                if(!isN($rc_Ls_Rg_Prd_A['mdlsprd_nm'])){
	                    $_i_p = $rc_Ls_Rg_Prd_A['mdlcntprd_mdlcnt'];
	                    $_i_p_prd = $rc_Ls_Rg_Prd_A['id_mdlcntprd'];
	                    $__col_prd_a[ $_i_p ][] = [
	                    							'id'=>$_i_p_prd,
	                                            	't'=> $rc_Ls_Rg_Prd_A['mdlsprd_nm']
												];
	                }

					//echo $this->li(date("Y-m-d H:i:s").' '.$Tot_Ls_Rg_Prd_A.' / Periodos '.$_i_p_prd);

				}
	            foreach ($__col_prd_a as $k_prd => $v_prd) { if(count($v_prd) > $__mdl_th_prd_a){ $__mdl_th_prd_a = count($v_prd); } }
	        }


		//-------------------- Lista Organizaciones --------------------//

	        $__li .= $this->li('Total Organizaciones:'.$Tot_Ls_Rg_Org);

	        if($Tot_Ls_Rg_Org > 0){

				while($rc_Ls_Rg_Org = $Ls_Rg_Org->fetch_assoc()){
	            //foreach ($row_Ls_Rg_Org as $rc_Ls_Rg_Org) {

	                if(!isN($rc_Ls_Rg_Org['org_nm'])){


	                    $___tp = explode(',', $rc_Ls_Rg_Org['__tp']);


	                    $_i_p = $rc_Ls_Rg_Org['id_mdlcnt'];
	                    $_i_p_org = $rc_Ls_Rg_Org['id_orgsds'];


	                    if(	in_array(_CId('ID_ORGTP_CLG'), $___tp) &&
	                    	(	$rc_Ls_Rg_Org['orgsdscnt_tpr'] == _CId('ID_ORGCNTRTP_ESTD_PRST') ||
	                    		$rc_Ls_Rg_Org['orgsdscnt_tpr'] == _CId('ID_ORGCNTRTP_ESTD_PAS')
	                    	)
	                    ){

	                        $__col_org_clg[ $_i_p ][] = [
	                        							'id'=>$_i_p_org,
	                                                	't'=>$rc_Ls_Rg_Org['org_nm']." ( ".$rc_Ls_Rg_Org['orgsds_nm']." )",
	                                                	'tpr'=> $rc_Ls_Rg_Org['tp_sisslc_tt']
													];

						}elseif(

							in_array(_CId('ID_ORGTP_EMP'), $___tp) &&
	                    	(	$rc_Ls_Rg_Org['orgsdscnt_tpr'] == _CId('ID_ORGCNTRTP_TRB_PRST') ||
	                    		$rc_Ls_Rg_Org['orgsdscnt_tpr'] == _CId('ID_ORGCNTRTP_TRB_PAS')
	                    	)

						){

							$__col_org_emp[ $_i_p ][] = [
	                        							'id'=>$_i_p_org,
	                                                	't'=> $rc_Ls_Rg_Org['org_nm']." ( ".$rc_Ls_Rg_Org['orgsds_nm']." )",
	                                                	'tpr'=> $rc_Ls_Rg_Org['tp_sisslc_tt']
													];


						}elseif(

							in_array(_CId('ID_ORGTP_UNI'), $___tp) &&
	                    	(	$rc_Ls_Rg_Org['orgsdscnt_tpr'] == _CId('ID_ORGCNTRTP_ESTD_PRST') ||
	                    		$rc_Ls_Rg_Org['orgsdscnt_tpr'] == _CId('ID_ORGCNTRTP_ESTD_PAS')
	                    	)

						){

							$__col_org_uni[ $_i_p ][] = [
	                        							'id'=>$_i_p_org,
	                                                	't'=> $rc_Ls_Rg_Org['org_nm']." ( ".$rc_Ls_Rg_Org['orgsds_nm']." )",
	                                                	'tpr'=> $rc_Ls_Rg_Org['tp_sisslc_tt']
													];

						}
	                }

				}


	            foreach ($__col_org_clg as $k_org_clg => $v_org_clg) { if(count($v_org_clg) > $__mdl_th_org_clg){ $__mdl_th_org_clg = count($v_org_clg); } }
	            foreach ($__col_org_emp as $k_org_emp => $v_org_emp) { if(count($v_org_emp) > $__mdl_th_org_emp){ $__mdl_th_org_emp = count($v_org_emp); } }
	            foreach ($__col_org_uni as $k_org_uni => $v_org_uni) { if(count($v_org_uni) > $__mdl_th_org_uni){ $__mdl_th_org_uni = count($v_org_uni); } }
	        }


	    //-------------------- Motivo de no interes --------------------//

	        $__li .= $this->li('Total No Interes:'.$Tot_Ls_Rg_Noi);

	        if($Tot_Ls_Rg_Noi > 0){

				while($rc_Ls_Rg_Noi = $Ls_Rg_Noi->fetch_assoc()){
	            //foreach ($row_Ls_Rg_Noi as $rc_Ls_Rg_Noi) {

	                if(!isN($rc_Ls_Rg_Noi['_noi'])){

	                    $_i_p = $rc_Ls_Rg_Noi['id_mdlcnt'];

	                    if( !isN($rc_Ls_Rg_Noi['_noi_prnt_sub_2']) ){
	                        $__col_noi[ $_i_p ][] = [	//Motivo de no interes 4
	                        							'id'=>$rc_Ls_Rg_Noi['_noi_prnt_sub_2'],
	                                                	't'=> $rc_Ls_Rg_Noi['_noi_tt_sub_3']
													];
						}

						if( !isN($rc_Ls_Rg_Noi['_noi_prnt_sub_1']) ){
							$__col_noi[ $_i_p ][] = [	//Motivo de no interes 3
	                        							'id'=>$rc_Ls_Rg_Noi['_noi_prnt_sub_1'],
	                                                	't'=> $rc_Ls_Rg_Noi['_noi_tt_sub_2']
													];
						}

	                    if( !isN($rc_Ls_Rg_Noi['_noi_prnt']) ){
	                        $__col_noi[ $_i_p ][] = [	//Motivo de no interes 2
	                        							'id'=>$rc_Ls_Rg_Noi['_noi_prnt'],
	                                                	't'=> $rc_Ls_Rg_Noi['_noi_tt_sub_1']
													];
						}

	                    if( !isN($rc_Ls_Rg_Noi['_noi']) ){
	                        $__col_noi[ $_i_p ][] = [   //Motivo de no interes 1
	                        							'id'=>$rc_Ls_Rg_Noi['_noi'],
	                                                	't'=> $rc_Ls_Rg_Noi['_noi_tt']
													];
						}

	                }

	            }

	            foreach ($__col_noi as $k_noi => $v_noi) { if(count($v_noi) > $__mdl_th_noi){ $__mdl_th_noi = count($v_noi); } }

	        }



		//-------------------- Atributos mdl_cnt --------------------//
			$__li .= $this->li('Total Atributos:'.$Tot_Ls_Rg_Attr_MdlCnt);

            if($Tot_Ls_Rg_Attr_MdlCnt > 0){

                while($row_Ls_Rg_Attr_MdlCnt = $Ls_Rg_Attr_MdlCnt->fetch_assoc()){

					$__mdlcnt_attr = '';
					$__mdlcnt_attr_prop = [];

                    if($row_Ls_Rg_Attr_MdlCnt['mdlcntattr_vl'] != ''){

						$__mdlcnt_attr = GtSlcF_JAttr($row_Ls_Rg_Attr_MdlCnt['___attr']);

						foreach($__mdlcnt_attr as $___mdlcnt_attr_k=>$___mdlcnt_attr_v){
							$__mdlcnt_attr_prop[$___mdlcnt_attr_v->key] = $___mdlcnt_attr_v;
						}

						if(!isN($__mdlcnt_attr_prop['ls']->vl)){
							$__slcdt = __LsDt([ 'id'=>$row_Ls_Rg_Attr_MdlCnt['mdlcntattr_vl'], 'no_lmt'=>'ok' ]);
							$__vl = $__slcdt->d->tt;
						}else{
							$__vl = $row_Ls_Rg_Attr_MdlCnt['mdlcntattr_vl'];
						}

                        $_i_p = $row_Ls_Rg_Attr_MdlCnt['id_mdlcnt'];
                        $_i_p_a_cnt = $row_Ls_Rg_Attr_MdlCnt['id_mdlcntattr'];
                        $__col_mdlcnt_attr[ $_i_p ][] = [
                            							'id'=>$_i_p_a_cnt,
														't'=>$row_Ls_Rg_Attr_MdlCnt['_attr_cnt_tt'], //Titulo Atributo
														'v'=>$__vl, //valor Atributo
														'attr'=>$row_Ls_Rg_Attr_MdlCnt['mdlcntattr_attr'] //Atributo
												 ];
					}

				}

                foreach ($__col_mdlcnt_attr as $k => $v) { if(count($v) > $__mdl_th_attr_mdlcnt){ $__mdl_th_attr_mdlcnt = count($v); } }
            }else{

		        echo $this->err(' $Tot_Ls_Rg_Attr_MdlCnt Cpml: ');

	        }

		//-------------------- Actividades cnt --------------------//

			echo $__li .= $this->li('Total Actividades:'.$Tot_Ls_Rg_MdlCnt_Actv);

            if($Tot_Ls_Rg_MdlCnt_Actv > 0){

                while($row_Ls_Rg_MdlCnt_Actv = $Ls_Rg_MdlCnt_Actv->fetch_assoc()){

					if(!isN($row_Ls_Rg_MdlCnt_Actv['mdl_nm'])){

	                    $_i_p = $row_Ls_Rg_MdlCnt_Actv['mdlcntmdl_mdlcnt'];
	                    $_i_p_actv = $row_Ls_Rg_MdlCnt_Actv['id_mdlcntmdl'];
	                    $__col_mdlcnt_actv[ $_i_p ][] = [
	                    							'id'=>$_i_p_actv,
	                                            	't'=>$row_Ls_Rg_MdlCnt_Actv['mdl_nm']
												];
	                }

					//echo $this->li(date("Y-m-d H:i:s").' '.$Tot_Ls_Rg_Cnt_Attr.' / Atributos '.$_i_p_a_cnt);

                }
                foreach ($__col_mdlcnt_actv as $k => $v) { if(count($v) > $__mdl_th_mdlcnt_actv){ $__mdl_th_mdlcnt_actv = count($v); } }
			}

		//-------------------- Marcas mdl_cnt_tra --------------------//

			echo $__li .= $this->li('Total Marcas:'.$Tot_Ls_Rg_MdlCnt_Sbrnd);

            if($Tot_Ls_Rg_MdlCnt_Sbrnd > 0){

                while($row_Ls_Rg_MdlCnt_Sbrnd = $Ls_Rg_MdlCnt_Sbrnd->fetch_assoc()){

					if(!isN($row_Ls_Rg_MdlCnt_Sbrnd['storebrnd_nm'])){

	                    $_i_p = $row_Ls_Rg_MdlCnt_Sbrnd['mdlcnttra_mdlcnt'];
	                    $_i_p_sbrnd = $row_Ls_Rg_MdlCnt_Sbrnd['id_mdlcnttra'];
	                    $__col_mdlcnt_sbrnd[ $_i_p ][] = [
	                    							'id'=>$_i_p_sbrnd,
	                                            	't'=>$row_Ls_Rg_MdlCnt_Sbrnd['storebrnd_nm']
												];
	                }

					//echo $this->li(date("Y-m-d H:i:s").' '.$Tot_Ls_Rg_Cnt_Attr.' / Atributos '.$_i_p_a_cnt);

                }
                foreach ($__col_mdlcnt_sbrnd as $k => $v) { if(count($v) > $__mdl_th_mdlcnt_sbrnd){ $__mdl_th_mdlcnt_sbrnd = count($v); } }
			}

		//-------------------- Tags mdl_cnt_tra --------------------//

			echo $__li .= $this->li('Total Tags:'.$Tot_Ls_Rg_MdlCnt_Tags);

			if($Tot_Ls_Rg_MdlCnt_Tags > 0){

				while($row_Ls_Rg_MdlCnt_Tags = $Ls_Rg_MdlCnt_Tags->fetch_assoc()){

					if(!isN($row_Ls_Rg_MdlCnt_Tags['tags'])){

						$_i_p = $row_Ls_Rg_MdlCnt_Tags['mdlcnttra_mdlcnt'];
						$_i_p_tags = $row_Ls_Rg_MdlCnt_Tags['id_mdlcnttra'];
						$__col_mdlcnt_tags[ $_i_p ][] = [
													'id'=>$_i_p_tags,
													't'=>$row_Ls_Rg_MdlCnt_Tags['tags']
												];
					}

				}
				foreach ($__col_mdlcnt_tags as $k => $v) { if(count($v) > $__mdl_th_mdlcnt_tags){ $__mdl_th_mdlcnt_tags = count($v); } }
			}

		//-------------------- Inicia Procesamiento --------------------//


	    if (($Tot_Ls_Rg > 0)/*&&($Tot_Ls_Rg < 20001)*/) {


	        //-------------------- Inicia - Construye Nuevas Columnas en la BD --------------------//

	            $_tr_i = 1;


	            do{

	                $_d_p_c = $__col_his[ $row_Ls_Rg['ID']];
	                $_d_p_e = $__col_est[ $row_Ls_Rg['ID']];
	                $_d_p_p = $__col_prd_a[ $row_Ls_Rg['ID']];
					$_d_p_mdlcnt_a = $__col_mdlcnt_attr[$row_Ls_Rg['ID']];
					$_d_p_mcnt_ac = $__col_mdlcnt_actv[$row_Ls_Rg['ID']];
					$_d_p_sbrnd = $__col_mdlcnt_sbrnd[$row_Ls_Rg['ID']];
					$_d_p_tags = $__col_mdlcnt_tags[$row_Ls_Rg['ID']];

	                for ($i = 1; $i <= $__mdl_th_his; $i++) {
	                    $__mdl_th_g[$i][1]['tt'] = TX_GSTN .' '. $i .' (Fecha)';
	                    $__mdl_th_g[$i][1]['tt_bd'] = 'Gestion_Fecha_'.$i;
	                    $__mdl_th_g[$i][2]['tt'] = TX_GSTN . $i. ' (Texto) ';
	                    $__mdl_th_g[$i][2]['tt_bd'] = 'Gestion_Texto_'.$i;
	                    $__mdl_th_g[$i][3]['tt'] = TX_GSTN . $i . ' (Usuario) ';
	                    $__mdl_th_g[$i][3]['tt_bd'] = 'Gestion_Usuario_'.$i;
	                }

	                for ($i = 1; $i <= $__mdl_th_est; $i++) {
	                    $__mdl_th_e[$i][1]['tt'] = TX_S .' '. $i .' (Fecha)';
	                    $__mdl_th_e[$i][1]['tt_bd'] = 'Estado_Fecha_'.$i;
	                    $__mdl_th_e[$i][2]['tt'] = TX_S . $i . ' (Estado) ';
	                    $__mdl_th_e[$i][2]['tt_bd'] = 'Estado_Texto_'.$i;
	                    $__mdl_th_e[$i][3]['tt'] = TX_S . $i . ' (Usuario) ';
	                    $__mdl_th_e[$i][3]['tt_bd'] = 'Estado_Usuario_'.$i;
	                }

	                //Periodo que aplica
	                for ($i = 1; $i <= $__mdl_th_prd_a; $i++) {
	                    $__mdl_th_p[$i][1]['tt_bd'] = TX_PRD_A.' '.$i;
	                    $__mdl_th_p[$i][1]['tt_bd'] = 'Periodo_Aplica_'.$i;
	                }

	                //Organizaciones colegios
	                for ($i = 1; $i <= $__mdl_th_org_clg; $i++) {
	                    $__mdl_th_clg[$i][1]['tt_bd'] = 'Colegio_'.$i;
	                    $__mdl_th_clg[$i][2]['tt_bd'] = 'Colegio_Tipo_Relacion_'.$i;
	                }

	                //Organizaciones empresas
	                for ($i = 1; $i <= $__mdl_th_org_emp; $i++) {
	                    $__mdl_th_emp[$i][1]['tt_bd'] = 'Empresa_'.$i;
	                    $__mdl_th_emp[$i][2]['tt_bd'] = 'Empresa_Tipo_Relacion_'.$i;
	                }

	                //Organizaciones universidad
	                for ($i = 1; $i <= $__mdl_th_org_uni; $i++) {
	                    $__mdl_th_uni[$i][1]['tt_bd'] = 'Universidad_'.$i;
	                    $__mdl_th_uni[$i][2]['tt_bd'] = 'Universidad_Tipo_Relacion_'.$i;
	                }

					//echo $this->li( date("Y-m-d H:i:s").' / No interes '.count($__mdl_th_noi) );
	                //Motivo de no interes
	                for ($i = 1; $i <= $__mdl_th_noi; $i++) {
	                    $__mdl_th_n[$i][1]['tt_bd'] = 'Motivo_no_interes_'.$i;
	                }


					//echo $this->li( date("Y-m-d H:i:s").' / Atributos '.count($__col_mdlcnt_attr)." - ".$row_Ls_Rg['ID'] );
	                //Atributos cnt
	                foreach($__col_mdlcnt_attr[ $row_Ls_Rg['ID'] ] as $_k_a_cnt => $_v_a_cnt){
						/*$_v_a_cnt_tt = str_replace([':', '\\', '/', '*', '-', '.', ' ', '(', ')'], "_", $_v_a_cnt['t']);*/ //Remplazar simbolos por Guion al piso _

						$_v_a_cnt_tt = preg_replace('/[^A-Za-z0-9\-]/', '', $_v_a_cnt['t']);
						$__mdl_th_a_cnt[$_v_a_cnt_tt]['tt'] = $_v_a_cnt_tt;
						$__mdl_th_a_cnt[$_v_a_cnt_tt]['tt_bd'] = $_v_a_cnt_tt;
						$__mdl_th_a_cnt[$_v_a_cnt_tt]['attr'] = $_v_a_cnt['attr'];
					}

					//Actividades cnt
					//echo $this->li( date("Y-m-d H:i:s").' / Actividades '.count($__mdl_th_mdlcnt_actv)." - ".$row_Ls_Rg['ID'] );
					if(!isN($__mdl_th_mdlcnt_actv)){
						for ($i = 1; $i <= $__mdl_th_mdlcnt_actv; $i++) {
							//echo $this->li('Creando Columna Actividad_'.$i);
							$__mdl_th_mdlcnt_a[$i][1]['tt_bd'] = 'Actividad_'.$i;
						}
					}

					//marcas mdl_cnt
					//echo $this->li( date("Y-m-d H:i:s").' / Marcas '.count($__mdl_th_mdlcnt_sbrnd)." - ".$row_Ls_Rg['ID'] );
					if(!isN($__mdl_th_mdlcnt_sbrnd)){
						for ($i = 1; $i <= $__mdl_th_mdlcnt_sbrnd; $i++) {
							//echo $this->li('Creando Columna Actividad_'.$i);
							$__mdl_th_mdlcnt_s[$i][1]['tt_bd'] = 'Marca_'.$i;
						}
					}

					//Tags mdl_cnt
					if(!isN($__mdl_th_mdlcnt_tags)){
						for ($i = 1; $i <= $__mdl_th_mdlcnt_tags; $i++) {
							$__mdl_th_mdlcnt_t[$i][1]['tt_bd'] = 'Tags_'.$i;
						}
					}

	                $_tr_i++;


	            } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());


				//Gestiones
	            for ($c = 1; $c <= count($__mdl_th_g); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_g[$c] ); $d++) {
	                    if($d == 2){ $_tp_c_f = 'TEXT'; }else{ $_tp_c_f = 'VARCHAR(60)'; }
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_g[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_His_A[] = ' ADD '.$__mdl_th_g[$c][$d]['tt_bd'].' '.$_tp_c_f.' ';
	                    }
	                }
	            }

	            if(!isN($Ls_Mdfy_His_A)){
	                $Ls_Mdfy_His_g = implode(',', $Ls_Mdfy_His_A);
	                $Ls_Mdfy_His = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'_his  '.$Ls_Mdfy_His_g; echo $this->h3($Ls_Mdfy_His);
	                $Ls_Mdf_H = $pdo_d->prepare($Ls_Mdfy_His); $Ls_Mdf_H->execute();
	                if(!$Ls_Mdf_H){ print_r($Ls_Mdf_H->errorInfo()); die(); }
	            }


				//Estados
	            for ($c = 1; $c <= count($__mdl_th_e); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_e[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_e[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_Est_A[] = ' ADD '.$__mdl_th_e[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

	            if(!isN($Ls_Mdfy_Est_A)){
	                $Ls_Mdfy_Est_g = implode(',', $Ls_Mdfy_Est_A);
	                $Ls_Mdfy_Est = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_Est_g; echo $this->h3($Ls_Mdfy_Est);
	                $Ls_Mdf_E = $pdo_d->prepare($Ls_Mdfy_Est); $Ls_Mdf_E->execute();
	                if(!$Ls_Mdf_E){ print_r($Ls_Mdf_E->errorInfo()); die(); }
	            }


	            //Periodo Aplica
	            for ($c = 1; $c <= count($__mdl_th_p); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_p[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_p[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_Prd_A[] = ' ADD '.$__mdl_th_p[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

	            //Periodo Aplica
	            if(!isN($Ls_Mdfy_Prd_A)){
	                $Ls_Mdfy_Prd_A_g = implode(',', $Ls_Mdfy_Prd_A);
	                $Ls_Mdfy_Prd = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_Prd_A_g;
	                $Ls_Mdf_P = $pdo_d->prepare($Ls_Mdfy_Prd); $Ls_Mdf_P->execute(); echo $this->h3($Ls_Mdfy_Prd);
	                if(!$Ls_Mdf_P){ print_r($Ls_Mdf_P->errorInfo()); die(); }
	            }

	            //organizaciones Colegios
	            for ($c = 1; $c <= count($__mdl_th_clg); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_clg[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_clg[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_Org_Clg[] = ' ADD '.$__mdl_th_clg[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

	            //organizaciones Colegios
	            if(!isN($Ls_Mdfy_Org_Clg)){
	                $Ls_Mdfy_Org_Clg_g = implode(',', $Ls_Mdfy_Org_Clg);
	                $Ls_Mdfy_Org_Clg = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_Org_Clg_g; echo $this->h3($Ls_Mdfy_Org_Clg);
	                $Ls_Mdf_P = $pdo_d->prepare($Ls_Mdfy_Org_Clg); $Ls_Mdf_P->execute();
	                if(!$Ls_Mdf_P){ print_r($Ls_Mdf_P->errorInfo()); die(); }
	            }

				//organizaciones Empresas
	            for ($c = 1; $c <= count($__mdl_th_emp); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_emp[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_emp[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_Org_Emp[] = ' ADD '.$__mdl_th_emp[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

	            //organizaciones Empresas
	            if(!isN($Ls_Mdfy_Org_Emp)){
	                $Ls_Mdfy_Org_Emp_g = implode(',', $Ls_Mdfy_Org_Emp);
	                $Ls_Mdfy_Org_Emp = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_Org_Emp_g; echo $this->h3($Ls_Mdfy_Org_Emp);
	                $Ls_Mdf_P = $pdo_d->prepare($Ls_Mdfy_Org_Emp); $Ls_Mdf_P->execute();
	                if(!$Ls_Mdf_P){ print_r($Ls_Mdf_P->errorInfo()); die(); }
	            }

	            //organizaciones Universidades
	            for ($c = 1; $c <= count($__mdl_th_uni); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_uni[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_uni[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_Org_Uni[] = ' ADD '.$__mdl_th_uni[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

	            //organizaciones Universidades
	            if(!isN($Ls_Mdfy_Org_Uni)){
	                $Ls_Mdfy_Org_Uni_g = implode(',', $Ls_Mdfy_Org_Uni);
	                $Ls_Mdfy_Org_Uni = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_Org_Uni_g; echo $this->h3($Ls_Mdfy_Org_Uni);
	                $Ls_Mdf_P = $pdo_d->prepare($Ls_Mdfy_Org_Uni); $Ls_Mdf_P->execute();
	                if(!$Ls_Mdf_P){ print_r($Ls_Mdf_P->errorInfo()); die(); }
	            }

	            //Motivo de no interes
	            for ($c = 1; $c <= count($__mdl_th_n); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_n[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_n[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_Noi[] = ' ADD '.$__mdl_th_n[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }


	            //Motivo de no interes
	            if(!isN($Ls_Mdfy_Noi)){
	                $Ls_Mdfy_Noi_g = implode(',', $Ls_Mdfy_Noi);
	                $Ls_Mdfy_Noi = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_Noi_g; echo $this->h3($Ls_Mdfy_Noi);
	                $Ls_Mdf_N = $pdo_d->prepare($Ls_Mdfy_Noi); $Ls_Mdf_N->execute();
	                if(!$Ls_Mdf_N){ print_r($Ls_Mdf_N->errorInfo()); die(); }
	            }


				//Atributos cnt
				foreach($__mdl_th_a_cnt as $_k_th => $_v_th){
					if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$_v_th['tt_bd'] ]) == 'no'){
						$Ls_Mdfy_CntAttr[] = ' ADD '.$_v_th['tt_bd'].' VARCHAR(60) ';
					}
				}

				if( !isN($Ls_Mdfy_CntAttr) ){

					$Ls_Mdfy_CntAttr_Cnt_g = implode(',', $Ls_Mdfy_CntAttr);
	                $Ls_Mdfy_CntAttr_Cnt = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.' '.$Ls_Mdfy_CntAttr_Cnt_g; //echo $this->h3($Ls_Mdfy_CntAttr_Cnt.'  >---->');
	                $Ls_Mdf_CntAttr = $pdo_d->prepare($Ls_Mdfy_CntAttr_Cnt); $Ls_Mdf_CntAttr->execute();
					if(!$Ls_Mdf_CntAttr){ print_r($Ls_Mdf_CntAttr->errorInfo()); die(); }

				}

				//Actividades cnt
				/*echo $this->li('antes de crear columna en query');
				echo $this->li(print_r($__mdl_th_mdlcnt_a, true));

				foreach($__mdl_th_mdlcnt_a as $_k_th => $_v_th){
					echo $this->li('creando columna en query: '.$_v_th['tt_bd']);
					if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$_v_th['tt_bd'] ]) == 'no'){
						$Ls_Mdfy_MdlCntActv[] = ' ADD '.$_v_th['tt_bd'].' VARCHAR(60) ';
					}
				}*/

				if(count($__mdl_th_mdlcnt_a) > 0){
					for ($c = 1; $c <= count($__mdl_th_mdlcnt_a); $c++) {
						for ($d = 1; $d <= count( $__mdl_th_mdlcnt_a[$c] ); $d++) {
							if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_mdlcnt_a[$c][$d]['tt_bd'] ]) == 'no'){
								$Ls_Mdfy_MdlCntActv[] = ' ADD '.$__mdl_th_mdlcnt_a[$c][$d]['tt_bd'].' VARCHAR(60)';
							}
						}
					}
				}

				if( !isN($Ls_Mdfy_MdlCntActv) ){
					$Ls_Mdfy_MdlCntActv_Cnt_g = implode(',', $Ls_Mdfy_MdlCntActv);
					$Ls_Mdfy_MdlCntActv_Cnt = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_MdlCntActv_Cnt_g; /*echo $this->li($Ls_Mdfy_MdlCntActv_Cnt." ------- ")*/;
					$Ls_Mdf_MdlCntActv = $pdo_d->prepare($Ls_Mdfy_MdlCntActv_Cnt);
					$Ls_Mdf_MdlCntActv->execute();

					if(!$Ls_Mdf_MdlCntActv){

						print_r($Ls_Mdf_MdlCntActv->errorInfo());

						/*UPD_Dwn([
							'i'=>$__dwn_dt->id,
							'e'=>'5',
							'w'=>'No create columns: '.print_r($Ls_Mdf_MdlCntSbrnd->errorInfo(), true).' on '.$Ls_Mdfy_MdlCntSbrnd_Cnt
						]);

						exit();*/

					}

				}

				// Marcas

				for ($c = 1; $c <= count($__mdl_th_mdlcnt_s); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_mdlcnt_s[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_mdlcnt_s[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_MdlCntSbrnd[] = ' ADD '.$__mdl_th_mdlcnt_s[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

				if( !isN($Ls_Mdfy_MdlCntSbrnd) ){
					$Ls_Mdfy_MdlCntSbrnd_Cnt_g = implode(',', $Ls_Mdfy_MdlCntSbrnd);
					$Ls_Mdfy_MdlCntSbrnd_Cnt = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_MdlCntSbrnd_Cnt_g; /*echo $this->li($Ls_Mdfy_MdlCntActv_Cnt." ------- ")*/;
					$Ls_Mdf_MdlCntSbrnd = $pdo_d->prepare($Ls_Mdfy_MdlCntSbrnd_Cnt);
					$Ls_Mdf_MdlCntSbrnd->execute();

					if(!$Ls_Mdf_MdlCntSbrnd){

						print_r($Ls_Mdf_MdlCntSbrnd->errorInfo());

						/*UPD_Dwn([
								'i'=>$__dwn_dt->id,
								'e'=>'5',
								'w'=>'No create columns: '.print_r($Ls_Mdf_MdlCntSbrnd->errorInfo(), true).' on '.$Ls_Mdfy_MdlCntSbrnd_Cnt
						]);

						exit();*/

					}

				}

				// Tags

				for ($c = 1; $c <= count($__mdl_th_mdlcnt_t); $c++) {
	                for ($d = 1; $d <= count( $__mdl_th_mdlcnt_t[$c] ); $d++) {
	                    if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_mdlcnt_t[$c][$d]['tt_bd'] ]) == 'no'){
	                        $Ls_Mdfy_MdlCntTags[] = ' ADD '.$__mdl_th_mdlcnt_t[$c][$d]['tt_bd'].' VARCHAR(60)';
	                    }
	                }
	            }

				if( !isN($Ls_Mdfy_MdlCntTags) ){
					$Ls_Mdfy_MdlCntTags_Cnt_g = implode(',', $Ls_Mdfy_MdlCntTags);
					$Ls_Mdfy_MdlCntTags_Cnt = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_MdlCntTags_Cnt_g; /*echo $this->li($Ls_Mdfy_MdlCntActv_Cnt." ------- ")*/;
					$Ls_Mdf_MdlCntSbrnd = $pdo_d->prepare($Ls_Mdfy_MdlCntTags_Cnt);
					$Ls_Mdf_MdlCntSbrnd->execute();

					if(!$Ls_Mdf_MdlCntSbrnd){
						print_r($Ls_Mdf_MdlCntSbrnd->errorInfo());
					}

				}

	            if(!isN($pdo_d->est_col) && !isN($pdo_d->his_col)){

	                $updateSQL_UPD = sprintf("UPDATE ".TB_DWN." SET dwn_est_col=%s, dwn_his_col=%s WHERE id_dwn=%s",
	                   GtSQLVlStr($__mdl_th_est, "text"),
	                   GtSQLVlStr($__mdl_th_his, "text"),
	                   GtSQLVlStr($__dwn_dt->id, "int")); //echo $updateSQL_UPD;

	                $Result_UPD = $__cnx->_prc($updateSQL_UPD);

	            }


			//-------------------- Actualizacion de Historiales y Estados --------------------//

	            $_h_c = 1;
	            $_e_c = 1;
	            $_p_c = 1;
	            $_p_org_clg = 1;
	            $_p_org_emp = 1;
	            $_p_org_uni = 1;
	            $_p_noi = 1; //Motivo de no interes
				$_p_mdlcnt_a = 1;
				$_p_mdlcnt_actv = 1;
				$_p_mdlcnt_sbrnd = 1;
				$_p_mdlcnt_tags = 1;

	            $Ls_Rg->data_seek(0);

	            do{

	                echo $this->h3('Start Process #'.$row_Ls_Rg['ID']);

	                $_r_id = $row_Ls_Rg['id_dwnprc'];
	                $_pc_i = $row_Ls_Rg['ID'];

	                $_pc_h_o = $__col_his[ $_pc_i ];
	                $_pc_e_o = $__col_est[ $_pc_i ];
	                $_pc_p_a = $__col_prd_a[ $_pc_i ]; //Periodo Aplica
	                $_pc_org_clg = $__col_org_clg[ $_pc_i ]; //Organizacion Colegio
	                $_pc_org_emp = $__col_org_emp[ $_pc_i ]; //Organizacion Empresas
	                $_pc_org_uni = $__col_org_uni[ $_pc_i ]; //Organizacion Universidad
	                $_pc_noi = $__col_noi[ $_pc_i ]; //Motivo de no interes
					$_pc_a_mdlcnt_o = $__col_mdlcnt_attr[ $_pc_i ]; // Atributos mdl_cnt
					$_pc_mdlcnt_actv_o = $__col_mdlcnt_actv[ $_pc_i ]; //Actividades de Lead
					$_pc_mdlcnt_sbrnd_o = $__col_mdlcnt_sbrnd[ $_pc_i ]; //Actividades de Lead
					$_pc_mdlcnt_tags_o = $__col_mdlcnt_tags[ $_pc_i ]; //Tags de Lead

	                $__r_e = 'ok';
					$update_f = [];
					$update_his_f = [];
					$update_f_go = '';
					$update_his_f_go = '';

	                if(count($_pc_h_o) > 0){

	                    foreach($_pc_h_o as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_his_f[] = sprintf("Gestion_Fecha_$_h_c=%s, Gestion_Texto_$_h_c = ".DB_DWN.".ctjTx(%s), Gestion_Usuario_$_h_c = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr(/*ctjTx(*/$_v['f']/*,'out')*/, "text"),
	                                                GtSQLVlStr(/*ctjTx(*/$_v['t']/*,'out')*/, "text"),
	                                                GtSQLVlStr(/*ctjTx(*/$_v['u']/*,'out')*/, "text"));

	                        }
	                        $_h_c++;
	                    }

	                }


	                if(count($_pc_e_o) > 0){

	                    foreach($_pc_e_o as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Estado_Fecha_$_e_c=%s, Estado_Texto_$_e_c = ".DB_DWN.".ctjTx(%s), Estado_Usuario_$_e_c = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr(/*ctjTx(*/$_v['f']/*,'out')*/, "text"),
	                                                GtSQLVlStr(/*ctjTx(*/$_v['t']/*,'out')*/, "text"),
													GtSQLVlStr(/*ctjTx(*/$_v['u']/*,'out')*/, "text"));

	                        }

	                        $_e_c++;
	                    }
	                }

	                //-------------------- Periodo que aplica --------------------//
	                if(count($_pc_p_a) > 0){

	                    foreach($_pc_p_a as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Periodo_Aplica_$_p_c = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr($_v['t'], "text"));

	                        }

	                        $_p_c++;
	                    }
	                }


	                 //-------------------- Organizaciones Colegio --------------------//
	                if(count($_pc_org_clg) > 0){

	                    foreach($_pc_org_clg as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Colegio_$_p_org_clg = ".DB_DWN.".ctjTx(%s), Colegio_Tipo_Relacion_$_p_org_clg = ".DB_DWN.".ctjTx(%s)",
	                                                GtSQLVlStr($_v['t'], "text"),
	                                                GtSQLVlStr($_v['tpr'], "text")
	                                                );

	                        }

	                        $_p_org_clg++;
	                    }
	                }

	                 //-------------------- Organizaciones Empresas --------------------//
	                if(count($_pc_org_emp) > 0){

	                    foreach($_pc_org_emp as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Empresa_$_p_org_emp = ".DB_DWN.".ctjTx(%s), Empresa_Tipo_Relacion_$_p_org_emp = ".DB_DWN.".ctjTx(%s)",
	                                                GtSQLVlStr($_v['t'], "text"),
	                                                GtSQLVlStr($_v['tpr'], "text")
	                                                );

	                        }

	                        $_p_org_emp++;
	                    }
	                }

					//-------------------- Organizaciones Universidad --------------------//

	                if(count($_pc_org_uni) > 0){

	                    foreach($_pc_org_uni as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Universidad_$_p_org_uni = ".DB_DWN.".ctjTx(%s), Universidad_Tipo_Relacion_$_p_org_uni = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr($_v['t'], "text"),
	                                                GtSQLVlStr($_v['tpr'], "text")
	                                                );

	                        }

	                        $_p_org_uni++;
	                    }
	                }


					//-------------------- Motivo de no interes --------------------//

	                if(count($_pc_noi) > 0){

	                    foreach($_pc_noi as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Motivo_no_interes_$_p_noi = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr($_v['t'], "text"));

	                        }

	                        $_p_noi++;
	                    }
	                }

					//-------------------- Atributos cnt --------------------//
	                if(count($_pc_a_mdlcnt_o) > 0){
                        foreach($_pc_a_mdlcnt_o as $_k => $_v ){

							 if($_v['t'] != '' && $_v['t'] != NULL){

								//$__t = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $_v['t']); //Remplazar simbolos por Guion al piso _

								$__t = preg_replace('/[^A-Za-z0-9\-]/', '', $_v['t']);
                                $l_dt = LsDmc([ 'attr'=>$_v['attr'], 'id'=>$_v['v'], 'tp'=>'dt' ]); //Trae el valor de los atributos en texto

                                if( $l_dt->e == "ok" ){
                                    $_attr_cnt_vl = $l_dt->tt;
                                }else{
                                    $_attr_cnt_vl = $_v['v'];
                                }

                                $update_f[] = sprintf(" ".$__t." = %s ",
                                                    GtSQLVlStr($_attr_cnt_vl, "text"));

                            }
                            $_p_mdlcnt_a++;
                        }
					}

					//-------------------- Actividades cnt --------------------//

	                if(count($_pc_mdlcnt_actv_o) > 0){

	                    foreach($_pc_mdlcnt_actv_o as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Actividad_$_p_mdlcnt_actv = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr($_v['t'], "text"));

	                        }

	                        $_p_mdlcnt_actv++;
	                    }
					}

					//-------------------- Marcas mdl_cnt --------------------//

	                if(count($_pc_mdlcnt_sbrnd_o) > 0){

	                    foreach($_pc_mdlcnt_sbrnd_o as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Marca_$_p_mdlcnt_sbrnd = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr($_v['t'], "text"));

	                        }

	                        $_p_mdlcnt_sbrnd++;
	                    }
					}

					//-------------------- Tags mdl_cnt --------------------//

	                if(count($_pc_mdlcnt_tags_o) > 0){

	                    foreach($_pc_mdlcnt_tags_o as $_k => $_v ){

	                        if(!isN($_v['t'])){

	                            $update_f[] = sprintf("Tags_$_p_mdlcnt_tags = ".DB_DWN.".ctjTx(%s) ",
	                                                GtSQLVlStr($_v['t'], "text"));

	                        }

	                        $_p_mdlcnt_tags++;
	                    }
	                }


	                if(is_array($update_f)){ $update_f_go = implode(', ', $update_f); }

	                if(count($update_f) > 0 && !isN($update_f_go)){

	                    $updateSQL = "UPDATE "._BdStr(DBD).$__dwn_dt->tab." SET ".$update_f_go." WHERE id_dwnprc='".GtSQLVlStr($_r_id, "int")."'";

	                    if(!isN($updateSQL)){

							$Result = $__cnx->_prc($updateSQL);

							if(is_array($update_his_f)){
								$update_his_f_go = implode(', ', $update_his_f);
								$updateHisSQL = "UPDATE "._BdStr(DBD).$__dwn_dt->tab."_his SET ".$update_his_f_go." WHERE id_dwnprc='".GtSQLVlStr($_r_id, "int")."'";
	                   			if(!isN($updateHisSQL)){
									$ResultHis = $__cnx->_prc($updateHisSQL);
								}
							}else{
								$ResultHis = true;
							}

	                        if(!$Result && $ResultHis){
								$__r_e = 'no';
								$__r_all = 'no';
								$this->Dwn_Rd();
								echo $__w .= $this->err('No update columns: '.$__cnx->c_p->error.' on '.$updateSQL);

								/*UPD_Dwn([
										'i'=>$__dwn_dt->id,
										'e'=>'5',
										'w'=>'No update columns: '.$__cnx->c_p->error.' on '.$updateSQL
								]);

								exit(); */
							}
	                    }

	                }else{

						echo $this->err('count($update_f):'.count($update_f));
						//$this->Dwn_Rd();

					}
	                //echo $this->li(date("Y-m-d H:i:s")." Tab: ".$__dwn_dt->tab." -> periodo $Ls_Rg_His_Fx");


	                if($__r_e == 'ok' || count($update_f) == 0){

		                //echo $this->li(date("Y-m-d H:i:s")." __r_e: ".$__r_e." -> update_f:".count($update_f));

						$__pdwn_r = UPD_Dwn_R([ 'd'=>$__dwn_dt->tab, 'r'=>$_pc_i ]);

						if($__pdwn_r->e == 'ok'){
							echo $this->scss('Change Status '.$_pc_i.' to '.$__dwn_dt->tab);
						}

	                }else{

						echo $this->err($__w);

	                }

	                $_h_c = 1;
	                $_e_c = 1;
	                $_p_c = 1;
	                $_p_org_clg=1;
	                $_p_org_emp=1;
					$_p_org_uni=1;
					$_p_noi=1;
					$_p_mdlcnt_a=1;
					$_p_mdlcnt_actv=1;
					$_p_mdlcnt_sbrnd=1;
					$_p_mdlcnt_tags=1;

	            } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	    }else{

	        echo $this->err('Result Tot:'.Pdo_Fix_RwTot($Ls_Rg));
	        echo $this->err(print_r($Ls_Rg, true));
	        echo $this->err(date("Y-m-d H:i:s").' No! Records on main query '.$Ls_Qry);

	    }

		$__cnx->_clsr($Ls_Rg_His);
		$__cnx->_clsr($Ls_Rg_Est);
		$__cnx->_clsr($Ls_Rg_Prd_A);
		$__cnx->_clsr($Ls_Rg_Org);
		$__cnx->_clsr($Ls_Rg_Noi);
		$__cnx->_clsr($Ls_Rg_Est);
		$__cnx->_clsr($Ls_Rg_MdlCnt_Attr);
		$__cnx->_clsr($Ls_Rg_MdlCnt_Actv);
		$__cnx->_clsr($Ls_Rg_MdlCnt_Sbrnd);
		$__cnx->_clsr($Ls_Rg_MdlCnt_Tags);

		//$Ls_Rg_His->closeCursor();
		//$Ls_Rg_Est->closeCursor();

    }else{

		echo $this->err( 'Problem Query Cmpl:'.$__cnx->c_p->error );
		echo $Ls_Qry;
		$this->Dwn_Rd();

    }

    $__cnx->_clsr($Ls_Rg);


    //if($__r_all != 'no'){ UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'2' ]); }

?>