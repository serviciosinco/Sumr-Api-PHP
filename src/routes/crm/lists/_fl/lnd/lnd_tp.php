<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					var SUMR_Lnd_Tp = {
						tp : $('#bx_lndtp_".$__Rnd."'),
						lndtpfm : {} 
					};

					
					function Dom_Rbld(){
						
						var __lndtp_bx_cdn_itm = $('#bx_lndtp_".$__Rnd." li.itm.lndtp ');
						
						__lndtp_bx_cdn_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'lnd',
								t2:'tp',
								d:'tp',
								est: est1,
								id_tp: _id,
								id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
								
								_bs:function(){ SUMR_Lnd_Tp.tp.addClass('_ld'); },
								_cm:function(){ SUMR_Lnd_Tp.tp.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										ClSet(_r.lnd.tp);	
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#lndtp_sch_".$__Rnd."', ls:__lndtp_bx_cdn_itm });

					}

					function LndTp_Html(){

						SUMR_Lnd_Tp.tp.html('');
						SUMR_Lnd_Tp.tp.append('<li class=\"sch\">".HTML_inp_tx('lndtp_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Lnd_Tp.lndtpfm['ls'], function(k, v) {

							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Lnd_Tp.tp.append('<li class=\"_anm itm lndtp '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure class=\"item_fmd\"><p></p></figure><span>'+v.nm+'</span></li>');
						});	
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
					function ClSet(p){
						if( !isN(p) ){ 
							if( !isN(p) ){ SUMR_Lnd_Tp.lndtpfm['ls'] = p.ls; SUMR_Lnd_Tp.lndtpfm['tot'] = p.tot; }
							LndTp_Html();
						}
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'lnd',
						t2:'tp',
						id_lnd : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								ClSet(_r.lnd.tp);	
							}
						} 
					});
				";
	    ?>
	        <div class="lndtp_cdn dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2('Tipo'); ?>
			        <div class="_wrp">
				    	<ul id="bx_lndtp_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	  
				    </div>
		        </div>  	   
	        </div>
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .lndtp_cdn{ text-align: center; margin-top: 10px; display: inline-block; width: 100%; }
				.lndtp_cdn ._c{ width: 100% !important; }
		        .lndtp_cdn ._c._c1 h2{ text-align: right; } 
		        .lndtp_cdn ._c h2{ text-align: center; }    
		        .lndtp_cdn ._c ul .itm.on {background-color: var(--main-bg-color); color: white;}        
		        .lndtp_cdn .item_fmd { z-index: 999; }
		        .lndtp_cdn .item_fmd p{ height: 100%; width: 100%; }
		        .lndtp_cdn .lndtp input{ width: 40px;display: inline-block;position: absolute;height: 100%;top: 0;right: 0; }
		        .lndtp_cdn ._c ul .itm span{ display: inline; }
		        .lndtp_cdn .lndtp input{ color: #FFF;background: #066;border: 1px solid #033;font: 400 16px Economica;}
		        .lndtp_cdn .lndtp input.edt{ color: #000000;background: #ffffff;border: 1px solid #033;font: 400 16px Economica;}
		        
	        </style>   
		</div>
	</div>
</div>