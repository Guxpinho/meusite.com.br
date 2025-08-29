
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <title>Sobre Mim</title>
</head>
<body style="margin:0; padding:0; background-color:#f7f7f7; font-family: Arial, sans-serif; display:flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; text-align: center;">

    <img src="https://i.pinimg.com/1200x/7f/14/2a/7f142a000a550d032a9b1e57d142d2dd.jpg" alt="Foto de Perfil" width="300" height="300" style="border-radius: 50%; box-shadow: 0 0 15px rgba(0,0,0,0.3); margin-bottom: 20px;" />

    <h1 style="color: #333;">Olá, eu tenho 17 anos!</h1>
    <p style="max-width: 450px; color: #555; font-size: 18px; line-height: 1.5; margin: 0 15px 30px;">
         Estou aprendendo a programar em Front-end e Back-end. Estou animado para crescer e desenvolver projetos incríveis nesta área!
     </p>

    <?php
     require_once 'funcoes.php'; // Inclui a função conecta
    echo "<p style='color: green; font-weight: bold;'>Foi cadastrada com sucesso!!</p>";
    ?>

</body>
</html>




