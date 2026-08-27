<?php 
 
require_once "database.php"; 
 
if ($_SERVER["REQUEST_METHOD"] !== "POST") { 
    header("Location: index.php"); 
    exit; 
} 
 
/* Get form values */ 
 
$employee_name = trim($_POST["employee_name"] ?? ""); 
$basic_salary = (float) ($_POST["basic_salary"] ?? 0); 
$hours_worked = (int) ($_POST["hours_worked"] ?? 0); 
$overtime_hours = (int) ($_POST["overtime_hours"] ?? 0); 
 
 
/* Validate */ 
 
if ( 
    $employee_name === "" || 
    $basic_salary < 0 || 
    $hours_worked < 0 || 
    $overtime_hours < 0 
) { 
    die("Invalid input. Please enter valid information."); 
} 
 
 
/*  
   PAYROLL COMPUTATION 
 
   Hourly Rate = Basic Salary / 8 
*/ 
 
$hourly_rate = $basic_salary / 8; 
 
 
/* 
   Regular Pay = Hourly Rate × Hours Worked 
*/ 
 
$regular_pay = $hourly_rate * $hours_worked; 
 
 
/* 
   Overtime Rate = Hourly Rate × 1.25 
*/ 
 
$overtime_rate = $hourly_rate * 1.25; 
 
 
/* 
   Overtime Pay = Overtime Rate × Overtime Hours 
*/ 
 
$overtime_pay = $overtime_rate * $overtime_hours; 
 
 
/* 
   Gross Salary = Regular Pay + Overtime Pay 
*/ 
 
$gross_salary = $regular_pay + $overtime_pay; 
 
 
/* Save to database */ 
 
$sql = "INSERT INTO payroll 
        ( 
            employee_name, 
            basic_salary, 
            hours_worked, 
            overtime_hours, 
            regular_pay, 
            overtime_pay, 
            gross_salary 
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?)"; 
 
$stmt = $conn->prepare($sql); 
 
