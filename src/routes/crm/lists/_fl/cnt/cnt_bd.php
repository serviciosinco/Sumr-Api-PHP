<div class="FmTb">
 
   <div id="<?php  echo DV_GNR_FM ?>">
   		
    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			$CntJV .= " 
			
				__cntbd_bx_act = $('#bx_act_".$__Rnd."');
				
				function Dom_Rbld(){
					
					__cntbd_bx_act_itm = $('#bx_act_".$__Rnd." > li.itm ');
					
					/* Contenedor para nuevo */
					__mdl_bx_new = $('.cl_grp_dsh .sch button');
					
					__cntbd_bx_act_fm = $('#bx_fm_act_".$__Rnd."');
					
					/* Boton Guardar */
					__cntbd_bx_new_sve = $('.cl_grp_dsh ._scrl ._new_fm button');
					
					/* Boton Volver */
					__mdl_bx_new_bck = $('.cl_grp_dsh h2 button');
					
					__cntbd_bx_act_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'cnt_bd', 
							d:'mdl',
							est: est,
							_bd_enc : _id,
							_cnt_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __cntbd_bx_act.addClass('_ld'); },
							_cm:function(){ __cntbd_bx_act.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cnt)){
										BdSet(_r.cnt);	
									}
								}
							} 
						});
						
					});
					
				
					
					__mdl_bx_new.off('click').click(function(e){	
						
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							
							$('.cl_grp_dsh').addClass('_new');
						}
				
					});	
					
					$('.btnOc').off('click').click(function(e){
						
						e.preventDefault();
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							var __data_snd = { 
									t:'cnt_bd',
									d:'new_bd',
									_cnt_enc : '".Php_Ls_Cln($__i)."',
									sisbd_nm: $('#sisbd_nm').val(),
									_bs:function(){ _Rqu_Msg({ t:'prc' }); },
									_w:function(){ _Rqu_Msg({ t:'w' }); },
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.e) && _r.e == 'ok'){
												swal('Bien ', 'Registro exitoso', 'success');
												$('.cl_grp_dsh').removeClass('_new ');
												TpSet(_r.cnt);	
											}else{	
												_Rqu_Msg({ t:'w' });		
											}
										}
									} 
								};
								
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
								Dom_Rbld();
							});
						}
						
						
					});
					
					
					__mdl_bx_new_bck.off('click').click(function(e){

						e.preventDefault();
						$('.cl_grp_dsh').removeClass('_new');
						
					});	
					
					
					
					SUMR_Main.LsSch({ str:'#act_sch_".$__Rnd."', ls:__cntbd_bx_act_itm });
					
				}
				
				
				
				/* Crea el listado de zonas */
				function CntBd_Html(){
					__cntbd_bx_act.html('');
					__cntbd_bx_act.append('<li class=\"sch\">".HTML_inp_tx('act_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"act\"></button></li>');
					
					$.each(_cntbd['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__cntbd_bx_act.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span>
						<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
						</li>');
					});	
					
					Dom_Rbld();
				}
			
				function GrpFmBld(p){
					
					if(p.t == 'act'){
						
						$('.cl_grp_dsh ._c1').addClass('_new');
						
						var _html = '".
							HTML_inp_tx('id_cntbd', TX_ZNA, ctjTx($___Ls->dt->rw['id_cntbd'],'in'), '')."
							<button new-tp=\"act\">".TXBT_GRDR."</button>
						'; 
						
						__cntbd_bx_act_fm.html( _html );
					
					}
					
					Dom_Rbld();
					
				}
			
			";
			
			$CntJV .= "
			
				function BdSet(p){
					try{
						if( !isN(p) ){
							_cntbd = {}; _cntbd['dt'] = {};
							
							if( !isN(p.bd) ){ _cntbd['ls'] = p.bd.ls; _cntbd['tot'] = p.bd.tot; }
							
							CntBd_Html();
							
							__mdl_bx_new
						}
					}catch(e) {
						SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
					}
				}
				
			";
		
		if($__i){

			$CntJV .= " 
			
				try{
					_Rqu({ 
						t:'cnt_bd',
						_cnt_enc : '".Php_Ls_Cln($__i)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.cnt)){
									BdSet(_r.cnt);			
								}
							}
						} 
					});
				}catch(e) {
					SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
				}
				
			";
			
		}
			
    
    ?>
    	 <div class="cl_grp_dsh dsh_cnt">
	     	<div class="_c _c1 _anm _scrl">
		        <?php echo h2('<button new-tp="act"></button> '.TX_BD); ?>
		        <div class="_wrp">
			     
			    	<ul id="bx_act_<?php echo $__Rnd; ?>" class="_ls _anm dls _bx_act"></ul>
			    	<div class="_new_fm" style="display:none;">
						<?php echo HTML_inp_tx('sisbd_nm', TX_BD, ctjTx($___Ls->dt->rw['sisbd_nm'],'in'), ''); ?>
						<button class="btnOc">Guardar</button>
				    </div>
		        </div>
	        </div>
        </div> 
        
             
        <style>
	        
	        
	        .cl_grp_dsh._new ._new_fm{ display: block!important; }
	        .cl_grp_dsh._new ._bx_act{ display: none!important; }
	        .cl_grp_dsh._new ._c._scrl h2 button{ display: inline-block!important; }
	        
	        
	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
	        
			.cl_grp_dsh ._c{ width: 26%; }
			
	        .cl_grp_dsh ._c._c1{ width: 70%!important; margin: auto; } 
	        .cl_grp_dsh ._c._c1._new{ width: 45%; } 
	        .cl_grp_dsh ._c._c1._new ._bx_act{ display: none; }
	        
	        .cl_grp_dsh ._c._c2{ width: 45%!important; } 
	        .cl_grp_dsh ._c._c2._new{ width: 45%; } 
	        .cl_grp_dsh ._c._c2._new ._bx_grp{ display: none; }
	        
	        .cl_grp_dsh ._c h2{ text-align: center; } 
	        
	        .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
	        .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .cl_grp_dsh ._c ul .itm.prm_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px; -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; }
	        

	        .cl_grp_dsh._new_act ._c._c1,
	        .cl_grp_dsh._new_grp ._c._c2,
	        .cl_grp_dsh._new_est ._c._c4{ width: 48%; border: none; }
	        
	        .cl_grp_dsh._new_act ._c._c1 ._ls,
	        .cl_grp_dsh._new_grp ._c._c2 ._ls,
	        .cl_grp_dsh._new_est ._c._c4 ._ls{ display: none; pointer-events: none; }
	        
	        .cl_grp_dsh._new_act ._c._c1 h2 button,
	        .cl_grp_dsh._new_grp ._c._c2 h2 button,
	        .cl_grp_dsh._new_est ._c._c4 h2 button{ display: inline-block; }
	        
	        
	        .cl_grp_dsh._new_act ._c._c2,
	        .cl_grp_dsh._new_act ._c._c2,
	        .cl_grp_dsh._new_grp ._c._c1,
	        .cl_grp_dsh._new_grp ._c._c1,
	        .cl_grp_dsh._new_est ._c._c2,
	        .cl_grp_dsh._new_est ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	        
        </style>   
       
         
      </div>
    
  </div>
</div>