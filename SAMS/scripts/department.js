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

  const dept_head2 = document.querySelector('#modal-header2');
  const clearSearch = document.querySelector('#clear-search');
  const loadtable = document.querySelector('[id*="switch-table"]');
  
  const selectmodal = document.querySelector('#myModal');
  const selectDeptCenterButton = document.querySelector('[id*="add-submit"]');

  const addDeptmodal = document.querySelector('#myModal2');
  const selectDept = document.querySelector('#add-department');
  const selectCcenter = document.querySelector('#add-ccenter');

  const editDeptmodal = document.querySelector('#myModal3');
  const deleteDeptmodal = document.querySelector('#myModal4');

  const addCcentermodal = document.querySelector('#myModal5');
  const editCcentermodal = document.querySelector('#myModal6');
  const deleteCcentermodal = document.querySelector('#myModal7');

  const cancelAddDepartment = document.querySelectorAll('#canceladd_submit');

  selectDeptCenterButton.addEventListener('click', () => {
        
    selectmodal.style.display = "block";
      
  });

  selectDept.addEventListener('click', () => {
    
    selectmodal.style.display = "none";
    addDeptmodal.style.display = "block";

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

    addCcentermodal.style.display = 'block';
    selectmodal.style.display = 'none';

  });

  document.addEventListener('click', (event) => {

    if (event.target && event.target.classList.contains('edit-dept')) {

      event.preventDefault();

      var curRow = $(event.target).closest("tr");
      var row = curRow.find('td');

      editDeptmodal.style.display = "block";
  
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

      var curRow = $(event.target).closest("tr");
      var row = curRow.find('td');

      editCcentermodal.style.display = "block";

      $('#ccenter_id').val(row.eq(0).text());
      $('#editCcenter').val(row.eq(1).text());

    }
    
  });

  document.addEventListener('click', (event) => {

  if (event.target && event.target.classList.contains('delete-dept')) {

    event.preventDefault();
    var curRow = $(event.target).closest("tr");
    var row = curRow.find('td');

    deleteDeptmodal.style.display = "block";

    $('#del_dept_id').val(row.eq(0).text());
    $('#span_dept').text(row.eq(1).text());

  }
  
  });

  document.addEventListener('click', (event) => {

    if (event.target && event.target.classList.contains('delete-ccenter')) {
  
      event.preventDefault();
      var curRow = $(event.target).closest("tr");
      var row = curRow.find('td');
  
      deleteCcentermodal.style.display = "block";
  
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
      dept_head2.textContent = 'Cost Center';
      loadAllCcenter();

    }else{

      loadtable.textContent = 'Cost Center';
      dept_head2.textContent = 'Department';
      loadAllDepartment();

    }

  });

});

