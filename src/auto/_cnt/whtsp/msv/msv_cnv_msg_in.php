<?php

	try {

		$__msg_chk = $this->_wthsp->GtCnvMsgDt([ "id"=>$__msg_v->id ]); //Valida que el mensaje masive exista
		if(!isN($__msg_chk->w)){ echo $this->err( 'error on GtCnvMsgDt'); exit(); }

		//wthsp_cnv
		if(	$__msg_v->channel->abandoned == 'ok' ||
			$__msg_v->channel->archived == 'ok' ||
			!isN($__msg_v->channel->closed)){
			$_cnv_est = _CId('ID_SCLCNVEST_RDY');
		}else{
			$_cnv_est = NULL;
		}

		echo $this->h3(' Message '.$__msg_v->id.' ----- ');

		echo $this->li(' ---- Abandoned? '.$__msg_v->channel->abandoned.' ----- ');
		echo $this->li(' ---- Archived? '.$__msg_v->channel->archived.' ----- ');
		echo $this->li(' ---- Closed? '.$__msg_v->channel->closed.' ----- ');
		echo $this->li(' ---- Status? '.$_cnv_est.' ----- ');

		//wthsp_me
		if($__msg_v->from == $row_Ls_Rg['wthsp_no']){
			$this->_wthsp->wthspcnvmsg_me = 'ok';
		}else{
			$this->_wthsp->wthspcnvmsg_me = 'no';
		}

		//wthsp_cnv_msg
		if(	$__msg_v->sent == 'ok'){
			$_cnv_msg_est = 1;
		}else{
			$_cnv_msg_est = 2;
		}

		//wthsp_from
		$this->_wthsp->wthspfrom_id = $__msg_v->from;
		$this->_wthsp->wthspfrom_nm = ( (!isN($__msg_v->channel->name))? $__msg_v->channel->name : "-NA-" );
		$this->_wthsp->wthspcnvmsg_wthspcnv = $__msg_v->channel->id;
		$this->_wthsp->wthspcnv_est = $_cnv_est;
		$this->_wthsp->wthspcnvmsg_snt = $_cnv_msg_est;
		$this->_wthsp->wthspcnv_whtsp = $___datprcs_v['id_wthsp'];
		$this->_wthsp->wthspcnv_id = $__msg_v->channel->id;

		if(!isN( $__msg_v->channel->closed )){
			$this->_wthsp->wthspcnv_cls = $this->_wthsp->_Tme($__msg_v->channel->closed);
		}else{
			$this->_wthsp->wthspcnv_cls = null;
		}

		//wthsp_cnv_us
		$this->_wthsp->wthspcnvus_us = $__usr->id;

		if( !isN($__usr->id) ){
			$__dt_us = GtUsDt($__usr->id);
			$this->_wthsp->wthspcnvmsg_us_enc = $__dt_us->enc;
		}

		$this->_wthsp->wthspcnvmsg_created = $this->_wthsp->_Tme( $__msg_v->created );
		$this->_wthsp->wthspcnvmsg_from = $__msg_v->from;
		$this->_wthsp->wthspcnvmsg_mdata = json_encode($__msg_v);
		$this->_wthsp->wthspcnvmsg_id = $__msg_v->id;
		$this->_wthsp->wthspcnvmsg_message = $__msg_v->text;
		$this->_wthsp->wthspcnvmsg_us = $__usr->id;

		if(!isN($__msg_chk->id) && $__msg_chk->e == "ok"){

			echo $this->li(' ---- Ya existe mensaje '.$__msg_chk->id.' ----- ');
			$Cnv_Msg_Upd = $this->_wthsp->Cnv_Msg_Upd([ 'd'=>$__msg_chk ]);
			echo $this->li(' ---- Resultado de Actualización '.compress_code( print_r($Cnv_Msg_Upd, true) ).' ----- ');

			if($Cnv_Msg_Upd->e == 'ok'){
				echo $this->scss('(Update) Actualizado exitosamente');
				$_plst = $__msg_v->id;
				$_psve++;
			}elseif(!isN($Cnv_Msg_Upd->w)){ print_r( $Cnv_Msg_Upd );
				$_log_w[] = $Cnv_Msg_Upd->w;
				$__prc_all = 'no';
			}

		}else{

			echo $this->li(' ---- A procesar conversacion '.$__msg_v->channel->id.' ----- ');
			$Cnv_Msg_In = $this->_wthsp->Cnv_Msg_In();
			echo $this->li(' ---- Insertando mensaje ----- '.$this->_wthsp->__new_cnv_id." - ".$this->_wthsp->__new_from_id." - ".$Cnv_Msg_In->e);

			if($Cnv_Msg_In->e == 'ok'){
				echo $this->scss('(Insert) Insertado exitosamente');
				if($__msg_v->id > $_plst){ $_plst = $__msg_v->id; }
				$_psve++;
			}elseif(!isN($Cnv_Msg_In->w)){
				$_log_w[] = $Cnv_Msg_In->w;
				echo $this->err( print_r( $Cnv_Msg_In , true ) );
				$__prc_all = 'no';
			}

		}

	} catch (Exception $e) {

	    echo $this->err($e->getMessage());

	}


?>