<div class="container">

    <b> <?= $team->name; ?></b>
    <ul>
        <?php foreach ($team->members() as $member) : ?>
            <li>
                <?= (!isset($team->captain()->name)) ?  $member->name : (($team->captain()->id === $member->id) ? "<b> $member->name </b>" : $member->name) ?>
            </li>
        <?php endforeach ?>
    </ul>
</div>