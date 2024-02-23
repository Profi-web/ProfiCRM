<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
$table = new Table($pagination, 'users', 'bedrijven');
$users = new Users('', $table->limit);
$logged = new User();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/

foreach ($users->findAll($table->startfrom, $table->limit) as $user) {
    if ($user['picture']) {
        $image = $user['picture'];
    } else {
        $image = 'placeholder.png';
    }
    if ($user['id'] == $_SESSION['userid']) {
        $class = 'current';
    } else {
        $class = '';
    }
    if ($logged->data['role'] != 1 && $user['visible'] == 1) {
        ?>
        <tr id="<?php echo $user['id'] ?>" class="user_tablee <?php echo $class; ?>">
        <td valign="middle">
            <?php echo $user['name'] ?>
        </td>
        <td>
            <img src="/uploads/picture/<?php echo $image; ?>" class="rounded-circle" width="35px" height="35px"
                 style="object-fit: cover"/>
        </td>
        <td valign="middle">
            <?php echo $user['email'] ?>
        </td>
        <td valign="middle">
            <?php echo $users->getRole($user['role']) ?>
        </td>
        <th scope="row" valign="middle">
            <?php echo $user['id'] ?>
        </th>
        <?php
    }
    if ($logged->data['role'] == 1) { ?>
        <tr id="<?php echo $user['id'] ?>" class="user_tablee <?php echo $class; ?>">
        <td valign="middle">
            <?php echo $user['name'] ?>
        </td>
        <td>
            <img src="/uploads/picture/<?php echo $image; ?>" class="rounded-circle" width="35px" height="35px"
                 style="object-fit: cover"/>
        </td>

        <td valign="middle">
            <?php echo $user['email'] ?>
        </td>
        <td valign="middle">
            <?php echo $users->getRole($user['role']) ?>
        </td>
        <td valign="middle">
            <?php
            if ($user['visible'] == 1) {
                ?>
                <form action="/controllers/tables/user/hide.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                    <button type="submit" class="custombuttonshown"><i
                                class="fas fa-check-circle text-success"></i></button>
                </form>
                <?php
            } else {
                ?>
                <form action="/controllers/tables/user/show.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                    <button type="submit" class="custombuttonhidden"><i
                                class="fas fa-times-circle text-danger"></i>
                    </button>
                </form>
                <?php
            } ?>
        </td>
        <th scope="row" valign="middle">
            <?php echo $user['id'] ?>
        </th>
        <?php
    }
    ?>
    </tr>
    <?php
}
?>
<script>
    $('tbody tr').on('click', function () {
        window.location.href = '/profiel?id=' + $(this).attr('id');
    });
</script>
