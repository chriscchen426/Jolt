<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>JOLT - Java Learning</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">JOLT</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Manage Courses</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Course name - CPS1234</p>
                <div class="list-group">
                    <a href="#" class="list-group-item active">Hello World</a>
                    <a href="#" class="list-group-item">Write a for loop</a>
                    <a href="#" class="list-group-item">Methods</a>
                </div>
            </div>

            <div class="col-md-9">

                <div class="thumbnail">
                    <div class="caption-full">
                        <div id="PageContent">

<p>Now that you've seen the "Hello World!" application (and perhaps even compiled and run it), you might be wondering how it works. Here again is its code:</p>
<div class="codeblock"><pre>
class HelloWorldApp {
    public static void main(String[] args) {
        System.out.println("Hello World!"); // Display the string.
    }
}
</pre></div>
<p>The "Hello World!" application consists of three primary components: <a href="#COMMENTS">source code comments</a>, <a href="#CLASS_DEF">the <code>HelloWorldApp</code> class definition</a>, and <a href="#MAIN">the <code>main</code> method</a>. The following explanation will provide you with a basic understanding of the code, but the deeper implications will only become apparent after you've finished reading the rest of the tutorial.</p>
<h2><a name="COMMENTS" id="COMMENTS">Source Code Comments</a></h2>
<p><a name="COMMENTS__1" id="COMMENTS__1">The following bold text defines the <i>comments</i> of the "Hello World!" application:</a></p>
<div class="codeblock"><pre><b>/**
 * The HelloWorldApp class implements an application that
 * simply prints "Hello World!" to standard output.
 */</b>
class HelloWorldApp {
    public static void main(String[] args) {
        System.out.println("Hello World!"); <b>// Display the string.</b>
    }
}
</pre></div>
<p>Comments are ignored by the compiler but are useful to other programmers. The Java programming language supports three kinds of comments:</p>
<dl>
<dt><code>/* <em>text</em> */</code></dt>
<dd>The compiler ignores everything from <code>/*</code> to <code>*/</code>.</dd>
<dt><code>/** <em>documentation</em> */</code></dt>
<dd>This indicates a documentation comment (<em>doc comment</em>, for short). The compiler ignores this kind of comment, just like it ignores comments that use <code>/*</code> and <code>*/</code>. The <code>javadoc</code> tool uses doc comments when preparing automatically generated documentation. For more information on <code>javadoc</code>, see the 
<a class="OutsideLink" target="_blank" href="https://docs.oracle.com/javase/8/docs/technotes/guides/javadoc/index.html">Javadoc™ tool documentation</a> .</dd>
<dt><code>// <em>text</em></code></dt>
<dd>The compiler ignores everything from <code>//</code> to the end of the line.</dd>
</dl>
<h2><a name="CLASS_DEF" id="CLASS_DEF">The <code>HelloWorldApp</code> Class Definition</a></h2>
<p><a name="CLASS_DEF__1" id="CLASS_DEF__1">The following bold text begins the class definition block for the "Hello World!" application:</a></p>
<div class="codeblock"><pre>/**
 * The HelloWorldApp class implements an application that
 * simply displays "Hello World!" to the standard output.
 */
<b>class HelloWorldApp {</b>
    public static void main(String[] args) {
        System.out.println("Hello World!"); // Display the string.
    }
<b>}</b>
</pre></div>
<p>As shown above, the most basic form of a class definition is:</p>
<div class="codeblock"><pre>class <em>name</em> {
    . . .
}
</pre></div>
<p>The keyword <code>class</code> begins the class definition for a class named <code>name</code>, and the code for each class appears between the opening and closing curly braces marked in bold above. Chapter 2 provides an overview of classes in general, and Chapter 4 discusses classes in detail. For now it is enough to know that every application begins with a class definition.</p>
<h2><a name="MAIN" id="MAIN">The <code>main</code> Method</a></h2>
<p><a name="MAIN__1" id="MAIN__1">The following bold text begins the definition of the <code>main</code> method:</a></p>
<div class="codeblock"><pre>/**
 * The HelloWorldApp class implements an application that
 * simply displays "Hello World!" to the standard output.
 */
class HelloWorldApp {
    <b>public static void main(String[] args) {</b>
        System.out.println("Hello World!"); //Display the string.
    <b>}</b>
}
</pre></div>
<p>In the Java programming language, every application must contain a <code>main</code> method whose signature is:</p>
<div class="codeblock"><pre>public static void main(String[] args)
</pre></div>
<p>The modifiers <code>public</code> and <code>static</code> can be written in either order (<code>public static</code> or <code>static public</code>), but the convention is to use <code>public static</code> as shown above. You can name the argument anything you want, but most programmers choose "args" or "argv".</p>
<p>The <code>main</code> method is similar to the <code>main</code> function in C and C++; it's the entry point for your application and will subsequently invoke all the other methods required by your program.</p>
<p>The <code>main</code> method accepts a single argument: an array of elements of type <code>String</code>.</p>
<div class="codeblock"><pre>public static void main(<b>String[] args</b>)
</pre></div>
<p>This array is the mechanism through which the runtime system passes information to your application. For example:</p>
<div class="codeblock"><pre>java <em>MyApp</em> <em>arg1</em> <em>arg2</em>
</pre></div>
<p>Each string in the array is called a <em>command-line argument</em>. Command-line arguments let users affect the operation of the application without recompiling it. For example, a sorting program might allow the user to specify that the data be sorted in descending order with this command-line argument:</p>
<div class="codeblock"><pre>-descending
</pre></div>
<p>The "Hello World!" application ignores its command-line arguments, but you should be aware of the fact that such arguments do exist.</p>
<p>Finally, the line:</p>
<div class="codeblock"><pre>System.out.println("Hello World!");
</pre></div>
<p>uses the <code>System</code> class from the core library to print the "Hello World!" message to standard output. Portions of this library (also known as the "Application Programming Interface", or "API") will be discussed throughout the remainder of the tutorial.</p>


        </div>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">3 reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div>
                </div>

                <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success">Leave a Review</a>
                    </div>

                    <hr>

                    
                    <hr>

                    

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<footer><iframe scrolling="no" src="https://www.learnjavaonline.org/" style="border: 0px none; margin-left: 0px; height: 280px; margin-top: -80px; width: 926px;">
</iframe></footer>

</body>

</html>
