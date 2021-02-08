<?php  
$__t = Php_Ls_Cln($_GET['tp']);


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

<div id="UplImgNw" class="UplImgNw">
		
		<form id="UplNwB" class="UplNwB" method="post" action="<?php echo PRC_UPLD_GN.'?'.TXGN_UPLNW ?>" enctype="multipart/form-data">
			<div id="drop" class="_drop">
				<?php echo TX_ARRTRAQ ?>

				<a><?php echo TX_EXPLR ?></a>
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
			</div>

			<ul></ul>

		</form>
</div>        
        <?php $CntWb .= "
								
				
			SUMR_Main.ld.f.upl( function(){						

				var e = $('#UplNwB ul');
				
				$('#drop a').off('click').click(function() {
					$(this).parent().find('input').click()
				});
				
				
				if(jQuery().fileupload){

					$('#UplNwB').fileupload({
						dropZone: $('#drop'),
						add: function(n, r) {
							var i = $('<li class=\"working\"><input type=\"text\" value=\"0\" data-width=\"48\" data-height=\"48\"' + ' data-fgColor=\"#0788a5\" data-readOnly=\"1\" data-bgColor=\"#3e4043\" /><p></p><span></span></li>');
							i.find('p').text(r.files[0].name).append('<i>' + SUMR_Ld.f.nSz(r.files[0].size) + '</i>');
							r.context = i.appendTo(e);
							i.find('input').knob();
							i.find('span').click(function() {
								if (i.hasClass('working')) {
									s.abort()
								}
								i.fadeOut(function() {
									i.remove()
								})
							});
							var s = r.submit()
						},
						progress: function(e, t) {
							var n = parseInt(t.loaded / t.total * 100, 10);
							t.context.find('input').val(n).change();
							if (n == 100) {
								t.context.removeClass('working')
							}
						},
						fail: function(e, t) {
							t.context.addClass('error')
						}
					});
				
				}

				
				/*$(document).on('drop dragover', function(e) {
					e.preventDefault()
				});*/
				
				SUMR_Main.log.f({ m:'Ready to show' });

			});
	
	"; ?>