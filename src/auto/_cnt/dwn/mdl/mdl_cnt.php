<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'dwn_mdl_cnt' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		//-------------------- PARAMETROS GET --------------------//

			$_i_dwn_p = $this->g__i;

			if(!isN($_i_dwn_p)){ $_qry_p = 'AND dwn_enc = "'.$_i_dwn_p.'" '; }else{ $_qry_p = ''; }

			$_fl_tt = _FleN([ 'tt'=>'Leads' ]);
			$_gt_all_noi = GtSisNoi();

			$pdo_d = CnPrc_Pdo();
			$pdo_d->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

			$pdo = CnRd_Pdo();
			$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

		//-------------------- QUERY --------------------//

		echo $this->h2('Descarga Programas');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'dwn_mdl_cnt', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

                    	$_AUTOP_d = $this->RquDt([ 't'=>'dwn_mdl_cnt', 'cl'=>$_cl_v->id, 'm'=>1 ]);

					//-------------------- AUTO TIME CHECK - END --------------------//

					if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->lck != 'ok' || $_AUTOP_d->hb == 'ok' )){

						$___lck = $this->Rqu([ 't'=>'dwn_mdl_cnt', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

						echo $this->h3('Lock '.$_cl_v->nm.' / e:'.$___lck->e);

						if($___lck->e == 'ok'){

							//-------------------- INITI CLASS --------------------//

								$__Dwn = new CRM_Dwn([ 'cl'=>$_cl_v->id ]);
								$__Dwn->bd = $_cl_v->bd;

							//-------------------- QUERY --------------------//

							$Ls_QC = "	SELECT id_dwn, dwn_cl,
											"._QrySisSlcF([ 'als'=>'f', 'als_n'=>'format' ]).",
											".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'format', 'als'=>'f' ])."
										FROM "._BdStr(DBD).TB_DWN."
											".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'dwn_frm', 'als'=>'f' ])."

										WHERE 	dwn_cl = '".$_cl_v->id."' AND
												dwn_tp = 'mdl_cnt' AND
												dwn_est != 1 AND
												dwn_est != 5 AND
												dwn_est != 6 AND
												dwn_est != 8 AND
												(dwn_rd = 2 || dwn_rd_f < NOW() - INTERVAL 3 MINUTE )
												{$_qry_p}
										ORDER BY RAND()
										LIMIT 5";

							//echo compress_code( $Ls_QC );

							$Ls_LsDwn = $__cnx->_qry($Ls_QC);

							if($Ls_LsDwn){

								$row_Ls_LsDwn = $Ls_LsDwn->fetch_assoc();
								$Tot_Ls_LsDwn = $Ls_LsDwn->num_rows;

								//-------------------- TITULO --------------------//

								echo $this->h2('Descargas Leads '.$Tot_Ls_LsDwn);
								//if($Tot_Ls_LsDwn==0){ echo $this->h2($Ls_QC); }

								if($Tot_Ls_LsDwn > 0){

									do{

										$this->id_dwn = $row_Ls_LsDwn['id_dwn'];
										$this->Dwn_Rd([ 'e'=>'on' ]);

										$__format = json_decode($row_Ls_LsDwn['___format']);

										foreach($__format as $__tp_k=>$__tp_v){
											$__format_go[$__tp_v->key] = $__tp_v;
										}

										$_cl_dt = GtClDt($row_Ls_LsDwn['dwn_cl']);

										$Ls_Mdfy_His_A = [];
										$Ls_Mdfy_Est_A = [];
										$Ls_Mdfy_Prd_A = [];
										$Ls_Mdfy_Org_Clg = [];
										$Ls_Mdfy_Org_Emp = [];
										$Ls_Mdfy_Org_Uni = [];
										$Ls_Mdfy_Noi = [];
										$Ls_Mdfy_MdlCntAttr = [];
										$Ls_Mdfy_MdlCntActv = [];
										$Ls_Mdfy_MdlCntSbrnd = [];

										$update_f_go = '';
										$updateSQL = '';

										$__dwn_dt = GtDwnDt([ 'id'=>$row_Ls_LsDwn['id_dwn'], 'd'=>[ 'col'=>'ok' ] ]);

										echo $this->h3('Procesando descarga #'.$__dwn_dt->id.' with status '.$__dwn_dt->est);

										$__dwn_frmt = $__format_go['ext']->vl;

										$__li .= $this->li('Id:'.$__dwn_dt->enc);
										$__li .= $this->li('Tot:'.json_encode($__dwn_dt->tot));

										echo $this->h1('$__dwn_dt->est:'.$__dwn_dt->est); //exit();

										if(!isN($__dwn_dt->id) && $__dwn_dt->est == 7){ // Creating Cols

											include( dirname(__FILE__).'/mdl_cnt_col.php' );

										}elseif(!isN($__dwn_dt->id) && $__dwn_dt->tot == 0 && $__dwn_dt->est != 6){ // No data on table

											$__li_clr = '#ffa300';
											$__li .= $this->li('No existe tabla');

											$__dwntot = GtDwnTotDt([ 'id'=>$__dwn_dt->id ]);

											UPD_Dwn([
													'i'=>$__dwn_dt->id,
													'e'=>'5',
													'tot'=>$__dwntot,
													'w'=>'No existe tabla - tot('. $__dwn_dt->tot .') - tot no upload('. $__dwn_dt->tot->no_u .') - estado (' .$__dwn_dt->est. ')'
											]);

										}elseif(!isN($__dwn_dt->id) && $__dwn_dt->tot->no_u > 0){ // Writing data attached

											include( dirname(__FILE__).'/mdl_cnt_cmpl.php' );

										}elseif($__dwn_dt->tot->no_u == 0  && $__dwn_dt->tot->e != 'no'/* && $__dwn_dt->blq == 'no'*/){ // Ready for create file

											echo $this->li('$__dwn_dt->tot->no_u:'.$__dwn_dt->tot->no_u);
											echo $this->li('$__dwn_dt->tot->e:'.print_r($__dwn_dt->tot->e, true));
											include( dirname(__FILE__).'/mdl_cnt_fle.php' );

										}else{

											$__li .= $this->li('No_U:'.$__dwn_dt->tot->no_u);
											$__li .= $this->li('Blq:'.$__dwn_dt->blq);
											$__li .= $this->li('No hace nada');

										}

										echo $this->ul($__li,'','color:'.$__li_clr);

										$__dwn_u_dt = GtDwnDt([ 'id'=>$__dwn_dt->id ]);

										if(!isN($__dwn_u_dt->id)){

											$this->_ws->Send([
												'srv'=>'download',
												'act'=>'status',
												'to'=>[$__dwn_u_dt->us->enc],
												'sadmin'=>'ok',
												'data'=>[
													'dwn'=>[
														'id'=>$__dwn_u_dt->enc,
														'status'=>[
															'id'=>$__dwn_u_dt->est,
															'tt'=>$__dwn_u_dt->est_tt,
															'clr'=>$__dwn_u_dt->est_clr
														],
														'tot'=>$__dwn_u_dt->tot
													]
												]
											]);

										}

										$this->Dwn_Rd();

									} while ($row_Ls_LsDwn = $Ls_LsDwn->fetch_assoc());

								}

							}

							$__cnx->_clsr($Ls_LsDwn);

						}

						$___lck = $this->Rqu([ 't'=>'dwn_mdl_cnt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

					}else{

						if($_AUTOP_d->e != 'ok'){ echo $this->nallw($_cl_v->nm.' No Query Result'); }
						if($_AUTOP_d->lck == 'ok'){ echo $this->nallw($_cl_v->nm.' Is Locked'); }
						if($_AUTOP_d->hb != 'ok'){ echo $this->nallw($_cl_v->nm.' Not allowed'); }

					}


				}else{

					echo $this->nallw($_cl_v->nm.' Downloads - Oportunidades - Off');

				}

			}

		} else{

			echo $this->nallw('No accounts for process');

		}

	}

	$pdo_d = NULL;
	$pdo = NULL;

}else{

	echo $this->nallw('Global Downloads - Oportunidades - Off');

}

?>