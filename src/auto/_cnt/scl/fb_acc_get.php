<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_acc_get' ]);

if( $_g_alw->est == 'ok' ){

	try {


		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'fb_acc', 'm'=>30 ]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';

		//-------------------- AUTO TIME CHECK - END --------------------//


		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){


			$_lmt_msg = 20;
			$__SclBd = new CRM_Thrd();

			if(class_exists('CRM_Cnx')){

				$___datprcs = [];

				$Ls_Qry = " SELECT  id_scl, scl_nm, scl_id, sclattr_vl,
									( scl_f_chk < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst
							FROM "._BdStr(DBT).TB_SCL."
								 INNER JOIN "._BdStr(DBT).TB_SCL_ATTR." ON sclattr_scl = id_scl
							WHERE 	scl_id IS NOT NULL AND
									scl_est = 1 AND
									scl_rds = ".GtSQLVlStr(344, 'int')." AND
									sclattr_key = 'tknlvd'
									{$__fl}

							GROUP BY sclattr_scl
							HAVING __rd_lst = 1 OR __rd_lst IS NULL
							ORDER BY sclattr_fa DESC
							LIMIT 10
						";

				//echo compress_code($Ls_Qry);

				$LsFbUpd = $__cnx->_qry($Ls_Qry);


				if($LsFbUpd){

					$row_LsFbUpd = $LsFbUpd->fetch_assoc(); $Tot_LsFbUpd = $LsFbUpd->num_rows;

					echo $this->h1('Facebook - FanPages Accounts - Get -'.$Tot_LsFbUpd);

					if($Tot_LsFbUpd > 0){

						do {

							try {

								$___datprcs[] = $row_LsFbUpd;
								echo $this->li('Lock Before to ID '.$row_LsFbUpd['id_sclacc']);

							} catch (Exception $e) {

								echo $this->err($e->getMessage());

							}

						} while ($row_LsFbUpd = $LsFbUpd->fetch_assoc());

						echo $this->ul($___accin);

					}
				}

				$__cnx->_clsr($LsFbUpd);

				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__hb='no';

						$__RquDt = $this->RquDt([ 't'=>'scl_get_acc', 'id'=>$___datprcs_v['id_scl'], 'm'=>5 ]);

						$___updchk = $__SclBd->UpdF(['t'=>'scl', 'f'=>'scl_f_chk', 'id'=>$___datprcs_v['id_scl'], 'v'=>SIS_F_D2 ]);

						//$__hb='ok'; // Tempo

						echo $this->h2($___datprcs_v['scl_nm'] . ' search accounts '.$__hb);

						if(!isN($__RquDt->fa)){
							$__diff = _Df_Dte($__RquDt->fa, SIS_F_TS);
							if($__diff->h > 1){ $__hb='ok'; } // Corre de nuevo 24 horas despues
						}else{
							$__hb='ok';
						}


						if($__hb == 'ok'){

							$__btch = $this->Rqu([
											't'=>'scl_get_acc',
											'id'=>$___datprcs_v['id_scl']
										]);

							$__get_acc = _NwFb_Ac_Ls([
												'id'=>$___datprcs_v['scl_id'],
												'access_token'=>$___datprcs_v['sclattr_vl']
											]);

							if(!isN($__get_acc) && isN($__get_acc->w)){

								foreach($__get_acc as $__get_acc_k=>$__get_acc_v){

									$__SclBd->__t = 'acc';
									$__SclBd->acc_scl = $___datprcs_v['id_scl'];
									$__SclBd->acc_id = $__get_acc_v->id;
									$__SclBd->acc_nm = $__get_acc_v->name;
									$__SclBd->scl_rds_id = _CId('ID_APITHRD_FB');
									$__SclBd->acc_img = $__get_acc_v->picture->url;
									$__SclBd->acc_cvr = $__get_acc_v->cover->source;
									$__SclBd->acc_attr = $__get_acc_v;
									$__SclBd->acc_tkn = $__get_acc_v->access_token;
									$__Prc = $__SclBd->In();

									if($__Prc->e == 'ok' && isN($__Prc->w)){
										echo $this->scss($__get_acc_v->id.' - '.$__get_acc_v->name.' created successfull');
									}else{
										echo $this->err( $__get_acc_v->id.' - '.$__get_acc_v->name.' not created successfully '.print_r($__Prc->w, true) );
									}

								}

							}else{

								echo $this->err($__get_acc->w.'No data for fetch on '.$__get_acc->url);

							}

						}else{

							$___accin .= $this->li(ctjTx($___datprcs_v['scl_nm'],'in'). $this->Spn(' actualizada hace 24 horas','', '', 'color:red;') );

						}

					}

				}

			}

			$this->Rqu([ 't'=>'fb_acc' ]);

		}else{

			echo $this->h1('Facebook'.$this->Spn('FanPages Accounts - Run On Next'), 'Auto_Tme_Prg');

		}

	} catch (Exception $e) {


		$this->Rqu([ 't'=>'fb_acc' ]);

		echo $e->getMessage();

	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Get Pages of Account - Off');

}


?>