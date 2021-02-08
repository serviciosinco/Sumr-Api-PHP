<?php
 	
    $__id_bx = 'FmBx'.$__id_rnd;
    $__id_fm = 'FmVtex'.$__id_rnd;
    $__id_fm_btn = 'FmVtexBtn'.$__id_rnd;
    $__me = Php_Ls_Cln($_GET['me']);

    if( ChckSESS_cnt() ){

        header('Location:/'.$_pm_module.'/');

    }else{ ?>
    
        <?php 
            if(!isN($__me)){ 
                $__ins_dt = GtVtexCmpgInsDt([ 't'=>'enc', 'id'=>$__me, 'bd'=>$__cl->bd ]);
            }
        ?>

        <section class="section login">
            <div class="_wrp">
                <div class="sld">
                    <div class="col1"></div>
                    <div class="col2">
                        <div class="__fm" style="opacity:0;" id="<?php echo $__id_bx ?>">	
                            
                            <h1 class="_msjrs">Texto error</h1>
                                
                            <form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off" class="<?php if($__fm->shw->sch=='ok'){ echo '__sch'; } ?>">
                                <div class="loader"></div> 
                                <?php echo HTML_inp_hd('____key', $__id_rnd); ?>
                                <?php echo HTML_inp_hd('____cl', $__cl->enc); ?>
                                <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
                                <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>

                                <div id="<?php echo $__id_fm ?>_flds" class="_flds">

                                    <p class="text">LOGIN</p>

                                    <div class="_ln cx1"> 
                                        <div class="_fd">
                                            <?php echo _HTML_Input('Cnt_Eml'.$__id_rnd, 'Correo', ( !isN($__ins_dt->cnt->eml)?$__ins_dt->cnt->eml:'' ) , FMRQD, 'email', ['ac'=>'name']); ?>
                                        </div> 
                                    </div>
                                    
                                    <div class="_ln cx1"> 
                                        <div class="_fd">
                                            <?php echo _HTML_Input('Cnt_Pss'.$__id_rnd, 'Contraseña', '', FMRQD, 'password', ['ac'=>'name']); ?>
                                        </div>
                                    </div>

                                    <div class="_btn_snd">	
                                        <button class="pin" id="<?php echo $__id_fm_btn ?>" name="<?php echo $__id_fm_btn ?>"><?php echo 'Ingresar'; ?></button>
                                    </div>
                                
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php }

    if (Dvlpr()){
        $_CntJQ_Vld .= " 
            var ___cl = '".$_sbdo."';
            var ___cl2 = '".$_sbdo."/';
        ";     
    }else{
        $_CntJQ_Vld .= " 
            var ___cl = ''; 
            var ___cl2 = '';
        ";
    }

    $_CntJQ_Vld .= "
    
        $('.pin').off('click').click(function(e){

            e.preventDefault();

            $.ajax({
                type:'POST',
                url: ___cl2+'".$_pm_module."/process/login/',
                data: $('#".$__id_fm."').serialize(),
                dataType: 'json',
                beforeSend: function() { 
                    $('.__fm').addClass('_ld');
                },
                complete:function(e){
                    $('.__fm').removeClass('_ld');
                },
                success:function(r){	
                    if(r.e == 'ok'){
                        location.href = ___cl+'/".$_pm_module."/'      
                    }else{
                        swal('Error al intertar ingresar', 'Por favor confirma tus datos', 'error');
                    }
                }
            });
        });
	"; 
?>