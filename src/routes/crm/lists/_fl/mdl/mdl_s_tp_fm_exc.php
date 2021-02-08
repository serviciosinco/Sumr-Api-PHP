    <div id="mdl_fm_exc">
        <ul>
        
        </ul>
    </div>


<?php 

    $CntJV = " 

        var SUMR_Mdl_Fm_Exc = {
            mdlfmexc:{},
            mdls_fm_itm:''
        }; 

        function DomFm_Rbld(){

            SUMR_Mdl_Fm_Exc.mdls_fm_itm = $('#mdl_fm_exc li span');

            SUMR_Mdl_Fm_Exc.mdls_fm_itm.not('.sch').off('click').click(function(){

                var _id = $(this).parent().attr('rel');
                var _enc = $(this).parent().attr('id');

                $(this).hasClass('est_1') ? est = 'ok' : est = 'no';

                var _tp = $(this).attr('data-tp');

                _Rqu({ 
                    t:'mdl_s_tp_fm_exc', 
                    d:'fld',
                    _id_fld : '".$_GET['__i']."',
                    _id_tp : '".$_GET['_rel']."',
                    _enc : _enc,
                    _tp : _tp,
                    _id : _id,
                    _est: est,
                    _bs:function(){ SUMR_Mdl_Fm_Exc.mdls_fm_itm.addClass('_ld'); },
                    _cm:function(){ SUMR_Mdl_Fm_Exc.mdls_fm_itm.removeClass('_ld'); },
                    _cl:function(_r){ 
                        if(!isN(_r)){ 
                            if(_r.mdl_fm.exc.e == 'ok'){ 
                                MdlFmExcSet(_r);
                            }
                        }
                    } 
                });
            });    
        }

        function MdlFmExc_Html(){
            if(SUMR_Mdl_Fm_Exc.mdlfmexc['tot'] > 0){
                
                $('#mdl_fm_exc ul').html('');

                $.each(SUMR_Mdl_Fm_Exc.mdlfmexc['ls'], function(k, v) {

                    if( (v.inc==2 && v.exc==2) || isN(v.id) ){ var vl = 'empty'; }else{ var vl = 'ok'}
                    if(!isN(v.enc)){ var enc = v.enc; }else{ var enc = ''; }

                    $('#mdl_fm_exc ul').append('<li id=\"'+v.sis_enc+'\" rel=\"'+enc+'\" class=\"_anm est_'+vl+'\">'+v.nm+'<span data-tp=\"inc\" class=\"_anm est inc est_'+v.inc+'\"></span><span data-tp=\"exc\" class=\"_anm est exc est_'+v.exc+'\"></span></li>');
                
                });

                DomFm_Rbld();
            }   
        }
        
        function MdlFmExcSet(p){

            if( !isN(p) ){ 
                
                if( !isN(p.mdl_fm.exc) ){ 
                    SUMR_Mdl_Fm_Exc.mdlfmexc['ls'] = p.mdl_fm.exc.ls; 
                    SUMR_Mdl_Fm_Exc.mdlfmexc['tot'] = p.mdl_fm.exc.tot;
                }

                MdlFmExc_Html();

            }
        }
    ";

    $CntJV .= " 	
            _Rqu({ 
                t:'mdl_s_tp_fm_exc', 
                _id_fld : '".$_GET['__i']."',
                _id_tp : '".$_GET['_rel']."',
                _cl:function(_r){ 
                    if(!isN(_r)){ 
                        if(_r.mdl_fm.exc.e == 'ok'){ 
                            MdlFmExcSet(_r);
                        }
                    }
                }  
            });
        ";
?>

<style>

    #mdl_fm_exc ul{list-style-type:none}
    #mdl_fm_exc li{text-align:left;position:relative;width:70%;background-color:#f3f3f3;margin:10px auto;padding:5px 30px;border-radius:10px;border:1px solid #9e9e9e;color:#949494}
    #mdl_fm_exc span.est{width:25px;height:25px;display:inline-block;vertical-align:top;margin:0 8px;position:absolute;top:2px;border-radius:50%;cursor:pointer}
    .est_empty{border:1px solid #cecece}
    .est_ok{border:2px solid #9bffb5!important}
    #mdl_fm_exc span.est.inc.est_1{border:1px solid #86da5c;filter:grayscale(0%)}
    #mdl_fm_exc span.est.inc{right:25px;filter:grayscale(100%);background-size:70% auto;background-position:center;background-repeat:no-repeat;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_fm_exc_ok.svg)}
    #mdl_fm_exc span.est.inc.est_2,span.est.exc.est_2,.est_{border:1px solid #949494;opacity:.4}
    #mdl_fm_exc span.est.exc{right:-4px;filter:grayscale(100%);background-size:60% auto;background-position:center;background-repeat:no-repeat;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_fm_exc_no.svg)}
    #mdl_fm_exc span.est.exc.est_1{border:1px solid red;filter:grayscale(0)}
    #mdl_fm_exc span.est.inc.est_1:hover{background-size:90%!important}
    #mdl_fm_exc span.est.inc.est_2:hover,.inc.est_:hover{background-size:90%!important;filter:grayscale(50%)!important}
    span.est.exc.est_1:hover{background-size:70%!important}
    span.est.exc.est_2:hover,.est_:hover{background-size:70%!important;filter:grayscale(50%)!important}
    span._anm.est._ld{cursor:no-drop!important;pointer-events:none;filter:grayscale(100)!important;opacity:.4}
    ._ldr{background-image:url(https://img.sumrdev.com/estr/svg/loader_black.svg)!important}

</style>