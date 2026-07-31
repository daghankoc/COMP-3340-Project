//get elements
const fileInput = document.getElementById('visuals');
const selectedFiles = document.getElementById('selectedvisuals');

//listen for change on file upload
fileInput.addEventListener('change', function () {
    
    //clean the div
    selectedFiles.innerHTML = '';

    //for each uploaded file
    Array.from(fileInput.files).forEach(function (file) {
        //show the uploaded files as h2 elements
        const fileName = document.createElement('h2');
        fileName.textContent = file.name;
        selectedFiles.appendChild(fileName);
    });
});