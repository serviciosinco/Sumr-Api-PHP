<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'wbhk_mdl_cnt' ]);

if( $_g_alw->est == 'ok' ){

	try{       
	
		if(class_exists('CRM_Cnx')){      
			
			$__Wbhk = new CRM_Webhook();
			
			$Qry = "SELECT * 
					FROM ".DBP.".".TB_WBHK." 
					WHERE 	wbhk_cl = 16 AND 
							wbhk_est = 1 AND 
							wbhk_tp = '"._CId('ID_WBHTP_MDLCNT')."' 
					";		

			$WbhkRg = $__cnx->_qry($Qry);
			
			if($WbhkRg){
				
				$row_WbhkRg = $WbhkRg->fetch_assoc();
				$Tot_WbhkRg = $WbhkRg->num_rows;
				
				echo $this->h1('Proceso Webhooks '.$Tot_WbhkRg);	
				
				if($Tot_WbhkRg > 0){
					
					try {					
						
						do{	
	
							
							$_cldt = GtClDt( $row_WbhkRg['wbhk_cl'], '', ['cnx'=>$__Wbhk->c_r] );
							
							echo $row_WbhkRg['wbhk_nm'].' '.$_cldt->bd;
							
							if(!isN($_cldt->bd)){
							
								//-------------------- LEADS TO SEND --------------------//
								
									/*
									$__fl_cmpg = "
										
										AND id_mdl NOT IN (
											
											(
												SELECT  mdlare_mdl 
												FROM ".$_cldt->bd.".".TB_MDL_ARE." 
													 INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
												WHERE clare_cl = ".$row_WbhkRg['wbhk_cl']." AND clare_cod=7 
											)
											
										)
										
									";*/
									
									
									$SbQry = "	SELECT * 
												
												FROM ".$_cldt->bd.".".TB_MDL_CNT."
													 INNER JOIN ".$_cldt->bd.".".TB_CNT." ON mdlcnt_cnt = id_cnt
													 INNER JOIN ".$_cldt->bd.".".TB_MDL." ON mdlcnt_mdl = id_mdl
												
												WHERE id_mdlcnt NOT IN (	SELECT wbhksnd_id 
																			FROM ".DBP.".".TB_WBHK_SND."
																			WHERE wbhksnd_wbhk = '".$row_WbhkRg['id_wbhk']."' AND wbhksnd_d = 'mdl_cnt'
																		)
																AND DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') >= '".$row_WbhkRg['wbhk_snc']."'		
													  
													  {$__fl_cmpg}
													    						
												ORDER BY id_mdlcnt DESC						
												LIMIT 10"; 
	
															   
									$WbhkSbRg = $__cnx->_qry($SbQry); 
									
									
									//echo $this->h1($SbQry).$__Wbhk->c_r->error;
	
							
									if($WbhkSbRg){
										
										$row_WbhkSbRg = $WbhkSbRg->fetch_assoc();
										$Tot_WbhkSbRg = $WbhkSbRg->num_rows;
										
										do{
	
											
											$__Wbhk->wbhksnd_wbhk = $row_WbhkRg['id_wbhk'];
											$__Wbhk->wbhksnd_id = $row_WbhkSbRg['id_mdlcnt'];
											$__Wbhk->wbhksnd_d = 'mdl_cnt';
											
											$__chk = $__Wbhk->_chk();
											
											
											if($__chk->rd != 'ok'){
												
												
												if(!isN($__chk->enc)){
													$__rd = $__Wbhk->_rd([ 'o'=>'ok' ]);
												}
																
														
												try {
													
													$__dtmdlcnt = GtMdlCntDt([ 	
																			'id'=>$row_WbhkSbRg['id_mdlcnt'], 
																			'bd'=>$_cldt->bd, 
																			'cnx'=>$__Wbhk->c_r,
																			'shw'=>[
																				'are'=>'ok',
																				'msj'=>'ok',
																				'attr'=>'ok',
																				'cnt'=>'ok'
																			]
																		]);
											
													if(!isN($__dtmdlcnt->cnt->id) && !isN($__dtmdlcnt->mdl->are->last->id) && !isN($__dtmdlcnt->attr_o->becall_prity->vl)){
														
														
														//-------------------- OJO ESTO TOCA CAMBIARLO A WEBHOOK CONTROLADO POR SISTEMA , POR AHORA ENVIA LOS DATOS DE COLSUBSIDIO --------------------//
														
														/*
														$__Wbhk->endpoint = $row_WbhkRg['wbhk_url'];
														$_prc = $__Wbhk->_snd();
														*/               
													    
													    $soap_request= '<?xml version="1.0" encoding="utf-8"?>
																		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
																		  <soap:Body>
																		    <AgregarLead xmlns="http://tempuri.org/">
																		    	<idregistro>'.$__dtmdlcnt->enc.'</idregistro>
																				<pnombre>'.$__dtmdlcnt->cnt->nm.'</pnombre>
																				<papellido>'.$__dtmdlcnt->cnt->ap.'</papellido>
																				<pcelular>'.$__dtmdlcnt->cnt->tel_c.'</pcelular>
																				<pemail>'.$__dtmdlcnt->cnt->eml_c.'</pemail>
																				<pidprograma>'.$__dtmdlcnt->mdl->nm.'</pidprograma>
																				<pidcampana>'.$__dtmdlcnt->mdl->are->last->are->cod.'</pidcampana>
																				<pmensaje>'.$__dtmdlcnt->msj->all.'</pmensaje>
																				<pprioridad>'.$__dtmdlcnt->attr_o->becall_prity->vl.'</pprioridad>
																		    </AgregarLead>
																		  </soap:Body>
																		</soap:Envelope>
											
																		';
														 
														$header = [
														    'Content-type: text/xml; charset="utf-8"',
														    'SOAPAction: "http://tempuri.org/AgregarLead"',
														    'Cache-Control: no-cache',
														    'Pragma: no-cache',
														    'Content-length: '.strlen($soap_request),
														];
														 
														 
														$soap_do = curl_init();
														curl_setopt($soap_do, CURLOPT_URL, 			  $row_WbhkRg['wbhk_url']);
														curl_setopt($soap_do, CURLOPT_PORT, 		  $row_WbhkRg['wbhk_port']);
														curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 20);
														curl_setopt($soap_do, CURLOPT_TIMEOUT,        20);
														curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
														curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
														curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
														curl_setopt($soap_do, CURLOPT_POST,           true );
														curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $soap_request);
														curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);
														curl_setopt($soap_do, CURLOPT_HEADER, 		  true);
													 
													
															
														$___do = curl_exec($soap_do); 
														$___r_info = curl_getinfo($soap_do);
														$___r_err  = curl_error($soap_do);
														$___r_errno = curl_errno($soap_do);  
													    $___r_err_msg = curl_strerror($___r_errno);
														$___r_code = curl_getinfo($soap_do, CURLINFO_HTTP_CODE);
														
													
														
														if($___do === false) {
														    
														    echo $this->h2( 'Curl error no: ' . $___r_errno );
														    echo $this->h2( 'Curl error: ' . $___r_err );
														    echo $this->h2( 'Curl Code: ' . $___r_code );
														    
														} else {
															
					
														    echo $__dtmdlcnt->id.' - Success:'.h2($___r_code);
														    
														    $__Wbhk->wbhksnd_soap = mBln($row_WbhkRg['wbhk_soap']);
														    $__Wbhk->wbhksnd_rest = mBln($row_WbhkRg['wbhk_rest']);
														    $__Wbhk->wbhksnd_rqu = $soap_request;
														    $__Wbhk->wbhksnd_err_no = $___r_errno;
														    $__Wbhk->wbhksnd_err_msg = $___r_err;
														    $__Wbhk->wbhksnd_err_str = $___r_err_msg;
														    $__Wbhk->wbhksnd_r = $___do;
														    $__Wbhk->wbhksnd_r_info = $___r_info;
														    $__Wbhk->wbhksnd_r_code = $___r_code;
														    $__Wbhk->wbhksnd_r_hdrs = $__Wbhk->_r_hdrs($___do);
														    $_prc = $__Wbhk->_upd();
														 	
			
														}
														
													
													
														curl_close($soap_do);
															
														
													}
				    
													$__Wbhk->_rd();
												    
												    
												} catch (Exception $e) {
													
													$__Wbhk->_rd();
												    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
												    
												}
											
											}								
											
										}while($row_WbhkSbRg = $WbhkSbRg->fetch_assoc()); 	
									
									}
									
									$__cnx->_clsr($WbhkSbRg);
									
								//-------------------- LEADS TO SEND --------------------//
							
							}
						
						}while($row_WbhkRg = $WbhkRg->fetch_assoc()); 
							
					}catch(Exception $e){
							
						echo $e->getMessage();
						
					}
						
				}	
			
			}
			
			$__cnx->_clsr($WbhkRg);			
							
		}
	
	}catch(Exception $e){
	    
		echo $e->getMessage();
	   
	    exit(1);
	    
	}

}else{

	echo $this->nallw('Global Monitor Webhook - Oportunidades - Off');

}

	
?>