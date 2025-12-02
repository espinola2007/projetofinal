<?php
include 'includes/header.php';
$produtos = json_decode(file_get_contents('data/produtos.json'), true);
?>
<section class="produtos-page">
    <h2>Produtos</h2>
    <div class="produtos-grid">
        <?php foreach ($produtos as $p): ?>
            <div class="card">
                <img src="<?php echo $p['imagem']; ?>" alt="<?php echo htmlspecialchars($p['nome']); ?>">
                <h3><?php echo htmlspecialchars($p['nome']); ?></h3>
                <p>R$ <?php echo number_format($p['preco'],2,',','.'); ?></p>
                <a class="btn" href="carrinho.php?add=<?php echo $p['id']; ?>" onclick="showToast('Produto adicionado!')">Adicionar ao Carrinho</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>

