<?php 

	try{
		
		$cnt = GtCntPrntDt(["enc"=>$_POST['_i']]);	
		$rsp['es'] = $cnt;
		
		$__CntIn = new CRM_Cnt();					
		
		if($_POST['d'] == 'tel'){
			$__dtcnt = $__CntIn->InCntTel([
							'tel'=>ctjTx($_POST['cnt_tel2'],'out'), 
							'ps'=>ctjTx($_POST['cnt_tel_ps2'],'out'), 
							'ext'=>ctjTx($_POST['cnt_tel_ext2'],'out'), 
							'tp'=>ctjTx($_POST['cnt_tel_tp2'],'out'), 
							'cnt'=>$cnt->cnt1
						]);
			
			$rsp['e']	= $__dtcnt->e;		
				
		}elseif($_POST['d'] == 'eml'){
			$__dtcnt = $__CntIn->InCntEml([ 'eml'=>$_POST['cnt_eml2'], 'cnt'=>$cnt->cnt1 ]);
			$rsp['e']	= $__dtcnt->e;
		}elseif($_POST['d'] == 'doc'){
			$__dtcnt = $__CntIn->InCntDc([ 'dc'=>$_POST['cnt_dc2'], 'tp'=>$_POST['cntdc_tp2'], 'cnt'=>$cnt->cnt1  ]);
			$rsp['e']	= $__dtcnt->e;
		}		
		
	
		

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
		
	}
	
?>