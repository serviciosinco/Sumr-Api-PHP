<?php 

	/*
	if(!isN($__last)){	
		
		//-------------------- ULTIMAS TAREAS ACTUALIZADAS EN UI * --------------//				
				
			$__last = date("Y-m-d H:i:s", strtotime("-2 minutes", strtotime($__last) )); // Resta 10 min por si algun registro entra tarde - Webhooks y demas
			
			
			$__rdsdt = __LsDt([ 'k'=>'api_thrd', 'tp'=>'enc', 'id'=>$__live->scl->prfl ]);
			$_acc_dt = GtSclAccDt([ 'enc'=>$__live->scl->acc ]);
			
			$__acc = GtSclAccLs(['rds'=>$__rdsdt->d->id, 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC, 'est'=>1, 'lst_fi'=>$__last, 'd'=>['cnv'=>'ok'] ]);
			
			if($__live->scl->cnv->est == 'inbx'){ $_est = 385; }
			elseif($__live->scl->cnv->est == 'rdy'){ $_est = 386; }
			elseif($__live->scl->cnv->est == 'spm'){ $_est = 387; }
			
			
			$rsp['live']['scl']['acc'] = $__acc->network;
			$rsp['live']['scl']['cnv'] = GtSclAccCnvLs([ 'scl_acc'=>$_acc_dt->id, 'est'=>$_est, 'lmt'=>20 ]);
			
			if($__live->scl->cnv->now){
				$_cnv_dt = GtSclAccCnvDt([ 'enc'=>$__live->scl->cnv->now ]);
				$rsp['live']['scl']['msg'] = GtSclAccCnvMsgLs([ 'scl_acc_cnv'=>$_cnv_dt->id, 'ord'=>'a' ]);
			}
	}
	*/
	
?>