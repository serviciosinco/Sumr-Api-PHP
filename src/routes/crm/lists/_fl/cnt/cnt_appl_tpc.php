<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					var SUMR_Mdl_Fm = {
						bx_cntappltpc : $('#bx_cntappltpc_".$__Rnd."'),
						cntappltpc : {} 
					}; 

					function Dom_Rbld(){
						
						var __clmdl_bx_cntappltpc_itm = $('#bx_cntappltpc_".$__Rnd." li.itm.mdlfm ');
						
						__clmdl_bx_cntappltpc_itm.not('.sch').off('click').click(function(){
							
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 
									
							var _id = $(this).attr('rel');
							
							_Rqu({ 
								t:'cnt_appl_tpc', 
								t2:'fm',
								d:'fm',
								est: est1,
								tpc_enc : _id,
								cntappl_enc : '".Php_Ls_Cln($___Ls->gt->isb)."',
								
								_bs:function(){ SUMR_Mdl_Fm.bx_cntappltpc.addClass('_ld'); },
								_cm:function(){ SUMR_Mdl_Fm.bx_cntappltpc.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										CntApplTpcSet(_r.tpc);
									}
								} 
							});
						});
						
						/*$('.item_fmd p').click(function(event){
					    	event.stopPropagation();
					    	var _enc = $(this).parent().parent().attr('rel');
					    	alert(2);
							_ldCnt({
						        u:'".FL_LS_GN.__t('mdl_s_tp_fm', true)."&_i='+_enc+'&_bld=mdl_gen".TXGN_ING.Fl_i($___Ls->gt->i).'&_m=130&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall."',
								c:'',
								pop:'ok',
								pnl:{
									e:'ok',
									s:'l',
									tp:'h'
								}
							});
					    });*/

						SUMR_Main.LsSch({ str:'#mdlfm_sch_".$__Rnd."', ls:__clmdl_bx_cntappltpc_itm });
						
					}

					function ClMdlFm_Html(){

						SUMR_Mdl_Fm.bx_cntappltpc.html('');
						SUMR_Mdl_Fm.bx_cntappltpc.append('<li class=\"sch\">".HTML_inp_tx('mdlfm_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Mdl_Fm.cntappltpc['ls'], function(k, v) {

							if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Mdl_Fm.bx_cntappltpc.append('
																<li class=\"_anm itm mdlfm '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\">
																	<figure style=\"background-image:url(".DMN_FLE_TPC."'+v.img+')\" class=\"item_fmd\"><p></p></figure>
																	<span>'+v.nm+'</span>
																</li>
															');
						
						});	
						
						$('#tot_mdlfm_".$__Rnd."').html( SUMR_Mdl_Fm.cntappltpc['tot'] );
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
					function CntApplTpcSet(p){
						
						try{
							if( !isN(p) ){
								SUMR_Mdl_Fm.cntappltpc = {}; 
								if( !isN(p) ){ SUMR_Mdl_Fm.cntappltpc['ls'] = p.ls; SUMR_Mdl_Fm.cntappltpc['tot'] = p.tot; }
								ClMdlFm_Html();
							}
						}catch(e) {
							SUMR_Main.log.f({ t:'Error en CntApplTpcSet', m:e });
						}
						
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'cnt_appl_tpc', 
						t2:'fm',
						cntappl_enc : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.tpc)){
									CntApplTpcSet(_r.tpc);
								}
							}
						} 
					});
				";
	    ?>
	        <div class="cnt_appltpc dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2(TX_TPC); ?>
			        <div class="_wrp">
				    	<ul id="bx_cntappltpc_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    </div>
		        </div>  	   
	        </div>
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .cnt_appltpc{ text-align: center; margin-top: 10px; display: inline-block; width: 100%; }
				.cnt_appltpc ._c{ width: 100% !important; }
		        .cnt_appltpc ._c._c1 h2{ text-align: right; } 
		        .cnt_appltpc ._c h2{ text-align: center; }  
		        
		        .cnt_appltpc figure{ background-size: 20px; }
		        
		        .cnt_appltpc ._c ul .itm.on {background-color: var(--main-bg-color); color: white;}
		        
		        .cnt_appltpc .item_fmd { z-index: 999; }
		        .cnt_appltpc .item_fmd p{ height: 100%; width: 100%; }
		        .__lve{ width: 59%; display: inline-block;vertical-align: top}
	        </style>   
		</div>
  </div>
</div>