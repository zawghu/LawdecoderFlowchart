<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="flowchart.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
  <div id="outer">
    <?php //This php takes in an xml file, and using its information, generates a flowchart
    $columns = simplexml_load_file('selling.xml');
    foreach ($columns->column as $column) {
      if ($column->title == "defaulttext") {
        print "<div id=\"info\" class=\"{$column->bubble->type}\"><h1>{$column->bubble->name}</h1><p>{$column->bubble->text}</p></div>";
        print "<div class=\"flowchart\">";
      }
      //if a column is titled arrow, it generates a thinner column for display of arrows
      else if ($column->title == "arrow") {
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
        print "</div>";
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
              print "<div class=\"name\">{$bubble->name}</div>";
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
        print "</div>";
      }
    }
    ?>
  </div></div>
  <div class="dropdown">
    <?php //This php takes in an xml file, and using its information, a series of dropdowns designed for mobile displays
      $priorType = "";
      $first = true;
      print "<div>";
      $columns = simplexml_load_file('selling.xml');
      foreach ($columns->column as $column) {
        if ($column->title != "arrow" && $column->title != "default") {
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
  $(document).ready(function() {
    //desktop interactivity
    $('.bubble').click(function() {
      if ($(event.currentTarget).next().hasClass("name")) {
        $('.bubble').removeClass('selected');
        $(event.currentTarget).addClass('selected');
        var title = $(event.currentTarget).next().html();
        var description = $(event.currentTarget).next().next().html();
        document.getElementById("info").innerHTML = "<h1>" + title  + "</h1><p>" + description + "</p>";
      }
    });
    //mobile interactivity
    $(".child").hide();
    //toggle the componenet with class bubble
    $(".parent").click(function() {
      $(this).next(".child").slideToggle(600);
    });
    $("#outer").css("zoom", $(window).width() * .00065);
  });

  $(window).resize(function() {
    $("#outer").css("zoom", $(window).width() * .00065);
  });
</script>
</html>
