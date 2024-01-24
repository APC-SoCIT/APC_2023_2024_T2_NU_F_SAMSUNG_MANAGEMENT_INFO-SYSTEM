$(document).ready(function(){

  function loadAllAssets() {
    $.ajax({
      url: "backend/load_asset.php",
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

  $("#sort-table").on('change', () => {
    var sort = $("#sort-table").val();
    var searchbar = $("#asset-sch").val();

    console.log("Hi");

    if(searchbar != ""){

      $.ajax({
        url:"backend/asset_rst.php",
        type:"POST",
        data:{sort:sort,
              input:searchbar},
        success:function(data){
          $("#searchresult").html(data)
          console.log("asset_rst");
        }
        
      });
      
    }else{

      $.ajax({
        url:"backend/load_asset.php",
        type:"POST",
        data:{sort:sort,
              input:searchbar},
        success:function(data){
          $("#searchresult").html(data)
          console.log("all asset");
        }
      });
    }
  })
  
});

  document.addEventListener('DOMContentLoaded', () => {

    function loadAllAssets() {
      $.ajax({
        url: "backend/load_asset.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    const closeModalBtn = document.querySelectorAll('#closeModalBtn');
    const addAssetBtn = document.querySelector('[id*="add-submit"]');
    const addAssetmodal = document.querySelector('#myModal');

    const assignAssetBtn = document.querySelector('[id*="assign-submit"]');
    const assignAssetmodal = document.querySelector('#myModal2');

    const editAssetBtn = document.querySelector('[id*="edit-row"]');
    const editAssetmodal = document.querySelector('#myModal3');

    const disposeAssetBtn = document.querySelector('[id*="dispose-submit"]');
    const disposeAssetmodal = document.querySelector('#myModal4');
    const clearSearch = document.querySelector('#clear-search');
    
  
    addAssetBtn.addEventListener('click', () => {
          
      addAssetmodal.style.display = 'block';  

    });

    closeModalBtn.forEach(button => {

      button.addEventListener('click', () => {

        addAssetmodal.style.display = 'none';
        if(addAssetmodal.style.display === 'none'){

          const assetType_txtfld = document.querySelector('#descr');
          const serial_txtfld = document.querySelector('#serial_no');
    
          assetType_txtfld.value = "";
          serial_txtfld.value = "";
        }

        assignAssetmodal.style.display = 'none';
        if(addAssetmodal.style.display === 'none'){

          const searchbar = document.querySelector('form.assign-assetform .emp-search-bar');
          searchbar.value= "";

          loadAllAssets();

        }

        editAssetmodal.style.display = 'none';
        if(editAssetmodal.style.display === 'none'){

          const asset_txtfld = document.querySelector('#editAsset_no');
          const catg_txtfld = document.querySelector('#category');
          const desc_txtfld = document.querySelector('#descr');
          const stat_txtfld = document.querySelector('#editStat');
          const date = document.querySelector('#issuedate');
    
          asset_txtfld.value = "";
          catg_txtfld.value = "";
          desc_txtfld.value = "";
          stat_txtfld.value = "";
          date.value = "";

        }

        disposeAssetmodal.style.display = 'none';

      });

    });

    assignAssetBtn.addEventListener('click', () => {

      const assignCheckbox = $('input[type=checkbox]:checked');

      if (assignCheckbox.length > 0) {
        assignAssetmodal.style.display = 'block';
      }else{
        alert("Please select at least 1 checkbox!");
      
      }
    });

    editAssetBtn.addEventListener('click', () => {

      const selectedCheckbox = $('input[type=checkbox]:checked');
      if (selectedCheckbox.length == 1) {

        editAssetmodal.style.display = 'block';

      }else{
        alert("You can only edit one row at a time!");
      }
        
    });
  
    clearSearch.addEventListener('click', () => {
  
      const search_bar = document.querySelector("#asset-sch");
  
      search_bar.value = "";
  
      loadAllAssets();
  
    });

    disposeAssetBtn.addEventListener('click', () => {

      const selectedCheckbox = $('input[type=checkbox]:checked');
      if (selectedCheckbox.length != 0) {
        
        disposeAssetmodal.style.display = "block";

      }else{
        alert("Please select atleast one asset to dispose!!");
      }

    });
  
  });

  $(document).ready(function() {
    $('[id*="assign-submit"]').click(function() {
        var checkedValues = [];
        var checkedIDs = [];
        
        // Loop through each checked checkbox
        $("input[type=checkbox]:checked").each(function() {
            checkedValues.push($(this).val());
            checkedIDs.push(this.id); // Use this.id to get the ID attribute
        });

        // Check if at least one checkbox is checked before proceeding
        if (checkedIDs.length > 0) {
            // Clear the existing list
            $("#resultList").empty();

            // Populate the list with the checked values
            for (var i = 0; i < checkedIDs.length; i++) {
                $("#resultList").append("<li>" + checkedIDs[i] + "</li>");
            }

            $("#hiddenInput").val(checkedValues.join(','));
        }
    });

    $('[id*="dispose-submit"]').click(function() {
      var checkedValues = [];
      var checkedIDs = [];
      
      // Loop through each checked checkbox
      $("input[type=checkbox]:checked").each(function() {
          checkedValues.push($(this).val());
          checkedIDs.push(this.id); // Use this.id to get the ID attribute
      });

      // Check if at least one checkbox is checked before proceeding
      if (checkedIDs.length > 0) {
          // Clear the existing list
          $("#disposeList").empty();

          // Populate the list with the checked values
          for (var i = 0; i < checkedIDs.length; i++) {
              $("#disposeList").append("<li>" + checkedIDs[i] + "</li>");
          }

          $("#hiddenDispose").val(checkedValues.join(','));
      }
    });
});


$(document).ready(function() {

  $('[id*="edit-row"]').click(function() {
      var checkedValues = [];
      var checkedIDs = [];
      
      // Loop through each checked checkbox and store its value in the array
      $("input[type=checkbox]:checked").each(function() {
          checkedValues.push($(this).val());
      });

      // Loop through each checked checkbox and store its id (ID) in the array
      $("input[type=checkbox]:checked").each(function() {
          checkedIDs.push(this.id); // Use this.id to get the ID attribute
      });

      // Clear the existing list
      $("#resultList").empty();

      // Populate the list with the checked values
      for (var i = 0; i < checkedIDs.length; i++) {
          $("#resultList").append("<li>" + checkedIDs[i] + "</li>");
      }

      $("#hiddenInput").val(checkedValues.join(','));
  });

});


//Load employees for Assign GUI

$(document).ready(function(){

  function loadAllEmployees() {
    $.ajax({
      url: "backend/assign_employees.php",
      method: "GET",
      success: function(data) {
        $("#search_employee").html(data);
      }
    });
  }

  loadAllEmployees();

  $("#emp-sch").keyup(function(){
    
    var input = $(this).val();
    
    if(input != ""){
      $.ajax({

        url:"backend/assign_emp_rst.php",
        method:"POST",
        data:{input:input},

        success:function(data){
          $("#search_employee").html(data);
          $("#search_employee").css("display", "block");
        }
      });
    }else{

      loadAllEmployees();

    }

  });

});

$(document).ready(function() {
  // Get references to the search bar and hidden input
  var $searchbar = $("#asset-sch");
  var $searchbar_cont = $("#searchbar_cont");

  // Listen for the input event on the search bar
  $searchbar.on("input", function() {
    // Update the hidden input's value with the current search bar value
    $searchbar_cont.val($searchbar.val());
  });
});

$(document).ready(function () {
  const editButton = $('[id*="edit-row"]'); // assuming you have an edit button

  // Function to populate form fields from a selected row
  function populateFormFromRow(selectedCheckbox) {
    const selectedRow = selectedCheckbox.closest('tr');
    const cells = selectedRow.find('td');

    $('#assetid').val(cells.eq(1).text()); // Asset ID
    $('#editAsset_no').val(cells.eq(2).text()); // Asset No.

    const categoryValue = cells.eq(3).text(); // Category
    $('#category option').filter(function() {
      return $(this).text() === categoryValue;
    }).prop('selected', true);

    $('#desc').val(cells.eq(4).text()); // Description
    $('#serialno').val(cells.eq(5).text()); // Serial No.
    $('#editStat').val(cells.eq(10).text()); // Status
    $('#issuedate').val(cells.eq(11).text()); //Issued Date
  }

  // Add an event listener to the Edit button
  editButton.click(function (event) {
    event.preventDefault(); // Prevent form submission
    const selectedCheckbox = $('input[type=checkbox]:checked');
    if (selectedCheckbox.length == 1) {
      populateFormFromRow(selectedCheckbox);
    }
  });
});
