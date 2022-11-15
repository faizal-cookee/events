<?php
session_start();
require "connection.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
            
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Data tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <title>Customers list</title>

    <script>
      $(document).ready(function() {

        $('#customer_tabel').DataTable();
      });
    </script>
</head>
<body>
  <div class="container px-0 bg-light">
    <h1 class="text-center bg-dark text-light mt-5">Customers List</h1>
  </div>
  <div class=" mt-3 container bg-light">
    <div class="mt-5 table-responsive">
      <table class="table table-hover" id="customer_tabel">
        <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone number</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
          $sql = "SELECT * FROM user";
          $result = $conn->query($sql);

          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['full_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phno'] ?></td>
          </tr>
          <?php
            }
          }
          ?>
          
        </tbody>
      </table>
      
    </div>
  </div>
  
</body>
</html>