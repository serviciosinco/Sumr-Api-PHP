<div class="FmTb">
    <div id="<?php  echo DV_GNR_FM ?>">
    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	        <?php
		        
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
	
				$CntJV .= " 
				
					var SUMR_Eml_Are = {
						bx_are:$('#bx_are_".$__Rnd."'),
						emlare: {}
					};
					
					function EmlAre_Dom_Rbld(){
						
						var __mdls_bx_sch_itm = $('#bx_are_".$__Rnd." > li.itm ');
	
						__mdls_bx_sch_itm.not('.sch').off('click').click(function(){
							
							var est = $(this).hasClass('on') ? 'del' : 'ok'; 		
							var _id = $(this).attr('rel');
	
							_Rqu({ 
								t:'eml', 
								d:'are',
								est:est,
								eml_enc : '".Php_Ls_Cln($__i)."',
								id_are : _id,
								_bs:function(){ SUMR_Eml_Are.bx_are.addClass('_ld'); },
								_cm:function(){ SUMR_Eml_Are.bx_are.removeClass('_ld'); },
								_cl:function(_r){ 
									if(!isN(_r)){ 
										if(!isN(_r.eml)){
											EmlAreSet(_r.eml);			
										}
									}
								} 
							});
							
						});
						
						SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:__mdls_bx_sch_itm });
					
					}

					function EmlAre_Html(){
			
						SUMR_Eml_Are.bx_are.html('');
						SUMR_Eml_Are.bx_are.append('<li class=\"sch fll\">".HTML_inp_tx('sch_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."');
						
						if(!isN(SUMR_Eml_Are.emlare['ls'])){
							$.each(SUMR_Eml_Are.emlare['ls'], function(k, v) { 
								if(!isN(v.tot) && v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								SUMR_Eml_Are.bx_are.append('<li class=\"_anm itm are '+_cls+'\" are-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span></li>');
							});	
						}
						
						EmlAre_Dom_Rbld();
					}
	
				";
				
				$CntJV .= "
				
					function EmlAreSet(p){
						if( !isN(p) ){
							SUMR_Eml_Are.emlare['ls'] = p.are.ls; 
							EmlAre_Html();
						}
						EmlAre_Dom_Rbld();
					}
				";
	
				$CntJV .= " 
				
					_Rqu({ 
						t:'eml', 
						eml_enc : '".Php_Ls_Cln($__i)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.eml)){
									EmlAreSet(_r.eml);
								}
							}
						} 
					});
				";
	    ?>
	        
	        <div class="are_eml_dsh dsh_cnt">
		        <div class="_c _c1 _anm ">
			        <?php echo h2(TX_ARE); ?>
			        <div class="_wrp">
				    	<ul id="bx_are_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_opt_<?php echo $__Rnd; ?>"></div>	 
			        </div>
		        </div>
		    </div>  
	        <style>   
		        .are_eml_dsh{ text-align: center; margin-top: 10px; display: flex; }
				.are_eml_dsh ._c{ width: 100%; }
		        .are_eml_dsh ._c._c1{ width: 100% !important; } 
		        .are_eml_dsh ._c h2{ text-align: center; }
			    #bx_are_<?php echo $__Rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);}
			    #bx_are_<?php echo $__Rnd ?> li._anm.itm.off{ opacity: 0.5; }
			    #bx_are_<?php echo $__Rnd ?> li._anm.itm.off:hover{ opacity: 1; }    
		    </style>      
      	</div>
  	</div>
</div>