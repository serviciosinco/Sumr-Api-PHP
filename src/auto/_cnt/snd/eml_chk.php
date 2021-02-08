<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_eml_chk' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		echo $this->h1('VERIFICACIÓN DE CORREOS');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_eml_chk', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'chk_eml', 'cl'=>$_cl_v->id, 'm'=>1 ]);
						echo $this->h2($_cl_v->nm.' habilitado? '.$_AUTOP_d->hb);
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->hb = 'ok';

					//-------------------- AUTO TIME CHECK - END --------------------//


					if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

						$___lck = $this->Rqu([ 't'=>'chk_eml', 'cl'=>$_cl_v->id ]);

						if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '50'; }

						$Ls_EmlChk_Qry = "	SELECT cnteml_enc, cnteml_eml
											FROM ".$_cl_v->bd.".".TB_CNT_EML."
											WHERE cnteml_est = '"._CId('ID_SISEMLEST_NOCHCK')."'
											/*ORDER BY RAND() */
											ORDER BY cnteml_prty ASC, id_cnteml DESC
											LIMIT $_qry_lmt ";

						//echo $this->scss( compress_code($Ls_EmlChk_Qry) );

						$Ls_EmlChk = $__cnx->_qry($Ls_EmlChk_Qry, ['cmps'=>'ok']);
						//print_r( $Ls_EmlChk );

						if($Ls_EmlChk){

							$row_Ls_EmlChk = $Ls_EmlChk->fetch_assoc();
							$Tot_Ls_EmlChk = $Ls_EmlChk->num_rows;

							echo $this->h2( $this->ttFgr($_cl_v).$Tot_Ls_EmlChk.' correos a verificar en '.ctjTx($_cl_v->nm,'in'));

							if($Tot_Ls_EmlChk > 0){

								do{

									$_dmn_eml = array_pop(explode('@', $row_Ls_EmlChk['cnteml_eml']));
									$_chk_eml = Chk_EmlRle([  'eml'=>$row_Ls_EmlChk['cnteml_eml'] ]);

									echo $this->h1('Start Check For:'.$row_Ls_EmlChk['cnteml_eml']);
									echo $this->h2('Chk_EmlRle:'.$_chk_eml->e);

									if(!checkdnsrr($_dmn_eml, 'MX')){

										$__prc =  UPDCntEml([ 'bd'=>$_cl_v->bd, 'id'=>$row_Ls_EmlChk['cnteml_enc'], 'est'=>_CId('ID_SISEMLEST_NOEXST') ]);

										if($__prc->e == 'ok'){
											echo $this->h2("Mal: ".$row_Ls_EmlChk['cnteml_eml']." no existe - estado "._CId('ID_SISEMLEST_NOEXST'));
										}

									}elseif($_chk_eml->e == 'no' && filter_var( $row_Ls_EmlChk['cnteml_eml'], FILTER_VALIDATE_EMAIL )){

										$__prc = UPDCntEml([ 'bd'=>$_cl_v->bd, 'id'=>$row_Ls_EmlChk['cnteml_enc'], 'est'=>_CId('ID_SISEMLEST_ACT') ]);

										if($__prc->e == 'ok'){
											echo $this->h2("Bien: ".$row_Ls_EmlChk['cnteml_eml']." formato correcto - estado "._CId('ID_SISEMLEST_ACT'));
											//echo $this->scss( print_r($__prc, true) );
										}

									}elseif($_chk_eml->e == 'ok'){

										$__prc =  UPDCntEml([ 'bd'=>$_cl_v->bd, 'id'=>$row_Ls_EmlChk['cnteml_enc'], 'est'=>_CId('ID_SISEMLEST_BADFRMT') ]);

										if($__prc->e == 'ok'){
											echo $this->h2("Mal: ".$row_Ls_EmlChk['cnteml_eml']." formato erroneo - estado "._CId('ID_SISEMLEST_BADFRMT'));
										}

									}else{

										echo $this->err($row_Ls_EmlChk['cnteml_eml']." No hay respuesta: ".$_chk_eml->e);

									}


									//echo $__rc['id_cnteml'].' -> '.$__rc['cnteml_eml'].$this->br(2);



								} while ($row_Ls_EmlChk = $Ls_EmlChk->fetch_assoc()); $Ls_EmlChk->free;

							}


						}else{

							echo $this->err('Error:'.$__cnx->c_r->error);

						}

						$__cnx->_clsr($Ls_EmlChk);

						//-------------------- FREE AUTO - START --------------------//

						$this->Rqu([ 't'=>'chk_eml', 'cl'=>$_cl_v->id ]);

						//-------------------- FREE AUTO - END --------------------//

					}

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Verificacion de Correos - Off');

				}

			}

		}

	}

}else{

	echo $this->nallw('Global Envios Masivos - Verificacion de Correos - Off');

}


?>