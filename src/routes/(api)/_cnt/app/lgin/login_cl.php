<?php

	if(!isN($__us_dt->id)){

		$___ses = new CRM_SES(); 

		$_chk = $___ses->GtSesDt([ 'i'=>$_uses_enc ]);
		
		if($_chk->e != 'ok' || $_chk->est != 'ok'){
			
			$___ses->lgin_dvc = $_usdvc_id;

			if($_usdvc_tp == 'android'){
				$___ses->lgin_dvc_android = 'ok';
			}elseif($_usdvc_tp == 'ios'){
				$___ses->lgin_dvc_ios = 'ok';
			}
			
			$___ses_r = $___ses->__rg([ 'cl'=>$_cl_enc, 'id'=>$__us_dt->id, 'nvl'=>$__us_dt->lvl ], 'ok');
			
			if($___ses_r->e == 'ok'){
				$rsp["e"] = "ok";
				$rsp["id"] = $___ses_r->enc;
			}else{
				$rsp["w"] = "no ses register ".$___ses_r->w." qry ".$___ses_r->q;
			}

		}else{

			$rsp["e"] = "ok";
			$rsp["id"] = $_chk->enc;

		}

	}

?>