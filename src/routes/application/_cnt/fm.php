<?php 	
	//-------------- VARIABLES GENERALES - START --------------//
	
	$__e = Php_Ls_Cln($_GET['_e']);
	$_____md_key = Php_Ls_Cln($_GET['__k']);
	
	$__id_rnd = '_'.Gn_Rnd(20);
	$__id_bx = 'FmBx'.$__id_rnd;
	$__id_fm = 'FmMdl'.$__id_rnd;
	$__id_fm_btn = 'FmMdlBtn'.$__id_rnd;
	
	//-------------- TARGET FORM --------------//
	
	if(!_isFm()){ $__trg_a = "_self"; }else{ $__trg_a = "_parent"; }
	
?> 
	<div class="__fm" style="opacity:0;" id="<?php echo $__id_bx ?>">	
		<h1 class="_msjrs">Texto error</h1>
		<form enctype="multipart/form-data" action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off" class="<?php if($__fm->shw->sch=='ok'){ echo '__sch'; } ?>">
			<?php if($_GET['__Sv'] == 'ok'){ echo HTML_inp_hd('__Sv', 'ok'); } ?>
			<?php echo HTML_inp_hd('____key', $__id_rnd); ?>
			<?php echo HTML_inp_hd('Appl_Fm'.$__id_rnd, $__cntr_fm->enc); ?>
			
			<div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
			<div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>	  	
			<div id="<?php echo $__id_fm ?>_flds" class="_flds">	
	
				<!------------- CAMPOS BASICOS DE FORMULARIO - START ------------->
	
				<?php include(DIR_CNT_FM.'custom.php'); ?>			
				<?php 

					if(!isN($__fm->plcy)){
							
						$__lnk_p = $__fm->plcy->lnk->url;
						$__lnk_p_t = $__fm->plcy->tx;
						if(!isN($__fm->plcy->lnk->tt)){ $___plcy_tt = $__fm->plcy->lnk->tt; }else{ $___plcy_tt = TX_PLTCDTA_TT; }
						
						echo HTML_inp_hd('Plcy_Id'.$__id_rnd, $__fm->plcy->enc);	
						
					}else{
						
						$__plcy = GtClPlcyDflt([ 'cl'=>$__cl->id ]);
						
						if(!isN($__plcy->id)){
							
							$__lnk_p = $__plcy->lnk->url;
							$__lnk_p_t = $__plcy->tx;
							if(!isN($__plcy->lnk->tt)){ $___plcy_tt = $__plcy->lnk->tt; }else{ $___plcy_tt = TX_PLTCDTA_TT; }
						
							echo HTML_inp_hd('Plcy_Id'.$__id_rnd, $__plcy->enc);	
	
						}
						
					}	
	
				?>	
	
				<?php if(!isN($__lnk_p_t)){ ?><div class="_plcy_txt"><?php echo $__lnk_p_t ?></div> <?php } ?>
	
				<div class="_plcy_lnk" id="_plcy_lnk<?php echo $__id_rnd; ?>">					
					<?php echo _HTML_Input('Plcy_Chck'.$__id_rnd, '<a href="'.$__lnk_p.'" target="_blank">'.$___plcy_tt.'</a>','','_chk','checkbox'); ?>	
				</div> 
	
				<div class="_btn_snd">	
					<button class="pin" id="<?php echo $__id_fm_btn ?>" name="<?php echo $__id_fm_btn ?>"><?php echo TX_SND; ?></button>
				</div>
			</div>
		</form> 
	
		<div class="success_ok">
			<figure></figure>
			<h1 class="_tt"></h1>  
			<div class="_tx"></div> 
		</div>
	</div>
	
	<?php
	
	if($__fm->thx->top == 'ok' && !isN($__fm->thx->url) && 1==2){

		$___thx_act = "

			if(!isN(_r) && !isN(_r.appl)){
				
				$(_fmrsl_tt).html(_utt);
				$(_fmrsl_tx).html(_utx);
				$('body').addClass('success');
				
				swal('ENVIO EXITOSO', 'Ahora se redireccionara para subir los documentos necesarios', 'info');
				
				setInterval(function(){
					var __url = '".$__fm->thx->url."'+_r.appl;
					window.top.location.href = __url;	
				},3000);

			}
			
		";
		
	}else{
		
		$___thx_act = "
			
			$(_fmrsl_tt).html(_utt);
			$(_fmrsl_tx).html(_utx);
			$('body').addClass('success');		
			
		";
		
	}
	
	
	$_CntJQ_Vld .= "
	
		var _ldr = $('#".$__id_fm."_ld');
		var _fm = $('#".$__id_fm."');
		var _fmflds = $('#".$__id_fm."_flds');
		var _fmrsl = $('#".$__id_fm."_rsl');
		var _fmrsl_tt = $('#".$__id_bx." .success_ok ._tt');
		var _fmrsl_tx = $('#".$__id_bx." .success_ok ._tx');
		var _fmrsl_msj = $('#".$__id_bx." ._msjrs');
		var _utt = '".TX_SCSS."';
		var _utx = '".TX_SCSS_MSJ."';
		
		function _gOk(_r){
			{$___thx_act}
		}
		
		function _gR(_r){
		
			if(_r.e == 'ok'){
				var p_d = { 'id':'".(!isN($__mdlgen->enc)?$__mdlgen->enc:$__mdl->enc)."', 't':'ck' };
		
				top.postMessage( JSON.stringify(p_d) , \"*\");	
				_gOk(_r);	
										
			}else{
				_gW();
			}
		}
		
		function _gW(_r){
			_fmrsl_msj.html('Intenta de nuevo, por favor').show();	
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
				$('#_plcy_lnk{$__id_rnd}').effect('shake', function(){ 
		
				});
				console.log('Vacio error');
			}
		}
		
		$('#{$__id_fm_btn}').off('click').click(function(event){
		
			_sndData();	
		
		});
	
	"; 
	
	if($_GET['Sv'] == 'ok'){ $_CntJQ .= "_gOk();"; }	
	if($__e == 'ok'){ $_CntJQ_Vld .= " _gOk(); "; }

?>