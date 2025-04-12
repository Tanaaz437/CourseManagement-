document.addEventListener("DOMContentLoaded", function () {
    var menuItems = document.querySelectorAll(".menu a");
    menuItems.forEach(item => {
        item.addEventListener("click", function(event) {
            menuItems.forEach(i => {
                i.classList.remove("greyout"); // Remove greyout class from all items
            });
            this.classList.add("greyout"); // Add greyout class to the clicked item
        });
    });
});


function showDropdown(button){
    var dropdown_content=button.nextElementSibling;
    dropdown_content.classList.toggle("show");

} 
window.onclick=function(event){
    if(!event.target.matches('.dropdown button')){
        var dropdown_contents=document.querySelectorAll(".dropdown-content");
        for(var i=0;i<dropdown_contents.length;i++){
            var displayingContents=dropdown_contents[i];
            if(displayingContents.classList.contains('show')){
                displayingContents.classList.remove('show');

            }
        }

    }

}




function viewCourses() {
    /* Admin/Student_Show_course.php */
    window.location.href = "/Admin/Student/Student_Show_course.php";
}

function editStudent() {
    window.location.href = "/Admin/Student/Student_Edit_course.php";
}

function deleteStudent(element) {
    var confirmation = confirm("Are you sure you want to delete this student?");
    if (confirmation) {
        var row = element.closest("tr");
        row.parentNode.removeChild(row);
    }
}







  /* group slots */



  // script.js for group slots

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.menu-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the click from propagating to the document
            
            // Get the next sibling which is the menu
            const menu = this.nextElementSibling;

            // Hide all other menus
            document.querySelectorAll('.group-menu').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });

            // Toggle the visibility of the current menu
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Hide the menu when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.group-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    });
});  /* group slot ends here */


/* javascrip of teacher button */

/*  edit redirection in edit button */


/* delete button of teacher interface */
function deleteTeacher(id) {
    if (confirm('Are you sure you want to delete this teacher?')) {
        window.location.href = '/Admin/delete_teacher.php?id=' + id;
    }
}

 function closeteacher(){
    window.location.href="teacher.php";
 }




