<div class="FmTb">
 
   <div id="<?php  echo DV_GNR_FM ?>">
   		
    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			$CntJV .= " 
			
				__lrnvd_bx_lrnvd_cl = $('#bx_lrn_".$__Rnd."');
				
				function Dom_Rbld(){
					
					__lrnvd_bx_lrn_itm = $('#bx_lrn_".$__Rnd." > li.itm ');
					
					/* Boton Volver 
					__mdl_bx_new_bck = $('.cl_grp_dsh h2 button');*/
					
					__lrnvd_bx_lrn_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'lrn_vd_cl', 
							d:'lrn',
							est: est,
							_cl_enc : _id,
							_lrn_enc: '".Php_Ls_Cln($__i)."',
							_bs:function(){ __lrnvd_bx_lrnvd_cl.addClass('_ld'); },
							_cm:function(){ __lrnvd_bx_lrnvd_cl.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.lrnvd)){
										BdSet(_r);	
									}
 								}
							} 
						});
						
					});
					
					SUMR_Main.LsSch({ str:'#lrnvd_sch_".$__Rnd."', ls:__lrnvd_bx_lrn_itm });
					
				}
				
				
				
				/* Crea el listado de Clientes */
				
				function Lrnvd_Html(){
					
					__lrnvd_bx_lrnvd_cl.html('');
					__lrnvd_bx_lrnvd_cl.append('<li class=\"sch\">".HTML_inp_tx('lrnvd_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"act\"></button></li>');
					
					$.each(lrnvd.ls, function(k, v) { 
						
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
	
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ 
							img=''; 
						}
						
						if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
														
						__lrnvd_bx_lrnvd_cl.append('<li class=\"_anm itm cl '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
													<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
													<span>'+v.nm+'</span>
												   </li>');
									});	
					
					Dom_Rbld();
				}
			
							
			";
			
			$CntJV .= "
			
				function BdSet(p){
					
					try{
						if( !isN(p) ){
							lrnvd = {};
					
							if( !isN(p.lrnvd) ){  lrnvd['ls'] = p.lrnvd.ls; lrnvd['tot'] = p.lrnvd.tot; }
							
							Lrnvd_Html();
							
							/* __mdl_bx_new */
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
						t:'lrn_vd_cl',
						_lrn_enc : '".Php_Ls_Cln($__i)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r)){
									BdSet(_r);			
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
		        <?php echo h2('<button new-tp="act"></button> '.TX_CL); ?>
		        <div class="_wrp">
			     
			    	<ul id="bx_lrn_<?php echo $__Rnd; ?>" class="_ls _anm dls _bx_lrnvd_cl"></ul>
			    	
		        </div>
	        </div>
        </div> 
        
             
        <style>
	        
	        
	        .cl_grp_dsh._new ._new_fm{ display: block!important; }
	        .cl_grp_dsh._new ._bx_lrnvd_cl{ display: none!important; }
	        .cl_grp_dsh._new ._c._scrl h2 button{ display: inline-block!important; }
	        
	        
	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
	        
			.cl_grp_dsh ._c{ width: 26%; }
			
	        .cl_grp_dsh ._c._c1{ width: 70%!important; margin: auto; } 
	        .cl_grp_dsh ._c._c1._new{ width: 45%; } 
	        .cl_grp_dsh ._c._c1._new ._bx_lrnvd_cl{ display: none; }
	        
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
	        
	        
	        

			.cl_grp_dsh ._c ul .itm.cl{ color: white; padding-left: 35px; border: none !important; }
			.cl_grp_dsh ._c ul .itm.cl.off{ -webkit-filter: grayscale(100%); filter: grayscale(100%); opacity: 0.5; } 
			.cl_grp_dsh ._c ul .itm.cl.off:hover{ -webkit-filter: grayscale(0%); filter: grayscale(0%); opacity: 1; }       
			.cl_grp_dsh ._c ul .itm figure{ left: -6px; }
			
	
	
        </style>   
       
         
      </div>
    
  </div>
</div>