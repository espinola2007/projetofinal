<?php
session_start();
include 'includes/header.php';

$produtos = json_decode(file_get_contents('data/produtos.json'), true);

if (!isset($_SESSION['carrinho'])) $_SESSION['carrinho']=[];

if (isset($_GET['add'])) {
  $id = intval($_GET['add']);
  $_SESSION['carrinho'][] = $id;
  
}


if(isset($_GET['del'])){
  $i=intval($_GET['del']);
  unset($_SESSION['carrinho'][$i]);
  $_SESSION['carrinho']=array_values($_SESSION['carrinho']);
}

echo "<h2>Seu Carrinho</h2>";

if (empty($_SESSION['carrinho'])) {
  echo "<p>O carrinho está vazio.</p>";
} else {
  $total = 0;
  foreach ($_SESSION['carrinho'] as $i=>$id) {
    foreach ($produtos as $p) {
      if ($p['id'] == $id) {
        echo "<div class='item'>
                <img src='{$p['imagem']}' width='70'>
                <span>{$p['nome']} - R$ ".number_format($p['preco'],2,',','.')."</span>
                <a href='carrinho.php?del=$i'>Remover</a>
              </div>";
        $total += $p['preco'];
      }
    }
  }
  echo "<h3>Total: R$ " . number_format($total,2,',','.') . "</h3>";
  echo "<a class='btn' href='checkout.php'>Finalizar Compra</a>";
}

include 'includes/footer.php';
?>