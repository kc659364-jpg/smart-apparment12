<!DOCTYPE html>
<html lang="en">
<head>
    <title>Security Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="security.css" rel="stylesheet">
</head>
<body class="">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 card p-4 shadow-lg">
            <h2 class="text-center mb-4">🛡️ Security - Visitor Entry</h2>
            <form action="save-visitor.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="visitor_name" class="form-control" placeholder="Visitor Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="vehicle_no" class="form-control" placeholder="Vehicle Number">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="flat_no" class="form-control" placeholder="Flat Number" required>
                    </div>
                    <div class="col-md-12">
                        <select name="work_type" class="form-select" required>
                            <option value="">Select Work</option>
                            <option>Zomato/Swiggy</option>
                            <option>Amazon/Flipkart</option>
                            <option>Guest</option>
                            <option>Plumber/Electrician</option>
                        </select>
                    </div>
                    <div class="col-12 d-grid gap-2">
                        <button type="submit" name="save_entry" class="btn btn-success">Save Entry</button>
                        <a href="security-dashboard.php" class="btn btn-info">View All Entries</a>
                         <a href="login.html" class="btn btn-danger">LOG OUT</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>