<?php 
	
$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'lck_auto_rqu' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){ 

		echo $this->h1('DISLOCK CRONJOBS');		
				
		if($this->_s_cl->tot > 0){	
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'lck_auto_rqu', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					$AutoRquQry = "	SELECT *
									FROM "._BdStr(DBA).TB_AUTO_RQU." 
									WHERE autorqu_lock='1' AND
										autorqu_cl='".$_cl_v->id."'
								";	  
		
					$AutoRqu = $__cnx->_qry($AutoRquQry); 	
						
					if($AutoRqu){

						$rwAutoRqu = $AutoRqu->fetch_assoc(); 
						$TotAutoRqu = $AutoRqu->num_rows;
						
						echo $this->h2($this->ttFgr($_cl_v).$TotAutoRqu.' cronjobs '.ctjTx($_cl_v->nm,'in').'('.$_cl_v->id.')' );		
								
						if($TotAutoRqu > 0){
							
							do{
								
								
								$__tme_1 = new DateTime($rwAutoRqu['autorqu_f_chk']);
								$__tme_2 = new DateTime(SIS_F_D2);
								$__intrv = $__tme_1->diff($__tme_2);
									
								echo $this->h3($rwAutoRqu['autorqu_tp'].' '.$rwAutoRqu['autorqu_f_chk']);
								
								if($__intrv->i > 3){
									
									$___lck = $this->Rqu([ 't'=>$rwAutoRqu['autorqu_tp'], 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									
									if($___lck->e == 'ok'){
										
										echo $this->scss('Desbloqueado exitosamente');
										
									}
										
								}
													
							} while ($rwAutoRqu = $AutoRqu->fetch_assoc()); $AutoRqu->free;
						
						}	
					
					}else{
						
						echo $this->err($__cnx->c_r->error);
						
					}
					
					
					$__cnx->_clsr($AutoRqu);
				
				}else{

					echo $this->nallw($_cl_v->nm.' Auto Request - Off');
			
				}					
				
			}
			
		}	
		
	}else{
		
		echo $this->err('AUTO_CHK_EML:off');
		
	}

}else{

	echo $this->nallw('Global Auto Request Off');

}		

?>