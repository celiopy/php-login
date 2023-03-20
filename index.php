<?php
require_once ('./inc/class.Database.php');
require_once ('./inc/class.User.php');
require_once ('./functions.inc.php');

// Check if the user is already logged in
$user_id = User::is_logged_in();

// If the user is already logged in, redirect them to the home page
if ($user_id === false) {
  header('Location: login.php');
  exit();
}

$user = User($user_id);
$sessions = Sessions($user_id);
?>

Hello, <?= $user['name']; ?>! <a href="logout.php">Sair</a>
<br>
Suas infos:<br>
<table>
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Última sessão</ŧh>
    </tr>
    <tr>
        <td><?= $user['id']; ?></ŧd>
        <td><?= $user['name']; ?></ŧd>
        <td><?= $user['email']; ?></ŧd>
        <td>?</ŧd>
        <td><?= $user['last_session']; ?></ŧd>
    </tr>
</table>
<hr>
Suas sessões:<br>
<table>
    <tr>
        <th>?</th>
        <th>Id</th>
        <th>Token</th>
        <th>Criado em</th>
    </tr>
    <?php foreach ( $sessions as $session ): ?>
    <tr>
        <th><?= ( $session['active'] ? '✓' : 'x' ); ?>
        <td><?= $session['id']; ?></ŧd>
        <td><?= $session['token']; ?></ŧd>
        <td><?= $session['created_at']; ?></ŧd>
    </tr>
    <?php endforeach; ?>
</table>