<?php
	if(class_exists('CRM_Cnx') ){

        $Dt_Qry = sprintf(" SELECT ecsndhtml_html, ecsndhtml_enc FROM ".TB_EC_SND." INNER JOIN ".TB_EC_SND_HTML." ON ecsndhtml_ecsnd = id_ecsnd WHERE ecsnd_enc = %s LIMIT 1", GtSQLVlStr($___Dt->gt->i, "text"));

        $Ls_Rg = $__cnx->_qry($Dt_Qry); 
	
	    if($Ls_Rg){
		
		    $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
		
		    if($Tot_Ls_Rg > 0){ 

                $_id = str_replace('LsFls_ec_', '', Php_Ls_Cln($_GET['_bx']));
                $_get = str_replace('LsFls_', '', Php_Ls_Cln($_GET['_bx']));

                ?>
                    <div class="">
                        <p id="bck_<?php echo $_get; ?>" class="click">Atras</p>
                    </div>
                <?php

                $CntWb .= "
    
                    function TbGrp_".$_get."_go(p) {
                        var __mre = '';
                        if (!isN(p) && !isN(p.mre)) {
                            var __mre = p.mre;
                        }
                        if (!isN(p) && !isN(p.o)) {
                            var __clc = p.o;
                        } else {
                            var __clc = '';
                        }
                        if (!isN(SUMR_Main.bxajx._LsFls_".$_get.")) {
                            $('#TbGrp_".$_get."').addClass('_ldp');
                            _ldCnt({
                                u: SUMR_Main.bxajx._LsFls_".$_get." + __mre,
                                c: 'LsFls_".$_get."',
                                ldr: '_m_ldr_pop_".$_id."',
                                _cl: function() {
                                    if (!isN(__clc)) {
                                        __clc.removeClass('_ldp');
                                    }
                                    setTimeout(function() {
                                        $('#TbGrp_".$_get."').removeClass('_ldp');
                                    }, 1000);
                                }
                            });
                        }
                        $('#Tt_Tb_CNT_".$_id."').addClass('_disabled');
                        if (!isN(SUMR_Main.bxajx.__cvr)) {
                            if (SUMR_Main.bxajx.__cvr.length > 0) {
                                SUMR_Main.bxajx.__cvr.delay(300).show();
                                $('#').addClass('_cmpct');
                                if (SUMR_Main.bxajx.__cvr_if.length) {
                                    SUMR_Main.bxajx.__cvr_if.height(130);
                                }
                            }
                        }
                    }
                    
                    $('#bck_".$_get."').off('click').on('click', function(e) {
                        e.preventDefault();
                        TbGrp_".$_get."_go({
                            o: $(this)
                        });
                    });
                ";

                $___ec_html = $_aws->_s3_get([ 'b'=>'fle', 'lcl'=>'ok', 'gcnt'=>'ok', 'fle'=> _TmpFixDir(DIR_FLE_EC_SND.$row_Ls_Rg['ecsndhtml_enc'].'.html') ]);
          
                $_img = DMN_TRCK.PXLNM;
                $_hmtl = str_replace($_img, "#", $___ec_html->html);
                echo $_hmtl;

            }

        }	

    } 

?>
<style>

    .click{ 
        background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>back.svg);
        cursor: pointer;
        height: 25px;
        width: 90px;
        opacity: 0.5;
        background-repeat: no-repeat;
        padding-left: 27px;
        padding-top: 2px;
        font-size: 13px !important;
        margin-left: 24px !important;   
    } 

    .click:hover{
        opacity: 1;    
    }   

</style>