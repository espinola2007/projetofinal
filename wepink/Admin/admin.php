<?php
include 'includes/header.php';
$jsonFile = 'data/produtos.json';
$produtos = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];


if (isset($_POST['salvar'])) {
    $novo = [
        "id" => count($produtos) > 0 ? end($produtos)['id'] + 1 : 1,
        "nome" => $_POST['nome'],
        "preco" => floatval($_POST['preco']),
        "descricao" => $_POST['descricao'],
        "imagem" => "img/" . $_POST['imagem']
    ];
    $produtos[] = $novo;
    file_put_contents($jsonFile, json_encode($produtos, JSON_PRETTY_PRINT));
    echo "<p style='color:green;'>Produto adicionado!</p>";
}


if (isset($_POST['editar'])) {
    foreach ($produtos as &$p) {
        if ($p['id'] == $_POST['id']) {
            $p['nome'] = $_POST['nome'];
            $p['preco'] = floatval($_POST['preco']);
            $p['descricao'] = $_POST['descricao'];
            $p['imagem'] = "img/" . $_POST['imagem'];
            break;
        }
    }
    file_put_contents($jsonFile, json_encode($produtos, JSON_PRETTY_PRINT));
    echo "<p style='color:green;'>Produto atualizado!</p>";
}


if (isset($_GET['excluir'])) {
    $idExcluir = $_GET['excluir'];
    $produtos = array_filter($produtos, fn($p) => $p['id'] != $idExcluir);
    file_put_contents($jsonFile, json_encode(array_values($produtos), JSON_PRETTY_PRINT));
    echo "<p style='color:red;'>Produto excluído!</p>";
}

$editar = null;
if (isset($_GET['editar'])) {
    foreach ($produtos as $p) {
        if ($p['id'] == $_GET['editar']) {
            $editar = $p;
            break;
        }
    }
}
?>

<h2>Painel Admin - WePink</h2>

<form method="post">
  <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
  <label>Nome:</label><br>
  <input type="text" name="nome" required value="<?php echo $editar['nome'] ?? ''; ?>"><br>
  <label>Preço:</label><br>
  <input type="number" step="0.01" name="preco" required value="<?php echo $editar['preco'] ?? ''; ?>"><br>
  <label>Descrição:</label><br>
  <textarea name="descricao"><?php echo $editar['descricao'] ?? ''; ?></textarea><br>
  <label>Imagem (nome do arquivo):</label><br>
  <input type="text" name="imagem" required value="<?php echo isset($editar['imagem']) ? basename($editar['imagem']) : ''; ?>"><br><br>
  <?php if ($editar): ?>
    <button type="submit" name="editar" class="btn">Atualizar</button>
    <a href="admin.php" class="btn">Cancelar</a>
  <?php else: ?>
    <button type="submit" name="salvar" class="btn">Cadastrar</button>
  <?php endif; ?>
</form>

<hr>
<h3>Produtos Cadastrados</h3>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Nome</th><th>Preço</th><th>Imagem</th><th>Ações</th></tr>
<?php foreach ($produtos as $p): ?>
<tr>
  <td><?php echo $p['id']; ?></td>
  <td><?php echo $p['nome']; ?></td>
  <td>R$ <?php echo number_format($p['preco'],2,',','.'); ?></td>
  <td><img src="<?php echo $p['imagem']; ?>" width="50"></td>
  <td>
    <a href="admin.php?editar=<?php echo $p['id']; ?>">✏️</a> |
    <a href="admin.php?excluir=<?php echo $p['id']; ?>" onclick="return confirm('Excluir?')">🗑️</a>
  </td>
</tr>
<?php endforeach; ?>
</table>

<?php include 'includes/footer.php'; ?>
