<?php 
	
	function Dsh_Dte($p=NULL){
		$a = array_unique($p['a']);

		foreach($a as $_k=>$_v){
			if($_min_now == ''){ $_min_now = $_v; }elseif($_v < $_min_now){  $_min_now = $_v; }
			if($_max_now == ''){ $_max_now = $_v; }elseif($_v >= $_max_now){  $_max_now = $_v; }
			$dte_rnge[$_v] = $_v;
		}
		
		foreach($dte_rnge as $_k=>$_v){
			$r['date']['rango'][] =	$_v;
		}
		
		$r['date']['min'] = $_min_now;
		$r['date']['max'] = $_max_now;
		
		
		return _jEnc($r);
	}
	
	function Dsh_Bld($p=NULL){
		
		if($p['graphic'] == 1){
	
			foreach($p['name'] as $_k => $_v){
				if($_v['data'] != '' && $_v['data'] != NULL){
					$r['js']['v'][ ] = array('name'=>$_v['name'].$_v['id'], 'data'=>$_v['data'], 'color'=>$_v['color']);
				}
			}
	
		}elseif($p['graphic'] == 3 || $p['graphic'] == 4){
					
			$_fetch_c = Dsh_Dte(array( 'a'=>$p['categories'] ));
			for($i=strtotime($_fetch_c->date->min); $i<=strtotime($_fetch_c->date->max); $i=$i+86400){
			    $_k_d = date('Y-m-d',$i);
			    foreach($p['name'] as $_k => $_v){
					$_js_series_s[ $_v['id'] ][ $_k_d ] = $p['series'][$_k_d][ $_v['id'] ]!=''?$p['series'][$_k_d][ $_v['id'] ]:0;
			    } 
			}
				
			foreach($p['name'] as $_k => $_v){
				foreach($_js_series_s[$_v['id']] as $k2=>$v2){ $_js_series_s2[$_v['id']][] = $v2; }
				if($_v['name'] != '' && $_v['name'] != NULL){
					$r['js']['v'][ ] = array('name'=>$_v['name'], 'data'=>$_js_series_s2[$_v['id']], 'color'=>$_v['color']);
				}
			}	
	
		}
		
		$r['js']['c'] = $_fetch_c->date->rango;
		return _jEnc($r);		
	
	}
	
?>