if (!$stmt) { 
    die("SQL Prepare Error: " . $conn->error); 
} 
 
 
$stmt->bind_param( 
    "sdidddd", 
    $employee_name, 
    $basic_salary, 
    $hours_worked, 
    $overtime_hours, 
    $regular_pay, 
    $overtime_pay, 
    $gross_salary 
); 
 
 
if (!$stmt->execute()) { 
    die("SQL Insert Error: " . $stmt->error); 
} 
 
 
$stmt->close(); 
$conn->close(); 
 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
 
    <meta charset="UTF-8"> 
 
    <meta name="viewport" 
          content="width=device-width, initial-scale=1.0"> 
 
    <title>Payroll Result</title> 
 
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

        font-family: "Segoe UI", Arial, Helvetica, sans-serif;

        background:
            radial-gradient(
                circle at 10% 10%,
                rgba(37, 99, 235, 0.16),
                transparent 32%
            ),
            radial-gradient(
                circle at 90% 90%,
                rgba(79, 70, 229, 0.13),
                transparent 32%
            ),
            #eef2f7;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 35px 20px;

        color: #1e293b;
    }

    /* =========================
       MAIN CARD
    ========================= */
    .container {
        width: 100%;
        max-width: 620px;

        padding: 38px;

        background: rgba(255, 255, 255, 0.97);

        border: 1px solid rgba(255, 255, 255, 0.8);

        border-radius: 22px;

        box-shadow:
            0 25px 60px rgba(15, 23, 42, 0.12),
            0 5px 15px rgba(15, 23, 42, 0.05);
    }

    /* =========================
       TITLE
    ========================= */
    h1 {
        margin: 0 0 30px;

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
       PAYROLL ROW
    ========================= */
    .row {
        min-height: 54px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 25px;

        padding: 14px 5px;

        border-bottom: 1px solid #e8edf3;

        font-size: 14px;
    }

    /* Left side labels */
    .row strong {
        color: #64748b;

        font-size: 14px;
        font-weight: 600;

        white-space: nowrap;
    }

    /* Right side values */
    .row span {
        color: #1e293b;

        font-size: 15px;
        font-weight: 700;

        text-align: right;

        word-break: break-word;
    }

    /* =========================
       EMPLOYEE NAME
    ========================= */
    .row:first-of-type {
        background: #f8fafc;

        padding: 15px 14px;

        border-radius: 10px;

        border-bottom: none;

        margin-bottom: 5px;
    }

    .row:first-of-type span {
        color: #2563eb;
    }

    /* =========================
       GROSS SALARY
    ========================= */
    .row.total {
        margin-top: 12px;

        min-height: 72px;

        padding: 18px 15px;

        border: none;

        border-radius: 12px;

        background: linear-gradient(
            135deg,
            #eff6ff,
            #eef2ff
        );

        box-shadow:
            inset 0 0 0 1px rgba(59, 130, 246, 0.08);
    }

    .row.total strong {
        color: #1e3a8a;

        font-size: 16px;
        font-weight: 800;
    }

    .row.total span {
        color: #1d4ed8;

        font-size: 22px;
        font-weight: 800;
    }

    /* =========================
       BUTTON AREA
    ========================= */
    .buttons {
        display: flex;

        gap: 12px;

        margin-top: 25px;
    }

    /* =========================
       BUTTONS
    ========================= */
    .btn {
        flex: 1;

        min-height: 50px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 12px 16px;

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

    .btn:hover {
        filter: brightness(1.05);

        transform: translateY(-2px);

        box-shadow:
            0 11px 24px rgba(37, 99, 235, 0.27);
    }

    .btn:active {
        transform: translateY(0);

        box-shadow:
            0 5px 12px rgba(37, 99, 235, 0.18);
    }

    /* =========================
       VIEW RECORDS BUTTON
    ========================= */
    .btn.records {
        background: #ffffff;

        color: #334155;

        border: 1px solid #dbe2ea;

        box-shadow:
            0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .btn.records:hover {
        background: #f8fafc;

        color: #2563eb;

        border-color: #bfdbfe;

        box-shadow:
            0 8px 18px rgba(15, 23, 42, 0.08);
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 600px) {

        body {
            padding: 20px 14px;
        }

        .container {
            padding: 28px 20px;

            border-radius: 18px;
        }

        h1 {
            font-size: 24px;

            margin-bottom: 25px;
        }

        .row {
            gap: 15px;

            padding: 13px 3px;
        }

        .row strong {
            font-size: 13px;
        }

        .row span {
            font-size: 14px;
        }

        .row.total span {
            font-size: 19px;
        }

        .buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }

    /* =========================
       SMALL MOBILE
    ========================= */
    @media (max-width: 380px) {

        .container {
            padding: 24px 16px;
        }

        h1 {
            font-size: 21px;
        }

        .row {
            align-items: flex-start;
            flex-direction: column;
            gap: 4px;
        }

        .row span {
            text-align: left;
        }

        .row.total {
            align-items: center;
        }

        .row.total span {
            text-align: center;
        }
    }
</style>
</head> 
 
<body> 
 
<div class="container"> 
 
    <h1>EMPLOYEE PAYROLL</h1> 
 
    <div class="row"> 
        <strong>Employee Name:</strong> 
        <span> 
            <?= htmlspecialchars($employee_name) ?> 
        </span> 
    </div> 
 
    <div class="row"> 
        <strong>Basic Salary:</strong> 
        <span> 
            ₱<?= number_format($basic_salary, 2) ?> 
        </span> 
    </div> 
 
    <div class="row"> 
        <strong>Hours Worked:</strong> 
        <span> 
            <?= $hours_worked ?> 
        </span> 
    </div> 
 
    <div class="row"> 
        <strong>Overtime Hours:</strong> 
        <span> 
            <?= $overtime_hours ?> 
        </span> 
    </div> 
 
    <div class="row"> 
        <strong>Hourly Rate:</strong> 
        <span> 
            ₱<?= number_format($hourly_rate, 2) ?> 
        </span> 
    </div> 
 
    <div class="row"> 
        <strong>Regular Pay:</strong> 
        <span> 
            ₱<?= number_format($regular_pay, 2) ?> 
        </span> 
    </div> 
 
    <div class="row"> 
        <strong>Overtime Pay:</strong> 
        <span> 
            ₱<?= number_format($overtime_pay, 2) ?> 
        </span> 
    </div> 
 
    <div class="row total"> 
        <strong>Gross Salary:</strong> 
        <span> 
            ₱<?= number_format($gross_salary, 2) ?> 
        </span> 
    </div> 
 
    <div class="buttons"> 
 
        <a href="index.php" class="btn"> 
            NEW PAYROLL 
        </a> 
 
        <a href="records.php" class="btn records"> 
            VIEW RECORDS 
        </a> 
 
    </div> 
 
</div> 
 
</body> 
</html>