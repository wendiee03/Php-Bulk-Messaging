<?php
session_start();
include('db.php');
include('RoyceBulkSMSGateway.php');

if (!isset($_SESSION['id'])) {
    header("Location: auth.php");
    exit();
}

// Handle adding a category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $user_id = $_SESSION['id']; // Fetch user ID from session

    $sql = "INSERT INTO categories (name, user_id) VALUES ('$category_name', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Category added successfully!";
    } else {
        $_SESSION['error'] = "Error adding category: " . $conn->error;
    }
}

// Handle adding a contact
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_contact'])) {
    $phone_number = $_POST['phone_number'];
    $category_id = $_POST['category_id'];
    $user_id = $_SESSION['id']; // Use $_SESSION['id'] here

    $sql = "INSERT INTO contacts (user_id, category_id, phone_number) VALUES ('$user_id', '$category_id', '$phone_number')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Contact added successfully!";
    } else {
        $_SESSION['error'] = "Error adding contact: " . $conn->error;
    }
}

// Handle sending SMS
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_sms'])) {
    $category_id = $_POST['category'];
    $message = $_POST['message'];
    $token = "176|AAYfhPrSka5SOudfeBTIqMdPtXaLych042nfnKwt"; // Replace with your token
    $senderid = "RoyceLtd";

    $sql = "SELECT phone_number FROM contacts WHERE category_id='$category_id' AND user_id='{$_SESSION['id']}'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $roycebulksms = new RoyceBulksmsGateway;
        while ($row = $result->fetch_assoc()) {
            $roycebulksms->sendSMS($row['phone_number'], $message, $senderid, $token);
        }
        $_SESSION['message'] = "Messages sent successfully!";
    } else {
        $_SESSION['error'] = "No contacts found for the selected category.";
    }
}


$categories = $conn->query("SELECT * FROM categories WHERE user_id='{$_SESSION['id']}'");
$contacts = $conn->query("SELECT * FROM contacts WHERE user_id='{$_SESSION['id']}'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <nav>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <?php if (isset($_SESSION['message'])): ?>
            <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <section>
            <h2>Add Category</h2>
            <form action="dashboard.php" method="POST">
                <label for="category_name">Category Name</label>
                <input type="text" id="category_name" name="category_name" required>
                <button type="submit" name="add_category">Add Category</button>
            </form>
        </section>

        <section>
            <h2>Add Contact</h2>
            <form action="dashboard.php" method="POST">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required>

                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <?php while ($row = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="add_contact">Add Contact</button>
            </form>
        </section>

        <section>
            <h2>Contacts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Phone Number</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $contacts->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php
                                $category = $conn->query("SELECT name FROM categories WHERE id='" . $row['category_id'] . "'")->fetch_assoc();
                                echo $category['name'];
                            ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <h2>Send Bulk SMS</h2>
        <button id="openModal">Send Message</button>

        <div id="sendMessageModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Send Message</h2>
                <form action="dashboard.php" method="POST">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <?php
                        $categories = $conn->query("SELECT * FROM categories WHERE user_id='{$_SESSION['id']}'");
                        while ($row = $categories->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>

                    <button type="submit" name="send_sms">Send</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Bulk SMS App</p>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>
