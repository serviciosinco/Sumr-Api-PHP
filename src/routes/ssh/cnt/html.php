<!-- Temporal
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<html>
	<body>
		
	
		<div id='btnra'>
			<button id="cnx" class="btn btn-secondary">Conectar</button>
			<button id="cnx" class="btn btn-secondary">ls</button>
			<button id="cnx" class="btn btn-secondary">close</button>
			<button id="cnx" class="btn btn-secondary">tp</button>
			<button id="cln" class="btn btn-secondary">Limpiar</button>
		</div>
	
		<form id="cmd" method="POST" > 
			<input type="text" id="comando" class="form-control" style="margin-top:9">
		</form>
	</body>
	
	<div id='trmnl' class="trmnl">
		
		<ul></ul>
	</div>
</html>

<!-- Temporal 
<script>
	

	$('#cnx').off('click').click(function(){
		__Rq({"tp":"conn"});
	});
	
	$('#cln').off('click').click(function(){
		$('#trmnl > ul').html('');
	});
		
	function __Rq(p=null){
		
		
		$.ajax({
		
		    type: 'POST',
		    url: "/process/",
		    data: { "tp":p.tp, "cmd":$("#comando").val() },
		    success: function(d){		
	            
	            if(d.e == 'ok'){
		            $.each( d.msj, function(k, v) {
					  $('#trmnl > ul').append(' <li>'+v+'</li> ');
					  $('#trmnl > ul').animate({ scrollTop: $('#trmnl')[0].scrollHeight}, 2000);
					});
	            }
	            else{  
	           		console.log('no se pudo');
	            }
	            
	        }
		});
	}
	
	p = Runtime.getRuntime().exec("ls");
	p.waitFor();
 
	  BufferedReader reader = 
	     new BufferedReader(new InputStreamReader(
	   p.getInputStream()));
	  String line = reader.readLine();
	  while (line != null) {
		line = reader.readLine();
  }

</script>

Temporal - Falta por pasar a archivo css 
<style>
	.trmnl{
		border: 1px solid #9bff00;
		width: 100%;
		height: 500px;
		margin-top: 1%;
		background-color: #444040;
		position: relative;
	}
	
	.trmnl > ul{
		width: 100%;
		height: 100%;
		margin-top: 15px;
		position: absolute;
		overflow: scroll;
	}
	
	.trmnl > ul > li{
		color:white;
		font-size: 13px;
	}
	
	#btnra{
		margin-top: 5%;
	}
	.cmd{
		margin-top: 25%;
	}
</style>


 
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
</head>     -->
<?php
	// ssh -i LightsailDefaultPrivateKey-us-east-1.pem ubuntu@54.167.81.46
	
	//$HOLA .= passthru('ls key');
	
	//echo system('ssh -i'.$HOLA.'ubuntu@54.167.81.46');
	//echo exec('ssh -i'.$HOLA.'ubuntu@54.167.81.46');
	$_ex = exec('cd key', $_out);
	$_ex2 = exec('ls', $_out2);
	echo print_r($_out, true);
	echo print_r($_out2, true);
	//echo exec('ssh -i LightsailDefaultPrivateKey-us-east-1.pem ubuntu@54.167.81.46');
	
	
//$rsp = passthru($c1,$c2);
 
	//print_r($rsp); 
	
?>
<!-- 
<body>
    <form action="prc.php" method="POST">
        <input type="text" id="c1" name="c1">
        <input type="text" id="c2" name="c2">
        <input type="submit" >
    </form>
</body>
</html> -->