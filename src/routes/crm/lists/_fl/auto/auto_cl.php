<div id="<?php  echo DV_GNR_FM ?>">
	<?php $___Ls->_bld_f_hdr(); ?>     
	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <?php 
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			$CntJV .= " 
			
				__auto_bx_autocl = $('#bx_autocl_".$__Rnd."');
				
				function Dom_Rbld(){
					
					__auto_bx_autocl_itm = $('#bx_autocl_".$__Rnd." li.itm.autocl ');
					__auto_bx_fm_autocl = $('#bx_fm_autocl_".$__Rnd."');
					
					__auto_bx_autocl_itm.off('click').click(function(){
						$(this).hasClass('on') ? est = '2' : est = '1'; 		
						var _id = $(this).attr('rel');
						_Rqu({ 
							t:'auto_cl', 
							d:'auto',
							est: est,
							_id_cl : _id,
							_id_auto : '".Php_Ls_Cln($___Ls->gt->i)."',
							
							_bs:function(){ __auto_bx_autocl_itm.addClass('_ld'); },
							_cm:function(){ __auto_bx_autocl_itm.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.auto)){
										ClSet(_r.auto.cl);
									}
								}
							} 
						});
					});
					
				}

				
				function ClMdlFm_Html(){

					__auto_bx_autocl.html('');
					
					$.each(_clautocl['ls'], function(k, v) {

                        if(v.est == 1){ var _cls = 'on'; }else{ var _cls = 'off'; }
                        if(!isN(v.img)){ var _img = v.img; }else{ var _img = ''; }
						__auto_bx_autocl.append('<li class=\"_anm itm autocl '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure class=\"_anm\" style=\"background-image: url(".DMN_FLE_CL_TH."'+_img+')\"></figure><p>'+v.nm+'</p></li>');
					});	
					
					$('#tot_autocl_".$__Rnd."').html( _clautocl['tot'] );
					
					Dom_Rbld();
				}
			";
			
			$CntJV .= "
				function ClSet(p){
					if( !isN(p) ){
                        _clautocl = {}; 
                            
						if( !isN(p) ){ 
                            _clautocl['ls'] = p.ls; _clautocl['tot'] = p.tot; 
                        }

						ClMdlFm_Html();
					}
				}		
			";
			
			$CntJV .= " 
				_Rqu({ 
					t:'auto_cl',
					_id_auto : '".Php_Ls_Cln($___Ls->gt->i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.auto)){
                                ClSet(_r.auto.cl);
							}
						}
					} 
				});
			";
    ?>
        <div class="cl_autocl">
	        <div class="_wrp">
		    	<ul id="bx_autocl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
		    	<div class="_new_autocl" id="bx_fm_autocl_<?php echo $__Rnd; ?>"></div>   
		    </div> 	   
        </div>
        
        <style>

		._ld{ animation: _blnk 0.8s cubic-bezier(.5,0,1,1) infinite alternate; pointer-events: none;}
	    
        .cl_autocl ._ls{list-style-type:none;padding:0;margin:0 auto;display:flex;margin-top:10px;flex-wrap:wrap;width:80%;justify-content:center}
        .cl_autocl ._ls li{margin:0 15px;cursor:pointer;display:inline-block;vertical-align:top;position:relative}
        .cl_autocl ._ls .autocl figure{width:40px;border:1px solid #afafaf;height:40px;background-size:100% auto;background-position:center;border-radius:50%;background-repeat:no-repeat;margin:0 auto}
        .cl_autocl ._ls li._anm.itm.autocl.off figure{-webkit-filter:grayscale(100%);filter:grayscale(100%);opacity:.5}
        .cl_autocl ._ls li._anm.itm.autocl.on figure{-webkit-filter:grayscale(0%);filter:grayscale(0%);opacity:1;border:2px solid var(--main-bg-color)}
        .cl_autocl ._ls li._anm.itm.autocl.off:hover figure{opacity:1}
        .cl_autocl ._ls li:hover figure{background-size:110% auto}
        .cl_autocl ._ls .autocl p{width:100px;text-align:center;margin-top:10px!important;font-size:12px}
        .cl_autocl ._ls li.on figure:before{content:"";width:20px;height:20px;display:block;bottom:-5px;position:absolute;right:-5px;border-radius:50%;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>checked.svg);border:1px solid #fff}
        .cl_autocl ._ls li.off figure:before{content:"";width:20px;height:20px;display:block;bottom:-5px;position:absolute;right:-5px;border-radius:50%;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg);border:1px solid #fff}
        </style>   
        
	</div>
	</div>