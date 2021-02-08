<?php 
		
	
	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_gr = Php_Ls_Cln($_GET['_g_r']);

	$__i = Php_Ls_Cln($_GET['__i']);
	
	
	$___Dt->sch->f = 'id_org, org_nm';
	
	$___Dt->sch->m = ' || (
		EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_SDS.' WHERE orgsds_org = id_org AND orgsds_nm LIKE \'%[-SCH-]%\' )  ||
		EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_org = id_org AND orgweb_web LIKE \'%[-SCH-]%\' ) ||
		EXISTS (SELECT * 
				FROM '._BdStr(DBM).TB_ORG_SDS_DC.' 
					 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsdsdc_orgsds = id_orgsds
				WHERE orgsds_org = id_org AND orgsdsdc_dc LIKE \'%[-SCH-]%\' 
			) 
	)';
	
	$___Dt->_strt();
	
	
	if( !isN($_t2) ){

		
		//-------------- FILTERS OUT  --------------//
		
			//$___Dt->qry_f .= " AND mdlst.mdlstp_tp = '".$___Dt->gt->tsb."' ";
			if(!isN($___Dt->gt->tsb_m)){ $___Dt->qry_f .= " AND mdlt.mdlstp_tp = '".$___Dt->gt->tsb_m."' "; }
		
		
		//-------------- START QUERYS AND BUILDERS  --------------//
	
		$__id_prfx = '_'.Gn_Rnd(20);	

		if($_tp == "grph_1"){

			include(dirname(__FILE__).'/'.$_t2.'/g1.php');
				
		}elseif($_tp == "grph_2"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g2.php');
			
		}elseif($_tp == "grph_3"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g3.php');
				
		}elseif($_tp == "grph_4"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g4.php');
				
		}elseif($_tp == "grph_5"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g5.php');
				
		}elseif($_tp == "grph_6"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g6.php');
				
		}elseif($_tp == "grph_7"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g7.php');
				
		}elseif($_tp == "grph_8"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g8.php');
				
		}elseif($_tp == "grph_mark_1"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g1.php');
				
		}elseif($_tp == "grph_mark_2"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g2.php');
				
		}elseif($_tp == "grph_clg_1" || $_tp == "org_clg_2"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g4.php');
				
		}elseif($_tp == "grph_clg_2" || $_tp == "org_clg_3"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g5.php');
				
		}elseif($_tp == "grph_clg_3"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g6.php');
				
		}elseif($_tp == "grph_card_1" || $_tp == "org_clg_4"){
			
			include(dirname(__FILE__).'/'.$_t2.'/g7.php');
				
		}
		
	} 
	
?>