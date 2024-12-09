// Function to toggle the visibility of forms
function toggleForm(formId) {
    var form = document.getElementById(formId);
    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block"; // Show the form
    } else {
        form.style.display = "none"; // Hide the form
    }
}

// Add event listeners for the buttons
document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to 'Add New Teacher' button
    document.getElementById("toggleStudentForm").addEventListener("click", function() {
        toggleForm('studentForm');
    });

    // Add event listener to 'Manage' button for Grade Level
    document.getElementById("toggleTeacherForm").addEventListener("click", function() {
        toggleForm('teacherForm');
    });

    // Add event listener to 'Create Announcement' button
    document.getElementById("toggleAnnouncementForm").addEventListener("click", function() {
        toggleForm('announcementForm');
    });
});
