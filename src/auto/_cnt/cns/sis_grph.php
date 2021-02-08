<?php

if(class_exists('CRM_Cnx')){

		function Auto_GtGrphChr($_p=NULL){

			global $__cnx;

			if(!isN($_p['id'])){

				$Ls_Qry = sprintf(" SELECT grphchr_key, grphchr_dfl, grphchrrlc_vl_es, id_sistpdt, sistpdt_sqv
									FROM "._BdStr(DBM).TB_GRPH_CHR_RLC."
									       INNER JOIN "._BdStr(DBM).TB_GRPH_CHR." ON grphchrrlc_chr = id_grphchr
									       INNER JOIN "._BdStr(DBM).TB_SIS_TP_DT." ON grphchr_tp = id_sistpdt
									 WHERE grphchrrlc_grph = %s
									", GtSQLVlStr($_p['id'], 'int'));

				$LsTp_Rg = $__cnx->_qry($Ls_Qry);

				if($LsTp_Rg){

					$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
					$Tot_LsTp_Rg = $LsTp_Rg->num_rows;


					$_r['tot'] = $Tot_LsTp_Rg;

				    if($Tot_LsTp_Rg > 0){

		                do{
							$_v[ $row_LsTp_Rg['grphchr_key'] ] = ['k'=>ctjTx($row_LsTp_Rg['grphchr_key'],'in'),
										  'dfl'=>ctjTx($row_LsTp_Rg['grphchr_dfl'],'in'),
										  'dfl_c'=>$row_LsTp_Rg['grphchrrlc_vl_es'],
										  'tp'=>[
											  	'id'=>$row_LsTp_Rg['id_sistpdt'],
												'sqv'=>$row_LsTp_Rg['sistpdt_sqv']
										  ]
									];

						} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());

					}

					$_r['ls'] = $_v;

				}

				$__cnx->_clsr($LsTp_Rg);

			}

		    $rtrn = json_decode(json_encode($_r));
		    return($rtrn);
		}


		function _Bld_Grph($_p=NULL){

			//$_r .= ___JS_HDR;
			$_r .= $_p['c'];
			//$_r .= ___JS_FTR;

			if(!isN($_r)){

				$_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);

				if(SUMR_ENV == 'prd'){ $_cfr='ok'; }else{ $_cfr='no'; }

				$result_sve = $_auto->_aws->_s3_put([ 'b'=>'js', 'fle'=>$_p['f'], 'cbdy'=>cmpr_js($_r), 'ctp'=>'text/javascript', 'cfr'=>$_cfr ]);

				$__js_lcl = dirname( dirname( dirname( dirname(__FILE__) ) ) ).'/includes/_js/'.$_p['f'];

				echo $_auto->h1( 'Graph Save To'.$__js_lcl );

				if($result_sve->e == 'ok'){

					if(!isN($__js_lcl) && !isN($_r)){

						//echo $_auto->scss('JS_GRPH:Load Sucessfully');

						$_fle = fopen($__js_lcl, "w") or die("Unable to open file ".$__js_lcl);

						if( fwrite( $_fle, cmpr_js($_r) )){
							fclose($_fle);
						}else{
							echo $_auto->err('Can not write it');
						}

					}else{
						echo $_auto->err('No data on '.$__js_lcl);
					}

				}else{
					echo $_auto->err('Not saved on AWS');
				}

			}
		}


		//-------------------- CRM JS PRIMERA CARGA --------------------//



			$LsGrph_Qry = sprintf("  SELECT id_grph, grph_fnc, grph_fnc_a, grph_fnc_b
							   	     FROM "._BdStr(DBM).TB_GRPH."
							         ORDER BY id_grph ASC");

			$LsGrph_Rg = $__cnx->_qry($LsGrph_Qry);

			if($LsGrph_Rg){

				$row_LsGrph_Rg = $LsGrph_Rg->fetch_assoc();
				$Tot_LsGrph_Rg = $LsGrph_Rg->num_rows;

				echo $this->h1('Sis Graphs Tot:'.$Tot_LsGrph_Rg);

				$__cde .= " if(
								(!SUMR_Ld.f.isN(SUMR_Main) && !SUMR_Ld.f.isN(SUMR_Main.is_f) && SUMR_Main.is_f('Highcharts') && !SUMR_Ld.f.isN( Highcharts )) ||
								(!SUMR_Ld.f.isN(SUMR_Ld) && !SUMR_Ld.f.isN(SUMR_Ld.f) && SUMR_Ld.f.is_f('Highcharts') && !SUMR_Ld.f.isN( Highcharts ))
							){
								var colors=Highcharts.getOptions().colors;
							} ";

				$__cde .= "
					SUMR_Grph = {
						f:{
				";

			    if($Tot_LsGrph_Rg > 0){

	                do{

						$___dfl = '';
						$__chr_g = Auto_GtGrphChr([ 'id'=>$row_LsGrph_Rg['id_grph'] ]);

						echo $this->h2('Graph '.$row_LsGrph_Rg['id_grph']);

						if(!isN( $__chr_g->ls )){

							foreach($__chr_g->ls as $_k => $_v){

								if(!isN($_v->dfl_c)){ $__mydfl = $_v->dfl_c; }else{ $__mydfl = $_v->dfl; }

								if($__mydfl != 'false'){

									if($_v->tp->id == 3){
										$__vlgsvs = $__mydfl;
									}else{
										$__vlgsvs = GtSQLVlStr($__mydfl, $_v->tp->sqv);
									}

									if($__vlgsvs == 'NULL'){ $__vlgsvs='null'; }

								}else{

									$__vlgsvs = 'false';

								}



								if(isN($__vlgsvs) && $_v->tp->sqv == 'text'){ $__vlgsvs = "null"; }
								if(isN($__vlgsvs) && $_v->tp->id == 3){ $__vlgsvs = true; }

								$___dfl .= 'if(SUMR_Ld.f.isN(_p.'.$_v->k.')){ _p.'.$_v->k.' = '.$__vlgsvs.'; } ';

								echo $this->li($__mydfl.' -> '.$_v->tp->sqv.' -> if(SUMR_Ld.f.isN(_p.'.$_v->k.')){ _p.'.$_v->k.' = '.$__vlgsvs.'; } ');


							}

						}

						$__cde .= 'g'.$row_LsGrph_Rg['id_grph'].':function(_p){

										setTimeout(function() {

											if(!SUMR_Ld.f.isN(_p)){
												try {

													'.ctjTx($row_LsGrph_Rg['grph_fnc_b'],'in','',true).'

												    '.$___dfl.'

												    '.ctjTx($row_LsGrph_Rg['grph_fnc'],'in','',true).'
													'.ctjTx($row_LsGrph_Rg['grph_fnc_a'],'in','',true).'

													if(!SUMR_Ld.f.isN(_p.js)){
														/*var _f = new Function(_p.js);*/
														_p.js();
													}

												}catch(e) {
													if(!SUMR_Ld.f.isN(typeof SUMR_Main)){
														SUMR_Main.log.f({ t:"SV-Error Gráficas('.$row_LsGrph_Rg['id_grph'].')", m:e });
													}else{
														console.log("SV-Error Gráficas('.$row_LsGrph_Rg['id_grph'].')");
														console.log(e);
													}
												}
											}

										}, 1000);

								   },';


					} while ($row_LsGrph_Rg = $LsGrph_Rg->fetch_assoc());
				}

				$__cde .= "

						}
					};
				";

			}else{

				echo $this->err('JS_GRPH:'.$__cnx->c_r->error.' on '.$LsGrph_Qry);

			}


			if(!isN($__cde)){

				//if(Dvlpr()){ $__pth = ___JS_CRM; }

				_Bld_Grph(['c'=>$__cde, 'f'=>$__pth.'js_grph.js' ]);

			}else{

				echo $this->err('JS_GRPH:No new code for graphic script');

			}



}



?>