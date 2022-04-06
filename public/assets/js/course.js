
    function relode_page(page)
    {
        showentries = $("#show_entries").val()
        $.ajax({
                url:"/getCourseList",
                data: { num_rows: showentries, page:page} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    $("#course_table > tbody").remove();
                   var row = '<tbody>';   
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="#" class="btn btn-primary" onclick="edit('+responseData[i]['id']+')">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                    $("#div_pagination > a").remove();
                    var paginate="";
                    for( i=1; i<=data.total_pages;i++){
                        paginate +="<a href='#' onclick='relode_page("+i+")' class='btn btn-primary'>"+i+"</a>&nbsp;&nbsp"
                    }
                    

                    $("#div_pagination").append(paginate)

                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });
    }

function del(id){
        if(confirm("Are you sure want to delete this user?"))
        {
            $.ajax({
                url:"/deleteCourse",
                method:"POST",
                data:{course_id:id},
                success:function(data)
                {
                    var json = $.parseJSON(data);
                    if(json['success']==false){
                        alert(json['message']);
                    }else{
                        location.reload();
                    }
                }
            });
        }
        else
        {
            return false;
        }
}
function edit(id){
 

    const form = document.createElement('form');
  form.method = 'post';
  form.action = '\editCourse';


   
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = "course_id";
      hiddenField.value = id;

      form.appendChild(hiddenField);
    

  document.body.appendChild(form);
  form.submit();
}
    $(document).ready(function(){
      $.ajax({
                url:"/getCourseList",
                data: { num_rows: 2} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    
                   var row = '<tbody>';   
                   if(responseData!='error' && responseData.length>0) {
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="#" class="btn btn-primary" onclick="edit('+responseData[i]['id']+')">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                    console.log(data.total_pages)
                    var paginate="";
                    for( i=1; i<=data.total_pages;i++){
                        paginate +="<a href='#' onclick='relode_page("+i+")' class='btn btn-primary'>"+i+"</a>&nbsp;&nbsp"
                    }
                    // console.log(paginate)

                    $("#div_pagination").append(paginate)
                }else if(responseData=='error'){
               
                    row += '<tr>';   
                row += '<td>' +"There is error on fetching records." + '</td>';
              
            
        
            row += '</tr>';
            row += '</tbody>';
            $('#course_table').append(row);
                } else{
                    row += '<tr>';   
                    row += '<td>' +"No records to display" + '</td>';
                  
                
            
                row += '</tr>';
                row += '</tbody>';
                $('#course_table').append(row);
                }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });

    $("#show_entries").change(function(){

        $.ajax({
                url:"/getCourseList",
                data: { num_rows: this.value} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    $("#course_table > tbody").remove();
                   var row = '<tbody>';   
                   if(responseData!='error' && responseData.length>0) {
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="#" class="btn btn-primary" onclick="edit('+responseData[i]['id']+')">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                    console.log(data.total_pages)
                    $("#div_pagination > a").remove();
                    var paginate="";
                    for( i=1; i<=data.total_pages;i++){
                        paginate +="<a href='#' onclick='relode_page("+i+")' class='btn btn-primary'>"+i+"</a>&nbsp;&nbsp"
                    }
                    // console.log(paginate)

                    $("#div_pagination").append(paginate)
                }else if(responseData=='error'){
               
                    row += '<tr>';   
                row += '<td>' +"There is error on fetching records." + '</td>';
              
            
        
            row += '</tr>';
            row += '</tbody>';
            $('#course_table').append(row);
                } else{
                    row += '<tr>';   
                    row += '<td>' +"No records to display" + '</td>';
                  
                
            
                row += '</tr>';
                row += '</tbody>';
                $('#course_table').append(row);
                }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });
    })

    

    

  
$( function() {
    $( "#datepicker" ).datepicker();
  } );
    });