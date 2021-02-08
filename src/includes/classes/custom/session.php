<?php

function CnPrc(){ $capus_nr = mysql_pconnect(HST, DB_US, DB_US_PSS); return($capus_nr); }

function CnFre( $r=NULL){ if($r!=NULL){ $r->free; } }

function KnIp($Vlr){if($Vlr != ""){if ($_SERVER) {if ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) {$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];} elseif ( $_SERVER["HTTP_CLIENT_IP"] ) {$realip = $_SERVER["HTTP_CLIENT_IP"];} else {$realip = $_SERVER["REMOTE_ADDR"];}} else {if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {$realip = getenv( 'HTTP_X_FORWARDED_FOR' );} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {$realip = getenv( 'HTTP_CLIENT_IP' );} else {$realip = getenv( 'REMOTE_ADDR' );}}return $realip;}}
// Detecto si viene de un movil

function isMobile(){
	$mobile_browser = '0';
	if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|blackberry|android)/i',strtolower($_SERVER['HTTP_USER_AGENT']))){	$mobile_browser++;}
	if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))){	$mobile_browser++;}
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
	$mobile_agents = array('w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
	if(in_array($mobile_ua,$mobile_agents)){$mobile_browser++;}
	if(strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {$mobile_browser++;}
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {$mobile_browser=0;}

	if($mobile_browser > 0 || $_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] == 'true'){
		return (bool)true;
	}else{
		return (bool)false;
	}
}

// Detecto si es Ipad
function isIPad(){return (bool) strpos($_SERVER ['HTTP_USER_AGENT'] ,'iPad');}

// Detecto si es Tablet
function isTablet(){return (bool) strpos($_SERVER ['HTTP_USER_AGENT'] ,'AT100');}

function LgnDsp(){if(isMobile()){ return( _CId('ID_SISDSP_MVL') ); }elseif( isIPad() or isTablet()){ return( _CId('ID_SISDSP_TBLT') ); }else{ return( _CId('ID_SISDSP_DSKTP') );}}

//GetSqlString
function GtSisPsDt($_p=NULL){

	global $__cnx;

	if(is_array($_p)){

		if(!isN($_p['id'])){

			$c_DtRg = "-1";if(!isN($_p['id'])){$c_DtRg = $_p['id'];}

			if($_p['t'] == 'enc'){ $__f = 'sisps_enc'; $__ft = 'text'; }
			elseif($_p['t'] == 'iso2'){ $__f = 'sisps_iso2'; $__ft = 'text'; }
			else{ $__f = 'id_sisps'; $__ft = 'int'; }

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_SIS_PS."
										 INNER JOIN "._BdStr(DBM).TB_SIS_LNG." ON sisps_lng = id_sislng
									WHERE {$__f} = %s", GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_sisps'];
					$Vl['tt'] = ctjTx($row_DtRg['sisps_tt'],'in');
					$Vl['int'] = ctjTx($row_DtRg['sisps_int'],'in');
					$Vl['tel'] = ctjTx($row_DtRg['sisps_tel'],'in');

					$Vl['lng']['id'] = ctjTx($row_DtRg['id_sislng'],'in');
					$Vl['lng']['nm'] = ctjTx($row_DtRg['sislng_nm'],'in');

					$Vl['lng']['tt']['es'] = ctjTx($row_DtRg['sislng_tt_es'],'in');
					$Vl['lng']['tt']['en'] = ctjTx($row_DtRg['sislng_tt_en'],'in');
					$Vl['lng']['tt']['it'] = ctjTx($row_DtRg['sislng_tt_it'],'in');
					$Vl['lng']['tt']['fr'] = ctjTx($row_DtRg['sislng_tt_fr'],'in');
					$Vl['lng']['tt']['gr'] = ctjTx($row_DtRg['sislng_tt_fr'],'in');

					$Vl['lng']['cod'] = ctjTx($row_DtRg['sislng_cod'],'in');
					$Vl['lng']['est'] = ctjTx($row_DtRg['sislng_est'],'in');

				}

			}

			$__cnx->_clsr($DtRg);

		}

		$__cnx->_clsr($DtRg);

	}

	return(_jEnc($Vl));
}


function KnGEO($p=NULL){
	/*
	$___key = '3a927d12bea920bad7ace5ab38a437cf8fc15213b32b355edd48bdbc8e867933';
	$__ip = KnIp('on');
	$__url = "http://api.ipinfodb.com/v3/ip-city/?key=$___key&ip=$__ip&format=json";
	$__url_hdr = array('Content-Type: application/json');

	$CurlRQ = new CRM_Out();
	$CurlRQ->url = $__url;
	$CurlRQ->o_post = false;
	$CurlRQ->o_header_http = $__url_hdr;
	$CurlRQ->o_vrbs = true;
	$CurlRQ->o_tmout = 10;
	$CurlRQ->out = 'json';
	$rsp = $CurlRQ->_Rq();
	$data = $rsp->rsl;

	if(strlen($data->countryCode)){

		$info['ip'] = $data->ipAddress;
		$info['country_code'] =	$data->countryCode;
		$info['country_name'] = $data->countryName;
		$info['region_name'] = $data->regionName;
		$info['city'] = $data->cityName;
		$info['zip_code'] = $data->zipCode;
		$info['latitude'] = $data->latitude;
		$info['longitude'] = $data->longitude;
		$info['time_zone'] = $data->timeZone;

		if($p['lng'] == 'ok'){

			$__ps = GtSisPsDt([ 'id'=>$data->countryCode, 't'=>'iso2' ]);

			if(!isN($__ps)){
				$info['language'] = $__ps->lng;
			}

		}

	}

	return _jEnc($info);

	*/
}

function _QrySisSlcF($p=NULL){

	if($p['cl'] == 'ok'){
		$__bd = VW_CL_SIS_SLC;
	}else{
		$__bd = _BdStr(DBM).VW_SIS_SLC;
	}

	if(!isN($p['als'])){ $__als = $p['als'].'.'; }
	if(!isN($p['als_n'])){ $__als_nm = '___'.$p['als_n']; }else{ $__als_nm = '___fld'; }
	if(!isN($p['als_fk'])){ $__als_fl = ' AND sisslctpf_key = '.GtSQLVlStr($p['als_fk'], "text"); }

	$_r = " (	SELECT JSON_ARRAYAGG(attributes)
			   FROM ".$__bd."
			   WHERE sisslcf_slc = ".$__als."id_sisslc {$__als_fl}
			) AS ".$__als_nm;

	return $_r;

}

function GtSlc_QryExtra($p=NULL){

	$_tp = $p['t']; // Tipo
	$_prfx = $p['p']; // Prefix builder
	$_als = $p['als']; // Alias de la Tablaç
	$_col = $p['col']; // Columna Relacion

	if($p['cl'] == 'ok'){
		$__bd = TB_CL_SLC;
	}else{
		$__bd = _BdStr(DBM).TB_SIS_SLC;
	}

	if($_tp=='fld'){
		$_r = "{$_als}.id_sisslc AS {$_prfx}_id_sisslc, {$_als}.sisslc_enc AS {$_prfx}_sisslc_enc, {$_als}.sisslc_tt AS {$_prfx}_sisslc_tt, {$_als}.sisslc_img AS {$_prfx}_sisslc_img, {$_als}.sisslc_img_bck AS {$_prfx}_sisslc_img_bck, {$_als}.sisslc_cns AS {$_prfx}_sisslc_cns";
	}elseif($_tp=='tb'){
		if($p['l'] == 'ok'){ $__rlt = 'LEFT'; }else{ $__rlt = 'INNER'; }
		$_r = "	".$__rlt." JOIN ".$__bd." {$_als} ON {$_col} = {$_als}.id_sisslc ";
	}

	return $_r;
}


