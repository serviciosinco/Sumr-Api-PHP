<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<?php $___Ls->_bld_f_hdr(); ?>     
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
					
					
					var SUMR_Bco = {
						are : $('#bx_are_".$__Rnd."'),
						bcoare: {},
					};
					
					
					function Dom_Rbld(){
						
						var __bco_bx_are_itm = $('#bx_are_".$__Rnd." li.itm.are ');
						
						__bco_bx_are_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							_Rqu({ 
								t:'bco_are', 
								d:'are',
								est: est1,
								_id_are : _id,
								_id_bco : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_bs:function(){ SUMR_Bco.are.addClass('_ld'); },
								_cm:function(){ SUMR_Bco.are.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.bco)){
											ClSet(_r.bco);			
										}
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#are_sch_".$__Rnd."', ls: __bco_bx_are_itm });
						
					}
					
					function ClGrpAre_Html(){

						SUMR_Bco.are.html('');
						SUMR_Bco.are.append('<li class=\"sch\">".HTML_inp_tx('are_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Bco.bcoare['ls'], function(k, v) {

							if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							if(!isN(v.img)){
								if(!isN(v.img.sm_s)){ var img = v.img.sm_s; }else{ var img = v.img; }
							}else{ var img = ''; }
							SUMR_Bco.are.append('<li class=\"_anm itm are '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
						});	
						
						$('#tot_are_".$__Rnd."').html( SUMR_Bco.bcoare['tot'] );
						
						Dom_Rbld();
					}

				";

				$CntJV .= "

					function ClSet(p){
						if( !isN(p) ){
							if( !isN(p.are) ){ SUMR_Bco.bcoare['ls'] = p.are.ls; SUMR_Bco.bcoare['tot'] = p.are.tot; }
							ClGrpAre_Html();
						}
					}	
						
				";
				
				$CntJV .= " 
					_Rqu({ 
						t:'bco_are', 
						_id_bco : '".Php_Ls_Cln($___Ls->gt->isb)."',
						_cl:function(_r){
							console.log(_r);
							if(!isN(_r)){
								if(!isN(_r.bco)){
									ClSet(_r.bco);			
								}
							}
						} 
					});
				";
	    ?>
	        <div class="bco_are_dsh dsh_cnt lead_data">
	            <div class="_c _c3 _anm _scrl">
			        <?php echo h2('<button new-tp="are"></button>'.TX_ARE); ?>
			        <div class="_wrp">
				    	<ul id="bx_are_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
				    	<div class="_new_fm" id="bx_fm_are_<?php echo $__Rnd; ?>"></div>   
				    </div>
		        </div>	   
	        </div>
	        <style>
		        
		        .bco_are_dsh{ text-align: center; margin-top: 10px; display: flex; }
				.bco_are_dsh ._c{ width: 100%; }
		        .bco_are_dsh ._c._c1{ width: 20%; } 
		        .bco_are_dsh ._c._c1 h2{ text-align: right; } 
		        .bco_are_dsh ._c h2{ text-align: center; }  

	        </style>   
		</div>
  </div>
</div>