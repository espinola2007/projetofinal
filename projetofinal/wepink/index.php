<div class='grid'>
<?php include 'includes/header.php'; ?>

<section class="banner">
  <img class='banner-img' src='img/banner.jpg' alt='Banner'>

  <h2>Beleza que insPIRA!</h2>
  <p>Venha gastar seu dinheiro com produtos que nunca vão chegar na sua casa!</p>
  <a href="produtos.php" class="btn">Ver Produtos</a>
</section>
  



<div class='grid'>

<section class="produtos-home">
    <h2>Produtos em Destaque</h2>
    <div class="produtos-grid">
        <?php
        $produtos = json_decode(file_get_contents("data/produtos.json"), true);
        foreach ($produtos as $p):
        ?>
            <div class="card">
                <img src="<?= $p['imagem'] ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
                <h3><?= htmlspecialchars($p['nome']) ?></h3>
                <p>R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                <a class="btn" href="carrinho.php?add=<?= $p['id'] ?>" onclick="showToast('Produto adicionado!')">
                    Adicionar ao Carrinho
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
