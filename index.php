<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Admin Panel</title>
  <meta name="description" content="admin panel">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="{{csrfToken}}">

  <!--<link rel="shortcut icon" href="./favicon.ico">-->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bb-login.css">
  <link rel="stylesheet" href="css/jquery.fileupload.css">
  <link rel="stylesheet" href="css/jquery.fileupload-ui.css">
  <noscript>&lt;link rel="stylesheet" href="css/jquery.fileupload-noscript.css"&gt;</noscript>
  <noscript>&lt;link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"&gt;</noscript>

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!--[if !IE 7]>
  <style type="text/css">
    #wrap {display:table;height:100%}
  </style>
  <![endif]-->

  <link type="text/css" rel="stylesheet" href="css/main.css" media="screen" />
  <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

<!--   <?php
  // $file = 'http://'.$_SERVER['HTTP_HOST']."/cocoadynamics/c/data/index.php?children=s20";
  ?> -->

</head>
<body>

  <!-- The navbar -->
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-container">
      --Moingo Logo goes here--
    </div>
  </nav>

  <!-- The wrapper HTML -->
  <div class="container-fluid">
    <div id="data-wrapper" class="row">
     <div id="addItemButton" class="col-sm-2"><button type="button" id="add" class="btn btn-primary btn-lg">Add New Item</button></div>
     <div id="attachItemButton" class="col-sm-2"><button type="button" id="attach" class="btn btn-primary btn-lg" data-target="#attach-item" data-toggle="modal">Attach Item</button></div>
     <div id="items-div">
     </div>
   </div>
 </div>
 <!-- The handlebars template for the item view -->
 <script id="data-template" type="text/x-handlebars-template">
  <form class="form">
    <div class="wrapper" id="{{id}}">
      <div class="row">

        <div class="col-xs-12 col-sm-6">
          <div class="form-group">
            <label for="name"><strong>Name:</strong></label>
            <input type="text" class="form-control" name="name" value="{{name}}" size="50" />
          </div>
          <div class="form-group">
            <label for="description"><strong>Description:</strong></label>
            <input type="text" class="form-control" name="description" value="{{description}}" size="75" />
          </div>
          <div class="form-group">
            <label for="url"><strong>URL or youtubeID:</strong></label>
            <input type="text" class="form-control" name="url" value="{{url}}" size="75" />
          </div>
          <!--            </div>
          <div class=col-xs-12>-->
            <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
              <!-- Redirect browsers with JavaScript disabled to the origin page -->
              <noscript>&lt;input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"&gt;</noscript>
              <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
              <div class="row fileupload-buttonbar">
                <div class="col-sm-12">
                  <!-- The fileinput-button span is used to style the file input field as button -->
                  <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add Thumbnail</span>
                    <input type="file" name="files[]" multiple="">
                  </span>
                  <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                  </button>
                  <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                  </button>
                  <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                  </button>
                  <!--<input type="checkbox" class="toggle">-->
                  <!-- The global file processing state -->
                  <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="col-sm-12 fileupload-progress fade">
                  <!-- The global progress bar -->
                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                  </div>
                  <!-- The extended global progress state -->
                  <div class="progress-extended">&nbsp;</div>
                </div>
              </div>
              <!-- The table listing the files available for upload/download -->
              <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
            </form>
          </div>

          <div class='col-xs-12 col-sm-3'>
            <label for="thumbnail">Thumbnail:</label>
            <img src="/thumbnails/{{thumbnail}}" class="img-responsive">
          </div>

          <div class="col-xs-12 col-sm-3">
           <span class="glyphicon glyphicon-arrow-up"></span>
           <span class="glyphicon glyphicon-arrow-down"></span>
           <!-- <button type="button" class="addItemtoCollection main btn btn-primary btn-lg">Add Video to Different Collection</button> -->
           <button type="submit" class="submit main btn btn-success btn-lg">Submit Changes</button><br>
           <button type="submit" class="delete main btn btn-danger btn-lg">Delete</button><br><br>
           <button type="button" class="chapterMarkers main btn btn-primary btn-lg" data-toggle="modal" data-target="#chapters-modal">Edit Chapter Markers</button>
           <button type="submit" class="stepIn main btn btn-primary btn-lg" data-id="{{id}}">Step In</button><br><br>
         </div>
       </div>
     </div>
   </form>
 </script>

 <!-- Handlebars template for modal-->
 <script id="modal-template" type="text/x-handlebars-template">
  <div class="modal fade bs-modal-lg" id="chapters-modal" tabindex="-1" role="dialog" aria-labelledby="LargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="modalLabel" data-pid="{{id}}" ><strong>{{name}}</strong><span>{{id}}</span></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5">
              <div class="flex-video widescreen" >
                <iframe id="youtube-video" width="560" height="315" src="https://www.youtube.com/embed/{{url}}?enablejsapi=1" frameborder="0" enablejsapi="1" allowfullscreen></iframe>
              </div>
            </div>
            <div class="col-sm-7" id="chaptersCollection-div" >
              <strong>CHAPTERS</strong>
              <button type="button" id="addChapter" class="btn btn-primary">Add New Chapter</button>
              <button type="button" id="saveChapters" class="btn btn-success">Save Chapters</button>
              <div id="chapters-div">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</script>
