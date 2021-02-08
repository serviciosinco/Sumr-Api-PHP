<?php

function DemoBD($b=NULL, $d=NULL){
	if($d){ $_r = str_replace('sumr', 'sumrapp', $b); }else{ $_r = $b; } return($_r);
}

function CnCls($c=NULL,$f=NULL){
	CnFre($f);
	if(is_object($c) && get_class($c) == 'mysqli' && $c != NULL){
		@$c->close();
	}
}


function CnOut($p=NULL){
	if(!isN($p['h']) && !isN($p['u']) && !isN($p['p'])){
		$_cn = new mysqli($p['h'], $p['u'], $p['p']);
		return($_cn);
	}
}


// Conexiones PDO
function CnRd_Pdo($p=NULL){

	if($p['d']=='prc' && defined('DB_PRC')){ $_bd = DB_PRC; }
	elseif($p['d']=='cl' && defined('DB_CL')){ $_bd = DB_CL; }
	elseif($p['d']=='cht' && defined('DBC')){ $_bd = DBC; }
	elseif($p['d']=='thrd' && defined('DBT')){ $_bd = DBT; }
	elseif($p['d']=='dwn' && defined('DB_DWN')){ $_bd = DB_DWN; }
	elseif($p['d']=='aut' && defined('DB_AUT')){ $_bd = DB_AUT; }
	else{ $_bd = DB; }


	$options = [
	  PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
	  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
	  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
	];

	try {
	 	$__pdodrvr = PDO::getAvailableDrivers();

		if(in_array('mysql', $__pdodrvr)){
			$_cn = new PDO('mysql:host='.RDS_HOSTNAME.';dbname='.$_bd, DB_US, DB_US_PSS, $options);
			$_cn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
			return($_cn);
		}else{
			echo 'No Driver For PDO MySql // execute -> sudo yum install php72-mysqlnd';
		}

	} catch (Exception $e) {

		error_log($e->getMessage()); die();

	}


}

function Pdo_Fix_RwTot($c=NULL){

	if(!isN($c)){
		if($c->rowCount() > 0){
			$__p['row'] = $c->fetch(PDO::FETCH_ASSOC);
		    $__p['tot'] = (int)$c->rowCount();
		}else{
			$__p['row'] = $c->fetchAll();
			$__p['tot'] = (int)count($__p['row']);
		}
	}

	return $__p;
}


function CnPrc_Pdo($p=NULL){

	if($p['d']=='prc' && defined('DB_PRC')){ $_bd = DB_PRC; }
	elseif($p['d']=='cl' && defined('DB_CL')){ $_bd = DB_CL;  }
	elseif($p['d']=='cht' && defined('DBC')){ $_bd = DBC;  }
	elseif($p['d']=='thrd' && defined('DBT')){ $_bd = DBT;  }
	elseif($p['d']=='dwn' && defined('DB_DWN')){ $_bd = DB_DWN;  }
	elseif($p['d']=='aut' && defined('DB_AUT')){ $_bd = DB_AUT;  }
	else{ $_bd = DB; }

	if(defined('RDS_HOSTNAME_WRT') && !isN(RDS_HOSTNAME_WRT)){ $__hst=RDS_HOSTNAME_WRT; }else{ $__hst=RDS_HOSTNAME; }

	$__pdodrvr = PDO::getAvailableDrivers();

	if(in_array('mysql', $__pdodrvr)){
		$_cn = new PDO('mysql:host='.$__hst.';dbname='.$_bd, DB_USPRC, DB_USPRC_PSS);
		return($_cn);
	}else{
		echo 'No Driver For PDO MySql // execute -> sudo yum install php72-mysqlnd';
	}
}



class CRM_Cnx {


    /*
	    function __construct($p=NULL) {
	        $this->c_r = CnRdi();
	        $this->c_p = CnPrci();
	    }

		function __destruct() {
			if(!isN($this->c_r)){ @$this->c_r->close(); }
			if(!isN($this->c_p)){ @$this->c_p->close(); }
	   	}
   	*/


