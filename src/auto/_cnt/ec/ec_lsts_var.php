<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'ec_lsts_var' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){	
		
		define('GL_SND_EC_LSTS', 'ec_lsts/'); // Actions

		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
			
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'ec_lsts_var', 'cl'=>$_cl_v->id ])->est == 'ok' ){
					
					//-------------------- AUTO TIME CHECK - START --------------------//
		
						$_AUTOP_d = $this->RquDt([ 't'=>'ec_lsts_var', 'cl'=>$_cl_v->id, 'm'=>5 ]);
						echo $this->h2($_cl_v->nm.' lock? '.$_AUTOP_d->lck, '', '_check');
							
					//-------------------- AUTO TIME CHECK - END --------------------//
				
					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){ 

						$___datprcs = [];

						echo $this->h1('Listas - Correos - Variables', '_lsts');

						$_ideclsts = Php_Ls_Cln($_POST['_lsts']);

						if(!isN($_ideclsts)){
							$__id_lsts = ' AND id_eclsts = '.$_ideclsts;	
						}
							
						$Ls_Lsts_Qry = " 	SELECT *  
											FROM "._BdStr(DBM).TB_EC_LSTS."
											WHERE 	eclsts_auto = 1 AND 
													id_eclsts IN (
														SELECT eclstsvar_lsts 
														FROM "._BdStr(DBM).TB_EC_LSTS_VAR."
													)  $__id_lsts
										";
											
						$Ls_Lsts = $__cnx->_qry($Ls_Lsts_Qry); 
						
						if($Ls_Lsts){
						
							$__CntIn = new CRM_Cnt();
							$row_Ls_Lsts = $Ls_Lsts->fetch_assoc(); 
							$Tot_Ls_Lsts = $Ls_Lsts->num_rows; 
							
							echo $this->h2($Tot_Ls_Lsts.' Listas', '_lsts');
							
							if($Tot_Ls_Lsts > 0){
							
								do{
								
									try {	
											
										$this->id_eclsts = $row_Ls_Lsts['id_eclsts'];
										$__rd_eclsts_p = $this->EcLsts_Rd([ 'e'=>'on' ]);	

										//echo $this->h3( 'Locked List:'.$this->id_eclsts.':'.$__rd_eclsts_p->e );

										if($__rd_eclsts_p->e == 'ok'){
											$___datprcs[] = $row_Ls_Lsts;
										}

									} catch (Exception $e) {
										
										$___lck = $this->Rqu([ 't'=>'ec_lsts_var', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
										echo $this->err($e->getMessage());
										
									}

								} while ($row_Ls_Lsts = $Ls_Lsts->fetch_assoc());


								//---------- Free Query For This Customer ----------//
									
									$this->Rqu([ 't'=>'ec_lsts_var', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									$__cnx->_clsr($LstsSgm);

								//---------- Release Query For This Customer ----------//				
												
								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){
									
									//echo $this->li('Process List:'.$___datprcs_v['id_eclsts']);
									
									require(GL_SND_EC_LSTS.'ec_lsts_var_ext_1.php');		
									
									$this->id_eclsts = $___datprcs_v['id_eclsts'];

									$__rd_eclsts_p = $this->EcLsts_Rd();

								}	

								echo $this->ul( $_li_f, 'Ls_Lsts');	
							
							}
							
						}else{
							
							echo $this->err($__cnx->c_r->error);
							
						}
						
						
						$__cnx->_clsr($Ls_Lsts);
					
					}

				}else{

					echo $this->nallw($_cl_v->nm.' Listas - Variables - Off');
			
				}
			
			}
		}
		
	}else{
		
		echo $this->err('AUTO_LSTS_EC:off');
		
	}

}else{

	echo $this->nallw('Global Listas - Variables - Off');

}

?>