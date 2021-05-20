<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>


    <title>Student Database</title>
</head>

<body>
    <center>
        <h1 style="padding: 10px; background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">Student Database</h1>
    </center><br>
    <form method="POST" style="display: inline-block; padding-left: 150px;">
        <h2>Search by phone number</h2>
        <div class="form-group">
            <label for="exampleInputEmail1">Phone number</label>
            <input type="text" name="phno" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter phone no">
        </div>

        <br>
        <button type="submit" class="btn btn-primary" onclick="TestsFunction()">Search</button>
        
        
    </form>
    <form method="POST" style="display: inline-block; padding-left: 170px;">
        <h2>Search by name</h2>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="student_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
        </div>

        <br>
        <button type="submit" class="btn btn-primary" onclick="TestsFunction()">Search</button>

    </form>
    <br><br><br>
    <form method="POST" style="display: inline-block; padding-left: 280px;">
        <h2>Search students having marks more than given</h2>
        <div class="form-group">
            <label for="exampleInputEmail1">Marks</label>
            <input type="text" name="total" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter marks">
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Search</button>

    </form><br><br><br>
<?php
   error_reporting(E_ALL ^ E_WARNING); 
   $con = mysqli_connect("localhost","root","","krishworks");
   if (!$con)
   {
       die('Could not connect: ' . mysqli_error());
   }

echo '
    <table id="students" class="table table-hover" style="width: 950px; text-align: center; margin: 0 auto;">
        <thead class="thead-dark" style="background-color: rgb(54, 51, 51);color: white;">
            <tr>

                <th scope="col">Name</th>
                <th scope="col">phone</th>
                <th scope="col">Emailid</th>
                <th scope="col">S-1</th>
                <th scope="col">S-2</th>
                <th scope="col">S-3</th>
                <th scope="col">S-4</th>
                <th scope="col">S-5</th>
                <th scope="col">Total</th>
            </tr>
        </thead>';
      
        
                
        echo '<tbody>';
        if (!empty($_REQUEST['phno'])) {

            $phno = mysqli_real_escape_string($con,$_POST['phno']);     
            
            $sql = "SELECT * FROM student WHERE phno ='{$phno}'"; 
            $row = mysqli_query($con,$sql);
            }
            
            if (!empty($_REQUEST['student_name'])) {
            
                $student_name = mysqli_real_escape_string($con,$_POST['student_name']);     
                
                $sql = "SELECT * FROM student WHERE student_name ='{$student_name}'"; 
                $row = mysqli_query($con,$sql);
            }
            if (!empty($_REQUEST['full'])) {
            
                $full = mysqli_real_escape_string($con,$_POST['full']);     
                
                $sql = "SELECT * FROM student WHERE student_name ='{$full}'"; 
                $row = mysqli_query($con,$sql);
            }
            
            
           
if($row){
        while($row1 = mysqli_fetch_array($row))

        {
      
        echo "<tr>";
      
        echo "<td>" . $row1['student_name'] . "</td>";
      
        echo "<td>" . $row1['phno'] . "</td>";
      
        echo "<td>" . $row1['emailid'] . "</td>";
      
        echo "<td>" . $row1['s1'] . "</td>";
        echo "<td>" . $row1['s2'] . "</td>";
        echo "<td>" . $row1['s3'] . "</td>";
        echo "<td>" . $row1['s4'] . "</td>";
        echo "<td>" . $row1['s5'] . "</td>";
        echo "<td>" . $row1['total_marks'] . "</td>";
        echo "</tr>";
      
        }
    }
        echo '</tbody>';
        ?>
    </table><br>
   <center>
   <input type="button" id="btnExport" class="btn btn-primary" value="Download (PDF)">

   </center>
    
<br>


<?php


   
   
      
        
                
       
        
            
            if (!empty($_REQUEST['total'])) {
            
                $total = mysqli_real_escape_string($con,$_POST['total']);     
                
                $sql = "SELECT student_name FROM student WHERE total_marks >'{$total}'"; 
                 
                $row = mysqli_query($con,$sql);
                
                 
                
                }
if($row){
    echo "<h1 style='text-align:center;'>List of students : </h1>";
        while($row1 = mysqli_fetch_array($row))

        {
   
      echo '<form id="fullsub" method="post">';
        echo "<center><input type='submit' class='btn btn-primary'  style='text-align:center;margin:0 auto;' type='submit' name='full' onclick='full()' value='". $row1['student_name'] . "'></center><br>\n";
      echo '</form>';
        
       
      
        }
    }
        
        ?>
    </table><br>
   






</body>

</html>
<style>
    .form-group input {
        width: 360px;
    }
    body{
        background-image: linear-gradient(to top, #a8edea 0%, #fed6e3 100%);
    }
</style>
<script>
    
        $("body").on("click", "#btnExport", function () {
            html2canvas($('#students')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("student-details.pdf");
                }
            });
        });
    
   

</script>
<script>
    function full(){
    document.getElementById("fullsub").submit();
   }
</script>