document.querySelector('.add-teacher ul').addEventListener('click', function() {
    document.getElementById('teacher-form').classList.toggle('hidden');
});

   document.getElementById('add-teacher-form').addEventListener('submit', function(e) {
    e.preventDefault();

   /*  document.querySelector('.form-element').addEventListener('submit', function(e) {
        e.preventDefault(); */

    var formData = new FormData(this);

    fetch('process_add_teacher.php', {   /* add_teacher_form.php */
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${data.no}</td>
                <td>${data.mid}</td>
                <td>${data.first_name} ${data.last_name}</td>
                <td>${data.email}</td>
                <td>${data.designation}</td>
                <td>${data.faculty}</td>
                <td>
                    <button onclick="Edit(${data.id})">Edit</button>
                    <button onclick="Delete(${data.id})">Delete</button>
                </td>
            `;

            document.querySelector('table tbody').appendChild(newRow);

            document.getElementById('teacher-form').classList.add('hidden');
            document.getElementById('add-teacher-form').reset();
        } else {
            alert('Failed to add teacher');
        }
    })
    .catch(error => console.error('Error:', error));
});








/* border box in add teacher form */

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('add-teacher-form');

    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Get all form elements
        const elements = form.querySelectorAll('input[required], select[required]');
        
        elements.forEach(element => {
            if (!element.value) {
                element.style.border = '2px solid red'; // Highlight invalid fields
                isValid = false;
            } else {
                element.style.border = ''; // Reset border if valid
            }
        });

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if invalid
        }
    });

    // Reset border on focus for valid input
    form.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('focus', function() {
            this.style.border = ''; // Reset border on focus
        });
    });
});

/* modal js for bulk upload */

// Function to open the modal
function openModal() {
    document.getElementById("bulkupload").style.display = "block";
}

// Function to close the modal
function closeModal() {
    document.getElementById("bulkupload").style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    if (event.target === document.getElementById("bulkupload")) {
        closeModal();
    }
}



/* group javascript */

function Close(){
    window.location.href="group.php";
}

document.addEventListener('DOMContentLoaded', function () {
    const addGroupBtn = document.getElementById('add-group-btn');
    const groupList = document.getElementById('group-list');

    // Function to create a new group item dynamically
    function addNewGroup() {
        // Create group-item container
        const groupItem = document.createElement('div');
        groupItem.classList.add('group-item');

        // Create h2 element for the time slot
        const timeSlot = document.createElement('h2');
        timeSlot.textContent = 'New Group Time Slot';

        // Create the vertical ellipsis (menu button)
        const menuButton = document.createElement('i');
        menuButton.classList.add('fa-solid', 'fa-ellipsis-vertical', 'menu-button');

        // Create the group menu (edit and delete options)
        const groupMenu = document.createElement('div');
        groupMenu.classList.add('group-menu');

        const menuList = document.createElement('ul');

        const editOption = document.createElement('li');
        editOption.classList.add('edit-option');
        editOption.textContent = 'Edit';

        const deleteOption = document.createElement('li');
        deleteOption.classList.add('delete-option');
        deleteOption.textContent = 'Delete';
        deleteOption.addEventListener('click', function () {
            groupItem.remove(); // Remove the group item when clicked
        });

        // Append options to the menu list
        menuList.appendChild(editOption);
        menuList.appendChild(deleteOption);
        groupMenu.appendChild(menuList);

        // Append elements to the group item
        groupItem.appendChild(timeSlot);
        groupItem.appendChild(menuButton);
        groupItem.appendChild(groupMenu);

        // Append the new group item to the group list
        groupList.appendChild(groupItem);
    }

    // Attach event listener to the add button
    addGroupBtn.addEventListener('click', addNewGroup);
});


    
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'block';
        } else {
            dropdownMenu.style.display = 'none';
        }
    }
    
    window.onclick = function(event) {
        var dropdownMenu = document.getElementById('dropdown-menu');
        if (!event.target.matches('.user-button')) {
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    }
   
    
    /* courses  js */

    //for teacher delete button
function deleteTeacher(id) {
    if (id) {  // Ensure that the id is valid
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this teacher? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete teacher script if confirmed
                window.location.href = 'delete_teacher.php?id=' + id;
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid teacher ID.'
        });
    }
}

//for course delete button
function deleteCourse(id) {
    if (id) {  // Ensure that the id is valid
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this course? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete course script if confirmed
                window.location.href = 'delete_course.php?id=' + id;
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid course ID.'
        });
    }
}

//for functionality of checkbox in course visibilty input
 document.addEventListener('DOMContentLoaded', function () {
    const dropdownInput = document.querySelector('.dropdown-input');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const checkboxes = dropdownMenu.querySelectorAll('input[type="checkbox"]');

    // Toggle dropdown menu visibility when the input field is clicked
    dropdownInput.addEventListener('click', function () {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Close the dropdown menu when clicking outside of it
    document.addEventListener('click', function (event) {
        if (!dropdownInput.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });

    // Update the input field with selected options
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const selectedOptions = [];
            checkboxes.forEach(function (cb) {
                if (cb.checked) {
                    selectedOptions.push(cb.value);
                }
            });
            dropdownInput.value = selectedOptions.join(', ');
        });
    });
});



/* reset javascrpt
 */

function toggleDropdown() {
    const dropdownMenu = document.getElementById('dropdown-menu');
    
    // Toggle the 'show' class to display or hide the dropdown menu
    if (dropdownMenu.classList.contains('show')) {
        dropdownMenu.classList.remove('show');
    } else {
        dropdownMenu.classList.add('show');
    }
}

// Hide the dropdown menu if clicked outside
document.addEventListener('click', function(event) {
    const dropdownMenu = document.getElementById('dropdown-menu');
    const dropdownInput = document.getElementById('visible-input');

    // Check if the click is outside the dropdown input and menu
    if (!dropdownInput.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.remove('show');
    }
});


function CloseCOurse(){
    window.location.href ='course.php';
    
}

function CloseEdit(){
    window.location.href='course.php';
}


/* user loging javascript */


        const passwordField = document.getElementById('student-password');
        const togglePassword = document.getElementById('toggle-password');

        // Toggle password visibility
        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle icon between eye and eye-slash
            this.classList.toggle('fa-eye-slash');
        });
function TeacherClose(){
    window.location.href='teacher.php';
}


/* groupslots stylin */

document.addEventListener('DOMContentLoaded', () => {
    const groupItems = document.querySelectorAll('.group-item');

    groupItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = 1;
            item.style.transform = 'translateY(0)';
        }, index * 150); // Staggered animation with a bit more delay for smooth effect
    });
});

/*  js for navabar */
// Function to set dynamic navbar colors
function setNavbarColors(bgColor, textColor, linkColor, linkHoverColor) {
    document.documentElement.style.setProperty('--navbar-bg-color', bgColor);
    document.documentElement.style.setProperty('--navbar-text-color', textColor);
    document.documentElement.style.setProperty('--navbar-link-color', linkColor);
    document.documentElement.style.setProperty('--navbar-link-hover-color', linkHoverColor);
}



setNavbarColors('#2c3e50', '#ecf0f1', '#3498db', '#e74c3c'); // Dark background, light text, blue links, red hover
    


/* loggout  page functionaloty */

/* <!-- SweetAlert and JavaScript logout logic --> */

function toggleDropdown() {
    var dropdown = document.getElementById('logout-dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the user registration page after logout
            /* window.location.href ='../User_registration/user.php'; */
            window.location.href = '/Admin/Logging.php'; 


        }
    });
}






// Optional: Close the dropdown if clicked outside
window.onclick = function(event) {
    if (!event.target.matches('.user-button')) {
        var dropdown = document.getElementById("logout-dropdown");
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        }
    }
};



/*  eye in login page */
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('student-password');

    togglePassword.addEventListener('click', function() {
        // Toggle the password field type
        if (passwordField.type === 'password') {
            passwordField.type = 'text'; // Show password
            togglePassword.classList.remove('fa-eye-slash');
            togglePassword.classList.add('fa-eye');
        } else {
            passwordField.type = 'password'; // Hide password
            togglePassword.classList.remove('fa-eye');
            togglePassword.classList.add('fa-eye-slash');
        }
    });
});

        function toggleDropdown() {
            document.getElementById("logout-dropdown").style.display = 
                document.getElementById("logout-dropdown").style.display === "none" ? "block" : "none";
        }

        /* function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to log out!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log out!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/logout.php'; 
                }
            });
        } */

        function openModal() {
            document.getElementById('bulkupload').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('bulkupload').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('bulkupload')) {
                closeModal();
            }
        };

        function viewCourses(studentId) {
            // Open a new window or redirect to the view courses page
            window.location.href = "view_courses.php?id=" + studentId; // Adjust URL accordingly
        }

        function editStudent(studentId) {
            // Redirect to the edit student page
            window.location.href = "edit_student.php?id=" + studentId; // Adjust URL accordingly
        }

        function confirmDelete(studentId, studentName) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete ' + studentName + '!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete page or execute delete action via AJAX
                    window.location.href = 'delete_student.php?id=' + studentId; 
                }
            });
        }
        
        


// Function to toggle the dropdown visibility
function toggleDropdown() {
    var dropdown = document.getElementById('logout-dropdown');
    dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
}

// Close the dropdown when clicking anywhere outside of it
document.addEventListener('click', function(event) {
    var dropdown = document.getElementById('logout-dropdown');
    var button = document.querySelector('.user-button');
    
    // Check if the click is outside of the dropdown or the button
    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

function Back(){
    window.location.href="/Admin/home.php";
}


/* JavaScript (For Show/Hide Password) */
document.getElementById("togglePassword").addEventListener("click", function() {
    let passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");
    }
});
