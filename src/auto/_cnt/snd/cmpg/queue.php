<?php

	try {

		$__eml_li .= $this->h3($___l_eml_v->eml.' to process');


		$this->k = $_cmpg_dt->p_f.'-'.$_cmpg_dt->p_h.'-'.$_cmpg_dt->ec->id.'-'.$___l_eml_v->cnt.'-'.$___l_eml_v->eml;
		$this->t = 'ec_snd';
		$this->rd = 'ok';
		$_AUTOP_rd = $this->Chck([ 'tme'=>1 ]);

		if($_AUTOP_rd->e == 'no'){

			$this->In();
			$_AUTOP_rd = $this->Chck();

		}elseif(isN($_AUTOP_rd->btch)){

			$_btch_upd = $this->Btch();

			if($_btch_upd->e == 'ok'){
				$_AUTOP_rd = $this->Chck();
				//echo $this->h3( 'New batch:'.print_r($_AUTOP_rd, true) );
			}

		}


		$__eml_li .= $this->li('Check is Locked');
		$__eml_li .= $this->li('Read e:'.$this->Spn($_AUTOP_rd->e));
		$__eml_li .= $this->li('Read Mode:'.$this->Spn($_AUTOP_rd->rd));
		$__eml_li .= $this->li('Batch Read:'.$this->Spn($_AUTOP_rd->btch));
		$__eml_li .= $this->li('Batch Id:'.$this->Spn($__btch_id));
		$__eml_li .= $this->li('After:'.$this->Spn($_AUTOP_rd->aft));


		if($_AUTOP_rd->e == 'ok' && $_AUTOP_rd->rd != 'ok' && $_AUTOP_rd->btch == $__btch_id){


			$_prc = $this->Lck();
			$_AUTOP_rd = $this->Chck();

			if(!isN($___l_eml_v->id) && $_prc->rd == 'ok' && $_AUTOP_rd->rd == 'ok' && $_AUTOP_rd->btch == $__btch_id){


				//----------- SEND TO QUEUE -----------//

				$_ec_snd->snd_f = $_cmpg_dt->p_f;
				$_ec_snd->snd_h = $_cmpg_dt->p_h;
				$_ec_snd->snd_ec = $_cmpg_dt->ec->id;
				$_ec_snd->snd_eml = $___l_eml_v->eml;
				$_ec_snd->snd_cnt = $___l_eml_v->cnt;
				$_ec_snd->snd_us = $___datprcs_v['eccmpg_us'];
				$_ec_snd->snd_cmpg = $_cmpg_dt->id;
				$_ec_snd->snd_upcol = $___l_eml_v->upcol;

				if(!isN($__cmpg_dt->eml->id)){
					$_ec_snd->snd_cleml = $__cmpg_dt->eml->id;
				}elseif(!isN($_cmpg_dt->eml->id)){
					$_ec_snd->snd_cleml = $_cmpg_dt->eml->id;
				}else{
					$_ec_snd->snd_cleml = NULL;
				}

				if(!Dvlpr() || $___l_eml_v->test == 'ok'){
					$__r = $_ec_snd->_SndEc([ 't'=>'cmpg', 'bd'=>$_cl_v->bd ]); // Temporal
				}

				$this->_RTme([ 'tp'=>$__btch_id.' -> ec_cmpg -> Btch -> '.print_r($__r, true) ]);


				$__eml_li .= $this->li('Campaña ID->'.$this->Spn($_cmpg_dt->id) );
				$__eml_li .= $this->li('Pushmail ID->'.$this->Spn($_cmpg_dt->ec->id));
				$__eml_li .= $this->li('LstsEml->'.$this->Spn($___l_eml_v->id));
				$__eml_li .= $this->li('Eml-> '.$this->Spn($___l_eml_v->eml));
				$__eml_li .= $this->li('UpCol-> '.$this->Spn($___l_eml_v->upcol));
				$__eml_li .= $this->li('IdCnt-> '.$this->Spn($___l_eml_v->cnt));
				$__eml_li .= $this->li('Dia->'.$this->Spn($_cmpg_dt->p_f));
				$__eml_li .= $this->li('Hora->'.$this->Spn($_cmpg_dt->p_h));
				$__eml_li .= $this->li('Result->'.$this->Spn( compress_code(print_r($__r, true))) );

				if($__r->e == 'ok'){

					echo $this->scss('Queue for '.$___l_eml_v->eml.' creado exitosamente');

				}

				//echo $this->br(2);

			}else{

				$__eml_li .= 'No Id - Read No - AutoRd No';

			}

			$this->rd = 'no';
			$this->Lck();

		}else{

			$__eml_li .= $this->err('No available to process');

			if($_AUTOP_rd->aft == 'ok'){
				$this->rd = 'no';
				$this->Lck();
				$this->Btch([ 'rst'=>'ok' ]);
				$__eml_li .= $this->h2('Unlock record to continue');
			}

		}

		$__eml_count_bd++;


	} catch (Exception $e) {


	   $__rd_cmpg_p = $this->EcCmpg_Rd();

	}


?>