<div class="FmTb">
    <div id="<?php  echo DV_GNR_FM ?>">     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <?php

			$CntJV .= " 
			
				__orglcl_bx_sch = $('#bx_org_lcl_".$__Rnd."');

				function OrgLcl_Dom_Rbld(){
					
                    __orglcl_bx_sch_itm = $('#bx_org_lcl_".$__Rnd." > li.itm ');
                    
					__orglcl_bx_sch_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'org_sds_arr_lcl', 
							d:'lcl',
							est:est,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_id_lcl : _id,
							_bs:function(){ __orglcl_bx_sch.addClass('_ld'); },
							_cm:function(){ __orglcl_bx_sch.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.er) && !isN(_r.er.msj)){   
                                        swal({ 
                                            title:'Error', 
                                            text:_r.er.msj, 
                                            type:'warning' 
                                        });  
                                    } 

                                    if(!isN(_r.org)){
                                        OrgLclSet(_r.org);			
                                    }
								}
							} 
						});	
                    });	
                    
                    SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:__orglcl_bx_sch_itm });
				}
				
				
				function OrgLcl_Html(){
		
                    __orglcl_bx_sch.html('');
                    __orglcl_bx_sch.append('<li class=\"sch\">".HTML_inp_tx('sch_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');

					if(!isN(_orglcl['ls'])){
						$.each(_orglcl['ls'], function(k, v) { 
							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							__orglcl_bx_sch.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
						});	
					}
					
					OrgLcl_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function OrgLclSet(p){
					if( !isN(p) ){	
						_orglcl = {}; 
						if( !isN(p.lcl) ){ _orglcl['ls'] = p.lcl.ls; _orglcl['tot'] = p.lcl.tot; }
						OrgLcl_Html();
					}
					OrgLcl_Dom_Rbld();
				}
			";

			$CntJV .= " 
			
				_Rqu({ 
					t:'org_sds_arr_lcl', 
					_org_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.org)){
								OrgLclSet(_r.org);			
							}
						}
					} 
				});
				
			";
        ?>
        
        <div class="org_lcl_dsh dsh_cnt">
	        <div class="_c _c1 _anm ">
		        <?php echo h2('Locales'); ?>
		        <div class="_wrp">
			    	<ul id="bx_org_lcl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	 
		        </div>
	        </div>
	    </div>
        
        <style>
	        
	        .org_lcl_dsh{ text-align: center; margin-top: 10px; display: flex; }
			.org_lcl_dsh ._c{ width: 100%; }
	        .org_lcl_dsh ._c._c1{ width: 100% !important; margin: 0 auto; } 
	        .org_lcl_dsh ._c h2{ text-align: center; }
	        .org_lcl_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative;}
	        .org_lcl_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .org_lcl_dsh ._c ul .itm.prm_tp h2
	        { 
			    display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; 
			    height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; 
			    font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px;
			    -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; 
		    }
            #bx_org_lcl_<?php echo $__Rnd ?> {width:100%}
            #bx_org_lcl_<?php echo $__Rnd ?> li._anm{ height:auto; }
		    #bx_org_lcl_<?php echo $__Rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
		    #bx_org_lcl_<?php echo $__Rnd ?> li._anm.itm.off{ opacity: 0.5; }
		    #bx_org_lcl_<?php echo $__Rnd ?> li._anm.itm.off:hover{ opacity: 1; }    

            .org_lcl_dsh .sch:not(.fll) .___txar{ padding-right: 0 !important; }
            .org_lcl_dsh ._c ul.dls{margin: 0px 0 0 0 !important; }

	    </style>      
      </div>
  </div>
</div>