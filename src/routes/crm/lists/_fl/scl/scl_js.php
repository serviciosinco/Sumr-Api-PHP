<?php

    $CntWb .= "
    
        SUMR_Scl = {
            bxajx:{
                enc:''
            },
            open:{
			
            },
            oid:function(){
				if(!isN(SUMR_Scl.bxajx) && !isN(SUMR_Scl.bxajx.enc)){ return SUMR_Scl.bxajx.enc; }else{ return false; }
			},
            dom:function(p){

                var __sisslc_bx_cl_itm = $('li.fms');

                $('#lstd_form li.fms').off('click').click(function(){ 
                    SUMR_Scl.bxajx.enc = $(this).attr('rel');
                    SUMR_Scl.Shw({ o:'ok', u:'scl_acc_form' });
                });

                $('.btn_sch').off('click').click(function(){ 

                    var val_sch = $('#cl_sch_').val();

                    SUMR_Scl.Rqu({
                        d:{
                            _tp:'scl_dsh',
                            _fnc:'search',
                            _vl: val_sch
                        },
                        _bs:function(){
                            $('.tend_li_form').addClass('_ldp');
                        },
                        _cm:function(){
                            $('.tend_li_form').removeClass('_ldp');
                        },
                        _cl:function(_r){

                            if(_r.f.tot > 0){
                                $('.fms').remove();
                                $.each(_r.f.o.d, function(k,v){

                                    if(!isN(v.mdl)){ var mdl = 'on'; }else{ var mdl = 'off'; }
                                    if(v.tot_qus == v.tot_qus_a){ var fld = 'on'; }else{ var fld = 'off'; }
                                    if(!isN(v.md.img_chk) && v.md.img_chk == 'ok'){ var md = 'on'; }else{ var md = 'off'; }
                                    if(v.ld >= v.ld_exd){ var ld = 'on'; }else{ var ld = 'off'; }
    
                                    
                                    $('#lstd_form').append('<li class=\"fms\" rel=\"'+v.id+'\">
                                                                <div class=\"mdl '+mdl+'\"></div>
                                                                <div style=\"background-image:url('+v.md.img+');\" class=\"md '+md+'\"></div>
                                                                <div class=\"nm\">
                                                                    <div class=\"n\">'+v.nm+'</div>
                                                                    <div class=\"lead\"> 
                                                                        <div class=\"'+ld+' ld\">
                                                                            '+v.ld+'/'+v.ld_exd+'
                                                                        </div>
                                                                    </div>
                                                                    <div id=\"_form_'+v.id+'\" class=\"flds '+fld+'\">'+v.tot_qus+' / <p style=\"display:inline-block;\" class=\"tot_qus_slc\">'+v.tot_qus_a+'</p></div>
                                                                    <div class=\"fchs fch_crd\">'+v.crd_tm+'</div>
                                                                    <div class=\"fchs fch_chk\">'+v.f_chk+'</div>
                                                                </div>
                                                            </li>');
                                });  
                                
                                $('.tend_li_form').remove();
                                $('.btn_mre ul').append('<li class=\"tend_li_form\"> <div class=\"load\"></div> <button data-pag=\"10\"> Cargas más </button> </li>');
                                
                                
                                SUMR_Scl.dom();
                            }else{
                                $('.tend_li_form').remove();     
                            }
                        }
                    });
                });

                $('.tend_li_form button').not('._ldp').off('click').click(function(){ 

                    var pg = $(this).attr('data-pag');
                    var val_sch = $('#cl_sch_').val();

                    SUMR_Scl.Rqu({
                        d:{
                            _tp:'scl_dsh',
                            _fnc:'forms',
                            _pg:pg,
                            _vl:val_sch 
                        },
                        _bs:function(){
                            $('.tend_li_form').addClass('_ldp');
                        },
                        _cm:function(){
                            $('.tend_li_form').removeClass('_ldp');
                        },
                        _cl:function(_r){

                            if(_r.f.tot > 0){
                                $.each(_r.f.o.d, function(k,v){

                                    if(!isN(v.mdl)){ var mdl = 'on'; }else{ var mdl = 'off'; }
                                    if(v.tot_qus == v.tot_qus_a){ var fld = 'on'; }else{ var fld = 'off'; }
                                    if(!isN(v.md.img_chk) && v.md.img_chk == 'ok'){ var md = 'on'; }else{ var md = 'off'; }
                                    if(v.ld >= v.ld_exd){ var ld = 'on'; }else{ var ld = 'off'; }
    
                                    $('#lstd_form').append('<li class=\"fms\" rel=\"'+v.id+'\">
                                                                <div class=\"mdl '+mdl+'\"></div>
                                                                <div style=\"background-image:url('+v.md.img+');\" class=\"md '+md+'\"></div>
                                                                <div class=\"nm\">
                                                                    <div class=\"n\">'+v.nm+'</div>
                                                                    <div class=\"lead\"> 
                                                                        <div class=\"'+ld+' ld\">
                                                                           '+v.ld+'/'+v.ld_exd+'
                                                                        </div>
                                                                    </div>
                                                                    <div id=\"_form_'+v.id+'\" class=\"flds '+fld+'\">'+v.tot_qus+' / <p style=\"display:inline-block;\" class=\"tot_qus_slc\">'+v.tot_qus_a+'</p></div>
                                                                    <div class=\"fchs fch_crd\">'+v.crd_tm+'</div>
                                                                    <div class=\"fchs fch_chk\">'+v.f_chk+'</div>
                                                                </div>
                                                            </li>');
                                });  
                                pdg = parseInt(pg)+10;
    
                                $('.tend_li_form button').attr('data-pag',pdg);
    
                                SUMR_Scl.dom();
                            }else{
                                $('.tend_li_form').remove();     
                            }
                        }
                    });
                });

                SUMR_Main.LsSch({ str:'#cl_sch_".$__Rnd."', ls:__sisslc_bx_cl_itm });

            },
            Rqu:function(p=null){
                var wrtry=1000,
                    rqt;

                if(!isN(p) && !isN(p.d) && !isN(p.d._tp)){ 
                    
                    rqt = '_'+p.d.tp;
                
                    if (SUMR_Main.onl() && isN( SUMR_Main.ibx['sclpnl_rq'+rqt] ) ){
                        
                        SUMR_Main.ibx['sclpnl_rq'+rqt] = $.ajax({
                                                            async:true,
                                                            type:'POST',
                                                            dataType: 'json',
                                                            url: '_cnt/_json/_gn.php?_t=scl',
                                                            data: !isN(p.d)?p.d:null,
                                                            timeout:20000,
                                                            tryCount:0,
                                                            retryLimit:3,
                                                            beforeSend: function() {
                                                                if(!isN(p._bs)){ p._bs(); }
                                                            },
                                                            error:function(e){
                                                                if(!isN(p._w)){ p._w(e); }
                                                            },
                                                            success:function(e){	
                                                                if(!isN(e.w)){ swal('Error!', e.w, 'error');  }
                                                                if(!isN(p) && !isN(p._cl)){ p._cl(e); }
                                                            },
                                                            complete:function(e){
                                                                SUMR_Main.ibx['sclpnl_rq'+rqt] = null;
                                                                if(!isN(p._cm)){ p._cm(e); }
                                                            },
                                                            error:function(r,s,e){

                                                                var _thisajx = this;

                                                                if(r.status == '401'){

                                                                    SUMR_Main.ui.lgagn({ 
                                                                        e:'o',
                                                                        c:function(){
                                                                            SUMR_Main.ibx['sclpnl_rq'+rqt] = $.ajax(_thisajx);
                                                                        } 
                                                                    });
                                                                
                                                                    return;
                                                                
                                                                }else if(s === 'timeout' || s == 'Gateway Timeout') {
                                                                    
                                                                    if(this.retryLimit > 1 && this.tryCount <= this.retryLimit) {
                                                        
                                                                        setTimeout(function(){ 
                                                                            SUMR_Main.ibx['sclpnl_rq'+rqt] = $.ajax(_thisajx);
                                                                        }, wrtry);
                                                        
                                                                        this.tryCount++;
                                                                        return;

                                                                    }else{

                                                                        _Rqu_Msg({ t:'w', d:SUMR_Ld.t.alrt_tmout });	

                                                                    }

                                                                }else if(s != 'abort') {
                                                                    
                                                                    _Rqu_Msg({ t:'w' });

                                                                }else{
                                                                    
                                                                    $('._col_new').removeClass('_col _new');

                                                                }
                                                                
                                                            }
                                                        });							
                    }
                }		
            },
            grph : { 
                id_start: '',
                rndr:function(p){
                    if(p.tp == 'grph_tp_1'){
                        SUMR_Grph.f.g1({ 
                            id: p.id,
                            tt: p.tt,
                            tt_sb: ' ',
                            c: p.c,
                            d: p.d,
                            tp: 'pie',
                            g_spc_t: 0,
                            g_h: 150,
                        });              
                    }else if(p.tp == 'grph_tp_2'){
                        SUMR_Grph.f.g2({ 
                            id: p.id,
                            tt: p.tt,
                            sbt: p.sbt,
                            d: p.d,
                            g_h: 230
                        });
                    }else if(p.tp == 'grph_tp_3'){
                    }else if(p.tp == 'grph_tp_4'){
    
                        SUMR_Grph.f.g4({ 
                            id: p.id,
                            c: p.c,
                            d: p.d,
                            tt: p.tt, 
                            tt_sb: p.sbt,
                            c_e: p.c_e
                        });
    
                    }else if(p.tp == 'grph_tp_5'){
                    }else if(p.tp == 'grph_tp_6'){
                    }else if(p.tp == 'grph_tp_7'){
                    }else if(p.tp == 'grph_tp_8'){
                        SUMR_Grph.f.g8({ 
                            id: p.id,
                            dt_lbl: true,
                            tt: p.tt,
                            tt_sb: ' ',
                            c: p.c,
                            d: p.d,
                        });
                    }else if(p.tp == 'grph_tp_9'){
    
                    }else if(p.tp == 'grph_tp_12'){
    
                        SUMR_Grph.f.g12({ 
                            id: p.id,
                            tt: p.tt,
                            d: p.d
                        });    
                    }
                },
                build:function(p){
                    SUMR_Scl.Rqu({
                        d:{
                            _tp:'scl_dsh',
                        },
                        _bs:function(){
                            $('.Dsh_Scl_Ld .TabbedPanelsTab._dsh').addClass('_ldp');
                        },
                        _cm:function(){
                            $('.Dsh_Scl_Ld .TabbedPanelsTab._dsh').removeClass('_ldp');
                        },
                        _cl:function(_r){

                            if( !isN(_r) && !isN(_r.d) ){
    
                                if(!isN(_r.d.e == 'ok')){
                                    
                                    if(!isN(_r.d.o)){

                                        var data=[];
    
                                        for(var k in _r.d.o){
                                            var v = _r.d.o[k];
                                            data.push(v);
                                        }

                                        if(!isN(data)){
                                            SUMR_Scl.grph.rndr({ 
                                                id: '#grph1',
                                                tt: 'Leads por día',
                                                sbt: 'Mes Actual',
                                                tp: 'grph_tp_4',
                                                c: !isN(_r.d.c)?_r.d.c:'',
                                                d: [{       
                                                    name: '',       
                                                    data: data 
                                                }]
                                            });
                                        }
    
                                    }

                                    if(!isN(_r.f.o)){
    
                                        $('#lstd_form').html('');

                                        $('#lstd_form').append('<li class=\"th_li_form\"> 
                                                                    <div class=\"nm\">
                                                                        <div class=\"n\">".HTML_inp_tx('cl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_anm btn_sch\"></button></div>
                                                                        <div class=\"lead\"></div>
                                                                        <div class=\"flds \"></div>
                                                                        <div class=\"fchs fch_crd\"></div>
                                                                        <div class=\"fchs fch_chk\"></div>
                                                                    </div>
                                                                </li>');
    
                                        $.each(_r.f.o.d, function(k,v){

                                            if(!isN(v.mdl)){ var mdl = 'on'; }else{ var mdl = 'off'; }
                                            if(v.tot_qus == v.tot_qus_a){ var fld = 'on'; }else{ var fld = 'off'; }
                                            if(!isN(v.md.img_chk) && v.md.img_chk == 'ok'){ var md = 'on'; }else{ var md = 'off'; }
                                            if(v.ld >= v.ld_exd){ var ld = 'on'; }else{ var ld = 'off'; }

                                            $('#lstd_form').append('<li class=\"fms\" rel=\"'+v.id+'\">
                                                                        <div class=\"mdl '+mdl+'\"></div>
                                                                        <div style=\"background-image:url('+v.md.img+');\" class=\"md '+md+'\"></div>
                                                                        <div class=\"nm\">
                                                                            <div class=\"n\">'+v.nm+'</div>
                                                                            <div class=\"lead\"> 
                                                                                <div class=\"'+ld+' ld\">
                                                                                   '+v.ld+'/'+v.ld_exd+'
                                                                                </div>
                                                                            </div>
                                                                            <div rel=\"'+v.tot_qus+'\" id=\"_form_'+v.id+'\" class=\"flds '+fld+'\">'+v.tot_qus+' / <p style=\"display:inline-block;\" class=\"tot_qus_slc\">'+v.tot_qus_a+'</p></div>
                                                                            <div class=\"fchs fch_crd\">'+v.crd_tm+'</div>
                                                                            <div class=\"fchs fch_chk\">'+v.f_chk+'</div>
                                                                        </div>
                                                                    </li>');
                                        }); 

                                        $('.btn_mre').html('');
                                        $('.btn_mre').append('<ul><li class=\"tend_li_form\"> 
                                                        <div class=\"load\"></div>
                                                        <button data-pag=\"10\"> Cargas más </button>
                                                    </li></ul>');

                                        SUMR_Scl.dom();
                                        
    
                                    }

                                    if(!isN(_r.fac.o)){

                                        var data=[];

                                        for(var k in _r.fac.o){
                                            var v = _r.fac.o[k];
                                            if(!isN(v.data)){
                                                data.push({ name:v.name, data:v.data, color: v.color });
                                            }
                                        }
                                        
                                        if(!isN(data)){
                                            
                                            SUMR_Grph.f.g1({ 
                                                id: '#grph2',
                                                c: !isN(_r.fac.c)?_r.fac.c:'',
                                                d: data,
                                                tt: 'Facultad', 
                                                tt_sb: 'por medio',
                                                c_e: true
                                            });
                                        }
                                    }

                                    if(!isN(_r.md.o)){
                                        
                                        SUMR_Main.ld.f.rtng( function(){ 

                                            $('#c2').html('').addClass('__col_'+_r.md.tot); 

                                            for(var k in _r.md.o.d){
                                                var v = _r.md.o.d[k];
                                                $('#c2').append('<div class=\"_cols\">
                                                                    <div class=\"card est_1\">
                                                                        <div class=\"_img\"><img src=\"'+v.img+'\"></div>
                                                                        <span>'+v.tot+'</span>
                                                                        <div class=\"star_ptj\">'+v.ptj.html+'</div>
                                                                    </div>
                                                                </div>');
                                                
                                                $(':radio.star').rating({ cancel: 'Cancel', cancelValue: '0' }); 
                                            }

                                        });  

                                    }

                                    
                                } 
                            }
                            
                            if(!isN(p) && !isN(p.c)){ p.c(); }
    
                        } 
                    });

                    
                },
                dom:function(p){
                    
                    $('#sort1').sortable({
                        placeholder: 'new-conten2'
                    }).disableSelection();
        
                    $('.DshSclMntr .cols .rows .col1, .DshSclMntr .cols .rows .col2').sortable({
                        connectWith: '.cols',
                        placeholder: 'new-conten1',
                        stop: function (event, ui) { 
                            SUMR_Scl.grph.build();
                        }
                    }).disableSelection();
        
                    $('.DshSclMntr .cols .rows').sortable({
                        connectWith: '.DshSclMntr .cols .rows',
                        placeholder: 'new-conten',
                        start: function(event, ui) {
        
                            ui.item.parent().addClass('_prc');
                            SUMR_Scl.grph.id_start = $(this).attr('id');
        
                        },
                        stop: function (event, ui) { 
        
                            var lgu = $('#'+SUMR_Scl.grph.id_start+' ._cols').length;
                            var tots = 100 / lgu;
                            $('#'+SUMR_Scl.grph.id_start+' ._cols').css('width', tots+'%');
                            $('#'+SUMR_Scl.grph.id_start).removeClass('_prc');
        
                            ui.item.parent().addClass('prc');
                            var lg = $('.prc > ._cols').length;
                            var tot = 100 / lg;
                            $('.prc ._cols').css('width', tot+'%');
                            ui.item.parent().removeClass('prc');
        
                            SUMR_Scl.grph.build();
        
                        }
    
                    }).disableSelection();
    
                    SUMR_Scl.grph.build({ c:(!isN(p)&&!isN(p.c))?p.c:null });
    
                    
                }
                
            },
            Shw:function(p){
				
				if(!isN(p) && !isN(p.o) && p.o =='ok'){

                    if(!isN(p.u)){ var __u = p.u; }else{ var __u = 'scl'; }
					
					_ldCnt({
						u:'_cnt/_dt/_gn.php?_t='+__u+'&_i='+SUMR_Scl.oid(), 
						pop:'ok',
						w:'700',
						h:'90%',
						cls:'SclDtlBx',
						ocls:function(){
							
						},
						_cl:function(){	
				
							SUMR_Scl.Rqu({
								d:{
									tp:'dt',
									enc:SUMR_Scl.oid(),
									fi:SUMR_Scl.bxajx.fi_tme
								},
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.d)){	
											SUMR_Scl.open = _r.d;
										}	
									}
								}
							});	
							
						}
						
					});
					
				}else{
					
				 
					
				}
				
			}
        };
		
    ";

    $CntWb .= "
            SUMR_Scl.grph.dom();
        ";
        
    

?>
<style>
    .DshSclMntr .lead{display:inline-block;width:80px;text-align:center}
    .DshSclMntr .lead span{display:inline-block}
    .DshSclMntr .ld{display:inline-block}
    .DshSclMntr .in{color:green}
    .DshSclMntr .out{color:red}
    .DshSclMntr .mdl{position:absolute;width:30px;height:30px;background-color:gray;top:15px;left:-35px;border-radius:50%;background-position:center;background-size:60% auto;background-repeat:no-repeat;background-image:url(<?php echo DMN_IMG_ESTR_SVG; ?>scl_form.svg)}
    .DshSclMntr .mdl.on{background-color:#64d788}
    .DshSclMntr .md{position:absolute;width:20px;height:20px;top:35px;left:-35px;border-radius:50%;background-repeat:no-repeat;background-position:center;background-size:65% auto;border:1px solid #bababa;background-color:#fff}
    .DshSclMntr .cols .rows ._cols ul li{position:relative;padding:10px 0}
    .DshSclMntr .fchs{font-size:11px;width:60px;color:#949494;display:inline-block;text-align:center}
    .DshSclMntr .fch_crd{top:10px}
    .DshSclMntr .fch_chk{top:40px}
    .DshSclMntr .flds.off{color:red}
    .DshSclMntr .flds.on{color:green}
    .DshSclMntr .flds{color:red;display:inline-block;width:50px;text-align:center}
    .DshSclMntr .md.on{background-size:100% auto!important}
    .DshSclMntr .nm .n{display:inline-block;width:calc(100% - 250px)}
    .DshSclMntr .th_li_form{padding:0!important}
    .DshSclMntr .th_li_form .lead{background-image:url(<?php echo DMN_IMG_ESTR_SVG; ?>leads.svg);height:30px;background-repeat:no-repeat;background-position:center;background-size:35% auto}
    .DshSclMntr .th_li_form input{border: 1px solid #f6f6f6;text-align:center;background-image:url(<?php echo DMN_IMG_ESTR_SVG; ?>search_bck.svg);background-position:right 5px center;background-size:15px auto;margin-bottom:5px;background-repeat:no-repeat;width:100%}
    .DshSclMntr .th_li_form .nm .n{ position: relative; }
    .DshSclMntr .th_li_form .nm .n .btn_sch{position: absolute;top: 0;right: 0;width: 30px;height: 37px;text-align: center;background-image: url(<?php echo DMN_IMG_ESTR_SVG; ?>search_bck.svg);background-position: right 5px center;background-size: 15px auto;background-repeat: no-repeat;border: 1px solid #e0e0e0;border-radius: 0px 5px 5px 0px;cursor: pointer; }
    .DshSclMntr .th_li_form .nm .n .btn_sch:hover{ background-size: 17px auto;background-color: #e0e0e0;}
    .DshSclMntr .th_li_form .flds{background-image:url(<?php echo DMN_IMG_ESTR_SVG; ?>fields.svg);height:30px;background-repeat:no-repeat;background-position:center;background-size:50% auto}
    .DshSclMntr .th_li_form .fch_crd{background-image:url(<?php echo DMN_IMG_ESTR_SVG; ?>fecha_in.svg);height:30px;background-repeat:no-repeat;background-position:center;background-size:35% auto}
    .DshSclMntr .th_li_form .fch_chk{background-image:url(<?php echo DMN_IMG_ESTR_SVG; ?>fecha_chk.svg);height:30px;background-repeat:no-repeat;background-position:center;background-size:35% auto}
    .DshSclMntr .off.ld{color:red}
    .DshSclMntr .nm{display:flex;align-items:center}
    .DshSclMntr .on.ld{color:green}
    .DshSclMntr .tend_li_form button{border:0;text-transform:uppercase;font-family:Economica;color:#fff;background-color:#a0a0a0;padding:7px 10px;margin:10px auto;display:block;cursor:pointer}
    .DshSclMntr .tend_li_form button:hover{background-color:var(--main-bg-color)}
    .DshSclMntr .tend_li_form._ldp{cursor:not-allowed!important}
    .DshSclMntr .tend_li_form._ldp button{cursor:not-allowed!important;pointer-events:none;color:#a0a0a0}
    .DshSclMntr .tend_li_form._ldp .load{border:3px solid #707070;border-radius:50%;border-top:2px solid #fff;border-left:2px solid #fff;border-right:2px solid #fff;border-bottom:2px solid #ffffff00;width:17px;height:17px;-webkit-animation:lder 2s linear infinite;animation:lder 2s linear infinite;position:absolute;left:48%;top:37%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}
    .slct .styled-select-bx label{display:none !important}
    .slct{width: 80%;margin: 0 auto; }
    .DshSclMntr .cols .rows ._cols .card ._img{ width: 50px;margin: 10px auto;display: block;height: 50px; }
    .DshSclMntr .cols .rows ._cols .card ._img img{ width: 100% }
    .DshSclMntr .cols .rows ._cols .card span{ font-size: 35px;}
    .star_ptj{position:relative;margin-top: 15px;}
    .star_ptj .__rtio{position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);-webkit-transform: translate(-50%, -50%);width: auto;}
    .star_ptj .__rtio div.rating-cancel, div.star-rating{width: 20px;height: 20px;}
    .star_ptj .__rtio div.rating-cancel a, div.star-rating a{ width:20px;}
</style>
