<?php
if(_onl_isbot()) die();

$stringIp = $_SERVER['REMOTE_ADDR'];
$_ipvl = KnIp('on'); print_r($_ipvl);

if(!_onl_IP($_ipvl, $__dtec->id) && !isN($__dtec->id)){
	
	if($_COOKIE['geoData'])	{
		$_ip=array();
		list($_ip->city, $_ip->country_name, $_ip->country_code) = explode('|', strip_tags($_COOKIE['geoData']));
	}else{
		$_ip = json_decode(file_get_contents('http://api.hostip.info/get_json.php?ip='.$stringIp)); 
		setcookie('geoData',$_ip->city.'|'.$_ip->country_name.'|'.$_ip->country_code, time()+60*60*24*30,'/');
	}
	

	if(!isN($_ip->country_name) && !isN($_ip->country_code) && !isN($_ip->city)){
		$insertSQL = sprintf("INSERT INTO ".TB_EC_ONL." (econl_ip, econl_idobj, econl_country, econl_countrycode, econl_city) VALUES (%s, %s, %s, %s, %s)",

                       GtSQLVlStr($_ipvl, "text"),
					   GtSQLVlStr($__dtec->id, "int"),
					   GtSQLVlStr($_ip->country_name, "text"),
					   GtSQLVlStr($_ip->country_code, "text"),
					   GtSQLVlStr($_ip->city, "text"));		

		$__cnx->src_main = $insertSQL;
		$Result = $__cnx->_prc($insertSQL);
	
	}
	
	
	
	
}else{
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_ONL." SET econl_dt=NOW() WHERE econl_ip=%s AND econl_idobj=%s",
                       GtSQLVlStr($_ipvl, "text"),
                       GtSQLVlStr($__dtec->id, "int"));		

	$Result = $__cnx->_prc($updateSQL);	
	
}
	$deleteSQL = "DELETE FROM ec_onl WHERE econl_dt<SUBTIME(NOW(),'0 0:5:0')";		

	$Result = $__cnx->_prc($deleteSQL);
	
	
	

echo Spn(_onl_tot($__dtec->id)); 

$__cnx->_clsr($Result);
?>