function GtSlcTpF_Ls($p){

	global $__cnx;

	$Vl['e']='no';

	if(!isN($p['tp'])){

		if($p['cl'] == 'ok'){
			$__bd = TB_CL_SLC_F;
			$__bd2 = TB_CL_SLC_TP_F;
			$__bd3 = TB_CL_SLC_TP;
		}else{
			$__bd = _BdStr(DBM).TB_SIS_SLC_F;
			$__bd2 = _BdStr(DBM).TB_SIS_SLC_TP_F;
			$__bd3 = _BdStr(DBM).TB_SIS_SLC_TP;
		}

		if(!isN($p['tp'])){$c_tp=$p['tp'];}else{$c_tp='-1';}

		$query_DtRg = sprintf("	SELECT *
								FROM $__bd2
									 INNER JOIN ".$__bd3." ON sisslctpf_tp = id_sisslctp
									 INNER JOIN "._BdStr(DBM).MDL_SIS_TP_DT_BD." ON sisslctpf_tpd = id_sistpdt
								WHERE sisslctp_enc = %s
								ORDER BY sisslctpf_ord ASC", GtSQLVlStr($c_tp, 'text'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e']='ok';

				do{

					if(!isN( $row_DtRg['sisslctpf_ord'] )){
						$id = $row_DtRg['sisslctpf_ord'];
					}else{
						$id = $row_DtRg['sisslctpf_enc'];
					}

					$Vl['ls'][$id]['id'] = ctjTx($row_DtRg['id_sisslcf'],'in');
					$Vl['ls'][$id]['f'] = ctjTx($row_DtRg['sisslcf_f'],'in');

					$Vl['ls'][$id]['tp']['id'] = ctjTx($row_DtRg['id_sisslctpf'],'in');
					$Vl['ls'][$id]['tp']['tt'] = ctjTx($row_DtRg['sisslctpf_tt'],'in');
					$Vl['ls'][$id]['tp']['cns'] = ctjTx($row_DtRg['sisslctpf_cns'],'in');
					$Vl['ls'][$id]['tp']['key'] = ctjTx($row_DtRg['sisslctpf_key'],'in');
					$Vl['ls'][$id]['tp']['ord'] = ctjTx($row_DtRg['sisslctpf_ord'],'in');

					$Vl['ls'][$id]['rqd'] = mBln($row_DtRg[''.$_prfx.'slctpf_rqd']);

					if(mBln($row_DtRg[''.$_prfx.'slctpf_rqd']) == 'ok'){
						$Vl['ls'][$id]['icls'] = _Cns( $row_DtRg['sistpdt_rqd_vld'] );
					}else{
						$Vl['ls'][$id]['icls'] = _Cns( $row_DtRg['sistpdt_vld'] );
					}

					$Vl['ls'][$id]['tpd']['id'] = ctjTx($row_DtRg['id_sistpdt'],'in');
					$Vl['ls'][$id]['tpd']['tt'] = ctjTx($row_DtRg['sistpdt_tt'],'in');
					$Vl['ls'][$id]['tpd']['sqv'] = ctjTx($row_DtRg['sistpdt_sqv'],'in');
					$Vl['ls'][$id]['tpd']['vld'] = ctjTx($row_DtRg['sistpdt_vld'],'in');
					$Vl['ls'][$id]['tpd']['rqd_vld'] = ctjTx($row_DtRg['sistpdt_rqd_vld'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

	}

	return($Vl);
}



function GtSlcF_Ls($p){

	global $__cnx;

	$Vl['e']='no';

	if(!isN($p['tp'])){

		if($p['cl'] == 'ok'){
			$__bd = TB_CL_SLC_F;
			$__bd2 = TB_CL_SLC_TP_F;
			$__bd3 = TB_CL_SLC_TP;
		}else{
			$__bd = _BdStr(DBM).TB_SIS_SLC_F;
			$__bd2 = _BdStr(DBM).TB_SIS_SLC_TP_F;
			$__bd3 = _BdStr(DBM).TB_SIS_SLC_TP;
		}


		$__flds_tp = GtSlcTpF_Ls($p);

		if(!isN($p['tp'])){$c_tp=$p['tp'];}else{$c_tp='-1';}

		if(!isN($p['id'])){
			$__data_inner = "LEFT JOIN $__bd ON sisslcf_f = id_sisslctpf ";
			$__data_fl = sprintf(" AND sisslcf_slc= %s ", $p['id']);
		}

		$query_DtRg = sprintf("	SELECT *
								FROM $__bd2
									 INNER JOIN ".$__bd3." ON sisslctpf_tp = id_sisslctp
									 INNER JOIN "._BdStr(DBM).MDL_SIS_TP_DT_BD." ON sisslctpf_tpd = id_sistpdt
									 {$__data_inner}

								WHERE sisslctp_enc = %s {$__data_fl}

								ORDER BY sisslctpf_ord ASC", GtSQLVlStr($c_tp, 'text'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e']='ok';
				$Vl = $__flds_tp;

				do{

					if(!isN( $row_DtRg['sisslctpf_ord'] )){
						$id = $row_DtRg['sisslctpf_ord'];
					}else{
						$id = $row_DtRg['sisslctpf_enc'];
					}

					if($row_DtRg['id_sistpdt'] == 10){
						$Vl['ls'][$id]['vl'] = _jBty([ 't'=>'o', 'v'=>ctjTx($row_DtRg['sisslcf_vl'],'in') ]);
					}elseif($row_DtRg['id_sistpdt'] == 7){
						$Vl['ls'][$id]['vl'] = ctjTx($row_DtRg['sisslcf_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no'] );
					}else{
						$Vl['ls'][$id]['vl'] = ctjTx($row_DtRg['sisslcf_vl'],'in','',['html'=>'ok']);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

	}

	return(_jEnc($Vl));
}


function GtSlcF_Attr($p){

	global $__cnx;

	$Vl['e']='no';

	if(!isN($p['id'])){

		if($p['cl'] == 'ok'){
			$__bd = TB_CL_SLC;
			$__bd2 = TB_CL_SLC_F;
			$__bd3 = TB_CL_SLC_TP_F;
			$__bd4 = TB_CL_SLC_TP;
		}else{
			$__bd = _BdStr(DBM).TB_SIS_SLC;
			$__bd2 = _BdStr(DBM).TB_SIS_SLC_F;
			$__bd3 = _BdStr(DBM).TB_SIS_SLC_TP_F;
			$__bd4 = _BdStr(DBM).TB_SIS_SLC_TP;
		}

		if($p['t']=='enc'){ $__fld = 'sisslc_enc'; }else{ $__fld = 'id_sisslc'; }

		$query_DtRg = sprintf("	SELECT 	id_sisslc, sisslc_enc, sisslc_cns, id_sisslcf, sisslcf_enc, sisslctp_key, id_sisslctpf, sisslctpf_tt, sisslctpf_key,
										sisslctpf_ord, sisslcf_vl
								FROM {$__bd}
									 INNER JOIN {$__bd4} ON sisslc_tp = id_sisslctp
									 INNER JOIN {$__bd2} ON sisslcf_slc = id_sisslc
									 INNER JOIN {$__bd3} ON sisslcf_f = id_sisslctpf
									 INNER JOIN "._BdStr(DBM).MDL_SIS_TP_DT_BD." ON sisslctpf_tpd = id_sistpdt
								WHERE $__fld = %s
								ORDER BY sisslctpf_ord ASC", GtSQLVlStr($p['id'], 'text'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;	//echo h2('------TOT'.$Tot_DtRg);

			if($Tot_DtRg > 0){

				$Vl['e']='ok';
				$Vl = $__flds_tp;

				do{

					$_key = $row_DtRg['sisslctpf_key'];

					$Vl['ls'][$_key] = [

						'id'=>ctjTx($row_DtRg['id_sisslcf'],'in'),
						'enc'=>ctjTx($row_DtRg['sisslcf_enc'],'in'),
						'cns'=>ctjTx($row_DtRg['sisslc_cns'],'in'),
						'tp'=>ctjTx($row_DtRg['sisslctpf_tt'],'in'),
						'f'=>ctjTx($row_DtRg['sisslcf_f'],'in'),
						'key'=>ctjTx($row_DtRg['sisslctpf_key'],'in'),
						'ord'=>ctjTx($row_DtRg['sisslctpf_ord'],'in'),
						'tp_i'=>ctjTx($row_DtRg['id_sisslctpf'],'in'),
						'vl'=>ctjTx($row_DtRg['sisslcf_vl'],'in')

					];

					if(!isN($row_DtRg['sisslctp_key'])){
						$Vl['ls']['keym'] = [
							'key'=>'keym',
							'vl'=>ctjTx($row_DtRg['sisslctp_key'],'in'),
						];
					}


				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

	}

	return(_jEnc($Vl));
}


function GtSlcF_JAttr($p){
	if(!isN($p)){

		if(substr(trim($p), 0, 1) != '[') {
			$p = json_decode('['.$p.']');
		}else{
			$p = json_decode($p);
		}

		foreach($p as $p_k=>$p_v){
			$__o[$p_v->key] = $p_v;
		}
	}
	return _jEnc($__o);
}

function _CId($c=NULL){
	if($c!=NULL){
		$r = defined($c)?constant($c):null;
	}else{
		return false;
	}
	return $r;
}

function _bTree( $ar, $pid=null, $fr='j') {

    $op = [];

    if(is_array($ar)){

	    foreach( $ar as $item) {

	        if( $item['prnt'] == $pid ) {

		        $__html[ $item['id'] ] .= '{';
		        $__html_k = [];

				foreach($item as $k=>$v){
					$op[$item['id']][$k] = $v;
					$__html_k[] = '"'.$k.'":'.($v!=''?'"'.$v.'"':'null');
				}

	            $children = _bTree( $ar, $item['id'], $fr);

	            if($children){
	                $op[$item['id']]['sub'] = $children;
	                $__html_k[] = '"sub":['.$children.']';
	            }

	            $__html[ $item['id'] ] .= implode(',',$__html_k);
	            $__html[ $item['id'] ] .= '}';
	        }

	    }

		if(!isN($__html) && $fr=='j'){ return implode(',',$__html); }else{ return $op; }
	}

}


function _bTree_id( $ar, $pid=null, $fr='j') {
    $op = [];

    if(is_array($ar)){
	    foreach( $ar as $item ) {
	        if( $item['prnt'] == $pid ) {

		        foreach($item as $k=>$v){
	            	$op[$item['id']][$k] = $v;
	            }

	            $children =  _bTree_id( $ar, $item['id'], $fr);

	            if($children) {
	                $op[$item['id']]['sub'] = $children;
	            }
	        }
	    }

		return $op;
	}

}


function _bTree_chld($p=NULL, $m=NULL){

	if(!isN($m['bld'])){ $_r=$m['bld']; }
	if(!isN($m['lvl'])){ $_lvl=$m['lvl']; }else{ $_lvl=1; }
	if(!isN($m['pobj'])){ $_pobj=$m['pobj']; }

	foreach($p as $__three_k=>$__three_v){

		$_r['are-'.$__three_k]['id']=$__three_k;
		$_r['are-'.$__three_k]['tot']=count($__three_v['sub']);
		$_r['are-'.$__three_k]['tt'] = $__three_v['tt'];
		$_r['are-'.$__three_k]['clr'] = $__three_v['clr'];
		$_r['are-'.$__three_k]['logo'] = $__three_v['logo'];
		$_r['are-'.$__three_k]['tp'] = $__three_v['tp'];

		$_pobj = $_r['are-'.$__three_k];

		if(isN($_r['are-'.$__three_k]['sub'])){ $_r['are-'.$__three_k]['sub']=array(); }

		if(!isN($m['pid'])){
			foreach($m['pid'] as $pid_v){
				array_push($_r['are-'.$pid_v]['sub'], $_pobj);
			}
		}

		if(is_array($__three_v['sub']) && count($__three_v['sub']) > 0){

			if(!isN($m['pid'])){
				$pid =  array_merge($m['pid'], $_pobj);
			}else{
				$pid = [$__three_k];
			}

			$_r = _bTree_chld( $__three_v['sub'], ['bld'=>$_r, 'pid'=>$pid, 'pobj'=>$_pobj, 'lvl'=>$_lvl+1 ]);

		}else{

			// End Loop

		}

	}

	return $_r;

}


function _bTree_prnt($p=NULL, $m=NULL){

	if(!isN($m['bld'])){ $_r=$m['bld']; }
	if(!isN($m['lvl'])){ $_lvl=$m['lvl']; }else{ $_lvl=1; }
	if(!isN($m['pid'])){ $_pid=$m['pid']; }
	if(!isN($m['pobj'])){ $_pobj=$m['pobj']; }

	foreach($p as $__three_k=>$__three_v){

		$_t_id = $_r['are-'.$__three_k]['id'] = $__three_k;
		$_r['are-'.$__three_k]['tt'] = $__three_v['tt'];
		$_r['are-'.$__three_k]['clr'] = $__three_v['clr'];
		$_r['are-'.$__three_k]['logo'] = $__three_v['logo'];
		$_r['are-'.$__three_k]['tp'] = $__three_v['tp'];
		$_r['are-'.$__three_k]['tot'] = count($__three_v['sub']);


		if(isN($_r['are-'.$__three_k]['prnt'])){ $_r['are-'.$__three_k]['prnt']=array(); }

		if(!isN($_pid)){
			$_mrg = array_merge($_r['are-'.$__three_k]['prnt'], $_r['are-'.$_pid]['prnt'] );
			$_r['are-'.$__three_k]['prnt'] = $_mrg;
			array_push($_r['are-'.$__three_k]['prnt'], $_pobj);
		}

		$_pobj = $_r['are-'.$__three_k];

		if(is_array($__three_v['sub']) && count($__three_v['sub']) > 0){

			$_r = _bTree_prnt( $__three_v['sub'], ['bld'=>$_r, 'pid'=>$_t_id, 'pobj'=>$_pobj, 'lvl'=>$_lvl+1 ]);

		}else{

			// End Loop

		}

	}

	return $_r;

}



class CRM_SES{

    private $savePath;
    private $sess_id;

	function __construct($p=NULL){

		global $__no_sbdmn;

		if(isN($p['cl']) && $__no_sbdmn != 'ok'){
	        $this->cl = $this->__cldt([ 't'=>'sbd', 'id'=>Gt_SbDMN() ]);
	    }else{
	    	$this->cl = $p['cl'];
	    }

	    if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }

		if(	Gt_DMN() == 'sumr.co' ||
			Gt_DMN() == 'sumr.cloud' ||
			Gt_DMN() == 'sumr.nz' ||
			Gt_DMN() == 'massivespace.rocks'
		){
			$this->__ssl = true;
		}else{
			$this->__ssl = false;
		}

	}

	function __destruct() {

   	}





	function __cltagls($p){

		global $__cnx;

		if(($p['id']!=NULL)){

			$__f = 'cltag_cl'; $__ft = 'int';
			$c_DtRg = "-1"; if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf("	SELECT *, "._QrySisSlcF()."
									FROM "._BdStr(DBM).TB_CL_TAG."
										 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cltag_sistag = id_sisslc
									WHERE ".$__f." = %s", GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				//$__slc_o = GtSlcF_Ls([ 'tp'=>$row_DtRg['sisslc_tp' ] ]);

				if($Tot_DtRg > 0){

					do{

						$___col = json_decode($row_DtRg['___fld']);

						if(is_array($___col)){
							foreach($___col as $___col_k=>$___col_v){
								if($___col_v->key=='tp'){
									$__grp=$___col_v->vl;
								}else{
									$__vle[ $___col_v->vl ]['op'] = $___col_v;
									$__vle[ $___col_v->vl ]['v'] = $row_DtRg['cltag_vl'];
								}
							}
						}

						$Vl[ $__grp ] = $__vle;

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				echo $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}
	}


	public function __cldt($p=NULL){ //$Id, $Tp=NULL, $p=NULL

		global $__cnx;

		if($p['id']!=''){

			if($p['t'] == 'enc'){ $__f = 'cl_enc'; $__ft = 'text'; }
			elseif($p['t'] == 'sbd'){ $__f = 'cl_sbd'; $__ft = 'text'; }
			elseif($p['t'] == 'prfl'){ $__f = 'cl_prfl'; $__ft = 'text'; }
			else{ $__f = 'id_cl'; $__ft = 'int'; }

			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_CL.' WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($p['id'], $__ft));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_cl'];
					$Vl['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$Vl['sbd'] = ctjTx($row_DtRg['cl_sbd'],'in');
					$Vl['dir'] = ctjTx($row_DtRg['cl_dir'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$Vl['prfl'] = ctjTx($row_DtRg['cl_prfl'],'in');
					$Vl['bd'] = DB_PRFX_CL.ctjTx($row_DtRg['cl_sbd'],'in');

					$Vl['tag'] = $this->__cltagls([
								'id'=>$row_DtRg['id_cl']
							]);

					$Vl['img'] = _ImVrs([
									'img'=>$row_DtRg['cl_img'],
									'f'=>DMN_FLE_CL
								]);

				}

			}else{

				echo $__cnx->c_r->error;

			}
			$__cnx->_clsr($DtRg);
			return(_jEnc($Vl));
		}
	}


	public function SetSess($k=NULL,$v=NULL){

		try{

			if(!isN($v) && defined('DB_CL_ENC_SES') && !isN(DB_CL_ENC_SES)){

				$_r['e'] = 'ok';

				if($k=='ctry'){
					$_SESSION[DB_CL_ENC_SES.MM_ADM_SES_CTRY] = $v;
				}elseif($k=='lng'){
					$_SESSION[DB_CL_ENC_SES.MM_ADM_SES_LNG] = $v;
				}elseif($k=='usr'){
					$_SESSION[DB_CL_ENC_SES.MM_ADM] = $v;
				}elseif($k=='grp'){
					$_SESSION[DB_CL_ENC_SES.MM_ADM_GRP] = $v;
				}elseif($k=='cl'){
					$_SESSION[DB_CL_ENC_SES.MM_ACNT] = $v;
				}elseif($k=='ses'){
					$_SESSION[DB_CL_ENC_SES.MM_ADM_SES_ID]	= $v;
				}
			}

		}catch (Exception $e){
	        $_r['e'] = 'no';
	        $_r['w'] = $e->getCode();;
	    }

		return _jEnc($_r);
	}

	public function GtSess($k=NULL){

		try{

			if($k=='ctry'){
				$r = $_SESSION[DB_CL_ENC_SES.MM_ADM_SES_CTRY];
			}elseif($k=='lng'){
				$r = $_SESSION[DB_CL_ENC_SES.MM_ADM_SES_LNG];
			}elseif($k=='usr'){
				$r = $_SESSION[DB_CL_ENC_SES.MM_ADM];
			}elseif($k=='grp'){
				$r = $_SESSION[DB_CL_ENC_SES.MM_ADM_GRP];
			}elseif($k=='cl'){
				$r = $_SESSION[DB_CL_ENC_SES.MM_ACNT];
			}elseif($k=='ses'){
				$r = $_SESSION[DB_CL_ENC_SES.MM_ADM_SES_ID];
			}

		}catch (Exception $e){

	        return null;

	    }

		return $r;
	}


	public function __lng($p=NULL){

		if(!isN($p['lng']) || !isN($p['ctry'])){

			if( $this->SetSess('lng', $p['lng'])->e == 'ok' ){
				$this->__ck();
				$_r['e'] = 'ok';
			}

			if( $this->SetSess('ctry', $p['ctry'])->e == 'ok'){
				$this->__ck();
				$_r['e'] = 'ok';
			}

		}else{

			if( isN($this->GtSess('ctry')) || isN($this->GtSess('lng')) ){
				if(!defined('MACHINE_WRKR') || Dvlpr()){ $__myip = KnGEO([ 'lng'=>'ok' ]); }
			}

			if( isN($this->GtSess('ctry')) && !isN($__myip->country_code)){
				$this->SetSess('ctry', $__myip->country_code);
			}
			if( isN($this->GtSess('lng')) && !isN($__myip->language->cod) ){
				$this->SetSess('lng', $__myip->language->cod);
			}
		}

		return _jEnc($_r);

	}


	public function __lgin_set_rg(){

       	$_r['t'] = $this->usr_cl;

        if(!isN($this->usr) && !isN($this->usr_grp)){

			if(PHP_VERSION >= 5.1){ session_regenerate_id(true); }else{ session_regenerate_id(); }

			$this->SetSess('usr', $this->usr);
			$this->SetSess('grp', $this->usr_grp);
			$this->SetSess('ses', $this->usr_ses);

			if(defined('DB_CL_ENC_SES') && DB_CL_ENC_SES!='' && $this->usr_cl != NULL){
				$this->SetSess('cl', $this->usr_cl);
			}

			$__rg = $this->__rg([ 'id'=>$this->usr_id, 'nvl'=>$this->usr_nvl ], 'ok');
			$_r['__rg'] = $__rg;

			if($__rg->e == 'ok'){
				$_r['e'] = 'ok';
				$_r['ck'] = $this->__ck();
			}else{
				$_r['e'] = 'no';
				$_r['w'] = $__rg->w;
				if(!isN($__rg->dvcw)){ $_r['dvcw'] = $__rg->dvcw; }
				$_r['w2'] = $__rg->w2;
			}
		}

        return json_decode(json_encode($_r));

    }


    public function __rg_upd($p=NULL){

	    global $__cnx;

	    $r['e'] = 'no';
	    $r['id'] = $this->sess_id;

		if(!isN($this->sess_id)){

			if($p['t'] == 'set'){

				/*
				if(!isN( $p['us_id'] ) && defined('DB_CL_ENC') ){

					if($p['us_nvl'] != 'superadmin'){

						$__dt_cl = __Cl([ 'id'=>DB_CL_ENC, 't'=>'enc' ]);

						if($p['off']=='ok'){ $__est_upd = 2; }else{ $__est_upd = 1; }

						$updatebfSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_SES." SET uses_est=%s WHERE uses_cl=%s AND uses_us=%s AND id_uses!=%s",
										   GtSQLVlStr($__est_upd, "int"),
										   GtSQLVlStr($__dt_cl->id, "int"),
										   GtSQLVlStr($p['us_id'], "int"),
										   GtSQLVlStr($this->sess_id, "int"));

						$Resultbf_UP = $__cnx->_prc($updatebfSQL);

						if($Resultbf_UP){

							$r['e'] = 'ok';

						}else{

							$r['ses_w'] = 'Problem on update SES';

						}

					}

				}*/

			}elseif($p['t'] == 'tme'){

				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_SES." SET uses_exp=%s WHERE id_uses=%s",
						   GtSQLVlStr($p['exp'], "date"),
						   GtSQLVlStr($this->sess_id, "int"));
				$Result_UP = $__cnx->_prc($updateSQL);

				if($Result_UP){
					$r['e'] = 'ok';
				}

			}

			$r['w'] = $__cnx->c_p->error;

	    }

	    return(_jEnc($r));
	}



	// Funcion Registra Sesion de Usuari
	public function __rg($_u=NULL, $_e='no', $_m=NULL){

		global $__cnx;

		$r['e'] = 'no';
		$r['get']['uid'] = $_u['id'];
		$r['get']['e'] = $_e;

		if(!isN($_e)){

			$browser = new Browser();
			$IpUs = KnIp("on");
			$_brws_pltf = $browser->getPlatform();
			$_brws_n = $browser->getBrowser();
			$_brws_v = $browser->getVersion();
			$_dsp = LgnDsp();

			if(!isN($_u['cl'])){
				$__dt_cl = $this->__cldt([ 'id'=>$_u['cl'], 't'=>'enc' ]);
			}else{
				$__dt_cl = $this->__cldt([ 'id'=>Gt_SbDMN(), 't'=>'sbd' ]);
			}

			if (!class_exists('CRM_Ws')) {
				require_once DIR_CLS_CRM.'_ws.php';
			}

			if (class_exists('CRM_Ws')) {

				$_ws = new CRM_Ws();
				$_ws->usdvc_cl = $__dt_cl->id;
				$_ws->usdvc_us = $_u['id'];
				$_ws->usdvc_id = $this->lgin_dvc;

				if($this->lgin_dvc_ios == 'ok'){
					$_ws->usdvc_ios = 'ok';
				}elseif($this->lgin_dvc_android == 'ok'){
					$_ws->usdvc_android = 'ok';
				}else{
					$_ws->usdvc_web = 'ok';
				}

				$_dvc = $_ws->Dvc();
				//$_ws_exst = print_r($_dvc, true);

			}else{

				$_ws_exst='no';

			}

			if(!isN($__dt_cl->id) && !isN($_u['id']) && !isN($_dvc->id)){

				$__enc = Enc_Rnd($__dt_cl->id.'-'.$_u['id'].'-'.$IpUs);

				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_SES." (uses_enc, uses_cl, uses_us, uses_dvc, uses_f, uses_h, uses_ip, uses_d, uses_b_p, uses_b_t, uses_b_v, uses_mlw) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($__dt_cl->id, "int"),
								GtSQLVlStr($_u['id'], "int"),
								GtSQLVlStr($_dvc->id, "int"),
								GtSQLVlStr(SIS_F, "date"),
								GtSQLVlStr(SIS_H2, "date"),
								GtSQLVlStr($IpUs, "text"),
								GtSQLVlStr($_dsp, "int"),
								GtSQLVlStr($_brws_pltf, "text"),
								GtSQLVlStr($_brws_n, "text"),
								GtSQLVlStr($_brws_v, "text"),
								GtSQLVlStr($_m, "text"));

				$Result = $__cnx->_prc($insertSQL);


				if($Result){

					if(!isN($__enc)){ $this->SetSess('ses', $__enc); }
					$r['i'] = $this->sess_id = $__cnx->c_p->insert_id;
					$r['enc'] = $__enc;

					//$__upd = $this->__rg_upd([ 't'=>'set', 'us_id'=>$_u['id'], 'us_nvl'=>$_u['nvl'] ]);
					//$r['upd'] = $__upd;

					/*if($__upd->e=='ok' || $_u['nvl'] == 'superadmin'){*/ $r['e'] = 'ok'; /*}*/

				}else{

					$r['w'] = 'error __rg:'.$__cnx->c_p->error;
					$r['q'] = $insertSQL;

				}

			}else{

				$r['w'] = 'No cl id ('.$__dt_cl->id.') / uid ('.$_u['id'].') / dvc ('.$_dvc->id.') / ws:('.$_ws_exst.') ';
				$r['dvcw'] = 'ok';
				$r['w2'] = $_dvc;

			}


		}else{

			$r['w'] = 'No e data';

		}

		return _jEnc($r);
	}


	// Funcion Registra Cookie
	public function __chk() {

		$__chck_ses = $_COOKIE[CK_SES_C.DB_CL_ENC];
		$__chck_ses_lng = $_COOKIE[CK_SES_L];

		if(defined('DB_CL_ENC_SES') && !empty($__chck_ses) && (count($__chck_ses) > 0) && !isN($__chck_ses)){

			$__CRM_c = explode('.', $__chck_ses);

			if(count($__CRM_c) > 2){

				if (!empty($__chck_ses) && defined('DB_CL')) {

					$_us_dt = $this->GtSesUsDt($__CRM_c[0], 'enc');
					$_ses_dt = $this->GtSesDt(['i'=>$__CRM_c[3]]);

					if( ($_us_dt->e && !isN($_us_dt->id)) &&
					    ($_ses_dt->e && !isN($_ses_dt->id)) &&
					    ($_ses_dt->us->id === $_us_dt->id)){

						if(PHP_VERSION >= 5.1){ session_regenerate_id(true); }else{ session_regenerate_id(); }

						$this->usr = $__CRM_c[0];
						$this->usr_grp = $__CRM_c[1];
						$this->usr_cl = $__CRM_c[2];
						$this->usr_ses = $__CRM_c[3];

						$this->__lgin_set_rg();
						//$this->__rg($_us_dt->id, 'ok');
						$this->__ck();
					}

				}
			}
		}


		if(defined('DB_CL_ENC_SES') && !empty($__chck_ses_lng) && (count($__chck_ses_lng) > 0)){

			$__CRM_l = explode('.', $__chck_ses_lng);
			if( !isN($__CRM_l[0]) && !isN($__CRM_l[1])){
				$this->__lng([ 'lng'=>$__CRM_l[1], 'ctry'=>$__CRM_l[0] ]);
			}

		}
	}


	public function __ck(){

		$__ses_mm_adm = $this->GtSess('usr');
		$__ses_mm_adm_g = $this->GtSess('grp');
		$__ses_mm_acnt = $this->GtSess('cl');
		$__ses_mm_ses = $this->GtSess('ses');

		$__ses_mm_ses_ctry = $this->GtSess('ctry');
		$__ses_mm_ses_lng = $this->GtSess('lng');

		if($__ses_mm_adm != '' && $__ses_mm_adm_g != '' && $__ses_mm_acnt != '' && $__ses_mm_ses != ''){

			$cookiehash = $__ses_mm_adm .'.'. $__ses_mm_adm_g . '.'. $__ses_mm_acnt . '.'. $__ses_mm_ses;

			if($this->usr_sve){
				$expireson = time()+(10 * 365 * 24 * 60 * 60);
			}else{
				$expireson = time()+(3600 * 6);
			}

			$this->ses_expon = $expireson;
			setcookie(CK_SES_C.DB_CL_ENC, $cookiehash, $expireson, '/', Gt_DMN(), $this->__ssl, 'httponly');
			setcookie(CK_SES_L, $__ses_mm_ses_ctry.'.'.$__ses_mm_ses_lng, $expireson, '/', DMN_CRM_B, $this->__ssl, 'httponly');

			$__upd = $this->__rg_upd([ 't'=>'tme', 'exp'=>date('Y-m-d H:i:s', $expireson) ]);

			$_r['expires'] = $expireson;
		}

		return _jEnc($_r);
	}


	public function __ck_us(){

		if(!isN($this->ses_usenc)){
			$expireson = time()+(10 * 365 * 24 * 60 * 60);
			setcookie(CK_SES_U, $this->ses_usenc, $expireson, '/', Gt_DMN(), $this->__ssl, 'httponly');
			$_r['expires'] = $expireson;
		}

		return _jEnc($_r);
	}



	public function __ck_cln($p=NULL){

		setcookie(CK_SES_C.DB_CL_ENC, FALSE, -1, '/', Gt_DMN(), $this->__ssl, 'httponly');

		unset($_COOKIE[CK_SES_L]);
		unset($_COOKIE[CK_SES_C.DB_CL_ENC]);
		unset($_COOKIE[CK_SES]);
		unset($_SESSION); $_SESSION=NULL;

		if(isset($_COOKIE)){
			foreach($_COOKIE as $name => $value){
				unset($_COOKIE[$name]);
			}
		}

		if($p['dstry']=='ok'){ session_destroy(); }else{ session_reset(); }

		if(PHP_VERSION >= 5.1){ session_regenerate_id(true); }else{ session_regenerate_id(); }

	}



	public function GtUsPrmAll($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['us']) ){

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_US_PRM.'
										 INNER JOIN '._BdStr(DBM).TB_MDL_S_TP_PRM.' ON usprm_prm = id_mdlstpprm
										 INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON mdlstpprm_mdlstp = id_mdlstp
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON usprm_cl = id_cl
										 INNER JOIN '._BdStr(DBM).TB_US.' ON usprm_us = id_us
									WHERE us_enc = %s AND cl_enc = %s',
									GtSQLVlStr($p['us'],'text'),
									GtSQLVlStr(DB_CL_ENC,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do {

						$__ide = $row_DtRg['mdlstpprm_enc'];

						$__vle[] = $row_DtRg['mdlstpprm_vl'];
						$__id[] = $row_DtRg['id_mdlstpprm'];

						$_o[$__ide] = [
							'id'=>$Vl['id_mdlstpprm'],
							'enc'=>$__ide,
							'nm'=>ctjTx($row_DtRg['mdlstpprm_nm'],'in'),
							'mdlstp'=>[
								'nm'=>ctjTx($row_DtRg['mdlstp_nm'],'in'),
							]
						];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				echo $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

			$query_DtRgGrp = sprintf('SELECT *
									  FROM '._BdStr(DBM).TB_CL_GRP_PRM.'
									  	   INNER JOIN '._BdStr(DBM).TB_MDL_S_TP_PRM.' ON clgrpprm_prm = id_mdlstpprm
									  	   INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON mdlstpprm_mdlstp = id_mdlstp
									  	   INNER JOIN '._BdStr(DBM).TB_CL_GRP.' ON clgrpprm_clgrp = id_clgrp
									  WHERE

									  	id_clgrp IN (

											SELECT clgrpus_clgrp
											FROM '._BdStr(DBM).TB_CL_GRP_US.'
												 INNER JOIN '._BdStr(DBM).TB_CL_GRP.' ON clgrpus_clgrp = id_clgrp
												 INNER JOIN '._BdStr(DBM).TB_CL.' ON clgrp_cl = id_cl
												 INNER JOIN '._BdStr(DBM).TB_US.' ON clgrpus_us = id_us
											WHERE us_enc = %s AND cl_enc = %s

										)

									   ', GtSQLVlStr($p['us'],'text'), GtSQLVlStr(DB_CL_ENC,'text'));

			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Tot_DtRgGrp > 0){

					$Vl['e'] = 'ok';

					do {

						$__ide = $row_DtRgGrp['mdlstpprm_enc'];

						$__vle[] = $row_DtRgGrp['mdlstpprm_vl'];
						$__id[] = $row_DtRgGrp['id_mdlstpprm'];


						$_o[$__ide] = [
							'id'=>$Vl['id_mdlstpprm'],
							'enc'=>$__ide,
							'nm'=>ctjTx($row_DtRgGrp['mdlstpprm_nm'],'in'),
							'mdlstp'=>[
								'nm'=>ctjTx($row_DtRgGrp['mdlstp_nm'],'in'),
							]
						];


					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());


				}

				if(is_array($__vle)){ $Vl['mdl'] = implode(',', $__vle); }
				if(is_array($__id)){ $Vl['mdl_n'] = implode(',', $__id); }
				if(is_array($__id)){ $Vl['mdl_a'] = $_o; }

			}else{

				echo $__cnx->c_r->error;

			}
			$__cnx->_clsr($DtRgGrp);

			return _jEnc($Vl);
		}
	}


	public function GtUsMdlAll($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['us']) ){

			$query_DtRg = sprintf('	SELECT *
									FROM '.$this->bd.TB_MDL_US.'
										 INNER JOIN '.$this->bd.TB_MDL.' ON mdlus_mdl = id_mdl
										 INNER JOIN '._BdStr(DBM).TB_US.' ON mdlus_us = id_us
									WHERE us_enc = %s',
									GtSQLVlStr($p['us'],'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do {

						$__ide = $row_DtRg['mdl_enc'];

						$__vle[] = $row_DtRg['mdl_nm'];
						$__id[] = $row_DtRg['id_mdl'];

						$_o[$__ide] = [
							'id'=>$Vl['id_mdl'],
							'enc'=>$__ide,
							'nm'=>ctjTx($row_DtRg['mdl_nm'],'in'),
						];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);


			$query_DtRgGrp = sprintf('SELECT *
									  FROM '.$this->bd.TB_CLGRP_MDL.'
									  	   INNER JOIN '.$this->bd.TB_MDL.' ON mdlgrp_mdl = id_mdl
									  	   INNER JOIN '._BdStr(DBM).TB_CL_GRP.' ON mdlgrp_clgrp = id_clgrp
									  WHERE

									  	mdlgrp_clgrp IN (

											SELECT id_clgrp
											FROM '._BdStr(DBM).TB_CL_GRP_US.'
												 INNER JOIN '._BdStr(DBM).TB_CL_GRP.' ON clgrpus_clgrp = id_clgrp
												 INNER JOIN '._BdStr(DBM).TB_CL.' ON clgrp_cl = id_cl
												 INNER JOIN '._BdStr(DBM).TB_US.' ON clgrpus_us = id_us
											WHERE us_enc = %s AND cl_enc = %s

										)

									   ', GtSQLVlStr($p['us'],'text'), GtSQLVlStr(DB_CL_ENC,'text'));

			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Tot_DtRgGrp > 0){

					$Vl['e'] = 'ok';

					do {

						$__ide = $row_DtRgGrp['mdl_enc'];

						$__vle[] = $row_DtRgGrp['mdl_nm'];
						$__id[] = $row_DtRgGrp['id_mdl'];


						$_o[$__ide] = [
							'id'=>$Vl['mdl_enc'],
							'enc'=>$__ide,
							'nm'=>ctjTx($row_DtRgGrp['mdl_nm'],'in'),
						];


					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());


				}


			}else{

				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRgGrp);

			if(is_array($__vle)){ $Vl['mdl'] = implode(',', $__vle); }
			if(is_array($__id)){ $Vl['mdl_n'] = implode(',', $__id); }
			if(is_array($__id)){ $Vl['mdl_a'] = $_o; }

			return _jEnc($Vl);
		}
	}

	public function GtUsCntEstAll($p=NULL){ //$Id=NULL, $Nw=NULL

		global $__cnx;

		if(!isN($p['id'])){

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRgGrp = sprintf('SELECT *
									  FROM '._BdStr(DBM).TB_SIS_CNT_EST.'
									  	   '.DBM.'.us_grp_cntest ON usgrpcntest_cntest = id_siscntest
									  	   '.DBM.'.us_grp_us ON usgrpcntest_usgrp = usgrpus_grp
									  	   '._BdStr(DBM).TB_US.' ON usgrpus_us = id_us
									  WHERE usgrpus_us = %s', GtSQLVlStr($c_DtRg,'int'));

			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Nw != ''){
					$_Nw_Arr = explode(',', $Nw);
				}

				if($Tot_DtRgGrp > 0){

					do {
						$__vle[] = $row_DtRgGrp['id_siscntest'];
					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());

					if(is_array($_Nw_Arr)){  $_Nw_Mrg = array_merge($_Nw_Arr, $__vle);  }else{ $_Nw_Mrg = $__vle; }
					if(is_array($_Nw_Mrg)){  $Vl['vld'] = implode(',', $_Nw_Mrg);  }

					$Vl['e'] = true;
				}else{
					$Vl['e'] = false;
				}

			}else{

				echo $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRgGrp);

			return(_jEnc($Vl));

		}
	}




	public function GtClAreAll($p=NULL){

		global $__cnx;

		if( defined('DB_CL_ENC') || !isN($p['cl_enc']) ){

			if( !isN($p['cl_enc']) ){
				$_cl_enc = $p['cl_enc'];
			}else{
				$_cl_enc = DB_CL_ENC;
			}

			$c_DtRg = "-1"; if(isset($p['id'])){ $c_DtRg = $p['id']; }

			$query_Ls = sprintf('SELECT *,
											'._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).',
											'.GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ]).'
									  FROM '._BdStr(DBM).TB_CL_ARE.'
									  	   INNER JOIN '._BdStr(DBM).TB_CL.' ON clare_cl = id_cl
									  	   '.GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clare_tp', 'als'=>'t' ]).'
									  WHERE cl_enc = %s', GtSQLVlStr($_cl_enc,'text'));

			$Ls = $__cnx->_qry($query_Ls);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){

					do {


						$___id = $row_Ls['id_clare'];
						$___b[$___id] = [
											'id'=>$___id,
											'tt'=>ctjTx($row_Ls['clare_tt'],'in'),
											'clr'=>ctjTx($row_Ls['clare_clr'],'in'),
											'logo'=>ctjTx($row_Ls['clare_logo'],'in'),
											'tp'=>[
												'id'=>ctjTx($row_Ls['tipo_id_sisslc'],'in'),
												'tt'=>ctjTx($row_Ls['tipo_sisslc_tt'],'in'),
												'enc'=>ctjTx($row_Ls['tipo_sisslc_enc'],'in')
											],
											'prnt'=>$row_Ls['clare_prnt']
										];


					}while($row_Ls = $Ls->fetch_assoc());

					$Vl['e'] = 'ok';

					$__three = _bTree_id($___b, '', 'a');
					$Vl['ls']['a'] = $__three;

					$__ch_three_d = _bTree_chld($__three);
					$Vl['ls']['c'] = $__ch_three_d;

					$__pr_three_d = _bTree_prnt($__three);
					$Vl['ls']['p'] = $__pr_three_d;


				}else{

					$Vl['e'] = 'no';

				}

			}else{

				echo $__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls);

		}

		return(_jEnc($Vl));

	}


	public function GtClPlcyAll($p=NULL){

		global $__cnx;

		if(defined('DB_CL_ENC')){

			$c_DtRg = "-1"; if(isset($p['id'])){ $c_DtRg = $p['id']; }

			$query_Ls = sprintf('SELECT *
								 FROM '._BdStr(DBM).TB_CL_PLCY.'
								  	 INNER JOIN '._BdStr(DBM).TB_CL.' ON clplcy_cl = id_cl
								 WHERE cl_enc = %s', GtSQLVlStr(DB_CL_ENC,'text'));

			$Ls = $__cnx->_qry($query_Ls);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){

					do {


						$___id = $row_Ls['id_clplcy'];
						$___b[$___id] = [
											'id'=>ctjTx($row_Ls['id_clplcy'],'in'),
											'enc'=>ctjTx($row_Ls['clplcy_enc'],'in'),
											'nm'=>ctjTx($row_Ls['clplcy_nm'],'in'),
											'tx'=>ctjTx($row_Ls['clplcy_tx'],'in'),
											'lnk'=>[
												'tt'=>ctjTx($row_Ls['clplcy_lnk_tt'],'in'),
												'url'=>ctjTx($row_Ls['clplcy_lnk'],'in')
											]
										];


					}while($row_Ls = $Ls->fetch_assoc());

					$Vl['e'] = 'ok';

					$__three = _bTree_id($___b, '', 'a');
					$Vl['ls']['a'] = $__three;

					$__ch_three_d = _bTree_chld($__three);
					$Vl['ls']['c'] = $__ch_three_d;

					$__pr_three_d = _bTree_prnt($__three);
					$Vl['ls']['p'] = $__pr_three_d;


				}else{

					$Vl['e'] = 'no';

				}

			}else{

				echo $__cnx->c_r->error;

			}
			$__cnx->_clsr($Ls);

		}

		return(_jEnc($Vl));

	}


	public function GtUsAreAll($p=NULL){ //$Id=NULL, $Nw=NULL

		global $__cnx;

		if(!isN($p['us'])){

			$__all_are = $this->GtClAreAll(); //echo json_encode($__all_are->ls->a); echo '---------';

			$c_DtRg = "-1";if (isset($p['us'])){ $c_DtRg = $p['us']; }


			$query_DtRgGrp = sprintf('SELECT *
									  FROM '._BdStr(DBM).TB_US_ARE.'
									  	   INNER JOIN '._BdStr(DBM).TB_US.' ON usare_us = id_us
									  	   INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON usare_clare = id_clare
									  	   INNER JOIN '._BdStr(DBM).TB_CL.' ON clare_cl = id_cl
									  WHERE us_enc = %s AND cl_enc = %s',
									  		GtSQLVlStr($c_DtRg,'text'),
									  		GtSQLVlStr(DB_CL_ENC,'text'));


			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Tot_DtRgGrp > 0){

					do {

						$_r['ls'][] = $row_DtRgGrp['usare_clare'];

					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());

					$Vl['e'] = 'ok';

				}else{

					$Vl['e'] = 'no';

				}

			}else{

				echo $__cnx->c_r->error;

			}



			$query_DtRgGrp = sprintf('SELECT *
									  FROM '._BdStr(DBM).TB_CL_GRP_ARE.'
									  	   INNER JOIN '._BdStr(DBM).TB_CL_GRP.' ON clgrpare_clgrp = id_clgrp
									  	   INNER JOIN '._BdStr(DBM).TB_CL_GRP_US.' ON clgrpus_clgrp = id_clgrp
									  	   INNER JOIN '._BdStr(DBM).TB_US.' ON clgrpus_us = id_us
									  	   INNER JOIN '._BdStr(DBM).TB_CL.' ON clgrp_cl = id_cl
									  WHERE us_enc = %s AND cl_enc = %s',
									  	GtSQLVlStr($c_DtRg,'text'),
									  	GtSQLVlStr(DB_CL_ENC,'text'));

			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Tot_DtRgGrp > 0){

					do {

						$_r['ls'][] = $row_DtRgGrp['clgrpare_clare'];

					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());

				}

			}else{

				echo $__cnx->c_r->error;
				$Vl['e'] = 'no';

			}

			$_arels = array();
			$_arelo = array();

			$__mrg = _jEnc( array_unique($_r['ls']) );

			foreach($__mrg as $__mrg_v){

				$__o = $__all_are->ls->c->{'are-'.$__mrg_v};
				$__sub = $__o->sub;

				array_push($_arels, $__mrg_v);
				array_push($_arelo, $__o);

				if(count($__sub) > 0){
					foreach($__sub as $__sub_k=>$__sub_v){
						array_push($_arels, $__sub_v->id);
						array_push($_arelo, $__sub_v);
					}
				}

			}

			$Vl['ls'] = $_arels;
			$Vl['o'] = $_arelo;


			//$__three = _bTree_id($_arelo, '', 'a');
			//$Vl['a'] = $__three;


			$__cnx->_clsr($DtRgGrp);

			return(_jEnc($Vl));

		}
	}



	public function GtUsPlcyAll($p=NULL){ //$Id=NULL, $Nw=NULL

		global $__cnx;

		if(!isN($p['us'])){

			$__all_plcy = $this->GtClPlcyAll();

			$query_DtRgGrp = sprintf('SELECT *
									  FROM '._BdStr(DBM).TB_US_PLCY.'
									  	   INNER JOIN '._BdStr(DBM).TB_US.' ON usplcy_us = id_us
									  	   INNER JOIN '._BdStr(DBM).TB_CL_PLCY.' ON usplcy_plcy = id_clplcy
									  	   INNER JOIN '._BdStr(DBM).TB_CL.' ON clplcy_cl = id_cl
									  WHERE us_enc = %s AND cl_enc = %s',
									  		GtSQLVlStr($p['us'],'text'),
									  		GtSQLVlStr(DB_CL_ENC,'text'));

			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Tot_DtRgGrp > 0){

					do {

						$_r['ls'][] = $row_DtRgGrp['usplcy_plcy'];

					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());

					$Vl['e'] = 'ok';

				}else{

					$Vl['e'] = 'no';

				}

			}else{

				echo $__cnx->c_r->error;

			}


			$query_DtRgGrp = sprintf('SELECT *
									  FROM '._BdStr(DBM).TB_CL_GRP_PLCY.'
									  	   INNER JOIN '._BdStr(DBM).TB_CL_GRP.' ON clgrpplcy_clgrp = id_clgrp
									  	   INNER JOIN '._BdStr(DBM).TB_CL_GRP_US.' ON clgrpus_clgrp = id_clgrp
									  	   INNER JOIN '._BdStr(DBM).TB_US.' ON clgrpus_us = id_us
									  	   INNER JOIN '._BdStr(DBM).TB_CL.' ON clgrp_cl = id_cl
									  WHERE us_enc = %s AND cl_enc = %s',
									  	GtSQLVlStr($p['us'],'text'),
									  	GtSQLVlStr(DB_CL_ENC,'text'));

			$DtRgGrp = $__cnx->_qry($query_DtRgGrp);

			if($DtRgGrp){

				$row_DtRgGrp = $DtRgGrp->fetch_assoc();
				$Tot_DtRgGrp = $DtRgGrp->num_rows;

				if($Tot_DtRgGrp > 0){

					do {

						$_r['ls'][] = $row_DtRgGrp['clgrpplcy_clplcy'];

					}while($row_DtRgGrp = $DtRgGrp->fetch_assoc());

				}

			}else{

				echo $__cnx->c_r->error;
				$Vl['e'] = 'no';

			}

			$_plcyls = array();
			$_plcylo = array();

			$__mrg = _jEnc( array_unique($_r['ls']) );

			foreach($__mrg as $__mrg_v){

				$__o = $__all_plcy->ls->c->{'plcy-'.$__mrg_v};
				$__sub = $__o->sub;

				array_push($_plcyls, $__mrg_v);
				array_push($_plcylo, $__o);

				if(count($__sub) > 0){
					foreach($__sub as $__sub_k=>$__sub_v){
						array_push($_plcyls, $__sub_v->id);
						array_push($_plcylo, $__sub_v);
					}
				}

			}

			$Vl['ls'] = $_plcyls;
			$Vl['o'] = $_plcylo;


			$__cnx->_clsr($DtRgGrp);
			return(_jEnc($Vl));

		}
	}


	public function GtUsSesLng($_p=NULL){

		global $__cnx;

		if(!isN($_p['cod'])){

			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_LNG." WHERE sislng_cod = %s LIMIT 1", GtSQLVlStr($_p['cod'],'text'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$Vl['id'] = ctjTx($row_DtRg['id_sislng'], 'in');
						$Vl['enc'] = ctjTx($row_DtRg['sislng_enc'], 'in');
						$Vl['nm'] = ctjTx($row_DtRg['sislng_nm'], 'in');
						$Vl['cod'] = ctjTx($row_DtRg['sislng_cod'], 'in');

						if($row_DtRg['sislng_cod'] == 'es' && !isN( $this->GtSess('ctry') ) ){
							$__flg = str_replace('.', '_'.$this->GtSess('ctry').'.', $row_DtRg['lng_flg']);
						}elseif(!isN($row_DtRg['sislng_flg'])){
							$__flg = $row_DtRg['sislng_flg'];
						}else{
							$__flg = 'es.svg';
						}

						if(!isN($__flg)){
							$Vl['flg'] = DMN_FLE_LNG.$__flg;
						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL;
				}

			}else{

				echo $__cnx->c_r->error;

			}
			$__cnx->_clsr($DtRg);
		}

		return(_jEnc($Vl));
	}


	public function GtSesDt($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if(($p['i']!='')){

			$c_DtRg = "-1"; if(isset($p['i'])){$c_DtRg = $p['i'];}

			$query_DtRg = sprintf('	SELECT id_uses, uses_enc, uses_us, uses_exp, uses_est, uses_dvc
									FROM '._BdStr(DBM).TB_US_SES.'
									WHERE uses_enc=%s
									LIMIT 1', GtSQLVlStr($c_DtRg,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_uses'];
					$Vl['enc'] = $row_DtRg['uses_enc'];

					if($p['bsc']!='ok'){
						$Vl['us'] = $this->GtSesUsDt($row_DtRg['uses_us']);
					}

					$Vl['exp'] = $row_DtRg['uses_exp'];
					$Vl['dvc']['id'] = $row_DtRg['uses_dvc'];
					$Vl['est'] = mBln($row_DtRg['uses_est']);
					$Vl['e'] = 'ok';

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;
				$Vl['e'] = 'no_q';

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = $__cnx->c_r->error;
			$Vl['e'] = 'no_i';

		}

		return( _jEnc($Vl) );
	}


	public function GtSesUsDt($Id=NULL, $Tp=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($Id)){

			if($Tp == 'enc'){
				$__f = 'us_enc'; $__ft = 'text';
			}elseif($Tp == 'eml'){
				$__f = 'us_user'; $__ft = 'text';
			}else{
				$__f = 'id_us'; $__ft = 'int';
			}

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_US.'
									WHERE '.$__f.' = '.GtSQLVlStr($c_DtRg, $__ft).'
									LIMIT 1');

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$__sisusprm = $this->GtUsPrmAll([ 'us'=>$row_DtRg['us_enc'] ]);
					$__sisusmdl = $this->GtUsMdlAll([ 'us'=>$row_DtRg['us_enc'] ]);
					//$__sisusmdl = $this->GtUsMdlGrpAll([ 'us'=>$row_DtRg['us_enc'] ]);
					$__sisuscntest = $this->GtUsCntEstAll([ 'us'=>$row_DtRg['id_us'], 'siscntest_inc'=>$row_DtRg['us_cntest_inc'] ]);
					$__sisuslng = $this->GtUsSesLng([ 'cod'=>$this->GtSess('lng') ]);
					$__sisusare = $this->GtUsAreAll([ 'us'=>$row_DtRg['us_enc'] ]);
					$__sisusplcy = $this->GtUsPlcyAll([ 'us'=>$row_DtRg['us_enc'] ]);


					$Vl['id'] = $row_DtRg['id_us'];
					$Vl['e'] = true;
					$Vl['n'] = $row_DtRg['us_nivel'];

					$Vl['nivel'] = $row_DtRg['us_nivel'];
					$Vl['user'] = $row_DtRg['us_user'];
					$Vl['fac'] = $row_DtRg['us_fac'];
					$Vl['enc'] = $row_DtRg['us_enc'];
					$Vl['gnr'] = $row_DtRg['us_gnr'];
					$Vl['nm'] = ctjTx($row_DtRg['us_nm'],'in');
					$Vl['ap'] = ctjTx($row_DtRg['us_ap'],'in');
					$Vl['fn'] = ctjTx($row_DtRg['us_fn'],'in');
					$Vl['ntf'] = mBln($row_DtRg['us_ntf']);

					$Vl['crg'] = ctjTx($row_DtRg['us_crg'],'in');

					$Vl['fll'] = ctjTx($row_DtRg['us_nm'].HTML_BR.$row_DtRg['us_ap'],'in');


					if( !isN($row_DtRg['us_img']) ){
						$Vl['img'] = _ImVrs(['img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);
					}else{
						$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
						$Vl['img'] = $_img;
					}

					$Vl['age'] = $row_DtRg['us_age'];

					$Vl['siscntest_exc'] = $row_DtRg['us_cntest_exc'];



					$Vl['pass'] = $row_DtRg['us_pass'];
					$Vl['pass_chn'] = $row_DtRg['us_pass_chn'];
					//$Vl['mdl'] = $__sisusprm;
					$Vl['prm'] = $__sisusprm;
					$Vl['mdl'] = $__sisusmdl;

					$Vl['msv_usr'] = ctjTx($row_DtRg['us_msv_user'],'in');


					if(!isN($__sisusare->ls)){ $Vl['are'] = implode(',', $__sisusare->ls); }
					if(!isN($__sisusplcy->ls)){ $Vl['plcy'] = implode(',', $__sisusplcy->ls); }


					$Vl['cnt_est'] = $__sisuscntest;

					$Vl['lng'] = $__sisuslng;

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['m'] = 'No data';

		}

		return(_jEnc($Vl));
	}



	public function GtSesOauthDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'usesoauth_enc'; $__ft = 'text';
			}else{
				$__f = 'id_usesoauth'; $__ft = 'int';
			}

			$query_DtRg = sprintf('	SELECT id_usesoauth, usesoauth_cl, usesoauth_us, us_user, usesoauth_expire, usesoauth_active
									FROM '._BdStr(DBM).TB_US_SES_OAUTH.'
										 INNER JOIN '._BdStr(DBM).TB_US.' ON usesoauth_us = id_us
									WHERE '.$__f.' = '.GtSQLVlStr($p['id'], $__ft).'
									LIMIT 1');

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_usesoauth'];
					$Vl['us']['id'] = $row_DtRg['usesoauth_us'];
					$Vl['us']['user'] = $row_DtRg['us_user'];
					$Vl['cl']['id'] = $row_DtRg['usesoauth_cl'];
					$Vl['exp'] = $row_DtRg['usesoauth_expire'];
					$Vl['on'] = mBln($row_DtRg['usesoauth_active']);
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['m'] = 'No data';

		}

		return(_jEnc($Vl));
	}



	public function SesOauthUpd($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$insertSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_SES_OAUTH." SET usesoauth_active=%s WHERE id_usesoauth=%s",
											GtSQLVlStr(2, "text"),
											GtSQLVlStr($p['id'], "text"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
			}

		}

		return _jEnc($rsp);
	}


	public function _Lgin(){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->lgin_oauth)){

			$_oauth_dt = $this->GtSesOauthDt([ 'id'=>$this->lgin_oauth, 't'=>'enc' ]);

			if(!isN($_oauth_dt->us->id) && $_oauth_dt->on == 'ok'){

				if(SIS_F_TS < $_oauth_dt->exp) {
					$_us_dt = $this->GtSesUsDt($_oauth_dt->us->id);
					$loginUsername = enCad( $_us_dt->id . $_oauth_dt->us->user . $_us_dt->n );
				}else{
					$rsp['w'] = 'oauth expired';
				}

			}

		}else{
			$password = enCad( $this->lgin_pass );
			$_us_dt = $this->GtSesUsDt($this->lgin_user, 'eml');
			$loginUsername = enCad( $_us_dt->id . $this->lgin_user . $_us_dt->n );
		}

	    if( $_us_dt->e && !isN($_us_dt->enc)){

			if(!isN($_oauth_dt->us->id)){
				$_pss = sprintf('AND id_us=%s',GtSQLVlStr($_oauth_dt->us->id, "int"));
			}else{
				$_pss = sprintf('AND us_pass=%s',GtSQLVlStr($password, "text"));
			}

		    if($this->lgin_acc != 'ok'){

			   	$__cl_fl = sprintf(" AND (	id_us IN(
												SELECT uscl_us
												FROM "._BdStr(DBM).TB_US_CL."
													 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
												WHERE cl_sbd = %s ) OR
											us_nivel = %s
									 )",
									 GtSQLVlStr(Gt_SbDMN(), "text"),
									 GtSQLVlStr("superadmin", "text")
								);
			}

	        $MM_redirecttoReferrer = true;

	        $LoginRS__query = sprintf("	SELECT id_us, us_user, us_nivel
	        							FROM "._BdStr(DBM).TB_US."
										WHERE us_est = 1 AND us_enc=%s {$_pss} ".$__cl_fl."
										LIMIT 1",
	                                    GtSQLVlStr($loginUsername, "text"));

	        $LoginRS = $__cnx->_qry($LoginRS__query);

	        if($LoginRS){

		        $row_LoginRS = $LoginRS->fetch_assoc();
		        $loginFoundUser = $LoginRS->num_rows;
				//$rsp['dvcw'] = 'ok';
	            if(($loginFoundUser)){

                    mysqli_data_seek($LoginRS, 0);

                    $this->usr = $loginUsername;
                    $this->usr_grp = enCad($row_LoginRS['us_nivel']);
                    $this->usr_id = $row_LoginRS['id_us'];

                    if(defined('DB_CL_ENC')){
                    	$this->usr_cl = DB_CL_ENC;
                    }

                    if($this->lgin_usdt=='ok'){
	                    $this->ses_usenc = $_us_dt->enc;
						$this->__ck_us([ ]);
	                }

                    $this->usr_nvl = $row_LoginRS['us_nivel'];

					if($this->lgin_sve == 1){ $this->usr_sve = true; }

					if($this->lgin_acc != 'ok'){
						$__e = $this->__lgin_set_rg();
					}

                    if($__e->e == 'ok' || $this->lgin_acc == 'ok'){

						$rsp['e'] = 'ok';
						$rsp['u'] = $row_LoginRS['us_user'];
						$rsp['m'] = 1;

						if($this->lgin_acc != 'ok'){
							$rsp['ses']['id'] = $__e->__rg->enc;
						}

						unset($_us_dt->pass);
						$rsp['us']=$_us_dt;

						if(!isN($this->lgin_oauth)){
							$this->SesOauthUpd([ 'id'=>$_oauth_dt->id ]);
						}

                    }else{

						$rsp['w'] = $__e->w;
						$rsp['w2'] = $__e->w2;
						if(!isN($__e->dvcw)){ $rsp['dvcw'] = $__e->dvcw; }
					}

	            } else {

	                //$__e = $this->__rg([ 'id'=>'3' ], 'no', $loginUsername);
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
	                //$rsp['w2'] = enCad( $_us_dt->id . $this->lgin_user . $_us_dt->n );

	                //$rsp['tmp_lgin']['username'] = $loginUsername;
	                //$rsp['tmp_lgin']['password'] = $password;
	                //$rsp['tmp_lgin']['password_d'] = $this->lgin_pass;

	            }

            }else{

	            $rsp['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($LoginRS);

	    }else{

	        $rsp['e'] = 'no'; $rsp['m'] = 2;

	    }

		return _jEnc($rsp);
	}


	// Funcion Registra Sesion de Usuari
	public function __oauth($_p=NULL){

		global $__cnx;

		$r['e'] = 'no';

		if(!isN($_p['us']) && !isN($_p['cl']) && !isN($_p['tp'])){

			$__enc = Enc_Rnd($_p['us'].'-'.$_p['cl'].'-'.$_p['tp']);
			$__expr = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime(date("Y-m-d H:i:s"))));

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_SES_OAUTH." (usesoauth_enc, usesoauth_cl, usesoauth_us, usesoauth_tp, usesoauth_cid, usesoauth_data, usesoauth_expire) VALUES (%s, %s, %s, %s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($_p['cl'], "int"),
							GtSQLVlStr($_p['us'], "int"),
							GtSQLVlStr($_p['tp'], "int"),
							GtSQLVlStr($_p['cid'], "text"),
							GtSQLVlStr(ctjTx($_p['data'],'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no' ]), "text"),
							GtSQLVlStr($__expr, "date"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$r['e'] = 'ok';
				$r['enc'] = $__enc;
			}else{
				$r['w'] = 'error __rg:'.$__cnx->c_p->error;
				$r['q'] = $insertSQL;
			}

		}else{

			$r['w'] = 'No e data';

		}

		return _jEnc($r);
	}

}


