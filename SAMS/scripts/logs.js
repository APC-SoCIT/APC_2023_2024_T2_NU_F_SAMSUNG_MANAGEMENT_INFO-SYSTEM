//Global Variable for sorting and filtering
var sort = "";
// Set if ascending (1) or descending (0)
var flag = 0;

$(document).ready(function(){

    //Function for filtering

  //Filter Category on change lister for actual filter
  $("#filter-cat").on('change', () => {
    var filter_cat = $("#filter-cat").val();
    var searchbar = $("#logs-sch").val();


    //On change of the filter category, ensure that the actual filter is back to none for the selected option
    const filter_field = document.querySelector("#filter-table");
    filter_field.selectedIndex =  0;

    $.ajax({
      url:"backend/logs_filter.php",
      type:"POST",
      data:{filter_cat:filter_cat},
      success:function(data){
        $("#filter-table").html(data);
      }  
    });

    if(searchbar != ""){
      $.ajax({
        url:"backend/logs_rst.php",
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
        url:"backend/load_logs.php",
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
    var searchbar = $("#logs-sch").val();
    var filter_cat = $("#filter-cat").val();
    var filter = $("#filter-table").val();

    if(searchbar != ""){
      $.ajax({
        url:"backend/logs_rst.php",
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
        url:"backend/load_logs.php",
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


    // Function to load All assets
  
    function loadAllAssets() {
      $.ajax({
        url: "backend/load_logs.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
    
    loadAllAssets();
    
    // Function for search bar
  
    $("#logs-sch").keyup(function(){
      var input = $(this).val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();
  
      if(input != ""){
        $.ajax({
  
          url:"backend/logs_rst.php",
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
          url:"backend/load_logs.php",
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

    document.addEventListener('click', (event) => {

      var searchbar = $("#logs-sch").val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();
  
      if (event.target && event.target.id === "log-id"){
    
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "logs_tbl.Logs_ID";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "id-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "logs_tbl.Asset_ID";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "no-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "it_assets_tbl.Asset_No";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "catg-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "it_assets_tbl.Category";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "desc-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "it_assets_tbl.Descr";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "serial-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "it_assets_tbl.Serial_No";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "emp-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "employee_tbl.Employee_ID";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "assign-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "employee_tbl.Lname";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "stat-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "logs_tbl.Stat";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "remarks-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "logs_tbl.Remarks";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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
  
      }else if(event.target && event.target.id === "date-col"){
  
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }
  
        sort = "logs_tbl.Issued_Date";
  
        if(searchbar != ""){
          $.ajax({
            url:"backend/logs_rst.php",
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
            url:"backend/load_logs.php",
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