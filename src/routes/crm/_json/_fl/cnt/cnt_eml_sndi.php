 <?php 
	
	try{
		
		$__Cnt = new CRM_Cnt();
		
		//------------------ Post Data ------------------//
		
		
			$_p_cnteml = Php_Ls_Cln($_POST['cnteml']);
			$_p_plcy = Php_Ls_Cln($_POST['plcy']);
			$_p_est = Php_Ls_Cln($_POST['est']);
		
		
		//------------------ Detail Data ------------------//
		
		
			$___plcydt = GtClPlcyDt([ 'id'=>$_p_plcy, 't'=>'enc' ]);
			$___cntemldt = GtCntEmlDt(['id'=>$_p_cnteml, 'tp'=>'enc', 'd'=>['plcy'=>'ok'] ]);
			$__Cnt->plcy_id = $___plcydt->id;
			

		//------------------ Process Change ------------------//


		$__chk = $__Cnt->CntEmlPlcyChk([ 'cnteml'=>$___cntemldt->id, 'plcy'=>$___plcydt->id ]);
		
		
		if(!isN($__chk->id)){
			
			$__prc = $__Cnt->UpdCntEml_Plcy([ 'id'=>$__chk->id, 'sndi'=>$_p_est ]);
			$rsp = $__prc;
			
		}else{
			
			$__prc = $__Cnt->InCntEml_Plcy([ 'cnteml'=>$___cntemldt->id ]); 
			$rsp = $__prc;
			
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>