    //--------------------- Start Class ---------------------//

        public $_cusr = 'us';
        public $_cbdr = '';
        public $_cbdp = '';
        public $_cfree = [];
        public $_tmslp = 100000;

	    function __construct($p=NULL) {
	        if(isN($this->c_r)){ $this->c_r = $this->_bcnx_r([ 'd'=>'cl' ]); }
	        if(isN($this->c_p)){ $this->c_p = $this->_bcnx_p([ 'd'=>'cl' ]); }
	    }

		function __destruct() {

			if(!isN($this->_cfree)){
				foreach($this->_cfree as $free_k=>$free_v){
					if(!isN($free_v)){
						$this->_clsr($free_v);
					}
				}
			}

			if(!isN($this->c_r)){ @$this->c_r->close(); }
			if(!isN($this->c_p)){ @$this->c_p->close(); }
	   	}


	//--------------------- Connect Database ---------------------//

		private function _bcnx_r($p=NULL){


			$_bd = $this->_sldb([ 'd'=>$p['d'] ]);

			if(!isN($_bd) && defined('DB_US') && defined('RDS_HOSTNAME') && defined('DB_US_PSS')){

				$try=0;
				$_connected='';

				while($try<10){

					$_cn = new mysqli(RDS_HOSTNAME, DemoBD(DB_US, $p['demo']), DB_US_PSS, '', defined('RDS_HOSTNAME_PRT') ? RDS_HOSTNAME_PRT : 3306 );
					if(!isN($_cn)){ $_cn->set_charset("utf8mb4"); }

					if(isWrkr()){
						$_cn->options( MYSQLI_OPT_CONNECT_TIMEOUT, 600);
					}

					if(!isN($_cn) && isN($_cn->connect_error) && !isN($_bd)){
						if($_cn->select_db( DemoBD($_bd, $p['demo']) ) ){
							$_connected='ok';
							break;
						}
					}else{
						if(isWrkr()){
							echo '$_cn->connect_error on read '.RDS_HOSTNAME.'(' . $_cn->connect_errno . ') '.$_cn->connect_error.br();
							if(!defined('DB_US')){ echo 'DB_US:'.DB_US; }
							//exit();
						}
					}

					$try++; sleep( $this->_tmslp * $try );

				}

				if(!isN($_cn->connect_error) && $_connected != 'ok'){

					echo 'Error de conexión on read '.RDS_HOSTNAME.' (' . $_cn->connect_errno . ') ' . $_cn->connect_error . br();

					if(isWrkr()){
						//exit();
					}

				}

				return($_cn);

			}else{

				echo 'No data for connection'.br();
				echo '$_bd:'.$_bd.br();
				echo 'DB_US:'.DB_US.br();
				echo 'DB_US_PSS:'.DB_US_PSS.br();
				echo 'RDS_HOSTNAME:'.RDS_HOSTNAME.br();

				exit();

			}

		}


	//--------------------- Connect Database ---------------------//

