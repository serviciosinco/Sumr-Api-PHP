<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					
					var SUMR_Lnd_Cdn = {
						cdn : $('#bx_lndjs_".$__Rnd."'),
						lndjsfm : {} 
					};
					
					function Dom_Rbld(){
						
						var __lndjs_bx_cdn_itm = $('#bx_lndjs_".$__Rnd." li.itm.lndjs ');
						
						__lndjs_bx_cdn_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'lnd',
								t2:'js',
								d:'cdn',
								est: est1,
								id_js: _id,
								id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
								
								_bs:function(){ SUMR_Lnd_Cdn.cdn.addClass('_ld'); },
								_cm:function(){ SUMR_Lnd_Cdn.cdn.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										ClSet(_r.lnd.js);	
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#lndjs_sch_".$__Rnd."', ls:__lndjs_bx_cdn_itm });
						
						$('input').off('click').click(function(event){
							
							event.stopPropagation();

							$(this).addClass('edt');
							var _id = $(this).parent().attr('rel');
							
							$(this).off('blur').blur(function(){
								var val = $(this).val();	
								_Rqu({ 
									t:'lnd',
									t2:'js',
									d:'edt_ord',
									id_js: _id,
									val: val,
									id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
									
									_bs:function(){ SUMR_Lnd_Cdn.cdn.addClass('_ld'); },
									_cm:function(){ SUMR_Lnd_Cdn.cdn.removeClass('_ld'); },
									_cl:function(_r){
										if(!isN(_r)){
											ClSet(_r.lnd.js);	
										}
									} 
								});	
							});
						});
					}

					function LndJs_Html(){

						SUMR_Lnd_Cdn.cdn.html('');
						SUMR_Lnd_Cdn.cdn.append('<li class=\"sch\">".HTML_inp_tx('lndjs_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						if(!isN( SUMR_Lnd_Cdn.lndjsfm['ls'] )){
							
							$.each(SUMR_Lnd_Cdn.lndjsfm['ls'], function(k, v) {
	
								if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.js) && v.js == 'ok'){ _cls = _cls+' js'; }
								if(!isN(v.css) && v.css == 'ok'){ _cls = _cls+' css'; }
								
								SUMR_Lnd_Cdn.cdn.append('<li class=\"_anm itm lndjs '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure class=\"item_fmd\"><p></p></figure><span>'+v.nm+'</span><input type=\"text\" value=\"'+v.ord+'\"> </li>');
							});	
						
						}
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
					function ClSet(p){
						if( !isN(p) ){
							if( !isN(p) ){ SUMR_Lnd_Cdn.lndjsfm['ls'] = p.ls; SUMR_Lnd_Cdn.lndjsfm['tot'] = p.tot; }
							LndJs_Html();
						}
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'lnd',
						t2:'js',
						id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								ClSet(_r.lnd.js);	
							}
						} 
					});
				";
	    ?>
	        <div class="lndjs_cdn dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2('PLUGINS'); ?>
			        <div class="_wrp">
				    	<ul id="bx_lndjs_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	  
				    </div>
		        </div>  	   
	        </div>
	        <style>
		        
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .lndjs_cdn{ text-align: center; margin-top: 10px; display: inline-block; width: 100%; }
				.lndjs_cdn ._c{ width: 100% !important; }
		        .lndjs_cdn ._c._c1 h2{ text-align: right; } 
		        .lndjs_cdn ._c h2{ text-align: center; }    
		        .lndjs_cdn ._c ul .itm.on {background-color: var(--main-bg-color); color: white;}  
		        .lndjs_cdn ._c ul .itm.on input{ display: block; }
		        
		        
		        .lndjs_cdn ._c ul .itm.js figure{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cdn_js.svg); }
		        .lndjs_cdn ._c ul .itm.css figure{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cdn_css.svg); }
		        
		        
		              
		        .lndjs_cdn .item_fmd { z-index: 999; }
		        .lndjs_cdn .item_fmd p{ height: 100%; width: 100%; }
		        
		        .lndjs_cdn .lndjs input{ width: 40px;display: inline-block;position: absolute;height: 100%;top: 0;right: 0; display: none; }
		        .lndjs_cdn ._c ul .itm span{ display: inline; }
		        
		        .lndjs_cdn .lndjs input{ color: #FFF;background: #066;border: 1px solid #033;font: 400 16px Economica;}
		        .lndjs_cdn .lndjs input.edt{ color: #000000;background: #ffffff;border: 1px solid #033;font: 400 16px Economica;}
		        
	        </style>   
		</div>
	</div>
</div>