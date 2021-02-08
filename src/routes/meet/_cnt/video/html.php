<?php 
    Hdr_HTML(); 
    $_tt_html = $__dt_cl->nm.' | Videollamada ';
    if(!isN($__cnt->enc)){ $_tt_html .= ' con '.$__cnt->nm; }
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $_tt_html; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
		<base href="/" target="_blank">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property='fb:app_id' content='<?php echo APP_FB_ID ?>'/>
        <meta property="og:site_name" content="<?php echo $_tt_html; ?>">
        <meta property="og:title" content="<?php echo $_tt_html; ?>" />
        <meta property="og:description" content="Ingresa ahora para iniciar tu gestión comercial" />
        <meta property="og:image" itemprop="image" content="<?php echo DMN_IMG_ESTR.'meet/scl_prvw.jpg'; ?>">
        <meta property="og:image:width" content="1280">
        <meta property="og:image:height" content="700">
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
		<style>
			<?php include(DIR_INC.'css/hd.css'); ?>			
			<?php 
		        
				$__cl_tag = $__dt_cl->tag;
				$__cl_clr = $__cl_tag->clr;
				
				if(!isN($__cl_clr->main->v)){ $__root_v .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__root_v .= ' --main-bg-color:#4f006f;'; }
				if(!isN($__cl_clr->second->v)){ $__root_v .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__root_v .= ' --second-bg-color:#de86d4; '; }
				
				echo '
					:root{
						'.$__root_v.'
					}
				';
	
	        ?>     
		</style>
	</head>
	<body class="main-box">
        <div class="_prld _anm"></div>
        <?php if(Dvlpr()){ ?><div class="error" id="show_error"></div><?php } ?>
        <div class="dash_call _anm" id="bx_dash_call" me-audio-enable="ok" me-video-enable="ok">
            <button class="join_now _anm" id="join_now">Unirme ahora</button>
            <div class="wrp _anm">
                
                <div class="form_call _anm">
                    <div class="logo"></div>
                    <div class="flds"><?php /*?>
                        <!--<input type="text" id="my_name" placeholder="Nombre" value="<?php echo $_GET['name']; ?>"/>-->
                        <?php if(isset($_GET['room'])){ ?>
                        <input type="hidden" id="my_room" value="<?php echo $_GET['room']; ?>"/>
                        <?php } ?>
                        <button id="preview_btn">➤</button>
                        <?php */ ?>
                        <div class="sayhi">Hola <?php echo $__cnt->nm; ?>, <br><span>estamos iniciando...</span></div>

                        <?php if(!isN($__cnt->enc)){ ?>
                            <input type="hidden" id="cnt_id" value="<?php echo $__cnt->enc; ?>"/>
                        <?php }elseif(!isN($__us->enc)){ ?>
                            <input type="hidden" id="us_id" value="<?php echo $__us->enc; ?>"/>    
                        <?php } ?>

                        <input type="hidden" id="room_id" value="<?php echo $__vcall->unm; ?>"/>
                        
                    </div>
                </div>

                <div class="my_track _anm" id="bx_my_track">
                    <div class="video _anm" id="bx_my_track_video"></div>
                    <div class="audio _anm" id="bx_my_track_audio"></div>
                    <div class="options _anm">
                        <button class="swap _anm" id="btn_swap_camera">Swap Camera</button>
                    </div>
                    <div class="drag-cursor _anm"></div>
                    <div class="waiting"></div>
                </div>

                <div class="p_track _anm" id="bx_p_track">
                    <div class="tracks"></div>
                    <div class="waiting"></div>
                    <div class="brand"></div>
                </div>

                <div class="c_options _anm" id="bx_options">
                    <div class="left"></div>
                    <div class="center">
                        <button class="mic _anm" id="btn_mic">Mic</button>
                        <button class="hangout _anm" id="btn_hangout">Hangout</button>
                        <button class="camera _anm" id="btn_camera">Camera</button>
                    </div>
                    <div class="right">
                        <button class="settings _anm" id="btn_prvw_stup">Setup</button>    
                    </div>
                </div>


            </div>
        </div>    
        <div class="dash_setup _anm" id="bx_dash_setup">
            <div class="close _anm" id="bx_dash_setup_cls"></div>
            <div id="TP_Setup" class="TabbedPanels">
                <ul class="TabbedPanelsTabGroup _anm">
                    <li class="TabbedPanelsTab video _anm">Video</li>
                    <li class="TabbedPanelsTab audio _anm">Audio</li>
                </ul>
                <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent">
                        <ul class="camera c-chck">
                            <li><h2></h2></li>
                        </ul>
                    </div>
                    <div class="TabbedPanelsContent">   
                        <ul class="audio_in c-chck">
                            <li><h2>Micrófono</h2></li>
                        </ul>
                        <ul class="audio_out c-chck">
                            <li><h2>Altavoces</h2></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="body_overlay"></div>
    </body>
</html>
<script type="text/javascript">
	
	"use strict";
	
    <?php
        $____fmly[] = ['name'=>'Baloo+2:400,500,700'];
        $____fmly[] = ['name'=>'Raleway'];
        $___font = __font([ 'fly'=>$____fmly ]); 
    ?>
	
	<?php if(!isN($___font->js->string)){ ?> 
		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout:2000  };		
	<?php } ?>
	
	var __ldsnd={};
	
    var SUMR_Main={slc:{ sch:''}};
    
	function __ld_all(){
        
        SUMR_Ld.cl.id = '<?php echo $__dt_cl->enc; ?>';
        
		SUMR_Ld.f.js({ 
            t:'c',
			u:'jquery.js',
			c:function(){
                
                SUMR_Ld.f.js({
                    u:'https://media.twiliocdn.com/sdk/js/video/releases/2.3.0/twilio-video.min.js',
                    c:function(){

                        SUMR_Ld.f.js({ 
                            
                            t:'c',
                            u:'sb/meet/main.js',
                            c:function(){ 

                                SUMR_Ld.f.css({ 
                                    
                                    h:'sb/meet/all',
                                    tag:'ok',
                                    c:function(){

                                        $('body').addClass('SUMR_VCall');

                                        SUMR_VCall.dom();

                                        SUMR_Ld.f.js({
                                            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
                                            c:function(){
                                            }	    
                                        });

                                        setTimeout(function(){
                                            $('body').addClass('on');
                                        }, 300);
                                                
                                        $(document).ready(function(){
                                            <?php echo $_CntJQ_Vld; ?>
                                            <?php echo $_CntJQ; ?>                                       
                                        });
                                    
                                        $(window).on('load',function(){

                                            SUMR_VCall.stup.pth.ownd = '<?php echo $__owndmn; ?>';   
                                            SUMR_VCall.stup.pth.url = '<?php echo $__path; ?>'; 

                                            SUMR_VCall.init({
                                                c:function(){

                                                    <?php if(!isN($__room)){ ?>
                                                        SUMR_VCall.prvw();
                                                    <?php } ?>
                                                    
                                                }
                                            });

                                            window.onbeforeunload=function(){ window.focus(); }

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
	
</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>