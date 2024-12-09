document.addEventListener("DOMContentLoaded", () => {
    const nextButton = document.getElementById("next-btn");

    nextButton.addEventListener("click", (event) => {
        event.preventDefault(); // Prevent the default form submission
        window.location.href = "documentsforms.html"; // Redirect to documentsforms.html
    });
});
