<div class="___org_sds_act _sch step1 _anm" style="width: 500px; margin: 0 auto;">
	<div class="_cblq">
		<?php echo _HTML_Input('Clg_Act_Sch'.$__id_rnd, 'Escribe el nombre del colegio', '', FMRQD, 'text', ['ac'=>'off']); ?>
		<button class="_sch_go _anm" id="Clg_Act_Sch_Btn_Act<?php echo $__id_rnd ?>"></button>
	</div>
	<div class="_lst_clg" style="display: block;" id="Clg_Ls<?php echo $__id_rnd ?>">
		<ul id="bx_orgact_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>
	</div>
</div>

<?php $CntWb .="
		var SUMR_Dsh_Org_Act = {
	        orgact:{}
	    }; 
	
	    function Dom_Rbld(){
	
	        var __mdls_bx_orgact_act_itm = $('#bx_orgact_".$__id_rnd." > li.itm ');
	        
	        __mdls_bx_orgact_act_itm.not('.sch').off('click').click(function(){
	        
	            $(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
	            var _id = $(this).attr('data-id');
	
	            _Rqu({ 
	                t:'act_org', 
	                d:'mod',
	                est: est,
	                _id_act : '".Php_Ls_Cln($__i)."',
	                _id_org : _id,
	                _bs:function(){ $('.___org_sds_act').addClass('_ld'); },
	                _cm:function(){ $('.___org_sds_act').removeClass('_ld'); },
	                _cl:function(_r){ 
	                	if(!isN(_r)){ 
	                		if(!isN(_r)){ 
	                			MdlActSet(_r); 
	                		} 
	                	} 
	                } 
	            });
	            
	        });
	        
	        SUMR_Main.LsSch({ str:'#Clg_Act_Sch".$__id_rnd."', ls:__mdls_bx_orgact_act_itm });
	    }
	
		function MdlAct_Html(){
	        var __mdls_bx_orgact_act_itm = $('#bx_orgact_".$__id_rnd."');
	
			__mdls_bx_orgact_act_itm.html('');
			var est = SUMR_Dsh_Org_Act.orgact['dt'].tp;
			var tot = SUMR_Dsh_Org_Act.orgact['dt'].tot;
			var _el = '';

			if(tot == 0){
				var _img = 'background-image:url(https://uexternado.sumr.co/_img/estr/svg/none.svg)';
				_el = _el+'<li style=\"'+_img+'\" class=\"_anm tot_0\"><p>Sin resultados</p></li>';	
			}else{
				if(!isN(SUMR_Dsh_Org_Act.orgact['ls'])){
					
					$.each(SUMR_Dsh_Org_Act.orgact['ls'], function(k, v) { 
						
						if(!isN(v.img) && !isN(v.img.th_100)){
							var _cls = '';
							var _img = 'background-image:url('+v.img.th_100+')';
						}else{
							var _img = '';
							var _cls = 'empty';
						} 
						
						_el = _el+'<li class=\"_anm item itm '+est+'\" data-id=\"'+v.id+'\">
										<figure	style=\"'+_img+'\" class=\"'+_cls+' _anm\"></figure>
										<div class=\"_tx _anm\">
											'+v.nm+'
											<span>'+v.cd.tt+'</span>
										</div>	
									</li>';
										
					});
				}
			}
	        
	        __mdls_bx_orgact_act_itm.append(_el);	
	        
	        Dom_Rbld();
	    }
	
		function MdlActSet(p){
	        if( !isN(p) ){ 
	
	            if( !isN(p.clg) ){ 
	                SUMR_Dsh_Org_Act.orgact['ls'] = p.clg.ls; 
	                SUMR_Dsh_Org_Act.orgact['dt'] = p.clg;
	            }
	            
	            MdlAct_Html();
	        }
	    }
	
		$('#Clg_Act_Sch_Btn_Act".$__id_rnd."').off('click').click(function(e){
			e.preventDefault();
			var vl = $('#Clg_Act_Sch".$__id_rnd."');
			if(!isN( vl.val() ) ){
				if(e.target != this){
			       e.stopPropagation();
				   return;
				}else{

					_Rqu({ 
			            t:'act_org',
						sch : vl.val(),
						_bs:function(){ $('.___org_sds_act').addClass('_ld'); },
	                	_cm:function(){ $('.___org_sds_act').removeClass('_ld'); },
			            _cl:function(_r){
			                if(!isN(_r)){ 
								vl.val('');
			                    MdlActSet(_r);
			                }
			            } 
					});
					
				}	
			}else{
				__Rqu();	
			}
		});

		$('#Clg_Act_Sch').keyup(function(e) {
			if(e.keyCode == 13) {
				e.preventDefault();
				var vl = $('#Clg_Act_Sch".$__id_rnd."');

				if(!isN( vl.val() ) ){
					if(e.target != this){
						e.stopPropagation();
						return;
					}else{
						_Rqu({ 
							t:'act_org',
							sch : vl.val(),
							_bs:function(){ $('.___org_sds_act').addClass('_ld'); },
							_cm:function(){ $('.___org_sds_act').removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){ 
									vl.val('');
									MdlActSet(_r);
								}
							} 
						});
					}	
				}else{
					__Rqu();	
				}
			}
		});

		__Rqu();

		function __Rqu(){
			_Rqu({ 
				t:'act_org',
				d:'dt',
				_id_act : '".Php_Ls_Cln($__i)."',
				_bs:function(){ $('.___org_sds_act').addClass('_ld'); },
	        	_cm:function(){ $('.___org_sds_act').removeClass('_ld'); },
				_cl:function(_r){
					if(!isN(_r)){ 
						MdlActSet(_r);
					}
				} 
			});
		}
	"; ?>
	
