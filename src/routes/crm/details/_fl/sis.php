<?php 
if(class_exists('CRM_Cnx')){
	
	
	$__mnu_rnd = '__mnu_'.Gn_Rnd(20);
	
	
	
	//echo json_encode($_mnu_sis);
	
	${$__mnu_rnd} = json_decode($_mnu_sis);
	
	function _BldTab($p=NULL){
		
		$_oi=1;
		
		if(!isN($p['lvl'])){ $_lvl=$p['lvl']; }else{ $_lvl=1; }
		
		foreach($p['c'] as $mn_v){ 
			
			$__allw = 'ok';
			$__tt_btn = defined($mn_v->cns)?_Cns($mn_v->cns):'-'.$mn_v->cns.'-';		
				
			$__tt_img = $mn_v->img;
			if($mn_v->chckmd == 'ok'){  if(!_ChckMd($mn_v->chckmd_v)){ $__allw = 'no'; }; }
			
			//-------------- MENU SISTEMA --------------//
				
				if($__allw == 'ok'){
					
					if(!isN($p['itemf'])){	
						$obj_a[$_oi]=$p['itemf'];
						$obj_a[$_oi]['lvl'] = $_lvl; 
						$p['itemf'] = NULL;
						$_oi++;		
					}
					
					$__id_rnd = Gn_Rnd(20); 
					
					if($_oi==1 && $_lvl==1){ 
						$_r['f_clck'] = TBGRP. $mn_v->cls.'_'.$__id_rnd;
					}
					
					$obj_a[$_oi]['id'] = $__id_rnd;
					$obj_a[$_oi]['tt'] = $__tt_btn;
					$obj_a[$_oi]['img'] = $__tt_img;
					$obj_a[$_oi]['lvl'] = $_lvl; 
					
					if($_oi==1 && $p['fld']=='ok' && $_lvl < 3){ 
						$obj_a[$_oi]['l'] = 'ok';
					}
					
					if(!isN($mn_v->sub)){
						
						if($_oi==1 && $p['fld']!='ok'){ $_f_ld = 'ok'; }else{ $_f_ld = 'no'; }
						
						$obj_a[$_oi]['tbs'] = $mn_v->cls; // Subcontent Tab
						$obj_a[$_oi]['tbs_sis'] = 'ok'; // Tab de Sistema
						$obj_a[$_oi]['tbs_go'] = $mn_v->rel; // Subcontent Tab Go
						$obj_a[$_oi]['tbs_go_s'] = $mn_v->rel_sub; // Subcontent Tab Go
						$obj_a[$_oi]['tbs_go_t'] = $mn_v->rel_tp; // Subcontent Type Tab Go
						$obj_a[$_oi]['tbs_go_d'] = $mn_v->rel_data; // Subcontent Type Tab Go
						
						if($_lvl > 1){ 
							$itemf=$obj_a[$_oi]; 
							$itemf['tb'] = $mn_v->cls;
							$itemf['dp'] = 'ok'; // Duplicated on first tab next
						}
						
						$__chld = _BldTab([ 
											'c'=>$mn_v->sub, 
											'itemf'=>$itemf, 
											'fld'=>$_f_ld, 
											'lvl'=>($_lvl+1), 
											'sub'=>'ok' 
										]);
										 
						$obj_a[$_oi]['sb'] = $__chld->a;
							
					}else{
						
						$obj_a[$_oi]['tb'] = $mn_v->cls; // Single Tab
						$obj_a[$_oi]['tbs_go_s'] = $mn_v->rel_sub; // Subcontent Tab Go
						$obj_a[$_oi]['tbs_go_t'] = $mn_v->rel_tp; // Subcontent Type Tab Go
						$obj_a[$_oi]['tbs_go_d'] = $mn_v->rel_data; // Subcontent Type Tab Go
						$obj_a[$_oi]['tbs_sis'] = 'ok'; // Tab de Sistema
						
					}
				
				}	
			
				$_oi++;
				
			//-------------- MENU SISTEMA --------------//
				
		}

		$_r['a'] = $obj_a;
			
		return _jEnc($_r);
	}
	
	$__html = _BldTab([ 'c'=>${$__mnu_rnd} ]);
	
?>
<div class="Cvr_Sis">
	  
    <div class="_ln">
            <?php
	            
	       		$__d2 = __b_tbd( $__html->a, ['frst'=>'ok','mny'=>'ok'] );
	       		echo $__d2->html;
	       		$CntJV .= $__d2->js;
				
				$CntJV .= "
					
					SUMR_Main.bxajx.___tbd_mny_e = 'no';
					
					function ___tbd_mny(p){
						
						if(!isN(p) && !isN(p.e) && p.e == 'o'){
							$('.Cvr_Sis .TabbedPanelsContent .VTabbedPanels').addClass('mny');
							SUMR_Main.bxajx.___tbd_mny_e = 'ok';
						}else{
							$('.Cvr_Sis .TabbedPanelsContent .VTabbedPanels').removeClass('mny');
							SUMR_Main.bxajx.___tbd_mny_e = 'no';
						}
					}
					
					$('.Cvr_Sis .TabbedPanelsContent .VTabbedPanels .TabbedPanelsTab').click(function(){
						
						___tbd_mny({ e:'o' });
						
					});
							
					
					$('#mny".$__mnu_rnd."').off('click').click(function(){
						if(SUMR_Main.bxajx.___tbd_mny_e == 'ok'){
							___tbd_mny();
						}else{
							___tbd_mny({ e:'o' });	
						}
					});
					
					
					
				";
				
				
				if(!isN($__html->f_clck)){
					
					$CntWb .= " 
					
						setTimeout(function(){ 
							document.getElementById('".$__html->f_clck."').click();
						}, 300);
						
					";	
					
				}
				
			?>	
    </div>						
</div>                                                                  
<?php  } ?>