		private function _bcnx_p($p=NULL){

			$_bd = $this->_sldb([ 'd'=>$p['d'] ]);

			if(!isN($_bd) && defined('DB_USPRC') && defined('RDS_HOSTNAME') && defined('DB_USPRC_PSS')){

				if(defined('RDS_HOSTNAME_WRT') && !isN(RDS_HOSTNAME_WRT)){ $__hst=RDS_HOSTNAME_WRT; }else{ $__hst=RDS_HOSTNAME; }

				$try=0;
				$_connected='';

				while($try<10){

					if($try > 8){ $__hst = PBLC_RDS_HOSTNAME; }

					$_cn = new mysqli($__hst, DemoBD(DB_USPRC, $p['demo']), DB_USPRC_PSS, '', defined('RDS_HOSTNAME_PRT') ? RDS_HOSTNAME_PRT : 3306);
					if(!isN($_cn)){ $_cn->set_charset("utf8mb4"); }

					if(isWrkr()){
						$_cn->options( MYSQLI_OPT_CONNECT_TIMEOUT, 10000);
					}

					if(!isN($_cn) && isN($_cn->connect_error)){
						if($_cn->select_db( DemoBD($_bd, $p['demo']) )){
							$_connected='ok';
							break;
						}
					}else{
						if(isWrkr() && $try > 8){
							echo '$_cn->connect_error on save '.$__hst.'(' . $_cn->connect_errno . ') '.$_cn->connect_error . br();
							//exit();
						}
					}

					$try++; usleep( $this->_tmslp * $try );

				}

				if(!isN($_cn->connect_error) && $_connected != 'ok'){

					echo 'Error de conexión on save '.$__hst.' (' . $_cn->connect_errno . ') ' . $_cn->connect_error . br();

					if(isWrkr()){
						//exit();
					}

				}

				return($_cn);

			}else{

				echo 'No data for connection'.br();
				echo '$_bd:'.$_bd.br();
				echo 'DB_USPRC:'.DB_USPRC.br();
				echo 'RDS_HOSTNAME:'.$__hst.br();

				exit();

			}

		}



	//--------------------- Change Database On Connect ---------------------//


		public function _sldb($p=NULL){

			if($p['d']=='prc' && defined('DB_PRC')){ $_bd = DB_PRC; }
			elseif($p['d']=='cl' && defined('DB_CL')){ $_bd = DB_CL;  }
			elseif($p['d']=='cht' && defined('DBC')){ $_bd = DBC;  }
			elseif($p['d']=='thrd' && defined('DBT')){ $_bd = DBT;  }
			elseif($p['d']=='dwn' && defined('DB_DWN')){ $_bd = DB_DWN;  }
			elseif($p['d']=='aut' && defined('DB_AUT')){ $_bd = DB_AUT;  }
			elseif($p['d']=='main' && defined('DB')){ $_bd = DB;  }
			else{ $_bd = DB; }

			return $_bd;
		}


	//--------------------- Change Database On Connect ---------------------//


		public function _bdbr($p=NULL){
			$_bd = $this->_sldb([ 'd'=>$p['d'] ]);
			if(!isN($_bd) && !isN($this->c_r)){
				if($this->c_r->select_db($_bd)){
					$this->_cbdr = $_bd;
				}
			}
		}

	//--------------------- Change Database On Connect ---------------------//

		public function _bdbp($p=NULL){
			$_bd = $this->_sldb([ 'd'=>$p['d'] ]);
			if(!isN($_bd) && !isN($this->c_p)){
				if($this->c_p->select_db($_bd)){
					$this->_cbdp = $_bd;
				}
			}
		}

	//--------------------- Check Ping ---------------------//


		public function _chkcnx($p=NULL){
			if(!isN($this->c_r) && !$this->c_r->ping()){
				$this->c_r = $this->_bcnx_r([ 'd'=>'cl' ]);
			}
			if(!isN($this->c_p) && !$this->c_p->ping()){
				$this->c_p = $this->_bcnx_p([ 'd'=>'cl' ]);
			}
		}


	//--------------------- Connection to Process ---------------------//

