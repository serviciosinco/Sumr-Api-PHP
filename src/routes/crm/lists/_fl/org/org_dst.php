<div class="FmTb">
 
   <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			$CntJV .= " 
			
				__orggrp_bx_grp = $('#bx_grp_".$__Rnd."');
			
				
				function Dom_Rbld(){
					
					__orggrp_bx_grp_itm = $('#bx_grp_".$__Rnd." > li.itm ');
			 
					
					
					/* Contenedor para nuevo */
					__org_bx_new = $('.cl_grp_dsh .sch button');
					
					__orggrp_bx_grp_fm = $('#bx_fm_grp_".$__Rnd."');
				
					
					/* Boton Guardar */
					__orgzna_bx_new_sve = $('.cl_grp_dsh ._scrl ._new_fm button');
					
					/* Boton Volver */
					__org_bx_new_bck = $('.cl_grp_dsh h2 button');
					
						
						
					__orggrp_bx_grp_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'org_dst',
							d:'grp',
							est: est,
							_orggrp_enc : _id,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __orggrp_bx_grp.addClass('_ld'); },
							_cm:function(){ __orggrp_bx_grp.removeClass('_ld'); },
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
							GrpFmBld({ t:_tp });
							$('.cl_grp_dsh').addClass('_new _new_'+_tp);
						}
						
					});
					
					__org_bx_new_bck.off('click').click(function(e){
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							$('.cl_grp_dsh').removeClass('_new _new_'+_tp);
						}
					});	
					
					__orgzna_bx_new_sve.off('click').click(function(e){
					
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
	
							var __data_snd = { 
									t:'org_dst', 
									d:'new_'+_tp, 
									orggrp_nm: $('#sisbd_nm').val(),
									orgzna_clr: $('#orgzna_clr').val(),
									_org_enc : '".Php_Ls_Cln($__i)."',
									_bs:function(){ _Rqu_Msg({ t:'prc' }); },
									_w:function(){ _Rqu_Msg({ t:'w' }); },
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.e) && _r.e == 'ok'){
												OrgSet(_r.org);
												swal('Bien ', 'Registro exitoso', 'success');
												$('.cl_grp_dsh').removeClass('_new _new_'+_tp);
												_Rqu_Msg({ t:'inok' });	
												GrpFmBld({ t:_tp });		
											}else{	
												_Rqu_Msg({ t:'w' });		
											}
										}
									} 
								};
							
							
							$('#bx_fm_'+_tp+'_{$__Rnd} :input').each(function(e){	
								id = this.id;
								__data_snd[ this.id ] = this.value ;
							});
							
							swal({									  
								  title: '".TX_ETSGR."',              
								  text: '".TX_SWAL_SVE."!',                        
								  showCancelButton: true,                      
								  confirmButtonText: '".TX_SWAL_YES."',      
								  confirmButtonColor: '".BTN_OK_CLR."',          
								  cancelButtonText: '".TX_SWAL_CNCL."',           
								  closeOnConfirm: false                   
								},										  
							function(){                               
								_Rqu( __data_snd );
							});
							
						}
					});
					
					SUMR_Main.LsSch({ str:'#grp_sch_".$__Rnd."', ls:__orggrp_bx_grp_itm });
					
				}
				
				
			
				
			
				/* Crea el listado de grupos */
				function OrgGrp_Html(){
					__orggrp_bx_grp.html('');
					__orggrp_bx_grp.append('<li class=\"sch\">".HTML_inp_tx('grp_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
					
					$.each(_orggrp['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ var img=v.img.sm_s; }else{ var img=v.img; }
						}else{ img=''; }
						__orggrp_bx_grp.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span>
						<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
						</li>');
					});	
					
					Dom_Rbld();
				}
			
				function GrpFmBld(p){
					
					if(p.t == 'zna'){
						
						$('.cl_grp_dsh ._c1').addClass('_new');
						
						var _html = '".
							HTML_inp_tx('id_orgzna', TX_ZNA, ctjTx($___Ls->dt->rw['id_orgzna'],'in'), '').
							HTML_inp_clr(['id'=>'orgzna_clr', 'plc'=>TX_NM_CL, 'vl'=>$___Ls->dt->rw['orgzna_clr'] ])
						."
							
							<button new-tp=\"zna\">".TXBT_GRDR."</button>
						'; 
						
						__orgzna_bx_zna_fm.html( _html );
					
					}else if(p.t == 'grp'){
						
						$('.cl_grp_dsh ._c2').addClass('_new');
						
						var _html = '".
							HTML_inp_tx('id_orggrp', TX_GRP, ctjTx($___Ls->dt->rw['id_orggrp'],'in'), '')."
							<button new-tp=\"grp\">".TXBT_GRDR."</button>
						'; 
						
						__orggrp_bx_grp_fm.html( _html );
						
					}
					
					Dom_Rbld();
					
				}
			
			";
			
			$CntJV .= "
			
				function OrgSet(p){
					
					try{
						if( !isN(p) ){
							_orggrp = {};
							_orggrp['dt'] = {};
							
							
							
							
							if( !isN(p.grp) ){ _orggrp['ls'] = p.grp.ls; _orggrp['tot'] = p.grp.tot; }
						
						
							OrgGrp_Html();
							
							
							__org_bx_new.hide();
						}
					}catch(e) {
						SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
					}
					
				}
				
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'org_dst', 
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
		        <?php echo h2('<button new-tp="grp"></button>'.TX_GRP); ?>
		        <div class="_wrp">
			    	<ul id="bx_grp_<?php echo $__Rnd; ?>" class="_ls _anm dls _bx_grp"></ul>	
			    	<div class="_new_fm" id="bx_fm_grp_<?php echo $__Rnd; ?>"></div>   
			    </div>
	        </div>
	      
        </div>
        
        <style>
	    
	     	.cl_grp_dsh._new ._new_fm{ display: block!important; }
	        .cl_grp_dsh._new ._bx_zna{ display: none!important; }
	        .cl_grp_dsh._new ._c._scrl h2 button{ display: inline-block!important; }

	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
	        
			.cl_grp_dsh ._c{ width: 26%; }
			
	        .cl_grp_dsh ._c._c1{ width: 95%!important; } 
	        .cl_grp_dsh ._c._c1._new{ width: 45%; } 
	        
	        .cl_grp_dsh ._c._c2{ width: 45%!important; } 
	        .cl_grp_dsh ._c._c2._new{ width: 45%; } 
	        .cl_grp_dsh ._c._c2._new ._bx_grp{ display: block; }
	        
	        .cl_grp_dsh ._c h2{ text-align: center; } 
	        
	        .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
	        .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .cl_grp_dsh ._c ul .itm.prm_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px; -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; }
	        ._bx_zna .__zna{ display: block!important ; }
			._bx_grp .__grp{ display: block!important ; }

	        .cl_grp_dsh._new_zna ._c._c1,
	        .cl_grp_dsh._new_grp ._c._c2,
	        .cl_grp_dsh._new_est ._c._c4{ width: 48%; border: none; }
	        
	        .cl_grp_dsh._new_zna ._c._c1 ._ls,
	        .cl_grp_dsh._new_grp ._c._c2 ._ls,
	        .cl_grp_dsh._new_est ._c._c4 ._ls{ display: none; pointer-events: none; }
	        
	        .cl_grp_dsh._new_zna ._c._c1 h2 button,
	        .cl_grp_dsh._new_grp ._c._c2 h2 button,
	        .cl_grp_dsh._new_est ._c._c4 h2 button{ display: inline-block; }
	        
	        
	        .cl_grp_dsh._new_zna ._c._c2,
	        .cl_grp_dsh._new_zna ._c._c2,
	        .cl_grp_dsh._new_grp ._c._c1,
	        .cl_grp_dsh._new_grp ._c._c1,
	        .cl_grp_dsh._new_est ._c._c2,
	        .cl_grp_dsh._new_est ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	        
        </style>   
       
         
      </div>
    
  </div>
</div>