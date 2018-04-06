<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title> Manage your content</title>

  <!-- Favicons>
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  < Favicons>
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  < For iPhone >
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  < For Windows Phone -->

  <!-- CORE CSS-->
  <link href="{{ asset ('css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="{{ asset ('css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->
  <link href=" {{ asset ('css/custom-style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- CSS for full screen (Layout-2)-->
  <link href=" {{ asset ('css/style-fullscreen.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="{{ asset ('css/prism.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="{{ asset ('js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
  <link rel="stylesheet" href="{{ asset ('css/partition.css') }}">

</head>

<body class="cyan lighten-4">


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- Start Page Loading -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- Contents data array -->

  <script type="text/javascript">

    var selected_content=1;
    var current_scroll=0;
    var grid_rows=20;

    var contents = {
      "0":{
        "title":"Header",
        "description":"A picture of the mountain",
        "type":"Media",
        "owner":"Mounir",
        "creator":"Mounir",
        "responsible":"Lotfi BK",
        "top":7,
        "left":2,
        "height":3,
        "width":10,
        "center-h":true,
        "center-v":false,
        "displayed":false,
      },
      "1":{
        "title":"Introduction",
        "description":"Mont Fuji overview",
        "type":"Text",
        "owner":"Lotfi BK",
        "creator":"Lotfi BK",
        "responsible":"Mounir",
        "top":1,
        "left":3,
        "height":6,
        "width":7,
        "center-h":false,
        "center-v":true,
        "displayed":true,
      },
      "2":{
        "title":"aa",
        "description":"aa",
        "type":"Text",
        "owner":"Lotfi BK",
        "creator":"Lotfi BK",
        "responsible":"Mounir",
        "top":10,
        "left":2,
        "height":8,
        "width":8,
        "center-h":false,
        "center-v":false,
        "displayed":false,
      },
    };

  </script>

  <!-- //////////////////////////////////////////////////////////////////////////// -->



  <!-- Content add button -->
  <div class="add-content">
    <a class="modal-trigger modal-close btn waves-effect waves-light deep-orange darken-3 white-text" href="#content-form">
       new content <i class="mdi-content-add-box right"></i>
    </a>
  </div>

  <!-- Content modal form -->
  <div class="modal" id="content-form">

    <form class="col s12">
      <div class="card-panel">

        <h4 class="header2">New Content</h4>

        <div class="row">
          <div class="input-field col s12">
            <input id="content-title" type="text">
            <label for="content-title">Title</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <select id="content-type">
              <option value = "" disabled selected class="dark-text">Type</option>
              <option value = "1">Mango</option>
              <option value = "2">Orange</option>
              <option value = "3">Apple</option>
            </select>
            <label for="content-type" class="">Type</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <select id="content-responsible">
              <option value = "" disabled selected class="dark-text">Assigned To</option>
              <option value = "1">Mohamed</option>
              <option value = "2">Lotfi</option>
              <option value = "3">Mounir</option>
            </select>
            <label for="content-responsible" class="">Responsible</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <textarea id="content-description" class="materialize-textarea"></textarea>
            <label for="content-description">Description</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s3 offset-s9">
            <button class="btn teal waves-effect waves-light right" type="submit" name="action">
              Submit
              <i class="mdi-content-send right"></i>
            </button>
          </div>
        </div>

      </div>
    </form>

  </div>


  <!-- //////////////////////////////////////////////////////////////////////////// -->


  <!-- Content List -->
  <div class="card-panel teal panel-right contents-basket">

    <div class="card-panel white teal-text waves-effect" id="c-0">
      <h5 class=""> Header </h5>
      <span class=""> A picture of the mountain </span>

      <a class="add-to-board btn-floating teal">
        <i class="mdi-content-reply white-text"></i>
      </a>
    </div>

    <div class="card-panel white teal-text waves-effect" id="c-1">
      <h5 class=""> Introduction </h5>
      <span class=""> Mont Fuji overview  </span>

      <a class="add-to-board btn-floating teal">
        <i class="mdi-content-reply white-text"></i>
      </a>
    </div>

    <div class="card-panel white teal-text waves-effect" id="c-2">
      <h5 class=""> History </h5>
      <span class=""> The History of the mountain </span>

      <a class="add-to-board btn-floating teal">
        <i class="mdi-content-reply white-text"></i>
      </a>
    </div>

    <div class="card-panel white teal-text waves-effect" id="c-3">
      <h5 class=""> Tourism </h5>
      <span class=""> Tourism in mont Fuji</span>

      <a class="add-to-board btn-floating teal">
        <i class="mdi-content-reply white-text"></i>
      </a>
    </div>

  </div>


  <!-- //////////////////////////////////////////////////////////////////////////// -->


  <!-- Bottom Panel  -->
  <div class="card-panel teal panel-bottom">

    <!-- Currently selected content infos card   -->
    <div class="target-inf card-panel deep-orange accent-2 white-text">
      <h5> / </h5>
      <span> / </span>

      <a class="edit-content btn-floating white modal-trigger" href="#content-form">
        <i class="mdi-editor-border-color"></i>
      </a>
      <div class="delete-content btn-floating white">
        <i class="mdi-action-delete"></i>
      </div>
    </div>


    <!-- Movement buttons -->
    <div class="move-controls">
      <div class="white-text move-title"> Position </div>

      <div class="btn-floating waves-effect waves-light white move-top" style="top:5%; left:40%;">
        <i class="mdi-navigation-expand-less teal-text"></i>
      </div>
      <div class="btn-floating waves-effect waves-light white move-bot" style="bottom:5%; left:40%;">
        <i class="mdi-navigation-expand-more teal-text"></i>
      </div>
      <div class="btn-floating waves-effect waves-light white move-left" style="top:35%; left:10%;">
        <i class="mdi-navigation-chevron-left teal-text"></i>
      </div>
      <div class="btn-floating waves-effect waves-light white move-right" style="top:35%; right:10%;">
        <i class="mdi-navigation-chevron-right teal-text"></i>
      </div>

    </div>


    <!-- Size buttons -->
    <div class="size-controls">
      <div class="white-text size-title"> Size </div>

      <!--div class="btn-floating waves-effect waves-light yellow accent-4 tooltipped less-height"-->
      <div class="btn-floating waves-effect waves-light white tooltipped less-height"
      style="top:5%; left:40%;" data-position="top" data-delay="50" data-tooltip="Less height">
        <i class="mdi-navigation-unfold-less teal-text"></i>
      </div>
      <div class="btn-floating waves-effect waves-light white tooltipped more-height"
      style="bottom:5%; left:40%;"data-position="top" data-delay="50" data-tooltip="more height">
        <i class="mdi-navigation-unfold-more teal-text"></i>
      </div>
      <div class="btn-floating waves-effect waves-light white tooltipped less-width"
      style="top:35%; left:10%;"data-position="left" data-delay="50" data-tooltip="Less width">
        <i class="mdi-editor-vertical-align-top teal-text" style="transform:rotate(-90deg)"></i>
      </div>
      <div class="btn-floating waves-effect waves-light white tooltipped more-width"
      style="top:35%; right:10%;"data-position="right" data-delay="50" data-tooltip="more width">
        <i class="mdi-editor-vertical-align-top teal-text" style="transform:rotate(90deg)"></i>
      </div>

    </div>


    <!-- Currently selected content Settings -->
    <div class="properties-basket teal darken-2 white-text">
      <!-- col 1 -->
      <p style="grid-column:1; grid-row:1;">Owner</p>
      <p style="grid-column:1; grid-row:2;">Creator</p>
      <p style="grid-column:1; grid-row:3;">Responsible</p>
      <p style="grid-column:1; grid-row:4;">Type</p>

      <!-- col 2 -->
      <p style="grid-column:2; grid-row:1; text-align:left;">/</p>
      <p style="grid-column:2; grid-row:2; text-align:left;">/</p>
      <p style="grid-column:2; grid-row:3; text-align:left;">/</p>
      <p style="grid-column:2; grid-row:4; text-align:left;">/</p>

      <!-- col 3 -->
      <p style="grid-column:3; grid-row:1;">Top</p>
      <p style="grid-column:3; grid-row:2;">Left</p>
      <p style="grid-column:3; grid-row:3;">Width</p>
      <p style="grid-column:3; grid-row:4;">Height</p>

      <!-- col 4 -->
      <input type="number" value="0" style="grid-column:4; grid-row:1; text-align:left;" class="fix-input inf-top">
      <input type="number" value="0" style="grid-column:4; grid-row:2; text-align:left;" class="fix-input inf-left">
      <input type="number" value="0" style="grid-column:4; grid-row:3; text-align:left;" class="fix-input inf-width">
      <input type="number" value="0" style="grid-column:4; grid-row:4; text-align:left;" class="fix-input inf-height">
      <!--p style="grid-column:4; grid-row:4; text-align:left;">4</p-->

      <!-- col 5 -->
      <p style="grid-column:5; grid-row:1;">Center V</p>
      <p class="input-field" style="grid-column:5; grid-row:2;">
        <input type="checkbox" id="vertical-center">
        <label for="vertical-center"></label>
      </p>
      <p style="grid-column:5; grid-row:3; ">Center H</p>
      <p class="input-field white-text" style="grid-column:5; grid-row:4;">
        <input type="checkbox" id="horizontal-center">
        <label for="horizontal-center"></label>
      </p>

    </div>

  </div>


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- content managment board -->
  <div class="grid-container">
    <div class="grid-board">

      <div class="content-space" id="cs-1" style="grid-area:1 / 3 / span 6 / span 7 ;">
        <div class="content-itself card-panel deep-orange-text">
          <h5> Introduction </h5>
          <span> Mont Fuji overview </span>
        </div>
      </div>

    </div>
  </div>

  <!-- 12 vertical lines -->
  <div class="vertical-lines">
    <div class="teal darken-4" style="left:0%; width:3px;"></div>
    <div class="teal" style="left:8.33%;"></div>
    <div class="teal" style="left:16.66%;"></div>
    <div class="teal" style="left:25%;"></div>
    <div class="teal" style="left:33.33%;"></div>
    <div class="teal" style="left:41.66%;"></div>
    <div class="teal" style="left:50%;"></div>
    <div class="teal" style="left:58.33%;"></div>
    <div class="teal" style="left:66.66%;"></div>
    <div class="teal" style="left:75%;"></div>
    <div class="teal" style="left:83.33%;"></div>
    <div class="teal" style="left:91.66%;"></div>
    <div class="teal darken-4" style="left:100%; width:3px;"></div>
  </div>

  <!-- dynamic horizontal lines -->
  <div class="horizontal-lines">
    <div class="horizontal-line teal" style="margin-top:0;"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
    <div class="horizontal-line teal"></div>
  </div>





  <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- ============================= Scripts ============================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="{{ asset ('js/jquery-1.11.2.min.js') }}"></script>
    <!--materialize js-->
    <script type="text/javascript" src="{{ asset ('js/materialize.js') }}"></script>
    <!--prism-->
    <script type="text/javascript" src="{{ asset ('js/prism.js') }}"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="{{ asset ('js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="{{ asset ('js/plugins.js') }}"></script>
    <!--customJs-->
    <script type="text/javascript" src="{{ asset ('js/partition.js') }}"></script>

</body>
</html>
