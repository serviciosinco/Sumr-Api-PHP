<div class="FmTb">
	<div id="<?php  echo DV_GNR_FM ?>">
    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

        <?php
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			$CntJV .= " 
				var SUMR_Cnt_Appl_Cntrc = {
					bx_cntapplcntrc : $('#bx_act_".$__Rnd."'),
					applcntrc : {} 
				};

				function Dom_Rbld(){
					
					cntapplcntrc_itm = $('#bx_act_".$__Rnd." > li.itm');
					cntapplcntrc_itm_fg = $('#bx_act_".$__Rnd." > li.itm figure');
					
					cntapplcntrc_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
	
						_Rqu({ 
							t:'cnt_appl_cntrc', 
							d:'appl',
							est: est,
							_cntrc_enc : _id,
							_cntappl_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ SUMR_Cnt_Appl_Cntrc.bx_cntapplcntrc.addClass('_ld'); },
							_cm:function(){ SUMR_Cnt_Appl_Cntrc.bx_cntapplcntrc.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cnt)){
										TpSet(_r.cnt);	
									}
								}
							} 
						});
						
					});	
					
					cntapplcntrc_itm_fg.not('.sch').off('click').click(function(e){		
												
						e.preventDefault();
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							
							var __rel = $(this).parent().hasClass('on');
							var _id = $(this).parent().attr('rel');
							
							if(__rel){
								
								_Rqu({ 
									t:'cnt_appl_cntrc', 
									d:'view',
									_cntrc_enc : _id,
									_cntappl_enc : '".Php_Ls_Cln($__i)."',
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.view)){
												window.open('https://contrato.".DMN."cityu/'+_r.view.enc, '_blank');
											}
										}
									} 
								});		
							}else{
								swal('".TX_ERROR."', 'Para visualizarlo tienes que seleccionar el documento', 'error');	
							}	
						}

					});
					
					SUMR_Main.LsSch({ str:'#act_sch_".$__Rnd."', ls:cntapplcntrc_itm });
					
				}

				function CntTp_Html(){
					SUMR_Cnt_Appl_Cntrc.bx_cntapplcntrc.html('');
					SUMR_Cnt_Appl_Cntrc.bx_cntapplcntrc.append('<li class=\"sch\">".HTML_inp_tx('act_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
										
					$.each(SUMR_Cnt_Appl_Cntrc.applcntrc['ls'], function(k, v) { 
						
						var _sty = '';
						
						if(v.tot > 0){
							if( !isN(v.clr) && v.clr != '#999999' ){
								var _sty = ' style=\"background-color: '+v.clr+'!important \" ';
							}
							var _cls = 'on'; 
						}else{ 
							var _cls = 'off';
						}

						SUMR_Cnt_Appl_Cntrc.bx_cntapplcntrc.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" '+_sty+'> <span>'+v.nm+'</span><figure '+_sty+' style=\"background-image: url(".DIR_IMG_ESTR_SVG."pdf.svg);\" class=\"_bg\"></figure></li>');
					});	
					
					Dom_Rbld();
				}
			";
			
			$CntJV .= "
			
				function TpSet(p){
					try{
						if( !isN(p) ){
							SUMR_Cnt_Appl_Cntrc.applcntrc = {}; SUMR_Cnt_Appl_Cntrc.applcntrc['dt'] = {};		
							if( !isN(p.appl) ){ SUMR_Cnt_Appl_Cntrc.applcntrc['ls'] = p.appl.ls; SUMR_Cnt_Appl_Cntrc.applcntrc['tot'] = p.appl.tot; }
							CntTp_Html();
						}
					}catch(e) {
						SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
					}
				}
			";

			$CntJV .= " 
				_Rqu({ 
					t:'cnt_appl_cntrc',
					_cntappl_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cnt)){
								TpSet(_r.cnt);			
							}
						}
					} 
				});
			";
    	?>
    	
    	<div class="cl_grp_dsh dsh_cnt">
	    	<div class="_c _c1 _anm _scrl">
		        <?php echo h2('<button new-tp="act"></button> '.'Contratos'); ?>
		        <div class="_wrp">
			    	<ul id="bx_act_<?php echo $__Rnd; ?>" class="_ls _anm dls _bx_act"></ul>
		        </div>
	        </div>
        </div>
        
        <style>  
	        .cl_grp_dsh._new ._bx_act{ display: none!important; }
	        .cl_grp_dsh._new ._c._scrl h2 button{ display: inline-block!important; }
	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
			.cl_grp_dsh ._c{ width: 26%; }
	        .cl_grp_dsh ._c._c1{ width: 70%!important; margin: auto; } 
	        .cl_grp_dsh ._c h2{ text-align: center; }    
	        .cl_grp_dsh ._c ul .itm figure._bg{ background-size: 65% auto !important; }     
        </style>   
	</div>  
</div>