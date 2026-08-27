<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Payroll System</title>

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
        font-family: "Segoe UI", Arial, sans-serif;
        background:
            radial-gradient(circle at top left, rgba(59, 130, 246, 0.18), transparent 35%),
            radial-gradient(circle at bottom right, rgba(99, 102, 241, 0.15), transparent 35%),
            #eef2f7;

        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        color: #1e293b;
    }

    /* =========================
       MAIN CARD
    ========================= */
    .container {
        width: 100%;
        max-width: 560px;
        background: rgba(255, 255, 255, 0.96);
        padding: 42px;
        border-radius: 24px;

        box-shadow:
            0 25px 60px rgba(15, 23, 42, 0.12),
            0 4px 12px rgba(15, 23, 42, 0.05);

        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    /* =========================
       TITLE
    ========================= */
    h1 {
        margin: 0 0 32px;
        text-align: center;

        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.8px;

        color: #172554;
    }

    h1::after {
        content: "";
        display: block;

        width: 55px;
        height: 4px;

        margin: 12px auto 0;

        border-radius: 20px;
        background: linear-gradient(90deg, #2563eb, #6366f1);
    }

    /* =========================
       LABEL
    ========================= */
    label {
        display: block;

        margin-top: 19px;
        margin-bottom: 8px;

        color: #334155;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    /* =========================
       INPUT
    ========================= */
    input {
        width: 100%;
        height: 50px;

        padding: 0 16px;

        border: 1px solid #dbe2ea;
        border-radius: 11px;

        background: #f8fafc;

        color: #1e293b;
        font-family: inherit;
        font-size: 15px;

        outline: none;

        transition:
            border-color 0.2s ease,
            background 0.2s ease,
            box-shadow 0.2s ease,
            transform 0.2s ease;
    }

    input::placeholder {
        color: #94a3b8;
    }

    input:hover {
        border-color: #b8c4d3;
        background: #ffffff;
    }

    input:focus {
        border-color: #3b82f6;
        background: #ffffff;

        box-shadow:
            0 0 0 4px rgba(59, 130, 246, 0.10);

        transform: translateY(-1px);
    }

    /* Remove arrows from number input */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 0.6;
    }

    /* =========================
       COMPUTE BUTTON
    ========================= */
    button {
        width: 100%;
        height: 52px;

        margin-top: 28px;

        border: none;
        border-radius: 11px;

        background: linear-gradient(
            135deg,
            #2563eb,
            #4f46e5
        );

        color: #ffffff;

        font-family: inherit;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.3px;

        cursor: pointer;

        box-shadow:
            0 8px 18px rgba(37, 99, 235, 0.22);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            filter 0.2s ease;
    }

    button:hover {
        filter: brightness(1.05);

        transform: translateY(-2px);

        box-shadow:
            0 12px 24px rgba(37, 99, 235, 0.28);
    }

    button:active {
        transform: translateY(0);

        box-shadow:
            0 5px 12px rgba(37, 99, 235, 0.20);
    }

    /* =========================
       RECORDS BUTTON
    ========================= */
    .records-btn {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        height: 50px;

        margin-top: 12px;

        border: 1px solid #dbe2ea;
        border-radius: 11px;

        background: #ffffff;

        color: #334155;

        font-size: 14px;
        font-weight: 700;
        text-decoration: none;

        transition:
            background 0.2s ease,
            color 0.2s ease,
            border-color 0.2s ease,
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .records-btn:hover {
        background: #f8fafc;
        color: #2563eb;

        border-color: #bfdbfe;

        transform: translateY(-1px);

        box-shadow:
            0 5px 15px rgba(15, 23, 42, 0.07);
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 600px) {

        body {
            padding: 20px 14px;
        }

        .container {
            padding: 30px 22px;
            border-radius: 20px;
        }

        h1 {
            font-size: 25px;
        }

        input {
            height: 48px;
        }

        button,
        .records-btn {
            height: 50px;
        }
    }

    /* =========================
       SMALL MOBILE
    ========================= */
    @media (max-width: 380px) {

        .container {
            padding: 25px 18px;
        }

        h1 {
            font-size: 22px;
        }

        label {
            font-size: 13px;
        }

        input {
            font-size: 14px;
        }
    }

    </style>
</head>

<body>

<div class="container">

    <h1>EMPLOYEE PAYROLL SYSTEM</h1>

    <form action="save.php" method="POST">

        <label>Employee Name</label>
        <input
            type="text"
            name="employee_name"
            maxlength="100"
            required
        >

        <label>Basic Salary</label>
        <input
            type="number"
            name="basic_salary"
            min="0"
            step="0.01"
            required
        >

        <label>Hours Worked</label>
        <input
            type="number"
            name="hours_worked"
            min="0"
            required
        >

        <label>Overtime Hours</label>
        <input
            type="number"
            name="overtime_hours"
            min="0"
            value="0"
            required
        >

        <button type="submit">
            COMPUTE PAYROLL
        </button>

    </form>

    <a href="records.php" class="records-btn">
        VIEW SAVED RECORDS
    </a>

</div>

</body>
</html>