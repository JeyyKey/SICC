document.addEventListener("DOMContentLoaded", () => {
    const nextButton = document.getElementById("next-btn");
    const form = document.getElementById("documentsForm");

    nextButton.addEventListener("click", (event) => {
        event.preventDefault(); // Prevent the default form submission
        
        // Submit the form using the submit() method to ensure file data is submitted
        form.submit(); // This submits the form

        // After the form is submitted, redirect to the receipt page
        window.location.href = "receipt.html"; // Redirect to receipt.html
    });
});
