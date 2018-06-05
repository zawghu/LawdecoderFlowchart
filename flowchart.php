
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="flowchart.css">
</head>

<body>
  <div>
    <div id="info" class="information">
      <h1>Default Title</h1>
      <p>^ↀᴥↀ^<br>Meow. I'm a huge cat with a lot of information.</p>
    </div>
    <div class="flowchart">
      <?php
        $columns = simplexml_load_file('test.xml');
        foreach ($columns->column as $column) {
          print "<div class=\"column\">";
          foreach ($column->bubble as $bubble) {
            if($bubble->type == "empty") {
              print "<div class=\"bubble empty\"></div>";
            } else {
              print "<div id=\"{$bubble->name}\" class=\"bubble {$bubble->type}\"><p>{$bubble->name}</p></div>";
            }
          }
          print "</div>";
        }
      ?>
    </div>
  </div>
</body>
<script>
  <?php
  $columns = simplexml_load_file('test.xml');
  foreach ($columns->column as $column) {
    foreach ($column->bubble as $bubble) {
      if ($bubble->type != "empty" && $bubble->type != "default") {
        print "document.getElementById(\"{$bubble->name}\").addEventListener(\"click\", function(){
          changeText(\"{$bubble->name}\", \"{$bubble->text}\");
        });";
      }
    }
  }
  ?>

  var previousBubble;
  function changeText(title, description) {
    document.getElementById("info").innerHTML = "<h1>" + title  + "</h1><p>" + description + "</p>";

    document.getElementById(title).classList.add('selected');
    if (previousBubble) {
      document.getElementById(previousBubble).classList.remove('selected');
    }
    previousBubble = title;
  }
</script>
</html>
