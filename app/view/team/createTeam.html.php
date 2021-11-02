<div class="container">
    <h1>Créer une équipe</h1>

    <form action="/?controller=team&task=create" accept-charset="UTF-8" method="post">
        <div class="form-group">
            <label for="team[title]">Nom de l'équipe</label>
            <input type="text" class="form-control <?= (isset($fields['title']->error)) ? 'is-invalid' : '' ?>" id="team[title]" name="team[title]" aria-describedby="validationTeamTitle" placeholder="Entrer le nom de l'équipe">
            <div id="validationTeamTitle" class="invalid-feedback">
                <?= (isset($fields['title']->error)) ? $fields['title']->error : '' ?>
            </div>
            <small id="teamHelp" class="form-text text-muted">Le nom de l'équipe doit être unique</small>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

        </div>
        <input type="submit" name="commit" value="Create Exercise" />
    </form>
</div>