<?php
    $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');
    
    if($conn === false){
        die("Erro: " . mysqli_connect_error());
    }
    
    $param_id_person = $param_country_code = $param_number = '';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $var_id_person = trim($_POST['id_person']);
        $var_country_code = trim($_POST['country_code']);
        $var_number = trim($_POST['number']);
        
        $sql = "insert into wp_contacts(id_person, country_code, number) values (?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            
            mysqli_stmt_bind_param($stmt, 'iss', $param_id_person, $param_country_code, $param_number);
            
            $param_id_person = $var_id_person;
            $param_country_code = $var_country_code;
            $param_number = $var_number;
            
            if(mysqli_stmt_execute($stmt)){
                echo 'gravado!';
            }
        }
        
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    global $wp;
?>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    <body>
        <h1 class="wp-heading-inline">Create</h1>
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
                            id: e.name + " (" + e.callingCodes + ")",
                            text: e.name + " (" + e.callingCodes + ")",
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
                 <h2>Add New Contact</h2>
                 <form id="addtag" method="post" action="?page=create-contact" class="validate">
                    <div class="form-field form-required term-name-wrap">
                        <div class="form-field term-parent-wrap">
                           <label for="id_person">Person</label>
                            <?php 
                                $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');
                                if(isset($_GET['id_person']) && !empty($_GET['id_person'])){
                                    $query = $conn->query("select id, name from wp_person where id = ".$_GET['id_person']);
                                }else{
                                    $query = $conn->query("select id, name from wp_person");
                                }
                            ?>
                            <select name="id_person" id="id_person" class="postform">
                                <?php 
                                    while($reg = $query->fetch_array()) { ?>
                                        <option value="<?php echo $reg['id'];?>"><?php echo $reg['name'];?></option>
                                <?php } ?>
                            </select>
                           <p>Choose the person associated with this new contact.</p>
                           </select>
                        </div>
                       <label for="tag-country_code">Country Code</label>
                       
                       <select name="country_code" class="country" id="country" style="width:200px"></select>
                       <p>The name is how it appears on your contact.</p>
                    </div>
                    <div class="form-field term-slug-wrap">
                       <label for="tag-number">Number</label>
                       <input name="number" id="tag-number" type="text" value="<?php echo $param_number; ?>" style="width:200px" maxlength="9" required>
                       <p>Please provide contact number.</p>
                    </div>
                    <p class="submit">
                       <input type="submit" name="submit" id="submit" class="button button-primary" value="Add New Contact">
                       <a href="https://lucasdomingues.eu1.alfasoft.pt/wp-admin/admin.php?page=list-contact">Voltar</a>
                       <input type="hidden" name="gravar" value="1">
                       <span class="spinner"></span>
                    </p>
                 </form>
              </div>
           </div>
        </div>
        
    </body>
</html>
