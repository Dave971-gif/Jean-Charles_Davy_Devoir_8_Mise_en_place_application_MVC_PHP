<?php

use PHPUnit\Framework\TestCase;
use core\Database;

require_once __DIR__ . '/../core/Database.php'; 

class AgencyTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // INSERT TEST (CREATE)
    public function testInsertAgency(): void
    {
        $testName = 'Agence de Test ' . uniqid();

        $stmt = $this->pdo->prepare("INSERT INTO agencies (nom) VALUES (:nom)");
        $result = $stmt->execute(['nom' => $testName]);

        $this->assertTrue($result);

        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM agencies WHERE nom = :nom");
        $checkStmt->execute(['nom' => $testName]);
        $count = $checkStmt->fetchColumn();

        $this->assertEquals(1, $count);
    }

    // Read test: check if we can read an agency from the database
    public function testSelectAgency(): void
    {
        // Checking if at least one agency exists to read
        $stmt = $this->pdo->query("SELECT * FROM agencies LIMIT 1");
        $agency = $stmt->fetch();

        // Affiirm that we got an agency and it has the expected structure
        $this->assertNotEmpty($agency);
        $this->assertArrayHasKey('nom', $agency);
    }

    // MODIFICATION TEST (UPDATE)
    public function testUpdateAgency(): void
    {
        // Create a temporary agency to update
        $originalName = 'Agence Avant Update ' . uniqid();
        $this->pdo->prepare("INSERT INTO agencies (nom) VALUES (:nom)")->execute(['nom' => $originalName]);
        $id = $this->pdo->lastInsertId();

        // Simulate the update
        $newName = 'Agence Après Update ' . uniqid();
        $stmt = $this->pdo->prepare("UPDATE agencies SET nom = :nom WHERE id = :id");
        $result = $stmt->execute(['nom' => $newName, 'id' => $id]);

        // Assertions
        $this->assertTrue($result);

        // Check if the update was successful
        $checkStmt = $this->pdo->prepare("SELECT nom FROM agencies WHERE id = :id");
        $checkStmt->execute(['id' => $id]);
        $updatedName = $checkStmt->fetchColumn();

        $this->assertEquals($newName, $updatedName);
    }

    // DELETION TEST (DELETE)
    public function testDeleteAgency(): void
    {
        // Create a temporary agency to delete
        $testName = 'Agence A Supprimer ' . uniqid();
        $this->pdo->prepare("INSERT INTO agencies (nom) VALUES (:nom)")->execute(['nom' => $testName]);
        $id = $this->pdo->lastInsertId();

        // Simulate the deletion
        $stmt = $this->pdo->prepare("DELETE FROM agencies WHERE id = :id");
        $result = $stmt->execute(['id' => $id]);

        // Assertions
        $this->assertTrue($result);

        // Checking that the agency no longer exists
        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM agencies WHERE id = :id");
        $checkStmt->execute(['id' => $id]);
        $count = $checkStmt->fetchColumn();

        $this->assertEquals(0, $count);
    }
}