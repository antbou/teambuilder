<div class="container">
    <?php foreach ($members as $member) : ?>
        <b> <?= $member->name; ?></b>
        <?php
        $teams = $member->teams();
        foreach ($teams as $team) :
        ?>
            <i><?= $team->name; ?></i>
            <?= (end($teams) !== $team) ? ', ' : '' ?>
        <?php endforeach; ?>
        <br>
    <?php endforeach; ?>
</div>