<?php
session_start();
$produtos = json_decode(file_get_contents('data/produtos.json'), true);

$carrinho = $_SESSION['carrinho'] ?? [];

$items=[];
$total=0;

foreach($carrinho as $id){
  foreach($produtos as $p){
    if($p['id']==$id){
      $items[]=$p;
      $total+=$p['preco'];
    }
  }
}
?>
<!DOCTYPE html><html><head><meta charset='utf-8'>
<link rel='stylesheet' href='css/style.css'>
<title>Checkout</title></head><body>
<h2>Checkout</h2>

<?php if(empty($items)): ?>
<p>Seu carrinho está vazio.</p>
<?php else: ?>
<?php foreach($items as $it): ?>
  <div class='item'>
    <img src='<?php echo $it['imagem']; ?>' width='80'>
    <span><?php echo $it['nome']; ?></span>
    <span>R$ <?php echo number_format($it['preco'],2,',','.'); ?></span>
  </div>
<?php endforeach; ?>

<h3>Total: R$ <?php echo number_format($total,2,',','.'); ?></h3>

<form method="post">
  <input type="text" name="nome" placeholder="Nome completo" required>
  <input type="text" name="endereco" placeholder="Endereço" required>
  <button type="submit">Finalizar Pedido</button>
</form>
<?php endif; ?>

<?php
if($_POST){
  $pedido=[
    "cliente"=>$_POST['nome'],
    "endereco"=>$_POST['endereco'],
    "total"=>$total,
    "itens"=>$items,
    "data"=>date("Y-m-d H:i:s")
  ];
  $file="data/pedidos.json";
  $all=[];
  if(file_exists($file)){
    $all=json_decode(file_get_contents($file),true);
  }
  $all[]=$pedido;
  file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT));
  echo "<p>Pedido realizado com sucesso!</p>";
  $_SESSION['carrinho']=[];
}
?>
</body></html>
