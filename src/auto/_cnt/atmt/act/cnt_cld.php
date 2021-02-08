<?php

	$__cng_do = 'no';
	$__cng_exc = 'no';
	$__cnt_dt = GtCntDt([ 'bd'=>$_cl_v->bd, 't'=>'enc', 'id'=>$row_Ls_RgMdlCnt['cnt_enc'] ]);

	if(!isN($__cnt_dt->id) && $___action_t->dt->c->tp->ord >= $__cnt_dt->est->tp->ord ){

		//echo $this->li($this->Spn( "Cambiar calidad lead TEMPO - ( ".compress_code( json_encode($___action_t) )." )") );
		//echo $this->li($this->Spn( "qUALITY TEMPO - ( ".compress_code( print_r($__cnt_dt->cld->ptje->f, true) )." )") );
		echo $this->li($this->Spn( "Cambiar calidad lead - ( ".$___action_t->dt->c->d->tt." -> ".$___action_t->dt->c->id." ) ", '', '','color:'.$___action_t->dt->c->clr ) );

		$_cnt_cld = UPDCnt_Cld([ 'bd'=>$_cl_v->bd, 'id'=>$row_Ls_RgMdlCnt['cnt_enc'], 'c'=>$___action_t->dt->c->id ]);

		if($_cnt_cld->e == 'ok'){
			$__cng_do = 'ok';
			$__cng_exc = 'ok';
		}else{
			echo $this->err( 'Problem on Update Quality:'.compress_code( print_r($_cnt_cld, true) ) );
		}

	}else{

		if(isN($__cnt_dt->w)){
			$__cng_do = 'ok';
		}

		$_exc_w[] = $___action_t->dt->c->tp->ord.' > '.$__cnt_dt->est->tp->ord.' ? ';

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

		echo $this->li('Save Automation----->');

		if($__sve->e == 'ok'){
			echo $this->scss('Success: '.compress_code(print_r($__sve, true)));
		}

	}



?>