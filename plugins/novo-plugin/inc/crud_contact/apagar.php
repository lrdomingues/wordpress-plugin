<?php
echo '<div class="wrap">
            <div id="icon-options-general" class="icon32"><br></div>
            <h2>Delete Contact</h2>
          </div>';    
    $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');

    if($conn === false){
        die("Erro: " . mysqli_connect_error());
    }
    
    if(isset($_POST['id']) && !empty($_POST['id'])){
        
        $sql = 'delete from wp_contacts where id = ?';
        
        if($stmt = mysqli_prepare($conn, $sql)){
            
            $param_id = trim($_POST['id']);
            
            mysqli_stmt_bind_param($stmt, 'i', $param_id);
            
            if(mysqli_stmt_execute($stmt)){
                echo '<p>excluido!</p>';
                echo '<p><a href="https://lucasdomingues.eu1.alfasoft.pt/wp-admin/admin.php?page=list-contact">Voltar</a></p>';
            }
            
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }else{
        
        if(empty(trim($_GET['id']))){
            echo 'cliente não identificado.';
        }
        
    }
?>

<form action="?page=apagar-contact" method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
</form>