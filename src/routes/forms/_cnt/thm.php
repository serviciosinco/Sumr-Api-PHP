<?php
    $Rt = '../../../includes/'; $__pbc='ok'; $__https_off = 'off'; $__bdfrnt = 'ok';
    include($Rt.'inc.php');
    ob_start('compress_code');
    header('Access-Control-Allow-Origin: *');
?>
<?php Hdr_HTML([ 'cche'=>'ok', 'fa'=>$__fm->fa ]); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $__head_tt; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="/" target="_blank">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="<?php echo DMN_IMG_ESTR; ?>favicon.ico" type="image/x-icon">
		<link rel="preconnect" href="<?php echo DMN_JS; ?>" />
		<style>
            <?php include(DIR_INC.'css/hd.css'); ?>
            h1.tt,.cnt{ display:none; }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans&family=Roboto&display=swap" rel="stylesheet">
	</head>
	<body>
        <h1 class="tt">SUMR Form</h1>
        <div class="_prld _anm"></div>
        <div class="cnt">
            <nav class="nav">
                <?php $__themes = __LsDt(['k'=>'fm_thm' ]); ?>

                <h2>Themes</h2>
                <ul class="cthm">
                    <?php foreach($__themes->ls->fm_thm as $_th_k=>$_th_v){ ?>
                        <li thm-key="<?php echo $_th_v->key->vl; ?>"><?php echo $_th_v->tt; ?></li>
                    <?php } ?>
                </ul>

                <h2>Options</h2>
                <ul class="opt">
                    <li>
                        <div class="pretty p-switch p-fill">
                            <input type="checkbox" id="opts-icns" checked />
                            <div class="state">
                                <label>Mostrar Iconos</label>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="pretty p-switch p-fill">
                            <input type="checkbox" id="opts-drk" />
                            <div class="state">
                                <label>Versión Dark</label>
                            </div>
                        </div>
                    </li>

                </ul>

            </nav>
            <section class="form">
                <!-- Form - SUMR CRM -->
                <iframe id='SUMR-FM-2dc63a93acc51fe04c08ad12c178360ea1a482c4' width="100%" frameborder></iframe>
            </section>
        </div>
		<footer></footer>
	</body>
</html>
<script type="text/javascript">

	"use strict";

    var SUMR_Main={slc:{ sch:''}};
    var SUMR_FormThemes={};

	function __ld_all(){

		SUMR_Ld.f.js({
			t:'c',
			u:'jquery.js',
			c:function(){

                SUMR_Ld.f.css({ tag:'ok', h:'sb/form/thm' });
		        $('body').addClass('SUMR_Form on');

                SUMR_FormThemes = {

                    o:{
                        thm:'bsc'
                    },
                    dom:()=>{

                        $('div.cnt .nav ul.cthm li').off('click').click(function(e){
                            e.preventDefault();
                            if(e.target != this){
                                e.stopPropagation(); return false;
                            }else{
                                var _t=$(this);
                                $('div.cnt .nav ul.cthm li').removeClass('selected');
                                _t.addClass('selected');
                                SUMR_FormThemes.o.thm = _t.attr('thm-key');
                                SUMR_FormThemes.ifr.bld();
                            }
                        });

                        $('#opts-drk').off('change').change(function() {
                            if(this.checked) {
                                $('body').addClass('_dark');
                            }else{
                                $('body').removeClass('_dark');
                            }
                            SUMR_FormThemes.ifr.bld();
                        });

                        $('#opts-icns').off('change').change(function() {
                            SUMR_FormThemes.ifr.bld();
                        });

                    },
                    ifr:{
                        bld:function(p=null){

                            $('li[thm-key=\''+SUMR_FormThemes.o.thm+'\']').addClass('_ld');

                            $('script').each(function(){
                                if(this.id === 'SUMR-Form-JS'){
                                    this.parentNode.removeChild( this );
                                }
                            });

                            var d=document,
                                s='script',
                                l='dataLayer',
                                f=d.getElementsByTagName(s)[0],
                                j=d.createElement(s),
                                dl=l!='dataLayer'?'&l='+l:'',
                                m='';

                            if($('#opts-icns').is(":checked")){ m += '&icon=ok'; }
                            if($('#opts-drk').is(":checked")){ m += '&opaque=ok'; }
                            if(!SUMR_Ld.f.isN(SUMR_FormThemes.o.thm)){ m += '&theme='+SUMR_FormThemes.o.thm; }

                            j.async=true;
                            j.id = 'SUMR-Form-JS';
                            j.src= 'https://form.sumrdev.com/b.js?f=2dc63a93acc51fe04c08ad12c178360ea1a482c4&id=dbab775fe0&g=ok&w=100%25'+m;
                            j.onload = ()=>{
                                $('li[thm-key=\''+SUMR_FormThemes.o.thm+'\']').removeClass('_ld');
                                if(!SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.c)){ p.c(); }
                            };

                            f.parentNode.insertBefore(j,f);

                            SUMR_FormThemes.dom();

                        }
                    }
                };

                SUMR_FormThemes.ifr.bld();

			}

        });

	}

</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<?php ob_end_flush(); ?>