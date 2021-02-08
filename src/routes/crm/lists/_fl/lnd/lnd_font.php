<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
					
					var SUMR_Lnd_Font = {
						font : $('#bx_lndfont_".$__Rnd."'),
						lndfontfm : {} 
					};
					
					function Dom_Rbld(){
						
						var __lndfont_bx_cdn_itm = $('#bx_lndfont_".$__Rnd." li.itm.lndfont ');
						
						__lndfont_bx_cdn_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'lnd',
								t2:'font',
								d:'font',
								est: est1,
								id_font: _id,
								id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
								
								_bs:function(){ SUMR_Lnd_Font.font.addClass('_ld'); },
								_cm:function(){ SUMR_Lnd_Font.font.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										ClSet(_r.lnd.font);	
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#lndfont_sch_".$__Rnd."', ls:__lndfont_bx_cdn_itm });

					}

					function LndFont_Html(){

						SUMR_Lnd_Font.font.html('');
						SUMR_Lnd_Font.font.append('<li class=\"sch\">".HTML_inp_tx('lndfont_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Lnd_Font.lndfontfm['ls'], function(k, v) {

							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Lnd_Font.font.append('<li class=\"_anm itm lndfont '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure class=\"item_fmd\"><p></p></figure><span>'+v.nm+'</span></li>');
						});	
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
					function ClSet(p){
						if( !isN(p) ){
							if( !isN(p) ){ SUMR_Lnd_Font.lndfontfm['ls'] = p.ls; SUMR_Lnd_Font.lndfontfm['tot'] = p.tot; }
							LndFont_Html();
						}
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'lnd',
						t2:'font',
						id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								ClSet(_r.lnd.font);
							}
						} 
					});
				";
	    ?>
	        <div class="lnd_font dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2('FONTS'); ?>
			        <div class="_wrp">
				    	<ul id="bx_lndfont_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	  
				    </div>
		        </div>  	   
	        </div>
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .lnd_font{ text-align: center; margin-top: 10px; display: inline-block; width: 100%; }
				.lnd_font ._c{ width: 100% !important; }
		        .lnd_font ._c._c1 h2{ text-align: right; } 
		        .lnd_font ._c h2{ text-align: center; }    
		        .lnd_font ._c ul .itm.on {background-color: var(--main-bg-color); color: white;}        
		        .lnd_font .item_fmd { z-index: 999; }
		        .lnd_font .item_fmd p{ height: 100%; width: 100%; }
		        .lnd_font .lndfont input{ width: 40px;display: inline-block;position: absolute;height: 100%;top: 0;right: 0; }
		        .lnd_font ._c ul .itm span{ display: inline; }
		        .lnd_font .lndfont input{ color: #FFF;background: #066;border: 1px solid #033;font: 400 16px Economica;}
		        .lnd_font .lndfont input.edt{ color: #000000;background: #ffffff;border: 1px solid #033;font: 400 16px Economica;}
		        
	        </style>   
		</div>
	</div>
</div>