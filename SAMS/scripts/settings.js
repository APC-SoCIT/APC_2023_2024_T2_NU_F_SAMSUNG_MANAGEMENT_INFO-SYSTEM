 document.addEventListener('DOMContentLoaded', () => {
  
    const changepassBtn = document.querySelector('[id*="change-pass"]');
  
    const Changepassmodal = document.querySelector('#myModal8');

    const closeModalBtn = document.querySelectorAll('#closeModalBtn');

    const changepassSubmit = document.querySelector('[id*="change-pass"]');
  
    changepassBtn.addEventListener('click', () => {
  
      if(Changepassmodal.style.display === "none"){
        Changepassmodal.style.display = "block";
      }else{
        Changepassmodal.style.display = "none";
      }
  
    });
  
    closeModalBtn.forEach(button => {
  
      button.addEventListener('click', () => {

        Changepassmodal.style.display = "none";
 
      });
  
    });

    changepassSubmit.forEach(button => {
  
      button.addEventListener('click', () => {

        Changepassmodal.style.display = "none";
 
      });
  
    });
  });

  $(document).ready(function () {
    $('.toggle-password').on('click', function () {
      $(this).toggleClass('fa-eye fa-eye-slash');
      let inputField = $($(this).attr('toggle'));
      let fieldType = inputField.attr('type');
      
      // Toggle password visibility
      if (fieldType === 'password') {
        inputField.attr('type', 'text');
      } else {
        inputField.attr('type', 'password');
      }
    });
  });