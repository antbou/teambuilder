<div class="container">
    <h2>Liste des modo</h2>
    <ul>
        <?php foreach ($modo as $member) : ?>
            <li>
                <?= $member->name; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>