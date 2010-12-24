<?php

/* base.html */
class __TwigTemplate_8944b57466f08564caa53a1988261ae0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\" class=\"no-js\">
<head>
    <meta charset=\"utf-8\">

    <!-- www.phpied.com/conditional-comments-block-downloads/ -->
    <!--[if IE]><![endif]-->

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
         Remove this if you use the .htaccess -->
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <title>";
        // line 12
        echo twig_escape_filter($this->env, (isset($context['title']) ? $context['title'] : null), "html");
        echo "</title>
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">

    <!--  Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0\">

    <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel=\"shortcut icon\" href=\"/favicon.ico\">
    <link rel=\"apple-touch-icon\" href=\"/apple-touch-icon.png\">

    <!-- CSS : implied media=\"all\" -->
    <link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "/css/style.css\">

    <!-- Uncomment if you are specifically targeting less enabled mobile browsers
    <link rel=\"stylesheet\" media=\"handheld\" href=\"css/handheld.css?v=1\">  -->

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src=\"";
        // line 30
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "/js/modernizr-1.5.min.js\"></script>
</head>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class=\"ie6\"> <![endif]-->
<!--[if IE 7 ]>    <body class=\"ie7\"> <![endif]-->
<!--[if IE 8 ]>    <body class=\"ie8\"> <![endif]-->
<!--[if IE 9 ]>    <body class=\"ie9\"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->

    <div id=\"container\">
        <header>
            <h1><a href=\"";
        // line 43
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "\">Cristian Hampus</a></h1>
            <p>I'm a graphic design student<br>from Sweden who loves web design.</p>
        </header>
        <div id=\"main\">
            ";
        // line 47
        $this->getBlock('content', $context, $blocks);
        // line 50
        echo "        </div>
        <footer>
        </footer>
    </div> <!--! end of #container -->

    <!-- Javascript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
    <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js\"></script>
    <script>!window.jQuery && document.write('<script src=\"";
        // line 59
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "/js/jquery-1.4.2.min.js\"><\\/script>')</script>

    <script src=\"";
        // line 61
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "/js/plugins.js?v=1\"></script>
    <script src=\"";
        // line 62
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "/js/script.js?v=1\"></script>

    <!--[if lt IE 7 ]>
        <script src=\"";
        // line 65
        echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
        echo "/js/dd_belatedpng.js?v=1\"></script>
    <![endif]-->

    <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet 
         change the UA-XXXXX-X to be your site's ID -->
    <script>
        var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
        (function(d, t) {
            var g = d.createElement(t),
                s = d.getElementsByTagName(t)[0];
            g.async = true;
            g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g, s);
        })(document, 'script');
    </script>
</body>
</html>";
    }

    // line 47
    public function block_content($context, array $blocks = array())
    {
        // line 48
        echo "            
            ";
    }

    public function getTemplateName()
    {
        return "base.html";
    }
}
