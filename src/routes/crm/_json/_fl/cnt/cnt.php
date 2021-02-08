<?php 
	
	$__mdlstp = Php_Ls_Cln($_POST['t2']);

	$c_DtRg = "-1";
	if(!isN($__q)){ $__sch = $__q; }else{ $__sch = $__i; }
	if (isset($__sch)){$c_DtRg = preg_replace('/\s+/','',$__sch);}
	
	
	if(!isN($__q)){
		
		$___Dt = new CRM_Dt();
		$___Dt->sch->f = 'id_cnt, cnt_nm, cnt_ap';
		$___Dt->gt->sch = $__q;
		$___Dt->_sch([ 't'=>'no' ]);
		
		if(!isN($___Dt->sch->cod)){ $__fl .= ' || '. $___Dt->sch->cod; }
	}
	
	$_fl_dc = ", (SELECT GROUP_CONCAT(cntdc_dc) FROM ".TB_CNT_DC." WHERE cntdc_cnt = id_cnt) as _dc ";
	$_fl_tel = ", (SELECT GROUP_CONCAT(cnttel_tel) FROM ".TB_CNT_TEL." WHERE cnttel_cnt = id_cnt) as _tel ";
	$_fl_eml = ", (SELECT GROUP_CONCAT(cnteml_eml) FROM ".TB_CNT_EML." WHERE cnteml_cnt = id_cnt) as _eml ";
	
	$query_DtRg = sprintf('
							SELECT 	id_cnt, cnt_enc, cnt_nm, cnt_ap
									'.$_fl_dc.' '.$_fl_tel.' '.$_fl_eml.' 
							FROM '.TB_CNT.' 
							WHERE id_cnt IN (SELECT cntdc_cnt FROM '.TB_CNT_DC.' WHERE cntdc_dc = %s) || 
								  id_cnt IN (SELECT cnteml_cnt FROM '.TB_CNT_EML.' WHERE cnteml_eml = %s) ||
								  id_cnt IN (SELECT cnttel_cnt FROM '.TB_CNT_TEL.' WHERE cnttel_tel = %s) 
						  ', 
							GtSQLVlStr($c_DtRg,'text'),
							GtSQLVlStr($c_DtRg,'text'),
							GtSQLVlStr($c_DtRg,'text')
						).$__fl;
						
	$DtRg = $__cnx->_qry($query_DtRg); 

	$rsp['e'] = 'no';
	
	if($DtRg){
	
		$row_DtRg = $DtRg->fetch_assoc(); 
		$Tot_DtRg = $DtRg->num_rows;	
		
		if(filter_var($__i, FILTER_VALIDATE_EMAIL)){ $rsp['t_s'] = 'eml'; }
		
		if($Tot_DtRg > 0){	
			
			$rsp['e'] = 'ok';
			
			if(!isN($__q)){
				
				do {
					
					$rsp['items'][] = [
						'id'=>$row_DtRg['cnt_enc'],
						'text'=>ctjTx($row_DtRg['cnt_nm'],'in').' '.ctjTx($row_DtRg['cnt_ap'],'in')
					];		
					
				} while ($row_DtRg = $DtRg->fetch_assoc());
				
			}else{
				
				$rsp['id'] = $row_DtRg['id_cnt'];
				$rsp['enc'] = ctjTx($row_DtRg['cnt_enc'],'in');
				//$rsp['dc'] = ctjTx($row_DtRg['cnt_dc'],'in');
				//$rsp['dc_nm'] = ctjTx($row_DtRg['sisdoc_nm'],'in');
				$rsp['nm'] = ctjTx($row_DtRg['cnt_nm'],'in');
				$rsp['ap'] = ctjTx($row_DtRg['cnt_ap'],'in');
				$rsp['nm_fll'] = ctjTx($row_DtRg['cnt_nm'].' '.$row_DtRg['cnt_ap'],'in');
				
				//traer documentos, telefonos, email -- Felipe
				$rsp['_dc'] = explode( ",", ctjTx($row_DtRg['_dc'],'in') );
				$rsp['_tel'] = explode( ",", ctjTx($row_DtRg['_tel'],'in') );
				$rsp['_eml'] = explode( ",", ctjTx($row_DtRg['_eml'],'in') );
				
				$_eml = explode(",", $___Ls->dt->rw['_eml']); $i_eml = 1;
				
				foreach($_eml as $_v_eml){
					if(!isN($_v_eml)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_EML."-".$i_eml,'',true).ctjTx($_v_eml, 'in'); ?></li><?php $i_eml++; }
				}	

				if($__mdlstp == 'sac'){
					$__Cnt = new CRM_Cnt();
					$__SchOth = $__Cnt->MdlCnt_Sac([ 'cnt'=>$rsp['id'], 'opn'=>'ok' ]);
					$rsp['oth'] = $__SchOth;
				}

			}
			
		}
	
	}
	
	$Dt_Rg->free; 
?>