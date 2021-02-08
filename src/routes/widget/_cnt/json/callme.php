<?php 

	$_ida = Php_Ls_Cln($_GET['ida']);
	$_phne = Php_Ls_Cln($_GET['phne']);
	$_nm = Php_Ls_Cln($_GET['nm']);

	if(!isN($_ida)){ 
		$_wdgt_act_dt = GtClWdgtActDt([ 'id'=>$_ida, 't'=>'enc' ]);
	}
	
	if(!isN($_wdgt_act_dt->id)){
		
		if($_wdgt_act_dt->chnl->id == _CId('ID_WDGTCHNL_RBTS_CBCK')){

			try{
				
				//---------------- Insert Lead - Before ----------------//	
				
                $__CntIn = new CRM_Cnt([ 'cl'=>$_wdgt_dt->cl->id ]);
                $__CntIn->cnt_nm = $_nm;
                $__CntIn->cnt_tel = str_replace(' ','',$_phne);
				$__cntr = $__CntIn->_Cnt();
				
				//---------------- Get Data Global ----------------//	
				
				//$r['tmpcl'] = $__cntr;
				
				if(!isN( $__cntr->i )){

					$__data['number'] = '57'.$_phne;
					$__data['queue'] = $_wdgt_act_dt->chnl->que;
					
					$CurlRQ = new CRM_Out();
					$CurlRQ->o_crqst = 'GET';
					$CurlRQ->url = 'https://webserv.pbxvirtual.net/api/public/call-me';			
					$CurlRQ->o_header_http = [
												'Content-Type: application/json',
												'account:'.$_wdgt_act_dt->chnl->acc,
												'key:'.$_wdgt_act_dt->chnl->key
											];
					$CurlRQ->o_post_f = json_encode($__data);
					$CurlRQ->o_tmout = 10;
					$CurlRQ->o_ctmout = 10;
					$CurlRQ->out = 'json';

					$r['rsp'] = $rsp = $CurlRQ->_Rq();	

					$insertSQL = " INSERT INTO _cl_wdgt_rq (clwdgtrq_enc, clwdgtrq_rqu, clwdgtrq_rsp) VALUES ('".Enc_Rnd(SIS_F)."', '".json_encode($__data)."', '".json_encode($rsp->rsl)."') ";
					$Result = $__cnx->_prc($insertSQL);

											
					if($rsp->rsl->message == 'Success' && $rsp->rsl->result_code == '1'){
						$r['e'] = 'ok';	
					}

				}

			}catch(Exception $e){    
			
				$r['w'] = $e->getMessage();    
					
			}

		}else if($_wdgt_act_dt->chnl->id == _CId('ID_WDGTCHNL_SMR_CBCK')){

			$r['e'] = 'ok';
			$r['tmp'] = 'Lets write internal call action';

		}
	
	}else{

		$r['w'] = 'No detail';

	}
    
         
?>