<?php
	Hdr_HTML();
	ob_start("compress_code");
?>
<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Your Website</title>
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
</head>

<body>

    <h1>WEBSOCKET</h1>

    <ul class="messages">

    </ul>

    <script>

        const _wsio = io.connect('wss://server.massivespace.rocks');

        var onevent = _wsio.onevent;

        _wsio.onevent = function (packet) {
            var args = packet.data || [];
            onevent.call (this, packet);
            packet.data = ["*"].concat(args);
            onevent.call(this, packet);
        };

        _wsio.on('connect', ()=>{
            console.log('Connnect 1');

            _wsio.on('disconnect', ()=>{
                _wsio.open();
            });

            _wsio.on("*",function(event,data) {
                if(data.type == 'new_message' || data.type == 'new_channel' || data.type == 'message_delivered'){
                    $('ul.messages').prepend('<li><h2>Channel: '+data.entity.channel+'</h2><strong>'+data.entity.origin_id+' envia mensaje </strong>' + data.entity.text + ' <span style="color:#ccc;"> a ' + data.recipient+' </span> </li>');
                    console.log(event);
                    console.log(data);
                }
            });

        });




    </script>

</body>

</html>
<?php ob_end_flush(); ?>