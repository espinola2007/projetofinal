<?php include 'includes/header.php'; ?>

<h2>Contato</h2>

<p><strong>Telefone:</strong> (16) 1234-567</p>
<p><strong>Email:</strong> wepinkhelp@gmail.com</p>

<?php
$dataFile = 'data/contatos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    if (!file_exists($dataFile)) {
        file_put_contents($dataFile, json_encode([]));
    }

    $lista = json_decode(file_get_contents($dataFile), true);
    $lista[] = [
        'nome' => $nome,
        'email' => $email,
        'mensagem' => $mensagem,
        'data' => date('Y-m-d H:i:s')
    ];

    file_put_contents($dataFile, json_encode($lista, JSON_PRETTY_PRINT));
    echo '<p style="color:green;">Mensagem enviada com sucesso!</p>';
}
?>

