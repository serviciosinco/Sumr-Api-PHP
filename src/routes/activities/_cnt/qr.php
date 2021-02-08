<header><img src="<?php echo $__cl->lgo->lght->big; ?>"></header>
<div class="_wrp">
    <div class="_act">
        <div class="__dtl">    
	        <section id="__cnt_qr" style="text-align: center;">
  				<?php
	  				
	  				$__url_qr = MyPssU([
		  							't'=>'act',
		  							'enc'=>PrmLnk('bld',$__dt_act->enc)
	  							]);
	  							
	  				$width = $height = 400;
					$url   = urlencode($__url_qr);

					$_shrt = new CRM_Shrt();
					$url_b= $_shrt->get([ 'url'=> $__url_qr ])->url;


					echo "<img src=\"https://chart.googleapis.com/chart?chs={$width}x{$height}&cht=qr&chl=$url\" />";
					echo $url_b;
					
  				?>
	  		</section>	
        </div>          
        <div class="__opc">
           	<h1>QR Actividad - <?php echo $__dt_act->tt; ?></h1>
           	
           <?php if(!isN($__dt_act->org->d->nm_fll)){ ?>
           <h3><?php echo $__dt_act->org->d->nm_fll ?></h3>
           <?php } ?>
           	
		   <h4><?php echo $__dt_act->tp->tt ?></h4>
		   <h5><?php echo $__dt_act->fi.' - '.$__dt_act->fn ?></h5>
		   	
		   <div class="opt_btns">
		   		<a href="javascript:window.print()" class="__prnt">Imprimir</a>
		   </div>
		   	
        </div>
    </div>
</div>
<footer> <!--<iframe width="250" height="30" src="https://iframe.servicios.in/pwr.php?tp=1&amp;a=_d&amp;_cl=b" frameborder="0" allowTransparency="true"></iframe> --> </footer>