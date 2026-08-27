<?php

require_once "database.php";

$sql = "SELECT
            id,
            employee_name,
            basic_salary,
            hours_worked,
            overtime_hours,
            regular_pay,
            overtime_pay,
            gross_salary
        FROM payroll
        ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error retrieving records: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Payroll Records</title>

<style>
    /* =========================
       RESET
    ========================= */
    * {
        box-sizing: border-box;
    }

    /* =========================
       BODY
    ========================= */
    body {
        margin: 0;
        min-height: 100vh;
        padding: 45px 25px;

        font-family: "Segoe UI", Arial, sans-serif;

        background:
            radial-gradient(
                circle at top left,
                rgba(59, 130, 246, 0.16),
                transparent 35%
            ),
            radial-gradient(
                circle at bottom right,
                rgba(99, 102, 241, 0.14),
                transparent 35%
            ),
            #eef2f7;

        color: #1e293b;
    }

    /* =========================
       MAIN CONTAINER
    ========================= */
    .container {
        width: 100%;
        max-width: 1350px;

        margin: 0 auto;
        padding: 35px;

        background: rgba(255, 255, 255, 0.97);

        border-radius: 22px;

        border: 1px solid rgba(255, 255, 255, 0.8);

        box-shadow:
            0 25px 60px rgba(15, 23, 42, 0.12),
            0 4px 12px rgba(15, 23, 42, 0.05);
    }

    /* =========================
       TITLE
    ========================= */
    h1 {
        margin: 0 0 28px;

        text-align: center;

        color: #172554;

        font-size: 29px;
        font-weight: 800;

        letter-spacing: -0.7px;
    }

    h1::after {
        content: "";

        display: block;

        width: 55px;
        height: 4px;

        margin: 12px auto 0;

        border-radius: 20px;

        background: linear-gradient(
            90deg,
            #2563eb,
            #6366f1
        );
    }

    /* =========================
       ADD PAYROLL BUTTON
    ========================= */
    .add-btn {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 150px;
        height: 46px;

        padding: 0 20px;

        margin-bottom: 22px;

        border-radius: 10px;

        background: linear-gradient(
            135deg,
            #2563eb,
            #4f46e5
        );

        color: #ffffff;

        text-decoration: none;

        font-size: 14px;
        font-weight: 700;

        box-shadow:
            0 7px 18px rgba(37, 99, 235, 0.20);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            filter 0.2s ease;
    }

    .add-btn:hover {
        filter: brightness(1.05);

        transform: translateY(-2px);

        box-shadow:
            0 11px 24px rgba(37, 99, 235, 0.27);
    }

    .add-btn:active {
        transform: translateY(0);
    }

    /* =========================
       TABLE WRAPPER
    ========================= */
    .table-container {
        width: 100%;

        overflow-x: auto;

        border-radius: 13px;

        border: 1px solid #e2e8f0;

        background: #ffffff;

        box-shadow:
            0 4px 14px rgba(15, 23, 42, 0.05);
    }

    /* =========================
       TABLE
    ========================= */
    table {
        width: 100%;

        min-width: 1050px;

        border-collapse: separate;
        border-spacing: 0;

        overflow: hidden;
    }

    /* =========================
       TABLE HEADER
    ========================= */
    th {
        height: 55px;

        padding: 0 15px;

        background: #172554;

        color: #ffffff;

        text-align: center;

        font-size: 13px;
        font-weight: 700;

        letter-spacing: 0.3px;

        white-space: nowrap;

        border: none;
    }

    th:first-child {
        border-top-left-radius: 12px;
    }

    th:last-child {
        border-top-right-radius: 12px;
    }

    /* =========================
       TABLE DATA
    ========================= */
    td {
        height: 54px;

        padding: 10px 15px;

        border: none;

        border-bottom: 1px solid #edf1f5;

        color: #475569;

        text-align: center;

        font-size: 14px;

        white-space: nowrap;
    }

    /* Employee name */
    td:nth-child(2) {
        color: #1e293b;

        font-weight: 600;

        text-align: left;
    }

    /* ID */
    td:first-child {
        color: #64748b;

        font-weight: 700;
    }

    /* Salary columns */
    td:nth-child(3),
    td:nth-child(6),
    td:nth-child(7),
    td:nth-child(8) {
        color: #1e293b;

        font-weight: 600;
    }

    /* =========================
       ALTERNATING ROWS
    ========================= */
    tr:nth-child(even) td {
        background: #f8fafc;
    }

    tr:nth-child(odd) td {
        background: #ffffff;
    }

    /* =========================
       ROW HOVER
    ========================= */
    tbody tr {
        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }

    tbody tr:hover td {
        background: #eff6ff;
    }

    /* =========================
       LAST ROW
    ========================= */
    tbody tr:last-child td {
        border-bottom: none;
    }

    /* =========================
       EMPTY RECORDS
    ========================= */
    td[colspan="8"] {
        height: 120px;

        color: #94a3b8;

        font-size: 15px;

        font-weight: 600;

        text-align: center;

        background: #ffffff !important;
    }

    /* =========================
       SCROLLBAR
    ========================= */
    .table-container::-webkit-scrollbar {
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f5f9;

        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;

        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 768px) {

        body {
            padding: 25px 12px;
        }

        .container {
            padding: 25px 18px;

            border-radius: 18px;
        }

        h1 {
            font-size: 23px;

            margin-bottom: 23px;
        }

        .add-btn {
            width: 100%;

            margin-bottom: 18px;
        }

        .table-container {
            border-radius: 10px;
        }
    }

    /* =========================
       SMALL MOBILE
    ========================= */
    @media (max-width: 480px) {

        body {
            padding: 15px 10px;
        }

        .container {
            padding: 22px 14px;
        }

        h1 {
            font-size: 20px;
        }

        th,
        td {
            font-size: 13px;
        }
    }
</style>
</head>

<body>

<div class="container">

    <h1>EMPLOYEE PAYROLL RECORDS</h1>

    <a href="index.php" class="add-btn">
        + ADD PAYROLL
    </a>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Employee</th>

                    <th>Basic Salary</th>

                    <th>Hours Worked</th>

                    <th>OT Hours</th>

                    <th>Regular Pay</th>

                    <th>OT Pay</th>

                    <th>Gross Salary</th>

                </tr>

            </thead>

            <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= $row["id"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row["employee_name"]) ?>
                        </td>

                        <td>
                            ₱<?= number_format(
                                $row["basic_salary"],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= $row["hours_worked"] ?>
                        </td>

                        <td>
                            <?= $row["overtime_hours"] ?>
                        </td>

                        <td>
                            ₱<?= number_format(
                                $row["regular_pay"],
                                2
                            ) ?>
                        </td>

                        <td>
                            ₱<?= number_format(
                                $row["overtime_pay"],
                                2
                            ) ?>
                        </td>

                        <td>
                            ₱<?= number_format(
                                $row["gross_salary"],
                                2
                            ) ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="8">
                        No payroll records found.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>

<?php

$conn->close();

?>