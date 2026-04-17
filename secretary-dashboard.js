document.addEventListener("DOMContentLoaded", function() {
    const block = localStorage.getItem("loginBlock");
    const blockStatus = document.getElementById("blockStatus");
    const ownerDiv = document.getElementById("ownerDetails");

    if (block) {
        blockStatus.innerHTML = `Showing Details for: <strong>Block ${block}</strong>`;
        
        // Loading status
        ownerDiv.innerHTML = '<div class="text-center my-4"><div class="spinner-border text-primary" role="status"></div><p>Loading Residents...</p></div>';

        // Backend se data mangwana
        fetch(`get-residents.php?block=${encodeURIComponent(block)}`)
            .then(response => {
                if (!response.ok) throw new Error('Database Error');
                return response.text();
            })
            .then(data => {
                ownerDiv.innerHTML = data; // Table yahan insert ho jayegi
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                ownerDiv.innerHTML = `<div class="alert alert-danger">Error: Could not connect to database.</div>`;
            });

    } else {
        blockStatus.innerHTML = '<span class="text-danger">Session Expired</span>';
        ownerDiv.innerHTML = '<div class="alert alert-warning">Please login to continue.</div>';
        // Auto-redirect if you want:
        // window.location.href = "login.php";
    }
});

function logout() {
    localStorage.clear(); // Saara session data saaf karne ke liye
    window.location.href = "login.php"; // Apne login page ka sahi naam yahan likhein
}