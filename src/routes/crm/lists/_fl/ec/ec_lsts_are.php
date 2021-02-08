<div class="FmTb">

    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);

			$CntJV .= " 
			
				__ec_lsts_are_bx = $('#bx_ec_lsts_".$__Rnd."');

				function EcLsts_Dom_Rbld(){
					
					__ec_lsts_are_bx_sch_itm = $('#bx_ec_lsts_".$__Rnd." > li.itm ');

					__ec_lsts_are_bx_sch_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'ec_lsts_are', 
							d:'are',
							est:est,
							_lsts_enc : '".Php_Ls_Cln($__i)."',
							_id_are : _id,
							_bs:function(){ __ec_lsts_are_bx.addClass('_ld'); },
							_cm:function(){ __ec_lsts_are_bx.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.ec)){
										EcLstsSet(_r.ec);			
									}
								}
							} 
						});
						
					});	
					
					SUMR_Main.LsSch({ str:'#sch_are_".$___Ls->id_rnd."', ls:__ec_lsts_are_bx_sch_itm });
				
				}
				
				
				function EcLstsAre_Html(){
		
					__ec_lsts_are_bx.html('');
					__ec_lsts_are_bx.append('<li class=\"sch\">".HTML_inp_tx('sch_are_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');
					
					if(!isN(_eclstsare['ls'])){
						$.each(_eclstsare['ls'], function(k, v) { 
							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							__ec_lsts_are_bx.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
						});	
					}
					
					EcLsts_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function EcLstsSet(p){
					if( !isN(p) ){	
						_eclstsare = {}; 
						if( !isN(p.lsts.are) ){ _eclstsare['ls'] = p.lsts.are.ls; _eclstsare['tot'] = p.lsts.are.tot; }
						EcLstsAre_Html();
					}
					EcLsts_Dom_Rbld();
				}
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'ec_lsts_are', 
					_lsts_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.ec)){
								EcLstsSet(_r.ec);		
							}
						}
					} 
				});
				
			";
		}
			
    
    ?>
        
        <div class="ec_lsts_are_dsh dsh_cnt">
	     
	        <div class="_c _c1 _anm _scrl">
		        <?php echo h2('<button new-tp="are"></button> '.TX_ARE); ?>
		        <div class="_wrp">
			    	<ul id="bx_ec_lsts_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
			    	<div class="_new_fm" id="bx_fm_us_<?php echo $__Rnd; ?>"></div>	 
		        </div>
	        </div>
	    </div>
        
        <style>
	        
	        .ec_lsts_are_dsh{ text-align: center; margin-top: 10px; display: flex; }
			.ec_lsts_are_dsh ._c{ width: 100%; }
	        .ec_lsts_are_dsh ._c._c1{ width: 100% !important; } 
	        .ec_lsts_are_dsh ._c h2{ text-align: center; }
	        .ec_lsts_are_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative;}
	        .ec_lsts_are_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .ec_lsts_are_dsh ._c ul .itm.prm_tp h2
	        { 
			    display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; 
			    height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; 
			    font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px;
			    -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; 
		    }
		    #bx_ec_lsts_<?php echo $__Rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
		    #bx_ec_lsts_<?php echo $__Rnd ?> li._anm.itm.off{ opacity: 0.5; }
		    #bx_ec_lsts_<?php echo $__Rnd ?> li._anm.itm.off:hover{ opacity: 1; }    
	    </style>      
      </div>
  </div>
</div>