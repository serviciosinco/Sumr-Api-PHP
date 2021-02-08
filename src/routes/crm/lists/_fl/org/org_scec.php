<?php 
																							
echo h2('Sector Economico');	
?>
    <div class="cl_org_scec_dsh dsh_cnt">
        <div class="_c _c1 _anm _scrl">
            <div class="_wrp">
                <ul id="bx_org_scec<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>
            </div>
        </div>
    </div>
<?php

$CntJV .= "	
        
    var SUMR_Dsh_Org_Scec = {
        orgscec:{},
        orgs_bx_scec : $('#bx_org_scec".$__Rnd."'),
        orgs_bx_scec_itm : $('#bx_org_scec".$__Rnd." > li.itm ')
    }; 

    function Dom_Rbld(){

        var __org_bx_scec_itm = $('#bx_org_scec".$__Rnd." > li.itm ');

        __org_bx_scec_itm.not('.sch').off('click').click(function(){
        
            $(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
            var _id = $(this).attr('rel');

            _Rqu({ 
                t:'org_scec', 
                d:'scec',
                est: est,
                _id_org : '".Php_Ls_Cln($__i)."',
                _id_scec : _id,
                _bs:function(){ $('.cl_org_scec_dsh').addClass('_ld'); },
                _cm:function(){ $('.cl_org_scec_dsh').removeClass('_ld'); },
                _cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ OrgScecSet(_r); } } } 
            });
            
        });	
        
        SUMR_Main.LsSch({ str:'#sch_orgscec_".$___Ls->id_rnd."', ls: __org_bx_scec_itm });
    }

    function OrgScec_Html(){

        var __org_bx_scec_itm = $('#bx_org_scec".$__Rnd."');

        __org_bx_scec_itm.html('');
        __org_bx_scec_itm.append('<li class=\"sch\">".HTML_inp_tx('sch_orgscec_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');

        if(!isN(SUMR_Dsh_Org_Scec.orgscec['ls'])){
            $.each(SUMR_Dsh_Org_Scec.orgscec['ls'], function(k, v) { 
                if(!isN(v.est) && v.est >= 1){ var _cls = 'on'; }else{ var _cls = 'off'; }

                if(!isN(v.img)){ var _img = v.img.th_50; }else{ var _img = ''; }

                __org_bx_scec_itm.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" >
                            <figure style=\"background-image:url('+_img+')\" class=\"_md\" ></figure>
                            <span>'+v.nm+'</span>
                        </li>');
            });	
        }
        
        Dom_Rbld();	
    }

    function OrgScecSet(p){

        if( !isN(p) ){ 

            if( !isN(p.org.scec) ){  

                SUMR_Dsh_Org_Scec.orgscec['ls'] = p.org.scec.ls; 
                SUMR_Dsh_Org_Scec.orgscec['tot'] = p.org.scec.tot;
            }
            
            OrgScec_Html();
        }
    }	
    ";

    $CntWb .= " 

        _Rqu({ 
            t:'org_scec', 
            _id_org : '".Php_Ls_Cln($__i)."',
            _cl:function(_r){
                if(!isN(_r)){ 
                    OrgScecSet(_r);
                }
            } 
        });
    ";

?>

<style>

.cl_org_grp_dsh ._c1{ width: 100%; }	
.cl_org_grp_dsh ._c ul .itm.off {-webkit-filter: grayscale(100%);filter: grayscale(100%);opacity: 0.5;color: black}
.cl_org_grp_dsh ._c ul .itm.on,
.cl_org_grp_dsh ._c ul .itm.off:hover {-webkit-filter: grayscale(100%);filter: grayscale(0%);opacity: 1;color: black;}
.cl_org_grp_dsh h2{ background-color: rgba(222, 222, 222, 0.7) !important; text-align: center; border-bottom: none !important; border-top: 1px solid #a7adb0; padding-top: 20px !important; padding-bottom: 20px !important; }
.cl_org_grp_dsh ._c ul.dls{ margin: 0px 0 0 0 !important; }

.lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width:5% !important; list-style-type: none !important; }
.cl_org_grp_dsh ._c ul .itm.on { border: 2px solid var(--second-bg-color) !important; }

.Ls_Rg .bx_tp {font-size: 11px;color: #aaa7a7 !important;}
.Ls_Rg .bx_tp {font-size: 11px;color: #aaa7a7;}

._c._c1._anm._scrl {width: 33%;margin: 0 auto;}

</style>