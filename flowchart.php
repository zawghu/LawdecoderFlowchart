<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="flowchart.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<!--TODO: comment this code it's incredibly messy right now-->
<body>
  <div id="outer">
    <div id="info" class="information">
      <h1>Housing Flowchart</h1>
      <p>These are the steps necessary for buying a house. Click on any step for additional details!</p>
    </div>
    <div class="flowchart">
      <!--This php takes in an xml file, and using its information, generates a flowchart -->
      <?php
        $columns = simplexml_load_file('test1.xml');
        foreach ($columns->column as $column) {
          //if a column is titled arrow, it generates a thinner column for display of arrows
          if ($column->title == "arrow") {
            print "<div class=\"column arrow-column\">";
            //this iterates through each arrow in column
            foreach ($column->arr as $arr) {
              //if arr named empty, uses its height for spacing
              if ($arr->name == "empty") {
                print "<div style=\"height:{$arr->height}px;\" class=\"empty\"></div>";
              }
              //this prints out the proper kind of arrow depending on its name
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
            print "<div class=\"column\">";
            foreach ($column->bubble as $bubble) {
              if($bubble->type == "empty") {
                print "<div style=\"height:{$bubble->height}px;\" class=\"empty\"></div>";
              } else {
                if($bubble->arrow) {
                  print "<div id=\"{$bubble->name}\" class=\"bubble arrow-bubble {$bubble->type}\"><p>{$bubble->name}</p></div>";
                } else {
                  print "<div id=\"{$bubble->name}\" class=\"bubble {$bubble->type}\"><p>{$bubble->name}</p></div>";
                }
                if ($bubble->type != "default") {
                  print "<div class=\"contents\">{$bubble->text}</div>";
                }
                switch($bubble->arrow) {
                  case "up":
                    print "<div class=\"vertical-arrow\"><p>&uarr;</p></div>";
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
    <div class="dropdown">
      <?php
        $priorType = "";
        $first = true;
        print "<div>";
        $columns = simplexml_load_file('test1.xml');
        foreach ($columns->column as $column) {
          if ($column->title != "arrow") {
            foreach ($column->bubble as $bubble) {
              if($bubble->type != "empty") {
                if($priorType != $bubble->type) {
                  print "</div><div class=\"parent bubble {$bubble->type} column-title\"><p>{$column->title}</p></div>";
                  print "<div class=\"child\">";
                }
                print "<div id=\"{$bubble->name}\" class=\"bubble parent {$bubble->type}\"><p>{$bubble->name}</p></div>";
                if ($bubble->type != "default") {
                  print "<div class=\"child contents\">{$bubble->text}</div>";
                }
                $priorType = (string)$bubble->type;
              }
            }
          }
        }
        print "</div>";
      ?>
    </div>
</div>
</body>
<script type="text/javascript">
  <?php
  $columns = simplexml_load_file('test1.xml');
  //this adds functionality to each bubble such that if you click it, text changes
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
  //function called above that changes the text of the information div
  function changeText(title, description) {
    document.getElementById("info").innerHTML = "<h1>" + title  + "</h1><p>" + description + "</p>";

    document.getElementById(title).classList.add('selected');
    if (previousBubble) {
      document.getElementById(previousBubble).classList.remove('selected');
    }
    previousBubble = title;
  }

  //this functions as to create slideToggle functionality when in mobile view
  $(document).ready(function() {
    //hide the all of the element with class contents
    $(".child").hide();
    //toggle the componenet with class bubble
    $(".parent").click(function() {
      $(this).next(".child").slideToggle(600);
    });
  });
</script>
</html>
