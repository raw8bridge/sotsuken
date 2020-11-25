<?php

session_start();

if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
?>

<p>
    こんにちは、あなたがこのページに来たのは <?php echo $_SESSION['count']; ?> 回目ですね。
</p>

<p>
    続けるには、<a href="test_session.php?<?php echo htmlspecialchars(SID); ?>">ここをクリック</A>
    してください。
</p>
<?php echo htmlspecialchars(SID); ?>