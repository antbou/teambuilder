<div class="container">
    <ul>
        <b> <?= $team->name; ?></b>
    </ul>
    <?php foreach ($team->members() as $member) : ?>
        <li><?= $member->name ?></li>
    <?php endforeach ?>
</div>