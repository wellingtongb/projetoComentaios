<?php
    
    try{
        $database = "mysql:dbname=projetoComentarios;host=localhost";
        $dbUser = "root";
        $dbPass = 'qwert1234';

        $pdo = new PDO($database, $dbUser, $dbPass);

    } catch(PDOException $e){
        echo "Falhou conexão: ".$e->getMessage();
        exit;
    }

    //verifica se existiu um evento de post
    if(isset($_POST['nome']) && !empty($_POST['nome'])){
        $nome = $_POST['nome'];
        $comentario = $_POST['comentario'];

        //$sql = $pdo->prepare("INSERT INTO comentarios SET nome = :nome, comentario = :comentario, datacomentario:NOW()");
        $sql = $pdo->prepare("INSERT INTO comentarios SET nome = :nome, comentario = :comentario, datacomentario = NOW()");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":comentario", $comentario);
        $sql->execute();
        
        //evitando o reenvio do formulario
        header("Location: index.php");
        //checando se o ultimo insert foi valido
        /* if($pdo->lastInsertId() > 0) {
            echo 'cadastrado com sucesso!';
          } else {
            echo 'Ocorreu um erro!';
          } */
        
    }

?>

<fieldset>
    <form method="POST">
        Nome: <br/>
        <input type="text" name="nome"/><br/><br/>
        Comentario: <br/>
        <textarea name="comentario"></textarea>  <br/><br/>
        <input type="submit" value="Enviar">
    </form>
</fieldset><br/><br/>



<?php
    $sql = "SELECT * FROM comentarios ORDER BY datacomentario DESC";
    $sql = $pdo->query($sql);

   if($sql->rowCount() > 0){
    foreach ($sql->fetchAll() as $comentario):
        $data_convertida = date('d/m/Y H:i:s', strtotime($comentario['datacomentario']));
        ?>
        <fieldset>
        <strong> <?php echo $comentario['nome'] ?> </strong> em <?php echo $data_convertida ?><br/><br/>
        <?php echo $comentario['comentario']; ?>
        </fieldset><br/>
        <?php
    endforeach;
   } else{
       echo "Não há mensagens!.";
   }
?>