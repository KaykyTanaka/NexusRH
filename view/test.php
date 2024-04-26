<?php
  $banco = new PDO('mysql:host=localhost;dbname=rhdaz', 'root','1234');
  print "Conexão Efetuada com sucesso!";
  ?>
<?php
    //Nothing still
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/cssg.css">
    <title>Atividade Geometria</title>
    <script src="js/bootstrap.min.js"></script>
</head>
<body style="text-align: center; margin-top:6%;">
    
    <form method="post" action="">

    <input type="submit" value="Calcular" name="Enviar" class="btn btn-dark">
    </form>

    <?php
        $chamada = $banco->query("SELECT adm_email, adm_senha FROM adm_administradorRH;");

        while($linha = $chamada->fetch(PDO::FETCH_ASSOC)) {
            echo "Email: {$linha['adm_email']} - Senha: {$linha['adm_senha']} <br />";
        }
    ?>


</body>
</html>


