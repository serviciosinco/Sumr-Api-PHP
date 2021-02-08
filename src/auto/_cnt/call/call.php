<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'call' ]);

if( $_g_alw->est == 'ok' ){

	try {	

		echo $this->h1('LLAMADAS - MP3');
		
		if(date("H") > 18 || $this->g__t == 'call'){	
		
			if(class_exists('CRM_Cnx')){

				$__twiliosrc = 'ok';	

				$Ls_Qry = " 
							SELECT call_sid
							FROM "._BdStr(DBT).TB_CALL." 
							WHERE call_audio IS NULL AND call_audio_e = 1 AND call_callstatus = 'completed'
							LIMIT 5
						";
							
				$Ls_Rg = $__cnx->_qry($Ls_Qry); 

				if($Ls_Rg){

					$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
					$Tot_Ls_Rg = $Ls_Rg->num_rows;
				
					if($Tot_Ls_Rg > 0){
					
						echo $this->h1('Vinculo Grabaciones '.$Tot_Ls_Rg);
						
						do { 
						
								$__Call = new CRM_Call();
								$__Call->sid = $row_Ls_Rg['call_sid'];
								$PrcDt = $__Call->Call_Audio_Upd(['run'=>'ok']);
								
								echo $this->li( $this->Strn($row_Ls_Rg['call_sid']));	
								if($PrcDt->e == 'ok'){ echo $this->scss('Guardado exitosamente'); }

						} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); 

					}
				
				}
				
				$__cnx->_clsr($Ls_Rg);	
				
			}
		
		}else{
					
			echo $this->h2('Actualiza después de las 6PM');
			
		}


	} catch (Exception $e) {
		
		echo 'Error Call: ',  $e->getMessage(), "\n";
		
	}

}else{

	echo $this->nallw('Global Call Off');

}

?>