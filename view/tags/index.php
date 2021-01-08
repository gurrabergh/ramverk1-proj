<?php
namespace Anax\View;

?>
<h1>Taggar</h1>
<p>Klicka på en tagg för att se alla inlägg som har taggats med den taggen.</p>
<ul>
<?php foreach ($tags as $tag) { ?>
            <li>
                <p><a href="tags/view?tag=<?= $tag->tag ?>"><?= $tag->tag?></a></p>
            </li>
<?php } ?>
</ul>