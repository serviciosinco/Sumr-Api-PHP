<?php 
	
	if (!function_exists('HTML_attr')) {
		function HTML_attr($p=NULL){ 
			if(!isN($p['a'])){ 
				foreach($p['a'] as $_attr_k=>$_attr_v){
					$html_attr .= ' '.$_attr_k.'="'.$_attr_v.'" ';
				} 
			}
			return $html_attr;
		}
	}
		
	if (!function_exists('HTML_Slct')) {

		function HTML_Slct($p=NULL){
			
			if($p['rq'] == 2){$Rq='';}else{$Rq=FMRQD;}
			
			if($p['m']=='ok' || $p['m']=='sch'){
				$__m = ' size="7" multiple="multiple" '; $__nm = $p['id'].'[]'; 
			}else{
				$__m = ''; $__nm = $p['id']; 
			}
			
			if(!isN($p['nm'])){ $__nm=$p['nm']; }
			
			//if($p['m']=='ok' || $p['m']=='sch'){$__m = ' size="7" multiple="multiple" '; $__nm = $p['id']; }else{$__m = ''; $__nm = $p['id']; }
			$_lb = Lb($p['ph']);
			
			if( !isN($p['cls']) ){
				$__cls = ' class="'.$p['cls'].'" ';
			}
			
			$_r = $_lb.'<select '.$__cls.' name="'.$__nm.'" data-placeholder="'.$p['ph'].'" id="'.$p['id'].'" '.$__m.' '.HTML_attr([ 'a'=>$p['attr'] ]).' '.$Rq.' autocomplete="off" >'; $_r .= $p['c']; $_r .= '</select>'; 
			
			return($_r);

		}

	}
	
	if (!function_exists('HTML_OpVl')) {
		function HTML_OpVl($p=NULL){
			if($p['c'] != ''){ $__c = ' class="'.$p['c'].'"'; }
			if($p['s'] == 'ok'){ $__sl = ' selected="selected"'; } 
			if($p['ct'] != 'off'){ $__t = ctjTx($p['t'],'in'); }else{ $__t = $p['t']; }
			if(!isN($p['rel'])){ $__rel = ' rel="'.ctjTx($p['rel'],'in').'"'; }
			if(!isN($p['data-img'])){ $__dimg = ' data-img="'.ctjTx($p['data-img'],'in').'"'; }
			if(!isN($p['sty'])){ $__sty = ' style="'.ctjTx($p['sty'],'in').'"'; }
			
			if(!isN($p['attr'])){ 
				foreach($p['attr'] as $_attr_k=>$_attr_v){
					$__attr .= ' '.$_attr_k.'="'.$_attr_v.'"';
				}
			}
			
			$_r = '<option class="_slc_opt" value="'.$p['v'].'"'.$__sty.$__rel.$__dimg.$__sl.$__c.$__attr.'>'.$__t.'</option>'; return($_r); 
		}	
	}
	
	if (!function_exists('HTML_RdoVl')) {
		
		function HTML_RdoVl($p=NULL){
			
			if($p['c'] != ''){ $__c = ' class="'.$p['c'].'" '; }
			if($p['s'] == 'ok'){ $__sl = 'checked="checked"'; }
			if($p['d'] == 'ok'){ $__d = 'disabled="disabled"'; }
			
			if(!isN($p['attr'])){ 
				foreach($p['attr'] as $_attr_k=>$_attr_v){
					$__attr .= ' '.$_attr_k.'="'.$_attr_v.'" ';
				}
			}
			
			if($p['lbl']=='ok'){
				$_r = '<label>'.ctjTx($p['t'],'in').'<input name="'.$p['n'].'" '.$__sl.' type="radio" '.$__d.$__attr.' value="'.$p['v'].'"/><span class="chkmk"></span></label>'; 
			}elseif($p['lbl']){	
				$_r = '<input name="'.$p['n'].'" '.$__sl.' type="radio" '.$__c.$__d.$__attr.' value="'.$p['v'].'"/>'; 
			}
			
			return($_r); 
		}
	}
	
	
	function JQ_Ls($i=NULL, $p=NULL, $tk=false, $tr=false, $_p=NULL){
		if(!isN($i) /*&& $p != NULL && !isMobile()*/){
			if($tk){ $__tkn = ", tokenSeparators: [',', ' '] "; }
			if($tr){ $__trs = ", templateResult: ".$tr.", templateSelection: ".$tr." "; }
			
			if($_p['ac'] != 'no'){ $__clr = "true"; }else{ $__clr = "false"; }
			if(!isN($_p['thm'])){ $__thm = ' theme:"'.$_p['thm'].'", '; }
			if($_p['cls']=='ok'){$_slc=".";}else{$_slc="#";}
			
			$_r = "$('".$_slc.$i."').select2({ ".$__thm." allowClear: ".$__clr.", placeholder: '".$p."' {$__tkn} {$__trs} });";
			
			return($_r);
		}
	}
					
					
	function _LsTree($p=NULL, $l=NULL){
			
		if(!isN($l)){ $lvl=$l; }else{ $lvl=0; } $lvl=$lvl+1;
		
		foreach($p as $mn_v){
			
			for($i=1; $i<$lvl;$i++){ if($lvl>1){ $__li_sub .= '-'; } }
			
			//--------------- Trabajar en Algun Momento los SelectGroup - PENDIENTE ---------------//
			//if(!isN($mn_v['sub'])){	$__html_b .= '<optgroup label="'.$mn_v['tt'].'" clr="'.$mn_v['attr']['clr'].'">'; }	
			
			if(!isN($mn_v['v_go'])){ $__v_go=$mn_v['v_go']; }else{ $__v_go=$mn_v['id']; }
										
			$__html_b .= HTML_OpVl([ 't'=>$__li_sub.$mn_v['tt'], 'v'=>$__v_go, 's'=>$mn_v['slc'], 'attr'=>$mn_v['attr'] ]);
	
			if(!isN($mn_v['sub'])){			;
				$__chld = _LsTree($mn_v['sub'], $lvl);
				$__html_b .= $__chld;
			}
			
			//if(!isN($mn_v['sub'])){ $__html_b .= '</optgroup>'; }
			
		}
			
		return $__html_b;		
					
	}	

	function LsSis_A($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				for($_i=date('Y'); $_i>2000; $_i--) {
					if (!(strcmp($_i, $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$_i, 'v'=>$_i, 's'=>$_slc]);
				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLA, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			return($_rtrn2);
		}
	}
	
	
	function LsSis_SiNo($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	 
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_SINO." 
						WHERE id_sissino != 3 
						ORDER BY id_sissino ASC";
			
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sissino_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$p['attr'] ]), 'cls'=>$_cls ]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	

	function LsSis_Noi($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
				
			if(!isN($_p['tp'])){ $__fl .= " AND siscntnoi_".$_p['tp']." = 1 "; }
			if(!isN($_p['fl'])){ $__fl .= " AND ".$_p['fl']; }

			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_CNT_NOI."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntnoi_cl = id_cl 
						WHERE id_siscntnoi != '1' AND cl_enc = '".DB_CL_ENC."' $__fl 
						ORDER BY siscntnoi_nm ASC";
			
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){ 
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
	
				if($Tot_Ls > 0){
					do {
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if(is_array($__va)){ $_chkv=$__va; }else{ $_chkv=explode(',',$__va); }
								if (in_array($row_Ls[$__v], $_chkv)){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['siscntnoi_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				}

			}
				
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	function Ls_Grd($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL){
		if(!isN($__id)){	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
			$_vl = ['12','11','10','9','8','7','6','5','4','3','2','1'];
			
			foreach($_vl as $_v){
				if (!(strcmp("{$_v}", $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
				$LsBld .= HTML_OpVl(['t'=>"{$_v}", 'v'=>"{$_v}", 's'=>$_slc]);
			}	
			
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if(!isN($__lbl)){ $_lbl = $__lbl; }else{ $_lbl = TX_SLCTK; }
			
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			return($_rtrn2);
		}

	}
	
	function Ls_GrdClg($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL){
		if(!isN($__id)){	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
			$_vl = ['6','7','8','9','10','11','12'];
			
			foreach($_vl as $_v){
				if (!(strcmp("{$_v}", $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
				$LsBld .= HTML_OpVl(['t'=>"{$_v}", 'v'=>"{$_v}", 's'=>$_slc]);
			}	
			
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if(!isN($__lbl)){ $_lbl = $__lbl; }else{ $_lbl = TX_SLCTK; }
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			return($_rtrn2);
		}

	}
	
	function Ls_GstIng($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL){
		if(!isN($__id)){	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
			$_vl = ['Ingreso'=>'f_i','Gestion'=>'f_his'];
			
			
			foreach($_vl as $_k => $_v){
				if (!(strcmp("{$_v}", $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
				$LsBld .= HTML_OpVl(['t'=>"{$_k}", 'v'=>"{$_v}", 's'=>$_slc]);
			}	
			
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if(!isN($__lbl)){ $_lbl = $__lbl; }else{ $_lbl = TX_SLCTK; }
			
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			return($_rtrn2);
		}
	}
	
	function Ls_Vl_Key($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL){
		if(!isN($__id)){	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
			$_vl = ['1','2','3','4','5'];
			
			foreach($_vl as $_v){
				if (!(strcmp("[v{$_v}]", $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
				$LsBld .= HTML_OpVl(['t'=>"[v{$_v}]", 'v'=>"[v{$_v}]", 's'=>$_slc]);
			}	
			
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCTK, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			return($_rtrn2);
		}
	}
	
	function Ls_Vl_Year($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL){
		if(!isN($__id)){	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
			$_vl = date("Y");
			
			for ($_v=$_vl; $_v<=($_vl+15); $_v++){
				if (!(strcmp("{$_v}", $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
				$LsBld .= HTML_OpVl(['t'=>"{$_v}", 'v'=>"{$_v}", 's'=>$_slc]);
			}
			
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_YR, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			return($_rtrn2);
		}
	}

	
	function LsSisEcSgmVarTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP." ORDER BY sisecsgmvartp_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls > 0){	
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['sisecsgmvartp_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCTPVAR, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
				}
			
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
			
		}
	}
	
///--------------*****

	function LsSisEcSgm($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
				
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_EC_SGM." ORDER BY sisecsgm_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				
				if($Tot_Ls){
				
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['sisecsgm_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCSGM, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
				}
			
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
			
		}
		
	}
	

	function LsTexTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_TX_TP." ORDER BY textp_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls > 0){
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['textp_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLTP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
				}
				
				
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	

	// Listado de sedes 
	
	function LsOrgSds($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			
			if( !isN($_p['org']) ){ 
				$_fl .= " AND org_enc = '".$_p['org']."' ";
			}

			if( !isN($_p['n_rpt']) && $_p['n_rpt'] == 'ok' ){ 
				$_fl .= " AND orgsdsarr_vl_rpt = '2' AND orgsdsarr_est = 1";
				$_cl_inn = "	
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
					";
			}

			if( !isN($_p['est']) && $_p['est'] == 'ok' ){ 
				$_fl .= " AND org_est = '1' ";
			}
			
			if( !isN($_p['org_tp_k']) ){ 
				$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
				
				foreach($__org_tp->ls->org_tp as $_k => $_v){
					if($_p['org_tp_k'] == $_v->key->vl){ 
						$_fl_org[] = $_k; 
						$_ph = _Cns('TX_SLC_'.strtoupper($_v->key->vl));
					}
					if(!isN($_fl_org)){ $_fl .= " AND id_org IN ( SELECT orgtp_org FROM "._BdStr(DBM).TB_ORG_TP." WHERE orgtp_tp IN (".implode(',',$_fl_org).") ) "; }
				}
		
			}
			
			if(!isN($_p['cl'])){ 
				$_fl .= " AND cl_enc = '".CL_ENC."' ";
				$_cl_inn = "	
						INNER JOIN "._BdStr(DBM).TB_ORG_CL." ON id_org = orgcl_org
						INNER JOIN "._BdStr(DBM).TB_CL." ON orgcl_cl = id_cl
					";
			}
			
			$Ls_Qry = "	SELECT * FROM "._BdStr(DBM).TB_ORG_SDS." 
								 	  INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org 
								 	  INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON orgsds_cd = id_siscd 
								 	  INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
								      {$_cl_inn}
						WHERE id_orgsds != '' $_fl
						ORDER BY org_nm ASC ";
					
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
			
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
												
				if($Tot_Ls > 0){

					do {
						
						if(!isN($_p['va'])){ 
							if($_p['mlt'] == 'ok'){
								if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['org_nm']."  "."(".$row_Ls['orgsds_nm'].") - ".$row_Ls['siscd_tt']." (".$row_Ls['siscddp_tt'].")" , 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
					
					} while ($row_Ls = $Ls->fetch_assoc());

				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				
				if(!isN($_ph)){ $__lbl = $_ph; }else{ $__lbl = FM_LS_SLSDS; }
				
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$__lbl, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);	
			
			}
			
			$__cnx->_clsr($Ls);
			
			
			return($_rtrn2);
		
		}
	}
	
	function LsOrg($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $_tp=NULL, $__cls=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
			
			$__org_tp = __LsDt([ 'k'=>'org_tp' ]);

			foreach($__org_tp->ls->org_tp as $_k=>$_v){
				if($_tp == $_v->key->vl){ $_fl_org[] = $_k; }
				if(!isN($_fl_org)){ $_fl .= " AND id_org IN ( SELECT orgtp_org FROM "._BdStr(DBM).TB_ORG_TP." WHERE orgtp_tp IN (".implode(',',$_fl_org).") ) "; }
			}
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_ORG." 
						WHERE id_org != '' $_fl 
						ORDER BY org_nm ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
	
			if($Ls){	
			
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
				do {
					
					if($__mlt == 'ok'){
						if(is_array($__va)){ $_go_va = $__va; }else{ $_go_va = explode(',',$__va); } 
						if(in_array($row_Ls[$__v], $_go_va)){ $_slc = 'ok'; }else{ $_slc = 'no'; } 
					}else{
						if(!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok'; }else{$_slc = 'no';} 
					}
							
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['org_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);

					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				
				if(isN($__lbl)){
					$__lbl = _Cns('TX_SLC_'.strtoupper($_tp));
				}
				
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'cls'=>$__cls, 'nm'=>$p['nm'], 'attr'=>$p['attr'] ]), 'cls'=>$_cls]);
			
			}else{
				
				echo $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);	
			
		}
		
		return($_rtrn2);
		
	}
	
	// ----------- Lista de Tipo de Topic ---------- //
	
	function LsTpcTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		if(!isN($__id)){	

			$Ls_Qry = "SELECT * FROM ".TB_TPC_TP." ORDER BY tpctp_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				if($Tot_Ls > 0){
					
					$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['tpctp_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLDP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
					
				}	
				
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
		
	}

	function LsCdDp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_CD_DP." ORDER BY siscddp_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['siscddp_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLDP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}

	function LsPs($p=NULL){ //$__id, $__v, $__va=NULL, $__lbl, $__rq=NULL
		
		global $__cnx;
		
		if(!isN($p['id'])){	
	
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_PS." ORDER BY sisps_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {

					if(!isN($p['va'])){ 
						if(!isN($p['ino'])){ $__vc=$p['ino']; }else{ $__vc=$p['v']; }
						if($p['mlt'] == 'ok'){
							if (in_array($row_Ls[$__vc], $p['va']) || $Tot_Ls == 1){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $p['va'])) || $Tot_Ls == 1){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sisps_tt'], 'v'=>$row_Ls[ $p['v'] ], 's'=>$_slc]);

				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$p['id'], 'ph'=>TX_SLCPS, 'rq'=>$p['rq'], 'c'=>$LsBld, 'm'=>$p['mlt'], 'attr'=>$p['attr'] ]), 'cls'=>$_cls]);
			
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}

	function LsUpPrc($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['id'])){	
	
			$Ls_Qry = "SELECT id_upfld, upfld_enc, upfld_tt FROM "._BdStr(DBP).TB_UP_FLD." ORDER BY upfld_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {

					if(!isN($p['va'])){ 
						if(!isN($p['ino'])){ $__vc=$p['ino']; }else{ $__vc=$p['v']; }
						if($p['mlt'] == 'ok'){
							if (in_array($row_Ls[$__vc], $p['va']) || $Tot_Ls == 1){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $p['va'])) || $Tot_Ls == 1){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['upfld_tt'], 'v'=>$row_Ls[ $p['v'] ], 's'=>$_slc]);

				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$p['id'], 'ph'=>'Seleccione un campo', 'rq'=>$p['rq'], 'c'=>$LsBld, 'm'=>$p['mlt'], 'attr'=>$p['attr'] ]), 'cls'=>$_cls]);
			
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	function LsFtp($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			$Ls_Qry = "SELECT * FROM ".TB_CL_FTP." WHERE clftp_cl = (SELECT id_cl FROM ".TB_CL." WHERE cl_enc = '".DB_CL_ENC."') ORDER BY clftp_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['clftp_nm'].' ('.$row_Ls['clftp_nm'].')', 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>FM_SLC_FTP, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	
	
	function LsPlcy($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id) && (defined('DB_CL_ENC') || !isN($_p['cl']))){
			
			if(!isN($_p['cl'])){ $__cl = $_p['cl']; }else{ $__cl = DB_CL_ENC; }
			if(!isN($_p['shw'])){ $__fl .= ' AND id_clplcy IN ('.implode(',', $_p['shw']).') '; }
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_CL_PLCY."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl 
						WHERE id_clplcy != '' AND cl_enc = '".$__cl."' {$__fl}
						ORDER BY clplcy_nm ASC";
							
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
					do {
	
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if(is_array($__va)){ $_chkv=$__va; }else{ $_chkv=explode(',',$__va); }
								if(in_array($row_Ls[$__v], $_chkv)){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if(!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
	
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['clplcy_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					
					if($__lbl != ''){$label = $__lbl;}else{$label = FM_LS_PLCY;}				
					
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
					
				$__cnx->_clsr($Ls);
				return($_rtrn2);
				
			}
		}
	}
	

	function LsCd($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){	

			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$_p['ph'], 'nm'=>$_p['nm'], 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);

			return($_rtrn2);
		}
	}

	function LsCdOld($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['flt_ps'])){ $___flt = ' AND siscddp_ps = '.$_p['flt_ps']; }
		
		if(!isN($_p)){
			
			$Ls_Qry = "	SELECT id_sisps, id_siscd, siscd_enc, siscd_tt, siscddp_tt
						FROM "._BdStr(DBM).MDL_SIS_CD_BD."
							 INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
							 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
						WHERE id_siscd != '' AND siscd_vrf = 1 $___flt
						ORDER BY sisps_tt ASC, siscd_tt ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls >= 0){ if(!isN($_p['oth']) && $_p['oth'] == 'ok' ) { $LsBld .= HTML_OpVl([ 't'=>'- Otra ciudad -', 'v'=>'-oth-' ]); } }
				
				do {
					
					if(!isN($_p['va'])){ 
						
						if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$_p['v']; }
						
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						}
						
						/*if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$__vc], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}*/
					}
					
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['siscd_tt'].' ('.$row_Ls['siscddp_tt'].')', 'v'=>$row_Ls[$_p['v']], 's'=>$_slc, 'data-img'=>$row_Ls['id_sisps'] ]);						
						
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if(!isN($_p['ph'])){ $ph = $_p['ph']; }else{ $ph = FM_LS_SLCD; }
	
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'nm'=>$_p['nm'], 'ph'=>$ph, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				
			}else{
				
				if(Dvlpr()){ echo 'Error:'.$__cnx->c_r->error; }

			}
				
			$__cnx->_clsr($Ls);
			
		}else{
				
			if(Dvlpr()){ echo 'No parameters'; }

		}

		return($_rtrn2);

	}
	
	
	function LsCdDpTmp($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p)){
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_CD_DP." ORDER BY siscddp_tt ASC ";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls >= 1){ if(!isN($_p['oth']) && $_p['oth'] == 'ok' ) { $LsBld .= HTML_OpVl([ 't'=>'- Otro Departamento -', 'v'=>'-oth-' ]); } }
				
				do {
					
					if(!isN($_p['va'])){ 
						
						if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$_p['v']; }
						
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$__vc], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['siscddp_tt'].' ('.$row_Ls['siscddp_tt'].')', 'v'=>$row_Ls[$_p['v']], 's'=>$_slc, 'data-img'=>$row_Ls['siscddp_ps'] ]);						
						
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if(!isN($_p['ph'])){ $ph = $_p['ph']; }else{ $ph = FM_LS_SLCD; }
	
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'nm'=>$_p['nm'], 'ph'=>$ph, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				
			}else{
				
			}
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsLng($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_LNG." ORDER BY sislng_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sislng_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if(!isN($_p['ph'])){ $ph = $_p['ph']; }else{ $ph = TX_SLC_LNG; }
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$ph, 'nm'=>$_p['nm'], 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	
	function LsOrgSdsCln($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_CLN." WHERE id_orgsdscln != '' ORDER BY orgsdscln_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['orgsdscln_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'Seleccione Calendario', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	function LsClLcl($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			//No traer los locales que tienen relacion con otros arriendos
			if( !isN($_p['va']) ){
				$_fl_lcl = " AND orgsdsarr_lcl != ".$_p['va']." ";
			}

			$_fl .= " 
					AND id_cllcl NOT IN ( 
											SELECT orgsdsarr_lcl FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_lcl = id_cllcl 
											$_fl_lcl
											AND orgsdsarr_est = 1 
										) ";

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_CL_LCL." WHERE id_cllcl != '' $_fl ORDER BY cllcl_tt ASC";
			
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['cllcl_tt'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'Seleccione Local', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}

	function LsOrgCnt($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			$Ls_Qry = "SELECT
							*
						FROM
							".TB_ORG_SDS_CNT."
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
						INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
						INNER JOIN ".TB_CNT." ON id_cnt = orgsdscnt_cnt
						WHERE
							id_orgsdscnt != ''
						AND org_enc = '".$_p['id_org']."'
						ORDER BY
							id_orgsdscnt DESC";

			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['cnt_nm'].' '.$row_Ls['cnt_ap'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'Selecione el contacto', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	function LsSisEcEgSgm($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
		
			$Ls_Qry = "SELECT * FROM ".TB_SIS_EC_SGM." WHERE id_sisecsgm != 1 ORDER BY sisecsgm_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sisecsgm_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'Seleccione Segmento', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	
	function LsSisEcEgSgmVar($_p=NULL){ //$__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $_p=NULL
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			if(!isN($_p['sgm'])){ $_fl .= " AND sisecsgmvar_sgm = '".$_p['sgm']."' "; }	
				
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_EC_SGM_VAR."
							 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp 
						WHERE id_sisecsgmvar != '' $_fl 
						ORDER BY sisecsgmvar_nm ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sisecsgmvar_nm'], 'rel'=>$row_Ls['sisecsgmvar_tp'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$_p['lbl'], 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
			
			}else{
				
				echo $__cnx->c_r->error;
				
			}
			
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	function LsOrgSdsEst($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_EST." WHERE id_orgsdsest != '' ORDER BY orgsdsest_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['orgsdsest_tt'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>TX_EST, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	function LsOrgSdsSx($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_SX." WHERE id_orgsdssx != '' ORDER BY orgsdssx_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['orgsdssx_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'Seleccione Genero', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	function LsActGrd($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_ACT." 
							INNER JOIN "._BdStr(DBM).TB_ACT_GRD."  ON actgrd_act = id_act 
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON actgrd_grd = id_sisslc 
						WHERE id_act != '' AND act_enc = '".$_p['act']."' ORDER BY sisslc_tt ASC";

			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sisslc_tt'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2['html'] = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>' - Seleccione curso -', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				$_rtrn2['tot'] = $Tot_Ls > 0;
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	function LsActGenGrd($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "	SELECT * 
						FROM "._BdStr($_p['bd']).TB_MDL_GEN." 
							INNER JOIN "._BdStr($_p['bd']).TB_MDL_GEN_GRD."  ON mdlgengrd_mdlgen = id_mdlgen
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlgengrd_grd = id_sisslc 
						WHERE id_mdlgen != '' AND mdlgen_enc = '".$_p['act']."' 
						ORDER BY id_sisslc DESC";

			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sisslc_tt'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2['html'] = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>' - Seleccione curso -', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				$_rtrn2['tot'] = $Tot_Ls > 0;
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}

	function LsSlcLs($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){	
			
			$Ls_Qry = "	SELECT id_sisslctp, sisslctp_enc, sisslctp_tt
						FROM "._BdStr(DBM).TB_SIS_SLC_TP." 
						WHERE id_sisslctp != '' 
						ORDER BY sisslctp_tt ASC";

			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls > 0){

					do {
						
						if(!isN($_p['va'])){ 
							if($_p['mlt'] == 'ok'){
								if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sisslctp_tt'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
					
					} while ($row_Ls = $Ls->fetch_assoc());
				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>FM_LS_SLCD, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);

			}

			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}

	
	function Ls_XLS_F($_p=NULL){
		if(!isN($_p['id'])){	
			$LsBld .= HTML_OpVl(['t'=>FM_LS_SLFLD, 'ct'=>'off']); 
				foreach ($_p['b'] as &$b) {
					if (strtoupper($b['t']) == strtoupper($_p['v_a']) || strtoupper($b['v']) == strtoupper($_p['v_a']) ){ $_slc = 'ok'; }else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$b['t'], 'v'=>$b['v'], 's'=>$_slc]);
				}
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'', 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'nm'=>$_p['nm'] ]), 'cls'=>$_cls ]);
			return($_rtrn2);
		}
		
	}
	
	function LsSisGrph($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_GRPH_CHR_BD." WHERE id_grphchr != '' ORDER BY grphchr_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {

					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['grphchr_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLTP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}

	function LsSisTpDt($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_SIS_TP_DT_BD." ORDER BY sistpdt_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sistpdt_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_TPDT, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	function LsMdlS($___tp, $__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id) /*&& !isN($___tp)*/){
			
			if(!isN($___tp)){ $Ls_Fltr .= " AND mdlstp_tp = '$___tp' "; }
			if(!isN($p) && $p['cl']=='ok'){ $Ls_Fltr .= " AND cl_enc = '".DB_CL_ENC."' "; }

			$Ls_Qry = "	SELECT id_mdls, mdls_enc, mdls_nm, mdlstp_nm
						FROM "._BdStr(DBM).TB_MDL_S." 
							 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON mdlstpcl_mdlstp = id_mdlstp
							 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
						WHERE id_mdls != '' $Ls_Fltr
						ORDER BY mdlstp_tp ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($__lbl != ''){ $__ph = $__lbl; }else{ $__ph = FM_LS_SLTP; }
					
					do {
	
						if(!isN($__va)){ 
							
							if($p['flt'] == 'ok'){
								$_v = $__va;
							}else{
								$_v = explode(',',$__va);
							}
							
							if($__mlt == 'ok'){ 
								if ( in_array($row_Ls[$__v], $_v) ){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}

						}
						
						if(!isN($p) && $p['tp']=='ok'){ $tt_sfx = ' '.$row_Ls['mdlstp_nm']; }
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['mdls_nm'].$tt_sfx, 'v'=>$row_Ls[$__v], 's'=>$_slc]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 
													  'ph'=>$__ph, 
													  'rq'=>$__rq, 
													  'c'=>$LsBld, 
													  'm'=>$__mlt,
													  'attr'=>$p['attr'],
													]), 
									 'cls'=>$_cls ]);
			}
				
			$__cnx->_clsr($Ls);

		}else{

			echo 'No all data';
		
		}
		
		return($_rtrn2);

	}
	
	function LsSis_Ese($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_ESE." WHERE id_sisese != '' ORDER BY id_sisese ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				
				if($Tot_Ls > 0){
					
					if(!isN($__lbl)){ $__lbl_go = $__lbl;}else{ $__lbl_go = TX_NVLSC;}	
					
					$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['sisese_tt'].' ('.$row_Ls['sisese_nm'].')', 'v'=>$row_Ls[$__v], 's'=>$_slc]); 
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl_go, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
				}
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	// Listado de Tipos de Campo
	function LsSisQly($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
		
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_QLY." ORDER BY qly_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;  
				
				if($Tot_Ls > 0){
				
					if($__lbl!=''){ $__label =  $__lbl; } else { $__label = FM_LS_SLFLD_TP; }
				
					$LsBld .= HTML_OpVl(['ct'=>'off']);
					
					do {
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['qly_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);				
				
				}
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}	
	
	function LsSis_Cld($_p=NULL){ //$__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $_dsbl=NULL
		
		if(!isN($_p['id'])){		
			
			$__cld = __LsDt([ 'k'=>'cld' ]);
			
			if(!isN( $__cld->ls->cld )){ 		
				foreach($__cld->ls->cld as $__cld_k=>$__cld_v){ 
					$__cld_ordrd[$__cld_v->ptje->vl] = $__cld_v;
				}
				ksort($__cld_ordrd);	
			}
			
			if(!isN($__cld_ordrd)){
				
				foreach($__cld_ordrd as $__cld_k=>$__cld_v){
					
					if (!(strcmp($__cld_v->id, $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';}
					
					if($_p['dsbl'] == 'ok'){  
						$__id_go = $__cld_v->ptje->vl; 
					}elseif($_p['v']=='id'){ 
						$__id_go = $__cld_v->id; 
					}else{ 
						$__id_go = $__cld_v->enc;
					}
					
					$LsBld .= HTML_RdoVl([ 'lbl'=>'1', 'n'=>$_p['id'], 'v'=>$__id_go, 's'=>$_slc, 'c'=>'star', 'd'=>$_p['dsbl'], 'attr'=>$_p['attr']  ]);
				}
				
			}
			
			$_rtrn2['html'] = bdiv([ 'c'=>$LsBld, 'cls'=>'__rtio' ]);
			$_rtrn2['js'] = " SUMR_Main.ld.f.rtng( function(){ $(':radio.star').rating({ cancel: 'Cancel', cancelValue: '0' }); });  ";			
			
			return _jEnc($_rtrn2);
		}
		
	}

	// Listado de Fuentes
	
	function LsCntFnt($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			//if($_p['tp'] != NULL){ $__fl .= " AND sisfnt_".$_p['tp']." = 1 " ; } Pendiente de Trabajo
			
			if(defined('DB_CL_ENC')){ $__cenc = DB_CL_ENC; }
			elseif(!isN($_p['cl'])){ $__cenc = $_p['cl']; }
			
			if(!isN($__cenc)){ $__fl .= " AND id_sisfnt IN (	SELECT sisfntcl_sisfnt 
																	FROM "._BdStr(DBM).TB_SIS_FNT_CL."
																		 INNER JOIN "._BdStr(DBM).TB_CL." ON sisfntcl_cl = id_cl
																	WHERE cl_enc = '".$__cenc."'
																) "; }
			 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_FNT." WHERE id_sisfnt != '' $__fl ORDER BY sisfnt_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
					  
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl();
				
				if($Tot_Ls > 0){
					do {
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['sisfnt_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_CNTFNT, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr']]), 'cls'=>$_cls]);
				}

			}	
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}

	// Listado de Sedes Cliente
	
	function LsClSds($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	

			$Ls_Qry = "	SELECT id_clsds, clsds_enc, clsds_nm 
						FROM "._BdStr(DBM).TB_CL_SDS."
						WHERE id_clsds != '' AND clsds_cl = '".DB_CL_ID."'
						ORDER BY clsds_nm ASC";

			$Ls = $__cnx->_qry($Ls_Qry); 
					  
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl();
				
				if($Tot_Ls > 0){
					do {
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['clsds_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SDS, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr']]), 'cls'=>$_cls]);
				}

			}	
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}

	
	// Listado de Sistema Usuarios

	function LsSis_Eml($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $_p=NULL){
		
		global $__cnx;
			
		if(!isN($__id)){

			$Ls_Qry = "SELECT * FROM sis_eml WHERE id_siseml != '' $__fl ORDER BY id_siseml ASC";
								
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['siseml_nm'].' '.$row_Ls['siseml_ap'].' ('.$row_Ls['siseml_eml'].')', 'rel'=>$row_Ls['siseml_from'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsSis_Md($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			if(!ChckSESS_superadm()){ $__fl .= 'AND sismd_usnvl = 3'; }
			//if($_p['tp'] != NULL){ $__fl .= " AND sismd_".$_p['tp']." = 1 " ; } Falta trabajar en el filtro
			
			if(defined('DB_CL_ENC')){ $__cenc = DB_CL_ENC; }
			elseif(!isN($_p['cl'])){ $__cenc = $_p['cl']; }

			if(!isN($_p['tp_md'])){ $__fl .= ' AND sismd_tp = '.$_p['tp_md']; }
			
			if(!isN($__cenc)){ 

				$__fl .= " AND id_sismd IN (	
											SELECT sismdcl_sismd 
											FROM "._BdStr(DBM).TB_SIS_MD_CL."
													INNER JOIN "._BdStr(DBM).TB_CL." ON sismdcl_cl = id_cl
											WHERE cl_enc = '".$__cenc."'
										) "; 

			}			

			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_MD." 
						WHERE id_sismd != '' {$__fl} ORDER BY sismd_tt ASC"; 

			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
	
					if(!isN($__va)){ 
						
						if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$__v; }
						
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__vc], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sismd_tt'], 'rel'=>$row_Ls['sismd_utm'], 'v'=>$row_Ls[$__v], 's'=>$_slc, 'attr'=>$_p['attr'] ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_MD, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr']]), 'cls'=>$_cls]);
				
			}else{
				
				echo 'LsSis_Md:'.$__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);
				
			return($_rtrn2);
		}
	}
	
	

	function LsSisMdTp($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_MD_TP." ORDER BY sismdtp_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
	
					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sismdtp_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLTP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}

	function LsSis_Dcto($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	

			$Ls_Qry = "SELECT * FROM  "._BdStr(DBM).MDL_DCTO_BD." WHERE id_dcto != '' ORDER BY dcto_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['dcto_nm'].'('.$row_Ls['dcto_vle'].')', 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_DCTO, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsSisPay($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__fml=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
				
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_PAY_EST." WHERE id_sispayest != '' ORDER BY sispayest_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sispayest_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__fml, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	function LsSis_Ps($_p=NULL){ //$__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $__ttag=NULL, $_p=NULL
		
		global $__cnx;
		
		if(!isN($_p['id'])){	
			
			/*if($__ttag == 'iso'){ $_o_by = 'sisps_iso2'; }else{ $_o_by = 'sisps_tt'; }
			if(!isN($_p['ids'])){ $_whr_f .= ' AND id_sisps IN ('.$_p['ids'].')' ; }
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_PS." 
						WHERE id_sisps != '' {$_whr_f} 
						ORDER BY $_o_by ASC ";

			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
			
				if(!isN($__lbl)){ $__lbl_go = $__lbl;}else{ $__lbl_go = TX_CNTRS;}	
			
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					
					if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$__v; }
					
					if (!(strcmp($row_Ls[$__vc], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
					
					if($__ttag == 'iso'){ $__nmtg = '('.$row_Ls['sisps_iso2'].') +'.$row_Ls['sisps_tel']; }
					else{ $__nmtg = $row_Ls['sisps_tt'].' ('.$row_Ls['sisps_iso2'].')'; } 
					
					$LsBld .= HTML_OpVl(['t'=>$__nmtg, 'rel'=>$row_Ls['sisps_iso2'], 'v'=>$row_Ls[$__v], 'data-img'=>$row_Ls['id_sisps'], 's'=>$_slc ]); 
					 
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				
			}*/

			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$_p['ph'], 'nm'=>$_p['nm'], 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);

			return($_rtrn2);
		}
	}

	function LsSis_PsOLD($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $__ttag=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			if($__ttag == 'iso'){ $_o_by = 'sisps_iso2'; }else{ $_o_by = 'sisps_tt'; }
			if(!isN($_p['ids'])){ $_whr_f .= ' AND id_sisps IN ('.$_p['ids'].')' ; }
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_PS." 
						WHERE id_sisps != '' {$_whr_f} 
						ORDER BY $_o_by ASC ";

			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
			
				if(!isN($__lbl)){ $__lbl_go = $__lbl;}else{ $__lbl_go = TX_CNTRS;}	
			
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					
					if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$__v; }
					
					if (!(strcmp($row_Ls[$__vc], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
					
					if($__ttag == 'iso'){ $__nmtg = '('.$row_Ls['sisps_iso2'].') +'.$row_Ls['sisps_tel']; }
					else{ $__nmtg = $row_Ls['sisps_tt'].' ('.$row_Ls['sisps_iso2'].')'; } 
					
					$LsBld .= HTML_OpVl(['t'=>$__nmtg, 'rel'=>$row_Ls['sisps_iso2'], 'v'=>$row_Ls[$__v], 'data-img'=>$row_Ls['id_sisps'], 's'=>$_slc ]); 
					 
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$__lbl_go, 'nm'=>$_p['nm'], 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);	
			
			}
			
			$__cnx->_clsr($Ls);	
			return($_rtrn2);
		}
	}

	
	function LsSis_Tel($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_SIS_TEL_BD." WHERE id_sistel != '1' ORDER BY sistel_nm";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			if(!isN($__lbl)){ $__lbl_go = $__lbl;}else{ $__lbl_go = TX_TYPPHN;}	
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sistel_nm'], 'rel'=>"{'_min':'".$row_Ls['sistel_c_min']."', '_max':'".$row_Ls['sistel_c_min']."'}", 'v'=>$row_Ls[$__v], 's'=>$_slc]); 
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl_go, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsSisLndLst($__id, $__v=NULL, $__va=NULL, $__lbl=NULL, $__rq=NULL, $_fl=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_FLD_LST." WHERE id_fldlst != '' AND fldlst_fld =  ".$_fl." ORDER BY id_fldlst ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				
				if(!isN($__lbl)){ $__lbl_go = $__lbl;}else{ $__lbl_go = TX_SLCNOPC ;}	
				
				$LsBld .= HTML_OpVl(['t'=>$__lbl_go, 'ct'=>'off']); 
				
				do {
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['fldlst_tt'], 'v'=>$row_Ls['id_fldlst'], 's'=>'no']); 
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl_go, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>'styled-select']);   
			}
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsSisLndRdb($__tt=NULL, $__id=NULL, $_fl=NULL, $_lng=NULL){
		
		global $__cnx;
		
		$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_FLD_LST." WHERE id_fldlst != '' AND fldlst_fld =  ".$_fl." ORDER BY fldlst_tt ASC";
		$Ls = $__cnx->_qry($Ls_Qry);
		
		if($Ls){
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= h3($__tt, 't_rdb'); 
			
			$i_c=0;
				do {
					if(!isN($_lng)){ if($row_Ls['fldlst_tt_'.$_lng] != ''){ $_tt_lng = $row_Ls['fldlst_tt_'.$_lng]; }else{ $_tt_lng = $row_Ls['fldlst_tt']; } }else{ $_tt_lng = $row_Ls['fldlst_tt']; }
					$__id_rnd = Gn_Rnd(20);
					
					$LsLi .= '<li class="rdb_l _col">
									<label for="'.$__id.$__id_rnd.'">'./*ctjTx($row_Ls['fldlst_tt'],'in').*/'</label>
									<input type="radio"  name="'.$__id.'" id="'.$__id.$__id_rnd.'" value="'.$row_Ls['id_fldlst'].'" />
									<div class="check">'.ctjTx($_tt_lng,'in').'</div>
							   </li>';
					
					$i_c++;
				} while ($row_Ls = $Ls->fetch_assoc());
			$LsBld .= ul($LsLi, 'colx_'.$i_c);
			$LsHtml = '<div class="rdb_box">'.$LsBld.'</div>';
		
		}	
				
		$__cnx->_clsr($Ls);	
		return($LsHtml);
		
	}
	

	function LsMdlSTp($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $__ext_qry=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){ 
			
			if(!isN($p['sis']) && $p['sis'] == 'no'){ $fl .= ' AND mdlstp_sis=2 '; }
			if(!isN($p['inf']) && $p['inf'] == 'no'){ $fl .= ' AND mdlstp_inf=2 '; }
			if(!isN($p['cl'])){ $__cl = $p['cl']; }else{ $__cl = DB_CL_ENC; }
			if(!isN($p['fl'])){ $_fl .= $p['fl']; }
			
			$fl .= " AND id_mdlstp IN ( SELECT mdlstpcl_mdlstp 
										FROM "._BdStr(DBM).TB_MDL_S_TP_CL." 
											 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
										WHERE cl_enc = '".$__cl."') ";
			
			if($__ext_qry != ''){ $fl .= " AND id_mdlstp IN ($__ext_qry) ";}
			
			$Ls_Qry = "	SELECT id_mdlstp, mdlstp_tp, mdlstp_nm 
						FROM "._BdStr(DBM).TB_MDL_S_TP." 
						WHERE id_mdlstp != '' $fl 
						ORDER BY mdlstp_nm ASC";

			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
					do {
						
						if(_ChckMd( $row_Ls['mdlstp_tp'] ) || $p['all'] == 'ok'){
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							$LsBld .= HTML_OpVl(['t'=>$row_Ls['mdlstp_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
						}
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$p['attr']]), 'cls'=>$_cls]);
				
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsLndTp($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $__ext_qry=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){ 
			
			$Ls_Qry = "SELECT * 
							FROM "._BdStr(DBM).TB_LND_TP." 
							INNER JOIN "._BdStr(DBM).TB_LND." ON id_lnd = lndtp_lnd	
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = lndtp_mdlstp 
						WHERE 
							lnd_enc = '".$p['enc']."' 
						ORDER BY mdlstp_nm ASC";

			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
					do {
						
						if(_ChckMd( $row_Ls['mdlstp_tp'] )){
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							$LsBld .= HTML_OpVl(['t'=>$row_Ls['mdlstp_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
						}
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	

	function LsMdlBx($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){	

			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$_p['ph'], 'nm'=>$_p['nm'], 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);

			return($_rtrn2);
		}
	}

	function LsMdl($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			if(!isN($_p["tp"])){ 
				if(is_array($_p["tp"])){
					$fl .= sprintf(' AND mdls_tp IN(%s) ',  implode(',',$_p["tp"]) );	
				}else{
					$fl .= sprintf(' AND mdls_tp = %s ', GtSQLVlStr($_p["tp"], "int"));	
				}	
			}

			if(!isN($_p['mdls'])){
				$fl .= sprintf(' AND mdl_mdls = %s ', GtSQLVlStr($_p['mdls'], "int"));	
			}	

			if(!isN($_p["tp_k"])){ $fl .= sprintf(' AND mdls_tp IN (SELECT id_mdlstp FROM '._BdStr(DBM).TB_MDL_S_TP.' WHERE mdlstp_tp = %s) ', GtSQLVlStr($_p["tp_k"], "text")); }
			
			if(!isN($_p["gen"])){ $fl .= sprintf(' AND id_mdl IN ( SELECT mdlgenmdl_mdl FROM '.TB_MDL_GEN_MDL.' WHERE mdlgenmdl_gen = %s) ', GtSQLVlStr($_p["gen"], "int")); }
			
			if(!isN($_p["mdlmdl_main"])){ $fl .= sprintf(' AND id_mdl IN ( SELECT mdlmdl_mdl FROM '.TB_MDL_MDL.' WHERE mdlmdl_main = %s) ', GtSQLVlStr($_p["mdlmdl_main"], "int")); }
			
			if(!isN($_p["genrel_gen"])){ $__fl = sprintf(' INNER JOIN '.TB_MDL_GEN_REL.' ON mdlgenrel_mdl = id_mdl '); $_fl_gen = sprintf(' AND mdlgenrel_mdlgen = %s ',GtSQLVlStr($_p["genrel_gen"], "int")); }
			
			if(!isN($_p['mdl_are'])){ $fl .= sprintf(' AND id_mdl IN ( SELECT mdlare_mdl FROM '.TB_MDL_ARE.' WHERE mdlare_are IN(%s) ) ', GtSQLVlStr( implode(',',$_p["mdl_are"]) , "int")); }
			
			if(!isN($_p['mdl_exc'])){ $fl .= ' AND id_mdl NOT IN ( '.$_p['mdl_exc'].' ) ';  }

			if(!isN($_p['mdl_s_sch'])){ $fl_vl .= ' , ( SELECT COUNT(*) FROM _mdl_sch WHERE mdlsch_mdl = id_mdl ) AS __tot_sch ';  }

			if(!isN($_p['shw_attr'])){ 	
				
										$_v_c .= implode( '","', $_p['shw_attr']) ;	
										$fl_vl = ' ,(
											SELECT
												GROUP_CONCAT(mdlattr_vl SEPARATOR " - ")
											FROM
												'.TB_MDL_ATTR.'
											INNER JOIN '._BdStr(DBM).TB_SIS_SLC.' ON id_sisslc = mdlattr_attr
											WHERE sisslc_cns IN ("'.$_v_c.'") AND mdlattr_mdl = id_mdl 
										) AS vl ';  
										
									}
			
			if(!ChckSESS_superadm()){
				
				if(!isN($_p['flt_are'])){

					if(defined('SISUS_ARE') && !isN(SISUS_ARE)){
					
						$fl_are = ' (	
										id_mdl IN (	SELECT mdlare_mdl 
													FROM '.TB_MDL_ARE.' 
													WHERE mdlare_are IN ('.SISUS_ARE.')
												)
										||
										
										id_mdl NOT IN (		SELECT mdlare_mdl 
															FROM '.TB_MDL_ARE.'
														)		
									) '; 
					
					}
				}	
					
				
				
				if(defined('SISUS_MDL_N') && !isN(SISUS_MDL_N)){
					
					if(!isN($fl_are)){ $fl_mdl = ' || '; }
					
					$fl_mdl .= ' (	
									id_mdl IN ('.SISUS_MDL_N.')	
								) '; 
				}	
			
			
				if(!isN($fl_mdl) || !isN($fl_are)){ $fl .= ' AND ( '.$fl_are.$fl_mdl.' ) ';  }
				  
				$fl .= " AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' ";		
			
			}	

			$Ls_Qry = "	SELECT * $fl_vl
						FROM ".TB_MDL."
							 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
							 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp  
							 $__fl
						WHERE id_mdl != '' $fl $_fl_gen
						ORDER BY mdl_nm ASC ";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
				do {
		
					if(!isN($__va)){ 
						if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$__v; }
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__vc], $__va) || $Tot_Ls == 1){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $__va)) || $Tot_Ls == 1){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}else{
						if ($Tot_Ls == 1){ $_slc = 'ok'; }
					}
					
					if($row_Ls['__tot_sch'] > 0){ 
						$_p['attr']['_sch'] = 1;
					}else{
						$_p['attr']['_sch'] = 2;
					}
					
					if(!isN($row_Ls['vl'])){ $__vl_adc = $row_Ls['vl']; }else{ $__vl_adc=''; }
					if(!isN($_p['prfx'])){ $__prfx = '('.$row_Ls[ $_p['prfx'] ].') '; }else{ $__prfx=''; }
					
					$LsBld .= HTML_OpVl([ 't'=>$__prfx.$row_Ls['mdl_nm'].' '.$__vl_adc, 'v'=>$row_Ls[$__v], 's'=>$_slc, 'attr'=>$_p['attr'] ]);
					
					
				} while ($row_Ls = $Ls->fetch_assoc());
			
			}
				
			if(!isN($__lbl)){ $__lbl = $__lbl; }else{ $__lbl = _MdlTx(TX_SLCMDL); }	
			
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl, 'nm'=>(!isN($_p['n'])?$_p['n']:''), 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
		
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	
	
	
	
	
	function LsMdlGen($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id']) && !isN($_p['bd'])){

			if(!isN($_p["tp"])){ 
				if(is_array($_p["tp"])){
					$fl .= sprintf(' AND mdlgen_tp IN(%s) ',  implode(',',$_p["tp"]) );	
				}else{
					$fl .= sprintf(' AND mdlgen_tp = %s ', GtSQLVlStr($_p["tp"], "int"));	
				}	
			}
			
			$Ls_Qry = "	SELECT *
						FROM "._BdStr($_p['bd']).TB_MDL_GEN."
						WHERE id_mdlgen != '' $fl
						ORDER BY mdlgen_tt DESC ";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
				do {
					
					if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$_p['v']; }
					
					if(!isN($_p['va'])){ 	
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__vc], $_p['va'])){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
					if(!isN($_p['prfx'])){ $__prfx = '('.$row_Ls[ $_p['prfx'] ].') '; }else{ $__prfx=''; }
					$LsBld .= HTML_OpVl([ 't'=>$__prfx.$row_Ls['mdlgen_tt'], 'v'=>$row_Ls[$__vc], 's'=>$_slc, 'attr'=>$_p['attr'] ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
			
			}
				
			if(!isN($_p['lbl'])){ $__lbl = $_p['lbl']; }else{$__lbl = _MdlTx(TX_SLCMDL); }	
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>$__lbl, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr']]), 'cls'=>$_cls ]);
		
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	
	

	
	function LsSisMnu($__idb, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__idb)){	
			
			$__tbr = ' LEFT '; 
			
			if(!isN($_p['cl'])){ $__f .= " AND clmnur_cl = '".$_p['cl']."' "; $__tbr = ' INNER ';  }
			if(!isN($_p['sis'])){ $__f .= " AND clmnu_sis = '".$_p['sis']."' "; }

			$Ls_Qry = " SELECT * 
						FROM "._BdStr(DBM).TB_CL_MNU." 
							 {$__tbr} JOIN "._BdStr(DBM).TB_CL_MNU_R." ON clmnur_clmnu = id_clmnu
						WHERE id_clmnu != '' {$__f} ORDER BY clmnur_cl ASC, clmnu_ord ASC"; 
						
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						if($row_Ls['clmnu_sis'] == 1){ $_sbtt = '[SIS] '; }else{ $_sbtt = ''; }
						
						$___id = $row_Ls['id_clmnu'];
						$___b[$___id] = [ 
											'id'=>$___id, 
											'tt'=>$_sbtt.$row_Ls['clmnu_tt'],
											'slc'=>$_slc, 
											'prnt'=>$row_Ls['clmnu_prnt']
										];
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					$__row = _bTree($___b, '', 'a');
					$__html = _LsTree($__row);
					$LsBld .= $__html;
					
				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = $__idb.bdiv(['c'=>HTML_Slct(['id'=>$__idb, 'ph'=>TX_PRNT, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	// Listado de Sistema FORMULARIO	
	function LsSisMnuTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_MNU_TP." WHERE id_sismnutp != '' ORDER BY sismnutp_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['sismnutp_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_TP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsCl($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_tp=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			if(!isN($p['ex'])){ $_fl .= ' AND id_cl != "'.$p['ex'].'" '; }

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_CL." WHERE id_cl != '' {$_fl} ORDER BY cl_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					if(!isN($__va)){ 
						
						if($__mlt == 'ok'){
							if(is_array($__va)){ $_go_va = $__va; }else{ $_go_va = explode(',',$__va); } 
							if(in_array($row_Ls[$__v], $_go_va)){ $_slc = 'ok'; }else{ $_slc = 'no'; } 
						}else{
							if(!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok'; }else{$_slc = 'no';} 
						}
					}
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['cl_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$p['attr']]), 'cls'=>$_cls]);
			
			}

			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}	
		
	
				
				
	function LsClAre($_p=NULL){
		
		global $__cnx;
			
		if(!isN($_p['id'])){
			
			if(!ChckSESS_superadm() && $_p['all'] != 'ok' && defined('SISUS_ARE')){ $__f .= "AND id_clare IN (".SISUS_ARE.")"; }
			if(!isN($_p['flt']) && $_p['flt'] == 'ok' && !isN($_p['flt_n']) ){ $__f .= "AND clare_tp = ".$_p['flt_n'].""; }		
			if( !isN($_p['cl']) ){ $__f .= " AND cl_enc = '".$_p['cl']."' "; }else{ $__f .= " AND cl_enc = '".DB_CL_ENC."' ";  }

			$Ls_Qry = " SELECT *,
							   "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
							   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ])."
						FROM "._BdStr(DBM).TB_CL_ARE." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clare_cl = id_cl
							 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clare_tp', 'als'=>'t' ])."
						WHERE id_clare != '' {$__f}  AND clare_est = 1
						ORDER BY clare_cl ASC, clare_ord ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				//echo $Ls_Qry;
				
				if($Tot_Ls > 0){
						
					do{
						
						$__are = $row_Ls['tipo_sisslc_tt'];
						
						if(!isN($_p['va'])){ 
							
							if($_p['flt'] == 'ok'){
								$_v = $_p['va'];
							}else{
								$_v = explode(',',$_p['va']);
							}
							
							if($_p['mlt'] == 'ok'){ 
								if ( in_array($row_Ls[$_p['v']], $_v) ){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
							
						}
						
						if(isN($row_Ls['clare_clr'])){
							if(isN($row_Ls['clare_prnt'])){ $_clr=''; }
						}else{
							$_clr = $row_Ls['clare_clr'];
						}
						
						$__ide = $row_Ls[ $_p['v'] ];
						
						$___b[ $__ide ] = [ 
							'id'=>$row_Ls[ $_p['v'] ], 
							'v_go'=>$row_Ls[ $_p['v_go'] ], 
							'tt'=>'('.$__are.') '.$row_Ls['clare_tt'], 
							'slc'=>$_slc, 
							'prnt'=>$row_Ls['clare_prnt'],
							'attr'=>[
								'clr'=>$_clr
							]
						];


						$__html_opt .= HTML_OpVl([
										't'=>'('.$__are.') '.$row_Ls['clare_tt'], 
										'v'=>$row_Ls[$_p['v']], 's'=>$_slc
									]);
						
						
						if(isN($row_Ls['clare_prnt'])){
							$_trhis_p = 'ok';
						}	
		
						
					}while ($row_Ls = $Ls->fetch_assoc());
					
					if($_trhis_p == 'ok'){
						$__row = _bTree($___b, '', 'a');
						$__html = _LsTree($__row);
					}else{
						$__html = $__html_opt;
					}
					
					$LsBld .= $__html;
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					
					$_rtrn2 = bdiv([
						'c'=>HTML_Slct([
							'id'=>$_p['id'],
							'ph'=>(!isN($_p['ph'])?$_p['ph']:TX_SLCAR),
							'rq'=>$_p['rq'],
							'c'=>$LsBld,
							'm'=>$_p['mlt'],
							'attr'=>$_p['attr'], 
							'flt'=>$_p['flt']
						]), 
						'cls'=>$_cls 
					]);	

				}
				
			}
			
			$__cnx->_clsr($Ls);	

			return($_rtrn2);			
			
		}
	}
	
	
	function LsSisCntNoi($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $p = NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			if(!isN($p['are'])){
				
				$__f1 = " 
						INNER JOIN ".TB_SIS_CNT_NOI_ARE." ON id_siscntnoi =  siscntnoiare_cntnoi
						INNER JOIN ".TB_CL_ARE." ON id_clare =  siscntnoiare_clare";
						
				$__f .= "AND id_clare IN (".$p['are'].")";	
		
			}
				
			$__f .= " AND cl_enc = '".DB_CL_ENC."' ";

			$Ls_Qry = " SELECT * 
						FROM "._BdStr(DBM).TB_SIS_CNT_NOI." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntnoi_cl = id_cl {$__f1}
						WHERE id_siscntnoi != '' {$__f} 
						ORDER BY siscntnoi_cl ASC, siscntnoi_nm ASC";
								
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						
						$___id = $row_Ls['id_siscntnoi'];
						$___b[$___id] = [ 
											'id'=>$___id, 
											'tt'=>$row_Ls['siscntnoi_nm'],
											'slc'=>$_slc, 
											'prnt'=>$row_Ls['siscntnoi_prnt']
										];
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					$__row = _bTree($___b, '', 'a');
					$__html = _LsTree($__row);
					$LsBld .= $__html;
					
				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				if(!isN($__lbl)){ $_lbl=$__lbl; }else{ $_lbl=TX_PRNT; }
				
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			} 
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsSisCntNoiAre($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	

			if(!isN($p['fl'])){ $__fl .= " AND ".$p['fl']; }
			
			$Ls_Qry = " SELECT
							*
						FROM
							"._BdStr(DBM).TB_SIS_CNT_NOI."
						WHERE siscntnoi_cl IN (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."')
						AND (
								id_siscntnoi IN ( SELECT siscntnoiare_cntnoi FROM "._BdStr(DBM).TB_SIS_CNT_NOI_ARE." WHERE siscntnoiare_clare IN(".$p['are'].") )
								OR id_siscntnoi NOT IN ( SELECT siscntnoiare_cntnoi FROM "._BdStr(DBM).TB_SIS_CNT_NOI_ARE." )
							) 
							$__fl"; 
			
						
					
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						
						$___id = $row_Ls['id_siscntnoi'];
						$___b[$___id] = [ 
											'id'=>$___id, 
											'tt'=>$row_Ls['siscntnoi_nm'],
											'slc'=>$_slc
										];
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					$__row = _bTree($___b, '', 'a');
					$__html = _LsTree($__row);
					$LsBld .= $__html;
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					if(!isN($__lbl)){ $_lbl=$__lbl; }else{ $_lbl=TX_PRNT; }
				
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
					
				}
				
				
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
		
	function LsUs($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
        if(!isN($__id)){

             
            if(!isN($_p['tp'])){ 
                if(is_array($_p['tp'])){ $__sql_arr = "mdlstpprm_vl IN (". implode(',', $_p['tp']) .")"; }else{ $__sql_arr = "mdlstpprm_vl = '". $_p['tp'] ."' " ; }
                $_f .= " AND id_us IN (	SELECT usmdl_us 
                						FROM ".MDL_US_MDL_BD.", ".TB_MDL_S_TP_PRM." 
                						WHERE usmdl_mdl = id_mdlstpprm AND usmdl_us = id_us AND {$__sql_arr} ) "; 
            }
             

            if($_p['mdl_fl'] != NULL){

                //$__dtmdl = GtMdlCntDt($_p['mdl_fl']);
                $__dtmdl = GtMdlCntDt([ 'id'=>mdl_fl ]);   
                if($__dtmdl->apr->fac != ''){ $_f_fac = " || (id_us IN (SELECT usfac_us FROM ".MDL_US_FAC_BD." WHERE usfac_fac IN(".$__dtmdl->apr->fac.") )  AND FIND_IN_SET('".$__dtmdl->apr->pro."', us_mdl_exc) IS NULL ) "; $_f_and = true; } 
                if($__dtmdl->apr->pro != ''){ 
                    $_f_pro .= " (FIND_IN_SET('".$__dtmdl->apr->pro."',  (SELECT GROUP_CONCAT(usmdl_pro SEPARATOR ',') FROM ".MDL_US_PRO_BD." WHERE usmdl_us = id_us AND usmdl_tp = 1) ) AND
                                  NOT FIND_IN_SET('".$__dtmdl->apr->pro."', (SELECT GROUP_CONCAT(usmdl_pro SEPARATOR ',') FROM ".MDL_US_PRO_BD." WHERE usmdl_us = id_us AND usmdl_tp = 2) ) ) "; $_f_and = true; 


                }
 
                if($_f_and == true){ $_f .= " AND ( {$_f_pro} {$_f_fac} )"; }
            }
             
            if($_p['mdl'] != ''){ 
                $_f_us_mdl = " (id_us IN (SELECT usmdl_us FROM ".MDL_US_MDL_BD.",".TB_MDL_S_TP_PRM." WHERE usmdl_mdl = id_mdlstpprm AND usmdl_us = id_us AND mdlstpprm_vl = '".$_p['mdl']."' )) "; 
                $_f_grp_mdl = " (id_us IN (  SELECT usgrpus_us 
                                                 FROM ".TB_CL_GRP_PRM.", ".MDL_GRP_US_BD.", ".TB_CL_GRP.", ".TB_MDL_S_TP_PRM."
                                                 WHERE clgrpprm_mdl = id_mdlstpprm AND clgrpprm_usgrp = id_usgrp AND usgrpus_grp = id_usgrp AND usgrpus_us = id_us AND mdlstpprm_vl = '".$_p['mdl']."' )
                                              ) ";
                $_f .= " AND ( {$_f_us_mdl} || {$_f_grp_mdl} )";    
            }
 
            $Ls_Qry = "	SELECT id_us, us_nm, us_ap, us_user, us_enc
            			FROM "._BdStr(DBM).TB_US."
            				 INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us
            				 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
            			WHERE id_us != '' AND cl_enc = '".DB_CL_ENC."' $_f 
            			ORDER BY us_nm ASC";
            			
            $Ls = $__cnx->_qry($Ls_Qry); 
            
            if($Ls){
	            
	            $row_Ls = $Ls->fetch_assoc();  
	            $Tot_Ls = $Ls->num_rows; 
	            
	            $LsBld .= HTML_OpVl(['ct'=>'off']);
	            if($__lbl != ''){ $__ph = $__lbl; }else{ $__ph = FM_LS_US; }
                 
                do { 

	              
	                if($__mlt == 'ok'){
						if (in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
					}else{
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					}
                    
                    $LsBld .= HTML_OpVl(array('t'=>ctjTx($row_Ls['us_nm'],'out').' '.ctjTx($row_Ls['us_ap'],'out').' ('.$row_Ls['us_user'].')', 'v'=>$row_Ls[$__v], 's'=>$_slc)); 

                } while ($row_Ls = $Ls->fetch_assoc());
                 
                if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
                if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
                $_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$__ph, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr']]), 'cls'=>$_cls]);
            
            
            
            }else{
				
				echo 'LsUs:'.$__cnx->c_r->error;
				
			}
            
            $__cnx->_clsr($Ls);
            
            return($_rtrn2);
        }
    }
    
    
	
	
	function LsUsTel($_p=NULL){
		
		global $__cnx;
		
		if($_p['us']!=''){	

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_US_TEL_BD.", "._BdStr(DBM).TB_SIS_PS." WHERE ustel_est = 1 AND ustel_ps = id_sisps AND (ustel_us = ".GtSQLVlStr($_p['us'], "int")." || ustel_sis = 1) ORDER BY ustel_dfl ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			
			if($_p['ct'] != 'no'){ $LsBld .= HTML_OpVl(['ct'=>'off']); }
				
				
				do {
					if (!(strcmp($row_Ls['ustel_tel'], $__va))){$_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['ustel_tel'], 'rel'=>$row_Ls['ustel_enc'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				if($_p['ph'] != 'no'){ $__ph = FM_LS_SLTEL; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>$__ph, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	function LsUsEml($_p=NULL){
		
		global $__cnx;
				
		if(defined('DB_CL_ENC')){ $__f .= " AND cl_enc = '".DB_CL_ENC."' "; }
		if(defined('SISUS_ID')){ $__f .= " AND useml_us = '".GtSQLVlStr(SISUS_ID, "int")."' "; }
			
		$Ls_Qry = "	SELECT id_useml, id_eml, eml_enc, eml_eml
					FROM "._BdStr(DBM).TB_US_EML." 
						 INNER JOIN "._BdStr(DBM).TB_US." ON useml_us = id_us
						 INNER JOIN "._BdStr(DBM).TB_CL." ON useml_cl = id_cl
						 INNER JOIN "._BdStr(DBM).TB_CL_EML." ON cleml_cl = id_cl
						 INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON useml_eml = id_eml
					WHERE id_useml != '' {$__f}
					GROUP BY id_eml
					ORDER BY id_useml DESC";
					
		$Ls = $__cnx->_qry($Ls_Qry);
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;
		
		if($_p['ct'] != 'no'){ $LsBld .= HTML_OpVl(['ct'=>'off']); }
			
			
			do {
				if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){$_slc = 'ok';}else{$_slc = 'no';} 
				$LsBld .= HTML_OpVl(['t'=>$row_Ls['eml_eml'], 'rel'=>$row_Ls['eml_enc'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc]);
			} while ($row_Ls = $Ls->fetch_assoc());
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if($_p['ph'] != 'no'){ $__ph = FM_LS_SLEML; }
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>$__ph, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
		$__cnx->_clsr($Ls);
		return($_rtrn2);
		
	}	
	
	
	
	function LsCntEst($_p=NULL){ //$__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL
		
		global $__cnx;

		if(!isN($_p['id'])){

			if(!ChckSESS_superadm()){ 
				
				$__fl .= ' AND siscntest_usnvl = 3 '; 
				
				if(defined('SISUS_ARE') && !isN(SISUS_ARE)){
					
					$__fl .= " AND (
										id_siscntest IN (	SELECT siscntestare_est 
															FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
															WHERE siscntestare_are IN (".SISUS_ARE.")
														) 
										|| id_siscntest NOT IN( SELECT siscntestare_est 
															 FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
														)
										||	id_siscntest IN(
											SELECT
												siscntestare_est
											FROM
												"._BdStr(DBM).TB_SIS_CNT_EST_ARE."
											WHERE
												siscntestare_are IN(
													SELECT
														clare_prnt
													FROM
														"._BdStr(DBM).TB_CL_ARE."
													WHERE
														id_clare IN(".SISUS_ARE.")
												)
										)
														
									)				
							"; 
																													
				}
			}
			
			if(defined('DB_CL_ENC')){ $__fl .= " AND cl_enc = '".DB_CL_ENC."'"; }
			
			if(!isN($_p['mdl'])){ 	
				
				$__cntestare = LsCntEstAreAll([ 'mdl'=>$_p['mdl'] ]); 
				
				if(!isN($__cntestare) && !isN($__cntestare->ls)){
					foreach($__cntestare->ls as $__cntestare_k=>$__cntestare_v){
						$___are_in[] = $__cntestare_v->id;
					}
					if(is_array($___are_in)){ $___are_in_go = implode(',', $___are_in); }
				}
				
				if(!isN($___are_in_go)){
					$__fl .= " AND ( id_siscntest IN (	SELECT siscntestare_est 
																	FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
																	WHERE siscntestare_are IN (".$___are_in_go.")
																) 
																
										||	id_siscntest NOT IN( SELECT siscntestare_est 
															 FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
														)
														
										||	id_siscntest IN(
											SELECT
												siscntestare_est
											FROM
												"._BdStr(DBM).TB_SIS_CNT_EST_ARE."
											WHERE
												siscntestare_are IN(
													SELECT
														clare_prnt
													FROM
														"._BdStr(DBM).TB_CL_ARE."
													WHERE
														id_clare IN(".$___are_in_go.")
												)
										)
							
									)"; 
				}											
			}	
			
			
			if( !isN($_p['mdlstp']) ){
				
				$__fl .= sprintf(' AND  
									(	SELECT COUNT(*) 
										FROM '._BdStr(DBM).TB_MDL_S_TP_EST.'
										WHERE siscntest_cl = id_cl AND mdlstpest_mdlstp=%s AND mdlstpest_est = 1 AND mdlstpest_cntest = id_siscntest 
									) > 0',
									GtSQLVlStr($_p['mdlstp'], 'int'));  						
			}	
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_CNT_EST."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntest_cl = id_cl
							 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp 
						WHERE id_siscntest != '' $__fl ORDER BY siscntesttp_ord ASC, siscntest_tt ASC"; 
			
				
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;  
				$LsBld .= HTML_OpVl(['ct'=>'off']);	
					
				do {
					
					if(!isN($_p['va'])){  
					
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], $_p['va'])){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						}
	
					}
					
					$___id = $row_Ls['id_siscntesttp'];
					$___idm = $row_Ls['id_siscntest'];
					
					$___b[$___id]['id'] = $row_Ls['id_siscntesttp'];
					$___b[$___id]['tt'] = ctjTx($row_Ls['siscntesttp_tt'],'in');
					$___b[$___id]['clr'] = $row_Ls['siscntesttp_clr_bck'];
					$___b[$___id]['ls'][$___idm] = [ 'id'=>$___idm, 
													 'enc'=>$row_Ls['siscntest_enc'],
													 'tt'=>$row_Ls['siscntest_tt'],
													 'clr'=>$row_Ls['siscntest_clr_bck'],
													 'noi'=>$row_Ls['siscntest_noi'],
													 'slc'=>$_slc
													];
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				foreach($___b as $___b_k=>$___b_v){
				
					$LsBld .= '<optgroup label="'.$___b_v['tt'].'" clr="'.$___b_v['clr'].'">';
					
					if(!isN($___b_v['ls'])){
						
						foreach($___b_v['ls'] as $op_k=>$op_v){
							
							if($_p['v_go']=='enc'){ $__v_go=$op_v['enc']; }else{ $__v_go=$op_v['id']; }
							
							$__attr = $_p['attr'];
							$__attr['clr'] = $op_v['clr'];
							$__attr['noi'] = $op_v['noi'];
							
							$LsBld .= HTML_OpVl([ 't'=>$op_v['tt'], 
												  'v'=>$__v_go, 
												  's'=>$op_v['slc'],
												  'attr'=>$__attr
												]);	
						}
					}
					
					$LsBld .= '</optgroup>';
				}
			
			}
			
				
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if($_p['lbl'] != ''){$label = $_p['lbl'];}else{$label = FM_LS_EST;}
			
			
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$label, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
						
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	
	}
	
	
	
	function LsCntEstAre($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			if(!ChckSESS_superadm()){ $__fl .= ' AND siscntest_usnvl = 3 '; }
			if(defined('DB_CL_ENC')){ $__fl .= " AND cl_enc = '".DB_CL_ENC."'"; }
			
			$Ls_Qry = "	SELECT
							DISTINCT id_siscntest, siscntest_tt
						FROM
							"._BdStr(DBM).TB_SIS_CNT_EST."
						INNER JOIN "._BdStr(DBM).TB_CL." ON siscntest_cl = id_cl
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_ARE." ON id_siscntest = siscntestare_est
						INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON id_clare = siscntestare_are
						WHERE
							id_siscntest != ''
						AND cl_enc = '".CL_ENC."'
						AND siscntestare_are IN (".$__va.")
						ORDER BY
							siscntesttp_ord ASC ,
							siscntest_tt ASC ";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;  
			$LsBld .= HTML_OpVl(['ct'=>'off']);	
				
			do {
				
				if(!isN($__va)){  
					
					if($__mlt == 'ok'){
						if (in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
					}else{
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					}

				}
				
				$___id = $row_Ls['id_siscntesttp'];
				$___idm = $row_Ls['id_siscntest'];
				
				$___b[$___id]['id'] = $row_Ls['id_siscntesttp'];
				$___b[$___id]['tt'] = ctjTx($row_Ls['siscntesttp_tt'],'in');
				$___b[$___id]['clr'] = $row_Ls['siscntesttp_clr_bck'];
				$___b[$___id]['ls'][$___idm] = [ 'id'=>$___idm, 
												 'enc'=>$row_Ls['siscntest_enc'],
												 'tt'=>$row_Ls['siscntest_tt'],
												 'clr'=>$row_Ls['siscntest_clr_bck'],
												 'noi'=>$row_Ls['siscntest_noi'],
												 'slc'=>$_slc
												];
				
			} while ($row_Ls = $Ls->fetch_assoc());
			
			
			foreach($___b as $___b_k=>$___b_v){
				
				$LsBld .= '<optgroup label="'.$___b_v['tt'].'" clr="'.$___b_v['clr'].'">';
				
				if(!isN($___b_v['ls'])){
					foreach($___b_v['ls'] as $op_k=>$op_v){
						$LsBld .= HTML_OpVl([ 't'=>$op_v['tt'], 
											  'v'=>$op_v['enc'], 
											  's'=>$op_v['slc'],
											  'attr'=>[
												  'clr'=>$op_v['clr'],
												  'noi'=>$op_v['noi']
											  ]
											]);	
					}
				}
				
				$LsBld .= '</optgroup>';
			}	
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if($__lbl != ''){$label = $__lbl;}else{$label = FM_LS_EST;}
			
			
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
			
		}
	}
	
	function LsCntEstTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
				
			if( !isN($_p['mdlstp']) ){
				
				$__fl .= sprintf(' AND  
									(	SELECT COUNT(*) 
										FROM '._BdStr(DBM).TB_MDL_S_TP_EST.'
											 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST.' ON mdlstpest_cntest = id_siscntest
										WHERE siscntest_cl = id_cl AND mdlstpest_mdlstp=%s AND mdlstpest_est = 1 AND siscntest_tp = id_siscntesttp 
									) > 0',
									GtSQLVlStr($_p['mdlstp'], 'int'));  						
			}	
			 
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_CNT_EST_TP."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntesttp_cl = id_cl 
						WHERE id_siscntesttp != '' AND cl_enc = '".DB_CL_ENC."' {$__fl}
						ORDER BY siscntesttp_tt ASC";
							
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
				if($Tot_Ls > 0){

					do {
	
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if(is_array($__va)){ $_chkv=$__va; }else{ $_chkv=explode(',',$__va); }
								if(in_array($row_Ls[$__v], $_chkv)){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if(!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}

						$LsBld .= HTML_OpVl([ 
										't'=>$row_Ls['siscntesttp_tt'], 
										'v'=>$row_Ls[$__v], 
										's'=>$_slc, 
										'attr'=>[ 
											'clr'=>!isN($row_Ls['siscntesttp_clr_fnt']) ? $row_Ls['siscntesttp_clr_fnt'] : $row_Ls['siscntesttp_clr_bck']
										] 
									]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
				}

				if($__lbl != ''){$label = $__lbl;}else{$label = TX_SLCETP;}
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);

				$Ls->free; 
			
			}else{
				
				echo 'LsCntEstTp: '.$__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
				
			
		}
	}

	function LsCntTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
				
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_CNT_TP."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON siscnttp_cl = id_cl 
						WHERE id_siscnttp != '' AND cl_enc = '".DB_CL_ENC."' {$__fl}
						ORDER BY siscnttp_nm ASC";
							
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
				do {

					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if(is_array($__va)){ $_chkv=$__va; }else{ $_chkv=explode(',',$__va); }
							if(in_array($row_Ls[$__v], $_chkv)){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if(!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['siscnttp_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				if($__lbl != ''){$label = $__lbl;}else{$label = FM_LS_VNCU;}				
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
			
		}
	}

	function LsCntEtp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
				
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_CL_ETP."
							INNER JOIN "._BdStr(DBM).TB_CL." ON cletp_cl = id_cl 
						WHERE id_cletp != '' AND cl_enc = '".DB_CL_ENC."'
						ORDER BY cletp_nm ASC";
							
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
				do {

					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if(is_array($__va)){ $_chkv=$__va; }else{ $_chkv=explode(',',$__va); }
							if(in_array($row_Ls[$__v], $_chkv)){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if(!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['cletp_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				if($__lbl != ''){$label = $__lbl;}else{$label = FM_LS_VNCU;}				
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
			
		}
	}

		
	function LsUsEst($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_US_EST." ORDER BY usest_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['usest_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_EST, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}

		
	function LsGrph($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_GRPH_BD." WHERE id_grph != '' ORDER BY grph_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {

					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['grph_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=> TX_SLCTPGRP , 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			}

			$__cnx->_clsr($Ls);
			return($_rtrn2);
			
		}
	}
	
	
	function LsDms($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_tp=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			if($_tp != ''){ $_fl = "AND id_dshdms IN( SELECT dshgrphdms_dms FROM "._BdStr(DBM).TB_DSH_GRPH_DMS." WHERE dshgrphdms_grph = ".$_tp.")"; }
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_DSH_DMS." WHERE id_dshdms != '' $_fl ORDER BY dshdms_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {
					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['dshdms_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCDMS, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}	
	
	function LsMtrc($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_tp=NULL){
		
		global $__cnx;
		global $__dt_cl;
		
		if(!isN($__id)){

			if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

			$_Cl_Dt_Id = $__dt_cl->id;
			$__fl_cl = sprintf(' AND id_cl = '.$_Cl_Dt_Id.' ');
			
			if($_tp != ''){ $_fl = "AND id_dshmtrc IN( SELECT dshdmsmtrc_mtrc FROM "._BdStr(DBM).TB_DSH_DMS_MTRC." WHERE dshdmsmtrc_dms = ".$_tp.")"; }
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_DSH_MTRC.", "._BdStr(DBM).TB_DSH_MTRC_CL.", "._BdStr(DBM).TB_CL." WHERE id_dshmtrc != '' AND dshmtrccl_mtrc = id_dshmtrc AND dshmtrccl_cl = id_cl $_fl $__fl_cl ORDER BY dshmtrc_tt ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
		
				do {
					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['dshmtrc_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCMTRC, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
			
		}
	}
	
	
	function LsSisSlcTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_tp=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
			
			$__bd = TB_SIS_SLC_TP;
			$_prfx = 'sis';
				
			if($_tp != ''){ $_fl = "AND id_".$_prfx."scltp = ".$__id.")"; }
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).$__bd." WHERE id_".$_prfx."slctp != '' $_fl ORDER BY ".$_prfx."slctp_tt ASC";
			
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				do {

					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls[''.$_prfx.'slctp_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCTP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}	
	
	function LsEmp_Vst($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $__flt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_EMP_VST_BD.", "._BdStr(DBM).TB_EMP_CNT." WHERE empvst_cnt = id_empcnt $__flt ORDER BY id_empvst DESC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls > 0){
					do {
	
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
	
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['empvst_f'].' ('.$row_Ls['empvst_h'].')', 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());
				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				if($Tot_Ls > 0){ $_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLVSTA, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]); }
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsSmsLsts($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		$Ls_Qry = "SELECT * FROM "._BdStr(DBM).MDL_SMS_LSTS_BD." WHERE id_smslsts != '' $_fl ORDER BY smslsts_nm ASC";
		
		$Ls = $__cnx->_qry($Ls_Qry); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows; 
		$LsBld .= HTML_OpVl(['ct'=>'off']);
			
			do {
				if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
				$LsBld .= HTML_OpVl(['t'=>$row_Ls['smslsts_nm'], 'rel'=>$row_Ls['smslsts_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
			} while ($row_Ls = $Ls->fetch_assoc());
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if($__lbl != ''){$label = $__lbl;}else{$label = TX_SLCCNLT;}
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
		$__cnx->_clsr($Ls);
		return($_rtrn2);
		
	}		
	
	function LsTraCol($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
			
		$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_TRA_COL." WHERE id_tracol != '' $_fl AND tracol_cl = '".DB_CL_ID."' ORDER BY tracol_tt ASC";
		$Ls = $__cnx->_qry($Ls_Qry); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows; 
		$LsBld .= HTML_OpVl(['ct'=>'off']);
			
			do {
				if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
				$LsBld .= HTML_OpVl(['t'=>$row_Ls['tracol_tt'], 'rel'=>$row_Ls['tracol_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
			} while ($row_Ls = $Ls->fetch_assoc());
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if($__lbl != ''){$label = $__lbl;}else{$label = TX_SLCCLM;}
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
		$__cnx->_clsr($Ls);
		return($_rtrn2);
		
	}	
	
	function LsCmpgCtg($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			$Ls_Qry = "SELECT * FROM ".TB_TB_SMS_CMPG_CTG." WHERE ".$_p['ctg']." = 1 ORDER BY cmpgctg_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;  
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
	
					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}

					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['cmpgctg_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				if($__lbl != ''){$label = $__lbl;}else{$label = TX_SLCCNCTG;}
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt ]), 'cls'=>$_cls ]);
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
			
		}
	}
		
			
	function __Ls($_p=NULL){
		
		global $__cnx;
		
		if($_p['cl'] == 'ok'){
			$__bd = TB_CL_SLC;
			$_prfx = 'sis';
			$__bd2 = TB_CL_SLC_TP;	
		}else{
			$__bd = _BdStr(DBM).TB_SIS_SLC;
			$_prfx = 'sis';
			$__bd2 = _BdStr(DBM).TB_SIS_SLC_TP;
		}
		
		if(!isN($_p['slc']) && !isN($_p['slc']['opt']['attr'])){
			foreach($_p['slc']['opt']['attr'] as $_opt_k=>$_opt_v){
				$__kals = substr($_opt_v,0,2);
				$__slcf .= ','._QrySisSlcF([ 'als_n'=>$_opt_v, 'als_fk'=>$_opt_v ]);
			}
		}
		
		if(!isN($_p['k'])){ $_fl .= sprintf(" AND ".$_prfx."slctp_key = %s", GtSQLVlStr($_p['k'], "text")); }
		if(!isN($_p['idt'])){ $_fl .= sprintf(" AND id_".$_prfx."slctp = %s", GtSQLVlStr($_p['idt'], "int")); }
		
		
		if($_p['fcl']=='ok'){ $_fl .= sprintf(" AND id_sisslc IN ( SELECT sisslccl_sisslc 
																			FROM "._BdStr(DBM).TB_SIS_SLC_CL."
																				 INNER JOIN "._BdStr(DBM).TB_CL." ON sisslccl_cl = id_cl
																			WHERE cl_enc=%s) ", GtSQLVlStr(DB_CL_ENC, "text")); }
																		
		
		if(!isN($_p['ord']) && $_p['ord']=='ok'){ $__ord = $_prfx."slc_tt ASC"; }else{ $__ord = "id_".$_prfx."slc DESC";  }
																			
		$Ls_Qry = sprintf("	SELECT * {$__slcf} 
					FROM $__bd 
						 INNER JOIN $__bd2 ON ".$_prfx."slc_tp = id_".$_prfx."slctp
					WHERE ".$_prfx."slctp_key != '' {$_fl}
					ORDER BY 
						CASE WHEN sisslctp_ord = 1 AND sisslctp_ord_desc = 1 THEN sisslc_ord END DESC,
						CASE WHEN sisslctp_ord = 1 AND sisslctp_ord_desc = 2 THEN sisslc_ord END ASC,
						CASE WHEN sisslctp_ord = 2 AND sisslctp_ord_desc = 2 THEN sisslc_tt END ASC,
						CASE WHEN sisslctp_ord = 2 AND sisslctp_ord_desc = 1 THEN sisslc_tt END DESC");

		$Ls = $__cnx->_qry($Ls_Qry);
			
		if($Ls){
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
		
			if($_p['ct']!='no' && $_p['f']!='str' && $_p['f']!='rto'){ $LsBld .= HTML_OpVl(['ct'=>'off']); }
			if(!isN($_p['v'])){ $__pv = $_p['v']; }else{ $__pv = 'id_'.$_prfx.'slc'; }
			
					
			do { 

				$__tt_sfx = '';
				$__tt_pfx = '';

				if(!isN($_p['ttb'] )){
					foreach($_p['ttb'] as $_tt_k=>$_tt_v){	
						$__js = json_decode($row_Ls['___'.$_tt_k]);
						if(!isN($__js->vl)){
							if(!isN($_tt_v['p']) && $_tt_v['p'] == 'ok'){ 
								$__tt_pfx .= '('.$__js->vl.') ';
							}else{
								$__tt_pfx .= $__js->vl.' ';
							}
						}
					}	
				}

				if(!isN($_p['tta'] )){
					foreach($_p['tta'] as $_tt_k=>$_tt_v){	
						$__js = json_decode($row_Ls['___'.$_tt_k]);
						if(!isN($__js->vl)){
							if(!isN($_tt_v['p']) && $_tt_v['p'] == 'ok'){ 
								$__tt_sfx .= ' ('.$__js->vl.')';
							}else{
								$__tt_sfx .= ' '.$__js->vl;
							}
						}
					}	
				}

				if(!isN($_p['va'])){ 
					if($_p['mlt'] == 'ok'){
						if(is_array($_p['va'])){ $_chkv=$_p['va']; }else{ $_chkv=explode(',',$_p['va']); }
						if (in_array($row_Ls[$__pv], $_chkv)){ $_slc = 'ok';}else{$_slc = 'no';}
					}else{
						if (!(strcmp($row_Ls[$__pv], $_p['va'] ))){$_slc = 'ok';}else{ $_slc = 'no'; } 
					}
				}	
				
				$__attr=[]; //echo $__tt_sfx;
				
				if(!isN($_p['slc']) && !isN($_p['slc']['opt']['attr'] )){
					foreach($_p['slc']['opt']['attr'] as $_opt_k=>$_opt_v){		
						$__js = json_decode($row_Ls['___'.$_opt_v]);
						$__attr[ $_opt_k ] = $__js[0]->vl;
					}	
				}				
				
				if(!isN($_p['opt_v'])){ $__lbl = $__attr[$_p['opt_v']]; }else{ $__lbl = $row_Ls[$_prfx.'slc_tt']; }
				
				if($_p['f']=='rto'){
					
					$LsBld .= HTML_RdoVl([ 'lbl'=>$_p['lbl'], 'attr'=>$_p['attr'], 't'=>$__lbl, 'n'=>$__tt_pfx.(!isN($_p['n'])?$_p['n']:$_p['id']).$__tt_sfx, 'v'=>$row_Ls[$__pv], 's'=>$_slc, 'c'=>'star', 'd'=>$_p['dsbl'] ]);
				
				}elseif($_p['f']=='str'){
					
					$LsBld .= HTML_RdoVl([ 'lbl'=>$_p['lbl'], 't'=>$__lbl, 'n'=>$__tt_pfx.(!isN($_p['n'])?$_p['n']:$_p['id']).$__tt_sfx, 'v'=>$row_Ls[$__pv], 's'=>$_slc, 'c'=>'star', 'd'=>$_p['dsbl'] ]);
				
				}else{

					$LsBld .= HTML_OpVl(['t'=>$__tt_pfx.$__lbl.$__tt_sfx, 'rel'=>$row_Ls[$_prfx.'slc_enc'], 'v'=>$row_Ls[$__pv], 's'=>$_slc, 'attr'=>$__attr ]);
				}
				
				
						
			} while ($row_Ls = $Ls->fetch_assoc());
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			
			if($_p['mlt']=='ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{ $_cls = DV_CLSS_SLCT_BX; }
			
			if($_p['f']=='str' || $_p['f']=='rto'){ $_cls = '__rtio'; }elseif($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{ $_cls = DV_CLSS_SLCT_BX; }
			
			if(!isN($_p['ph'])){ $__ph = $_p['ph']; }else{ $__ph = _Cns('FM_SISSLC_'.strtoupper($row_Ls[''.$_prfx.'slctp_key'])); }
			
			$_rtrn2 = bdiv(['c'=>HTML_Slct([ 
										'id'=>$_p['id'], 
										'ph'=>$__ph, 
										'rq'=>$_p['rq'], 
										'nm'=>(!isN($_p['n'])?$_p['n']:''),
										'c'=>$LsBld, 
										'm'=>$_p['mlt'], 
										'attr'=>$_p['attr'], 
										'cls'=>$_p['cls'] 
									]), 
							'cls'=>$_cls 
					]);
					
			if($_p['f']=='str' || $_p['f']=='rto'){ 
				
				$r['html'] = bdiv([ 'c'=>$LsBld, 'cls'=>$_cls ]);
				
				if($_p['f']=='str'){ $r['js'] = " SUMR_Main.ld.f.rtng( function(){ $(':radio.star').rating({cancel: 'Cancel', cancelValue: '0'}); });"; }
			
			}else{ 
				$r['html'] = $_rtrn2;
				$r['js'] = JQ_Ls($_p['id'], $__ph, '', '', $_p['slc']); 
			}	
		
		}else{
			
			superadm_echo($__cnx->c_r->error);
			
		}
			
		$__cnx->_clsr($Ls);
				
		return _jEnc($r);
		
	}
	
	
	function LsEncTp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $_p=NULL ){
		
		global $__cnx;
		
        if(!isN($__id)){ 
	         
            if(!isN($_p['tp'])){ $__fl = 'AND mdlstp_tp = "'.$_p['tp'].'"'; }else{ $__fl = ''; }
            $Ls_Qry = "SELECT * FROM ".TB_ENC.", "._BdStr(DBM).TB_MDL_S_TP."  WHERE id_enc != '' AND id_mdlstp = enc_mdlstp $__fl ORDER BY enc_tt ASC";
            $Ls = $__cnx->_qry($Ls_Qry);
            $row_Ls = $Ls->fetch_assoc(); 
            $Tot_Ls = $Ls->num_rows; 
            $LsBld .= HTML_OpVl(['ct'=>'off']);
                 
                do {
                    if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
                    $LsBld .= HTML_OpVl(['t'=>$row_Ls['enc_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
                } while ($row_Ls = $Ls->fetch_assoc());
                 
                if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
                if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
                $_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_SLCNCST, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
           
            $__cnx->_clsr($Ls);
           
            return($_rtrn2);
        }
    }
    
    
    
    // Listado de Sistema FORMULARIO
	function LsSisMdl($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			$Ls_Qry = "SELECT * FROM ".TB_TB_MDL_S_TP_PRM." ORDER BY mdlstpprm_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry); 
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				do {
					if(!isN($__va)){ if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} } 
					$LsBld .= HTML_OpVl(['t'=>$row_Ls['mdlstpprm_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_PMS, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
			
		}
	}
	
	
	
	function LsSisFld($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $__flt=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
			
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_SIS_FLD." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON sisfld_cl = id_cl
						WHERE id_sisfld != '' AND cl_enc = '".DB_CL_ENC."' ".$__fl."  
						ORDER BY sisfld_tt ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
					do {
	
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
	
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['sisfld_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>FM_LS_SLFLD, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt ]), 'cls'=>$_cls ]);
			
			}
			
			$__cnx->_clsr($Ls);
			
		}
		
		return($_rtrn2);
		
	}	

	function LsLnd($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_tp=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){

			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_LND."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON lnd_cl = id_cl
						WHERE id_lnd != '' AND cl_enc = '".DB_CL_ENC."'
						ORDER BY lnd_tt ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				//echo $Ls_Qry;
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
					do {
						
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['lnd_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>MDL_LND, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt ]), 'cls'=>$_cls ]);
			
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	function LsEcLsts($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
			
		if(!isN($__fml['tp'])){

			$__tp = GtMdlSTpDt([ 'id'=>$__fml['tp'], 't'=>'tp' ]);
			
			if(!isN($__tp->id)){ $_tp=$__tp->id; }
			
			$flt .= " AND
			 
						(
							id_eclsts IN (	SELECT eclststp_lsts 
										FROM "._BdStr(DBM).TB_EC_LSTS_TP." 
										WHERE eclststp_lsts = id_eclsts AND eclststp_tp = ".$_tp."
									) 
							OR
							
							id_eclsts NOT IN (	SELECT eclststp_lsts FROM "._BdStr(DBM).TB_EC_LSTS_TP." ) 
									
						)				
					
					"; 
					
		}else{
			$flt = '';
		}
		
		
		if(!ChckSESS_superadm() && !_ChckMd('snd_ec_lsts_all') && defined('SISUS_ARE') && !isN(SISUS_ARE)){
			
            $flt .= " AND ( 
            				id_eclsts IN ( 	SELECT eclstsare_eclsts 
            								FROM "._BdStr(DBM).TB_EC_LSTS_ARE." 
            								WHERE eclstsare_clare IN (".SISUS_ARE.")
            							) || 
            							
            				id_eclsts NOT IN ( SELECT eclstsare_eclsts 
            									FROM "._BdStr(DBM).TB_EC_LSTS_ARE."
            							)			
						)
            		";
        }
    
		
		if(!isN($_p['sndr'])){ $flt .= " AND eclsts_sndr = '".$_p['sndr']."' "; }
		
		
		$Ls_Qry = "	SELECT *,
						 	(
							 	SELECT COUNT(*)
								FROM "._BdStr(DBM).TB_EC_LSTS_ARE." 
									 INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON eclstsare_clare = id_clare 
								WHERE eclstsare_eclsts = id_eclsts							 	
						 	) AS __tot 
						 	
					FROM "._BdStr(DBM).MDL_EC_LSTS_BD." 
						 INNER JOIN "._BdStr(DBM).TB_CL." ON eclsts_cl = id_cl
					WHERE id_eclsts != '' AND cl_enc = '".DB_CL_ENC."' ".$flt." 
					ORDER BY eclsts_nm ASC";
					
		$Ls = $__cnx->_qry($Ls_Qry);
		
		if($Ls){
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			$LsBld .= HTML_OpVl(['ct'=>'off']);
			
			do {
				
				if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
				
				$LsBld .= HTML_OpVl([
							't'=>$row_Ls['eclsts_nm'], 
							'rel'=>$row_Ls['eclsts_nm'], 
							'v'=>$row_Ls[$__v], 's'=>$_slc, 
							'attr'=>[ 'are-tot'=>$row_Ls['__tot'] ] 
						]);
					
			} while ($row_Ls = $Ls->fetch_assoc());
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			if($__lbl != ''){$label = $__lbl;}else{$label = 'Seleccione lista';}
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>$label, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
		
		}else{
			
			echo $__cnx->c_r->error; 
			
		}
		
		$__cnx->_clsr($Ls);
		
		return($_rtrn2);
		
	}
	
	
	function LsEcLstsSgm($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if($__id!=''){
			
			if(!isN($_p['lsts'])){ $_fl .= " AND eclsts_enc = '".$_p['lsts']."' "; }
			if(!isN($_p['wvar']) && $_p['wvar'] == 'ok'){ $_fl .= " AND ( eclstssgm_tot_var > 0 || eclsts_sndr != '"._CId('ID_SISEML_SUMR')."' ) "; }
			

			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_EC_LSTS_SGM."
							 INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstssgm_lsts = id_eclsts
						WHERE id_eclstssgm != '' $_fl 
						ORDER BY eclstssgm_nm ASC";
			
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['eclstssgm_nm'], 'rel'=>$row_Ls['eclstssgm_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					} while ($row_Ls = $Ls->fetch_assoc());
							
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt ]), 'cls'=>$_cls ]);
				
				}

			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	function LsMdlSPrd($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx;

		if(!isN($p['tp_mdl'])){ 
			$___rel = "INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD_TP." ON mdlsprdtp_prd = id_mdlsprd
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlsprdtp_tp = id_mdlstp";
			$__cond = "AND mdlstp_tp = '".$p['tp_mdl']."'";			
		}else{ 
			$___rel = '';
			$__cond = '';
		}

		if(!isN($p['est']) && $p['est'] == 'ok'){ $__cond .= " AND mdlsprd_est = 1"; }
			
		if(!isN($__id)){
																	
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_MDL_S_PRD."
							INNER JOIN "._BdStr(DBM).TB_CL." ON mdlsprd_cl = id_cl $___rel
						WHERE id_mdlsprd != ''
							  AND cl_enc = '".DB_CL_ENC."' $__cond
						ORDER BY mdlsprd_nm ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				//echo $Ls_Qry;
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				
				if( $Tot_Ls > 0 ){
					do {
						
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if(is_array($__va)){ $__a_ex = $__va; }else{ $__a_ex = explode(',',$__va); }
								if(in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['mdlsprd_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					if(!isN($__lbl)){ $_lbl = $__lbl; }else{ $_lbl=FM_LS_PRD; } 

					
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$p['attr'] ]), 'cls'=>$_cls ]);	
				}
			}
			
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}
	
	//horarios
	function LsMdlSHrs($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx; 
		
		if(!isN($__id)){
																	
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_MDL_S_SCH."
						INNER JOIN "._BdStr(DBM).TB_CL." ON mdlssch_cl = id_cl
						WHERE id_mdlssch != ''
						AND cl_enc = '".DB_CL_ENC."'
						ORDER BY mdlssch_nm ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				//echo $Ls_Qry;
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
				do {
					
					if(!isN($__va)){ 
						if($__mlt == 'ok'){
							if(is_array($__va)){ $__a_ex = $__va; }else{ $__a_ex = explode(',',$__va); }
							if(in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['mdlssch_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				if(!isN($__lbl)){ $_lbl = $__lbl; }else{ $_lbl=FM_LS_PRD; } 

				
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$p['attr'] ]), 'cls'=>$_cls ]);
			
			}
			
			$__cnx->_clsr($Ls);

			return($_rtrn2);

		}

	}
	
	// fin Horarios
	
	function LsBcoK($__id, $__v, $__va=NULL, $__lbl=NULL, $__rq=NULL, $__fml=NULL, $__tp=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
 
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_BCO_ATTR." WHERE bcoattr_k = '".$__tp."' GROUP BY bcoattr_v ";
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
					
					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['bcoattr_v'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt ]), 'cls'=>$_cls ]);
					
					$__cnx->_clsr($Ls);
				
				}
			
			}
			
			return($_rtrn2);
			
		}
	}
	
	
	function LsClEtp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
			
		if(!isN($__id)){

			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_CL_ETP." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON cletp_cl = id_cl
						WHERE id_cletp != '' AND cl_enc = '".DB_CL_ENC."'
						ORDER BY cletp_ord ASC"; 
						
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
				if($Tot_Ls > 0){
						
					do {
	
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
	
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['cletp_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc, 'rel'=>$row_Ls['cletp_ord']]);
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>FM_LS_ETP, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt ]), 'cls'=>$_cls ]);
				
				}
				
				
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	
	function LsMdlSch($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){
			
			$Ls_Qry = " SELECT id_mdlssch, mdlssch_enc, mdlssch_nm, id_mdl
						FROM
							"._BdStr(DBM).TB_MDL_S_SCH."
						INNER JOIN ".TB_MDL_SCH." ON id_mdlssch = mdlsch_sch
						INNER JOIN ".TB_MDL." ON id_mdl = mdlsch_mdl
						WHERE
							mdlssch_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".DB_CL_ENC."')
						AND id_mdl = ".$p['id_mdl']." ";
			
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
				
					if($Tot_Ls > 0){
						do {
						
							if(!isN($__va)){ 
								if($__mlt == 'ok'){
									if(is_array($__va)){ $__a_ex = $__va; }else{ $__a_ex = explode(',',$__va); }
									if(in_array($row_Ls[$__v], $__va)){ $_slc = 'ok';}else{$_slc = 'no';} 
								}else{
									if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
								}
							}
							$LsBld .= HTML_OpVl([ 't'=>$row_Ls['mdlssch_nm'], 'v'=>$row_Ls[$__v], 's'=>$_slc ]);
							
						} while ($row_Ls = $Ls->fetch_assoc());	
						
						if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
						if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
						if(!isN($__lbl)){ $_lbl = $__lbl; }else{ $_lbl=FM_LS_PRD; } 
	
						
						$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>$_lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$p['attr'] ]), 'cls'=>$_cls ]);
					}
					
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
		
	}
	
	
	
	function LsClPlcy($_p=NULL){ //$__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL
		
		global $__cnx;
		
		if(!isN($_p['id'])){	
			 
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_CL_PLCY." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
						WHERE cl_enc = '".DB_CL_ENC."' {$__fl}
						ORDER BY clplcy_nm ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
						
					do {
	
						if(!isN($_p['va'])){ 
							
							if($_p['mlt'] == 'ok'){
								if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{ $_slc = 'no';} 
							}
						}
	
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['clplcy_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc, 'rel'=>$row_Ls['eml_eml']]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>TX_FMSLCPLCY, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
				}	
			
			}else{
				
				echo $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
			
		}
	}




	function LsClEml($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	
			
			if(!ChckSESS_superadm()){ 
				$__fl .= ' AND cleml_eml IN (SELECT useml_eml FROM '._BdStr(DBM).TB_US_EML.' WHERE useml_us="'.SISUS_ID.'" ) ';
			}
			
			$Ls_Qry = "	SELECT * 
						FROM  "._BdStr(DBM).TB_CL_EML." 
							 INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON cleml_eml = id_eml
							 INNER JOIN "._BdStr(DBM).TB_CL." ON cleml_cl = id_cl
						WHERE cl_enc = '".DB_CL_ENC."' {$__fl}
						ORDER BY id_cleml ASC";
						
			$Ls = $__cnx->_qry($Ls_Qry); 

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
						
					do {
	
						if(!isN($__va)){ 
							if($__mlt == 'ok'){
								if (in_array($row_Ls[$__v], explode(',',$__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
	
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['eml_nm'].' ('.$row_Ls['eml_eml'].')', 'v'=>$row_Ls[$__v], 's'=>$_slc, 'rel'=>$row_Ls['eml_eml']]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$__id, 'ph'=>'- seleccione sender -', 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls ]);
				
				}
			
			}else{
				
				echo $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	

	function LsClGrp($__id, $__v, $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL){
		
		global $__cnx;
		
		if(!isN($__id)){	

			$Ls_Qry = " SELECT * 
						FROM "._BdStr(DBM).TB_CL_GRP." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clgrp_cl = id_cl 
						WHERE id_clgrp != '' AND cl_enc = '".DB_CL_ENC."' {$__f} 
						ORDER BY clgrp_cl ASC, clgrp_nm ASC"; 

						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
				
				if($Tot_Ls > 0){
					
					do {
						
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{ $_slc = 'no'; } 
						
						$___id = $row_Ls['id_clgrp'];
						
						$___b[$___id] = [ 
											'id'=>$___id, 
											'tt'=>$_sbtt.$row_Ls['clgrp_nm'],
											'slc'=>$_slc, 
											'prnt'=>$row_Ls['clgrp_prnt']
										];
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					$__row = _bTree($___b, '', 'a');
					$__html = _LsTree($__row);
					$LsBld .= $__html;
					
				}
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_PRNT, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	
	
	function LsEcCmpg($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['id'])){

			$Ls_Qry = "	SELECT * 
						FROM ".TB_EC_CMPG."
							INNER JOIN "._BdStr(DBM).TB_CL." ON eccmpg_cl = id_cl
						WHERE cl_enc = '".DB_CL_ENC."'
						ORDER BY eccmpg_p_f DESC, eccmpg_p_h DESC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
					do {
						
						if(!isN($p['ino'])){ $__vc=$p['ino']; }else{ $__vc=$p['v']; }
						
						if(!isN($p['va'])){ 
							if($p['mlt'] == 'ok'){
								if(is_array($p['va'])){ $__a_ex = $p['va']; }else{ $__a_ex = explode(',',$p['va']); }
								if(in_array($row_Ls[$__vc], $p['va'])){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__vc], $p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['eccmpg_nm'].' ('.$row_Ls['eccmpg_p_f'].' / '.$row_Ls['eccmpg_p_h'].')', 'v'=>$row_Ls[$p['v']], 's'=>$_slc ]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					if(!isN($p['lbl'])){ $_lbl = $p['lbl']; }else{ $_lbl=FM_LS_SLCMPG; } 

					
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$p['id'], 'ph'=>$_lbl, 'rq'=>$p['rq'], 'c'=>$LsBld, 'm'=>$p['mlt'], 'attr'=>$p['attr'] ]), 'cls'=>$_cls ]);
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	
	
	function LsAtmt($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['id'])){
			
			$Ls_Qry = "	SELECT * 
						FROM ".DBA.".".TB_ATMT."
							INNER JOIN "._BdStr(DBM).TB_CL." ON atmt_cl = id_cl
						WHERE cl_enc = '".DB_CL_ENC."'
						ORDER BY atmt_fi DESC";
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']); 
					
					do {
						
						if(!isN($p['ino'])){ $__vc=$p['ino']; }else{ $__vc=$p['v']; }
						
						if(!isN($p['va'])){ 
							if($p['mlt'] == 'ok'){
								if(is_array($p['va'])){ $__a_ex = $p['va']; }else{ $__a_ex = explode(',',$p['va']); }
								if(in_array($row_Ls[$__vc], $p['va'])){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$__vc], $p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						
						$LsBld .= HTML_OpVl([ 't'=>$row_Ls['atmt_nm'].' ('.$row_Ls['atmt_fi'].')', 'v'=>$row_Ls[$p['v']], 's'=>$_slc ]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
					if(!isN($p['lbl'])){ $_lbl = $p['lbl']; }else{ $_lbl=FM_LS_SLCATMT; } 

					
					$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$p['id'], 'ph'=>$_lbl, 'rq'=>$p['rq'], 'c'=>$LsBld, 'm'=>$p['mlt'], 'attr'=>$p['attr'] ]), 'cls'=>$_cls ]);
			
			}
			
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	
	

	function LsSisCntTpGrp($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_TP_GRP." ORDER BY siscnttpgrp_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['siscnttpgrp_nm'].' ('.$row_Ls['siscnttpgrp_nm'].')', 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>TX_SLCGRP, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	// ------- Lista de vinculos con la universidad ------- //
	
	function LsSisCntTp($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){
			
			$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_TP." WHERE siscnttp_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".$_p['cl']."' ) ORDER BY siscnttp_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['siscnttp_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc, 'attr'=>['data'=>$row_Ls['siscnttp_key']] ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				
				
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$_p['ph'], 'rq'=>$_p['rq'], 'nm'=>$_p['nm'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	
	
	
	function LsAct($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id']) && !isN($_p['cl'])){ 
			
			if(!isN($_p['cl'])){ $fl .= " AND id_cl = '".$_p['cl']."' "; }
			if(!isN($_p['est'])){ $fl .= " AND act_est = '".$_p['est']."' "; }
			
			if(!isN($_p["tp"])){ 
				if(is_array($_p["tp"])){
					$fl .= sprintf(' AND acttp_mdlstp IN(%s) ',  implode(',',$_p["tp"]) );	
				}else{
					$fl .= sprintf(' AND acttp_mdlstp = %s ', GtSQLVlStr($_p["tp"], "int"));	
				}	
			}
			
			$Ls_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_ACT."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON act_cl = id_cl
							 LEFT JOIN "._BdStr(DBM).TB_ACT_TP." ON acttp_act = id_act
						WHERE id_act != '' $fl
						GROUP BY id_act
						ORDER BY id_act DESC ";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				$LsBld .= HTML_OpVl(['ct'=>'off']);
					
				do {
					
					if(!isN($_p['ino'])){ $__vc=$_p['ino']; }else{ $__vc=$_p['v']; }
					
					if(!isN($_p['va'])){ 	
						if($__mlt == 'ok'){
							if (in_array($row_Ls[$__vc], $_p['va'])){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$__vc], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
					if(!isN($_p['prfx'])){ $__prfx = '('.$row_Ls[ $_p['prfx'] ].') '; }else{ $__prfx=''; }
					$LsBld .= HTML_OpVl([ 't'=>$__prfx.$row_Ls['act_tt'], 'v'=>$row_Ls[$__vc], 's'=>$_slc, 'attr'=>$_p['attr'] ]);
					
				} while ($row_Ls = $Ls->fetch_assoc());
			
			}
				
			if(!isN($_p['lbl'])){ $__lbl = $_p['lbl']; }else{$__lbl = _MdlTx(TX_SLCACT); }	
			
			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
			$_rtrn2 = bdiv([ 'c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>$__lbl, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$_p['mlt'], 'attr'=>$_p['attr']]), 'cls'=>$_cls ]);
		
			$__cnx->_clsr($Ls);
			
			return($_rtrn2);
		}
	}

	function LsMdlSTpFm($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){	
 
			$Ls_Qry = "	SELECT * 
						FROM "._BdStr(DBM).TB_MDL_S_TP_FM." 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpfm_cl = id_cl 
						WHERE cl_enc = '".CL_ENC."' 
						ORDER BY mdlstpfm_nm ASC";
 
			$Ls = $__cnx->_qry($Ls_Qry); 
			
			if($Ls){

				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows; 
				
				if($Tot_Ls > 0){

					$LsBld .= HTML_OpVl(['ct'=>'off']);
					
					do {
		
						if(!isN($_p['va'])){ 
							if($_p['mlt'] == 'ok'){
								if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}else{
								if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
							}
						}
						$LsBld .= HTML_OpVl(['t'=>'('.$row_Ls['id_mdlstpfm'].') '.$row_Ls['mdlstpfm_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc]);
						
					} while ($row_Ls = $Ls->fetch_assoc());
							
					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{ $_cls = DV_CLSS_SLCT_BX; }
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>' - seleccione formulario - ', 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls]);
				
				}

			}

			$__cnx->_clsr($Ls);
			return($_rtrn2);
		}
	}
	
	function LsAutoTp($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "SELECT * FROM "._BdStr(DBA).TB_AUTO_TP." ORDER BY autotp_nm ASC";
			$Ls = $__cnx->_qry($Ls_Qry);
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['autotp_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if(!isN($_p['ph'])){ $ph = $_p['ph']; }else{ $ph = TX_SLC_LNG; }
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$ph, 'nm'=>$_p['nm'], 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}
	

	function LsBcoPay($_p=NULL){
		
		if(!isN($_p['id'])){
			
			$LsBld .= HTML_OpVl(['ct'=>'off']);

			$__estpay = __LsDt([ 'k'=>'gtwy_pay_est' ]);
			
			if(!isN($__estpay->ls->gtwy_pay_est)){
				
				foreach($__estpay->ls->gtwy_pay_est as $__estpay_k=>$__estpay_v){
					
					if(!isN($_p['v'])){ 
						$__id_go = $__estpay_v->{ $_p['v'] }; 
					}else{ 
						$__id_go = $__estpay_v->enc;
					}
					
					if (!(strcmp($__id_go, $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
					$LsBld .= HTML_OpVl(['t'=>ctjTx($__estpay_v->tt,'out'), 'v'=>$__id_go, 's'=>$_slc]);

				}
				
			}
			if(!isN($LsBld)){
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{ $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>$_p['ph'], 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);
			}		

			return _jEnc($_rtrn2);

		}
		
	}


	function LsGtStoreBrnd($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			$Ls_Qry = "	SELECT id_storebrnd, storebrnd_enc, storebrnd_nm
						FROM "._BdStr(DBS).TB_STORE_BRND."
                             INNER JOIN "._BdStr(DBS).TB_STORE." ON storebrnd_store = id_store 
							 INNER JOIN "._BdStr(DBM).TB_CL." ON store_cl = id_cl
						WHERE cl_enc = '".DB_CL_ENC."' 
						ORDER BY storebrnd_nm ASC";

			$Ls = $__cnx->_qry($Ls_Qry);
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
					$LsBld .= HTML_OpVl([ 't'=>$row_Ls['storebrnd_nm'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc, 'attr'=>$_p['attr'] ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if(!isN($_p['ph'])){ $ph = $_p['ph']; }else{ $ph = TX_SLC_BRND; }
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>$ph, 'nm'=>$_p['nm'], 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}

	function LsClAwsAcc($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){

			if(!isN($_p['cl'])){ $_fl .= " AND awsacc_cl='".$_p['cl']."' "; }

			$Ls_Qry = sprintf("	SELECT id_awsacc, awsacc_id
								FROM "._BdStr(DBT).TB_AWS_ACC." 
								WHERE id_awsacc != '' {$_fl} "); 

			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;
			$LsBld .= HTML_OpVl(['ct'=>'off']); 
			
				do {
					
					if(!isN($_p['va'])){ 
						if($_p['mlt'] == 'ok'){
							if (in_array($row_Ls[$_p['v']], explode(',',$_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}else{
							if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';} 
						}
					}
					
				$LsBld .= HTML_OpVl([ 't'=>$row_Ls['awsacc_id'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc ]);
				
				} while ($row_Ls = $Ls->fetch_assoc());
				
				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($_p['mlt'] == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX; }
				$_rtrn2 = bdiv([ 'c'=>HTML_Slct([ 'id'=>$_p['id'], 'ph'=>'Cuenta Amazon', 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls ]);
				
			$__cnx->_clsr($Ls);
			return($_rtrn2);
		
		}
	}



?>