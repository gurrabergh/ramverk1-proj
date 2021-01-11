<?php
namespace Anax\View;

?>
<h1>Välkommen till "Allt Om Sengångare"!</h1>
<h2>Senaste frågorna:</h2>
<ul>
<?php foreach ($questions as $question) { ?>
            <li>
                <h4><a href="questions/view?question=<?= $question->id ?>"><?= $question->title ?></a><strong style="float: right;">Rating: <?= $question->rating ?></strong></h4>
                <p>Antal svar: <?= $question->answers ?></p>
            </li>
<?php } ?>
</ul>
<h2>Populäraste taggarna (frekvens):</h2>
<ul>
<?php foreach ($tags as $tag) { ?>
            <li>
                <p><a href="tags/view?tag=<?= $tag->tag ?>"><?= $tag->tag?></a> (<?= $tag->frequency?>)</p>
            </li>
<?php } ?>
</ul>
<h2>Top 3 användare (rep):</h2>
<ul>
<?php foreach ($users as $user) { ?>
            <li>
                <h4><a href="user/view?user=<?= $user->nick ?>"><?= $user->nick ?></a> (<?= $user->rep?>)</h4>
            </li>
<?php } ?>
</ul>