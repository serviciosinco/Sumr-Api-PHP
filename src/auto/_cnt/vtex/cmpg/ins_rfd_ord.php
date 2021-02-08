<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'vtex_ins_rfd_ord' ]);

if( $_g_alw->est == 'ok' ){
		
	if(class_exists('CRM_Cnx')){

		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=> 'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id ])->est == 'ok' ){
					
					//-------------------- AUTO TIME CHECK - START --------------------//
							
						$_AUTOP_d = $this->RquDt([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 's'=>10 ]);
							
					//-------------------- AUTO TIME CHECK - END --------------------//
					
					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5 || $_AUTOP_d->hb == 'ok'){ 			
						
						try {
							
							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');	
							
							//---------- Lock Account While Check Result On Read Mode ----------//
							
							$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 'lck'=>1 ]);
							
							//---------- Start Query Execution ----------//
							
							$___datprcs = [];
							
							if($___lck->e == 'ok'){	
									
								$VtexCmpgInsRfdOrdQry = "	SELECT id_vtexord, id_vtexcmpgins, id_vtexcmpginsrfd, vtexcmpg_ec_ins_ord, vtexcntpss_cnt, vtexcntpss_eml
                                                            FROM  "._BdStr(DBT).TB_VTEX_ORD."
                                                                  INNER JOIN "._BdStr(DBT).TB_VTEX_COUP." ON vtexord_coup = id_vtexcoup
                                                                  INNER JOIN "._BdStr($_cl_v->bd).TB_VTEX_CMPG_INS_RFD." ON vtexcmpginsrfd_rfd_coup = id_vtexcoup
                                                                  INNER JOIN "._BdStr($_cl_v->bd).TB_VTEX_CMPG_INS." ON vtexcmpginsrfd_ins = id_vtexcmpgins
                                                                  INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
                                                                  INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON vtexcmpgins_cnt = id_cnt
																  INNER JOIN "._BdStr($_cl_v->bd).TB_VTEX_CNT_PSS." ON vtexcntpss_cnt = id_cnt
                                                            WHERE vtexcoup_sumr = 1 AND
                                                                  vtexcmpginsrfd_chk_cmp = 2 AND 
                                                                  vtexord_status = 'invoiced'
                                                            ORDER BY id_vtexord DESC
                                                            LIMIT 50";
												
								//echo $VtexCmpgInsRfdOrdQry; 
								//exit();

								$VtexCmpgInsRfdOrd = $__cnx->_qry($VtexCmpgInsRfdOrdQry, ['cmps'=>'ok'] ); 

								if($VtexCmpgInsRfdOrd){
					
									$rwVtexCmpgInsRfdOrd = $VtexCmpgInsRfdOrd->fetch_assoc(); 
									$TotVtexCmpgInsRfdOrd = $VtexCmpgInsRfdOrd->num_rows;
									
									echo $this->li($TotVtexCmpgInsRfdOrd.' registros');

									if($TotVtexCmpgInsRfdOrd > 0){				
										do{ //---------- Get all Id For Read Mode Markup ----------//
											try {
												$___datprcs[] = $rwVtexCmpgInsRfdOrd;
											} catch (Exception $e) {												
											    $___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());												
											}											
										} while ($rwVtexCmpgInsRfdOrd = $VtexCmpgInsRfdOrd->fetch_assoc()); 	
									}else{	
										$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 'lck'=>2 ]);	
									}
								
								}else{
									
									$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error);
									
								}
                                                          
								$__cnx->_clsr($VtexCmpgInsRfdOrd);

								if(!isN( $___datprcs ) && count($___datprcs) > 0){	

                                    foreach($___datprcs as $___datprcs_k=>$___datprcs_v){		

										echo $this->li( $___datprcs_v['id_vtexcmpginsrfd'].' to process' );
                                        
                                        $__ec = new API_CRM_ec();
                                        $__ec->snd_f = SIS_F;
                                        $__ec->snd_h = SIS_H2;
                                        $__ec->snd_ec = $___datprcs_v['vtexcmpg_ec_ins_ord'];
                                        $__ec->snd_eml = $___datprcs_v['vtexcntpss_eml'];
                                        $__ec->snd_cnt = $___datprcs_v['vtexcntpss_cnt'];
                                        $__ec->sndr_id = $___datprcs_v['id_vtexcmpginsrfd'];
                                        $__ec->sndr_tp = 'vtex_ins_rfd';
                                        $__ec->snd_prty = 1;
                                        $__ec->snd_us = 3;
                                        $__snd = $__ec->_SndEc([ 't'=>'r', 'auto'=>'ok', 'bd'=>$_cl_v->bd ]);
                                        
                                        if($__snd->e == 'ok'){
                                            
                                            $_upd_insrfd = $this->_vtex->InsRfd_Upd([ 
                                                'bd'=>$_cl_v->bd,
                                                'id'=>$___datprcs_v['id_vtexcmpginsrfd'],
                                                'f'=>[
                                                    'vtexcmpginsrfd_chk_cmp'=>1
                                                ]
                                            ]);
                                            
                                            if($_upd_insrfd->e == 'ok'){
                                                echo $this->scss( $___datprcs_v['id_vtexcmpginsrfd'].' saved on vtex success' );
                                            }else{
                                                echo $this->err( $___datprcs_v['id_vtexcmpginsrfd'].' sent but not updated '.$_upd_eml->w );
                                            }

                                        }else{
                                            echo $this->err( 'InsRfdOrd:'.$___datprcs_v['id_vtexcmpgins'].' not mail sended '.$_upd->w ); 
                                        }
                                        

                                    }
								}	
							}
						
						} catch (Exception $e) {
							$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							echo $this->err($e->getMessage());	
						}
						
						$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_ord', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
					
					}else{
						echo $this->nallw(' $_AUTOP_d->e off '.$_cl_v->nm);
					}
				
				}else{
					echo $this->nallw(' Vtex - Campaigns - Inscrito Cupon - Off - '.$_cl_v->nm);
				}
				
			}
			
		}
		
	} 

}else{

	echo $this->nallw('Vtex - Campaigns - Inscrito - Referido - Nueva Compra - Off');

}

?>