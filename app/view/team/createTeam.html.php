<div class="container">
    <h1>Créer une équipe</h1>

    <form action="/exercises" accept-charset="UTF-8" method="post">
        <div class="form-group">
            <label for="team[title]">Nom de l'équipe</label>
            <input type="text" class="form-control" id="team[title]" aria-describedby="teamHelp" placeholder="Entrer le nom de l'équipe">
            <small id="teamHelp" class="form-text text-muted">Le nom de l'équipe doit être unique</small>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </div>
        <input type="submit" name="commit" value="Create Exercise" />
    </form>
</div>