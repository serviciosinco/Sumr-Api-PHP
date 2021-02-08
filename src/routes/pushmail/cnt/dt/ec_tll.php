<?php 
	$__id_fm = 'FmTll';
	$__id_bx = 'FmBx';
	$__id_rnd = '_'.Gn_Rnd(20);
	
?>
<div class="_fm_snd_frd" id="<?php echo $__id_bx ?>">		
	
	<div class="wrp">  
		<div class="_col1"> 
			<h1>
				Enviar a un amigo
				
				<div><img src="<?php echo $__dtec->img_v->ste->bg ?>" width="<?php echo $__mxwdimg ?>" style="<?php echo $__mxhgimg ?>"/></div> 
				<?php echo Spn($__dtec->tt); ?> 
			</h1>	
		</div> 
		<div class="_col2">
			<div class="_logo"><img src="<?php echo $__dtec->cl->lgo->main->big ?>" /></div>
			<form action="inc/prc/_gn.php?_t=tll" method="POST" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>">
				<h2 class="_msjrs"></h2>
				<input name="SndUs" id="SndUs" type="hidden" value="On" />
				<input name="SndEmad" id="SndEmad" type="hidden" value="On" />
				<input name="_i" id="_i" type="hidden" value="<?php echo $__dtec->enc ?>" />
				<input name="MM_Send" id="MM_Send" type="hidden" value="EcTll" />
				<div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
				<div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
				<div id="<?php echo $__id_fm ?>_flds"> 
					<ul>
						<li><?php echo HTML_inp_hd('____key', $__id_rnd); ?></li>
						<li><?php echo HTML_inp_hd('____cl', $__dtec->cl->enc); ?></li>
						<li><?php echo HTML_inp_hd('____ec', $__dtec->id); ?></li>
						<li><?php echo HTML_inp_tx('Cnt_Nm'.$__id_rnd, 'Nombre completo', '' , FMRQD); ?></li>
						<li><?php echo HTML_inp_tx('Cnt_Eml'.$__id_rnd, 'Correo', '' , FMRQD_EM); ?></li>
						<li><?php echo HTML_inp_tx('ussnd_nm', 'Nombre del destinatario', '' , FMRQD); ?></li>
						<li><?php echo HTML_inp_tx('ussnd_em', 'Correo del destinatario', '' , FMRQD_EM); ?></li>
						<li><p><?php echo $__dtec->cl->tag->txta->{'plcy-txt'}->v; ?></p></li>
						<?php if(!isN($__dtec->cl->tag->lnk->{'plcy-link'}->v)){ ?>
							<li>
								<div class="_plcy_lnk" id="_plcy_lnk<?php echo $__id_rnd; ?>">
									<?php echo _HTML_Input('Plcy_Chck'.$__id_rnd, '<a href="'.$__dtec->cl->tag->lnk->{'plcy-link'}->v.'" target="_blank">'.'Acepto Políticas de Privacidad'.'</a>','','_chk','checkbox'); ?>	
								</div>
							</li>
						<?php } ?>
						
						<li class="_snd">
							<input class="botonEnviar" type="submit" name="Submit"  value="<?php echo TX_SND ?>">
						</li>
					</ul> 
				</div>
			</form>

			<div class="success_ok">
				<figure></figure>
				<h2 class="_tt"></h2>  
				<div class="_tx"></div> 
			</div>                 
		</div>
	</div>
