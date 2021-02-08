<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					__clgrp_bx_are = $('#bx_are_".$__Rnd."');
					/*__clgrp_bx_mdl = $('#bx_mdl_".$__Rnd."');*/
					__clgrp_bx_plcy = $('#bx_plcy_".$__Rnd."');
					
					function Dom_Rbld(){
						
						__clgrp_bx_are_itm = $('#bx_are_".$__Rnd." li.itm.are ');
						/*__clgrp_bx_mdl_itm = $('#bx_mdl_".$__Rnd." li.itm.mdl ');*/
						__clgrp_bx_plcy_itm = $('#bx_plcy_".$__Rnd." li.itm.plcy ');
						
						__clgrp_bx_are_fm = $('#bx_fm_are_".$__Rnd."');
						/*__clgrp_bx_mdl_fm = $('#bx_fm_mdl_".$__Rnd."');*/
						__clgrp_bx_plcy_fm = $('#bx_fm_plcy_".$__Rnd."');
						
						__clgrp_bx_new = $('.cl_mdl_are_dsh .sch button');	
						__clgrp_bx_new_bck = $('.cl_mdl_are_dsh h2 button');
						__clgrp_bx_new_sve = $('.cl_mdl_are_dsh ._scrl ._new_fm button');
						
						__clgrp_bx_are_itm.not('.sch').off('click').click(function(){
							$(this).hasClass('on') ? est1 = 'del' : est1 = 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'cl_mdl_are', 
								d:'are',
								est: est1,
								_id_are : _id,
								_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_bs:function(){ __clgrp_bx_are.addClass('_ld'); },
								_cm:function(){ __clgrp_bx_are.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl);			
										}
									}
								} 
							});
						});
						
						/*__clgrp_bx_mdl_itm.not('.sch').off('click').click(function(){
							$(this).hasClass('on') ? est1 = 'del' : est1 = 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'cl_mdl_are', 
								d:'mdl',
								est: est1,
								_id_mdl : _id,
								_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_bs:function(){ __clgrp_bx_mdl.addClass('_ld'); },
								_cm:function(){ __clgrp_bx_mdl.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl);			
										}
									}
								} 
							});
						});*/
						
						__clgrp_bx_plcy_itm.not('.sch').off('click').click(function(){
							$(this).hasClass('on') ? est1 = 'del' : est1 = 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'cl_mdl_are', 
								d:'plcy',
								est: est1,
								_id_plcy : _id,
								_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_bs:function(){ __clgrp_bx_plcy.addClass('_ld'); },
								_cm:function(){ __clgrp_bx_plcy.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl);			
										}
									}
								} 
							});
						});
							
						__clgrp_bx_new.off('click').click(function(e){
							e.preventDefault();
							var _tp = $(this).attr('new-tp');
							if(e.target != this){
						    	e.stopPropagation(); return;
							}else{
								GrpFmBld({ t:_tp });
								$('.cl_mdl_are_dsh').addClass('_new _new_'+_tp);
							}
						});
						
						__clgrp_bx_new_bck.off('click').click(function(e){
							e.preventDefault();
							var _tp = $(this).attr('new-tp');
							if(e.target != this){
						    	e.stopPropagation(); return;
							}else{
								$('.cl_mdl_are_dsh').removeClass('_new _new_'+_tp);
							}
						});	
						
						__clgrp_bx_new_sve.off('click').click(function(e){
							e.preventDefault();
							var _tp = $(this).attr('new-tp');
							if(e.target != this){
						    	e.stopPropagation(); return;
							}else{
								var __data_snd = { 
									t:'cl_mdl_are', 
									d:'new_'+_tp, 
									_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
									_bs:function(){ _Rqu_Msg({ t:'prc' }); },
									_w:function(){ _Rqu_Msg({ t:'w' }); },
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.e) && _r.e == 'ok'){
												ClSet(_r.cl);	
												$('.cl_mdl_are_dsh').removeClass('_new _new_'+_tp);
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

						SUMR_Main.LsSch({ str:'#are_sch_".$__Rnd."', ls:__clgrp_bx_are_itm });
						/*SUMR_Main.LsSch({ str:'#mdl_sch_".$__Rnd."', ls:__clgrp_bx_mdl_itm });*/
						SUMR_Main.LsSch({ str:'#plcy_sch_".$__Rnd."', ls:__clgrp_bx_plcy_itm });
						
					}
					
					function ClGrpAre_Html(){

						__clgrp_bx_are.html('');
						__clgrp_bx_are.append('<li class=\"sch\">".HTML_inp_tx('are_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"are\"></button></li>');
						
						if(!isN(_clgrpare['ls'])){
							
							$.each(_clgrpare['ls'], function(k, v) {
	
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.img)){
									if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
								}else{ img=''; }
								__clgrp_bx_are.append('<li class=\"_anm itm are '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
							});	
							
							$('#tot_are_".$__Rnd."').html( _clgrpare['tot'] );
						
						}
						
						Dom_Rbld();
					}
					
					/*function ClGrpMdl_Html(){

						__clgrp_bx_mdl.html('');
						__clgrp_bx_mdl.append('<li class=\"sch\">".HTML_inp_tx('mdl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"mdl\"></button></li>');
						if(!isN(_clgrpmdl['ls'])){
							$.each(_clgrpmdl['ls'], function(k, v) {
	
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.img)){
									if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
								}else{ img=''; }
								__clgrp_bx_mdl.append('<li class=\"_anm itm mdl '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
							});	
						}
						
						$('#tot_mdl_".$__Rnd."').html( _clgrpmdl['tot'] );
						
						Dom_Rbld();
					}*/
					
					function ClGrpPlcy_Html(){

						__clgrp_bx_plcy.html('');
						__clgrp_bx_plcy.append('<li class=\"sch\">".HTML_inp_tx('plcy_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"mdl\"></button></li>');
						if(!isN(_clgrpplcy['ls'])){
							$.each(_clgrpplcy['ls'], function(k, v) {
	
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.img)){
									if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
								}else{ img=''; }
								__clgrp_bx_plcy.append('<li class=\"_anm itm plcy '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
							});	
						}
						
						$('#tot_plcy_".$__Rnd."').html( _clgrpplcy['tot'] );
						
						Dom_Rbld();
					}
				";
				
				
				$l_gnr = __Ls(['k'=>'sx', 'id'=>'mdl_gnr', 'va'=>$___Ls->dt->rw['mdl_gnr'] , 'ph'=>FM_LS_SISSX]); 
				$l_aretp = __Ls([ 'k'=>'mdls_tp_are', 'id'=>'mdlstpare_tp', 'ph'=>'-' ]);
				
				$CntJV .= "
				
				function GrpFmBld(p){
					
					if(p.t == 'mdl'){
						
						var _html = '".HTML_inp_tx('mdl_mdler', TX_US, ctjTx($___Ls->dt->rw['mdl_mdler'],'in'), FMRQD_EM)." 
			            			".HTML_inp_tx('mdl_nm', TX_NM, ctjTx($___Ls->dt->rw['mdl_nm'],'in'), FMRQD)." 
									".HTML_inp_tx('mdl_ap', TX_AP, ctjTx($___Ls->dt->rw['mdl_ap'],'in'), FMRQD).
									$l_gnr->html."<button new-tp=\"mdl\">".TXBT_GRDR."</button>'; 
						
						__clgrp_bx_mdl_fm.html( _html );
						
						$l_gnr->js  
					
					}else if(p.t == 'are'){
						
						var _html = '".LsMdlSTp('mdlstpare_mdlstp', 'id_mdlstp', '', '', 1).
									   $l_aretp->html.			 
					    			   HTML_inp_tx('mdlstpare_nm', TX_NM , '', FMRQD).   	
									   HTML_inp_tx('mdlstpare_vl', TX_KEY, '', FMRQD)."
									   <button new-tp=\"are\">".TXBT_GRDR."</button>'; 
						
						__clgrp_bx_are_fm.html( _html );
						
						$l_aretp->js 
						".JQ_Ls('mdlstpare_mdlstp', FM_LS_SLTP)." 
					
					}
					Dom_Rbld();
				}
				
				
				function ClSet(p){
					if( !isN(p) ){
						_clgrpare = {}; 
						_clgrpare['dt'] = {};
						/*_clgrpmdl = {}; 
						_clgrpmdl['dt'] = {};*/
						_clgrpplcy = {}; 
						_clgrpplcy['dt'] = {};
						
						if( !isN(p.grp.are) ){ _clgrpare['ls'] = p.grp.are.ls; _clgrpare['tot'] = p.grp.are.tot; }
						/*if( !isN(p.grp.mdl) ){ _clgrpmdl['ls'] = p.grp.mdl.ls; _clgrpmdl['tot'] = p.grp.mdl.tot; }*/
						if( !isN(p.grp.mdl) ){ _clgrpplcy['ls'] = p.grp.plcy.ls; _clgrpplcy['tot'] = p.grp.plcy.tot; }
						
						ClGrpAre_Html();
						/*ClGrpMdl_Html();*/
						ClGrpPlcy_Html();
					}
				}		
			";
				$CntJV .= " 
					_Rqu({ 
						t:'cl_mdl_are', 
						_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.cl)){
									ClSet(_r.cl);			
								}
							}
						} 
					});
					
				";
	    ?>
	        <div class="cl_mdl_are_dsh dsh_cnt lead_data">
	            <!--<div class="_c _c2 _anm _scrl">
			        <?php echo h2('<button new-tp="mdl"></button> '.TX_MDL); ?>
			        <div class="_wrp">
				    	<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_mdl_<?php echo $__Rnd; ?>"></div>	 
			        </div>
		        </div>-->
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2('<button new-tp="are"></button>'.TX_ARE); ?>
			        <div class="_wrp">
				    	<ul id="bx_are_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_are_<?php echo $__Rnd; ?>"></div>   
				    </div>
		        </div>  
		        <div class="_c _c4 _anm _scrl">
			        <?php echo h2('<button new-tp="plcy"></button>'.'Politicas de privacidad'); ?>
			        <div class="_wrp">
				    	<ul id="bx_plcy_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_plcy_<?php echo $__Rnd; ?>"></div>  
				    </div>
		        </div>	   
	        </div>
	        <?php //include(DIR_EXT.'act_css.php'); ?> 
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
				/*.cl_grp_dsh ._c{ width: 50% !important; }*/
		        .cl_mdl_are_dsh{ text-align: center; margin-top: 10px; display: flex; }
				.cl_mdl_are_dsh ._c{ width: 33%; }
		        .cl_mdl_are_dsh ._c._c1{ width: 20%; } 
		        .cl_mdl_are_dsh ._c._c1 h2{ text-align: right; } 
		        .cl_mdl_are_dsh ._c h2{ text-align: center; }  
		        .cl_mdl_are_dsh ._c ul .itm.are_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
		        .cl_mdl_are_dsh ._c ul .itm.are_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
		        .cl_mdl_are_dsh ._c ul .itm.are_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radimdl: 10px 0px 0px 10px; -moz-border-radimdl: 10px 0px 0px 10px; -webkit-border-radimdl: 10px 0px 0px 10px; }
				.cl_mdl_are_dsh._new_mdl ._c._c2,
		        .cl_mdl_are_dsh._new_are ._c._c3,
		        .cl_mdl_are_dsh._new_est1 ._c._c4{ width: 48%; border: none; } 
		        .cl_mdl_are_dsh._new_mdl ._c._c2 ._ls,
		        .cl_mdl_are_dsh._new_are ._c._c3 ._ls,
		        .cl_mdl_are_dsh._new_est1 ._c._c4 ._ls{ display: none; pointer-events: none; } 
		        .cl_mdl_are_dsh._new_mdl ._c._c2 h2 button,
		        .cl_mdl_are_dsh._new_are ._c._c3 h2 button,
		        .cl_mdl_are_dsh._new_est1 ._c._c4 h2 button{ display: inline-block; }
		        .cl_mdl_are_dsh._new_mdl ._c._c3,
		        .cl_mdl_are_dsh._new_mdl ._c._c4,
		        .cl_mdl_are_dsh._new_are ._c._c2,
		        .cl_mdl_are_dsh._new_are ._c._c4,
		        .cl_mdl_are_dsh._new_est1 ._c._c2,
		        .cl_mdl_are_dsh._new_est1 ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	        </style>   
		</div>
  </div>
</div>