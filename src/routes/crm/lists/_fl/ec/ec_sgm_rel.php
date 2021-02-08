<div class="FmTb">

    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 

				var SUMR_Ec_Sgm_Rel = {
					eccmpgsgm_bx : $('#bx_ec_cmpg_smg_".$___Ls->id_rnd."'),
					eccmpgsgm: {},
				};
				
				
				function EcCmpg_Dom_Rbld(){	
					
					var __eccmpgsgm_bx_itm = $('#bx_ec_cmpg_smg_".$___Ls->id_rnd." > li.itm ');	
					
					__eccmpgsgm_bx_itm.not('.sch').off('click').click(function(){
						
						var est = $(this).hasClass('on') ? 'del' : 'in'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'ec_sgm', 
							d:'ec_sgm',
							est:est,
							_id_eccmpg : '".Php_Ls_Cln($__i)."',
							_id_sgm : _id,
							_bs:function(){ SUMR_Ec_Sgm_Rel.eccmpgsgm_bx.addClass('_ld'); },
							_cm:function(){ SUMR_Ec_Sgm_Rel.eccmpgsgm_bx.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){
									if(!isN(_r.cl.ec)){	
										EcCmpgSet(_r.cl.ec);	
									}
								}
							} 
						});
						
					});	
						
					SUMR_Main.LsSch({ str:'#eccmpgsgm_sch_".$___Ls->id_rnd."', ls:__eccmpgsgm_bx_itm });
				
				}
				
				
				function EcCmpg_Html(){
		
					SUMR_Ec_Sgm_Rel.eccmpgsgm_bx.html('');
					SUMR_Ec_Sgm_Rel.eccmpgsgm_bx.append('<li class=\"sch\">".HTML_inp_tx('eccmpgsgm_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');

					if(!isN(SUMR_Ec_Sgm_Rel.eccmpgsgm['ls'])){
						$.each(SUMR_Ec_Sgm_Rel.eccmpgsgm['ls'], function(k, v) { 
							if(!isN(v.tot) && v.tot >= '1'){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Ec_Sgm_Rel.eccmpgsgm_bx.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.html+'</span><span>'+v.fi+'</span></li>');
						});	
					}
					
					EcCmpg_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function EcCmpgSet(p){
					if( !isN(p) ){	
						 
						if( !isN(p.sgm) ){ SUMR_Ec_Sgm_Rel.eccmpgsgm['ls'] = p.sgm.ls; SUMR_Ec_Sgm_Rel.eccmpgsgm['tot'] = p.sgm.tot; }
						EcCmpg_Html();
					}
					EcCmpg_Dom_Rbld();
				}
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'ec_sgm',
					_id_eccmpg : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cl.ec)){	
								EcCmpgSet(_r.cl.ec);	
							}
						}
					} 
				});
				
			";
		}
		
    
    	?>
        
        <div class="cl_grp_dsh dsh_cnt">
	        <div class="_c _c1 _anm _scrl">
		        <?php echo h2('<button new-tp="us"></button> '.'Segmentos'); ?>
		        <div class="_wrp">
			    	<ul id="bx_ec_cmpg_smg_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>	
		        </div>
	        </div>
	    </div>
        
        <style>
	        
	        
	        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
			.cl_grp_dsh ._c{ width: 100%; }
	        .cl_grp_dsh ._c._c1{ width: 100% !important; } 
	        .cl_grp_dsh ._c h2{ text-align: center; }
	        .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative;}
	        .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .cl_grp_dsh ._c ul .itm.prm_tp h2
	        { 
			    display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; 
			    height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; 
			    font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px;
			    -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; 
		    }
		    #bx_ec_cmpg_smg_<?php echo $___Ls->id_rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
		    #bx_ec_cmpg_smg_<?php echo $___Ls->id_rnd ?> li._anm.itm.off{ opacity: 0.5; }
		    #bx_ec_cmpg_smg_<?php echo $___Ls->id_rnd ?> li._anm.itm.off:hover{ opacity: 1; }    
	    </style>      
      </div>
  </div>
</div>