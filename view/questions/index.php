<?php
namespace Anax\View;

?>
<h1>Frågor</h1>
<p><a href="<?= url("questions/ask") ?>">Ställ en fråga!</a></p><h2>Alla frågor:</h2>
<ul>
<?php foreach ($questions as $question) { ?>
            <li>
                <h4><a href="questions/view?question=<?= $question->id ?>"><?= $question->title ?></a><strong style="float: right;">Rating: <?= $question->rating ?></strong></h4>
                <p>Antal svar: <?= $question->answers ?></p>
            </li>
<?php } ?>
</ul>