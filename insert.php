
<?php

include "db.php";

$success = false;
$message = "";
$details = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $employee_id   = trim($_POST['employee_id'] ?? '');
    $employee_name = trim($_POST['employee_name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $department    = trim($_POST['department'] ?? '');
    $designation   = trim($_POST['designation'] ?? '');
    $salary        = $_POST['salary'] ?? '';
    $joining_date  = $_POST['joining_date'] ?? '';

    if (
        $employee_id === '' || $employee_name === '' ||
        $email === '' || $phone === '' ||
        $department === '' || $designation === '' ||
        $salary === '' || $joining_date === ''
    ) {
        $message = "Please fill in all employee details.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";

    } elseif (!is_numeric($salary) || $salary < 0) {
        $message = "Please enter a valid salary.";

    } else {

        $salary = (float)$salary;

        $sql = "INSERT INTO employees
        (employee_id, employee_name, email, phone,
        department, designation, salary, joining_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $message = "Database query error.";

        } else {

            $stmt->bind_param(
                "ssssssds",
                $employee_id,
                $employee_name,
                $email,
                $phone,
                $department,
                $designation,
                $salary,
                $joining_date
            );

            if ($stmt->execute()) {

                $success = true;
                $message = "Employee Registered Successfully!";

                $details = [
                    "Employee ID" => $employee_id,
                    "Employee Name" => $employee_name,
                    "Email" => $email,
                    "Phone Number" => $phone,
                    "Department" => $department,
                    "Designation" => $designation,
                    "Salary" => "₹" . number_format($salary, 2),
                    "Joining Date" => $joining_date
                ];

            } elseif ($stmt->errno == 1062) {
                $message = "This Employee ID already exists!";

            } else {
                $message = "Unable to save employee details.";
            }

            $stmt->close();
        }
    }

} else {
    $message = "Invalid request. Please submit the registration form.";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration Status - Blue Shift</title>

    <link rel="stylesheet" href="style.css">

    <style>
        .result-box {
            max-width: 650px;
            margin: 50px auto;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .result-box h1 {
            text-align: center;
            color: #2457a7;
            margin-bottom: 12px;
        }

        .success-message {
            text-align: center;
            color: #16805d;
            font-size: 17px;
            margin-bottom: 25px;
        }

        .error-message {
            text-align: center;
            color: #dc3545;
            font-size: 17px;
            margin-bottom: 25px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table th {
            background: #2457a7;
            color: white;
            padding: 13px;
            text-align: left;
        }

        .details-table td {
            padding: 13px;
            border-bottom: 1px solid #e5e5e5;
        }

        .details-table tr:nth-child(even) {
            background: #f4f7fb;
        }

        .result-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .result-buttons a {
            display: inline-block;
            padding: 12px 18px;
            background: #2457a7;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

        .result-buttons a:hover {
            background: #173e7c;
        }

        @media (max-width: 600px) {
            .result-box {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="result-box">

            <h1>Blue Shift</h1>

            <?php if ($success): ?>

                <p class="success-message">
                    ✓ <?php echo htmlspecialchars($message); ?>
                </p>

                <h3>Employee Details</h3>

                <table class="details-table">

                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>

                    <?php foreach ($details as $field => $value): ?>

                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($field); ?></strong>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($value); ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </table>

            <?php else: ?>

                <p class="error-message">
                    ✗ <?php echo htmlspecialchars($message); ?>
                </p>

            <?php endif; ?>

            <div class="result-buttons">

                <a href="index.html">Register Another Employee</a>

                <a href="employees.php">View Employees</a>

            </div>

        </div>

    </div>

</body>
</html>
