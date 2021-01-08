<?php
namespace Anax\View;

?>
<h1>Profil</h1>
<img src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?d=robohash" alt="robot">
<p>Nick: <?= $user->nick ?></p>
<p>Epost: <?= $user->email ?></p>
<p>Rep: <?= $user->rep ?></p>
<p>Röstat antal gånger:<?= $user->votes ?></p>
<p>Om mig: <?= $user->bio ?></p>

<a href="<?= url("user/edit") ?>">Redigera profil</a>
<a href="<?= url("user/logout") ?>">Logga ut</a>
