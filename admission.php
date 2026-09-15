<?php

include "db.php";

$message = "";
$message_type = "";

// Save application
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"] ?? "");
    $father_name = trim($_POST["father_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $program = trim($_POST["program"] ?? "");

    // Check required fields
    if (
        $full_name === "" ||
        $father_name === "" ||
        $email === "" ||
        $phone === "" ||
        $program === ""
    ) {
        $message = "Please fill in all required fields.";
        $message_type = "danger";
    }

    // Validate email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $message_type = "danger";
    }

    // Insert application
    else {

        $stmt = $conn->prepare(
            "INSERT INTO applications 
            (full_name, father_name, email, phone, program)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $full_name,
            $father_name,
            $email,
            $phone,
            $program
        );

        if ($stmt->execute()) {
            $stmt->close();

            // Redirect after successful submission
            header("Location: admission.php");
            exit;
        } else {
            $message = "Error saving application: " . $stmt->error;
            $message_type = "danger";
        }

        $stmt->close();
    }
}

// Get all applications
$result = $conn->query(
    "SELECT id, full_name, father_name, email, phone, program
     FROM applications
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Admission Application</title>

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <!-- Admission Form -->

    <div class="card shadow mb-5">

        <div class="card-header bg-primary text-white">

            <h2 class="text-center mb-0">
                Student Admission Application
            </h2>

        </div>

        <div class="card-body">

            <?php if ($message !== ""): ?>

                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>


            <form method="post">

                <!-- Full Name -->

                <div class="mb-3">

                    <label for="full_name" class="form-label">
                        Full Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="full_name"
                        name="full_name"
                        required
                    >

                </div>


                <!-- Father's Name -->

                <div class="mb-3">

                    <label for="father_name" class="form-label">
                        Father's Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="father_name"
                        name="father_name"
                        required
                    >

                </div>


                <!-- Email -->

                <div class="mb-3">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required
                    >

                </div>


                <!-- Phone -->

                <div class="mb-3">

                    <label for="phone" class="form-label">
                        Phone
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="phone"
                        name="phone"
                        required
                    >

                </div>


                <!-- Program -->

                <div class="mb-3">

                    <label for="program" class="form-label">
                        Program
                    </label>

                    <select
                        class="form-select"
                        id="program"
                        name="program"
                        required
                    >

                        <option value="">
                            Select Program
                        </option>

                        <option value="Information Systems">
                            Information Systems
                        </option>

                        <option value="Software Engineering">
                            Software Engineering
                        </option>

                        <option value="Computer Science">
                            Computer Science
                        </option>

                    </select>

                </div>


                <!-- Submit Button -->

                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    Submit Application
                </button>

            </form>

        </div>

    </div>


    <!-- Submitted Applications -->

    <div class="card shadow">

        <div class="card-header">

            <h3 class="mb-0">
                Submitted Applications
            </h3>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Father's Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Program</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while ($row = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($row["id"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["full_name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["father_name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["email"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["phone"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["program"]); ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>