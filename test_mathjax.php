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
  <!-- <annotation encoding="application/x-tex">y=\dfrac{a}{x}</annotation> -->
  <p>次の数式\(<?php echo hsc($text) ?>\)の\(x\)の値を求めよ</p>
  <p>\(\begin{aligned}\begin{cases}\overline{A\cup B}=\overline{A}\cap \overline{B}\\\overline{A\cap B}=\overline{A}\cup \overline{B}\end{cases}\end{aligned}\)</p>

</body>

</html>