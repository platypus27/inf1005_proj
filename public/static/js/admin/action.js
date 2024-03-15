$(".userAction").submit(function(e){
    e.preventDefault(); // Prevent the default form submission behavior
    var form_data = $(this).serialize(); // Serialize the form data
    var btn = $(this).find("input[type=submit]:focus").attr('name'); // Get the name attribute of the focused submit button
    form_data += "&button=" + btn; // Append the name of the focused submit button to the form data
    console.log(form_data); // Log the form data (for testing purposes)
    var post_url = "/admin/action"; // Define the URL to post the form data
    $.post( // Send a POST request
        post_url,
        form_data, // Form data to be sent
        function(data, status){ // Callback function to handle the response
            alert("Successfully performed requested action"); // Display a success message
            location.reload(); // Reload the page to reflect changes
        }
    );
});