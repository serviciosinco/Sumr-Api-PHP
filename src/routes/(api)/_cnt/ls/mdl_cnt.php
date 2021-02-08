<?php 

try{

	$__mdlstp = _GetPost('__modulo_base');
	$__mdls = _GetPost('__modulo_sub');
	$__mdl = _GetPost('__modulo_id');

	$__dstart = _GetPost('__data_start');
	$__dend = _GetPost('__data_end');
	$__limit = _GetPost('__limit');
	$__next = _GetPost('__next');


	if( !isN($__mdlstp) ){ 

		$__fl .= "

			AND
					
			(   CASE WHEN (_his.inout = 'O') 
				THEN _his_c.origin_id = '".$__mdlstp."'  
				ELSE _his.origin_id = '".$__mdlstp."' 
				END
			)

		"; 
	}


	if(!isN($__dstart) && !isN($__dend)){ 
		$__fl .= " AND DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') BETWEEN '".$__dstart."' AND '".$__dend."' "; 
	}elseif(!isN($__dstart)){
		$__fl .= " AND DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') = '".$__dstart."' ";
	}elseif(!isN($__dend)){
		$__fl .= " AND DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') = '".$__dend."' "; 
	}


	if( !isN($__limit) && $__limit < 501){ 
		$__lmt = ' LIMIT '.$__limit;
	}else{
		$__lmt = ' LIMIT 50';
	}

	if( !isN($__next) ){ 
		$__lst_rqu = $api->_RqDt([ 't'=>'enc', 'id'=>$__next ]);
	}

	if(!isN( $__lst_rqu->next->v )){
		$__fl .= " AND id_mdlcnt < '".$__lst_rqu->next->v."' ";
	}

	$qbse = "
		SELECT 
			id_mdlcnt,
			mdlcnt_fi,
			mdlcnt_fa,

			id_mdl,
			mdl_nm,

			id_mdlcnthis,
			mdlcnthis_dsc,
			mdlcnthis_fi,
			mdlcnthis_hi,

			id_siscntest,
			siscntest_tt,

			id_siscntesttp,
			siscntesttp_tt,

			id_mdls,
			mdls_nm,

			id_mdlstp,
			mdlstp_nm,

			cnt_nm,
			cnt_ap,

			id_cnttel,
			cnttel_tel,
			sisps_tt,

			id_cnteml,
			cnteml_eml,
			id_cntdc,
			cntdc_dc,

			id_us,
			us_nm,
			us_ap,
			us_user

		FROM "._BdStr(DB_CL).TB_MDL_CNT."
			 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
			 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
			 INNER JOIN "._BdStr(DB_CL).TB_MDL." ON mdlcnt_mdl = id_mdl
			 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
			 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = mdls_tp
			 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
			 INNER JOIN "._BdStr(DB_CL).TB_CNT." ON mdlcnt_cnt = id_cnt

			 LEFT JOIN "._BdStr(DB_CL).TB_MDL_CNT_HIS." ON mdlcnthis_mdlcnt = id_mdlcnt
			 LEFT JOIN "._BdStr(DBM).TB_US." ON mdlcnthis_us = id_us
			 LEFT JOIN "._BdStr(DB_CL).TB_CNT_EML." ON cnteml_cnt = id_cnt
			 LEFT JOIN "._BdStr(DB_CL).TB_CNT_TEL." ON cnttel_cnt = id_cnt
			 LEFT JOIN "._BdStr(DBM).TB_SIS_PS." ON cnttel_ps = id_sisps
			 LEFT JOIN "._BdStr(DB_CL).TB_CNT_DC." ON cntdc_cnt = id_cnt

		WHERE id_mdlcnt != '' {$__fl}	 
		ORDER BY id_mdlcnt DESC

		{$__lmt}
	"; 
	

	$rsl = $__cnx->_qry($qbse);

	if($rsl){

		$____prc_e = 'ok';

		$rw = $rsl->fetch_assoc(); 
		$tot = $rsl->num_rows;

		
		if($tot > 0){

			do{

				try{

					$id = $rw['id_mdlcnt'];
					$id_tel = $rw['id_cnttel'];
					$id_eml = $rw['id_cnteml'];
					$id_dc = $rw['id_cntdc'];
					$id_his = $rw['id_mdlcnthis'];


					$rsp['list'][$id]['id'] = $rw['id_mdlcnt'];
					$rsp['list'][$id]['name'] = !isN(ctjTx($rw['cnt_nm'],'in')) ? ctjTx($rw['cnt_nm'],'in') : $rw['cnt_nm'];
					$rsp['list'][$id]['surname'] = ctjTx($rw['cnt_ap'],'in');
					$rsp['list'][$id]['date']['inserted'] = ctjTx($rw['mdlcnt_fi'],'in');
					$rsp['list'][$id]['date']['updated'] = ctjTx($rw['mdlcnt_fa'],'in');

					$rsp['list'][$id]['module']['id'] = $rw['id_mdl'];
					$rsp['list'][$id]['module']['name'] = ctjTx($rw['mdl_nm'],'in');
					
					$rsp['list'][$id]['module']['sub']['id'] = $rw['id_mdls'];
					$rsp['list'][$id]['module']['sub']['name'] = ctjTx($rw['mdls_nm'],'in');

					$rsp['list'][$id]['module']['base']['id'] = $rw['id_mdlstp'];
					$rsp['list'][$id]['module']['base']['name'] = ctjTx($rw['mdlstp_nm'],'in');

					
					$rsp['list'][$id]['status']['id'] = $rw['id_siscntest'];
					$rsp['list'][$id]['status']['name'] = ctjTx($rw['siscntest_tt'],'in');
					$rsp['list'][$id]['status']['type']['id'] = ctjTx($rw['id_siscntesttp'],'in');
					$rsp['list'][$id]['status']['type']['name'] = ctjTx($rw['siscntesttp_tt'],'in');


					if(!isN($id_tel)){
						$rsp['list'][$id]['phone'][$id_tel]['id'] = $id_tel;
						$rsp['list'][$id]['phone'][$id_tel]['number'] = $rw['cnttel_tel'];
						$rsp['list'][$id]['phone'][$id_tel]['country'] = ctjTx($rw['sisps_tt'],'in');
					}

					if(!isN($id_eml)){
						$rsp['list'][$id]['email'][$id_eml]['id'] = $id_eml;
						$rsp['list'][$id]['email'][$id_eml]['value'] = $rw['cnteml_eml'];
					}

					if(!isN($id_dc)){
						$rsp['list'][$id]['document'][$id_dc]['id'] = $id_dc;
						$rsp['list'][$id]['document'][$id_dc]['no'] = $rw['cntdc_dc'];
					}

					if(!isN($id_his)){
						$rsp['list'][$id]['history'][$id_his]['id'] = $id_his;
						$rsp['list'][$id]['history'][$id_his]['description'] = ctjTx($rw['mdlcnthis_dsc'],'in');
						$rsp['list'][$id]['history'][$id_his]['date'] = $rw['mdlcnthis_fi'].' '.$rw['mdlcnthis_hi'];

						$rsp['list'][$id]['history'][$id_his]['id_user'] = $rw['id_us'];
						$rsp['list'][$id]['history'][$id_his]['name_user'] = $rw['us_nm'].' '.$rw['us_ap'];
						$rsp['list'][$id]['history'][$id_his]['user'] = $rw['us_user'];

					}

				
				}catch(Exception $e){    
				
					$rsp['w2'][] = $e->getMessage();    
						
				}
			
				$___lst = $rw['id_mdlcnt'];
				
				$rsp['tot']++;

			}while($rw = $rsl->fetch_assoc()); 

		}else{

			$rsp['tot'] = $tot;

		}
		
	}else{

		$rsp['w'] = $__cnx->c_r->error();

	}

	$__next = $api->_Nxt([ 'nxt_v'=>$___lst ]);

	if(!isN($___lst)){
		$rsp['next'] = $__next->enc;
	}

}catch(Exception $e){    
			
	$rsp['w'] = $e->getMessage();    
		
}

?>