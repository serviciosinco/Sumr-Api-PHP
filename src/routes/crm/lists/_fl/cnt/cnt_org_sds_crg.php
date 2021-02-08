<div class="FmTb">
   <div id="<?php  echo DV_GNR_FM ?>">
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

            <?php

                $CntJV .= "

                    SUMR_Cnt_Crg = {
                        bx_crg: $('#bx_crg'),
                        ls_crg: {},
                        f:{
                            dom: function(){
                                $('#bx_crg > li.itm ').not('.sch').off('click').click(function(){

                                    $(this).hasClass('on') ? est = 'del' : est = 'in';
                                    var _id = $(this).attr('rel');

                                    _Rqu({
                                        t:'org_sds_cnt_crg',
                                        d:'crg',
                                        est: est,
                                        _crg_enc : _id,
                                        _orgdsdscnt_enc : '".Php_Ls_Cln($___Ls->gt->i)."',
                                        _bs:function(){ SUMR_Cnt_Crg.bx_crg.addClass('_ld'); },
                                        _cm:function(){ SUMR_Cnt_Crg.bx_crg.removeClass('_ld'); },
                                        _cl:function(_r){
                                            if(!isN(_r)){
                                                if(!isN(_r.cnt)){
                                                    SUMR_Cnt_Crg.f.set(_r.cnt);
                                                }
                                            }
                                        }
                                    });
                                });

                                SUMR_Main.LsSch({ str:'#crg_sch', ls: $('#bx_crg > li.itm ') });

                            },
                            set: function(p){
                                try{
                                    if( !isN(p) ){

                                        if( !isN(p.crg) ){
                                            SUMR_Cnt_Crg.ls_crg['ls'] = p.crg.ls;
                                            SUMR_Cnt_Crg.ls_crg['tot'] = p.crg.tot;
                                        }

                                        SUMR_Cnt_Crg.f.html();
                                    }
                                }catch(e) {
                                    SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
                                }
                            },
                            html: function(){

                                SUMR_Cnt_Crg.bx_crg.html('');
                                SUMR_Cnt_Crg.bx_crg.append('<li class=\"sch\">".HTML_inp_tx('crg_sch', TX_SEARCH, '')."</li>');

                                $.each(SUMR_Cnt_Crg.ls_crg['ls'], function(k, v) {

                                    if(v.est > 0){ var _cls = 'on';  }else{   var _cls = 'off'; }
                                    SUMR_Cnt_Crg.bx_crg.append('<li  class=\"_anm itm crg '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"> <span>'+v.nm+'</span>');

                                });

                                SUMR_Cnt_Crg.f.dom();
                            }
                        }
                    };
                ";

                if($__i){

                    $CntJV .= "

                        try{
                            _Rqu({
                                t:'org_sds_cnt_crg',
                                _orgdsdscnt_enc : '".Php_Ls_Cln($___Ls->gt->i)."',
                                _cl:function(_r){
                                    if(!isN(_r)){
                                        if(!isN(_r.cnt)){
                                            SUMR_Cnt_Crg.f.set(_r.cnt);
                                        }
                                    }
                                }
                            });
                        }catch(e){
                            SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
                        }
                    ";
                }
            ?>

            <div class="cl_grp_dsh dsh_cnt">
                <div class="_c _c1 _anm _scrl">
                    <?php echo h2('CARGOS'); ?>
                    <div class="_wrp">
                        <ul id="bx_crg" class="_ls _anm dls"></ul>
                    </div>
                </div>
            </div>

            <style>
                .cl_grp_dsh .bx_crg._ld{pointer-events: none;}
                .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
                .cl_grp_dsh ._c._c1{ width: 100%!important; margin: auto; }
                .cl_grp_dsh ._c h2{ text-align: center; }
                .cl_grp_dsh ._c ul .itm.crg:hover,
                .cl_grp_dsh ._c ul .itm.crg.on {background-color: var(--main-bg-color);color: white !important;}
                .cl_grp_dsh ._c ul .itm.crg.on span {color: white;}
            </style>
        </div>
    </div>
</div>