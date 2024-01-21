<div>
    <table class="table table-striped">
                <caption>Liste des Utilisateurs</caption>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['pseudo'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
    </div>