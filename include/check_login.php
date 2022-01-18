<?php
if (isset($_COOKIE['login'])) { ?>
    <td class="iat" style="display: none;">
        <label for="login_id">Ваш login:</label>
        <input id="login_id" value="<?= $_COOKIE['login']; ?>" size="30" name="login">
    </td>
<?php } else { ?>
    <td class="iat">
        <label for="login_id">Ваш login:</label>
        <input id="login_id" value="" size="30" name="login">
    </td>
    </tr>
<?php }
