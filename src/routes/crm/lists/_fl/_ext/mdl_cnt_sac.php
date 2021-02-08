<?php 

    if($___Ls->gt->pnl->e == 'ok'){

        $_slc_sac_cls = 'fll';
        $_sac_owl_c = 'true';
        $_sac_owl_itms = 8;

    }else{

        $_sac_owl_c = 'true';
        $_sac_owl_itms = 6;

        if(!isN($___Ls->gt->tra_col)){
            $_slc_sac_cls = 'colx2';     
        }else{
            $_slc_sac_cls = 'colx3';
        }
    }

?>
<div class="slc-sac <?php echo $_slc_sac_cls; ?>" id="slc_sac_<?php echo $___Ls->id_rnd; ?>" style="display:none;">
    
    <?php 
    
        if(isN($___Ls->gt->i)){

            /*echo HTML_inp_hd('mdlcnt_tracol', $___Ls->gt->tra_col);
            echo h2( TX_RSPNS, '__cmnt');
            echo LsUs('mdlcnt_traus','id_us', '' , '', 2, '', ["are" => "ok"] ); $CntWb .= JQ_Ls('mdlcnt_traus','');
            */

            if(!isN($__t2) && $__t2 == 'sac' ){ ?>
                <?php 
                    $TraColDt = GtTraColLs([ 'flt' => ' AND tracol_chk_pqr != 1' ]);
                    $StoreBrnd = GtStoreBrndLs();
                ?>
                <div class="task_detail">
                    <div class="sac-exst">Encontramos Tickets Abiertos Relacionados <button id="sac-shw-tckts">Ver Tickets</button></div>
                    <div class="slc-wrp">
                        <div class="pnl_col_brd">
                            
                            <?php if(isN($___Ls->gt->tra_col)){ ?>
                            <div class="opt">	
                                <?php echo h2( 'Columna', '__cmnt icn-col'); ?>
                                <?php $__id_cols_crs = 'opt-'.Gn_Rnd(20); ?>
                                <div id="<?php echo $__id_cols_crs; ?>" class="owl-carousel owl_col">
                                    <?php 
                                        
                                        $brnd_i=0;

                                        foreach($TraColDt->ls as $_k => $_v){
                                            echo '										
                                                <div class="item _anm ls_col col" data-id="'.$_v->enc.'" id="col_'.$_v->id.'" rel="'.$_v->id.'" style="background-color:'.$_v->clr->vl.'; background-image: url('.$_v->icn->slc->img.') ">
                                                    <p style="color:'.$_v->clr->vl.';">'.$_v->tt.'</p>
                                                </div>
                                            ';
                                            $brnd_i++;
                                        } 

                                        $__col_crsl = "SUMR_Main.ld.f.owl( function(){
                                                            $('#".$__id_cols_crs."').owlCarousel({
                                                                nav:true,
                                                                items:{$_sac_owl_itms},
                                                                center:{$_sac_owl_c},
                                                                loop:false
                                                            }).trigger('next.owl.carousel').trigger('next.owl.carousel');
                                                        });";
                                    ?>
                                </div>
                                <?php echo HTML_inp_hd('mdlcnt_tracol', ''); ?>

                            </div>
                            <?php }else{ ?>
                                <?php echo HTML_inp_hd('mdlcnt_tracol', $___Ls->gt->tra_col); ?>
                            <?php } ?>

                            <?php if($StoreBrnd->tot > 0){ ?>
                                <div class="opt">	
                                    <?php echo h2( 'Marca', '__cmnt icn-brnd'); ?>
                                    <?php $__id_brnd_crs = 'opt-'.Gn_Rnd(20); ?>
                                    <div id="<?php echo $__id_brnd_crs; ?>" class="owl-carousel owl_col">
                                        <?php 

                                            $ccol_i=0;

                                            foreach($StoreBrnd->ls as $__k=>$__v){
                                                if(!isN($__v->img->th_100)){ 
                                                    $_img_brnd='background-image: url('.$__v->img->th_100.');'; $_cls_brnd='';
                                                }else{ 
                                                    $_img_brnd=''; $_cls_brnd='empty';
                                                }

                                                echo '										
                                                    <div class="item _anm ls_brnd col '.$_cls_brnd.'" data-id="'.$__v->enc.'" id="brnd_'.$__v->id.'" rel="'.$__v->id.'" style="background-color:'.$__v->clr->vl.';'.$_img_brnd.' ">
                                                        <p style="color:'.$__v->clr->vl.';">'.$__v->nm.'</p>
                                                    </div>
                                                ';

                                                $ccol_i++;

                                            } 

                                        ?>
                                    </div>
                                    <?php echo HTML_inp_hd('mdlcnt_tra_sbrnd', ''); ?>
                                </div>
                                <?php 
                                    $__brnd_crsl = "
                                        SUMR_Main.ld.f.owl( function(){
                                            $('#".$__id_brnd_crs."').owlCarousel({
                                                nav:true,
                                                items:{$_sac_owl_itms},
                                                center:{$_sac_owl_c},
                                                loop:false
                                            }).trigger('next.owl.carousel').trigger('next.owl.carousel');
                                        });
                                    ";
                                ?>
                            <?php } ?>

                        </div>
                        <div class="opt">	
                            <?php
                                echo h2( TX_RSPNS, '__cmnt');
                                echo LsUs('mdlcnt_traus','id_us', '' , '', 2, '', ["are" => "ok"] ); $CntWb .= JQ_Ls('mdlcnt_traus',''); 
                            ?>
                        </div>
                    </div>
                    
                </div>
                
                <?php 

                    $CntWb .= "

                        $('.slc-sac .ls_col').off('click').click(function() {                       
                            var id = $(this).attr('data-id');
                            $('#mdlcnt_tracol').val(id);
                            $('.ls_col').removeClass('ok');
                            $(this).addClass('ok');
                            SUMR_Main.mdlcnt.f.sac_chk();
                        });

                        $('.slc-sac .ls_brnd').off('click').click(function() {                       
                            var id = $(this).attr('data-id');
                            $('#mdlcnt_tra_sbrnd').val(id);
                            $('.ls_brnd').removeClass('ok');
                            $(this).addClass('ok');
                            SUMR_Main.mdlcnt.f.sac_chk();
                        });

                        $('#mdlcnt_traus').change(function(){    
                            setTimeout(function(){ SUMR_Main.mdlcnt.f.sac_chk(); }, 1000);
                        });

                        setTimeout(function(){
                            {$__brnd_crsl}
                            {$__col_crsl}
                        }, 2000);
                        
                    ";
            
                ?>	
            <?php } 	
        }
        
    ?>
</div>