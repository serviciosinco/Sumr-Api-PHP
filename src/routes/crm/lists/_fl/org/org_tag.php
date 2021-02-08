<div class="FmTb">
    <div id="<?php  echo DV_GNR_FM ?>">     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <?php

			$CntJV .= " 
			
				__orgtag_bx_sch = $('#bx_org_tag_".$__Rnd."');

				function OrgTag_Dom_Rbld(){
					
					__orgtag_bx_sch_itm = $('#bx_org_tag_".$__Rnd." > li.itm ');
					__orgtag_bx_sch_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
						var _id = $(this).attr('rel');

						_Rqu({ 
							t:'org_tag', 
							d:'tag',
							est:est,
							_org_enc : '".Php_Ls_Cln($__i)."',
							_id_tag : _id,
							_bs:function(){ __orgtag_bx_sch.addClass('_ld'); },
							_cm:function(){ __orgtag_bx_sch.removeClass('_ld'); },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.org)){
										OrgTagSet(_r.org);			
									}
								}
							} 
						});	
					});	
				}
				
				
				function OrgTag_Html(){
		
					__orgtag_bx_sch.html('');

					if(!isN(_orgtag['ls'])){
						$.each(_orgtag['ls'], function(k, v) { 
							if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							__orgtag_bx_sch.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
						});	
					}
					
					OrgTag_Dom_Rbld();
				}
				
					
			";
			
			$CntJV .= "
			
				function OrgTagSet(p){
					if( !isN(p) ){	
						_orgtag = {}; 
						if( !isN(p.tag) ){ _orgtag['ls'] = p.tag.ls; _orgtag['tot'] = p.tag.tot; }
						OrgTag_Html();
					}
					OrgTag_Dom_Rbld();
				}
			";

			$CntJV .= " 
			
				_Rqu({ 
					t:'org_tag', 
					_org_enc : '".Php_Ls_Cln($__i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.org)){
								OrgTagSet(_r.org);			
							}
						}
					} 
				});
				
			";
        ?>
        
        <div class="org_tag_dsh dsh_cnt">
	        <div class="_c _c1 _anm ">
		        <?php echo h2('Etiquetas'); ?>
		        <div class="_wrp">
			    	<ul id="bx_org_tag_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	 
		        </div>
	        </div>
	    </div>
        
        <style>
	        
	        .org_tag_dsh{ text-align: center; margin-top: 10px; display: flex; }
			.org_tag_dsh ._c{ width: 100%; }
	        .org_tag_dsh ._c._c1{ width: 40% !important; margin: 0 auto; } 
	        .org_tag_dsh ._c h2{ text-align: center; }
	        .org_tag_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative;}
	        .org_tag_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .org_tag_dsh ._c ul .itm.prm_tp h2
	        { 
			    display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; 
			    height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; 
			    font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px;
			    -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; 
		    }
		    #bx_org_tag_<?php echo $__Rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
		    #bx_org_tag_<?php echo $__Rnd ?> li._anm.itm.off{ opacity: 0.5; }
		    #bx_org_tag_<?php echo $__Rnd ?> li._anm.itm.off:hover{ opacity: 1; }    
	    </style>      
      </div>
  </div>
</div>