function SisTst(){
	if(isset($_SESSION[DB_CL_ENC_SES.MM_ADM_TST])){ return true; }else{ return false; }
}

// Cotejamiento Texto
function ctjTx($tx=NULL,$tCtj=NULL, $_JSON=NULL, $p=NULL){

	try{

		if($p['html']!=NULL){$_p_html=$p['html'];}else{$_p_html='no';} // Html Tags
		if($p['schr']!=NULL){$_p_schr=$p['schr'];}else{$_p_schr='no';} // Special Chars
		if($p['sslh']!=NULL){$_p_sslh=$p['sslh'];}else{$_p_sslh='no';} // Strip Slashes
		if($p['nl2']!=NULL){$_p_nl2=$p['nl2'];}else{$_p_nl2='no';} // Strip br
		if($p['qte']!=NULL){$_p_qte=$p['qte'];}else{$_p_qte='no';} // Strip br

		if($tCtj == "in"){
			if($_p_html=='no'){ $tx = strip_tags($tx); }
			//if($_p_schr=='ok'){ $tx = htmlspecialchars($tx); }
			if($_p_sslh=='ok'){ $tx = stripslashes($tx); }
			//$val1 = utf8_decode($tx);
			$val1 = $tx;
		}else if($tCtj == "out"){
			//if($_p_html=='no'){ $tx = strip_tags($tx); }
			if($_p_qte=='ok'){ $tx = str_replace('"', '\'', $tx); }else{ $tx = $tx; }
			if($_p_html!='no' && $_p_nl2!='no'){ $tx = nl2br($tx); }else{ $tx = $tx; }
			if($_p_schr=='ok'){ $tx = htmlspecialchars($tx); }
			if($_p_sslh=='ok'){ $tx = stripslashes($tx); }
			//$val1 = utf8_encode($__html);
			$val1 = $tx;
		}
		if($_JSON==true){ $val1 = addslashes(strip_tags($val1)); }

	}catch(Exception $e) {

		if(defined('DSERR') && DSERR == 'on'){
			echo $e->getMessage().' ctjTx on '.$tx;
		}
	}

	return $val1;
}


