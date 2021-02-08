<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'whtsp_msv_acc' ]);

if( $_g_alw->est == 'ok' ){

	try {
			
		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'msv_acc', 'm'=>1 ]);
		
		//-------------------- AUTO TIME CHECK - END --------------------//
		
		//$_AUTOP_d->hb = 'ok';
			
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){	
			
			if(class_exists('CRM_Cnx')){
				
				$Ls_Qry = " SELECT wthsp_no
							FROM "._BdStr(DBT).TB_WHTSP." 
								INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
							WHERE whtsp_api = ".GtSQLVlStr(ID_APITHRD_MSVSPC, 'int')." 
						";
				
				//echo $this->h1($Ls_Qry);
						
				$LsMsvAcc = $__cnx->_qry($Ls_Qry);		
						
				if($LsMsvAcc){
					
					$row_LsMsvAcc = $LsMsvAcc->fetch_assoc(); $Tot_LsMsvAcc = $LsMsvAcc->num_rows; 
					
					echo $this->h1('WhatsApp - MassiveSpace - Accounts '.$Tot_LsMsvAcc);
					
					if($Tot_LsMsvAcc > 0){					
						
						do {
							
							echo $this->h2('Details of account '.$row_LsMsvAcc['wthsp_no']);
							
							$__detail = $this->_massive->acc_dtl([ 'acc'=>$row_LsMsvAcc['wthsp_no'] ]);
							
							//print_r($__detail->rsl);
							
								
						} while ($row_LsMsvAcc = $LsMsvAcc->fetch_assoc()); 
						
						
						echo $this->ul($___accin);
						
					}
				
				}

				$__cnx->_clsr($LsMsvAcc);

			}
		
			
			$this->Rqu([ 't'=>'msv_acc' ]);
		
			
		}else{
			
			echo $this->h1('WhatsApp'.$this->Spn('MassiveSpace Accounts - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
		
		
		
	} catch (Exception $e) {
		
		
		$this->Rqu([ 't'=>'fb_acc' ]);

		echo $e->getMessage();
		
	}


}else{

	echo $this->nallw('Global Whatsapp - Massive - Accounts Info - Off');

}
	
?>