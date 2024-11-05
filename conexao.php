<?php

$conn = new mysqli("localhost", "usuario", "senha", "longavida_db");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plano = $_POST['plano'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

   
    $sql = "INSERT INTO associado (plano, nome, endereco, cidade, estado, cep) 
            VALUES ('$plano', '$nome', '$endereco', '$cidade', '$estado', '$cep')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "Novo associado cadastrado com sucesso!";
    } else {
        $mensagem = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$planos_sql = "SELECT numero, descricao FROM plano";
$planos_result = $conn->query($planos_sql);

$associados_sql = "SELECT a.plano, a.nome, a.endereco, a.cidade, a.estado, a.cep, p.descricao 
                   FROM associado a 
                   JOIN plano p ON a.plano = p.numero";
$associados_result = $conn->query($associados_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Longa Vida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        form input, form select, form button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .message {
            padding: 15px;
            background-color: #e7f5e7;
            color: green;
            border: 1px solid #c3e6c3;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .error {
            padding: 15px;
            background-color: #f8d7da;
            color: red;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Associados - Longa Vida</h1>

        <?php if (isset($mensagem)) { ?>
            <div class="message"><?php echo $mensagem; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <h2>Cadastro de Novo Associado</h2>
            <label for="plano">Plano:</label>
            <select name="plano" id="plano" required>
                <?php
                if ($planos_result->num_rows > 0) {
                    while ($row = $planos_result->fetch_assoc()) {
                        echo "<option value='".$row['numero']."'>".$row['descricao']."</option>";
                    }
                }
                ?>
            </select>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" required>

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidade" required>

            <label for="estado">Estado (UF):</label>
            <input type="text" name="estado" id="estado" maxlength="2" required>

            <label for="cep">CEP:</label>
            <input type="text" name="cep" id="cep" maxlength="9" required>

            <button type="submit">Cadastrar Associado</button>
        </form>

        <h2>Associados Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Plano</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>CEP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($associados_result->num_rows > 0) {
                    while ($row = $associados_result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['descricao']."</td>
                                <td>".$row['nome']."</td>
                                <td>".$row['endereco']."</td>
                                <td>".$row['cidade']."</td>
                                <td>".$row['estado']."</td>
                                <td>".$row['cep']."</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum associado cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
