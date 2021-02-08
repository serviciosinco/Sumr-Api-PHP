<?php 

	$__eml_dt = GtEmlDt([ 'id'=>$___Dt->gt->i, 't'=>'enc' ]);
	
	if($__eml_dt->tp->attr->cls->vl != 'imap'){
		$CntJV .= "setTimeout(function(){ parent.$.colorbox.resize({ width:600 }); }, 500); ";
	}
	
	
?>
<div class="_new_in_data" cls-tp="<?php echo $__eml_dt->tp->attr->cls->vl; ?>">
			
	<div class="_c _c1">
		
		<figure class="avtr _o">
			<div class="_img _o" style="background-image:url('<?php echo $__eml_dt->avtr; ?>');"></div>
			<div class="onl _o _anm _<?php if($__eml_dt->onl->v == 'ok'){ echo 'on'; }else{ echo 'off'; } ?>"></div>
			<div class="upd _o _anm">
				<div class="bqe">
					<div class="c1"><button class="upl _anm"></button></div>
					<div class="c2"><button class="slc _anm"></button></div>
				</div>
			</div>
		</figure>


		<div class="_anm _data _nm" eml-acc-fld="eml_nm" eml-acc-enc="<?php echo enCad('eml_nm'); ?>">
			<div class="tx" eml-plc="<?php echo TX_NM; ?>"><?php echo $__eml_dt->nm ?></div>
		</div>
		
		<div class="_anm _data _eml" eml-acc-fld="eml_eml" eml-acc-enc="<?php echo enCad('eml_eml'); ?>" >
			<div class="tx" eml-plc="<?php echo TT_FM_EML; ?>"><?php echo $__eml_dt->eml ?></div>
		</div>
		
						
		<div class="_anm _data _tp">
			<?php 
				
				$l = __Ls([ 'k'=>'sis_eml', 
							'id'=>'eml_srv_tp', 
							'va'=>$__eml_dt->tp->id,
							'ph'=>TX_SLUSCLNEML, 
							'slc'=>['ac'=>'no', 
									'thm'=>'eml-acc-slc', 
									'opt'=>[
											'attr'=>[
												'itm-key'=>'key',
												'itm-cls'=>'cls'	
											]	
										] 
									] 
						]); 
						
				echo $l->html; $CntWb .= $l->js; 
    		?>
		</div>
		
		<div class="opt">
			<div class="_d _d1">
				<div class="tx"><?php echo OLD_HTML_chck('eml_ssl', TX_LBL_SSL, $__eml_dt->ssl->id, 'in', ['mny'=>'ok', 'icn'=>'<div class="icn ssl"></div>', 'attr'=>['eml-acc-fld'=>'eml_ssl', 'eml-acc-enc'=>enCad('eml_ssl') ] ]); ?></div>
			</div>
			<div class="_d _d2">
				<div class="tx"><?php echo OLD_HTML_chck('eml_dfl', TX_PC, $__eml_dt->dfl->id, 'in', ['mny'=>'ok', 'icn'=>'<div class="icn dfl"></div>', 'attr'=>['eml-acc-fld'=>'eml_dfl', 'eml-acc-enc'=>enCad('eml_dfl') ] ]); ?></div>
			</div>
		</div>
		
	</div>
	
	<div class="_c _c2">
		<div class="blq _in">
			<h2><?php echo TX_DTENT ?></h2>
			<div class="_anm _data _srv_in" eml-acc-fld="eml_srv_in" eml-acc-enc="<?php echo enCad('eml_srv_in'); ?>" eml-plc="<?php echo TX_SRVR ?>">
				<div class="tx" eml-plc="<?php echo TX_SRVR ?>"><?php echo $__eml_dt->in->srv; ?></div>
			</div>
			<div class="_anm _data _prt_in" eml-acc-fld="eml_prt_in" eml-acc-enc="<?php echo enCad('eml_prt_in'); ?>" eml-plc="<?php echo TX_PRTO; ?>">
				<div class="tx" eml-plc="<?php echo TX_PRTO; ?>"><?php echo $__eml_dt->in->prt; ?></div>
			</div>							
		</div>
		<div class="blq _out">
			<h2><?php echo TX_DTSLD ?></h2>
			<div class="_anm _data _srv_out" eml-acc-fld="eml_srv_out" eml-acc-enc="<?php echo enCad('eml_srv_out'); ?>" eml-plc="<?php echo TX_SRVR ?>">
				<div class="tx" eml-plc="<?php echo TX_SRVR ?>"><?php echo $__eml_dt->out->srv; ?></div>
			</div>
			<div class="_anm _data _prt_out" eml-acc-fld="eml_prt_out" eml-acc-enc="<?php echo enCad('eml_prt_out'); ?>" eml-plc="<?php echo TX_PRTO; ?>">
				<div class="tx" eml-plc="<?php echo TX_PRTO; ?>"><?php echo $__eml_dt->out->prt; ?></div>
			</div>							
		</div>
		
	</div>
	
	<div class="_c _c3">
		<div class="blq _usr">
			<h2> <?php echo TX_USR.' / '.TX_PSSW; ?></h2>
			<div class="_anm _data _usr" eml-acc-fld="eml_usr" eml-acc-enc="<?php echo enCad('eml_usr'); ?>" eml-plc="User">
				<div class="tx"><?php echo $__eml_dt->user; ?></div>
			</div>
			<div class="_anm _data _pss" eml-acc-fld="eml_pss" eml-acc-enc="<?php echo enCad('eml_pss'); ?>" eml-plc="Password">
				<div class="tx">*******</div>
			</div>
		</div>
		<div class="cnx_box _tkn">
			<button class="_anm" id="eml-acc-tkn"><?php echo TX_OBT_TKN ?></button>
		</div>
		<div class="cnx_box _test">
			<button id="eml-acc-test"><?php echo TX_PRB_CNX ?></button>
		</div>
	</div>

