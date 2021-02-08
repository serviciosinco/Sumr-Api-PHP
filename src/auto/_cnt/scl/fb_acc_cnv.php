<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_acc_cnv' ]);

if( $_g_alw->est == 'ok' ){

	try {


		//-------------------- AUTO TIME CHECK - START --------------------//

			$__SclBd = new CRM_Thrd();
			$_AUTOP_d = $this->RquDt(['t'=>'fb_acc_cnv', 'm'=>1 ]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';

		//-------------------- AUTO TIME CHECK - END --------------------//


		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){


			$_cnv = Php_Ls_Cln($_GET['_cnv']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);

			$_lmt_msg = 50;

			if(class_exists('CRM_Cnx')){

				$___datprcs = [];

				if(!isN($_cnv)){
					$_cnvdt = GtSclAccCnvDt(['enc'=>$_cnv]);
					$__fl .= sprintf(' AND id_sclacc = %s', GtSQLVlStr($_cnvdt->acc->id, 'int')) ;
					$_lmt_msg = 2;
					$_cnv_sch = $_cnvdt->cnv_id;
				}

				$Ls_Qry = " SELECT id_sclacc, sclacc_nm, sclacc_id, scl_rds,
									(	SELECT sclacccnv_upd
										FROM "._BdStr(DBT).TB_SCL_ACC_CNV."
										WHERE sclacccnv_sclacc = id_sclacc
										ORDER BY sclacccnv_upd DESC
										LIMIT 1
									) AS ___cnv_upd,

									( sclacc_f_chk_cnv < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst

							FROM "._BdStr(DBT).TB_SCL_ACC."
								INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
								INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
							WHERE 	sclacc_id IS NOT NULL AND
									sclacc_est = 1 AND
									scl_rds = ".GtSQLVlStr(_CId('ID_APITHRD_FB'), 'int')."
									{$__fl}

							GROUP BY id_sclacc DESC
							HAVING __rd_lst = 1 OR __rd_lst IS NULL
							LIMIT 10
				";

				$LsAccFbCnv = $__cnx->_qry($Ls_Qry);

				if($LsAccFbCnv){

					$rwAccFbCnv = $LsAccFbCnv->fetch_assoc();
					$Tot_LsAccFbCnv = $LsAccFbCnv->num_rows;

					echo $this->h1('Facebook - FanPages Accounts - Messages '.$Tot_LsAccFbCnv);

					if($Tot_LsAccFbCnv > 0){

						do {

							try {

								$___datprcs[] = $rwAccFbCnv;
								echo $this->li('Lock Before to ID '.$rwAccFbCnv['id_sclacc']);

							} catch (Exception $e) {

								echo $this->err($e->getMessage());

							}

						} while ($rwAccFbCnv = $LsAccFbCnv->fetch_assoc());

					}else{

						echo $this->li( compress_code('Query Executed:'.$Ls_Qry) );

					}

				}else{

					echo $this->err( $__cnx->c_r->error );

				}

				$__cnx->_clsr($LsAccFbCnv);

				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__diff = _Df_Dte($___datprcs_v['___cnv_upd'], SIS_F_TS);

						if($___datprcs_v['___cnv_upd']=='' || ($__diff->Y > 0 || $__diff->m > 0) ){

							$_lmt_msg = 5000;

						}else{

							if(!isN($___datprcs_v['___cnv_upd'])){

								if(!isN($_lmt)){
									$_lmt_msg = $_lmt;
								}elseif($__diff->d > 0){
									$_lmt_msg = 20;
								}elseif($__diff->H > 0){
									$_lmt_msg = 10;
								}elseif($__diff->i > 0){
									$_lmt_msg = 5;
								}elseif($__diff->l > 0){
									$_lmt_msg = 2;
								}else{
									$_lmt_msg = 2;
								}
							}
						}

						$__RquDt = $__SclBd->RquDt(['tp'=>'cnv', 'acc'=>$___datprcs_v['id_sclacc'] ]);

						$___updchk = $__SclBd->UpdF(['t'=>'acc', 'f'=>'sclacc_f_chk_cnv', 'id'=>$___datprcs_v['id_sclacc'], 'v'=>SIS_F_D2 ]);

						if(!isN($__RquDt->nxt)){ $_lmt_msg = ''; }

						$__id_acc = $___datprcs_v['id_sclacc'];

						$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$__id_acc ]);

						if($___tkns->tot > 0){

							foreach($___tkns->ls as $_tkn_k=>$_tkn_v){

								//---------- Try Tokens - Start ----------//

									echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in')/*.' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl*/);

									require(GL_SCL_FB.'fb_acc_cnv_in.php');

									if($__tkn_scss == 'ok'){
										//echo $this->scss('Token '.$_tkn_v->vl.' success, not need another');
										break;
									}

								//---------- Try Tokens - End ----------//

							}

						}

					}

					echo $this->ul($___accin);

				}

			}

			$this->Rqu([ 't'=>'fb_acc_cnv' ]);

		}else{

			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Messages - Run On Next'), 'Auto_Tme_Prg');
			//print_r($_AUTOP_d);

		}

	} catch (Exception $e) {

		$this->Rqu([ 't'=>'fb_acc_cnv' ]);
		echo $e->getMessage();

	}


}else{

	echo $this->nallw('Global Social Media - Facebook - Conversations Off');

}

?>