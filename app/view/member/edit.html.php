<div class="container">
    <b> <?= $member->name; ?></b>
    <?php if (!$isModo) : ?>
        <form action="?controller=member&task=edit&id=<?= $member->id ?>" accept-charset="UTF-8" method="post">
            <p class="text-success">
                <?= (is_null($success)) ? '' : $success; ?>
            </p>

            <div class="form-group">
                <label for="member[name]">Nom de l'utilisateur</label>
                <input type="text" class="form-control <?= (isset($fields['name']->error)) ? 'is-invalid' : '' ?>" id="member[name]" name="member[name]" aria-describedby="validationTeamTitle" placeholder="Entrer le nom de l'équipe" value="<?= $member->name ?>">
                <div id="validationTeamTitle" class="invalid-feedback">
                    <?= (isset($fields['name']->error)) ? $fields['name']->error : '' ?>
                </div>
                <small id="teamHelp" class="form-text text-muted">Le nom d'utilisateur doit être unique</small>
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

            </div>
            <input type="submit" name="commit" value="Edit user" />
        </form>
    <?php else : ?>
        <form action="?controller=member&task=edit&id=<?= $member->id ?>" accept-charset="UTF-8" method="post">
            <p class="text-success">
                <?= (is_null($success)) ? '' : $success; ?>
            </p>

            <div class="form-group">

                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

            </div>
            <input type="submit" name="commit" value="Edit user" />
        </form>
    <?php endif; ?>
</div>