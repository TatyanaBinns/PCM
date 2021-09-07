<h1>Hello World</h1>
We love COP4331!
<p>This is the temporary homepage of the Group 12 "Personal Contact Manager" site!</p>


<?php
$x = 1;

echo "<p>Some PHP Example Code:</p>";

while($x <= 5) {
  echo "The number is: $x <br>";
  $x++;
}

$arr1 = array('a' => 10, 'b' => 20, 'c' => 30, 'd' => 40, 'e' => 50);
$arr2 = array('a' => 11, 'b' => 21, 'c' => 31, 'd' => 41, 'e' => 51);
$arr3 = array('a' => 12, 'b' => 22, 'c' => 32, 'd' => 42, 'e' => 52);

$res = array();

$res['first'] = $arr1;
$res['second'] = $arr2;
$res['third'] = $arr3;
?>

<div> <h3>Var-dump of raw variable:</h3>
<pre><code><?php var_dump($res); ?></code></pre>
</div>

<div> <h3>Json encoding of the same variable:</h3>
<pre><code><?php echo json_encode($res); ?></code></pre>
</div>
