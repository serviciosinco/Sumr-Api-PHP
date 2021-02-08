<?php

    use Firebase\JWT\JWT;

    class CRM_JWT{
    
        function __construct($p=NULL) { 
            $this->scrt = ENCRYPT_JWT;
	    }
	    
	    function __destruct(){
        }

        function set($p=NULL){

            if($p['sve']=='ok'){ 
				$expireson = time()+(10 * 365 * 24 * 60 * 60);
			}else{
				$expireson = time()+(3600 * 6);
            }
            
            $time = time();

            $token = [
                'iat'=>$time, // Tiempo que inició el token
                'exp'=>$expireson, // Tiempo que expirará el token (+1 hora)
                'data'=>[ // información del usuario
                    'id' => 1,
                    'name' => 'Eduardo'
                ]
            ];

            $jwt = JWT::encode($token, $this->scrt, 'HS256');
            return $jwt;
        
        }

        function get($p=NULL){

            try{
                $data = JWT::decode($p['tkn'], $this->scrt.'s', ['HS256']);
                return $data;
            }catch(Exception $e){                           
                return $e;
            }

        }

    }

?>