		public function _opnx($p=NULL){

			if($p['mod'] == 'ok'){

				//if(isWrkr()){ echo br().' Writte Ping '.$this->c_p->ping().br(); }

				if(!isN($this->c_p) && !$this->c_p->ping()){

					//if(isWrkr()){ echo br().' Try Connect '.br(); }

					CnCls($this->c_p);
					$this->c_p=NULL;

					if(isN($p['rst']) || $p['rst'] != 'no'){ $__r_b='cl'; }else{ $__r_b=''; }
					$this->c_p = $this->_bcnx_p([ 'd'=>$__r_b ]);

				}else{

					//if(isWrkr()){ echo br().' Connect Still Same '.br(); }

				}

				if(defined('DB_CL') && !isN(DB_CL) && $this->_cbdp != DB_CL && (isN($p['rst']) || $p['rst'] != 'no' )){
					$this->_bdbp([ 'd'=>'cl' ]);
				}

				return $this->c_p;

			}else{


				if(!isN($this->c_r) && !$this->c_r->ping()){

					CnCls($this->c_r);
					$this->c_r=NULL;

					if(isN($p['rst']) || $p['rst'] != 'no'){ $__r_b='cl'; }else{ $__r_b=''; }
					$this->c_r = $this->_bcnx_r([ 'd'=>$__r_b ]);
				}

				if(defined('DB_CL') && !isN(DB_CL) && $this->_cbdr != DB_CL && (isN($p['rst']) || $p['rst'] != 'no' ) ){
					$this->_bdbr([ 'd'=>'cl' ]);
				}

				return $this->c_r;

			}


		}

	//--------------------- Close Connection to Read ---------------------//

		public function _clsr($c=NULL){
			$this->_qry_free($c);
		}

	//--------------------- Query Execute Select ---------------------//

		public function _qry($q=NULL, $p=NULL){

			if(!isN($q)){

				try{

					$c = $this->_opnx([ 'rst'=>$p['rst'] ]);

					if(!isN($c) && !isN($c->thread_id)){
						if($p['cmps']=='ok'){ $q = compress_code($q); }
						$r = $c->query($q);
						$this->_cfree[] = $r;
					}else{
						$r = false;
					}

					if($r){

						return $r;

					}elseif(!isN($this->c_r->error)){

						if( function_exists('ChckSESS_superadm') && ChckSESS_superadm() ){
							if((defined('DSERR') && DSERR == 'on') || Dvlpr()){ echo $this->c_r->error.' on '.$q; }
						}

						$__errm = debug_backtrace();

						$_err = _ErrSis([ 'p'=>$q, 'd'=>$this->c_r->error, 'd'=>$this->c_r->error, 'n'=>$this->c_r->errno, 'f'=>$__errm[0]['file'], 'l'=>$__errm[0]['line'], 'src_main'=>$this->src_main ]);

						if($_err->e == true){

							$this->src_main = NULL;

						}

					}

				}catch(Exception $e) {

					$e->getMessage();
					return false;

				}

			}else{

				return false;

			}

		}

	//--------------------- Query Execute Insert, Update, Delete ---------------------//

		public function _prc($q=NULL, $p=NULL){

			if(!isN($q)){

				try{

					$c = $this->_opnx([ 'mod'=>'ok' ]);

					if(!isN($c)){
						if($p['cmps']=='ok'){ $q = compress_code($q); }
						$r = $c->query($q);
						$this->_cfree[] = $r;
					}

					if($r){

						return $r;

					}elseif(!isN($this->c_p->error)){

						if( function_exists('ChckSESS_superadm') && ChckSESS_superadm()){
							if((defined('DSERR') && DSERR =='on') || Dvlpr()){ echo $this->c_p->error.' on '.$q; }
						}

						$__errm = debug_backtrace();
						_ErrSis([ 'p'=>$q, 'd'=>$this->c_p->error, 'd'=>$this->c_p->error, 'n'=>$this->c_r->errno, 'f'=>$__errm[0]['file'], 'l'=>$__errm[0]['line'], 'src_main'=>$this->src_main ]);

						if($_err->e == true){

							$this->src_main = NULL;

						}

					}

				}catch(Exception $e) {

					echo $e->getMessage();
					return false;

				}

			}else{

				return false;

			}

		}

	//--------------------- Query Free Memory ---------------------//


	   	public function _qry_free($r=NULL){
		   	if(!isN($r) && $r){ @$r->free(); }
		}


	//--------------------- Scape Strings to Prevent Query Injections ---------------------//


