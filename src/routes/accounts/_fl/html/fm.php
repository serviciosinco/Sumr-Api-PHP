<form id="__fm_<?php echo $__id_rnd; ?>">
	<input id="____key" name="____key" type="hidden" value="<?php echo $__id_rnd ?>" />

	<h1><?php echo Strn(TX_ACCLGIN).' '.Spn(TX_ACCLGCRD); ?></h1>

	<div id="__fld_<?php echo $__id_rnd; ?>" class="__fm_wrp"></div>


	<?php


    	$_CntJQ .= "

			var __fld_bx = $('#__fld_".$__id_rnd."');
			var __cnct_bx = $('#_cnct_".$__id_rnd."');

			if(__fld_bx.html().length == 0){
				__fld_bx.append('
					<div class=\"_field _user\">
						<input name=\"user_form".$__id_rnd."\" type=\"email\" id=\"user_form".$__id_rnd."\" autocomplete=\"off\" placeholder=\"Usuario\" ".FMRQD_EM." />
					</div>
					<div class=\"_field _pass\">
						<input name=\"password_form".$__id_rnd."\" type=\"password\" class=\"required\" id=\"password_form".$__id_rnd."\" autocomplete=\"off\" placeholder=\"Clave\" />
					</div>
					<button id=\"__snd_".$__id_rnd."\">Conectar</button>
				');
			}


			$(document).on('focus', ':input', function(){
				$(this).attr('autocomplete', 'off');
			});

			$('input, :input').attr('autocomplete', 'off');

		";

		$_CntScrptLd .= "SUMR_App.f.AccDomBld();";


	?>

</form>