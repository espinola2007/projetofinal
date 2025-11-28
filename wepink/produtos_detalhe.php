<?php
include 'includes/header.php';
$id = $_GET['id'] ?? 0;
$produtos = json_decode(file_get_contents('data/produtos.json'), true);
$produto = null;

foreach ($produtos as $p) {
  if ($p['id'] == $id) {
    $produto = $p;
    break;
  }
}

if (!$produto) {
  echo "<p>Produto não encontrado!</p>";
  include 'includes/footer.php';
  exit;
}
?>

<h2><?php echo $produto['nome']; ?></h2>
<img src="<?php echo $produto['imagem']; ?>" width="200">
<p><?php echo $produto['descricao']; ?></p>
<p>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>

<form method="post" action="carrinho.php">
  <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
  <button type="submit" name="adicionar" class="btn">Adicionar ao Carrinho</button>
</form>

<?php include 'includes/footer.php'; ?>
