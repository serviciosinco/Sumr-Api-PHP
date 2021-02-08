<div class="FmTb">

    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 
			
				__mdls_bx = $('#bx_mdl_".$__Rnd."');
				
				function Mdl_Dom_Rbld(){	
					__mdls_bx_itm = $('#bx_mdl_".$__Rnd." > li.itm ');	
					__mdls_bx_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'mdl_tabs', 
							d:'mdl_mdl',
							est:est,
							_mdl_enc : '".Php_Ls_Cln($__i)."',
							_id : _id,
							_bs:function(){ __mdls_bx.addClass('_ld'); },
							_cm:function(){ __mdls_bx.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.mdl_tabs)){
										MdlSet(_r.mdl_tabs);			
									}
								}
							} 
						});
						
					});	
						
					SUMR_Main.LsSch({ str:'#sch_".$___Ls->id_rnd."', ls:__mdls_bx_itm });
				
				}
				
				
				function MdlS_Html(){
		
					__mdls_bx.html('');
					__mdls_bx.append('<li class=\"sch\">".HTML_inp_tx('sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');
					
					if(!isN(_mdl['ls'])){
						$.each(_mdl['ls'], function(k, v) { 
							if(!isN(v.est) && v.est >= '1'){ var _cls = 'on'; }else{ var _cls = 'off'; }
							__mdls_bx.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
						});	
					}
					
					Mdl_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function MdlSet(p){
					if( !isN(p) ){	
						_mdl = {}; 
						if( !isN(p.mdl) ){ _mdl['ls'] = p.mdl.ls; _mdl['tot'] = p.mdl.tot; }
						MdlS_Html();
					}
					Mdl_Dom_Rbld();
				}
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'mdl_tabs', 
					_mdl_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.mdl_tabs)){	
								MdlSet(_r.mdl_tabs);	
							}
						}
					} 
				});
				
			";
		}
		
    
    	?>
        
        <div class="cl_grp_dsh dsh_cnt">
	     
	        <div class="_c _c1 _anm _scrl">
		        <?php echo h2('<button new-tp="us"></button> '.TX_MDL); ?>
		        <div class="_wrp">
			    	<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_us_<?php echo $__Rnd; ?>"></div>	 
		        </div>
	        </div>
	    </div>
        
        <style>
	        
	        
	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
			.cl_grp_dsh ._c{ width: 100%; }
	        .cl_grp_dsh ._c._c1{ width: 100% !important; } 
	        .cl_grp_dsh ._c h2{ text-align: center; }
	        .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative;}
	        .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .cl_grp_dsh ._c ul .itm.prm_tp h2
	        { 
			    display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; 
			    height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; 
			    font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px;
			    -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; 
		    }
		    #bx_mdl_<?php echo $__Rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
		    #bx_mdl_<?php echo $__Rnd ?> li._anm.itm.off{ opacity: 0.5; }
		    #bx_mdl_<?php echo $__Rnd ?> li._anm.itm.off:hover{ opacity: 1; }    
	    </style>      
      </div>
  </div>
</div>