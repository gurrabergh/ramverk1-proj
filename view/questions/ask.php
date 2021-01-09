<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
?>
<h1>Ställ fråga</h1>
<p>Skriv frågans innehåll i markdown.</p>
<p>Ange taggar som ord med ett mellanrum(space) mellan varje tagg. </p>
<p>Exempel: <code>djur blå stor</code></p>
<?php
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?><article <?= classList($classes) ?>>
<?= $content ?>
</article>

