<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Email UI - Dribbble Rebound</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
      @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
* {
  box-sizing: border-box;
}

body {
  font-family: 'Open Sans', sans-serif;
}

.clr {
  clear: both;
}

a {
  text-decoration: none;
}

.btn {
  border-radius: 4px;
  padding: 6px 10px;
  text-align: center;
  text-shadow: none;
  color: #fff;
  background: #fff;
}
.btn.btn-primary {
  background: #44c4e7;
}

.container {
  display: flex;
  width: 100%;
  height: 100%;
}

.sidebar {
  width: 250px;
  background: #34393d;
  order: 1;
  flex-flow: column;
  color: #fff;
}
.sidebar a {
  color: #fff;
}
.sidebar h1 {
  font-weight: 400;
  background: #19a0c5;
  line-height: 80px;
  margin: 0;
  padding: 0 30px;
}
.sidebar .main-nav {
  margin: 30px 0;
}
.sidebar .main-nav > ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
.sidebar .main-nav > ul > li {
  transition: background-color .3s ease;
}
.sidebar .main-nav > ul > li.active, .sidebar .main-nav > ul > li:hover {
  background: #40464b;
}
.sidebar .main-nav > ul > li > a {
  padding: 20px 30px;
  display: block;
  color: #999;
  font-weight: 700;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}
.sidebar .main-nav > ul > li > .btn {
  display: block;
  color: #fff;
  text-shadow: none;
  margin: 10px 30px;
  padding: 10px;
  font-weight: 400;
}
.sidebar .main-nav > ul > li > ul {
  list-style: none;
  margin: 0;
  padding: 10px 0;
}
.sidebar .main-nav > ul > li > ul.labels {
  border-top: 1px solid #555;
  margin-top: 20px;
}
.sidebar .main-nav > ul > li > ul > li {
  transition: background-color .3s ease;
  padding: 10px 30px;
}
.sidebar .main-nav > ul > li > ul > li.active, .sidebar .main-nav > ul > li > ul > li:hover {
  background: #4b5359;
}
.sidebar .main-nav > ul > li > ul > li .btn {
  font-size: .875rem;
  padding: 5px;
  float: right;
  position: relative;
  top: -4px;
}
.sidebar .main-nav > ul > li > ul > li .label {
  width: 20px;
  height: 20px;
  display: inline-block;
  top: 0;
}
.sidebar .main-nav > ul > li > ul > li a {
  color: #999;
}

.main {
  -webkit-flex: 1;
  order: 2;
  background: #f5f5f5;
}
.main .header {
  background: #44c4e7;
  min-height: 80px;
}
.main .header form {
  padding: 20px;
  display: inline-block;
}
.main .header form input[type="search"] {
  background: #19a0c5;
  border: none;
  border-radius: 3px;
  line-height: 40px;
  width: 500px;
  padding: 0 10px;
  outline: none;
}
.main .header form input[type="search"]::-webkit-input-placeholder {
  color: #fff;
}
.main .header ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
.main .header .nav-settings {
  float: right;
  line-height: 80px;
  border-left: 1px solid #1cb3dc;
}
.main .header .nav-settings li {
  display: inline-block;
}
.main .header .nav-settings li:hover {
  background: #2dbde4;
}
.main .header .nav-settings li a {
  padding: 0 20px;
  color: #fff;
  display: inline-block;
}

.messages {
  order: 1;
  width: 400px;
  background: #fff;
  border-right: 1px solid #DDD;
}
.messages h1 {
  margin: 0;
  padding: 20px;
  font-weight: 400;
  color: #777;
  border-bottom: 1px solid #DDD;
}
.messages form {
  padding: 20px;
  background: #FCFCFC;
}
.messages form input[type="search"] {
  width: 100%;
  border-radius: 4px;
  border: 1px solid #ddd;
  padding: 10px;
  box-sizing: border-box;
  outline: none;
}
.messages .message-list {
  padding: 0;
  margin: 0;
  list-style: none;
  border-bottom: 1px solid #ddd;
}
.messages .message-list li {
  background: #F8F6F4;
  transition: background-color .3s ease;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  border-right: 3px solid #1cb3dc;
  padding: 10px 20px;
  display: flex;
  cursor: pointer;
}
.messages .message-list li input[type="checkbox"] {
  appearance: none;
  cursor: pointer;
  margin: 5px 10px 0 0;
  order: 1;
  width: 15px;
  height: 15px;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 3px;
}
.messages .message-list li input[type="checkbox"]:checked {
  background: #EFEFEF;
}
.messages .message-list li .preview {
  flex: 1;
  order: 2;
}
.messages .message-list li .preview h3 {
  margin: 0;
  font-weight: 400;
  color: #333;
}
.messages .message-list li .preview h3 small {
  float: right;
  color: #AAA;
  font-size: .8125rem;
}
.messages .message-list li .preview p {
  color: #888;
  margin: 5px 0;
}
.messages .message-list li:hover {
  background: #fff;
}
.messages .message-list li.active {
  background: #fd9162;
  border-right: 3px solid rgba(0, 0, 0, 0.1);
}
.messages .message-list li.active .preview h3, .messages .message-list li.active .preview h3 small, .messages .message-list li.active .preview p {
  color: #fff;
}
.messages .message-list li.new {
  background: #fff;
  border-right: 3px solid #44c4e7;
}

