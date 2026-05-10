<?php include 'header.php'; ?>
    <main>
        <?php if (isset($role) && $role === 'admin'): ?>
            <h2>Tableau de bord Administrateur</h2>
            
            <h3>Liste des Utilisateurs</h3>
            <ul>
                <?php if (isset($users) && !empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <li>
                            <?php echo $user['nom']; ?> ||
                            <?php echo $user['prenom']; ?> ||
                            <?php echo $user['contact']; ?> ||
                            <?php echo $user['email']; ?> ||
                            <?php echo $user['role']; ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <h3>Gestion des Agences</h3>
            <a href="create_agence.php">Créer une nouvelle agence</a>
            <ul>
                <?php if (isset($agences) && !empty($agences)): ?>
                    <?php foreach ($agences as $agence): ?>
                        <li>
                            <?php echo $agence['nom']; ?> - 
                            <a href="edit_agence.php?id=<?php echo $agence['id']; ?>">Modifier</a> 
                            <a href="delete_agence.php?id=<?php echo $agence['id']; ?>">Supprimer</a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <h3>Gestion des Trajets</h3>
            <ul>
                <?php if (isset($trajets) && !empty($trajets)): ?>
                    <?php foreach ($trajets as $trajet): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Agence de départ</th>
                                    <th>Date de départ</th>
                                    <th>Agence d'arrivée</th>
                                    <th>Date d'arrivée</th>
                                    <th>Places disponibles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $trajet['depart']; ?> </td>
                                    <td><?php echo $trajet['depart_date']; ?> </td>
                                    <td><?php echo $trajet['destination']; ?> </td>
                                    <td><?php echo $trajet['destination_date']; ?> </td>
                                    <td><?php echo $trajet['places']; ?> </td>
                                <td><a href="delete_trajet.php?id=<?php echo $trajet['id']; ?>">Supprimer le trajet</a></td>
                            </tr>
                        </table>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        <?php elseif (isset($role) && $role === 'user'): ?>
            <h2>Bienvenue sur votre tableau de bord</h2>
            <p>Voici les trajets disponibles pour vous :</p>
            <table>
                <thead>
                    <tr>
                        <th>Agence de départ</th>
                        <th>Date de départ</th>
                        <th>Agence d'arrivée</th>
                        <th>Date d'arrivée</th>
                        <th>Places disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($trajets) && !empty($trajets)): ?>
                        <?php foreach ($trajets as $trajet): ?>
                            <tr>
                                <td><?php echo $trajet['depart']; ?></td>
                                <td><?php echo $trajet['depart_date']; ?></td>
                                <td><?php echo $trajet['destination']; ?></td>
                                <td><?php echo $trajet['destination_date']; ?></td>
                                <td><?php echo $trajet['places']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Aucun trajet disponible pour le moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php else : ?>
            <h2>Bienvenue sur le tableau de bord de Touche pas mon Klaxon</h2>
            <p>Voici la liste des trajets disponibles :</p>
            <table>
                <caption>Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</caption>
                
                <thead>
                    <tr>
                        <th>Agence de départ</th>
                        <th>Date de départ</th>
                        <th>Agence d'arrivée</th>
                        <th>Date d'arrivée</th>
                        <th>Places disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($trajets) && !empty($trajets)): ?>
                        <?php foreach ($trajets as $trajet): ?>
                            <tr>
                                <td><?php echo $trajet['depart']; ?></td>
                                <td><?php echo $trajet['depart_date']; ?></td>
                                <td><?php echo $trajet['destination']; ?></td>
                                <td><?php echo $trajet['destination_date']; ?></td>
                                <td><?php echo $trajet['places']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Aucun trajet enregistré pour le moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

<?php include 'footer.php'; ?>