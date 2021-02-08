<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_from' ]);

if( $_g_alw->est == 'ok' ){
	
	try {
		
			$__force = Php_Ls_Cln($_GET['_force']);
		
		//-------------------- AUTO TIME CHECK - START --------------------//
			
			$_AUTOP_d = $this->RquDt([ 't'=>'fb_from', 'm'=>2 ]);
			//$_AUTOP_d->hb = 'ok';

		//-------------------- AUTO TIME CHECK - END --------------------//

		if($_AUTOP_d->hb == 'ok' || $__force == 'ok'){	
				
			if(class_exists('CRM_Cnx')){
				
				$___datprcs = [];
				
				$__SclBd = new CRM_Thrd();
				
				$Ls_Qry = " SELECT id_sclfrom, sclfrom_id, sclfrom_enc,

									( sclfrom_f_chk < NOW() - INTERVAL 15 MINUTE ) AS __rd_lst,

									(	SELECT sclacccnv_enc 
										FROM "._BdStr(DBT).TB_SCL_ACC_CNV."
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclacccnv_sclacc = id_sclacc 
										WHERE sclacccnv_from = id_sclfrom LIMIT 1) AS __cnv,
										
									(	SELECT sclacccnvmsg_enc 
										FROM "._BdStr(DBT).TB_SCL_ACC_CNV_MSG."
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_CNV." ON sclacccnvmsg_sclacccnv = id_sclacccnv
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclacccnv_sclacc = id_sclacc 
										WHERE sclacccnvmsg_from = id_sclfrom LIMIT 1
									) AS __msg
									
							FROM "._BdStr(DBT).TB_SCL_FROM."
							WHERE sclfrom_pic IS NULL AND sclfrom_rds = ".GtSQLVlStr(_Cns('ID_APITHRD_FB'), 'int')."
							HAVING __rd_lst = 1 || sclfrom_f_chk IS NULL
							ORDER BY RAND() /*id_sclfrom DESC*/
							LIMIT 50";	
							
									
				$LsFbFrom = $__cnx->_qry($Ls_Qry); 
				
				
				if($LsFbFrom){
					
					$rwLsFbFrom = $LsFbFrom->fetch_assoc(); 
					$Tot_LsFbFrom = $LsFbFrom->num_rows; 
					
					echo $this->h1('Facebook - Users Platform - Data '.$Tot_LsFbFrom);
					
					if($Tot_LsFbFrom > 0){
		
						do { 
							
							try {	
												
								$___datprcs[] = $rwLsFbFrom;
								echo $this->li('Lock Before to ID '.$rwLsFbFrom['id_sclfrom']);

							} catch (Exception $e) {
								
								echo $this->err($e->getMessage());
								
							}

						} while ($rwLsFbFrom = $LsFbFrom->fetch_assoc()); 

					}

					$__cnx->_clsr($LsFbFrom);

					if(!isN( $___datprcs ) && count($___datprcs) > 0){

						foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

							$___updchk = $__SclBd->UpdF(['t'=>'from', 'f'=>'sclfrom_f_chk', 'id'=>$___datprcs_v['id_sclfrom'], 'v'=>SIS_F_D2 ]);
							
							if($___datprcs_v['__cnv'] != ''){
								$__cnvdt = GtSclAccCnvDt(['enc'=>$___datprcs_v['__cnv']]);
								$__tp = 'CNV';
								$__tp_id = $___datprcs_v['__cnv'];
								$__tkn = $__cnvdt->acc_scl;
							}elseif($___datprcs_v['__msg'] != ''){
								$__cnvdt = GtSclAccCnvMsgDt(['enc'=>$___datprcs_v['__msg']]);
								$__tp = 'MSG';
								$__tp_id = $___datprcs_v['__msg']; 
								$__tkn = $__cnvdt->cnv->acc_scl;
							}
							
							$__id_us = $___datprcs_v['id_sclfrom'];
							
							foreach($__tkn as $ka=>$va){
								$__us = _NwFb_Us_Dt(['id'=>$___datprcs_v['sclfrom_id'],'access_token'=>$va->tlvd ]);
								if(isN($__us->w)){ break; }
							}	
							
							if(!isN($__id_us) && !isN($__us->picture->url)){
									
								try {
		
									//-------------------- SAVE IMAGE LOCALLY --------------------//
										
										$ch = curl_init ($__us->picture->url);
										curl_setopt($ch, CURLOPT_HEADER, 0);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
										curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
										$raw=curl_exec($ch);
										$myme=curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
										
										curl_close ($ch);
										
										$___nw_nme = 'scl_'.$___datprcs_v['sclfrom_enc'].'.jpg';
										
										$_sve = $this->_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_SCL_FROM.$___nw_nme), 'cbdy'=>$raw, 'ctp'=>$myme ]);
										
										if($_sve->e == 'ok'){
											
											$___res = $__SclBd->UpdF([	
																't'=>'us', 
																'f'=>'sclfrom_pic', 
																'id'=>$___datprcs_v['id_sclfrom'], 
																'v'=>$___nw_nme
															]);
																
											$___usupd .= $this->li( /*print_r($__us, true).'->'.*/ $___datprcs_v['sclfrom_id'].' - '. 
																	$this->h1($__tp_id.' - '.$__tp.
																	' - User:'.$__id_us. 
																	'-> FanPage:'. $__cnvdt->acc->id) /*. 
																	' Api Rsl:'. print_r($__us, true). 
																	'Res:'.print_r($___res, true) */ 
																	);
											
											echo $this->scss('Image saved on S3:'.DIR_FLE_SCL_FROM.$___nw_nme);						

										}else{
										
											echo $this->err($__us->picture->url.' not saved '.DIR_FLE_SCL_FROM);  
											
										}
									
									//--------------------  SAVE IMAGE LOCALLY --------------------//
								
								
								} catch (Exception $e) {
			
									echo $e->getMessage();
									
								}
		
		
							}else{

								echo $this->err('$__id_us:'.$__id_us.' - $__us->picture->url:'.$__us->picture->url);  

							}
								
						}

					}		
				
				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
				
			}	
			
			$this->Rqu([ 't'=>'fb_from' ]);

		}else{
			
			echo $this->h1('Facebook - Users Platform '.$this->Spn('Data - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
		

	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'fb_from' ]);
		echo $e->getMessage();
		
	}

}else{

	echo $this->nallw('Global Social Media - Facebook - From - Off');

}	
	
?>