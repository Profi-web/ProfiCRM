<?php

class loginError
{
    public $notification = false;

    public function showError()
    {
        if ($this->notification) {
            echo "<div class=\"alert alert-warning alert-dismissibl show\" role=\"alert\" id=\"alert\" style='display:block'>
     Je sessie is verlopen, log aub opnieuw in
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
    </button>
</div>";
        }
    }
    public function check(){
        if (isset($_SESSION['notification'])) {
            session_unset();
            $this->notification = true;
        }
    }
}