</div>



<style>
	
	
	/*-------------------- NEW SETUP DESGIN --------------------*/
		
	._new_in_data *{ background-repeat: no-repeat; font-family: 'Source Sans Pro'; font-weight: 400; background-repeat: no-repeat; }
	
	._new_in_data ._o{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px;}
	
	._new_in_data.new > ._c{ display: none; }
	
	
	._new_in_data{ padding: 30px 10px 25px 10px; }
	
			
	._new_in_data .opt{ margin-top: 10px; }
	._new_in_data .opt ._d{ display:inline-block; vertical-align: top; }
	._new_in_data .opt ._d._d1{ width: 49%;  }	
	._new_in_data .opt ._d._d2{ width: 49%; }
	._new_in_data .opt ._d._d1 .tx .__slc_ok{ text-align: right; }
	._new_in_data .opt ._d._d2 .tx .__slc_ok{ text-align: left; }	
	._new_in_data .opt ._d .__slc_ok{ border: none; }
	._new_in_data .opt ._d .__slc .icn{ width: 30px; height: 24px; display: block; position: absolute; top:0; left:25px; background-repeat: no-repeat; background-position: center center; background-size: auto 80%; }
	._new_in_data .opt ._d .__slc .icn.ssl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_ssl.svg'); }
	._new_in_data .opt ._d .__slc .icn.dfl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_dfl.svg'); }
	._new_in_data .opt ._d .__slc .slideThree{ width:80px; }
	._new_in_data .opt ._d .__slc .slideThree label{ top: 2px!important; }
	._new_in_data .opt ._d .__slc .slideThree input[type=checkbox]:checked + label{ left: 55px !important; }
	
	
	._new_in_data .blq{ border: 1px dotted #adadad; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; position: relative; padding: 20px 5px 10px 5px; margin-top: 20px; }
	._new_in_data .blq h2{ margin: 0; padding: 0; font-family: Economica; font-size: 12px; position: absolute; top: -15px; right: 5px; background-color: #e6e6e6; padding: 10px 15px; text-transform: uppercase; color: #808080; }
	
	._new_in_data .blq._usr{ border: 1px solid #cfcfcf; margin-top: 0px; padding-left: 20px; padding-right: 20px; }
	._new_in_data .blq._usr h2{ background-color: white; }
	._new_in_data .blq._usr ._data .tx{ border-bottom-color: #d6d6d6 !important; }

	



	
	/*-------------------- IMAP SETUP DESIGN --------------------*/

		._new_in_data.imap{}
		
		
		
	/*-------------------- GMAIL SETUP DESIGN --------------------*/
		
		._new_in_data ._tkn{ display: none; }
		._new_in_data[cls-tp="gmail"]{}
		._new_in_data[cls-tp="gmail"]:not(.imap) ._tkn{ display: block; }
		._new_in_data[cls-tp="gmail"] ._c._c1{ width: 35%; }	
		._new_in_data[cls-tp="gmail"] ._c._c2{ display:none; }	
		._new_in_data[cls-tp="gmail"] ._c._c3{ width: 64%; padding: 20px 100px 20px 100px; }
		._new_in_data[cls-tp="gmail"] .blq._usr{ display: none; }
	
	
	/*-------------------- OFFICE SETUP DESIGN --------------------*/


		._new_in_data[cls-tp="office"]{}
		._new_in_data[cls-tp="office"]:not(.imap) ._tkn{ display: block; }
		._new_in_data[cls-tp="office"] ._c._c1{ width: 45%; }	
		._new_in_data[cls-tp="office"] ._c._c2{ display:none; }	
		._new_in_data[cls-tp="office"] ._c._c3{ width: 54%; padding: 20px 50px 20px 50px; }
		._new_in_data[cls-tp="office"] .blq._usr{ display: none; }
	

	
	/*-------------------- MAIL SETUP BASIC --------------------*/
	
	
	
	._new_in_data .styled-select-bx label{ display: none; }
	
	._new_in_data{ display: block; width: 100%; }
	._new_in_data > ._c{ display:inline-block; vertical-align: top; min-height: 300px; }
	._new_in_data > ._c._c1{ width: 35%; /*border-right: 1px solid #cdcdcd;*/  }	
	._new_in_data > ._c._c2{ width: 33%; padding: 20px 10px 20px 10px; background-color: #e6e6e6; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; }	
	._new_in_data > ._c._c3{ width: 31%; padding: 20px 0px 20px 10px; }	
	
	._new_in_data .avtr{ display: block; margin-top: 10px; width: 150px; height: 150px; position: relative; margin-left: auto; margin-right: auto; border: 3px solid #d2d2d2; padding: 5px; cursor: pointer; }
	._new_in_data .avtr ._img{ background-color: #d2d2d2; width: 135px; height: 135px; background-size: 100% 100%; background-position: center center; border: none;  }
	._new_in_data .avtr .onl{ width: 35px; height: 35px; display: block; position: absolute; right: -2px; bottom: -2px; border: 4px solid white; animation: _blnk_ldr 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_plug.svg'); background-position: center center; background-size: 60% auto; z-index: 10; background-color: white; }
	._new_in_data .avtr .onl._off{ background-color: #8e1313; }
	._new_in_data .avtr .onl._on{ background-color: #31830b; }
	
	
	._new_in_data .avtr:hover .upd{ opacity: 1; width: 95%; height: 95%; left:2.5%; top:2.5%; pointer-events: all; margin-left: 0; margin-top: 0; }
	
	._new_in_data .avtr .upd{ opacity: 0; background-color: rgba(0, 0, 0, 0.8); width:1px; height:1px; position: absolute; left:50%; top:50%; margin-left: -0.5px; margin-top: -0.5px; pointer-events: none; }
	._new_in_data .avtr .upd .bqe{ width: 100%; height: 35px; position: absolute; top:50%; margin-top: -17.5px; }
	._new_in_data .avtr .upd .bqe .c1,
	._new_in_data .avtr .upd .bqe .c2{ display: inline-block; width: 48%; text-align: center; vertical-align: top; height: 35px; text-align: center; }
	._new_in_data .avtr .upd .bqe .c1{ text-align: right; padding-right: 5px; border-right: 1px solid #656d71; }
	._new_in_data .avtr .upd .bqe .c2{ text-align: left; padding-left: 5px; }
	._new_in_data .avtr .upd .bqe button{ width: 35px; height: 35px; background-color: transparent; border: none; background-repeat: no-repeat; background-position: center center; background-size: 70% auto; cursor: pointer; }
	._new_in_data .avtr .upd .bqe button:hover{ background-size: 60% auto; }
	
	._new_in_data .avtr .upd .bqe button.upl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_upl.svg'); }
	._new_in_data .avtr .upd .bqe button.slc{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_avtr.svg'); }
	
	
	
	._new_in_data > ._c ._data._nm,
	._new_in_data > ._c ._data._eml,
	._new_in_data > ._c ._data._tp{ width:80%; margin-left: auto; margin-right: auto; margin-top: 0px; white-space: nowrap; }
	
	
	
	._new_in_data > ._c ._data._nm .tx,
	._new_in_data > ._c ._data._eml .tx { font-family: Economica; text-align: center; text-overflow: ellipsis; overflow: hidden; width: 100%; margin-bottom: 0; }
	._new_in_data > ._c ._data._nm .tx{ text-transform: uppercase; font-weight: 500; font-size: 25px; }
	._new_in_data > ._c ._data._eml .tx{ font-weight: 200; font-size: 17px; }
	
	
	
	
	._new_in_data ._data._srv_in .tx,
	._new_in_data ._data._prt_in .tx,
	._new_in_data ._data._srv_out .tx,
	._new_in_data ._data._prt_out .tx,
	._new_in_data ._data._usr .tx{
		padding-left: 40px; background-size: 20px auto; background-position: 10px center;
	}
	
	
	._new_in_data ._data._srv_in .tx,
	._new_in_data ._data._srv_out .tx{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_srv.svg'); }
	._new_in_data ._data._prt_in .tx,
	._new_in_data ._data._prt_out .tx{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_prt.svg'); }
	._new_in_data ._data._usr .tx{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_eml.svg'); }
	
	._new_in_data > ._c ._data{ font-size: 16px; }
	._new_in_data > ._c ._data._ld{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg'); background-size: 15px auto; background-position: center center; background-repeat: no-repeat; min-height: 25px; }
	._new_in_data > ._c ._data._ld .tx,
	._new_in_data > ._c ._data._ld .___txar{ display: none !important; }

	
	._new_in_data > ._c ._data .tx:empty::before{ display: block; width: 100%; height: 10px; content: attr(eml-plc); color: #9f9f9f; text-transform: lowercase; }


	
	
	._new_in_data > ._c ._data .tx{ font-size: 12px; margin-bottom: 10px; width: 100%; min-height: 32px; border-radius:10px;
-moz-border-radius:10px; -webkit-border-radius: 0px 5px 10px 5px; border-bottom: 1px solid white; pointer-events: none; text-align: center; padding-top: 5px; position: relative; }
	._new_in_data > ._c ._data .tx:empty,
	._new_in_data > ._c ._data:hover .tx{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>inp_edit.svg'); background-size: 10px auto; background-position: 10px center; }
	
	
	._new_in_data > ._c ._data .___txar label{ display: none; }
	._new_in_data > ._c ._data input[type=text]{ background-color: white; width: 100%; font-size: 12px; text-align: center; background-color: transparent; }
	._new_in_data > ._c._c1 input[type=text]{ text-align: center; font-family: Economica; }
	._new_in_data > ._c._c1 ._data._nm input[type=text]{ font-weight: 500; font-size: 25px; text-transform: uppercase; padding: 0 !important; }
	._new_in_data > ._c._c1 ._data._eml input[type=text]{ font-weight: 200; font-size: 17px; padding: 0 !important; }
			
	._new_in_data > ._c ._data:hover{ cursor:text; }
	._new_in_data > ._c ._data:hover .tx{ border-bottom-color: #bfbfbf; cursor:text; }
	

	
	
	
	._new_in_data .cnx_box{ border: 1px solid #e0e0e0; padding: 30px 20px; margin-top: 10px; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; }
	._new_in_data .cnx_box button{ position: relative; padding: 20px 15px 20px 40px; width: 100%; text-align: center; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; border: 1px solid #666666; background-color: #565a5d; color: white; font-family: Economica; text-transform: uppercase; font-size: 13px; cursor: pointer; border: none; }
	._new_in_data .cnx_box button:hover{ background-color: #838e90; }
	._new_in_data .cnx_box button::before{ display: block; width: 40px; height: 55px; vertical-align: middle; background-size: auto 70%; background-position: center right; background-repeat: no-repeat; position: absolute; left: 0px; top:0; }
	._new_in_data .cnx_box button:hover::before{ background-size: auto 60%; }
	._new_in_data .cnx_box button._ld::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>loader_white.svg'); }
	._new_in_data .cnx_box button._ld{ background-color: #828282; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; }
	
	
	
	._new_in_data .cnx_box._test button::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_test.svg'); }
	._new_in_data.gmail .cnx_box._tkn button{ background-color: #e4e4e4; color: #394245; border: 1px solid #929a9c; }
	._new_in_data.gmail .cnx_box._tkn button::before{ width: 50px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_google.svg'); background-position: center center; margin-left: 10px; }
	
	._new_in_data[cls-tp="office"] .cnx_box._tkn button{ background-color: #e4e4e4; color: #394245; border: 1px solid #929a9c; }
	._new_in_data[cls-tp="office"] .cnx_box._tkn button::before{ width: 50px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_office.svg'); background-position: center center; margin-left: 10px; }
	
	
	
	
	
		
		
	
</style>



<?php 
			
	$CntJV .= "
		
		
		__eml_o_acc_test = $('#eml-acc-test');
		__eml_o_acc_avtr_onl = $('._new_in_data .avtr .onl');
		__eml_o_acc_avtr_img = $('._new_in_data .avtr ._img');
		
		
		function __eml_slc_chng(){

			$('#eml_srv_tp').change(function() {
					
				var __acc = SUMR_Main.scl.f.SclEmlG({ o:'eml' }).ls[ __eml_accstup ];
				_val = $(this).val();
				
				if(!isN(__acc.tp) && !isN(__acc.tp.id)){ var _tp_b = __acc.tp.id; }    	
			    
			    var __onerror = function(e){
				    if(!isN(e)){
						swal('".TX_ERROR."', '".TX_INTNW."', 'error'); 
					}
			    };
			    
			    
			    if(!isN(_val)){
					SUMR_Main.eml.rqu({
						_tp:'eml_fld',	
						_eml:__eml_accstup,
						_fld:'eml_tp',
						_fenc:'".enCad('eml_tp')."',
						_vle:_val,
						_cl:function(__r){
							if(!isN(__r)){
								if(!isN(__r.sve) && !isN(__r.sve.e) && __r.sve.e != 'ok'){ 
									if(!isN(__txr_t)){ __txr.html( __txr_t ); }else{ __txr.html( _val ); }	
									swal('".TX_ERROR."', '".TX_INTNW."', 'error');	
								}
							}
					    },
						_w:__onerror
					});
				}
				
				return false;
				
    		});
    		
    		
    		$('._new_in_data #eml_ssl, ._new_in_data #eml_dfl').change(function() {
					
				var __ac_now = __eml_accstup;
				
				var __fid = $(this).attr('eml-acc-fld');
				var __fenc = $(this).attr('eml-acc-enc');
				
			    if(this.checked) {
			        _val = 1;
			        _val_r = false;
			    }else{
				    _val = 2;
				    _val_r = true;
			    }
			    
			    SUMR_Main.eml.rqu({
					_tp:'eml_fld',	
					_eml:__ac_now,
					_fld:__fid,
					_fenc:__fenc,
					_vle:_val,
					_cl:function(__r){
						if(!isN(__r)){
							if(!isN(__r.sve) && !isN(__r.sve.e) && __r.sve.e != 'ok'){ 
								$('#'+__fid).prop('checked', _val_r);	
								swal('".TX_ERROR."', '".TX_INTNW."', 'error');	
							}
							__eml_poprbld();
						}
				    },
					_w:function(e){
						if(!isN(e)){
							$('#'+__fid).prop('checked', _val_r);
							swal('".TX_ERROR."', '".TX_INTNW."', 'error'); 
						}
					}
				});	
					
			});

    	}
    	
    	
    	
		
		
		
    	
    	$('._new_in_data ._data').off('click').on('click', function(e){ 
				
			e.preventDefault();
			
			if(e.target != this){
		    	e.stopPropagation();
		    	return;
			}else{
				
				var __fid = $(this).attr('eml-acc-fld');
				var __fenc = $(this).attr('eml-acc-enc');
				var __phld = $(this).attr('eml-plc');
				
				
				var __fld = 'eml_acc_'+__fid;
				var __slc = $(this);
				var __txr = __slc.find('.tx');
				var __txr_t = __txr.html();
				
				if( !$('#'+__fld).length > 0 ){	
					if(__fid == 'eml_pss'){ var _tx_s = ''; }else{ var _tx_s = __txr_t; }
					__slc.append('".HTML_inp_tx('\'+__fld+\'', '\'+__phld+\'', '\'+_tx_s+\'', '', '', '', '', 'off')."');
				}else{
					$('#'+__fld).show();
				}		
				
				if( $('#'+__fld).length > 0 ){	
					
					__txr.hide();
					
					if(__fid != 'eml_pss'){
						$('#'+__fld).val( __txr_t );
					}else{ 
						$('#'+__fld).val( _tx_s );
					}	
					
					$('#'+__fld).focus();
					
					$('#'+__fld).focusout(function() {
						__txr.show();
					}).blur(function(){
						$(this).hide();
						
						_val = $(this).val();
						__txr.show();
						
						if(__txr_t != _val){
							
							__txr.html( _val );								
							
							var _error = function(){
								__txr.html( __txr_t );
							};
							
							
							SUMR_Main.eml.rqu({
								_tp:'eml_fld',	
								_eml:__eml_accstup,
								_fld:__fid,
								_fenc:__fenc,
								_vle:_val,
								_bf:function(){
									__slc.addClass('_ld');		
								},
								_cmp:function(){
									__slc.removeClass('_ld');
								},
								_cl:function(__r){
								
									if(!isN(__r)){

										if(!isN(__r.sve) && !isN(__r.sve.e)){ 
											
											if(__fid == 'eml_pss'){ 
												var _dfl = '*******'; 
											}else{ 
												var _dfl = __txr_t;
											}
												
											if(__r.sve.e == 'ok'){
												if(__fid != 'eml_pss'){ var _dfl = __r.sve.val; }
											}else{
												swal('".TX_ERROR."!', '".TX_INTNW."', 'error');	
											}
											
											__eml_poprbld();
											__txr.html( _dfl ); 
												
										}
									}

								},
								_w:_error
							});
							
						}	
					});
				}
				
			}
		
			
		});
		
		__eml_o_acc_test.off('click').on('click', function(e){ 
			SUMR_Main.eml.acc.cnx({ 
				id:__eml_accstup, 
				l:__eml_o_acc_test, 
				cl:function(r){
					
					__eml_o_acc_avtr_onl.addClass('_off');
					
					if(!isN(r)){
						if(!isN(r.cnx) && !isN(r.cnx.e == 'ok')){
							__eml_o_acc_avtr_onl.addClass('_on'); 
						}
					}
					
				}
			});
		});
		
		
		$('#eml-acc-tkn').off('click').click(function() {
			__pop_stup = $('._new_in_data');
			__t = __pop_stup.attr('cls-tp');
			SUMR_Main.eml.tkn({ id:__eml_accstup, tpc:__t, cl:'".DB_CL_ENC."', us:'".SISUS_ENC."' });
		});
		
		
		
		__eml_slc_chng();
	";
			
?>			