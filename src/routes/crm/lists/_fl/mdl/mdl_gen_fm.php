<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					var SUMR_Mdl_Gen_Fm = {
						mdlfm : $('#bx_mdlfm_".$__Rnd."'),
						mdlgenfm : {} 
					}; 
					
					function Dom_Rbld(){
						
						var __clmdl_bx_mdlfm_itm = $('#bx_mdlfm_".$__Rnd." li.itm.mdlfm ');
						var __clmdl_bx_fm_mdlfm = $('#bx_fm_mdlfm_".$__Rnd."');
						
						__clmdl_bx_mdlfm_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'mdl_gen', 
								d:'mdl_gen_mdlfm',
								est: est1,
								_id_mdlfm : _id,
								_id_mdlgen : '".Php_Ls_Cln($___Ls->gt->isb)."',
								
								_bs:function(){ SUMR_Mdl_Gen_Fm.mdlfm.addClass('_ld'); },
								_cm:function(){ SUMR_Mdl_Gen_Fm.mdlfm.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl.mdlgen.mdlfm);			
										}
									}
								} 
							});
						});
						
						$('.item_fmd p').click(function(event){
					    	event.stopPropagation();
					    	var _enc = $(this).parent().parent().attr('rel');
					    	
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
					    });

						SUMR_Main.LsSch({ str:'#mdlfm_sch_".$__Rnd."', ls: __clmdl_bx_mdlfm_itm });
						
					}
					
					
					
					function ClMdlGenFm_Html(){

						SUMR_Mdl_Gen_Fm.mdlfm.html('');
						SUMR_Mdl_Gen_Fm.mdlfm.append('<li class=\"sch\">".HTML_inp_tx('mdlfm_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Mdl_Gen_Fm.mdlgenfm['ls'], function(k, v) {

							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Mdl_Gen_Fm.mdlfm.append('<li class=\"_anm itm mdlfm '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure class=\"item_fmd\"><p></p></figure><span>'+v.nm+'</span></li>');
						});	
						
						$('#tot_mdlfm_".$__Rnd."').html( SUMR_Mdl_Gen_Fm.mdlgenfm['tot'] );
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
					function ClSet(p){
						if( !isN(p) ){ 
							if( !isN(p) ){ SUMR_Mdl_Gen_Fm.mdlgenfm['ls'] = p.ls; SUMR_Mdl_Gen_Fm.mdlgenfm['tot'] = p.tot; }
							ClMdlGenFm_Html();
						}
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'mdl_gen', 
						t2:'".$___Ls->gt->tsb."',
						_id_mdlgen : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.cl)){
									ClSet(_r.cl.mdlgen.mdlfm);			
								}
							}
						} 
					});
				";
	    ?>
	        <div class="cl_mdl_gen_mdlfm dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2(TX_FM); ?>
			        <div class="_wrp">
				    	<ul id="bx_mdlfm_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_mdlfm" id="bx_fm_mdlfm_<?php echo $__Rnd; ?>"></div>   
				    </div>
		        </div>  	   
	        </div>
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .cl_mdl_gen_mdlfm{ text-align: center; margin-top: 10px; display: flex; }
				.cl_mdl_gen_mdlfm ._c{ width: 100% !important; }
		        .cl_mdl_gen_mdlfm ._c._c1 h2{ text-align: right; } 
		        .cl_mdl_gen_mdlfm ._c h2{ text-align: center; }  
		        
		        .cl_mdl_gen_mdlfm ._c ul .itm.on {background-color: var(--main-bg-color); color: white;}
		        
		        .cl_mdl_gen_mdlfm .item_fmd { z-index: 999; }
		        .cl_mdl_gen_mdlfm .item_fmd p{ height: 100%; width: 100%; }
	        </style>   
		</div>
  </div>
</div>