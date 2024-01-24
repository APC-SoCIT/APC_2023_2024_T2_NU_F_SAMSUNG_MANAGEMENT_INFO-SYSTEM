$(document).ready(function(){

  function loadAllDepartment() {
    $.ajax({
      url: "backend/load_department.php",
      method: "GET",
      success: function(data) {
        $("#searchresult").html(data);
      }
    });
  }

  loadAllDepartment();

  $("#dept-sch").keyup(function(){
    
    var input = $(this).val();
    
    if(input != ""){
      $.ajax({

        url:"backend/department_rst.php",
        method:"POST",
        data:{input:input},

        success:function(data){
          $("#searchresult").html(data);
          $("#searchresult").css("display", "block");
        }
      });
    }else{

      loadAllDepartment();

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

  function loadAllDepartment() {
    $.ajax({
      url: "backend/load_department.php",
      method: "GET",
      success: function(data) {
        $("#searchresult").html(data);
      }
    });
  }

  function loadAllCcenter() {
    $.ajax({
      url: "backend/load_ccenter.php",
      method: "GET",
      success: function(data) {
        $("#searchresult").html(data);
      }
    });
  }

  const selectDeptCenterButton = document.querySelector('#add-submit');
  const cancelSelectDepartment = document.querySelector('#cancel_select_dept');
  const cancelAddDepartment = document.querySelectorAll('#canceladd_submit');
  const selectDept = document.querySelector('#add-department');
  const selectCcenter = document.querySelector('#add-ccenter');
  const clearSearch = document.querySelector('#clear-search');
  const loadtable = document.querySelector('#switch-table');

  selectDeptCenterButton.addEventListener('click', () => {
        
    const selectDepartmentGUI = document.querySelector('.select-dept_ccenterGUI.overlay');
    
    selectDepartmentGUI.style.display = "block";
      
  });

  cancelSelectDepartment.addEventListener('click', () => {
      
    const selectDepartmentGUI = document.querySelector('.select-dept_ccenterGUI.overlay');

    selectDepartmentGUI.style.display = "none";

  });

  selectDept.addEventListener('click', () => {

    const addDepartmentGUI = document.querySelector('.add-departmentGUI.overlay');
    const selectDepartmentGUI = document.querySelector('.select-dept_ccenterGUI.overlay');
    
    selectDepartmentGUI.style.display = "none";
    addDepartmentGUI.style.display = "block";

  });

  cancelAddDepartment.forEach(button => {

    button.addEventListener('click', () => {

      const addDepartmentGUI = document.querySelector('.add-departmentGUI.overlay');
      const addCcenterGUI = document.querySelector('.add-ccenterGUI.overlay');
      const dept_name_txtfld = document.querySelector('#dept_name');
      const ccenter_txtfld = document.querySelector('#ccenter');
      const editDepartmentGUI = document.querySelector('.edit-deptGUI.overlay');
      const editCcenterGUI = document.querySelector('.edit-ccenterGUI.overlay');
      const deleteDepartment = document.querySelector('.delete-deptGUI.overlay');
      const deleteCcenter = document.querySelector('.delete-ccenterGUI.overlay');

      addDepartmentGUI.style.display = "none";
      addCcenterGUI.style.display = "none";
      editDepartmentGUI.style.display = "none";
      editCcenterGUI.style.display = "none";
      deleteDepartment.style.display = "none";
      deleteCcenter.style.display = "none";
      dept_name_txtfld.value = "";
      ccenter_txtfld.value = "";

    });

  });

  selectCcenter.addEventListener('click', () => {

    const addCcenterGUI = document.querySelector('.add-ccenterGUI.overlay');
    const selectDepartmentGUI = document.querySelector('.select-dept_ccenterGUI.overlay');

    selectDepartmentGUI.style.display = "none";
    addCcenterGUI.style.display = "block"

  });

  document.addEventListener('click', (event) => {

    if (event.target && event.target.classList.contains('edit-dept')) {

      event.preventDefault();

      const editDepartmentGUI = document.querySelector('.edit-deptGUI.overlay');
      var curRow = $(event.target).closest("tr");
      var row = curRow.find('td');

      editDepartmentGUI.style.display = "block";
  
      $('#dept_id').val(row.eq(0).text());
      $('#editDepartment').val(row.eq(1).text());

      $.ajax({
        url: 'backend/load_ccenter.php',
        type: 'POST',
        data: {rm_ccenter: true,
               dept_id: $('#dept_id').val()},
        success: function(response) {
            $("#rm_ccenter").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle any errors
            console.log(textStatus, errorThrown);
        }
      });

    }else if(event.target && event.target.classList.contains('edit-ccenter')){

      const editCcenterGUI = document.querySelector('.edit-ccenterGUI.overlay');
      var curRow = $(event.target).closest("tr");
      var row = curRow.find('td');

      editCcenterGUI.style.display = "block";

      $('#ccenter_id').val(row.eq(0).text());
      $('#editCcenter').val(row.eq(1).text());

    }
    
  });

  document.addEventListener('click', (event) => {

  if (event.target && event.target.classList.contains('delete-dept')) {

    event.preventDefault();
    var curRow = $(event.target).closest("tr");
    var row = curRow.find('td');

    const deleteDepartmentGUI = document.querySelector('.delete-deptGUI.overlay');
    deleteDepartmentGUI.style.display = "block";

    $('#del_dept_id').val(row.eq(0).text());
    $('#span_dept').text(row.eq(1).text());

  }
  
  });

  document.addEventListener('click', (event) => {

    if (event.target && event.target.classList.contains('delete-ccenter')) {
  
      event.preventDefault();
      var curRow = $(event.target).closest("tr");
      var row = curRow.find('td');
  
      const deleteccenterGUI = document.querySelector('.delete-ccenterGUI.overlay');
      deleteccenterGUI.style.display = "block";
  
      $('#del_ccenter_id').val(row.eq(0).text());
      $('#del_ccenter').val(row.eq(1).text());
      $('#span_ccenter').text(row.eq(1).text());
  
    }
    
  });

  clearSearch.addEventListener('click', () => {

    const search_bar = document.querySelector("#dept-sch");

    search_bar.value = "";

    loadAllDepartment();

  });

  loadtable.addEventListener('click', () => {

    var button_txt = loadtable.textContent;
    if(button_txt === 'Cost Center'){

      loadtable.textContent = 'Department';
      loadAllCcenter();

    }else{

      loadtable.textContent = 'Cost Center';
      loadAllDepartment();

    }
    

  });

});

