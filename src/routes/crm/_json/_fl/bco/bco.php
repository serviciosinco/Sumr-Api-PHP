<?php 
if(class_exists('CRM_Cnx')){
	
	$rsp['e'] = 'no';
	
	
	//--------------**--------------//GET PARAMETERS *****--------------//
		
		$f_f1 = Php_Ls_Cln($_GET['_bcofl_f1']);
		$f_f2 = Php_Ls_Cln($_GET['_bcofl_f2']);
		$f_id = Php_Ls_Cln($_GET['_bcofl_id']);
		$f_are = Php_Ls_Cln($_GET['_bcofl_are']);
		$f_w = Php_Ls_Cln($_GET['_bcofl_w']);
		$f_h = Php_Ls_Cln($_GET['_bcofl_h']);
		$f_mk = Php_Ls_Cln($_GET['_bcofl_mk']);
		$f_mdl = Php_Ls_Cln($_GET['_bcofl_mdl']);
		$f_tag = Php_Ls_Cln($_GET['_bcofl_tag']);
		
	
	// Filtros Avanzados
	if(!isN($f_f1) && !isN($f_f2)){ 
		$__fl .= ' AND DATE_FORMAT(bco_fa, "%Y-%m-%d") BETWEEN '.GtSQLVlStr($f_f1, 'date').' AND '.GtSQLVlStr($f_f2, 'date'); 
	}elseif(!isN($f_f1)){
		$__fl .= " AND DATE_FORMAT(bco_fa, '%Y-%m-%d') like  '%".$f_f1."%' "; 
	}elseif(!isN($f_f2)){
		$__fl .= " AND DATE_FORMAT(bco_fa, '%Y-%m-%d')  like  '%".$f_f2."%' ";  
	}
	
	if($f_tag == 1){
		$__fl .= " AND id_bco IN ( SELECT bcotag_bco FROM "._BdStr(DBM).TB_BCO_TAG." ) ";
	}elseif($f_tag == 2){
		$__fl .= " AND id_bco NOT IN ( SELECT bcotag_bco FROM "._BdStr(DBM).TB_BCO_TAG." ) ";
	}
	

	if(!isN($f_id)){ $__fl .= _AndSql('id_bco', $f_id); }
	if(!isN($f_are)){ $__fl .=  "AND id_bco IN (SELECT bcoare_bco FROM "._BdStr(DBM).TB_BCO_ARE." WHERE bcoare_are IN (".$f_are.") ) "; }
	if(!isN($f_w)){ $__fl .= _AndSql('bco_w', $f_w); }
	if(!isN($f_h)){ $__fl .= _AndSql('bco_h', $f_h); }
	if(!isN($f_mk)){ $__fl .= "AND id_bco IN (SELECT bcoattr_bco FROM "._BdStr(DBM).TB_BCO_ATTR." WHERE bcoattr_bco = id_bco AND bcoattr_k = 'Make' AND bcoattr_v = '".str_replace('*.',' ',$f_mk)."' )"; }
	if(!isN($f_mdl)){ $__fl .= "AND id_bco IN (SELECT bcoattr_bco FROM "._BdStr(DBM).TB_BCO_ATTR." WHERE bcoattr_bco = id_bco AND bcoattr_k = 'Model' AND bcoattr_v = '".str_replace('*.',' ',$f_mdl)."' )"; }
	
	
	$__schcod = Sch_Cd('id_bco, bco_dsc, bco_org, bcotag_tag_es, bcotag_tag_en, bcotag_tag_it, bcotag_tag_fr, bcotag_tag_gr, bcotag_tag_krn, bcotag_tag_jpn, bcotag_tag_ptg, bcotag_tag_mdn',$_GET['_sch'], 2); 
	
	
	$__ls = FL_LS_GN; // Listas
	$__imgid = 'bco_img'; // Campo Imagen			

	$GtSisBcoTot = GtSisBcoTot();
	$_tot = ceil($GtSisBcoTot->tot/SIS_NMRG);

	$Ls_Pg = 0; 
	if (isset($_GET['pgN'])) {$Ls_Pg = $_GET['pgN'];} $Ls_St = $Ls_Pg * SIS_NMRG;
	 
	
	if(!_ChckMd('bco_all')){ 
		$__fl_are .= "
		
			AND 
				
				( 
					( id_bco IN( 	SELECT bcoare_bco 
									FROM "._BdStr(DBM).TB_BCO_ARE." 
									WHERE bcoare_are IN (	SELECT usare_clare 
															FROM "._BdStr(DBM).TB_US_ARE." 
															WHERE usare_us = ".SISUS_ID."
														) 
								) 
					)
					
				OR 
					( id_bco IN( 	SELECT bcocd_bco 
									FROM "._BdStr(DBM).TB_BCO_CD." 
									WHERE bcocd_cd IN (		SELECT uscd_cd 
															FROM "._BdStr(DBM).TB_US_CD." 
															WHERE uscd_us = ".SISUS_ID."
														) 
								) 
					)
					
				OR id_bco NOT IN( 	SELECT bcoare_bco 
									FROM "._BdStr(DBM).TB_BCO_ARE." 
								) 
				
				AND id_bco NOT IN( 	SELECT bcocd_bco 
									FROM "._BdStr(DBM).TB_BCO_CD." 
								) 
				) 
			
		"; 
	}
	
	$Ls_Whr = "	FROM "._BdStr(DBM).MDL_BCO_BD."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON bco_cl = id_cl
					 LEFT JOIN "._BdStr(DBM).TB_BCO_TAG." ON bcotag_bco = id_bco
				WHERE id_bco != '' AND cl_enc = '".DB_CL_ENC."' AND bco_est = '"._CId('ID_SISBCOEST_ACTV')."' $__schcod $__fl_are $__fl 
				
			";
				
	$Ls_Qry = " SELECT *, 
						(SELECT COUNT(DISTINCT id_bco) $Ls_Whr) AS __rgtot 
				$Ls_Whr
				GROUP BY bcotag_bco
				ORDER BY id_bco DESC";
				
	$Ls_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $Ls_St, SIS_NMRG);
	
	$Ls_Rg = $__cnx->_qry($Ls_Lmt); 
	
	if($Ls_Rg){
		
		$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
		$Tot_Ls_Rg = $Ls_Rg->num_rows; 
		
		QuPgsi($_GET['totRws'],$row_Ls_Rg['__rgtot'],SIS_NMRG,$_SERVER['QUERY_STRING']); $Pgs = RcPg($_GET['pgN'],LS_QR,TT_PGS,$__ls, array('r'=>$__bxrld));
		
		
		$rsp['tot'] = $_tot; 
		$rsp['url_s'] = $__shrt; 
		
			
		if ((TT_RWS > 0)) {
		
			$rsp['e'] = 'ok';
			
	    	do { 
		    	
		    	if(!isN($__dt_cl->dmn->sbd->fle) && mBln($row_Ls_Rg['bco_out']) == 'ok'){ 
			    	
			    	if($__dt_cl->dmn->sbd->fle->ssl == 'ok'){ $__http='https://'; }else{ $__http='http://'; }
			    	$__url = $__http.$__dt_cl->dmn->sbd->fle->url.'/_bco/th/';
			    	
		    	}else{
			    	
			    	$__url = DMN_FLE_BCO_TH;
			    	
		    	}
		    	
		    	$dt_img_u = $__url.'th_'.$row_Ls_Rg['bco_img'];
		    	
		    	$rsp['ls'][$row_Ls_Rg['id_bco']]['img']['f'] = $dt_img;
		    	$rsp['ls'][$row_Ls_Rg['id_bco']]['img']['url'] = $dt_img_u;
		    	$rsp['html'] .= li('', '', 'background-image:url('.$dt_img_u.');', '', ['rel'=>$row_Ls_Rg['id_bco']] );
		    	
	    	} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	
		}
	
	}else{
		
		$rsp['w'] = $__cnx->c_r->error; 
		
		if(ChckSESS_superadm()){
			$rsp['nn'] = $Ls_Lmt;
		}
		
	}
	
	
} $Dt_Rg->free;  

?>
