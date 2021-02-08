<?php 
		
	if(class_exists('CRM_Cnx')){
		
		
		$_AUTOP_d = $this->RquDt([ 't'=>'kill_sleep', 'm'=>2 ]); 
	
	
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
			
			
			$this->Rqu([ 't'=>'kill_sleep' ]);
		
		
			try {
				
				$Ls_Qry = "SHOW processlist";			
				$Ls_Rg = $__cnx->_qry($Ls_Qry);
				
				if($Ls_Rg){ 
					
					$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
					$Tot_Ls_Rg = $Ls_Rg->num_rows;
					
					do { 
						
						$__id = $row_Ls_Rg['Id'];
						$__cmnd = $row_Ls_Rg['Command'];
						$__tme = $row_Ls_Rg['Time'];
						
						echo $this->br();
							
						if($__cmnd == "Sleep" && $__tme > 300){
							$Ls_PQry = "KILL $__id";			
							$Ls_PRg = $__cnx->_qry($Ls_PQry);
							if($Ls_PRg){
								echo $this->scss('Deleted');
							}else{
								echo $this->err('Not deleted: '.$__cnx->c_p->error);
							}
						}else{	
							echo '<span style="color:aqua;">Not sleeping</span>';	
						}
						echo $this->br(2);
						
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				
				}
				
				
				$__cnx->_clsr($Ls_Rg);
				
				
				
				
				
				$Ls_Qry = "SHOW processlist";			
				$Ls_Rg = $__cnx->_prc($Ls_Qry);
				
				if($Ls_Rg){ 
					
					$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
					$Tot_Ls_Rg = $Ls_Rg->num_rows;
					
					do { 
						
						$__id = $row_Ls_Rg['Id'];
						$__cmnd = $row_Ls_Rg['Command'];
						$__tme = $row_Ls_Rg['Time'];
						
						echo $this->br();
							
						if($__cmnd == "Sleep" && $__tme > 300){
							$Ls_PQry = "KILL $__id";			
							$Ls_PRg = $__cnx->_prc($Ls_PQry);
							if($Ls_PRg){
								echo '<span style="color:green;">Deleted</span>';
							}else{
								echo '<span style="color:red;">Not deleted: '.$__cnx->c_p->error.'</span>';
							}
						}else{	
							echo '<span style="color:aqua;">Not sleeping</span>';	
						}
						echo $this->br(2);
						
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				
				}
			
				$__cnx->_clsr($Ls_Rg);
				
				$this->Rqu([ 't'=>'kill_sleep' ]);
				
			
			} catch (Exception $e) {
				
				$this->Rqu([ 't'=>'kill_sleep' ]);
				
			    echo 'Error Verificar Contactos Bloqueados: ',  $e->getMessage(), "\n";
			    
			}
		
		
		}else{
		
			echo $this->h2('Unlock '.$this->Spn('SQL'), 'Auto_Tme_Prg');
			
		}
		
		

	}
?>