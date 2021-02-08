 <?php 
	
	try{
		
		$__Ec = new API_CRM_ec();
		
		//------------------ Post Data ------------------//
		
		
			$_p_eclsts = Php_Ls_Cln($_POST['eclsts']);
			$_p_plcy = Php_Ls_Cln($_POST['plcy']);
			$_p_est = Php_Ls_Cln($_POST['est']);
		
		
		//------------------ Detail Data ------------------//
		
		
			$___plcydt = GtClPlcyDt([ 'id'=>$_p_plcy, 't'=>'enc' ]);
			$___eclstsdt = GtEcLstsDt(['id'=>$_p_eclsts, 't'=>'enc' ]);
			$__Ec->plcy_id = $___plcydt->id;
			

		//------------------ Process Change ------------------//


		$__chk = $__Ec->EcLstsPlcyChk([ 'eclsts'=>$___eclstsdt->id, 'plcy'=>$___plcydt->id ]);

		
		if(!isN($__chk->id)){
			
			$___opt = [ 'id'=>$__chk->id, 'e'=>$_p_est ];
			$__prc = $__Ec->UpdEcLsts_Plcy($___opt);
			$rsp = $__prc;

		}else{
			
			$__prc = $__Ec->InEcLsts_Plcy([ 'eclsts'=>$___eclstsdt->id ]); 
			$rsp = $__prc;
			$rsp->in = 'ok';
			
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>