<!-- Handlebars script for the Chapters-->
<script id="chapters-template" type="text/x-handlebars-template">
  <div class="col-sm-12">
    <form class="form-inline modal-form chapter-form" role="form" name="modal-form">

      <label for="hours">Hours:</label>
      <select class="form-control hours" name="hours">
        <option{{selected hours "0"}}>0</option>
        <option{{selected hours "1"}}>1</option>
        <option{{selected hours "2"}}>2</option>
      </select>

      <label for="minutes">Minutes:</label>
      <select class="form-control minutes" name="minutes">
        <option{{selected minutes "0"}}>0</option>
        <option{{selected minutes "1"}}>1</option>
        <option{{selected minutes "2"}}>2</option>
        <option{{selected minutes "3"}}>3</option>
        <option{{selected minutes "4"}}>4</option>
        <option{{selected minutes "5"}}>5</option>
        <option{{selected minutes "6"}}>6</option>
        <option{{selected minutes "7"}}>7</option>
        <option{{selected minutes "8"}}>8</option>
        <option{{selected minutes "9"}}>9</option>
        <option{{selected minutes "10"}}>10</option>
        <option{{selected minutes "11"}}>11</option>
        <option{{selected minutes "12"}}>12</option>
        <option{{selected minutes "13"}}>13</option>
        <option{{selected minutes "14"}}>14</option>
        <option{{selected minutes "15"}}>15</option>
        <option{{selected minutes "16"}}>16</option>
        <option{{selected minutes "17"}}>17</option>
        <option{{selected minutes "18"}}>18</option>
        <option{{selected minutes "19"}}>19</option>
        <option{{selected minutes "20"}}>20</option>
        <option{{selected minutes "21"}}>21</option>
        <option{{selected minutes "22"}}>22</option>
        <option{{selected minutes "23"}}>23</option>
        <option{{selected minutes "24"}}>24</option>
        <option{{selected minutes "25"}}>25</option>
        <option{{selected minutes "26"}}>26</option>
        <option{{selected minutes "27"}}>27</option>
        <option{{selected minutes "28"}}>28</option>
        <option{{selected minutes "29"}}>29</option>
        <option{{selected minutes "30"}}>30</option>
        <option{{selected minutes "31"}}>31</option>
        <option{{selected minutes "32"}}>32</option>
        <option{{selected minutes "33"}}>33</option>
        <option{{selected minutes "34"}}>34</option>
        <option{{selected minutes "35"}}>35</option>
        <option{{selected minutes "36"}}>36</option>
        <option{{selected minutes "37"}}>37</option>
        <option{{selected minutes "38"}}>38</option>
        <option{{selected minutes "39"}}>39</option>
        <option{{selected minutes "40"}}>40</option>
        <option{{selected minutes "41"}}>41</option>
        <option{{selected minutes "42"}}>42</option>
        <option{{selected minutes "43"}}>43</option>
        <option{{selected minutes "44"}}>44</option>
        <option{{selected minutes "45"}}>45</option>
        <option{{selected minutes "46"}}>46</option>
        <option{{selected minutes "47"}}>47</option>
        <option{{selected minutes "48"}}>48</option>
        <option{{selected minutes "49"}}>49</option>
        <option{{selected minutes "50"}}>50</option>
        <option{{selected minutes "51"}}>51</option>
        <option{{selected minutes "52"}}>52</option>
        <option{{selected minutes "53"}}>53</option>
        <option{{selected minutes "54"}}>54</option>
        <option{{selected minutes "55"}}>55</option>
        <option{{selected minutes "56"}}>56</option>
        <option{{selected minutes "57"}}>57</option>
        <option{{selected minutes "58"}}>58</option>
        <option{{selected minutes "59"}}>59</option>
      </select>

      <label for="seconds">Seconds:</label>
      <select class="form-control seconds" name="seconds">
        <option{{selected seconds "0"}}>0</option>
        <option{{selected seconds "1"}}>1</option>
        <option{{selected seconds "2"}}>2</option>
        <option{{selected seconds "3"}}>3</option>
        <option{{selected seconds "4"}}>4</option>
        <option{{selected seconds "5"}}>5</option>
        <option{{selected seconds "6"}}>6</option>
        <option{{selected seconds "7"}}>7</option>
        <option{{selected seconds "8"}}>8</option>
        <option{{selected seconds "9"}}>9</option>
        <option{{selected seconds "10"}}>10</option>
        <option{{selected seconds "11"}}>11</option>
        <option{{selected seconds "12"}}>12</option>
        <option{{selected seconds "13"}}>13</option>
        <option{{selected seconds "14"}}>14</option>
        <option{{selected seconds "15"}}>15</option>
        <option{{selected seconds "16"}}>16</option>
        <option{{selected seconds "17"}}>17</option>
        <option{{selected seconds "18"}}>18</option>
        <option{{selected seconds "19"}}>19</option>
        <option{{selected seconds "20"}}>20</option>
        <option{{selected seconds "21"}}>21</option>
        <option{{selected seconds "22"}}>22</option>
        <option{{selected seconds "23"}}>23</option>
        <option{{selected seconds "24"}}>24</option>
        <option{{selected seconds "25"}}>25</option>
        <option{{selected seconds "26"}}>26</option>
        <option{{selected seconds "27"}}>27</option>
        <option{{selected seconds "28"}}>28</option>
        <option{{selected seconds "29"}}>29</option>
        <option{{selected seconds "30"}}>30</option>
        <option{{selected seconds "31"}}>31</option>
        <option{{selected seconds "32"}}>32</option>
        <option{{selected seconds "33"}}>33</option>
        <option{{selected seconds "34"}}>34</option>
        <option{{selected seconds "35"}}>35</option>
        <option{{selected seconds "36"}}>36</option>
        <option{{selected seconds "37"}}>37</option>
        <option{{selected seconds "38"}}>38</option>
        <option{{selected seconds "39"}}>39</option>
        <option{{selected seconds "40"}}>40</option>
        <option{{selected seconds "41"}}>41</option>
        <option{{selected seconds "42"}}>42</option>
        <option{{selected seconds "43"}}>43</option>
        <option{{selected seconds "44"}}>44</option>
        <option{{selected seconds "45"}}>45</option>
        <option{{selected seconds "46"}}>46</option>
        <option{{selected seconds "47"}}>47</option>
        <option{{selected seconds "48"}}>48</option>
        <option{{selected seconds "49"}}>49</option>
        <option{{selected seconds "50"}}>50</option>
        <option{{selected seconds "51"}}>51</option>
        <option{{selected seconds "52"}}>52</option>
        <option{{selected seconds "53"}}>53</option>
        <option{{selected seconds "54"}}>54</option>
        <option{{selected seconds "55"}}>55</option>
        <option{{selected seconds "56"}}>56</option>
        <option{{selected seconds "57"}}>57</option>
        <option{{selected seconds "58"}}>58</option>
        <option{{selected seconds "59"}}>59</option>
      </select>

      <label class="sr-only" for="chapterTitle">Title</label>
      <input type="text" class="form-control chapterTitle" placeholder="Title" value="{{title}}" name="title">
      <button type="button" class="btn btn-danger btn-lg deleteChapter">Delete</button>
      <button type="button" class="btn btn-primary btn-lg cue">Cue</button>
    </form>
  </div>
