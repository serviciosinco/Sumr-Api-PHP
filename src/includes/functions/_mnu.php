<?php 
	
	
	function _BldMnu($p=NULL, $s=NULL, $o=NULL){
 		
		foreach($p as $mn_v){
			
			$_attr_pop = '';
			$_attr_pop_w = '';
			$_attr_pop_h = '';
			$__tt_btn = defined($mn_v->cns)?_Cns($mn_v->cns):'-'.$mn_v->cns.'-';
			
			$__tt_img = 'background-image:url('.$mn_v->img.');'; 
			$__allw = 'ok';
			
			if($mn_v->chckmd == 'ok' && !isN($mn_v->chckmd_v)){  if(!_ChckMd(trim($mn_v->chckmd_v))){ $__allw = 'no'; }; } 
			if($mn_v->spradmn == 'ok'){  if(!ChckSESS_superadm()){ $__allw = 'no'; }; }
			
			if($s!=NULL){ $__cls_sub = ' _sub '; }else{ $__cls_top = '_mtop'; }
			
			
			//-------------- MENU CLIENTE --------------//
				
				if($__allw == 'ok'){
					
					if($mn_v->shct == 'ok'){ $__cnt = 's'; }elseif($mn_v->main == 'ok'){ $__cnt = 'm'; }else{ $__cnt = 'b'; }
					
					if($s!=NULL || $mn_v->shct == 'ok'){ $__tt_btn_g=$__tt_btn; }else{ $__tt_btn_g='<div class="tt-mbl">'.$__tt_btn.'</div>'; }
					
					if(!isN($o['clr_bck'])){ $__tt_clr .= 'background-color:'.$o['clr_bck'].';'; }
					if(!isN($o['clr_fnt'])){ $__tt_clr .= 'color:'.$o['clr_fnt'].';'; }
					if(!isN($mn_v->clr_bck)){ $__tt_sty = 'color:'.$mn_v->clr_bck.';'; }else{ $__tt_sty=''; }	

						
					${'__html_'.$__cnt} .= '<li style="'.$__tt_clr.'">';
					
					if($mn_v->pop == 'ok'){
						$_attr_pop=' pop="ok" ';
						if(!isN($mn_v->pop_w)){ $_attr_pop_w=' pop-w="'.$mn_v->pop_w.'" '; }else{$_attr_pop_w='';}
						if(!isN($mn_v->pop_h)){ $_attr_pop_h=' pop-h="'.$mn_v->pop_h.'" '; }else{$_attr_pop_h='';}
					}else{
						$_cls_pop_w='';
					}

					if($mn_v->cche == 'ok'){ $_s_cache='s-cache="ok"'; }else{ $_s_cache=''; }
					
					${'__html_'.$__cnt} .= '<a href="'.VoId().'" rel="'.$mn_v->rel.'" rel-sub="'.$mn_v->rel_sub.'" rel-tp="'.$mn_v->rel_tp.'" rel-data="'.$mn_v->rel_data.'" '.$_s_cache.' class="'.$mn_v->cls_l.' '.$__cls_top.'" '.$_attr_pop.$_attr_pop_w.$_attr_pop_h.'>'.bdiv(['cls'=>'mn-icon _cstm '.$__cls_sub.' '.$mn_v->cls_i, 'sty'=>$__tt_img]) . $__tt_btn_g .'</a>';
					
					if(!isN($mn_v->rel_sub)){ $_tt_rel_sub='_'.$mn_v->rel_sub; }else{ $_tt_rel_sub=''; }
					if(!isN($mn_v->rel_tp)){ $_tt_rel_tp='_'.$mn_v->rel_tp; }else{ $_tt_rel_tp=''; }
					if(!isN($mn_v->rel_data)){ $_tt_rel_data='_'.$mn_v->rel_data; }else{ $_tt_rel_data=''; }
					
					$__html_tt .= bdiv([ 'c'=>$__tt_btn, 'id'=>'tt_'.$mn_v->rel.$_tt_rel_sub.$_tt_rel_tp, 'cls'=>'', 'sty'=>$__tt_sty ]);
					
					if($mn_v->sub != NULL){
						
						if(!isN($mn_v->clr_fnt)){ $__clr_fnt = $mn_v->clr_fnt; }else{ $__clr_fnt=NULL; }
						if(!isN($mn_v->clr_bck)){ $__clr_bck = $mn_v->clr_bck; }else{ $__clr_bck=NULL; }
									
						${'__html_'.$__cnt} .= '<ul>';
						$__chld = _BldMnu($mn_v->sub, 'sub', [ 'clr_fnt'=>$__clr_fnt, 'clr_bck'=>$__clr_bck ] ); 
						${'__html_'.$__cnt} .= $__chld->b;
						${'__html_'.$__cnt} .= '</ul>';
					}
				
					${'__html_'.$__cnt} .= '</li>';
					
				}
			
			//-------------- MENU CLIENTE --------------//
				
		}
		
		
		$__html_tt .= bdiv(['c'=>TX_TRA, 'id'=>'tt_tra', 'cls'=>'']);
		$__html_tt .= bdiv(['c'=>TX_SHCT, 'id'=>'tt_sht', 'cls'=>'']);
		
		$_r['b'] = $__html_b;
		$_r['s'] = $__html_s;
		$_r['m'] = $__html_m;
		$_r['t'] = $__html_tt;
			
		return _jEnc($_r);
	}
	
	
?>