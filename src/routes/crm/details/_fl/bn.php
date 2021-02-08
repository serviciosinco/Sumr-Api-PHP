<?php	

	
	$__i = Php_Ls_Cln($_GET['__i']);
	$__dtbn = GtBnDt($__i, 'enc');
	$Dir = DMN_BN.'fl/'.$__dtbn->dir.'/src.swf?Rnd='.Gn_Rnd(20);
	
?>
<?php if(($__dtbn->id != NULL)){ ?>
	
 	<?php
		if($__dtbn->tp_id == 579){
			$__h_js = 310;
			$__w_js = 600;
		}elseif($__dtbn->tp_id == 582){
			$__h_js = ($__dtbn->h_vd);
			$__w_js = ($__dtbn->w_vd);
		}else{	
			$__h_js = $__dtbn->h;
			$__w_js = $__dtbn->w;
		} 	
	?>
	
	<script type="text/javascript">	
		SUMR_Main.ld.f.cbx(function(){
			$.fn.colorbox.resize({
					 innerHeight: "<?php echo $__h_js ?>px",
		       		 innerWidth: "<?php echo $__w_js ?>px",
					 title: "soe"
			});
		});
		
		<?php if(($__dtbn->tp_id == '575')){ ?> SUMR_Ld.f.js({ t:"j", u:"swfobject.js" }); <?php } ?>
	</script>
	
	
	<div class="__dt_bn">
	    <?php if(($__dtbn->tp_id == '575')){ ?>
		     <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $__dtbn->w ?>" height="<?php echo $__dtbn->h ?>">
		      <param name="movie" value="<?php echo $Dir ?>" />
		      <param name="quality" value="high" />
		      <param name="wmode" value="opaque" />
		      <param name="swfversion" value="9.0.45.0" />
		      <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
		      <param name="expressinstall" value="ex.swf" />
		      <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. --> <!--[if !IE]>-->
		      <object type="application/x-shockwave-flash" data="<?php echo $Dir ?>" width="<?php echo $__dtbn->w ?>" height="<?php echo $__dtbn->h ?>">
		        <!--<![endif]-->
		        <param name="quality" value="high" />
		        <param name="wmode" value="opaque" />
		        <param name="swfversion" value="9.0.45.0" />
		        <param name="expressinstall" value="ex.swf" />
		        <!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
		        <div>
		          <h4>El contenido de esta página requiere una versión más reciente de Adobe Flash Player.</h4>
		          <p><a href="https://www.adobe.com/go/getflashplayer"><img src="https://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
		        </div>
		        <!--[if !IE]>-->
		      </object>
		      <!--<![endif]-->
		    </object>
		    
		<?php 
			}elseif($__dtbn->tp_id == '578' || $__dtbn->tp_id == '581'){   
				echo '<iframe src="'.DMN_BN.$__dtbn->enc.'/" width="'.$__dtbn->w.'" height="'.$__dtbn->h.'" border="0" style="border:none;"></iframe>';
			}elseif($__dtbn->tp_id == '577' || $__dtbn->tp_id == '579'){   
				echo '<iframe src="'.DMN_BN.$__dtbn->enc.'/?_w='.$__w_js.'&_r='.Gn_Rnd(20).'" width="'.$__w_js.'" height="'.$__h_js.'" border="0" style="border:none; width:'.$__w_js.'px; height:'.$__h_js.'px; "></iframe>';
			} elseif($__dtbn->tp_id == '582'){ /*DMN_BN.'fl/'*/ 
				echo '<iframe src="'.DMN_BN.$__dtbn->enc.'/?_w='.$__w_js.'&_r='.Gn_Rnd(20).'" width="'.$__w_js.'" height="'.$__h_js.'" border="0" style="border:none; width:'.$__w_js.'px; height:'.$__h_js.'px; "></iframe>';
			} 
			

		?>		
	    <div class="__tt">
	        <?php echo Strn(TX_NM.': '.Spn($__dtbn->tt)).
					   Strn(TX_WDTH.': '.Spn(($__dtbn->tp_id == 582) ? $__dtbn->w_vd.'px' : $__dtbn->w.'px' )).
					   Strn(TX_HEGT.': '.Spn(($__dtbn->tp_id == 582) ? $__dtbn->h_vd.'px' : $__dtbn->h.'px')); ?>
	    </div>
	</div>
		
<?php } ?>
<?php  ob_end_flush(); ?>