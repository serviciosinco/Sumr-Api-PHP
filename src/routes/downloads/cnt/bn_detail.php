<!doctype html>
<html lang='es' class='no-js'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $__dtbn->tt.SP.DB_CL_NM ?></title>
<base href="<?php echo DMN_DWN ?>" target="_self">
<meta name='description' content='<?php echo strip_tags($__dtbn->dsc); ?>' />
<link href="inc/sty/all.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo DMN_JS ?>html5.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS ?>modernizr.js"></script>
<![endif]-->
</head>

<body>
<header><img src="<?php echo $__dtec->cl->lgo->main->big ?>"></header>

<div class="_wrp">
    <div class="_dwn">
      <div class="__dtl">
          <ul>
              <li><?php echo Strn('Orden: ') . $__dtbn->ord; ?></li>
              <li><?php echo Strn('Estado: ') . Spn($__dtbn->est->tt,'',$__dtbn->est->sty); ?></li>
              <li><?php echo Strn('Tipo: ') . $__dtbn->tp; ?></li>
              <li><?php echo Strn('Proceso:') . $__dtbn->prc ?></li>
              <li><?php echo Strn('Tamaño:') . $__dtbn->w .' x '.$__dtbn->h; ?></li>
              <?php if($__dtbn->tp_id == 8){ ?>
              	<li><?php echo Strn('Tamaño Previsualización:') . $__dtbn->w_vd .' x '.$__dtbn->h_vd; ?></li>
              <?php } ?>
              <li><?php echo Strn('Fecha / Ingreso:') . $__dtbn->fi ?></li>
              <li><?php echo Strn('Fecha / Actualización:') . $__dtbn->fa ?> </li>
          </ul>
       </div>
          
	   <div class="__opc">
          <div class="__tt"><?php echo Strn($__dtbn->tt) ?></div> 
          <div class="__dsc"><?php echo $__dtbn->dsc ?></div>
          <div class="__btn">  
	          	
	          	<?php if($__dtbn->tp_id != 8){ ?>
	            	<div class="_bt_3 _bt"><a href="<?php echo DMN_DWN.PrmLnk('bld', LNK_BN).'?_f='.$__dtbn->enc.'&_t=html5' ?>" class="_sr_no" target="_self"><div class="_icn"></div></a>
	                		<a class="_sr" href="<?php echo DMN_BN.'_js/edge2.js?__b='.$__dtbn->enc.'&__d=ok' ?>">Edge</a>
	                        <a class="_sr" href="<?php echo DMN_BN.PrmLnk('bld', $__dtbn->enc).$__dtbn->edge_id.'_edge.js?__d=ok' ?>">Edge Setup</a>
	                        <a class="_sr" href="<?php echo DMN_BN.PrmLnk('bld', $__dtbn->enc).$__dtbn->edge_id.'_edgeActions.js?__d=ok' ?>">Acciones</a>
	                		<div class="__sbt">Otros Medios<br>Rutas Absolutas</div>
	                </div>
                <?php } ?>
                
            	<div class="_bt_2 _bt"><a href="<?php echo DMN_DWN.PrmLnk('bld', LNK_BN).'?_f='.$__dtbn->enc.'&_t=zip' ?>" target="_self"><div class="_icn"></div></a><div class="__sbt">Flash, Fuentes<br>Curvas, Swf</div></div>
            	<div class="_bt_4 _bt"><a href="<?php echo DMN_BN.PrmLnk('bld', $__dtbn->enc).'?_r='.Gn_Rnd(20); ?>" target="_self"><div class="_icn"></div></a><div class="__sbt">Versión en Línea<br>Ver Banner</div></div>
          </div>    
        </div>
    </div>
</div>

<footer><?php /*?><iframe width="250" height="30" src="http://iframe.servicios.in/pwr.php?tp=1&amp;a=_d&amp;_cl=b" frameborder="0" allowTransparency="true"></iframe><?php */?></footer>

<noscript>
<div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div>
</noscript>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery.colorbox.js"></script>
    
	<script type="text/javascript"> 
        
		$('#___vw').click(function(){
			
			<?php if(isFrme()){ ?>
				if (window!=window.top){ 
					var __lnk = '<?php echo DMN_BN.PrmLnk('bld', $__dtbn->enc) ?>';
				}else{
					var __lnk = '<?php echo DMN_CRM.'_cnt/_dt/_bn.php?_e='.$__dtbn->enc ?>';
				}
			<?php }else{ ?>
				var __lnk = '<?php echo DMN_BN.PrmLnk('bld', $__dtbn->enc) ?>';
			<?php } ?>
			
			window.location.href = __lnk;
		});
		
    </script>
    <?php echo _anl(2); ?>
</body></html>
