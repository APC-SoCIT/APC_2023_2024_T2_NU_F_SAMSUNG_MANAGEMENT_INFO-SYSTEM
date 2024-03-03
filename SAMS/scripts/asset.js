//Global Variable for sorting and filtering
var sort = "";
// Set if ascending (1) or descending (0)
var flag = 0;

$(document).ready(function(){

  //Function for filtering

  //Filter Category on change lister for actual filter
  $("#filter-cat").on('change', () => {
    var filter_cat = $("#filter-cat").val();
    var searchbar = $("#asset-sch").val();

    $('#filter_cat').val(filter_cat);
    $('#filter').val("");


    //On change of the filter category, ensure that the actual filter is back to none for the selected option
    const filter_field = document.querySelector("#filter-table");
    filter_field.selectedIndex =  0;

    $.ajax({
      url:"backend/asset_filter.php",
      type:"POST",
      data:{filter_cat:filter_cat},
      success:function(data){
        $("#filter-table").html(data);
      }  
    });

    if(searchbar != ""){
      $.ajax({
        url:"backend/asset_rst.php",
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
        url:"backend/load_asset.php",
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
    var searchbar = $("#asset-sch").val();
    var filter_cat = $("#filter-cat").val();
    var filter = $("#filter-table").val();

    $('#filter').val(filter);

    if(searchbar != ""){
      $.ajax({
        url:"backend/asset_rst.php",
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
        url:"backend/load_asset.php",
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
      url: "backend/load_asset.php",
      method: "GET",
      success: function(data) {
        $("#searchresult").html(data);
      }
    });
  }
  
  loadAllAssets();
  
  // Function for search bar

  $("#asset-sch").keyup(function(){
    var input = $(this).val();
    var filter_cat = $("#filter-cat").val();
    var filter = $("#filter-table").val();

    if(input != ""){
      $.ajax({

        url:"backend/asset_rst.php",
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
        url:"backend/load_asset.php",
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

    const assignAssetBtn = document.querySelector('[id*="assign-submit"]');
    const assignAssetmodal = document.querySelector('#myModal2');

    const editAssetBtn = document.querySelector('[id*="edit-row"]');
    const editAssetmodal = document.querySelector('#myModal3');

    const disposeAssetBtn = document.querySelector('[id*="dispose-submit"]');
    const disposeAssetmodal = document.querySelector('#myModal4');
    const clearSearch = document.querySelector('#clear-search');

    closeModalBtn.forEach(button => {

      button.addEventListener('click', () => {

        
        if(assignAssetmodal.style.display = 'none'){

          const searchbar = document.querySelector('form.assign-assetform #emp-sch');
          searchbar.value = "";

          loadAllAssets();

        }

        
        if(editAssetmodal.style.display = 'none'){

          const asset_txtfld = document.querySelector('#editAsset_no');
          const catg_txtfld = document.querySelector('#category');
          const desc_txtfld = document.querySelector('#desc');
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

      const assignCheckbox = $('input[type=checkbox]:checked').not('#switch-mode');

      if (assignCheckbox.length > 0) {
        assignAssetmodal.style.display = 'block';
      }else{
        alert("Please select at least 1 checkbox!");
      
      }
    });

    editAssetBtn.addEventListener('click', () => {

      const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
      if (selectedCheckbox.length == 1) {

        editAssetmodal.style.display = 'block';

      }else{
        alert("You can only edit one row at a time!");
      }
        
    });
  
    clearSearch.addEventListener('click', () => {
  
      const search_bar = document.querySelector("#asset-sch");
      const filter_cat_field = document.querySelector("#filter-cat");
      const filter = document.querySelector("#filter-table");

      search_bar.value = "";

      filter_cat_field.selectedIndex =  0;
      filter.selectedIndex =  0;
      //reset ascending or descending
      flag = 0;
  
      var filter_cat = $("#filter-cat").val();

        //reset report form values
        $('#sort').val("");
        $('#flag').val("");
        $('#filter_cat').val("");
        $('#filter').val("");

      $.ajax({
        url:"backend/asset_filter.php",
        type:"POST",
        data:{filter_cat:filter_cat},
        success:function(data){
          $("#filter-table").html(data);
        }  
      });

      loadAllAssets();
  
    });

    disposeAssetBtn.addEventListener('click', () => {

      const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
      if (selectedCheckbox.length != 0) {
        
        disposeAssetmodal.style.display = "block";

      }else{
        alert("Please select atleast one asset to dispose!!");
      }

    });

    // Table Column sort

    document.addEventListener('click', (event) => {

      var searchbar = $("#asset-sch").val();
      var filter_cat = $("#filter-cat").val();
      var filter = $("#filter-table").val();

      if (event.target && event.target.id === "id-col"){
    
        if(flag == 0){
          flag = 1;
        }else{
          flag = 0;
        }

        sort = "assigned_assets_tbl.Asset_ID";

        // Set input column and flag generate report
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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

        sort = "assigned_assets_tbl.Stat";
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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

        sort = "assigned_assets_tbl.Issued_Date";
        $('#sort').val(sort);
        $('#flag').val(flag);

        if(searchbar != ""){
          $.ajax({
            url:"backend/asset_rst.php",
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
            url:"backend/load_asset.php",
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

  $(document).ready(function() {
    $('[id*="assign-submit"]').click(function() {
        var checkedValues = [];
        var checkedIDs = [];
        
        // Loop through each checked checkbox
        $("input[type=checkbox]:checked:not(#switch-mode)").each(function() {
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
      $("input[type=checkbox]:checked:not(#switch-mode)").each(function() {
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
  // Get references to the search bar and hidden input
  var $searchbar = $('id*="asset-sch"'); 
  var $searchbar_cont = $("#searchbar_cont");

  // Listen for the input event on the search bar
  $searchbar.on("input", function() {
    // Update the hidden input's value with the current search bar value
    $searchbar_cont.val($searchbar.val());
  });
});


$(document).ready(function() {

  $('[id*="edit-row"]').click(function() {
      var checkedValues = [];
      var checkedIDs = [];
      
      // Loop through each checked checkbox and store its value in the array
      $("input[type=checkbox]:checked:not(#switch-mode)").each(function() {
          checkedValues.push($(this).val());
      });

      // Loop through each checked checkbox and store its id (ID) in the array
      $("input[type=checkbox]:checked:not(#switch-mode)").each(function() {
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

// Searchbar
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

// EDIT
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
    const selectedCheckbox = $('input[type=checkbox]:checked:not(#switch-mode)');
    if (selectedCheckbox.length == 1) {
      populateFormFromRow(selectedCheckbox);
    }
  });

  // Event Handler to toggle checkbox when clicking entire row

  document.addEventListener('click', (event) => {

    if (event.target && event.target.tagName === "TD"){

      // Find the tr that contains the clicked td
      var row = event.target.parentNode;
      
      // Find the checkbox within that tr
      var checkbox = row.querySelector('input[type="checkbox"]:not(#switch-mode)');
      var radio = row.querySelector('input[type="radio"]');

      // Toggle the radio state

      if(radio){
        radio.checked = !radio.checked;
        row.style.backgroundColor = radio.checked ? 'var(--selectrow)' : '';
      }
      
      // Toggle the checkbox state
      if (checkbox){
        checkbox.checked = !checkbox.checked;
        row.style.backgroundColor = checkbox.checked ? 'var(--selectrow)' : '';
      }

    }

  });

});