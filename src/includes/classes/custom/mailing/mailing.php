<?php

class CRM_Eml extends CRM_Thrd{

	function __construct() {
		parent::__construct();
    }

	function __destruct() {
		parent::__destruct();
   	}


	public function _box_lbl_tree($p=NULL){

		$r['e']='no';

		if(substr_count($p['v'], '.')){
			if(substr_count($p['v'], 'INBOX')){
				$_vle = explode('.',$p['v']);
				$r['main']=$_vle[0];
				$r['nm']=$_vle[1];
				$r['e']='ok';
			}
		}

		$rtrn = _jEnc($r);
		return($rtrn);
	}

	public function _box_lbl($p=NULL){

		$__tree = $this->_box_lbl_tree(['v'=>$p['id']]);
		$r['tree'] = $__tree;

		if($__tree->e=='ok'){

			$__nm_nw = strtoupper($__tree->nm);

			/*
			switch (strtoupper($__tree->nm)) {
			    case 'NOTES':
			    case 'SPAM':
			    case 'DRAFT':
			    case 'DRAFTS':
			        $r['sub']='ok'; break;
			}
			*/

		}else{
			$r['sub']='no';
		}

		$__nm_g = strtoupper($p['id']);

		switch (true) {
		    case ($__nm_g == 'INBOX' || $__nm_nw == 'INBOX' ):
		        $r['ord'] = 1; $r['cls'] = 'inbx'; break;
		    case ($__nm_g == 'DRAFT' || $__nm_nw == 'DRAFT' ):
		    case ($__nm_g == 'DRAFTS' || $__nm_nw == 'DRAFTS' ):
		        $r['ord'] = 2; $r['cls'] = 'dfrt'; break;
		    case ($__nm_g == 'SENT' || $__nm_nw == 'SENT' ):
		        $r['ord'] = 3; $r['cls'] = 'snt'; break;
		    case ($__nm_g == 'STARRED' || $__nm_nw == 'STARRED'):
		        $r['ord'] = 4; $r['cls'] = 'strrd'; break;
		    case ($__nm_g == 'CHAT' || $__nm_nw == 'CHAT'):
		        $r['ord'] = 900; $r['cls'] = 'cht'; break;
            case ($__nm_g == 'TRASH' || $__nm_nw == 'TRASH'):
                $r['ord'] = 901; $r['cls'] = 'trsh'; break;
            case ($__nm_g == 'SPAM' || $__nm_nw == 'SPAM'):
            	$r['ord'] = 902; $r['cls'] = 'spam'; break;
            case ($__nm_g == 'JUNK' || $__nm_nw == 'JUNK'):
                $r['ord'] = 903; $r['cls'] = 'spam'; break;
            case ($__nm_g == 'NOTES' || $__nm_nw == 'NOTES'):
                $r['ord'] = 904; $r['cls'] = 'notes'; break;
            case ($__nm_g == 'CATEGORY_SOCIAL' || $__nm_nw == 'CATEGORY_SOCIAL'):
                $r['ord'] = 905; $r['cls'] = 'c_scl'; break;
            case ($__nm_g == 'CATEGORY_UPDATES' || $__nm_nw == 'CATEGORY_UPDATES'):
                $r['ord'] = 906; $r['cls'] = 'c_upd'; break;
            case ($__nm_g == 'CATEGORY_FORUMS' || $__nm_nw == 'CATEGORY_FORUMS'):
                $r['ord'] = 907; $r['cls'] = 'c_frm'; break;
            case ($__nm_g == 'CATEGORY_PROMOTIONS' || $__nm_nw == 'CATEGORY_PROMOTIONS'):
                $r['ord'] = 908; $r['cls'] = 'c_prm'; break;
		    default:
		    	$r['ord'] = NULL; $r['cls'] = 'fldr'; break;
		}

		//if($__tree->e=='ok'){ $r['ord'] = NULL; }

		if(!isN($__nm_nw)){
			$r['nm'] = (defined('GA_'.strtoupper($__nm_nw))?_Cns('GA_'.strtoupper($__nm_nw)):ucfirst( strtolower($__nm_nw) ) );
		}else{
			$r['nm'] = (defined('GA_'.strtoupper($p['id']))?_Cns('GA_'.strtoupper($p['id'])):ucfirst( strtolower($p['id']) ) );
		}

		$rtrn = _jEnc($r);
		return($rtrn);
	}


