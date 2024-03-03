//Global Variable for sorting and filtering
var sort = "";
// Set if ascending (1) or descending (0)
var flag = 0;

$(document).ready(function(){

    //Function for filtering

    //Filter Category on change lister for actual filter
    $("#filter-cat").on('change', () => {
      var filter_cat = $("#filter-cat").val();
      var searchbar = $("#emp-sch").val();


      //On change of the filter category, ensure that the actual filter is back to none for the selected option
      const filter_field = document.querySelector("#filter-table");
      filter_field.selectedIndex =  0;

      $.ajax({
        url:"backend/emp_filter.php",
        type:"POST",
        data:{filter_cat:filter_cat},
        success:function(data){
          $("#filter-table").html(data);
        }  
      });

      if(searchbar != ""){
        $.ajax({
          url:"backend/emp_rst.php",
          type:"POST",
          data:{sort:sort,
                input:searchbar,
                flag:flag},
          success:function(data){
            $("#searchresult").html(data);
          }
        });
      }else{
        $.ajax({
          url:"backend/load_employees.php",
          type:"POST",
          data:{sort:sort,
                input:searchbar,
                flag:flag},
          success:function(data){
            $("#searchresult").html(data)
          }
        });
      }
    });

    //Actual Filter on change listener
    $("#filter-table").on('change', () => {
      var searchbar = $("#emp-sch").val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();

      if(searchbar != ""){
        $.ajax({
          url:"backend/emp_rst.php",
          type:"POST",
          data:{sort:sort,
                input:searchbar,
                filter:filter,
                filter_cat:filter_cat,
                flag:flag},
          success:function(data){
            $("#searchresult").html(data);
          }
        });
      }else{
        $.ajax({
          url:"backend/load_employees.php",
          type:"POST",
          data:{sort:sort,
                input:searchbar,
                filter:filter,
                filter_cat:filter_cat,
                flag:flag},
          success:function(data){
            $("#searchresult").html(data)
          }
        });
      }
    });

    function loadAllEmployees() {
      $.ajax({
        url: "backend/load_employees.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    loadAllEmployees();
  
    $("#emp-sch").keyup(function(){
      
      var input = $(this).val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();
  
      if(input != ""){
        $.ajax({
  
          url:"backend/emp_rst.php",
          method:"POST",
          data:{input:input,
                sort:sort,
                filter:filter,
                filter_cat:filter_cat,
                flag:flag},
  
          success:function(data){
            $("#searchresult").html(data);
            $("#searchresult").css("display", "block");
          }
        });
      }else if(sort != "" || filter != ""){
        $.ajax({
          url:"backend/load_employees.php",
          type:"POST",
          data:{sort:sort,
                filter:filter,
                filter_cat:filter_cat,
                flag:flag},
          success:function(data){
            $("#searchresult").html(data)
          }
        });
      }else{
    
          loadAllEmployees();
    
        }
    
      });
  
  });
  
  function loadCostCenter(dept) {
    $.ajax({
      url: `backend/get_cost_center.php`,
      method: "GET",
      data: {
        dept: dept
      },
      success: function(response) {
        $("#cost_center").html(response);
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
      }
    });
  }
  
  document.addEventListener('DOMContentLoaded', () => {
  
    function loadAllEmployees() {
      $.ajax({
        url: "backend/load_employees.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    const closeModalBtn = document.querySelectorAll('#closeModalBtn');

    const addEmployeeButton = document.querySelector('[id*="add-submit"]');
    const addEmployeemodal = document.querySelector('#myModal');

    const editEmployeeButton = document.querySelector('[id*="edit-employee"]');
    const editEmployeemodal = document.querySelector('#myModal2');

    const import_employee = document.querySelector('[id*="import_employee"]');
    const import_form = document.querySelector('#myModal3');

    const clearSearch = document.querySelector('#clear-search');

  
    addEmployeeButton.addEventListener('click', () => {
          
        addEmployeemodal.style.display = 'block';

    });

    closeModalBtn.forEach(button => {

        button.addEventListener('click', () => {

            addEmployeemodal.style.display = 'none';
            if(addEmployeeButton.style.display === 'none'){

                const fname_txtfld = document.querySelector('#employee_fname');
                const lname_txtfld = document.querySelector('#employee_lname');
                const department = document.querySelector('#dept_add');
                const cost_center = document.querySelector('#ccenter');

                fname_txtfld.value = "";
                lname_txtfld.value = "";
                department.selectedIndex = 0;
                cost_center.selectedIndex = 0;

                loadCostCenter();
            }

            editEmployeemodal.style.display = 'none';
            if(editEmployeemodal.style.display === 'none'){
                
                const empid_txtfld = document.querySelector('#editEmployee_ID');
                const fname_txtfld = document.querySelector('#fname');
                const lname_txtfld = document.querySelector('#lname');
                const knoxid_txtfld = document.querySelector('#knox_ID');
                const dept_txtfld = document.querySelector('#dept');
                const ccenter_txtfld = document.querySelector('#ccenter');
          
                empid_txtfld.value = "";
                fname_txtfld.value = "";
                lname_txtfld.value = "";
                knoxid_txtfld.value = "";
                dept_txtfld.value = "";
                ccenter_txtfld.value="";

            }

        });

    });
  
    editEmployeeButton.addEventListener('click', () => {
  
      const selectedCheckbox = $('input[type=checkbox]:checked').not('#switch-mode');
      if (selectedCheckbox.length == 1) {
        editEmployeemodal.style.display = 'block';

      }else{
        alert("You can only edit one row at a time!");
      }
        
    });
  
    clearSearch.addEventListener('click', () => {
  
      const search_bar = document.querySelector("#emp-sch");
      const filter_cat_field = document.querySelector("#filter-cat");
      const filter = document.querySelector("#filter-table");

      search_bar.value = "";

      filter_cat_field.selectedIndex =  0;
      filter.selectedIndex =  0;
      //reset ascending or descending
      flag = 0;
  
      var filter_cat = $("#filter-cat").val();

      $.ajax({
        url:"backend/asset_filter.php",
        type:"POST",
        data:{filter_cat:filter_cat},
        success:function(data){
          $("#filter-table").html(data);
        }  
      });
  
      loadAllEmployees();
  
    });
  
    import_employee.addEventListener('click', () => {
  
      if(import_form.style.display === "none"){
          import_form.style.display = "block";
      }else{
          import_form.style.display = "none";
      }
    
    });
  
  });
  
  $(document).ready(function () {
    const editButton = $('[id*="edit-employee"]'); // assuming you have an edit button
  
    // Function to populate form fields from a selected row
    function populateFormFromRow(selectedCheckbox) {
      const selectedRow = selectedCheckbox.closest('tr');
      const cells = selectedRow.find('td');
  
      $('#sys_id').val(cells.eq(1).text()); // System ID
      $('#editEmployee_ID').val(cells.eq(2).text()); // Employee ID
      $('#fname').val(cells.eq(3).text()); // First Name
      $('#lname').val(cells.eq(4).text()); // Last Name
      $('#knox_ID').val(cells.eq(5).text()); // Knox ID
  
      const departmentValue = cells.eq(6).text(); // Department
      console.log(departmentValue);
      $('#dept_edit option').filter(function () {
        return $(this).text().trim() == departmentValue.trim();
      }).prop('selected', true);
  
    }
  
    // Event listener for the Edit button
    editButton.click(function (event) {
      event.preventDefault(); // Prevent form submission
      const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
      if (selectedCheckbox.length == 1) {
        populateFormFromRow(selectedCheckbox);
        // Trigger the change event on the "Department" dropdown to load Cost Centers
        $('#dept_edit').change();
      }
    });
  
    // Event handler for the "Department" dropdown
    $('#dept_edit').on('change', function () {
  
      const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
  
      const selectedRow = selectedCheckbox.closest('tr');
      const cells = selectedRow.find('td');
      const selectedDepartment = $(this).val();
      const ccenter = cells.eq(7).text();
  
      // Make an AJAX request to fetch the corresponding Cost Centers based on the selected department
      $.ajax({
        url: `backend/get_cost_center.php`,
        method: "GET",
        data: {
          dept: selectedDepartment,
          ccenter: ccenter
        },
        success: function(response) {
          $("#ccenter_edit").html(response);
          const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
          if (selectedCheckbox.length == 1) {
            populateFormFromRow(selectedCheckbox);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', error);
        }
      });
    });
  
    // Event handler for the "Department" dropdown
    $('#dept_add').on('change', function () {

      const selectedDepartment = $(this).val();
  
      // Make an AJAX request to fetch the corresponding Cost Centers based on the selected department
      $.ajax({
        url: `backend/get_cost_center.php`,
        method: "GET",
        data: {
          dept: selectedDepartment,
        },
        success: function(response) {
          $("#ccenter_add").html(response);
          const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
          if (selectedCheckbox.length == 1) {
            //populateFormFromRow(selectedCheckbox);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', error);
        }
      });
    });

    // Event Handler to toggle checkbox when clicking entire row
    
    document.addEventListener('click', (event) => {

      if (event.target && event.target.tagName === "TD"){

        // Find the tr that contains the clicked td
        var row = event.target.parentNode;
        
        // Find the checkbox within that tr
        var checkbox = row.querySelector('input[type="checkbox"]:not(#switch-mode)');
        
        // Toggle the checkbox state
        if (checkbox) {
          checkbox.checked = !checkbox.checked;
          row.style.backgroundColor = checkbox.checked ? 'var(--selectrow)' : '';
        }

      }

    });


    // Table Column sort

    document.addEventListener('click', (event) => {

      var searchbar = $("#emp-sch").val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();

      if (event.target && event.target.id === "id-col"){
    
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "employee_tbl.Employee_ID";

        if(searchbar != ""){
          $.ajax({
            url:"backend/emp_rst.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data);
            }
          });
        }else{

          $.ajax({
            url:"backend/load_employees.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data)
            }
          });
        }

      }else if(event.target && event.target.id === "fname-col"){

        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "employee_tbl.Fname";

        if(searchbar != ""){
          $.ajax({
            url:"backend/emp_rst.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data);
            }
          });
        }else{

          $.ajax({
            url:"backend/load_employees.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data)
            }
          });
        }

      }else if(event.target && event.target.id === "lname-col"){

        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "employee_tbl.Lname";

        if(searchbar != ""){
          $.ajax({
            url:"backend/emp_rst.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data);
            }
          });
        }else{

          $.ajax({
            url:"backend/load_employees.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data)
            }
          });
        }

      }else if(event.target && event.target.id === "knox-col"){

        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "employee_tbl.Knox_ID";

        if(searchbar != ""){
          $.ajax({
            url:"backend/emp_rst.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data);
            }
          });
        }else{

          $.ajax({
            url:"backend/load_employees.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data)
            }
          });
        }

      }else if(event.target && event.target.id === "dept-col"){

        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "department_tbl.Department";

        if(searchbar != ""){
          $.ajax({
            url:"backend/emp_rst.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data);
            }
          });
        }else{

          $.ajax({
            url:"backend/load_employees.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data)
            }
          });
        }

      }else if(event.target && event.target.id === "ccenter-col"){

        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "cost_center_tbl.Cost_Center";

        if(searchbar != ""){
          $.ajax({
            url:"backend/emp_rst.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data);
            }
          });
        }else{

          $.ajax({
            url:"backend/load_employees.php",
            type:"POST",
            data:{sort:sort,
                  input:searchbar,
                  filter:filter,
                  filter_cat:filter_cat,
                  flag:flag},
            success:function(data){
              $("#searchresult").html(data)
            }
          });
        }

      }
    });
  
    import_employee.addEventListener('click', () => {
  
      if(import_form.style.display === "none"){
          import_form.style.display = "block";
      }else{
          import_form.style.display = "none";
      }
    
    });

  });

