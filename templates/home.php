<?php include 'header.php'; ?>
    <main>
        <!-- ---------- ADMIN ---------- --> 
         
        <?php if (isset($role) && $role === 'admin'): ?> 
            <h2>Tableau de bord Administrateur</h2>
            
            <h3 id="utilisateurs">Liste des Utilisateurs</h3>

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

            <h3 id="agences">Gestion des Agences</h3>

            <a href="./agence">Créer une nouvelle agence</a>
            <ul>
                <?php if (isset($agences) && !empty($agences)): ?>
                    <?php foreach ($agences as $agence): ?>
                        <li>
                            <?php echo $agence['nom']; ?> - 
                            <a href="./agence/edit?id=<?php echo $agence['id']; ?>" class="ms-2 text-warning"><i class="bi bi-pencil-square"></i></a> 
                            <a href="./agence/delete?id=<?php echo $agence['id']; ?>" class="ms-2 text-danger"><i class="bi bi-trash"></i></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            
            <h3 id="trajets">Gestion des Trajets</h3>

            <?php if (isset($admin_trajets) && !empty($admin_trajets)): ?>
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
                        <?php foreach ($admin_trajets as $trajet): ?>
                            <tr>
                                <td><?php echo $trajet['depart']; ?> </td>
                                <td><?= date('d/m/Y', strtotime($trajet['depart_date'])) ?></td>
                                <td><?php echo $trajet['destination']; ?> </td>
                                <td><?= date('d/m/Y', strtotime($trajet['destination_date'])) ?></td>
                                <td><?php echo $trajet['places']; ?> </td>
                                <td>
                                    <a href="./delete_journey?id=<?= $trajet['id'] ?>" class="ms-2 text-danger"
                                    onclick="return confirm('Supprimer ce trajet ?')">
                                            <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

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
                    <?php if (isset($user_trajets) && !empty($user_trajets)): ?>
                        <?php foreach ($user_trajets as $trajet): ?>
                            <tr>
                                <td><?php echo $trajet['depart']; ?></td>
                                <td><?= date('d/m/Y', strtotime($trajet['depart_date'])) ?></td>
                                <td><?php echo $trajet['destination']; ?></td>
                                <td><?= date('d/m/Y', strtotime($trajet['destination_date'])) ?></td>
                                <td><?php echo $trajet['places']; ?></td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalTrajet<?= $trajet['id'] ?>">
                                        <i class="bi bi-eye"></i> 
                                    </a>

                                    <?php 
                                    // Verifying if the user is the owner of the journey 
                                    if ((int)$_SESSION['user_id'] === (int)$trajet['user_id']): 
                                    ?>
                                        <a href="journey/<?= $trajet['id'] ?>/edit" class="ms-2 text-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="journey/<?= $trajet['id'] ?>/delete" class="ms-2 text-danger" 
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
                                            <?php if (!empty($trajet['user_id'])): ?>
                                                <p><strong>Auteur : </strong><?= htmlspecialchars($trajet['prenom'] . ' ' . $trajet['nom']) ?></p>
                                                <p><strong>Téléphone : </strong><a href="tel:<?= htmlspecialchars($trajet['contact']) ?>"><?= htmlspecialchars($trajet['contact']) ?></a></p>
                                                <p><strong>Email : </strong><a href="mailto:<?= htmlspecialchars($trajet['email']) ?>"><?= htmlspecialchars($trajet['email']) ?></a></p>
                                            <?php else: ?>
                                                <p><strong>Auteur : </strong>Inconnu</p>
                                            <?php endif; ?>
                                            
                                            <hr>
                                            <p><strong>Nombre total de places : </strong><?= htmlspecialchars($trajet['places']) ?></p>
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
                        <th>Places</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($guest_trajets) && !empty($guest_trajets)): ?>
                        <?php foreach ($guest_trajets as $trajet): ?>
                            <tr>
                                <td><?php echo $trajet['depart']; ?></td>
                                <td><?= date('d/m/Y', strtotime($trajet['depart_date'])) ?></td>
                                <td><?php echo $trajet['destination']; ?></td>
                                <td><?= date('d/m/Y', strtotime($trajet['destination_date'])) ?></td>
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