<style>
._cblq{position:relative}
._sch_go{position:absolute;right:6px;top:6px;background-color:#a2aaae;border-radius:200px;-moz-border-radius:200px;-webkit-border-radius:200px;width:30px;height:30px;background-image:url(<?php echo DIR_IMG_ESTR_SVG ?>ls_sch.svg);background-repeat:no-repeat;background-position:center center;background-size:60% auto;opacity:.6;cursor:pointer}
input#Clg_Act_Sch{font-family:"Lato",Verdana,Geneva,sans-serif;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;border:1px solid #999;width:100%;font-size:var(--font-s-inp);margin-bottom:5px;background-color:#FFF;background-position:right 10px center;background-size:auto 50%;text-align:center;padding:12px 20px}
._lst_clg ul li{text-align:center;width:100%;border-bottom:1px solid #e6ebec;padding-top:20px;padding-bottom:20px;text-align:center;align-items:center;justify-content:center;cursor:pointer;position:relative}
._lst_clg ul li figure{margin:0;padding:0;width:40px;height:40px;border-radius:200px;-moz-border-radius:200px;-webkit-border-radius:200px;border:2px solid #abb1b3;background-size:cover;background-position:center center;background-repeat:no-repeat;margin-right:10px;display:inline-block;position:relative;margin-bottom:-6px}
._lst_clg ul li ._tx{display:inline-block;font-family:Economica;text-transform:uppercase;font-size:16px}
._lst_clg ul li ._tx span{color:#bbbebf;font-weight:300;font-family:Economica;font-size:14px;display:block;width:100%}
._lst_clg ul{list-style:none;margin:0;padding:0}
._lst_clg ul li:hover{background-color:#e8e8e8}
._lst_clg ul li:hover figure{border:1px solid #a2a2a2}
._lst_clg ul li.on:before{content:"x";color:#fff;width:20px;font-size:15px;height:20px;vertical-align:middle;background-color:#e05b5b;display:none;border-radius:50%;position:absolute;top:-4px;text-align:center;right:-9px}
._lst_clg ul li:hover:before{display:block}
._lst_clg ul li figure.empty:before{content:'';background-image:url(<?php echo DIR_IMG_ESTR_SVG ?>none.svg);background-size:auto 60%;background-repeat:no-repeat;background-position:center center;width:30px;height:30px;background-color:#c8cbcc;border-radius:200px;-moz-border-radius:200px;-webkit-border-radius:200px;opacity:.3;position:absolute;left:3px;top:3px}
._lst_clg ul li._anm.tot_0 {background-repeat: no-repeat;background-position: center;height: 150px;margin: 40px 0;border: 0;opacity: 0.2;color: black;position: relative;}
._lst_clg ul li._anm.tot_0 p{ position: absolute;left: 50%;top: 100%;font-size: 16px;transform: translate(-50%, -50%);-webkit-transform: translate(-50%, -50%);}
.___org_sds_act._sch.step1._anm._ld {background-image: url(<?php echo DIR_IMG_ESTR_SVG ?>mail_loader.svg) !important;background-repeat: no-repeat;background-position: 50% 250px;background-size: 30px 30px;min-height: 500px;}
.___org_sds_act._sch.step1._anm._ld li {opacity: 0.4;}
</style>