
<?php 

$_t3 = Php_Ls_Cln($__t3);
$_t2 = Php_Ls_Cln($__t2);

if(!isN($_t3)){
    $__t = $_t3;
}else{
    $__t = $_t2;
}

?>

<div class="cl_mdl_act_grd dsh_cnt">
    <?php echo h2('Grados'); ?>
    <div class="_c _c1 _anm _scrl">
        <div class="_wrp">
            <ul id="bx_mdlact_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>
        </div>
    </div>
</div>
<?php

$CntJV .= "	
    
var SUMR_Dsh_Mdl_Act_Grd = {
    mdlact:{}
}; 

function Dom_Rbld(){

    var __mdls_bx_mdlact_act_itm = $('#bx_mdlact_".$__Rnd." > li.itm ');
    
    __mdls_bx_mdlact_act_itm.not('.sch').off('click').click(function(){
    
        $(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
        var _id = $(this).attr('rel');

        _Rqu({ 
            t:'act_grd', 
            d:'mdl',
            est: est,
            _id_act : '".Php_Ls_Cln($__i)."',
            _id_mdl : _id,
            _t2 : '".$__t."', 
            _bs:function(){ $('.cl_mdl_act_grd').addClass('_ld'); },
            _cm:function(){ $('.cl_mdl_act_grd').removeClass('_ld'); },
            _cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ MdlActGrdSet(_r); } } } 
        });
        
    });	
    
    SUMR_Main.LsSch({ str:'#sch_mdlact_".$___Ls->id_rnd."', ls:__mdls_bx_mdlact_act_itm });
}

function MdlAct_Html(){
    var __mdls_bx_mdlact_act_itm = $('#bx_mdlact_".$__Rnd."');

    __mdls_bx_mdlact_act_itm.html('');
    __mdls_bx_mdlact_act_itm.append('<li class=\"sch\">".HTML_inp_tx('sch_mdlact_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');

    if(!isN(SUMR_Dsh_Mdl_Act_Grd.mdlact['ls'])){
        $.each(SUMR_Dsh_Mdl_Act_Grd.mdlact['ls'], function(k, v) { 
            if(!isN(v.est) && v.est >= 1){ var _cls = 'on'; }else{ var _cls = 'off'; }
            __mdls_bx_mdlact_act_itm.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
        });	
    }
    
    Dom_Rbld();	
}

function MdlActGrdSet(p){
    if( !isN(p) ){ 

        if( !isN(p.mdl.act) ){ 
            SUMR_Dsh_Mdl_Act_Grd.mdlact['ls'] = p.mdl.act.ls; 
            SUMR_Dsh_Mdl_Act_Grd.mdlact['tot'] = p.mdl.act.tot;
        }
        
        MdlAct_Html();
    }
}	
";

$CntWb .= " 

    _Rqu({ 
        t:'act_grd', 
        d: 'mdl',
        _id_act : '".Php_Ls_Cln($__i)."',
        _t2 : '".$__t."', 
        _cl:function(_r){
            if(!isN(_r)){ 
                MdlActGrdSet(_r);
            }
        } 
    });
";

?>

<style>

.cl_mdl_act_grd{ width: 50%; margin: 0 auto; display: block; }
.cl_mdl_act_grd ._c1{ width: 100%; }	
.cl_mdl_act_grd ._c ul .itm.off {-webkit-filter: grayscale(100%);filter: grayscale(100%);opacity: 0.5;color: black}
.cl_mdl_act_grd ._c ul .itm.on,
.cl_mdl_act_grd ._c ul .itm.off:hover {-webkit-filter: grayscale(100%);filter: grayscale(0%);opacity: 1;color: black;}
.cl_mdl_act_grd ._c ul.dls{ margin: 0px 0 0 0 !important; }
.cl_mdl_act_grd ._c ul .itm.on { border: 2px solid var(--second-bg-color) !important; }

</style>