<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'dwn_bd_rmv' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		//-------------------- PARAMETROS GET --------------------//

			$_i_dwn_p = $this->g__i;

		//-------------------- QUERY --------------------//

		echo $this->h1('Remove Tables Procesed');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'dwn_bd_rmv', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					$BldBd_Qry = "	SELECT id_dwn
									FROM "._BdStr(DBD).TB_DWN."
									WHERE 	dwn_eli = 2 AND
											dwn_cl = '".$_cl_v->id."' AND
											(
												(
													(dwn_est = 5 AND dwn_prc = 2) OR
													(dwn_est = 1 AND dwn_prc = 2)
												)
												OR
												(
													dwn_fi < NOW() - INTERVAL 1 WEEK
												)
											)

									ORDER BY RAND()
									LIMIT 1000";

					$BldBd = $__cnx->_qry($BldBd_Qry);

					if($BldBd){

						$rw_BldBd = $BldBd->fetch_assoc();
						$Tot_BldBd = $BldBd->num_rows;

						if($Tot_BldBd > 0){

							do{

								$deleteSQL = 'DROP TABLE IF EXISTS '._BdStr(DBD).'_d_'.$rw_BldBd['id_dwn'];
								$QExc_r = $__cnx->_prc($deleteSQL);

								if($QExc_r){

									$deleteSQLHis = 'DROP TABLE IF EXISTS '._BdStr(DBD).'_d_'.$rw_BldBd['id_dwn'].'_his';
									$QExcHis_r = $__cnx->_prc($deleteSQLHis);

									if($QExcHis_r){

										$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_prc=%s WHERE id_dwn=%s",
															GtSQLVlStr(1, "int"),
															GtSQLVlStr($rw_BldBd['id_dwn'], "int"));

										$updateExc = $__cnx->_prc($updateSQL);

										if($updateExc){

											echo $this->h3('Se ejecuto script');

											$__upd = UPD_Dwn([ 'i'=>$rw_BldBd['id_dwn'], 'eli'=>1 ]);
											if($__upd->e == 'ok'){
												echo $this->scss('Changed flag eli Ok!');
											}else{
												echo $this->err('Not changed the status of record');
											}

										}else{

											echo $this->li('Search record on table schema to check if exists');

											$tableExists = 'SELECT * FROM information_schema.tables WHERE table_schema = "'.DBD.'" AND table_name = "_d_'.$rw_BldBd['id_dwn'].'" ';
											$tableExistsR = $__cnx->_prc($tableExists);

											if($tableExistsR){

												$rw_Exsts = $tableExistsR->fetch_assoc();
												$Tot_Exsts = $tableExistsR->num_rows;

												if($Tot_Exsts == 0){
													$__upd = UPD_Dwn([ 'i'=>$rw_BldBd['id_dwn'], 'eli'=>1 ]);
													if($__upd->e == 'ok'){
														echo $this->scss('Changed flag eli Ok!');
													}else{
														echo $this->err('Not changed the status of record');
													}
												}

											}

											$__cnx->_clsr($tableExistsR);

										}

									}

								}else{

									echo $this->err('No se ejecuto script para eliminar '.compress_code($deleteSQL));
									echo $this->err($__cnx->c_p->error);

								}

							} while ($rw_BldBd = $BldBd->fetch_assoc());

						}

					}

					$__cnx->_clsr($BldBd);

				}else{

					echo $this->nallw($_cl_v->nm.' Downloads - Remove Database - Off');

				}

			}

		}

	}

}else{

	echo $this->nallw('Global Downloads - Remove Database - Off');

}

?>