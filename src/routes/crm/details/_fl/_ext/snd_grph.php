<?php 

    $__grph_shw = "
        
        /* 
        
        _ldCnt({ 
            u:'".Fl_Rnd(FL_GRPH_GN.__t('ec_snd', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=dsp&_g_r=".$___Ls->id_rnd."' , 
            c:'_grph_3_glb',
            trs:false, 
            anm:'no',
            _cl:function(){
                
                _ldCnt({ 
                    u:'".Fl_Rnd(FL_GRPH_GN.__t('ec_snd', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=os&_g_r=".$___Ls->id_rnd."' , 
                    c:'_grph_4_glb',
                    trs:false,
                    anm:'no',
                    _cl:function(){
                        
                        _ldCnt({ 
                            u:'".Fl_Rnd(FL_GRPH_GN.__t('ec_snd', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=brws&_g_r=".$___Ls->id_rnd."' , 
                            c:'_grph_5_glb',
                            trs:false,
                            anm:'no',
                            _cl:function(){
                                
                                _ldCnt({ 
                                    u:'".Fl_Rnd(FL_GRPH_GN.__t('ec_snd', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=clnt&_g_r=".$___Ls->id_rnd."' , 
                                    c:'_grph_6_glb',
                                    trs:false,
                                    anm:'no',
                                    _cl:function(){
                                        
                                        _ldCnt({ 
                                            u:'".Fl_Rnd(FL_GRPH_GN.__t('ec_snd', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=bnct&_g_r=".$___Ls->id_rnd."' , 
                                            c:'_grph_7_glb',
                                            trs:false,
                                            anm:'no',
                                            _cl:function(){
                                                
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

        */

    ";

    $CntWb .= " setTimeout(function(){ ".$__grph_shw." }, 1000); ";


    /*$CntWb .= "		
                
        function _rq_json(p=null){
            if( !isN(SUMR_Main['main']) ){
                SUMR_Main['main'].abort();
                SUMR_Main['main'] = '';
            }

            return new Promise((resolve, reject)=>{

                if( isN(SUMR_Main['main']) ){
                    SUMR_Main['main'] = $.getJSON('".FL_JSON_GN.__t('ec_snd_grph', true)."&__t='+p._t+'&Rnd='+Math.random(), function(_p){
                        if(!isN(_p['e'])){
                            resolve(_p);
                        }
                    });
                }

            });
        }
        
        //---------- Peticion 1 ----------
        if( $('#_grph_3_glb').length > 0 ){
            _rq_json({ _t:'dsp' }).then(function(p) {
                if(!isN(p.e)){
                    
                    if(p.e == 'ok'){
                        var _p_d = [];
                        
                        $.each( p._d, function(k, v) {
                            _p_d.push({ \"name\":v['name'], \"y\":parseInt(v['y']) });
                        });
                        SUMR_Grph.f.g2({ 
                            id: '#_grph_3_glb',
                            g_h: 350,
                            g_mrg_t:0,
                            g_mrg_b:0,
                            d: _p_d ,
                            tt: 'Aperturas',
                            tt_sb: 'Unicas por dispositivo',
                            dt_lbl: false,
                            lgnd:true,
                            dt_lbl_frmt: '{pint.percentage:.1f}%',
                            lgnd_frmt: function() {
                                return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                            },
                            i_s:'50%',
                            lgnd_lyt: 'horizontal',
                            lgnd_valgn: 'bottom',
                            lgnd_algn: 'center',
                            lgnd_y: 0
                        });
                    }
                    SUMR_Main['main'] = '';
                    $('#_grph_3_glb').parent('._grph').removeClass('_ld');
                    
                    

                    // ---------- Peticion 2 ----------
                    if( $('#_grph_4_glb').length > 0 ){
                        _rq_json({ _t:'os' }).then(function(p) {
                            if(!isN(p.e)){

                                if(p.e == 'ok'){
                                    var _p_d = [];
                                    $.each( p._d, function(k, v) {
                                        _p_d.push({ \"name\":v['name'], \"y\":parseInt(v['y']) });
                                    });
                                    SUMR_Grph.f.g2({ 
                                        id: '#_grph_4_glb',
                                        g_h: 350,
                                        g_mrg_t:0,
                                        g_mrg_b:0,
                                        d: _p_d,
                                        tt: 'Aperturas Movil',
                                        tt_sb: 'Sistema Operativo',
                                        dt_lbl: false,
                                        lgnd:true,
                                        lgnd_frmt: function() {
                                            return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                                        },
                                        i_s:'50%',
                                        lgnd_lyt: 'horizontal',
                                        lgnd_valgn: 'bottom',
                                        lgnd_algn: 'center',
                                        lgnd_y: 0
                                    });
                                }
                                SUMR_Main['main'] = '';
                                $('#_grph_4_glb').parent('._grph').removeClass('_ld');
                                


                                // ---------- Peticion 3 ----------
                                if( $('#_grph_5_glb').length > 0 ){
                                    _rq_json({ _t:'brws' }).then(function(p) {
                                        if(!isN(p.e)){
                                            if(p.e == 'ok'){
                                                var _p_d = [];
                                                $.each( p._d, function(k, v) {
                                                    _p_d.push({ \"name\":v['name'], \"y\":parseInt(v['y']) });
                                                });
                                                SUMR_Grph.f.g2({
                                                    id: '#_grph_5_glb',
                                                    g_h: 350,
                                                    g_mrg_t:0,
                                                    g_mrg_b:0,
                                                    g_spc_t:0,
                                                    d: _p_d,
                                                    tt: 'Aperturas',
                                                    tt_sb: 'Navegador',
                                                    dt_lbl: false,
                                                    lgnd:true,
                                                    lgnd_frmt: function() {
                                                        return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                                                    },
                                                    i_s:'50%',
                                                    lgnd_lyt: 'horizontal',
                                                    lgnd_valgn: 'bottom',
                                                    lgnd_algn: 'center',
                                                    lgnd_y: 0
                                                });
                                            }
                                            SUMR_Main['main'] = '';
                                            $('#_grph_5_glb').parent('._grph').removeClass('_ld');


                                            
                                            // ---------- Peticion 4 ----------
                                            if( $('#_grph_6_glb').length > 0 ){
                                                _rq_json({ _t:'clnt' }).then(function(p) {
                                                    if(!isN(p.e)){
                                                        if(p.e == 'ok'){
                                                            var _p_d = [];
                                                            var _p_d_ctg = [];

                                                            $.each( p._d, function(k, v) {
                                                                if(!isN(v['y']) && !isN(v['name'])){
                                                                    _p_d_ctg.push( v['name'] );
                                                                    _p_d.push( parseInt(v['y']) );
                                                                }
                                                            });
                                                            SUMR_Grph.f.g7({ 
                                                                id: '#_grph_6_glb',
                                                                g_spc_b: 80,
                                                                tt: 'Aperturas',
                                                                tt_sb: 'Cliente Email',
                                                                ctg: _p_d_ctg,
                                                                d: [{ name: 'Aperturas', data: _p_d }]	
                                                            });
                                                        }
                                                        SUMR_Main['main'] = '';
                                                        $('#_grph_6_glb').parent('._grph').removeClass('_ld');



                                                        // ---------- Peticion 5 ----------
                                                        if( $('#_grph_7_glb').length > 0 ){
                                                            _rq_json({ _t:'bnct' }).then(function(p) {
                                                                if(!isN(p.e)){
                                                                    if(p.e == 'ok'){
                                                                        var _p_d = [];
                                                                        $.each( p._d, function(k, v) {
                                                                            _p_d.push({ \"name\":v['name'], \"y\":parseInt(v['y']) });
                                                                        });
                                                                        SUMR_Grph.f.g2({ 
                                                                            id: '#_grph_7_glb',
                                                                            g_h: 350,
                                                                            g_mrg_t:0,
                                                                            g_mrg_b:0,
                                                                            g_spc_t:0,
                                                                            d: _p_d,
                                                                            tt: 'Rebotes',
                                                                            tt_sb: 'por tipologia',
                                                                            dt_lbl: false,
                                                                            lgnd:true,
                                                                            lgnd_frmt: function() {
                                                                                return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
                                                                            },
                                                                            i_s:'50%',
                                                                            lgnd_lyt: 'horizontal',
                                                                            lgnd_valgn: 'bottom',
                                                                            lgnd_algn: 'center',
                                                                            lgnd_y: 0
                                                                        });
                                                                    }
                                                                    SUMR_Main['main'] = '';
                                                                    $('#_grph_7_glb').parent('._grph').removeClass('_ld');
                                                                }
                                                            });
                                                        }



                                                    }
                                                });
                                            }



                                        }
                                    });
                                }



                            }
                        });
                    }



                }
            });
        }
    ";

?>