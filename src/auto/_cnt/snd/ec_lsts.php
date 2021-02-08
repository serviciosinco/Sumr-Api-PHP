<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_lsts' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx') && defined('AUTO_LSTS_EC') && AUTO_LSTS_EC == 'on'){	
		
		echo $this->h1('Listas Envio - Automaticas', '_lsts');
		
		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec_lsts', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					$Ls_Lsts_Qry = "
					
									SELECT eclsts_nm
									FROM "._BdStr(DBM).TB_EC_LSTS." 
										INNER JOIN "._BdStr(DBM).TB_CL." ON eclsts_cl = id_cl
									WHERE cl_enc = '".$_cl_v->enc."' AND eclsts_auto = 1	 			
									ORDER BY id_eclsts ASC
									LIMIT 20
								
								";
								
					$Ls_Lsts = $__cnx->_qry($Ls_Lsts_Qry); 
					
					if($Ls_Lsts){
					
						$row_Ls_Lsts = $Ls_Lsts->fetch_assoc(); 
						$Tot_Ls_Lsts = $Ls_Lsts->num_rows; 
						
						echo $this->h2($this->ttFgr($_cl_v).$Tot_Ls_Lsts.' listas de '.$_cl_v->nm, '_lsts');
						
						if($Tot_Ls_Lsts > 0){
				
							do{
								
								echo $this->h3('Lista:'.ctjTx($row_Ls_Lsts['eclsts_nm'],'in') );										
								
							} while ($row_Ls_Lsts = $Ls_Lsts->fetch_assoc());		
							
							echo $this->ul( $_li_f, 'Ls_Lsts');	
											
						}
								
					}else{
						
						echo $this->err($__cnx->c_r->error);
						
					}
					
					$__cnx->_clsr($Ls_Lsts);

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Listas Automaticas - Off');
				
				}	
				
			}			
		
		}	
		
		
		
		
	}else{
		
		echo $this->err('AUTO_LSTS_EC:off');
		
	}


}else{

	echo $this->nallw('Global Envios Masivos - Listas Automaticas - Off');

}

?>