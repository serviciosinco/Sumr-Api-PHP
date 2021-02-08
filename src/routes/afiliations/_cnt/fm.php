<?php 
	
	//-------------- VARIABLES GENERALES - START --------------//
		
		$__e = Php_Ls_Cln($_GET['_e']);
		$_____md_1 = Php_Ls_Cln($_GET['_MD']);
		$_____md_2 = Php_Ls_Cln($_GET['_Md']);
		$_____md_3 = Php_Ls_Cln($_GET['_md']);
		$_____md_rfr = Php_Ls_Cln($_GET['rfr']);
		$_____fnt_uid = Php_Ls_Cln($_GET['_fnt']);
		$_____md_key = Php_Ls_Cln($_GET['__k']);

		if(!isN($_____md_1)){ 
			$_____md_uid = $_____md_1; 
		}elseif(!isN($_____md_2)){ 
			$_____md_uid = $_____md_2; 
		}elseif(!isN($_____md_3)){ 
			$_____md_uid = $_____md_3; 
		}else{
			
			$_____md_url = URL_Data( $_____md_rfr );
			$_____md_schw = unserialize(SIS_SCHWBS);
			
			if (in_array($_____md_url['host'], $_____md_schw)){ 
				$_____md_uid = SIS_MD_SCHORG; 
			}
		}
		
		if(isN($_____md_key) && $_____md_key == '{keyword}'){ $_____md_key = ''; }
		
		$__id_rnd = '_'.Gn_Rnd(20);
		$__id_bx = 'FmBx'.$__id_rnd;
		$__id_fm = 'FmMdl'.$__id_rnd;
		$__id_fm_btn = 'FmMdlBtn'.$__id_rnd;

	//-------------- CLASS FORM --------------//

		$__Forms = new CRM_Forms();
		$__Forms->_rnd = $__id_rnd;

	//-------------- TARGET FORM --------------//

		if(!_isFm()){ $__trg_a = "_self"; }else{ $__trg_a = "_parent"; }

