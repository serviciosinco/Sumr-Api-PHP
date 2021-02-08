<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_tw_acc_cnv' ]);

if( $_g_alw->est == 'ok' ){


	try {
		
		$_cnv = Php_Ls_Cln($_GET['_cnv']);
		$_lmt = Php_Ls_Cln($_GET['lmt']);
		
		$_lmt_msg = 100;
		
		if(class_exists('CRM_Cnx')){
			
			if(!isN($_cnv)){
				$_cnvdt = GtSclAccCnvDt(['enc'=>$_cnv]);
				$__fl .= sprintf(' AND id_sclacc = %s', GtSQLVlStr($_cnvdt->acc->id, 'int')) ;
				$_lmt_msg = 2;	
				$_cnv_sch = $_cnvdt->cnv_id;
			}

			$Ls_Qry = " SELECT *,
								(	SELECT sclacccnv_upd 
									FROM "._BdStr(DBT).TB_SCL_ACC_CNV." 
									WHERE sclacccnv_sclacc = id_sclacc ORDER BY sclacccnv_upd DESC LIMIT 1
								) AS ___cnv_upd,
									
								(
									SELECT sclacccnvmsg_id
									FROM "._BdStr(DBT).TB_SCL_ACC_CNV_MSG."
										INNER JOIN "._BdStr(DBT).TB_SCL_ACC_CNV." ON sclacccnvmsg_sclacccnv = id_sclacccnv
									WHERE sclacccnv_sclacc = id_sclacc
									ORDER BY sclacccnvmsg_id DESC
									LIMIT 1
								) AS ___last
								
						FROM "._BdStr(DBT).TB_SCL_ACC." 
							INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
							INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
						WHERE sclacc_id IS NOT NULL AND sclacc_est = 1 AND scl_rds = ".GtSQLVlStr(345, 'int')." {$__fl} ";	
											
			$LsAccTw = $__cnx->_qry($Ls_Qry);

					
			if($LsAccTw){
				
				$row_LsAccTw = $LsAccTw->fetch_assoc(); 
				$Tot_LsAccTw = $LsAccTw->num_rows; 
				echo $this->h1('Twitter - Accounts - Messages '.$Tot_LsAccTw);
				
				if($Tot_LsAccTw > 0){					
					
					do {
						
						
						
						$__diff = _Df_Dte($row_LsAccTw['___cnv_upd'], SIS_F_TS); 
						
						if($row_LsAccTw['___cnv_upd']=='' || ($__diff->Y > 0 || $__diff->m > 0) ){
							$_lmt_msg = 50;
						}else{
							if($row_LsAccTw['___cnv_upd'] != ''){
								
								if($_lmt != ''){ 
									$_lmt_msg = $_lmt; 
								}elseif($__diff->d > 0){
									$_lmt_msg = 20;
								}elseif($__diff->H > 0){
									$_lmt_msg = 10;
								}elseif($__diff->i > 0){
									$_lmt_msg = 5;
								}elseif($__diff->l > 0){
									$_lmt_msg = 2;
								}else{
									$_lmt_msg = 2;
								}
							}
						}
						
						
						$__scl_dt = GtSclDt(['enc'=>$row_LsAccTw['scl_enc']]); 					
						$__scl_bd = new CRM_Thrd();
						$__rqu_r_dt = $__scl_bd->RquDt(['tp'=>'cnv_r', 'acc'=>$row_LsAccTw['id_sclacc'] ]);
						$__rqu_s_dt = $__scl_bd->RquDt(['tp'=>'cnv_s', 'acc'=>$row_LsAccTw['id_sclacc'] ]);
						
						if(!isN($__rqu_r_dt->nxt)){ $_lmt_r_msg = ''; }else{ $_lmt_r_msg = $_lmt_msg; }
						if(!isN($__rqu_s_dt->nxt)){ $_lmt_s_msg = ''; }else{ $_lmt_s_msg = $_lmt_msg; }
						
						$__id_acc = $row_LsAccTw['id_sclacc'];
						
						$__Tw = new CRM_Twitter(['conn_tkn'=>$__scl_dt->attr->oauth_token, 'conn_tkns'=>$__scl_dt->attr->oauth_token_secret]);
						
						echo $this->h2($__scl_dt->attr->oauth_token);
						echo $this->h3($__scl_dt->attr->oauth_token_secret);
						
						//-------------------- CONSULTA DIRECTA A TWITTER --------------------//
							
							if($__rqu_r_dt->all=='ok'){ 
								$__r_snc = $row_LsAccTw['___last']; 
								$__r_max = '';
							}else{ 
								$__r_max = $__rqu_r_dt->nxt;
								$__r_snc = ''; 
							}
							
							
							if($__rqu_s_dt->all=='ok'){ 
								$__s_snc = $row_LsAccTw['___last']; 
								$__s_max = '';
							}else{ 
								$__s_max = $__rqu_s_dt->nxt;
								$__s_snc = ''; 
							}
							
							
							$__cnv_r = $__Tw->_Msg(['snc'=>$__r_snc, 'max'=>$__r_max, 'lmt'=>$_lmt_r_msg ]); print_r($__cnv_r);				
							$__cnv_s = $__Tw->_Msg(['t'=>'snt', 'snc'=>$__s_snc, 'max'=>$__s_max, 'lmt'=>$_lmt_s_msg ]);
							
							
							print_r($__cnv_r);
							exit();
							
							
						//-------------------- CONSULTA DIRECTA A TWITTER --------------------//
						
						if(count($__cnv_r) > 0){	
							
							$__c_cnv_r = 1;
							
							foreach($__cnv_r as $cnv_k=>$cnv_v){
								
								if(count($__cnv_r) == $__c_cnv_r){	
									if(!isN($__rqu_r_dt->nxt)&&(count($__cnv_r)==1)){ $all_old = 'ok'; }else{ $all_old = ''; }
									
									$__scl_bd->Rqu([
										'tp'=>'cnv_r',
										'acc'=>$row_LsAccTw['id_sclacc'],
										'nxt'=>$cnv_v->id,
										'all'=>$all_old
									]);
								}
									
								$__scl_bd = new CRM_Thrd();
								$__scl_bd->__t = 'acc_msg';			
								$__scl_bd->cnv_from = $cnv_v->sender->id;	
								$__scl_bd->scl_rds = $row_LsAccTw['scl_rds'];
								$__scl_bd->cnv_acc = $row_LsAccTw['id_sclacc'];
								$__scl_bd->cnv_acc_id = $row_LsAccTw['sclacc_id'];
								$__scl_bd->cnv_id = $cnv_v->sender->id.'_'.$cnv_v->recipient->id;
								$__scl_bd->cnv_snpt = $cnv_v->text;
								$__scl_bd->cnv_upd = $cnv_v->created_at;	
								$__scl_bd->msg_created = $cnv_v->created_at;
								$__scl_bd->msg_from_o = json_encode($cnv_v->sender);
								$__scl_bd->msg_from = $cnv_v->sender->id;
								$__scl_bd->msg_id = $cnv_v->id;
								$__scl_bd->msg_message = $cnv_v->text;
								$__Prc = $__scl_bd->In();
								
								if($__Prc->e != 'ok'){ $_sty = ' color:red;'; }else{ $_sty = ' color:green;'; }
								
								$___tw_cnv_li[$__id_acc] .= $this->li(
											$this->Spn('(R)').print_r($cnv_v, true).'<br>'.
												'Last Message:'.$row_LsAccTw['___last'].'<br>'.
												'Last Update:'.$row_LsAccTw['___cnv_upd'].'<br>'.
												'Diff:'.print_r($__diff, true).'<br>'.
												'Prc:'.print_r($__Prc, true), '', ' font-family:Arial; font-size:10px; '.$_sty );
											
								$__c_cnv_r++;			
							}	
						}

						
						if(count($__cnv_s) > 0){
							
							$__c_cnv_s = 1;
							
							foreach($__cnv_s as $cnv_k=>$cnv_v){
								
								if(count($__cnv_s) == $__c_cnv_s){
									if(!isN($__rqu_s_dt->nxt)&&(count($__cnv_s)==1)){ $all_old = 'ok'; }else{ $all_old = ''; }
									$__scl_bd->Rqu([
										'tp'=>'cnv_s',
										'acc'=>$row_LsAccTw['id_sclacc'],
										'nxt'=>$cnv_v->id,
										'all'=>$all_old	
									]);
								}
									
								$__scl_bd = new CRM_Thrd();
								$__scl_bd->__t = 'acc_msg';			
								$__scl_bd->cnv_from = $cnv_v->recipient->id;	
								$__scl_bd->scl_rds = $row_LsAccTw['scl_rds'];
								$__scl_bd->cnv_acc = $row_LsAccTw['id_sclacc'];
								$__scl_bd->cnv_acc_id = $row_LsAccTw['sclacc_id'];
								$__scl_bd->cnv_id = $cnv_v->recipient->id.'_'.$cnv_v->sender->id;
								$__scl_bd->cnv_snpt = $cnv_v->text;
								$__scl_bd->cnv_upd = $cnv_v->created_at;	
								$__scl_bd->msg_created = $cnv_v->created_at;
								$__scl_bd->msg_from_o = json_encode($cnv_v->sender);
								$__scl_bd->msg_from = $cnv_v->sender->id;
								$__scl_bd->msg_id = $cnv_v->id;
								$__scl_bd->msg_message = $cnv_v->text;
								$__Prc = $__scl_bd->In();
								
								if($__Prc->e != 'ok'){ $_sty = ' color:red;'; }else{ $_sty = ' color:green;'; }
								
								$___tw_cnv_li[$__id_acc] .= $this->li($this->Spn('(S)').'Last Update:'.$row_LsAccTw['___cnv_upd'].' -> Diff:'.print_r($__diff, true).' -> Prc:'.print_r($__Prc, true), '', ' font-family:Arial; font-size:10px; '.$_sty );
											
								$__c_cnv_s++;	
								
							}
						}
						
						$___tw_accin .= $this->li( 
										$this->h1(
											$this->ul(
												$this->li('Account:'.$__id_acc). 
												$this->li('-> Id:'. $row_LsAccTw['sclacc_id']).
												$this->li('-> Conversations:'. $__totcnv).
												$this->li('-> Limit Messages:'.$_lmt_msg).
												$this->li('-> Messages:'.ul($___tw_cnv_li[$__id_acc]))
											)
										) 
									);	
							
					} while ($row_LsAccTw = $LsAccTw->fetch_assoc()); 
					
					//echo $this->ul($___tw_accin);
				}
			
			}
			
			
			
			$__cnx->_clsr($Ls_Qry);

		}

	} catch (Exception $e) {
		
		echo $e->getMessage();
		
	}

}else{

	echo $this->nallw('Global Social Media - Twitter - Get Conversations - Off');

}
	
?>