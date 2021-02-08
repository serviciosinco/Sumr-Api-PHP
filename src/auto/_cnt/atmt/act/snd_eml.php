<?php

	$__lead_h .= $this->li('Emls Tot:'.count($__dt_mdlcnt->cnt->eml));

	if(!isN($__dt_mdlcnt->cnt->eml) && count($__dt_mdlcnt->cnt->eml) > 0 && isN($__dt_mdlcnt->cnt->eml->w)){

		$__eml_c = 1;
		$__snd_cnt = 0;
		$__eml_sec_i=1;

		foreach($__dt_mdlcnt->cnt->eml as $_eml_k=>$_eml_v){

			$_eml_v_sndi='';
			$_eml_v_cnt_sndi='';

			if(!isN($_eml_v->v)){

				foreach($___atmt_plcy_id as $_atmt_plcy_k=>$_atmt_plcy_v){
					$_eml_v_sndi = $__dt_mdlcnt->cnt->plcy->ls->{$_atmt_plcy_v}->on;
					$_eml_v_cnt_sndi = $_eml_v->plcy->ls->{$_atmt_plcy_v}->sndi;
				}


				if($__eml_c <= 10){

					///--------- Valida si el correo tiene errores ----------///

					$_vld_eml = 'ok';

					$_chk_eml = Chk_EmlRle([ "eml"=>$_eml_v->v ]);

					if($_chk_eml->e == "ok"){ $_vld_eml = "no"; }
					if($_eml_v->cld < 0){ $_vld_eml = "no"; }

					if(	$_eml_v->est == _CId('ID_SISEMLEST_NOCHCK') ||
						$_eml_v->est == _CId('ID_SISEMLEST_SERV_NOCHCK') ||
						isN($_eml_v->est)){
							$_vld_eml = "no";
					}

					if(	$_eml_v->est != _CId('ID_SISEMLEST_ACT') ){
							$_vld_eml = "no";
					}

					if($_eml_v->rjct == 'ok'){ $_vld_eml = "no"; }
					if($_eml_v_sndi != 'ok'){ $_vld_eml = "no"; }
					if($_eml_v_cnt_sndi != 'ok'){ $_vld_eml = "no"; }

					//$___atmt_plcy_id


					$__lead_h .= $this->li('Valid for:'.$_eml_v->v.' ('.$this->Spn($_vld_eml).')');


					if($_vld_eml == 'ok'

						/*	&&
						(	$_eml_v->v == 'camilo.garzon@servicios.in' ||
							$_eml_v->v == 'manuel@massivespace.rocks' ||
							$_eml_v->v == 'manuel.idrobo@uexternado.edu.co' ||
							$_eml_v->v == 'jonnathan.prieto@servicios.in' ||
							$_eml_v->v == 'camila.mejia@servicios.in' ||
							$_eml_v->v == 'ricardo.carron@servicios.in' ||
							$_cl_dt->id == 17
						)*/

					){ // Quitar

						//Enviar correo

						$__ec = new API_CRM_ec([ 'cl'=>$_cl_dt->id ]);
						$__ec->snd_f = SIS_F;
						$__ec->snd_h = date('H:i:s',strtotime('+'.$__eml_sec_i.' seconds',strtotime( date("H:i:s") )));

						$__ec->snd_ec = $___action_t->dt->c->id;
						$__ec->snd_mdlcnt = $__dt_mdlcnt->id;
						$__ec->snd_eml = $_eml_v->v;
						$__ec->snd_cnt = $__dt_mdlcnt->cnt->id;
						//$__ec->snd_mdlcnt = $row_Ls_RgMdlCnt['id_mdlcnt'];

						if(!isN($___atmtdt->eml->id)){
							$__ec->snd_cleml = $___atmtdt->eml->id;
						}else{
							$__ec->snd_cleml = NULL;
						}

						if(defined('SISUS_ID')){
							$__ec->snd_us = SISUS_ID;
						}else{
							$__ec->snd_us = 3;
						}

						$__snd = $__ec->_SndEc([ 't'=>'mdl', 'atmt'=>'ok', 'bd'=>$_cl_v->bd ]);

						echo $this->h2('Snd Mail Result:'.print_r($__snd, true));

						if($__snd->e == "ok"){

							$__lead_h .= $this->ul(
													$this->li($this->Spn( ctjTx("id_cnteml ----- Id email lead - ( ".$_eml_v->id." ) ",'in') ) ).
													$this->li($this->Spn( ctjTx("id_mdlcnt ----- Id Lead - ( ".$row_Ls_RgMdlCnt['id_mdlcnt']." ) ",'in') ) ).
													$this->li($this->Spn( ctjTx("mdl_nm ----- Modulo - ( ".$row_Ls_RgMdlCnt['mdl_nm']." ) ",'in') ) ).
													$this->li($this->Spn( ctjTx("cnt_nm ----- Lead - ( ".$row_Ls_RgMdlCnt['cnt_nm']." ) ",'in') ) ).
													$this->li($this->Spn( ctjTx("cnteml_eml ----- Email - ( ".$_eml_v->v." ) ",'in') ) ).
													$this->li($this->Spn( ctjTx("mdlcnt_fi ----- Fecha de ingreso Lead - ( ".$row_Ls_RgMdlCnt['mdlcnt_fi']." ) ",'in') ) ).
													$this->li($this->Spn( ctjTx("cntest_tt ----- Estado - ( ".$row_Ls_RgMdlCnt['siscntest_tt']." ) ",'in') ) )
												);

							$__snd_cnt++;

						}else{

							echo $this->h2( 'Send Mail?'.print_r($__snd, true) );
							$_exc_w[] = '$__ec->snd_h:'.$__ec->snd_h.' / SIS_H2:'.SIS_H2.' /  Email '.$_eml_v->v.' not inserted / '.compress_code( print_r($__snd, true) );
							//exit();
						}

						$Tot_Mdl_Cnt++;

						//sleep(2);

					}else{

						$_exc_w[] = 'Email ('.print_r($_eml_v, true).') not valid for send';

					}

				}

				$__eml_c++;
				$__eml_sec_i++;

			}

		}

	}else{

		$_exc_w[] = 'No emails for send / '.compress_code( print_r($__dt_mdlcnt->cnt->eml, true) );

	}

	$__lead_h .= $this->li('Correos enviados:'.$__snd_cnt);

	if(!isN($__dt_mdlcnt->id) && !isN($__atmt_a_tp) && isN($__dt_mdlcnt->w) && isN($__dt_mdlcnt->cnt->w) && isN($__dt_mdlcnt->cnt->eml->w)){

		$__Atmt->atmtrg_tp=$__atmt_a_tp;
		$__Atmt->atmtrg_atmt=$row_Ls_AtmtRg['id_atmt'];
		$__Atmt->atmtrg_trgr=$row_Ls_AtmtRg['id_atmttrgr'];
		$__Atmt->atmtrg_act=$row_Ls_AtmtRg['id_atmttrgract'];
		$__Atmt->atmtrg_id=$row_Ls_RgMdlCnt['id_mdlcnt'];
		$__Atmt->atmtrg_exc=($__snd_cnt>0?1:2);
		$__Atmt->atmtrg_exc_w=$_exc_w;

		$__sve = $__Atmt->_RgIn();

		$__lead_h .= $this->li('Save Automation----->');

		if($__sve->e == 'ok'){
			$__lead_h .= $this->li('Success: '.print_r($__sve, true));
		}

	}


?>