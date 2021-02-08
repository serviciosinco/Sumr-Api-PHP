<?php 
	
	//----------------- GET Parameters -----------------//
	
		$__sgm = Php_Ls_Cln($_POST['_sgm']);
		$__mdl = Php_Ls_Cln($_POST['_mdl']);
		$__lnd = Php_Ls_Cln($_POST['_lnd']);
		$__tab = Php_Ls_Cln($_POST['_tab']);
	
	//----------------- Process -----------------//
		
	$___sgm_dt = GtLndMdlSgmDt([ 'sgm_enc'=>$__sgm, 'mdl_enc'=>$__mdl, 'lnd_enc'=>$__lnd  ]);
	
?>
<div class="_lnddt _anm">
	<div class="_bx">
		<div class="_left _anm">
			<textarea class="_smr_nte"></textarea>
		</div>
		<div class="_right _anm">
			<div class="_hd">
				<div class="btn_pnl"></div>
			</div>
			<div class="_lnrght">
				<ul></ul>
			</div>
		</div>
	</div>
</div>
<div class="_lnddt_btn">
	<button class="_btn_sve _anm" rel="lnd_sgm_sve_tx"><?php echo TXBT_GRDR ?></button>
	<button class="_btn_his _anm" rel="lnd_sgm_his"><?php echo TX_HSTR ?></button>
	<button class="_btn_rmv _anm" rel="lnd_sgm_rmv"><?php echo TX_ELMNR ?></button>
