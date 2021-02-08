<div id="<?php  echo DV_GNR_FM ?>">
	<?php $___Ls->_bld_f_hdr(); ?>     
	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <?php 
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			$CntJV .= " 
			
				__org_bx_orgtp = $('#bx_orgtp_".$__Rnd."');
				
				function Dom_Rbld(){
					
					__org_bx_orgtp_itm = $('#bx_orgtp_".$__Rnd." li.itm.orgtp ');
					__org_bx_fm_orgtp = $('#bx_fm_orgtp_".$__Rnd."');
					
					__org_bx_orgtp_itm.off('click').click(function(){
						$(this).hasClass('on') ? est1 = 'del' : est1 = 'in'; 		
						var _id = $(this).attr('rel');
						_Rqu({ 
							t:'org_tp', 
							d:'tp',
							est: est1,
							_org_tp : _id,
							_id_org : '".Php_Ls_Cln($___Ls->gt->isb)."',
							
							_bs:function(){ __org_bx_orgtp.addClass('_ld'); },
							_cm:function(){ __org_bx_orgtp.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.org)){
										ClSet(_r.org.tp);
									}
								}
							} 
						});
					});
					
				}

				
				function ClMdlFm_Html(){

					__org_bx_orgtp.html('');
					
					$.each(_clorgtp['ls'], function(k, v) {

						if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						__org_bx_orgtp.append('<li class=\"_anm itm orgtp '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\">'+v.nm+'</li>');
					});	
					
					$('#tot_orgtp_".$__Rnd."').html( _clorgtp['tot'] );
					
					Dom_Rbld();
				}
			";
			
			$CntJV .= "
				function ClSet(p){
					if( !isN(p) ){
						_clorgtp = {}; 
						if( !isN(p) ){ _clorgtp['ls'] = p.ls; _clorgtp['tot'] = p.tot; }
						ClMdlFm_Html();
					}
				}		
			";
			
			$CntJV .= " 
				_Rqu({ 
					t:'org_tp',
					_id_org : '".Php_Ls_Cln($___Ls->gt->isb)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.org)){
								ClSet(_r.org.tp);
							}
						}
					} 
				});
			";
    ?>
        <div class="cl_orgtp">
	        <div class="_wrp">
		    	<ul id="bx_orgtp_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
		    	<div class="_new_orgtp" id="bx_fm_orgtp_<?php echo $__Rnd; ?>"></div>   
		    </div> 	   
        </div>
        
        <style>
	    
	        .cl_orgtp{}
	        .cl_orgtp ._ls{ list-style-type: none; padding: 0; margin: 0; width: 100%; display: flex; margin-top: 10px; }
	        .cl_orgtp ._ls li{ width: auto; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background-repeat: no-repeat; background-position: left 10px center; background-size: auto 50%; border: 1px dotted #fff; text-align: center; padding: 10px 10px 10px 30px; opacity: 0.6; line-height: 11px; font-size: 11px; cursor: pointer; margin-right: 6px; color: #fff; } 
		    .cl_orgtp ._ls li.on,
		    .cl_orgtp ._ls li:hover{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_tp_on.svg); opacity: 1; }
		    .cl_orgtp ._ls li.off{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_tp_off.svg); }
		    
        
        </style>   
        
	</div>
	</div>