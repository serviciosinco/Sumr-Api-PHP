<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up_cnt' ]);

if( $_g_alw->est == 'ok' ){
	
	$__prfx_tt = 'CNT - ';

	if(class_exists('CRM_Cnx')){
													
		
		//--------- AUTO TIME CHECK - START ---------//

		$_AUTOP_d = $this->RquDt([ 't'=>'up_cnt', 'm'=>2 ]); 
		
		
		$_AUTOP_d->hb = 'ok';
		
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
			
			
			$this->Rqu([ 't'=>'up_cnt' ]);
				
			$this->_up->tp = 'up_cnt';
		
		
			//-------------------- CHECK IF GET ID SPECIFIC TO WORK --------------------//
											
			if(!isN($this->g__i)){ 
				$__lst_nou = $this->_up->_UpLstNo_U(['id'=>$this->g__i, 't'=>'enc', 'tp'=>'cnt']);
				$__i_udp = $__lst_nou->id;
			}else{
				$__lst_nou = $this->_up->_UpLstNo_U([ 'tp'=>'cnt', 'f'=>' AND up_est != '._CId('ID_UPEST_ELI').' ' ]);
				$__i_udp = $__lst_nou->id; 
			}

			//-------------------- CHECK CUSTOM LIMIT --------------------//


				if(defined('UP_CNT_MAX') && !isN(UP_CNT_MAX)){ 
					$_qry_lmt = UP_CNT_MAX; 
				}elseif(!isN($this->g__lmt)){ 
					$_qry_lmt = $this->g__lmt; 
				}else{ 
					$_qry_lmt = '100'; 
				}
		
		
			//-------------------- IF THERE IS RECORS NOT UPDATE RUN QUERY --------------------//
		
			if($__lst_nou->r_tot > 0 && !isN($__i_udp)){
		
				$LsUpCnt_Qry = "SELECT *
							FROM ".DB_PRC.".".MDL_UP_COL_BD."
									INNER JOIN ".DB_PRC.".".MDL_UP_BD." ON upcol_up = id_up 
							WHERE (	up_est != "._CId('ID_UPEST_ON')." AND 
										up_est != '"._CId('ID_UPEST_ELI')."'
									) AND 
									
									up_fld != '' AND 
									upcol_est != "._CId('ID_UPEST_ON')." AND 
									(up_tp = 'cnt') AND 
									upcol_up = '".$__i_udp."' $__f 
							ORDER BY RAND() LIMIT {$_qry_lmt} ";
										
				$LsUpCnt_Rg = $__cnx->_prc($LsUpCnt_Qry);  //echo $LsUpCnt_Qry;
				
				if($LsUpCnt_Rg){
					
					$row_LsUpCnt_Rg = $LsUpCnt_Rg->fetch_assoc(); 
					$Tot_LsUpCnt_Rg = $LsUpCnt_Rg->num_rows; 
					
					echo $this->h1($__prfx_tt. ' Carga de Archivos CNT '.$this->Spn($Tot_LsUpCnt_Rg). 
									' - cargados '.$row_LsUpCnt_Rg['__tot_up']. 
									' - rows total '.$Tot_LsUpCnt_Rg ); 
												
				}else{
					
					echo $this->err( $__cnx->c_p->error );
					
					
				}
				
				$__cnx->_clsr($LsUpCnt_Rg);
				
				
			}elseif(!isN($__i_udp)){
				
				echo $this->h1($__prfx_tt.$__lst_nou->id.' no tiene registros creados en la tabla ' ); 
										
			}else{			
							
				echo $this->h1($__prfx_tt.' No hay bases para cargar');
							
			}
		
		
		//-------------------- THERE ARE RECORS TO PROCESS --------------------//
		
			
			if($Tot_LsUpCnt_Rg > 0){
				
				
				if(!isN($__lst_nou->id) && $__lst_nou->r_tot > 0 && $__lst_nou->r_tot_up == $__lst_nou->r_tot){ 
				
					$this->_up->_InUp_Est([ 'id'=>$__i_udp, 'e'=>_CId('ID_UPEST_ON') ]); 
					echo 'Actualiza registro '.$__lst_nou->id.' a 1';
					
				}elseif(($__lst_nou->r_tot_up+$__lst_nou->r_tot_w) == $__lst_nou->r_tot){
					
					$this->_up->_InUp_Est([ 'id'=>$__i_udp, 'e'=>_CId('ID_UPEST_ON') ]); 
					echo 'Actualiza registro '.$row_UpEcLsts_Rg['id_up'].' a 1';
					
				}
				
				
				do{
					
					$this->id_upcol = $row_LsUpCnt_Rg['id_upcol'];
					
					/*-------------- CHECK IF RECORD IS ON READ STATE --------------*/ 
							
					$___chk = $this->UpCol_Chk(); if($___chk->rd == 'ok'){ echo $row_LsUpCnt_Rg['id_upcol'].' esta en modo lectura'.$this->br(); }
					
					/*-------------- IF CHECK IS NOT ON READ STATE --------------*/ 
					
					if($___chk->e == 'ok' && $___chk->rd != 'ok'){
					
					
						$__rd_p = $this->_up->_InUpRow_Rd(['id'=>$row_LsUpCnt_Rg['id_upcol'], 'e'=>'on' ]);
						
						
						if($__rd_p->e == 'ok'){	

							$_out = '';
							$_fields = json_decode($row_LsUpCnt_Rg['up_fld'], true); 
							$_chk = new CRM_Cnt_Up([ 'cl'=>$row_LsUpCnt_Rg['up_cl'] ]);
								
							/*-------------- CHECK ALL FIELDS SELECTED TO VERIFY INTEGRITY --------------*/ 
							
							
								foreach ($_fields as $k=>$v){
									
									$v= _jEnc($v);
									$k2 = str_replace('c_', '', $k);
									$_chk->up_tp = $row_LsUpCnt_Rg['up_tp'];
									
									if(!isN($v->id)){
										
										if($v->id == 'cnt_tel' || $v->id == 'cnt_tel_2' || $v->id == 'cnt_tel_3' || $v->id == 'cnt_cel' || $v->id == 'cnt_cel_2'){	
											$_chk->{$v->id} = ['no'=> ctjTx($row_LsUpCnt_Rg['upcol_'.$k2], 'in') ];
										
										}elseif($v->ext->cnt == 'ok' || $v->ext->mdl_cnt == 'ok'){	
											
											if($v->ext->cnt == 'ok'){
												
												$_chk->ext->cnt[$v->id] = ctjTx($row_LsUpCnt_Rg['upcol_'.$k2], 'in');
												
											}elseif($v->ext->mdl_cnt == 'ok'){
												
												$_chk->ext->mdl_cnt[$v->id] = ctjTx($row_LsUpCnt_Rg['upcol_'.$k2], 'in');
												
											}
											
										}else{

											$_chk->{$v->id} = ctjTx($row_LsUpCnt_Rg['upcol_'.$k2], 'in');
										
										}
										
										
										$_chk->id_upcol = $row_LsUpCnt_Rg['id_upcol'];
										$_chk->up_bd = $row_LsUpCnt_Rg['up_bd'];
										$_chk->c = $v->id;
										$_chk->v = strip_tags($row_LsUpCnt_Rg['upcol_'.$k2]);
										
										$_vlgo = $_chk->{$v->id};
										if(isN($_vlgo)){ $_vlgo = $row_LsUpCnt_Rg['upcol_'.$k2]; }
											
										$_out .= $this->li('Row:'.$row_LsUpCnt_Rg['id_upcol'].' / Col:'.$k2.' | '.$v->id.':'.$_vlgo);
									
									}
								}
								
								
								$_chk->Run();
								
								
							/*-------------- IF ALL DATA IS GOOD TO BE UPLOADED --------------*/ 
							
							
								//echo $_chk->hb.' <-> '.$_chk->mdlcnt_enc.' <-> '.$_chk->cnt_dc.' <-> '.$_chk->cnt_eml.' <-> '.$_chk->cnt_eml_2.' <-> '.$_chk->cnt_eml_3;
							
							
								if($_chk->hb != 'no' && (!isN($_chk->mdlcnt_enc) || !isN($_chk->cnt_dc) || !isN($_chk->cnt_eml) || !isN($_chk->cnt_eml_2) || !isN($_chk->cnt_eml_3) )){
										
									$__CntIn = new CRM_Cnt([ 'cl'=>$row_LsUpCnt_Rg['up_cl'] ]);
									
									$__CntIn->up_tp = $_chk->up_tp;
									$__CntIn->up_us = $row_LsUpCnt_Rg['up_us'];
									$__CntIn->gt_cl_id = $row_LsUpCnt_Rg['up_cl'];
									
									$__CntIn->cnt_nm = $_chk->cnt_nm;
									$__CntIn->frce_cnt_nm  = 'ok';
									$__CntIn->cnt_ap = $_chk->cnt_ap;
									$__CntIn->frce_cnt_ap  = 'ok';
									
									$__CntIn->cnt_dc = filter_var($_chk->cnt_dc, FILTER_SANITIZE_STRING);
									$__CntIn->cnt_dc_tp = $_chk->cnt_dctp;
									$__CntIn->cnt_eml = filter_var($_chk->cnt_eml, FILTER_SANITIZE_EMAIL);
									$__CntIn->cnt_eml_2 = filter_var($_chk->cnt_eml_2, FILTER_SANITIZE_EMAIL);
									$__CntIn->cnt_eml_3 = filter_var($_chk->cnt_eml_3, FILTER_SANITIZE_EMAIL);
									$__CntIn->cnt_tp = $_chk->cnt_tp;
									$__CntIn->cnt_tp_2 = $_chk->cnt_tp_2;
									$__CntIn->cnt_tp_3 = $_chk->cnt_tp_3;
									
									$__CntIn->cnt_cd_1 = $_chk->cnt_cd_1;			
									$__CntIn->cnt_cd_tpr_1 = $_chk->cnt_cd_tpr_1;
														
									$__CntIn->cnt_cd_2 = $_chk->cnt_cd_2;			
									$__CntIn->cnt_cd_tpr_2 = $_chk->cnt_cd_tpr_2;					
														
																			
									$__CntIn->cnt_cd_all = $_chk->cnt_cd_all;
															
									
									$__CntIn->cnt_tel = [
															'no'=>$_chk->cnt_tel['no'], 
															'tp'=>$_chk->cnt_tel_tp['tp'],
															'ext'=>$_chk->cnt_tel_ext['ext'],
															'ps'=>$_chk->cnt_tel_ps['ps']
														];
									
									
									$__CntIn->cnt_tel_2 = [
															'no'=>$_chk->cnt_tel_2['no'], 
															'tp'=>$_chk->cnt_tel_2_tp['tp'],
															'ext'=>$_chk->cnt_tel_2_ext['ext'],
															'ps'=>$_chk->cnt_tel_2_ps['ps']
														];					
									
									$__CntIn->cnt_tel_3 = [
															'no'=>$_chk->cnt_tel_3['no'], 
															'tp'=>$_chk->cnt_tel_3_tp['tp'],
															'ext'=>$_chk->cnt_tel_3_ext['ext'],
															'ps'=>$_chk->cnt_tel_3_ps['ps']
														];	
					
									$__CntIn->cnt_uni_egr = $_chk->cnt_uni_egr;
									$__CntIn->cnt_estr = $_chk->cnt_estr;
									$__CntIn->cnt_eps = $_chk->cnt_eps;
									$__CntIn->cnt_emp = $_chk->cnt_em;
									$__CntIn->cnt_prf = $_chk->cnt_prf;
									$__CntIn->cnt_dir = $_chk->cnt_dir;
									$__CntIn->cnt_clg_tx = $_chk->cnt_clg_tx;
									$__CntIn->cnt_sx = $_chk->cnt_sx;
									$__CntIn->up_bd = $_chk->up_bd;
									$__CntIn->cnt_bd = [
											$_chk->cnt_bd,
											$_chk->cnt_bd_2,
											$_chk->cnt_bd_3
										];
										
									$__CntIn->cnt_sndi = $_chk->cnt_sndi;
									$__CntIn->cnt_fn = $_chk->cnt_fn;
									$__CntIn->cnt_fi = $_chk->cnt_fi;
									$__CntIn->cnt_rnvl = $_chk->cnt_rnvl;
									
									$__CntIn->demo = DEMO_CLSS;
									$__CntIn->bugs = BUGS_EST;
									$__CntIn->cnt_tel_getc = 'no';
									$__CntIn->ext_all = $_chk->ext_out;
									
									$__CntIn->snd->eml->adm = 'no';
									$__CntIn->snd->eml->us = 'no';
									
									$__CntIn->plcy_id = $_chk->plcy_id;
									$__CntIn->invk->by = _CId('ID_SISINVK_AUTO');
								
								
									$PrcDt = $__CntIn->_Cnt();
																			
									$PrcDt_u = ['w'=>$PrcDt->w];
									
									if(!isN($PrcDt->i)){
										$_chk->Upd_Rw($PrcDt_u); // Enabled
									}else{
										$_chk->Upd_Rw_W($PrcDt_u);
									}
									
									$_chk->hb_w_all .= $PrcDt->w.' '.$PrcDt->w_all;
									$_chk->hb_u_all .= $PrcDt->u_all;	
										
								}else{
									
									echo $this->h2('No allowed');
									
								}
								
								if(!isN($_chk->hb_w_all)){ $_out .= $this->err('Errores:'.$_chk->hb_w_all); }
								
								$_out .= $this->li($this->Spn('Output:').$this->br().$_chk->hb_u_all);
								
								if($_chk->hb == 'no'){ $_cls = '_no'; $_chk->Upd_Rw_W(); }else{ $_cls = ''; }
								
								//if(($_chk->hb == 'no' || $PrcDt->e == 'no') || (DEMO_CLSS == true)){
									echo $this->h1($row_LsUpCnt_Rg['upcol_up'].'-> Row '.$row_LsUpCnt_Rg['id_upcol'], $_cls). bdiv(array('c'=>$_out, 'cls'=>$_cls)); 
								//}
						
						}
						
					}
					
					$this->_up->_InUpRow_Rd(['id'=>$row_LsUpCnt_Rg['id_upcol']]);		
						
				} while ($row_LsUpCnt_Rg = $LsUpCnt_Rg->fetch_assoc()); $LsUpCnt_Rg->free;
			}				
			
			echo $this->ul($_out);	
		
		
		}else{
			
			echo $this->h1('Upload '.$this->Spn('Leads - Run On Next'), 'Auto_Tme_Prg');
			
		}
						
	}

}else{

	echo $this->nallw('Global Monitor Upload - People CNT - Off');

}

?>	
