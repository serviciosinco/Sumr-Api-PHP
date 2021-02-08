<?php 
	
	$__Rnd = Gn_Rnd(20); 
		
?>
<div class="Dsh_Scl" id="Dsh_Scl<?php echo $__Rnd; ?>">
	<header></header>
	<div class="scl_acc_dsh dsh_cnt social_account_detail">
		<div class="_c _c1 _scrl _anm">
			
			<div class="cvr">
				<figure class="avtr _o">
					<div class="_img _o"></div>
					<div class="onl _o _anm"></div>
				</figure>
			</div>
			<div class="_dtl">
				<div class="_anm _data _nm">
					<div class="tx"></div>
				</div>
				
				<div class="_anm _data _dsc">
					<div class="tx"></div>
				</div>
				
				<ul id="bx_rsmn_<?php echo $__Rnd; ?>" class="dls"></ul>
				
			</div>
			
		</div>
		<div class="_c _c2 _scrl _anm">
			<?php echo h2( TX_GRP ); ?>
			<div class="_wrp">
				<ul id="bx_cl_<?php echo $__Rnd; ?>" class="dls">
					<ul id="bx_grp_<?php echo $__Rnd; ?>" class="dls"></ul>			
				</ul>
			</div>
		</div>
		<div class="_c _c3 _scrl _anm">
			<?php echo h2(TX_USRS); ?>
			<div class="_wrp">
				<ul id="bx_us_<?php echo $__Rnd; ?>" class="dls"></ul>
			</div>
		</div>
		<div class="_c _c4 _scrl _anm">
			<?php echo h2('<button new-tp="form"></button> '.'Forms'); ?>
			<div class="_wrp">
				<ul id="bx_form_<?php echo $__Rnd; ?>" class="dls">
					<?php foreach($_acc_dt->form->ls as $_acc_frm_k=>$_acc_frm_v){ ?>	
						<li class="itm"><?php echo $_acc_frm_v->nm; ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="_c _c5 _scrl _anm _form_r _rdy">
			<div class="_wrp">
				<div id="bx_attrform_<?php echo $__Rnd; ?>" class="dls">
					
				</div>
			</div>	
		</div>				
	</div>	
</div>



<?php 
	      
    $__Cl = new CRM_Cl(); 
	
	
	$CntJV .= " 
	
	
	SUMR_Main.scl.bxajx.bx_rsmn = $('#bx_rsmn_".$__Rnd."');	
	SUMR_Main.scl.bxajx.bx_cl = $('#bx_cl_".$__Rnd."');
	SUMR_Main.scl.bxajx.bx_form = $('#bx_form_".$__Rnd."');
	SUMR_Main.scl.bxajx.bx_us = $('#bx_us_".$__Rnd."');
	SUMR_Main.scl.bxajx.bx_grp = $('#bx_grp_".$__Rnd."');

	
	SUMR_Main.scl.bxajx.main = $('#Dsh_Scl{$__Rnd}');
	
	SUMR_Main.scl.bxajx.c1 = $('#Dsh_Scl{$__Rnd} ._c1');
	SUMR_Main.scl.bxajx.c2 = $('#Dsh_Scl{$__Rnd} ._c2');
	SUMR_Main.scl.bxajx.c3 = $('#Dsh_Scl{$__Rnd} ._c3');
	SUMR_Main.scl.bxajx.c4 = $('#Dsh_Scl{$__Rnd} ._c4');
	SUMR_Main.scl.bxajx.c5 = $('#Dsh_Scl{$__Rnd} ._c5');
	
	SUMR_Main.scl.bxajx.cvr = $('#Dsh_Scl{$__Rnd} .cvr');
	SUMR_Main.scl.bxajx.avtr_img = $('#Dsh_Scl{$__Rnd} .avtr ._img');
	
	SUMR_Main.scl.bxajx.onl = $('#Dsh_Scl{$__Rnd} .cvr .onl');
	SUMR_Main.scl.bxajx.d_nm = $('#Dsh_Scl{$__Rnd} ._dtl ._nm .tx');
	SUMR_Main.scl.bxajx.d_dsc = $('#Dsh_Scl{$__Rnd} ._dtl ._dsc .tx');
	
	
	
	function SclAcc_Dom_Rbld(){
		
		SUMR_Main.scl.bxajx.bx_form_itm = $('#bx_form_".$__Rnd." > li.itm ');
		SUMR_Main.scl.bxajx.bx_us_itm = $('#bx_us_".$__Rnd." > li.itm ');
		SUMR_Main.scl.bxajx.bx_grp_itm = $('#bx_grp_".$__Rnd." > li.itm ');
		
		SUMR_Main.scl.bx_new_bck = $('.scl_acc_dsh h2 button');
		SUMR_Main.scl.bxajx.bx_form_itm.not('.sch').off('click').click(function(e){
			
			
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{
				
				SUMR_Main.scl.bxajx.c5.removeClass('_form_r');
				SUMR_Main.scl.bxajx.c5.addClass('ok');	
						
				var __rel = $(this).attr('rel');
				
				_ldCnt({ u:'".FL_DT_GN.__t('scl_acc_form',true).ADM_LNK_DT."' + __rel+'&Rnd='+Math.random(), c:'bx_attrform_".$__Rnd."' });

				SUMR_Main.scl.bxajx.main.addClass('_form_r');
				
			}
			
		});	
		
		SUMR_Main.scl.bxajx.bx_us_itm.not('.sch').off('click').click(function(e){
			$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
			var _id = $(this).attr('rel');
			_Rqu({ 
				t:'scl_acc',
				d:'us_scl_acc',
				est: est, 
				_id: _id,
				_id_sclacc : '".Php_Ls_Cln($__i)."',
				_bs:function(){ SUMR_Main.scl.bxajx.bx_us.addClass('_ld'); },
				_cm:function(){ SUMR_Main.scl.bxajx.bx_us.removeClass('_ld'); },
				_cl:function(_r){
					if(!isN(_r)){
						if(!isN(_r.sclacc)){
							SclAccSet(_r.sclacc);			
						}
					}
				} 
			});
		});
		
		SUMR_Main.scl.bxajx.bx_grp_itm.not('.sch').off('click').click(function(e){
			$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
			var _id = $(this).attr('rel');
			_Rqu({ 
				t:'scl_acc',
				d:'grp_scl_acc',
				est: est, 
				_id: _id,
				_id_sclacc : '".Php_Ls_Cln($__i)."',
				_bs:function(){ SUMR_Main.scl.bxajx.bx_grp.addClass('_ld'); },
				_cm:function(){ SUMR_Main.scl.bxajx.bx_grp.removeClass('_ld'); },
				_cl:function(_r){
					if(!isN(_r)){
						if(!isN(_r.sclacc)){
							SclAccSet(_r.sclacc);			
						}
					}
				} 
			});
		});
		
		SUMR_Main.scl.bx_new_bck.off('click').click(function(e){
			e.preventDefault();
			
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{
				SUMR_Main.scl.bxajx.main.removeClass('_form_r');
				SUMR_Main.scl.bxajx.c5.addClass('_form_r');
				SUMR_Main.scl.bxajx.c5.removeClass('ok');
			}
		});	
				
		$('.sch_btn').not('.sch').off('click').click(function(e){
			var vl = $('#form_sch_$__Rnd').val();
			if( !isN ( vl ) ){
				$('#form_sch_$__Rnd').removeClass('_empty');
				_Rqu({ 
					t:'scl_acc',
					d:'sch_form',
					_tt: vl,
					_id_sclacc : '".Php_Ls_Cln($__i)."',
					_bs:function(){ SUMR_Main.scl.bxajx.bx_form.addClass('_ld'); },
					_cm:function(){ SUMR_Main.scl.bxajx.bx_form.removeClass('_ld'); },
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.sclacc)){
								SclAccSet(_r.sclacc);	
								$('#form_sch_$__Rnd').val(vl);		
							}
						}
					} 
				});
			}else{
				_Rqu({ 
					t:'scl_acc',
					d:'sch_form',
					_id_sclacc : '".Php_Ls_Cln($__i)."',
					_bs:function(){ SUMR_Main.scl.bxajx.bx_form.addClass('_ld'); },
					_cm:function(){ SUMR_Main.scl.bxajx.bx_form.removeClass('_ld'); },
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.sclacc)){
								SclAccSet(_r.sclacc);			
							}
						}
					} 
				});
			} 
		});		
				
		/*SUMR_Main.LsSch({ str:'#form_sch_".$__Rnd."', ls:SUMR_Main.scl.bxajx.bx_form_itm });*/
		SUMR_Main.LsSch({ str:'#us_sch_".$__Rnd."', ls:SUMR_Main.scl.bxajx.bx_us_itm });
		SUMR_Main.LsSch({ str:'#grp_sch_".$__Rnd."', ls:SUMR_Main.scl.bxajx.bx_grp_itm });
		_DshPopH({ c:'.social_account_detail', ov:80 });
		
	}
	
	function SclAcc_Attr_Html(v){
		if(!isN(v)){ SUMR_Main.scl.bxajx.bx_rsmn.append('<li class=\"itm rsmn\">'+v+'</li>'); }
	}
		
	function SclAcc_Html(){
		
		SUMR_Main.scl.bxajx.bx_form.html('');
		SUMR_Main.scl.bxajx.bx_form.append('<li class=\"sch fll\">".HTML_inp_tx('form_sch_'.$__Rnd, TX_SEARCH, '')."<span class=\"sch_btn\"></span></li>');

		if(!isN(SUMR_Main.scl.bxajx.form) && !isN(SUMR_Main.scl.bxajx.form.ls)){

			$.each(SUMR_Main.scl.bxajx.form.ls, function(k, v) { 
				if(!isN(v.in) && !isN(v.in.est) && v.in.est == 'ok'){ var _cls = 'on'; }else{ var _cls = 'off'; }
				
				if(!isN(v.mdl) || v.tot_form > 0){ var _mdl = 'on'; }else{ var _mdl = 'off'; }
				if(!isN(v.mdl)){ var _mdl_t = 'on'; }else{ var _mdl_t = 'off'; }
				
				var tot = '<p style=\"display:inline-block;\" class=\"tot_qus_slc\">'+v.tot_form+'</p> / '+v.tot;
				
				SUMR_Main.scl.bxajx.bx_form.append('
					<li class=\"_anm itm form '+_cls+' _mdl_'+_mdl+' _mdl_t_'+_mdl_t+'\" form-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" id=\"_form_'+v.enc+'\">
						<figure style=\"\" class=\"_bg\"></figure>
						<figure style=\"background-image:url('+v.md.img+')\" class=\"_md\" ></figure>
						<h3>'+v.nm+'</h3>
						<span class=\"_date\">'+v.created+'</span>
						<span class=\"_date\">'+tot+'</span>
					</li>
				');
				
				SUMR_Main.scl.bxajx.c4.addClass('_rdy');
			});
		}else if(  SUMR_Main.scl.bxajx.form.tot == 0){
			SUMR_Main.scl.bxajx.bx_form.append('<div class=\"tx\">No se han encontrado registros</div>');
		}
		
		if(!isN(SUMR_Main.scl.bxajx.us) && !isN(SUMR_Main.scl.bxajx.us.ls)){

			SUMR_Main.scl.bxajx.bx_us.html('');
			SUMR_Main.scl.bxajx.bx_us.append('<li class=\"sch\">".HTML_inp_tx('us_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"sch\"></button></li>');
					
			$.each(SUMR_Main.scl.bxajx.us.ls, function(k, v) { 

				if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
				if(!isN(v.img)){
					if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
				}else{ img=''; }
				
				SUMR_Main.scl.bxajx.bx_us.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
				
				SUMR_Main.scl.bxajx.c3.addClass('_rdy');
			});	
			
			
			SUMR_Main.scl.bxajx.bx_grp.html('');
			SUMR_Main.scl.bxajx.bx_grp.append('<li class=\"sch\">".HTML_inp_tx('grp_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"sch\"></button></li>');
					
			$.each(SUMR_Main.scl.bxajx.grp.ls, function(k, v) { 

				if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
				if(!isN(v.img)){
					if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
				}else{ img=''; }
				
				SUMR_Main.scl.bxajx.bx_grp.append('<li class=\"_anm itm grp '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
				
				SUMR_Main.scl.bxajx.c2.addClass('_rdy');
			});	
		
		
		}
		
		if(!isN(SUMR_Main.scl.bxajx.data)){
			
			var _d = SUMR_Main.scl.bxajx.data;
			
			if(!isN(_d.cvr)){ SUMR_Main.scl.bxajx.cvr.css('background-image', 'url('+_d.cvr+')'); }
			if(!isN(_d.img)){ SUMR_Main.scl.bxajx.avtr_img.css('background-image', 'url('+_d.img+')'); }
			if(!isN(_d.est) && _d.est == 'ok'){ SUMR_Main.scl.bxajx.onl.removeClass('_off').addClass('_on'); }else{ SUMR_Main.scl.bxajx.onl.removeClass('_on').addClass('_off'); }
			if(!isN(_d.nm)){ SUMR_Main.scl.bxajx.d_nm.html(_d.nm); }
			if(!isN(_d.attr)){ 
				
				var _o = _d.attr;
				
				if(!isN(_o)){ 
					
					if(!isN(_o.about)){ SUMR_Main.scl.bxajx.d_dsc.html(_o.about); } 
					SUMR_Main.scl.bxajx.bx_rsmn.html('');
					
					
					if(!isN(_o.fan_count)){ SclAcc_Attr_Html('<strong>'+_o.fan_count+'</strong> fans'); }
					if(!isN(_o.talking_about_count)){ SclAcc_Attr_Html('<strong>'+_o.talking_about_count+'</strong> ".TX_PRSHBL."'); }
					if(!isN(_o.were_here_count)){ SclAcc_Attr_Html('<strong>'+_o.were_here_count+'</strong> ".TX_PPWRHR."'); }
					if(!isN(_o.new_like_count)){ SclAcc_Attr_Html('<strong>'+_o.new_like_count+'</strong> ".TX_NWLKS."'); }
					if(!isN(_o.unread_notif_count)){ SclAcc_Attr_Html('<strong>'+_o.unread_notif_count+'</strong> ".TX_NTFCNS."'); }
					if(!isN(_o.unseen_message_count)){ SclAcc_Attr_Html('<strong>'+_o.unseen_message_count+'</strong> ".TX_MSNNW."'); }
				
				}
							
			}
			
			SUMR_Main.scl.bxajx.c1.addClass('_rdy');
			
		}
		
		SclAcc_Dom_Rbld();
	}
	
	
	";
	
	$CntJV .= "

		
		function SclAccSet(p){
			
			if( !isN(p) ){	
				
				SUMR_Main.scl.bxajx.data = p; 
				
				if( !isN(p.form) ){ 
					SUMR_Main.scl.bxajx.form = {}; 
					SUMR_Main.scl.bxajx.form.ls = p.form.ls; 
					SUMR_Main.scl.bxajx.form.tot = p.form.tot; 
				}
				if( !isN(p.us) ){ 
					SUMR_Main.scl.bxajx.us = {}; 
					SUMR_Main.scl.bxajx.us.ls = p.us.ls; 
					SUMR_Main.scl.bxajx.us.tot = p.us.tot; 
				}
				if( !isN(p.grp) ){ 
					SUMR_Main.scl.bxajx.grp = {}; 
					SUMR_Main.scl.bxajx.grp.ls = p.grp.ls; 
					SUMR_Main.scl.bxajx.grp.tot = p.grp.tot; 
				}
				SclAcc_Html();	
			}
		}
	
	
		
	";


	
	$CntJV .= " 
	
		
		_Rqu({ 
			t:'scl_acc', 
			_id_sclacc : '".Php_Ls_Cln($__i)."',
			_cl:function(_r){
				if(!isN(_r)){
					if(!isN(_r.sclacc)){
						SclAccSet(_r.sclacc);			
					}
				}
			} 
		});
		
	";


?>

<style>
	
	/*-------------------- NEW SETUP DESGIN --------------------*/
		
		.Dsh_Scl header{ height: 50px; }
		.Dsh_Scl .scl_acc_dsh{ display: flex; }
		.Dsh_Scl .scl_acc_dsh .owl-controls{ display: none !important; }

	
	/*-------------------- SOCIAL SETUP BASIC --------------------*/
	
		.Dsh_Scl .scl_acc_dsh .styled-select-bx label{ display: none; }
	
		.Dsh_Scl .scl_acc_dsh ._c{ display:inline-block; vertical-align: top; min-height: 300px; border-right: 1px solid #dcdfe0; padding: 0px 10px;  }
		.Dsh_Scl .scl_acc_dsh ._c._c1{ width: 25%; padding-top: 0; }	
		.Dsh_Scl .scl_acc_dsh ._c._c2{ width: 25%; }	
		.Dsh_Scl .scl_acc_dsh ._c._c3{ width: 25%; }	
		.Dsh_Scl .scl_acc_dsh ._c._c4{ width: 25%; border-right: none; }	
		
		
		.Dsh_Scl .scl_acc_dsh ._c:not(._rdy){ animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; }
		.Dsh_Scl .scl_acc_dsh ._c._c1:not(._rdy){ background-position: center top 140px; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>scl_dsh_ldr_1.svg'); background-position: center top 140px; background-repeat:no-repeat; background-size: 80% auto; }
		.Dsh_Scl .scl_acc_dsh ._c._c2:not(._rdy),
		.Dsh_Scl .scl_acc_dsh ._c._c3:not(._rdy){ background-position: center top 140px; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>scl_dsh_ldr_2.svg'); background-position: center top; background-repeat:repeat-y; background-size: 80% auto; }
		.Dsh_Scl .scl_acc_dsh ._c._c2:not(._rdy) h2,
		.Dsh_Scl .scl_acc_dsh ._c._c3:not(._rdy) h2,
		.Dsh_Scl .scl_acc_dsh ._c._c4:not(._rdy) h2{ opacity: 0; }
		
		
		.Dsh_Scl .scl_acc_dsh ._c._c4:not(._rdy){ background-position: center top 140px; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>scl_dsh_ldr_3.svg'); background-position: center top 140px; background-repeat:repeat-y; background-size: 80% auto; }
		
		
		.Dsh_Scl .scl_acc_dsh ._c._c5{display: none}
		.Dsh_Scl .scl_acc_dsh ._c._c5.ok{ width: 45%;display: inline-block }
		
		.Dsh_Scl .scl_acc_dsh ._c ._data._nm .tx,
		.Dsh_Scl .scl_acc_dsh ._c ._data._eml .tx { font-family: Economica; text-align: center; text-overflow: ellipsis; overflow: hidden; width: 100%; margin-bottom: 0; padding: 10px 10px 0 0; line-height: 22px; }
		.Dsh_Scl .scl_acc_dsh ._c ._data._nm .tx{ text-transform: uppercase; font-weight: 500; font-size: 22px; }
		.Dsh_Scl .scl_acc_dsh ._c ._data._dsc .tx{ font-weight: 200; font-size: 11px; color: #8d9393; margin-top: 10px; }
	
		
		
		.Dsh_Scl .scl_acc_dsh .cvr{ background-size:auto 100% ; background-position: center top; height: 100px; position: relative; background-color: #e9efef; }
		.Dsh_Scl .scl_acc_dsh .cvr .avtr{ display: block; margin-top: 10px; width: 100px; height: 100px; position: relative; margin-left: auto; margin-right: auto; border: 3px solid #d2d2d2; padding: 5px; cursor: pointer; background-color: white; position: absolute; left: 50%; margin-left: -50px; top: 20px; }
		.Dsh_Scl .scl_acc_dsh .cvr .avtr ._img{ background-color: #d2d2d2; width: 85px; height: 85px; background-size: 100% 100%; background-position: center center; border: none;  }
		.Dsh_Scl .scl_acc_dsh .cvr .avtr .onl{ width: 35px; height: 35px; display: block; position: absolute; right: -2px; bottom: -2px; border: 4px solid white; animation: _blnk_ldr 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_plug.svg'); background-position: center center; background-size: 60% auto; z-index: 10; background-color: white; }
		.Dsh_Scl .scl_acc_dsh .cvr .avtr .onl._off{ background-color: #8e1313; }
		.Dsh_Scl .scl_acc_dsh .cvr .avtr .onl._on{ background-color: #31830b; }
		
		
		.Dsh_Scl .scl_acc_dsh ._dtl{ margin-top: 30px; }
		
		
		
		
		.Dsh_Scl .scl_acc_dsh .itm.rsmn{ border: none !important; color: #859193 !important; }
		.Dsh_Scl .scl_acc_dsh .itm.rsmn strong{ font-weight: 500 !important; color: #212525 !important; pointer-events: none; }
		
		
		.Dsh_Scl .scl_acc_dsh .itm.form{ background-color: #f0f0f0; border:none !important; }
		.Dsh_Scl .scl_acc_dsh .itm.form h3{ margin:0; padding:0; color:#141616; pointer-events: none; }
		.Dsh_Scl .scl_acc_dsh .itm.form figure{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_form.svg'); background-repeat: no-repeat; background-position: center center; background-size: 60% auto !important; top:5px; pointer-events: none; }
		
		
		figure._md{ width: 20px !important; height: 20px !important;top: 33px !important; background-color: white !important; }
		
	
	/*-------------------- READY FOR WORK ON FORMS --------------------*/
	
		
		.Dsh_Scl._form_r ._form_r._c._c5,
		.Dsh_Scl._form_r ._c._c2,
		.Dsh_Scl._form_r ._c._c3{ width:1px; height: 1px; opacity: 0; pointer-events: none; padding: 0; }
		
		.Dsh_Scl._form_r ._c._c4 h2 button{ display: inline-block; }
		span.sch_btn {
			position: absolute;
			top: 0;
			right: 0;
			width: 30px;
			height: 100%;
			cursor: pointer;
			border-radius: 6px;
		}
		span.sch_btn:hover {
			background-color: #b1b1b138;
		}
		#form_sch_<?php echo $__Rnd ?>._empty{ border: 1px solid #ff7615; }
</style>