<?php

    $__id_bx = 'FmBx'.$__id_rnd;
    $__id_fm = 'FmApp'.$__id_rnd;
    $__id_fm_btn = 'FmAppBtn'.$__id_rnd;

    if($appdt->e == 'ok'){
		
        if(!isN($__l)){ $_lng = $__l; }else{ $_lng='es'; }

?>
<!DOCTYPE HTML>
<html lang="<?php echo $_lng; ?>">
	<head>
		<title><?php echo 'APP | '.$__dt_cl->nm; ?></title>
		<base href="<?php echo DMN_APP.$__pm_1; ?>/" target="_self">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="icon" href="img/touch-icon-iphone.png" type="image/x-icon" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo $__dt_cl->img->th_400 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $__dt_cl->img->th_100 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $__dt_cl->img->th_200 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $__dt_cl->img->th_200 ?>"/>
		<link rel="shortcut icon" href="<?php echo $__dt_cl->lgo->ico->big; ?>" type="image/x-icon"/>	
		<link rel="manifest" href="/manifest.json">
		<style>
			
			
			*{ box-sizing: border-box; outline: none; background-repeat: no-repeat; background-position: center center; font-weight: 300; }
            body{ padding: 0; margin: 0; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;  }
            
            body:not(.on) header, 
            body:not(.on) footer, 
            body:not(.on) .app-main{ display: none; }
            
            body ._prld{ z-index: 99999999; position: absolute; width: 100%; height: 100%; left: 0; top: 0; background-size: 50px auto; }           
            body ._prld{ background-image: url('<?php echo DMN_APP; ?>img/estr/loader_white.svg'); }
            
            
            body.on ._prld, body.on ._ovly{ display: none; }
            body.on .app-main,
            body.on header,
            body.on footer{ display: block; }

            .lgt {position: relative;cursor:pointer;opacity:0.7;}
            .lgt:hover {opacity:1;}
            .lgt::before {content: "";background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>app_out.svg);position: absolute;right: 70px;top: 2px;width: 15px;opacity: .5;cursor: pointer;height: 15px;background-size: 100% auto;background-position: center center;z-index: 999999;}

			<?php 
		        
				$__cl_tag = $__dt_cl->tag;
				$__cl_clr = $__cl_tag->clr;		
				
				if(!isN($__cl_clr->main->v)){ $__root_v .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__root_v .= ' --main-bg-color:#4f006f;'; }
				if(!isN($__cl_clr->second->v)){ $__root_v .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__root_v .= ' --second-bg-color:#de86d4; '; }
				
				echo '
					:root {
						'.$__root_v.'
					}
				';
	
	        ?>
		</style>		
	</head>
	<body>	
        <div class="_bcki"></div>
        <div class="wrp-content">
            <header>
                <div class="">
                    <div class="lg _anm">
                        <div class="lg_cl"></div>
                    </div>
                </div>		
            </header>
            
            <section class="app-main">
                
                <div class="">

                    <div class="app-cnt _anm" id="app-cnt">
                        <div class="_ldr _anm"><div class="_spn"></div></div>
                        <div class="_clse _anm"></div>
                        <div class="_bxhtt _anm">
                            <div class="_bxhtt_cnt"></div>
                        </div>	
                    </div>
                    <h2>Devoluciones / Novedades</h2> 
                    <div class="dsh-main" id="dsh-main">
                        <!-- Form - SUMR CRM --><iframe id='SUMR-FM-9f692d14ca379c897f1005f84734e1a17f091e20' data-dark="ok" data-icon="ok" data-col="42b5638b1d3b7e1f8eccc04b2b435cc3e7d350b3" data-width="100%" width="100%"  frameborder='0'></iframe> <script  async>(function(w,d,s,l){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src= 'https://js.sumr.co/mdl/prochampions/9f692d14ca379c897f1005f84734e1a17f091e20.js'; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer');</script>
                    </div>
                </div>	
            </section>
        </div>
		
		<footer>
			<div class="lg_sumr"></div>
		</footer>		
		<div class="_ovly _anm"></div>
		<div class="_prld _anm"></div>		
	</body>
</html> 

<script type="text/javascript">

    var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){
        
        SUMR_AppCm={};
        
		SUMR_Ld.f.css({ 	 

            t:'p',
            tag:'ok',
            h:'/css/?_c=<?php echo $__dt_cl->enc; ?>&_app=<?php echo $appdt->enc; ?>',
            
	        c:function(){ 
                
                SUMR_Ld.f.css({ 

                    t:'p',
                    h:'<?php echo DMN_FLE_APP; ?>html/<?php echo $appdt->dir; ?>/main.css',
                    tag:'ok',
                    c:function(){

                        SUMR_Ld.f.js({

                            t:'c',
					        u:'jquery.js',
                            c:function(){

                                SUMR_Ld.f.js({

                                    tag:'ok',
                                    u:'<?php echo DMN_FLE_APP; ?>html/<?php echo $appdt->dir; ?>/main.js',
                                    c:function(){

                                        SUMR_Ld.f.js({
                                            tag:'ok',
                                            u:'<?php echo DMN_JS ?>js.js',
                                            c:function(){
                                        
                                                SUMR_Ld.f.js({ 
                                                    t:'c',
                                                    u:'jquery-ui.js',
                                                    c:function(){ 
                                                        
                                                        SUMR_Ld.f.js({ tag:'ok', u:'/js/?_c=<?php echo $__dt_cl->enc; ?>&_a=<?php echo $appdt->enc; ?>' });
                                                        
                                                        SUMR_Ld.f.js({ 
                                                            t:'c',
                                                            u: 'highcharts/highcharts.js',
                                                            c:function(){
                                                                SUMR_Ld.f.js({ 
                                                                    u:'<?php echo DMN_JS ?>jquery.colorbox-min.js',
                                                                    c:function(){
                                                                        SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>colorbox.css' });

                                                                        SUMR_Ld.f.js({ 
                                                                            u:'<?php echo DMN_JS ?>select2.js',
                                                                            c:function(){
                                                                                SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>select2.css' });

                                                                                SUMR_Ld.f.css({ 
                                                                                    t:'p',
                                                                                    h:'<?php echo DMN_CSS ?>ui/jquery-ui.css',
                                                                                    c:function(){
                                                                                        
                                                                                        SUMR_Ld.f.js({ 
                                                                                            u:'<?php echo DMN_JS ?>sweetalert.js',
                                                                                            c:function(){
                                                                                                SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>sweetalert.css' });
                                                                                                
                                                                                                try{
                                                                                                                    
                                                                                                      

                                                                                                            SUMR_Ld.f.js({
                                                                                                                u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js', 
                                                                                                                c:function(){ }   
                                                                                                            });
                                    
                                                                                                            /*SUMR_AppCm.Dom_Rbld();*/
                                                                                                        

                                                                                                    

                                                                                                }catch(e){
                                                                                                    
                                                                                                    console.info(e.message);
                                                                                                    console.info(e);

                                                                                                }
                                                                                                                
                                                                                                $(document).ready(function(){

                                                                                                    $('body').addClass('on'); 

                                                                                                    <?php echo $CntWb; ?>
                                                                                                    
                                                                                                });
                                                                                            }
                                                                                        });
                                                                                    }
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                });       
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });	
                                    }
                                });	
                            }
                        });
                    }
                });
			}  
		}); 	             	
	}
    
    SUMR_RquClg = {
        rnd:'',
        snd:{},
        _utt: 'Envio Exitoso',
        _utx: 'Tus datos fueron enviados.'
    };
		
</script>
<script type="text/javascript" id="main-script" src="<?php echo DMN_JS ?>_ld.js?__r=<?php if(!Dvlpr()){ echo E_TAG; }else{ echo Enc_Rnd('r'); } ?>" async></script>
<?php } ?>