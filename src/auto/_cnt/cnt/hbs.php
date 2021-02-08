<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'cnt_hbs' ]);

if( $_g_alw->est == 'ok' ){
		
	if(class_exists('CRM_Cnx')){

		//------------------- Basic Parameters ---------------------//	

		$__btch_id = Gn_Rnd(20);	
		$__i = $this->g__i;

		//------------------- Start ---------------------//	

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'cnt_hbs', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					$__ec = new API_CRM_ec([ 'cl'=>$_cl_dt->id ]);
					$___datprcs = [];

					//-------- QUERY ---------//
					$Ls_QC = "	SELECT
									cnteml_cnt, cnteml_eml, cnteml_fi, clplcy_ec, id_eclstseml, id_eclsts, eclstsplcy_plcy
								FROM
									"._BdStr(DBM).TB_EC_LSTS."
									INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = id_eclsts
									INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON eclstsplcy_plcy = id_clplcy
									INNER JOIN ".$_cl_v->bd.".".TB_EC_LSTS_EML." ON eclstseml_lsts = id_eclsts
									INNER JOIN ".$_cl_v->bd.".".TB_CNT_EML." ON eclstseml_eml = id_cnteml
									LEFT JOIN ".$_cl_v->bd.".".TB_CNT_PLCY." ON cntplcy_cnt = cnteml_cnt
									LEFT JOIN ".$_cl_v->bd.".".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
									LEFT JOIN ".$_cl_v->bd.".".TB_EC_SND." ON ecsnd_eml = cnteml_eml
								WHERE 
									cnteml_est = '"._CId('ID_SISEMLEST_ACT')."' AND
									eclsts_plcy = 1 AND 
									eclstsplcy_e = 1 AND
									(
										id_cntplcy IS NULL ||
										id_cntemlplcy IS NULL 
									) AND 
									clplcy_ec IS NOT NULL
									AND ecsnd_eml IS NULL
									AND DATE_FORMAT(cnteml_fi, '%Y-%m-%d') > '2020-11-10'
								GROUP BY cnteml_eml
								ORDER BY RAND()
								LIMIT {$_g_alw->lmt}";

					$LsHbs = $__cnx->_qry($Ls_QC);
				
					if($LsHbs){
						
						$row_LsHbs = $LsHbs->fetch_assoc();
						$Tot_LsHbs = $LsHbs->num_rows;
			
						//-------------------- TITULO --------------------//
						
						echo $this->h1('Cliente: '.$_cl_v->nm.' - Numero de emails: '.$Tot_LsHbs);

						if($Tot_LsHbs > 0){	
							do{
								$___datprcs[] = $row_LsHbs;
							} while ($row_LsHbs = $LsHbs->fetch_assoc());
						}
						
					}	

					$__cnx->_clsr($LsHbs);

					if(!isN($___datprcs)){
						
						foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

							$dtime = new DateTime($___datprcs_v['cnteml_fi']);
							$date = $dtime->format('Y-m-d');
							$time = $dtime->format('H:i:s');

							if(!isN($date) && !isN($time)){
								
								$__ec->snd_f = $date;
								$__ec->snd_h = $time;
								$__ec->snd_ec = $___datprcs_v['clplcy_ec'];
								$__ec->snd_eml = $___datprcs_v['cnteml_eml'];
								$__ec->snd_cnt = $___datprcs_v['cnteml_cnt'];
								$__ec->snd_us = 3;
								$__ec->snd_plcy->e = 2;
								$__ec->snd_plcy->id = $___datprcs_v['eclstsplcy_plcy'];
								
								$__snd = $__ec->_SndEc([ 'auto'=>'ok', 'bd' => $_cl_v->bd ]);	

								if(!isN($__snd->i)){
									echo $this->scss('Created on Queue with ID '.$__snd->i);
								}else{
									echo $this->err('Error with queue with email '.$___datprcs_v['cnteml_eml']);
								}
								

							}

						}	
						
					}
				
				}else{

					echo $this->nallw($_cl_v->nm.' Leads - Habeas Data - Off');
			
				}

			}
		}
	}

}else{

	echo $this->nallw('Global Leads - Habeas Data - Off');

}

?>