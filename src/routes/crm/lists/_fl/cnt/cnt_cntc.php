<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <?php
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			$CntJV .= " 
			
				__cntcntc_bx_act = $('#bx_act_".$__Rnd."');
				
				function Dom_Rbld(){
					
					__cntcntc_bx_act_itm = $('#bx_act_".$__Rnd." > li.itm ');
					__cntcntc_bx_act_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'cnt_cntc', 
							d:'cntc',
							est: est,
							_cntc_enc : _id,
							_cnt_enc : '".Php_Ls_Cln($__i)."',
							_bs:function(){ __cntcntc_bx_act.addClass('_ld'); },
							_cm:function(){ __cntcntc_bx_act.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cnt)){
										BdSet(_r.cnt);	
									}
								}
							} 
						});
					});
					
					SUMR_Main.LsSch({ str:'#act_sch_".$__Rnd."', ls:__cntcntc_bx_act_itm });
				}

				function CntBd_Html(){
					__cntcntc_bx_act.html('');
					__cntcntc_bx_act.append('<li class=\"sch\">".HTML_inp_tx('act_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
					
					$.each(_cntcntc['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						__cntcntc_bx_act.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><span>'+v.nm+'</span>
						<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
						</li>');
					});	
					
					Dom_Rbld();
				}
			";
			
			$CntJV .= "
			
				function BdSet(p){
					try{
						if( !isN(p) ){
							_cntcntc = {}; _cntcntc['dt'] = {};
							
							if( !isN(p.cntc) ){ _cntcntc['ls'] = p.cntc.ls; _cntcntc['tot'] = p.cntc.tot; }
							
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
						t:'cnt_cntc',
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
		        <?php echo h2('<button new-tp="act"></button> '.'Horarios de contactabilidad'); ?>
		        <div class="_wrp">	     
			    	<ul id="bx_act_<?php echo $__Rnd; ?>" class="_ls _anm dls _bx_act"></ul>
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