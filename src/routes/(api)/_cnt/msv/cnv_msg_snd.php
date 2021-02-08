<?php

	if(!isN( $__cnv_msg_id )){

		$__msgs = $_massive->msg_ls([ 'app'=>'ok', 'chnl'=>$__cnv_id, 'msg'=>$__cnv_msg_id ]);

		//$rsp['tmp_msgs'] = $__msgs;

		if($__msgs->rsl->tot > 0){
			$rsp['e'] = 'ok';
		}

		$rsp['msg']['tot'] = $__msgs->rsl->tot;

		if(!isN( $__msgs->rsl->ls )){
								
			foreach($__msgs->rsl->ls as $__msg_k=>$__msg_v){

				$__usr = $_wthsp->Chk_Us([ 'usr'=>$__msg_v->user->username ]); //Validar usuario

				try {

					$__msg_chk = $_wthsp->GtCnvMsgDt([ "id"=>$__msg_v->id ]); //Valida que el mensaje masive exista
					if(!isN($__msg_chk->w)){ echo $this->err( 'error on GtCnvMsgDt'); exit(); }

					$__acc_chk = GtWhtspDt([ 'no'=>$__msg_v->account->no ]);
					
					if( !isN($__acc_chk->id) ){
						
						//$rsp['cnv']['id'] = $__msg_v->channel->id;
						
						//wthsp_cnv
						if( $__msg_v->channel->abandoned == 'ok' || 
							$__msg_v->channel->archived == 'ok' ||
							!isN($__msg_v->channel->closed)){ 
							$_cnv_est = _CId('ID_SCLCNVEST_RDY'); 
						}else{
							$_cnv_est = NULL;
						}

						//wthsp_me
						if($__msg_v->from == $__acc_chk->no){  
							$_wthsp->wthspcnvmsg_me = 'ok';	
						}else{
							$_wthsp->wthspcnvmsg_me = 'no';
						}

						//wthsp_from
						$_wthsp->wthspfrom_id = $__msg_v->from;
						$_wthsp->wthspfrom_nm = ( (!isN($__msg_v->channel->name))? $__msg_v->channel->name : "-NA-" );
						$_wthsp->wthspcnv_est = $_cnv_est;
						$_wthsp->wthspcnv_whtsp = $__acc_chk->id;
						$_wthsp->wthspcnv_id = $__msg_v->channel->id;
				
						//wthsp_cnv_us
						$_wthsp->wthspcnvus_us = $__usr->id;

						if( !isN($__usr->id) ){
							$__dt_us = GtUsDt($__usr->id);
							$_wthsp->wthspcnvmsg_us_enc = $__dt_us->enc;
						}

						if(!isN($__msg_chk->id) && $__msg_chk->e == "ok"){	

							// Change Created Data

							$cnv_upd = $_wthsp->UpdF([
											't'=>'msg',
											'f'=>[
												'wthspcnvmsg_created'=>$_wthsp->_Tme($__msg_v->created),
												'wthspcnvmsg_snt'=>1
											],
											'id'=>$__msg_chk->id
										]);
							
							$rsp['msg']['upd'] = $cnv_upd;

							if($cnv_upd->e == 'ok'){

								$__msg_dt = $_wthsp->GtCnvMsgDt([ 'enc'=>$__msg_chk->enc ]);

								$_wthsp->_ws->Send([
									'srv'=>'chat',
									'act'=>'chat_message_sended',
									'to'=>[$_wthsp->wthspcnvmsg_us_enc], // Recibe
									'data'=>[
										'id'=>$__msg_dt->enc,
										'f'=>$__msg_dt->f,
										'tx'=>$__msg_dt->msg,
										'snt'=>$__msg_dt->snt,
										'me'=>'ok'
									]
								]);

							}
				

						}else{

							$_wthsp->wthspcnvmsg_wthspcnv = $__msg_v->channel->id;
							$_wthsp->wthspcnvmsg_created = $_wthsp->_Tme($__msg_v->created);
							$_wthsp->wthspcnvmsg_from = $__msg_v->from;
							$_wthsp->wthspcnvmsg_mdata = json_encode($__msg_v);
							$_wthsp->wthspcnvmsg_id = $__msg_v->id;
							$_wthsp->wthspcnvmsg_message = $__msg_v->text;
							$_wthsp->wthspcnvmsg_us = $__usr->id;
							
							$Cnv_Msg_In = $_wthsp->Cnv_Msg_In();
							
							//$rsp['cnv']['msg']['in']['p'] = $Cnv_Msg_In;

						}

					}	

				} catch (Exception $e) {
			
					echo $this->err($e->getMessage());
					
				}	
			}
		}
	}

?>