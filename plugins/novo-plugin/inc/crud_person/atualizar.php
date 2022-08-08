<?php
    $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');

    if($conn === false){
        die("Erro: " . mysqli_connect_error());
    }
    
    $nome = $email = '';
    
    if(isset($_POST['id']) && !empty($_POST['id'])){
        
        $id = $_POST['id'];
        
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        
        $sql = 'update wp_person set name = ?, email_address = ? where id = ?';
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, 'ssi', $param_nome, $param_email, $param_id);
            
            $param_nome = $nome;
            $param_email = $email;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                //echo 'gravado!';
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }else{
        
        if(isset($_GET['id']) && !empty(trim($_GET['id']))){
            
            $id = $_GET['id'];
            
            $sql = "select * from wp_person where id = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                
                $param_id = trim($_GET['id']);
                
                if(mysqli_stmt_execute($stmt)){
                    
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if(mysqli_num_rows($result) == 1){
                        
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        $nome = $row['name'];
                        $email = $row['email_address'];
        
                    }else{
                        echo 'erro 1';
                    }
                }else{
                    echo 'erro 2';
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
    
    global $wp;
?>
<h1 class="wp-heading-inline">Update</h1>
<div id="col-left">
   <div class="col-wrap">
      <div class="form-wrap">
         <h2>Update Person</h2>
         <form id="addtag" method="post" action="?page=atualizar" class="validate">
            <div class="form-field form-required term-name-wrap">
               <label for="nome">Name</label>
               <input name="nome" id="tag-name" type="text" value="<?php echo $nome; ?>" size="40" minlength="5" required aria-required="true">
               <p>The name is how it appears on your contact.</p>
            </div>
            <div class="form-field term-slug-wrap">
               <label for="tag-slug">E-mail</label>
               <input name="email" id="tag-email" type="email" value="<?php echo $email; ?>" required>
               <p>Enter your email.</p>
            </div>
            <p class="submit">
               <input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar">		
               <input type="hidden" name="id" value="<?php echo $id; ?>">
               <a href="https://lucasdomingues.eu1.alfasoft.pt/wp-admin/admin.php?page=list">Voltar</a>
               <span class="spinner"></span>
            </p>
         </form>
      </div>
   </div>
</div>