	public function _box_e($p=NULL){

		global $__cnx;

		$__ebox = 2;

		if(!isN($p['id'])){
			$__idbox = $p['id']; $__sql_t = 'int';
			if(!isN($p['e'])&&$p['e']=='on'){ $__ebox = 1; }
		}else{
			$__idbox = ' IS NOT NULL'; $__sql_t = 'text';
		}

		$query_DtRg = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_BOX." SET emlbox_est=%s WHERE id_emlbox=%s ",
					GtSQLVlStr($__ebox, 'int'),
                   	GtSQLVlStr($__idbox, $__sql_t));

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);
	}


	public function _eml($p=NULL) {

		global $__cnx;

		$r['e'] = 'no';

		try {

			if(!isN($p) && !isN($p['us']) ){

				if(!isN($p['us'])){ $__f .= sprintf(' AND id_eml IN (SELECT useml_eml FROM '._BdStr(DBM).TB_US_EML.' WHERE useml_us=%s  ) ', GtSQLVlStr($p['us'], 'int')); }
				if(!isN($p['cl'])){ $__f .= sprintf(' AND id_eml IN (SELECT useml_eml FROM '._BdStr(DBM).TB_US_EML.' INNER JOIN '._BdStr(DBM).TB_CL.' ON useml_cl = id_cl WHERE cl_enc=%s  ) ', GtSQLVlStr($p['cl'], 'text')); }


				$query_DtRg = '	SELECT *,
									   '._QrySisSlcF(['als'=>'t', 'als_n'=>'tipo']).',
									   '._QrySisSlcF(['als'=>'a', 'als_n'=>'avatar']).',
									   '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t']).',
									   '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'avatar', 'als'=>'a']).'
								FROM '._BdStr(DBT).TB_THRD_EML.'
									 LEFT JOIN '._BdStr(DBT).TB_THRD_EML_BOX.' ON emlbox_eml = id_eml
									 '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'eml_tp', 'als'=>'t']).'
									 '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'eml_avtr', 'als'=>'a']).'

								WHERE id_eml != "" '.$__f.'
								ORDER BY eml_dfl ASC, eml_fi DESC';

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$r['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$r['e'] = 'ok';

						do {

							$__enc = $row_DtRg['eml_enc'];

							if($row_DtRg['avatar_sisslc_img'] != ''){
								$__avtr_img = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['avatar_sisslc_img'],'in');
							}else{
								$__avtr_img = '';
							}

							if(mBln($row_DtRg['eml_dfl']) == 'ok'){
							    $r['dfl'] = $__enc;
						    }

						    if(!isN($row_DtRg['___tipo'])){
							    $__tipo_attr = json_decode($row_DtRg['___tipo']);

							    if(!isN($__tipo_attr) && is_array($__tipo_attr)){
								    foreach($__tipo_attr as $_attr_k=>$_attr_v){
									    $__toa_attr[ $_attr_v->key ] = $_attr_v;
								    }
								}

						    }else{
							    $__toa_attr = NULL;
						    }

						    $_ob = [
								'id'=>$row_DtRg['id_eml'],
							    'enc'=>$__enc,
							    'nm'=>ctjTx($row_DtRg['eml_nm'],'in'),
							    'eml'=>ctjTx($row_DtRg['eml_eml'],'in'),
							    'in'=>[
								   'srv'=>ctjTx($row_DtRg['eml_srv_in'],'in'),
								   'prt'=>ctjTx($row_DtRg['eml_prt_in'],'in'),
							    ],
							    'out'=>[
									'srv'=>ctjTx($row_DtRg['eml_srv_out'],'in'),
									'prt'=>ctjTx($row_DtRg['eml_prt_out'],'in'),
							    ],
							    'usr'=>ctjTx($row_DtRg['eml_usr'],'in'),
							    'ssl'=>mBln($row_DtRg['eml_ssl']),
							    'avtr'=>$__avtr_img,
							    'tp'=>[
							    	'attr'=>$__toa_attr,
							    	'id'=>$row_DtRg['tipo_id_sisslc'],
							    	'nm'=>$row_DtRg['tipo_sisslc_tt']
							    ],
							    'dfl'=>mBln($row_DtRg['eml_dfl']),
							    'onl'=>mBln($row_DtRg['eml_onl']),
							    'fi'=>$row_DtRg['eml_fi'],
								'rd'=>[
									'e'=>mBln($row_DtRg['eml_rd']),
									'f'=>$row_DtRg['eml_rd_f']
								],
						    ];

						    $r['ls'][$__enc] = $_ob;

						    if($__enc != $__id_now){
						    	$r['a'][] = $_ob;
						    }

						    $__id_now = $__enc;

						} while ($row_DtRg = $DtRg->fetch_assoc());


						ksort($r['ls']);
					}
				}

				$__cnx->_clsr($DtRg);
			}

		} catch (Excetion $e) {
			if(!isN($DtRg)){
				$__cnx->_clsr($DtRg);
			}
			$r['w'] = $e->getMessage();
		}
	  	$rtrn = _jEnc($r);
		return($rtrn);
	}



	public function _box($p=NULL) {

		global $__cnx;

		$r['e'] = 'no';

		try {

			if(!isN($p) && (!isN($p['id']) || !isN($p['eml']) || !isN($p['enc']) || !isN($p['us']))){

				if(!isN($p['id'])){ $__f .= sprintf(' AND id_emlbox=%s ', GtSQLVlStr($p['id'], 'int')); }
				if(!isN($p['enc'])){ $__f .= sprintf(' AND eml_enc=%s ', GtSQLVlStr($p['enc'], 'int')); }
				if(!isN($p['eml'])){ $__f .= sprintf(' AND emlbox_eml=%s ', GtSQLVlStr($p['eml'], 'int')); }
				if(!isN($p['box_id'])){ $__f .= sprintf(' AND emlbox_id=%s ', GtSQLVlStr($p['box_id'], 'text')); }
				if(!isN($p['us'])){ $__f .= sprintf(' AND id_eml IN (SELECT useml_eml FROM '._BdStr(DBM).TB_US_EML.' WHERE useml_us=%s  ) ', GtSQLVlStr($p['us'], 'int')); }
				if(!isN($p['cl'])){ $__f .= sprintf(' AND id_eml IN (SELECT useml_cl FROM '._BdStr(DBM).TB_US_EML.' WHERE useml_cl=%s  ) ', GtSQLVlStr($p['cl'], 'int')); }

				if(!isN($p['fchk']) && $p['fchk'] == 'ok'){
					if(!isN($p['fchk_f'])){ $_fld=$p['fchk_f']; }else{ $_fld=$p['emlbox_f_chk']; }
					$__f .= sprintf(' AND ( '.$_fld.' < NOW() - INTERVAL 2 MINUTE || '.$_fld.' IS NULL )');
				}

				if(!isN($p['lmt'])){ $__lmt .= sprintf(' LIMIT %s ', GtSQLVlStr($p['lmt'], 'int')); }

				$query_DtRg = '	SELECT *,

									 (  SELECT COUNT(*)
									 	FROM '._BdStr(DBT).TB_THRD_EML_MSG.'
									 	WHERE emlmsg_eml = id_eml AND emlmsg_inp != \'out\' AND
									 		  id_emlmsg NOT IN ( SELECT emlmsgread_emlmsg FROM '._BdStr(DBT).MDL_THRD_EML_MSG_READ_BD.') AND
									 		  id_emlmsg IN ( SELECT emlmsgbox_msg FROM '._BdStr(DBT).TB_THRD_EML_MSG_BOX.' WHERE emlmsgbox_box = emlbox_id )
									 ) AS __noread

								FROM '._BdStr(DBT).TB_THRD_EML_BOX.'
									 INNER JOIN '._BdStr(DBT).TB_THRD_EML.' ON emlbox_eml = id_eml
								WHERE id_emlbox != "" '.$__f.'
								ORDER BY RAND()
								'.$__lmt.'
							';

				$r['q'] = $query_DtRg;

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$r['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$r['e'] = 'ok';
						$i = 1;
						$i_af = 500;

						do {

							$__enc = $row_DtRg['emlbox_enc'];
							$__m = $this->_box_lbl([ 'id'=>$row_DtRg['emlbox_lbl'] ]);

						    if(!isN($__m->ord)){
							    $ia = $__m->ord;
							}else{
								$ia = $i_af;
							}

						    $r['ls'][ $ia ] = [
								'id'=>$row_DtRg['id_emlbox'],
							    'enc'=>$row_DtRg['emlbox_enc'],
							    'box'=>[
									'id'=>$row_DtRg['emlbox_id'],
									'lbl'=>$row_DtRg['emlbox_lbl'],
									'no_read'=>$row_DtRg['__noread']
							    ],
							    'nm'=>$__m->nm,
							    'ord'=>$ia,
							    'cls'=>$__m->cls,
							    'lbl'=>$__m,
							    'fi'=>$row_DtRg['emlbox_fi'],
								'fa'=>$row_DtRg['emlbox_fa'],
						    ];

						    /*
						    $r['ls'][$ia]['id'] = $row_DtRg['id_emlbox'];
						    $r['ls'][$ia]['enc'] = $row_DtRg['emlbox_enc'];
						    $r['ls'][$ia]['box']['id'] = $row_DtRg['emlbox_id'];
						    $r['ls'][$ia]['nm'] = $__m->ord.'->'.$ia.'->'.$__m->nm;
						    //$r['ls'][$i]['lbl'] = $label->getLabelListVisibility();
						    //$r['ls'][$i]['msg']['tot'] = $label->getMessagesTotal();
						    //$r['ls'][$i]['msg']['unr'] = $label->getMessagesUnread();
						    //$r['ls'][$i]['tp'] = $label->getType();
						    $r['ls'][$ia]['ord'] = $ia;
						    $r['ls'][$ia]['cls'] = $__m->cls;
						    $r['ls'][$ia]['lbl'] = $__m;

						    $r['ls'][$ia]['fi'] = $row_DtRg['emlbox_fi'];
							$r['ls'][$ia]['fa'] = $row_DtRg['emlbox_fa'];
							*/

							$i_af++;
							if(!isN($__m->ord)){ $i++; }

						} while ($row_DtRg = $DtRg->fetch_assoc());


						ksort($r['ls']);
					}
				}

				$__cnx->_clsr($DtRg);
			}

		} catch (Excetion $e) {
			if(!isN($DtRg)){
				$__cnx->_clsr($DtRg);
			}
		    $r['w'] = $e->getMessage();
		}

	  	$rtrn = _jEnc($r);
		return($rtrn);
	}




	public function _upd_fld($p=NULL){

		global $__cnx;

		if($p['t']=='cnv'){
			$__bd = TB_THRD_EML_CNV;
			$__bd_enc = 'emlcnv_enc';
			$__bd_enc_val = $this->emlcnv_enc;
			if($p['f'] == 'f_chk'){ $__id= 'emlcnv_f_chk'; $__vl=$this->emlcnv_f_chk; $_tp='date'; }
		}

		if($__vl != NULL && $__id != NULL){

				$query_DtRg = sprintf("UPDATE "._BdStr(DBT).$__bd." SET ".$__id."=%s WHERE ".$__bd_enc."=%s",
							GtSQLVlStr(ctjTx($__vl,'out'), $_tp),
	                       	GtSQLVlStr(ctjTx($__bd_enc_val,'out'), "text"));
	                       	//echo $query_DtRg.'<br><br>';

				$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);
	}


	public function _islbl($p=NULL){

		global $__cnx;

		$r = 'no';

		if( is_array($p['lbl']) ){
			foreach($p['lbl'] as $k=>$v){
				if($v == $p['v']){ $r = 'ok'; }
			}
		}

		return $r;
	}


	public function _gt_ls_attr($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if(($p['id']!=NULL)){

			if($p['tp'] != NULL){ $__f .= sprintf(' AND emlattr_tp=%s ', GtSQLVlStr($p['tp'], 'text')); }
			if($p['id'] != NULL){ $__f .= sprintf(' AND emlattr_id=%s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = sprintf("	SELECT emlattr_key, emlattr_vl
									FROM "._BdStr(DBT).TB_THRD_EML_ATTR."
									WHERE id_emlattr != '' {$__f}");
			$DtRg = $__cnx->_prc($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					if(!isN($row_DtRg['emlattr_vl'])){
						$key = $row_DtRg['emlattr_key'];
						$Vl[ $key ] = ctjTx($row_DtRg['emlattr_vl'],'in','',['html'=>'ok','qte'=>'no']);
					}
				} while ($row_DtRg = $DtRg->fetch_assoc());

			}

			$__cnx->_clsr($DtRg);
		}


		return _jEnc($Vl);
	}

	public function _gt_ls_addr($p){

		global $__cnx;

		if(!isN($p['id']) || !isN($p['cnv'])){

			if(!isN($p['id'])){ $__f .= sprintf(' AND emlmsgaddr_msg=%s ', GtSQLVlStr($p['id'], 'text')); }
			if(!isN($p['cnv'])){
				$__f .= sprintf(' AND emlcnvmsg_cnv=%s ', GtSQLVlStr($p['cnv'], 'text'));
				$__f .= " AND emlmsg_inp='in' ";
			}

			$query_DtRg = sprintf("	SELECT emlmsgaddr_enc, emlmsgaddr_tp, id_fllcnt, fllcnt_enc, fllcnt_eml, fllcnt_nm_fll, fllcnt_est, cnt_nm, cnt_ap
									FROM "._BdStr(DBT).TB_THRD_EML_MSG_ADDR."
										 INNER JOIN "._BdStr(DBT).TB_THRD_EML_MSG." ON emlmsgaddr_msg = id_emlmsg
										 INNER JOIN "._BdStr(DBT).TB_THRD_EML_CNV_MSG." ON emlcnvmsg_msg = id_emlmsg
										 INNER JOIN "._BdStr(DBM).TB_FLL_CNT." ON emlmsgaddr_fllcnt = id_fllcnt
										 LEFT JOIN ".TB_CNT_EML." ON fllcnt_eml = cnteml_eml
										 LEFT JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
									WHERE id_emlmsgaddr != '' {$__f}");

			//echo compress_code( $query_DtRg );

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					//$Vl = array();

					do{

						$_nm_sprt='';
						$_key_1=$row_DtRg['emlmsgaddr_tp'];
						$_key_2=$row_DtRg['fllcnt_enc'];

						$_nm_sprt_x = explode(' ',ctjTx($row_DtRg['fllcnt_nm_fll'],'in'));
						if(!isN($_nm_sprt_x[0])){ $_nm_sprt = substr($_nm_sprt_x[0], 0, 1); }
						if(!isN($_nm_sprt_x[1])){ $_nm_sprt .= substr($_nm_sprt_x[1], 0, 1); }

						$Vl['ls'][ $_key_1 ][ $_key_2 ]['enc'] = $_key_2;
						$Vl['ls'][ $_key_1 ][ $_key_2 ]['tp'] = $row_DtRg['emlmsgaddr_tp'];
						$Vl['ls'][ $_key_1 ][ $_key_2 ]['dt'] = [
							'id'=>ctjTx($row_DtRg['id_fllcnt'],'in'),
							'eml'=>ctjTx($row_DtRg['fllcnt_eml'],'in'),
							'nm'=>!isN($row_DtRg['cnt_nm'])?ctjTx($row_DtRg['cnt_nm'].' '.$row_DtRg['cnt_ap'],'in'):ctjTx($row_DtRg['fllcnt_nm_fll'],'in'),
							'sg'=>strtoupper($_nm_sprt),
							'est'=>mBln($row_DtRg['fllcnt_est'])
						];


					} while ($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['e'] = 'no_records';

				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No get id for processs';

		}

		return _jEnc($Vl);
	}



	public function _gt_ls_ref($p){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['id'])){ $__f .= sprintf(' AND emlmsgref_msg=%s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = sprintf("	SELECT emlmsgref_enc, emlmsgref_id, emlmsgref_cid
									FROM "._BdStr(DBT).TB_EML_MSG_REF."
									WHERE id_emlmsgref != '' {$__f}"); //echo $query_DtRg;

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						//echo 'RAW ID:'.$row_DtRg['emlmsgref_id'].' / CTJXID:'.ctjTx($row_DtRg['emlmsgref_id'],'in').PHP_EOL;

						$id = $row_DtRg['emlmsgref_enc'];
						$Vl['ls'][$id]['enc'] = $row_DtRg['emlmsgref_enc'];
						$Vl['ls'][$id]['id'] = ctjTx($row_DtRg['emlmsgref_id'],'in','',['html'=>'ok']);
						$Vl['ls'][$id]['cid'] = ctjTx($row_DtRg['emlmsgref_cid'],'in','',['html'=>'ok']);

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No get id for processs';

		}

		return _jEnc($Vl);
	}



	public function _gt_ls_attch($p){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['id'])){ $__f .= sprintf(' AND emlmsgattch_emlmsg=%s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = sprintf("	SELECT emlmsgattch_enc, emlmsgattch_cid, emlmsgattch_file
									FROM "._BdStr(DBT).TB_THRD_EML_MSG_ATTCH."
									WHERE id_emlmsgattch != '' {$__f}"); //echo $query_DtRg;

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$id = $row_DtRg['emlmsgattch_enc'];
						$Vl['ls'][$id]['enc'] = $row_DtRg['emlmsgattch_enc'];
						$Vl['ls'][$id]['cid'] = ctjTx($row_DtRg['emlmsgattch_cid'],'in');
						$Vl['ls'][$id]['fle'] = ctjTx($row_DtRg['emlmsgattch_file'],'in');
						$Vl['ls'][$id]['embd'] = !isN($row_DtRg['emlmsgattch_cid'])?'ok':'no';

						if(!isN($row_DtRg['emlmsgattch_cid'])){
							$Vl['ls'][$id]['url'] = $this->_aws->_s3_get([ 'b'=>'eml', 'fle'=>'attach/'.$row_DtRg['emlmsgattch_file'] ]);
						}

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No get id for processs';

		}

		return _jEnc($Vl);
	}

	public function EmlBoxChk($p=NULL){

		global $__cnx;

		if(!isN($p)){
			$Vl['e'] = 'no';

			if($p['id'] != NULL){ $__f .= sprintf(' AND emlbox_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if($p['eml'] != NULL){ $__f .= sprintf(' AND emlbox_eml= %s ', GtSQLVlStr($p['eml'], 'text')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_THRD_EML_BOX.' WHERE id_emlbox != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlbox'];
					$Vl['enc'] = $row_DtRg['emlbox_enc'];
				}
			}
			$__cnx->_clsr($DtRg);
		}
		return _jEnc($Vl);
	}


	public function CnvChk($p=NULL){

		global $__cnx;

		if(!isN($p)){
			$Vl['e'] = 'no';
			if($p['id'] != NULL){ $__f .= sprintf(' AND sclacccnv_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if($p['sclacc'] != NULL){ $__f .= sprintf(' AND sclacccnv_sclacc= %s ', GtSQLVlStr($p['sclacc'], 'text')); }
			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_CNV.' WHERE id_sclacccnv != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclacccnv'];
					$Vl['enc'] = $row_DtRg['sclacccnv_enc'];
				}
			}
			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);
		}
	}

	public function MsgChk($p){

		if(!isN($p)){

			$Vl['e'] = 'no';

			if($p['id'] != NULL){ $__f .= sprintf(' AND sclacccnvmsg_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if($p['cnv'] != NULL){ $__f .= sprintf(' AND sclacccnvmsg_sclacccnv= %s ', GtSQLVlStr($p['cnv'], 'text')); }

			$query_DtRg = sprintf('	SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_CNV_MSG.' WHERE id_sclacccnvmsg != "" '.$__f);
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclacccnvmsg'];
					$Vl['enc'] = $row_DtRg['sclacccnvmsg_enc'];
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}

	public function EmlCnvChk($p=NULL){

		global $__cnx;

		if(!isN($p) && !isN($p['id']) && !isN($p['eml'])){

			$Vl['e'] = 'no';

			if(!isN($p['id'])){ $__f .= sprintf(' AND emlcnv_id= %s ', GtSQLVlStr(trim($p['id']), 'text')); }
			if(!isN($p['cid'])){ $__f .= sprintf(' AND emlcnv_cid= %s ', GtSQLVlStr(trim($p['id']), 'text')); }
			if(!isN($p['eml'])){ $__f .= sprintf(' AND emlcnv_eml= %s ', GtSQLVlStr($p['eml'], 'text')); }
			if(!isN($p['inp'])){ $__f .= sprintf(' AND emlcnv_inp= %s ', GtSQLVlStr($p['inp'], 'text')); }

			$query_DtRg = '	SELECT id_emlcnv, emlcnv_enc, emlcnv_snpt
							FROM '._BdStr(DBT).TB_THRD_EML_CNV.'
							WHERE id_emlcnv != "" '.$__f; //echo compress_code( $query_DtRg );

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['e'] = 'ok';

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_emlcnv'];
					$Vl['enc'] = $row_DtRg['emlcnv_enc'];
					$Vl['snpt'] = $row_DtRg['emlcnv_snpt'];
				}else{
					$Vl['wm'][] = 'No records';
					$Vl['q'] = compress_code($query_DtRg);
				}

			}else{

				$Vl['w'][] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			if(isN($p['id'])){ $Vl['w'][] = 'Id empty'; }
			if(isN($p['eml'])){ $Vl['w'][] = 'Eml empty'; }

		}

		return _jEnc($Vl);

	}


	public function EmlMsgChk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p)){

			if(!isN($p['id'])){ $__f .= sprintf(' AND id_emlmsg= %s ', GtSQLVlStr(trim($p['id']), 'text')); }
			if(!isN($p['enc'])){ $__f .= sprintf(' AND emlmsg_enc= %s ', GtSQLVlStr(trim($p['enc']), 'text')); }
			if(!isN($p['mid'])){ $__f .= sprintf(' AND emlmsg_id= %s ', GtSQLVlStr(trim($p['mid']), 'text')); }
			if(!isN($p['cid'])){ $__f .= sprintf(' AND emlmsg_cid= %s ', GtSQLVlStr(trim($p['cid']), 'text')); }
			if(!isN($p['eml'])){ $__f .= sprintf(' AND emlmsg_eml= %s ', GtSQLVlStr($p['eml'], 'text')); }
			if(!isN($p['inp'])){ $__f .= sprintf(' AND emlmsg_inp= %s ', GtSQLVlStr($p['inp'], 'text')); }

			$query_DtRg = 'SELECT id_emlmsg, emlmsg_enc, emlmsg_bdy_sve, emlmsg_attch_sve FROM '._BdStr(DBT).TB_THRD_EML_MSG.' WHERE id_emlmsg != "" '.$__f;
			$DtRg = $__cnx->_prc($query_DtRg); //echo $query_DtRg;

			$Vl['q'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlmsg'];
					$Vl['enc'] = $row_DtRg['emlmsg_enc'];
					$Vl['bdy']['sve'] =  mBln($row_DtRg['emlmsg_bdy_sve']);
					//$Vl['bdy']['snpt'] =  ctjTx($row_DtRg['emlmsg_bdy_snpt'],'out');
					$Vl['attch']['sve'] =  mBln($row_DtRg['emlmsg_attch_sve']);
				}

			}else{

				$Vl['w'][] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'][] = 'No data for process';

		}

		return _jEnc($Vl);
	}


	public function EmlCnvMsgChk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p) ){

			if($p['id'] != NULL){ $__f .= sprintf(' AND id_emlcnvmsg= %s ', GtSQLVlStr($p['id'], 'int')); }
			if($p['cnv'] != NULL){ $__f .= sprintf(' AND emlcnvmsg_cnv= %s ', GtSQLVlStr($p['cnv'], 'int')); }
			if($p['msg'] != NULL){ $__f .= sprintf(' AND emlcnvmsg_msg= %s ', GtSQLVlStr($p['msg'], 'int')); }

			$query_DtRg = '	SELECT id_emlcnvmsg, emlcnvmsg_enc
							FROM '._BdStr(DBT).TB_THRD_EML_CNV_MSG.'
							WHERE id_emlcnvmsg != "" '.$__f;

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_emlcnvmsg'];
					$Vl['enc'] = $row_DtRg['emlcnvmsg_enc'];
				}
			}else{
				$Vl['w'][] = $__cnx->c_p->error;
			}

			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
	}



	public function EmlMsgAttchChk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p) ){

			if(!isN($p['id'])){ $__f .= sprintf(' AND id_emlmsgattch= %s ', GtSQLVlStr($p['id'], 'int')); }
			if(!isN($p['cid'])){ $__f .= sprintf(' AND emlmsgattch_cid= %s ', GtSQLVlStr($p['cid'], 'text')); }
			if(!isN($p['nm'])){ $__f .= sprintf(' AND emlmsgattch_name= %s ', GtSQLVlStr($p['nm'], 'text')); }
			if(!isN($p['msg'])){ $__f .= sprintf(' AND emlmsgattch_emlmsg= %s ', GtSQLVlStr($p['msg'], 'text')); }

			$query_DtRg = '	SELECT id_emlmsgattch, emlmsgattch_enc, emlmsgattch_file
							FROM '._BdStr(DBT).TB_THRD_EML_MSG_ATTCH.'
							WHERE id_emlmsgattch != "" '.$__f;

			$DtRg = $__cnx->_qry($query_DtRg);
			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlmsgattch'];
					$Vl['enc'] = $row_DtRg['emlmsgattch_enc'];
					$Vl['fle'] = $row_DtRg['emlmsgattch_file'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
	}

	public function EmlCnvMsgIn($p=NULL){

		global $__cnx;

		$__chk = $this->EmlCnvMsgChk($p);

		$rsp['e']='ok';
		$rsp['prc']['r'] = $__chk;

		if($__chk->e == 'ok'){
			$rsp['prc']['tp'] = 'set';
			if(!isN($__chk->id)){
				$rsp['id'] = $__chk->id;
				//$__chk_upd = $this->EmlCnvMsg([ 't'=>'upd', 'id'=>$p['id'], 'cnv'=>$p['cnv'], 'msg'=>$p['msg'] ]);
				//if($__chk_upd->e!='ok'){ $rsp['e']='no'; $rsp['w'][]=$__chk_upd; }
			}else{

				$rsp['prc']['tp'] = 'in';

				$__chk = $this->EmlCnvMsg([ 'id'=>$p['id'], 'cnv'=>$p['cnv'], 'msg'=>$p['msg'] ]);

				$rsp['prc']['r'] = $__chk;

				if($__chk->e == 'ok' && !isN($__chk->id)){
					$rsp['id'] = $__chk->id;
				}else{
					$rsp['e']='no'; $rsp['w'][]=$__chk;
				}

			}
		}else{
			$rsp['w'][] = 'EmlCnvMsgIn problem on check database data';
			$rsp['w'][] = 'EmlCnvMsgIn No Result:'.print_r($__chk->w, true);
		}

		return _jEnc($rsp);
	}



	public function EmlChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['eml'])){ $__f .= sprintf(' AND eml_eml= %s ', GtSQLVlStr( strtolower($p['eml']) , 'text')); }

			$query_DtRg = '	SELECT id_eml, eml_enc,
								   (SELECT COUNT(*) FROM '._BdStr(DBM).TB_US_EML.' WHERE useml_eml=id_eml) AS ___us_tot
							FROM '._BdStr(DBT).TB_THRD_EML.' WHERE id_eml != "" '.$__f;

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eml'];
					$Vl['enc'] = $row_DtRg['eml_enc'];
					$Vl['tot'] = $row_DtRg['___us_tot'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	public function EmlUsChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['eml'])){ $__f .= sprintf(' AND useml_eml= %s ', GtSQLVlStr($p['eml'], 'int')); }
			if(!isN($p['us'])){ $__f .= sprintf(' AND useml_us= %s ', GtSQLVlStr($p['us'], 'int')); }
			if(!isN($p['cl'])){ $__f .= sprintf(' AND useml_cl= %s ', GtSQLVlStr($p['cl'], 'int')); }


			$query_DtRg = '	SELECT *
							FROM '._BdStr(DBM).TB_US_EML.' WHERE id_useml != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_useml'];
					$Vl['fi'] = $row_DtRg['useml_fi'];
					$Vl['fa'] = $row_DtRg['useml_fa'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	public function Eml($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->eml_eml) && filter_var($this->eml_eml, FILTER_VALIDATE_EMAIL)){

			$__eml = strtolower($this->eml_eml);
			$__enc = enCad(Gn_Rnd(20).'-'.$__eml);

			if(!isN($this->eml_avtr)){ $_avtr = $this->eml_avtr; }else{ $_avtr = 471; }

    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML." (eml_enc, eml_nm, eml_eml, eml_tp, eml_avtr) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($this->eml_nm,'out'), "text"),
                   GtSQLVlStr(ctjTx($__eml,'out'), "text"),
                   GtSQLVlStr($this->eml_tp, "int"),
                   GtSQLVlStr($_avtr, "int"));

			if(!isN($_sql_s)){

				$Result_RLC = $__cnx->_prc($_sql_s);

				if($Result_RLC){

					$rsp['e'] = 'ok';
					$this->eml_id_upd = $__cnx->c_p->insert_id;
					$rsp['id'] = $this->eml_id_upd;
					$rsp['enc'] = $__enc;

				}else{

					$rsp['w'] = 'Eml No result:'.$__cnx->c_p->error;

				}

			}else{

				$rsp['w'] = 'No $_sql_s';

			}

		}else{

			$rsp['w'] = TX_FLTDTINC;

		}

		return _jEnc($rsp);
    }



    public function EmlUs($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->eml_us) && !isN($this->eml_id_upd)){

	    	$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_US_EML." (useml_cl, useml_us, useml_eml) VALUES (%s, %s, %s)",
                       GtSQLVlStr($this->eml_cl, "int"),
                       GtSQLVlStr($this->eml_us, "int"),
                       GtSQLVlStr($this->eml_id_upd, "int"));

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = 'EmlUs No result:'.$__cnx->c_p->error;
			}
		}else{
			$rsp['w'] = TX_FLTDTINC;
		}

		return _jEnc($rsp);

	}





    public function EmlCnv($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->emlcnv_id) && !isN($this->emlcnv_eml)){

			if($p['t'] != 'upd'){

				if(isN($this->emlcnv_inp)){ $_inp = 'non'; }else{ $_inp = $this->emlcnv_inp; } // in/out/non
				$__id = ctjTx(trim($this->emlcnv_id),'out');

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_CNV." (emlcnv_enc, emlcnv_inp, emlcnv_id, emlcnv_cid, emlcnv_eml, emlcnv_est, emlcnv_tot, emlcnv_snpt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr(enCad(Gn_Rnd(20).'-'.$this->emlcnv_eml), "text"),
                       GtSQLVlStr($_inp, "text"),
					   GtSQLVlStr(enCad($__id), "text"),
					   GtSQLVlStr($__id, "text"),
                       GtSQLVlStr($this->emlcnv_eml, "int"),
					   GtSQLVlStr(_CId('ID_SCLCNVEST_ON'), "int"),
					   GtSQLVlStr($this->emlcnv_tot, "int"),
					   GtSQLVlStr(ctjTx($this->emlcnv_snpt,'out'), "text"));

			}elseif(!isN($this->emlcnv_id_upd)){

				if(!isN( $this->emlcnv_snpt )){ $_upd[] = sprintf( 'emlcnv_snpt=%s ', GtSQLVlStr($this->emlcnv_snpt, "text") ); }
				if(!isN( $this->emlcnv_tot ) || $this->emlcnv_tot == 0){ $_upd[] = sprintf( 'emlcnv_tot=%s ', GtSQLVlStr($this->emlcnv_tot, "text") ); }

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_CNV." SET ".implode(',', $_upd)." WHERE id_emlcnv=%s",
							   GtSQLVlStr($this->emlcnv_id_upd, "int"));

			}


			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){
					$this->emlcnv_id_upd = $rsp['id'] = $__cnx->c_p->insert_id;
				}else{
					$rsp['id'] = $this->emlcnv_id_upd;
				}

			}else{
				$rsp['w'] = 'EmlCnv No result:'.$__cnx->c_p->error.' on '.compress_code($_sql_s);
			}

		}else{

			$rsp['w'] =TX_FLTDTINC;

		}

		return _jEnc($rsp);
    }


	public function EmlCnvMsg($p=NULL){

	    global $__cnx;

		$rsp['e'] = 'no';
		//$rsp['data_in'] = $p;

	    if(!isN($p['cnv']) && !isN($p['msg'])){

			$__enc = Enc_Rnd( Gn_Rnd(20).'-'.$p['cnv'].'-'.$p['msg'] );

    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_CNV_MSG." (emlcnvmsg_enc, emlcnvmsg_cnv, emlcnvmsg_msg) VALUES (%s, %s, %s)",
									GtSQLVlStr($__enc, "text"),
									GtSQLVlStr($p['cnv'], "int"),
									GtSQLVlStr($p['msg'], "int"));

			if(!isN($_sql_s)){

				$Result_RLC = $__cnx->_prc($_sql_s);

				if($Result_RLC){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__cnx->c_p->insert_id;
					$rsp['enc'] = $__enc;
				}else{
					$rsp['w'] = 'EmlCnvMsg No result:'.$__cnx->c_p->error.' on '.$_sql_s;
				}
			}

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}

		return _jEnc($rsp);
    }


    public function EmlMsg($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->emlmsg_id) && !isN($this->emlmsg_eml) && ( !isN($this->emlmsg_box) || !isN($p['box']) )){

			if(isN($this->emlmsg_inp)){ $_inp = 'non'; }else{ $_inp = $this->emlmsg_inp; } // in/out/non

			if($p['t'] != 'upd'){

				if(!isN($this->emlmsg_id)){

					$_enc = Enc_Rnd($this->emlmsg_id.'-'.$this->emlmsg_cnv);
					if(!isN($this->emlmsg_attch_tot)){ $_attch_tot=$this->emlmsg_attch_tot; }else{ $_attch_tot=0; }
					if(!isN($this->emlmsg_attr_tot)){ $_attr_tot=$this->emlmsg_attr_tot; }else{ $_attr_tot=0; }
					if(!isN($this->emlmsg_ref_tot)){ $_ref_tot=$this->emlmsg_ref_tot; }else{ $_ref_tot=0; }
					if(!isN($p['box'])){ $_box=$p['box']; }else{ $_box=$this->emlmsg_box; }

					$_id = trim($this->emlmsg_id);

		    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_MSG." (emlmsg_enc, emlmsg_id, emlmsg_cid, emlmsg_no, emlmsg_uid, emlmsg_sbj, emlmsg_inp, emlmsg_eml, emlmsg_box, emlmsg_attch_sve, emlmsg_attch_tot, emlmsg_attr_sve, emlmsg_attr_tot, emlmsg_ref_sve, emlmsg_ref_tot, emlmsg_bdy_sze, emlmsg_f) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
									GtSQLVlStr($_enc, "text"),
									GtSQLVlStr(enCad($_id), "text"),
									GtSQLVlStr($_id, "text"),
									GtSQLVlStr($this->emlmsg_no, "text"),
									GtSQLVlStr($this->emlmsg_uid, "text"),
									GtSQLVlStr($this->emlmsg_sbj, "text"),
									GtSQLVlStr($_inp, "text"),
									GtSQLVlStr($this->emlmsg_eml, "int"),
									GtSQLVlStr($_box, "int"),
									GtSQLVlStr($this->emlmsg_attch_sve, "int"),
									GtSQLVlStr($_attch_tot, "text"),
									GtSQLVlStr($this->emlmsg_attr_sve, "text"),
									GtSQLVlStr($_attr_tot, "text"),
									GtSQLVlStr($this->emlmsg_ref_sve, "text"),
									GtSQLVlStr($_ref_tot, "int"),
									GtSQLVlStr($this->emlmsg_bdy_sze, "text"),
									GtSQLVlStr($this->emlmsg_f, "date"));

                }

			}else{

				if(!isN($this->emlmsg_id_upd)){

					//echo h1( '$this->emlmsg_attch_tot:'.$this->emlmsg_attch_tot );

					if(!isN( $this->emlmsg_no )){ $_upd[] = sprintf( 'emlmsg_no=%s ', GtSQLVlStr($this->emlmsg_no, "text") ); }
					if(!isN( $this->emlmsg_uid )){ $_upd[] = sprintf( 'emlmsg_uid=%s ', GtSQLVlStr($this->emlmsg_uid, "text") ); }

					if(!isN( $this->emlmsg_box )){ $_upd[] = sprintf( 'emlmsg_box=%s ', GtSQLVlStr(trim($this->emlmsg_box), "int") ); }
					if(!isN( $this->emlmsg_sbj )){ $_upd[] = sprintf( 'emlmsg_sbj=%s ', GtSQLVlStr(ctjTx(trim($this->emlmsg_sbj),'out'), "text") ); }
					if(!isN( $this->emlmsg_bdy_sze )){ $_upd[] = sprintf( 'emlmsg_bdy_sze=%s ', GtSQLVlStr($this->emlmsg_bdy_sze, "text") ); }
					if(!isN( $this->emlmsg_bdy_sve )){ $_upd[] = sprintf( 'emlmsg_bdy_sve=%s ', GtSQLVlStr($this->emlmsg_bdy_sve, "int") ); }
					if(!isN( $this->emlmsg_bdy_snpt )){ $_upd[] = sprintf( 'emlmsg_bdy_snpt=%s ', GtSQLVlStr(ctjTx(trim($this->emlmsg_bdy_snpt),'out'), "text") ); }

					if(!isN( $this->emlmsg_attch_sve )){ $_upd[] = sprintf( 'emlmsg_attch_sve=%s ', GtSQLVlStr($this->emlmsg_attch_sve, "int") ); }
					if(!isN( $this->emlmsg_attch_tot ) || $this->emlmsg_attch_tot == '0'){
						$_upd[] = sprintf( 'emlmsg_attch_tot=%s ', GtSQLVlStr($this->emlmsg_attch_tot, "int") );
					}

					if(!isN( $this->emlmsg_attr_sve )){ $_upd[] = sprintf( 'emlmsg_attr_sve=%s ', GtSQLVlStr($this->emlmsg_attr_sve, "int") ); }
					if(!isN( $this->emlmsg_attr_tot ) || $this->emlmsg_attr_tot == '0'){
						$_upd[] = sprintf( 'emlmsg_attr_tot=%s ', GtSQLVlStr($this->emlmsg_attr_tot, "int") );
					}

					if(!isN( $this->emlmsg_ref_sve )){ $_upd[] = sprintf( 'emlmsg_ref_sve=%s ', GtSQLVlStr($this->emlmsg_ref_sve, "int") ); }
					if(!isN( $this->emlmsg_ref_tot ) || $this->emlmsg_ref_tot == '0'){
						$_upd[] = sprintf( 'emlmsg_ref_tot=%s ', GtSQLVlStr($this->emlmsg_ref_tot, "int") );
					}

					if(!isN($_upd)){
						$_sql_s = "UPDATE "._BdStr(DBT).TB_THRD_EML_MSG." SET ".implode(',', $_upd)." WHERE id_emlmsg=".GtSQLVlStr($this->emlmsg_id_upd, "int")." LIMIT 1";
					}

				}

			}

			if(!isN($_sql_s)){ //echo $_sql_s.PHP_EOL;

				$Result_RLC = $__cnx->_prc($_sql_s);

				if($Result_RLC){

					if($p['t'] != 'upd'){
						$rsp['enc'] = $_enc;
						$this->emlmsg_id_upd = $__cnx->c_p->insert_id;
					}

					$_attr = $this->Eml_Attr([ 'tp'=>'msg' ]);
					$_addr = $this->Eml_AddrAll([ 'tp'=>'msg' ]);
					$_ref = $this->Eml_Ref(['tp'=>'msg']);

					if(
						($_attr->e == 'ok' && $_addr->e == 'ok' && $_ref->e == 'ok') ||
						$p['box'] == 'no'
					){

						if($__cnx->c_p->commit()){
							$rsp['e'] = 'ok';
							$rsp['attr'] = $_attr;
							$rsp['addr'] = $_addr;
							$rsp['ref'] = $_ref;
						}else{
							$rsp['w'][] = 'EmlMsg Commit:'.$__cnx->c_p->error;
						}

					}else{

						$rsp['w'][] = 'No commit so have to do rollback';

						if($_attr->e != 'ok'){ $rsp['w']['attr'] = $_attr; }
						if($_addr->e != 'ok'){ $rsp['w']['addr'] = $_addr; }
						if($_ref->e != 'ok'){ $rsp['w']['ref'] = $_ref; }
						$__cnx->c_p->rollback();

					}

				}else{

					$rsp['w'][] = $p['t'].' - EmlMsg Query:'.$__cnx->c_p->error.' on '.$_sql_s;

				}

			}else{

				$rsp['w'][] = 'No $_sql_s on EmlMsg';

			}

		}else{

			if(isN($this->emlmsg_box)){ $_msg_m .='emlmsg_box empty '.$this->emlmsg_box; }
			if(isN($this->emlmsg_id)){ $_msg_m .='emlmsg_id empty '.$this->emlmsg_id; }
			if(isN($this->emlmsg_eml)){ $_msg_m .='emlmsg_eml empty '.$this->emlmsg_eml; }
			$rsp['w'][] = TX_FLTDTINC.' | '.$_msg_m;

		}

		return _jEnc($rsp);
    }



    public function EmlMsgAttch($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->emlmsgattch_name) && !isN($this->emlmsgattch_emlmsg)){

			if($p['t'] != 'upd'){

				if(!isN($this->emlmsgattch_name)){

					$_enc = Enc_Rnd($this->emlmsgattch_name.'-'.$this->emlmsgattch_emlmsg);
					$ext = pathinfo($this->emlmsgattch_name, PATHINFO_EXTENSION);
					$_fle = $_enc.'.'.$ext;

		    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_MSG_ATTCH." (emlmsgattch_enc, emlmsgattch_emlmsg, emlmsgattch_type, emlmsgattch_name, emlmsgattch_cid, emlmsgattch_embd, emlmsgattch_file, emlmsgattch_sze) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
									GtSQLVlStr($_enc, "text"),
									GtSQLVlStr($this->emlmsgattch_emlmsg, "int"),
									GtSQLVlStr(trim($this->emlmsgattch_type), "text"),
									GtSQLVlStr(ctjTx($this->emlmsgattch_name,'out'), "text"),
									GtSQLVlStr(ctjTx($this->emlmsgattch_cid,'out'), "text"),
									GtSQLVlStr(ctjTx($this->emlmsgattch_embd,'out'), "text"),
									GtSQLVlStr(ctjTx($_fle,'out'), "text"),
									GtSQLVlStr($this->emlmsgattch_sze, "int"));

                }

			}else{

				if(!isN($this->emlmsgchk_id_upd)){

					if(!isN( $this->emlmsgattch_sze )){ $_upd[] = sprintf( 'emlmsgattch_sze=%s ', GtSQLVlStr($this->emlmsgattch_sze, "text") ); }

					$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_MSG_ATTCH." SET ".implode(',', $_upd)." WHERE id_emlmsgattch=%s",
								   GtSQLVlStr($this->emlmsgattch_id_upd, "int"));

				}

			}

			if(!isN($_sql_s)){

				$rsp['q'] = $_sql_s;
				$Result_RLC = $__cnx->_prc($_sql_s);

				if($Result_RLC){
					$rsp['e'] = 'ok';
				}else{
					echo $rsp['w'][] = 'EmlMsgAttch No result:'.$__cnx->c_p->error.' on '.$_sql_s;
				}

			}else{

				$rsp['w'][] = 'No $_sql_s on EmlMsg '.$p['t'];

			}

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}

		return _jEnc($rsp);
    }


    public function EmlBox($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->emlbox_id) && !isN($this->emlbox_eml)){

			if($p['t'] != 'upd'){

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_BOX." (emlbox_enc, emlbox_id, emlbox_lbl, emlbox_eml, emlbox_jnk, emlbox_drf, emlbox_out, emlbox_trsh, emlbox_prnt, emlbox_tot, emlbox_luid) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr(enCad($this->emlbox_id.'-'.$this->emlbox_eml), "text"),
                       GtSQLVlStr($this->emlbox_id, "text"),
                       GtSQLVlStr($this->emlbox_lbl, "text"),
					   GtSQLVlStr($this->emlbox_eml, "int"),
					   GtSQLVlStr($this->emlbox_jnk, "int"),
					   GtSQLVlStr($this->emlbox_drf, "int"),
					   GtSQLVlStr($this->emlbox_out, "int"),
					   GtSQLVlStr($this->emlbox_trsh, "int"),
					   GtSQLVlStr($this->emlbox_parent_id, "int"),
					   GtSQLVlStr($this->emlbox_tot, "int"),
					   GtSQLVlStr($this->emlbox_luid, "int"));

			}else{

				if(!isN($this->emlbox_id_upd)){

					$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_BOX." SET emlbox_lbl=%s, emlbox_prnt=%s, emlbox_jnk=%s, emlbox_drf=%s, emlbox_out=%s, emlbox_trsh=%s, emlbox_tot=%s, emlbox_luid=%s WHERE id_emlbox=%s",
			                       GtSQLVlStr($this->emlbox_lbl, "text"),
								   GtSQLVlStr($this->emlbox_parent_id, "int"),
								   GtSQLVlStr($this->emlbox_jnk, "int"),
								   GtSQLVlStr($this->emlbox_drf, "int"),
								   GtSQLVlStr($this->emlbox_out, "int"),
								   GtSQLVlStr($this->emlbox_trsh, "int"),
								   GtSQLVlStr($this->emlbox_tot, "int"),
								   GtSQLVlStr($this->emlbox_luid, "int"),
								   GtSQLVlStr($this->emlbox_id_upd, "int"));

				}

			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = 'EmlBox No result:'.$__cnx->c_p->error;
			}
		}else{
			$rsp['w'] = TX_FLTDTINC.'id:'.$this->emlbox_id.' eml:'.$this->emlbox_eml;
		}
		return _jEnc($rsp);
    }





	public function EmlAttrDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['key']) && !isN($p['id']) && !isN($p['tp'])){

			if($p['key'] != NULL){ $__f .= ' AND emlattr_key='.GtSQLVlStr($p['key'], 'text').' '; }
			if($p['id'] != NULL){ $__f .= ' AND emlattr_id='.GtSQLVlStr($p['id'], 'text').' '; }
			if($p['tp'] != NULL){ $__f .= ' AND emlattr_tp='.GtSQLVlStr($p['tp'], 'text').' '; }

			$query_DtRg = 'SELECT id_emlattr FROM '._BdStr(DBT).TB_THRD_EML_ATTR.' WHERE id_emlattr != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlattr'];
				}
			}else{
				$rsp['w'] = $this->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'EmlAttrDt:No data on P';

		}

		return(_jEnc($Vl));
	}


	public function Eml_Attr($p=NULL){

		global $__cnx;

	    $rsp['e'] = 'no';
		//$rsp['p'] = $p;

		if(
			(!isN($this->eml_id_upd) && $p['tp'] == 'eml') ||
			(!isN($this->emlmsg_id_upd) && $p['tp'] == 'msg')
		){

		    if(
				(!isN($this->eml_attr) && $p['tp'] == 'eml') ||
				(!isN($this->emlmsg_attr) && $p['tp'] == 'msg')
			){

				$_prc_tot=0;

				if($p['tp'] == 'eml'){
					$attr_id = $this->eml_id_upd;
					$attr_ls = $this->eml_attr;
				}elseif($p['tp'] == 'msg'){
					$attr_id = $this->emlmsg_id_upd;
					$attr_ls = $this->emlmsg_attr;
				}

			    foreach($attr_ls as $k=>$v){

					$rsp['ls'][ $k ] = $v.'->ok';

					$__chk = $this->EmlAttrDt([ 'key'=>$k, 'tp'=>$p['tp'], 'id'=>$attr_id ]);

					if(is_array($v)){
						$__v = json_encode($v);
					}elseif(is_object($v)){
						$__v = json_encode($v, true);
					}else{
						$__v = trim($v);
					}

					if(!isN($__v) && !isN($attr_id)){

						if($__chk->e == 'ok' && !isN($__chk->id) && !isN(trim($__v))){

							$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_ATTR." SET emlattr_vl=%s WHERE emlattr_tp=%s AND emlattr_id=%s AND emlattr_key=%s",
								GtSQLVlStr( ctjTx($__v,'out') , "text"),
								GtSQLVlStr( $p['tp'] , "text"),
								GtSQLVlStr( $attr_id , "int"),
								GtSQLVlStr( $k , "text"));

						}elseif(!isN($attr_id) && !isN($k) && !isN($__v)){

							$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_ATTR." (emlattr_tp, emlattr_id, emlattr_key, emlattr_vl) VALUES (%s, %s, %s, %s)",
								GtSQLVlStr($p['tp'], "text"),
								GtSQLVlStr($attr_id, "int"),
								GtSQLVlStr($k, "text"),
								GtSQLVlStr(ctjTx($__v,'out'), "text"));

						}

						if(!isN($_sql_s)){

							$Result_RLC = $__cnx->_prc($_sql_s);

							if($Result_RLC){
								$rsp['e'] = 'ok'; $_prc_tot++;
							}else{
								$rsp['w'][] = 'Eml_Attr No result:'.$__cnx->c_p->error;
								$rsp['w'][] = 'Eml_Attr $__chk:'.print_r($__chk, true);
							}

						}

					}else{

						$rsp['w'][] = $k.' value is empty';

					}

				}

		    }else{

				if(isN($this->eml_attr)){ $rsp['w']['data'] = '$this->eml_attr empty'; }
				if(isN($this->emlmsg_attr)){ $rsp['w']['data'] = '$this->emlmsg_attr empty'; }

			}

		}else{

			$rsp['w']['dtinc'] = TX_FLTDTINC;
			if(isN($this->eml_id_upd)){ $rsp['w']['idempt'] = 'eml_id_upd empty'; }
			if(isN($this->emlmsg_id_upd)){ $rsp['w']['idempt'] = 'emlmsg_id_upd empty'; }

		}

		$rsp['p']['tot'] = $_prc_tot;

		return _jEnc($rsp);
	}


	public function EmlRefDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && (!isN($p['id']) || !isN($p['cid']))&& !isN($p['msg'])){

			if(!isN($p['id'])){ $__f .= ' AND emlmsgref_id='.GtSQLVlStr($p['id'], 'text').' '; }
			if(!isN($p['cid'])){ $__f .= ' AND emlmsgref_cid='.GtSQLVlStr($p['cid'], 'text').' '; }
			if(!isN($p['msg'])){ $__f .= ' AND emlmsgref_msg='.GtSQLVlStr($p['msg'], 'text').' '; }

			$query_DtRg = 'SELECT id_emlmsgref FROM '._BdStr(DBT).TB_EML_MSG_REF.' WHERE id_emlmsgref != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_prc($query_DtRg);
			//echo $query_DtRg.PHP_EOL;

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlmsgref'];
				}
			}else{
				$rsp['w'] = $this->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'EmlRefDt:No data on P';

		}

		return(_jEnc($Vl));
	}

	public function Eml_Ref($p=NULL){

		global $__cnx;

	    $rsp['e'] = 'no';
	    //$rsp['p'] = $p;

	    if(!isN($this->emlmsg_id_upd)){

		    if(!isN($this->emlmsg_ref)){

				$rsp['l']['all'] = $this->emlmsg_ref;

				$rsp['l']['tot'] = count($this->emlmsg_ref);

				$_prc_tot=0;

			    foreach($this->emlmsg_ref as $k=>$v){

					$rsp['p']['ls'][] = $v;

					$__chk = $this->EmlRefDt([ 'id'=>enCad($v), 'msg'=>$this->emlmsg_id_upd ]);

					if(is_array($v)){
						$__v = json_encode($v);
					}elseif(is_object($v)){
						$__v = json_encode($v, true);
					}else{
						$__v = trim($v);
					}

					if(!isN($__v)){

						if($__chk->e == 'ok' && !isN($__chk->id) && !isN(trim($__v))){

							$rsp['e'] = 'ok';
							$_prc_tot++;

						}elseif(!isN($this->emlmsg_id_upd) && !isN($__v)){

							$__enc = Enc_Rnd( $__v.'-'.$this->emlmsg_id_upd );
							$__id = ctjTx($__v,'out');

							$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_EML_MSG_REF." (emlmsgref_enc, emlmsgref_id, emlmsgref_cid, emlmsgref_msg) VALUES (%s, %s, %s, %s)",
												GtSQLVlStr($__enc, "text"),
												GtSQLVlStr(enCad($__id), "text"),
												GtSQLVlStr($__id, "text"),
												GtSQLVlStr($this->emlmsg_id_upd, "text"));

						}

						//echo $_sql_s.PHP_EOL.PHP_EOL;

						if(!isN($_sql_s)){

							$Result_RLC = $__cnx->_prc($_sql_s);

							if($Result_RLC){
								$rsp['e'] = 'ok';
								$_prc_tot++;
							}else{
								$rsp['w'][] = 'Eml_Ref No result:'.$__cnx->c_p->error;
								$rsp['w'][] = 'Eml_Ref $__chk:'.print_r($__chk, true);
							}

						}

					}

				}

				$rsp['p']['tot'] = $_prc_tot;

		    }else{

				$rsp['e'] = 'ok';

			}

		}else{

			$rsp['w'] = TX_FLTDTINC;

		}

		return _jEnc($rsp);

	}



    public function EmlAddrDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['cnv']) && !isN($p['tp']) && !isN($p['fllcnt'])){

			if(!isN($p['cnv'])){ $__f .= ' AND emlmsgaddr_msg='.GtSQLVlStr($p['cnv'], 'text').' '; }
			if(!isN($p['tp'])){ $__f .= ' AND emlmsgaddr_tp='.GtSQLVlStr($p['tp'], 'text').' '; }
			if(!isN($p['fllcnt'])){ $__f .= ' AND emlmsgaddr_fllcnt='.GtSQLVlStr($p['fllcnt'], 'int').' '; }

			$query_DtRg = 'SELECT id_emlmsgaddr FROM '._BdStr(DBT).TB_THRD_EML_MSG_ADDR	.' WHERE id_emlmsgaddr != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_prc($query_DtRg);

			$Vl['q'] = $query_DtRg;

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg == 1){
					$Vl['id'] = $row_DtRg['id_emlmsgaddr'];
				}

			}else{
				$Vl['w'] = $this->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'EmlAddrDt:No data on P';

		}

		return(_jEnc($Vl));
	}





    public function Eml_AddrAll($p=NULL){

		//$rsp['ls'] = $this->emlmsg__addr;

		if(!isN($this->emlmsg__addr)){

			$rsp['e'] = 'ok';

			foreach($this->emlmsg__addr as $addr_k=>$addr_v){

				if(!isN($addr_v)){

					foreach($addr_v as $addr_k2=>$addr_v2){

						//echo 'PROCESS '.$addr_v2->eml.PHP_EOL;

						if(!isN($addr_v2) && !isN($addr_v2->eml)){

							$_sve = $this->Eml_Addr([
								't'=>$p['tp'],
								'tp'=>$addr_k,
								'nm'=>$addr_v2->nm,
								'eml'=>$addr_v2->eml
							]);

							if($_sve->e != 'ok'){ $rsp['e'] = 'no'; $rsp['w'] = $_sve->w; break; }

						}

					}

				}

			}

		}else{

			$rsp['e'] = 'ok';

		}

		return _jEnc($rsp);
	}




    public function Eml_Addr($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($this->emlmsg_id_upd) && !isN($p['eml']) && !isN($p['tp'])){

            $__Fll = new CRM_Fll();
			$__Fll->c_eml = ctjTx(filter_var( strtolower($p['eml']), FILTER_SANITIZE_EMAIL),'out');

			if(!isN($__Fll->c_eml)){

				$__Fll->c_eml_nm = [
					'fll'=>ctjTx($p['nm'],'out')
				];

				$__Sve = $__Fll->sve();

				if(!isN($__Sve->eml->id)){

					$__chk = $this->EmlAddrDt([ 'cnv'=>$this->emlmsg_id_upd, 'tp'=>$p['tp'], 'fllcnt'=>$__Sve->eml->id ]);

					//echo h2('Try to save eml:'.$p['eml'].' and ID:'.$__Sve->eml->id.' <br> '.print_r($__chk,true) );

					if($__chk->e == 'ok' && isN($__chk->id) && !isN($this->emlmsg_id_upd) && !isN($p['tp']) && !isN($__Sve->eml->id)){

						$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML_MSG_ADDR." (emlmsgaddr_enc, emlmsgaddr_msg, emlmsgaddr_fllcnt, emlmsgaddr_tp) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr(Enc_Rnd($this->emlmsg_id_upd.$p['tp'].$__Sve->eml->id), "text"),
							GtSQLVlStr($this->emlmsg_id_upd, "int"),
							GtSQLVlStr($__Sve->eml->id, "int"),
							GtSQLVlStr($p['tp'], "text"));
							//echo h2($_sql_s);

						if(!isN($_sql_s)){

							$Result_RLC = $__cnx->_prc($_sql_s);

							if($Result_RLC){
								$rsp['e'] = 'ok';
							}else{
								$rsp['w'][] = 'Eml_Addr No result:'.$__cnx->c_p->error.' / '.$__chk->q.' / on '.$_sql_s;
								$rsp['w'][] = $__chk;
							}

						}

					}else{

						if($__chk->e != 'ok'){
							$rsp['w'][] = $__chk;
						}elseif(!isN($__chk->id)){
							$rsp['e'] = 'ok';
						}

						if(isN($this->emlmsg_id_upd)){ $rsp['w'][] = '$this->emlmsg_id_upd:'.$this->emlmsg_id_upd; }
						if(isN($p['tp'])){ $rsp['w'][] = '$p[tp]:'.$p['tp']; }
						if(isN($__Sve->eml->id)){
							$rsp['w'][] = '$__Sve->eml->id:'.$__Sve->eml->id;
							$rsp['w'][] = $__Sve;
						}

					}

				}else{

					$rsp['w'][] = '$__Sve->eml->id is empty';
					$rsp['w'][] = $__Sve;

				}

			}else{

				$rsp['w'][] = strtolower('Email:'.$p['eml']).' empty on sanitize';

			}

		}else{

			if(isN($p['eml'])){ $rsp['w'][] = '$p[eml] is empty'; }
			if(isN($p['tp'])){ $rsp['w'][] = 'tp is empty:'.$p['tp']; }
			if(isN($this->emlmsg_id_upd)){ $rsp['w'][] = TX_FLTDTINC.' $this->emlmsg_id_upd:'.$this->emlmsg_id_upd; }

		}

		return _jEnc($rsp);

    }




    public function EmlMsgBoxDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['box']) && !isN($p['msg']) ){

			if($p['box'] != NULL){ $__f .= ' AND emlmsgbox_box='.GtSQLVlStr($p['box'], 'text').' '; }
			if($p['msg'] != NULL){ $__f .= ' AND emlmsgbox_msg='.GtSQLVlStr($p['msg'], 'int').' '; }

			$query_DtRg = 'SELECT id_emlmsgbox FROM '._BdStr(DBT).TB_THRD_EML_MSG_BOX.' WHERE id_emlmsgbox != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['id'] = $row_DtRg['id_emlmsgbox'];
				}

			}else{
				$rsp['w'] = $this->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'EmlMsgBoxDt:No data on P';
		}


		return(_jEnc($Vl));

	}





	public function EmlBoxDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p)){

			if($p['eml'] != NULL){ $__f .= ' AND emlbox_eml='.GtSQLVlStr($p['eml'], 'int').' '; }
			if($p['id'] != NULL){ $__f .= ' AND emlbox_id='.GtSQLVlStr($p['id'], 'int').' '; }
			if($p['enc'] != NULL){ $__f .= ' AND emlbox_enc='.GtSQLVlStr($p['enc'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_THRD_EML_BOX.' WHERE id_emlbox != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){

					$__m = $this->_box_lbl([ 'id'=>$row_DtRg['emlbox_lbl'] ]);


					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlbox'];
					$Vl['enc'] = $row_DtRg['emlbox_enc'];
					$Vl['eml'] = $row_DtRg['emlbox_eml'];
					$Vl['box']['id'] = $row_DtRg['emlbox_id'];
					$Vl['box']['lbl'] = $row_DtRg['emlbox_lbl'];
					$Vl['box']['nm'] = $__m->nm;
				    $Vl['box']['ord'] = $__m->ord;
				    $Vl['box']['cls'] = $__m->cls;


				}
			}else{
				$rsp['w'] = $this->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'EmlBoxDt:No data on P';

		}

		return(_jEnc($Vl));

	}

	public function EmlMsgLs($p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if( !isN($p) && !isN($p['id']) ){

			if($p['t']=='enc'){ $_t_fld = 'emlcnv_enc'; $_t_fld_s='text'; }
			if(!isN($p['id'])){ $__fl .= sprintf(' AND '.$_t_fld.'=%s', GtSQLVlStr($p['id'], $_t_fld_s)); }

			$query_DtRg = sprintf('SELECT id_emlmsg, emlmsg_enc, emlmsg_cid, emlmsg_bdy_sze, emlmsg_f, emlattr_key, emlattr_vl
								   FROM '._BdStr(DBT).TB_THRD_EML_MSG.'
								   		INNER JOIN '._BdStr(DBT).TB_THRD_EML_CNV_MSG.' ON emlcnvmsg_msg = id_emlmsg
										INNER JOIN '._BdStr(DBT).TB_THRD_EML_CNV.' ON emlcnvmsg_cnv = id_emlcnv
										LEFT JOIN '._BdStr(DBT).TB_THRD_EML_ATTR.' ON emlattr_id = id_emlmsg
								   WHERE id_emlmsg IS NOT NULL '.$__fl.' AND emlattr_tp = "msg"
								   ORDER BY emlmsg_f DESC');

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = "ok";

					do{

						$__id = $row_DtRg['emlmsg_enc'];

						$Vl['ls'][$__id]['id'] = $row_DtRg['id_emlmsg'];
						$Vl['ls'][$__id]['enc'] = $row_DtRg['emlmsg_enc'];
						$Vl['ls'][$__id]['cid'] = $row_DtRg['emlmsg_cid'];
						$Vl['ls'][$__id]['bdy'] = [
							'sze'=>ctjTx($row_DtRg['emlmsg_bdy_sze'],'in')
						];

						$Vl['ls'][$__id]['attr'][ $row_DtRg['emlattr_key'] ] = ctjTx($row_DtRg['emlattr_vl'],'in');
						$Vl['ls'][$__id]['f'] = $row_DtRg['emlmsg_f'];

						if($p['d']['html']=='ok'){
							$Vl['ls'][$__id]['html'] = $this->_aws->_s3_get([ 'b'=>'eml', 'fle'=>'message/'.$row_DtRg['emlmsg_enc'].'.html' ]);
						}

						if($p['d']['addr']=='ok'){ $Vl['ls'][$__id]['addr'] = $this->_gt_ls_addr(['tp'=>'msg', 'id'=>$row_DtRg['id_emlmsg']]); }
						if($p['d']['attch']=='ok'){ $Vl['ls'][$__id]['attch'] = $this->_gt_ls_attch(['tp'=>'msg', 'id'=>$row_DtRg['id_emlmsg']]); }

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['m'] = 'no_records on '.$query_DtRg;
				}

			}else{
				$Vl['e'] = 'no';
				$Vl['w'] = 'ERROR Query:'.$__cnx->c_p->error.' on '.$query_DtRg;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No all data for query';
		}

		return _jEnc($Vl);

	}





	public function EmlCnvAddrDt($p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if( !isN($p) && !isN($p['id']) ){

			if($p['t']=='enc'){ $_t_fld = 'emlcnv_enc'; $_t_fld_s='text'; }
			if(!isN($p['id'])){ $__fl .= sprintf(' AND '.$_t_fld.'=%s', GtSQLVlStr($p['id'], $_t_fld_s)); }

			$query_DtRg = sprintf('SELECT id_emlmsgaddr, emlmsgaddr_enc, emlmsgaddr_tp, fllcnt_nm_fll, fllcnt_eml
								   FROM '._BdStr(DBT).TB_THRD_EML_MSG.'
								   		INNER JOIN  '._BdStr(DBT).TB_THRD_EML.' ON emlmsg_eml = id_eml
								   		INNER JOIN '._BdStr(DBT).TB_THRD_EML_CNV_MSG.' ON emlcnvmsg_msg = id_emlmsg
										INNER JOIN '._BdStr(DBT).TB_THRD_EML_CNV.' ON emlcnvmsg_cnv = id_emlcnv
										INNER JOIN '._BdStr(DBT).TB_THRD_EML_MSG_ADDR.' ON emlmsgaddr_msg = id_emlmsg
										INNER JOIN '._BdStr(DBM).TB_FLL_CNT.' ON emlmsgaddr_fllcnt = id_fllcnt
								   WHERE id_emlmsg IS NOT NULL '.$__fl.' AND emlmsg_inp="in" AND fllcnt_eml != eml_eml
								   ORDER BY emlmsgaddr_fi ASC
								   LIMIT 10');

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = "ok";

					do{

						$__id = $row_DtRg['emlmsgaddr_enc'];
						$__tp = $row_DtRg['emlmsgaddr_tp'];
						$__o=[];

						$__o['id'] = $row_DtRg['id_emlmsgaddr'];
						$__o['enc'] = $row_DtRg[' emlmsgaddr_enc'];
						$__o['eml'] = ctjTx($row_DtRg['fllcnt_eml'],'in');
						$__o['nm'] = ctjTx($row_DtRg['fllcnt_nm_fll'],'in');

						$Vl[$__tp]['ls'][$__id] = $__o;
						$Vl[$__tp]['main'] = $__o;

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['e'] = "no";
					$Vl['w'] = $__cnx->c_r->error;
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}



	public function EmlCnvDt($p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p) && ( !isN($p['id']) || !isN($p['cnv_id']) ) ){

			if($p['t']=='enc'){
				$_t_fld = 'emlcnv_enc'; $_t_fld_s='text';
			}else{
				$_t_fld = 'id_emlcnv'; $_t_fld_s='int';
			}

			if(!isN($p['id'])){ $__fl .= sprintf(' AND '.$_t_fld.'=%s', GtSQLVlStr($p['id'], $_t_fld_s) ); }
			if(!isN($p['cnv_id'])){ $__fl .= sprintf(' AND emlcnv_id=%s', GtSQLVlStr(trim($p['cnv_id']), 'text') ); }
			if(!isN($p['eml'])){ $__fl .= sprintf(' AND emlcnv_eml=%s', GtSQLVlStr($p['eml'], 'int') ); }

			$query_DtRg = 'SELECT id_emlcnv, emlcnv_enc, emlcnv_id, emlcnv_cid, emlcnv_inp, emlcnv_eml, emlcnv_snpt, emlcnv_tot, eml_enc
						   FROM '._BdStr(DBT).TB_THRD_EML_CNV.'
						   	    INNER JOIN '._BdStr(DBT).TB_THRD_EML.' ON emlcnv_eml = id_eml
						   WHERE id_emlcnv IS NOT NULL '.$__fl.'
						   LIMIT 1';

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$Vl['e'] = "ok";
				//$Vl['q'] = compress_code($query_DtRg);

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_emlcnv'];
					$Vl['enc'] = $row_DtRg['emlcnv_enc'];
					$Vl['inp'] = ctjTx($row_DtRg['emlcnv_inp'],'in');

					$Vl['mid'] = ctjTx($row_DtRg['emlcnv_id'],'in');
					$Vl['cid'] = ctjTx($row_DtRg['emlcnv_cid'],'in');

					$Vl['eml']['id'] = ctjTx($row_DtRg['emlcnv_eml'],'in');
					$Vl['eml']['enc'] = ctjTx($row_DtRg['eml_enc'],'in');

					$Vl['snpt'] = ctjTx($row_DtRg['emlcnv_snpt'],'in');

					$Vl['tot']['msg'] = ctjTx($row_DtRg['emlcnv_tot'],'in');

					if($p['d']['addr']=='ok'){
						$Vl['addr'] = $this->EmlCnvAddrDt([ 't'=>'enc', 'id'=>$row_DtRg['emlcnv_enc'] ]);
					}

				}

			}else{
				$Vl['e'] = "no";
				$Vl['w'][] = 'EmlCnvDt error on query '.compress_code($query_DtRg);
				$Vl['w'][] = $__cnx->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			if(isN($p['id'])){ $Vl['w'][] = '$p[id] is empty'; }
			if(isN($p['cnv_id'])){ $Vl['w'][] = '$p[cnv_id] is empty'; }

		}

		return _jEnc($Vl);

	}


	public function EmlMsgDt($p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p)){

			if($p['t']=='enc'){ $_t_fld = 'emlmsg_enc'; $_t_fld_s='text'; }
			if(!isN($p['id'])){ $__fl .= sprintf(' AND '.$_t_fld.'=%s', GtSQLVlStr($p['id'], $_t_fld_s) ); }
			if(!isN($p['cid'])){ $__fl .= sprintf(' AND emlmsg_cid=%s', GtSQLVlStr($p['cid'], 'text') ); }
			if(!isN($p['mid'])){ $__fl .= sprintf(' AND emlmsg_id=%s', GtSQLVlStr($p['mid'], 'text') ); }

			$query_DtRg = 'SELECT id_emlmsg, emlmsg_enc, emlmsg_cid, emlcnv_id, emlcnv_cid
						   FROM '._BdStr(DBT).TB_THRD_EML_MSG.'
						   		LEFT JOIN '._BdStr(DBT).TB_THRD_EML_CNV_MSG.' ON emlcnvmsg_msg = id_emlmsg
								LEFT JOIN '._BdStr(DBT).TB_THRD_EML_CNV.' ON emlcnvmsg_cnv = id_emlcnv
						   WHERE id_emlmsg IS NOT NULL '.$__fl.'
						   LIMIT 1';

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$Vl['e'] = "ok";
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_emlmsg'];
					$Vl['enc'] = $row_DtRg['emlmsg_enc'];
					$Vl['cid'] = $row_DtRg['emlmsg_cid'];
					$Vl['cnv']['id'] = $row_DtRg['emlcnv_id'];
					$Vl['cnv']['cid'] = $row_DtRg['emlcnv_cid'];

					if($p['r_bdy']!='no'){
						$Vl['bdy']['sze'] = ctjTx($row_DtRg['emlmsg_bdy_sze'],'in');
					}

					if($p['d']['attr']=='ok'){ $Vl['attr'] = $this->_gt_ls_attr(['tp'=>'msg', 'id'=>$row_DtRg['id_emlmsg'] ]); }
					if($p['d']['addr']=='ok'){ $Vl['addr'] = $this->_gt_ls_addr(['tp'=>'msg', 'id'=>$row_DtRg['id_emlmsg']]); }
					if($p['d']['ref']=='ok'){ $Vl['ref'] = $this->_gt_ls_ref(['tp'=>'msg', 'id'=>$row_DtRg['id_emlmsg']]); }
					if($p['d']['attch']=='ok'){ $Vl['attch'] = $this->_gt_ls_attch(['tp'=>'msg', 'id'=>$row_DtRg['id_emlmsg']]); }

					$Vl['f'] = $row_DtRg['emlmsg_f'];

				}else{

					$Vl['w'] = 'No records on query';

				}

			}else{

				$Vl['w'] = 'Error '.$__cnx->c_p->error.' on query ('.compress_code($query_DtRg).') ';

			}

			$__cnx->_clsr($DtRg);


		}else{

			$Vl['w'] = 'No all data for process';

		}

		return _jEnc($Vl);

	}



	public function EmlMsgCnv_Mtch($p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p) && !isN($p['msg']) && !isN($p['eml']) && !isN($p['cid'])){

			$query_DtRg = sprintf('	SELECT id_emlmsg, emlmsg_enc, emlmsg_cid, emlmsg_f, emlmsg_sbj, id_emlcnv, emlcnv_enc
						   			FROM '._BdStr(DBT).TB_THRD_EML_MSG.'
										 INNER JOIN '._BdStr(DBT).TB_EML_MSG_REF.' ON emlmsgref_msg = id_emlmsg
										 LEFT JOIN '._BdStr(DBT).TB_THRD_EML_CNV_MSG.' ON emlcnvmsg_msg = id_emlmsg
										 LEFT JOIN '._BdStr(DBT).TB_THRD_EML_CNV.' ON emlcnvmsg_cnv = id_emlcnv
									WHERE id_emlmsg !=%s AND emlmsg_eml=%s AND (emlmsgref_id=%s || emlmsg_cid=%s)
									ORDER BY emlmsg_f ASC',
									GtSQLVlStr($p['msg'], 'int'),
									GtSQLVlStr($p['eml'], 'int'),
									GtSQLVlStr($p['cid'], 'text'),
									GtSQLVlStr($p['cid'], 'text')
								);

			$DtRg = $__cnx->_prc($query_DtRg);
			//echo $query_DtRg.PHP_EOL;

			if($DtRg){

				$Vl['e'] = "ok";
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$key = $row_DtRg['emlmsg_enc'];
						$Vl['ls'][ $key ]['id'] = $row_DtRg['id_emlmsg'];
						$Vl['ls'][ $key ]['enc'] = $row_DtRg['emlmsg_enc'];
						$Vl['ls'][ $key ]['cid'] = $row_DtRg['emlmsg_cid'];
						$Vl['ls'][ $key ]['f'] = $row_DtRg['emlmsg_f'];
						$Vl['ls'][ $key ]['cnv']['id'] = ctjTx($row_DtRg['id_emlcnv']);
						$Vl['ls'][ $key ]['cnv']['enc'] = ctjTx($row_DtRg['emlcnv_enc']);

						if($row_DtRg['emlmsg_f'] < $_f_bfr || isN($_f_bfr)){
							$Vl['ls'][ $key ]['is_older'] =	'ok';
						}

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);


		}else{

			$Vl['w'] = 'No all data for process';

		}

		return _jEnc($Vl);

	}


	public function EmlMsgReadChk($p=NULL){

		global $__cnx;

		if(!isN($p)){
			$Vl['e'] = 'no';

			if($p['msg'] != NULL){ $__f .= sprintf(' AND emlmsgread_emlmsg=%s', GtSQLVlStr($p['msg'], 'int')); }
			if($p['us'] != NULL){ $__f .= sprintf(' AND emlmsgread_us= %s ', GtSQLVlStr($p['us'], 'int')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).MDL_THRD_EML_MSG_READ_BD.' WHERE id_emlmsgread != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlmsgread'];
					$Vl['enc'] = $row_DtRg['emlmsgread_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}
		return _jEnc($Vl);
	}



	public function EmlMsgReadIn($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($p['us']) && !isN($p['msg'])){

			if($p['t'] != 'upd'){
				$rsp['enc'] = enCad($p['msg'].'-'.$p['us']);
	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).MDL_THRD_EML_MSG_READ_BD." (emlmsgread_enc, emlmsgread_emlmsg, emlmsgread_us) VALUES (%s, %s, %s)",
                       GtSQLVlStr($rsp['enc'], "text"),
                       GtSQLVlStr($p['msg'], "int"),
                       GtSQLVlStr($p['us'], "int"));
			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){
				$rsp['id'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = 'EmlMsgReadIn No result:'.$__cnx->c_p->error;
			}

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }


	public function EmlMsgRead($p=NULL){

		$__chk_emlcnvmsread = $this->EmlMsgReadChk([ 'msg'=>$p['msg'], 'us'=>SISUS_ID ]);

		if($__chk_emlcnvmsread->e != 'ok'){
			$__chk_emlmsgread = $this->EmlMsgReadIn([ 'msg'=>$p['msg'], 'us'=>SISUS_ID ]);
		}

		if($__chk_emlmsgread->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['id'] = $__chk_emlmsgread->id;
			$rsp['enc'] = $__chk_emlmsgread->enc;
		}

	}


	public function Upd_Eml_Fld($p=NULL){

		global $__cnx;

		if(!isN($p['id']) && !isN($p['fld'])){

				foreach($p['fld'] as $_f_k=>$_f_v){

					if(isN($_f_v['v'])){ $v = NULL; }else{ $v = $_f_v['v']; }

					if($_f_v['pss']=='ok'){
						$__f_q = " ".$_f_v['k']." = AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."') ";
					}else{
						$__f_q = " ".$_f_v['k']." = %s ";
					}

					$_f_upd[] = sprintf($__f_q, GtSQLVlStr(ctjTx($v,'out'), "text") );

				}

				if($p['t']=='box'){
					$__bd = TB_THRD_EML_BOX; $__bdr = 'emlbox_enc';
				}elseif($p['t']=='eml'){
					$__bd = TB_THRD_EML; $__bdr = 'eml_enc';
				}

				if(!isN($__f_q) && !isN($__bd)){
					$query_DtRg = sprintf("UPDATE "._BdStr(DBT).$__bd." SET ".implode(',', $_f_upd)." WHERE ".$__bdr."=%s LIMIT 1",
								GtSQLVlStr(ctjTx($p['id'],'out'), "text"));  //echo $query_DtRg;
					$DtRg = $__cnx->_prc($query_DtRg);
				}

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				if($p['pss']!='ok'){  $rsp['val'] = $p['vle']; }
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				//$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);
	}


	public function html_clr($string) {
		// ----- remove HTML TAGs -----
		$string = preg_replace ('/<[^>]*>/', ' ', $string);
		// ----- remove control characters -----
		$string = str_replace("\r", '', $string);
		$string = str_replace("\n", ' ', $string);
		$string = str_replace("\t", ' ', $string);
		$string = str_replace("&nbsp;", ' ', $string);
		// ----- remove multiple spaces -----
		$string = trim(preg_replace('/ {2,}/', ' ', $string));
		$string = strip_tags($string);
		return $string;

	}

	public function IdH($v=null){ //------------ Id for Html ------------//
		$v = str_replace(['<','>'],'',$v);
		return $v;
	}

	public function In($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if($this->__t == 'eml'){

			$__c_eml = new CRM_Eml();

			$this->eml_eml = $this->eml_eml;
			$__chk_eml = $this->EmlChk([ 'eml'=>$this->eml_eml ]);

			if($__chk_eml->e == 'ok'){

				$rsp['e'] = 'ok';
				$rsp['id'] = $__chk_eml->id;
				$rsp['enc'] = $__chk_eml->enc;

				if(!isN($this->eml_avtr)){

					$this->Upd_Eml_Fld([
								't'=>'eml',
								'id'=>$__chk_eml->enc,
								'fld'=>[[
									'k'=>'eml_avtr',
									'v'=>$this->eml_avtr
								]]
							]);

				}

			}else{
				$rsp['prc'] = $__chk_eml = $this->Eml();
			}

			if($__chk_eml->e == 'ok'){

				$__chk_eml_us = $this->EmlUsChk();

				if($__chk_eml_us->e != 'ok'){
					$__chk_eml_us = $this->EmlUs();
				}

				if($__chk_eml_us->e == 'ok'){

					if($rsp['e'] != 'exist'){ $rsp['e'] = 'ok'; }

					$rsp['id'] = $__chk_eml->id;
					$rsp['enc'] = $__chk_eml->enc;
				}
			}

		}elseif($this->__t == 'eml_box'){

			$__chk_emlbox = $this->EmlBoxChk([ 'eml'=>$this->emlbox_eml, 'id'=>$this->emlbox_id ]);

			if(!isN($this->emlbox_parent)){
				$__prnt = $this->EmlBoxChk([ 'eml'=>$this->emlbox_eml, 'id'=>$this->emlbox_parent ]);
				if(!isN($__prnt) && !isN($__prnt->id)){ $this->emlbox_parent_id=$__prnt->id; }else{ $this->emlbox_parent_id=NULL; }
			}

			if($__chk_emlbox->e == 'ok'){
				if($__chk_emlbox->id != NULL){
					$this->emlbox_id_upd = $__chk_emlbox->id;
					$__chk_upd = $this->EmlBox([ 't'=>'upd' ]);
				}
			}else{
				$rsp['in'] = 'ok';
				$__chk_emlbox = $this->EmlBox();
			}

			if($__chk_emlbox->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['prc'] = $__chk_emlbox;
				$rsp['id'] = $__chk_emlbox->id;
				$rsp['enc'] = $__chk_emlbox->enc;
				$rsp['upd'] = 'ok';
			}else{
				$rsp['w'] = $__chk_emlbox->w;
			}

		}elseif($this->__t == 'eml_cnv'){


			//--------------- IN CONVERSATION - START  ---------------//

				$__chk_emlcnv = $this->EmlCnvChk([ 'id'=>enCad($this->emlcnv_id), 'eml'=>$this->emlcnv_eml ]);
				$this->emlcnv_id_upd = NULL;
				$rsp['cnv_e']=0;
				//print_r($__chk_emlcnv);

				if($__chk_emlcnv->e == 'ok' && !isN($__chk_emlcnv->id)){
					if(!isN($__chk_emlcnv->id)){
						$this->emlcnv_id_upd = $__chk_emlcnv->id;
						$__chk_upd = $this->EmlCnv(['t'=>'upd']);
					}
				}else{
					$__emlcnv_in = $this->EmlCnv();
					if($__emlcnv_in->e == 'ok'){
						$__chk_emlcnv = $this->EmlCnvChk([ 'id'=>enCad($this->emlcnv_id), 'eml'=>$this->emlcnv_eml ]);
					}
				}

			//--------------- EXISTS NOW - START  ---------------//

				if(($__chk_emlcnv->e == 'ok' && !isN($__chk_emlcnv->id)) || $__chk_upd->e == 'ok'){

					$__cnv_rlt = 'ok';

					if(!isN($__chk_emlcnv->id) && !isN($this->emlmsg__msg)){

						$rsp['cnv'][] = $_cnv = $this->EmlCnvMsgIn([ 'cnv'=>$__chk_emlcnv->id, 'msg'=>$this->emlmsg__msg ]);
						if($_cnv->e!='ok'){ $__cnv_rlt='no'; $rsp['w'][] = $_cnv; }else{ $rsp['cnv_e']++; }

						//--------------- EXISTS GROUP OF MESSAGES IN SAME CONVERSATIO ---------------//

						if(!isN($this->emlmsg__mtch)){
							foreach($this->emlmsg__mtch as $_mtch_k=>$_mtch_v){
								if(!isN($_mtch_v)){
									$rsp['cnv'][] = $_cnv = $this->EmlCnvMsgIn([ 'cnv'=>$__chk_emlcnv->id, 'msg'=>$_mtch_v ]);
									if($_cnv->e!='ok'){ $__cnv_rlt='no'; $rsp['w'][] = $_cnv; }else{ $rsp['cnv_e']++; }
								}
							}
						}

					}

					if($__cnv_rlt == 'ok'){
						$rsp['e'] = 'ok';
						$rsp['id'] = $__chk_emlcnv->id;
						$rsp['enc'] = $__chk_emlcnv->enc;
						if($__chk_upd->e == 'ok'){ $rsp['upd'] = 'ok'; }
					}else{
						$rsp['w'][] = 'Problem on related conversation and message';
					}

				}else{

					if(!isN($__chk_upd->w)){ $rsp['w']['__chk_upd'] = $__chk_upd->w; }
					if(!isN($__emlcnv_in->w)){ $rsp['w']['__emlcnv_in'] = $__emlcnv_in->w; }
					if(!isN($__emlcnv_in->w) || !isN($__emlcnv_in->w)){ $rsp['w']['__chk_emlcnv'] = $__chk_emlcnv; }

				}


			//--------------- IN CONVERSATION - END  ---------------//

				$__cnx->c_p->autocommit(TRUE);

		}elseif($this->__t == 'eml_msg'){


				$__cnx->c_p->autocommit(FALSE);
				$this->emlmsg_bdy_sve = NULL;
				$this->emlmsg_bdy_snpt = NULL;

			//--------------- IN MESSAGE - START  ---------------//

				if(!isN($this->emlmsg_enc)){

					$__chk_emlmsg = $this->EmlMsgChk([
						'enc'=>$this->emlmsg_enc
					]);

				}else{

					$__chk_emlmsg = $this->EmlMsgChk([
							'cid'=>$this->emlmsg_id,
							'eml'=>$this->emlmsg_eml,
							'inp'=>$this->emlmsg_inp
					]);

				}

				//$rsp['chk1'][] = $__chk_emlmsg;

				if($__chk_emlmsg->e == 'ok'){

					$rsp['exst'] = 'ok';

					if(!isN($__chk_emlmsg->id)){

						if($__chk_emlmsg->bdy->sve != 'ok' && !isN( $__chk_emlmsg->enc ) && ( !isN($this->emlmsg_bdy_html) || !isN($this->emlmsg_bdy_plain) )){

							if(!isN( $this->emlmsg_bdy_html ) || !isN( $this->emlmsg_bdy_plain )){

								$_prc_sve_s3='ok';

								if(!isN( $this->emlmsg_bdy_html )){
									$rsp['s3'] = $_s3_html = $this->_aws->_s3_put([ 'b'=>'eml', 'fle'=>'message/html/'.$__chk_emlmsg->enc.'.html', 'cbdy'=>$this->emlmsg_bdy_html, 'ctp'=>'text/html' ]);
									if($_s3_html->e != 'ok'){ $_prc_sve_s3='no'; }
								}

								if(!isN( $this->emlmsg_bdy_plain )){
									$rsp['s3'] = $_s3_plain = $this->_aws->_s3_put([ 'b'=>'eml', 'fle'=>'message/plain/'.$__chk_emlmsg->enc.'.html', 'cbdy'=>$this->emlmsg_bdy_plain, 'ctp'=>'text/plain' ]);
									if($_s3_plain->e != 'ok'){ $_prc_sve_s3='no'; }
								}

								if($_prc_sve_s3 == 'ok'){
									$this->emlmsg_bdy_sve = 1;
									$this->emlmsg_bdy_snpt = compress_code( $this->html_clr($this->emlmsg_bdy_html) );
								}else{
									$this->w[] = $_s3->w;
								}

							}else{

								$this->emlmsg_bdy_sve = 1;

							}

						}

						$this->emlmsg_id_upd = $__chk_emlmsg->id;
						$__chk_upd = $this->EmlMsg([ 't'=>'upd', 'box'=>$p['box'] ]);

						if($__chk_upd->e != 'ok'){
							$rsp['upd'] = $__chk_upd;
							$rsp['w'][] = 'EmlMsg Update:'.print_r($__chk_upd, true);
						}else{
							$rsp['upd'] = $__chk_upd;
						}

					}else{

						$rsp['w'][] = 'Exists but cant take id';

					}

				}else{

					$__emlmsg_in = $this->EmlMsg();

					if($__emlmsg_in->e == 'ok'){

						$__chk_emlmsg = $this->EmlMsgChk([ 'cid'=>$this->emlmsg_id, 'eml'=>$this->emlmsg_eml, 'inp'=>$this->emlmsg_inp ]);

						if(!isN( $this->emlmsg_bdy_html ) || !isN( $this->emlmsg_bdy_plain )){

							$_prc_sve_s3='ok';

							if(!isN($this->emlmsg_bdy_html)){
								$_s3_html = $this->_aws->_s3_put([ 'b'=>'eml', 'fle'=>'message/html/'.$__emlmsg_in->enc.'.html', 'cbdy'=>$this->emlmsg_bdy_html, 'ctp'=>'text/html' ]);
								if($_s3_html->e != 'ok'){ $_prc_sve_s3='no'; }
							}

							if(!isN( $this->emlmsg_bdy_plain )){
								$rsp['s3'] = $_s3_plain = $this->_aws->_s3_put([ 'b'=>'eml', 'fle'=>'message/plain/'.$__emlmsg_in->enc.'.html', 'cbdy'=>$this->emlmsg_bdy_plain, 'ctp'=>'text/plain' ]);
								if($_s3_plain->e != 'ok'){ $_prc_sve_s3='no'; }
							}


							if($_prc_sve_s3 == 'ok'){

								$this->emlmsg_bdy_sve = 1;
								$__chk_upd = $this->EmlMsg(['t'=>'upd']);

								if($__chk_upd->e != 'ok'){
									$rsp['w'][] =	$__emlmsg_in->w;
								}
							}

						}else{

							$this->emlmsg_bdy_sve = 1;

						}

					}else{

						$rsp['w'][] = '$__emlmsg_in:'.print_r($__emlmsg_in, true);
						$rsp['w'][] = '$__chk_emlmsg:'.print_r($__chk_emlmsg, true);

					}

				}


			//--------------- EXISTS NOW - START  ---------------//


				if(($__chk_emlmsg->e == 'ok' && isN($__chk_upd)) || (!isN($__chk_upd) && $__chk_upd->e == 'ok')){

					if(!isN($this->emlmsg__cnv)){
						$_cnv = $this->EmlCnvMsgIn([ 'cnv'=>$this->emlmsg__cnv, 'msg'=>$__chk_emlmsg->id ]);
						$rsp['cnv'] = $_cnv;
					}

					$rsp['e'] = 'ok';
					$rsp['prc'] = $__chk_emlmsg;
					$rsp['id'] = $__chk_emlmsg->id;
					$rsp['enc'] = $__chk_emlmsg->enc;
					$rsp['upd'] = 'ok';

				}else{

					if(!isN($__chk_emlmsg->w)){
						$rsp['w'][] = $__chk_emlmsg->w;
					}elseif(!isN($__chk_upd->w)){
						$rsp['w'][] = $__chk_upd->w;
					}else{
						$rsp['w'][] =	'No inserted or updated';
					}

				}

			//--------------- IN MESSAGE - END  ---------------//


				$__cnx->c_p->autocommit(TRUE);


		}elseif($this->__t == 'eml_msg_attch'){

			//--------------- IN CONVERSATION - START  ---------------//

				$__chk_emlmsg = $this->EmlMsgChk(['id'=>$this->emlmsgattch_emlmsg ]);
				$__chk_emlattch = $this->EmlMsgAttchChk([ 'nm'=>$this->emlmsgattch_name, 'cid'=>$this->emlmsgattch_cid, 'msg'=>$this->emlmsgattch_emlmsg ]);

				//print_r($__chk_emlattch);

				if($__chk_emlattch->e == 'ok'){
					if(!isN($__chk_emlattch->id)){
						$this->emlattch_id_upd = $__chk_emlattch->id;
						$__chk_upd = $this->EmlMsgAttch(['t'=>'upd']); $rsp['q'] = $__chk_upd->q;
						if($__chk_upd->e != 'ok'){ $rsp['w']['upd'] = $__chk_upd; }
					}
				}else{
					$__emlattch_in = $this->EmlMsgAttch(); $rsp['q'] = $__emlattch_in->q;
					if($__emlattch_in->e == 'ok'){
						$__chk_emlattch = $this->EmlMsgAttchChk([ 'nm'=>$this->emlmsgattch_name, 'cid'=>$this->emlmsgattch_cid, 'msg'=>$this->emlmsgattch_emlmsg ]);
					}else{
						$rsp['w']['in'] = $__emlattch_in;
					}
				}

			//--------------- EXISTS NOW - START  ---------------//

				if($__chk_emlattch->e == 'ok' || $__chk_upd->e == 'ok'){

					if($__chk_emlmsg->attch->sve != 'ok' && !isN($__chk_emlattch->fle) && !isN($this->emlmsgattch_fle)){

						$_s3 = $this->_aws->_s3_put([ 'b'=>'eml', 'fle'=>'attach/'.$__chk_emlattch->fle, 'cbdy'=>$this->emlmsgattch_fle, 'ctp'=>$this->emlmsgattch_type ]);

						if($_s3->e == 'ok'){
							$rsp['e'] = 'ok';
						}else{
							$rsp['w']['s3'] = $_s3;
							//print_r( $_s3 );
						}

					}

				}else{

					$rsp['w']['chk'] = 'No processed';

				}


			//--------------- IN CONVERSATION - END  ---------------//


		}else{

			$rsp['w'] =	'No $this->__t send';

		}

		if(!isN($this->w)){ $rsp['w'] = $this->w; }

		return _jEnc($rsp);

	}



}




function GtUsEmlDt($Id, $Tp=NULL, $p=NULL){

	global $__cnx;


	if(($Id!='')){

		if($Tp == 'enc'){
			$__f = 'eml_enc'; $__ft = 'text';
		}elseif($Tp == 'lst'){
			$__f = 'useml_us'; $__ft = 'int'; $__ord = ' ORDER BY id_useml DESC';
		}else{
			$__f = 'id_useml'; $__ft = 'int';
		}

		if($p['cl'] != NULL){ $__fl .= sprintf(' AND cl_enc = %s', GtSQLVlStr($p['cl'], 'text')); }

		$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

		$query_DtRg = sprintf('SELECT *,
									  (SELECT emlbox_enc FROM '._BdStr(DBT).TB_THRD_EML_BOX.' WHERE emlbox_eml = id_eml AND emlbox_id="INBOX" LIMIT 1) AS __box,
									  '._QrySisSlcF().',
									  AES_DECRYPT(eml_pss, \''.ENCRYPT_PASSPHRASE.'\') AS __pss
							   FROM '._BdStr(DBM).TB_US_EML.'
							   		INNER JOIN '._BdStr(DBM).TB_CL.' ON useml_cl = id_cl
							   		INNER JOIN '._BdStr(DBT).MDL_THRD_EML_BD.' ON useml_eml = id_eml
							   		INNER JOIN '._BdStr(DBM).TB_SIS_SLC.' ON eml_tp = id_sisslc
							   		RIGHT JOIN '._BdStr(DBT).TB_THRD_EML_ATTR.' ON emlattr_id = id_eml

							   WHERE '.$__f.' = %s '.$__fl.' '.$__ord.' LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$___col = CG_Array([ 'f'=>$row_DtRg['___fld'], 'k'=>'key' ]);

				$Vl['e'] = "ok";
				$Vl['id'] = $row_DtRg['id_useml'];

				$Vl['eml']['id'] = ctjTx($row_DtRg['id_eml'],'in');
				$Vl['eml']['eml'] = ctjTx($row_DtRg['eml_eml'],'in');
				$Vl['eml']['enc'] = ctjTx($row_DtRg['eml_enc'],'in');

				$Vl['eml']['box_dflt']['enc'] = ctjTx($row_DtRg['__box'],'in');

				$Vl['tp']['id'] = ctjTx($row_DtRg['eml_tp'],'in');
				$Vl['tp']['key'] = $___col->key->vl;

				$Vl['srv'] = ctjTx($row_DtRg['eml_srv'],'in');
				$Vl['prt'] = ctjTx($row_DtRg['eml_prt'],'in');
				$Vl['user'] = ctjTx($row_DtRg['eml_usr'],'in');

				if($p['pss']=='ok'){ $Vl['pass'] = ctjTx($row_DtRg['__pss'],'in'); }

				$Vl['attr'] = GtEmlAttrLs([ 'eml'=>$row_DtRg['id_eml'] ]);


			}else{
				$Vl['e'] = "no";
				$Vl['w'] = $__cnx->c_r->error;
			}
		}

		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);
	}

}




?>
