<?php include 'header.php'; ?>
    <main>
        <!-- ---------- ADMIN ---------- --> 
         
        <?php if (isset($role) && $role === 'admin'): ?> 
            <h2>Tableau de bord Administrateur</h2>
            
            <h3 id="utilisateurs">Liste des Utilisateurs</h3>
            <ul>
                <?php if (isset($users) && !empty($users)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Contact</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['nom']; ?></td>
                                    <td><?php echo $user['prenom']; ?></td>
                                    <td><?php echo $user['contact']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </ul>

            <h3 id="agences">Gestion des Agences</h3>
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
            
            <h3 id="trajets">Gestion des Trajets</h3>
            <ul>
                <?php if (isset($trajets) && !empty($trajets)): ?>
                    <table>
                        <thead>
                            <?php foreach ($trajets as $trajet): ?>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </ul>

            <!-- ---------- USER ----------- -->
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
                        <th>Actions</th>
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
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalTrajet<?= $trajet['id'] ?>">
                                        <i class="bi bi-eye"></i> 
                                    </a>

                                    <?php 
                                    // Verifying if the user is the owner of the journey 
                                    if ((int)$_SESSION['user_id'] === (int)$trajet['user_id']): 
                                    ?>
                                        <a href="templates/journey.php?id=<?= $trajet['id'] ?>" class="ms-2 text-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="templates/delete_journey.php?id=<?= $trajet['id'] ?>" class="ms-2 text-danger" 
                                        onclick="return confirm('Supprimer ce trajet ?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalTrajet<?= $trajet['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Détails du trajet</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Auteur :</strong> <?= $trajet['prenom'] . ' ' . $trajet['nom'] ?></p>
                                            <p><strong>Téléphone :</strong> <?= $trajet['contact'] ?></p>
                                            <p><strong>Email :</strong> <?= $trajet['email'] ?></p>
                                            <hr>
                                            <p><strong>Nombre total de places :</strong> <?= $trajet['places'] ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Aucun trajet disponible pour le moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- ------- GUEST ----------- -->
             
        <?php else : ?>
            <h2>Bienvenue sur le tableau de bord de Touche pas mon Klaxon</h2>
            <h3>Voici la liste des trajets disponibles :</h3>

            <p>Pour obtenir plus d'informations sur un trajet, veuillez vous connecter.</p>
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
                        <tr><td colspan="5">Aucun trajet enregistré pour le moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

<?php include 'footer.php'; ?>