		function _sqlvstrng($p=NULL){ // $theValue=NULL, $theType=NULL, $theDefinedValue=NULL, $theNotDefinedValue=NULL, $_p=NULL

			$this->_bcnx_p();
			$cnx = $this->c_p; //CnPrci();

			if(PHP_VERSION > 6){

				try{
					if(!isN($p) && ( !isN($p['v']) || $p['v'] == '0' ) && !isN($cnx)){ $_vl = $cnx->real_escape_string($p['v']); }
				}catch(Exception $e) {
					if(defined('DSERR') && DSERR == 'on'){
						echo $e->getMessage().' _sqlvstrng on '.$p['v'];
					}
				}

			}else{

				$_vl = get_magic_quotes_gpc() ? stripslashes($p['v']) : $p['v'];

				if(function_exists("mysql_real_escape_string")){
					$_vl = $cnx->real_escape_string($p['v']);
				}else{
					$_vl = mysql_escape_string($p['v'], $cnx);
				}

			}

			switch ($p['t']) {
				case "text": $_r = ($_vl != "") ? "'" . $_vl . "'" : "NULL"; break;
				case "int": $_r = ($_vl != "") ? intval($_vl) : "NULL"; break;
				case "long": $_r = ($_vl != "") ? intval($_vl) : "NULL"; break;
				case "double": $_r = ($_vl != "") ? doubleval($_vl) : "NULL"; break;
				case "date": $_r = ($_vl != "") ? "'" . $_vl . "'" : "NULL"; break;
				case "defined": $_r = ($_vl != "") ? $p['dv'] : $p['ndv']; break;
			}

			return ($_r);
		}



}

$__cnx = new CRM_Cnx();


function CnRdi($p=NULL){

	global $__cnx;
	$__cnx->_chkcnx();
	$__cnx->_bdbr([ 'd'=>$p['d'] ]);
	return $__cnx->c_r;

	/*
	if($p['d']=='prc' && defined('DB_PRC')){ $_bd = DB_PRC; }
	elseif($p['d']=='cl' && defined('DB_CL')){ $_bd = DB_CL;  }
	elseif($p['d']=='cht' && defined('DBC')){ $_bd = DBC;  }
	elseif($p['d']=='thrd' && defined('DBT')){ $_bd = DBT;  }
	elseif($p['d']=='dwn' && defined('DB_DWN')){ $_bd = DB_DWN;  }
	elseif($p['d']=='aut' && defined('DB_AUT')){ $_bd = DB_AUT;  }
	else{ $_bd = DB; }


	if(!isN($_bd) && defined('DB_US') && defined('RDS_HOSTNAME') && defined('DB_US_PSS')){

		$try=0;

		while($try<5){

			$_cn = new mysqli(RDS_HOSTNAME, DemoBD(DB_US, $p['demo']), DB_US_PSS, '', RDS_HOSTNAME_PRT);

			if(!isN($_cn) && isN($_cn->connect_error)){
				$_cn->select_db( DemoBD($_bd, $p['demo']) ); break;
			}
			$try++; sleep(5);
		}
		if(!isN($_cn->connect_error)){
			echo 'Error de conexion '.RDS_HOSTNAME.' (' . $_cn->connect_errno . ') ' . $_cn->connect_error . br(); exit();
		}

		return($_cn);

	}
	*/

}


