<?php
namespace Anax\View;

?>
<h1>Användare</h1>
<ul>
<?php foreach ($users as $user) { ?>
            <li>
                <h4><img src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?d=robohash&s=40" alt="robot"> <a href="view?user=<?= $user->nick ?>"><?= $user->nick ?></h4>
            </li>
<?php } ?>
</ul>