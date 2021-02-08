<?php 
	
	try{
		
		$_t2 = Php_Ls_Cln($_POST['t2']);
		$_id = Php_Ls_Cln($_POST['id']);
		$_acc = Php_Ls_Cln($_POST['acc']);
		$_act = Php_Ls_Cln($_POST['act']);

		if(!isN($_acc)){
			$__acc_dt = GtClAwsAccDt([ 'id'=>$_acc, 't'=>'enc' ]);
			$__acc_key = $__acc_dt->key;
			$__acc_scrt = $__acc_dt->scrt;
		}

		$_aws->AWS_KEY = $__acc_key;
		$_aws->AWS_SCRT = $__acc_scrt;
		$_aws->rcnx();

		
		/*
		$rsp['tmp_acc_key'] = $_aws->AWS_KEY;
		$rsp['tmp_acc_scrt'] = $_aws->AWS_SCRT;
		$rsp['tmp2_acc_key'] = $__acc_key;
		$rsp['tmp2_acc_scrt'] = $__acc_scrt;
		*/

		if($_t2 == 'turn_ec2'){
			
			if($_act =='start'){ $_trone='on'; }elseif($_act =='stop'){ $_trone='off'; }
			
			for ($k=0; $k<2; $k++){	
				$__prc = $_aws->_ec2_trnon([ 'e'=>$_trone, 'id'=>$_id ]);
				//sleep(2);
			}

			if($__prc->e == 'ok'){ 
				$rsp['e'] = 'ok'; 
				$rsp['nwcls'] = $__prc->nw_status; 
			}else{
				$rsp['w'] = 'not response';
				$rsp['rq'] = $__prc;
			}

		}

		
		
	}catch(Exception $e){

		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();

	}
	
?>