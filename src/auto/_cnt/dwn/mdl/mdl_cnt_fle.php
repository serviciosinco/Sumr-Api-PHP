<?php 
	
	//-------------------- Inicia Escritura de Archivo --------------------//
							
							
	$_pth = $this->_aws->_s3_get([ 'b'=>'prvt', 'fle'=>DIR_PRVT_DWN.$__dwn_dt->id.'.xlsx' ]);
	
	echo $this->h3(date("Y-m-d H:i:s").' File '.DIR_PRVT_DWN.$__dwn_dt->id.'.xlsx Exists On Aws?'.print_r($_pth, true));
	
	if( !isN($_pth->uri) ){
		
		echo $this->h3(date("Y-m-d H:i:s").' Yes! Change State');
		
		$_UPD_Dwn = UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'1']);
		
		// Notificaciones
									
		$_CRM_Ntf = new CRM_Ntf();
		
		$_CRM_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_DWNRDY'), 'v1'=>$__dwn_dt->id ];
		$_CRM_Ntf->ntf_tp  = _CId('ID_NTFTP_DWN');
		$_CRM_Ntf->ntf_sub = "mdl_cnt";
		$_CRM_Ntf->cl = $_cl_dt->id;
		$_CRM_Ntf->ntf_id_enc = $__dwn_dt->enc;
		$_CRM_Ntf->ntf_id = $__dwn_dt->id;
		$_CRM_Ntf->ntf_us = $__dwn_dt->us->id;
		
		$_CRM_Ntf->Prc();

		if( $_UPD_Dwn == 1 ){
			
			$__r = 	$this->_ws->Send([
						'srv'=>'notification',
						'act'=>'download_ready',
						'to'=>[$__dwn_dt->us->enc], // Recibe
						'data'=>[    
							'dwn'=>[
								'id'=>$__dwn_dt->enc
							]
						]
					]);
		}
		
	}else{
		
		echo $this->err(date("Y-m-d H:i:s").' No! Send Post to Node Js Worker To Try Again');
		
		print_r( $_pth );

		//UPD_Dwn(['i'=>$__dwn_dt->id, 'b'=>'1' ]);
        
        try{
			
			$updateSQLCol = ('ALTER TABLE '._BdStr(DBD).'_d_'.$__dwn_dt->id.' DROP COLUMN __dwn_e, DROP COLUMN __dwn_i, DROP COLUMN id_dwnprc');
			$QExc = $__cnx->_prc($updateSQLCol);
				
			if($QExc){

				$updateSQLCol_His = ('ALTER TABLE '._BdStr(DBD).'_d_'.$__dwn_dt->id.'_his DROP COLUMN __dwn_i, DROP COLUMN id_dwnprc');
				$QExc_His = $__cnx->_prc($updateSQLCol_His);

				if($QExc_His){
					echo $this->scss('Deleted columns success');
				}

			}else{
				echo $this->err('No delete basic columns '.$__cnx->c_p->error);	
			}	

			$__dwntot = GtDwnTotDt([ 'id'=>$__dwn_dt->id ]);

			if($__dwntot == 0){
				$_UPD_Dwn = UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'8','w'=>'Intenta realizar una consulta mas amplia']);
			}else{
				$_UPD_Dwn = UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'2']);
				$__r = __AutoRUN([ 'twrk'=>'njs', 'msg'=>[ 'invkby'=>'mdl_cnt_fle', 'type'=>'download', 'id'=>$__dwn_dt->id, 'tt'=>$__dwn_dt->tt ] ]);
				echo $this->h3(date("Y-m-d H:i:s").' Result Auto Worker?');
				echo $this->li( print_r($__r, true) );
			}
			
		}catch(Exception $e){
			
			echo $this->ul($e->getMessage(),'','color:red');
			UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'2', 'w'=>'Error:'.$e->getMessage()]);       
			    
		}
        
        UPD_Dwn(['i'=>$__dwn_dt->id, 'b'=>'2' ]);
		
	}
	
?>