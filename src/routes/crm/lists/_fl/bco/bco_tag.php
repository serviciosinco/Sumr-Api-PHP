<div class="FmTb">
	<div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
				$CntJV .= " 
				
					var SUMR_Bco = {
						tag : $('#bx_tag_".$__Rnd."'),
						bcotag: {},
					};

					function Dom_Rbld(){
						
						var __bco_bx_tag_itm = $('#bx_tag_".$__Rnd." li.itm.tag');
						var __bco_bx_tag_itm_figure_tag = $('#bx_tag_".$__Rnd." li.itm.tag figure');
						var __bco_bx_tag_itm_figure = $('#bx_tag_".$__Rnd." li.sch figure');
						
						__bco_bx_tag_itm_figure_tag.not('.sch').off('click').click(function(){
									
							var _id = $('.sch').attr('rel');	
							var us_id = $(this).parent().attr('us-id');
							var vl_tag = $('#tx_'+us_id).html();
	
							_Rqu({ 
								t:'bco_tag', 
								d:'tag',
								est : 'del',
								_vl_tag: vl_tag,
								_id_bco : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_id_bco_n : _id,
								_bs:function(){ SUMR_Bco.tag.addClass('_ld'); },
								_cm:function(){ SUMR_Bco.tag.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(_r.e == 'ok'){
											if(!isN(_r.bco)){
												ClSet(_r.bco);
											}		
										}else{
											swal('Alerta!', 'Error vuelva intentar', 'error');		
										}
									}
								}  
							});
						});
						
						__bco_bx_tag_itm_figure.not('.itm').off('click').click(function(){ 		
		
							if(!isN($('#tag_sch_".$__Rnd."').val())){
								
								var vl_tag = $('#tag_sch_".$__Rnd."').val();
								var id_bco = $('#tag_sch_".$__Rnd."').parent().parent().attr('rel');
								
								_Rqu({ 
									t:'bco_tag', 
									d:'tag',
									est : 'in',
									_vl_tag: vl_tag,
									_id_bco : '".Php_Ls_Cln($___Ls->gt->isb)."',
									_id_bco_n : id_bco,
									_bs:function(){ SUMR_Bco.tag.addClass('_ld'); },
									_cm:function(){ SUMR_Bco.tag.removeClass('_ld'); },
									_cl:function(_r){
										if(!isN(_r)){
											if(_r.e == 'ok'){
												if(!isN(_r.bco)){
													ClSet(_r.bco);
												}		
											}else{
												swal('Alerta!', 'Esta etiqueta ya esta asignada a esta imagen', 'error');		
											}
										}
									} 
								});	
							}else{
								swal('Alerta!', 'El campo no puede estar vacio', 'error');
							}		
						});
	
						SUMR_Main.LsSch({ str:'#tag_sch_".$__Rnd."', ls: __bco_bx_tag_itm });	
					}
					
					function ClGrpAre_Html(){
	
						SUMR_Bco.tag.html('');
						SUMR_Bco.tag.append('<li rel=\"'+SUMR_Bco.bcotag['id']+'\" class=\"sch\">".HTML_inp_tx('tag_sch_'.$__Rnd, 'Buscar o guardar', '')."<figure></figure></li>');
						
						if(SUMR_Bco.bcotag['tot'] > 0){
							$.each(SUMR_Bco.bcotag['ls'], function(k, v) {
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								if(!isN(v.cls)){ var _cls = _cls+' '+v.cls; }
								SUMR_Bco.tag.append('<li class=\"_anm itm tag '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure></figure><span id=\"tx_'+v.enc+'\">'+v.nm+'</span></li>');
							});	
						}		
						
						Dom_Rbld();
					}
				";
	
				$CntJV .= "
	
					function ClSet(p){
						if( !isN(p) ){
							if( !isN(p.tag) ){ 
								SUMR_Bco.bcotag['ls'] = p.tag.ls; 
								SUMR_Bco.bcotag['tot'] = p.tag.tot; 
								SUMR_Bco.bcotag['id'] = p.tag.id;
							}
							ClGrpAre_Html();
						}
					}		
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'bco_tag', 
						_id_bco : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){ 
							if(!isN(_r) && !isN(_r.bco)){ 
								ClSet(_r.bco);
							} 
						} 
					});
				";
	    ?>
	        <div class="bco_tag_dsh dsh_cnt lead_data">
	            <div class="_c _c3 _anm">
			        <?php echo h2(TX_TAGS); ?>
			        <div class="_wrp">
				    	<ul id="bx_tag_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>  
				    </div>
		        </div>	   
	        </div>
	        <style>
		        
		        .bco_tag_dsh{ text-align: center; margin-top: 10px; display: flex; }
				.bco_tag_dsh ._c{ width: 100%; }
		        .bco_tag_dsh ._c h2{ text-align: center; }  
	
				.bco_tag_dsh ._c ul._ls{}
				
				.bco_tag_dsh ._c li.tag.high{ background-color: #dff4dd; }
				.bco_tag_dsh ._c li.tag.medium{ background-color: #fddfad; }
				.bco_tag_dsh ._c li.tag.low{ background-color: #f6d3d3; }
				.bco_tag_dsh ._c li.tag.local{ background-color: #c8c9ca; }
				
		        .bco_tag_dsh ._c li._anm.itm.tag.off{ color:#000; display:inline-block; padding:7px 10px; margin:0 3px 3px 0; height:30px; width:auto; border: none; opacity: 0.4; }
				.bco_tag_dsh ._c li._anm.itm.tag.off:hover{ -webkit-animation: _puff 0.4s ease-out; opacity: 1; }
				.bco_tag_dsh ._c li._anm.itm.tag.off:hover figure{display:block!important;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg)}
				.bco_tag_dsh ._c li._anm.itm.tag.off figure{display:none!important;width:20px!important;height:20px!important;background-color:red!important;position:absolute!important;top:-8px!important;left:-11px!important}
				.bco_tag_dsh ._c li.sch input{display:inline-block}
				.bco_tag_dsh ._c li.sch figure{cursor:pointer;display:inline-block!important;width:20px!important;height:20px!important;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>save.svg)}
				.bco_tag_dsh ._c li.sch div{display:inline-block;vertical-align:middle;width:90%}





	        </style>   
		</div>
  	</div>
</div>