<?php 
	
//---------------------- VARIABLES GET ----------------------//
		
	$__inbox_eml = Php_Ls_Cln($_POST['inbox_eml']);
	$__inbox_id = Php_Ls_Cln($_POST['inbox_id']);
	$__inbox_sch = Php_Ls_Cln($_POST['inbox_sch']);
	$__inbox_tkn_nxt = Php_Ls_Cln($_POST['inbox_tkn_nxt']);
	
	
	$__Eml = new CRM_Eml();
	
	$rsp['sch'][TX_MAIL_FROM] = $__Eml->_gtStrBtw($__inbox_sch, TX_MAIL_FROM.':(',')');
	$rsp['sch'][TX_MAIL_TO] = $__Eml->_gtStrBtw($__inbox_sch, TX_MAIL_TO.':(',')');
	$rsp['sch'][TX_MAIL_SBJ] = $__Eml->_gtStrBtw($__inbox_sch, TX_MAIL_SBJ.':(',')');
	$rsp['sch'][TX_MAIL_WRDS] = $__Eml->_gtStrBtw($__inbox_sch, TX_MAIL_WRDS.':(',')');
	
	
	if(!isN($__inbox_id)){ $__chk = $__Eml->EmlBoxDt([ 'enc'=>$__inbox_id ]); }
	if(!isN($__chk->box->id)){ $qry_lbl=$__chk->box->id; }else{ $qry_lbl='INBOX'; }
	
	
	if(!isN($qry_lbl)){ 
		$__flcod = sprintf(' AND id_emlmsg IN ( SELECT emlmsgbox_msg 
												   FROM '._BdStr(DBT).TB_THRD_EML_MSG_BOX.' 
												   WHERE emlmsgbox_box = %s) ', GtSQLVlStr($qry_lbl, 'text')); 
	}
	
	if($__inbox_sch != ''){ $qry_sch = $__inbox_sch; }else{ $qry_sch = ''; }
	if($__inbox_tkn_nxt != ''){ $qry_tkn = $__inbox_tkn_nxt; }else{ $qry_tkn = ''; }
				
//---------------------- SELECCIONA CORREO ----------------------//		

	if($__inbox_eml != ''){ 
		$___emlslc = GtUsEmlDt($__inbox_eml, 'enc'); 
	}else{ 
		$___emlslc = GtUsEmlDt(SISUS_ID, 'lst', ['cl'=>DB_CL_ENC]); 
	}
	
	if(isN($___emlslc)){ exit(); }else{ $__flcod .= sprintf(' AND emlcnv_eml = %s ', GtSQLVlStr($___emlslc->eml->id, 'int')); }



	$__sch = $_POST['sch']; // Valores a Buscar
	$__schcod = Sch_Cd('cd_tt',$__sch, 2); // Codigo Armado y los campos en '' son en los que se realizara la consulta.
	$__totrws = $_POST['totRws'];

	
	$Ls_Pg = 0; 
	if (isset($_POST['pgN'])) {$Ls_Pg = $_POST['pgN'];} $Ls_St = $Ls_Pg * SIS_NMRG;	
	 
	$Ls_Whr = " FROM "._BdStr(DBT).TB_THRD_EML_MSG."
					 INNER JOIN "._BdStr(DBT).TB_THRD_EML_CNV_MSG." ON emlcnvmsg_msg = id_emlmsg 
					 INNER JOIN "._BdStr(DBT).TB_THRD_EML_CNV." ON emlcnvmsg_cnv = id_emlcnv
				WHERE id_emlmsg != '' $__schcod $__flcod";
	
	
	$Ls_Qry = "	SELECT *, 
						(SELECT GROUP_CONCAT(emlmsgbox_box SEPARATOR ',') FROM "._BdStr(DBT).TB_THRD_EML_MSG_BOX." WHERE emlmsgbox_msg = id_emlmsg) AS __lbl,
					  	(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
					  	(SELECT COUNT(*) FROM "._BdStr(DBT).MDL_THRD_EML_MSG_READ_BD." WHERE emlmsgread_emlmsg = id_emlmsg) AS __readtot
					  	
				$Ls_Whr 
				GROUP BY emlcnvmsg_cnv 
				ORDER BY emlmsg_f DESC"; 
						
	$Ls_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $Ls_St, SIS_NMRG);
	$Ls_Rg = $__cnx->_qry($Ls_Lmt); 

	if($Ls_Rg){

		$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
		$Tot_Ls_Rg = $Ls_Rg->num_rows; 

		QuPgsi($_POST['totRws'],$row_Ls_Rg['__rgtot'],SIS_NMRG,$_SERVER['QUERY_STRING']); $Pgs = RcPg($_POST['pgN'],LS_QR,TT_PGS,$__ls);
		
		$rsp['msg']['q'] = $Ls_Lmt;

		$rsp['msg']['tot'] = $Tot_Ls_Rg;
		
		if($Tot_Ls_Rg > 0){
			
			$thrdeml = new CRM_Eml();
			
			$rsp['e'] = 'ok';
			$rsp['msg']['pg']['start'] = $Ls_St;
			$rsp['msg']['pg']['end'] = SIS_NMRG;
			$rsp['msg']['pg']['tot'] = TT_RWS;
			$rsp['msg']['ls'] = [];

			do {
						
				$message_labels = explode(',',$row_Ls_Rg['__lbl']);
				$_var_isstar = $thrdeml->_islbl(['v'=>'STARRED', 'lbl'=>$message_labels]);
				$_var_issent = $thrdeml->_islbl(['v'=>'SENT', 'lbl'=>$message_labels]);
				if($_var_issent!='ok'){ $_var_issent = $thrdeml->_islbl(['v'=>'INBOX.Sent', 'lbl'=>$message_labels]); }
				
				$__attr = $thrdeml->_gt_ls_attr(['tp'=>'msg', 'id'=>$row_Ls_Rg['id_emlmsg']]);
				$__addr = $thrdeml->_gt_ls_addr(['tp'=>'msg', 'id'=>$row_Ls_Rg['id_emlmsg']]);
				
				if($_var_issent == 'ok'){
					$sndr = Spn(TX_MAIL_TO.': ').( !isN($__addr->to[0]->dt->nm)?$__addr->to[0]->dt->nm:$__addr->to[0]->dt->eml );
				}else{
					$sndr = !isN($__addr->from[0]->dt->nm)?$__addr->from[0]->dt->nm:$__addr->from[0]->dt->eml; 
				}
			
				
				if(!isN($__attr->subject)){ 
					$sbj=$__attr->subject; 
				}elseif(!isN($__attr->Subject)){ 
					$sbj=$__attr->Subject; 
				}else{ 
					$sbj=TX_NOSBJ; 
				} 			
				
				$_ls_ob = [
					'enc'=>$row_Ls_Rg['emlcnv_enc'],				
					'star'=>$_var_isstar,
					'sndr'=>$sndr, 
					'sbj'=>$sbj, 
					'read'=>$row_Ls_Rg['__readtot'],
					'f'=>FechaESP_OLD($row_Ls_Rg['emlmsg_f'], 8)
				];
			
				array_push($rsp['msg']['ls'], $_ls_ob);
			
			} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
						
		}else{ 
			
			$rsp['e'] = 'no';
		
		} 

	}else{
		
		$rsp['w'] = $__cnx->c_r->error;

	}

?>