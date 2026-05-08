<?php include 'header.php'; ?>
    <main>
        <!-- Formation du Tableau de bord -->
        <table>
            <caption>Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</caption>
            
            <thead>
                <tr>
                    <th>Départ</th>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Places</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <h3>Test de récupération des agences :</h3>
        <ul>
            <?php if (isset($agences) && !empty($agences)): ?>
                <?php foreach ($agences as $agence): ?>
                    <li><?php echo $agence['nom']; ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </main>

<?php include 'footer.php'; ?>