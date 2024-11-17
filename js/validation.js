document.getElementById("registerForm").addEventListener("submit", function(event) {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;
    const contactNumber = document.getElementById("contact_number").value.trim();
    const email = document.getElementById("email").value.trim();
    const address = document.getElementById("address").value.trim();

    // Basic validation
    if (username === "" || password === "" || contactNumber === "" || email === "" || address === "") {
        alert("All fields are required!");
        event.preventDefault();
    } else if (!/^\d{10}$/.test(contactNumber)) {
        alert("Please enter a valid 10-digit contact number.");
        event.preventDefault();
    } else if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        event.preventDefault();
    }
});
