$(document).ready(function(){

    function loadAllAcc() {
      $.ajax({
        url: "backend/load_useracc.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    loadAllAcc();
  
    $("#usr-sch").keyup(function(){
      
      var input = $(this).val();
      
      if(input != ""){
        $.ajax({
  
          url:"backend/useracc_rst.php",
          method:"POST",
          data:{input:input},
  
          success:function(data){
            $("#searchresult").html(data);
            $("#searchresult").css("display", "block");
          }
        });
      }else{
  
        loadAllAcc();
  
      }
  
    });
  
  });
  
  document.addEventListener('DOMContentLoaded', () => {
  
    function loadAllAcc() {
      $.ajax({
        url: "backend/load_useracc.php",
        method: "GET",
        success: function(data) {
          $("#searchresult").html(data);
        }
      });
    }
  
    const addAccountmodal = document.querySelector('#myModal');
    const deleteAccountmodal = document.querySelector("#myModal2");
    const editAccountmodal = document.querySelector("#myModal3");
    const closeModalBtn = document.querySelectorAll('#closeModalBtn');
    const clearSearch = document.querySelector('#clear-search');

    document.addEventListener('click', (event) => {

        if (event.target && event.target.id === "openModalBtn"){
            addAccountmodal.style.display = "block";

            const selectedRow = $(event.target).closest('tr');
            const cells = selectedRow.find('td');

            $('#hidden-id').val(cells.eq(0).text()); // Employee ID
            $('#hidden-pass').val(cells.eq(3).text() + cells.eq(0).text()); //Default Password
            $('#hidden-cpass').val(cells.eq(3).text() + cells.eq(0).text()); //Confirm Default Password
            $('#full-name').text(cells.eq(1).text()); // Full Name

        }else if (event.target && event.target.id === "deleteModalBtn"){
          deleteAccountmodal.style.display = "block";

          const selectedRow = $(event.target).closest('tr');
          const cells = selectedRow.find('td');

          $('#del-hidden-id').val(cells.eq(0).text()); // Employee ID
          $('#del-full-name').text(cells.eq(1).text()); // Full Name

        }else if (event.target && event.target.id === "editModalBtn"){
          editAccountmodal.style.display = "block";

          const selectedRow = $(event.target).closest('tr');
          const cells = selectedRow.find('td');

          $('#up-hidden-id').val(cells.eq(0).text()); // Employee ID
          $('#up-full-name').text(cells.eq(1).text()); // Full Name

        } 

    });

    closeModalBtn.forEach(button => {

        button.addEventListener('click', () => {

          // Set all modals to none/hidden
            addAccountmodal.style.display = "none";
            editAccountmodal.style.display = "none";
            deleteAccountmodal.style.display = "none";

        });

    });
  
    clearSearch.addEventListener('click', () => {
  
      const search_bar = document.querySelector("#usr-sch");
  
      search_bar.value = "";
  
      loadAllAcc();
  
    });
  
  });