?> 
	<div class="__fm" style="opacity:0;" id="<?php echo $__id_bx ?>">	
		
		<h1 class="_msjrs">Texto error</h1>
				
	    <form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off" class="<?php if($__fm->shw->sch=='ok'){ echo '__sch'; } ?>">
	    	
	    	<?php if($_GET['__Sv'] == 'ok'){ echo HTML_inp_hd('__Sv', 'ok'); } ?>
	    	
	    	<?php echo HTML_inp_hd('____key', $__id_rnd); ?>
	    	<?php echo HTML_inp_hd('SndUs'.$__id_rnd, 'On'); ?>
	    	<?php echo HTML_inp_hd('SndEmad'.$__id_rnd, 'On'); ?>
	    	<?php echo HTML_inp_hd('MMSend'.$__id_rnd, 'WebLndg'); ?>
	    	<?php echo HTML_inp_hd('sch_cnt', "no"); ?>
	    	<?php if(!isN($_____fnt_uid)){ echo HTML_inp_hd('SndFnt'.$__id_rnd, $_____fnt_uid); } ?>
	    	<?php if(!isN($_____md_uid)){ echo HTML_inp_hd('SndMed'.$__id_rnd, $_____md_uid); } ?>
	    	<?php if(!isN($_____md_key)){ echo HTML_inp_hd('KeyMed'.$__id_rnd, $_____md_key); } ?>
	    	<?php if(!isN($_____md_lat)){ echo HTML_inp_hd('Lat'.$__id_rnd, $_____md_lat); } ?>
	    	<?php if(!isN($_____md_lon)){ echo HTML_inp_hd('Lon'.$__id_rnd, $_____md_lon); } ?>
				  
		  	<?php if($__mdlgen->id != NULL){ echo HTML_inp_hd('MdlGen'.$__id_rnd, $__mdlgen->enc); } ?>
		  	<?php echo $__Forms->_fields()->hdn; ?>
	      
		  	<div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
		  	<div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
		  	
		  	<!------------- SEARCH BY KEY - START ------------->

		  	<div id="<?php echo $__id_fm ?>_flds" class="_flds">
		  		
		  		<?php 
			  		if($__mdl->fld != NULL){
						
						$_f = _Fm_Fld_B(['a'=>$__mdl->fld, 'r'=>$__id_rnd]); echo $_f->html;
						$_CntJQ_Vld .= $_f->js;
						
					}else{
		  		?>		

		  				<!------------- CAMPOS BASICOS DE FORMULARIO - START ------------->

			 
		  				<?php include(DIR_CNT_FM.'default.php'); ?>	
		  				
						
	                          
				<?php } ?> 
					
					
			  
	    	</div>
	    </form> 
	    
	    <div class="success_ok">
			<figure></figure>
			<h1 class="_tt"></h1>  
			<div class="_tx"></div> 
	    </div>
    
	</div>
    
    <style>
	    
	    ._err{border: 1px solid rgb(240, 144, 1);padding: 10px;border-radius: 8px;}
	    ._err label{margin-bottom:0px !important}
	    .search{ background-image: url(DMN_IMG_ESTR_SVG.'search_fm.svg');
			    display: inline-block;
			    width: 40px;
			    height: 40px;
			    vertical-align: middle;
			    background-position: center;
			    background-repeat: no-repeat;
			    background-size: 60% auto;
			    background-color: white;    opacity: 0.5;cursor: pointer}
		.search:hover{ background-color: #e2e2e2; border-radius: 8px; opacity: 1; background-size: 70% auto; }
		.tb3.__hd{ display: none !important; }
	    
    </style>

    <?php if($__g_trck != false){ echo __CkCod([ 'prfl'=>$__cl->prfl ]); } ?>
    
<?php
	
	if($__fm->thx->top == 'ok' && !isN($__fm->thx->url)){

		$___thx_act = "
			
			if(!isN(_r) && !isN(_r.thx) && !isN(_r.thx.url)){
				
				var __url = _r.thx.url;
				window.top.location.href = __url;
				
				/*ga('send', 'pageview', __mdlsucss);*/
			}
			
		";
		
	}else{
		
		$___thx_act = "
			
			$(_fmrsl_tt).html(_utt);
			$(_fmrsl_tx).html(_utx);
			$('body').addClass('success');		
			
		";
	}
	
	$_CntJQ .= "
		function _rSz(p){
			var _h = '';	
			var _h_ov='';
			var _h_doc = parseInt(document.body.offsetHeight);
			
			if(!isN(p)&&!isN(p.h_ov)){ _h_ov=p.h_ov; }
			
			if(!isN(_h_ov)){ 
				var _h = parseInt(_h_doc) + parseInt(_h_ov);
			}else{
				var _h = _h_doc;
			}
			
			var p_d = { 'id':'".(!isN($__mdlgen->enc)?$__mdlgen->enc:$__mdl->enc)."', 't':'rsze', 'height':_h };
			top.postMessage( JSON.stringify(p_d) , \"*\");	
		}
		
	";	
	
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
			
			/*if(_r.w != undefined && _r.w != '' && _r.w != null){ alert(_r.w); }*/
			
			if(_r.e == 'ok'){
				var p_d = { 'id':'".(!isN($__mdlgen->enc)?$__mdlgen->enc:$__mdl->enc)."', 't':'ck' };
				
				top.postMessage( JSON.stringify(p_d) , \"*\");	
				_gOk(_r);							
			}else{
				_gW();
			}
			
			_rSz();
		}
		
		function _gW(_r){
			_fmrsl_msj.html('Intenta de nuevo, por favor').show();	
			_rSz({ h_ov:'1' });
			
			setTimeout(function(){ _fmrsl_msj.fadeOut('slow',function(){ _rSz(); }); }, 6000);
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
			
				event.preventDefault();
				_sndData();	
        });
        
        $(window).resize(function(){
			_rSz();
		});
        
        _rSz();
        
	"; 
	if($_GET['Sv'] == 'ok'){ $_CntJQ .= "_gOk(); "; }	
	if($__e == 'ok'){ $_CntJQ_Vld .= " _gOk(); "; }
		
?>