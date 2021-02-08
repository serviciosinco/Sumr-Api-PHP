<?php 
	$__id_fm = 'FmRpr';
    $_tra = Php_Ls_Cln($_GET['_tra']);
    $_tra_col = Php_Ls_Cln($_GET['_tra_col']);

    $__data = GtTraColLs([ 'flt'=>' AND tracol_chk_pqr != 1 ' ]);
    
    foreach ($__data->ls as $key => $value) {
        if($value->id == $_tra_col){ $est = 'act'; }else{ $est = 'desc'; }

        $_li .= '<li class="c_'.$est.'" data-enc="'.$value->enc.'" data-id="'.$value->id.'"><span class="_anm '.$est.'" style="background-color:'.$value->clr->vl.';background-image:url('.$value->icn->slc->img.')"></span>'.$value->tt.'</li>';
        
    }
    
?>

<div class="icn_brnd"> </div>

<ul class="ls_tracol">
    <?php echo $_li; ?>
</ul>

<style>

    .icn_brnd{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>columnas.svg);width: 100px;height: 140px;margin: 0 auto;background-position: center;background-repeat: no-repeat;background-size: 100% auto; }
    .ls_tracol._ldr{ pointer-events: none; opacity: 0.4; }
    .ls_tracol{margin: 0;padding: 0;}
    .ls_tracol li{ opacity:.3; border-radius: 9px; display:flex; align-items: center; justify-content: center; margin: 12px 0px; text-align: center; cursor:pointer; width:100%; border:2px dashed #ccc; font-family:Economica; font-size:16px; text-transform:uppercase; padding: 5px 10px; }
    .ls_tracol li:hover{ opacity:1; }
    .ls_tracol li span{ width: 40px;height: 40px;display: block;background-position: center;background-repeat: no-repeat;background-size: 50% auto;border-radius: 50%; margin:0px 6px 0 0; }
    .ls_tracol li span.act{ opacity: 1 !important; }
    .ls_tracol li span.desc:hover{opacity: .6}
    .ls_tracol li.c_act { border: 2px dashed #b0b0b0; padding: 6px; opacity:1; }

</style>

<?php 

    $CntWb .= "$('.ls_tracol li.c_desc').off('click').click(function(){

                    var id_tracol = $(this).attr('data-id');
                    var tracol_enc = $(this).attr('data-enc');

                    SUMR_Tra.f.Rqu({
                        d:{
                            tp:'edi_tra_col', 
                            tra:'".$_tra."', 
                            id_tracol:id_tracol
                        },
                        _bs:function(){ $('.ls_tracol').addClass('_ldr'); },
                        _cm:function(){ $('.ls_tracol').removeClass('_ldr'); },
                        _cl:function(_r){
                            if(!isN(_r.e) && _r.e == 'ok'){

                                let html = $('#tra_".$_tra."').clone();
                                $('#tra_".$_tra."').remove();
                                $('#_tra_appn_'+tracol_enc).prepend( html );

                                SUMR_Main.pnl.f.shw();   
                                SUMR_Tra.f.Shw();
                                SUMR_Tra.f.DomRbld();

                            }	
                        } 
                    });
                });";

?>