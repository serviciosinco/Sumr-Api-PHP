<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'cnt_mdl_lck' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){
		
		$___datprcs = [];

		//--------- AUTO TIME CHECK - START ---------//

		$_AUTOP_d = $this->RquDt([ 't'=>'mdl_cnt_lck', 'm'=>2 ]); 
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
			
			$this->Rqu([ 't'=>'mdl_cnt_lck' ]);
				
			try {
				
				$__Cl = new CRM_Cl(); 
				$__clls = $__Cl->Cl_Ls([ 'on'=>1, 'adm'=>'ok' ]);
								
				echo $this->h1('Verificar Contactos Bloqueados '.SIS_H2);
				
				foreach($__clls->ls as $__clls_k=>$__clls_v){
					
					$Ls_MdlCnt_Qry = "	SELECT id_mdlcnt 
										FROM ".$__clls_v->bd.".".TB_MDL_CNT." 
										WHERE mdlcnt_lck = 1 
										LIMIT 50";
										
					$Ls_MdlCnt = $__cnx->_qry($Ls_MdlCnt_Qry); 
					
					if($Ls_MdlCnt){
						
						$row_Ls_MdlCnt = $Ls_MdlCnt->fetch_assoc(); 
						$Tot_Ls_MdlCnt = $Ls_MdlCnt->num_rows;
						
						if($Tot_Ls_MdlCnt > 0){
							
							$_tot = 0;
							
							do{
									
								try {	
												
									$___datprcs[] = $row_Ls_MdlCnt;
									echo $this->li('Lock Before to ID '.$row_Ls_MdlCnt['id_mdlcnt']);

								} catch (Exception $e) {
									
									echo $this->err($e->getMessage());
									
								}
						
							} while ($row_Ls_MdlCnt = $Ls_MdlCnt->fetch_assoc()); $Ls_MdlCnt->free;
						}
					}
					
					$__cnx->_clsr($Ls_MdlCnt);

					if(!isN( $___datprcs ) && count($___datprcs) > 0){

						foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

							$__tme_1 = new DateTime($___datprcs_v['mdlcnt_lck_h']);
							$__tme_2 = new DateTime(date("H:i:s"));
							$__intrv = $__tme_1->diff($__tme_2);

							if($__intrv->h > 0 || $__intrv->i > 10){
								$rsl = MdlCntLck([ 'id'=>$___datprcs_v['id_mdlcnt'], 'bd'=>$__clls_v->bd ]);
								if($rsl->e == 'ok'){ $_tot++; }		
							}

						}
					}

					echo 'Desbloqueados '.$_tot.' leads en '.$__clls_v->bd.'</br>';				
			
				}
				
				$this->Rqu([ 't'=>'mdl_cnt_lck' ]);
				
			
			} catch (Exception $e) {
				
				$this->Rqu([ 't'=>'mdl_cnt_lck' ]);
				
				echo 'Error Verificar Contactos Bloqueados: ',  $e->getMessage(), "\n";
				
			}
		
		
		}else{
			
			echo $this->h2('Unlock '.$this->Spn('Leads Gestion'), 'Auto_Tme_Prg');
			
		}
			
	}

}else{

	echo $this->nallw('Global Leads - Oportunidad Lock - Off');

}


?>