.message {
  -webkit-flex: 1;
  order: 2;
  background: #fff;
}
.message h2 {
  margin: 0;
  padding: 20px 30px;
  font-weight: 400;
}
.message .meta-data {
  margin: 10px 30px;
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
  line-height: 50px;
  color: #888;
}
.message .meta-data .user {
  color: #fd9162;
}
.message .meta-data img {
  display: inline;
  vertical-align: middle;
  margin-right: 20px;
  border-radius: 3px;
}
.message .meta-data .date {
  float: right;
  color: #aaa;
}
.message .body {
  padding: 20px 30px;
}
.message .action {
  background: #fcfcfc;
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
  padding: 20px 30px;
}
.message .action .options {
  list-style: none;
  margin: 0;
  padding: 0;
}
.message .action .options li {
  float: left;
}
.message .action .options li:first-child {
  border-right: 1px solid #ddd;
}
.message .action .options li:first-child a {
  padding-left: 0;
}
.message .action .options li a {
  color: #888;
  padding: 0 10px;
}
.message .action .options li a.active {
  color: #333;
}
.message .action .textarea {
  background: #fff;
  padding: 10px;
  border: 1px solid #ddd;
  position: relative;
  margin: 20px 0;
}
.message .action .textarea:before {
  content: '';
  display: block;
  border: 10px solid transparent;
  border-bottom: 10px solid #FFF;
  position: absolute;
  top: -19px;
  left: 25px;
  -webkit-filter: drop-shadow(0 -1px 0 #ddd);
}
.message .action .textarea textarea {
  width: 100%;
  min-height: 300px;
  appearance: none;
  border: none;
  resize: none;
  outline: none;
  margin-bottom: 50px;
}
.message .action .textarea .fileupload {
  background: #FCFCFC;
  border: 1px solid #ddd;
  padding: 10px;
  color: #888;
  justify-content: space-between;
}
.message .action .textarea .fileupload .fileinfo {
  flex: 1;
}
.message .action .textarea .fileupload .progress {
  width: 80%;
  border: 1px solid #ddd;
  background: #fff;
  padding: 2px;
}
.message .action .textarea .fileupload .progress .bar {
  background: #44c4e7;
  width: 65%;
  text-align: right;
  color: #fff;
  padding: 3px;
  font-size: .75rem;
}

    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body>
  <div class="container app">
  <aside class="sidebar">
    <h1 class="logo">
      <a href="#">Simpl<strong>est</strong></a>
    </h1>
    <nav class="main-nav">
      <ul>
        <li><a href="#">Profile</a></li>
        <li class="active">
          <a href="#">Email</a><br />
          <a href="#" class="btn btn-primary">Compose new</a>
          <ul>
            <li class="active"><a href="#">Inbox <span class="btn btn-primary">25</span></a></li>
            <li><a href="#">Drafts</a></li>
            <li><a href="#">Sent</a></li>
            <li><a href="#">Trash</a></li>
            <li><a href="#">Junk Mail</a></li>
          </ul>
          <ul class="labels">
            <li><a href="#">Clients <span class="btn btn-primary label"></span></a></li>
            <li><a href="#">Friends <span class="btn btn-primary label"></span></a></li>
            <li><a href="#">Family <span class="btn btn-primary label"></span></a></li>
            <li><a href="#">Dribbble <span class="btn btn-primary label"></span></a></li>
          </ul>
        </li>
        <li><a href="#">Docs</a></li>
        <li><a href="#">Stats</a></li>
      </ul>
    </nav>
  </aside>
  <div class="main">
    <header class="header">
      <form action="">
        <input type="search" name="s" placeholder="Search on simplest" />
      </form>
      <nav class="nav-settings">
        <ul>
          <li><a href="#">Gregoire Vella</a></li>
          <li><a href="#" class="icon icon-gear"></a></li>
        </ul>
      </nav>
      <div class="clr"></div>
    </header>
    <div class="container">
      <div class="messages">
        <h1>Inbox <span class="icon icon-arrow-down"></span></h1>
        <form action="">
          <input type="search" class="search" placeholder="Search Inbox" />
        </form>
        <ul class="message-list">
          <li class="new">
            <input type="checkbox" />
            <div class="preview">
              <h3>Sarach Connor <small>Jul 15</small></h3>
              <p><strong>I've been hunted - </strong>A crazing robot ...</p>
            </div>
          </li>
          <li class="active">
            <input type="checkbox" />
            <div class="preview">
              <h3>Jeremy Clarkson <small>Jul 15</small></h3>
              <p>The brand new season of Top Gear</p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Eureka.com <small>Jul 14</small></h3>
              <p><strong>Interface design - </strong>Hi Greg ...</p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Jeremy Legrand <small>Jul 13</small></h3>
              <p><strong>CSS Responsive - </strong>Here is my hack to ...</p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Noe Vella <small>Jul 13</small></h3>
              <p><strong>Personal resume - </strong>Hi Greg, as expected ...</p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Dribbble <small>Jul 12</small></h3>
              <p><strong>Thank you for purchaseing a pro account</strong></p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Dribbble <small>Jul 12</small></h3>
              <p><strong>Work inquiry from Andy Blast - </strong>the foll...</p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Behance <small>Jul 12</small></h3>
              <p><strong>Raj sent you a direct message - </strong></p>
            </div>
          </li>
          <li class="new">
            <input type="checkbox" />
            <div class="preview">
              <h3>Behance <small>Jul 12</small></h3>
              <p><strong>Raj sent you a direct message - </strong></p>
            </div>
          </li>
          <li class="">
            <input type="checkbox" />
            <div class="preview">
              <h3>Dribbble <small>Jul 11</small></h3>
              <p><strong>Peter Avey is now following you - </strong>Hi ...</p>
            </div>
          </li>
        </ul>
      </div>
      <section class="message">
        <h2><span class="icon icon-star-large"></span> The brand new season of Top Gear <span class="icon icon-reply-large"></span><span class="icon icon-delete-large"></span></h2>
        <div class="meta-data">
          <p>
            <img src="http://placehold.it/40x40" class="avatar" alt="" />
            Jeremy Clarkson to <span class="user">me</span>
            <span class="date">July 15, 2013</span>
          </p>
        </div>
        <div class="body">
          <p>Hi Greg,</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam modi possimus dignissimos maxime ipsa unde voluptatum consectetur harum debitis dolorum quas quibusdam vero iusto ducimus blanditiis. Enim autem illo praesentium est quis ab voluptate sequi quia magnam deleniti vero dicta iste. Harum velit asperiores expedita inventore error nulla eius nostrum voluptas aspernatur at quia eaque ipsa deserunt quas doloribus totam incidunt mollitia iure! Libero laudantium nobis necessitatibus veniam autem molestias distinctio voluptas quos aliquam vitae. Consequuntur adipisci natus hic sed rerum dolore cumque numquam illum rem at quaerat reprehenderit iste quis maiores fuga voluptates delectus suscipit dicta nulla itaque placeat.</p>
          <p>Cheers</p>
        </div>
        <div class="action">
          <ul class="options">
            <li><a href="#" class="active">Answering</a></li>
            <li><a href="#">Forward</a></li>
            <div class="clr"></div>
          </ul>
          <div class="textarea">
            <textarea name="r">Hello Jeremy,
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit qui impedit magni fuga velit nobis quas fugit odio voluptas voluptates odit animi quos nam dolorem harum molestiae culpa sint rem ad esse laboriosam vero quod molestias porro ea dolores eligendi!
            </textarea>
            <div class="fileupload container">
              <span class="fileinfo">My file enclosed.pdf</span>
              <div class="progress">
                <div class="bar">65%</div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
  
  
</body>
</html>
