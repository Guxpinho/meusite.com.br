<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Sorteio de um número</h1>
    </header>

    <div class="sorteio">
        <form action="sorteio.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
            
            <br><br>

            <button type="submit">Sortear número</button>
        </form>
    </div>
    <nav>
        <img src="https://pegapromocao.com.br/wp-content/uploads/2022/09/Promocao-Nestle-e-Voce-Fort-Attacadista-e-Comper.jpg" alt="programação">
    </nav>
    <aside>
        <img src="https://pegapromocao.com.br/wp-content/uploads/2024/05/Promocao-Nestle-Faz-Bem-Ganhar-Toda-Hora.jpg" alt="">
    </aside>

</body>
</html>

