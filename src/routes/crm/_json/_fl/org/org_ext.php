<?php 
	
	$__org = new CRM_Org();
	$__orgs = Php_Ls_Cln($_POST['org']);
	$__tp = Php_Ls_Cln($_POST['tp']);
	
	
	
	if(!isN($__orgs)){
		
		
		$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
		
		foreach($__org_tp->ls->org_tp as $_k => $_v){
			if($__tp == $_v->key->vl){ 
				$_org_tp = $_v;
			}
		}
		
		$__orgs_a = explode(',', $__orgs);
		$__orgs_a = implode("','", $__orgs_a);
			
		//-------------------- Consulta Principal Leads --------------------//
			
			
			$_fl_cty = ", (	SELECT GROUP_CONCAT( CONCAT(siscd_tt,' (', siscddp_tt , ')') ) 
							FROM "._BdStr(DBM).TB_ORG_SDS." 
								 INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON orgsds_cd = id_siscd 
								 INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp 
							WHERE orgsds_org = id_org
						   ) AS _city";

			$_fl_dc = ", (	SELECT GROUP_CONCAT(sisslc_tt,' : ', orgsdsdc_dc SEPARATOR ' | ') 
						   FROM "._BdStr(DBM).TB_ORG_SDS_DC." 
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON orgsdsdc_tp = id_sisslc
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsdc_orgsds = id_orgsds
								WHERE orgsds_org = id_org
						  ) AS ___dc";
			
			
			$_fl_sds = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_org = id_org) AS _sds";
			$_fl_gst = ", (SELECT COUNT(*) FROM ".TB_ORG_GST." WHERE orggst_org = id_org) AS _gst";
			
			$_fl_sds_cnt = ", (	SELECT COUNT(*) 
								FROM ".TB_ORG_SDS_CNT." 
									 INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds 
								WHERE orgsdscnt_orgsds = id_orgsds AND orgsdscnt_tpr = '"._CId('ID_ORGCNTRTP_TRB_PRST')."' AND orgsds_org = id_org) AS _cnt";

			$_fl_eml = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_EML." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdseml_orgsds = id_orgsds WHERE orgsds_org = id_org) AS _eml";	
			$_fl_tel = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_TEL." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdstel_orgsds = id_orgsds WHERE orgsds_org = id_org) AS _tel";
			$_fl_doc = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_DC." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsdc_orgsds = id_orgsds WHERE orgsds_org = id_org) AS _dc";
			$_fl_web = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_WEB." WHERE orgweb_org = id_org) AS _web";
		
			
			if($__tp == "clg"){
				
				$_fl_enf = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_ENF." WHERE orgenf_org = id_org) AS _enf";
				$_fl_lng = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_LNG." WHERE orglng_org = id_org) AS _lng";
				$_fl_bch = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_BCH." WHERE orgbch_org = id_org) AS _bch";
				$_fl_exa = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_EXA." WHERE orgexa_org = id_org) AS _exa";
				
			}
		
			$Ls_Qry = "SELECT *
							  $_fl_cty $_fl_eml $_fl_tel $_fl_dc $_fl_sds $_fl_gst $_fl_sds_cnt $_fl_eml $_fl_doc $_fl_web $_fl_enf $_fl_lng $_fl_bch $_fl_exa
						FROM "._BdStr(DBM).TB_ORG."
						WHERE org_enc IN ('{$__orgs_a}')";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				$rsp['total'] = $Tot_Ls;
				
				if($Tot_Ls>0){		
				
					$rsp['e'] = 'ok';	
					
					do {
						
						$__inftot = $__org->pinfo([ 't'=>$__tp, 'drw'=>$row_Ls ]);
					  	$AvncId = Gn_Rnd(5).'_avnc';
					  	$___js_avnc = _Kn_Prcn([ 'id'=>$AvncId, 'w'=>'33', 'di'=>'ok', 'ds'=>'0.01', 'dt'=>'1', 'v'=>$__inftot->p, 'bclr'=>'bfc6c7' ]);   

						$ido = $row_Ls['org_enc'];
						
						$rsp['l'][$ido]['id'] = $row_Ls['org_enc'];
						
						$rsp['l'][$ido]['cty'] = ctjTx($row_Ls["_city"],'in');
						$rsp['l'][$ido]['___dc'] = ctjTx($row_Ls["___dc"],'in');
						
						$rsp['l'][$ido]['tot']['sds'] = $row_Ls["_sds"];
						$rsp['l'][$ido]['tot']['gst'] = $row_Ls["_gst"];
						$rsp['l'][$ido]['tot']['tel'] = $row_Ls["_tel"];
						$rsp['l'][$ido]['tot']['cnt'] = $row_Ls["_cnt"];
						$rsp['l'][$ido]['tot']['eml'] = $row_Ls["_eml"];
						$rsp['l'][$ido]['tot']['dc'] = $row_Ls["_dc"];
						
						if($__tp == 'clg'){
							$rsp['l'][$ido]['tot']['enf'] = $row_Ls["_enf"];
							$rsp['l'][$ido]['tot']['lng'] = $row_Ls["_lng"];
							$rsp['l'][$ido]['tot']['bch'] = $row_Ls["_bch"];
							$rsp['l'][$ido]['tot']['exa'] = $row_Ls["_exa"];
						}

						$rsp['l'][$ido]['fi'] = $row_Ls['org_fi'];
						
						$rsp['l'][$ido]['avnc']['html'] = '<div class="__avnc_l" id="bx_'.$AvncId.'">'.$___js_avnc->html.'</div>';
						$rsp['l'][$ido]['avnc']['js'] = $___js_avnc->js;
						
					} while ($row_Ls = $Ls->fetch_assoc());
					

				}
			
			}else{
					
				$rsp['w'] = $__cnx->c_r->error;
				
			}
	
	
	}else{
					
		$rsp['w'] = 'No data';
		
	}
	
	
	
	
	
	

?>