$(document).ready(function(){

    function loadAllDisposed() {
        $.ajax({
        url: "backend/load_disposed.php",
        method: "GET",
        success: function(data) {
            $("#searchresult").html(data);
        }
        });
    }

    loadAllDisposed();

    $("#dis-sch").keyup(function(){
        
        var input = $(this).val();
        
        if(input != ""){
        $.ajax({

            url:"backend/disposed_rst.php",
            method:"POST",
            data:{input:input},

            success:function(data){
            $("#searchresult").html(data);
            $("#searchresult").css("display", "block");
            }
        });
        }else{

        loadAllDisposed();

        }

    });

});

document.addEventListener('DOMContentLoaded', () => {

    function loadAllDisposed() {
      $.ajax({
        url: "backend/load_disposed.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    const cancelEditAsset = document.querySelector('#canceledit_submit');
    const editAssetButton = document.querySelector('#edit-dis');
    const clearSearch = document.querySelector('#clear-search');
  
    cancelEditAsset.addEventListener('click', () => {
        
        const editAssetGUI = document.querySelector('.edit-rowGUI.overlay');
        const department = document.querySelector('#dept_add');
        const cost_center = document.querySelector('#ccenter');
  
        editAssetGUI.style.display = "none";
        department.selectedIndex = 0;
        cost_center.selectedIndex = 0;
  
    });
  
    editAssetButton.addEventListener('click', () => {
  
      const selectedCheckbox = $('input[type=checkbox]:checked');
      if (selectedCheckbox.length == 1) {
        const editEmployeeGUI = document.querySelector('.edit-rowGUI.overlay');
        editEmployeeGUI.style.display = "block";
      }else{
        alert("You can only edit one row at a time!");
      }
        
    });
  
    clearSearch.addEventListener('click', () => {
  
      const search_bar = document.querySelector("#dis-sch");
  
      search_bar.value = "";
  
      loadAllDisposed();
  
    });
  
});

$(document).ready(function () {
    const editButton = $('#edit-dis'); // assuming you have an edit button
  
    // Function to populate form fields from a selected row
    function populateFormFromRow(selectedCheckbox) {
      const selectedRow = selectedCheckbox.closest('tr');
      const cells = selectedRow.find('td');
  
      $('#dispose_ID').val(cells.eq(1).text()); // Asset ID
      $('#editAsset_no').val(cells.eq(2).text()); // Asset No

      const categoryValue = cells.eq(3).text(); // Category
      $('#category option').filter(function() {
        return $(this).text() === categoryValue;
      }).prop('selected', true);

      $('#desc').val(cells.eq(4).text()); // Description
      $('#serialno').val(cells.eq(5).text()); // Serial Number
      $('#editStat').val(cells.eq(6).text()); // Status
      $('#issuedate').val(cells.eq(7).text()); // Date
  
    }
  
    // Event listener for the Edit button
    editButton.click(function (event) {
      event.preventDefault(); // Prevent form submission
      const selectedCheckbox = $('input[type=checkbox]:checked');
      if (selectedCheckbox.length == 1) {
        populateFormFromRow(selectedCheckbox);
        // Trigger the change event on the "Department" dropdown to load Cost Centers
        // $('#dis_edit').change();
      }
    });
  
    
});