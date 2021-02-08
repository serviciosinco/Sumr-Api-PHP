<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_imap_box' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt([ 't'=>'imap_box', 'm'=>1 ]);
		//$_AUTOP_d->e = 'ok';
		//$_AUTOP_d->hb = 'ok';
		define('UNLCK_MIN', '5'); // Minutes Wait Unlock
		$___datprcs = [];

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

		try {

			$_eml = $this->_argv->_eml ? $this->_argv->_eml : Php_Ls_Cln($_GET['_eml']);

			if(!isN($_g_alw->lmt)){ $_lmt_msg = $_g_alw->lmt; }else{ $_lmt_msg = 5; }

			$__EmlBd = new CRM_Eml();
			$__EmlBd->_box_e();

			if(class_exists('CRM_Cnx')){

				if(!isN($_eml)){ $__f .= sprintf(' AND id_eml = %s ', $_eml); }

				$Ls_Qry = " SELECT  id_eml, eml_enc, eml_eml
							FROM "._BdStr(DBT).TB_THRD_EML."
							WHERE eml_tp = '"._CId('ID_SISEML_IMAP')."' AND
								  eml_onl = 1 /*AND
								  (eml_cnct = 2 || eml_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE) AND
								  (eml_rd = 2 || eml_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE)*/
								  {$__f}
						";

				echo compress_code( $Ls_Qry );

				$Ls_Imap_Lbl = $__cnx->_qry($Ls_Qry);

				if($Ls_Imap_Lbl){

					$row_Ls_Imap_Lbl = $Ls_Imap_Lbl->fetch_assoc();
					$Tot_Ls_Imap_Lbl = $Ls_Imap_Lbl->num_rows;

					echo $this->h1('Imap - Mail - Box '.$Tot_Ls_Imap_Lbl);

					if($Tot_Ls_Imap_Lbl > 0){

						$__Imap = new CRM_Imap();

						do {

							try{

								$___datprcs[] = $row_Ls_Imap_Lbl;

							}catch(Exception $e){
								echo $this->err( $e->getMessage() );
							}

						} while ($row_Ls_Imap_Lbl = $Ls_Imap_Lbl->fetch_assoc());

					}else{

						echo $this->err( 'No records to process' );

					}

					$this->Rqu([ 't'=>'imap_box' ]);

				}else{

					echo $this->err($__cnx->c_r->error);

				}

				$__cnx->_clsr($Ls_Imap_Lbl);


				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						echo $this->h2('Process '.$___datprcs_v['eml_eml']);

						$__upd_rd = $__EmlBd->Upd_Eml_Fld([
							't'=>'eml',
							'id'=>$___datprcs_v['eml_enc'],
							'fld'=>[
								['k'=>'eml_rd_f','v'=>SIS_F_TS],
								['k'=>'eml_rd','v'=>1]
							]
						]);

						if($__upd_rd->e == 'ok'){

							$__id_eml = $___datprcs_v['id_eml'];
							$__Imap->c_eml = $__id_eml;
							$labels = $__Imap->_fldr(); //print_r( $labels );

							if(!isN( $labels->ls )){

								foreach ($labels->ls as $k=>$v){ print_r( $v );

									//echo '('. $__sch[ ( $this->mbox->count() - 1 ) ] .') '.$__sch_message_v->getNumber().' -> '.$p['nxt'].' -> '.count($__sch).PHP_EOL;
									//$tot = $this->mbox->count();

									if(!isN($v->id)){ //print_r( $v );

										echo $this->li('ID Eml:'.$__id_eml);
										echo $this->li('ID Box:'.$v->id);

										if(	strpos(strtolower($v->id), 'junk') !== false){
											$is_jnk = 1;
										}else{
											$is_jnk = 2;
										}

										if(	strpos(strtolower($v->id), 'sent') !== false ||
											strpos(strtolower($v->id), 'enviados') !== false
										){
											$is_snt = 1;
										}else{
											$is_snt = 2;
										}

										if(	strpos(strtolower($v->id), 'draft') !== false ||
											strpos(strtolower($v->id), 'borrador') !== false ||
											strpos(strtolower($v->id), 'borradores') !== false
										){
											$is_drf = 1;
										}else{
											$is_drf = 2;
										}

										if(	strpos(strtolower($v->id), 'trash') !== false ||
											strpos(strtolower($v->id), 'eliminados') !== false
										){
											$is_trsh = 1;
										}else{
											$is_trsh = 2;
										}

										$__EmlBd->__t = 'eml_box';
										$__EmlBd->emlbox_eml = $__id_eml;
										$__EmlBd->emlbox_id = $v->id;
										$__EmlBd->emlbox_lbl = $v->id;
										$__EmlBd->emlbox_jnk = $is_jnk;
										$__EmlBd->emlbox_drf = $is_drf;
										$__EmlBd->emlbox_trsh = $is_trsh;
										$__EmlBd->emlbox_out = $is_snt;
										$__EmlBd->emlbox_tot = $v->tot;
										$__EmlBd->emlbox_luid = $v->luid;

										$__Prc = $__EmlBd->In();

										//echo $this->li('Prc: '.print_r($__Prc, true) );

										if($__Prc->e=='ok' || !isN($__Prc->prc->id)){
											echo $this->scss( 'Set On:'.$__Prc->prc->id );
											$_setbox = $__EmlBd->_box_e([ 'e'=>'on', 'id'=>$__Prc->prc->id ]);
											echo $this->scss( 'Result Box:'.$_setbox->e );
										}else{
											echo $this->err('Cant save box');
											echo $this->err( print_r($__Prc, true) );
										}
									}

								}

							}else{

								echo $this->err( 'No folders on imap' );
								echo $this->err( 'Labels result:'.print_r($labels, true) );

							}

						}

						$__upd_rd = $__EmlBd->Upd_Eml_Fld([
							't'=>'eml',
							'id'=>$___datprcs_v['eml_enc'],
							'fld'=>[
								['k'=>'eml_rd','v'=>2]
							]
						]);

					}

				}

			}

		} catch (Exception $e) {

			echo $e->getMessage();

		}

	}

}else{

	echo $this->nallw('Global Email - Imap - Get Boxes - Off');

}


?>