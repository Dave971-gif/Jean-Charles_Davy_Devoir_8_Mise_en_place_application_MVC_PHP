<?php include 'header.php'; ?>
    <main>
        <!-- Formation du Tableau de bord -->
        <table>
            <caption>Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</caption>
            
            <thead>
                <tr>
                    <th>Départ</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Places</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($trajets) && !empty($trajets)): ?>
                    <?php foreach ($trajets as $trajet): ?>
                        <tr>
                            <td><?php echo $trajet['depart']; ?></td>
                            <td><?php echo $trajet['depart_date']; ?></td>
                            <td><?php echo $trajet['depart_heure']; ?></td>
                            <td><?php echo $trajet['destination']; ?></td>
                            <td><?php echo $trajet['destination_date']; ?></td>
                            <td><?php echo $trajet['destination_heure']; ?></td>
                            <td><?php echo $trajet['places']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Aucun trajet disponible pour le moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

<?php include 'footer.php'; ?>