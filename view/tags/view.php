<?php
namespace Anax\View;

?>

<h1>Frågor taggade med '<?= $tag ?>'</h1>
<ul>
<?php foreach ($questions as $question) { ?>
            <li>
                <h4><a href="<?= url("questions/view?question=")?> <?= $question->id ?>"><?= $question->title ?></a><strong style="float: right;">Rating: <?= $question->rating ?></strong></h4>
                <p>Antal svar: <?= $question->answers ?></p>
            </li>
<?php } ?>
</ul>