</div>
<?php 
	
	
	$CntJV .= "
	
		var keys = {};
		
		SUMR_Lnd.sgm = '".$__sgm."';
		SUMR_Lnd.mdl = '".$__mdl."';
		SUMR_Lnd.lnd = '".$__lnd."';
		SUMR_Lnd.lndsgm = '".$___sgm_dt->enc."';
	
		$('._lnddt ._bx ._smr_nte').summernote('destroy');
		
		$('._lnddt ._bx ._smr_nte').summernote({
			
			placeholder: '".TX_INGCTN."',
			height: 1000,
			tabsize: 1,
	        dialogsInBody: true,
	        enterHtml: '<br><br>',
	        emptyPara: '<div style=\'border:1px solid red\'></div>',
	        formatPara: '<br>',
	        lang: 'es-ES',
	        
	        toolbar: [
		        ['color', ['color']],
				['fontsize', ['fontsize']],
				['font', ['bold', 'italic', 'underline', 'clear']],
				['para', ['ul', 'ol', 'paragraph', 'height']],
				['insert', ['hr', 'link', 'unlink', 'table']]
			],
			
			fontSizes: ['8', '10', '11', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36'],
			
	        popover: {
			    air: [
				  ['color', ['color']],
				  ['fontsize', ['fontsize']],
			      ['font', ['bold', 'italic', 'underline', 'clear']],
			      ['para', ['ul', 'ol', 'paragraph', 'height']],
			      ['insert', ['hr', 'link', 'unlink', 'table']]
			    ]
			},
			insertTableMaxSize: {
			  col: 20,
			  row: 20
			},
			callbacks: {
				onInit: function() {
					$(this).summernote('code', '".$___sgm_dt->html."');
			    },
			    onPaste: function(e) {
					SUMR_Ec.f.cpyhtml_snd({
				     	id:'._lnddt ._bx ._smr_nte',
				     	s:function(d){
					 		if(d.e == 'ok'){
					     		$('._ovr ._lnd_mod_ovr ._smr_nte').summernote('code', 'aaa');
							 	$('._ovr ._lnd_mod_ovr ._smr_nte').summernote('code', 'eee');
						 	}
				     	},
				     	sw:function(d){
					     	
				     	}
			     	});
			    },
			    onChange: function(e) {
				    console.log('onChange');
			    },
			    onKeyup: function(e) {
			    	keys['key'+e.keyCode] = 'no';
			    },
			    onKeydown: function(e) {
					keys['key'+e.keyCode] = 'ok';
				    	
			    	var _k13 = keys['key'+13];
				    var _k16 = keys['key'+16];
				      
				    if( _k13 == 'ok' && _k16 == 'ok' ){
					    
				    }else if(_k13 == 'ok'){
					    swal('¡Recuerda!', 'Utiliza (Shift+Enter) para insertar saltos de línea', 'info');
				    }
			    }
			}
			
		});
		 
		$('#cboxClose').detach().appendTo('#cboxWrapper > div:first-child').addClass('_anm');

		setTimeout(function() { 

			$('._lnddt_btn').addClass('_fxd');
		
		}, 1000);

	";
?>

<!-- Temporal -->
<style>
	
	._lnddt{ }
	._lnddt ._bx{ display: block; position: relative; padding-bottom: 60px; }
	._lnddt ._bx ._left .note-editable.panel-body{ height: 250px; }
	._lnddt ._bx ._left .note-editor.note-frame.panel.panel-default{ display: block!important; margin: auto!important; width: 98%!important; margin-top:5px!important; }
	._lnddt ._bx ._left .note-editor.note-frame.panel.panel-default .note-statusbar{ height: 25px; }
	
	  

	._lnddt ._bx ._right { background: #545657; width: 0%; height: 100%; position: absolute; top: 0%; right: 0%; }
	._lnddt ._bx ._right._opn { width:60%; }
	._lnddt ._bx ._right._opn > div{ display: block!important; width: 100%; }
	._lnddt ._bx ._right._opn ._hd{ border: 1px solid #c3c5c6; height: 10%; }
	._lnddt ._bx ._right._opn ._hd .btn_pnl{ display: inline-block; background-image: url("<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_btn_right.svg"); width: 30px; height: 30px; background-size: 100% auto; background-repeat: no-repeat; display: block; cursor: pointer; margin-top: 5px; margin-left: 10px; }
	._lnddt ._bx ._right._opn ._hd .btn_pnl:Hover{ opacity: 0.7; }
	._lnddt ._bx ._right._opn ._lnrght{ height: 90%; overflow: scroll; border: 1px solid #c3c5c6;  }
	._lnddt ._bx ._right._opn ._lnrght ul{ list-style: none; padding: 0; margin: 20px 0 0 0; }
	._lnddt ._bx ._right._opn ._lnrght ul li{ border-bottom: 1px dotted #7a7a7a; width: 90%; margin-left: auto; margin-right: auto; display: block; color: #ffffff; padding-top: 10px;  padding-bottom: 10px; }
	._lnddt ._bx ._right._opn ._lnrght ul li .us{ width: 30px; height: 30px; background-repeat: no-repeat; background-position: center center; display: inline-block; background-size: cover; }
	._lnddt ._bx ._right._opn ._lnrght ul li .bx{ display: inline-block; padding-left: 10px; }
	._lnddt ._bx ._right._opn ._lnrght ul li button{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_txt_his_rstr.svg); width: 30px; height: 30px; background-color: transparent; background-position: center center; background-size: 70% auto; display: inline-block; float: right; border: none; background-repeat: no-repeat; opacity: 0.7; }
	._lnddt ._bx ._right._opn ._lnrght ul li button:Hover{ background-size: 100% auto; opacity: 1; }
	
	
	._lnddt_btn{ width: 100%; /*height: 60px;*/ display: block; /*margin-top: 6%!important; margin: auto;*/ text-align: center; position: absolute; left: 0; bottom:0; background-color:#e4e9eb; padding: 10px 15px; border-radius: 0px 0px 25px 25px; -moz-border-radius: 0px 0px 20px 20px; -webkit-border-radius: 0px 0px 20px 20px; }
	._lnddt_btn ._btn_sve{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_btn_sve.svg'); }
	._lnddt_btn ._btn_his{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_btn_his.svg'); }
	._lnddt_btn ._btn_rmv{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_btn_rmv.svg'); }
	._lnddt_btn button{ width: 28%; border: 1px solid #929aa0; display: inline-block; background-repeat: no-repeat!important; text-align: center; cursor: pointer; border-radius: 11px; -moz-border-radius: 11px; -webkit-border-radius: 11px; font-family: Economica; text-transform: uppercase; font-weight: 500; padding: 6px 10px 6px 50px; background-position: left -5px center; background-color: transparent; color: #7a8486; }
	._lnddt_btn button:hover{ background-position: left -5px center; color: #343c3e; }
	._lnddt_btn._fxd{ position: sticky !important; bottom: 0; }
	
</style>