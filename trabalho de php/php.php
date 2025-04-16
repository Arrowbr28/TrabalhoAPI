<?php
if (!isset($_GET['cnpj'])) {
    header("Location: index.html");
    exit;
}

$cnpj = preg_replace('/\D/', '', $_GET['cnpj']); // Limpa o CNPJ para só números
$url = "https://www.receitaws.com.br/v1/cnpj/$cnpj";

$options = [
    "http" => [
        "header" => "User-Agent: PHP"
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Consulta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a href="index.html" class="voltar">← Nova Consulta</a>
        <?php if (isset($data['nome'])): ?>
            <h1><?= $data['nome'] ?></h1>
            <div class="info">
                <p><strong>CNPJ:</strong> <?= $data['cnpj'] ?></p>
                <br>
                <p><strong>Tipo:</strong> <?= $data['tipo'] ?></p>
                <br>
                <p><strong>Nome Fantasia:</strong> <?= $data['fantasia'] ?></p>
                <br>
                <p><strong>Situação:</strong> <?= $data['situacao'] ?></p>
                <br>
                <p><strong>Telefone:</strong> <?= $data['telefone'] ?></p>
                <br>
                <p><strong>Email:</strong> <?= $data['email'] ?></p>
                <br>
                <p><strong>Endereço:</strong> <?= "{$data['logradouro']}, {$data['numero']} - {$data['bairro']}, {$data['municipio']}/{$data['uf']}" ?></p>
            </div>
        <?php else: ?>
            <p class="error">Erro ao consultar o CNPJ. Tente novamente mais tarde.</p>
        <?php endif; ?>
    </div>
</body>
</html>
