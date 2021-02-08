 <?php 
	
	try{
		
		$__Cnt = new CRM_Cnt();
		
		//------------------ Post Data ------------------//
		
		
			$_p_cnttel = Php_Ls_Cln($_POST['cnttel']);
			$_p_plcy = Php_Ls_Cln($_POST['plcy']);
			$_p_plcy_tp = Php_Ls_Cln($_POST['plcy_tp']);
			$_p_est = Php_Ls_Cln($_POST['est']);
		
		
		//------------------ Detail Data ------------------//
		
		
			$___plcydt = GtClPlcyDt([ 'id'=>$_p_plcy, 't'=>'enc' ]);
			$___cntteldt = GtCntTelDt(['id'=>$_p_cnttel, 't'=>'enc' ]);
			$__Cnt->plcy_id = $___plcydt->id;
			

		//------------------ Process Change ------------------//


		$__chk = $__Cnt->CntTelPlcyChk([ 'cnttel'=>$___cntteldt->id, 'plcy'=>$___plcydt->id ]);
		
		
		if(!isN($__chk->id)){
			
			$___opt = [ 'id'=>$__chk->id, $_p_plcy_tp=>$_p_est ];
			if($_p_plcy_tp != 'sndi' && $_p_est == 1){ $___opt['sndi'] = 1; }
			
			$__prc = $__Cnt->UpdCntTel_Plcy($___opt);
			$rsp = $__prc;

		}else{
			
			$__prc = $__Cnt->InCntTel_Plcy([ 'cnttel'=>$___cntteldt->id ]); 
			$rsp = $__prc;
			$rsp->in = 'ok';
			
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>