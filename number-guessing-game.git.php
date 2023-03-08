<?php
session_start();

if (!isset($_SESSION["low"]) && !isset($_SESSION["high"])) {
    $_SESSION["low"] = 1;
    $_SESSION["high"] = 100;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_number = $_POST["user_number"];

    if (isset($_POST["option"])) {
        $option = $_POST["option"];

        if ($option == "correct") {
            echo "<p>Chính xác! Số bạn nghĩ là $user_number.</p>";
            unset($_SESSION["low"]);
            unset($_SESSION["high"]);
        } elseif ($option == "smaller") {
            $_SESSION["high"] = $user_number - 1;
        } elseif ($option == "larger") {
            $_SESSION["low"] = $user_number + 1;
        }
    }
}

if (isset($_SESSION["low"]) && isset($_SESSION["high"])) {
    $low = $_SESSION["low"];
    $high = $_SESSION["high"];
    $computer_number = round(($low + $high) / 2);
} else {
    $low = null;
    $high = null;
    $computer_number = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Game đoán số</title>
</head>
<body>
<h1>Game đoán số</h1>

<?php if (!isset($_SESSION["low"]) && !isset($_SESSION["high"])) : ?>
    <p>Hãy nghĩ ra một số ngẫu nhiên từ 1 đến 100, sau đó máy tính sẽ đoán số đó!</p>
    <form method="POST" action="">
        <label for="user_number">Số của bạn:</label>
        <input type="number" name="user_number" min="1" max="100" required>
        <button type="submit">Bắt đầu</button>
    </form>
<?php else : ?>

    <p>Máy tính đoán số của bạn là: <?php echo $computer_number; ?></p>
    <p>Chọn một trong ba lựa chọn sau:</p>
    <form method="POST" action="">
        <input type="hidden" name="user_number" value="<?php echo $computer_number; ?>">
        <button type="submit" name="option" value="correct">Chính xác</button>
        <button type="submit" name="option" value="smaller">Nhỏ hơn</button>
        <button type="submit" name="option" value="larger">Lớn hơn</button>
    </form>
<?php endif; ?>
</body>
</html>
