<?php

    /*
    @ini_set('display_errors', true);
    error_reporting(E_ALL);
    define('DSERR','on');
    */

    $_rsp['e'] = 'no';

    $cnt_id = Php_Ls_Cln($_POST['cnt_id']);
    $us_id = Php_Ls_Cln($_POST['us_id']);
    $roomName = Php_Ls_Cln($_POST['room']);

    $__vcall = $call->CallRoom_Chk([ 'unm'=>$roomName ]);

    $_rsp['tmp_vcall'] = $__vcall;

    if(!isN($cnt_id)){
        $identity = $cnt_id;
        $_rsp['user']['tp'] = 'cnt';
    }elseif(!isN($us_id)){
        $identity = $us_id;
        $_rsp['user']['tp'] = 'us';
    }

    if(!isN($identity) && !isN($roomName)){

        $room = _Vdo_Room_New([ 'roomNme'=>$roomName ]);

        if(!isN($room->sid)){

            $room_set = _Vdo_Room_Set([ 'usid'=>$identity, 'roomNme'=>$roomName ]);

            if($room_set->e == 'ok' && !isN($room_set->tkn)){

                $shrt = new CRM_Shrt();
		        $shrt->shrt_url = DMN_MEET.$__dt_cl->sbd.'/video/?room='.$__vcall->enc.'&_u=6362324b7653099e2ac7999b201389f2d35374d1';
                $__shrt = $shrt->get([ 'url'=>$shrt->shrt_url ]);

                if(!isN( $__shrt->url ) && !isN($cnt_id)){
                    $_rsp['wa']['api'] = Whtsp_Snd([
                                            //'to'=>'593963606242', // Cris
                                            //'to'=>'573043808678', // Cami
                                            'to'=>'573146406263', // Manu
                                            //'to'=>'573008403437', // Gus
                                            'msg'=>'Hola Manuel tienes una solicitud de videollamada comercial, para continuar inicia tu gestión en el siguiente link: '.$__shrt->url
                                        ]);
                }else{
                    $_rsp['w'] = 'No short url';
                }

                $_rsp['e'] = 'ok';
                $_rsp['token'] = $room_set->tkn;
                $_rsp['room']['name'] = $roomName;
                $_rsp['room']['sid'] = $room->sid;

            }

        }

    }

    Hdr_JSON();
	ob_start("compress_code");
    echo json_encode($_rsp);
    ob_end_flush();

?>