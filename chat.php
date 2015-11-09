<?php
require_once "maincore.php";
echo "<title>".$settings['sitename']." - Chat</title>";
echo "<frameset>
    <frame SRC='".BASEDIR."chat/flashchat.php'>
</frameset>";
echo "<noframes><center>You can also access the chatroom <a href='".BASEDIR."chat/flashchat.php'>here</a>.</center>";
?>
