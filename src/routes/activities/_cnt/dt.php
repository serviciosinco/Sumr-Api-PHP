<div class="_wrp">
    <div class="_evn">
        <div class="__dtl">    
	        <section id="__cnt_qr">
	  				<?php
		  				$__url_qr = MyPssU([
			  							't'=>'evn',
			  							'enc'=>$__dt_evncnt->enc
		  							]);
		  				$width = $height = 400;
						$url   = urlencode($__url_qr);
						echo "<img src=\"https://chart.googleapis.com/chart?chs={$width}x{$height}&cht=qr&chl=$url\" />";
	  				?>	
	  		</section>	
        </div>          
        <div class="__opc">
           	<h1>Confirmación Evento</h1>
           	<h2><?php echo $__dt_evncnt->apr->evn->nm ?></h2>
           	<h3><?php echo $__dt_evncnt->cnt->nm.' '.$__dt_evncnt->cnt->ap ?></h3>
		   	<h4><?php echo $__dt_evncnt->cnt->dc_tp.' '.$__dt_evncnt->cnt->dc ?></h4>
		   	
		   	<div class="opt_btns">
		   		<a href="<?php echo DMN_MYPSS.PrmLnk('bld', 'evn').PrmLnk('bld', $__i); ?>" class="__pssbk" target="_self">Passbook</a>
		   		<a href="javascript:window.print()" class="__prnt">Imprimir</a>
		   	</div>
		   	
        </div>
    </div>
</div>