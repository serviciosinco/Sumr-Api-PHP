<?php

	try {

		$___all_eml_tot = '';

		$_li .= $this->li( 'Campaña: '.$___datprcs_v['id_eccmpg'] );


		//----------- IF CAMPAIGN SEND TO LIST -----------//

		if(!isN($_cmpg_dt->lsts) && !isN($_cmpg_dt->lsts->ls)){
			foreach($_cmpg_dt->lsts->ls as $_lsts_k=>$_lsts_v){
				if(!isN($_lsts_v)){
					if(!isN($_lsts_v) && $_lsts_v->e == 'ok'){
						$_li .= $this->li( 'Debe enviarse a la lista '.$this->Spn($_lsts_v->nm).' con '.$_lsts_v->qry_r->tot.' leads' );
					}
				}

			}
		}


		$_li .= $this->li( 'Correos ingresados a cola (Btch In): '.$this->Spn($_cmpg_dt->btch->in) );
		$_li .= $this->li( 'Correos enviados (Btch Snd): '.$this->Spn($_cmpg_dt->btch->snd) );
		$_li .= $this->li( 'Pushmail ID:'.$this->Spn($_cmpg_dt->ec->id) );


		//----------- IF CAMPAIGN SEND TO SOME SPECIFIC SEGMENT -----------//

		if(!isN($_cmpg_dt->sgm) && $_cmpg_dt->sgm->tot > 0){

			$___all_eml = $_cmpg_dt->sgm->ls;
			$___all_eml_t = 'sgm';

			$_li2 = '';

			$_li2 .= $this->li( $this->h2(print_r($_cmpg_dt->sgm->tot, true).'Segmentos seleccionados', ['n'=>2] ), '', ['n'=>3] );

			foreach($_cmpg_dt->sgm->ls as $_s1){

				$_var_qry .= $_s1->var->qry;

				if(!isN($_s1->nm)){

					$_li2 .= $this->li( $this->h2('Al segmento '.$this->Spn($_s1->nm), ['n'=>2]  ), '', ['n'=>3] );
					$_li2 .= $this->li( $this->h2('Con '.$this->Spn($_s1->var->tot.' variable(s)'), ['n'=>2]  ), '', ['n'=>3] );

					if( !isN($_s1->var->ls) ){

						foreach($_s1->var->ls as $_k_var => $_v_var){
							if(!isN($_v_var->sgm_nm)){
								$_li2 .= $this->li( $this->h2( $_v_var->sgm_nm.' '.$this->Spn($_v_var->var_nm.' '.$_v_var->vl) ) );
							}
						}

					}

				}
			}

			$_li .= $this->ul($_li2, '', '', ['n'=>4] );

		}elseif(!isN($_cmpg_dt->lsts) && !isN($_cmpg_dt->lsts->ls)){

			echo $this->h1('Lsts');

			//print_r($_cmpg_dt->lsts);
			$___all_eml = $_cmpg_dt->lsts->ls;
			$___all_eml_t = 'lsts';

		}

		//echo json_encode($_cmpg_dt->sgm)." -- ";
		//echo $_var_qry;




		//echo h2('$___all_eml:'.print_r($___all_eml, true));


		//----------- GET AND FETCH ALL EMAILS OF LISTS OR SEGMENTS -----------//

		if(!isN($___all_eml)){

			$___lst_or_sgm_added = [ 'lst'=>[], 'sgm'=>[] ];

			foreach($___all_eml as $_s2_k=>$_s2_v){

				$__eml_li = '';
				$___sgm_w = '';

				//-------- OBJETO CON LISTAS DE EMAIL (RESTANTES) POR METER EN COLA --------//


					if($___all_eml_t == 'sgm'){

						$_li .= $this->li('Conteo desde '.$this->Spn('Segmentos') );

						foreach($___all_eml as $_s3_k=>$_s3_v){


							$_li .= $this->li('Query For Segment '.$this->Spn($_s3_v->var->snd_q));
							$_li .= $this->li('Data of Segment '.$this->Spn($_s3_v->nm) );
							$_li .= $this->li('With '.$this->Spn($_s3_v->var->qry_t->tot->allw).' emails' );
							$_li .= $this->li('SndN '.print_r($_s3_v->var->snd_n, true) );

							if(!in_array($_s3_v->id, $___lst_or_sgm_added['sgm'])){

								if(isN($___l_eml)){

									$___l_eml = $_s3_v->var->snd_n;

								}else{

									$___l_extract = $___l_eml;
									$___o_extract = $_s3_v->var->snd_n;

									if($___l_extract->tot > 0){

										$___l_eml = [];
										$___l_eml['tot'] = $___o_extract->tot+$___l_extract->tot;
										$___l_eml['ls'] = array_merge((array)$___l_extract->ls, (array)$___o_extract->ls);
										$___l_eml = _jEnc($___l_eml);

									}

								}

								$___all_eml_tot = $___all_eml_tot + $_s3_v->var->qry_t->tot->allw;
								$___lst_or_sgm_added['sgm'][] = $_s3_v->id;

							}

							$___sgm_w .= $_s3_v->var->snd_n->w;
						}

						$_li .= $this->br();

					}else{

						$_li .= $this->li('Conteo ('.$_s2_v->qry_t->tot->allw.') desde '.$this->Spn('Listas') );
						//$_li .= $this->li('Query: '.$_s2_v->qry_t->qry->allw.$this->br().$this->br() );

						if(isN($___l_eml)){

							$___l_eml = $_s2_v->snd_n;

						}else{

							$___l_extract = $___l_eml;
							$___o_extract = $_s2_v->snd_n;

							$___l_eml = [];
							$___l_eml['tot'] = $___o_extract->tot+$___l_extract->tot;
							$___l_eml['ls'] = array_merge((array)$___l_extract->ls, (array)$___o_extract->ls);

							$___l_eml = _jEnc($___l_eml);

						}

						if(!in_array($_s2_v->id, $___lst_or_sgm_added['lst'])){

							$___all_eml_tot = $___all_eml_tot + $_s2_v->qry_t->tot->allw;
							$___lst_or_sgm_added['lst'][] = $_s2_v->id;

						}

					}

					if(!isN($___all_eml_tot)){
						$_li .= $this->li('Correos habilitados: '.$this->Spn($___all_eml_tot) );
					}else{
						$_li .= $___sgm_w;
					}


					if($___all_eml_tot != $_cmpg_dt->tot->lds){

						//$_upd_eml_tot = $_ec_snd->_EcCmpgUpd_Fld([ 'id'=>$_cmpg_dt->id, 'f'=>'eccmpg_tot_lds', 'v'=>$___all_eml_tot ]);

						if($_upd_eml_tot->e == 'ok'){

							//$_li .= $this->li($this->h3('Update new allow mails to: '.$this->Spn($___all_eml_tot) ));

						}

					}



				//-------- OBJETO CON LISTAS DE EMAIL (RESTANTES) POR METER EN COLA --------//


				if($___l_eml->tot > 0){

					$__eml_li .= $this->li( $this->Strn('Now start process of insert '.$___l_eml->tot.' emails') );
					$__eml_count_bd = 1;


					foreach($___l_eml->ls as $___l_eml_k=>$___l_eml_v){

						try{

							require('queue.php');

						}catch(Exception $e){

							$this->rd = 'no';
							$this->Lck();
							$this->Btch([ 'rst'=>'ok' ]);
		                	echo $e->getMessage();

		                }

					}

				}else{

					$_li .= $this->err('No mails to proceed');
					//$_li .= $this->err('$___l_eml Result: '. print_r($___l_eml, true) );

				}

				if(!isN($__eml_li)){
					$_li .= $this->li( $this->ul($__eml_li, 'Ls_Cmpg_Eml','', ['n'=>3]) );
				}


				//-------- CHANGE STATUS OF CAMPAIGNS --------//

				require('status.php');

			}

		}




	} catch (Exception $e) {

	   $__rd_cmpg_p = $this->EcCmpg_Rd();

	}


?>