<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'cnt_dvrf' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){
		
		echo $this->h1('VERIFICACIÓN DE CODIGOS DOBLE AUTENTICACION');

		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'cnt_dvrf', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					$__dvrf = new CRM_Dvrf([ 'cl'=>$_cl_v->id ]);
					
					if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '50'; }	
					
					$DvrfChk_Qry = " SELECT id_cntdvrf, cntdvrf_cod,
											( cntdvrf_fi < NOW() - INTERVAL 10 MINUTE ) AS __rd_aft								    	
									FROM ".$_cl_v->bd.".".TB_CNT_DVRF." 
									WHERE cntdvrf_hb = '1'
									HAVING __rd_aft > 0
									ORDER BY id_cntdvrf DESC 					  	 
									LIMIT $_qry_lmt ";	  
								
					$DvrfChk = $__cnx->_qry($DvrfChk_Qry); 
					
					if($DvrfChk){

						$row_DvrfChk = $DvrfChk->fetch_assoc(); 
						$Tot_DvrfChk = $DvrfChk->num_rows;
						
						echo $this->h2($this->ttFgr($_cl_v).$Tot_DvrfChk.' códigos a verificar en '.ctjTx($_cl_v->nm,'in'));
						
						if($Tot_DvrfChk > 0){
							
							do{
									
								$___e_r = $__dvrf->UpdCod([ 'hb'=>2, 'id'=>$row_DvrfChk['id_cntdvrf'] ]);
					
								if($___e_r->e == 'ok'){ 
									echo "Bien <span style='color:green;'>".$row_DvrfChk['cntdvrf_cod']."</span> con estado no".$this->br(); 
								}
								
													
							} while ($row_DvrfChk = $DvrfChk->fetch_assoc()); $DvrfChk->free;
						
						}
						
					
					}else{
						
						echo $this->err($__cnx->c_r->error);
						
					}
					
					$__cnx->_clsr($DvrfChk);

				}else{

					echo $this->nallw($_cl_v->nm.' Leads - Double Verification - Off');
			
				}
				
			}
			
		}	
	}

}else{

	echo $this->nallw('Global Leads - Double Verification - Off');

}

?>