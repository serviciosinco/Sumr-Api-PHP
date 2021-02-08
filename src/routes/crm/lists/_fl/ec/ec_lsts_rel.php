<div class="FmTb">

    <div id="<?php  echo DV_GNR_FM ?>">

    	<?php $___Ls->_bld_f_hdr(); ?>      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 

				var SUMR_Ec_Lsts_Rel = {
					eccmpglsts_bx : $('#bx_ec_cmpg_lsts_".$___Ls->id_rnd."'),
					eccmpglsts: {},
				};
				
				
				function EcCmpg_Dom_Rbld(){	
					
					var __eccmpglsts_bx_itm = $('#bx_ec_cmpg_lsts_".$___Ls->id_rnd." > li.itm ');	
					
					__eccmpglsts_bx_itm.not('.sch').off('click').click(function(){
						
						var est = $(this).hasClass('on') ? 'del' : 'in'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'ec_lsts', 
							d:'ec_lsts',
							est:est,
							_id_eccmpg : '".Php_Ls_Cln($__i)."',
							_id_lsts : _id,
							_bs:function(){ SUMR_Ec_Lsts_Rel.eccmpglsts_bx.addClass('_ld'); },
							_cm:function(){ SUMR_Ec_Lsts_Rel.eccmpglsts_bx.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){
									if(!isN(_r.cl.ec)){	
										EcCmpgSet(_r.cl.ec);	
									}
								}
							} 
						});
						
					});	
						
					SUMR_Main.LsSch({ str:'#eccmpglsts_sch_".$___Ls->id_rnd."', ls:__eccmpglsts_bx_itm });
				
				}
				
				
				function EcCmpg_Html(){
		
					SUMR_Ec_Lsts_Rel.eccmpglsts_bx.html('');
					SUMR_Ec_Lsts_Rel.eccmpglsts_bx.append('<li class=\"sch\">".HTML_inp_tx('eccmpglsts_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');

					if(!isN(SUMR_Ec_Lsts_Rel.eccmpglsts['ls'])){
						$.each(SUMR_Ec_Lsts_Rel.eccmpglsts['ls'], function(k, v) { 
							if(!isN(v.tot) && v.tot >= '1'){ var _cls = 'on'; }else{ var _cls = 'off'; }
							
							if(!isN(v.img)){
								if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
							}else{ img=''; }

							SUMR_Ec_Lsts_Rel.eccmpglsts_bx.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
						});	
					}
					
					EcCmpg_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function EcCmpgSet(p){
					if( !isN(p) ){	
						 
						if( !isN(p.lsts) ){ SUMR_Ec_Lsts_Rel.eccmpglsts['ls'] = p.lsts.ls; SUMR_Ec_Lsts_Rel.eccmpglsts['tot'] = p.lsts.tot; }
						EcCmpg_Html();
					}
					EcCmpg_Dom_Rbld();
				}
			";
		
		if($__i){

			$CntJV .= " 
			
				_Rqu({ 
					t:'ec_lsts',
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
		        <?php echo h2('<button new-tp="us"></button> '.'Listas'); ?>
		        <div class="_wrp">
			    	<ul id="bx_ec_cmpg_lsts_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>	
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
		    #bx_ec_cmpg_lsts_<?php echo $___Ls->id_rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
		    #bx_ec_cmpg_lsts_<?php echo $___Ls->id_rnd ?> li._anm.itm.off{ opacity: 0.5; }
		    #bx_ec_cmpg_lsts_<?php echo $___Ls->id_rnd ?> li._anm.itm.off:hover{ opacity: 1; }   
		    
		    .dsh_cnt ._c ul .itm figure{ 
			    	left: -10px;
			    background-size: 70% auto;
		    }
		    
		    .dsh_cnt ._c ul .itm.on figure {
			    background-color: #ffffff;
			    border: 2px solid #0db55e;
			}
		     
	    </style>      
      </div>
  </div>
</div>