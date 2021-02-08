<div class="FmTb">

    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 
			
				__mdls_bx_sch = $('#bx_mdl_".$__Rnd."');
				
				
				function MdlSch_Dom_Rbld(){
					
					__mdls_bx_sch_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
					
					__sch_bx_new = $('.cl_grp_dsh .sch button'); 

					__mdls_bx_sch_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'mdl_sch', 
							d:'sch',
							est:est,
							_mdl_enc : '".Php_Ls_Cln($__i)."',
							_id_sch : _id,
							_bs:function(){ __mdls_bx_sch.addClass('_ld'); },
							_cm:function(){ __mdls_bx_sch.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.cl)){
										MdlSchSet(_r.cl);			
									}
								}
							} 
						});
						
					});	
					
					__sch_bx_new.off('click').click(function(e){
						
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							
							/*GrpFmBld({ t:_tp });
							$('.cl_grp_dsh').addClass('_new _new_'+_tp);*/
						}
				
					});
					
					SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:__mdls_bx_sch_itm });
				
				}
				
				
				function MdlSSch_Html(){
		
					__mdls_bx_sch.html('');
					__mdls_bx_sch.append('<li class=\"sch fll\">".HTML_inp_tx('sch_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."');
					
					if(!isN(_mdlssch['ls'])){
						$.each(_mdlssch['ls'], function(k, v) { 
							if(!isN(v.in) && !isN(v.in.est) && v.in.est == 'ok'){ var _cls = 'on'; }else{ var _cls = 'off'; }
							__mdls_bx_sch.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
						});	
					}
					
					MdlSch_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function MdlSchSet(p){
					if( !isN(p) ){	
						_mdlssch = {}; 
						if( !isN(p.mdls.sch) ){ _mdlssch['ls'] = p.mdls.sch.ls; _mdlssch['tot'] = p.mdls.sch.tot; }
						MdlSSch_Html();
					}
					MdlSch_Dom_Rbld();
				}
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'mdl_sch', 
					_mdl_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cl)){
								MdlSchSet(_r.cl);			
							}
						}
					} 
				});
				
			";
		}
			
    
    ?>
        
        <div class="cl_grp_dsh dsh_cnt">
	     
	        <div class="_c _c1 _anm ">
		        <?php echo h2(TX_HRO); ?>
		        <div class="_wrp">
			    	<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_opt_<?php echo $__Rnd; ?>"></div>	 
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