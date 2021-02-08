<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_imap_cnv_msg' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$__Imap = new CRM_Imap();
		$__Eml = new CRM_Eml();

		$_AUTOP_d = $this->RquDt([ 't'=>'imap_cnv_msg', 'm'=>1 ]);
		//$_AUTOP_d->e = 'ok';
		//$_AUTOP_d->hb = 'ok';

	//-------------------- AUTO TIME CHECK - END --------------------//

	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

		$_box = $this->_argv->_box ? $this->_argv->_box : Php_Ls_Cln($_GET['_box']);
		$_eml = $this->_argv->_eml ? $this->_argv->_eml : Php_Ls_Cln($_GET['_eml']);

		//------------------- Start ---------------------//

		if($this->_s_eml->tot > 0){

			foreach($this->_s_eml->ls as $_eml_k=>$_eml_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'eml_imap_cnv_msg', 'cl'=>$_eml_v->cl->id ])->est == 'ok' ){

					try {

						if(!isN($_g_alw->lmt)){ $_lmt_msg = $_g_alw->lmt; }else{ $_lmt_msg = 50; }

						if(class_exists('CRM_Cnx')){

							$___datprcs = [];

							if(!isN($_box)){ $__f_icnv .= sprintf(' AND id_emlbox=%s ', $_box); }
							elseif(!isN($_eml)){ $__f_icnv .= sprintf(' AND emlbox_eml=%s ', $_eml); }

							$__f_icnv .= ' AND (
												/*(NOW() > DATE_ADD(emlbox_msg_chk, INTERVAL +5 MINUTE) || emlbox_msg_chk IS NULL) OR */
												(NOW() > DATE_ADD(eml_msg_chk, INTERVAL +2 MINUTE) || eml_msg_chk IS NULL)
											)';

							$Ls_Qry = " SELECT id_eml, eml_eml, id_emlbox, emlbox_enc, emlbox_id, emlbox_luid/*,
												SELECT () AS _luid_msg*/
										FROM "._BdStr(DBT).TB_THRD_EML_BOX."
											INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlbox_eml = id_eml
										WHERE   id_emlbox IS NOT NULL AND
												emlbox_luid IS NOT NULL AND
												emlbox_est = '1' AND
												emlbox_upd = '1' AND
												eml_onl = '1' AND
												emlbox_jnk = '2' AND
												eml_tp = '"._CId('ID_SISEML_IMAP')."' AND
												emlbox_eml = '".$_eml_v->eml->id."'
												{$__f_icnv}
										ORDER BY RAND()
										/*ORDER BY emlbox_msg_chk ASC*/
										/*LIMIT {$_lmt_msg}*/";

							$LsImapCnvMsg = $__cnx->_qry($Ls_Qry);

							//echo compress_code($Ls_Qry);

							if($LsImapCnvMsg){

								$row_LsImapCnvMsg = $LsImapCnvMsg->fetch_assoc();
								$Tot_LsImapCnvMsg = $LsImapCnvMsg->num_rows;

								echo $this->h1('Imap - Mail - Messages '.$Tot_LsImapCnvMsg);

								if($Tot_LsImapCnvMsg > 0){


									do {

										$___datprcs[] = $row_LsImapCnvMsg;


									} while ($row_LsImapCnvMsg = $LsImapCnvMsg->fetch_assoc());

								}

								$this->Rqu([ 't'=>'imap_cnv_msg', 'no_all'=>'ok' ]);

							}else{

								echo $this->err($__cnx->c_r->error);

							}

							$__cnx->_clsr($LsImapCnvMsg);

							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									require(GL_EML_IMAP.'imap_cnv_msg_in.php');

								}

							}

						}

					} catch (StartSQL $e) {

						echo $e->getMessage();

					}

				}else{

					echo $this->nallw($_eml_v->cl->nm.' ('.$_eml_v->eml->eml.') Global Email - Imap - Get Messages - Off');

				}

			}

		}

	}

}else{

	echo $this->nallw('Global Email - Imap - Get Messages - Off');

}

?>