</div>
<style>
@import url('https://fonts.googleapis.com/css?family=Economica|Lato|Roboto&display=swap');
*{padding:0;margin:0;box-sizing:border-box}
._fm_snd_frd{padding-top:0;padding-bottom:0;overflow:hidden;display:flex;background-color:<?php echo $__dtec->cl->tag->clr->main->v; ?>}
._fm_snd_frd .wrp{display:flex;width:100%}
._fm_snd_frd .wrp ._col1,
._fm_snd_frd .wrp ._col2{width:50%;position:relative}
._fm_snd_frd .wrp ._col1{-webkit-box-shadow:0 0 5px 0 rgba(0,0,0,0.75);-moz-box-shadow:0 0 5px 0 rgba(0,0,0,0.75);box-shadow:0 0 5px 0 rgba(0,0,0,0.75);}
._fm_snd_frd .wrp ._col1 h1{text-transform:uppercase;text-align:center;display:block;color:#FFF;background-color:var(--ec-fm-bck);position:relative;font:300 25px/1em Yanone Kaffeesatz;margin:0;padding:20px 0 0}
._fm_snd_frd .wrp ._col1 h1 img{width:100%;padding:0;margin-bottom:0;margin-top:23px}
._fm_snd_frd .wrp ._col1 h1,
._fm_snd_frd .wrp ._col1 h1 span{background-color:#909091}
._fm_snd_frd .wrp ._col1 h1 span{color:#FFF;font-size:18px;line-height:.9em;text-transform:none;margin:0;display:block;padding:20px}
._fm_snd_frd .wrp ._col2{display:inline-table;float:right;padding-right:30px;padding-left:30px;padding-top:20px}
._fm_snd_frd .wrp ._col2 ._logo{width:70%;margin:10px auto 20px}
._fm_snd_frd .wrp ._col2 ._logo img{width:100%}
._fm_snd_frd .wrp ._col2 form ul{list-style-type:none}
._fm_snd_frd .wrp ._col2 form .___txar._anm{position:relative}
._fm_snd_frd .wrp ._col2 form p{font-family:'Lato',sans-serif;text-align:left;font-size:9px;line-height:16px;color:#999;margin-bottom:20px;color:#a2abad;text-align:justify;text-overflow:ellipsis;margin-bottom:20px;line-height:12px}
._fm_snd_frd .wrp ._col2 form .___txar._anm input[type=text],
._fm_snd_frd .wrp ._col2 form .___txar._anm input[type=email],
._fm_snd_frd .wrp ._col2 form .___txar._anm textarea{font-family:"Lato",Verdana,Geneva,sans-serif;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;border:1px solid #999;width:100%;margin-bottom:5px;background-color:#FFF;background-position:right 10px center;background-size:auto 50%;padding:10px 20px}
._fm_snd_frd .wrp ._col2 form .botonEnviar{padding:15px 10px!important;background-color:#1d2324!important;width:50%;margin:0 auto;display:block}
._fm_snd_frd .wrp ._col2 form ::-webkit-input-placeholder{font-size:12px;color:#c1c1c1}
._fm_snd_frd .wrp ._col2 form :-ms-input-placeholder{font-size:12px;color:#c1c1c1}
._fm_snd_frd .wrp ._col2 form ::placeholder{font-size:12px;color:#c1c1c1}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk{background-color:#e7ebed;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;margin-bottom:13px}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc{text-align:left;margin-top:5px;margin-bottom:5px}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc ._chk{width:100%;position:relative;border-radius:50px;vertical-align:top;display:inline-block;text-align:center;margin:10px auto 7px}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc ._chk input[type=checkbox]{visibility:hidden}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc ._chk label{width:16px;height:16px;cursor:pointer;position:relative;border-radius:50px;background-color:#CCC;background-position:bottom;display:inline-block;vertical-align:top}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc ._chk input[type=checkbox]:checked + label:after{opacity:1}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc ._chk label:after{content:'';width:10px;height:10px;position:absolute;top:3px;left:3px;opacity:0;border-radius:50px;background-color:#1d2324;background-position:bottom}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc span{vertical-align:top;display:inline-block;margin-left:6px;font-size:12px;color:#fff}
._fm_snd_frd .wrp ._col2 form ._plcy_lnk .__chkslc span a{color:#a1abad;text-decoration:none;font-size:11px}
._fm_snd_frd .wrp ._col2.success .success_ok{display:block}
._fm_snd_frd .wrp ._col2.success .success_ok ._tt{text-align:center;font-family:Economica;text-transform:uppercase;padding:0;margin:0;font-size:25px;color:#ffffff99}
._fm_snd_frd .wrp ._col2.success .success_ok ._tx{text-align:center;font-size:15px;font-family:'Roboto',sans-serif;color:#ffffffad}
._fm_snd_frd .wrp ._col2.success form{display:none}
._fm_snd_frd .wrp ._col2.success .success_ok figure{width:100px;height:80px;margin-left:auto;margin-right:auto;background-image:url(https://form.sumr.co/_img/estr/success_icn_1.svg);margin-top:30px;background-position:center;background-repeat:no-repeat}
._fm_snd_frd .wrp ._col2 ._msjrs{display:block;opacity:0;font-size:10px;text-align:center;padding:4px 0;border:1px solid orange;color:orange;font-weight:100;border-radius:6px;margin-bottom:10px}
._fm_snd_frd .wrp ._col2 ._msjrs.ok{opacity:1}
._fm_snd_frd .wrp ._col2 .___txar._anm input[type=text].error,
._fm_snd_frd .wrp ._col2 .___txar._anm input[type=email].error{ border:1px solid #f09100 }
._fm_snd_frd .wrp ._col2 .___txar._anm label.error{position:absolute;right:5px;top:5px;color:#f09100;font-size:9px;text-transform:lowercase;font-style:italic;opacity:1;pointer-events:none}
</style>
<?php 

	$_CntJQ .= "

		var _fm = $('#".$__id_fm."');
		var _fmrsl_tt = $('#".$__id_bx." .success_ok ._tt');
		var _fmrsl_tx = $('#".$__id_bx." .success_ok ._tx');
		var _fmrsl_msj = $('#".$__id_bx." ._msjrs');
		var __ldsnd={};
	
		if(typeof __onl != 'function'){ 
			function SUMR_Ld.f.onl(){
				var __e = navigator.onLine; 
				if(__e == true){ return true; }else{ return false; }
			}
		}

		function __snd(p=null){
			
			if(!isN(p) && !isN(p.t) && !isN(p.d)){
				if (SUMR_Ld.f.onl() && isN( __ldsnd[p.t] ) ){
		
					__ldsnd[p.t] = $.ajax({
										type:'POST',
										url: '/inc/prc/_gn.php?_t=tll',
										data: p.d,
										dataType: 'json',
										beforeSend: function() {
											if(!isN(p._bs)){ p._bs(); }
										 },
										 error:function(e){
											 if(!isN(p._w)){ p._w(e); }
										 },
										success:function(e){	
											if(!isN(p._cl)){ p._cl(e); }
										},
										complete:function(e){
											__ldsnd[p.t] = '';
											if(!isN(p._cm)){ p._cm(e); }
										}
									});							
				}
			}
		} 

		function _gW(_r){
			_fmrsl_msj.html('Intenta de nuevo, por favor').addClass('ok');			
			setTimeout(function(){ _fmrsl_msj.removeClass('ok'); }, 6000);
		}

		function _gR(_r){
			if(_r.e == 'ok'){
				var p_d = { 'id':'".$__dtec->enc."', 't':'ck' };	
				top.postMessage( JSON.stringify(p_d) , \"*\");	
				_gOk(_r);							
			}else{
				_gW();
			} 
		} 

		function _gOk(_r){
			$(_fmrsl_tt).html('".TX_SCSS."');
			$(_fmrsl_tx).html('".TX_SCSS_MSJ."');
			$('._fm_snd_frd ._col2').addClass('success');	
		}

		function _sndData(){
			
			var __plcy_e = $('#Plcy_Chck{$__id_rnd}').is(':checked');
			
			if(__plcy_e){

				if(_fm.valid()){	
					__snd({
						t:'mdl_cnt',
						d:_fm.serialize(),
						_bs:function(){ $('body').removeClass('on'); },
						_cl:function(r){
							if(!isN(r)){ _gR(r); }	
						},
						_cm:function(r){ $('body').addClass('on'); },
						_w:function(r){
							if(!isN(r)){ _gW(r); }
						}
					});    
				}	

            }else{
				$('#_plcy_lnk{$__id_rnd}').effect('shake', function(){  });
		    }
		}

		$('.botonEnviar').off('click').click(function(event){
			event.preventDefault();
			_sndData();
		});

		$('input').keyup(function() {
			var _i = $(this);
			if(_i.val() != '') { $(_i).addClass('_ok'); }else{ $(_i).removeClass('_ok'); }   
		});
	"; 
?>