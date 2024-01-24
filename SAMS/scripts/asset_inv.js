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
  
    loadAllAssets();
  
    $("#asset-sch").keyup(function(){
      
      var input = $(this).val();
      
      if(input != ""){
        $.ajax({
  
          url:"backend/asset_rst.php",
          method:"POST",
          data:{input:input},
  
          success:function(data){
            $("#searchresult").html(data);
            $("#searchresult").css("display", "block");
          }
        });
      }else{
  
        loadAllAssets();
  
      }
  
    });

    $("#asset-inv-sch").keyup(function(){
      
        var inputs = $(this).val();
        
        if(inputs != ""){

            console.log(inputs);

          $.ajax({

            url:"backend/asset_rst.php",
            method:"POST",
            data:{inputs:inputs},
    
            success:function(data){
              $("#searchresult").html(data);
              $("#searchresult").css("display", "block");
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

    importAssetBtn.addEventListener('click', () => {
    
        if(importAssetmodal.style.display === "none"){
    
            importAssetmodal.style.display = "block";
    
        }else{
    
            importAssetmodal.style.display = "none";
    
        }
    
    });

    clear_search.addEventListener('click', () => {
        
        searchbar.value = "";
        loadAllAssets();

    });

    closeModalBtn.forEach(button => {

        button.addEventListener('click', () => {

            importAssetmodal.style.display = 'none';

        });

    });

});


