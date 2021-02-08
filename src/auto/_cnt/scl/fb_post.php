<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_post' ]);

if( $_g_alw->est == 'ok' ){

	try {
			
		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt(['t'=>'fb_post', 'm'=>5]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';
		
		//-------------------- AUTO TIME CHECK - END --------------------//
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){	
				
			$__SclBd = new CRM_Thrd();
			$_post = Php_Ls_Cln($_GET['_post']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);
			
			if(class_exists('CRM_Cnx')){
				
				$___datprcs = [];
				
				$Ls_Qry = " SELECT *,
								(
									SELECT sclaccpost_fa
									FROM "._BdStr(DBT).TB_SCL_ACC_POST."
									WHERE sclaccpost_sclacc = id_sclacc
									ORDER BY sclaccpost_fa DESC
									LIMIT 1
								) AS ___lst_post_fa,
								
								( sclacc_f_chk_post < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst

							FROM "._BdStr(DBT).TB_SCL_ACC." 
								INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
								INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
							WHERE sclacc_id IS NOT NULL AND 
								id_sclacc IN (SELECT clsclacc_sclacc FROM "._BdStr(DBM).TB_CL_SCL_ACC.") AND 
								sclacc_est = 1 {$__fl} 
							HAVING __rd_lst = 1
							
							GROUP BY id_sclacc DESC
							LIMIT 50
						";	
												
				$LsAccPost = $__cnx->_qry($Ls_Qry);
						
				if($LsAccPost){
					
					$row_LsAccPost = $LsAccPost->fetch_assoc();
					$Tot_LsAccPost = $LsAccPost->num_rows;
					
					echo $this->h1('Facebook - FanPages Accounts - Post '.$Tot_LsAccPost);
					
					if($Tot_LsAccPost > 0){					
						
						do {
							
							try {	
												
								$___datprcs[] = $row_LsAccPost;
								echo $this->li('Lock Before to ID '.$row_LsAccPost['id_sclacc']);

							} catch (Exception $e) {
								
								echo $this->err($e->getMessage());
								
							}

						} while ($row_LsAccPost = $LsAccPost->fetch_assoc()); 
						
						echo $this->ul($___postin);
					}
				
				}

				$__cnx->_clsr($LsAccPost);

				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__diff = _Df_Dte($___datprcs_v['___post_upd'], SIS_F_TS); 
						
						if($___datprcs_v['___lst_post_fa']=='' || ($__diff->Y > 0 || $__diff->m > 0) ){
							
							$_lmt = '100';

						}else{
							if($___datprcs_v['___lst_post_fa'] != ''){
								if($_lmt != ''){ 
									$_lmt = $_lmt; 
								}elseif($__diff->d > 0){
									$_lmt = 20;
								}elseif($__diff->H > 0){
									$_lmt = 10;
								}elseif($__diff->i > 0){
									$_lmt = 5;
								}elseif($__diff->l > 0){
									$_lmt = 2;
								}else{
									$_lmt = 2;
								}
							}else{
								$_lmt = 100;
							}
						}
						
						
						$__RquDt = $__SclBd->RquDt([ 'tp'=>'post', 'acc'=>$___datprcs_v['id_sclacc'] ]);
						
						if(!isN($__RquDt->nxt)){ $_lmt = ''; }

						$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$___datprcs_v['id_sclacc'] ]);
						
						$___updchk = $__SclBd->UpdF(['t'=>'acc', 'f'=>'sclacc_f_chk_post', 'id'=>$___datprcs_v['id_sclacc'], 'v'=>SIS_F_D2 ]);

						if($___tkns->tot > 0){

							foreach($___tkns->ls as $_tkn_k=>$_tkn_v){
								
								//---------- Try Tokens - Start ----------//

									echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in').' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl);

									require(GL_SCL_FB.'fb_post_in.php');

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
		
			$this->Rqu([ 't'=>'fb_post' ]);
			
		}else{
			
			echo $this->h1('Facebook - FanPages Accounts '.$this->Spn('Posts - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'fb_post' ]);
		echo $e->getMessage();
		
	}

	$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_post_cmn.php');
	$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_post_rct.php');

}else{

	echo $this->nallw('Global Social Media - Facebook - Posts - Off');

}

	
?>