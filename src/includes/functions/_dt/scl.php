<?php

	function GtSclAccPostLs($p=NULL){

		global $__cnx;

		try {

			if($p['scl_acc']){ $__fl .= sprintf(' AND sclaccpost_sclacc = %s ', GtSQLVlStr($p['scl_acc'], "text")); }
			if($p['lst_fi'] != ''){
				$__fl .= sprintf(" AND (sclaccpost_created_time > %s)", GtSQLVlStr($p['lst_fi'], 'date'));
			}
			if($p['nxt']){ $__fl .= sprintf(' AND sclaccpost_created_time < %s ', GtSQLVlStr($p['nxt'], "date")); }
			if($p['lmt'] != ''){ $_limit = $p['lmt']; }else{ $_limit = 20; }



			$__fl .= ' AND id_sclacc IN ( 	SELECT clsclacc_sclacc
										FROM '._BdStr(DBM).TB_CL_SCL_ACC.'
										  	  INNER JOIN '._BdStr(DBM).TB_CL.' ON clsclacc_cl = id_cl
										WHERE clsclacc_sclacc = id_sclacc AND cl_enc = "'.DB_CL_ENC.'"
									)';


			$query_DtRg = sprintf(" SELECT *
									FROM "._BdStr(DBT).TB_SCL_ACC_POST."
										 INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccpost_sclacc = id_sclacc
									WHERE id_sclaccpost != '' {$__fl}
									ORDER BY sclaccpost_created_time DESC
									LIMIT {$_limit} ");

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$i=1;

					do{
						$_id = $row_DtRg['sclaccpost_enc'];

						if(!isN($_id)){

							$Vl['acc']['id'] = ctjTx($row_DtRg['sclacc_enc'],'in');

							$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccpost'];
							$Vl['ls'][$_id]['enc'] = $_id;
							$Vl['ls'][$_id]['sclacc'] = ctjTx($row_DtRg['sclaccpost_sclacc'],'in');
							$Vl['ls'][$_id]['postid'] = ctjTx($row_DtRg['sclaccpost_id'],'in');
							$Vl['ls'][$_id]['name'] = ctjTx($row_DtRg['sclaccpost_name'],'in', '', ['html'=>'no', 'schr'=>'ok', 'sslh'=>'ok' ]);
							$Vl['ls'][$_id]['link'] = ctjTx($row_DtRg['sclaccpost_link'],'in', '', ['html'=>'no', 'schr'=>'ok', 'sslh'=>'ok' ]);
							$Vl['ls'][$_id]['message'] = ctjTx($row_DtRg['sclaccpost_message'],'in', '', ['html'=>'no', 'schr'=>'ok', 'sslh'=>'ok' ]);
							$Vl['ls'][$_id]['caption'] = ctjTx($row_DtRg['sclaccpost_caption'],'in', '', ['html'=>'no', 'schr'=>'ok', 'sslh'=>'ok' ]);

														$Vl['ls'][$_id]['fullpic'] = ctjTx($row_DtRg['sclaccpost_full_picture'],'in');
							$Vl['ls'][$_id]['icon'] = ctjTx($row_DtRg['sclaccpost_icon'],'in');
							$Vl['ls'][$_id]['picture'] = ctjTx($row_DtRg['sclaccpost_picture'],'in');
							$Vl['ls'][$_id]['type'] = ctjTx($row_DtRg['sclaccpost_type'],'in');

							$Vl['ls'][$_id]['count']['shares'] = ctjTx($row_DtRg['sclaccpost_c_shares'],'in');
							$Vl['ls'][$_id]['count']['comments'] = ctjTx($row_DtRg['sclaccpost_c_comments'],'in');
							$Vl['ls'][$_id]['count']['reacts'] = ctjTx($row_DtRg['sclaccpost_c_reacts'],'in');

							$Vl['ls'][$_id]['dte']['f1'] = FechaESP_OLD($row_DtRg['sclaccpost_created_time'],7);
							$Vl['ls'][$_id]['dte']['f2'] = ctjTx($row_DtRg['sclaccpost_created_time'],'in');
							$Vl['ls'][$_id]['fi'] = ctjTx($row_DtRg['sclaccpost_fi'],'in');
							$Vl['ls'][$_id]['fa'] = ctjTx($row_DtRg['sclaccpost_fa'],'in');

							$___atch = json_decode($row_DtRg['sclaccpost_attch']);

							if($___atch != ''){
								$Vl['ls'][$_id]['attach'] = $___atch[0];
							}


						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = 'Query error:'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		} catch (Exception $e) {

		    $Vl['w'] = $e->getMessage();

		}

		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}



	function GtSclAccCnvLs($p=NULL){

		global $__cnx;

		if(!isN($p['scl_acc'])){ $__fl .= sprintf(' AND sclacccnv_sclacc = %s ', GtSQLVlStr($p['scl_acc'], "text")); }
		if(!isN($p['nxt'])){ $__fl .= sprintf(' AND sclacccnv_upd < %s ', GtSQLVlStr($p['nxt'], "date")); }

		if(!isN($p['est'])){
			$__fl .= sprintf(' AND sclacccnv_est = %s', GtSQLVlStr($p['est'], "int"));
		}else{
			$__fl .= sprintf(' AND sclacccnv_est = %s', GtSQLVlStr(385, "int"));
		}

		if($p['lst_fi'] != ''){
			$__fl .= sprintf(" AND (sclacccnv_upd > %s || sclacccnv_fa > %s) AND
								   ( id_sclacccnv IN (	SELECT sclacccnvmsg_sclacccnv
								   						FROM "._BdStr(DBT).TB_SCL_ACC_CNV_MSG."
								   						WHERE sclacccnvmsg_sclacccnv = id_sclacccnv AND sclacccnvmsg_fi > %s)
								   )",

								   GtSQLVlStr($p['lst_fi'], 'date'),
								   GtSQLVlStr($p['lst_fi'], 'date'),
								   GtSQLVlStr($p['lst_fi'], 'date'));
		}
		if($p['lmt'] != ''){ $_limit = $p['lmt']; }else{ $_limit = 20; }


		$__fl .= ' AND id_sclacc IN ( 	SELECT clsclacc_sclacc
										FROM '._BdStr(DBM).TB_CL_SCL_ACC.'
										  	  INNER JOIN '._BdStr(DBM).TB_CL.' ON clsclacc_cl = id_cl
										WHERE clsclacc_sclacc = id_sclacc AND cl_enc = "'.DB_CL_ENC.'"
									)';

		$query_DtRg = sprintf(" SELECT *,
									(SELECT

											CONCAT(
												\"{\"
													,'\"id\":\"', sclacccnvmsg_enc,'\",'
													,'\"from\":\"', sclacccnvmsg_from,'\"'
											    '}'
											)

									   FROM "._BdStr(DBT).TB_SCL_ACC_CNV_MSG."
									   WHERE sclacccnvmsg_sclacccnv = id_sclacccnv
									   ORDER BY sclacccnvmsg_created DESC
									   LIMIT 1
									) AS __last,

									"._QrySisSlcF(['als'=>'e', 'als_n'=>'estado']).",
									".GtSlc_QryExtra(['t'=>'fld', 'p'=>'estado', 'als'=>'e'])."

								FROM "._BdStr(DBT).TB_SCL_ACC_CNV."
									 INNER JOIN "._BdStr(DBT).TB_SCL_FROM." ON sclacccnv_from = id_sclfrom
									 INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclacccnv_sclacc = id_sclacc
									 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'sclacccnv_est', 'als'=>'e'])."

								WHERE id_sclacccnv != '' {$__fl}
								ORDER BY sclacccnv_upd DESC
								LIMIT {$_limit} ");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$i=1;
				$ord=1;

				do{
					$_id = $row_DtRg['sclacccnv_enc'];
					$_js = json_decode( $row_DtRg['__last'], true);

					if(!isN($_id)){

						if($i == 1){
							$Vl['last']['id'] = $_id;
							$i++;
						}

						$Vl['acc']['id'] = ctjTx($row_DtRg['sclacc_enc'],'in');

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclacccnv'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['ord'] = $ord;


						$___estado = json_decode($row_DtRg['___estado'], true);

						foreach($___estado as $k=>$v){
							$Vl['ls'][$_id]['est'][$v['key']] = $v;
						}


						$Vl['ls'][$_id]['sclacc'] = ctjTx($row_DtRg['sclacccnv_sclacc'],'in');
						$Vl['ls'][$_id]['cnvid'] = ctjTx($row_DtRg['sclacccnv_id'],'in');
						$Vl['ls'][$_id]['upd'] = ctjTx($row_DtRg['sclacccnv_upd'],'in');
						$Vl['ls'][$_id]['snpt'] = ctjTx($row_DtRg['sclacccnv_snpt'],'in', '', ['html'=>'ok', 'schr'=>'ok' ]);
						$Vl['ls'][$_id]['unr'] = ctjTx($row_DtRg['sclacccnv_unr'],'in');

						$Vl['ls'][$_id]['from']['id'] = ctjTx($row_DtRg['id_sclfrom'],'in');
						$Vl['ls'][$_id]['from']['nm'] = ctjTx($row_DtRg['sclfrom_nm'],'in');

						if(!isN($row_DtRg['sclfrom_pic'])){
							$Vl['ls'][$_id]['from']['pic'] = DMN_FLE_SCL_FROM.ctjTx($row_DtRg['sclfrom_pic'],'in');
						}else{
							$Vl['ls'][$_id]['from']['pic'] = '';
						}

						$Vl['ls'][$_id]['dte']['f1'] = FechaESP_OLD($row_DtRg['sclacccnv_upd'],7);
						$Vl['ls'][$_id]['dte']['f2'] = ctjTx($row_DtRg['sclacccnv_upd'],'in');

						$Vl['ls'][$_id]['lmsg']['me'] = ($_js['from']==$row_DtRg['sclacccnv_from']?'no':'ok');


						foreach($_js as $k=>$v){
							$Vl['ls'][$_id]['last'][$k] = ctjTx($v,'in');
						}

						$Vl['ls'][$_id]['fi'] = ctjTx($row_DtRg['sclacccnv_fi'],'in');
						$Vl['ls'][$_id]['fa'] = ctjTx($row_DtRg['sclacccnv_fa'],'in');

						$Vl['ls'][$_id]['ts']['fi'] = strtotime($row_DtRg['sclacccnv_fi']);
						$Vl['ls'][$_id]['ts']['fa'] = strtotime($row_DtRg['sclacccnv_fa']);

					}

					$ord++;
				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}

	function GtSclAccCnvMsgLs($p=NULL){

		global $__cnx;

		if($p['scl_acc_cnv']){ $__fl .= sprintf(' AND sclacccnvmsg_sclacccnv = %s ', GtSQLVlStr($p['scl_acc_cnv'], "text")); }

		if($p['ord']=='a'){ $_ord = 'ASC'; }else{ $_ord = 'DESC'; }

		$query_DtRg = sprintf(" SELECT *
								FROM "._BdStr(DBT).TB_SCL_ACC_CNV_MSG."
									 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_CNV." ON sclacccnvmsg_sclacccnv = id_sclacccnv
									 INNER JOIN "._BdStr(DBT).TB_SCL_FROM." ON sclacccnvmsg_from = id_sclfrom
									 INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclacccnv_sclacc = id_sclacc
								WHERE id_sclacccnvmsg != '' {$__fl}
								ORDER BY sclacccnvmsg_created {$_ord}, sclacccnvmsg_id {$_ord} ");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$i=1;
				$msg_grp=0;

				do{

					$_id = $row_DtRg['sclacccnvmsg_enc'];
					$json = str_replace("'", '"', $row_DtRg['sclacccnvmsg_tags']);
					$_tags = json_decode($json);

					if($_from != $row_DtRg['id_sclfrom']){ $msg_grp++; }

					if(!isN($_id)){



						$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclacccnvmsg'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['sclacc'] = ctjTx($row_DtRg['sclacccnv_sclacc'],'in');
						$Vl['ls'][$_id]['cnvid'] = ctjTx($row_DtRg['sclacccnvmsg_sclacccnv'],'in');
						$Vl['ls'][$_id]['created'] = ctjTx($row_DtRg['sclacccnvmsg_created'],'in');
						$Vl['ls'][$_id]['group'] = $msg_grp;
						$Vl['ls'][$_id]['own'] = ($row_DtRg['sclacccnvmsg_from']==$row_DtRg['sclacccnv_from']?'no':'ok');


						$Vl['grp'][$msg_grp]['tot']++;
						$Vl['grp'][$msg_grp]['id']=$msg_grp;
						$Vl['grp'][$msg_grp]['own']=$Vl['ls'][$_id]['own'];


						$Vl['ls'][$_id]['from']['id'] = ctjTx($row_DtRg['id_sclfrom'],'in');
						$Vl['ls'][$_id]['from']['nm'] = ctjTx($row_DtRg['sclfrom_nm'],'in');

						if(!isN($row_DtRg['sclfrom_pic'])){
							$Vl['ls'][$_id]['from']['pic'] = DMN_FLE_SCL_FROM.ctjTx($row_DtRg['sclfrom_pic'],'in');
						}else{
							$Vl['ls'][$_id]['from']['pic'] = '';
						}

						$Vl['ls'][$_id]['dte']['f1'] = FechaESP_OLD($row_DtRg['sclacccnvmsg_created'],8);
						$Vl['ls'][$_id]['dte']['f2'] = _DteHTML(['d'=>$row_DtRg['sclacccnvmsg_created'], 'nd'=>'no']);

						$Vl['ls'][$_id]['message'] = nl2br( ctjTx($row_DtRg['sclacccnvmsg_message'],'in', '', ['html'=>'ok', 'schr'=>'ok' ]) );
						$Vl['ls'][$_id]['sticker'] = ctjTx($row_DtRg['sclacccnvmsg_sticker'],'in');

						$___atch = json_decode($row_DtRg['sclacccnvmsg_attch']);

						if($___atch != ''){
							$Vl['ls'][$_id]['attach'] = $___atch[0];
						}

						try {

							foreach($_tags as $k=>$v){
								$vl=ctjTx($v->name,'in');
								$mre = explode(':', $vl);

								if(!isN($mre[1]) && !isN($mre[1])){
									$Vl['ls'][$_id]['tags'][$mre[0]] .= $mre[1];
								}else{
									$Vl['ls'][$_id]['tags'][$vl] = 'ok';
								}
							}

						}catch(Exception $e){
						    $Vl['ls'][$_id]['tags']['w'] = $e->getMessage();
						}

						$Vl['ls'][$_id]['fi'] = ctjTx($row_DtRg['sclacccnv_fi'],'in');
						$Vl['ls'][$_id]['fa'] = ctjTx($row_DtRg['sclacccnv_fa'],'in');

						$_from = $row_DtRg['id_sclfrom'];
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}

	function GtSclAccLs($p=NULL){

		global $__cnx;

		if(!isN($p['scl'])){ $__fl .= sprintf(' AND id_sclacc IN ( SELECT sclaccscl_acc FROM '._BdStr(DBT).TB_SCL_ACC_SCL.' WHERE sclaccscl_scl= %s)', GtSQLVlStr($p['scl'], "int")); }
		if(!isN($p['est'])){ $__fl .= sprintf(' AND sclacc_est = %s ', GtSQLVlStr($p['est'], "int")); }
		if(!isN($p['rds'])){ $__fl .= sprintf(' AND sclacc_rds = %s ', GtSQLVlStr($p['rds'], "int")); }

		if(!isN($p['cl'])){ $__fl .= sprintf('  AND (

												/*id_scl IN ( SELECT clscl_scl FROM '._BdStr(DBM).TB_CL_SCL.'
														 INNER JOIN '._BdStr(DBM).TB_CL.' ON clscl_cl = id_cl
														 WHERE clscl_scl = id_scl AND cl_enc = %s)

												AND
												*/

												id_sclacc IN ( 	SELECT clsclacc_sclacc
																FROM '._BdStr(DBM).TB_CL_SCL_ACC.'
																	  INNER JOIN '._BdStr(DBM).TB_CL.' ON clsclacc_cl = id_cl
																WHERE clsclacc_sclacc = id_sclacc AND cl_enc = %s)

											)


										', GtSQLVlStr($p['cl'], "text"), GtSQLVlStr($p['cl'], "text"));

		}

		if($p['us']){ $__fl .= sprintf(' AND id_scl IN
												(	SELECT usscl_scl
													FROM '._BdStr(DBM).TB_US_SCL.'
													WHERE usscl_scl = id_scl AND usscl_us = %s
												)  ', GtSQLVlStr($p['us'], "int")); }


		$query_DtRg = " SELECT *,

							(	SELECT COUNT(*)
								FROM "._BdStr(DBM).TB_CL_SCL_ACC."
									 INNER JOIN "._BdStr(DBM).TB_CL." ON clsclacc_cl = id_cl
								WHERE clsclacc_sclacc = id_sclacc AND cl_enc = '".DB_CL_ENC."'
							) AS _cl_v

							"/*,
							(SELECT COUNT(*) FROM ".TB_SCL_ACC_CNV." WHERE sclacccnv_sclacc = id_sclacc AND sclacccnv_est = 385) AS _tot_inbx,
							(SELECT COUNT(*) FROM ".TB_SCL_ACC_CNV." WHERE sclacccnv_sclacc = id_sclacc AND sclacccnv_est = 386) AS _tot_rdy,
							(SELECT COUNT(*) FROM ".TB_SCL_ACC_CNV." WHERE sclacccnv_sclacc = id_sclacc AND sclacccnv_est = 387) AS _tot_trsh */."
					    FROM  "._BdStr(DBT).TB_SCL_ACC_SCL."
					    	  INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccscl_acc = id_sclacc
					    	  INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
					    	  INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON sclacc_rds = id_sisslc
					    WHERE id_sclacc != '' $__fl
					    ORDER BY sclacc_nm ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				//$Vl['q'] = $query_DtRg.'->'.$Tot_DtRg;

				$Vl['e'] = 'ok';

				$i=1;

				do{

					$_id = $row_DtRg['sclacc_enc'];
					$_enc = $row_DtRg['sisslc_enc'];

					if(!isN($_id)){

						if($i == 1 && $row_DtRg['sclacc_est'] == 1){
							$Vl['network']['ls'][$_enc]['f'] = $_id;
							$i++;
						}

						$Vl['network']['ls'][$_enc]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
						$Vl['network']['ls'][$_enc]['enc'] = $_enc;

						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['id'] = $row_DtRg['id_sclacc'];
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['enc'] = $row_DtRg['sclacc_enc'];
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['est'] = mBln($row_DtRg['sclacc_est']);
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['cest'] = mBln( $row_DtRg['_cl_v']==0?2:1 );

						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['nm'] = ctjTx($row_DtRg['sclacc_nm'],'in');
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['id'] = ctjTx($row_DtRg['sclacc_id'],'in');

						$__accscl = $row_DtRg['id_sclaccscl'];
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['acc_scl'][$__accscl]['tkn'] = ctjTx($row_DtRg['sclaccscl_tkn'],'in');
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['acc_scl'][$__accscl]['tlvd'] = ctjTx($row_DtRg['sclaccscl_tlvd'],'in');
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['acc_scl'][$__accscl]['perms'] = ctjTx($row_DtRg['sclaccscl_perms'],'in');

						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['img'] = DMN_FLE_SCL_ACC.ctjTx($row_DtRg['sclacc_img'],'in');
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['cvr'] = DMN_FLE_SCL_ACC_CVR.ctjTx($row_DtRg['sclacc_cvr'],'in');

						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['tot']['rdy'] = $row_DtRg['_tot_rdy'];
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['tot']['inbx'] = $row_DtRg['_tot_inbx'];
						$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['tot']['trsh'] = $row_DtRg['_tot_trsh'];


						if($p['d']['cnv']=='ok'){
							$Vl['network']['ls'][$_enc]['acc']['ls'][$_id]['cnv'] = GtSclAccCnvLs([ 'scl_acc'=>$row_DtRg['id_sclacc'], 'lst_fi'=>$p['lst_fi'] ]);
						}

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}


	function GtSclLs($p=NULL){

		global $__cnx;

		if($p['us']){ $__fl .= sprintf(' AND id_scl IN ( SELECT usscl_scl FROM '._BdStr(DBM).TB_US_SCL.' WHERE usscl_scl = id_scl AND usscl_us = %s) ', GtSQLVlStr($p['us'], "int")); }
		if($p['cl']){ $__fl .= sprintf(' AND id_scl IN ( SELECT clscl_scl FROM '._BdStr(DBM).TB_CL_SCL.' INNER JOIN '._BdStr(DBM).TB_CL.' ON clscl_cl = id_cl WHERE clscl_scl = id_scl AND cl_enc = %s) ', GtSQLVlStr($p['cl'], "text")); }
		if($p['rds']){ $__fl .= sprintf(' AND scl_rds = %s ', GtSQLVlStr($p['rds'], "int")); }


		$query_DtRg = " SELECT *,
							  (SELECT COUNT(*) FROM "._BdStr(DBT).TB_SCL." WHERE id_scl != '' $__fl ) AS ___tot
					    FROM  "._BdStr(DBT).TB_SCL."
					    	  INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON scl_rds = id_sisslc
					    	  RIGHT JOIN "._BdStr(DBT).TB_SCL_ATTR." ON sclattr_scl = id_scl
					    WHERE id_scl != '' $__fl ORDER BY scl_nm ASC";

		$Vl['q'] = $query_DtRg;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $row_DtRg['___tot'];

			if($Tot_DtRg > 0){

				$__i=1;

				do{
					$_id = $row_DtRg['scl_enc'];
					$_enc = $row_DtRg['sisslc_enc'];

					if(!isN($_id)){

						if($__i == 1){
							$Vl['scl'][$_enc]['f'] = $_id;
							$i++;
						}

						$Vl['scl'][$_enc][$_id]['id'] = $row_DtRg['id_scl'];
						$Vl['scl'][$_enc][$_id]['enc'] = $_id;
						$Vl['scl'][$_enc][$_id]['nm'] = ctjTx($row_DtRg['scl_nm'],'in');
						$Vl['scl'][$_enc][$_id]['scl']['i'] = ctjTx($row_DtRg['scl_rds'],'in');
						$Vl['scl'][$_enc][$_id]['scl']['id'] = ctjTx($row_DtRg['scl_id'],'in');
						$Vl['scl'][$_enc][$_id]['scl']['attr'][ $row_DtRg['sclattr_key'] ] = ctjTx($row_DtRg['sclattr_vl'],'in');


						$__accls = GtSclAccLs(['o'=>'a', 'us'=>$p['us'], 'scl'=>$row_DtRg['id_scl'] ]);
						$Vl['scl'][$_enc][$_id]['acc'] = $__accls;


						//$__acc_all_ls = GtSclAccLs(['o'=>'a', 'us'=>$p['us'], 'est'=>1, 'rds'=>$row_DtRg['id_sisslc'] ]);
						$Vl['scl'][$_enc]['acc'] = $__acc_all_ls;



					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtSclDt($p){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND scl_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBT).TB_SCL.'
										  RIGHT JOIN '._BdStr(DBT).TB_SCL_ATTR.' ON sclattr_scl = id_scl
									WHERE id_scl != "" '.$__f);
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				do{

					$Vl['id'] = $row_DtRg['id_scl'];
					$Vl['nm'] = ctjTx($row_DtRg['scl_nm'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['scl_enc'],'in');
					$Vl['attr'][ $row_DtRg['sclattr_key'] ] = ctjTx($row_DtRg['sclattr_vl'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);

			return($rtrn);
		}
	}




	function GtSclAccFormLs($p=NULL){

		global $__cnx;

		if( !isN($p['tp']) && $p['tp'] == 'enc' && !isN($p['sclacc'])){
			$__fl .= sprintf(' AND sclaccform_sclacc = ( SELECT id_sclacc FROM '._BdStr(DBT).TB_SCL_ACC.' WHERE sclacc_enc = %s) ', GtSQLVlStr($p['sclacc'], "text"));
		}else if($p['sclacc']){
			$__fl .= sprintf(' AND sclaccform_sclacc = %s ', GtSQLVlStr($p['sclacc'], "int"));
		}

		if(!isN($p['tt'])){
			$__tt = GtSQLVlStr('%'.$p['tt'].'%', "text");
			$__fl_tt = " AND sclaccform_name LIKE $__tt ";
		}

		$query_DtRg = " SELECT * ,
								(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBT).TB_SCL_ACC_FORM_QUS."
									WHERE
										id_sclaccform = sclaccformqus_sclaccform
								) as _tot,
								(


									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD."
									INNER JOIN  "._BdStr(DBT).TB_SCL_ACC_FORM_QUS." ON sclaccformqusfld_qus = id_sclaccformqus
									WHERE
										id_sclaccform = sclaccformqus_sclaccform
									{$__fl}

								) as _tot_form

								FROM "._BdStr(DBT).TB_SCL_ACC_FORM."
								WHERE id_sclaccform != '' {$__fl} AND
									  sclaccform_status = 1 AND
									  sclaccform_est = "._CId('ID_SISEST_OK')." $__fl_tt
								ORDER BY sclaccform_created_time DESC LIMIT 10";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$i=1;
				$msg_grp=0;

				do{

					$_id = $row_DtRg['sclaccform_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccform'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['sclaccform_name'],'in');
						$Vl['ls'][$_id]['created'] = ctjTx($row_DtRg['sclaccform_created_time'],'in');
						$Vl['ls'][$_id]['form_id'] = ctjTx($row_DtRg['sclaccform_id'],'in');
						$Vl['ls'][$_id]['status'] = ctjTx($row_DtRg['sclaccform_status'],'in');
						$Vl['ls'][$_id]['mdl'] = ctjTx($row_DtRg['sclaccform_mdl'],'in');
						$Vl['ls'][$_id]['tot'] = ctjTx($row_DtRg['_tot'],'in');
						$Vl['ls'][$_id]['tot_form'] = ctjTx($row_DtRg['_tot_form'],'in');

						$Vl['ls'][$_id]['md'] = GtSisMdDt([ 'id'=>$row_DtRg['sclaccform_md'] ]);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}

	/* ------ Social Usuario ------ */
	function GtSclAccUsLs($p=NULL){

		global $__cnx;

		if($p['sclacc']){ $__fl .= sprintf(' AND ussclacc_sclacc = %s ', GtSQLVlStr($p['sclacc'], "int")); }

		$query_DtRg = sprintf(" SELECT
								*, ( SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_US_SCL_ACC."
									WHERE
										id_us = ussclacc_us
									$__fl ) __est
								FROM "._BdStr(DBM).TB_US."
								INNER JOIN "._BdStr(DBM).TB_US_CL." ON id_us = uscl_us
								WHERE uscl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".DB_CL_ENC."') ORDER BY __est DESC ");

		$DtRg = $__cnx->_qry($query_DtRg);

		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;
		$Vl['tot'] = $Tot_DtRg;

		if($Tot_DtRg > 0){

			$i=1;
			$msg_grp=0;

			do{

				$_id = $row_DtRg['us_enc'];

				if(!isN($_id)){

					$Vl['ls'][$_id]['id'] = $row_DtRg['id_us'];
					$Vl['ls'][$_id]['enc'] = $_id;
					$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['us_nm'],'in').'  '.ctjTx($row_DtRg['us_ap'],'in');
					$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');
					if( !isN($row_DtRg['us_img']) ){

						$Vl['ls'][$_id]['img'] = _ImVrs([ 'img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

					}else{
						$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
						$Vl['ls'][$_id]['img'] = $_img;
					}

				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);
		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}


	function GtSclAccUs_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_US_SCL_ACC." WHERE
											ussclacc_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) AND
											ussclacc_sclacc = (SELECT id_sclacc FROM "._BdStr(DBT).TB_SCL_ACC." WHERE sclacc_enc = %s)",
											GtSQLVlStr($p['id'], "text"),
											GtSQLVlStr($p['id_sclacc'], "text"));

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


	function GtSclAccUs_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($p['id'].'-'.$p['id_sclacc']);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_US_SCL_ACC." (
							ussclacc_enc, ussclacc_us, ussclacc_sclacc) VALUES
							(%s, (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s), (SELECT id_sclacc FROM "._BdStr(DBT).TB_SCL_ACC." WHERE sclacc_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p['id'], "text"),
							GtSQLVlStr($p['id_sclacc'], "text"));

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

	function GtSclAccGrpLs($p=NULL){

		global $__cnx;

		if($p['sclacc']){ $__fl .= sprintf(' AND clgrpsclacc_sclacc = %s ', GtSQLVlStr($p['sclacc'], "int")); }

		$query_DtRg = sprintf(" SELECT
								* , ( SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_CL_GRP_SCL_ACC."
									WHERE
										id_clgrp = clgrpsclacc_clgrp
									$__fl ) __est
								FROM "._BdStr(DBM).TB_CL_GRP."
								WHERE clgrp_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".DB_CL_ENC."') ");

		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;

		$Vl['tot'] = $Tot_DtRg;

		if($Tot_DtRg > 0){
			do{

				$_id = $row_DtRg['clgrp_enc'];

				if(!isN($_id)){
					$Vl['ls'][$_id]['id'] = $row_DtRg['id_clgrp'];
					$Vl['ls'][$_id]['enc'] = $_id;
					$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['clgrp_nm'],'in');
					$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');
				}
			}while($row_DtRg = $DtRg->fetch_assoc());
		}

		$__cnx->_clsr($DtRg);

		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}


	function GtSclAccGrp_Eli($p=NULL){

		global $__cnx;

		$query_DtRg =   sprintf("DELETE FROM ".TB_CL_GRP_SCL_ACC." WHERE
											clgrpsclacc_clgrp = (SELECT id_clgrp FROM ".TB_CL_GRP." WHERE clgrp_enc = %s) AND
											clgrpsclacc_sclacc = (SELECT id_sclacc FROM "._BdStr(DBT).TB_SCL_ACC." WHERE sclacc_enc = %s)",

											GtSQLVlStr($p['id'], "text"),
											GtSQLVlStr($p['id_sclacc'], "text"));
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


	function GtSclAccGrp_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($p['id'].'-'.$p['id_sclacc']);

		$query_DtRg =   sprintf("INSERT INTO ".TB_CL_GRP_SCL_ACC." (
							clgrpsclacc_enc, clgrpsclacc_clgrp, clgrpsclacc_sclacc) VALUES
							(%s, (SELECT id_clgrp FROM ".TB_CL_GRP." WHERE clgrp_enc = %s), (SELECT id_sclacc FROM "._BdStr(DBT).TB_SCL_ACC." WHERE sclacc_enc = %s)) ",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p['id'], "text"),
							GtSQLVlStr($p['id_sclacc'], "text"));

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

	function GtSclAccDt($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclacc_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }
			if(!isN($p['acc_id'])){ $__f .= sprintf(' AND sclacc_id= %s ', GtSQLVlStr($p['acc_id'], 'text')); }

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBT).TB_SCL_ACC.'
										 INNER JOIN '._BdStr(DBT).TB_SCL_ACC_SCL.' ON sclaccscl_acc = id_sclacc
										 RIGHT JOIN '._BdStr(DBT).TB_SCL_ACC_ATTR.' ON sclaccattr_sclacc = id_sclacc
									WHERE id_sclacc != "" '.$__f.'
									LIMIT 1');

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_sclacc'];
						$Vl['nm'] = ctjTx($row_DtRg['sclacc_nm'],'in');
						$Vl['cid'] = ctjTx($row_DtRg['sclacc_id'],'in');
						$Vl['enc'] = ctjTx($row_DtRg['sclacc_enc'],'in');
						$Vl['enc'] = ctjTx($row_DtRg['sclacc_enc'],'in');
						$Vl['rds'] = ctjTx($row_DtRg['sclacc_rds'],'in');
						$Vl['est'] = mBln($row_DtRg['sclacc_est']);

						$__accscl = $row_DtRg['sclaccscl_enc'];
						$Vl['acc_scl'][$__accscl]['tkn'] = ctjTx($row_DtRg['sclaccscl_tkn'],'in');
						$Vl['acc_scl'][$__accscl]['tlvd'] = ctjTx($row_DtRg['sclaccscl_tlvd'],'in');
						$Vl['acc_scl'][$__accscl]['perms'] = ctjTx($row_DtRg['sclaccscl_perms'],'in');


						if(is_numeric($row_DtRg['sclaccattr_vl'])){
							$__vl = _Nmb($row_DtRg['sclaccattr_vl'], 3);
						}else{
							$__vl = $row_DtRg['sclaccattr_vl'];
						}

						$Vl['attr'][ $row_DtRg['sclaccattr_key'] ] = ctjTx($__vl,'in');

						$Vl['img'] = DMN_FLE_SCL_ACC.ctjTx($row_DtRg['sclacc_img'],'in');
						$Vl['cvr'] = DMN_FLE_SCL_ACC_CVR.ctjTx($row_DtRg['sclacc_cvr'],'in');
						$Vl['fi'] = ctjTx($row_DtRg['sclacc_fi'],'in');
						$Vl['fa'] = ctjTx($row_DtRg['sclacc_fa'],'in');

						$Vl['us'] = GtSclAccUsLs([ 'sclacc'=>$row_DtRg['id_sclacc'] ]);
						$Vl['grp'] = GtSclAccGrpLs([ 'sclacc'=>$row_DtRg['id_sclacc'] ]);

						if($p['form'] == 'ok'){
							$Vl['form'] = GtSclAccFormLs([ 'sclacc'=>$row_DtRg['id_sclacc'] ]);
						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = 'Query error:'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}




	function GtSclAccFormDt($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclaccform_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }
			if(!isN($p['form_id'])){ $__f .= sprintf(' AND sclaccform_id= %s ', GtSQLVlStr($p['form_id'], 'text')); }

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}



			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBT).TB_SCL_ACC_FORM.'
										 INNER JOIN '._BdStr(DBT).TB_SCL_ACC.' ON sclaccform_sclacc = id_sclacc
										 INNER JOIN '._BdStr(DBT).TB_SCL_ACC_SCL.' ON sclaccscl_acc = id_sclacc
										 INNER JOIN '._BdStr(DBT).TB_SCL.' ON sclaccscl_scl = id_scl
									WHERE id_sclacc != "" '.$__f.'
									LIMIT 1');

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccform'];
					$Vl['nm'] = ctjTx($row_DtRg['sclacc_nm'],'in');
					$Vl['tlvd'] = ctjTx($row_DtRg['sclaccscl_tlvd'],'in');

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}




	function GtSclAccFormAttrLs($p=NULL){

		global $__cnx;

		if($p['enc']){ $__fl .= sprintf(' AND sclaccformattr_sclaccform = ( SELECT id_sclaccform FROM '._BdStr(DBT).TB_SCL_ACC_FORM.' WHERE sclaccform_enc = %s ) ', GtSQLVlStr($p['enc'], "text")); }

		$query_DtRg = sprintf(" SELECT *
								FROM "._BdStr(DBT).TB_SCL_ACC_FORM_ATTR."
								WHERE id_sclaccformattr != '' {$__fl}
								ORDER BY sclaccformattr_key DESC ");

		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;

		$Vl['tot'] = $Tot_DtRg;

		if($Tot_DtRg > 0){

			$i=1;
			$msg_grp=0;

			do{

				$_id = $row_DtRg['sclaccformattr_enc'];

				if(!isN($_id)){

					$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccformattr'];
					$Vl['ls'][$_id]['enc'] = $_id;
					$Vl['ls'][$_id]['key'] = ctjTx($row_DtRg['sclaccformattr_key'],'in');
					$Vl['ls'][$_id]['vl'] = ctjTx($row_DtRg['sclaccformattr_vl'],'in');

				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);
		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}

	function GtSclAccQusLs($p=NULL){

		global $__cnx;

		if($p['enc']){
			$__fl .= sprintf(' AND sclaccformqus_sclaccform = ( SELECT id_sclaccform FROM '._BdStr(DBT).TB_SCL_ACC_FORM.' WHERE sclaccform_enc=%s ) ', GtSQLVlStr($p['enc'], "text"));
		}

		$query_DtRg = sprintf(" SELECT *
								FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS."
								WHERE id_sclaccformqus != '' {$__fl}
								ORDER BY sclaccformqus_key DESC ");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$i=1;
				$msg_grp=0;

				do{

					$_id = $row_DtRg['sclaccformqus_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccformqus'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['tpe'] = ctjTx($row_DtRg['sclaccformqus_type'],'in');
						$Vl['ls'][$_id]['opc'] = GtSclAccQusOptLs(['id'=>$row_DtRg['id_sclaccformqus']]);
						$Vl['ls'][$_id]['key'] = ctjTx($row_DtRg['sclaccformqus_key'],'in');
						$Vl['ls'][$_id]['vl'] = ctjTx($row_DtRg['sclaccformqus_label'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}

	function GtSclAccQusOptLs($p=NULL){

		global $__cnx;

		if($p['id']){ $__fl .= sprintf(' AND sclaccformqusopt_sclaccformqus = %s ', GtSQLVlStr($p['id'], "text")); }

		$query_DtRg = sprintf(" SELECT *
								FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT."
								WHERE id_sclaccformqusopt != '' {$__fl}
								ORDER BY sclaccformqusopt_key DESC ");

		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;

		$Vl['tot'] = $Tot_DtRg;

		if($Tot_DtRg > 0){

			$i=1;
			$msg_grp=0;

			do{

				$_id = $row_DtRg['sclaccformqusopt_enc'];

				if(!isN($_id)){

					$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccformqusopt'];
					$Vl['ls'][$_id]['enc'] = $_id;
					$Vl['ls'][$_id]['key'] = ctjTx($row_DtRg['sclaccformqusopt_key'],'in');
					$Vl['ls'][$_id]['vl'] = ctjTx($row_DtRg['sclaccformqusopt_vl'],'in');

				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);
		if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
		return($rtrn);

	}


	function GtSclAccCnvDt($p){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclacccnv_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND id_sclacccnv= %s ', GtSQLVlStr($p['id'], 'int')); }

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf("	SELECT *,

										(SELECT

												CONCAT(
													\"{\"
														,'\"id\":\"', sclacccnvmsg_enc,'\",'
														,'\"from\":\"', sclacccnvmsg_from,'\"'
												    '}'
												)

										   FROM "._BdStr(DBT).TB_SCL_ACC_CNV_MSG."
										   WHERE sclacccnvmsg_sclacccnv = id_sclacccnv
										   ORDER BY sclacccnvmsg_created DESC
										   LIMIT 1
										) AS __last


									FROM "._BdStr(DBT).TB_SCL_ACC_CNV."
										 INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclacccnv_sclacc = id_sclacc
										 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
										 INNER JOIN "._BdStr(DBT).TB_SCL_FROM." ON sclacccnv_from = id_sclfrom
									WHERE id_sclacc != '' {$__f}
									LIMIT 1
								");

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						$_js = json_encode($row_DtRg['__last'], true);

						$Vl['id'] = $row_DtRg['id_sclacccnv'];
						$Vl['enc'] = ctjTx($row_DtRg['sclacccnv_enc'],'in');
						$Vl['cnv_id'] = ctjTx($row_DtRg['sclacccnv_id'],'in');

						$Vl['acc']['id'] = ctjTx($row_DtRg['id_sclacc'],'in');
						$Vl['acc']['enc'] = ctjTx($row_DtRg['sclacc_enc'],'in');

						$__accscl = $row_DtRg['sclaccscl_enc'];
						$Vl['acc_scl'][$__accscl]['tkn'] = ctjTx($row_DtRg['sclaccscl_tkn'],'in');
						$Vl['acc_scl'][$__accscl]['tlvd'] = ctjTx($row_DtRg['sclaccscl_tlvd'],'in');
						$Vl['acc_scl'][$__accscl]['perms'] = ctjTx($row_DtRg['sclaccscl_perms'],'in');

						$Vl['from']['id'] = ctjTx($row_DtRg['id_sclfrom'],'in');
						$Vl['from']['nm'] = ctjTx($row_DtRg['sclfrom_nm'],'in');

						if(!isN($row_DtRg['sclfrom_pic'])){
							$Vl['from']['pic'] = DMN_FLE_SCL_FROM.ctjTx($row_DtRg['sclfrom_pic'],'in');
						}else{
							$Vl['from']['pic'] = '';
						}


						$Vl['upd'] = ctjTx($row_DtRg['sclacccnv_upd'],'in');
						$Vl['unr'] = ctjTx($row_DtRg['sclacccnv_unr'],'in');


						$Vl['snpt'] = ctjTx($row_DtRg['sclacccnv_snpt'],'in', '', ['html'=>'ok', 'schr'=>'ok' ]);

						$Vl['lmsg']['me'] = ($_js['from']==$row_DtRg['sclacccnv_from']?'no':'ok');

						$Vl['fi'] = ctjTx($row_DtRg['sclacc_fi'],'in');
						$Vl['fa'] = ctjTx($row_DtRg['sclacc_fa'],'in');

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				echo $__cnx->c_r->error.' on '.compress_code($query_DtRg);

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}



	function GtSclAccCnvMsgDt($p){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclacccnvmsg_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBT).TB_SCL_ACC_CNV_MSG.'
										 INNER JOIN '._BdStr(DBT).TB_SCL_ACC_CNV.' ON sclacccnvmsg_sclacccnv = id_sclacccnv
										 INNER JOIN '._BdStr(DBT).TB_SCL_ACC.' ON sclacccnv_sclacc = id_sclacc
										 INNER JOIN '._BdStr(DBT).TB_SCL_FROM.' ON sclacccnvmsg_from = id_sclfrom
									WHERE id_sclacc != "" '.$__f);
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_sclacccnvmsg'];
				$Vl['enc'] = ctjTx($row_DtRg['sclacccnvmsg_enc'],'in');
				$Vl['msg_id'] = ctjTx($row_DtRg['sclacccnvmsg_id'],'in');

				$Vl['cnv'] = GtSclAccCnvDt(['id'=>$row_DtRg['id_sclacccnv']]);

				$Vl['from']['id'] = ctjTx($row_DtRg['id_sclfrom'],'in');
				$Vl['from']['nm'] = ctjTx($row_DtRg['sclfrom_nm'],'in');


				if(!isN($row_DtRg['sclfrom_pic'])){
					$Vl['from']['pic'] = DMN_FLE_SCL_FROM.ctjTx($row_DtRg['sclfrom_pic'],'in');
				}else{
					$Vl['from']['pic'] = '';
				}

			}

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);

			return($rtrn);
		}
	}

	function GtSclAccPostDt($p){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclaccpost_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclaccpost_id= %s ', GtSQLVlStr($p['id'], 'int')); }


			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBT).TB_SCL_ACC_POST."
										 INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccpost_sclacc = id_sclacc
										 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
									WHERE id_sclaccpost != '' ".$__f);

			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl['id'] = $row_DtRg['id_sclaccpost'];
					$Vl['enc'] = ctjTx($row_DtRg['sclaccpost_enc'],'in');
					$Vl['cnv_id'] = ctjTx($row_DtRg['sclaccpost_id'],'in');
					$Vl['nm'] = ctjTx($row_DtRg['sclaccpost_name'],'in', '', ['html'=>'ok', 'schr'=>'ok' ]);
					$Vl['msg'] = ctjTx($row_DtRg['sclaccpost_message'],'in', '', ['html'=>'ok', 'schr'=>'ok' ]);
					$Vl['cpt'] = ctjTx($row_DtRg['sclaccpost_caption'],'in', '', ['html'=>'ok', 'schr'=>'ok' ]);

					$Vl['acc']['id'] = ctjTx($row_DtRg['id_sclacc'],'in');
					$Vl['acc']['enc'] = ctjTx($row_DtRg['sclacc_enc'],'in');

					$__accscl = $row_DtRg['sclaccscl_enc'];
					$Vl['acc_scl'][$__accscl]['tkn'] = ctjTx($row_DtRg['sclaccscl_tkn'],'in');
					$Vl['acc_scl'][$__accscl]['tlvd'] = ctjTx($row_DtRg['sclaccscl_tlvd'],'in');
					$Vl['acc_scl'][$__accscl]['perms'] = ctjTx($row_DtRg['sclaccscl_perms'],'in');

					$Vl['crtd'] = ctjTx($row_DtRg['sclaccpost_created_time'],'in');
					$Vl['link'] = ctjTx($row_DtRg['sclaccpost_link'],'in');
					$Vl['icon'] = ctjTx($row_DtRg['sclaccpost_icon'],'in');
					$Vl['type'] = ctjTx($row_DtRg['sclaccpost_type'],'in');

					$___atch = json_decode($row_DtRg['sclaccpost_attch']);

					if($___atch != ''){
						$Vl['attach'] = $___atch[0];
					}

					$Vl['pic']['bsc'] = ctjTx($row_DtRg['sclaccpost_picture'],'in');
					$Vl['pic']['full'] = ctjTx($row_DtRg['sclaccpost_full_picture'],'in');

					$Vl['count']['shares'] = ctjTx($row_DtRg['sclaccpost_c_shares'],'in');
					$Vl['count']['comments'] = ctjTx($row_DtRg['sclaccpost_c_comments'],'in');
					$Vl['count']['reacts'] = ctjTx($row_DtRg['sclaccpost_c_reacts'],'in');

					$Vl['fi'] = ctjTx($row_DtRg['sclaccpost_fi'],'in');
					$Vl['fa'] = ctjTx($row_DtRg['sclaccpost_fa'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);

			return($rtrn);
		}
	}


	function GtSclFromDt($p){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclfrom_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclfrom_id= %s ', GtSQLVlStr($p['id'], 'text')); }


			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBT).TB_SCL_FROM."
									WHERE id_sclfrom != '' ".$__f);

			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['id'] = $row_DtRg['id_sclfrom'];
				$Vl['enc'] = ctjTx($row_DtRg['sclfrom_enc'],'in');

			}

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);

			return($rtrn);
		}
	}


	function Scl_F_URL($p=NULL){
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		$i=1;
	    if(preg_match_all($reg_exUrl, $p['txt'], $urls)) {
	        foreach($urls[0] as $url){
	            $Vl['url']['url'.$i] = $url;
	            $i++;
	        }
	    }
		return(_jEnc($Vl));
	}

	function setcan($p=NULL){

		$Vl['get']['url'] = $p['url'];

		if(!isN($p['url'])){
			libxml_use_internal_errors(true);
			$url = $p['url'];
			$doc = new DomDocument();
			$doc->loadHTML(file_get_contents($url));
			$xpath = new DOMXPath($doc);
			$query = '//*/meta[starts-with(@property, \'og:\')]';
			$metas = $xpath->query($query);

			foreach ($metas as $meta) {
			    $property = $meta->getAttribute('property');
			    $content = $meta->getAttribute('content');
			    $Vl['data'][ str_replace(':','_',$property) ] = $content;
			}
		}

		return(_jEnc($Vl));
	}

	function GtSclDshDayDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$__dt_1 = date('Y-m-01');
		$__dt_2 = date('Y-m-d');

		$query_DtRg =  "SELECT
							id_sclaccformleads,
							DATE_FORMAT( sclaccformleads_fi, '%Y-%m-%d' ) AS f_i,
							COUNT( DISTINCT id_sclaccformleads ) AS tot
						FROM
							"._BdStr(DBT).TB_SCL_ACC_FORM_LEADS."
							INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM." ON sclaccformleads_form = id_sclaccform
							INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
							INNER JOIN "._BdStr(DBM).TB_CL_SCL_ACC." ON clsclacc_sclacc = id_sclacc
						WHERE
							clsclacc_cl = ".DB_CL_ID." AND
							DATE_FORMAT( sclaccformleads_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."'
							AND '".$__dt_2."'
						GROUP BY
							DATE_FORMAT( sclaccformleads_fi, '%Y-%m-%d' )";

		$DtRg = $__cnx->_qry($query_DtRg);
		if($DtRg){

			$Vl['e'] = 'ok';

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					$_r['ctg'][$row_DtRg['f_i']] = $row_DtRg['f_i'];
					$_r['d'][$row_DtRg['f_i']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				for($i=$__dt_1;$i<=$__dt_2;$i = date('Y-m-d', strtotime($i .'+ 1 days'))){

					$__ctg[] = $i;
					$_d[] = ( !isN($Vl_Grph->d->{$i}->tot) ) ? (int)$Vl_Grph->d->{$i}->tot : 0 ;

				}

				$Vl['c'] = $__ctg;
				$Vl['o'] = $_d;

			}

		}else{

			$Vl['w'] = 'Query error:'.$__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtSclDshForms($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';


		if(!isN($p['pag']) ){ $pg = $p['pag']; }else{ $pg = 0; }
		if(!isN($p['vl']) ){ $__fl = "AND sclaccform_name LIKE '%".$p['vl']."%' "; }else{ $vl = ''; }

		$query_DtRg = "SELECT
							sclaccform_name, sclaccform_enc, sclaccform_leads, sclaccform_leads_expired,
							sclaccform_created_time, sclaccform_tot_qus, sclaccform_f_chk, sclaccform_fi,
							sclaccform_mdl, sclaccform_md, sismd_img,
							(
								SELECT
									COUNT(*)
								FROM
									"._BdStr(DBT).TB_SCL_ACC_FORM_QUS."
								WHERE
									id_sclaccform = sclaccformqus_sclaccform
							) as _tot,
							(
								SELECT
									COUNT(*)
								FROM
									"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD."
									INNER JOIN  "._BdStr(DBT).TB_SCL_ACC_FORM_QUS." ON sclaccformqusfld_qus = id_sclaccformqus
								WHERE
									id_sclaccform = sclaccformqus_sclaccform
							) as _tot_form,
							"._QrySisSlcF(['als'=>'e', 'als_n'=>'estado']).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'estado', 'als'=>'e'])."
						FROM
							"._BdStr(DBT).TB_SCL_ACC_FORM."
							".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'sclaccform_est', 'als'=>'e'])."
							INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
							INNER JOIN "._BdStr(DBM).TB_CL_SCL_ACC." ON clsclacc_sclacc = id_sclacc
							LEFT JOIN "._BdStr(DBM).TB_SIS_MD." ON sclaccform_md = id_sismd

						WHERE
							sclaccform_est = "._CId('ID_SISEST_OK')." AND
							sclaccform_status = 1 AND
							clsclacc_cl = ".DB_CL_ID."
							{$__fl}
						ORDER BY
						sclaccform_created_time DESC LIMIT $pg, 10";

		$Vl['es'] = $query_DtRg;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{

					$_r['d'][$row_DtRg['sclaccform_enc']]['id'] = ctjTx($row_DtRg['sclaccform_enc'],'in');
					$_r['d'][$row_DtRg['sclaccform_enc']]['nm'] = ctjTx($row_DtRg['sclaccform_name'],'in');
					$_r['d'][$row_DtRg['sclaccform_enc']]['mdl'] = ctjTx($row_DtRg['sclaccform_mdl'],'in');
					$_r['d'][$row_DtRg['sclaccform_enc']]['md'] = GtSisMdDt([ 'id'=>$row_DtRg['sclaccform_md'] ]);

					$_r['d'][$row_DtRg['sclaccform_enc']]['ld'] = ctjTx($row_DtRg['sclaccform_leads'],'in');
					$_r['d'][$row_DtRg['sclaccform_enc']]['ld_exd'] = ctjTx($row_DtRg['sclaccform_leads_expired'],'in');

					$_r['d'][$row_DtRg['sclaccform_enc']]['crd_tm'] = FechaESP([ 'f'=>$row_DtRg['sclaccform_created_time'], 't'=>'cmpr' ]);
					$_r['d'][$row_DtRg['sclaccform_enc']]['f_chk'] = FechaESP([ 'f'=>$row_DtRg['sclaccform_f_chk'], 't'=>'cmpr' ]);



					$_r['d'][$row_DtRg['sclaccform_enc']]['tot_qus'] = ctjTx($row_DtRg['_tot'],'in');
					$_r['d'][$row_DtRg['sclaccform_enc']]['tot_qus_a'] = ctjTx($row_DtRg['_tot_form'],'in');

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['o'] = $_r;
			}else{
				$Vl['tot'] = 0;
			}

		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtSclDshLdScr($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = "SELECT
							COUNT( * ) AS tot, sismd_img, sismd_tt, id_sismd, id_sisslc, id_sismd
						FROM
							".TB_CNT."
							INNER JOIN ".TB_MDL_CNT." ON mdlcnt_cnt = id_cnt
							INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cnt_cld = id_sisslc
						WHERE
							id_sismd = "._CId('SIS_MD_FB')." OR id_sismd = "._CId('SIS_MD_IN')."
						GROUP BY
							mdlcnt_m, id_sisslc
						";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				$prm = 0;

				do{

					if($row_DtRg['id_sisslc'] == _CId('ID_CLD_BAD')){ $_ptj = 1; }
					elseif($row_DtRg['id_sisslc'] == _CId('ID_CLD_RGLR')){ $_ptj = 2; }
					elseif($row_DtRg['id_sisslc'] == _CId('ID_CLD_MDM')){ $_ptj = 3; }
					elseif($row_DtRg['id_sisslc'] == _CId('ID_CLD_GOOD')){ $_ptj = 4; }
					elseif($row_DtRg['id_sisslc'] == _CId('ID_CLD_EXCL')){ $_ptj = 5; }

					$r[$row_DtRg['id_sismd']]['tot_rg'][] = $tot_rg = $row_DtRg['tot'];
					$r[$row_DtRg['id_sismd']]['tot_prm'][] = $row_DtRg['tot'] * $_ptj;

					if(isN($row_DtRg['sismd_img'])){
						$img = DMN_IMG_ESTR_SVG.'unknow.svg';
					}else{
						$img = DMN_FLE.'sis/md/'.ctjTx($row_DtRg['sismd_img'],'in');
					}

					$_r['d'][$row_DtRg['id_sismd']] = [
										'md'=>ctjTx($row_DtRg['sismd_tt'],'in'),
										'img'=>$img,
										'tot'=>0,
										'ptj'=>''
									];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['tot'] = count($_r['d']);

				foreach($r as $k => $v){

					$p_tot = array_sum($v['tot_prm'])/array_sum($v['tot_rg']);

					$p_tot_r = round($p_tot);

					if($p_tot_r == 1){ $_ptj = _CId('ID_CLD_BAD'); }
					elseif($p_tot_r == 2){ $_ptj = _CId('ID_CLD_RGLR'); }
					elseif($p_tot_r == 3){ $_ptj = _CId('ID_CLD_MDM'); }
					elseif($p_tot_r == 4){ $_ptj = _CId('ID_CLD_GOOD'); }
					elseif($p_tot_r == 5){ $_ptj = _CId('ID_CLD_EXCL'); }

					$_r['d'][$k]['tot'] = str_replace(".", ",", round($p_tot,2));
					$_r['d'][$k]['ptj'] = LsSis_Cld([ 'id'=>'cnt_cld'.$k, 'v'=>'id', 'va'=>$_ptj, 'rq'=>2, 'dsbl'=>'ok' ]);


				}
				$_r['da'] = $r;
				$Vl['o'] = $_r;

			}

		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtSclDshFac($p=NULL){
		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = "SELECT
							id_clare, clare_tt, mdlcnt_m, sismd_tt, sismd_clr, COUNT(*) as tot
						FROM
							".TB_MDL_CNT."
							INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
							INNER JOIN ".TB_MDL_ARE." ON mdlare_mdl = id_mdl
							INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
							INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
						WHERE
							clare_tp = "._CId('ID_CLARETP_FAC')." AND (mdlcnt_m = "._CId('SIS_MD_FB')." OR mdlcnt_m = "._CId('SIS_MD_IN').")
						GROUP BY id_clare, mdlcnt_m";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{
					$r['ctg'][$row_DtRg['id_clare']] = $row_DtRg['clare_tt'];

					$r['d'][$row_DtRg['mdlcnt_m']]['nm'] = $row_DtRg['sismd_tt'];
					$r['d'][$row_DtRg['mdlcnt_m']]['clr'] = $row_DtRg['sismd_clr'];
					$r['d'][$row_DtRg['mdlcnt_m']][$row_DtRg['id_clare']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($r);

				foreach($Vl_Grph->ctg as $k => $v){
					$__ctg[] = $v;

					foreach($Vl_Grph->d as $_k => $_v){

						$_d[$_k]['name'] = $_v->nm;
						$_d[$_k]['color'] = $_v->clr;
						$_d[$_k]['data'][] = ( !isN($_v->{$k}->tot) ) ? (int)$_v->{$k}->tot : 0 ;

					}

				}

				$Vl['c'] = $__ctg;
				$Vl['o'] = $_d;

			}else{
				$Vl['tot'] = 0;
			}

		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}



	function GtEmlLs($p=NULL){

		global $__cnx;

		if(defined('DB_CL_ENC')){ $__f .= " AND cl_enc = '".DB_CL_ENC."' "; }
		if(defined('SISUS_ID')){ $__f .= " AND useml_us = '".GtSQLVlStr(SISUS_ID, "int")."' "; }

		$query_DtRg = "	SELECT 	id_useml, id_eml, eml_enc, eml_eml, eml_nm, eml_img, useml_view,
								"._QrySisSlcF(['als'=>'a', 'als_n'=>'avatar']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'avatar', 'als'=>'a'])."
						FROM "._BdStr(DBM).TB_US_EML."
							INNER JOIN "._BdStr(DBM).TB_US." ON useml_us = id_us
							INNER JOIN "._BdStr(DBM).TB_CL." ON useml_cl = id_cl
							INNER JOIN "._BdStr(DBM).TB_CL_EML." ON cleml_cl = id_cl
							INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON useml_eml = id_eml
							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'eml_avtr', 'als'=>'a'])."
						WHERE id_useml != '' {$__f}
						GROUP BY id_eml
						ORDER BY id_useml DESC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$i=1;
				$msg_grp=0;

				do{

					$_id = $row_DtRg['eml_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_eml'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['eml'] = ctjTx($row_DtRg['eml_eml'],'in');
						$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['eml_nm'],'in');
						$Vl['ls'][$_id]['view'] = mBln($row_DtRg['useml_view']);


						if(!isN($row_DtRg['eml_img'])){
							$Vl['ls'][$_id]['img'] = _ImVrs(['img'=>$row_DtRg['eml_img'], 'f'=>DMN_FLE_EML ]);
						}

						if(!isN($row_DtRg['avatar_sisslc_img'])){
							$__avtr_img = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['avatar_sisslc_img'],'in');
							$Vl['ls'][$_id]['avtr'] = $__avtr_img;
						}

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

	}


?>