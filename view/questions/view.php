<?php
namespace Anax\View;

if ($user == $question->author) :
        $vote = "disabled";
        $acceptBtn = "";
else :
            $vote = "";
            $acceptBtn = "disabled";
endif;
if ($question->solved == 1) :
        $acceptBtn = "disabled";
endif;
?>
<h1>Frågan ställd utav: <strong><a href="<?= url("user/view?user=")?><?= $question->author ?>"><?= $question->author ?></a></strong></h1>
<ul>
<h2><?= $question->title ?><strong style="float: right;">
    <form method="post" action="<?= url("questions/vote") ?>"><button type="submit" value="up" name="action" <?= $vote ?>>&uarr;</button>
    <input type="hidden" value="<?= $question->id ?>" name="id">
    <input type="hidden" value="<?= $question->id ?>" name="qid">
    <input type="hidden" value="<?= $question->author ?>" name="author">
    <input type="hidden" value="questions" name="type">
    <?= $question->rating ?>
    <button type="submit" value="down" name="action" <?= $vote ?>> &darr;</button></form></strong> </h2>
<p><?= $question->content->text ?></p>
<br>
</ul>
<form method="post" action="<?= url("questions/answer") ?>">
    <label for="content">Svara:</label>
    <textarea required name="content" cols="25" rows="7"></textarea>
    <input type="hidden" value="<?= $question->id ?>" name="id">
    <button type="submit">Skicka</button>
    </form>
<h2 id="svar">Svar: <small style="float: right;display: flex;">Sortera på:

<?php if ($order == "date") :
        $date = "disabled";
else :
    $date = "";
endif; ?>
<form action="<?= url("questions/view#svar")?> " >
<input type="hidden" value="<?= $question->id ?>" name="question">
<input type="hidden" value="date" name="order">
<button <?= $date ?> type="submit">Datum</button></form>
<?php if ($order == "rating") :
    $rank = "disabled";
else :
    $rank = "";
endif; ?>
<form action="<?= url("questions/view#svar")?> " >
<input type="hidden" value="<?= $question->id ?>" name="question">
<input type="hidden" value="rating" name="order">
<button <?= $rank ?> type="submit">Rank</button></form></small></h2>
<ul>
<?php foreach ($answers as $answer) { ?>
    <?php if ($user == $answer->author) :
        $voteA = "disabled";
    else :
        $voteA = "";
    endif; ?>

    <?php  if ($answer->accepted == 1) :
        $accepted = "&#9989;";
    else :
        $accepted = "";
    endif; ?>
    <li>
        <h3 id="a<?= $answer->id ?>"><?= $accepted ?>Skrivet av: <a href="<?= url("user/view?user=")?><?= $answer->author ?>"><?= $answer->author ?></a>, <small><i><?= $answer->date ?></i></small>
        <small style="float: right;">
        <form method="post" action="<?= url("questions/vote") ?>"><button type="submit" value="up" name="action" <?= $voteA ?>>&uarr;</button>
        <input type="hidden" value="<?= $answer->id ?>" name="id">
        <input type="hidden" value="<?= $answer->author ?>" name="author">
        <input type="hidden" value="<?= $question->id ?>" name="qid">
        <input type="hidden" value="answers" name="type">
        <?= $answer->rating ?>
        <button type="submit" value="down" name="action" <?= $voteA ?>> &darr;</button></form></small></h3>
        <p><?= $answer->content->text ?></p>
        <form action="accept" method="post"><button <?= $acceptBtn ?>>Acceptera svar</button>
        <input type="hidden" value="<?= $answer->id ?>" name="aid">
        <input type="hidden" value="<?= $question->id ?>" name="qid">
    </form>
    </li>
    <ul>
    <?php foreach ($comments as $comment) { ?>
        <?php if ($comment->answer == $answer->id) : ?>
            <?php if ($user == $comment->author) :
                $voteC = "disabled";
            else :
                $voteC = "";
            endif; ?>
            <li>
            <h4 id="c<?= $comment->id ?>">Kommentar av: <a href="user/view?user=<?= $comment->author ?>" ><?= $comment->author ?></a>
            <small style="float: right;">
            <form method="post" action="<?= url("questions/vote") ?>"><button type="submit" value="up" name="action" <?= $voteC ?>>&uarr;</button>
            <input type="hidden" value="<?= $comment->id ?>" name="id">
            <input type="hidden" value="<?= $question->id ?>" name="qid">
            <input type="hidden" value="<?= $comment->author ?>" name="author">
            <input type="hidden" value="comments" name="type">
            <?= $comment->rating ?>
            <button type="submit" value="down" name="action" <?= $voteC ?>> &darr;</button></form></small></h4>
            <p><?= $comment->content->text ?></p>
            </li>
        <?php endif; ?>
    <?php } ?>
        </ul>
    <form method="post" action="<?= url("questions/comment") ?>">
        <label for="content">Kommentera:</label>
        <textarea required name="content" cols="25" rows="7"></textarea>
        <input type="hidden" value="<?= $question->id ?>" name="question">
        <input type="hidden" value="<?= $answer->id ?>" name="id">
        <button type="submit">Skicka</button>
    </form>
<?php } ?>
</ul>
<?php if (count($answers) == 0) : ?>
    <p>Inga svar på denna fråga ännu..</p>
<?php endif; ?>
<a href="<?= url("questions") ?>">Se alla frågor</a>