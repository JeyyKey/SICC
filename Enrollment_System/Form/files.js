document.getElementById("download-pdf-btn").addEventListener("click", function() {
    // Fetch the content of the current page (index.html)
    fetch("Form.html") // Adjust the path if necessary
      .then(response => response.text())
      .then(htmlString => {
        // Create a temporary element to hold the HTML string
        const tempContainer = document.createElement("div");
        tempContainer.innerHTML = htmlString;
  
        // Find the specific section to print (in this case, the entire form container)
        const printableContent = tempContainer.querySelector(".form-container");
  
        if (printableContent) {
          // Use html2pdf to generate the PDF
          html2pdf()
            .set({
              margin: 10, // Adjust margins as desired
              filename: 'StudentInformation_form.pdf',
            })
            .from(printableContent)
            .save();
        } else {
          console.error("Could not find the form container on the page.");
        }
      })
      .catch(error => {
        console.error("Error fetching the page content:", error);
      });
  });