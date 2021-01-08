<?php
namespace Anax\View;

?>
<h1><img src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?d=robohash" alt="robot"><?= $user->nick ?></h1>
<p>Biografi: <?= $user->bio ?></p>
<p>Rep: <?= $user->rep ?></p>
<p>Röstat antal gånger:<?= $user->votes ?></p>
<h2>Ställda frågor:</h2>
<ul>
<?php foreach ($questions as $question) { ?>
            <li>
                <h4><a href="<?= url("questions/view?question=")?><?= $question->id ?>"><?= $question->title ?></a></h4>
            </li>
<?php } ?>
</ul>
<h2>Svar lämnade:</h2>
<ul>
<?php foreach ($answers as $answer) { ?>
            <li>
                <h4><a href="<?= url("questions/view?question=")?><?= $answer->question ?>#a<?= $answer->id ?>"><?= $answer->content ?></a></h4>
            </li>
<?php } ?>
</ul>
<h2>Kommentarer lämnade:</h2>
<ul>
<?php foreach ($comments as $comment) { ?>
            <li>
                <h4><a href="<?= url("questions/view?question=")?><?= $comment->question ?>#c<?= $comment->id ?>"><?= $comment->content ?></a></h4>
            </li>
<?php } ?>
</ul>
