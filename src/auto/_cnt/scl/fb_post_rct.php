<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_post_rct' ]);

if( $_g_alw->est == 'ok' ){

	try {
		
		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt(['t'=>'fb_post_rct', 'm'=>5]); 
		
		//-------------------- AUTO TIME CHECK - END --------------------//
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

			if(class_exists('CRM_Cnx')){
		
				$___datprcs = [];

				$Ls_Qry = " SELECT *,
								(SELECT COUNT(*)
								FROM "._BdStr(DBT).TB_SCL_ACC_POST_RCT."
								WHERE sclaccpostrct_sclaccpost = id_sclaccpost
								) AS _tot,
								
								DATE_ADD(sclaccpost_f_chk, INTERVAL +4 HOUR) AS __datewait,
								NOW() AS __datenow
								
							FROM "._BdStr(DBT).TB_SCL_ACC_POST."
								INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccpost_sclacc = id_sclacc
								INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
								INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
							WHERE 	sclacc_id IS NOT NULL AND 
									sclacc_est = 1 {$__fl} AND 
									sclaccpost_c_reacts IS NOT NULL AND 
									scl_rds = ".GtSQLVlStr( _CId('ID_APITHRD_FB') , 'int')."
							
							HAVING _tot != sclaccpost_c_reacts AND 
									NOW() > DATE_ADD(sclaccpost_f_chk, INTERVAL +4 HOUR)
							
							ORDER BY id_sclaccpost DESC
							LIMIT 50";
												
				$LsAccPostRct = $__cnx->_qry($Ls_Qry);
				
						
				if($LsAccPostRct){
					
					$row_LsAccPostRct = $LsAccPostRct->fetch_assoc(); $Tot_LsAccPostRct = $LsAccPostRct->num_rows; 
					echo $this->h1('Facebook - FanPages Accounts - Post - Reacciones '.$Tot_LsAccPostRct);
					
					if($Tot_LsAccPostRct > 0){					
						
						do {
							
							try {	
												
								$___datprcs[] = $row_LsAccPostRct;
								echo $this->li('Lock Before to ID '.$row_LsAccPostRct['id_sclaccform']);

							} catch (Exception $e) {
								
								echo $this->err($e->getMessage());
								
							}

						} while ($row_LsAccPostRct = $LsAccPostRct->fetch_assoc()); 
						
						//echo $this->ul($___postrctin);
					}
				
				}
				
				$__cnx->_clsr($LsAccPostRct);

				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__id_accrct = $___datprcs_v['id_sclaccpost'];
						
						$__SclBd = new CRM_Thrd();
						$__RquDt = $__SclBd->RquDt(['tp'=>'post_rct', 'acc'=>$___datprcs_v['id_sclacc'] ]);
						
						if($__RquDt->nxt != NULL){ $_lmt = ''; }
						
						$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$___datprcs_v['id_sclacc'] ]);
					
						if($___tkns->tot > 0){

							foreach($___tkns->ls as $_tkn_k=>$_tkn_v){
								
								//---------- Try Tokens - Start ----------//

									echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in').' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl);

									require(GL_SCL_FB.'fb_post_rct_in.php');

									if($__tkn_scss == 'ok'){ 
										echo $this->scss('Token '.$_tkn_v->vl.' success, not need another');
										break; 
									}

								//---------- Try Tokens - End ----------//

							}
						
						}					 
				
					}

				}	
				
			}	
			
			$this->Rqu([ 't'=>'fb_post_rct' ]);
			
		}else{
			
			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Post - Reacciones - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
		


	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'fb_post_rct' ]);
		echo $e->getMessage();
		
	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Posts - Reactions - Off');

}	

	
?>