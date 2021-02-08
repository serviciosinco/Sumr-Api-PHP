<?php
	        
    $CntJV .= " 

        var SUMR_Mdl_Fm_Ps = {
            bx_mdlfm_ps:$('#bx_mdlfm_ps".$__Rnd."'),
            bx_mdlfm_ps_itm:'',
            f:{
                dom:function(){

                    SUMR_Mdl_Fm_Ps.bx_mdlfm_ps_itm = $('#bx_mdlfm_ps".$__Rnd." > li.itm ');

                    SUMR_Mdl_Fm_Ps.bx_mdlfm_ps_itm.not('.sch').off('click').click(function(){
                                
                        $(this).hasClass('on') ? est = 'del' : est = 'in'; 		
                        var _id = $(this).attr('rel');

                        _Rqu({ 
                            t:'mdl_s_tp_fm_ps', 
                            _id_mdl_fm : '".Php_Ls_Cln($___Ls->gt->isb)."',
                            _id: _id,
                            _d: 'prc',
                            _bs:function(){ $('._mdlfm_us ul').addClass('_ld'); },
                            _cm:function(){ $('._mdlfm_us ul').removeClass('_ld'); },
                            _cl:function(_r){
                                if(!isN(_r)){
                                    if(!isN(_r.mdlfm)){
                                        SUMR_Mdl_Fm_Ps.f.set(_r.mdlfm);				
                                    }
                                }
                            } 
                        });
                        
                    });

                    SUMR_Main.LsSch({ str:'#mdlfm_ps_sch_".$__Rnd."', ls:SUMR_Mdl_Fm_Ps.bx_mdlfm_ps_itm });
                },
                html:function(){
                    SUMR_Mdl_Fm_Ps.bx_mdlfm_ps.html('');
                    SUMR_Mdl_Fm_Ps.bx_mdlfm_ps.append('<li class=\"sch\">".HTML_inp_tx('mdlfm_ps_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
                    
                    if(!isN(_mdlfm_ps['ls'])){
                        
                        $.each(_mdlfm_ps['ls'], function(k, v) { 
                            if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
                            SUMR_Mdl_Fm_Ps.bx_mdlfm_ps.append('<li class=\"_anm itm ps mdlfm_us '+_cls+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url(https://fle.sumr.cloud/ps/th/sis_ps_'+v.id+'x200.jpg)\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
                        });	
                    }
                    
                    SUMR_Mdl_Fm_Ps.f.dom();
                },
                set:function(p){
                    if( !isN(p) ){
                
                        _mdlfm_ps = {};
                        
                        if( !isN(p.ps) ){ _mdlfm_ps['ls'] = p.ps.ls; _mdlfm_ps['tot'] = p.ps.tot; }
                        SUMR_Mdl_Fm_Ps.f.html();
        
                    }
                }
            }
        };
    ";

    $CntJV .= " 

        _Rqu({ 
            t:'mdl_s_tp_fm_ps', 
            _id_mdl_fm : '".Php_Ls_Cln($___Ls->gt->isb)."',
            _d: 'ls',
            _cl:function(_r){
                if(!isN(_r)){
                    if(!isN(_r.mdlfm)){
                        SUMR_Mdl_Fm_Ps.f.set(_r.mdlfm);			
                    }
                }
            } 
        });
    ";
?>

    <div class="_c _c2 _anm _scrl _mdlfm_us">
        <?php echo h2(TX_PS); ?>
        <div class="_wrp">
            <ul id="bx_mdlfm_ps" class="_ls _anm dls"></ul>	
        </div>
    </div>

    <style>

        ._mdlfm_us ul{ list-style-type: none;padding: 0; }
        ._mdlfm_us ul._ld{ opacity: 0.4; }
        ._mdlfm_us ul._ld li{ pointer-events: none; }

        ._mdlfm_us ul .mdlfm_us{width: 100%;background-color: #d4d4d4;border-radius: 7px;padding: 7px 35px;position: relative;height: 28px;margin: 3px 0;cursor:pointer;}
        ._mdlfm_us ul .mdlfm_us figure{ display: block;width: 35px;height: 35px;background-position: center center;background-repeat: no-repeat;background-size: 100% auto;border: 2px solid white;border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;position: absolute;top: -4px;padding: 0;margin: 0;background-color: white;left: -5px; }
        ._mdlfm_us ul .mdlfm_us.on,
        ._mdlfm_us ul .mdlfm_us:hover {color: white;filter: grayscale(0%);opacity: 1;border: 2px solid var(--second-bg-color);background-color: var(--main-bg-color);}
    
    </style>