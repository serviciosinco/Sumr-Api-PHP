<?php

class API_CRM_Auto extends CRM_Main{


	function __construct($p=NULL) {

		$this->__btch_id = Gn_Rnd(20);

		if(defined('MACHINE_WRKR') && MACHINE_WRKR == 'ok'){
			ini_set('max_execution_time', 60000);
		}

		define('GL_AWS', DIR_CNT.'aws/');
		define('GL_CNS', DIR_CNT.'cns/');
		define('GL_MDL', DIR_CNT.'mdl/');
		define('GL_EC', DIR_CNT.'ec/');
		define('GL_ATMT', DIR_CNT.'atmt/');
		define('GL_CALL', DIR_CNT.'call/');
		define('GL_TOT', DIR_CNT.'tot/');
		define('GRP_FL_SND', DIR_CNT.'snd/');
		define('GRP_FL_UP', DIR_CNT.'up/');
        define('GRP_FL_DWN', DIR_CNT.'dwn/');
        define('GRP_FL_LCK', DIR_CNT.'lck/');
		define('GRP_FL_TOT', DIR_CNT.'tot/');
		define('GRP_FL_TMP', DIR_CNT.'tmp/');
		define('GRP_FL_VTEX', DIR_CNT.'vtex/');
		define('GRP_FL_US', DIR_CNT.'us/');


        if(!isN($p['argv'])){

			$this->_argv = $p['argv'];

			$this->g__i = $this->_argv->__i;

			$this->g__e = $this->_argv->__e;

			$this->g__t = $this->_argv->_t;
			$this->g__t2 = $this->_argv->_t2;
			$this->g__lmt = $this->_argv->_lmt;

			$this->g__s = $this->_argv->_s;
			$this->g__s2 = $this->_argv->_s2;
			$this->g__s3 = $this->_argv->_s3;

			$this->g__force = $this->_argv->_force;

			if(!isN( $this->_argv->_cjid )){
				$this->g__cjid = $this->_argv->_cjid;
			}

			$this->g__rnd = $this->_argv->_rnd;

			$this->g__ssh = $this->_argv->ssh;


			if(!isN($this->_argv->cshow)){ $this->g__cshow = $this->_argv->cshow; }

			$this->g__cfrmt = $this->_argv->cfrmt;

			$this->g_exec = $this->_argv->_exec;

		}

		if(!isN($_GET)){

			$this->g__i = Php_Ls_Cln($_GET['__i']);
			$this->g__e = Php_Ls_Cln($_GET['__e']);
			$this->g__t = Php_Ls_Cln($_GET['_t']);
			$this->g__t2 = Php_Ls_Cln($_GET['_t2']);

			$this->g__lmt = Php_Ls_Cln($_GET['_lmt']);
			$this->g__bd = Php_Ls_Cln($_GET['_bd']);

			$this->g__s = Php_Ls_Cln($_GET['_s']);
			$this->g__s2 = Php_Ls_Cln($_GET['_s2']);
			$this->g__s3 = Php_Ls_Cln($_GET['_s3']);

			$this->g__sz = Php_Ls_Cln($_GET['_sz']);

			$this->g__force = Php_Ls_Cln($_GET['_force']);

			if(!isN(Php_Ls_Cln($_GET['_cjid']))){
				$this->g__cjid = Php_Ls_Cln($_GET['_cjid']);
			}

			$this->g__us = Php_Ls_Cln($_GET['__us']);
			$this->g__fst = Php_Ls_Cln($_GET['_fst']);
			$this->g_exec = Php_Ls_Cln($_GET['_exec']);
			$this->g__rnd = Php_Ls_Cln($_GET['_rnd']);



			if(!isN(Php_Ls_Cln($_GET['ssh']))){
				$this->g__ssh = Php_Ls_Cln($_GET['ssh']);
			}

			if(!isN(Php_Ls_Cln($_GET['cshow']))){
				$this->g__cshow = Php_Ls_Cln($_GET['cshow']);
			}

			if(!isN(Php_Ls_Cln($_GET['cfrmt']))){
				$this->g__cfrmt = Php_Ls_Cln($_GET['cfrmt']);
			}


		}

		if(!isN($_POST)){


			$this->g__i = Php_Ls_Cln($_POST['__i']);
			$this->g__e = Php_Ls_Cln($_POST['__e']);
			$this->g__t = Php_Ls_Cln($_POST['_t']);
			$this->g__t2 = Php_Ls_Cln($_POST['_t2']);

			$this->g__lmt = Php_Ls_Cln($_POST['_lmt']);
			$this->g__bd = Php_Ls_Cln($_POST['_bd']);

			$this->g__s = Php_Ls_Cln($_POST['_s']);
			$this->g__s2 = Php_Ls_Cln($_POST['_s2']);
			$this->g__s3 = Php_Ls_Cln($_POST['_s3']);

			$this->g__sz = Php_Ls_Cln($_POST['_sz']);

			$this->g__force = Php_Ls_Cln($_POST['_force']);

			$this->g__us = Php_Ls_Cln($_GET['__us']);
			$this->g__fst = Php_Ls_Cln($_POST['_fst']);

			if(!isN(Php_Ls_Cln($_POST['_cjid']))){
				$this->g__cjid = Php_Ls_Cln($_POST['_cjid']);
			}

			$this->g_exec = Php_Ls_Cln($_POST['_exec']);
			$this->g__rnd = Php_Ls_Cln($_POST['_rnd']);

			$this->g_lmt = Php_Ls_Cln($_POST['lmt']);

			if(!isN(Php_Ls_Cln($_POST['ssh']))){
				$this->g__ssh = Php_Ls_Cln($_POST['ssh']);
			}

			if(!isN(Php_Ls_Cln($_POST['cshow']))){
				$this->g__cshow = Php_Ls_Cln($_POST['cshow']);
			}

			if(!isN(Php_Ls_Cln($_POST['cfrmt']))){
				$this->g__cfrmt = Php_Ls_Cln($_POST['cfrmt']);
			}

		}

		$this->g__f = substr($_SERVER['REQUEST_URI'], 1);
		$this->g__aws_p = _jEnc(_PostRw());
		$this->__pm_1 = PrmLnk('rtn', 1, 'ok');
		$this->__pm_2 = PrmLnk('rtn', 2, 'ok');
		$this->__pm_3 = PrmLnk('rtn', 3, 'ok');
		$this->__pm_4 = PrmLnk('rtn', 4, 'ok');
		$this->___getmxexc = ini_get('max_execution_time');

		if(isN($p['cl'])){
	        $this->cl = GtClDt( Gt_SbDMN(), "sbd");
	    }else{
		    $this->cl = $p['cl'];
	    }

		$this->_aws = new API_CRM_Aws();
		$this->_up = new CRM_Up();
		$this->_snd = new API_CRM_Snd();
		$this->_ws = new CRM_Ws;

        //$this->_ec = new API_CRM_ec();

		$this->_s_cl = GtClLs([ 'on'=>'ok', 'rnd'=>'ok' ]); // System Clientes
		$this->_s_eml = GtClEmlLs([ 'on'=>'ok', 'onl'=>'ok', 'rnd'=>'ok', 'tp'=>_CId('ID_SISEML_IMAP') ]); // System Clientes

        $this->_massive = new API_CRM_Massive();
        $this->_wthsp = new CRM_Wthsp();
		$this->_vtex = new CRM_VTex();
		$this->_ntf = new CRM_Ntf();
		$this->_gtwy = new CRM_Gtwy([ 'cl'=>$p['cl'] ]);

    }


	function __destruct() {
		parent::__destruct();
   	}


	public function WrkrOn(){
		if(defined('MACHINE_WRKR_E') && !isN(MACHINE_WRKR_E) && MACHINE_WRKR_E == encAd(SIS_ENCI)){
			return true;
		}elseif($this->g__e == encAd(SIS_ENCI)){
			return true;
		}else{
			return false;
		}
	}

	public function _Auto_Inc($f=NULL){

		global $__cnx;

		if(PHP_VERSION > 6){
			$___pth = dirname(__FILE__, 4);
		}else{
			$___pth = dirname(dirname(dirname(dirname(__FILE__))));
		}

		$f = $___pth.'/_auto/'.$f;

		if(file_exists($f)){

			$__tme_s = microtime(true);

			try {
				require_once($f); /*$__tmexc = _Rg_Tme($__tme_s, microtime(true), ['f'=>$f]);*/
			} catch (Exception $e) {
				echo $this->err('AUTOINC:'.$e->getMessage());
				echo $this->err( print_r($e, true) );
			}

		}else{

			echo $this->err('AUTOINC:'.$f.' no existe');
			echo $this->err( print_r($e, true) );

		}

	}

