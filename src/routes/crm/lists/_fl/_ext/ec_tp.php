<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">    
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 

		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				
				$CntJV .= " 
					
					
					
					var SUMR_Dsh_EcTp = {
						bx_tp:$('#bx_tp_".$__Rnd."'),
						bx_are:$('#bx_are_".$__Rnd."'),
						clectp:{},
						clecare:{}
					}; 
					
					function Dom_Rbld(){
						
						SUMR_Dsh_EcTp.bx_tp_itm = $('#bx_tp_".$__Rnd." li.itm.tp ');
						SUMR_Dsh_EcTp.bx_tp_fm = $('#bx_fm_tp_".$__Rnd."');
						
						SUMR_Dsh_EcTp.bx_are_itm = $('#bx_are_".$__Rnd." li.itm.are ');
						SUMR_Dsh_EcTp.bx_are_fm = $('#bx_fm_are_".$__Rnd."');

						SUMR_Dsh_EcTp.bx_tp_itm.not('.sch').off('click').click(function(){
							$(this).hasClass('on') ? est1 = 'del' : est1 = 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'ec_tp', 
								d:'tp',
								est: est1,
								_id_tp : _id,
								_id_est : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ SUMR_Dsh_EcTp.bx_tp.addClass('_ld'); },
								_cm:function(){ SUMR_Dsh_EcTp.bx_tp.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl);			
										}
									}
								} 
							});
						});
						
						SUMR_Dsh_EcTp.bx_are_itm.not('.sch').off('click').click(function(){
							$(this).hasClass('on') ? est1 = 'del' : est1 = 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'ec_tp', 
								d:'are',
								est: est1,
								_id_tp : _id,
								_id_est : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ SUMR_Dsh_EcTp.bx_are.addClass('_ld'); },
								_cm:function(){ SUMR_Dsh_EcTp.bx_are.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											ClSet(_r.cl);			
										}
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#tp_sch_".$__Rnd."', ls:SUMR_Dsh_EcTp.bx_tp_itm });
						SUMR_Main.LsSch({ str:'#are_sch_".$__Rnd."', ls:SUMR_Dsh_EcTp.bx_are_itm });
						
					}
					
					function ClEcTp_Html(){

						SUMR_Dsh_EcTp.bx_tp.html('');
						SUMR_Dsh_EcTp.bx_tp.append('<li class=\"sch\">".HTML_inp_tx('tp_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"tp\"></button></li>');
						
						if(!isN(SUMR_Dsh_EcTp.clectp) && !isN(SUMR_Dsh_EcTp.clectp['ls'])){
							
							$.each(SUMR_Dsh_EcTp.clectp['ls'], function(k, v) {
	
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								
								if(!isN(v.img)){
									if(!isN(v.img.sm_s)){ var img=v.img.sm_s; }else{ var img=v.img; }
								}else{ 
									var img=''; 
								}
								
								SUMR_Dsh_EcTp.bx_tp.append('<li class=\"_anm itm tp '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
							});	
							
						}
						
						$('#tot_tp_".$__Rnd."').html( SUMR_Dsh_EcTp.clectp['tot'] );
						
						Dom_Rbld();
					}
					
					function ClEcAre_Html(){

						SUMR_Dsh_EcTp.bx_are.html('');
						SUMR_Dsh_EcTp.bx_are.append('<li class=\"sch\">".HTML_inp_tx('are_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						if(!isN(SUMR_Dsh_EcTp.clecare) && !isN(SUMR_Dsh_EcTp.clecare['ls'])){
							$.each(SUMR_Dsh_EcTp.clecare['ls'], function(k, v) {
	
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.img)){
									if(!isN(v.img.sm_s)){ var img=v.img.sm_s; }else{ var img=v.img; }
								}else{ 
									var img=''; 
								}
								SUMR_Dsh_EcTp.bx_are.append('<li class=\"_anm itm are '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
							});	
						}
						
						$('#tot_are_".$__Rnd."').html( SUMR_Dsh_EcTp.clecare['tot'] );
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
				
				function ClSet(p){
					if( !isN(p) ){
						SUMR_Dsh_EcTp.clectp = {}; 
						SUMR_Dsh_EcTp.clectp['dt'] = {};
						SUMR_Dsh_EcTp.clecare = {}; 
						SUMR_Dsh_EcTp.clecare['dt'] = {};
						
						
						if( !isN(p.ec.tp) ){ SUMR_Dsh_EcTp.clectp['ls'] = p.ec.tp.ls; SUMR_Dsh_EcTp.clectp['tot'] = p.ec.tp.tot; }
						if( !isN(p.ec.are) ){ SUMR_Dsh_EcTp.clecare['ls'] = p.ec.are.ls; SUMR_Dsh_EcTp.clecare['tot'] = p.ec.are.tot; }
						
						ClEcTp_Html();
						ClEcAre_Html();
					}
				}		
			";
				$CntJV .= " 
					_Rqu({ 
						t:'ec_tp', 
						_id_est : '".Php_Ls_Cln($___Ls->gt->i)."',
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
	        <div class="cl_mdl_tp_dsh dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl">
			        <?php echo h2('<button new-tp="tp"></button>'.TX_MDL); ?>
			        <div class="_wrp">
				    	<ul id="bx_tp_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_tp_<?php echo $__Rnd; ?>"></div>   
				    </div>
		        </div>  	   
	        </div>
	       
	        <style>
		        .lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important }
		        .cl_mdl_tp_dsh{ text-align: center; margin-top: 10px; display: flex; }
				.cl_mdl_tp_dsh ._c{ width: 90%; }
		        .cl_mdl_tp_dsh ._c._c1{ width: 90%; } 
		        .cl_mdl_tp_dsh ._c._c1 h2{ text-align: right; } 
		        .cl_mdl_tp_dsh ._c h2{ text-align: center; }  
		        .cl_mdl_tp_dsh ._c ul .itm.tp_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
		        .cl_mdl_tp_dsh ._c ul .itm.tp_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
		        .cl_mdl_tp_dsh ._c ul .itm.tp_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radimdl: 10px 0px 0px 10px; -moz-border-radimdl: 10px 0px 0px 10px; -webkit-border-radimdl: 10px 0px 0px 10px; }
				.cl_mdl_tp_dsh._new_mdl ._c._c2,
		        .cl_mdl_tp_dsh._new_tp ._c._c3,
		        .cl_mdl_tp_dsh._new_est1 ._c._c4{ width: 48%; border: none; } 
		        .cl_mdl_tp_dsh._new_mdl ._c._c2 ._ls,
		        .cl_mdl_tp_dsh._new_tp ._c._c3 ._ls,
		        .cl_mdl_tp_dsh._new_est1 ._c._c4 ._ls{ display: none; pointer-events: none; } 
		        .cl_mdl_tp_dsh._new_mdl ._c._c2 h2 button,
		        .cl_mdl_tp_dsh._new_tp ._c._c3 h2 button,
		        .cl_mdl_tp_dsh._new_est1 ._c._c4 h2 button{ display: inline-block; }
		        .cl_mdl_tp_dsh._new_mdl ._c._c3,
		        .cl_mdl_tp_dsh._new_mdl ._c._c4,
		        .cl_mdl_tp_dsh._new_tp ._c._c2,
		        .cl_mdl_tp_dsh._new_tp ._c._c4,
		        .cl_mdl_tp_dsh._new_est1 ._c._c2,
		        .cl_mdl_tp_dsh._new_est1 ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	        </style>   
		</div>
  </div>
</div>