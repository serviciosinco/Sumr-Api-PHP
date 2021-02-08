<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_post_cmn' ]);

if( $_g_alw->est == 'ok' ){

	try {
		
		
		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt(['t'=>'fb_post_cmn', 'm'=>5]); 
		
		//-------------------- AUTO TIME CHECK - END --------------------//

		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

			if(class_exists('CRM_Cnx')){
				
				$___datprcs = [];
				
				$Ls_Qry = " SELECT id_sclaccpost, id_sclacc, sclacc_nm, sclaccpost_id, scl_rds, sclaccpost_c_comments,
								(SELECT COUNT(*)
								FROM "._BdStr(DBT).TB_SCL_ACC_POST_CMN."
								WHERE sclaccpostcmn_sclaccpost = id_sclaccpost
								) AS _tot
							FROM "._BdStr(DBT).TB_SCL_ACC_POST."
								INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccpost_sclacc = id_sclacc
								INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
								INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
							WHERE 	sclacc_id IS NOT NULL AND 
									sclacc_est = 1 {$__fl} AND 
									sclaccpost_c_comments IS NOT NULL 
									AND scl_rds = ".GtSQLVlStr(_CId('ID_APITHRD_FB'), 'int')."
							
							HAVING _tot != sclaccpost_c_comments
							
							ORDER BY id_sclaccpost DESC
							LIMIT 50";
												
				$LsAccPostCmn = $__cnx->_qry($Ls_Qry);
						
				if($LsAccPostCmn){
					
					$row_LsAccPostCmn = $LsAccPostCmn->fetch_assoc(); $Tot_LsAccPostCmn = $LsAccPostCmn->num_rows; 
					echo $this->h1('Facebook - FanPages Accounts - Post - Comments '.$Tot_LsAccPostCmn);
					
					if($Tot_LsAccPostCmn > 0){					
						
						do {
							
							try {	
												
								$___datprcs[] = $row_LsAccPostCmn;
								echo $this->li('Lock Before to ID '.$row_LsAccPostCmn['id_sclaccform']);

							} catch (Exception $e) {
								
								echo $this->err($e->getMessage());
								
							}

						} while ($row_LsAccPostCmn = $LsAccPostCmn->fetch_assoc()); 
						
						echo $this->ul($___postcmnin);
					}
				
				}

				$__cnx->_clsr($LsAccPostCmn);

				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__id_accpost = $___datprcs_v['id_sclaccpost'];
						
						$__SclBd = new CRM_Thrd();
						
						$__RquDt = $__SclBd->RquDt(['tp'=>'post_cmn', 'acc'=>$___datprcs_v['id_sclacc'] ]);
						
						if($__RquDt->nxt != NULL){ $_lmt = ''; }
						
						$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$___datprcs_v['id_sclacc'] ]);

						if($___tkns->tot > 0){

							foreach($___tkns->ls as $_tkn_k=>$_tkn_v){

								//---------- Try Tokens - Start ----------//

									echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in').' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl);

									require(GL_SCL_FB.'fb_post_cmn_in.php');

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
			
			$this->Rqu([ 't'=>'fb_post_cmn' ]);
			
		}else{
			
			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Post - Comments - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
		
		
	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'fb_post_cmn' ]);
		echo $e->getMessage();
		
	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Posts - Comments - Off');

}		
	
?>