function GtClTagLs($p){

	global $__cnx;

	if(!isN($p['id'])){

		$__f = 'cltag_cl'; $__ft = 'int';

		$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

		$query_DtRg = sprintf("	SELECT *, "._QrySisSlcF()."
								FROM "._BdStr(DBM).TB_CL_TAG.", "._BdStr(DBM).TB_SIS_SLC."
								WHERE cltag_sistag = id_sisslc AND ".$__f." = %s", GtSQLVlStr($c_DtRg, $__ft));

		$DtRg = $__cnx->_qry($query_DtRg);
		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			//$__slc_o = GtSlcF_Ls([ 'tp'=>$row_DtRg['sisslc_tp' ] ]);

			if($Tot_DtRg > 0){

				do{

					$___col = json_decode($row_DtRg['___fld']);

					foreach($___col as $__attr_k=>$__attr_v){
						$__attr_go->{$__attr_v->key} = $__attr_v;
					}

					$__grp = $__attr_go->tp->vl;

					if(is_array($___col)){

						foreach($___col as $___col_k=>$___col_v){

							if($___col_v->key != 'tp'){

								//----------- OPTIONS IN VALUE ----------//

								$__vle[$__grp][ $___col_v->vl ]['op'] = $___col_v;

								//----------- SET KIND OF RETURN IN VALUE ----------//

								if($__grp == 'chk'){

									$__vle[$__grp][ $___col_v->vl ]['v'] = mBln($row_DtRg['cltag_vl']);

								}else{

									$__vle[$__grp][ $___col_v->vl ]['v'] = ctjTx($row_DtRg['cltag_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']);

								}

							}

						}

					}

					$Vl[ $__grp ] = $__vle[ $__grp ];

				} while ($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}


}


function GtClScrptLs($p){

	global $__cnx;

	$Vl['e'] = 'no';

	if(!isN(DB_CL_ENC)){

		if(!isN($p['tp'])){ $__f .= " AND clscrpt_tp = '".$p['tp']."' "; }
		if(!isN($p['ord'])){ $__f .= " AND clscrpt_ord = '".$p['ord']."' "; }
		if(!isN($p['nxt'])){ $__f .= " AND clscrpt_ord > '".$p['nxt']."' "; $_lmt=' ORDER BY clscrpt_ord ASC LIMIT 1'; }
		if(!isN($p['sino'])){ $__f .= " AND clscrpt_sino = '".$p['sino']."' "; }

		$query_DtRg = sprintf("	SELECT *,
									   "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
									   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ]).",
									   "._QrySisSlcF([ 'als'=>'a', 'als_n'=>'action' ]).",
									   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'action', 'als'=>'a' ])."
								FROM "._BdStr(DBM).TB_CL_SCRPT."
									 INNER JOIN "._BdStr(DBM).TB_CL." ON clscrpt_cl = id_cl
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clscrpt_tp', 'als'=>'t' ])."
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clscrpt_act', 'als'=>'a' ])."

								WHERE cl_enc = '".DB_CL_ENC."' ".$__f."
								".$_lmt."

							");

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['q'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['e'] = 'ok';
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					if(!isN($row_DtRg['clscrpt_vl'])){

						$act = json_decode($row_DtRg['___action'], true);
						$tp = json_decode($row_DtRg['___tipo'], true);

						foreach($act as $act_k=>$act_v){
							$_act[ $act_v['key'] ] = $act_v;
						}

						foreach($tp as $tp_k=>$tp_v){
							$_tp[ $tp_v['key'] ] = $tp_v;
						}

						$Vl['ls'][] = [
										'id'=>$row_DtRg['id_clscrpt'],
										'enc'=>$row_DtRg['clscrpt_enc'],
										'ord'=>$row_DtRg['clscrpt_ord'],
										'sino'=>mBln($row_DtRg['clscrpt_sino']),
										'end'=>mBln($row_DtRg['clscrpt_end']),
										'tx'=>ctjTx($row_DtRg['clscrpt_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']),
										'act'=>$_act,
										'tp'=>$_tp,
									];

					}

				} while ($row_DtRg = $DtRg->fetch_assoc());

			}

		}

	}

	$__cnx->_clsr($DtRg);

	return(_jEnc($Vl));

}


