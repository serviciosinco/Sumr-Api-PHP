<?php 
	
	$r['e'] = 'ok';
    
    
    //$__sve_dt = _SvWdgtTrck([ 'id'=>$_wdgt_dt->id, 'u'=>$_SERVER['HTTP_REFERER'] ]);
    
    
    if(!isN($_wdgt_dt->act)){
    	
    	foreach($_wdgt_dt->act as $_act_k=>$_act_v){
	    	if(!isN($_act_v)){
		    	foreach($_act_v as $_lne_k=>$_lne_v){
			    	if($_lne_v->e == 'ok'){
	    				$_srv[ $_act_k ]['lines'][$_lne_v->id] = $_lne_v;
	    			}
	    		}
	    	}
    	}
    	
	    $r['services'] = $_srv;
    
    }
    
    if($_wdgt_dt->pst->top->e == 'ok'){ $r['class'] .= 'smr_dsk_top '; }
    if($_wdgt_dt->pst->right->e == 'ok'){ $r['class'] .= 'smr_dsk_right '; }
    if($_wdgt_dt->pst->bottom->e == 'ok'){ $r['class'] .= 'smr_dsk_bottom '; }
    if($_wdgt_dt->pst->left->e == 'ok'){ $r['class'] .= 'smr_dsk_left '; }
    

    if(!isN($_wdgt_dt->pst->top->v)){ $r['root']['dsk'] .= '--sumr-dsk-left:'.$_wdgt_dt->pst->top->v.'px;'; }
    if(!isN($_wdgt_dt->pst->right->v)){ $r['root']['dsk'] .= '--sumr-dsk-right:'.$_wdgt_dt->pst->right->v.'px;'; }
    if(!isN($_wdgt_dt->pst->bottom->v)){ 
	    $r['root']['dsk'] .= '--sumr-dsk-bottom:'.$_wdgt_dt->pst->bottom->v.'px;';
	    $r['root']['dsk'] .= '--sumr-opt-bottom:'.($_wdgt_dt->pst->bottom->v + 60).'px;'; 
	}
    if(!isN($_wdgt_dt->pst->left->v)){ $r['root']['dsk'] .= '--sumr-dsk-left:'.$_wdgt_dt->pst->left->v.'px;'; }
    
    
    
    if($_wdgt_dt->pst->mbl->top->e == 'ok'){ $r['class'] .= 'smr_mbl_top '; }
    if($_wdgt_dt->pst->mbl->right->e == 'ok'){ $r['class'] .= 'smr_mbl_right '; }
    if($_wdgt_dt->pst->mbl->bottom->e == 'ok'){ $r['class'] .= 'smr_mbl_bottom '; }
    if($_wdgt_dt->pst->mbl->left->e == 'ok'){ $r['class'] .= 'smr_mbl_left '; }
    
    
    if(!isN($_wdgt_dt->pst->mbl->top->v)){ $r['root']['mbl'] .= '--sumr-mbl-left:'.$_wdgt_dt->pst->mbl->top->v.'px;'; }
    if(!isN($_wdgt_dt->pst->mbl->right->v)){ $r['root']['mbl'] .= '--sumr-mbl-right:'.$_wdgt_dt->pst->mbl->right->v.'px;'; }
    if(!isN($_wdgt_dt->pst->mbl->bottom->v)){ 
	    $r['root']['mbl'] .= '--sumr-mbl-bottom:'.$_wdgt_dt->pst->mbl->bottom->v.'px;'; 
	    $r['root']['mbl'] .= '--sumr-mbl-opt-bottom:'.($_wdgt_dt->pst->mbl->bottom->v + 60).'px;'; 
	}
    if(!isN($_wdgt_dt->pst->mbl->left->v)){ $r['root']['mbl'] .= '--sumr-mbl-left:'.$_wdgt_dt->pst->mbl->left->v.'px;'; }
    
    
    
    
    if($_wdgt_dt->puff == 'ok'){ $r['class'] .= 'smr_dsk_puff '; } 
    if($_wdgt_dt->mbl->puff == 'ok'){ $r['class'] .= 'smr_mbl_puff '; }
    
    
    if($_wdgt_dt->shwtt == 'ok'){ $r['class'] .= 'smr_dsk_shwtt '; } 
    if($_wdgt_dt->mbl->shwtt == 'ok'){ $r['class'] .= 'smr_mbl_shwtt '; }
    
    
    $r['powered'] = $_wdgt_dt->pwd;
    $r['puff'] = $_wdgt_dt->puff;
    $r['shwtt'] = $_wdgt_dt->shwtt;
    
    $r['mbl']['powered'] = $_wdgt_dt->mbl->pwd;
    $r['mbl']['puff'] = $_wdgt_dt->mbl->puff;
    $r['mbl']['shwtt'] = $_wdgt_dt->mbl->shwtt;
    
    
    
    $r['reseller'] = $_wdgt_dt->rsllr;

    
    $r['img']['start'] = $_wdgt_dt->img->big;
    
    
    
    if(!isN($_wdgt_dt->clr)){
	    
	    $r['clr']['start'] = $_wdgt_dt->clr->strt;
	    $r['clr']['header'] = $_wdgt_dt->clr->hdr;
    
    }
    
    
    if(!isN($_wdgt_dt->tx)){
	    
	    $r['tx']['button_title'] = $_wdgt_dt->tx->btn_tt;
	    $r['tx']['popup_title'] = $_wdgt_dt->tx->pop_tt;
	    $r['tx']['popup_intro'] = $_wdgt_dt->tx->pop_intro;
		$r['tx']['callme_placeholder'] = $_wdgt_dt->tx->call_ph;
    
    }
    
         
?>