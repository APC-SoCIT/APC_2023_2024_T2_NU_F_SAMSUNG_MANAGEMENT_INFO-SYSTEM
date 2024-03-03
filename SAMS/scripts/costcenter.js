//Global Variable for sorting and filtering
var sort = "";
// Set if ascending (1) or descending (0)
var flag = 0;

$(document).ready(function(){

    //Function for filtering

  //Filter Category on change lister for actual filter
  $("#filter-cat").on('change', () => {
    var filter_cat = $("#filter-cat").val();
    var searchbar = $("#ccenter-sch").val();


    //On change of the filter category, ensure that the actual filter is back to none for the selected option
    const filter_field = document.querySelector("#filter-table");
    filter_field.selectedIndex =  0;

    $.ajax({
      url:"backend/ccenter_filter.php",
      type:"POST",
      data:{filter_cat:filter_cat},
      success:function(data){
        $("#filter-table").html(data);
      }  
    });

    if(searchbar != ""){
      $.ajax({
        url:"backend/ccenter_rst.php",
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
        url:"backend/load_ccenter.php",
        type:"POST",
        data:{sort:sort,
              input:searchbar,
              flag:flag},
        success:function(data){
          $("#searchresult").html(data)
        }
      });
    }
  })

  //Actual Filter on change listener
  $("#filter-table").on('change', () => {
    var searchbar = $("#ccenter-sch").val();
    var filter_cat = $("#filter-cat").val();
    var filter = $("#filter-table").val();

    if(searchbar != ""){
      $.ajax({
        url:"backend/ccenter_rst.php",
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
        url:"backend/load_ccenter.php",
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

    function loadAllCostCenter() {
      $.ajax({
        url: "backend/load_ccenter.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    loadAllCostCenter();
  
    //Function for search bar

    $("#ccenter-sch").keyup(function(){
      var input = $(this).val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();
  
      if(input != ""){
        $.ajax({
  
          url:"backend/ccenter_rst.php",
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
          url:"backend/load_ccenter.php",
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
        loadAllAssets();
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
  
    function loadAllCostCenter() {
      $.ajax({
        url: "backend/load_ccenter.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    const clearSearch = document.querySelector('#clear-search');
        
    const editDeptmodal = document.querySelector('#myModal3');
  
    const editCcentermodal = document.querySelector('#myModal6');
    const deleteCcentermodal = document.querySelector('#myModal7');
  
    const cancelAddDepartment = document.querySelectorAll('#canceladd_submit');
  
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
  
      }else if(event.target && event.target.classList.contains('delete-ccenter')){
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
  
      const search_bar = document.querySelector("#ccenter-sch");
      const filter_cat_field = document.querySelector("#filter-cat");
      const filter = document.querySelector("#filter-table");
      search_bar.value = "";
  
      filter_cat_field.selectedIndex =  0;
      filter.selectedIndex =  0;
      //reset ascending or descending
      flag = 0;
  
      var filter_cat = $("#filter-cat").val();
  
      $.ajax({
        url:"backend/ccenter_filter.php",
        type:"POST",
        data:{filter_cat:filter_cat},
        success:function(data){
          $("#filter-table").html(data);
        }  
      });
  
      loadAllCostCenter();
  
    });

    // Sort and Filtering AJAX

    document.addEventListener('click', (event) => {

      var searchbar = $("#ccenter-sch").val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();
  
      if (event.target && event.target.id === "id-col"){
    
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "Cost_Center_ID";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/ccenter_rst.php",
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
            url:"backend/load_ccenter.php",
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
  
        sort = "Cost_Center";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/ccenter_rst.php",
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
            url:"backend/load_ccenter.php",
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

  });
