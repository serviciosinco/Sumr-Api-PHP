<?php 
	$__rnd_op = Gn_Rnd(20);	
?>
<section class="___myeml">
	<nav>
		<div id="useml_nav">
			<div class="acc_slc" id="useml_acc"></div>
			<ul class="_anm no-draggable-area"></ul>
		</div>
		
		<div id="__ld_useml_nav" class="_anm __ld">
			<?php echo bdiv(['cls'=>'icn blnk']).h2(TX_EML_LDNAV); ?>
		</div>
		
	</nav>
	<section class="list">
		<div id="__ld_useml_msg" class="_anm __ld ">
			<?php echo bdiv(['cls'=>'icn blnk']).h2(TX_EML_LDLS); ?>
		</div>
		<nav>
			<div class="nav_bx">
				<div class="_nmr"></div>
				<button class="_anm prv" <?php /*?>disabled="true"<?php*/ ?>></button>
				<button class="_anm nxt" <?php /*?>disabled="true"<?php*/ ?>></button>
			</div>	
			<div class="sch_bx">
				<div class="sch_tx_bx">
					<input type="text" id="__useml_sch">
					<button class="opt"></button>
					<button class="sch_clr"></button>
					<button class="sch"></button>
				</div>	
				<div class="sch_op_bx _anm">
					<?php echo HTML_inp_tx('__useml_sch_from', TX_MAIL_FROM);  ?>
					<?php echo HTML_inp_tx('__useml_sch_to', TX_MAIL_TO);  ?>
					<?php echo HTML_inp_tx('__useml_sch_subj', TX_MAIL_SBJ);  ?>	
					<?php echo HTML_inp_tx('__useml_sch_wrd', TX_MAIL_WRD);  ?>	
				</div>
			</div>
		</nav>
		<div id="useml_msg" class="ls"></div>
	</section>
</section>

