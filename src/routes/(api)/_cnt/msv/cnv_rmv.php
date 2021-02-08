<?php

	if(!isN( $__cnv_msg_id )){

		//$_wthsp->GtCnvDt([ 'id'=>$this->wthspcnvmsg_wthspcnv ]);
		
		$_wthsp->_ws->Send([
			'srv'=>'chat',
			'act'=>'chat_conversation_closed',
			'to'=>[$_wthsp->wthspcnvmsg_us_enc], // Recibe
			'data'=>[
				'id'=>'sch'
			]
		]);

	}

?>