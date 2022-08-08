<?php
    $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');

    if($conn === false){die("Erro: " . mysqli_connect_error());}
    
    $country_code = $number = '';
    
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id = $_POST['id'];
        
        $id_person = trim($_POST['id_person']);
        $country_code = trim($_POST['country_code']);
        $number = trim($_POST['number']);
        
        $sql = 'update wp_contacts set country_code = ?, number = ? where id = ?';
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, 'ssi', $param_country_code, $param_numer, $param_id);
            
            $param_id_person = $id_person;
            $param_country_code = $country_code;
            $param_id = $id;
            $param_numer = $number;
            
            if(mysqli_stmt_execute($stmt)){
                //echo 'gravado!';
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }else{
        
        if(isset($_GET['id']) && !empty(trim($_GET['id']))){
            
            $id = $_GET['id'];
            
            $sql = "select * from wp_contacts where id = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                
                $param_id = trim($_GET['id']);
                
                if(mysqli_stmt_execute($stmt)){
                    
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if(mysqli_num_rows($result) == 1){
                        
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        $country_code = $row['country_code'];
                        $number = $row['number'];
        
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
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    <body>
        <h1 class="wp-heading-inline">Update</h1>
        <script>
            $(document).ready(function () {
                var countriesList = 'https://restcountries.com/v2/all';
                
                $(".country").select2({
                  ajax: {
                    type: 'GET',
                    url: countriesList,
                    dataType: 'json',
                    success: function(response) {
                        $("select").select2({
                          data: response.map(e => ({
                            id: e.name,
                            text: e.name + " (" + e.callingCodes + ")"
                          })),
                          width: 300,
                          dropdownAutoWidth: true
                        });
                    },
                    error: function() {},
                    complete: function() {}
                  }
                });
            });
        </script>
        <div id="col-left">
           <div class="col-wrap">
              <div class="form-wrap">
                 <h2>Update Contact</h2>
                 <form id="addtag" method="post" action="?page=atualizar-contact" class="validate">
                    <div class="form-field form-required term-name-wrap">
                        <div class="form-field term-parent-wrap">
                           <label for="id_person">Person</label>
                            <?php 
                                $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');
                                $query = $conn->query("select id, name from wp_person"); 
                            ?>
                            <select name="id_person" id="id_person" class="postform">
                                <?php 
                                    while($reg = $query->fetch_array()) { ?>
                                        <option value="<?php echo $reg['id'];?>"><?php echo $reg['name'];?></option>
                                <?php } ?>
                            </select>
                           <p>Choose the person associated with this new contact.</p>
                        </div>
                       <label for="tag-country_code">Country Code</label>
                       <select name="country_code" class="country" id="country" style="width:200px">
                       </select>
                       <p>The name is how it appears on your contact.</p>
                    </div>
                    <div class="form-field term-slug-wrap">
                       <label for="tag-number">Number</label>
                       <input name="number" id="tag-number" type="text" value="<?php echo $number; ?>" style="width:200px" maxlength="9" required>
                       <p>Please provide contact number.</p>
                    </div>
                    <p class="submit">
                       <input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar">
                       <a href="https://lucasdomingues.eu1.alfasoft.pt/wp-admin/admin.php?page=list-contact">Voltar</a>
                       <input type="hidden" name="id" value="<?php echo $id; ?>">
                       <span class="spinner"></span>
                    </p>
                 </form>
              </div>
           </div>
        </div>
        
    </body>
</html>