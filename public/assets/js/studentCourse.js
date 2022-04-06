$( function() {
    
    var studentdropdown =[]
    var studentnamedropdown =[]
    var courseDropdown =[]
    var coursenameDropdown =[]

    $("#student option").each(function() {
        if(this.value != ""){
        studentdropdown.push(this.value);
        studentnamedropdown.push(this.getAttribute('name')); 
        }       // or $(this).val()
    });
    $("#course option").each(function() {
        if(this.value != ""){
        courseDropdown.push(this.value);
        coursenameDropdown.push(this.getAttribute('name'));        // or $(this).val()
        }
    });
   
    var rowIdx = 0;

   // jQuery button click event to add a row
   $('#addBtn').on('click', function () {
     // Adding a row inside the tbody.
    var tabledata = `<tr id="R${++rowIdx}">
          <td> <div class="form-group col-md-4">     
         <select id="student" name="student[]" class="form-control">
           <option selected value="">Select Student</option>`;
     for(var i=0; i<studentdropdown.length;i++){ 
       tabledata += "<option value='"+studentdropdown[i]+"'>"+studentnamedropdown[i]+"( RegNo- "+studentdropdown[i]+")</option>"
     } 
    tabledata += "</select></div></td><td>"

    tabledata += `<div class="form-group col-md-4">  
                   <select id="course" name="course[]" class="form-control">
                     <option selected value ="">Select Course</option>`
                     for(var k=0; k<courseDropdown.length;k++){ 
                       tabledata += "<option value='"+courseDropdown[k]+"'>"+coursenameDropdown[k]+"( code -"+courseDropdown[k]+")</option>";
                     }
tabledata +=" </select></div></td></tr>";
   $('table').append(tabledata)
 

   });


} );