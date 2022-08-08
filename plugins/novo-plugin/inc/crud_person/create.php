<?php
    $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');
    
    if($conn === false){
        die("Erro: " . mysqli_connect_error());
    }
    
    $param_nome = $param_email = '';
    $param_status = 1;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $var_nome = trim($_POST['nome']);
        $var_email = trim($_POST['email']);
        
        $sql = "insert into wp_person(name, email_address, status) values (?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            
            mysqli_stmt_bind_param($stmt, 'ssi', $param_nome, $param_email, $param_status);
            
            $param_nome = $var_nome;
            $param_email = $var_email;
            
            if(mysqli_stmt_execute($stmt)){
                echo 'Registro gravado com sucesso!';
            }
        }
        
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    global $wp;
?>
<h1 class="wp-heading-inline">Create</h1>
<div id="col-left">
   <div class="col-wrap">
      <div class="form-wrap">
         <h2>Add New Person</h2>
         <form id="addtag" method="post" action="?page=create" class="validate">
            <div class="form-field form-required term-name-wrap">
               <label for="nome">Name</label>
               <input name="nome" id="tag-name" type="text" value="<?php echo $param_nome; ?>" size="40" minlength="5" required aria-required="true">
               <p>The name is how it appears on your contact.</p>
            </div>
            <div class="form-field term-slug-wrap">
               <label for="tag-slug">E-mail</label>
               <input name="email" id="tag-email" type="email" value="<?php echo $param_email; ?>" required>
               <p>Enter your email.</p>
            </div>
            <p class="submit">
               <input type="submit" name="submit" id="submit" class="button button-primary" value="Add New Person">		
               <input type="hidden" name="gravar" value="1">
               <span class="spinner"></span>
            </p>
         </form>
      </div>
   </div>
</div>