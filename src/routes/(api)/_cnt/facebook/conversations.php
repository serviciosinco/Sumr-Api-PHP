<?php 
	
	
	$_acc_dt = GtSclAccDt([ 'acc_id'=>$cv->value->page_id ]);

	
	//file_put_contents("post.log",print_r($cv,true).print_r($_acc_dt,true));
	
	
	if(!isN($_acc_dt->acc_scl)){
		
		
		foreach($_acc_dt->acc_scl as $ka=>$va){
			if(!isN($va->tlvd)){
				$__cnv = _NwFb_Acc_Msg([
										'id'=>$cv->value->page_id,
										'cnv'=>$cv->value->thread_id,
										'access_token'=>$va->tlvd,
										'lmt'=>20
									]);
				if(!isN($__cnv->data)){ break; }	
			}				
		}	
											
		$__totcnv = count($__cnv->data);
		
		if($__totcnv > 0){
			
			foreach($__cnv->data as $cnv_k=>$cnv_v){
				
				if(!isN($__cnv->data->messages)){
					$__bx_msg = $__cnv->data;
				}
		
				$__totmsg = count( $__bx_msg ); 

				if($__totmsg > 0){	
						
					foreach( $__bx_msg->messages as $msg_k=>$msg_v){
						
						$__SclBd = new CRM_Thrd();
						
						foreach( $__bx_msg->senders as $ks=>$vs){
							if($vs->id != $_acc_dt->cid){ $__SclBd->cnv_from = $vs->id; }
						}
						
						$__SclBd->__t = 'acc_msg';	
						$__SclBd->scl_rds = $row_LsAcc['scl_rds'];
						$__SclBd->cnv_acc = $_acc_dt->id;
						$__SclBd->cnv_acc_id = $_acc_dt->acc_id;
						$__SclBd->cnv_id =  $__bx_msg->id;
						$__SclBd->cnv_snpt =  $__bx_msg->snippet;
						
						if(!isN($__bx_msg->updated_time->date)){
							$__SclBd->cnv_upd =  $__bx_msg->updated_time->date;
						}else{
							$__SclBd->cnv_upd =  $__bx_msg->updated_time;
						}
						
						$__SclBd->cnv_unr =  $__bx_msg->unread_count;
						$__SclBd->msg_created = $msg_v->created_time->date;
						$__SclBd->msg_from_o = json_encode($msg_v->from);
						$__SclBd->msg_from = $msg_v->from->id;
						$__SclBd->msg_id = $msg_v->id;
						$__SclBd->msg_message = $msg_v->message;
						$__SclBd->msg_sticker = $msg_v->sticker;
						$__SclBd->msg_tags = json_encode($msg_v->tags);
						$__SclBd->msg_attach = json_encode($msg_v->attachments);
						$__Prc = $__SclBd->In();
						
						if($__Prc->e == 'ok'){ 
							$__e = 'ok';	
						}else{
							$__e = 'no';
						}
						
					}	
					
				}
				
			}
			
		}
	}
	
	
	
?>