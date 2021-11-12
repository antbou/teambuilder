<div class="container">
    <a href="?controller=member&task=edit&id=<?= $member->id ?>" class="btn btn-info" role="button">Edit profile</a>

    <h1>Profil de l'utilisateur <?= $member->name; ?></h1>
    <ul>
        <li><b>Prénom</b> : <?= $member->name; ?></li>
        <li>Rôle : <?= $member->getRole()->name; ?></li>
        <li>Status : <?= $member->getStatus()->name; ?></li>
    </ul>

    <div>
        <?php $teams = $member->teams(); ?>
        <h2><?= (empty($teams)) ? 'Membre de aucune équipe' : 'Liste'; ?></h2>
        <ul>


            <?php $teamsCaptain = $member->teamsCaptain();
            if (!empty($teamsCaptain)) : ?>
                <li>
                    Capitaine de :
                    <?php foreach ($teamsCaptain as $team) :
                    ?>
                        <i><?= $team->name; ?></i>
                        <?= (end($teamsCaptain) !== $team) ? ', ' : '' ?>
                    <?php endforeach; ?>
                </li>
            <?php endif; ?>

            <?php

            if (!empty($teams)) : ?>
                <li>
                    Membre de :

                    <?php $teamsCaptain = $member->teamsCaptain();
                    foreach ($teams as $team) :
                    ?>
                        <?php if (!in_array($team, $teamsCaptain)) : ?>
                            <i><?= $team->name; ?></i>
                            <?= (end($teams) !== $team) ? ', ' : '' ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
            <?php endif; ?>

        </ul>
    </div>


    <br>
</div>