function __Cl($p=NULL){

	global $__cnx;

	$Vl['e'] = 'no';

	if(!isN($p['id'])){

		if($p['t'] == 'enc'){
			$__f = 'cl_enc'; $__ft = 'text';
		}elseif($p['t'] == 'sbd'){
			$__f = 'cl_sbd'; $__ft = 'text';
		}elseif($p['t'] == 'prfl'){
			$__f = 'cl_prfl'; $__ft = 'text';
		}elseif($p['t'] == 'dmn'){
			$__fltr = sprintf( ' AND id_cl IN ( SELECT cldmn_cl
									   FROM '.TB_CL_DMN.'
									   	    INNER JOIN '.TB_CL_DMN_SUB.'
									   WHERE CONCAT(cldmnsub_sub,\'.\',cldmn_dmn)=%s
									 ) ', GtSQLVlStr($p['id'], 'text'));
		}else{
			$__f = 'id_cl'; $__ft = 'int';
		}


		$c_DtRg = "-1"; if(!isN($p['id'])){ $c_DtRg = $p['id']; }

		if(!isN($__f) && !isN($__ft)){ $__fltr = sprintf(' AND '.$__f.'=%s', GtSQLVlStr($c_DtRg, $__ft));  }

		$query_DtRg = sprintf('	SELECT id_cl, cl_sbd, cl_rsllr
								FROM '._BdStr(DBM).TB_CL.'
								WHERE id_cl!="" '.$__fltr.'
								LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$__dataext = Cl_CData([ 'id'=>$row_DtRg['cl_sbd'] ]);

				$Vl['e'] = 'ok';
				$Vl['id'] = $row_DtRg['id_cl'];
				$Vl['sbd'] = $__dataext->sbd;
				$Vl['nm'] = $__dataext->nm;
				$Vl['enc'] = $__dataext->enc;
				$Vl['prfl'] = $__dataext->prfl;
				$Vl['bd'] = $__dataext->bd;
				$Vl['tag'] = $__dataext->tag;
				$Vl['dmn'] = $__dataext->dmn;
				$Vl['eml'] = $__dataext->eml;
				$Vl['img'] = $__dataext->img;
				$Vl['bck'] = $__dataext->bck;
				$Vl['lgo'] = $__dataext->lgo;
				$Vl['chat'] = $__dataext->chat;
				$Vl['mdlstp'] = $__dataext->mdlstp;
				$Vl['on'] = $__dataext->on;

				if(!isN($row_DtRg['cl_rsllr'])){
					$Vl['rsllr'] = __Cl([ 'id'=>$row_DtRg['cl_rsllr'] ]);
				}


			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

	}else{

		$Vl['w'] = 'no data';

	}

	return(_jEnc($Vl));

}


function _ImVrs($p=NULL){


	if((!isN($p['img']) || !isN($p['img_ste'])) && !isN($p['f'])){

		$ext = '.'.pathinfo($p['img'], PATHINFO_EXTENSION);
		$Vl['ext'] = str_replace('.','',$ext);

		$_fld = $p['f'];
		$_fld_th = $p['f'].DR_IMG_TH;
		$_fld_bn = $p['f'].DR_IMG_BN;

		if(!isN($p['img'])){ $Vl['big'] = $p['f'].$p['img']; }

		if($p['img_ste']){

			if(!isN($p['img_ste_d'])){
				$_fld = $p['img_ste_d'];
				$_fld_th = $p['img_ste_d'].DR_IMG_TH;
			}

			$Vl['ste']['bg'] = $_fld.'ec_ste_'.$p['img_ste'].'.jpg';
			$Vl['ste']['th'] = $_fld_th.'ec_ste_'.$p['img_ste'].'.jpg';
		}

		if($ext != '.svg' && !isN($p['img'])){

			$Vl['sm_s'] = $p['f'].'_sm_'.$p['img'];
			$Vl['bg_s'] = $p['f'].'_md_'.$p['img'];
			$Vl['th_50'] = $_fld_th.str_replace($ext, 'x50.jpg', $p['img']);

			$Vl['th_100'] = $_fld_th.str_replace($ext, 'x100.jpg', $p['img']);
			$Vl['th_200'] = $_fld_th.str_replace($ext, 'x200.jpg', $p['img']);
			$Vl['th_400'] = $_fld_th.str_replace($ext, 'x400.jpg', $p['img']);

			$Vl['th_c_50'] = $_fld_th.str_replace($ext, '_c_x50.jpg', $p['img'] );
			$Vl['th_c_50p'] = $_fld_th.str_replace($ext, '_c_x50.png', $p['img'] );
			$Vl['th_c_100'] = $_fld_th.str_replace($ext, '_c_x100.jpg', $p['img'] );
			$Vl['th_c_100p'] = $_fld_th.str_replace($ext, '_c_x100.png', $p['img'] );
			$Vl['th_c_200'] = $_fld_th.str_replace($ext, '_c_x200.jpg', $p['img'] );
			$Vl['th_c_200p'] = $_fld_th.str_replace($ext, '_c_x200.png', $p['img'] );
			$Vl['th_c_400'] = $_fld_th.str_replace($ext, '_c_x400.jpg', $p['img'] );
			$Vl['th_c_200p'] = $_fld_th.str_replace($ext, '_c_x200.png', $p['img'] );


			$Vl['bn_200'] = $_fld_bn.str_replace($ext, 'x200.jpg', $p['img']);
			$Vl['bn_400'] = $_fld_bn.str_replace($ext, 'x400.jpg', $p['img']);
			$Vl['bn_800'] = $_fld_bn.str_replace($ext, 'x800.jpg', $p['img']);

		}
	}

	if($p['o']=='a'){ $rtrn = $Vl; }else{ $rtrn = _jEnc($Vl); }
	return($rtrn);

}

function Php_Ls_Cln($_v){
	if(GtSQLVlStr($_v, 'text')){ $_r = $_v; }
	return($_r);
}

function _GetPost($_i=NULL){

	if($_i != NULL){

		$_RAW = _PostRw(); // Post Objeto JSON
		$_RUNB = _PostR_JData(); // Post Objeto JSON - Unbounce

		$_p = Php_Ls_Cln($_POST[$_i]);
		$_g = Php_Ls_Cln($_GET[$_i]);
		$_r = Php_Ls_Cln($_RAW[$_i]);
		$_ru = Php_Ls_Cln($_RUNB->{$_i});

		if($_p != NULL && $_p != ''){ return $_p; }
		elseif($_g != NULL && $_g != ''){ return $_g; }
		elseif($_r != NULL && $_r != ''){ return $_r; }
		elseif($_ru != NULL && $_ru != ''){ return $_ru; }


		return html_entity_decode($_r); //Tempo to check encode json data
		//return ($_r);

	}else{
		return false;
	}
}

if(!function_exists("PrmLnk")){

	function PrmLnk($_t='', $_r_n='', $_pml=NULL){

		$__xpl = explode('?', $_SERVER['REQUEST_URI']);
		$prm_dt = explode('/', $__xpl[0]);

		if($_pml == 'ok'){
			$_prm_sb1 = $prm_dt[1];
			$_prm_sb2 = $prm_dt[2];
			$_prm_sb3 = $prm_dt[3];
			$_prm_sb4 = $prm_dt[4];
			$_prm_sb5 = $prm_dt[5];
		}else{
			$_prm_sb1 = _GetPost('_p1');
			$_prm_sb2 = _GetPost('_p2');
			$_prm_sb3 = _GetPost('_p3');
			$_prm_sb4 = _GetPost('_p4');
			$_prm_sb5 = _GetPost('_p5');
		}

		if($_t == 'rtn'){
			$__val = ${'_prm_sb'.$_r_n};
		}elseif($_t == 'bld'){
			$__val = $_r_n.'/';
		}elseif($_t == 'chck'){

			if((($_prm_sb1 != '')||($_prm_sb2 != '')||($_prm_sb3 != ''))&&(($prm_dt[1] != 'index.php'))){
				$__val = true;
			}else{
				$__val = false;
			}

		}else{
			$__val = false;
		}

		return($__val);

	}

}


?>