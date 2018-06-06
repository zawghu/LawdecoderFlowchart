
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
          print "<div class=\"parent preprocess column-title\"><p>{$column->title}</p></div>";
          print "<div class=\"column child\">";
          foreach ($column->bubble as $bubble) {
            if($bubble->type == "empty") {
              print "<div class=\"bubble empty\"></div>";
            } else {
              print "<div id=\"{$bubble->name}\" class=\"bubble parent {$bubble->type}\"><p>{$bubble->name}</p></div>";
              if ($bubble->type != "default") {
                print "<div class=\"child baby contents\">{$bubble->text}</div>";
              }
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
  //hide the all of the element with class contents
  if ($(document).width() < 900) {
    $(".child").hide();
  }
  $(".baby").hide();

  //toggle the componenet with class bubble
  $(".parent").click(function()
  {
    if ($(document).width() < 900) {
      $(this).next(".child").slideToggle(600);
    }
  });
});

$(window).resize(function()
{
  //hide the all of the element with class contents
  if ($(document).width() > 900) {
    $(".child").show();
    $(".baby").hide();
  }
});
</script>
</html>
