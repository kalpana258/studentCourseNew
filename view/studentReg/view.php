<!DOCTYPE html>
<html>
<head>
    <title>List</title>

    <!-- bootstrap Lib -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
 
    <style type="text/css">
        .content{
            max-width: 800px;
            margin: auto;
        }

        h1{
            text-align: center;
            padding-bottom: 60px;
        }
    </style>

</head>
<body>
<?php 
// include nav bar

require realpath(__DIR__ . '/..')."/includes/header.php";

require realpath(__DIR__ . '/../..')."/src/config/config.php";


?>

<div class="content">
    <h1></h1>
      <label class="control-label"  for="contact_no">Show</label>
    <select name="num_rows" id="show_entries">
     <?php foreach($config['show'] as $show) {?>
        <option value=<?php echo  $show['key'] ?>><?php echo  $show['value'] ?></option>
        <?php } ?>
       
          </select>
               <table width="100%" id="course_table" class="table table-striped">
                    <thead >
                        <tr class="tr_header">
                           <th scope="col" >Reg No.</th>
                           <th scope="col" >First Name</th>
                           <th scope="col" >Last Name</th>
                           <th scope="col" >Mobile</th>
                           <th scope="col" >Action</th>
                        </tr>
                    </thead>
                    
                </table><br/>
                <div id="div_pagination">               
                    
                    <!-- <input type="button" class="btn btn-info" id="prev" name="but_prev" value="Previous">
                    <input type="button" class="btn btn-info" id="next" name="but_next" value="Next"> -->
                </div>
                <br>
             <div align="right">
             <a href="/createStudent" id="add_button"  class="btn btn-success">Add Student</a>
       </div>     
</div>
</body>
</html>


<!-- script file -->
 <script type="text/javascript" src="../public/assets/js/student.js"></script>

      