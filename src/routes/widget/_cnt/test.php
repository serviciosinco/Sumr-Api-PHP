<?php

if($_wdgt_dt->test->inline == 'no'){

    $c = curl_init($_wdgt_dt->test->url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($c);
    $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    if($http_status == 200 || $http_status == 202){

        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $base = $doc->getElementsByTagName('base');

        if(count($base) > 0){
            foreach ($base as $base_t){
                $base_t->removeChild($href);
            }
        }

        $head = $doc->getElementsByTagName('head')->item(0);
        $body = $doc->getElementsByTagName('body')->item(0);

        $base = $doc->createElement('base');
        $base->setAttribute('href',$_wdgt_dt->test->url);

        $wdgtc = $doc->createElement('script', __WdgtCod([ 'id'=>$_wdgt_dt->enc, 'notag'=>'ok' ]));
        $wdgts = $doc->createElement('style', '.sumr_test_label{ position:relative; top:0; left:0; width:100%; background-color:black; color:white; font-weight:bolder; text-align:center; padding:5px 0; z-index:99999999999; }');

        $wdgtc_lbl = $doc->createElement('div','Widget Test From SUMR');
        $wdgtc_lbl->setAttribute('class','sumr_test_label');

        if($head->hasChildNodes()){
            $head->insertBefore($base,$head->firstChild);
            $head->insertBefore($wdgtc,$head->firstChild);
            $head->insertBefore($wdgts,$head->firstChild);
        }else{
            $head->appendChild($base);
            $head->appendChild($wdgtc);
            $head->appendChild($wdgts);
        }


        if($body->hasChildNodes()){
            $body->insertBefore($wdgtc_lbl,$body->firstChild);
        }else{
            $body->appendChild($base);
        }


        $nhtml = $doc->saveHTML();

        echo $nhtml;

        $_CntJQ .= "

            jQuery('head title').remove();
            /*$('head').a*/

        ";

    }else{

        $__new_html = '<div class="web_back" style="background-image:url('.$_wdgt_dt->test->image->back->big.');"></div>';
        $__show_html = 'ok';
        $__smlimg = 'ok';

    }

    curl_close($c);

}else{

    echo 'No ID for show';
    $__show_html='ok';

}

?>
<?php if($__show_html=='ok' && !isN($_wdgt_dt->id)){ ?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Widget Demo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <style>
            body{ padding:0; margin:0; }
            .main-page{ position:absolute; width:100%; height:100%; z-index:1; }
            .web_back{ position:absolute; left:0; top:0; width:100%; height:100%; z-index:1; background-size:cover; background-repeat:no-repeat; background-position:center center; }
        </style>
    </head>
<body>
    <?php if(!isN($__new_html)){ ?>
        <?php echo $__new_html; ?>
        <?php echo __WdgtCod([ 'id'=>$_wdgt_dt->enc ]); ?>
    <?php }elseif($_wdgt_dt->test->inline){ ?>
        <iframe src="<?php echo $_wdgt_dt->test->url; ?>" width="100%" height="100%" class="main-page"></iframe>
    <?php }else{ ?>
        <?php echo __WdgtCod([ 'id'=>$_wdgt_dt->enc ]); ?>
    <?php } ?>
</body>
</html>
<?php } ?>
<?php ob_start("compress_code"); ?>
<script type="text/javascript">

	"use strict";

    var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){

        SUMR_Ld.test.wdgt = true;

        var onld = function(){

            jQuery(document).ready(function($){
                SUMR_Ld.f.js({
                    t:'c',
                    u:'js.js',
                    c:function(){
                        /*console.log('Lets execute');*/
                    }
                });
            });

        };

        if(!window.jQuery){
            SUMR_Ld.f.js({
                t:'c',
                u:'jquery.js',
                c:function(){ onld(); }
            });
        }else{
            onld();
        }

	}

</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<?php ob_end_flush(); ?>