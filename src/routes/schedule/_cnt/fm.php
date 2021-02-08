<div class="wrp" style="opacity:0;">
	<div class="_box _main">
		<section class="logo-mbl"><div class="logo" style="background-image: url(<?php echo $__cl->lgo->lght->big; ?>);"></div></section>
		<div class="_c1">
			<header>
				<figure></figure>
				<h1>Reunion con Camilo Garzón</h1>
			</header>
			<div id="calendario"></div>
			<div class="data_full _anm no"> <div class="check"></div> </div>
		</div>
		<div class="_c2">
			<div class="logo" style="background-image: url(<?php echo $__cl->lgo->lght->big; ?>);"></div>	
			<div class="data">
				<h2>¿Cuánto tiempo necesita?</h2>
				<div class="intrvl">
					<ul>
						<li class="on" data-intv="15">15 min</li>
						<li data-intv="30">30 min</li>
						<li data-intv="60">60 min</li>
					</ul>
				</div>
				<h2>¿Cuál es la mejor hora?</h2>
				<div class="slctime">
					<ul id="tme_opt"></ul>
				</div>
				
				
			</div>
			<div class="data_full _anm no">
				<h1>Confirmar reunión</h1>	
				<h2 class="tme_slc"></h2>
				<form id="form">
					<input id="nm" type="text" name="nm" placeholder="Nombre">
					<input id="ap" type="text" name="ap" placeholder="Apellido">
					<input id="eml" type="text" name="eml" placeholder="Correo electrónico">
				</form>
				<div class="back">Volver</div>
				<div class="val no">Confirmar</div>
			</div>
		</div>	 
	</div>   
</div>



<?php 
	
	$_CntJQ_S2 .= "
		
		var __col1 = $('.SUMR_Agnd .wrp ._box ._c1');
		var __col2 = $('.SUMR_Agnd .wrp ._box ._c2');
		
		$('.back').off('click').click(function(e){		
			$('._c2 .data_full._anm').addClass('no');
			$('._c1 .data_full._anm').addClass('no');
		});
		
		$('.val').off('click').click(function(e){	
			if($(this).hasClass('ok')){
				__snd_data.input = $('#form').serializeArray();
				__snd({ 
					t:'agnd', 
					d:__snd_data,
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r)){
								console.log(_r);	
							}
						}
					} 
				});	
				
				
			}
		});	
		
		$('#calendario').flatpickr({
			inline: true,
			altInput: true,
			altFormat: 'F j Y',
			dateFormat: 'Y-m-d',
			ariaDateFormat: 'l, F j Y',
			minDate:'".date("Y-m-d", strtotime("+1 day"))."',
			maxDate:'".date("Y-m-t")."',
			onChange: function(s,d,i) {
				
				__arlbl = $('.flatpickr-calendar .dayContainer .selected').attr('aria-label'); 
				__snd_data.date = d;
				
				$('.tme_slc').html(__arlbl+' '+__snd_data.hour);
				
				if(!isN(__snd_data.hour) && !isN(__snd_data.date)){
					$('._c2 .data_full._anm').removeClass('no');
					$('._c1 .data_full._anm').removeClass('no');
				}
 
				if( !__col2.is(':visible') ) {
					$('body').addClass('mbl-step2');
				}
				
		    },
		});
	
		$('#form input').keyup(function() {
	        var form = $(this).parents('#form');
	        var check = checkCampos(form);
	        if(check) { $('.val').removeClass('no').addClass('ok'); } else { $('.val').addClass('no').removeClass('ok'); }
	    });
	    
	    function checkCampos(obj) {
			var camposRellenados = true;
			obj.find('input').each(function() { var f = $(this); if( f.val().length <= 0 ) { camposRellenados = false; return false; } });
			if(camposRellenados == false) { return false; } else { return true; }
		}
		
	";																
	
	
	$_CntJQ_S2 .= "
		__tm_intrv_b({ 
			ivl:'15',
			strt:'07:00',
			end:'17:00'
		});";
	
																	
?>