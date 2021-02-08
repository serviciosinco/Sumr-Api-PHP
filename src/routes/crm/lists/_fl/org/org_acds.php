<div class="FmTb">
 
    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 
			
				__orgenf_bx_enf = $('#bx_enf_".$__Rnd."');
				__orglng_bx_lng = $('#bx_lng_".$__Rnd."');
				__orgbch_bx_bch = $('#bx_bch_".$__Rnd."');
				__orgexa_bx_exa = $('#bx_exa_".$__Rnd."');
				
				function Dom_Rbld(){
					
					__orgenf_bx_enf_itm = $('#bx_enf_".$__Rnd." > li.itm ');
					__orglng_bx_lng_itm = $('#bx_lng_".$__Rnd." > li.itm ');
					__orgbch_bx_bch_itm = $('#bx_bch_".$__Rnd." > li.itm ');
					__orgexa_bx_exa_itm = $('#bx_exa_".$__Rnd." > li.itm ');
					
					
					/* Contenedor para nuevo */
					__org_bx_new = $('.cl_grp_dsh .sch button');
					
					
					__orgenf_bx_enf_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'org_acds', 
							d:'enf',
							est: est,
							_orgenf_enc : _id,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __orgenf_bx_enf.addClass('_ld'); },
							_cm:function(){ __orgenf_bx_enf.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.org)){
										OrgSet(_r.org);			
									}
								}
							} 
						});
						
					});	
					
					__orglng_bx_lng_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'org_acds', 
							d:'lng',
							est: est,
							_orglng_enc : _id,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __orglng_bx_lng.addClass('_ld'); },
							_cm:function(){ __orglng_bx_lng.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.org)){
										OrgSet(_r.org);			
									}
								}
							} 
						});
						
					});	
					
					__orgbch_bx_bch_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'org_acds', 
							d:'bch',
							est: est,
							_orgbch_enc : _id,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __orgbch_bx_bch.addClass('_ld'); },
							_cm:function(){ __orgbch_bx_bch.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.org)){
										OrgSet(_r.org);			
									}
								}
							} 
						});
						
					});
					
					__orgexa_bx_exa_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'org_acds', 
							d:'exa',
							est: est,
							_orgexa_enc : _id,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __orgexa_bx_exa.addClass('_ld'); },
							_cm:function(){ __orgexa_bx_exa.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.org)){
										OrgSet(_r.org);			
									}
								}
							} 
						});
						
					});	
					
					
					__org_bx_new.off('click').click(function(e){
						
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							/*GrpFmBld({ t:_tp });
							$('.cl_grp_dsh').addClass('_new _new_'+_tp);*/
						}
				
					});
					
					SUMR_Main.LsSch({ str:'#enf_sch_".$__Rnd."', ls:__orgenf_bx_enf_itm });
					SUMR_Main.LsSch({ str:'#lng_sch_".$__Rnd."', ls:__orglng_bx_lng_itm });
					SUMR_Main.LsSch({ str:'#bch_sch_".$__Rnd."', ls:__orgbch_bx_bch_itm });
					SUMR_Main.LsSch({ str:'#bch_exa_".$__Rnd."', ls:__orgexa_bx_exa_itm });
					
					
				}
			
				function OrgEnf_Html(){
					__orgenf_bx_enf.html('');
					__orgenf_bx_enf.append('<li class=\"sch\">".HTML_inp_tx('enf_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"enf\"></button></li>');
					
					$.each(_orgenf['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__orgenf_bx_enf.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span>
						<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
						</li>');
					});	
					
					Dom_Rbld();
				}
				
				
				function OrgLng_Html(){
					__orglng_bx_lng.html('');
					__orglng_bx_lng.append('<li class=\"sch\">".HTML_inp_tx('lng_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"lng\"></button></li>');
					
					$.each(_orglng['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__orglng_bx_lng.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span></li>');
					});	
					
					Dom_Rbld();
				}
				
				function OrgBch_Html(){
					__orgbch_bx_bch.html('');
					__orgbch_bx_bch.append('<li class=\"sch\">".HTML_inp_tx('bch_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"bch\"></button></li>');
					
					$.each(_orgbch['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__orgbch_bx_bch.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span></li>');
					});	
					
					Dom_Rbld();
				}
				
				function OrgExa_Html(){
					__orgexa_bx_exa.html('');
					__orgexa_bx_exa.append('<li class=\"sch\">".HTML_inp_tx('exa_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"exa\"></button></li>');
					
					$.each(_orgexa['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__orgexa_bx_exa.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span></li>');
					});	
					
					Dom_Rbld();
				}
		
			";
			
			$CntJV .= "
			
				function OrgSet(p){
					if( !isN(p) ){
						
						try{
						
							_orgenf = {};
							if( !isN(p.enf) ){ _orgenf['ls'] = p.enf.ls; _orgenf['tot'] = p.enf.tot; }
							OrgEnf_Html();
							
							_orglng = {};
							if( !isN(p.lng) ){ _orglng['ls'] = p.lng.ls; _orglng['tot'] = p.lng.tot; }
							OrgLng_Html();
							
							_orgbch = {};
							if( !isN(p.bch) ){ _orgbch['ls'] = p.bch.ls; _orgbch['tot'] = p.bch.tot; }
							OrgBch_Html();
							
							_orgexa = {};
							if( !isN(p.exa) ){ _orgexa['ls'] = p.exa.ls; _orgexa['tot'] = p.exa.tot; }
							OrgExa_Html();
						
						}catch(e) {
							SUMR_Main.log.f({ t:'Error en funcion OrgSet()', m:e });
						}
						
					}
					__org_bx_new.hide();
				}
				
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'org_acds', 
					_org_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.org)){
								OrgSet(_r.org);			
							}
						}
					} 
				});
				
			";
			
		}
			
    
    ?>
        
        
        <div class="cl_grp_dsh dsh_cnt">
	        
	        <div class="_c _c1 _anm _scrl">
		        <?php echo h2('<button new-tp="us"></button> '.TX_ENF); ?>
		        <div class="_wrp">
			    	<ul id="bx_enf_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_us_<?php echo $__Rnd; ?>"></div>	 
		        </div>
	        </div>
	        <div class="_c _c2 _anm _scrl">
		        <?php echo h2('<button new-tp="prm"></button>'.MDL_SIS_LNG); ?>
		        <div class="_wrp">
			    	<ul id="bx_lng_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_prm_<?php echo $__Rnd; ?>"></div>   
			    </div>
	        </div>
	         <div class="_c _c2 _anm _scrl">
		        <?php echo h2('<button new-tp="prm"></button>'.TX_BCH); ?>
		        <div class="_wrp">
			    	<ul id="bx_bch_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_prm_<?php echo $__Rnd; ?>"></div>   
			    </div>
	        </div>
	        
	         <div class="_c _c2 _anm _scrl">
		        <?php echo h2('<button new-tp="prm"></button>'.TX_EXA); ?>
		        <div class="_wrp">
			    	<ul id="bx_exa_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_prm_<?php echo $__Rnd; ?>"></div>   
			    </div>
	        </div>
	        
        </div>
        
        
        <style>
	        
	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
	        
			.cl_grp_dsh ._c{ width: 26%; }
	        .cl_grp_dsh ._c._c1{ width: 25%; } 
	        .cl_grp_dsh ._c h2{ text-align: center; } 
	        
	        .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
	        .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .cl_grp_dsh ._c ul .itm.prm_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px; -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; }
	        

	        .cl_grp_dsh._new_us ._c._c2,
	        .cl_grp_dsh._new_prm ._c._c3,
	        .cl_grp_dsh._new_est ._c._c4{ width: 48%; border: none; }
	        
	        .cl_grp_dsh._new_us ._c._c2 ._ls,
	        .cl_grp_dsh._new_prm ._c._c3 ._ls,
	        .cl_grp_dsh._new_est ._c._c4 ._ls{ display: none; pointer-events: none; }
	        
	        .cl_grp_dsh._new_us ._c._c2 h2 button,
	        .cl_grp_dsh._new_prm ._c._c3 h2 button,
	        .cl_grp_dsh._new_est ._c._c4 h2 button{ display: inline-block; }
	        
	        
	        .cl_grp_dsh._new_us ._c._c3,
	        .cl_grp_dsh._new_us ._c._c4,
	        .cl_grp_dsh._new_prm ._c._c2,
	        .cl_grp_dsh._new_prm ._c._c4,
	        .cl_grp_dsh._new_est ._c._c2,
	        .cl_grp_dsh._new_est ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	        
	        
        </style>   
       
         
      </div>
    
  </div>
</div>