	public function UpdF($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($p)){

			if($p['t']=='ec_cmpg'){ $tb=TB_EC_CMPG; $_bd=DBM; $fld=$p['f']; $id='id_eccmpg'; }
			elseif($p['t']=='whtsp'){ $tb=TB_WHTSP; $_bd=DBT; $fld=$p['f']; $id='id_wthsp'; }

			if(!isN($tb) && !isN($_bd) && !isN($p['v'])){
				$updateSQL = sprintf("UPDATE "._BdStr($_bd).$tb." SET ".$fld."=%s WHERE ".$id."=%s",
								   GtSQLVlStr($p['v'], "text"),
								   GtSQLVlStr($p['id'], "int"));
				$Result = $__cnx->_prc($updateSQL);

				if($Result){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = $__cnx->c_p->error; }
			}
		}

		return _jEnc($rsp);
	}


	public function Lck(){

		$__chk = $this->Chck();

		$rsp['chk'] = $__chk;

		if($__chk->e != 'ok'){
			$__in = $this->In();
			$rsp['in'] = $__in;
			if($__in->e == 'ok'){ $__chk = $this->Chck(); }
		}

		if($__chk->e == 'ok'){
			$this->autop_id = $__chk->id;
			$__rd = $this->Rd([ 'e'=>$this->rd ]);

			if($__rd->e == 'ok'){
				$rsp['rd'] = $this->rd=='ok'?'ok':'no';
			}
		}

		return _jEnc($rsp);
	}



	public function tallw($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if($p['t'] == 'key'){ $__f = 'autotp_key'; $__ft = 'text'; }
			elseif($p['t'] == 'enc'){ $__f = 'autotp_enc'; $__ft = 'text'; }
			else{ $__f = 'id_autotp'; $__ft = 'int'; }

			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$query_DtRg = "SELECT * FROM "._BdStr(DBA).TB_AUTO_TP."
							WHERE ".$__f." = '".$p['id']."'
							LIMIT 1
						";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_autotp'];
					$Vl['enc'] = $row_DtRg['autotp_enc'];
					$Vl['prnt'] = $row_DtRg['autotp_prnt'];
					$Vl['nm'] = $row_DtRg['autotp_nm'];
					$Vl['key'] = $row_DtRg['autotp_key'];
					$Vl['est'] = mBln($row_DtRg['autotp_e']);
					$Vl['lmt'] = $row_DtRg['autotp_lmt_rg'];

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No id data';

		}

		return _jEnc($Vl);

	}

	public function tallw_cl($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if($p['t'] == 'key'){ $__f = 'autotp_key'; $__ft = 'text'; }
			elseif($p['t'] == 'enc'){ $__f = 'autotp_enc'; $__ft = 'text'; }
			else{ $__f = 'id_autotp'; $__ft = 'int'; }

			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$query_DtRg = "	SELECT *
							FROM "._BdStr(DBA).TB_AUTO_TP."
								 INNER JOIN "._BdStr(DBA).TB_AUTO_CL." ON autocl_tp = id_autotp
							WHERE ".$__f."='".$p['id']."' AND autocl_cl='".$p['cl']."'
							LIMIT 1
						";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_autotp'];
					$Vl['enc'] = $row_DtRg['autotp_enc'];
					$Vl['prnt'] = $row_DtRg['autotp_prnt'];
					$Vl['nm'] = $row_DtRg['autotp_nm'];
					$Vl['key'] = $row_DtRg['autotp_key'];
					$Vl['est'] = mBln($row_DtRg['autocl_e']);
					$Vl['lmt'] = $row_DtRg['autoto_lmt_rg'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);

		}
	}



	public function Rd($p=NULL){

		global $__cnx;

		if(!isN($this->autop_id)){

			if($p['e']=='ok'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_AUTO_PRC." SET autoprc_e=%s WHERE id_autoprc=%s LIMIT 1",
										   			GtSQLVlStr($__e, "int"),
													GtSQLVlStr($this->autop_id, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; }

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'no data';
		}
		$rtrn = _jEnc($rsp);
		if(!isN($rtrn)){ return($rtrn); }
	}


	public function Btch($p=NULL){

		global $__cnx;

		if(!isN($this->autop_id)){

			if($p['rst']=='ok'){ $__b = ''; }else{ $__b = $this->btch_id; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_AUTO_PRC." SET autoprc_btch=%s WHERE id_autoprc=%s LIMIT 1",
													GtSQLVlStr($__b, "text"),
										   			GtSQLVlStr($this->autop_id, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; }

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'no data';
		}

		$rtrn = _jEnc($rsp);
		if(!isN($rtrn)){ return($rtrn); }

	}


	public function Chck($p=NULL){

		global $__cnx;

		if(!isN($this->k) && !isN($this->t)){

			if(!isN($p['tme'])){ $_tme = $p['tme']; }else{ $_tme = 5; }

			$__qry = sprintf('	SELECT *,
									   ( autoprc_fa < NOW() - INTERVAL '.$_tme.' MINUTE ) AS __rd_aft
								FROM '._BdStr(DBA).TB_AUTO_PRC.'
								WHERE autoprc_tp=%s AND autoprc_key=%s
								LIMIT 1', GtSQLVlStr($this->t, 'text'), GtSQLVlStr($this->k, 'text'));

			$DtRg = $__cnx->_prc($__qry);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_autoprc'];
					$this->autop_id = $row_DtRg['id_autoprc'];

					$Vl['btch'] = $row_DtRg['autoprc_btch'];
					$Vl['rd'] = mBln($row_DtRg['autoprc_e']);
					$Vl['aft'] = mBln($row_DtRg['__rd_aft']);

				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_p->error;
				}
			}else{
				$Vl['w'] = $__cnx->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['r'] = 'no';
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}


	public function In($p=NULL){

		global $__cnx;

		if(!isN($this->k) && !isN($this->t)){

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_AUTO_PRC." (autoprc_tp, autoprc_key, autoprc_btch) VALUES (%s, %s, %s)",
	                       GtSQLVlStr( $this->t, "text"),
						   GtSQLVlStr( $this->k, "text"),
						   GtSQLVlStr( $this->btch_id, "text"));

			$Result = $__cnx->_prc($insertSQL);

	 		if($Result){
		 		$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$this->w_all .= $__cnx->c_p->error;
			}

		}else{
			$rsp['e'] = 'no';
		}

		$rtrn = _jEnc($rsp);
		if(!isN($rtrn)){ return($rtrn); }
	}




	public function EcSnd_Upd($p=NULL){

		global $__cnx;

		if (!isN($this->id_ecsnd)) {

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }
			if(!isN($p['e'])){ $est = $p['e']; }else{ $est = _CId('ID_SNDEST_SND'); }

			$updateSQL = sprintf("UPDATE ".$_bd.TB_MDL_EC_SND." SET ecsnd_est=%s WHERE id_ecsnd=%s LIMIT 1",
							   GtSQLVlStr($est, "int"),
							   GtSQLVlStr($this->id_ecsnd, "int"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['es'] = $updateSQL;
			}

		}else{

			$rsp['ess'] = $this->id_ecsnd;

		}

		return _jEnc($rsp);

	}


	public function EcSnd_Rd($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->id_ecsnd)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			if(!isN($_p['btch'])){ $_upd_f .= sprintf(", ecsnd_btch=%s", GtSQLVlStr($_p['btch'], "text")); }
			if(!isN($_p['btch_c'])){ $_upd_f .= sprintf(", ecsnd_btch=%s", GtSQLVlStr(NULL, "text")); }

			$updateSQL = sprintf("UPDATE "._BdStr($_p['bd']).TB_MDL_EC_SND." SET ecsnd_rd=%s, ecsnd_rd_f=%s {$_upd_f} WHERE id_ecsnd=%s LIMIT 1",
									   GtSQLVlStr($__e, "int"),
									   GtSQLVlStr(SIS_F_D, "date"),
									   GtSQLVlStr($this->id_ecsnd, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			//$rsp['q'] = $updateSQL;

			if($Result_UPD){

				$__dt_snd = GtEcSndBtch([ 'id'=>$this->id_ecsnd, 'bd'=>$_p['bd'] ]);
				$rsp['d'] = $__dt_snd;

				if(!isN($__dt_snd->id) && !isN($__dt_snd->btch)){
					$rsp['e'] = 'ok';
					$rsp['btch'] = $__dt_snd->btch;
				}else{
					$rsp['w'] = 'No detail after update';
				}

			}else{

				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_r->error.' on '.$updateSQL;

			}

		}else{

			$rsp['w'] = 'Empty $this->id_ecsnd';

		}

		return _jEnc($rsp);

	}


	public function EcSndMlt_Rd($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($_p['ids'])){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			if(!isN($_p['btch'])){ $_upd_f .= sprintf(", ecsnd_btch=%s", GtSQLVlStr($_p['btch'], "text")); }
			if(!isN($_p['btch_c'])){ $_upd_f .= sprintf(", ecsnd_btch=%s", GtSQLVlStr(NULL, "text")); }

			$updateSQL = sprintf("UPDATE "._BdStr($_p['bd']).TB_MDL_EC_SND." SET ecsnd_rd=%s, ecsnd_rd_f=%s {$_upd_f} WHERE id_ecsnd IN(".implode(',', $_p['ids']).") LIMIT 1",
									   GtSQLVlStr($__e, "int"),
									   GtSQLVlStr(SIS_F_D, "date"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			$rsp['q'] = $updateSQL;

			if($Result_UPD){

				$rsp['e'] = 'ok';

			}else{

				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_r->error.' on '.$updateSQL;

			}

		}else{

			$rsp['w'] = 'Empty $this->id_ecsnd';

		}

		return _jEnc($rsp);

	}


	public function EcSnd_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($this->id_ecsnd)){

			$__qry = sprintf(' 	SELECT id_ecsnd, ecsnd_rd, ecsnd_id, ecsnd_est, ecsnd_rd_f, ecsnd_btch, ecsnd_html_btch
								FROM '._BdStr($p['bd']).TB_MDL_EC_SND.'
								WHERE id_ecsnd=%s LIMIT 1', GtSQLVlStr($this->id_ecsnd, 'int')
							);

			$query_DtRg = $__qry;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_ecsnd'];
					$Vl['rd'] = mBln($row_DtRg['ecsnd_rd']);
					$Vl['btch'] = $row_DtRg['ecsnd_btch'];
					$Vl['html']['btch'] = $row_DtRg['ecsnd_html_btch'];

					$Vl['cid'] = $row_DtRg['ecsnd_id'];
					$Vl['est'] = $row_DtRg['ecsnd_est'];

					$_diffd = _Df_Dte($row_DtRg['ecsnd_rd_f'], SIS_F_TS, ['_fr'=>'c', 'wkn'=>'no'] );

					if(!isN($_diffd)){
						$Vl['diff'] = $_diffd;
					}

				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_r->error;
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['r'] = 'no';

		}

		return _jEnc($Vl);

	}





	public function SmsSnd_Upd($p=NULL){

		global $__cnx;

		if (!isN($this->id_smssnd)) {

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }
			if(!isN($p['e'])){ $est = $p['e']; }else{ $est = _CId('ID_SNDEST_SND'); }

			$updateSQL = sprintf("UPDATE ".$_bd.TB_SMS_SND." SET smssnd_est=%s WHERE id_smssnd=%s",
							   GtSQLVlStr($est, "int"),
							   GtSQLVlStr($this->id_smssnd, "int"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				//$rsp['es'] = $updateSQL;
			}

		}else{
			$rsp['ess'] = $this->id_smssnd;
		}
		return _jEnc($rsp);
	}


	public function SmsSnd_Rd($_p=NULL){

		global $__cnx;

		if(!isN($this->id_smssnd)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			if(!isN($_p['btch'])){ $_upd_f .= sprintf(", smssnd_btch=%s", GtSQLVlStr($_p['btch'], "text")); }
			if(!isN($_p['btch_c'])){ $_upd_f .= sprintf(", smssnd_btch=%s", GtSQLVlStr(NULL, "text")); }


			$updateSQL = sprintf("UPDATE "._BdStr($_p['bd']).TB_SMS_SND." SET smssnd_rd=%s {$_upd_f} WHERE id_smssnd=%s",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr($this->id_smssnd, "int")); //$rsp['q'] = $updateSQL;

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){
				$rsp['e'] = 'ok';
				$rsp['btch'] = $_p['btch'];
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_p->error;
			}

			return _jEnc($rsp);
		}
	}



	public function SmsSnd_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($this->id_smssnd)){

			$__qry = sprintf(' SELECT * FROM '._BdStr($p['bd']).TB_SMS_SND.' WHERE id_smssnd=%s LIMIT 1', GtSQLVlStr($this->id_smssnd, 'int'));

			$query_DtRg = $__qry;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_smssnd'];
					$Vl['rd'] = mBln($row_DtRg['smssnd_rd']);
					$Vl['btch'] = $row_DtRg['smssnd_btch'];
				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_r->error;
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}


	public function SmsSndCmpg_Chk($_p=NULL){

		global $__cnx;

		if(!isN($this->id_smscmpg) && !isN($this->smscmpg_cel)){

			$Qry = "SELECT *
						FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND."
						WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = '".$this->id_smscmpg."' AND smssnd_cel = '".$this->smscmpg_cel."'
						GROUP BY smssnd_cel
					    ORDER BY id_smssndcmpg";

			$DtRg = $__cnx->_qry($Qry);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg == 1){
				$_v['e'] = 'ok';
				$_v['id'] = $row_DtRg['id_smssndcmpg'];
			}else{
				$_v['e'] = 'no';
			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_v);

	}



	public function ClFljSnd_Upd($p=NULL){

		global $__cnx;

		if (!isN($this->id_clfljsnd)) {

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }
			if(!isN($p['e'])){ $est = $p['e']; }else{ $est = _CId('ID_SNDEST_SND'); }

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_FLJ_SND." SET clfljsnd_id=%s, clfljsnd_est=%s, clfljsnd_rd=%s WHERE id_clfljsnd=%s",
							   GtSQLVlStr($this->clfljsnd_id, "text"),
							   GtSQLVlStr($est, "int"),
							   GtSQLVlStr(2, "int"),
							   GtSQLVlStr($this->id_clfljsnd, "int"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['es'] = $updateSQL;
			}


		}else{
			$rsp['ess'] = $this->id_clfljsnd;
		}
		return _jEnc($rsp);
	}


	public function ClFljSnd_Rd($_p=NULL){

		global $__cnx;

		if(!isN($this->id_clfljsnd)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }
			if(!isN($_p['btch'])){ $_upd_f .= sprintf(", clfljsnd_btch=%s", GtSQLVlStr($_p['btch'], "text")); }


			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_FLJ_SND." SET clfljsnd_rd=%s, clfljsnd_rd_f=%s {$_upd_f} WHERE id_clfljsnd=%s",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($this->id_clfljsnd, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){
				$rsp['e'] = 'ok';
				$rsp['id'] = $this->id_clfljsnd;
				$rsp['btch'] = $_p['btch'];
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $_p['bd'];
			}

			return _jEnc($rsp);
		}
	}



	public function ClFljSnd_Chk($p=NULL){

		global $__cnx;

		if(!isN($this->id_clfljsnd)){

			$__qry = sprintf(' SELECT * FROM '._BdStr(DBM).TB_CL_FLJ_SND.' WHERE id_clfljsnd=%s LIMIT 1', GtSQLVlStr($this->id_clfljsnd, 'int'));
			$query_DtRg = $__qry;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_clfljsnd'];
					$Vl['btch'] = $row_DtRg['clfljsnd_btch'];
					$Vl['rd'] = mBln($row_DtRg['clfljsnd_rd']);
				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_r->error;
				}
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['r'] = 'no';
		}
		return _jEnc($Vl);
	}







	public function CntEcLsts_Chk($_p=NULL){

		global $__cnx;

		$_v['e'] = 'no';

		if(!isN($this->ec_lsts_id) && !isN($_p['eml'])){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }

			$Qry = "	SELECT *
						FROM ".$_bd.TB_EC_LSTS_EML."
							 INNER JOIN ".$_bd.TB_CNT_EML." ON eclstseml_eml = id_cnteml
						WHERE eclstseml_lsts = '".$this->ec_lsts_id."' AND cnteml_eml = '".strtolower($_p['eml'])."'
					    ORDER BY id_eclstseml";

			$DtRg = $__cnx->_qry($Qry, ['cmps'=>'ok']);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$_v['e'] = 'ok';
					$_v['id'] = $row_DtRg['id_eclstseml'];
				}else{
					$_v['e'] = 'no';
				}

			}else{

				$_v['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$_v['m'] = 'no_all_data $this->ec_lsts_id:'.$this->ec_lsts_id.' eml:'.$_p['eml'];

		}

		return _jEnc($_v);

	}

	public function Inc_Fle($p=NULL){

		global $__cnx;

		if(!isN($p['f'])){

			$__tme_s = microtime(true);

			echo '<div class="__fle">';

			try {

				echo '<div class="__wrp">';
				include($p['f']);
				echo '</div>';

			} catch (Exception $e) {

			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";

			    if (PHP_VERSION < 6) {
			    	//break;
			   	}

			}

			$__tmexc = _Rg_Tme($__tme_s, microtime(true));
			$pnl_t = $__tmexc->tme_s;
			echo h3('Total Time: '.Spn($pnl_t), '_tme');
			echo '</div>';

		}
	}




	public function UpCol_Chk($p=NULL){

		global $__cnx;

		if(!isN($this->id_upcol)){

			$__qry = sprintf(' SELECT * FROM '._BdStr(DBP).MDL_UP_COL_BD.' WHERE id_upcol=%s LIMIT 1', GtSQLVlStr($this->id_upcol, 'int'));
			$query_DtRg = $__qry;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_upcol'];
					$Vl['rd'] = mBln($row_DtRg['upcol_rd']);
				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_r->error;
				}
			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['r'] = 'no';
		}
		return(_jEnc($Vl));
	}



	public function RquDt($p=NULL){

		global $__cnx;

		$this->tme_s = microtime(true);

	    $Vl['e'] = 'no';

		if(!isN($p) && !isN($p['t']) ){

			if(!isN($p['t'])){ $__f .= ' AND autorqu_tp='.GtSQLVlStr($p['t'], 'text').' '; }
			if(!isN($p['id'])){ $__f .= ' AND autorqu_id='.GtSQLVlStr($p['id'], 'text').' '; }else{ $__f .= " AND autorqu_id= '[NOID]' "; }
			if(!isN($p['cl'])){ $__f .= ' AND autorqu_cl='.GtSQLVlStr($p['cl'], 'text').' '; }
			if(!isN($p['nxt'])){ $__f .= ' AND autorqu_nxt='.GtSQLVlStr($p['nxt'], 'text').' '; }
			if(!isN($p['pge'])){ $__f .= ' AND autorqu_pge='.GtSQLVlStr($p['pge'], 'text').' '; }
			if(!isN($p['all'])){ $__f .= ' AND autorqu_all='.GtSQLVlStr($p['all'], 'text').' '; }

			if(!isN($__cnx->c_r->thread_id)){

				$query_DtRg = 'SELECT * FROM '._BdStr(DBA).TB_AUTO_RQU.' WHERE id_autorqu != "" '.$__f.' LIMIT 1';
				$DtRg = $__cnx->_qry($query_DtRg);

			}else{

				$Vl['w'] = 'Connection not active';

			}

			if($DtRg){

				$Vl['e'] = 'ok';

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $Vl['tot'] = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$_diffd = _Df_Dte($row_DtRg['autorqu_f_chk'], SIS_F_TS, ['_fr'=>'c', 'wkn'=>'no'] );

					if(!isN($_diffd)){

						$Vl['diff'] = $_diffd;

						if(	!isN($_diffd->s) && !isN($p['s']) &&
							($_diffd->s >= $p['s'] || $_diffd->i > 0 || $_diffd->H > 0)
						){
							$Vl['hb'] = 'ok';
						}elseif(!isN($_diffd->i) && !isN($p['m']) && ($_diffd->i >= $p['m'] || $_diffd->H > 0)){
							$Vl['hb'] = 'ok';
							$Vl['m_lck'] = $_diffd->i;
						}else{
							$Vl['hb'] = 'no';
						}

					}

					$Vl['e'] = 'ok';
					$Vl['t'] = $p['t'];
					$Vl['id'] = $row_DtRg['id_autorqu'];
					$Vl['nxt'] = $row_DtRg['autorqu_nxt'];
					$Vl['cl'] = $row_DtRg['autorqu_cl'];
					$Vl['cid'] = $row_DtRg['autorqu_id'];
					$Vl['pge'] = $row_DtRg['autorqu_pge'];
					$Vl['pge_tot'] = $row_DtRg['autorqu_pge_tot'];
					$Vl['f_chk'] = $row_DtRg['autorqu_f_chk'];
					$Vl['all'] = mBln($row_DtRg['autorqu_all']);


					$Vl['lck'] = mBln($row_DtRg['autorqu_lock']);

					$Vl['date']['next'] = $row_DtRg['autorqu_date_next'];
					$Vl['date']['start'] = $row_DtRg['autorqu_date_start'];

					$Vl['old']['pge'] = $row_DtRg['autorqu_old_pge'];
					$Vl['old']['pge_tot'] = $row_DtRg['autorqu_old_pge_tot'];
					$Vl['old']['all'] = mBln($row_DtRg['autorqu_old_all']);

				}else{

					$Vl['hb'] = 'ok';
					$Vl['lck'] = mBln($row_DtRg['autorqu_lock']);

				}

			}else{

				$Vl['w'] = 'RquDt:'.print_r($__cnx->c_r, true);

			}

			if(!isN($query_DtRg)){
				$__cnx->_clsr($DtRg);
			}

		}else{

			$Vl['w'] = 'Auto - No data on P';

		}

		return(_jEnc($Vl));

	}


	public function Rqu($p=NULL){

	    global $__cnx;

	    $rsp['e'] = 'no';

	    if( !isN($p) && !isN($p['t']) ){

			//$_aws = new API_CRM_Aws();

			$__dt = $this->RquDt([ 't'=>$p['t'], 'id'=>$p['id'], 'cl'=>$p['cl'] ]);

			if(!isN($this->tme_s)){ $__tmexc = _Rg_Tme($this->tme_s, microtime(true)); }
			if(isN($p['id'])){ $p['id']='[NOID]'; }

			if($__dt->e == 'ok' && !isN($__dt->id)){

				if(!isN($p['id'])){ $fupd .= sprintf(', autorqu_id=%s', GtSQLVlStr($p['id'],"text") ); }
				if(!isN($p['cl'])){ $fupd .= sprintf(', autorqu_cl=%s', GtSQLVlStr($p['cl'],"text") ); }
				if(!isN($p['nxt'])){ $fupd .= sprintf(', autorqu_nxt=%s', GtSQLVlStr($p['nxt'],"text") ); }
				if(!isN($p['pge'])){ $fupd .= sprintf(', autorqu_pge=%s', GtSQLVlStr($p['pge'],"text") ); }
				if(!isN($p['pge_tot'])){ $fupd .= sprintf(', autorqu_pge_tot=%s', GtSQLVlStr($p['pge_tot'],"text") ); }
				if(!isN($p['all'])){ $fupd .= sprintf(', autorqu_all=%s', GtSQLVlStr($p['all'],"text") ); }
				if(!isN($p['lck'])){ $fupd .= sprintf(', autorqu_lock=%s', GtSQLVlStr($p['lck'],"text") ); }

				if(!isN($p['date_start'])){ $fupd .= sprintf(', autorqu_date_start=%s', GtSQLVlStr($p['date_start'],"date") ); }
				if(!isN($p['date_next'])){ $fupd .= sprintf(', autorqu_date_next=%s', GtSQLVlStr($p['date_next'],"date") ); }

				if(!isN($__tmexc)){ $fupd .= sprintf(', autorqu_tme=%s', GtSQLVlStr($__tmexc,"text") ); }

				if(!isN($p['old_pge'])){ $fupd .= sprintf(', autorqu_old_pge=%s', GtSQLVlStr($p['old_pge'],"text") ); }
				if(!isN($p['old_pge_tot'])){ $fupd .= sprintf(', autorqu_old_pge_tot=%s', GtSQLVlStr($p['old_pge_tot'],"text") ); }
				if(!isN($p['old_all'])){ $fupd .= sprintf(', autorqu_old_all=%s', GtSQLVlStr($p['old_all'],"text") ); }


				$fupd .= sprintf(', autorqu_f_chk=%s', GtSQLVlStr(SIS_F_TS,"date") );

                $_sql_s = sprintf("UPDATE "._BdStr(DBA).TB_AUTO_RQU." SET autorqu_tp=%s, autorqu_cjid=%s {$fupd} WHERE id_autorqu=%s LIMIT 1",
							   GtSQLVlStr($p['t'], "text"),
							   GtSQLVlStr($this->g__cjid, "text"),
							   GtSQLVlStr($__dt->id, "int"));

			}else{

				if(!isN($p['id'])){ $fin_f .= ', autorqu_id'; $fin_v .= sprintf(',%s', GtSQLVlStr($p['id'],"text") ); }
				if(!isN($p['cl'])){ $fin_f .= ', autorqu_cl'; $fin_v .= sprintf(',%s', GtSQLVlStr($p['cl'],"text") ); }
				if(!isN($p['nxt'])){ $fin_f .= ', autorqu_nxt'; $fin_v .= sprintf(',%s', GtSQLVlStr($p['nxt'],"text") ); }
				if(!isN($p['pge'])){ $fin_f .= ', autorqu_pge'; $fin_v .= sprintf(',%s', GtSQLVlStr($p['pge'],"text") ); }
				if(!isN($p['all'])){ $fin_f .= ', autorqu_all'; $fin_v .= sprintf(',%s', GtSQLVlStr($p['all'],"text") ); }
				if(!isN($p['lck'])){ $fupd .= sprintf(', autorqu_lock=%s', GtSQLVlStr($p['lck'],"text") ); }
				if(!isN($__tmexc)){ $fin_f .= ', autorqu_tme'; $fin_v .= sprintf(',%s', GtSQLVlStr($__tmexc,"text") ); }

				$fin_f .= ', autorqu_f_chk'; $fin_v .= sprintf(',%s', GtSQLVlStr(SIS_F_TS,"date") );

				$_sql_s = sprintf("INSERT INTO "._BdStr(DBA).TB_AUTO_RQU." (autorqu_tp, autorqu_cjid {$fin_f}) VALUES (%s, %s {$fin_v})",
												GtSQLVlStr($p['t'], "text"),
												GtSQLVlStr($this->g__cjid, "text"));
			}

			//$rsp['qry'] = $_sql_s;

			if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s, ['cmps'=>'ok']); }
			if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['w'] = $_sql_s.' -> No result:'.$__cnx->c_p->error; }

		}else{

			$rsp['w'] = TX_FLTDTINC;

		}

		return _jEnc($rsp);

	}

    public function Atmt_Rd($_p=NULL){

		global $__cnx;

		if(!isN($this->id_atmt)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT." SET atmt_rd=%s, atmt_rd_f=%s WHERE id_atmt=%s",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($this->id_atmt, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL, ['cmps'=>'ok']);

			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; $rsp['w'] = $_p['bd']; }
			return _jEnc($rsp);
		}
	}



	public function Atmt_Chk($p=NULL){

		global $__cnx;

		if(!isN($this->id_atmt)){

			$__qry = sprintf(' 	SELECT id_atmt, atmt_rd
								FROM '._BdStr(DBA).TB_ATMT.'
								WHERE id_atmt=%s LIMIT 1', GtSQLVlStr($this->id_atmt, 'int'));

			$query_DtRg = $__qry;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_atmt'];
					$Vl['rd'] = mBln($row_DtRg['atmt_rd']);
				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_r->error;
				}
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['r'] = 'no';
		}

		return _jEnc($Vl);
	}



	public function _UsBupd_Rq($p=NULL){
		/*
		global $__cnx;

		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_BUPD." (usbupd_us, usbupd_cl) VALUES (%s,%s) ON DUPLICATE KEY UPDATE usbupd_f=%s",
						   GtSQLVlStr( SISUS_ID, "text"),
						   GtSQLVlStr( $this->cl->id, "text"),
						   GtSQLVlStr( SIS_F2.' '.SIS_H2, "date"));

		$Result = $__cnx->_prc($insertSQL);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
		}

		$rtrn = _jEnc($rsp);
		return($rtrn); */
	}


	public function _UsBupd_Dt($p=NULL){

		global $__cnx;

		if(!isN($p['us'])){ $__us = $p['us']; }else{ $__us =  SISUS_ID; }
		if(!isN($p['cl'])){ $__cl = $p['cl']; }else{ $__cl = $this->cl->id; }

		$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_US_BUPD." WHERE usbupd_us=%s AND usbupd_cl=%s LIMIT 1",
								GtSQLVlStr($__us, "int"),
								GtSQLVlStr($__cl, "int"));

		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;

		if($Tot_DtRg > 0){

			$Vl['id'] = $row_DtRg['id_usbupd'];
			$Vl['us'] = $row_DtRg['usbupd_us'];
			$Vl['cl'] = $row_DtRg['usbupd_cl'];
			$Vl['f'] = $row_DtRg['usbupd_f'];

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}


	public function _RTme($p=NULL){

		if($p['start'] == 'ok'){
			$this->__tme_s = microtime(true);
		}else{
			$this->__tmexc = _Rg_Tme($this->__tme_s, microtime(true), [ 'btch'=>$this->btch_id, 'tp'=>$p['tp'] ]);
			if($this->__tmexc->est == 'ok'){
				//unset($this->__tme_s);
			}
		}

	}


	public function ttFgr($_p=NULL){
		if(!$this->isSsh()){
			if(!isN($_p->lgo->main->big)){
				return('<figure class="cl_logo" style="background-image:url('.$_p->lgo->main->big.');"></figure>');
			}
		}
	}


	public function isSsh(){
		if(($this->g__ssh == 'on' || !isN($this->_argv) || ( defined('MACHINE_POST') && MACHINE_POST == 'ok' )) && $this->g__ssh != 'off'){ return true; }else{ return false; }
	}


	public function cronShow(){
		if($this->g__cshow == 'on'){ return true; }else{ return false; }
	}



	public function cExc(){ // Can Execute It?
		if((defined('SYS_AUTO') && SYS_AUTO == 'on') || $this->g_exec == 'ok'){ return true; }else{ return false; }
	}




	public function tb($n=NULL){

		if($this->g__cfrmt != 'json'){

			if(isN($n)){ $n=1; }
			for ($i=1; $i<=$n; $i++) {
			    $_r .= "   ";
			}
			return $_r;

		}

	}

	public function br($n=NULL){

		if($this->g__cfrmt != 'json' && ( isWrkr() || $this->cExc() ) ){

			if(isN($n)){ $n=1; }
			for ($i=1; $i<=$n; $i++) {
				if($this->isSsh()){
					$_r .= PHP_EOL;
			    }else{
				    $_r .= HTML_BR;
			    }
			}
			return $_r;

		}
	}

	public function clr($t=NULL,$c=NULL){
		return "\e[".$c."m".$t."\e[0m";
	}

	public function h1($t=NULL,$c=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){
				return $this->br(1).$this->clr('::::'.date("Y-m-d H:i:s").' '.$t.'::::', '36').$this->br(1);
			}else{
				return h1(date("Y-m-d H:i:s").' '.$t,$c=NULL).$this->br(1);
			}
		}
	}

	public function h2($t=NULL,$o=NULL,$c=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){

				if($o['n']==2){ $tb1=''; $tb2=''; }
				elseif($o['n']==3){ $tb1=''; $tb2=''; }
				else{ $tb1=/*$this->br().*/$this->tb(); $tb2=$this->br(); }

				return $tb1.$this->clr('---- '.date("Y-m-d H:i:s").' '.$t.' ----', '35').$tb2;
			}else{

				return h2(date("Y-m-d H:i:s").' '.$t,$c);

			}
		}
	}

	public function nallw($t=NULL,$o=NULL,$c=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){

				if($o['n']==2){ $tb1=''; $tb2=''; }
				elseif($o['n']==3){ $tb1=''; $tb2=''; }
				else{ $tb1=/*$this->br().*/$this->tb(); $tb2=$this->br(); }

				return $tb1.$this->clr('---- '.date("Y-m-d H:i:s").' 🛑 '.$t.' ----', '31').$tb2;
			}else{

				return h2( date("Y-m-d H:i:s").' 🛑 '.$t,$c, 'color:red;' );

			}
		}
	}

	public function h3($t=NULL,$o=NULL,$c=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){

				if($o['n']==2){ $tb1=''; $tb2=''; }
				elseif($o['n']==3){ $tb1=''; $tb2=''; }
				else{ $tb1=$this->br().$this->tb(2); $tb2=$this->br(); }

				return $tb1.$this->clr('**--------------//'.date("Y-m-d H:i:s").' '.$t.' ****', '34').$tb2;

			}else{
				return h3($t,$c);
			}
		}
	}




	public function ul($t=NULL,$c=NULL,$s=NULL,$o=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){

				if($o['n']==2){
					$tb1=$this->br(2).$this->tb(4); $tb2=$this->br(3);
				}elseif($o['n']==3){
					$tb1=$this->br().$this->tb(5); $tb2=$this->br(3);
				}elseif($o['n']==4){
					$tb1=$this->br().$this->tb(6); $tb2=$this->br(3);
				}else{
					$tb1=$this->br().$this->tb(3); $tb2=$this->br(3);
				}

				return 	$tb1.$this->clr('---------------------------------------------------', '32').$this->br(2).
							 $this->clr($t, '33').
						$tb1./*$this->clr('---------------------------------------------------', '32').*/
						$tb2;

			}else{
				return ul($t,$c,$s);
			}
		}
	}



	public function li($t=NULL,$c=NULL,$o=NULL,$w='no'){

		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){

			if($this->isSsh()){

				if($o['sb']=='ok'){

					return $t;

				}else{

					if($o['n']==2){ $tb=$this->tb(4); }
					if($o['n']==3){ $tb=$this->tb(6); }
					else{ $tb=$this->tb(4); }

					if($w=='no'){ $_clr='37'; }else{ $_clr='31'; }
					return /*$this->br().*/$tb. $this->clr( '◘ '.date("Y-m-d H:i:s").' '.$t, $_clr).$this->br();

				}

			}else{

				return li( '<code>'.date("Y-m-d H:i:s").$t.'</code>' , $c);

			}
		}
	}


	public function Spn($t=NULL,$c=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){
				return $this->clr($t, '33');
			}else{
				return Spn($t,$c);
			}
		}
	}

	public function Strn($t=NULL,$c=NULL){
		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){
			if($this->isSsh()){
				return $this->clr($t, '33');
			}else{
				return Strn($t,$c);
			}
		}
	}



	public function err($t=NULL){

		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){

			if($this->isSsh()){

				$__tot = strlen($t);

				for($i=1; $i<=$__tot+10; $i++){ $__f1 .= '*'; }
				for($i=1; $i<=$__tot+8; $i++){ $__f2 .= ' '; }
				for($i=1; $i<=$__tot+8; $i++){ $__f3 .= ' '; }

				$_r .= $this->tb(4).$this->clr('/'.$__f1.'/', '31').$this->br();
				$_r .= $this->tb(4).$this->clr('/*'.$__f2.'*/', '31').$this->br();
				$_r .= $this->tb(4).$this->clr('/*   🤬 '.$t.'  */', '31').$this->br();
				$_r .= $this->tb(4).$this->clr('/*'.$__f3.'*/', '31').$this->br();
				$_r .= $this->tb(4).$this->clr('/'.$__f1.'/', '31').$this->br();

			}else{

				return '<span style="color:red;">'.$t.'</span>'.HTML_BR;

			}
		}

		return $_r;

	}




	public function scss($t=NULL){

		if(!isN($t) && $this->cronShow() && $this->g__cfrmt != 'json'){

			if($this->isSsh()){

				$__tot = strlen($t);

				for($i=1; $i<=$__tot+10; $i++){ $__f1 .= '*'; }
				for($i=1; $i<=$__tot+8; $i++){ $__f2 .= ' '; }
				for($i=1; $i<=$__tot+8; $i++){ $__f3 .= ' '; }

				$_r .= $this->tb(4).$this->clr('/'.$__f1.'/', '32').$this->br();
				$_r .= $this->tb(4).$this->clr('/*'.$__f2.'*/', '32').$this->br();
				$_r .= $this->tb(4).$this->clr('/*   💚 '.$t.'  */', '32').$this->br();
				$_r .= $this->tb(4).$this->clr('/*'.$__f3.'*/', '32').$this->br();
				$_r .= $this->tb(4).$this->clr('/'.$__f1.'/', '32').$this->br();

			}else{

				return '<span style="color:green;">'.$t.'</span>'.HTML_BR;

			}
		}

		return $_r;

	}


	public function _GtFCss($_u=NULL){

		$__ntf_tp = __LsDt([ 'k'=>'ntf_tp' ]);

		foreach($__ntf_tp->ls->ntf_tp as $_tp_k=>$_tp_v){
			$__noty_css .= '.noty_message.noty_'.$_tp_v->cls->vl.'{ background-image:url('.$_tp_v->img.'); background-color:'.$_tp_v->{'clr_bck'}->vl.'; color:'.$_tp_v->{'clr_fnt'}->vl.' !important; }';
			$__noty_css .= '.noty_message.noty_'.$_tp_v->cls->vl.' h2{ color:'.$_tp_v->{'clr_fnt'}->vl.'; }';
		}

		try{

			/*
			$CurlRQ = new CRM_Out();
			$CurlRQ->url = $_u.'?_etag='.E_TAG.'&_rndm='.Gn_Rnd(50);
			$CurlRQ->sve = 'no';
			$CurlRQ->o_encnull = 'ok';
			$rsp = $CurlRQ->_Rq();
			*/


			$__usch = [
				'[FESTR]',
				'[FSVG]',
				'[FWDGT]',
				'[FESTRICN]',
				'[FANM]',
				'[FEC]',
				'[FFNT]',
				'[LOGO_MAIN]',
				'[CSSNOTY]',
				'[CL_IMG_ESTR]',
				'[SISEST_PAPRB]',
				'[DSH_LSNUM]',
				'[DSH_LSGRPH]',
				'[DSH_DMS]',
				'[DSH_MTRC]'
			];

			$__uchn = [
				DMN_IMG_ESTR,
				DMN_IMG_ESTR_SVG,
				DMN_IMG_ESTR_WDGT,
				DMN_IMG_ESTR_ICN,
				DMN_ANM,
				DMN_EC,
				DMN_FONT,
				LOGO_MAIN,
				$__noty_css,
				CL_IMG_ESTR,
				ID_SISEST_PAPRB,
				LsNum('dshcolprs_cant', 6, ''),
				LsGrph('id_grph','id_grph', '', FM_LS_ASGNTRS, 1, ''),
				LsDms('id_dshdms','id_dshdms', '', TX_DIMNS, 1),
				LsMtrc('id_dshmtrc','id_dshmtrc', '', TX_DIMNS, 1)
			];

			$pth = dirname(dirname(dirname(__FILE__))).'/_sty/_fl/'.$_u;
			$cfle = file_get_contents( $pth );
			$cfle = str_replace($__usch,$__uchn,$cfle);


			//echo $this->h2( 'Getting '.$pth );

			if($cfle){
				$r['code'] = $cfle;
			}else{
				$r['w'] = 'Not a css render, read empty';  //exit();
			}


		}catch (Exception $e){

	        $strResponse = "";
	        $strErrorCode = $e->getCode();
	        $strErrorMessage = $e->getMessage();
	        //print_r($arrCurlInfo, $strErrorCode, $strErrorMessage);
	        //die;

	        $r['w'] = $strErrorMessage;

	    }

		return $r;
	}


	public function _BldCss($_p=NULL){


		try{

			if( (SUMR_ENV != 'prd' && SUMR_ENV != 'dev' && DMN_S != 'sumrdev.com' && DMN_S != 'sumr.co') ){
				$__pth = ___CSS_CRM;
			}

			$_gt = '';

			//$_r .= ___JS_HDR;

			$_d = DMN_CSS;

			foreach($_p['a'] as $_k => $_v){

				if( $_p['iF'] == 'ok' ){

					if($_v['iF'] != 'no'){

						$_gt = $this->_GtFCss( $_d.$_v['s'] );

						if(!isN($_gt['code'])){

							$_r .= $_gt['code'];

							if($_p['f'] == 'sb/acc/main.css'){ echo $this->h2('Se incluye '.$_d.$_v['s']. ' para '. $__pth.$_p['f'] ); }

							$_rspnsv = _CSS_Rsp([ 'nm'=>$_v['s'] ]); //print_r( $_rspnsv );

							if(!isN($_rspnsv)){
								foreach($_rspnsv as $_rspnsv_k=>$_rspnsv_v){
									$_gt = _GtFCss( $_rspnsv_v->fle);
									$_r .= $_rspnsv_v->strt.$_gt['code'].$_rspnsv_v->end;
								}
							}

						}else{

							//echo $this->err('No se incluye '.$_d.$_v['s'] .print_r($_gt, true) );

						}

					}else{

						//echo $this->err('No se incluye '.$_v['s']. ' para iFrame');

					}

				}else{

					$_gt = $this->_GtFCss( $_v['s'] );

					if(!isN($_gt['code'])){

						$_r .= $_gt['code'];

						if($_p['f'] == 'sb/acc/main.css'){ echo $this->h2('Se incluye '.$_d.$_v['s']. ' para '. $__pth.$_p['f'] ); }

						$_rspnsv = _CSS_Rsp([ 'nm'=>$_v['s'] ]);

						foreach($_rspnsv as $_rspnsv_k=>$_rspnsv_v){

							$_gt = $this->_GtFCss( $_rspnsv_v->fle);
							$_r .= $_rspnsv_v->strt.$_gt['code'].$_rspnsv_v->end;

						}


					}else{
						//echo $this->err('No se incluye '.$_d.$_v['s'] . print_r($_gt, true) );
						//exit();
					}
				}
			}

			//$_r .= ___JS_FTR;

			if(!isN($_r)){

				if( (SUMR_ENV == 'prd' || SUMR_ENV == 'dev' || DMN_S == 'sumrdev.com' || DMN_S == 'sumr.co') ){

					//echo $this->h3('Build:'.$_p['f']);
					//$_aws = new API_CRM_Aws();

					/*if(SUMR_ENV == 'prd'){ $_cfr='ok'; }else{*/ $_cfr='no';/* }*/
					$result_sve = $this->_aws->_s3_put([ 'b'=>'css', 'fle'=>$_p['f'], 'cbdy'=>cmpr_css($_r), 'ctp'=>'text/css', 'utf8'=>'ok', 'cfr'=>$_cfr ]);

				}else{

					//echo $this->h3('Build:'.$__pth.'_bld/'.$_p['f']);
					$_fle = fopen($__pth.'_bld/'.$_p['f'], "w") or die("Unable to open file ".$__pth.$_p['f']);
					fwrite($_fle, cmpr_css($_r) );
					fclose($_fle);

				}

			}


		}catch (Exception $e){

	        echo $this->err( $e->getMessage() );

	    }


	}



	public function _GtFJs($_u=NULL){

		try{

			$__clrs = __LsDt([ 'k'=>'tra_col_clr' ]);
			$__icns = __LsDt([ 'k'=>'tra_col_icn', 'rnd'=>'ok' ]);

			foreach($__icns->ls->tra_col_icn as $k=>$v){
				$__icns_o .= "
					'".$v->enc."':{
						enc:'".$v->enc."',
						tt:'".$v->tt."',
						cns:'".$v->cns."',
						img:'".$v->img."',
						img_v:{
							ext:'".$v->img_v->ext."',
							big:'".$v->img_v->big."'
						},
						clsf:{
							enc:'".$v->clsf->enc."',
							vl:'".$v->clsf->vl."',
							slc:{
								id:'".$v->clsf->slc->id."',
								enc:'".$v->clsf->slc->enc."',
								tt:'".$v->clsf->slc->tt."'
							}
						}
					},
				";

				$__icns_all_o[ $v->clsf->vl ][ $v->id ] = $v;

			}

			$__icns_all_o = $__icns_all_o;

			foreach($__icns_all_o as $k=>$v){

				foreach($v as $kk=>$vv){
					$_clsf_k=_Cns('TX_TRA_ICN_CLSF_'.strtoupper($vv->clsf->vl));
				}

				$__icns_all .= "

						".$k.":{
							tt:'".$_clsf_k."',
							ls:{
						";

						if(is_array($v)){
							foreach($v as $k2=>$v2){
								$__icns_all .= "
									".$v2->id.":{
										enc:'".$v2->enc."',
										tt:'".$v2->tt."',
										cns:'".$v2->cns."',
										img:'".$v2->img."',
										img_v:{
											ext:'".$v2->img_v->ext."',
											big:'".$v2->img_v->big."'
										},
										clsf:{
											enc:'".$v2->clsf->enc."',
											vl:'".$v2->clsf->vl."',
											slc:{
												id:'".$v2->clsf->slc->id."',
												enc:'".$v2->clsf->slc->enc."',
												tt:'".$v2->clsf->slc->tt."'
											}
										}
									},
								";
							}
						}

				$__icns_all .= "
							}
						},
				";
			}

			foreach($__clrs->ls->tra_col_clr as $k=>$v){
				$__clr_slc .= '<cell class="_anm" title="'.$v->tt.'" data-color-value="'.$v->clr->vl.'" data-color-id="'.$v->clr->slc->enc.'" data-column-id="COL-ID"><div style="background-color:'.$v->clr->vl.'" class="_anm"></div></cell>';
			}

			$__usch = [
				'[ETAG]',
				'[ISDEV]',
				'[DMN_S]',
				'[DMN_JS]',
				'[DMN_CSS]',
				'[DMN_OAUTH]',
				'[DMN_WSS]',
				'[DMN_LND]',
				'[DMN_FLE]',
				'[DMN_IMG]',
				'[DMN_ANM]',
				'[DMN_FLE_PS_TH]',
				'[TRA_ICNS]',
				'[TRA_ICNS_C]',
				'[TRA_CLR]',
			];
			$__uchn = [
				E_TAG,
				(Dvlpr()?'ok':'no'),
				DMN_S,
				DMN_JS,
				DMN_CSS,
				DMN_OAUTH,
				DMN_WSS,
				DMN_LND,
				DMN_FLE,
				DMN_IMG,
				DMN_ANM,
				DMN_FLE_PS_TH,
				$__icns_o,
				$__icns_all,
				$__clr_slc,
			];


			$pth = dirname(dirname(dirname(__FILE__))).'/_js/'.$_u;
			$cfle = file_get_contents( $pth );
			$cfle = str_replace($__usch,$__uchn,$cfle);


			preg_match_all('/{{(.*?)}}/', $cfle, $_cns);

			foreach($_cns[0] as &$Key_cns){
				$_key_cns = str_replace(['{{','}}'],'',$Key_cns);
				$_key_vle = _Cns($_key_cns);
				$cfle = str_replace($Key_cns, $_key_vle, $cfle);
			}
			//echo $this->h2( 'Getting '.$pth );

			if(!isN($cfle)){
				$r['code'] = $cfle;
			}else{
				$r['w'] = 'Not a javascript render, read empty';  //exit();
			}


		}catch (Exception $e){

	        $strResponse = "";
	        $strErrorCode = $e->getCode();
	        $strErrorMessage = $e->getMessage();
	        //print_r($arrCurlInfo, $strErrorCode, $strErrorMessage);
	        //die;

	        $r['w'] = $strErrorMessage;

	    }

		return $r;
	}


	public function _BldJs($_p=NULL){

		try{

			if( (SUMR_ENV != 'prd' && SUMR_ENV != 'dev' && DMN_S != 'sumrdev.com') ){
				$__pth = ___JS_CRM;
			}

			$_gt = '';

			//$_r .= ___JS_HDR;

			$_d = DMN_JS;

			foreach($_p['a'] as $_k => $_v){

				if( $_p['iF'] == 'ok' ){

					if($_v['iF'] != 'no'){

						$_gt = $this->_GtFJs( $_d.$_v['s'] );

						if(!isN($_gt['code'])){
							if($_p['cmpr']!='no' && $_v['cmpr']!='no'){
								$_r .= cmpr_js($_gt['code']);
							}else{
								$_r .= $_gt['code'];
							}
							//echo $this->h2('Se incluye '.$_d.$_v['s']. ' para '. $__pth.$_p['f'] );
						}else{
							//echo $this->err('No se incluye '.$_d.$_v['s'] .print_r($_gt, true) );
						}

					}else{

						//echo $this->err('No se incluye '.$_v['s']. ' para iFrame');

					}

				}else{

					$_gt = $this->_GtFJs( $_v['s'] );

					if(!isN($_gt['code'])){
						if($_p['cmpr']!='no' && $_v['cmpr']!='no'){
							$_r .= cmpr_js($_gt['code']);
						}else{
							$_r .= $_gt['code'];
						}
						//echo $this->h2('Se incluye '.$_d.$_v['s']. ' para '. $__pth.$_p['f'] );
					}else{
						//echo $this->err('No se incluye '.$_d.$_v['s'] . print_r($_gt, true) );
						//exit();
					}
				}
			}

			//$_r .= ___JS_FTR;

			if(!isN($_r)){

				if( (SUMR_ENV == 'prd' || SUMR_ENV == 'dev' || DMN_S == 'sumrdev.com' || DMN_S == 'sumr.co') ){

					echo $this->h3('AWS Build:'.$_p['f']);
					//$_aws = new API_CRM_Aws();
					/*if(SUMR_ENV == 'prd'){ $_cfr='ok'; }else{ */$_cfr='no';/* }*/

					$result_sve = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>$_p['f'], 'cbdy'=>$_r, 'ctp'=>'text/javascript', 'utf8'=>'ok', 'cfr'=>$_cfr ]);

				}else{

					echo $this->h3('Local Build:'.$__pth.$_p['f']);
					$_fle = fopen($__pth.$_p['f'], "w") or die("Unable to open file ".$__pth.$_p['f']);
					fwrite($_fle, cmpr_js($_r) );
					fclose($_fle);

				}

			}


		}catch (Exception $e){

	        echo $e->getMessage();

	    }


	}




	public function EcCmpg_Rd($_p=NULL){

		global $__cnx;

		if(!isN($this->id_eccmpg)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_rd=%s, eccmpg_rd_f=%s, eccmpg_rd_tot=%s WHERE id_eccmpg=%s LIMIT 1",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($_p['tot'], "int"),
					   GtSQLVlStr($this->id_eccmpg, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){
				$rsp['e'] = 'ok';
				$rsp['btch'] = $_p['btch'];
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $_p['bd'];
			}

			return _jEnc($rsp);
		}
	}



	public function EcCmpg_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($this->id_eccmpg)){

			$__qry = sprintf(' SELECT id_eccmpg, eccmpg_rd, eccmpg_btch FROM '._BdStr(DBM).TB_EC_CMPG.' WHERE id_eccmpg=%s LIMIT 1', GtSQLVlStr($this->id_eccmpg, 'int'));

			$query_DtRg = $__qry;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eccmpg'];
					$Vl['rd'] = mBln($row_DtRg['eccmpg_rd']);
					$Vl['btch'] = $row_DtRg['eccmpg_btch'];
				}else{
					$Vl['e'] = 'no';
					$Vl['q_e'] = $__cnx->c_r->error;
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['r'] = 'no';

		}

		return _jEnc($Vl);

	}




	public function EcLstsEmlSgm_Chk($_p=NULL){

		global $__cnx;

		$_v['e'] = 'no';

		if(!isN($_p['sgm']) && !isN($_p['eml'])){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }

			$Qry = sprintf("
							SELECT *
							FROM ".$_bd.TB_EC_LSTS_EML_SGM."
							WHERE eclstsemlsgm_lstssgm=%s AND eclstsemlsgm_eml=%s
							LIMIT 1
						",
						GtSQLVlStr($_p['sgm'], 'int'),
						GtSQLVlStr($_p['eml'], 'int'));

			$DtRg = $__cnx->_qry($Qry);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$_v['e'] = 'ok';
					$_v['id'] = $row_DtRg['id_eclstsemlsgm'];
				}else{
					$_v['e'] = 'no';
				}

			}else{

				$_v['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$_v['m'] = 'no_all_data';

		}

		return _jEnc($_v);

	}



	public function __snd_ec_btch($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($_p['bd']) && !isN( $_p['ids'] ) && is_array($_p['ids'])){

			if($_p['t']=='html'){ $__f_rd='ecsnd_html_rd'; $__f_rd_f='ecsnd_html_rd_f'; $__f_btc='ecsnd_html_btch'; }
			else{ $__f_rd='ecsnd_rd'; $__f_rd_f='ecsnd_rd_f'; $__f_btc='ecsnd_btch'; }

			$updateSQL = sprintf("UPDATE "._BdStr($_p['bd']).TB_EC_SND." SET ".$__f_rd."=%s, ".$__f_rd_f."=%s, ".$__f_btc."=%s WHERE id_ecsnd IN (%s)",
								   GtSQLVlStr(1, "int"),
								   GtSQLVlStr(SIS_F_D2, "date"),
								   GtSQLVlStr( $_p['btch'] , "text"),
								   implode(',', $_p['ids'])
								);

			$Result = $__cnx->_prc($updateSQL);

			$rsp['qry'] = $updateSQL;

			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}

		}else{

			$rsp['w'] = 'No data';

		}

		return _jEnc($rsp);

	}




	public function _cln_fldr_tmp($dir=NULL, $sub=1){

		$__dir_stat = stat($dir);

		echo $this->h1($dir.' '.$sub);
		//echo $this->h2(print_r($__dir_stat, true));



		$__dir_dtte = date("Y-m-d H:i:s", $__dir_stat['mtime']);
		$__dir_f1 = new DateTime($__dir_dtte);
		$__dir_f2 = new DateTime(SIS_F2);
		$__dir_dif = $__dir_f1->diff($__dir_f2);


		echo $this->h2($__dir_stat['size']);
		echo $this->h2("Last modified: ".$__dir_dtte);


	    $ffs = scandir($dir);

	    unset($ffs[array_search('.', $ffs, true)]);
	    unset($ffs[array_search('..', $ffs, true)]);

		$__count_oc = count($ffs);


	    if($__count_oc > 0){

		    foreach($ffs as $ff){

				$__o = $dir.$ff;
				$__fle_dtte = date("Y-m-d H:i:s", filemtime($__o));
			    $__f1 = new DateTime($__fle_dtte);
				$__f2 = new DateTime(SIS_F2);
				$__dif = $__f1->diff($__f2);

		        if(is_dir($__o)){

			        $this->_cln_fldr_tmp($__o.'/', ($sub+1));

			    }elseif(is_file($__o)){

				    if(!isN($__fle_dtte) && !isN($__dif->d) && $__dif->d > 1){
					    echo $this->h3($__o);
						echo $this->li("Last modified: ".$__fle_dtte);
						echo $this->li("Days After Created: ".$__dif->d );

						if(unlink($__o)){
							echo $this->scss('Archivo borrado exitosamente');
						}

					}

			    }

		    }

	    }else{

		    if(is_dir($dir) && $sub > 1){

			    if(rmdir($dir)){
				    echo $this->scss('Carpeta borrada exitosamente');
			    }

		    }

	    }

	}



	public function _AwsSta_In($p=NULL){

		global $__cnx;

		if(!isN($p['accrsrc']) && !isN($p['type']) && !isN($p['date']) && !isN($p['value'])){

			$__enc = Enc_Rnd( $p['accrsrc'].'-'.$p['type'].'-'.$p['date'] );

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_AWS_RSRC_STA." (awsrsrcsta_enc, awsrsrcsta_awsaccrsrc, awsrsrcsta_type, awsrsrcsta_date, awsrsrcsta_value) VALUES (%s, %s, %s, %s, %s)",
			                       GtSQLVlStr($__enc, "text"),
			                       GtSQLVlStr($p['accrsrc'], "int"),
								   GtSQLVlStr($p['type'], "text"),
								   GtSQLVlStr($p['date'], "date"),
								   GtSQLVlStr($p['value'], "text"));

			$Result = $__cnx->_prc($insertSQL);

	 		if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_p->error;
			}

		}

		return _jEnc($rsp);
	}



	public function EcLsts_Rd($_p=NULL){

		global $__cnx;

		if(!isN($this->id_eclsts)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS." SET eclsts_rd=%s, eclsts_rd_f=%s WHERE id_eclsts=%s LIMIT 1",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($this->id_eclsts, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){
				$rsp['e'] = 'ok';
				$rsp['btch'] = $_p['btch'];
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $_p['bd'];
			}

			return _jEnc($rsp);
		}
	}



	public function EcLstsSgm_Rd($_p=NULL){

		global $__cnx;

		if(!isN($this->id_eclstssgm)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS_SGM." SET eclstssgm_rd=%s, eclstssgm_rd_f=%s WHERE id_eclstssgm=%s LIMIT 1",
					   GtSQLVlStr($__e, "int"),
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($this->id_eclstssgm, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){
				$rsp['e'] = 'ok';
				$rsp['btch'] = $_p['btch'];
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $_p['bd'];
			}

			return _jEnc($rsp);
		}
	}


	public function Dwn_Rd($_p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->id_dwn)){

			if($_p['e'] == 'on'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_rd=%s, dwn_rd_f=%s {$_upd_f} WHERE id_dwn=%s LIMIT 1",
									   GtSQLVlStr($__e, "int"),
									   GtSQLVlStr(SIS_F_D, "date"),
									   GtSQLVlStr($this->id_dwn, "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);

			$rsp['q'] = $updateSQL;

			if($Result_UPD){

				$rsp['e'] = 'ok';

			}else{

				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_r->error.' on '.$updateSQL;

			}

		}else{

			$rsp['w'] = 'Empty $this->id_dwn';

		}

		return _jEnc($rsp);

	}


}




?>