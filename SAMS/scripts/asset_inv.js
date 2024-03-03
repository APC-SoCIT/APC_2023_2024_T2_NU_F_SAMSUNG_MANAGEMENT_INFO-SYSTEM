//Global Variable for sorting and filtering
var sort = "";
// Set if ascending (1) or descending (0)
var flag = 0;

$(document).ready(function(){

    //Function for filtering

    //Filter Category on change lister for actual filter
    $("#filter-cat").on('change', () => {
      var filter_cat = $("#filter-cat").val();
      var searchbar = $("#asset-inv-sch").val();


      //On change of the filter category, ensure that the actual filter is back to none for the selected option
      const filter_field = document.querySelector("#filter-table");
      filter_field.selectedIndex =  0;

      $.ajax({
        url:"backend/asset_inv_filter.php",
        type:"POST",
        data:{filter_cat:filter_cat},
        success:function(data){
          $("#filter-table").html(data);
        }  
      });

      if(searchbar != ""){
        $.ajax({
          url:"backend/asset_inv_rst.php",
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
          url:"backend/load_asset_inv.php",
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
      var searchbar = $("#asset-inv-sch").val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();

      if(searchbar != ""){
        $.ajax({
          url:"backend/asset_inv_rst.php",
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
          url:"backend/load_asset_inv.php",
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

    function loadAllAssets() {
      $.ajax({
        url: "backend/load_asset_inv.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    loadAllAssets();

    $("#asset-inv-sch").keyup(function(){
      
      var input = $(this).val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();

      if(input != ""){
        $.ajax({

          url:"backend/asset_inv_rst.php",
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
          url:"backend/load_asset_inv.php",
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


$(document).ready(function(){

    function loadAllAssets() {
        $.ajax({
          url: "backend/load_asset_inv.php",
          method: "GET",
          success: function(data) {
            $("#searchresult").html(data);
          }
        });
    }

    const clear_search = document.querySelector("#clear-search");
    const searchbar = document.querySelector("#asset-inv-sch");

    const importAssetmodal = document.querySelector("#myModal");
    const importAssetBtn = document.querySelector('[id*="import_asset"]');
    const closeModalBtn = document.querySelectorAll('#closeModalBtn');

    const addAssetmodal = document.querySelector("#myModal2");
    const addAssetBtn = document.querySelector('[id*="add-submit"]');

    addAssetBtn.addEventListener('click', () => {

      addAssetmodal.style.display = "block";

    });

    importAssetBtn.addEventListener('click', () => {
    
        if(importAssetmodal.style.display === "none"){
    
            importAssetmodal.style.display = "block";
    
        }else{
    
            importAssetmodal.style.display = "none";
    
        }
    
    });

    clear_search.addEventListener('click', () => {
      const search_bar = document.querySelector("#asset-inv-sch");
      const filter_cat_field = document.querySelector("#filter-cat");
      const filter = document.querySelector("#filter-table");

      search_bar.value = "";

      filter_cat_field.selectedIndex =  0;
      filter.selectedIndex =  0;
      //reset ascending or descending
      flag = 0;
  
      var filter_cat = $("#filter-cat").val();

      $.ajax({
        url:"backend/asset_inv_filter.php",
        type:"POST",
        data:{filter_cat:filter_cat},
        success:function(data){
          $("#filter-table").html(data);
        }  
      });

        loadAllAssets();

    });

        // Table Column sort

        document.addEventListener('click', (event) => {

          var searchbar = $("#asset-inv-sch").val();
          var filter_cat = $("#filter-cat").val();
          var filter = $("#filter-table").val();
    
          if (event.target && event.target.id === "catg-col"){
        
            if(flag == 0){
              flag = 1;
            }else{
              flag = 0;
            }
    
            sort = "it_assets_tbl.Category";
    
            if(searchbar != ""){
              $.ajax({
                url:"backend/asset_inv_rst.php",
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
                url:"backend/load_asset_inv.php",
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
    
          }else if(event.target && event.target.id === "descr-col"){
    
            if(flag == 0){
              flag = 1;
            }else{
              flag = 0;
            }
    
            sort = "it_assets_tbl.Descr";
    
            if(searchbar != ""){
              $.ajax({
                url:"backend/asset_inv_rst.php",
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
                url:"backend/load_asset_inv.php",
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

    closeModalBtn.forEach(button => {

        button.addEventListener('click', () => {

            addAssetmodal.style.display = 'none';

        });

    });

});