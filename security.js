// =========================
// GET DATA FROM STORAGE
// =========================
let visitors = JSON.parse(localStorage.getItem("visitors")) || [];


// =========================
// SAVE ENTRY (SECURITY PAGE)
// =========================
let form = document.getElementById("visitorForm");

if (form) {
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        let name = document.getElementById("visitorName").value;
        let flat = document.getElementById("flatNumber").value;
        let mobile = document.getElementById("mobilenumber").value;
        let work = document.getElementById("work").value;
        let time = new Date().toLocaleString();

        let visitor = {
            name: name,
            flat: flat,
            mobile: mobile,
            work: work,
            time: time
        };

        visitors.push(visitor);

        // SAVE PERMANENTLY
        localStorage.setItem("visitors", JSON.stringify(visitors));

        alert("Visitor Saved ✅");

        form.reset();
    });
}


// =========================
// SHOW DATA (SECRETARY PAGE)
// =========================
function showVisitors(data) {
    let table = document.getElementById("visitorTable");

    if (!table) return;

    table.innerHTML = "";

    data.forEach(function(v) {
        table.innerHTML += `
            <tr>
                <td>${v.name}</td>
                <td>${v.flat}</td>
                <td>${v.mobile}</td>
                <td>${v.work}</td>
                <td>${v.time}</td>
            </tr>
        `;
    });
}

// PAGE LOAD PE DATA SHOW
showVisitors(visitors);


// =========================
// SEARCH FUNCTION
// =========================
let search = document.getElementById("searchFlat");

if (search) {
    search.addEventListener("keyup", function() {
        let value = search.value.toLowerCase();

        let filtered = visitors.filter(function(v) {
            return v.flat.toLowerCase().includes(value);
        });

        showVisitors(filtered);
    });
}