<div class="container">
    <h1>Profil de l'utilisateur <?= $member->name; ?></h1>
    <ul>
        <li>Nom :<b> <?= $member->name; ?></b></li>
        <li>Rôle : <?= $member->getRole()->name; ?></li>
        <li>Status : <?= $member->getStatus()->name; ?></li>
    </ul>
</div>