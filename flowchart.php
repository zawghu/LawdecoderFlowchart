<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="flowchart.css">
</head>

<!-- potentially use column technique*

Idea: use php to take in xml document that for each bubble contains
1. name/title
2. text to display when clicked
3. type of div (one type would be blank to allow for spacing)
4. whether div is the end of a column
-->

<body>
  <div>
    <div id="info" class="information">
      <h1>Title</h1>
      <p>^ↀᴥↀ^<br>Meow. I'm a huge cat with a lot of information.</p>
    </div>
    <div class="flowchart">
      <div class="column">
        <div id="test1" class="bubble preprocess">
          <p>Test 1 Yeah this is test 1 wowie</p>
        </div>

        <div id="test2" class="bubble offerprocess">
          <p>Test 2</p>
        </div>

        <div id="test3" class="bubble postprocess">
          <p>Test 3</p>
        </div>

        <div class="bubble postprocess">
          <p>Test 3</p>
        </div>
        <div class="bubble empty">
          <p>Test 3</p>
        </div>
      </div>
      <div class="column">
        <div id="test4" class="bubble preprocess">
          <p>Test 1 Yeah this is test 1 wowie</p>
        </div>
        <div class="bubble offerprocess">
          <p>Test 2</p>
        </div>
        <div class="bubble empty">
          <p>Test 3</p>
        </div>
        <div class="bubble postprocess">
          <p>Test 3</p>
        </div>
        <div class="bubble postprocess">
          <p>Test 3</p>
        </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  //have php automatically generate the number of times to call these functions
  document.getElementById("test1").addEventListener("click", function(){
    changeText("Test 1", " Woof. I'm a huge dog with no information", "test1");
  });
  document.getElementById("test4").addEventListener("click", function(){
    changeText("Test 4", " yeah", "test4");
  });

  document.getElementById("test2").addEventListener("click", function(){
    changeText("Test 2", " Glub. I'm a small fish with some information", "test2");
  });

  document.getElementById("test3").addEventListener("click", function(){
    changeText("Test 3", " Ribbit. I'm a huge frog with enough information", "test3");
  });

  var previousBubble;
  function changeText(title, description, id) {
    document.getElementById("info").innerHTML = "<h1>" + title  + "</h1><p>" + description + "</p>";

    document.getElementById(id).classList.add('selected');
    if (previousBubble) {
      document.getElementById(previousBubble).classList.remove('selected');
    }
    previousBubble = id;
  }
</script>


</html>
