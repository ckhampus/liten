<?php

/* blog.html */
class __TwigTemplate_827e86c354c59f395efb5c3f1f2e6ee5 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("base.html");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
    ";
        // line 5
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['posts']) ? $context['posts'] : null));
        foreach ($context['_seq'] as $context['_key'] => $context['post']) {
            // line 6
            echo "    <article id=\"post-0\">
        <header>
            <time pubdate datetime=\"";
            // line 8
            echo twig_escape_filter($this->env, twig_date_format_filter($this->getAttribute($this->getAttribute((isset($context['post']) ? $context['post'] : null), "date", array(), "any"), "sec", array(), "any"), "Y-m-d"), "html");
            echo "\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->getAttribute($this->getAttribute((isset($context['post']) ? $context['post'] : null), "date", array(), "any"), "sec", array(), "any"), "F j, Y"), "html");
            echo "</time>
            <h1><a href=\"";
            // line 9
            echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "slug", array(), "any"), "html");
            echo "\" rel=\"bookmark\" title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "title", array(), "any"), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "title", array(), "any"), "html");
            echo "</a></h1>
        </header>
        ";
            // line 11
            echo $this->getAttribute((isset($context['post']) ? $context['post'] : null), "content", array(), "any");
            echo "
        <footer>
            <p><a href=\"";
            // line 13
            echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "slug", array(), "any"), "html");
            echo "#comments\">";
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "comments", array(), "any")), "html");
            echo " Comment</a></p>
        </footer>
    </article>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 17
        echo "
    <div id=\"archive\">
        <h3>Older posts</h3>
        <ul>
            ";
        // line 21
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['posts']) ? $context['posts'] : null));
        foreach ($context['_seq'] as $context['_key'] => $context['post']) {
            // line 22
            echo "                <li><a href=\"";
            echo twig_escape_filter($this->env, (isset($context['base_url']) ? $context['base_url'] : null), "html");
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "slug", array(), "any"), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['post']) ? $context['post'] : null), "title", array(), "any"), "html");
            echo "</a></ul>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 24
        echo "        </ul>
    </div>

";
    }

    public function getTemplateName()
    {
        return "blog.html";
    }
}
