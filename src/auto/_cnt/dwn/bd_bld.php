<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'dwn_bd_bld' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		//-------------------- PARAMETROS GET --------------------//

			$_i_dwn_p = $this->g__i;
			$pdo = CnPrc_Pdo();
			$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

		//-------------------- QUERY --------------------//

		echo $this->h1('Build Tables');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'dwn_bd_bld', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					$BldBd_Qry = "	SELECT id_dwn, dwn_enc, dwn_tab, dwnhis_main, dwnhis_his
									FROM "._BdStr(DBD).TB_DWN."
										 INNER JOIN "._BdStr(DBD).TB_DWN_HIS." ON dwnhis_dwn = id_dwn
									WHERE 	dwn_est = 6 AND
											dwnhis_main IS NOT NULL AND
											dwnhis_his IS NOT NULL AND
											dwn_cl = '".$_cl_v->id."' AND
											dwn_prc = 2
									ORDER BY id_dwn ASC
									LIMIT 5";

					$BldBd = $__cnx->_qry($BldBd_Qry);

					if($BldBd){

						$rw_BldBd = $BldBd->fetch_assoc();
						$Tot_BldBd = $BldBd->num_rows;

						if($Tot_BldBd > 0){

							echo $this->h1('Execute '.$Tot_BldBd.' scripts '.$_cl_v->nm);

							do{

								try{

									$pdo->beginTransaction();

									$QExc = compress_code($rw_BldBd['dwnhis_main'].' '.$rw_BldBd['dwnhis_his']);

									if(!isN($QExc)){

										echo $this->h1($rw_BldBd['dwnhis_main'].' '.$rw_BldBd['dwnhis_his']);

										$QExc_r = $pdo->prepare($QExc);

										if($QExc_r->execute()){

											try{

												$pdo->commit();

												$__dwntot = GtDwnTotDt([ 'id'=>$rw_BldBd['id_dwn'] ]);

												echo $this->h3('Se ejecuto script');
												echo $this->h3('Update tot:'.$__dwntot);
												//UPD_Dwn(['i'=>$rw_BldBd['id_dwn'], 'e'=>'7' ]);	// Cambiar cuando este nuevo codigo
												UPD_Dwn([ 'i'=>$rw_BldBd['id_dwn'], 'e'=>'4', 'tot'=>$__dwntot ]);

												$__cnx->_clsr($GDwn);

											}catch(Exception $e){

												$pdo->rollBack();

											}

										}else{

											echo $this->err('No se ejecuto script:'.print_r($pdo->errorInfo(), true).' '.compress_code($QExc) );

										}

										if(!isN($QExc_r)){ $QExc_r->closeCursor(); }

									}

								}catch(Exception $e){

									echo $this->err('Error: '.$e->getMessage());
									$pdo->rollBack();
									if(!isN($QExc_r)){ $QExc_r->closeCursor(); }

								}


							} while ($rw_BldBd = $BldBd->fetch_assoc());

						}else{

							echo $this->scss('No executes for '.$_cl_v->nm/*.' on '.compress_code($BldBd_Qry)*/ );

						}

					}else{

						echo $this->err( compress_code($BldBd_Qry) );

					}

					$__cnx->_clsr($BldBd);

				}else{

					echo $this->nallw($_cl_v->nm.' Downloads - Build Database - Off');

				}

			}

		}

	}

}else{

	echo $this->nallw('Global Downloads - Build Database - Off');

}

?>