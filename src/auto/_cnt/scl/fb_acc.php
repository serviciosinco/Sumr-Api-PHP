<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_acc' ]);

if( $_g_alw->est == 'ok' ){

	try {

		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'fb_acc', 'm'=>5 ]);

		//-------------------- AUTO TIME CHECK - END --------------------//

		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

			$_lmt_msg = 20;
			$__SclBd = new CRM_Thrd();

			if(class_exists('CRM_Cnx')){

				$___datprcs = [];

				$Ls_Qry = " SELECT id_sclacc, sclacc_enc, sclacc_nm, sclacc_id
							FROM "._BdStr(DBT).TB_SCL_ACC."
								  INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
								  INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
							WHERE 	sclacc_id IS NOT NULL AND
									sclacc_est = 1 AND
									scl_rds = ".GtSQLVlStr(_Cns('ID_APITHRD_FB'), 'int')."
									{$__fl}

							GROUP BY sclaccscl_acc
							LIMIT 500";

				$LsAccFb = $__cnx->_qry($Ls_Qry);

				//echo compress_code( $Ls_Qry );

				if($LsAccFb){

					$row_LsAccFb = $LsAccFb->fetch_assoc(); $Tot_LsAccFb = $LsAccFb->num_rows;

					echo $this->h1('Facebook - FanPages Accounts '.$Tot_LsAccFb);

					if($Tot_LsAccFb > 0){

						do {

							try {

								$___datprcs[] = $row_LsAccFb;
								echo $this->li('Lock Before to ID '.$row_LsAccFb['id_sclacc']);

							} catch (Exception $e) {

								echo $this->err($e->getMessage());

							}

						} while ($row_LsAccFb = $LsAccFb->fetch_assoc());

					}

				}

				$__cnx->_clsr($LsAccFb);

				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__hb='no';

						$__RquDt = $__SclBd->RquDt(['tp'=>'acc', 'acc'=>$___datprcs_v['id_sclacc'] ]);

						if(!isN($__RquDt->fa)){
							$__diff = _Df_Dte($__RquDt->fa, SIS_F_TS);
							if($__diff->d > 1){ $__hb='ok'; } // Corre de nuevo 24 horas despues
						}else{
							$__hb='ok';
						}

						if($__hb == 'ok'){

							$__btch = $__SclBd->Rqu([
											'tp'=>'acc',
											'acc'=>$___datprcs_v['id_sclacc']
										]);


							$__acc_dt = GtSclAccDt([ 'enc'=>$___datprcs_v['sclacc_enc'] ]);

							foreach($__acc_dt->acc_scl as $_scl_k=>$_scl_v){

								$__account = _NwFb_Ac_Dt([ 'id'=>$__acc_dt->cid, 'access_token'=>$_scl_v->tlvd ]);

								if(!isN($__account->name)){

									$__SclBd->__t = 'acc';
									$__SclBd->acc_scl = $__acc_dt->cid;
									$__SclBd->acc_id = $__acc_dt->cid;
									$__SclBd->acc_nm = $__account->name;
									$__SclBd->acc_img = $__account->picture->url;
									$__SclBd->acc_cvr = $__account->cover->source;
									$__SclBd->acc_attr = $__account;
									$__Prc = $__SclBd->In();

									if($__Prc->e == 'ok'){
										break;
									}
								}

							}

							$___accin .= $this->li(
											$this->h1(
												$this->ul(
													$this->li('Account:'.$___datprcs_v['id_sclacc']).
													$this->li('-> FanPage:'. $___datprcs_v['sclacc_id']).
													$this->li(Strn('Cid:').$__acc_dt->cid.' : ').
													$this->li(Strn('Picture:').$__account->picture->url).
													$this->li(Strn('Source:').$__account->cover->source)
												)
											)
										);

						}else{

							$___accin .= $this->li(ctjTx($___datprcs_v['sclacc_nm'],'in'). $this->Spn(' actualizada hace 24 horas','', '', 'color:red;') );

						}

						echo $this->ul($___accin);

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

	echo $this->nallw('Global Social Media - Facebook - Accounts Info - Off');

}

?>