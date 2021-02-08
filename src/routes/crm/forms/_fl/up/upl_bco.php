<?php  
	$__t = Php_Ls_Cln($_GET['_t']);
 

	if($__t == 'bco'){
		$IdEl = 'id_bco'; // Id de Comparacion en Where
		$BdEl = MDL_BCO_BD; // Base de Datos de Consulta
		$ImNm = 'bco_img'; // Nombre del Campo de la Imagen
		$ImOrg = 'bco_org'; // Nombre del Campo de la Imagen
		$Im_W = 'bco_w'; // Nombre del Campo de la Imagen
		$Im_H= 'bco_h'; // Nombre del Campo de la Imagen
		$Im_B= 'bco_b'; // Nombre del Campo de la Imagen
		$DrIm = DIR_IMG_WEB_BCO; // Directorio de la Imagen 
		$SzBg_W = 10000;
		$SzBg_H = 10000;
	}

?>


<style>
	
	.UplImgNw{ text-align: center; opacity: 0; pointer-events: none; }
	.UplImgNw ._c{ display: inline-block; vertical-align: top; width: 49%; padding: 2%; }
	.UplImgNw._ready{ pointer-events: all; opacity: 1; }
	
	.UplImgNw ._c .___txar{ width: 100%; }
	.UplImgNw ._c .tag-editor{ width: 100% !important; border: 2px dotted #7a7a7a; background-color: white; padding:5px 5px; }
	.UplImgNw ._c .tag-editor .tag-editor-tag{ background-color: var(--second-bg-color); color: white; padding: 5px 9px; }
	.UplImgNw ._c .tag-editor .tag-editor-delete{ background-color: var(--second-bg-color); color: white; padding: 5px 9px 5px 0px; }
	
	.UplImgNw ._c h2{ text-align: left; font-size: 14px; color: #4c4c4c; }

	
	.styled-select-mlt{ background-position: right 10px center; background-size: 20px;padding: 6px 0; border: 2px dotted #7a7a7a; background-color: transparent }
	.styled-select-mlt label{ display: none; }
	.select2-container--default .select2-selection--multiple{ background-color: transparent }
	.select2-results__option {padding: 6px;user-select: none;-webkit-user-select: none;background-color: black;color: #bbbbbb;}
	.ftp_ls.no{ display: none; }
	.ftp_ls.ok{ display: block; padding: 20px 0; }
	
	.ftp_ls label{ display: none; }
	
	._bco_tx .select2-selection__rendered .select2-selection__choice{ background-color: var(--main-bg-color); border: 1px solid var(--second-bg-color);color: #ccc;padding: 5px; }
	._bco_tx .select2-selection__rendered .select2-selection__choice div{display: inline-block; }
	._bco_tx .select2-container--default .select2-results__option[aria-selected=true] {background-color: #3e3e3e;}
	._bco_tx .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{ margin-right: 6px; }
	
	
	
	.UplImgNw .tag-editor li{ border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; margin-right: 5px; }
	.UplImgNw .tag-editor .tag-editor-spacer{ display: none; }
	.UplImgNw .tag-editor .tag-editor-delete i:before{ color: white; }

	
	.UplImgNw_Ldr{ background-color: #EFF2F7; position: absolute; left: 0; top: 0; width: 100%; height: 100%; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; z-index: 1; }
	.UplImgNw_Ldr::before{ width: 200px; height: 200px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>bco_cvr_load.svg); background-repeat: no-repeat; background-position: center center; background-size: auto 100%; display: block; margin-left: auto; margin-right: auto; margin-top: 50px; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; }
	.UplImgNw_Ldr h1{ font-family: Economica; font-size: 22px; text-transform: uppercase; font-weight: 300; width: 100%; display: block; text-align: center; }
	.UplImgNw_Ldr h1 span{ display: block; color: #8a8f8f; font-size: 0.8em !important; }
	.UplImgNw_Ldr._ready{ top:-2000px; opacity: 0; pointer-events: none; }
	
</style>

<div id="UplImgNw_Ldr" class="UplImgNw_Ldr _anm">
	<h1>Cargando Entorno... <span>No tomará mucho tiempo</span></h1>
</div>
	
<div id="UplImgNw" class="UplImgNw UplBco _lght _anm">
		
	<div class="_c _c1">
		<form id="UplNwB" class="UplNwB" method="post" action="<?php echo PRC_UPLD_GN.'?'.'_t=upl_bco&Rnd='.Gn_Rnd(20) ?>" enctype="multipart/form-data">
			<div id="drop_<?php echo $___Ls->id_rnd; ?>" class="_drop">
				Arrastre Aquí

				<a>Explorar</a>
				<input type="file" name="upl" multiple />
                <input id="_nm" name="_nm" type="hidden" value="<?php echo $__t ?>" />
                <input id="_bd" name="_bd" type="hidden" value="<?php echo $BdEl ?>" />
                <input id="_id" name="_id" type="hidden" value="<?php echo $IdEl ?>" />
                <input id="_fl" name="_fl" type="hidden" value="<?php echo $ImNm ?>" />
                <input id="_fl_org" name="_fl_org" type="hidden" value="<?php echo $ImOrg ?>" />
                <input id="_fl_w" name="_fl_w" type="hidden" value="<?php echo $Im_W  ?>" />
                <input id="_fl_h" name="_fl_h" type="hidden" value="<?php echo $Im_H  ?>" />
                <input id="_fl_b" name="_fl_b" type="hidden" value="<?php echo $Im_B  ?>" />
                <input name="MM_update" type="hidden" value="ImgUplNw" />
                <input name="bco_tag_hid" id="bco_tag_hid" class="bco_tag_hid" type="hidden" value="" />
                <input name="bco_are_hid" id="bco_are_hid" class="bco_are_hid" type="hidden" value="" />
                <input name="bco_cd_hid" id="bco_cd_hid" class="bco_cd_hid" type="hidden" value="" />
                
                <input name="bco_ftp_on" id="bco_ftp_on" class="bco_ftp_on" type="hidden" value="" />
                <input name="bco_ftp_hid" id="bco_ftp_hid" class="bco_ftp_hid" type="hidden" value="" />
			</div>
			<ul></ul>
		</form>
	</div>
	
	<div class="_c _c2">
		<?php  
			if($__t == 'bco'){
				
				echo h2(TX_TAGS, '', "font-family: 'Economica',sans-serif; ");
				
				echo HTML_inp_tx('bco_tag', TX_KYW, ctjTx($row_Dt_Rg['bco_tag'],'in'), '', '', '_bco_tx').HTML_BR;  
				
				echo LsClAre([
								'all'=>'ok',
								'id'=>'bcoare_are',
								'v'=>'id_clare',
								'rq'=>2,
								'mlt'=>'ok'
							]).HTML_BR;  
							
				
				$CntWb .= JQ_Ls('bcoare_are', TX_SLCAR, '', '_slcClr', ['ac'=>'no']);
				
				//if(ChckSESS_superadm()){ 
                    echo LsCdOld([ 'id'=>'bco_cd','v'=>'id_siscd','','rq'=>1,'mlt'=>'ok' ]);  
                    $CntWb .= JQ_Ls('bco_cd',FM_LS_SLCD); 
				//}
				
                //echo OLD_HTML_chck('bco_ftp', 'FTP' );
            
                ?> <div class="ftp_ls no"> <?php       
               		//echo LsFtp(array('id'=>'bco_clftp','v'=>'id_clftp','','rq'=>1));  $CntWb .= JQ_Ls('bco_clftp',FM_LS_SLCD);         
                ?> </div> <?php
                
				                   
				$CntWb .=	" SUMR_Main.kyw({id:'bco_tag'}); "; 	
			}
		?>
	</div>
		
</div>    

<style>
	
	.UplImgNw.UplBco .UplNwB ul li{ padding-left:0px; padding-bottom: 10px; padding-bottom: 10px; min-height: inherit; }
	.UplImgNw.UplBco.str_prcs ._c._c1{ width: 100%; }
	.UplImgNw.UplBco.str_prcs ._c._c2{ display: none; }
	.UplImgNw.UplBco.str_prcs .UplNwB{ padding-top: 0px; padding-bottom: 15px; padding-left: 0; padding-right: 0; border: none; }
	.UplImgNw.UplBco.str_prcs .UplNwB ._drop{ margin-bottom: 0px; }
	.UplImgNw.UplBco.str_prcs ._drop{ padding-top: 30px; padding-bottom: 30px; }
	
	.UplImgNw.UplBco .UplNwB ul li canvas{ left: 0; top: 0; }
	.UplImgNw.UplBco .UplNwB ul li p{ left: 57px; width: 175px; margin: 0; }
	
	
	.UplImgNw.UplBco .UplNwB ul li div.opt{ position: absolute; top: 23px; right: 0px; display: flex; }
	.UplImgNw.UplBco .UplNwB ul li div.opt button{ width: 20px; height: 20px; background-repeat: no-repeat; background-position: center center; background-size: auto 80%; border: none; cursor: pointer; }
	.UplImgNw.UplBco .UplNwB ul li div.opt button.cancel{ background-image:url("<?php echo DMN_IMG_ESTR_SVG ?>upl_x.svg"); }
	.UplImgNw.UplBco .UplNwB ul li div.opt button.retry{ background-image:url("<?php echo DMN_IMG_ESTR_SVG ?>upl_retry.svg"); display: none; }
	.UplImgNw.UplBco .UplNwB ul li div.opt button:hover{ background-size: auto 70%; }
	
	
	.UplImgNw.UplBco .UplNwB ul li.error div.opt button.cancel{ display: none; }
	.UplImgNw.UplBco .UplNwB ul li.error div.opt button.retry{ display: block; }
	
	
	.UplImgNw.UplBco .UplNwB ul li.error p{ color: #d97c00; }
	.UplImgNw.UplBco .UplNwB ul li h2{ color: #848484; font-size: 12px; font-weight: 300; display: flex; margin: 0; padding: 0;  align-items: center; justify-content: center; }
	.UplImgNw.UplBco .UplNwB ul li h2 i{ margin-left: 5px; text-transform: lowercase; }
	
	
	.UplImgNw.UplBco .UplNwB ul li div._g{
		position: relative; display: block; width: 43px; height: 43px;
	}
	
	
	.UplImgNw .UplNwB ul li input[type=text] {
		display: block !important;
	    top: 50% !important;
	    margin-top: -10px !important;
	    margin-left: 0 !important;
	    font-family: Economica !important;
	    font-weight: 300 !important;
	    font-size: 12px !important;
	    height: 16px !important;
	    width: 100% !important;
	}
	
	.UplImgNw .UplNwB ul li input[type=text] span{
		font-size: 12px; opacity: 0.4;
	}

	
</style>	
	    
<?php 
	
	$CntWb .= "	
	       
	        
	        
		SUMR_Main.ld.f.upl( function(){	
	        
	        
	        var SUMR_Upl = {
		        bx:{
			        main:$('#UplImgNw')
		        },
	        	bco:{
		        	ls:[]
	        	}
        	};
        	
	       
	        function _Rsze_UpBx(p){
		        
		        
		        $('#bco_tag_hid').val( $('#bco_tag').val() );
		        
		        
		        var __tot_add = SUMR_Upl.bco.ls.length;
		        
		        if( !SUMR_Upl.bx.main.hasClass('str_prcs') && __tot_add > 0){
		        	SUMR_Upl.bx.main.addClass('str_prcs');
				}
				
		    	if(__tot_add == 0){
			    	
					$.colorbox.resize({ width:800, height:400 });
					SUMR_Upl.bx.main.removeClass('str_prcs');
						
				}else if(__tot_add < 5 && __tot_add > 2){
					
					$.colorbox.resize({ width:350, height:500 });	
					
				}else if(__tot_add < 3){
					
					$.colorbox.resize({ width:350, height:400 });	
					
				}else if(__tot_add > 5){
					
					$.colorbox.resize({ width:350, height:'80%' });	
					
				}
				 
	        }
	        
        	
        	
        	
			$('.tag-editor, .select2-container').addClass('_bco_tx');
			
			$('.tag-editor, #bco_tag').keyup(function(){
				$('#bco_tag_hid').val($('#bco_tag').val() );
			});

			
			$('#bcoare_are').change(function(){
				$('#bco_are_hid').val($('#bcoare_are').val());
				$('#bco_tag_hid').val($('#bco_tag').val() );
			});
			
			$('#bco_clftp').change(function(){
				$('#bco_ftp_hid').val($('#bco_clftp').val());
			});
			
			$('#bco_cd').change(function(){
				$('#bco_cd_hid').val($('#bco_cd').val());
				$('#bco_tag_hid').val($('#bco_tag').val() );
			});
			
			$('#bco_ftp').on( 'click', function(){
				if($( '#bco_ftp:checked' ).val() == 1){
					$('#bco_ftp_on').val('ok');
					$('.ftp_ls').addClass('ok').removeClass('no');			
				}else{
					$('#bco_ftp_on').val('');
					$('.ftp_ls').addClass('no').removeClass('ok');		
				}
			});
			
			
			
			$('#drop_".$___Ls->id_rnd." a').click(function() {
				$(this).parent().find('input').click();
			});
			
			
			SUMR_Main.ld.f.upl( function(){

				if(jQuery().fileupload){

					$('#UplNwB').fileupload({
						dropZone: $('#drop_".$___Ls->id_rnd."'),
						maxRetries: 100,
						retryTimeout: 500,
						dataType: 'json',
						maxNumberOfFiles: 100,
						limitConcurrentUploads:2,
						/*sequentialUploads: true,*/
						add: function(n, r) {
							
							var _id = Enc_Rnd(),
								e = $('#UplNwB ul'),
								i = $('<li class=\"working\" id=\"_upl_'+_id+'\" data-id=\"'+_id+'\"><div class=\"_g\"><input type=\"text\" class=\"_pcnt\" value=\"0\" data-width=\"40\" data-height=\"40\"' + ' data-fgColor=\"#0788a5\" data-readOnly=\"true\" data-bgColor=\"#d6dbde\" data-thickness=\".1\" data-displayInput=\"true\" /></div><p></p><div class=\"opt\"><button class=\"cancel _anm\"></button><button class=\"retry _anm\"></button></div></li>');
							
							i.find('p').text(r.files[0].name).append('<h2>' + SUMR_Ld.f.nSz(r.files[0].size) + '<i class=\"_bytes\"></i> </h2><em class=\"_error_msj_w\"></em>');
							r.context = i.appendTo(e);
							
							i.find('input').knob({
								format: function (v) {
									return v + '%';
								}
							});
							
							i.find('.cancel').click(function(e) {
								
								e.preventDefault();
								
								if (i.hasClass('working')){ s.abort(); }
								
								i.fadeOut(function(){ 
									
									SUMR_Upl.bco.ls.splice( SUMR_Upl.bco.ls.indexOf(_id),1);							
									i.remove(); 
									_Rsze_UpBx();
									
								});
								
							});
							
							i.find('.retry').click(function(e) {
								e.preventDefault();
								var s = r.submit();
								if (i.hasClass('error')){ 
									i.removeClass('error');
									r.submit();
								}
								_Rsze_UpBx();
							});
							
							var s = r.submit();
							
							SUMR_Upl.bco.ls.push(_id);
							
							_Rsze_UpBx();
							
						},
						progress: function(e, t) {
							
							var n = parseInt(t.loaded / t.total * 100, 10);
							var _id = t.context.attr('data-id');
							
							if(!isN(n)){					
								
								$('#_upl_'+_id+' input._pcnt').val(n).change();
								$('#_upl_'+_id+' ._bytes').html( ' / '+SUMR_Ld.f.nSz(t.loaded)+ ' cargados' );
			
								if (n == 100) {
									/*t.context.removeClass('working');*/
								}
							
							}
							
						},
						fail: function(e, t) {
							t.context.addClass('error');
						},
						done: function (e, t) {
							
							var n = parseInt(t.loaded / t.total * 100, 10);
							
							if (n == 100 && t.result.status == 'success') {	
								
								var _id = t.context.attr('data-id');
								
								t.context.removeClass('working').delay(1000).fadeOut('fast');
								
								if(!isN(_id)){ 

									SUMR_Upl.bco.ls.splice( SUMR_Upl.bco.ls.indexOf(_id),1);
									
								}
								
								_ldCnt({ 
									u:SUMR_Main.url['main'].lnk,
									c:SUMR_Main.url['main'].box
								});
								
							}else{
								
								t.context.addClass('error');
								if(t.result.w != 'undefined' && t.result.w != undefined){ swal('Error', t.result.w, 'error'); }
								if(t.result.exists != undefined && t.result.exists.e == 'ok'){
									t.context.find('p').find('._error_msj_w').html(t.result.exists.msj);
								}
								
							}
							
							_Rsze_UpBx();
								
						}		
						
					});

				}
			
			});
			
			/*$(document).on('drop dragover', function(e) {
				e.preventDefault();
			});*/
			
			$('#UplImgNw, #UplImgNw_Ldr').addClass('_ready');
			
		});
		
			
	"; 
		
?>