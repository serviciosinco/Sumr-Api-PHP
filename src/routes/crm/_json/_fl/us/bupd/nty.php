<?php 

	/*
	$Ls_Qry = "	
				SELECT id_ntf, ntf_enc, ntf_tp, ntf_acc, ntf_htrgr, ntf_dsc, ntf_e 
				FROM "._BdStr(DBM).TB_NTF." 
					 INNER JOIN "._BdStr(DBM).TB_CL." ON ntf_cl = id_cl
				WHERE cl_enc = '".DB_CL_ENC."'	AND 
					  '".SIS_F2."' >= ntf_ftrgr AND 
					  ( '".SIS_H2."' >= ntf_htrgr || '".SIS_F2."' >= ntf_ftrgr )
				AND ntf_e = 2
				AND ntf_us = ".SISUS_ID."
			"; 
	$NtyLs_Rg = $__cnx->_qry($Ls_Qry); 	
	
	if($NtyLs_Rg){
		
		$row_NtyLs_Rg = $NtyLs_Rg->fetch_assoc(); 
		$Tot_NtyLs_Rg = $NtyLs_Rg->num_rows;
		
		if($Tot_NtyLs_Rg > 0){
			
			$rsp['noty_new']['tot'] = $rsp['noty_new']['tot']+$Tot_NtyLs_Rg;
			$rsp['e'] = 'ok';
			
			do {
				
				$__ntf_tp = __LsDt([ 'k'=>'ntf_tp', 'id'=>$row_NtyLs_Rg['ntf_tp'], 'no_lmt'=>'ok' ]);
				$__ntf_acc = __LsDt([ 'k'=>'ntf_acc', 'id'=>$row_NtyLs_Rg['ntf_acc'], 'no_lmt'=>'ok' ]);
				
				$__ff = date_create($row_NtyLs_Rg['ntf_ftrgr'].' '.$row_NtyLs_Rg['ntf_htrgr'] );
				
				if(mBln($__ntf_acc->d->{'go_ls'}->vl)=='ok'){ 
					$__gn_f = FL_LS_GN;	
				}elseif(mBln($__ntf_acc->d->{'go_dt'}->vl)=='ok'){
					$__gn_f = FL_DT_GN;	
				}
					
				$_lnk = $__gn_f.__t($__ntf_acc->d->tp->vl,true).ADM_LNK_NTF.$row_NtyLs_Rg['ntf_enc']; 
				
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['id'] = $row_NtyLs_Rg['id_ntf'];
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['id_obj'] = 'ntf_'.$row_NtyLs_Rg['id_ntf'];
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['f'] = $__ff->format('Y-m-d');
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['h'] = $__ff->format('g:i a');
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['cnt'] = ctjTx($row_NtyLs_Rg['ntf_dsc'],'in');//($__dt_mdlcnt->mdl_cnt->cnt->nm != NULL) ? $__dt_mdlcnt->mdl_cnt->cnt->nm.' '.$__dt_mdlcnt->mdl_cnt->cnt->ap : "Tarea";
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['opn'] = $_lnk;
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tg'] = 'Ntf_'.$row_NtyLs_Rg['id_ntf'];
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tp'] = 'information';
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tp_c'] = $__ntf_tp->d->cls->vl;
				
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['btn_1'] = 'Ver';
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['btn_2'] = TX_CLSE;
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['hg'] = 600;
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['opn_pop'] = "no";
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['enc'] = $row_NtyLs_Rg['ntf_enc'];
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['est'] = $row_NtyLs_Rg['ntf_e'];
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['dsc'] = ctjTx($row_NtyLs_Rg['ntf_dsc'],'in');
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['icn'] = $__ntf_tp->d->img;
				$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['clr'] = $__ntf_tp->d->clr_bck->vl;
				
				
				/*
				if($row_NtyLs_Rg['ntf_tp'] == _CId('ID_NTFTP_TRA')){
					
					$__dt_mdlcnt = GtTraDt([ 'id'=>$row_NtyLs_Rg['ntf_id'] ]);
					//$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['dsc'] = ShortTx($__dt_mdlcnt->tt,80,'Pt');
					$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tt'] = ShortTx($__dt_mdlcnt->dsc,80,'Pt');
					$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tp_c'] = 'tareas';
					$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['arr'] = $__dt_mdlcnt;
					
				}elseif($row_NtyLs_Rg['ntf_tp'] == _CId('ID_NTFTP_EC_CMZ')){
					
					$__dt_ec =  GtEcDt($row_NtyLs_Rg['ntf_id']);
					//$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['dsc'] = ShortTx($__dt_ec->dsc,80,'Pt');
					$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tt'] = ShortTx($__dt_ec->tt,80,'Pt');
					$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['tp_c'] = 'Pushmail';
					$rsp['noty_new']['list'][ 'Nty_'.$row_NtyLs_Rg['id_ntf'] ]['arr'] = $__dt_ec;
				}
				*//*
				
			} while ($row_NtyLs_Rg = $NtyLs_Rg->fetch_assoc());
		
		}
	
	}	
	
	$__cnx->_clsr($NtyLs_Rg);

	*/
 
?>