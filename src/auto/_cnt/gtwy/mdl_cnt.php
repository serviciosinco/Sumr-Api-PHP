<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'gtwy_mdl_cnt' ]);

if( $_g_alw->est == 'ok' ){

				
	try {
						
		echo $this->h1('Verificar Pagos Pendientes '.SIS_H2);
		
		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				$___datprcs = [];

				if( $this->tallw_cl([ 't'=>'key', 'id'=> 'gtwy_mdl_cnt', 'cl'=>$_cl_v->id ])->est == 'ok' ){
					
					//-------------------- AUTO TIME CHECK - START --------------------//
							
						$_AUTOP_d = $this->RquDt([ 't'=>'gtwy_mdl_cnt', 'cl'=>$_cl_v->id, 'm'=>1 ]);
							
					//-------------------- AUTO TIME CHECK - END --------------------//
					
					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){ 

						$this->_gtwy->bd = _BdStr($_cl_v->bd);
						
						$LsMdlCntPay_Qry = "	
											SELECT
												id_mdlcnt, mdlcnt_enc, 
												mdlcntpay_cid, mdlcntpay_status, mdlcntpay_mdlcnt, mdlcntpay_fi, mdlcntpay_sndbx, 
												clgtwypay_enc
											FROM
												".$_cl_v->bd.".".TB_MDL_CNT_PAY_LNK." 
												INNER JOIN ".$_cl_v->bd.".".TB_MDL_CNT_PAY." ON mdlcntpay_lnk = id_mdlcntpaylnk
												INNER JOIN "._BdStr(DBM).TB_CL_GTWY_PAY." ON mdlcntpay_gtwy = id_clgtwypay
												INNER JOIN ".$_cl_v->bd.".".TB_MDL_CNT." ON mdlcntpay_mdlcnt = id_mdlcnt
											WHERE mdlcntpay_est IN ("._Cns('ID_GTWYPAYEST_INPRCS').", "._Cns('ID_GTWYPAYEST_PNDT').")
											GROUP BY id_mdlcntpaylnk
											ORDER BY id_mdlcntpay ASC
											LIMIT 500";
											
						$LsMdlCntPay = $__cnx->_qry($LsMdlCntPay_Qry); 
						
						if($LsMdlCntPay){
							
							$row_LsMdlCntPay = $LsMdlCntPay->fetch_assoc(); 
							$Tot_LsMdlCntPay = $LsMdlCntPay->num_rows;
							
							if($Tot_LsMdlCntPay > 0){
								
								$_tot = 0;
								
								do{
										
									try {	
													
										$___datprcs[] = $row_LsMdlCntPay;
										echo $this->li('Lock Before to ID '.$row_LsMdlCntPay['id_mdlcntpay']);

									} catch (Exception $e) {
										
										echo $this->err($e->getMessage());
										
									}
							
								} while ($row_LsMdlCntPay = $LsMdlCntPay->fetch_assoc()); $LsMdlCntPay->free;
							}
						}
						

						$__cnx->_clsr($LsMdlCntPay);


						if(!isN( $___datprcs ) && count($___datprcs) > 0){

							foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

								//echo $this->li( 'Try check pay '.$___datprcs_v['mdlcntpay_cid'].' '.$___datprcs_v['mdlcnt_enc'] );
								
								$this->_gtwy->mdlcnt_enc = $___datprcs_v['mdlcnt_enc'];
								$this->_gtwy->clgtwypay_enc = $___datprcs_v['clgtwypay_enc'];
								$this->_gtwy->mdlcntpay_mdlcnt = $___datprcs_v['id_mdlcnt'];
								$this->_gtwy->mdlcntpay_sndbx = $___datprcs_v['mdlcntpay_sndbx'];

								$__mpgo_pay_r = $this->_gtwy->mrcpago_pay_dt([ 'id'=>$___datprcs_v['mdlcntpay_cid'], 'sve'=>'ok' ]);
								
								//print_r($__mpgo_pay_r);

								if( !isN($__mpgo_pay_r->save->id) ){
									echo $this->scss('Payment status inserted');
								}
								
							}
						}

						echo $this->li('Desbloqueados '.$_tot.' leads en '.$_cl_v->nm);			

					}
				}
			}
		
		}

		$this->Rqu([ 't'=>'gtwy_mdl_cnt' ]);
		
	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'gtwy_mdl_cnt' ]);
		
		echo 'Error Pagos Pendientes: ',  $e->getMessage(), "\n";
		
	}

}else{

	echo $this->nallw('Global Leads - Oportunidad Lock - Off');

}


?>