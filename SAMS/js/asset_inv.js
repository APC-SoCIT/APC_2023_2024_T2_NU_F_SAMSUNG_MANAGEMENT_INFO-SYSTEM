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
  
});


const import_asset = document.querySelector("#import-asset");

import_asset.addEventListener('click', () => {

    const import_assetGUI = document.querySelector(".import-assetGUI");

    if(import_assetGUI.style.display === "none"){

        import_assetGUI.style.display = "block";
        console.log("Value: " + import_asset);

    }else{

        import_assetGUI.style.display = "none";

    }

});

      

