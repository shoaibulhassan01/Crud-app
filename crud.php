<?php
// INSERT INTO `notes` (`Sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Fast', 'please run fast so that you will win the race.', current_timestamp());
/*Connection to the data base*/
// DELETE FROM `notes` WHERE `notes`.`Sno` = 4
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud";

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
die("Sorry we failed to connect:". mysqli_connect_error());
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>iNotes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
  



</head>
<body>


<div class="container">
 
  <!-- Trigger the modal with a button -->
  

  <!-- Modal -->
  <div class="modal fade" id="editModal" role="dialog" tabindex="-1" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit note</h4>
        </div>
        <div class="modal-body">
        <form action="/crud app/crud.php" method="post">
          <input type="hidden" name="snoedit" id="snoedit">
    <div class="mb-3">
      <label for="title" class="form-label">Note Title</label>
      <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp">
      
    </div><br>
    <div class="mb-3">
      <label for="description" class="form-label">Note Descripttion</label>
      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" name="descriptionedit" id="descriptionedit" style="height: 100px"></textarea>
        
      </div>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">update Note</button>
  </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


  <!-- Navbar is here..... -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">iNotes</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="about us.html">About</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
    <form class="navbar-form navbar-right" action="/action_page.php">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</nav>








<!-- Form ha ye .....-->



<div class="container " style=" padding-right: 230px;">
  <h2>Add a note</h2>
  <form action="/crud app/crud.php" method="post">
    <div class="mb-3">
      <label for="title" class="form-label">Note Title</label>
      <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      
    </div><br>
    <div class="mb-3">
      <label for="description" class="form-label">Note Descripttion</label>
      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description" style="height: 100px"></textarea>
        
      </div>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Add Note</button>
  </form>
</div><br><br><br>


<!-- Data from here ....-->


<div class="container my-4">


<?php

if (isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql =  " DELETE FROM `notes` WHERE `notes`.`Sno` = $sno";
  $result = mysqli_query($conn,$sql);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){


  if (isset($_POST['snoedit'])) {
    $title = $_POST["titleedit"];
    $description = $_POST["descriptionedit"];
    $sno = $_POST["snoedit"];
  
    $sql =  "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`Sno` = $sno;";
    $result = mysqli_query($conn,$sql);
    if($result){
      echo "Notes are updated";
    }else{
      echo "notes are not updatesd";
    }
  }
  
  else{$title = $_POST["title"];
  $description = $_POST["description"];

  $sql =  "INSERT INTO `notes` (`Sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp())";
  $result = mysqli_query($conn,$sql);

  if($result){ 
    
}
else{
    echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
} 
}
}

?>


<!-- // Table Code ...... -->
<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.no</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php

$sql = "SELECT * FROM `notes`";
$result = mysqli_query($conn,$sql);

$sno = 0;
while($row = mysqli_fetch_assoc($result)){

$sno = $sno + 1;

 echo  "<tr>
 <th scope='row'>" . $sno ." </th>
 <td>" . $row['title'] ."</td>
 <td>" . $row['description'] ."</td>
 <td>  <button class='edit btn btn-sm btn-primary' id=".$row['Sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['Sno'].">Delete</button>    </td>
</tr>";

} 


?>
   
   
    
  </tbody>
</table>

</div>










<script>




edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerHTML
        description = tr.getElementsByTagName("td")[1].innerHTML
        console.log(title,description);
        titleedit.value = title;
        descriptionedit.value = description;
        snoedit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
        

      })
    })


deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerHTML
        description = tr.getElementsByTagName("td")[1].innerHTML
        Sno = e.target.id.substr(1,);
        if(confirm("Are you sure you want to delete this note")){
console.log("yes")
window.location = `/crud app/crud.php?delete=${Sno}`;

        }else{
          console.log("no")
        }
        

      })
    })
  </script>


</body>
</html>

