document.addEventListener('DOMContentLoaded', function () {
    var selectmodal = document.querySelector('#myModal');
    var addDeptmodal = document.querySelector('#myModal3');
    var deleteDeptmodal = document.querySelector('#myModal4');
    var addCcentermodal = document.querySelector('#myModal5');
    var editCcentermodal = document.querySelector('#myModal6');
    var deleteCcentermodal = document.querySelector('#myModal7');
    var openModalBtn = document.querySelectorAll('#openModalBtn');
    var closeModalBtn = document.querySelectorAll('#closeModalBtn');

    // Event listener to open the modal
    openModalBtn.forEach(button => {

        button.addEventListener('click', (event) => {
    
           selectmodal.style.display = 'block';
            var curRow = $(event.target).closest("tr");
            var row = curRow.find('td');
        
            $('#hidden-id').val(row.eq(0).text());
            $('#full-name').text(row.eq(1).text());
            $('#hidden-pass').val(row.eq(3).text() + row.eq(0).text());
            $('#hidden-cpass').val(row.eq(3).text() + row.eq(0).text());
    
        });
    
    });

    // Event listener to close the modal when clicking on the "x" button
    closeModalBtn.forEach(button => {

        button.addEventListener('click', () => {

            selectmodal.style.display = 'none';
            addDeptmodal.style.display = 'none';
            deleteDeptmodal.style.display = 'none';
            addCcentermodal.style.display = 'none';
            editCcentermodal.style.display = 'none';
            deleteCcentermodal.style.display = 'none';

        });

    });
});