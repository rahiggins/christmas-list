<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title>Andy's Christmas List</title>
    <base target="_blank">
    <style type="text/css">
      #titleDiv {
        background-color: #27a53a;
        text-align: right;
        height: 31px; 
        display: flex; 
        justify-content: flex-end;
        align-items: center;
      }

      #title {
        font-family: Beanie;
        font-size: 24px;
        color: #ffffff;
        padding-right:   6px;
      }

      #navBar {
        margin-bottom: 70px;
        font-family: Arial;
      }

      #navSection {
        justify-content: space-evenly;
      }

      #newA {
        padding-top: 7px;
        padding-bottom: 3px;
      }

      .bottomMargin { 
        margin-bottom: 2em;
      }

      .categoryTitle {
        font-family: Lydian;
        font-size: 48px;
        color:   red;
      }

      li {
        list-style-type: none;
      }

      .atBottomLeft {
        position: absolute;
        bottom: 0;
        left: 8px;
      }

      .atBottomRight {
        position: absolute;
        bottom: 0;
        right: 8px
      }

      .imgDiv {
        display: flex;
        align-items: center;
      }

      .itemLink {
        color: rgb(0, 0, 238);
        font-family: Times;
        font-size: 24px;
        text-decoration-color: rgb(0, 0, 238);
        text-decoration-line: underline;
        text-decoration-style: solid;
        text-decoration-thickness: auto;
      }

      .itemComment {
        color: black;
        font-family: Times;
        font-size: 18px;
      }
td {
  font-size: x-large;
  vertical-align: middle;
}

#music {
  font-size: medium;
}

#med {
  font-size: medium !important;
}

dt {
  margin-top: 5px;
  margin-bottom: 5px;
}

</style>
  <link rel="stylesheet" href="spectre.min.css">
</head>
  <body style="background-image: url(bkg_snowflake_white.jpg);">
<?php
  // Connect to Mysql database.
  require_once 'pdoconfig-helio.php';
  try {
  	$conn = new PDO($dsn, $user, $passwd);
  	$conn->setAttribute(PDO::ATTR_ERRMODE,    PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $e) {
  	echo "Connection failed: " . $e->getMessage();
  	exit();
  }
  unset($dsn, $user, $passwd);
?>
    <div class="container">
      <a name="top"></a>
      <div id="titleDiv">
        <span id="title">Andy's Christmas List 2025</span>
      </div>
      <header id="navBar" class="navbar">
        <section id="navSection" class="navbar-section" ">
          <a id="newA" href="#New" class="btn btn-link"
                target="_top"><img
                  src="New.gif"
                  border="0"
                  height="20"
                  width="60"></a>
<?php
  // Fetch categories from the database to populate the navigation bar.
  $stmt = $conn->query("SELECT id, Category FROM Categories WHERE id>1 ORDER BY id");
  $categories = $stmt->fetchALL(\PDO::FETCH_NUM);
  if ($categories !== false) {
  	foreach ($categories as $category) {
      [, $categoryName] = $category;
      $id = "#".$categoryName;
  		echo '          <a href="', $id, '" target="_top" class="btn btn-link text-dark">', $categoryName, '</a>', "\n";
  	}
  }
?> 
          <a href="#credits" target="_top" class="btn btn-link text-dark">Credits</a>
          <a href="#email" target="_top" class="btn btn-link text-dark">Email</a>
        </section>
      </header>
<?php
  // Fetch categories from the database to produce the page content
  function insertCategory($conn, $category, $catClasses) {
    // Insert a list of gift ideas for the specified category
    [, $categoryName] = $category;
    [$colClass, $tanneClass] = $catClasses;
    echo '        <div class="column ', $colClass, ' p-relative">';
    echo '          <div class="text-center">';
    echo '            <span class="categoryTitle">', $categoryName, '</span>';
    echo '            <ul>';
    // Retrieve gift ideas for this category
    $stmt = $conn->query("SELECT `Name`, `URL`, Comment FROM GiftIdeas WHERE Category='".$categoryName."' ORDER BY Position");
    $giftIdeas = $stmt->fetchALL(\PDO::FETCH_NUM);
    if ($giftIdeas) {
      foreach ($giftIdeas as $giftIdea) {
        [$name, $url, $comment] = $giftIdea;
        echo '              <li>';
        if ($url) {
          echo '<a class="itemLink" href="', $url, '" target="_blank">', $name, '</a>';
        } else {
          echo $name;
        }
        if ($comment) {
          echo '<span class="itemComment"> - ', $comment, '</span>';
        }
        echo '</li>', "\n";
      }
    }
    echo '            </ul>';
    echo '          </div>';
    echo '          <a class="', $tanneClass, '" href="#top" title="Click to go back to top of page" target="_top"><img src="tanne.gif" border="0" height="32" width="24"></a>';
    echo '        </div>';
  }
  function insertImage($conn, $category, $imgClass) {
    // Insert an image next to the gift ideas of a category
    [$order, ] = $category;
    $stmt = $conn->query("SELECT * FROM Images WHERE id=".$order);
    [[, $fileName, $height, $width]] = $stmt->fetchALL(\PDO::FETCH_NUM);
    echo '        <div class="imgDiv ', $imgClass, '">';
    echo '          <img src="', $fileName, '" border="0" height="', $height, '" width="', $width, '">';
    echo '        </div>';
  }
  // Retrieve categories from the database and display them with their gift ideas
  $stmt = $conn->query("SELECT id, Category FROM Categories ORDER BY id");
  $categories = $stmt->fetchALL(\PDO::FETCH_NUM);
  if ($categories) {
    foreach ($categories as $category) {
      [$order, $categoryName] = $category;
      echo '      <div class="columns col-oneline bottomMargin" id="', $categoryName, '">', "\n";
      // Alternate the position of the gift idea list and the image
      $left = $order % 2; // Odd categories (truthy), list on the left
      if ($left) {
        $catClasses = ["col-mr-auto", "atBottomLeft"];
        $imgClass = "pr-2";
        insertCategory($conn, $category, $catClasses);
        insertImage($conn, $category, $imgClass);
      } else {
        $catClasses = ["col-ml-auto", "atBottomRight"];
        $imgClass = "pl-2";
        insertImage($conn, $category, $imgClass);
        insertCategory($conn, $category, $catClasses);
      }
      echo '      </div>', "\n";
    }
  }
?>
      <!-- Credits and contact information -->
      <div><hr></div>
      <div class="columns col-oneline" style="margin-bottom: 2em;">
        <div class="imgDiv">
          <img src="xmas_ani.gif" border="0" height="85" width="124">
        </div>
        <div class="col-mx-auto text-center">
          <a name="credits"></a>
          <span style="font-family: Times; font-size: 18px; line-height: normal;">
            I made an RYO CMS to generate this page.<br>
            Check out the code<br>
              Illustrations by <a href="http://www.rudolfkoivu.fi/index.html" target="_blank">Rudolf
                Koivu</a><br>
              <a name="email"></a>As always, coordinate with <a href="mailto:jorja.higgins@gmail.com?Subject=Andy%27s%20Christmas%20list">Mom</a>.<br>
              Send questions, comments and your Christmas list to <a href="mailto:rahiggins@ameritech.net?Subject=Christmas">me</a>.</font>
          </span>
        </div>
        <div class="imgDiv">
          <img src="xmastree.jpg" border="0" height="85" width="131">
        </div>
      </div>
    </div>
  </body>
</html>