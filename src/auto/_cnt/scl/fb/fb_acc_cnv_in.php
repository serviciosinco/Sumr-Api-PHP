<?php

try {

	$__cnv = _NwFb_Acc_Msg([
		'id'=>$___datprcs_v['sclacc_id'],
		'cnv'=>$_cnv_sch,
		'access_token'=>$_tkn_v->vl,
		'next'=>$__RquDt->nxt,
		'lmt'=>$_lmt_msg
	]);

	//echo $this->li( compress_code( print_r($__cnv->pg, true) ) );

	if(isN( $__cnv->w )){ $__tkn_scss = 'ok'; }else{ $__tkn_scss = 'no'; }

	if(!isN($__id_acc)){

		$__totcnv = count($__cnv->data);

		$__SclBd->Rqu([
			'tp'=>'cnv',
			'acc'=>$___datprcs_v['id_sclacc'],
			'nxt'=>$__cnv->pg->paging->cursors->after
		]);

		if($__totcnv > 0){

			foreach($__cnv->data as $cnv_k=>$cnv_v){

				if(!isN($cnv_v->messages)){
					$__bx_msg = $cnv_v;
				}elseif(!isN($__cnv->data->messages)){
					$__bx_msg = $__cnv->data;
				}

				$__totmsg = count( $__bx_msg );

				if($__totmsg > 0){

					foreach( $__bx_msg->messages as $msg_k=>$msg_v){

						$__SclBd->cnv_from = NULL;

						foreach( $__bx_msg->senders as $ks=>$vs){
							if($vs->id != $___datprcs_v['sclacc_id']){
								$__SclBd->cnv_from = $vs->id;
							}
						}

						$__SclBd->__t = 'acc_msg';
						$__SclBd->scl_rds = $___datprcs_v['scl_rds'];

						$__SclBd->cnv_acc = $___datprcs_v['id_sclacc'];
						$__SclBd->cnv_acc_id = $___datprcs_v['sclacc_id'];
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

						if($__Prc->e != 'ok'){
							$___cnv_li[$__id_acc] .= $this->err( 'Last Update:'.$___datprcs_v['___cnv_upd'].' -> Diff:'.print_r($__diff, true).' -> Prc:'.print_r($__Prc, true), '', ' font-family:Arial; font-size:10px; '.$_sty );
						}else{
							$___cnv_li[$__id_acc] .= $this->scss('Last Update:'.$___datprcs_v['___cnv_upd'].' -> Diff:'.print_r($__diff, true).' -> Prc:'.print_r($__Prc, true), '', ' font-family:Arial; font-size:10px; '.$_sty );
						}

					}

				}

			}

		}else{

			echo $this->err( 'No results, error? '.$__cnv->w );

		}
	}

	$___accin .= $this->li(
		$this->h1(
			$this->ul(
				$this->li('Account:'.$__id_acc).
				$this->li('-> FanPage:'. $___datprcs_v['sclacc_id']).
				$this->li('-> Conversations:'. $__totcnv).
				$this->li('-> Limit Messages:'.$_lmt_msg).
				$this->li('-> Messages:'.ul($___cnv_li[$__id_acc]))
			)
		)
	);

} catch (Exception $e) {

    $this->Rqu([ 't'=>'fb_acc_cnv' ]);
    echo $e->getMessage();

}


?>