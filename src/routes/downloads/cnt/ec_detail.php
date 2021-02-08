<!doctype html>
<html lang='es' class='no-js'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $__dtec->tt.SP.DB_CL_NM ?></title>
<base href="<?php echo DMN_DWN ?>" target="_self">
<meta name='description' content='<?php echo strip_tags($__dtec->dsc); ?>' />
<link href="inc/sty/all.css?__c=<?php echo $__dtec->cl->enc; ?>" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo DMN_JS ?>html5.js"></script>
        <script type="text/javascript" src="<?php echo DMN_JS ?>modernizr.js"></script>
<![endif]-->
</head>
<body>
<header><img src="<?php echo $__dtec->cl->lgo->lght->big; ?>"></header>

<div class="_wrp">
    <div class="_dwn">
      <div class="__dtl">
      	  <div class="_img">
	      	  <div class="_bck" style="background-image:url('<?php echo !isN($__dtec->img_v->th_c_200)?$__dtec->img_v->th_c_200:$__dtec->img_v->ste->bg ?>'); "></div>
      	  </div>
          	<ul>
            	<?php if(!isN($__dtec->ord)){ echo li(Strn('Orden: ').$__dtec->ord); } ?>

				<?php if(!isN($__dtec->est)){ echo li(Strn('Estado: ').Spn($__dtec->est->tt,'',$__dtec->est->sty)); } ?>

				<?php if(!isN($__dtec->shr)){ echo li(Strn('URL Corta:').$__dtec->shr); } ?>
				<?php if(!isN($__dtec->eml)){ echo li(Strn('Correo:').$__dtec->eml); } ?>
				<?php if(!isN($__dtec->fi)){ echo li(Strn('Fecha / Ingreso:').$__dtec->fi); } ?>
				<?php if(!isN($__dtec->hi)){ echo li(Strn('Hora / Ingreso:').$__dtec->hi); } ?>
			</ul>
       </div>
          
      <div class="__opc">
          <div class="__tt"><?php echo Strn($__dtec->tt) ?></div> 
          <div class="__dsc"><?php echo $__dtec->dsc ?></div>
          <div class="__btn">
            	<div class="_bt_1 _bt">
	            	<a href="javascript:void(0);" url-link="<?php echo DMN_EC.LNK_HTML.'/'.$__dtec->enc.'?'  ?>" target="_self" id="btn_go_outl" class="link-go-to">
		            	<div class="_icn"></div>
		            </a>
	            	<div class="__sbt">Superior a Outlook 2007</div>
	            </div>
	            <?php
		        	$__tp = Php_Ls_Cln($_GET['__tp']);
		        	if( $__tp != 'mycmz' ){ ?>
		        		<div class="_bt_2 _bt">
							<a href="javascript:void(0);" url-link="<?php echo DMN_DWN.PrmLnk('bld', LNK_EC).'?_f='.$__dtec->enc.'&_t=zip' ?>&_r=<?php echo Gn_Rnd(20); ?>" target="_self" id="btn_go_zip" class="link-go-to">
								<div class="_icn"></div>
							</a>
							<div class="__sbt">Outlook 2003 <br>Outlook 2007</div>
						</div> 
		        	<?php }
		        ?>			
            	<div class="_bt_3 _bt">
	            	<a href="javascript:void(0);" url-link="<?php echo DMN_DWN.PrmLnk('bld', LNK_EC).'?_f='.$__dtec->enc.'&_t=html' ?>" target="_self" id="btn_go_html" class="link-go-to">
		            	<div class="_icn"></div>
		            </a>
		            <div class="__sbt">Envios Masivos<br>Plataformas de Envio</div>
		        </div>
            	<div class="_bt_4 _bt">
	            	<a href="javascript:void(0);" url-link="<?php echo DMN_EC.LNK_HTML.'/'.$__dtec->enc.'/'.'?' ?>" target="_self" id="btn_go_onl" class="link-go-to">
		            	<div class="_icn"></div>
		            </a>
		            <div class="__sbt">Versión en Línea<br>Redes Sociales</div>
		        </div>
          </div>    
        <div class="Nt"><?php echo Strn('Nota:'); ?> Las versiones superiores a Outlook 2007 permiten el envío de correos HTML, pero de manera distinta a la tradicional, compruebe la versión de su Microsoft Outlook antes de hacer uso de este archivo.</div>
        </div>
    </div>
</div>

<footer><?php /*?><iframe width="250" height="30" src="http://iframe.servicios.in/pwr.php?tp=1&amp;a=_d&amp;_cl=b" frameborder="0" allowTransparency="true"></iframe><?php */?></footer>

<noscript>
	<div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div>
</noscript>

<?php echo _anl(2); ?>
</body></html>
<script type="text/javascript">
	
	"use strict";

	var SUMR_Main={slc:{ sch:''}};
	
	function __ld_all(){	
		SUMR_Ld.f.js({	
			u:'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
			c:function(){  
		        SUMR_Ld.f.js({ 
					u:'<?php echo DMN_JS_SB_DWN; ?>base.js',
					c:function(){
						SUMR_Dwn.dom();
					}
				});   
			}	
		});	
	}
	
</script>
<script type="text/javascript" src="https://js.sumr.co/_ld.js" id="main-scrpt" data-id="<?php echo $__id_rnd; ?>" async></script>
