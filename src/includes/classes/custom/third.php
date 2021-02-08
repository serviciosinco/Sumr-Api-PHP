<?php

// Arreglar todas las auditorias ->Camilo

class CRM_Thrd {

    function __construct($p=NULL) {

		global $__cnx;
		global $__argv;

        if(!isN($p['cl'])){
			$this->cl = $p['cl'];
		}

		$this->crm_aud = new CRM_Aud();
		$this->_aws = new API_CRM_Aws();
		$this->_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);

    }

	function __destruct() {

   	}

   	public function _Tme($t=NULL,$p=NULL){
	   	if(!isN($t)){
			//echo '$t:'; print_r( $t );
			try {
				if($p['lcl']=='ok'){
					$dt = new DateTime($t);
				}else{
					$dt = new DateTime($t, new DateTimeZone('UTC'));
					$dt->setTimezone(new DateTimeZone('America/Bogota'));
				}
				return $dt->format('Y-m-d H:i:s.u');
			} catch (Exception $e) {
				echo 'Get $t:'; print_r( $t );
				print_r( $e );
			}
		}
    }

    function _gtStrBtw($s,$start,$end){
	    $i = strpos($s,$start);
		$j = strpos($s,$end,$i);
		return $i===false||$j===false? false: substr(substr($s,$i,$j-$i),strlen($start));
	}


    public function _Scl(){
   		if($this->__t != 'acc'){
   			$dt = __LsDt(['k'=>'api_thrd','tp'=>'enc','id'=>$this->scl]);
   		}
   		if(!isN($this->cl)){ $cl = GtClDt($this->cl, 'enc'); $this->cl_id = $cl->id; }
   		if(!isN($dt->d->id)){ $this->scl_rds_id = $dt->d->id; }

		if($this->scl_rds_id == _CId('ID_APITHRD_FB')){
			$this->_Fb_Prfl();
		} // Perfil de Facebook

		return _jEnc($rsp);
    }

    public function PostChk($p=NULL){

	    global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['sclacc'])){ $__f .= sprintf(' AND sclaccpost_sclacc= %s ', GtSQLVlStr($p['sclacc'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclaccpost_id= %s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_POST.' WHERE id_sclaccpost != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccpost'];
					$Vl['enc'] = $row_DtRg['sclaccpost_enc'];
				}
			}
			$__cnx->_clsr($DtRg);
		}

		return(_jEnc($Vl));

	}

	public function PostCmnChk($p=NULL){

		global $__cnx;

		if(!isN($p)){
			$Vl['e'] = 'no';
			if(!isN($p['sclaccpost'])){ $__f .= sprintf(' AND sclaccpostcmn_sclaccpost= %s ', GtSQLVlStr($p['sclaccpost'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclaccpostcmn_id= %s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_POST_CMN.' WHERE id_sclaccpostcmn != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccpostcmn'];
					$Vl['enc'] = $row_DtRg['sclaccpostcmn_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function PostRctChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['sclaccpost'])){ $__f .= sprintf(' AND sclaccpostrct_sclaccpost= %s ', GtSQLVlStr($p['sclaccpost'], 'text')); }
			if(!isN($p['from'])){ $__f .= sprintf(' AND sclaccpostrct_from= %s ', GtSQLVlStr($p['from'], 'text')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_POST_RCT.' WHERE id_sclaccpostrct != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccpostrct'];
					$Vl['enc'] = $row_DtRg['sclaccpostrct_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

   	public function SclChk($p=NULL){

	   	global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';
			if(!isN($p['rds'])){ $__f .= sprintf(' AND scl_rds= %s ', GtSQLVlStr($p['rds'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND scl_id= %s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL.' WHERE id_scl != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_scl'];
					$Vl['enc'] = $row_DtRg['scl_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}
	}

	public function AccChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';
			if(!isN($p['rds'])){ $__f .= sprintf(' AND sclacc_rds=%s ', GtSQLVlStr($p['rds'], 'int')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclacc_id=%s ', GtSQLVlStr($p['id'], 'text')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL_ACC.' WHERE id_sclacc != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclacc'];
					$Vl['enc'] = $row_DtRg['sclacc_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}
	}


	public function AccSclChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['acc'])){ $__f .= sprintf(' AND sclaccscl_acc= %s ', GtSQLVlStr($p['acc'], 'text')); }
			if(!isN($p['scl'])){ $__f .= sprintf(' AND sclaccscl_scl= %s ', GtSQLVlStr($p['scl'], 'text')); }

			$query_DtRg = '	SELECT id_sclaccscl, sclaccscl_enc FROM '._BdStr(DBT).TB_SCL_ACC_SCL.' WHERE id_sclaccscl != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);
			$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccscl'];
					$Vl['enc'] = $row_DtRg['sclaccscl_enc'];
				}
			}else{
				$Vl['w'] = $__cnx->c_r->error.' on '.compress_code($query_DtRg);
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}
	}

    public function FromChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['id'])){ $__f .= sprintf(' AND sclfrom_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclfrom_enc= %s ', GtSQLVlStr($p['enc'], 'text')); }
			if(!isN($p['rds'])){ $__f .= sprintf(' AND sclfrom_rds= %s ', GtSQLVlStr($p['rds'], 'int')); }

			$query_DtRg = '	SELECT * FROM '._BdStr(DBT).TB_SCL_FROM.' WHERE id_sclfrom != "" '.$__f;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclfrom'];
					$Vl['enc'] = $row_DtRg['sclfrom_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

    public function SclCnvChk($p=NULL){

	    global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclacccnv_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if(!isN($p['sclacc'])){ $__f .= sprintf(' AND sclacccnv_sclacc= %s ', GtSQLVlStr($p['sclacc'], 'text')); }

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
			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}
	}

	public function MsgChk($p){

		global $__cnx;

		if(!isN($p)){
			$Vl['e'] = 'no';
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclacccnvmsg_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if(!isN($p['cnv'])){ $__f .= sprintf(' AND sclacccnvmsg_sclacccnv= %s ', GtSQLVlStr($p['cnv'], 'text')); }

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
			return _jEnc($Vl);
		}
	}

	public function FormChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$cl = GtClDt(CL_ENC, 'enc');
			$Vl['e'] = 'no';
			if(!isN($p['sclacc'])){ $__f .= sprintf(' AND sclaccform_sclacc= %s ', GtSQLVlStr($p['sclacc'], 'text')); }
			if(!isN($p['id'])){ $__f .= sprintf(' AND sclaccform_id= %s ', GtSQLVlStr($p['id'], 'text')); }
			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclaccform_enc = %s ', GtSQLVlStr($p['enc'], 'text')); }

			$query_DtRg = '	SELECT *
							FROM '._BdStr(DBT).TB_SCL_ACC_FORM.'
							WHERE id_sclaccform != "" '.$__f;

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccform'];
					$Vl['enc'] = $row_DtRg['sclaccform_enc'];
					$Vl['nm'] = $row_DtRg['sclaccform_name'];
					$Vl['mdl'] = $row_DtRg['sclaccform_mdl'];

					$__est = __LsDt(['k'=>'sis_est']);
					$Vl['est'] = $row_DtRg['sclaccform_est'];
					$Vl['est_tt'] = $__est->ls->sis_est->{$row_DtRg['sclaccform_est']}->tt;
					$Vl['est_dt'] = $__est->ls->sis_est->{$row_DtRg['sclaccform_est']};


					$GtActDt = GtMdlDt([ "id"=>$row_DtRg['sclaccform_mdl'], 'bd'=>$this->cl->bd ]);
					$Vl['mdl_dt'] = $GtActDt;

					$___plcydt = GtClPlcyDt([ 'id'=>$row_DtRg['sclaccform_plcy'] ]);
					$Vl['plcy_dt'] = $___plcydt;

					$___mddt = GtSisMdDt([ 'id'=>$row_DtRg['sclaccform_md'] ]);
					$Vl['md_dt'] = $___mddt;

					$Vl['mdl_nm'] = $row_DtRg['mdl_nm'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}


	public function FormLeadDwnChk($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$cl = GtClDt(CL_ENC, 'enc');

			$Vl['e'] = 'no';
			if(!isN($p['cid'])){ $__f .= sprintf(' AND sclaccformleads_id= %s ', GtSQLVlStr($p['cid'], 'text')); }
			if(!isN($p['form'])){ $__f .= sprintf(' AND sclaccformleads_form= %s ', GtSQLVlStr($p['form'], 'text')); }
			if(!isN($p['enc'])){ $__f .= sprintf(' AND sclaccformleads_enc = %s ', GtSQLVlStr($p['enc'], 'text')); }

			$query_DtRg = '	SELECT id_sclaccformleads, sclaccformleads_enc, sclaccformleads_id
							FROM '._BdStr(DBT).TB_SCL_ACC_FORM_LEADS.'
							WHERE id_sclaccformleads != "" '.$__f; //echo $query_DtRg.PHP_EOL;

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_sclaccformleads'];
					$Vl['enc'] = $row_DtRg['sclaccformleads_enc'];
					$Vl['nm'] = $row_DtRg['sclaccformleads_id'];
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}


	public function UpdF($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($p)){

			if($p['t']=='us'){ $tb=TB_SCL_FROM; $fld=$p['f']; $id='id_sclfrom'; }
			elseif($p['t']=='cnv'){ $tb=TB_SCL_ACC_CNV; $fld=$p['f']; $id='id_sclacccnv'; }
			elseif($p['t']=='acc'){ $tb=TB_SCL_ACC; $fld=$p['f']; $id='id_sclacc'; }
			elseif($p['t']=='scl'){ $tb=TB_SCL; $fld=$p['f']; $id='id_scl'; }
			elseif($p['t']=='from'){ $tb=TB_SCL_FROM; $fld=$p['f']; $id='id_sclfrom'; }

			if(!isN($tb)){
				$updateSQL = sprintf("UPDATE "._BdStr(DBT).$tb." SET ".$fld."=%s WHERE ".$id."=%s",
								   GtSQLVlStr($p['v'], "text"),
								   GtSQLVlStr($p['id'], "int"));
				$Result = $__cnx->_prc($updateSQL);

				if($Result){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = $__cnx->c_p->error; }
			}
		}

		return _jEnc($rsp);
	}

    public function UsDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['us_id'])){

			if(!isN($p['us_id'])){ $__f .= ' AND sclfrom_id='.GtSQLVlStr($p['us_id'], 'text').' '; }
			if(!isN($p['rds'])){ $__f .= ' AND sclfrom_rds='.GtSQLVlStr($p['rds'], 'int').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_SCL_FROM.' WHERE id_sclfrom != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg == 1 && $row_DtRg['sclfrom_id'] == $p['us_id']){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclfrom'];
					$Vl['nm'] = ctjTx($row_DtRg['sclfrom_nm'],'in');
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'Third - No data on P';
		}

		$rtrn = _jEnc($Vl); return($rtrn);
	}



	public function RquDt($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['tp']) && (!isN($p['acc']) || !isN($p['eml']) )){

			if($p['md'] == 'eml'){
				$_tb = TB_THRD_EML_RQU; $_prfx = 'emlrqu'; $_obj = 'eml';
			}else{
				$_tb = TB_THRD_SCL_RQU; $_prfx = 'sclrqu'; $_obj = 'acc';
			}

			if(!isN($p['tp'])){ $__f .= ' AND '.$_prfx.'_tp='.GtSQLVlStr($p['tp'], 'text').' '; }
			if(!isN($p['acc'])){ $__f .= ' AND '.$_prfx.'_'.$_obj.'='.GtSQLVlStr($p[$_obj], 'text').' '; }
			if(!isN($p['box'])){ $__f .= ' AND '.$_prfx.'_box='.GtSQLVlStr($p['box'], 'text').' '; }
			if(!isN($p['id'])){ $__f .= ' AND '.$_prfx.'_id='.GtSQLVlStr($p['id'], 'text').' '; }
			if(!isN($p['eml']) && $p['md'] == 'eml'){ $__f .= ' AND '.$_prfx.'_eml='.GtSQLVlStr($p['eml'], 'int').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).$_tb.' WHERE id_'.$_prfx.' IS NOT NULL '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_'.$_prfx];
					$Vl['nxt'] = $row_DtRg[$_prfx.'_nxt'];
					$Vl['pge'] = $row_DtRg[$_prfx.'_pge'];
					$Vl['fi'] = $row_DtRg[$_prfx.'_fi'];
					$Vl['fa'] = $row_DtRg[$_prfx.'_fa'];
					$Vl['all'] = mBln($row_DtRg[$_prfx.'_all']);
				}else{
					$Vl['w'] = 'No records on '.$query_DtRg;
				}

			}else{
				$Vl['w'] = 'RquDt:'.$__cnx->c_r->error.' on '.$query_DtRg;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}

		return(_jEnc($Vl));
	}



	public function SclRlcDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';


		if(!isN($p) && !isN($p['t'])){

			if($p['t'] == 'us'){
				if(!isN($p['us'])){ $__f .= ' AND usscl_us='.GtSQLVlStr($p['us'], 'text').' '; }
				if(!isN($p['scl'])){ $__f .= ' AND usscl_scl='.GtSQLVlStr($p['scl'], 'text').' '; }
				$query_DtRg = 'SELECT * FROM '._BdStr(DBM).TB_US_SCL.' WHERE id_usscl != "" '.$__f.' LIMIT 1';
				$prfx='usscl';
			}elseif($p['t'] == 'cl'){
				if(!isN($p['cl'])){ $__f .= ' AND clscl_cl='.GtSQLVlStr($p['cl'], 'text').' '; }
				if(!isN($p['scl'])){ $__f .= ' AND clscl_scl='.GtSQLVlStr($p['scl'], 'text').' '; }
				$query_DtRg = 'SELECT * FROM '._BdStr(DBM).TB_CL_SCL.' WHERE id_clscl != "" '.$__f.' LIMIT 1';
				$prfx='clscl';
			}

			$Vl['q'] = $query_DtRg;
			$DtRg = $__cnx->_qry($query_DtRg);


			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_'.$prfx];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}


	public function Scl_Rlc($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->scl_id_upd)){

			$__chk = $this->SclRlcDt(['t'=>$p['t'], 'us'=>$this->us, 'cl'=>$this->cl_id, 'scl'=>$this->scl_id_upd]);

			$rsp['chk'] = $__chk;

			if($__chk->e != 'ok' && isN($__chk->id)){

				if($p['t'] == 'us'){
		    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_US_SCL." (usscl_us, usscl_scl) VALUES (%s, %s)",
											GtSQLVlStr($this->us, "int"),
											GtSQLVlStr($this->scl_id_upd, "text"));
				}elseif($p['t'] == 'cl'){
		    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_SCL." (clscl_cl, clscl_scl) VALUES (%s, %s)",
											GtSQLVlStr($this->cl_id, "int"),
											GtSQLVlStr($this->scl_id_upd, "text"));
				}

				$rsp['q'] = $_sql_s;
				if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
				if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

			}else{

				$rsp['w'] = $p['t'].' - No user relation '.$this->us.' - '.$__chk->w.' - '.$__chk->q;

			}

		}else{

			$rsp['w'] = TX_FLTDTINC.' scl_id_upd';

		}

		return _jEnc($rsp);
    }
























    public function SclAttrDt($p=NULL){

	    global $__cnx;
	    $Vl['e'] = 'no';
		if(!isN($p) && !isN($p['key']) && !isN($p['scl'])){

			if(!isN($p['key'])){ $__f .= ' AND sclattr_key='.GtSQLVlStr($p['key'], 'text').' '; }
			if(!isN($p['scl'])){ $__f .= ' AND sclattr_scl='.GtSQLVlStr($p['scl'], 'int').' '; }
			if(!isN($p['tp'])){ $__f .= ' AND sclattr_tp='.GtSQLVlStr($p['tp'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_SCL_ATTR.' WHERE id_sclattr != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclattr'];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}

	public function Scl_Attr($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($this->scl_id_upd)){

		    $rsp['ls'] = $this->scl_attr;

		    if(!isN($this->scl_attr)){

			    foreach($this->scl_attr as $k=>$v){

					$__chk = $this->SclAttrDt([ 'key'=>$k, 'tp'=>$p['tp'], 'scl'=>$this->scl_id_upd ]);

					if(is_array($v)){
						$__v = json_encode($v);
					}elseif(is_object($v)){
						$__v = json_encode($v, true);
					}else{
						$__v = $v;
					}

					if($__chk->e == 'ok' && !isN($__chk->id) && !isN($__v)){

						$rsp['prc'][] = 'upd';

			    		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ATTR." SET sclattr_vl=%s WHERE sclattr_scl=%s AND sclattr_key=%s",
		                       GtSQLVlStr(ctjTx($__v,'out'), "text"),
		                       GtSQLVlStr($this->scl_id_upd, "int"),
		                       GtSQLVlStr($k, "text"));

					}elseif(!isN($this->scl_id_upd) && !isN($k) && !isN($__v)){

						$rsp['prc'][] = 'in';

			    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ATTR." (sclattr_tp, sclattr_scl, sclattr_key, sclattr_vl) VALUES (%s, %s, %s, %s)",
		                       GtSQLVlStr($p['tp'], "text"),
		                       GtSQLVlStr($this->scl_id_upd, "int"),
		                       GtSQLVlStr($k, "text"),
		                       GtSQLVlStr(ctjTx($__v,'out'), "text"));

					}

					if(!isN($_sql_s)){

						$Result_RLC = $__cnx->_prc($_sql_s);
						$rsp['q'][] = $_sql_s;
					}

					if($Result_RLC){
						$rsp['e'] = 'ok';
					}else{
						$rsp['w'] = 'No result:'.$__cnx->c_p->error;
					}

			    }
		    }

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }






















	public function Scl($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->cl_id) && !isN($this->us) && !isN($this->scl_rds_id) && !isN($this->_scl_prf)){

			if($p['t'] != 'upd'){
				$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL." (scl_rds, scl_id, scl_nm) VALUES (%s, %s, %s)",
	                       GtSQLVlStr($this->scl_rds_id, "int"),
	                       GtSQLVlStr($this->_scl_prf, "text"),
	                       GtSQLVlStr( ctjTx($this->_scl_nm,'out') , "text")
						);

			}else{
				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL." SET scl_nm=%s WHERE id_scl=%s",
									   GtSQLVlStr( ctjTx($this->_scl_nm,'out') , "text"),
									   GtSQLVlStr( $this->scl_id_upd, "int"));
			}
			//$rsp['q'] = $_sql_s;

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;
					$__enc = enCad($rsp_i.'_'.$this->us.'-'.$this->scl_rds_id.'-'.$this->_scl_prf);
					$rsp['enc'] = $__enc;
					$rsp['id'] = $rsp_i;

					$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL." SET scl_enc=%s WHERE id_scl=%s",
									   GtSQLVlStr($__enc, "text"),
									   GtSQLVlStr($rsp_i, "int"));
					$Result = $__cnx->_prc($updateSQL);

					if(!$Result){
						$rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error;
					}else{
						$this->scl_id_upd = $rsp_i;
						$rsp['rlc']['us'] = $this->Scl_Rlc(['t'=>'us']);
						$rsp['rlc']['cl'] = $this->Scl_Rlc(['t'=>'cl']);
					}


				}else{

					$rsp['id'] = $this->scl_id_upd;
					$rsp['rlc']['us'] = $this->Scl_Rlc(['t'=>'us']);
					$rsp['rlc']['cl'] = $this->Scl_Rlc(['t'=>'cl']);

				}

				$_attr = $this->Scl_Attr(['tp'=>'scl']);

				$rsp['attr'] = $_attr;

			}else{
				if(ChckSESS_superadm()){ $rsp['w'] = $__cnx->c_p->error.' - '.$_sql_s; }
			}

		}else{

			$rsp['w'] = 'No all data to process';
			$rsp['data']['cl'] = $this->cl_id;
			$rsp['data']['us'] = $this->us;
			$rsp['data']['rds'] = $this->scl_rds_id;
			$rsp['data']['prf'] = $this->_scl_prf;

		}

		return _jEnc($rsp);

    }



    public function Acc($p=NULL){

	    global $__cnx;

	    if(!isN($this->acc_scl) && !isN($this->acc_id)){

			if($p['t'] != 'upd'){

				$__enc = Enc_Rnd($this->scl_rds_id.'-'.$this->acc_id);
				$__nw_img = $__enc.'.jpg';

				$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC." (sclacc_enc, sclacc_rds, sclacc_id, sclacc_nm, sclacc_img, sclacc_cvr) VALUES (%s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->scl_rds_id, "int"),
                       GtSQLVlStr($this->acc_id, "text"),
                       GtSQLVlStr( ctjTx($this->acc_nm,'out'), "text"),
                       GtSQLVlStr($__nw_img, "text"),
					   GtSQLVlStr($__nw_img, "text"));

			}else{

				$__enc = $this->acc_id_enc;
				$__nw_img = $__enc.'.jpg';

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC." SET sclacc_img=%s, sclacc_cvr=%s, sclacc_nm=%s WHERE id_sclacc=%s",
									    GtSQLVlStr($__nw_img, "text"),
									    GtSQLVlStr($__nw_img, "text"),
									    GtSQLVlStr( ctjTx($this->acc_nm,'out'), "text"),
										GtSQLVlStr( $this->acc_id_upd, "int"));

			}

			//echo $_sql_s;
			//if($this->_sclacc_tknlvd != ''){ _NwFb_Acc_Sbsc(array('id'=>$this->acc_id, 'access_token'=>$this->_sclacc_tknlvd)); }
			if(!isN($_sql_s)){

				$Result_RLC = $__cnx->_prc($_sql_s);

				if(!isN($__enc)){

					$imageContent = file_get_contents($this->acc_img);
					$myme = exif_imagetype($this->acc_img);
					$result_sve = $this->_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_SCL_ACC.$___nw_nme), 'cbdy'=>$imageContent, 'ctp'=>$myme ]);

					$imageContent_cover = file_get_contents($this->acc_cvr);
					$myme_cover = exif_imagetype($this->acc_cvr);
					$result_sve_cover = $this->_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_SCL_ACC_CVR.$___nw_nme), 'cbdy'=>$imageContent_cover, 'ctp'=>$myme_cover ]);

				}

			}

			//$rsp['q'] = $_sql_s;

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;
					$this->acc_id_upd = $rsp_i;

					$__enc = enCad($rsp_i.'_'.$this->acc_id.'-'.$this->scl);
					$rsp['enc'] = $__enc;
					$rsp['id'] = $rsp_i;

				}else{

					$rsp['id'] = $this->acc_id_upd;

				}

				$__acc_scl = $this->AccScl();

				if($__acc_scl->e == 'ok'){
					$rsp['e'] = 'no';
					$rsp['w'] = $__acc_scl->w;
				}

			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}


		}

		return _jEnc($rsp);

    }


    public function AccScl($p=NULL){

	    global $__cnx;

	    if(!isN($this->acc_scl) && !isN($this->acc_id)){

			$__dt = $this->AccSclChk([
							'acc'=>!isN($this->acc_id_upd)?$this->acc_id_upd:$this->acc_id,
							'scl'=>$this->acc_scl
						]);

			//if(!isN($this->acc_id)){ echo '$this->acc_id:'.$this->acc_id; }
			//if(!isN($this->acc_id_upd)){ echo '$this->acc_id_upd:'.$this->acc_id_upd; }

			//echo 'DT:';
			//print_r( $__dt );

			if(!isN($__dt->id)){ $this->accscl_id_upd = $__dt->id; }

			if($p['t'] != 'upd' && isN($__dt->id)){

				$__enc = enCad($rsp_i.'_'.$this->acc_scl.'-'.$this->acc_id_upd);

				$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_SCL." (sclaccscl_enc, sclaccscl_scl, sclaccscl_acc, sclaccscl_tkn, sclaccscl_perms, sclaccscl_tlvd) VALUES (%s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr($this->acc_scl, "int"),
                       GtSQLVlStr($this->acc_id_upd, "text"),
                       GtSQLVlStr($this->acc_tkn, "text"),
                       GtSQLVlStr($this->acc_perms, "text"),
					   GtSQLVlStr( ctjTx($this->_sclacc_tknlvd,'out') , "text"));

			}else{

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_SCL." SET sclaccscl_tkn=%s, sclaccscl_perms=%s, sclaccscl_tlvd=%s WHERE id_sclaccscl=%s",
										GtSQLVlStr( ctjTx($this->acc_tkn,'out') , "text"),
										GtSQLVlStr( ctjTx($this->acc_perms,'out') , "text"),
										GtSQLVlStr( ctjTx($this->_sclacc_tknlvd,'out'), "text"),
										GtSQLVlStr( $this->accscl_id_upd, "int"));
			}

			//echo $_sql_s;
			//if($this->_sclacc_tknlvd != ''){ _NwFb_Acc_Sbsc(array('id'=>$this->acc_id, 'access_token'=>$this->_sclacc_tknlvd)); }

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;
					$this->accscl_id_upd = $rsp_i;
					$rsp['enc'] = $__enc;
					$rsp['id'] = $rsp_i;

				}else{
					$rsp['id'] = $this->accscl_id_upd;
				}

			}else{

				if(!isN($__cnx->c_p->error)){ $rsp['w'] = $__cnx->c_p->error; }

			}
		}

		return _jEnc($rsp);

    }


    public function Us($p=NULL){

	    global $__cnx;

	    if(!isN($this->us_id) && !isN($this->us_nm)){

			if($p['t'] != 'upd'){

				$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_FROM." (sclfrom_id, sclfrom_nm, sclfrom_rds, sclfrom_pic) VALUES (%s, %s, %s, %s)",
	                       GtSQLVlStr($this->us_id, "text"),
	                       GtSQLVlStr(ctjTx($this->us_nm,'out'), "text"),
	                       GtSQLVlStr($this->scl_rds, "text"),
	                       GtSQLVlStr($this->us_pic, "text"));
			}else{

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_FROM." SET sclfrom_nm=%s, sclfrom_pic=%s WHERE id_sclfrom=%s LIMIT 1",
									   GtSQLVlStr(ctjTx($this->us_nm,'out'), "text"),
									   GtSQLVlStr($this->us_pic, "text"),
									   GtSQLVlStr($p['id'], "int"));

			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;

					$__enc = enCad($rsp_i.'_'.$this->us_id.'-'.$this->us_scl);
					$rsp['enc'] = $__enc;
					$rsp['id'] = $rsp_i;

					$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL_FROM." SET sclfrom_enc=%s WHERE id_sclfrom=%s LIMIT 1",
									   GtSQLVlStr($__enc, "text"),
									   GtSQLVlStr($rsp_i, "int"));

					$Result = $__cnx->_prc($updateSQL);

					if(!$Result){$rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error;  }

				}else{
					$rsp['id'] = $this->cnv_id_upd;
				}

			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);

    }

    public function UsInAll($p=NULL){

	    global $__cnx;

		if(!isN($this->msg_from_o)){ $__from_in = json_decode($this->msg_from_o); }
		elseif(!isN($this->postcmn_from_o)){ $__from_in = json_decode($this->postcmn_from_o); }
		elseif(!isN($this->postrct_from_o)){ $__from_in = json_decode($this->postrct_from_o); }

		$__chk_us = $this->FromChk(['id'=>$__from_in->id, 'rds'=>$this->scl_rds]);

		$rsp['__chk_us'] = $__chk_us;

		$this->us_id = $__from_in->id;
		$this->us_nm = $__from_in->name;


		if(!isN($__from_in->profile_image_url_https)){ $this->us_pic = $__from_in->profile_image_url_https; }

		if($__chk_us->e != 'ok'){
			$__sve = $this->Us();
			$rsp['p'] = 'i';
		}elseif($__chk_us->e == 'ok' && !isN($__chk_us->id)){
			$__sve = $this->Us(['t'=>'upd', 'id'=>$__chk_us->id]);
			$rsp['p'] = 'u';
		}

		$rsp['sql'] = $__sve;

		return _jEnc($rsp);
    }


    public function SclCnv($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->cnv_acc) && !isN($this->cnv_from) && (!isN($this->cnv_id) || !isN($this->cnv_id_upd))){

			$__dt_us = $this->UsDt(['us_id'=>$this->cnv_from, 'rds'=>$this->scl_rds]);

			if($__dt_us->e == 'ok' && !isN($__dt_us->id)){

				if($p['t'] != 'upd'){

					$__enc = enCad($rsp_i.'_'.$this->cnv_acc.'-'.$this->cnv_id);

		    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_CNV." (sclacccnv_enc, sclacccnv_sclacc, sclacccnv_from, sclacccnv_id, sclacccnv_upd, sclacccnv_unr, sclacccnv_snpt) VALUES (%s, %s, %s, %s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
	                      	GtSQLVlStr($this->cnv_acc, "int"),
	                       	GtSQLVlStr($__dt_us->id, "text"),
	                       	GtSQLVlStr($this->cnv_id, "text"),
	                       	GtSQLVlStr($this->_Tme($this->cnv_upd), "date"),
	                       	GtSQLVlStr($this->cnv_unr, "text"),
	                       	GtSQLVlStr(ctjTx($this->cnv_snpt,'out'), "text"));

				}else{

					if(!isN($this->cnv_upd)){

						$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_CNV." SET sclacccnv_sclacc=%s, sclacccnv_upd=%s, sclacccnv_unr=%s, sclacccnv_snpt=%s WHERE id_sclacccnv=%s LIMIT 1",
									GtSQLVlStr($this->cnv_acc, "int"),
									GtSQLVlStr($this->_Tme($this->cnv_upd), "date"),
									GtSQLVlStr(ctjTx($this->cnv_unr,'out'), "text"),
									GtSQLVlStr(ctjTx($this->cnv_snpt,'out'), "text"),
									GtSQLVlStr($this->cnv_id_upd, "int"));
					}

				}

				if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }


				if($Result_RLC){

					$rsp['e'] = 'ok';

					if($p['t'] != 'upd'){

						$rsp_i = $__cnx->c_p->insert_id;
						$rsp['id'] = $rsp_i;
						if(!isN($__enc)){ $rsp['enc'] = $__enc; }

					}else{
						$rsp['id'] = $this->cnv_id_upd;
					}

				}else{

					$rsp['w'] = 'No result:'.$__cnx->c_p->error;

				}

			}else{

				$rsp['w'] = 'No user id';

			}

		}else{

			$rsp['w'] = 'SclCnv:'.TX_FLTDTINC.' $this->cnv_acc:'.$this->cnv_acc.' -> $this->cnv_from:'.$this->cnv_from. ' -> $this->cnv_id:'.$this->cnv_id.' -> $this->cnv_id_upd:'.$this->cnv_id_upd;

		}

		return _jEnc($rsp);

    }



    public function SclMsg($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->chk_cnv_id) && !isN($this->msg_created) && (!isN($this->msg_id) || !isN($this->msg_id_upd))){

			$__dt_us = $this->UsDt(['us_id'=>$this->msg_from, 'rds'=>$this->scl_rds]);

			if($__dt_us->e == 'ok' && !isN($__dt_us->id)){

				if($this->msg_attach == 'null'){ $this->msg_attach = ''; }

				if($p['t'] != 'upd'){

		    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_CNV_MSG." (sclacccnvmsg_sclacccnv, sclacccnvmsg_created, sclacccnvmsg_from_o, sclacccnvmsg_from, sclacccnvmsg_id, sclacccnvmsg_message, sclacccnvmsg_sticker, sclacccnvmsg_attch, sclacccnvmsg_tags, sclacccnvmsg_q) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

		                       GtSQLVlStr( $this->chk_cnv_id , "int"),
		                       GtSQLVlStr( $this->_Tme($this->msg_created) , "date"),
		                       GtSQLVlStr( ctjTx($this->msg_from_o,'out'), "text"),
		                       GtSQLVlStr( $__dt_us->id, "int"),
		                       GtSQLVlStr( ctjTx($this->msg_id,'out'), "text"),
		                       GtSQLVlStr( ctjTx($this->msg_message,'out') , "text"),
		                       GtSQLVlStr( ctjTx($this->msg_sticker,'out') , "text"),
		                       GtSQLVlStr( $this->msg_attach , "text"),
		                       GtSQLVlStr( ctjTx($this->msg_tags,'out') , "text"),
		                       GtSQLVlStr( json_encode($this), "text"));

					$this->UpdF(['t'=>'cnv', 'f'=>'sclacccnv_est', 'id'=>$this->chk_cnv_id, 'v'=>_CId('ID_SCLCNVEST_ON') ]);

				}else{

					$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_CNV_MSG." SET sclacccnvmsg_from_o=%s, sclacccnvmsg_tags=%s, sclacccnvmsg_sticker=%s, sclacccnvmsg_attch=%s WHERE id_sclacccnvmsg=%s",
								   GtSQLVlStr(ctjTx($this->msg_from_o,'out'), "text"),
								   GtSQLVlStr(ctjTx($this->msg_tags,'out'), "text"),
								   GtSQLVlStr(ctjTx($this->msg_sticker,'out'), "text"),
								   GtSQLVlStr( ($this->msg_attach!='null'?$this->msg_attach:'') , "text"),
								   GtSQLVlStr($this->msg_id_upd, "int"));


				}

				if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }


				if($Result_RLC){

					$rsp['e'] = 'ok';

					if($p['t'] != 'upd'){

						$rsp['e'] = 'ok';
						$rsp_i = $__cnx->c_p->insert_id;
						$rsp['id'] = $rsp_i;
						$__enc = enCad($rsp_i.'_'.$this->msg_id.'-'.$this->msg_cnv);
						$rsp['enc'] = $__enc;
						$rsp['in'] = 'ok';

						$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_CNV_MSG." SET sclacccnvmsg_enc=%s WHERE id_sclacccnvmsg=%s",
										   GtSQLVlStr($__enc, "text"),
										   GtSQLVlStr($rsp_i, "int"));

						$Result = $__cnx->_prc($updateSQL);

						if(!$Result){ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }

					}else{
						$rsp['id'] = $this->cnv_id_upd;
					}

				}else{

					$rsp['w'] = 'No result:'.$__cnx->c_p->error;

				}

			}

		}else{

			$rsp['w'] = 'SclMsg:'.TX_FLTDTINC.'$this->cnv_acc:'.$this->cnv_acc.' -> $this->cnv_from:'.$this->cnv_from. ' -> $this->cnv_id:'.$this->cnv_id.' -> $this->cnv_id_upd:'.$this->cnv_id_upd;

		}

		return _jEnc($rsp);

    }



	public function SclPost($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->post_acc) && $this->post_acc_id && $this->post_created_time){

			if($this->post_attach == 'null'){ $this->post_attach = ''; }

			if($p['t'] != 'upd'){

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_POST." (sclaccpost_sclacc, sclaccpost_created_time, sclaccpost_message, sclaccpost_link, sclaccpost_name, sclaccpost_id, sclaccpost_caption, sclaccpost_full_picture, sclaccpost_icon, sclaccpost_c_shares, sclaccpost_c_comments, sclaccpost_c_reacts, sclaccpost_picture, sclaccpost_type, sclaccpost_attch) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($this->post_acc, "int"),
                       GtSQLVlStr($this->_Tme($this->post_created_time) , "date"),
                       GtSQLVlStr(ctjTx($this->post_message,'out'), "text"),
                       GtSQLVlStr(ctjTx($this->post_link,'out'), "text"),
                       GtSQLVlStr(ctjTx($this->post_name,'out'), "text"),
                       GtSQLVlStr($this->post_id, "text"),
                       GtSQLVlStr(ctjTx($this->post_caption,'out'), "text"),
                       GtSQLVlStr($this->post_full_picture, "text"),
                       GtSQLVlStr($this->post_icon, "text"),
                       GtSQLVlStr($this->post_c_shares, "text"),
                       GtSQLVlStr($this->post_c_comments, "text"),
                       GtSQLVlStr($this->post_c_reacts, "text"),
                       GtSQLVlStr($this->post_picture, "text"),
                       GtSQLVlStr($this->post_type, "text"),
                       GtSQLVlStr($this->post_attach , "text"));

			}else{

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_POST." SET sclaccpost_created_time=%s, sclaccpost_message=%s, sclaccpost_link=%s, sclaccpost_name=%s, sclaccpost_caption=%s, sclaccpost_full_picture=%s, sclaccpost_icon=%s, sclaccpost_c_shares=%s, sclaccpost_c_comments=%s, sclaccpost_c_reacts=%s, sclaccpost_picture=%s, sclaccpost_type=%s, sclaccpost_attch=%s WHERE id_sclaccpost=%s",
		                       GtSQLVlStr($this->_Tme($this->post_created_time), "text"),
		                       GtSQLVlStr(ctjTx($this->post_message,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->post_link,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->post_name,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->post_caption,'out'), "text"),
		                       GtSQLVlStr($this->post_full_picture, "text"),
		                       GtSQLVlStr($this->post_icon, "text"),
		                       GtSQLVlStr($this->post_c_shares, "text"),
		                       GtSQLVlStr($this->post_c_comments, "text"),
		                       GtSQLVlStr($this->post_c_reacts, "text"),
		                       GtSQLVlStr($this->post_picture, "text"),
		                       GtSQLVlStr($this->post_type, "text"),
		                       GtSQLVlStr($this->post_attach , "text"),
							   GtSQLVlStr($this->post_id_upd, "int"));
			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;
					$rsp['id'] = $rsp_i;
					$__enc = enCad($rsp_i.'_'.$this->post_acc.'-'.$this->post_id);
					$rsp['enc'] = $__enc;

					$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_POST." SET sclaccpost_enc=%s WHERE id_sclaccpost=%s",
									   GtSQLVlStr($__enc, "text"),
									   GtSQLVlStr($rsp_i, "int"));
					$Result = $__cnx->_prc($updateSQL);

					if(!$Result){ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }

				}else{
					$rsp['id'] = $this->cnv_id_upd;
				}
			}else{
				$rsp['w'] = 'No result:'.$__cnx->c_p->error;
			}
		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }



    public function PostCmn($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->postcmn_post) && isN($this->postcmn_id) && isN($this->postcmn_created_time)){

			if($this->postcmn_attach == 'null'){ $this->postcmn_attach = ''; }
			$__dt_us = $this->UsDt(['us_id'=>$this->postcmn_from, 'rds'=>$this->scl_rds]);

			if($p['t'] != 'upd'){

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_POST_CMN." (sclaccpostcmn_sclaccpost, sclaccpostcmn_from, sclaccpostcmn_created_time, sclaccpostcmn_message, sclaccpostcmn_id, sclaccpostcmn_tags, sclaccpostcmn_attch) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($this->postcmn_post, "int"),
                       GtSQLVlStr( $__dt_us->id, "int"),
                       GtSQLVlStr($this->_Tme($this->postcmn_created_time) , "date"),
                       GtSQLVlStr(ctjTx($this->postcmn_message,'out'), "text"),
                       GtSQLVlStr($this->postcmn_id, "text"),
                       GtSQLVlStr(ctjTx($this->postcmn_message_tags,'out'), "text"),
                       GtSQLVlStr($this->postcmn_attach , "text"));

			}else{

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_POST_CMN." SET sclaccpostcmn_tags=%s, sclaccpostcmn_attch=%s WHERE id_sclaccpostcmn=%s",
		                       GtSQLVlStr(ctjTx($this->postcmn_message_tags,'out'), "text"),
		                       GtSQLVlStr($this->postcmn_attach , "text"),
							   GtSQLVlStr($this->postcmn_id_upd, "int"));
			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;
					$rsp['id'] = $rsp_i;
					$__enc = enCad($rsp_i.'_'.$this->postcmn_post.'-'.$this->postcmn_id);
					$rsp['enc'] = $__enc;

					$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_POST_CMN." SET sclaccpostcmn_enc=%s WHERE id_sclaccpostcmn=%s",
									   GtSQLVlStr($__enc, "text"),
									   GtSQLVlStr($rsp_i, "int"));
					$Result = $__cnx->_prc($updateSQL);

					if(!$Result){ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }

				}else{
					$rsp['id'] = $this->cnv_id_upd;
				}
			}else{
				$rsp['w'] = 'No result:'.$__cnx->c_p->error;
			}
		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }



    public function PostRct($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->postrct_post) && !isN($this->postrct_type)){

			$__dt_us = $this->UsDt(['us_id'=>$this->postrct_from, 'rds'=>$this->scl_rds ]);

			if($p['t'] != 'upd'){

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_POST_RCT." (sclaccpostrct_sclaccpost, sclaccpostrct_from, sclaccpostrct_type, sclaccpostrct_created) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($this->postrct_post, "int"),
                       GtSQLVlStr( $__dt_us->id, "int"),
                       GtSQLVlStr(ctjTx($this->postrct_type,'out'), "text"),
                       GtSQLVlStr($this->_Tme($this->postrct_created), "date"));
			}else{
				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_POST_RCT." SET sclaccpostrct_type=%s, sclaccpostrct_created=%s WHERE id_sclaccpostrct=%s",
		                       GtSQLVlStr(ctjTx($this->postrct_type,'out'), "text"),
		                       GtSQLVlStr($this->_Tme($this->postrct_created), "date"),
							   GtSQLVlStr($this->postrct_id_upd, "int"));
			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';

				if($p['t'] != 'upd'){

					$rsp_i = $__cnx->c_p->insert_id;
					$rsp['id'] = $rsp_i;
					$__enc = enCad($rsp_i.'_'.$this->postrct_post.'-'.$__dt_us->id);
					$rsp['enc'] = $__enc;

					$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_POST_RCT." SET sclaccpostrct_enc=%s WHERE id_sclaccpostrct=%s",
									   GtSQLVlStr($__enc, "text"),
									   GtSQLVlStr($rsp_i, "int"));
					$Result = $__cnx->_prc($updateSQL);

					if(!$Result){ $rsp['e'] = 'no'; $rsp['w'] = $__cnx->c_p->error; }

				}else{
					$rsp['id'] = $this->cnv_id_upd;
				}
			}else{
				$rsp['w'] = 'No result:'.$__cnx->c_p->error;
			}
		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }




    public function SclForm($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->form_acc) && !isN($this->form_acc_id) /*&& !isN($this->form_created_time)*/){

			if($this->form_status == 'ACTIVE'){
				$status = 1;
				$est = _CId('ID_SISEST_OK');
			}else{
				$status = 2;
				$est = _CId('ID_SISEST_NO');
			}

			$___tot_qus = count($this->form_qus);

			if(!isN($this->form_leads_expired)){
				$__tot_leads = ($this->form_leads_expired+$this->form_leads)*1;
			}else{
				$__tot_leads = $this->form_leads;
			}

			// Politica de datos en formularios Social //
			if(!isN($p['plcy'])){ $__rg = ", sclaccform_plcy = ".$p['plcy']; }


			if($p['t'] != 'upd'){

				$__enc = Enc_Rnd($this->form_acc.'-'.$this->form_acc_id.' - '.SIS_H2);

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM." (sclaccform_enc, sclaccform_sclacc, sclaccform_created_time, sclaccform_status, sclaccform_name, sclaccform_id, sclaccform_leads, sclaccform_leads_expired, sclaccform_tot_qus, sclaccform_md, sclaccform_est) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->form_acc, "int"),
                       GtSQLVlStr($this->_Tme($this->form_created_time) , "date"),
                       GtSQLVlStr($status, "int"),
                       GtSQLVlStr(ctjTx($this->form_name,'out'), "text"),
                       GtSQLVlStr($this->form_id, "text"),
                       GtSQLVlStr($__tot_leads, "int"),
                       GtSQLVlStr($this->form_leads_expired, "int"),
                       GtSQLVlStr($___tot_qus, "int"),
                       GtSQLVlStr(_CId('SIS_MD_FB'), "int"),
                       GtSQLVlStr($est, "int"));

			}else{

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM." SET sclaccform_est=%s, sclaccform_status=%s, sclaccform_leads=%s, sclaccform_leads_expired=%s, sclaccform_tot_qus=%s $__rg WHERE id_sclaccform=%s LIMIT 1",
							   GtSQLVlStr($est, "int"),
							   GtSQLVlStr($status, "int"),
							   GtSQLVlStr($__tot_leads, "int"),
							   GtSQLVlStr($this->form_leads_expired, "int"),
							   GtSQLVlStr($___tot_qus, "int"),
							   GtSQLVlStr($this->form_id_upd, "int"));

			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }


			//echo h1('UPDATE FORM:'.$_sql_s.$__cnx->c_p->error);
			//echo 'Expired:'.$this->form_leads_expired;
			//echo 'Leads:'.$this->form_leads;
			//echo 'Total:'.$__tot_leads.HTML_BR.HTML_BR;



			if($Result_RLC){
				$rsp['e'] = 'ok';
				$rsp['id'] = $this->form_id_upd;
			}else{
				$rsp['w'] = 'No result:'.$__cnx->c_p->error;
			}
		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }


    public function SclFormLeadDwn($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($this->form_lead) && !isN($this->form_id)){

			$___tot_qus = count($this->form_qus);
			$___data = ctjTx( json_encode($this->formlead_data, JSON_UNESCAPED_UNICODE), 'out', '', ['html'=>'ok','qte'=>'no']);

			if($p['t'] != 'upd'){

				$__enc = Enc_Rnd($this->form_lead.'-'.$this->form_id);

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS." (sclaccformleads_enc, sclaccformleads_form, sclaccformleads_id, sclaccformleads_lead, sclaccformleads_created) VALUES (%s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($this->form_id, "int"),
                       GtSQLVlStr($this->form_lead, "int"),
                       GtSQLVlStr($___data, "text"),
                       GtSQLVlStr( $this->_Tme($this->formlead_created) , "date"));

			}else{

				$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS." SET sclaccformleads_lead=%s, sclaccformleads_created=%s WHERE id_sclaccformleads=%s",
							   GtSQLVlStr($___data, "text"),
							   GtSQLVlStr( $this->_Tme($this->formlead_created) , "date"),
							   GtSQLVlStr($this->form_lead_id_upd, "int"));
			}


			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

			if($Result_RLC){

				$rsp['e'] = 'ok';
				$rsp['id'] = $this->form_id_upd;

			}else{

				$rsp['w'] = 'No result:'.$__cnx->c_p->error.' -> '.$_sql_s;

			}

		}else{

			$rsp['w'] = TX_FLTDTINC;

		}

		return _jEnc($rsp);

    }


   	public function SclFormLeadUpd($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS." SET sclaccformleads_est=%s WHERE sclaccformleads_enc=%s",
		                       GtSQLVlStr(1, "int"),
		                       GtSQLVlStr($p['id'], "text"));

		   if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); $rsp['q'] = $_sql_s; }
		   if($Result_RLC){ $rsp['e'] = 'ok';  }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		}

		return _jEnc($rsp);
	}


	public function SclFormLeadUpdW($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS." SET sclaccformleads_w=%s WHERE sclaccformleads_enc=%s",
		                       GtSQLVlStr(ctjTx($p['w'],'out'), "text"),
		                       GtSQLVlStr($p['id'], "text"));

		   if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); $rsp['q'] = $_sql_s; }
		   if($Result_RLC){ $rsp['e'] = 'ok';  }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		}

		return _jEnc($rsp);
	}


    public function SclFormLeadData($p=NULL){

		foreach($this->form_lead_data as $_data_k=>$_data_v){

			$qus = $this->SclFormQusFldDt(['key_c'=>enCad($_data_v->name), 'form'=>$this->form_id]);

			/*echo '-----------SclFormLeadData DATA ----------'.PHP_EOL;
			print_r($_data_v);
			echo '-----------$qus DATA ----------'.PHP_EOL;
			print_r($qus);
			echo PHP_EOL;*/

			if(!isN($qus->up->id)){

				if($qus->up->key == 'cnt_tel' || $qus->up->key == 'cnt_tel_2' || $qus->up->key == 'cnt_tel_3'){
					$_nmbc = preg_replace('/[^0-9+]+/', '', $_data_v->values[0]);
					$_vle_go = [ 'no'=>$_nmbc ];
				}else{
					$_vle_go = $_data_v->values[0];
				}

				$rsp[] = [
							'lbl'=>$_data_v->name,
							'fld'=>$qus->up,
							'vle'=>$_vle_go
						];

			}

		}

		return _jEnc($rsp);

	}


    public function SclFormLead($p=NULL){

	    $rsp['e'] = 'no';

	    if(!isN($this->form_lead_data) && !isN($this->form_id)){

			$__CntIn = new CRM_Cnt([ 'cl'=>$this->cl->id ]);
			$__chk = new CRM_Cnt_Up([ 'cl'=>$this->cl->id ]);
			$__fld = $this->SclFormLeadData();

			if(!isN($__fld)){

				foreach($__fld as $__fld_k=>$__fld_v){

					/*echo '$__fld_v add to CRM_Cnt_Up ----------->'.PHP_EOL;
					print_r( $__fld_v );
					echo $__fld_v->fld->key.PHP_EOL;*/

					if(is_object($__fld_v->vle)){ $_v=json_decode($__fld_v->vle,true); }else{ $_v=$__fld_v->vle; }

					if($__fld_v->fld->key == 'cnt_tel' || $__fld_v->fld->key == 'cnt_tel_2' || $__fld_v->fld->key == 'cnt_tel_2'){

						$__chk->{ $__fld_v->fld->key } = [
															'no'=>$__fld_v->vle->no
														];

					}else{

						$__chk->{ $__fld_v->fld->key } = $_v;

					}

				}

				$__chk->cnt_tel_disallow = 'ok';
				$__chk->mdlcnt_md = $this->form_md; // Set Medio Facebook Ad Lead o medio seleccionado en el form
				$__chk->mdl_id = $this->form_mdl;
				$__chk->Run();


				if($__chk->hb != 'no'){

					foreach($__fld as $__fld_k=>$__fld_v){
						$__CntIn->{$__fld_v->fld->key} = $__chk->{$__fld_v->fld->key};
					}

					$__CntIn->mdlcnt_md = $__chk->mdlcnt_md;
					$__CntIn->gt_cl_id = $this->cl->id;
					$__CntIn->cnt_tel_getc = 'no';

					$__CntIn->plcy_id = $this->plcy_id;
					$__CntIn->invk->by = _CId('ID_SISINVK_API');

					$__CntIn->gt_mdl_id = $__chk->gt_mdl_id;
					$__CntIn->mdlcnt_fi = $this->form_lead_created;
					$__CntIn->cnt_sndi = 1;

					$PrcDt = $__CntIn->MdlCnt();

					if(!isN($PrcDt->i)){

						$__upd = $this->SclFormLeadUpd([ 'id'=>$this->formleads_enc ]);

						//echo h2( Strn('SclFormLeadUpd: ').print_r($__upd, true) );

						if($__upd->e == 'ok'){
							$rsp['e'] = 'ok';
							$rsp['i'] = $PrcDt->i;
							$rsp['prc'] = $PrcDt;
						}

					}else{
						$rsp['w'][] = 'No result on MdlCnt:'.$__cnx->c_p->error;
						$rsp['w'][] = $PrcDt;
					}

				}else{

					$rsp['w'] = 'Not allow to save';
					$__upd = $this->SclFormLeadUpdW([ 'id'=>$this->formleads_enc, 'w'=>$__chk->hb_w_all ]);
					echo $__chk->hb_w_all;

				}

			}else{

				$rsp['w'][] = 'No data on process SclFormLeadData()';

			}

		}

		return _jEnc($rsp);
    }


    /*Lady*/


   	public function SclFormAttrLs($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['id'])){

			if(!isN($p['id'])){ $__f .= ' AND sclaccformattr_sclaccform='.GtSQLVlStr($p['id'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_FORM_ATTR.' WHERE id_sclaccformattr != "" '.$__f.'';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				do{

					$_id = $row_DtRg['sclaccformattr_enc'];

					if(!isN($_id)){

						$Vl['ls']['id'] = $row_DtRg['id_sclaccformattr'];
						$Vl['ls']['enc'] = $_id;
						$Vl['ls']['key'] = ctjTx($row_DtRg['sclaccformattr_key'],'in');
						$Vl['ls']['vl'] = ctjTx($row_DtRg['sclaccformattr_vl'],'in');
						$Vl['ls'][$row_DtRg['sclaccformattr_key']]['vl'] = ctjTx($row_DtRg['sclaccformattr_vl'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}

		return(_jEnc($Vl));
	}

	public function SclFormQusOptLs($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['id'])){

			if(!isN($p['id'])){ $__f .= ' AND sclaccformqusopt_sclaccformqus='.GtSQLVlStr($p['id'], 'text').' '; }

			if(!isN($p['bd'])){
				$__bd = $p['bd'];
			}else{
				$__dt_cl = __Cl([ 'id'=>DB_CL_ENC, 't'=>'enc' ]);
				$__bd = $__dt_cl->bd;
			}

			if($p['tp'] == 'universidad_a_la_que_aspira'){

				$__flt = ' '._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT_ORG.' , '._BdStr(DBM).TB_ORG;
				$__flt2 = 'sclaccformqusoptorg_qusopt = id_sclaccformqusopt AND id_org = sclaccformqusoptorg_org';

			}elseif($p['tp'] == 'mdl_gen'){

				$__flt = _BdStr($__bd).TB_SCL_ACC_FORM_QUS_OPT_MDL.' , '._BdStr($__bd).TB_MDL;
				$__flt2 = 'sclaccformqusoptmdl_qusopt = id_sclaccformqusopt AND id_mdl = sclaccformqusoptmdl_mdl';

			}

			if(!isN($__flt)){

				$query_DtRg = '	SELECT *,( SELECT COUNT(*) FROM '.$__flt.' WHERE '.$__flt2.' '.$__f.' ) as __est
								FROM '._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT.'
								WHERE id_sclaccformqusopt != "" '.$__f.'';

				$DtRg = $__cnx->_qry($query_DtRg);

				$Vl['q'] = compress_code($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$_id = $row_DtRg['sclaccformqusopt_enc'];

						if(!isN($_id)){

							$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccformqusopt'];
							$Vl['ls'][$_id]['enc'] = $_id;
							$Vl['ls'][$_id]['key'] = ctjTx($row_DtRg['sclaccformqusopt_key'],'in');
							$Vl['ls'][$_id]['vl'] = ctjTx($row_DtRg['sclaccformqusopt_vl'],'in');
							$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');
							$Vl['ls'][$_id]['rlc'] = $row_DtRg['sclaccformqusopt_sclaccformqus'];

						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$Vl['w'] = 'No filter var for '.$p['tp'];

			}


		}else{

			$Vl['w'] = 'No data on P';

		}

		return(_jEnc($Vl));
	}




	public function SclFormQusLs($p=NULL){

	   	global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['id'])){

			if(!isN($p['id'])){ $__f .= ' AND sclaccformqus_sclaccform='.GtSQLVlStr($p['id'], 'text').' '; }

			$query_DtRg = 'SELECT *,

								(
									SELECT
										COUNT(*)
									FROM
										'._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD.' ,
										'.DBP.'.'.TB_UP_FLD.'
									WHERE
										sclaccformqusfld_qus = id_sclaccformqus
									AND id_upfld = sclaccformqusfld_fld
									'.$__f.'
								) as __est

							FROM '._BdStr(DBT).TB_SCL_ACC_FORM_QUS.'
								 INNER JOIN '._BdStr(DBT).TB_SCL_ACC_FORM.' ON sclaccformqus_sclaccform = id_sclaccform
								 LEFT JOIN '._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD.' ON sclaccformqusfld_qus = id_sclaccformqus
								 LEFT JOIN '.DBP.'.'.TB_UP_FLD.' ON id_upfld = sclaccformqusfld_fld
							WHERE id_sclaccformqus != "" '.$__f.' ';


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $DtRg->num_rows;

				do{

					$_id = $row_DtRg['sclaccformqus_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclaccformqus'];

						$Vl['ls'][$_id]['fm']['id'] = $row_DtRg['id_sclaccform'];
						$Vl['ls'][$_id]['fm']['enc'] = $row_DtRg['sclaccform_enc'];

						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['tpe'] = ctjTx($row_DtRg['sclaccformqus_type'],'in');
						$Vl['ls'][$_id]['key'] = ctjTx($row_DtRg['sclaccformqus_key'],'in');
						$Vl['ls'][$_id]['key_c'] = ctjTx($row_DtRg['sclaccformqus_key_c'],'in');

						$Vl['ls'][$_id]['vl'] = ctjTx($row_DtRg['sclaccformqus_label'],'in');
						$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');

						$Vl['ls'][$_id]['upfld_vl'] = ctjTx($row_DtRg['upfld_vl'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}

	public function SclFormQusFldLs($p=NULL){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['qus'])){ $_fl .= " AND sclaccformqusfld_qus = '".$p['qus']."' "; }
			if(!isN($p['form'])){ $_fl .= " AND id_sclaccform = '".$p['form']."' "; }

			$query_DtRg = "	SELECT *,
									(

										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD."
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM_QUS." ON sclaccformqusfld_qus = id_sclaccformqus
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM." ON sclaccformqus_sclaccform = id_sclaccform
										WHERE id_upfld = sclaccformqusfld_fld {$_fl}

									) as __est

							FROM
								".DBP.".".TB_UP_FLD."
								INNER JOIN "._BdStr(DBT).TB_SCL_LD_FLDS." ON sclldflds_fld = id_upfld
							WHERE
								sclldflds_est = 1
							ORDER BY __est DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['qry'] = $query_DtRg;

			if($DtRg){

				$Vl['tot'] = $DtRg->num_rows;

				do{

					$_id = $row_DtRg['upfld_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_upfld'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['tt'] = ctjTx($row_DtRg['upfld_tt'],'in');
						$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{

				$Vl['q'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function SclOpt($p=NULL){

		$Vl['e'] = 'no';
		$__chk = $this->SclOpt_Chk();


		if(isN($__chk->id)){
			$__in = $this->SclOpt_In();
			if($__in->e == 'ok'){ $Vl['e'] = 'ok'; $Vl['qry'] = $__in; }else{ $Vl['eddd'] = $__in; }
		}

		if(!isN($__chk->id)){
			$__upd = $this->SclOpt_Del();
			if($__upd->e == 'ok'){ $Vl['del']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
		}

		return(_jEnc($Vl));
	}


	public function SclOpt_Chk($p=NULL){

		global $__cnx;

		if( !isN($this->id_fld) && !isN($this->id_qus) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf('SELECT *
								   FROM '.$this->bd.'
								   WHERE '.$this->id_rel.' = %s AND '.$this->id.' = %s
								   LIMIT 1', GtSQLVlStr($this->id_fld,'text'), GtSQLVlStr($this->id_qus,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg[$this->id_tx];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	public function SclOpt_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($this->id_fld.'-'.$this->id_qus);

		$query_DtRg = sprintf("INSERT INTO ".$this->bd." (".$this->enc.", ".$this->id_rel.", ".$this->id.") VALUES (%s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->id_fld, "int"),
						GtSQLVlStr($this->id_qus, "int"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['id'] = $query_DtRg;
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['qry'] = $query_DtRg;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}
		return _jEnc($rsp);

	}


	public function SclOpt_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM ".$this->bd." WHERE  ".$this->id_rel." = %s AND ".$this->id." =  %s",
               GtSQLVlStr($this->id_fld, "text"),
               GtSQLVlStr($this->id_qus, "int"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	public function SclFormQusOptOrgLs($p=NULL){

   		global $__cnx;

		if(!isN($p) && !isN($p['id'])){

			$query_DtRg = "SELECT *,(
								SELECT
									COUNT(*)
								FROM
									"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT_ORG.",
									"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT."
								WHERE
									sclaccformqusoptorg_qusopt = id_sclaccformqusopt
								AND id_org = sclaccformqusoptorg_org
								AND sclaccformqusoptorg_qusopt = '".$p['id']."'

							) as __est

							FROM "._BdStr(DBM).TB_ORG."

						WHERE
							sisslc_cns = '".$p['tp']."' ORDER BY __est DESC, org_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['tot'] = $DtRg->num_rows;

			if($DtRg){
				do{

					$_id = $row_DtRg['org_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_org'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['tt'] = ctjTx($row_DtRg['org_nm'],'in','',['schr'=>'ok']);
						$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	public function SclFormQusOptMdlLs($p=NULL){

   		global $__cnx;

   		$Cl = GtClDt(CL_ENC, 'enc');

		if(!isN($p) && !isN($p['id'])){

			$query_DtRg = "SELECT *,
							(	SELECT
									COUNT(*)
								FROM
									".$Cl->bd.".".TB_SCL_ACC_FORM_QUS_OPT_MDL.",
									"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT."
								WHERE
									sclaccformqusoptmdl_qusopt = id_sclaccformqusopt
								AND id_mdl = sclaccformqusoptmdl_mdl
								AND sclaccformqusoptmdl_qusopt = '".$p['id']."'
							) as __est

						FROM ".$Cl->bd.".".TB_MDL."
						ORDER BY __est DESC, mdl_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['tot'] = $DtRg->num_rows;

			if($DtRg){
				do{

					$_id = $row_DtRg['mdl_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_org'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['tt'] = ctjTx($row_DtRg['mdl_nm'],'in','',['schr'=>'ok']);
						$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	public function SclFormQusOptFldLs($p=NULL){

	   	global $__cnx;

		if(!isN($p) && !isN($p['id'])){

			$query_DtRg = "SELECT *,(
							SELECT
								COUNT(*)
							FROM
								"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT_FLD." ,
								"._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT."
							WHERE
								sclaccformqusfldopt_qusopt = id_sclaccformqusopt
							AND id_upfld = sclaccformqusfldopt_fld
							AND sclaccformqusfldopt_qusopt = '".$p['id']."'

						) as __est FROM ".DBP.".".TB_UP_FLD." ORDER BY __est DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['tot'] = $DtRg->num_rows;

			if($DtRg){

				do{

					$_id = $row_DtRg['upfld_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_upfld'];
						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['tt'] = ctjTx($row_DtRg['upfld_tt'],'in');
						$Vl['ls'][$_id]['est'] = ctjTx($row_DtRg['__est'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

			$__cnx->_clsr($DtRg);

		}
		return(_jEnc($Vl));
	}

    /*Lady*/

    public function SclFormAttrDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['key']) && !isN($p['id'])){

			if(!isN($p['key'])){ $__f .= ' AND sclaccformattr_key='.GtSQLVlStr($p['key'], 'text').' '; }
			if(!isN($p['id'])){ $__f .= ' AND sclaccformattr_sclaccform='.GtSQLVlStr($p['id'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_FORM_ATTR.' WHERE id_sclaccformattr != "" '.$__f.' LIMIT 1';

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccformattr'];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}


    public function SclForm_Attr($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($this->form_id_upd)){

		    $rsp['ls'] = $this->form_attr;

		    if(!isN($this->form_attr)){

			    foreach($this->form_attr as $k=>$v){

					$__chk = $this->SclFormAttrDt(['key'=>$k, 'tp'=>$p['tp'], 'id'=>$this->form_id_upd]);

					if(is_array($v)){
						$__v = json_encode($v);
					}elseif(is_object($v)){
						$__v = json_encode($v, true);
					}else{
						$__v = $v;
					}

					if($__chk->e == 'ok' && !isN($__chk->id) && !isN($__v)){
			    		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM_ATTR." SET sclaccformattr_vl=%s WHERE sclaccformattr_sclaccform=%s AND sclaccformattr_key=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx($__v,'out'), "text"),
		                       GtSQLVlStr($this->form_id_upd, "int"),
		                       GtSQLVlStr($k, "text"));
					}elseif(!isN($this->form_id_upd) && !isN($k) && !isN($__v)){

						$__enc = Enc_Rnd($k.'-'.$this->form_id_upd);

			    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM_ATTR." (sclaccformattr_enc, sclaccformattr_sclaccform, sclaccformattr_key, sclaccformattr_vl) VALUES (%s, %s, %s, %s)",
		                       GtSQLVlStr($__enc, "text"),
		                       GtSQLVlStr($this->form_id_upd, "int"),
		                       GtSQLVlStr($k, "text"),
		                       GtSQLVlStr(ctjTx($__v,'out'), "text"));
					}


					if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
					if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

			    }
		    }

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }

    // -------- I - Email Cliente -------- //
    public function ClEmlLs($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$query_DtRg = "	SELECT *,
								(SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = "._CId('ID_SISTAG_CLR_MAIN')." AND cltag_cl = id_cl ) AS _cl_clr,
									(

										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_CL_EML."
											INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON id_eml = cleml_eml
										WHERE cleml_cl = id_cl
										AND cleml_eml = (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = '".$p['id']."')

									) as __est

							FROM "._BdStr(DBM).TB_CL."
							LEFT JOIN "._BdStr(DBM).TB_CL_EML." ON cleml_cl = id_cl";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['tot'] = $DtRg->num_rows;
				$Vl['qry'] = $query_DtRg;

				do{

					$_id = $row_DtRg['cl_enc'];

					if(!isN($_id)){

						$Vl['ls'][$row_DtRg['cl_enc']]['enc'] = $row_DtRg['cl_enc'];
						$Vl['ls'][$row_DtRg['cl_enc']]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
						$Vl['ls'][$row_DtRg['cl_enc']]['dft'] = $row_DtRg['cleml_dfl'];
						$Vl['ls'][$row_DtRg['cl_enc']]['img'] = _ImVrs(['img'=>$row_DtRg['cl_img'], 'f'=>DMN_FLE_CL]);
						$Vl['ls'][$row_DtRg['cl_enc']]['clr'] = $row_DtRg['_cl_clr'];
						$Vl['ls'][$row_DtRg['cl_enc']]['tot'] = $row_DtRg['__est'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{

				$Vl['q'] = $query_DtRg;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function Chk_ClEml($p=NULL){

		global $__cnx;

		if(!isN($p['eml']) && !isN($p['cl'])){

			$query_DtRg = sprintf("SELECT id_cleml, cleml_enc, cleml_dfl
									FROM "._BdStr(DBM).TB_CL_EML."
									WHERE
										cleml_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s) AND
										cleml_eml = (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s)",
									GtSQLVlStr($p['cl'],'text'),
									GtSQLVlStr($p['eml'],'text')
							);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_cleml'];
					$Vl['enc'] = ctjTx($row_DtRg['cleml_enc'],'in');
					$Vl['dft'] = $row_DtRg['cleml_dfl'];
				}

			}else{

				$Vl['w'][] = compress_code($query_DtRg).' '.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'][] = 'No all data';

		}

		return(_jEnc($Vl));

	}

	public function ClEml_Upd($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("UPDATE "._BdStr(DBM).TB_CL_EML." SET cleml_dfl = %s WHERE id_cleml=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx($this->cleml_dft,'out'), "int"),
		                       GtSQLVlStr(ctjTx($this->id_cleml,'out'), "int"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok';  }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

    public function ClEml_In($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$__enc = Enc_Rnd($this->id_eml.'-'.$this->id_cl);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_CL_EML." (cleml_enc, cleml_eml, cleml_cl) VALUES (%s, (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s), (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->id_eml, "text"),
							GtSQLVlStr($this->id_cl, "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}

	public function ClEml_Del($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';
	    $Vl['tot'] = 0;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_EML." WHERE cleml_eml=(SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s) AND cleml_cl=(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s)",
							GtSQLVlStr($this->id_eml, "text"),
							GtSQLVlStr($this->id_cl, "text"));


		$Result = $__cnx->_prc($query_DtRg);
		$rsp['sssm'] = $query_DtRg;
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}


    public function EmlUsLs($p=NULL){

		global $__cnx;

		if(!isN($p)){

			if(!ChckSESS_superadm()){
				$__fl .= ' AND us_nivel="user" ';
			}

			$query_DtRg = "	SELECT us_enc, us_nm, us_ap, us_img, us_gnr,
									(
										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_US_EML."
											INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON id_eml = useml_eml
										WHERE useml_us = id_us
										AND useml_eml = (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = '".$p['id']."')

									) as __est

							FROM "._BdStr(DBM).TB_US."
								 INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us
								 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
							WHERE cl_enc = '".DB_CL_ENC."' {$__fl}
							ORDER BY __est DESC";


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['tot'] = $DtRg->num_rows;

				do{

					$_id = $row_DtRg['us_enc'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['us_nm'],'in').' '.ctjTx($row_DtRg['us_ap'],'in');
						$Vl['ls'][$_id]['tot'] = $row_DtRg['__est'];

						if( !isN($row_DtRg['us_img']) ){

							$Vl['ls'][$row_DtRg['us_enc']]['img'] = _ImVrs([ 'img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

						}else{

							$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
							$Vl['ls'][$_id]['img'] = $_img;
						}

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['q'] = $query_DtRg;
				$Vl['error'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
    }


    public function EmlUs_In($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_US_EML." (useml_cl, useml_eml, useml_us) VALUES (
								(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s),
								(SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s),
								(SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s))",
							GtSQLVlStr(CL_ENC, "text"),
							GtSQLVlStr($this->id_eml, "text"),
							GtSQLVlStr($this->id_us, "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}


		return _jEnc($rsp);

	}


	public function EmlUs_Del($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_US_EML." WHERE
									useml_eml = (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s) AND
									useml_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s) AND
									useml_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s)",
							GtSQLVlStr($this->id_eml, "text"),
							GtSQLVlStr($this->id_us, "text"),
							GtSQLVlStr(CL_ENC, "text"));


		$Result = $__cnx->_prc($query_DtRg);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);


	}

    public function EmlAreLs($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$query_DtRg = "	SELECT clare_enc, clare_tt,
									(
										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_CL_ARE_EML."
											INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON id_eml = clareeml_eml
										WHERE clareeml_clare = id_clare
										AND clareeml_eml = (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = '".$p['id']."')

									) as __est

							FROM "._BdStr(DBM).TB_CL_ARE."
							     INNER JOIN "._BdStr(DBM).TB_CL." ON clare_cl = id_cl
							WHERE cl_enc = '".DB_CL_ENC."'
							ORDER BY __est DESC";


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['tot'] = $DtRg->num_rows;

				do{

					$_id = $row_DtRg['clare_enc'];

					if($_id != ''){

						$Vl['ls'][$_id]['enc'] = $_id;
						$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['clare_tt'],'in');
						$Vl['ls'][$_id]['tot'] = $row_DtRg['__est'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['q'] = $query_DtRg;
				$Vl['error'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
    }


    public function EmlAre_In($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

	    $__enc = Enc_Rnd($this->id_eml.'-'.$this->id_are);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_CL_ARE_EML." (clareeml_enc, clareeml_eml, clareeml_clare) VALUES (
								%s,
								(SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s),
								(SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->id_eml, "text"),
							GtSQLVlStr($this->id_are, "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['qry'] = $query_DtRg;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}


		return _jEnc($rsp);

	}


	public function EmlAre_Del($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_ARE_EML." WHERE
									clareeml_eml = (SELECT id_eml FROM "._BdStr(DBT).TB_THRD_EML." WHERE eml_enc = %s) AND
									clareeml_clare = (SELECT id_clare FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc = %s)",
							GtSQLVlStr($this->id_eml, "text"),
							GtSQLVlStr($this->id_are, "text"));


		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}


    public function SclFormQusDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p)){

			if(!isN($p['enc'])){ $__f .= ' AND sclaccformqus_enc='.GtSQLVlStr($p['enc'], 'text').' '; }
			if(!isN($p['key'])){ $__f .= ' AND sclaccformqus_key='.GtSQLVlStr($p['key'], 'text').' '; }
			if(!isN($p['key_c'])){ $__f .= ' AND sclaccformqus_key_c='.GtSQLVlStr($p['key_c'], 'text').' '; }
			if(!isN($p['form'])){ $__f .= ' AND sclaccformqus_sclaccform='.GtSQLVlStr($p['form'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_FORM_QUS.' WHERE id_sclaccformqus != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);
			//echo $query_DtRg.HTML_BR;

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccformqus'];
					$Vl['lbl'] = $row_DtRg['sclaccformqus_label'];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}



	public function SclFormQusFldDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p)){

			if(!isN($p['key_c'])){ $__f .= ' AND sclaccformqus_key_c='.GtSQLVlStr($p['key_c'], 'text').' '; }
			if(!isN($p['form'])){ $__f .= ' AND sclaccformqus_sclaccform='.GtSQLVlStr($p['form'], 'text').' '; }

			$query_DtRg = '	SELECT *
							FROM '._BdStr(DBT).TB_SCL_ACC_FORM_QUS.'
								 INNER JOIN '._BdStr(DBT).TB_SCL_ACC_FORM.' ON sclaccformqus_sclaccform = id_sclaccform
								 LEFT JOIN '._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD.' ON sclaccformqusfld_qus = id_sclaccformqus
								 LEFT JOIN '.DBP.'.'.TB_UP_FLD.' ON sclaccformqusfld_fld = id_upfld

							WHERE id_sclaccformqus != "" '.$__f.'
							LIMIT 1';

			$DtRg = $__cnx->_qry($query_DtRg);
			//echo $query_DtRg.HTML_BR;

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccformqus'];
					$Vl['lbl'] = $row_DtRg['sclaccformqus_label'];

					$Vl['up']['id'] = $row_DtRg['id_upfld'];
					$Vl['up']['key'] = $row_DtRg['upfld_vl'];
				}

			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}


    public function SclForm_Qus($p=NULL){

		global $__cnx;

		//echo $this->_auto->li('Execute SclForm_Qus');

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($this->form_id_upd)){

		    $rsp['ls'] = $this->form_qus;

		    if(!isN($this->form_qus)){

				//echo $this->_auto->li('Count->'.count($this->form_qus));

			    foreach($this->form_qus as $k=>$v){

					if(!isN($v->key)){

						$__chk = $this->SclFormQusDt(['key_c'=>enCad($v->key), 'form'=>$this->form_id_upd]);

						if($__chk->e == 'ok' && !isN($__chk->id) && !isN($v)){

				    		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM_QUS." SET sclaccformqus_key=%s, sclaccformqus_key_c=%s, sclaccformqus_label=%s, sclaccformqus_type=%s, sclaccformqus_id=%s, sclaccformqus_tot_opt=%s WHERE sclaccformqus_sclaccform=%s AND sclaccformqus_key=%s LIMIT 1",
			                       GtSQLVlStr(ctjTx($v->key,'out'), "text"),
			                       GtSQLVlStr(enCad($v->key), "text"),
			                       GtSQLVlStr(ctjTx($v->label,'out'), "text"),
			                       GtSQLVlStr(ctjTx($v->type,'out'), "text"),
			                       GtSQLVlStr(ctjTx($v->id,'out'), "text"),
			                       GtSQLVlStr(count($v->options), "int"),
			                       GtSQLVlStr($this->form_id_upd, "int"),
			                       GtSQLVlStr(ctjTx($v->key,'out'), "text"));

						}elseif(!isN($this->form_id_upd) && !isN($v->key)){

							$__enc = Enc_Rnd($k.'-'.$this->form_id_upd);

							if(!isN($__enc) && !isN($v->key)){

					    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM_QUS." (sclaccformqus_enc, sclaccformqus_sclaccform, sclaccformqus_key, sclaccformqus_key_c, sclaccformqus_label, sclaccformqus_type, sclaccformqus_id, sclaccformqus_tot_opt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
				                       GtSQLVlStr($__enc, "text"),
				                       GtSQLVlStr($this->form_id_upd, "int"),
				                       GtSQLVlStr(ctjTx($v->key,'out'), "text"),
				                       GtSQLVlStr(enCad($v->key), "text"),
				                       GtSQLVlStr(ctjTx($v->label,'out'), "text"),
				                       GtSQLVlStr(ctjTx($v->type,'out'), "text"),
				                       GtSQLVlStr(ctjTx($v->id,'out'), "text"),
				                       GtSQLVlStr(count($v->options), "int"));

			                }
						}

						//echo $this->_auto->li('Count Options->'.count($v->options));

						if(count($v->options) > 0 && !isN($__chk->id)){
							$__opt = $this->SclForm_QusOpt([ 'id'=>$__chk->id, 'o'=>$v->options ]);
						}

						if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

						if($Result_RLC && (isN($__opt->w) || isN($__opt->w))){
							$rsp['e'] = 'ok';
						}else{
							$rsp['w'][] = 'No result:'.$__cnx->c_p->error;
							if(!isN($__opt->w)){ $rsp['w'][] = $__opt->w; }
						}

					}

			    }
		    }

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }

	public function SclFormAttrFldIn($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD." (sclaccformqusfld_fld, sclaccformqusfld_qus) VALUES ((SELECT id_upfld FROM ".DBP.".".TB_UP_FLD." WHERE upfld_enc =  %s), %s)",
                   GtSQLVlStr($this->id_fld, "text"),
                   GtSQLVlStr($this->id_qus, "int"));


		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormAttrFldDel($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("DELETE FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD." WHERE sclaccformqusfld_fld = (SELECT id_upfld FROM ".DBP.".".TB_UP_FLD." WHERE upfld_enc = %s) AND sclaccformqusfld_qus =  %s",
                   GtSQLVlStr($this->id_fld, "text"),
                   GtSQLVlStr($this->id_qus, "int"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormAttrOptFldIn($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT_FLD." (sclaccformqusfldopt_fld, sclaccformqusfldopt_qusopt) VALUES ((SELECT id_upfld FROM ".DBP.".".TB_UP_FLD." WHERE upfld_enc =  %s), %s)",
                   GtSQLVlStr($this->id_fld, "text"),
                   GtSQLVlStr($this->id_qus, "int"));



		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormAttrOptFldDel($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("DELETE FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT_FLD." WHERE sclaccformqusfldopt_fld = (SELECT id_upfld FROM ".DBP.".".TB_UP_FLD." WHERE upfld_enc = %s) AND sclaccformqusfldopt_qusopt =  %s",
                   GtSQLVlStr($this->id_fld, "text"),
                   GtSQLVlStr($this->id_qus, "int"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormUpd($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM." SET sclaccform_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), sclaccform_mdl=%s WHERE id_sclaccform=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx(CL_ENC,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->id_mdl,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->id_fm,'out'), "text"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok';  }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormUpdPlcy($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM." SET sclaccform_plcy = (SELECT id_clplcy FROM "._BdStr(DBM).TB_CL_PLCY." WHERE clplcy_enc = %s) WHERE id_sclaccform=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx($this->id_mdl,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->id_fm,'out'), "text"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok';  }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormUpdMd($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM." SET sclaccform_md = (SELECT id_sismd FROM "._BdStr(DBM).TB_SIS_MD." WHERE sismd_enc = %s) WHERE id_sclaccform=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx($this->id_mdl,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->id_fm,'out'), "text"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
		if($Result_RLC){ $rsp['e'] = 'ok';  }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		return _jEnc($rsp);
	}

	public function SclFormUpdEst($p=NULL){

		global $__cnx;

		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM." SET sclaccform_est=%s WHERE id_sclaccform=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx($this->id_mdl,'out'), "text"),
		                       GtSQLVlStr(ctjTx($this->id_fm,'out'), "text"));

		if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

		array_push($md_array['recipe_type'], $newdata);

		if($Result_RLC){
			$rsp['e'] = 'ok';
			$this->post['_est_nm'] = __LsDt([ 'k'=>'sis_est' ])->ls->sis_est->{$this->id_mdl}->tt;
			$rsp['a'] = $this->crm_aud->In_Aud([ "aud"=>_CId('ID_AUDDSC_SCL_UPD'), "db"=>'scl_acc_form', "post"=>$this->post ]);
		}else{
			$rsp['w'] = 'No result:'.$__cnx->c_p->error;
		}

		return _jEnc($rsp);
	}






	public function SclFormUpdFld($p=NULL){

		global $__cnx;

		if(!isN($p['enc'])){

			if(!isN($p['est'])){ $_upd[] = sprintf('sclaccform_est=%s', GtSQLVlStr($p['est'], "int")); }

			if(count($_upd) > 0){

				try {
					$updateSQL = "UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM." SET ".implode(',', $_upd)." WHERE sclaccform_enc=".GtSQLVlStr( $p['enc'] , "text")." LIMIT 1";
					$ResultUPD = $__cnx->_prc($updateSQL);
				} catch (Exception $e) {
					$rsp['w'] = $e->getMessage();
				}

			}

			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['e'] = 'no';
			}

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = 'no all data';

		}

		return _jEnc($rsp);
	}




	public function SclFormQusOptDt($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($p) && (!isN($p['key']) || !isN($p['enc'])) && !isN($p['id'])){

			if(!isN($p['enc'])){ $__f .= ' AND sclaccformqusopt_enc='.GtSQLVlStr($p['enc'], 'text').' '; }
			if(!isN($p['key'])){ $__f .= ' AND sclaccformqusopt_key_c='.GtSQLVlStr(enCad($p['key']), 'text').' '; }
			if(!isN($p['id'])){ $__f .= ' AND sclaccformqusopt_sclaccformqus='.GtSQLVlStr($p['id'], 'text').' '; }

			$query_DtRg = "SELECT * FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT." WHERE id_sclaccformqusopt != '' ".$__f." LIMIT 1";
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccformqusopt'];
					$Vl['lbl'] = $row_DtRg['sclaccformqusopt_vl'];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}

		return(_jEnc($Vl));
	}


    public function SclForm_QusOpt($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($p['id'])){

		    $rsp['ls'] = $p['o'];

		    if(!isN($p['o'])){

			    foreach($p['o'] as $k=>$v){

					$__chk = $this->SclFormQusOptDt(['key'=>$v->key, 'id'=>$p['id']]);

					if($__chk->e == 'ok' && !isN($__chk->id) && !isN($v)){

			    		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT." SET sclaccformqusopt_key=%s, sclaccformqusopt_key_c=%s, sclaccformqusopt_vl=%s WHERE sclaccformqusopt_sclaccformqus=%s AND sclaccformqusopt_key=%s LIMIT 1",
		                       GtSQLVlStr(ctjTx($v->key,'out'), "text"),
		                       GtSQLVlStr(enCad($v->key,'out'), "text"),
		                       GtSQLVlStr(ctjTx($v->value,'out'), "text"),
		                       GtSQLVlStr($p['id'], "int"),
		                       GtSQLVlStr(ctjTx($v->key,'out'), "text"));

					}elseif(!isN($p['id']) && !isN($v->key) && !isN($v->value)){

						//echo $this->_auto->li('Im in insert process');

						$__enc = Enc_Rnd($v->key.'-'.$p['id']);

			    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT." (sclaccformqusopt_enc, sclaccformqusopt_sclaccformqus, sclaccformqusopt_key, sclaccformqusopt_key_c, sclaccformqusopt_vl) VALUES (%s, %s, %s, %s, %s)",
		                       GtSQLVlStr($__enc, "text"),
		                       GtSQLVlStr($p['id'], "int"),
		                       GtSQLVlStr(ctjTx($v->key,'out'), "text"),
		                       GtSQLVlStr(enCad($v->key), "text"),
		                       GtSQLVlStr(ctjTx($v->value,'out'), "text"));
					}

					$__cnx->src_main = __FILE__;

					if(!isN($_sql_s)){
						$Result_RLC = $__cnx->_prc($_sql_s);
						if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'][] = 'No result:'.$__cnx->c_p->error; }
					}else{
						$rsp['w'][] = 'No query to execute key:'.$v->key.' / v:'.compress_code(print_r($v, true)).' / id:'.$p['id'].' / sql:'.compress_code($_sql_s);
					}


			    }
		    }

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }


    public function Rqu($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if(!isN($p['tp']) && ( !isN($p['acc']) || !isN($p['eml']) )){

			$__dt = $this->RquDt(['md'=>$p['md'], 'box'=>$p['box'], 'id'=>$p['id'], 'tp'=>$p['tp'], 'acc'=>$p['acc'], 'eml'=>$p['eml']]);

			if($p['md'] == 'eml'){
				$_tb = TB_THRD_EML_RQU; $_prfx = 'emlrqu'; $_obj = 'eml';
			}else{
				$_tb = TB_THRD_SCL_RQU; $_prfx = 'sclrqu'; $_obj = 'acc';
			}

			if($__dt->e == 'ok' && !isN($__dt->id)){

				if(!isN($p['box'])){
					$box = sprintf(', '.$_prfx.'_box=%s', GtSQLVlStr($p['box'],"text") );
				}

				if(!isN($p['id'])){
					$bid = sprintf(', '.$_prfx.'_id=%s', GtSQLVlStr($p['id'],"text") );
				}

				if($p['npge']!='ok'){
					if(!isN($p['nxt']) && $__dt->e == 'ok' && $__dt->all != 'ok'){ $pge = sprintf(', '.$_prfx.'_pge=%s', $__dt->pge+1); }
				}

				if(!isN($p['nxt']) && $__dt->all != 'ok'){
					$scnnxt = sprintf(', '.$_prfx.'_nxt=%s', GtSQLVlStr($p['nxt'], "text"));
				}else if(!isN($p['nxt']) && $p['nxt']=='clr'){
					$scnnxt = sprintf(', '.$_prfx.'_nxt=%s', NULL);
				}

				if($p['no_all'] == 'ok'){

				}else{
					if(($p['nxt'] == NULL && $__dt->all != 'ok' && !isN($__dt->nxt)) || ($p['all']=='ok')){
						$scnall = sprintf(', '.$_prfx.'_all=%s', 1);
					}elseif($p['all'] == 2){
						$scnall = sprintf(', '.$_prfx.'_all=%s', 2);
					}
				}

                $_sql_s = sprintf("UPDATE "._BdStr(DBT).$_tb." SET ".$_prfx."_fa=%s {$box} {$pge} {$bid} {$scnnxt} {$scnall} WHERE id_".$_prfx."=%s LIMIT 1",
							   GtSQLVlStr(SIS_F_TS, "date"),
							   GtSQLVlStr($__dt->id, "int")); //echo $_sql_s;

			}else{

				$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).$_tb." (".$_prfx."_tp, ".$_prfx."_box, ".$_prfx."_id, ".$_prfx."_".$_obj.", ".$_prfx."_nxt) VALUES (%s, %s, %s, %s, %s)",
                       GtSQLVlStr($p['tp'], "text"),
                       GtSQLVlStr($p['box'], "text"),
                       GtSQLVlStr($p['id'], "text"),
                       GtSQLVlStr($p[$_obj], "text"),
                       GtSQLVlStr($p['nxt'], "text"));

			}

			//echo $_sql_s.PHP_EOL;

		   	//$rsp['q']=$_sql_s;

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s, ['cmps'=>'ok']); }
			if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = $_sql_s.' -> No result:'.$__cnx->c_p->error; }

		}else{

			$rsp['w'] = TX_FLTDTINC;

		}

		return _jEnc($rsp);
    }




	public function _Rply(){

		$rsp['e'] = 'no';

	    if(!isN($this->rplycnv_id) && !isN($this->rplycnv_tkn) && !isN($this->rplycnv_msg)){
		    $api_rq = _NwFb_Acc_Msg_Rply(['id'=>$this->rplycnv_id, 'msg'=>$this->rplycnv_msg, 'access_token'=>$this->rplycnv_tkn ]);
			$rsp['api'] = $api_rq;
			if(!isN($api_rq->id)){ $rsp['e'] = 'ok'; }
		}

		return( _jEnc($rsp) );
	}


    public function _Fb_Prfl(){

	    if($this->__t == 'acc'){

		    $nwtokn = _NwFb_LAT([ 'access_token'=>$this->acc_tkn ]); //print_r( $nwtokn );

		    if(!isN($nwtokn)){
		    	$this->_sclacc_tknlvd = $nwtokn->getValue();
			}

		}else{

			$nwtokn = _NwFb_LAT(['access_token'=>$this->scl_attr['auth']->accessToken]);

			if(!isN($nwtokn)){
				$perfil = _NwFb_Dt(['id'=>$this->scl_attr['auth']->userID,'access_token'=>$nwtokn->getValue()]);
				$this->_scl_nm = $perfil->name;
				$this->_scl_prf = $this->scl_attr['auth']->userID;
				$this->scl_attr['img'] = $perfil->picture->url;
				$this->scl_attr['cvr'] = $perfil->cover->source;
				$this->scl_attr['tknlvd'] = $nwtokn->getValue();
			}
		}
	}

	public function In(){

		$rsp['e'] = 'no';
		$_scl = $this->_Scl();

		if($this->__t == 'acc'){

			$__chk_acc = $this->AccChk(['id'=>$this->acc_id, 'rds'=>$this->scl_rds_id ]);

			if($__chk_acc->e == 'ok'){

				if(!isN($__chk_acc->id)){

					$this->acc_id_upd = $__chk_acc->id;
					$this->acc_id_enc = $__chk_acc->enc;
					$__chk_upd = $this->Acc(['t'=>'upd']);

					if($__chk_upd->e != 'ok'){
						$rsp['w'][] = $__chk_upd->w;
					}
				}

			}else{
				$__chk_acc = $this->Acc();
			}

			if($__chk_acc->e == 'ok'){

				if(count($this->acc_attr) > 0){
					$_attr = $this->Acc_Attr();
					if(isN($_attr->w)){
						$rsp['attr'] = $_attr;
					}else{
						$rsp['w'][] = $_attr->w;
					}
				}

				$rsp['e'] = 'ok';
				$rsp['id'] = $__chk_acc->id;
				$rsp['enc'] = $__chk_acc->enc;
				$rsp['upd'] = 'ok';

			}else{
				$rsp['w'][] = $__chk_acc->w;
				$rsp['q'] = $__chk_acc->q;
			}


		}elseif($this->__t == 'acc_msg'){

			$rsp['usinall'] = $this->UsInAll();

			$__chk_cnv = $this->SclCnvChk(['id'=>$this->cnv_id, 'sclacc'=>$this->cnv_acc ]);

			if($__chk_cnv->e == 'ok'){
				if(!isN($__chk_cnv->id)){
					$this->cnv_id_upd = $__chk_cnv->id;
					$__chk_upd = $this->SclCnv(['t'=>'upd']);
				}
			}else{
				$__chk_cnv = $this->SclCnv();
			}

			$__dt_us = $this->UsDt(['us_id'=>$this->msg_from, 'rds'=>$this->scl_rds]);

			if($__chk_cnv->e == 'ok' && !isN($__chk_cnv->id) && !isN($this->msg_id) && $this->msg_id != '0' && !isN($__dt_us->id)){

				$this->chk_cnv_id = $__chk_cnv->id;

				$__chk_msg = $this->MsgChk(['id'=>$this->msg_id, 'cnv'=>$this->chk_cnv_id]);

				if($__chk_msg->e == 'ok'){
					if(!isN($__chk_msg->id)){
						$this->msg_id_upd = $__chk_msg->id;
						$__chk_upd = $this->SclMsg(['t'=>'upd']);
					}
				}else{
					$__chk_msg = $this->SclMsg();
				}


				if($__chk_cnv->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__chk_msg->id;
					$rsp['enc'] = $__chk_msg->enc;
					$rsp['upd'] = 'ok';
				}

			}else{

				$rsp['e'] = 'no';
				$rsp['w'] = ul(
								li('Chk: e->'.print_r($__chk_cnv, true)).
								li('Faltan campos Msg_Id: e->'.$__chk_cnv->e).
								li('Id->'.$__chk_cnv->id).
								li('MsgId->' .$this->msg_id).
								li('DtsUsOb-> ').
								li('Us:'.$this->msg_from).
								li('Search on UsDt() '.print_r($__dt_us, true)).
								li('<-DtsUsOb')
							);
			}

		}elseif($this->__t == 'scl'){

			if(!isN($this->scl_attr)){

				$__chk_scl = $this->SclChk([ 'rds'=>$this->scl_rds_id, 'id'=>$this->_scl_prf ]);

				$rsp['chk'] = $__chk_scl;

				if($__chk_scl->e == 'ok'){

					if(!isN($__chk_scl->id)){
						$this->scl_id_upd = $__chk_scl->id;
						$__chk_upd = $this->Scl([ 't'=>'upd' ]);
						$rsp['chk_upd'] = $__chk_upd;
					}

				}else{

					$rsp['chk_in'] = $__chk_scl = $this->Scl();

				}

				if($__chk_scl->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__chk_scl->id;
					$rsp['enc'] = $__chk_scl->enc;
					$rsp['upd'] = 'ok';
				}
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = 'no attributes';
			}

		}elseif($this->__t == 'acc_post'){

			$__chk_post = $this->PostChk(['sclacc'=>$this->post_acc, 'id'=>$this->post_id ]);

			//$rsp['tmp1'] = 'sclacc:'.$this->post_acc.' -> post_id:'.$this->post_id;

			if($__chk_post->e == 'ok'){
				if(!isN($__chk_post->id)){
					$this->post_id_upd = $__chk_post->id;
					$__chk_upd = $this->SclPost(['t'=>'upd']);
				}
			}else{
				$__chk_post = $this->SclPost();
			}

			if($__chk_post->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['id'] = $__chk_post->id;
				$rsp['enc'] = $__chk_post->enc;
				$rsp['upd'] = 'ok';
			}

		}elseif($this->__t == 'acc_form'){

			$__chk_form = $this->FormChk([ 'sclacc'=>$this->form_acc, 'id'=>$this->form_id ]);

			//$rsp['tmp1'] = 'sclacc:'.$this->form_acc.' -> form_id:'.$this->form_id;

			//echo 'sclacc:'.$this->form_acc.' -> form_id:'.$this->form_id.'<br>';

			if($__chk_form->e == 'ok'){

				if(!isN($__chk_form->id)){

					// Validacion  de Politica de datos en formularios Social //
					if(isN($__chk_form->plcy_dt)){
						$__chk = $this->SclAccClDt([ 'tp'=>'id', 'sclacc'=>$this->form_acc ]);
						$__Cl = new CRM_Cl([ 'cl'=>$__chk->cl ]);
						$___plcy_main = $__Cl->plcy_main([ 'cl'=>$__chk->cl ]);
						$plcy = $___plcy_main->id;
					}

					$this->form_id_upd = $__chk_form->id;
					$__chk_upd = $this->SclForm([ 't'=>'upd', 'cl'=>$__chk->cl, 'plcy'=>$plcy ]);

				}

			}else{

				$__chk_form = $this->SclForm([ 'cl'=>$__chk->cl ]);

			}

			if($__chk_form->e == 'ok'){

				if(count($this->form_attr) > 0){
					$this->SclForm_Attr();
				}

				if(count($this->form_qus) > 0){
					$_qus = $this->SclForm_Qus();
				}

				if(isN($_qus) || isN($_qus->w)){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__chk_form->id;
					$rsp['enc'] = $__chk_form->enc;
					$rsp['qus'] = $_qus;
					$rsp['upd'] = 'ok';
				}else{
					$rsp['w'][] = $_qus->w;
				}

			}

		}elseif($this->__t == 'acc_form_lead_dwn'){

			$__chk_form_lead = $this->FormLeadDwnChk(['form'=>$this->form_id, 'cid'=>$this->form_lead ]);

			$rsp['chk'] = $__chk_form_lead;

			if($__chk_form_lead->e == 'ok' && !isN($__chk_form_lead->id)){
				if(!isN($__chk_form_lead->id)){
					$this->form_lead_id_upd = $__chk_form_lead->id;
					$__chk_upd = $this->SclFormLeadDwn(['t'=>'upd']);
					$rsp['p'] = 'upd';
				}else{
					$rsp['e'] = 'No id';
				}
			}else{
				$rsp['p'] = 'in';
				$__chk_form_lead = $this->SclFormLeadDwn();
				$rsp['p_r'] = $__chk_form_lead;
			}



			if($__chk_form_lead->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['id'] = $__chk_form_lead->id;
				$rsp['enc'] = $__chk_form_lead->enc;
				$rsp['upd'] = 'ok';
			}

		}elseif($this->__t == 'acc_form_lead'){

			$__chk_form_lead = $this->SclFormLead();

			if($__chk_form_lead->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['id'] = $__chk_form_lead->id;
				$rsp['enc'] = $__chk_form_lead->enc;
				$rsp['upd'] = 'ok';
			}else{
				$rsp = $__chk_form_lead;
			}

		}elseif($this->__t == 'acc_post_cmn'){

			$rsp['usinall'] = $this->UsInAll();

			$__chk_postcmn = $this->PostCmnChk(['sclaccpost'=>$this->postcmn_post, 'id'=>$this->postcmn_id ]);

			if($__chk_postcmn->e == 'ok'){
				if(!isN($__chk_postcmn->id)){
					$this->postcmn_id_upd = $__chk_postcmn->id;
					$__chk_upd = $this->PostCmn(['t'=>'upd']);
				}
			}else{
				$__chk_postcmn = $this->PostCmn();
			}

			if($__chk_postcmn->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['prc'] = $__chk_postcmn;
				$rsp['id'] = $__chk_postcmn->id;
				$rsp['enc'] = $__chk_postcmn->enc;
				$rsp['upd'] = 'ok';
			}

		}elseif($this->__t == 'acc_post_rct'){

			$rsp['usinall'] = $this->UsInAll();

			$__fromdt = GtSclFromDt(['id'=>$this->postrct_from]);
			$__chk_postrct = $this->PostRctChk(['sclaccpost'=>$this->postrct_post, 'from'=>$__fromdt->id ]);

			if($__chk_postrct->e == 'ok'){
				if(!isN($__chk_postrct->id)){
					$this->postrct_id_upd = $__chk_postrct->id;
					$__chk_upd = $this->PostRct(['t'=>'upd']);
				}
			}else{
				$__chk_postrct = $this->PostRct();
			}

			if($__chk_postrct->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['prc'] = $__chk_postrct;
				$rsp['id'] = $__chk_postrct->id;
				$rsp['enc'] = $__chk_postrct->enc;
				$rsp['upd'] = 'ok';
			}

		}

		return _jEnc($rsp);

	}



	public function SclAccClDt($p=NULL){

		global $__cnx;

		if(!isN($p)){

			$Vl['e'] = 'no';

			if(!isN($p['sclacc']) && ($p['tp'] == 'id') ){ $__f .= sprintf(' AND id_sclacc = %s ', GtSQLVlStr($p['sclacc'], 'text')); }
			elseif(!isN($p['sclacc'])){ $__f .= sprintf(' AND sclacc_enc= %s ', GtSQLVlStr($p['sclacc'], 'text')); }else
			if(!isN($p['cl'])){ $__f .= sprintf(' AND clsclacc_cl= %s ', GtSQLVlStr($p['cl'], 'text')); }

			$query_DtRg = '	SELECT *
							FROM '._BdStr(DBM).TB_CL_SCL_ACC.'
								INNER JOIN '._BdStr(DBT).TB_SCL_ACC.' ON clsclacc_sclacc = id_sclacc
							WHERE id_clsclacc != "" '.$__f;

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_clsclacc'];
					$Vl['cl'] = $row_DtRg['clsclacc_cl'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	public function Scl_Cl_Acc($p=NULL){

		global $__cnx;

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($this->sclacc_enc)){

		    $__chk = $this->SclAccClDt([ 'cl'=>DB_CL_ID, 'sclacc'=>$this->sclacc_enc ]);

			if($this->sclacc_est == 1 && $__chk->e != 'ok'){

	    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_SCL_ACC." (clsclacc_cl,clsclacc_sclacc) VALUES (%s, (SELECT id_sclacc FROM "._BdStr(DBT).TB_SCL_ACC." WHERE sclacc_enc=%s) )",
                       GtSQLVlStr(DB_CL_ID, "int"),
                       GtSQLVlStr($this->sclacc_enc, "text"));

			}elseif($this->sclacc_est == 2 && $__chk->e == 'ok'){

				$_sql_s = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_SCL_ACC." WHERE clsclacc_cl=%s AND clsclacc_sclacc=(SELECT id_sclacc FROM "._BdStr(DBT).TB_SCL_ACC." WHERE sclacc_enc=%s)",
                   GtSQLVlStr(DB_CL_ID, "int"),
                   GtSQLVlStr($this->sclacc_enc, "text"));
			}

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
			if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }

	public function Upd_Acc_Fld(){

		global $__cnx;

		if($this->t == 'est'){ $__id= 'sclacc_est'; $__vl=$this->sclacc_est; }

		if(!isN($__vl) && !isN($__id)){

				$query_DtRg = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC." SET ".$__id."=%s WHERE sclacc_enc=%s",
							GtSQLVlStr(ctjTx($__vl,'out'), "text"),
	                       	GtSQLVlStr(ctjTx($this->sclacc_enc,'out'), "text"));
				$DtRg = $__cnx->_prc($query_DtRg);

				if($this->sclacc_data->acc_id != ''){

					foreach($this->sclacc_data->acc_scl as $ka=>$va){
						if(!isN($va->tlvd)){
							$rsp['subscribed'] = _NwFb_Acc_Sbsc(['id'=>$this->sclacc_data->acc_id, 'access_token'=>$va->tlvd]);
							if(!isN( $rsp['subscribed']->r )){ break; }
						}
					}

				}

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['cl'] = $this->Scl_Cl_Acc();
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);
	}







	public function AccAttrDt($p=NULL){

		global $__cnx;

	   	$Vl['e'] = 'no';

		if(!isN($p) && !isN($p['key']) && !isN($p['id'])){

			if(!isN($p['key'])){ $__f .= ' AND sclaccattr_key='.GtSQLVlStr($p['key'], 'text').' '; }
			if(!isN($p['id'])){ $__f .= ' AND sclaccattr_sclacc='.GtSQLVlStr($p['id'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '._BdStr(DBT).TB_SCL_ACC_FORM_ATTR.' WHERE id_sclaccattr != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sclaccattr'];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}


    public function Acc_Attr($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';
	    $rsp['p'] = $p;

	    if(!isN($this->acc_attr)){

		    $rsp['ls'] = $this->acc_attr;

		    if(!isN($this->acc_attr)){

			    foreach($this->acc_attr as $k=>$v){

					$__chk = $this->AccAttrDt([ 'key'=>$k, 'id'=>$this->acc_id_upd ]);


					if(is_array($v)){
						$__v = json_encode($v);
					}elseif(is_object($v)){
						$__v = json_encode($v, true);
					}else{
						$__v = $v;
					}

					if($__chk->e == 'ok' && !isN($__chk->id) && !isN($__v)){

			    		$_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_SCL_ACC_ATTR." SET sclaccattr_vl=%s WHERE sclaccattr_sclacc=%s AND sclaccattr_key=%s",
		                       GtSQLVlStr(ctjTx($__v,'out'), "text"),
		                       GtSQLVlStr($this->form_id_upd, "int"),
		                       GtSQLVlStr($k, "text"));

					}elseif(!isN($this->acc_id_upd) && !isN($k) && !isN($__v)){

						$__enc = Enc_Rnd($k.'-'.$this->acc_id_upd);

			    		$_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_ACC_ATTR." (sclaccattr_enc, sclaccattr_sclacc, sclaccattr_key, sclaccattr_vl) VALUES (%s, %s, %s, %s)",
		                       GtSQLVlStr($__enc, "text"),
		                       GtSQLVlStr($this->acc_id_upd, "int"),
		                       GtSQLVlStr($k, "text"),
		                       GtSQLVlStr(ctjTx($__v,'out'), "text"));
					}

					if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }
					if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = 'No result:'.$__cnx->c_p->error; }

			    }
		    }

		}else{
			$rsp['w'] = TX_FLTDTINC;
		}
		return _jEnc($rsp);
    }






	public function EmlAttrDt($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['key']) && !isN($p['id']) && !isN($p['tp'])){

			if(!isN($p['key'])){ $__f .= ' AND emlattr_key='.GtSQLVlStr($p['key'], 'text').' '; }
			if(!isN($p['id'])){ $__f .= ' AND emlattr_id='.GtSQLVlStr($p['id'], 'text').' '; }
			if(!isN($p['tp'])){ $__f .= ' AND emlattr_tp='.GtSQLVlStr($p['tp'], 'text').' '; }

			$query_DtRg = 'SELECT * FROM '.TB_THRD_EML_ATTR	.' WHERE id_emlattr != "" '.$__f.' LIMIT 1';
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_emlattr'];
				}
			}else{
				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No data on P';
		}
		return(_jEnc($Vl));
	}



	public function SclAccTknLs($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['acc'])){

			if(!isN($p['acc'])){ $__f .= ' AND sclaccscl_acc='.GtSQLVlStr($p['acc'], 'text').' '; }

			$query_DtRg = '	SELECT id_sclattr, sclattr_key, sclattr_vl
							FROM '._BdStr(DBT).TB_SCL_ACC_SCL.'
								 INNER JOIN '._BdStr(DBT).TB_SCL.' ON sclaccscl_scl = id_scl
								 INNER JOIN '._BdStr(DBT).TB_SCL_ATTR.' ON sclattr_scl = id_scl
							WHERE id_sclattr != "" AND
								  sclattr_tp = "scl" AND
								  sclattr_key = "tknlvd"
								  '.$__f.'';

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				do{

					$_id = $row_DtRg['id_sclattr'];

					if(!isN($_id)){

						$Vl['ls'][$_id]['id'] = $row_DtRg['id_sclattr'];
						$Vl['ls'][$_id]['key'] = ctjTx($row_DtRg['sclattr_key'],'in');
						$Vl['ls'][$_id]['vl'] = ctjTx($row_DtRg['sclattr_vl'],'in');

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{

				$rsp['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No data on P';

		}

		return(_jEnc($Vl));

	}



	public function SclFormQusOptGetMdlDt($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['form']) && !isN($p['data'])){

			if(!isN($p['bd'])){
				$__bd = $p['bd'];
			}else{
				$__dt_cl = __Cl(['id'=>DB_CL_ENC, 't'=>'enc' ]);
				$__bd = $__dt_cl->bd;
			}

			$__qus = $this->SclFormQusLs([ 'id'=>$p['form'] ]);
			$_lead_data = $p['data'];

			// Search field match with list of modules
			if(!isN($__qus->ls)){
				foreach($__qus->ls as $__qus_k=>$__qus_v){
					if($__qus_v->upfld_vl == 'mdl_gen'){
						$_fld_sch_key = $__qus_v->key;
						$_fld_sch_enc = $__qus_v->key_c;
						$_fld_opt = $this->SclFormQusOptLs([ 'bd'=>$__bd, 'id'=>$__qus_v->id,'tp'=>$__qus_v->upfld_vl]);
						break;
					}
				}
			}

			if(!isN($_fld_opt)){

				// Search value filled by user
				foreach($_lead_data as $_lead_data_k=>$_lead_data_v){
					if($_fld_sch_enc == enCad($_lead_data_v->name)){
						$_fld_sch_opt_key = $_lead_data_v->values[0];
						break;
					}
				}

				// Search value match with module id
				if(!isN($_fld_sch_opt_key)){
					foreach($_fld_opt->ls as $_fld_opt_k=>$_fld_opt_v){
						if($_fld_sch_opt_key == $_fld_opt_v->key){
							$_fld_sch_opt_id = $_fld_opt_v->id;
							break;
						}
					}
				}

			}

			if(!isN($_fld_sch_opt_id)){

				$query_DtRg = 	sprintf('
									SELECT id_mdl
									FROM '._BdStr($__bd).TB_SCL_ACC_FORM_QUS_OPT_MDL.'
										 INNER JOIN '._BdStr($__bd).TB_MDL.' ON sclaccformqusoptmdl_mdl = id_mdl
									WHERE sclaccformqusoptmdl_qusopt=%s
									LIMIT 1',
									GtSQLVlStr($_fld_sch_opt_id, 'text')
								);

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$Vl['e'] = 'ok';
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_mdl'];
					}

				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

				$__cnx->_clsr($DtRg);

			}


		}else{

			$Vl['w'] = 'No data on P';

		}

		return(_jEnc($Vl));
	}

	public function EmlBoxEstChck_Upd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if($this->est == 'ok'){ $est = 1; }else{ $est = 2; }

		$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_BOX." SET ".$this->cmp."=%s WHERE emlbox_enc=%s",
							GtSQLVlStr($est, "int"),
							GtSQLVlStr($this->enc, "text"));

		$Result = $__cnx->_prc($updateSQL);

		if($Result){
			$rsp['e'] = 'ok';
		}else{
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);
	}

}



?>