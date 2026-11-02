
<?php

include "db.php";



$sql = "SELECT * FROM employees ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee List</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    min-height: 100vh;
    background: linear-gradient(135deg, #eef3f8, #dce7f1);
    padding: 40px 25px;
    color: #333;
}

/* MAIN CONTAINER */

.container {
    width: 100%;
    max-width: 1250px;
    margin: auto;
}

/* HEADER */

h1 {
    text-align: center;
    color: #172b4d;
    font-size: 32px;
    margin-bottom: 8px;
}

.subtitle {
    text-align: center;
    color: #6b7280;
    font-size: 15px;
    margin-bottom: 30px;
}

/* TOP ACTION AREA */

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

/* ADD EMPLOYEE BUTTON */

.add-btn {
    display: inline-block;
    padding: 12px 20px;
    background: #1d3557;
    color: white;
    text-decoration: none;
    border-radius: 7px;
    font-size: 14px;
    font-weight: bold;
    transition: 0.3s;
}

.add-btn:hover {
    background: #457b9d;
    transform: translateY(-1px);
}

/* TABLE CARD */

.table-box {
    background: white;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.10);
    overflow-x: auto;
}

/* TABLE */

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 950px;
}

/* TABLE HEADER */

th {
    background: #1d3557;
    color: white;
    padding: 15px 12px;
    text-align: left;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

/* ROUNDED HEADER CORNERS */

th:first-child {
    border-radius: 7px 0 0 0;
}

th:last-child {
    border-radius: 0 7px 0 0;
}

/* TABLE DATA */

td {
    padding: 14px 12px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
    color: #374151;
    white-space: nowrap;
}

/* ALTERNATE ROW */

tr:nth-child(even) {
    background: #f8fafc;
}

/* ROW HOVER */

tr:hover td {
    background: #eef5fb;
}

/* EMPLOYEE ID */

td:first-child {
    font-weight: bold;
    color: #1d3557;
}

/* SALARY */

td:nth-last-child(2) {
    font-weight: bold;
    color: #198754;
}

/* NO DATA */

.no-data {
    text-align: center;
    padding: 35px;
    color: #777;
    font-size: 15px;
}

/* RESPONSIVE */

@media (max-width: 768px) {

    body {
        padding: 25px 15px;
    }

    h1 {
        font-size: 26px;
    }

    .subtitle {
        font-size: 14px;
    }

    .table-box {
        padding: 15px;
        border-radius: 10px;
    }

    .add-btn {
        width: 100%;
        text-align: center;
    }
}

</style>


</head>


<body>

    <div class="container">

        <h1>Registered Employees</h1>

        <p class="subtitle">
            BLUE SHIFT
        </p>


        <div class="top-bar">

    <a href="index.html" class="add-btn">
        + Add New Employee
    </a>

</div>

<div class="table-box">

            <table>

                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Joining Date</th>
                </tr>


                <?php

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row['employee_id']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['employee_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['phone']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['department']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['designation']); ?>
                    </td>

                    <td>
                        ₹<?php echo htmlspecialchars($row['salary']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['joining_date']); ?>
                    </td>

                </tr>

                <?php

                    }

                } else {

                    echo "<tr>
                            <td colspan='8' class='no-data'>
                                No employees registered yet.
                            </td>
                          </tr>";

                }

                ?>

            </table>

        </div>

    </div>

</body>

</html>

<?php

$conn->close();

?>
