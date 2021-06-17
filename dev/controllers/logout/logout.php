<?php
setcookie("remember", "", time()-10, "/");
Session::delete('userid');
Session::destroy();
header('Location: /');