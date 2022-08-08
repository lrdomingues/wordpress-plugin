<html>
    <head>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <script>
            $(document).ready(function () {
                $('#example').DataTable({});
            });
        </script>
        
        <div class="wrap">
            <br>
            <div id="icon-options-general" class="icon32"><br></div>
            <h2>List Person - Contact Management</h2>
            <br>
            <h3><a href="?page=create" class="btn btn-sucess pull-right">Add New Person</a></h3></br></br>
            
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>CountryCode</th>
                        <th>Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = mysqli_connect(getenv_docker('WORDPRESS_DB_HOST', 'mysql'),'','','recruitment');
                        
                        if($conn === false){die("Erro: " . mysqli_connect_error());}
                        
                        $sql = "select 
                                    wp_person.id, 
                                    wp_person.name, 
                                    wp_person.email_address, 
                                    wp_contacts.id_person,
                                    wp_contacts.country_code,
                                    wp_contacts.number
                                from wp_person 
                                left join wp_contacts on wp_contacts.id_person = wp_person.id
                                where wp_person.status = 1";
                            
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo '<tr>
                                            <td>'.$row['id'].'</td>
                                            <td><a href="?page=create-contact&id_person='.$row['id_person'].'">'.$row['name'].'</a></td>
                                            <td>'.$row['email_address'].'</td>
                                            <td>'.$row['country_code'].'</td>
                                            <td>'.$row['number'].'</td>
                                            <td>
                                                <form action="?page=atualizar" method="POST" style="display: inline-block;">
                                                    <input type="submit" value="Editar">
                                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                                    <input type="hidden" name="nome" value="'.$row['name'].'">
                                                    <input type="hidden" name="email" value="'.$row['email_address'].'">
                                                </form>
                                                <form action="?page=apagar&id='.$row['id'].'" method="POST" style="display: inline-block;">
                                                    <input type="submit" value="Excluir">
                                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                                </form>
                                            </td>
                                         </tr>';
                                }
                                mysqli_free_result($result);
                            }
                        }
                        mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