function CnPrci($p=NULL){

	global $__cnx;
	$__cnx->_chkcnx();
	$__cnx->_bdbp([ 'd'=>$p['d'] ]);
	return $__cnx->c_p;



	/*
	if($p['d']=='prc' && defined('DB_PRC')){ $_bd = DB_PRC; }
	elseif($p['d']=='cl' && defined('DB_CL')){ $_bd = DB_CL; }
	elseif($p['d']=='cht' && defined('DBC')){ $_bd = DBC;  }
	elseif($p['d']=='thrd' && defined('DBT')){ $_bd = DBT;  }
	elseif($p['d']=='dwn' && defined('DB_DWN')){ $_bd = DB_DWN;  }
	elseif($p['d']=='aut' && defined('DB_AUT')){ $_bd = DB_AUT;  }
	else{ $_bd = DB; }

	if(!isN($_bd) && defined('DB_USPRC') && defined('RDS_HOSTNAME') && defined('DB_USPRC_PSS')){

		$try=0;

		while($try<5){

			if(defined('RDS_HOSTNAME_WRT') && !isN(RDS_HOSTNAME_WRT)){ $__hst=RDS_HOSTNAME_WRT; }else{ $__hst=RDS_HOSTNAME; }
			if(defined('RDS_HOSTNAME_PRT') && !isN(RDS_HOSTNAME_PRT)){ $__hstp=RDS_HOSTNAME_PRT; }else{ $__hstp=''; }

			$_cn = new mysqli($__hst, DemoBD(DB_USPRC, $p['demo']), DB_USPRC_PSS, '', $__hstp);
			if(!isN($_cn) && isN($_cn->connect_error)){
				$_cn->select_db( DemoBD($_bd, $p['demo']) ); break;
			}
			$try++; sleep(5);
		}
		if(!isN($_cn->connect_error)){
			echo 'Error de conexion '.RDS_HOSTNAME.' (' . $_cn->connect_errno . ') ' . $_cn->connect_error . br(); exit();
		}

		return($_cn);

	}

	*/

}

if (!function_exists('_ErrSis')) {

	function _ErrSis($p=NULL){
		/*
		global $__cnx;

		if(!isN($p['d']) && defined('DBM') && !isN(DBM)){

			$__enc = Enc_Rnd($_p['p'].'-'.$_p['d']);

			echo '<h1>--------p:'.compress_code($p['p']).'</h1><br>';
			echo '<h1>--------d:'.compress_code($p['d']).'</h1><br>';
			echo '<h1>--------n:'.$p['n'].'</h1><br>';
			echo '<h1>--------f:'.$p['f'].'</h1><br>';
			echo '<h1>--------l:'.$p['l'].'</h1><br>';
			echo '<h1>--------srcmain:'.$p['src_main'].'</h1><br>';


			try{

				/*
				$Qry = sprintf("INSERT INTO ".DBM."._sis_err (siserr_enc, siserr_prc, siserr_dsc, siserr_no, siserr_src, siserr_src_lne, siserr_src_main) VALUES (%s, %s, %s, %s, %s, %s, %s)",
										GtSQLVlStr(ctjTx($__enc,'out'), "text"),
										GtSQLVlStr(ctjTx( compress_code($p['p']) ,'out'), "text"),
										GtSQLVlStr(ctjTx( compress_code($p['d']) ,'out'), "text"),
										GtSQLVlStr(ctjTx($p['n'],'out'), "text"),
										GtSQLVlStr(ctjTx($p['f'],'out'), "text"),
										GtSQLVlStr(ctjTx($p['l'],'out'), "text"),
										GtSQLVlStr(/*ctjTx( compress_code($p['src_main']) ,'out')*//*'', "text"));

				$insertSQL = $Qry;
				$Result1 = $__cnx->_prc($insertSQL);

				if($Result1){ $Vl['e'] = true;}else{ $Vl['e'] = false; $Vl['w'] = $__cnx->c_p->error; }



			}catch(Exception $e) {

				if(defined('DSERR') && DSERR == 'on'){
					echo $e->getMessage().' _ErrSis on '.$tx;
				}

			}

		}else{

			$Vl['e'] = false;
		}

		$rtrn = json_encode($Vl);
		return($rtrn);

		*/
	}

}

if (!function_exists("GtSQLVlStr")) {
	function GtSQLVlStr($theValue=NULL, $theType=NULL, $theDefinedValue=NULL, $theNotDefinedValue=NULL, $_p=NULL){
		global $__cnx;
		return $__cnx->_sqlvstrng([ 'v'=>$theValue, 't'=>$theType, 'dv'=>$theDefinedValue, 'ndv'=>$theNotDefinedValue ]);
	}
}