</script>

<div class="modal fade bs-modal-lg" id="attach-item"  tabindex="-1" role="dialog" aria-labelledby="LargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
     <h4 class="modal-title" id="modalLabel"><strong>Attach</strong></h4>
   </div>
   <div class="modal-body">
     <div class="container">
      <div class="row">
       <div class="col-sm-12" id="attach-modalContent">
        <input type="text" id="search-text-attach" class="col-sm-8" value="space"/>

        <div class='col-sm-3'><button type="button" id="search-attach" class="btn btn-primary col-sm-8">Search</button></div>
      </div>
      <div class="col-sm-12" id="attachCollection-div">
       <ul>
        <li class="col-sm-2">ID</li> <li class="col-sm-5">Name</li></ul>
      </ul>
      <ul id="attach-item-list">

      </ul>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>

<script id="attach-template" type="text/x-handlebars-template">
	<li class="col-sm-2">{{id}}</li> <li class="col-sm-7">{{name}}</li><li class="col-sm-3"><button type="button" class="itemAttach btn btn-primary col-sm-12">attach</button></li></ul>
</script>

<!-- Required libraries -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="js/libs/bootstrap.min.js"></script>
<script src="js/libs/underscore.js" type="text/javascript"></script>
<script src="js/libs/backbone.js" type="text/javascript"></script>
<script src="js/libs/handlebars.js" type="text/javascript"></script>

<!-- Backbone scripts -->
<script src="js/models.js" type="text/javascript"></script>
<script src="js/collections.js" type="text/javascript"></script>
<script src="js/views.js" type="text/javascript"></script>
<script src="js/app.js" type="text/javascript"></script>

</body>
</html>