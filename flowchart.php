
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="flowchart.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<!--TODO: comment this code it's incredibly messy right now-->
<body>
  <div>
    <div id="info" class="information">
      <h1>Default Title</h1>
      <p>^ↀᴥↀ^<br>Meow. I'm a huge cat with a lot of information.</p>
    </div>
    <div class="flowchart">
      <?php
        $columns = simplexml_load_file('test1.xml');
        foreach ($columns->column as $column) {
          if ($column->title == "arrow") {
            print "<div class=\"column arrow-column\">";
            foreach ($column->arr as $arr) {
              if ($arr->name == "empty") {
                print "<div style=\"height:{$arr->height}px;\" class=\"empty\"></div>";
              }
              switch($arr->name) {
                case "left":
                  print "<div class=\"horizontal-arrow\">&larr;</div>";
                  break;
                case "right":
                  print "<div class=\"horizontal-arrow\">&rarr;</div>";
                  break;
                case "NW":
                  print "<div class=\"horizontal-arrow\">&#8598;</div>";
                  break;
                case "NE":
                  print "<div class=\"horizontal-arrow\">&#8599;</div>";
                  break;
                case "SE":
                  print "<div class=\"horizontal-arrow\">&#8600;</div>";
                  break;
                case "SW":
                  print "<div class=\"horizontal-arrow\">&#8601;</div>";
                  break;
              }
            }
          }
          else {
            //print "<div class=\"parent preprocess column-title\"><p>{$column->title}</p></div>";
            print "<div class=\"column\">"; //child
            foreach ($column->bubble as $bubble) {
              if($bubble->type == "empty") {
                print "<div style=\"height:{$bubble->height}px;\" class=\"empty\"></div>";
              } else {
                if($bubble->arrow) {
                  print "<div id=\"{$bubble->name}\" class=\"bubble parent arrow-bubble {$bubble->type}\"><p>{$bubble->name}</p></div>";
                } else {
                  print "<div id=\"{$bubble->name}\" class=\"bubble parent {$bubble->type}\"><p>{$bubble->name}</p></div>";
                }
                if ($bubble->type != "default") {
                  print "<div class=\"child baby contents\">{$bubble->text}</div>";
                }
                switch($bubble->arrow) {
                  case "up":
                    print "<div class=\"vertical-arrow\">&uarr;</div>";
                    break;
                  case "down":
                    print "<div class=\"vertical-arrow\">&darr;</div>";
                    break;
                  case "updown":
                    print "<div class=\"vertical-arrow\">&#8597;</div>";
                    break;
                }
              }
            }
          }
          print "</div>";
        }
      ?>
    </div>
  </div>
</body>
<script type="text/javascript">
  <?php


  $columns = simplexml_load_file('test1.xml');
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

$(document).ready(function()
{
  //hide the all of the element with class contents
  if ($(document).width() < 900) {
    $(".child").hide();
  }
  $(".baby").hide();

  //toggle the componenet with class bubble
  $(".parent").click(function() {
    if ($(document).width() < 900) {
      $(this).next(".child").slideToggle(600);
    }
  });
});

//reshows proper elements on resize
$(window).resize(function()
{
  if ($(document).width() > 900) {
    $(".child").show();
    $(".baby").hide();
  }
});
</script>
</html>
