$(document).ready(function(){

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
    
    if(input != ""){
      $.ajax({

        url:"backend/emp_rst.php",
        method:"POST",
        data:{input:input},

        success:function(data){
          $("#searchresult").html(data);
          $("#searchresult").css("display", "block");
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

  const addEmployeeButton = document.querySelector('#add-submit');
  const cancelAddEmployee = document.querySelector('#canceladd_submit');
  const editEmployeeButton = document.querySelector('#edit-employee');
  const cancelEditEmployee = document.querySelector('#canceledit_submit');
  const clearSearch = document.querySelector('#clear-search');
  const import_employee = document.querySelector("#import_employee");

  addEmployeeButton.addEventListener('click', () => {
        
      const addEmployeeGUI = document.querySelector('.add-employeeGUI.overlay');
      
      addEmployeeGUI.style.display = "block";
  });

  cancelAddEmployee.addEventListener('click', () => {
      
      const addEmployeeGUI = document.querySelector('.add-employeeGUI.overlay');
      const fname_txtfld = document.querySelector('#employee_fname');
      const lname_txtfld = document.querySelector('#employee_lname');
      const department = document.querySelector('#dept_add');
      const cost_center = document.querySelector('#ccenter');

      addEmployeeGUI.style.display = "none";
      fname_txtfld.value = "";
      lname_txtfld.value = "";
      department.selectedIndex = 0;
      cost_center.selectedIndex = 0;

      loadCostCenter();

  });

  editEmployeeButton.addEventListener('click', () => {

    const selectedCheckbox = $('input[type=checkbox]:checked');
    if (selectedCheckbox.length == 1) {
      const editEmployeeGUI = document.querySelector('.edit-rowGUI.overlay');
      editEmployeeGUI.style.display = "block";
    }else{
      alert("You can only edit one row at a time!");
    }
      
  });

  cancelEditEmployee.addEventListener('click', () => {
      
      const editEmployeeGUI = document.querySelector('.edit-rowGUI.overlay');
      const empid_txtfld = document.querySelector('#editEmployee_ID');
      const fname_txtfld = document.querySelector('#fname');
      const lname_txtfld = document.querySelector('#lname');
      const knoxid_txtfld = document.querySelector('#knox_ID');
      const dept_txtfld = document.querySelector('#dept');
      const ccenter_txtfld = document.querySelector('#ccenter');

      editEmployeeGUI.style.display = "none";
      empid_txtfld.value = "";
      fname_txtfld.value = "";
      lname_txtfld.value = "";
      knoxid_txtfld.value = "";
      dept_txtfld.value = "";
      ccenter_txtfld.value="";

  });

  clearSearch.addEventListener('click', () => {

    const search_bar = document.querySelector("#emp-sch");

    search_bar.value = "";

    loadAllEmployees();

  });

  import_employee.addEventListener('click', () => {

    const import_employeeGUI = document.querySelector(".import-employeeGUI");
    if(import_employeeGUI.style.display === "none"){
        import_employeeGUI.style.display = "block";
    }else{
        import_employeeGUI.style.display = "none";
    }
  
  });

});

$(document).ready(function () {
  const editButton = $('#edit-employee'); // assuming you have an edit button

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
    const selectedCheckbox = $('input[type=checkbox]:checked');
    if (selectedCheckbox.length == 1) {
      populateFormFromRow(selectedCheckbox);
      // Trigger the change event on the "Department" dropdown to load Cost Centers
      $('#dept_edit').change();
    }
  });

  // Event handler for the "Department" dropdown
  $('#dept_edit').on('change', function () {

    const selectedCheckbox = $('input[type=checkbox]:checked');

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
        const selectedCheckbox = $('input[type=checkbox]:checked');
        if (selectedCheckbox.length == 1) {
          //populateFormFromRow(selectedCheckbox);
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
          const selectedCheckbox = $('input[type=checkbox]:checked');
          if (selectedCheckbox.length == 1) {
            //populateFormFromRow(selectedCheckbox);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', error);
        }
      });
    });
});