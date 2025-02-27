<?php
include('../config/db.php');

// Fetch the lawyer's current information based on the ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Always sanitize user inputs
    $query = "SELECT * FROM Footer WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result) {
        $lawyer = $result->fetch_assoc();
    } else {
        echo "Error fetching lawyer information: " . $conn->error;
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

// Update the lawyer's information based on the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Address = $_POST['name'];
    $Email = $_POST['email'];
    $Phone = $_POST['Phone'];

    $query = "UPDATE Footer SET Address = ?, email = ?, Phone = ? WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $Address, $Email, $Phone, $id);
    
    if ($stmt->execute()) {
        $message = "Record updated successfully.";
        header("Location: editfooter.php?message=" . urlencode($message));
        exit;
    } else {
        $message = "Error updating record: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5 wrapper">
        <h1>Edit Footer</h1>
        <?php if (isset($message)): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" id="Address" name="name" value="<?php echo $lawyer['Address']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="type" name="Phone" value="<?php echo $lawyer['Phone']; ?>" required>
            </div>
           
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="price" name="email" value="<?php echo $lawyer['email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="dash.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<style>
   
    /* Import Google font - Poppins */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }
    body {
        display: flex;
        padding: 0 10px;
        min-height: 100vh;
        background-image: url('../assets/images/hero-bg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        align-items: center;
        justify-content: center;
    }
    ::selection {
        color: #fff;
        background: #0D6EFD;
    }
    .wrapper {
        width: 715px;
        background: rgba(255, 255, 255, 0.15); /* Adjust the opacity here */
        border-radius: 5px;
        box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.05);
        margin: 0 auto;
    }
    .wrapper header {
        font-size: 22px;
        font-weight: 600;
        padding: 20px 30px;
        border-bottom: 1px solid #ccc;
    }
    .wrapper form {
        margin: 35px 30px;
    }
    .wrapper form.disabled {
        pointer-events: none;
        opacity: 0.7;
    }
    form .dbl-field {
        display: flex;
        margin-bottom: 25px;
        justify-content: space-between;
    }
    .dbl-field .field {
        height: 50px;
        display: flex;
        position: relative;
        width: calc(100% / 2 - 13px);
    }
    .wrapper form i {
        position: absolute;
        top: 50%;
        left: 18px;
        color: #ccc;
        font-size: 17px;
        pointer-events: none;
        transform: translateY(-50%);
    }
    form .field input,
    form .message textarea {
        width: 100%;
        height: 100%;
        outline: none;
        padding: 0 18px 0 48px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .field input::placeholder,
    .message textarea::placeholder {
        color: #ccc;
    }
    .field input:focus,
    .message textarea:focus {
        padding-left: 47px;
        border: 2px solid #0D6EFD;
    }
    .field input:focus ~ i,
    .message textarea:focus ~ i {
        color: #0D6EFD;
    }
    form .message {
        position: relative;
    }
    form .message i {
        top: 30px;
        font-size: 20px;
    }
    form .message textarea {
        min-height: 130px;
        max-height: 230px;
        max-width: 100%;
        min-width: 100%;
        padding: 15px 20px 0 48px;
    }
    form .message textarea::-webkit-scrollbar {
        width: 0px;
    }
    .message textarea:focus {
        padding-top: 14px;
    }
    form .button-area {
        margin: 25px 0;
        display: flex;
        align-items: center;
    }
    .button-area button {
        color: #fff;
        border: none;
        outline: none;
        font-size: 18px;
        cursor: pointer;
        border-radius: 5px;
        padding: 13px 25px;
        background: RGB(204, 183, 115);
        transition: background 0.3s ease;
    }
    .button-area button:hover {
        background: #CDA434;
    }
    .button-area span {
        font-size: 17px;
        margin-left: 30px;
        display: none;
    }
    @media (max-width: 600px) {
        .wrapper header {
            text-align: center;
        }
        .wrapper form {
            margin: 35px 20px;
        }
        form .dbl-field {
            flex-direction: column;
            margin-bottom: 0px;
        }
        form .dbl-field .field {
            width: 100%;
            height: 45px;
            margin-bottom: 20px;
        }
        form .message textarea {
            resize: none;
        }
        form .button-area {
            margin-top: 20px;
            flex-direction: column;
        }
        .button-area button {
            width: 100%;
            padding: 11px 0;
            font-size: 16px;
        }
        .button-area span {
            margin: 20px 0 0;
            text-align: center;
        }
    }
    .input-field input, select{
    outline: none;
    font-size: 14px;
    font-weight: 400;
    color: #333;
    border-radius: 5px;
    border: 1px solid #aaa;
    padding: 0 15px;
    width: 100%;
    height: 42px;
    margin: 8px 0;
}
</style>
</style>
<body>
