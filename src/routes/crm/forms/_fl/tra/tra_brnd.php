<?php 
	$__id_fm = 'FmRpr';
    $_tra = Php_Ls_Cln($_GET['_tra']);
    $_brnd = Php_Ls_Cln($_GET['_brnd']);

    $__data = GtStoreBrnd();

    foreach ($__data->ls as $key => $value) {
        if($value->id == $_brnd){ $est = 'act'; }else{ $est = 'desc'; }
        $_li .= '<li class="c_'.$est.'" data-id="'.$value->id.'"><span class="_anm '.$est.'" style="background-image:url('.$value->img.')"></span>'.$value->nm.'</li>';
    }
    
?>

<div class="icn_brnd"> </div>

<ul class="ls_store">
    <?php echo $_li; ?>
</ul>

<style>

    .icn_brnd{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>brand.svg);width: 100px;height: 140px;margin: 0 auto;background-position: center;background-repeat: no-repeat;background-size: 100% auto; }
    .ls_store._ldr{ pointer-events: none; opacity: 0.5; }
    .ls_store li{ display:block;margin: 12px 25px;text-align: center;cursor:pointer }
    .ls_store li span{opacity: .3;width: 50px;height: 50px;display: block;background-position: center;background-repeat: no-repeat;background-size: 100% auto;border-radius: 50%;margin: 10px auto; }
    .ls_store li span.act {opacity: 1 !important;border: 3px solid var(--second-bg-color);}
    .ls_store li span.desc:hover{opacity: .6}

</style>

<?php 

    $CntWb .= "$('.ls_store li.c_desc').off('click').click(function(){

                    var id_brnd = $(this).attr('data-id');

                    SUMR_Tra.f.Rqu({
                        d:{
                            tp:'edi_tra_brnd', 
                            tra:'".$_tra."', 
                            id_brnd:id_brnd
                        },
                        _bs:function(){ $('.ls_store').addClass('_ldr'); },
                        _cm:function(){ $('.ls_store').removeClass('_ldr'); },
                        _cl:function(_r){
                            if(!isN(_r.e) && _r.e == 'ok'){
                                SUMR_Main.pnl.f.shw();   
                                SUMR_Tra.f.Shw({ o:'ok' });
                            }	
                        } 
                    });
                });";

?>