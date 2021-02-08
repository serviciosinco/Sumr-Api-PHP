
<?php 

    $CntWb .= " 

        SUMR_Org = {
            orgdsh:{}, 
            f:{
                set:function(p){
                    try{
                        if( !isN(p) ){
                            if( !isN(p.ls) ){ SUMR_Org.orgdsh['ls'] = p.ls; }
                            SUMR_Org.f.html();
                        }
                    }catch(e) {
                        SUMR_Main.log.f({ t:'".TX_ERDNEXT."', m:e });
                    }
                },
                html:function(){
                    $('#sort1 .cols').html('');

                    if(!isN(SUMR_Org.orgdsh['ls'])){
                        $.each(SUMR_Org.orgdsh['ls'], function(k, v) {
                            var cols = '';
                            if(!SUMR_Ld.f.isN(v.cols) && v.cols.e == 'ok'){
                                $.each(v.cols.ls, function(_k, _v) {
                                    if(!SUMR_Ld.f.isN(_v.fld) && _v.fld.e == 'ok'){
                                        var fld = '';
                                        $.each(_v.fld.ls, function(__k, __v) {
                                            if(!SUMR_Ld.f.isN(__v.grph)){
                                                fld = fld+'<div class=\"__g\">
                                                            <div class=\"cont_grph\">
                                                                <button data-tpo=\"grph\" class=\"org_dsh_edt\" data-bx=\"'+__v.grph.enc+'\" data-tp=\"org_".$___Ls->gt->tsb."_'+__v.grph.id_attr+'\" rel=\"'+__v.grph.id+'\"></button>
                                                                <div class=\"cont\" id=\"'+__v.grph.enc+'\"></div>
                                                            </div>
                                                        </div>';
                                            }else if(!SUMR_Ld.f.isN(__v.card)){
                                                fld = fld+'<div class=\"__g\">
                                                            <ul class=\"ls_rsmn buy_rsmn\">
                                                                <li class=\"est_act\">
                                                                    <div class=\"cont_grph\">
                                                                        <button data-tpo=\"card\" class=\"org_dsh_edt\" data-bx=\"'+__v.card.enc+'\" data-tp=\"org_".$___Ls->gt->tsb."_'+__v.card.id_attr+'\" rel=\"'+__v.card.id+'\"></button>
                                                                        <div>
                                                                            <i style=\"background-image: url('+__v.card.img+');\"></i>
                                                                            <strong id=\"'+__v.card.enc+'\">0</strong>
                                                                        </div>
                                                                        <span id=\"tt_'+__v.card.enc+'\"></span>
                                                                    </div>
                                                                </li> 
                                                            </ul>
                                                        </div>';
                                            }
                                        });
                                    }else{
                                        fld = '';
                                    }
                                    cols = cols+'<div id=\"'+_v.enc+'\" class=\"_cols\"><div class=\"dropdown\">
                                    <button class=\"dropbtn\"></button>
                                    <div class=\"dropdown-content\">
                                        <button data=\"'+_v.enc+'\" rel=\"'+_v.id+'\" class=\"add_dta\"></button>
                                        <button data=\"'+_v.enc+'\" rel=\"'+_v.id+'\" class=\"del_col\"></button>
                                    </div>
                                </div>'+fld+'</div>';
                                });  
                            }
    
                            
                            $('#sort1 .cols').append('
                                            <div id=\"'+v.enc+'\" class=\"rows __col_'+v.col+'\">
                                                <div class=\"dropdown\">
                                                    <button class=\"dropbtn\"></button>
                                                    <div class=\"dropdown-content\">
                                                        <button data=\"'+v.enc+'\" rel=\"'+v.id+'\" class=\"add_col\"></button>
                                                        <button data=\"'+v.enc+'\" rel=\"'+v.id+'\" class=\"del_row\"></button>
                                                    </div>
                                                </div>
                                                '+cols+'
                                            </div>');
                        });
            
                        $.each(SUMR_Org.orgdsh['ls'], function(k, v) {
                            if(!SUMR_Ld.f.isN(v.cols) && v.cols.e == 'ok'){
                                $.each(v.cols.ls, function(_k, _v) {
                                    if(!SUMR_Ld.f.isN(_v.fld) && _v.fld.e == 'ok'){
                                        $.each(_v.fld.ls, function(__k, __v) {
                                            if(!SUMR_Ld.f.isN(__v.grph)){

                                                if(!SUMR_Ld.f.isN(__v.grph.data)){
                                                    if(!isN(__v.grph.data.o)){

                                                        var data=[];

                                                        for(var k in __v.grph.data.o){
                                                            var v = __v.grph.data.o[k];
                                                            if(!isN(v.data)){
                                                                var dt = 1;
                                                                data.push({ name:v.name, data:v.data });
                                                            }else{
                                                                var dt = 2;
                                                                data.push( v );  
                                                            }
                                                        }

                                                        if(dt==2){
                                                            var dta = [];
                                                            dta.push({ name:'Total', data:data });
                                                        }else{
                                                            dta = data;   
                                                        } 
                                                        
                                                        if(!isN(data)){
                                                            if(!isN(__v.grph.tp_grph) && __v.grph.tp_grph == 1 ){
                                                                SUMR_Grph.f.g1({ 
                                                                    id: '#'+__v.grph.enc,
                                                                    c: !isN(__v.grph.data.c)?__v.grph.data.c:'',
                                                                    d: dta,
                                                                    tt: __v.grph.tt, 
                                                                    tt_sb: '-',
                                                                    c_e: !isN(__v.grph.data.c)?true:false
                                                                });
                                                            }else if( !isN(__v.grph.tp_grph) && __v.grph.tp_grph == 4){
                                                                SUMR_Grph.f.g4({ 
                                                                    id: '#'+__v.grph.enc,
                                                                    c: !isN(__v.grph.data.c)?__v.grph.data.c:'',
                                                                    d: dta,
                                                                    tt: __v.grph.tt, 
                                                                    tt_sb: '-',
                                                                    c_e: !isN(__v.grph.data.c)?true:false,
                                                                    g_spc_l: 0
                                                                });
                                                            }
                                                        }
                                                    }
                                                }

                                            }else if(!SUMR_Ld.f.isN(__v.card)){
                                                $('strong#'+__v.card.enc).html(__v.card.data.tot);
                                                $('span#tt_'+__v.card.enc).html(__v.card.data.tt);
                                            }
                                        });
                                    }
                                });  
                            }
                        });    
                    }

                    

                    SUMR_Org.f.dom();
                },
                rqu:function(p){
                    _Rqu({ 
                        t: p.t, 
                        tp: p.tp,
                        dt: p.dt,
                        d: p.d,
                        _bs: p._bs,
                        _cm: p._cm,
                        _cl: p._cl
                    });
                },
                dom:function(){
                    /*$( '.col1' ).sortable({
                        cancel: '.points',
                        placeholder: 'new-conten1',
                        stop: function (event, ui) { 
                            
                        }
                    }).disableSelection();
            
                    $( '.rows' ).sortable({
                        connectWith: '.rows',
                        placeholder: 'new-conten',
                        start: function(event, ui) {
            
                            ui.item.parent().addClass('_prc');
                            id_start = $(this).attr('id');
            
                        },
                        stop: function (event, ui) { 
            
                            lgu = $('#'+id_start+' ._cols').length;
                            var tots = 100 / lgu;
                            $('#'+id_start+' ._cols').css('width', tots+'%');
                            $('#'+id_start).removeClass('_prc');
            
                            ui.item.parent().addClass('prc');
                            var lg = $('.prc > ._cols').length;
                            var tot = 100 / lg;
                            $('.prc ._cols').css('width', tot+'%');
                            ui.item.parent().removeClass('prc');
            
                        }
                    }).disableSelection();
            
                    $( '._cols' ).sortable({
                        connectWith: '._cols',
                        placeholder: 'new-conten',
                        start: function(event, ui) {
            
                            ui.item.parent().addClass('_prc');
                            id_start = $(this).attr('id');
            
                        },
                        stop: function (event, ui) { 
            
                            lgu = $('#'+id_start+' ._cols').length;
                            var tots = 100 / lgu;
                            $('#'+id_start+' ._cols').css('width', tots+'%');
                            $('#'+id_start).removeClass('_prc');
            
                            ui.item.parent().addClass('prc');
                            var lg = $('.prc > ._cols').length;
                            var tot = 100 / lg;
                            $('.prc ._cols').css('width', tot+'%');
                            ui.item.parent().removeClass('prc');
            
                        }
                    }).disableSelection();*/
        
                    $('.org_dsh_edt').off('click').click(function(e){
        
                        e.preventDefault();
            
                        var id = $(this).attr('rel');
                        var bx = $(this).attr('data-bx');
                        var tp_o = $(this).attr('data-tp');
                        var tpo = $(this).attr('data-tpo');

                        if(!isN(id)){
                            _ldCnt({ 
                                u:'".FL_FM_GN.__t('org_dsh',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB.$___Ls->gt->i."&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=".$_tp_org."&_id='+id+'&_box='+bx+'&_tpo='+tp_o+'&tpo='+tpo,
                                w:'98%',
                                h:'98%',
                                pop:'ok',
                                pnl:{ e:'ok', tp:'h', s:'l' }
                            }); 
                        }
                    });  

                    $('.add_org_row').off('click').click(function(e){
        
                        e.preventDefault();

                        SUMR_Org.f.rqu({ 
                            t: 'org_dsh', 
                            tp: '".$_tp_org."',
                            dt: 'row_in',
                            _bs:function(){  },
                            _cm:function(){  },
                            _cl:function(_r){ 
                                if(!SUMR_Ld.f.isN(_r) && _r.in.e == 'ok'){ 
                                    $('#sort1 .cols').append('<div id=\"'+_r.in.enc+'\" class=\"rows __col_1\"><div class=\"dropdown\">
                                    <button class=\"dropbtn\"></button>
                                    <div class=\"dropdown-content\">
                                        <button data=\"'+_r.in.enc+'\" rel=\"'+_r.in.id+'\" class=\"add_col\"></button>
                                        <button data=\"'+_r.in.enc+'\" rel=\"'+_r.in.id+'\" class=\"del_row\"></button>
                                    </div>
                                </div></div>'); 
                                
                                    SUMR_Org.f.dom();
                                
                                }
                            }
                        });
                        
                    });

                    $('.del_row').off('click').click(function(e){
        
                        e.preventDefault();

                        var id = $(this).attr('rel');
                        var enc = $(this).attr('data');

                        SUMR_Org.f.rqu({ 
                            t: 'org_dsh', 
                            tp: '".$_tp_org."',
                            dt: 'row_del',
                            d: {
                                id: id
                            },
                            _bs:function(){  },
                            _cm:function(){  },
                            _cl:function(_r){ 
                                if(!SUMR_Ld.f.isN(_r) && _r.del.e == 'ok'){ 
                                    $('#'+enc).remove();
                                    SUMR_Org.f.dom();
                                }
                            }
                        });
                        
                    });

                    $('.dropbtn').off('click').click(function(e){ e.preventDefault(); });

                    $('.add_col').off('click').click(function(e){
        
                        e.preventDefault();

                        var id = $(this).attr('rel');
                        var enc = $(this).attr('data');

                        SUMR_Org.f.rqu({ 
                            t: 'org_dsh', 
                            tp: '".$_tp_org."',
                            dt: 'col_in',
                            d: {
                                id: id
                            },
                            _bs:function(){  },
                            _cm:function(){  },
                            _cl:function(_r){ 
                                if(!SUMR_Ld.f.isN(_r) && _r.in.e == 'ok'){ 
                                    $('#'+enc).append('<div id=\"'+_r.in.enc+'\" class=\"_cols\"><div class=\"dropdown\">
                                    <button class=\"dropbtn\"></button>
                                    <div class=\"dropdown-content\">
                                        <button data=\"'+_r.in.enc+'\" rel=\"'+_r.in.id+'\" class=\"add_dta\"></button>
                                        <button data=\"'+_r.in.enc+'\" rel=\"'+_r.in.id+'\" class=\"del_col\"></button>
                                    </div>
                                </div></div>');   
                                    SUMR_Org.f.dom();       					
                                }
                            }
                        });
                    });

                    $('.del_col').off('click').click(function(e){
        
                        e.preventDefault();

                        var id = $(this).attr('rel');
                        var enc = $(this).attr('data');

                        SUMR_Org.f.rqu({ 
                            t: 'org_dsh', 
                            tp: '".$_tp_org."',
                            dt: 'col_del',
                            d: {
                                id: enc
                            },
                            _bs:function(){  },
                            _cm:function(){  },
                            _cl:function(_r){ 
                                if(!SUMR_Ld.f.isN(_r) && _r.del.e == 'ok'){ 
                                    $('#'+enc).remove();
                                    SUMR_Org.f.dom();
                                }
                            }
                        });
                        
                    });

                    $('.add_dta').off('click').click(function(e){
        
                        e.preventDefault();
            
                        var bx = $(this).attr('data');
                        var tp_o = $(this).attr('data-tp');
            
                        if(!isN(bx)){
                            _ldCnt({ 
                                u:'".FL_FM_GN.__t('org_dsh',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB.$___Ls->gt->i."&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=".$_tp_org."&_box='+bx+'&_tpo='+tp_o,
                                w:'98%',
                                h:'98%',
                                pop:'ok',
                                pnl:{ e:'ok', tp:'h', s:'l' }
                            }); 
                        }

                    });

                }    
            }   
        };

        SUMR_Org.f.rqu({ 
            t: 'org_dsh', 
            tp: '".$_tp_org."',
            dt: 'ls',
            d:{  
                _i: '".$___Ls->gt->i."',
                _t2: '".$___Ls->gt->tsb_m."'
            },
            _bs:function(){  },
            _cm:function(){  },
            _cl:function(_r){ 
                if(!SUMR_Ld.f.isN(_r) && _r.e == 'ok'){ 
                    if(!SUMR_Ld.f.isN(_r.dash)){
                        SUMR_Org.f.set(_r.dash);
                    }					
                }
            } 
        });
        
    ";

?>


<div id="sort1" class="_org_dsh">
    <div class="cols col1">
    </div>
</div>
<div><button class="add_org_row">Agregar Row</button></div>
<?php
    if(ChckSESS_superadm()){ ?>

        <style>
            .add_org_row{background-color: transparent;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>addi.svg);width: 50px;height: 50px;margin: 15px auto;display: block;border: 0;font-size: 0;}
            .add_col, .add_dta{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>addi.svg);width: 25px;height: 30px;margin: 5px auto;border: 0;font-size: 0;background-position: center;background-repeat: no-repeat;background-size:70% auto;}
            .del_row, .del_col{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);width: 25px;height: 30px;margin: 5px auto;border: 0;font-size: 0;background-position: center;background-repeat: no-repeat;background-size:70% auto;}
            .dropbtn{transform: rotate(90deg);border-radius:50%;color:#fff;padding:16px;font-size:16px;border:none;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>arrow.svg);background-position:center center;background-repeat:no-repeat;background-size:60% auto}
            .dropdown{z-index:999;position:absolute;width:30px;top:2px;height:30px;right:3px;color:grey;border-radius:50%}
            .dropdown-content{display:none;position:absolute}
            .dropdown-content button{color:#000;padding:12px 16px;text-decoration:none;display:block}
            .dropdown-content button:hover{background-color:#ddd}
            .dropdown:hover .dropdown-content{display:block}
            .dropdown:hover .dropbtn{background-color:#cacaca}
            .org_dsh_edt{background-color: transparent;width: 25px;height: 25px;top: -30px;left: -30px;position: absolute;width: 25px;height: 25px;border-radius: 50%;z-index: 9;border: 0;background-size: 100% auto;background-repeat: no-repeat;background-position: center;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>editar.svg); }
        
            .add_org_row,
            .add_col, .add_dta,.org_dsh_edt,
            .del_row, .del_col, .dropbtn{display:block !important}

        </style>

    <?php }
?>

<style>
    ._org_dsh{width:100%;display:flex;background-color:#f5f6fb}
    ._org_dsh .cols{margin:10px;}
    ._org_dsh .cols.col1{width:100%;}
    ._org_dsh .cols .rows{background-color:#fff;width:calc(100%);display:flex;position:relative;border-radius:5px;height:300px;margin: 10px 0;padding:20px;}   
    ._org_dsh .cols .rows ._cols{margin:10px;position:relative;cursor:move;display: flex;padding: 15px;border: 1px solid #ececec;}
    ._org_dsh .cols .rows.__col_1 ._cols{width:100%}
    ._org_dsh .cols .rows.__col_2 ._cols{width:50%}
    ._org_dsh .cols .rows.__col_3 ._cols{width:33.3%}
    ._org_dsh .cols .rows.__col_4 ._cols{width:25%}
    ._org_dsh .cols .rows.__col_5 ._cols{width:20%}
    ._org_dsh .cols .rows ._cols.ui-sortable-helper{background-color:#dcdcdc78}
    ._org_dsh .cols .rows ._cols.ui-sortable-helper:before,
    ._org_dsh .cols .rows ._cols:first-of-type:before{background-color:transparent}
    ._org_dsh .cols .rows ._cols::before{content:"";width:2px;height:70%;background-color:#efefef;display:block;position:absolute;left:0;top:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}      
    .new-conten{margin:10px!important;width:100px;border:2px dotted #b5b5b5!important;background-color:#e2e2e2}
    .new-conten2{height:100px;width:500px;margin:10px!important;border:2px dotted #b5b5b5!important;background-color:#e2e2e2}
    .new-conten1{height:100px;margin:10px!important;border:2px dotted #b5b5b5!important;background-color:#e2e2e2}
    ._org_dsh .cols .rows ._cols h2{text-align:center;font-family:economica;color:#868686;margin:0;padding: 15px 0;}
    ._org_dsh .cols .rows ._cols ul{list-style-type:none}
    ._org_dsh .cols .rows ._cols li{width:95%;font-size:15px;padding:6px 0;border-bottom:1px solid #e0e0e0}
    .__g{width: 100%;display: inline-block;}  
    .cont_grph,
    .cont {width: 100%;position: relative;height: 100%;}
    .add_org_row,
    .add_col, .add_dta,.org_dsh_edt,
    .del_row, .del_col, .dropbtn{display:none}
</style>