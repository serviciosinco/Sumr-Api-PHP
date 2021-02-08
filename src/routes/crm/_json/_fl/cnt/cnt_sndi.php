 <?php
	
	try{
		
		$__Cnt = new CRM_Cnt();
		
		//------------------ Post Data ------------------//
		
			$_p_est = Php_Ls_Cln($_POST['est']);
			$_p_cnt = Php_Ls_Cln($_POST['cnt']);
			$_p_plcy = Php_Ls_Cln($_POST['plcy']);
		
		//------------------ Detail Data ------------------//
		
			$___plcydt = GtClPlcyDt([ 'id'=>$_p_plcy, 't'=>'enc' ]);
			$___cntdt = GtCntDt([ 'id'=>$_p_cnt, 't'=>'enc' ]);
			$__Cnt->plcy_id = $___plcydt->id;
		
		//------------------ Process Change ------------------//
		
		
		$__chk = $__Cnt->CntPlcyChk([ 'cnt'=>$___cntdt->id, 'plcy'=>$___plcydt->id ]);
		
		
		if(!isN($__chk->id)){

			$__prc = $__Cnt->UpdCnt_Plcy([ 'id'=>$__chk->id, 'sndi'=>$_p_est ]);
			$rsp = $__prc;
			
		}else{
			
			$__prc = $__Cnt->InCnt_Plcy([ 'cnt'=>$___cntdt->id ]); 
			$rsp = $__prc;
			$rsp->in = 'ok';
			
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>