<?php 

    $__id_bx = 'FmBx'.$__id_rnd;
    $__id_fm = 'FmVtex'.$__id_rnd;
    $__id_fm_btn = 'FmVtexBtn'.$__id_rnd;

    $__me = Php_Ls_Cln($_GET['me']);

    if( !ChckSESS_cnt() ){
        
        if(!isN($__me)){ $_prm='?me='.$__me; }
        header('Location:/'.$_pm_module.'/login/'.$_prm);   

    }else{

        if(!isN($__cmpg_dt->enc)){
            $__ins_dt = GtVtexCmpgInsDt([ 't'=>'cnt', 'id'=>$__cnt->id, 'bd'=>$__cl->bd, 'cmpg'=>$__cmpg_dt->id ]);
        }

        if (Dvlpr()){
            $_CntJQ .= " 
                if(!SUMR_Ld.f.isN( SUMR_Vtex )){
                    SUMR_Vtex.d.cnt = '".$__cnt->enc."'; 
                    SUMR_Vtex.d.module = '".$_sbdo."/".$_pm_module."';
                    SUMR_Vtex.d.cmpg.on.id = '".$__cmpg_dt->enc."';
                    SUMR_Vtex.d.cmpg.on.mnd = '".$__cmpg_dt->vlr->mnd."';
                    SUMR_Vtex.d.ins.id = '".$__ins_dt->enc."'; 
                    SUMR_Vtex.rnd = '".$__id_rnd."';
                }
            ";   
        }else{
            $_CntJQ .= " 
                if(!SUMR_Ld.f.isN( SUMR_Vtex )){
                    SUMR_Vtex.d.cnt = '".$__cnt->enc."'; 
                    SUMR_Vtex.d.module = '".$_pm_module."';
                    SUMR_Vtex.d.cmpg.on.id = '".$__cmpg_dt->enc."';
                    SUMR_Vtex.d.cmpg.on.mnd = '".$__cmpg_dt->vlr->mnd."';
                    SUMR_Vtex.d.ins.id = '".$__ins_dt->enc."'; 
                    SUMR_Vtex.rnd = '".$__id_rnd."';
                }
            ";
        }
?>
<section class="section dashboard">
    <div class="_wrp">
        <div class="tt_dsh"></div>
            <div class="__fm" style="opacity:0;" id="<?php echo $__id_bx ?>">
                <div class="sld">
                    <div class="col1">
                        <!--<div class="cmpg_nm">
                            <?php //echo $__cmpg_dt->nm; ?>
                            Tu código de descuento es
                            <button class="cpy _anm" id="cpon_main<?php echo $__id_rnd ?>"></button>
                        </div>-->
                        <form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>">
                            <?php
                                if(!isN($__cmpg_dt->enc)){
                                        echo HTML_inp_hd('____key', $__id_rnd);
                                        echo HTML_inp_hd('____tp', 'new_rfd'); 

                                        echo HTML_inp_hd('Cnt_VtexIns'.$__id_rnd, $__ins_dt->enc);
                                        echo HTML_inp_hd('Cnt_VtexCmpg'.$__id_rnd, $__cmpg_dt->enc); 
                                    ?>
                                        <a href="#tit<?php echo $__id_rnd ?>" id="ancla<?php echo $__id_rnd ?>" class="ancla"></a>
                                        <div class="table">
                                            <div class="_rows _rdms">
                                                <div class="_row tt __col_4">
                                                    <div class="__col col_2">Nombres</div>
                                                    <div class="__col col_3">Email</div>
                                                    <div class="__col col_4">Código</div>
                                                    <div class="__col col_5">Redimir</div>
                                                </div>
                                                <div id="bx_rgsrfds_<?php echo $__id_rnd ?>"></div>
                                            </div>
                                            <div id="tit<?php echo $__id_rnd ?>" class="cnts ing"> 
                                                <button id="insert<?php echo $__id_rnd ?>" class="btn-insert"> Insert </button>
                                            </div>
                                        </div> 
                                    <?php

                                        $_CntJV .= " 

                                            var _ldr = $('#".$__id_fm."_ld');
                                            var _fm = $('#".$__id_fm."');
                                            var _fmflds = $('#".$__id_fm."_flds');
                                            var _fmrsl = $('#".$__id_fm."_rsl');
                                            
                                        ";

                                        $_CntJQ_S2 .= "if(!SUMR_Ld.f.isN( SUMR_Vtex )){ SUMR_Vtex.rfd.get(); } ";

                                }else{

                                    ?>
                                        <div class="table">
                                            <div class="_rows __url">
                                                <div class="_row tt __col_4">
                                                    <div class="__col col_1">#</div>
                                                    <div class="__col col_2">Nombres</div>
                                                    <div class="__col col_3">Ir</div>
                                                </div>
                                                <div id="bx_rgsrfds_<?php echo $__id_rnd ?>"></div>
                                            </div>
                                        </div> 
                                    <?php $_CntJQ_S2 .= "if(!SUMR_Ld.f.isN( SUMR_Vtex )){ SUMR_Vtex.cmpg.get(); }";      
                                }  
                            ?>
                        </form>
                    </div>
                    <div class="col2">
                        
                        <?php if(!isN($__cmpg_dt->enc)){ ?>
                            <div id="cont_ref_<?php echo $__id_rnd; ?>" class="conte"></div>
                        <?php } ?>
                    </div>      
                    <div class="col3">
                        <div class="conte perfil">
                            <div class="avatar"></div>
                            <div class="info">
                                <ul>
                                    <li> <i class="nm"></i><span><?php echo $__cnt->nm.' '.$__cnt->ap; ?></span></li>   
                                    <li> <i class="dc"></i><span><?php echo $__cnt->dc; ?></span></li> 
                                    <li> <i class="eml"></i>
                                        <?php 
                                            foreach ($__cnt->eml->ls as $key => $value) {
                                                echo '<span class="data">'.$value.'</span>';
                                                break;
                                            }
                                        ?>
                                    </li>
                                    <!--<li><button id="close_log<?php echo $__id_rnd; ?>" class="lgout">Cerrar Sesión</button></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>  
                </div>    
            </div>
        </div>
    </section>
    <div class="cpyCb" id="ccpy_bx<?php echo $__id_rnd; ?>"></div>
    <script>

        

    </script>
<?php } ?>