<?php 
	
	$CntJV .= "
		
		function __eml_domrbld_o(){
			
			__eml_o_acc = $('#useml_acc');	
			__eml_o_acc_itm = $('#useml_acc ._acc_p:not(._mre)');
			__eml_o_acc_itm_mre = $('#useml_acc ._acc_p._mre');	
			__eml_o_acc_itm_stup = $('#useml_acc ._acc_p .stup');
			
			
			__eml_o_acc_box = $('.Dsh_Scl .eml_acc');
			
			
			__eml_o_acc_dt_nm = $('.Dsh_Scl .eml_acc ._data._nm .tx');
			__eml_o_acc_dt_eml = $('.Dsh_Scl .eml_acc ._data._eml .tx');
			__eml_o_acc_dt_tp = $('.Dsh_Scl .eml_acc ._data._tp .tx');
			__eml_o_acc_dt_srv_in = $('.Dsh_Scl .eml_acc ._data._srv_in .tx');
			__eml_o_acc_dt_prt_in = $('.Dsh_Scl .eml_acc ._data._prt_in .tx');
			__eml_o_acc_dt_srv_out = $('.Dsh_Scl .eml_acc ._data._srv_out .tx');
			__eml_o_acc_dt_prt_out = $('.Dsh_Scl .eml_acc ._data._prt_out .tx');
			__eml_o_acc_dt_usr = $('.Dsh_Scl .eml_acc ._data._usr .tx');
			
						
						
			
			__eml_o_nav = $('#useml_nav ul');	
			__eml_o_nav_ldr = $('#__ld_useml_nav');
			
			__eml_o_bx = $('#useml_msg');
			__eml_o_bx_ldr = $('#__ld_useml_msg');
			__eml_o_bx_ovr = $('#__useml_ovr');
			
			__eml_o_btn_nxt = $('.___myeml nav .nxt');
			__eml_o_btn_prv = $('.___myeml nav .prv');
			__eml_o_btn_sch = $('.___myeml .list nav .sch_bx button.sch');
			__eml_o_btn_sch_clr = $('.___myeml .list nav .sch_bx button.sch_clr');
			__eml_o_btn_opt = $('.___myeml .list nav .sch_bx button.opt');
	
			__eml_o_txt_sch = $('#__useml_sch');
			__eml_o_txt_sch_bx = $('.___myeml .sch_bx');
			__eml_o_txt_sch_op = $('.___myeml .sch_op_bx');
			
			
			__eml_o_txt_sch_from = $('#__useml_sch_from');
			__eml_o_txt_sch_to = $('#__useml_sch_to');
			__eml_o_txt_sch_subj = $('#__useml_sch_subj');
			__eml_o_txt_sch_wrd = $('#__useml_sch_wrd');
			
		}
		

		__eml_domrbld_o();
		__eml_iduseml='';
		__eml_inboxid = '';
		__eml_inboxsch = '';
		__eml_navok = '';
		__eml_accstup = '';
		
		function __eml_ac(p){
			var __eml = '';
			if(!isN(p) && !isN(p.eml)){ 
				var __eml =p.eml; 
				SUMR_Main.scl.f.SclEmlS({ o:'ac', v:p.eml }); 
			}
			__eml_gt_acc();
			__eml_gt_nav(); 
			__eml_gt_thrd_ls({ eml:__eml }); 
		}
		
		
		function __eml_gt_nav(p){	
			__eml_html({ t:'nav' });		
		}
		
		function __eml_sch_clr(){
			__eml_o_txt_sch.val(''); 
			__eml_inboxsch = '';
			__eml_o_txt_sch_bx.removeClass('_on');
		}
		
		
		function __eml_html(p){
			
			var _html='';
			var _html_tr='';
			
			
			if(p.t == 'nav'){
				
				__eml_o_nav.html('');
				_bx = SUMR_Main.scl.f.SclEmlG({ o:'box' });
				
				if(!isN(_bx) && !isN(_bx.ls)){
					
					if(__eml_navok != 'ok'){ __eml_o_nav_ldr.addClass('_on'); }
					
					$.each(_bx.ls, function(box_k, box_v) {
						
						if($(document).find('[nav-id='+box_v.enc+']').length==0){ 
							
							if(!isN(box_v.box) && !isN(box_v.box.no_read) && box_v.box.no_read > 0){ 
								no_read = box_v.box.no_read; 
							}else{ 
								no_read = ''; 
							}
							
							if(!isN(box_v.ord) && box_v.ord == 1){ var _cls = ' selected'; }else{ var _cls = ''; }
							
							__eml_o_nav.append('<li class=\"\ _btn '+box_v.enc + _cls +'\" rel=\"'+box_v.enc+'\" nav-id=\"'+box_v.enc+'\" nav-ord=\"'+box_v.ord+'\">
													<div class=\"_anm icn '+box_v.cls+'\">
														<span>'+no_read+'</span>
													</div>'+box_v.nm+'
													<div class=\"_anm icn myrfrsh\"></div>
												</li>');
							
							__eml_navok = 'ok';						
							
						}	
								
					});
					
					setTimeout(function(){ __eml_o_nav_ldr.removeClass('_on'); }, 500);

				}

				
				
			}else if(p.t == 'msg_ls'){
				
				__eml_o_bx.html('');
				
				_html = '<div class=\"_ovr _anm\" id=\"__useml_ovr\"></div> <div class=\"ls_wrp\"><div class=\"ls_blq\"> <table class=\"thrd_ls\" id=\"eml_msg_ls\"></table></div></div> ';
				__eml_o_bx.html(_html);
				
				var _o = SUMR_Main.scl.f.SclEmlG({ o:'msg' });
				
				if(!isN(_o) && !isN(_o.ls)){
					$.each(_o.ls, function(k, v) {
						
						if($(document).find('[thrd-id='+v.enc+']').length==0){ 
							
							if(!isN(v.read) && v.read == 0){ cls_read = '_noread'; }else{ cls_read = ''; }

							$('#eml_msg_ls').append('<tr thrd-id=\"'+v.enc+'\" class=\"'+cls_read+'\">
														<td width=\"1%\" class=\"icnd\" nowrap> <div class=\"icn strrd\"></div></td>
														<td width=\"40%\" class=\"sndr\">'+v.sndr+'</td>
														<td width=\"54%\" class=\"subj\"><div class=\"_txt\">'+v.sbj+'</div></td>
														<td width=\"5%\" class=\"dte\" align=\"right\" nowrap>'+v.f+'</td>
													</tr>');	
						}	
								
					});
				}
					
				
			}
			
			__eml_domrbld();
			
		}
		
		function __eml_rqu_s(_r){
			if(!isN(_r)){
				if(!isN(_r.msg)){ SUMR_Main.scl.f.SclEmlS({ o:'msg', v:_r.msg }); }
				if(!isN(_r.box)){ SUMR_Main.scl.f.SclEmlS({ o:'box', v:_r.box }); }
				if(!isN(_r.eml)){ SUMR_Main.scl.f.SclEmlS({ o:'eml', v:_r.eml }); }	
				if(!isN(_r.scl)){ SUMR_Main.scl.f.lve(_r.scl); }
			}
		}
		
		function __eml_gt_thrd_ls(p){
			
			var __data = {};
			var __useml = '';
			var __get = '';
			var __rfrsh = 'no';
			var __start = 'no';
			var __btn = 'ok';
			var __loader = 'ok';
			
			if(!isN(p)){
				if(!isN(p.eml)){ __eml_iduseml = p.eml; }
				if(!isN(p.sch)){ __eml_inboxsch = p.sch; }
				if(!isN(p.inbox_id)){ __eml_inboxid = p.inbox_id; }
				if(!isN(p.rfrsh) && p.rfrsh == 'ok'){ __rfrsh = 'ok'; }
				if(!isN(p.start) && p.start == 'ok'){ __start = 'ok'; __eml_sch_clr(); }
				if(!isN(p.btn)){ __btn = p.btn; }
				if(!isN(p.ldr) && p.ldr == 'no'){ __loader='no'; }	
			}
			
			if(!isN(__eml_iduseml)){ __data['inbox_eml'] = __eml_iduseml; }
			if(!isN(__eml_inboxsch)){ __data['inbox_sch'] = __eml_inboxsch; }
			if(!isN(__eml_inboxid)){ __data['inbox_id'] = __eml_inboxid; }

			_ac = SUMR_Main.scl.f.SclEmlG({ o:'ac' });
			
			__data['_tp'] = 'msg_ls';
			__data['_ac'] = _ac;
			
			__data['_cl']= function(_r){				
				
				setTimeout(function(){ 
					
					_o = SUMR_Main.scl.f.SclEmlG({ o:'msg' });
					
					__eml_gt_nav();
					__eml_html({ t:'msg_ls' });
					if(!isN(_o) && !isN(_o.pg)){ __eml_nmr({ start: _o.pg.start , end:_o.pg.end, tot:_o.pg.tot }); }
					
					if(!isN(p.success)){ p.success(); }
				}, 500);
				
			};
			
			if(__loader == 'ok'){ 
				__data['_bf'] = function(){ 
					__eml_o_bx_ldr.show(); 
				}; 
			}
			
			__data['_cmp'] = function(){ 
				__eml_o_bx_ldr.hide(); 
			};

			SUMR_Main.eml.rqu( __data );
			
		}
		
		
		function __eml_nav_btn(p){
			
			if(!isN(p)){
				if(!isN(p.o)){ __sl_r = p.o.attr('rel'); }
			}	

			$('#useml_nav ._btn.'+__sl_r).addClass('_ld');
			
			__eml_gt_thrd_ls({ 
				inbox_id:__sl_r, 
				start:'ok', 
				success:function(){
					$('#useml_nav ._btn').removeClass('selected');
					$('#useml_nav ._btn.'+__sl_r).removeClass('_ld');  
					$('#useml_nav ._btn.'+__sl_r).addClass('selected');	
				} 
			});
		
			return false;		
		}
		
		function __eml_sch_cmpse_fix(v){
			if(!isN(v)){
				var str = v;
				var res = str.split(' ');
				
				/*if(res.length > 1){*/
					_r = '('+v+')';
				/*}else{
					_r = v;
				}*/
			}else{
				_r = '';
			}
			return _r;
		}
		
		function __eml_sch_cmpse(p){
			
			__eml_o_txt_sch.val('');
			var __tx_c = '';
			
			var _from = __eml_sch_cmpse_fix(__eml_o_txt_sch_from.val() );
			var _to = __eml_sch_cmpse_fix( __eml_o_txt_sch_to.val() );
			var _sbj = __eml_sch_cmpse_fix( __eml_o_txt_sch_subj.val() );
			var _wrd = __eml_sch_cmpse_fix(__eml_o_txt_sch_wrd.val() );
			
			if(!isN(_from)){ __tx_c = '".TX_MAIL_FROM.":'+_from; }
			if(!isN(_to)){ __tx_c = __tx_c + ' ".TX_MAIL_TO.":'+_to; }
			if(!isN(_sbj)){ __tx_c = __tx_c + ' ".TX_MAIL_SBJ.":'+_sbj; }
			if(!isN(_wrd)){ __tx_c = __tx_c + ' ".TX_MAIL_WRDS.":'+_wrd; }

			__eml_o_txt_sch.val( __tx_c );
			
			__tx_c = '';
		}
		
		function __eml_sch_op_d(p){
			if(!isN(p) && !isN(p.e) && p.e == 'o'){
				__eml_o_txt_sch_op.addClass('_on');
				__eml_o_bx_ovr.addClass('_on');
			}else{
				__eml_o_txt_sch_op.removeClass('_on');
				__eml_o_bx_ovr.removeClass('_on');
			}
		}
		
		
		function __eml_thrd_dt(p){
			var __get = '';
			
			if(!isN(p)){
				if(!isN(p.cnv)){ var __cnv_id = p.cnv; }	
			}
			
			if(!isN(__cnv_id)){ __get = __get+'&cnv_id='+__cnv_id; }
			
			_ldCnt({ 
				u:'".Fl_Rnd(FL_DT_GN.__t('my_eml_cnv',true))."'+__get, 
				pop:'ok', 
				trs:true, 
				ldr:'__ld_useml_msg', 
				hd:'ok', 
				pnl:{
					e:'ok',
					s:'eml',
					tp:'h'
				} 
			});	
		
		}
		
		function __eml_popcls(){
			
			var _clstp='';
			var _io_d_pop_c='';
			var _acc = SUMR_Main.scl.f.SclEmlG({ o:'eml' }).ls[ __eml_accstup ];
			
			if(!isN(_acc) && !isN(_acc.tp) && !isN(_acc.tp.attr) && !isN(_acc.tp.attr.cls) && !isN(_acc.tp.attr.cls.vl) ){ 
				_clstp = _acc.tp.attr.cls.vl;
			}else{
				_clstp = '';
			}

			if(!isN( SUMR_Main.scl.eml_stup ) && !isN( SUMR_Main.scl.eml_stup.tp ) && !isN( SUMR_Main.scl.eml_stup.tp.cls )){
				_io_d_pop_c = SUMR_Main.scl.eml_stup.cls;
			}else{
				if(isN(_clstp)){ _io_d_pop_c = 'new'; }	
			} 
			
			__eml_o_acc_box.removeClass('new');
			if(!isN(_io_d_pop_c)){ __eml_o_acc_box.addClass( _io_d_pop_c ); }
			if(!isN(_clstp)){ __eml_o_acc_box.attr('cls-tp', _clstp); }else{ __eml_o_acc_box.attr('cls-tp',''); }

		}
		
		function __eml_poprbld(){
			
			var _acc = SUMR_Main.scl.f.SclEmlG({ o:'eml' }).ls[ __eml_accstup ];        	
        	
        	__eml_popcls();
        	__eml_domrbld();
			        	
		}
		
		function __eml_dtl(p){
			if(!isN(p) && !isN(p.id)){
				_ldCnt({ 
					u:'".Fl_Rnd(FL_DT_GN.__t('my_eml_stup',true))."&_s=upd&_i='+p.id, 
					pop:'ok', 
					w:'700',
					h:'400',
					trs:true, 
				});
			}		
		}
		
		
		function __eml_domrbld(p){
		 	
		 	__eml_domrbld_o();
		 	
			$('#useml_nav ._btn:not(.selected) ').off('click').on('click', function(e){ 
				if(e.target != this){ return; }	
				__eml_nav_btn({ o:$(this) });	
				__eml_domrbld();
			});
			
			
			$('#useml_nav ._btn .myrfrsh').off('click').on('click', function(e){ 
				__eml_gt_thrd_ls({ rfrsh:'ok' });	
			});
			
			__eml_o_acc_itm.off('click').on('click', function(e){
				if( !$(e.target).hasClass('stup') ){ 
					__sl = $(this).attr('eml-acc-id');
					__eml_ac({ eml:__sl });
				}else{
					return;
				}
			});
			
			
			__eml_o_acc_itm_stup.off('click').on('click', function(e){ 
				__eml_accstup = $(this).attr('eml-acc-id');
				__eml_dtl({ id:__eml_accstup });
				
				/*
				SUMR_Main.scl.f.pop({ 
			        t:'eml_acc',
		        	e:'on', w:700, h:400,
		        	cl:function(){
			        	__eml_poprbld();	
		        	} 
		        }); 
		        */
		        
			});
			
			
			__eml_o_acc_itm_mre.off('click').on('click', function(e){ 
				
				_ldCnt({ 
					u:'".Fl_Rnd(FL_DT_GN.__t('my_eml_stup',true))."&_s=new', 
					pop:'ok', 
					w:'350',
					h:'300',
					trs:true, 
				});	
				
				SUMR_Main.scl.eml_stup['e'] = 'ok';
				__eml_accstup = '';
				
				
				/*
				SUMR_Main.scl.f.pop({ 
			        t:'eml_acc',
		        	e:'on', w:350, h:200,
		        	cl:function(){
			        	__eml_stup_crsl();
			        	__eml_poprbld();	
		        	} 
		        }); 
		        */
		        
			});
			
			
			$('.thrd_ls tr td').not('.icnd').off('click').on('click', function(e){ 
				_id = $(this).closest('tr').attr('thrd-id');
				__eml_thrd_dt({ cnv:_id });
			});
			
			$('.thrd_ls tr td .strrd').off('click').on('click', function(e){ 
				_id = $(this).closest('tr').attr('thrd-id'); 
				SUMR_Main.eml.rqu({ id_emlcnv:_id });
			});
			
			
			__eml_o_btn_sch.off('click').on('click', function(e){ 
				var sch = __eml_o_txt_sch.val();
				if(sch!=''){ 
					__eml_o_txt_sch_bx.addClass('_on'); 
					__eml_gt_thrd_ls({ sch:sch }); 
					__eml_sch_op_d(); 
				}	
			});
			
			
			__eml_o_bx_ovr.off('click').on('click', function(e){ 
				 __eml_sch_op_d();
			});
			
			
			__eml_o_btn_sch_clr.off('click').on('click', function(e){ 
				__eml_sch_clr(); __eml_gt_thrd_ls({ sch:' ' }); __eml_sch_op_d();	
			});
			
			__eml_o_btn_opt.off('click').on('click', function(e){ 
				if(__eml_o_txt_sch_op.hasClass('_on')){
					__eml_sch_op_d();
				}else{
					__eml_sch_op_d({ e:'o' });	
				}  
			});
			
	
			__eml_o_btn_nxt.off('click').on('click', function(e){ 
				__eml_gt_thrd_ls({ btn:'nxt' }); 	
			});
			
			__eml_o_btn_prv.off('click').on('click', function(e){ 
				__eml_gt_thrd_ls({ btn:'prv' }); 	
			});
			
			
			$('#__useml_sch_from, #__useml_sch_to, #__useml_sch_subj').bind('blur', function () {
	        	__eml_sch_cmpse();
		    }).bind('focus', function () {
		        
		    });
							
		}

						
		
		
		
		function __eml_nmr(p){
			if(!isN(p)){ $('.___myeml .list nav .nav_bx ._nmr').html( '<strong>'+p.start+'</strong>-<strong>'+p.end+'</strong> de <strong>'+p.tot+'</strong>' ); }
		}
		
		
		function __eml_gt_acc(){
			
			var _item='';
			__eml_o_acc.html('');
			
			var __ac_now = SUMR_Main.scl.f.SclEmlG({ o:'ac' });
			var __eml = SUMR_Main.scl.f.SclEmlG({ o:'eml' });
			
			if(!isN(__eml) && !isN(__eml.a) && !isN(__eml.tot) && __eml.tot > 0){
				$.each(__eml.a, function(eml_acc_k, eml_acc_v){ 
					
					if(__ac_now == eml_acc_v.enc){ _cls=' on '; }else{ _cls=''; }
					if(!isN( eml_acc_v.onl ) && eml_acc_v.onl == 'ok'){ _cls_onl=' _on '; }else{ _cls_onl=' _off '; }
					
					_item = _item+'<div class=\"item _anm no-draggable-area\" >
								<div class=\"_acc_p _o '+_cls+'\" eml-acc-id=\"'+eml_acc_v.enc+'\" title=\"'+eml_acc_v.eml+'\">
									<div class=\"_img _o\" style=\"background-image:url('+eml_acc_v.avtr+');\">
										<button class=\"stup _o _anm\" eml-acc-id=\"'+eml_acc_v.enc+'\"></button>
										<div class=\"onl _o _anm '+_cls_onl+'\"></div>
									</div>
								</div>
							</div>'; 		
				});
			}
			
			_item = _item+'<div class=\"item _anm\"><div class=\"_acc_p _o _mre _anm\" title=\"More\"></div></div>';	    
			__eml_crsl_html = '<div id=\"__crsl_acc_".$__rnd_op."\" class=\"owl-carousel eml-acc no-draggable-area\">'+_item+'</div>';    
			__eml_o_acc.append( __eml_crsl_html );
			
			SUMR_Main.ld.f.owl( function(){
				$('#__crsl_acc_".$__rnd_op."').owlCarousel({
					  items:2,
					  autoPlay: false
					  
					  /*,
					  center: false,
					  margin:5,
					  navigation: false,
					  singleItem: false,
					  autoHeight: false,
					  */
				});
			});
			
		}
	";	
?>