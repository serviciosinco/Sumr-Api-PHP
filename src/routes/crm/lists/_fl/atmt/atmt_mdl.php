<div class="FmTb">

    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 
			
				__atmtmdl_bx_mdl = $('#bx_mdl_".$__Rnd."');
				
				
				function Atmt_Dom_Rbld(){
					
					__atmtmdl_bx_mdl_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
					
				/* Contenedor para nuevo */
					
					
					__atmtmdl_bx_mdl_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'atmt_mdl', 
							d:'mdl',
							est:est,
							_mdl_enc : _id,
							_atmt_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __atmtmdl_bx_mdl.addClass('_ld'); },
							_cm:function(){ __atmtmdl_bx_mdl.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.atmt_mdl)){
										MdlSet(_r.atmt_mdl);	
												
									}
								}
							} 
						});
						
					});	
					
					SUMR_Main.LsSch({ str:'#mdl_sch_".$__Rnd."', ls:__atmtmdl_bx_mdl_itm });
				
				}
			
				function OrgEnf_Html(){
					__atmtmdl_bx_mdl.html('');
					__atmtmdl_bx_mdl.append('<li class=\"sch\">".HTML_inp_tx('mdl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"mdl\"></button></li>');
					
					$.each(_atmtmdl['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__atmtmdl_bx_mdl.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span>
						<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
						</li>');
					});	
					
					Atmt_Dom_Rbld();
				}	
			";
			
			$CntJV .= "
			
				function MdlSet(p){
					
					if( !isN(p) ){
						
						try{
						
							_atmtmdl = {};
							if( !isN(p.mdl) ){ _atmtmdl['ls'] = p.mdl.ls; _atmtmdl['tot'] = p.mdl.tot; }
							OrgEnf_Html();
							
						}catch(e) {
							SUMR_Main.log.f({ t:'Error en funcion MdlSet():', m:e });
						}
						
					}
					
				}
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'atmt_mdl', 
					_atmt_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.atmt_mdl)){
								MdlSet(_r.atmt_mdl);			
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
			.cl_grp_dsh ._c{ width: 26%; }
	        .cl_grp_dsh ._c._c1{ width: 100%; } 
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
		        
	    </style>      
      </div>
  </div>
</div>