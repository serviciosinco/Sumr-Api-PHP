<?php
    $_mdlcnt = GtMdlCntDt([ 't'=>'enc', 'id'=>$___Ls->gt->isb, 'shw'=>[ 'cnt'=>'ok' ] ]);
    $_gtway = GtClGtwyPayLs([ 'cl'=>DB_CL_ENC ]);
?>
<div class="--gtwy-pay-opt">
    <?php echo h1('Selecciona Plataforma'); ?>

    <div class="wrp">
        <div class="c1">
            <ul>
                <li class="opt-eml"><?php echo LsCntEml([ 'id'=>'gtwy_eml', 'cnt'=>$_mdlcnt->cnt->id, 'v'=>'cnteml_enc', 'actv'=>'no' ]); $CntWb .= JQ_Ls('gtwy_eml', FM_LS_SLEML); ?></li>
                <li class="opt-dc"><?php echo LsCntDc([ 'id'=>'gtwy_dc', 'cnt'=>$_mdlcnt->cnt->id, 'v'=>'cntdc_enc' ]); $CntWb .= JQ_Ls('gtwy_dc', FM_LS_SLDOC); ?></li>
                <li class="opt-qty">
                    <button class="_lss _anm"></button>
                    <div class="slc-qty">
                        <?php echo HTML_inp_tx('gtwy_qty', TX_CNTD, '1', FMRQD_NMR); ?>
                    </div>
                    <button class="_mre _anm"></button>
                </li>
            </ul>
        </div>
        <div class="c2">
            <?php if($_gtway->tot > 0){ ?>
                <ul>
                    <?php foreach($_gtway->ls as $_gtway_k=>$_gtway_v){ ?>
                        <li class="_anm actv-<?php echo $_gtway_v->e; ?> --gtwy-pay-opt-chnl" cl-gtwy-id="<?php echo $_gtway_v->enc; ?>">
                            <figure style="background-image:url(<?php echo $_gtway_v->img; ?>);" class="_anm"></figure>
                            <div class="tt _anm"><?php echo $_gtway_v->tt.HTML_BR.Spn('Generar Código'); ?></div>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <div>
    </div>
</div>

<?php 

    $_CntJV .= "
        
        function Dom_LnkToBuy_Api(){

            $('.--gtwy-pay-opt .--gtwy-pay-opt-chnl.actv-ok').off('click').click(function() {
                
                var _this = $(this);
                var _gtwy = $(this).attr('cl-gtwy-id'); 
                var _gtwy_eml = $('#gtwy_eml option:selected').val();
                var _gtwy_dc = $('#gtwy_dc option:selected').val();
                var _gtwy_qty = $('#gtwy_qty').val();

                if( _gtwy && ( !isN(_gtwy_eml) || !isN(_gtwy_dc) ) && !isN(_gtwy_qty) ){

                    _Rqu({

                        t:'mdl_cnt_pay_lnk',
                        cl_gtwy:_gtwy,
                        gtwy_eml:_gtwy_eml,
                        gtwy_dc:_gtwy_dc,
                        gtwy_qty:_gtwy_qty,
                        mdl_cnt:'".$___Ls->gt->isb."',
                        _bs:function(){ 
                            _this.addClass('_ld');
                        },
                        _cm:function(){ 
                            _this.removeClass('_ld');
                        },
                        _cl:function(_r){
                            if(!isN(_r)){
                                if(!isN(_r.e) && _r.e == 'ok'){
                                    $('#Links_ToBuy_Bx .--lnk-buy-items').append('
                                            <li>
                                                <figure style=\"background-image:url('+_r.tp.img+');\"></figure>
                                                <div class=\"_tt\">'+_r.tp.tt+'</br><span>'+_r.fi+'</span></div>
                                                <button class=\"_cpy\" lnk-go=\"'+_r.url+'\" title=\"'+_r.url+'\">Copiar</button>
                                            </li>');

                                    Dom_LnkToBuy();
                                    SUMR_Main.pnl.f.shw();
                                }
                            }
                        } 
                    });

                }else{

                    $('.--gtwy-pay-opt .wrp .c1').effect('shake', { times:3 }, 600 );

                }

            }); 



            $('.--gtwy-pay-opt .opt-qty ._lss').off('click').click(function() {
                bx_gtwy_qty = $('#gtwy_qty');
                if( !isN( bx_gtwy_qty.val() ) && bx_gtwy_qty.val() > 0){
                    var _n = bx_gtwy_qty.val()*1; _n = _n-1;
                    bx_gtwy_qty.val( _n ); 
                }
            });


            $('.--gtwy-pay-opt .opt-qty ._mre').off('click').click(function() {
                bx_gtwy_qty = $('#gtwy_qty');
                if( isN( bx_gtwy_qty.val() ) ){ bx_gtwy_qty.val(1); }else{ bx_gtwy_qty.val( (bx_gtwy_qty.val()*1)+1 ); }
            });

        }

    ";

    $CntWb .= " Dom_LnkToBuy_Api(); ";

?>

<style>

    .--gtwy-pay-opt{ width:100%; display:block; }

    .--gtwy-pay-opt label,
    .--gtwy-pay-opt .styled-select label, 
    .--gtwy-pay-opt .styled-select-bx label, 
    .--gtwy-pay-opt .styled-select-mlt label{ display:none; }
    
    .--gtwy-pay-opt .wrp{ width:100%; display:flex; }
    .--gtwy-pay-opt .wrp .c1{ width:47%; padding:20px; background-color:#f3f2f7; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; }
    .--gtwy-pay-opt .wrp .c2{ width:53%; }
    
    .--gtwy-pay-opt .wrp .opt-qty{ display:flex; width:100%; }
    .--gtwy-pay-opt .wrp .opt-qty .slc-qty{ width:100%; }
    .--gtwy-pay-opt .wrp .opt-qty ._lss,
    .--gtwy-pay-opt .wrp .opt-qty ._mre{ cursor:pointer; width:30px; height:30px; min-height:30px; min-width:30px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border:none; background-color:#ccc; margin-top:5px; background-repeat: no-repeat; background-position: center center; background-size: auto 60%; }
    
    .--gtwy-pay-opt .wrp .opt-qty ._lss{ margin-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>qty_less.svg); }
    .--gtwy-pay-opt .wrp .opt-qty ._mre{ margin-left:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>qty_more.svg); }


    .--gtwy-pay-opt .wrp .opt-qty ._lss:hover,
    .--gtwy-pay-opt .wrp .opt-qty ._mre:hover{ background-color:var(--main-bg-color); }

    .--gtwy-pay-opt .wrp .c1 ul{ padding:0; margin:0; list-style:none; }
    .--gtwy-pay-opt .wrp .c1 ul li input[type=text]{ width:100%; background-color:#fff; border: 1px solid #aaa; text-align:center; }
    .--gtwy-pay-opt .wrp .c1 ul li input[type=text]::-moz-placeholder{ text-align:center; font-size:9px; }
    .--gtwy-pay-opt .wrp .c1 ul li input[type=text]:-ms-input-placeholder{ text-align:center; font-size:9px; }
    .--gtwy-pay-opt .wrp .c1 ul li input[type=text]::-webkit-input-placeholder{ text-align:center; font-size:9px; }


    .--gtwy-pay-opt h1{ font-family:Economica; text-transform:uppercase; font-size:24px; text-align:center; font-weight:100; margin-bottom:100px; }
    .--gtwy-pay-opt h1::before{ width:40px; height:40px; margin-bottom:-10px; display:inline-block; margin-right:20px; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>gtwy_pay.svg'); background-repeat:no-repeat; background-position:center center; background-size: auto 90%; }
    .--gtwy-pay-opt ul{ padding:0; margin:0; width:100%; text-align:center;  }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl{ display:flex; width:100%; align-items: center; justify-content: center; font-size:16px; cursor:pointer; color:#999; margin-bottom:30px; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl figure{ width:50px; height:50px; margin-bottom:-10px; margin-right:10px; border-radius: 200px; -moz-border-radius: 200px; -webkit-border-radius: 200px; background-repeat:no-repeat; background-position:center center; background-size: auto 60%; background-color:#fff; border:2px solid #ececec; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl div.tt{ font-family:Economica; text-transform:uppercase; color:#000; opacity:0.5; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl div.tt span{ border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; border:1px solid #ccc; background-color:#fff; padding:5px 6px; color:#797979; font-size:9px; font-family:Roboto; text-transform:lowercase; }        
    
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl:hover{ filter: grayscale(0%) !important; opacity:1 !important; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl:hover div.tt{ opacity:1; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl:hover figure{ background-size: auto 70%; }

    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl.actv-no{ filter: grayscale(100%); opacity:0.5; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl._ld{ pointer-events:none; }
    .--gtwy-pay-opt ul > .--gtwy-pay-opt-chnl._ld figure{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg) !important; }
    


    


</style>