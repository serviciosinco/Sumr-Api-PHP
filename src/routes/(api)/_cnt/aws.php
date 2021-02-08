<?php 
	global $__cnx;
	
	$__Cl = new CRM_Cl();
	$__snd = new API_CRM_SndMail();
													
	$__postman = Php_Ls_Cln($_GET['Postman']);
	
	//-------------------- INCLUSIÓN DE ARCHIVOS --------------------/
	
	
		define('GL_AWS', DIR_CNT.'aws/');
		define('GL_AWS_SES', GL_AWS.'ses/');
						
	
	try {
		
			
		//-------------------- INPUT DATA --------------------//
		
			
			
			$j_urw  = _jEnc(_PostRw());
			$j_urwj  = json_encode(_PostRw());
			
			if($__postman == 'ok'){
				$j_msj = $j_urw->Message;
			}else{
				$j_msj = json_decode($j_urw->Message);
			}
			
			$__hdrs = _aws_ses_hdrs([ 'v'=>$j_msj->mail->headers ]);
			$__mail_cl = $__hdrs->{'SUMR-CL'};
			$__mail_flj = $__hdrs->{'SUMR-FLJ'};
						
			
		//-------------------- IDENTIFICA CLIENTE CUENTA --------------------//
		
			if(!isN($__mail_cl)){
				$_cl_dt = GtClDt($__mail_cl, 'enc');
				_StDbCl(['sbd'=>$_cl_dt->sbd, 'enc'=>$_cl_dt->enc, 'mre'=>$_cl_dt ]);
				$__ec = new API_CRM_ec([ 'cl'=>$_cl_dt->id ]);
			}		
		
		//-------------------- IDENTIFICA CLIENTE CUENTA --------------------//
		
				
			if(!isN($j_msj->mail->messageId) && $__mail_flj == 'cl' && !isN($_cl_dt->bd)){
				$__snd_dt = $__Cl->__flj_snd_dt([ 'id'=>$j_msj->mail->messageId, 't'=>'id', 'bd'=>$_cl_dt->bd ]);
			}else{
				$__snd_dt = GtEcSndDt([ 'id'=>$j_msj->mail->messageId, 'tp'=>'id', 'bd'=>$_cl_dt->bd.'.' ]);
			}
		
			//$insertSQL = "INSERT INTO ____RQ (rq, raw, field, field_unb, field_urw, field_post, field_get, field_srv, field_raw) VALUES ('AWS','','','','','','','','".json_encode($j_urw)."')";		   			
			//$Result = $__cnx->_prc($insertSQL);
			
			
		//-------------------- INICIA PROCESAMIENTO --------------------//	
		
				
			if(!isN($__snd_dt->id)){	
				
				if($__p3_o == 'ses'){		
					
					if($__p4_o == 'bounce' && $j_msj->notificationType == 'Bounce'){
						include(GL_AWS_SES."bounce.php");
					}elseif($__p4_o == 'complaint' && $j_msj->notificationType == 'Complaint'){
						include(GL_AWS_SES."complaint.php");
					}elseif($__p4_o == 'delivery' && $j_msj->notificationType == 'Delivery'){ echo GL_AWS_SES."delivery.php";
						include(GL_AWS_SES."delivery.php");
					}
					
				}
				
			}	
			
			
			if($__upd->e == 'ok'){
				$rsp['upd'] = 'ok';
				//http_response_code(200);
			}else{
				$rsp['upd'] = 'no';
				//http_response_code(400);
			}
		
		$__cnx->_clsr($Result);
									
	} catch (Exception $e) {
		  
	    $_w = $e->getMessage(); 
	    $insertSQL = "INSERT INTO ____RQ (rq, raw) VALUES ('AWS','".$_w."')";
		$Result = $__cnx->_prc($insertSQL);
		$__cnx->_clsr($Result);
			
	}
	

	
?>