<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
            <?php 

		        $__Rnd = Gn_Rnd(20);
                $CntJV .= " 
                
                    SUMR_Us_Grp = {
                        bx: $('#bx_grp_".$__Rnd."'),
                        ls: {}
                    };
					
					function Dom_Rbld(){
						
                        var usclgrp_itm = $('#bx_grp_".$__Rnd." li.itm.grp ');
                        
						usclgrp_itm.not('.sch').off('click').click(function(){
							$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'us_grp', 
								d:'grp',
								est: est,
								_id_grp : _id,
								_id_us : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_bs:function(){ SUMR_Us_Grp.bx.addClass('_ld'); },
								_cm:function(){ SUMR_Us_Grp.bx.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.us)){
											ClSet(_r.us);			
										}
									}
								} 
							});
                        });
                        
						SUMR_Main.LsSch({ str:'#grp_sch_".$__Rnd."', ls:usclgrp_itm });
						
					}
					
					function ClGrpAre_Html(){

						SUMR_Us_Grp.bx.html('');
						SUMR_Us_Grp.bx.append('<li class=\"sch\">".HTML_inp_tx('grp_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						if(!isN(SUMR_Us_Grp.ls)){
							$.each(SUMR_Us_Grp.ls, function(k, v) {
                                if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								SUMR_Us_Grp.bx.append('<li class=\"_anm itm grp '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
							});	
						}
						
						Dom_Rbld();
					}
				";
				
				$CntJV .= "
				
				
				function ClSet(p){
					if( !isN(p) ){
						if( !isN(p.grp) ){ SUMR_Us_Grp.ls = p.grp.ls; }
						ClGrpAre_Html();
					}
				}		
			";
				$CntJV .= " 
					_Rqu({ 
						t:'us_grp', 
						_id_us : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.us)){
									ClSet(_r.us);			
								}
							}
						} 
					});
					
				";
	    ?>
	        <div class="cl_mdl_grp_dsh dsh_cnt lead_data">
		        <div class="_c _c3 _anm _scrl" style="margin: 0 auto;">
			        <?php echo h2(TX_GRP); ?>
			        <div class="_wrp">
				    	<ul id="bx_grp_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_grp_<?php echo $__Rnd; ?>"></div>   
				    </div>
		        </div> 	   
	        </div>  
		</div>
    </div>
</div>