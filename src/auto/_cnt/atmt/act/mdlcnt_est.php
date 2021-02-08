<?php

	$__cng_do = 'no';
	$__cng_exc = 'no';
	$__est_lst = GtMdlCntEst_Lst(['id'=>$row_Ls_RgMdlCnt['id_mdlcnt'], 'bd'=>$_cl_v->bd, 'nw'=>$___action_t->dt->c->id ]);


	if($__est_lst->df == 'ok' && $___action_t->dt->c->tp->ord >= $__est_lst->est->tp->ord ){

		echo $this->li($this->Spn( "Cambiar a estado - ( ".$___action_t->dt->c->tt." -> ".$___action_t->dt->c->id." ) ", '', '','color:'.$___action_t->dt->c->clr ) );

		$_cnt_est = __MdlCntEst([ 'bd'=>$_cl_v->bd, 'c'=>$row_Ls_RgMdlCnt['id_mdlcnt'], 'us'=>SUMR_IDUS, 'e'=>$___action_t->dt->c->id ]);

		if($_cnt_est->e == 'ok'){
			$__cng_do = 'ok';
			$__cng_exc = 'ok';
		}

	}else{

		if(isN($__est_lst->w)){
			$__cng_do = 'ok';
		}

		$_exc_w[] = 'Different: '.$__est_lst->df.' / '.$___action_t->dt->c->tp->ord.' > '.$__cnt_dt->est->tp->ord.' ? ';

	}



	if($__cng_do == 'ok' && !isN($__atmt_a_tp)){

		$__Atmt->atmtrg_tp=$__atmt_a_tp;
		$__Atmt->atmtrg_atmt=$row_Ls_AtmtRg['id_atmt'];
		$__Atmt->atmtrg_trgr=$row_Ls_AtmtRg['id_atmttrgr'];
		$__Atmt->atmtrg_act=$row_Ls_AtmtRg['id_atmttrgract'];
		$__Atmt->atmtrg_id=$row_Ls_RgMdlCnt['id_mdlcnt'];
		$__Atmt->atmtrg_exc=($__cng_exc=='ok'?1:2);
		$__Atmt->atmtrg_exc_w=$_exc_w;

		$__sve = $__Atmt->_RgIn();

		echo li('Save Automation----->');

		if($__sve->e == 'ok'){
			echo li('Success: '.print_r($__sve, true));
		}

	}



?>