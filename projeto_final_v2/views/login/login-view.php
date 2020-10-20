<? verifyPath(); ?>

<div class="wrap">
<?
if($this->logged_in)
    echo '<p  class="alert">Sessão ativa</p>';
?>

<form method="post">
    <table class="from-table">
        <tr>
            <td>User</td>
            <td><input name="userdata[login]"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="userdata[password]"></td>
        </tr>
        <?
        if($this->login_error)
            echo '<tr><td colspan="2" class="error">'.$this->login_error.'</td></tr>';
        ?>
        <tr>
            <td>
            <input type="submit" value="enter" colspan="2">
            </td>
        </tr>
    </table>
</form>