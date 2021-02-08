<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					var SUMR_Mdl_S_Prd_Tp = {
						prdtp : $('#bx_prdtp_".$__Rnd."'),
						mdlsprdtp : {} 
					}; 
					
					function Dom_Rbld(){
						
						var __clmdl_bx_prdtp_itm = $('#bx_prdtp_".$__Rnd." li.itm.prdtp ');
						var __clmdl_bx_fm_prdtp = $('#bx_fm_prdtp_".$__Rnd."');
						
						__clmdl_bx_prdtp_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'mdl_s_prd_tp', 
								d:'mdl_s_prdtp',
								est: est1,
								_id_prdtp : _id,
								_id_mdlprd : '".Php_Ls_Cln($___Ls->gt->isb)."',
								
								_bs:function(){ SUMR_Mdl_S_Prd_Tp.prdtp.addClass('_ld'); },
								_cm:function(){ SUMR_Mdl_S_Prd_Tp.prdtp.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl.prdtp);			
										}
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#prdtp_sch_".$__Rnd."', ls: __clmdl_bx_prdtp_itm });
						
					}
					
					function MdlSPrdTp_Html(){
						
						SUMR_Mdl_S_Prd_Tp.prdtp.html('');
						SUMR_Mdl_S_Prd_Tp.prdtp.append('<li class=\"sch\">".HTML_inp_tx('prdtp_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Mdl_S_Prd_Tp.mdlsprdtp['ls'], function(k, v) {

							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Mdl_S_Prd_Tp.prdtp.append('<li class=\"_anm itm prdtp '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure class=\"item_fmd\"><p></p></figure><span>'+v.nm+'</span></li>');
						});	
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
					function ClSet(p){
						if( !isN(p) ){ 
							if( !isN(p) ){ SUMR_Mdl_S_Prd_Tp.mdlsprdtp['ls'] = p.ls; SUMR_Mdl_S_Prd_Tp.mdlsprdtp['tot'] = p.tot; }
							MdlSPrdTp_Html();
						}
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'mdl_s_prd_tp', 
						t2:'".$___Ls->gt->tsb."',
						_id_mdlprd : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.cl)){
									console.log(_r.cl.prdtp);
									ClSet(_r.cl.prdtp);	
								}
							}
						} 
					});
				";
	    ?>
	        <div class="mdl_s_prd_tp dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2('Tipo de Modulo'); ?>
			        <div class="_wrp">
				    	<ul id="bx_prdtp_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_prdtp" id="bx_fm_prdtp_<?php echo $__Rnd; ?>"></div>   
				    </div>
		        </div>  	   
	        </div>
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .mdl_s_prd_tp{ text-align: center; margin-top: 10px; display: flex; }
				.mdl_s_prd_tp ._c{ width: 100% !important; }
		        .mdl_s_prd_tp ._c._c1 h2{ text-align: right; } 
		        .mdl_s_prd_tp ._c h2{ text-align: center; }     
		        .mdl_s_prd_tp ._c ul .itm.on {background-color: var(--main-bg-color); color: white;}       
		        .mdl_s_prd_tp .item_fmd { z-index: 999; }
		        .mdl_s_prd_tp .item_fmd p{ height: 100%; width: 100%; }
	        </style>   
		</div>
  	</div>
</div>