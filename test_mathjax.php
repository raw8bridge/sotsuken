<?php
include "./test/function/htmlspchar.php";

if (isset($_POST['text'])) {
  $text = $_POST['text'];
}
?>

<!DOCTYPE html>
<html>

<head>
  <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>

  <title>MathML in HTML5</title>
</head>

<body>
  <p>POSTされた数式</p>
  <p>\(<?php echo hsc($text) ?>\)</p>

</body>

</html>