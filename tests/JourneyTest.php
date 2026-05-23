<?php

use PHPUnit\Framework\TestCase;
use core\Database;

require_once __DIR__ . '/../core/Database.php'; 

class JourneyTest extends TestCase
{
    private $pdo;

    /**
     * This method is executed BEFORE each test.
     */
    protected function setUp(): void
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    /**
     * Test inserting a new journey into the database.
     */
    public function testInsertJourney(): void
    {
        $departTest = 'Paris';
        $destinationTest = 'Toulouse';

        // Simulate insertion using the correct column names (depart, destination)
        $stmt = $this->pdo->prepare("INSERT INTO journey (depart, destination) VALUES (:depart, :destination)");
        $result = $stmt->execute([
            'depart' => $departTest,
            'destination' => $destinationTest
        ]);

        // Assertion 1: Check if the query executed successfully
        $this->assertTrue($result);

        // Assertion 2: Check if the journey actually exists in the database
        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM journey WHERE depart = :depart AND destination = :destination");
        $checkStmt->execute(['depart' => $departTest, 'destination' => $destinationTest]);
        
        $this->assertEquals(1, $checkStmt->fetchColumn());
    }

    /**
     * Test reading journey data (SELECT).
     */
    public function testSelectJourney(): void
    {
        // First, let's insert a temporary journey to make sure the table isn't empty
        $this->pdo->prepare("INSERT INTO journey (depart, destination) VALUES ('Temporary', 'Test')")->execute();

        // Fetch the record to verify data readability
        $stmt = $this->pdo->query("SELECT * FROM journey LIMIT 1");
        $journey = $stmt->fetch();

        // Assertion: Ensure data is successfully retrieved as an array, not false
        $this->assertIsArray($journey);
        $this->assertNotEmpty($journey);
    }

    /**
     * Test updating an existing journey (UPDATE).
     */
    public function testUpdateJourney(): void
    {
        // Create a temporary journey to update
        $this->pdo->prepare("INSERT INTO journey (depart, destination) VALUES ('Lyon', 'Marseille')")->execute();
        $id = $this->pdo->lastInsertId();

        // Simulate the modification process using correct columns
        $stmt = $this->pdo->prepare("UPDATE journey SET destination = :destination WHERE id = :id");
        $result = $stmt->execute(['destination' => 'Nice', 'id' => $id]);

        // Assertion 1: Check if the update query executed successfully
        $this->assertTrue($result);

        // Assertion 2: Verify that the data was correctly updated in the database
        $checkStmt = $this->pdo->prepare("SELECT destination FROM journey WHERE id = :id");
        $checkStmt->execute(['id' => $id]);
        
        $this->assertEquals('Nice', $checkStmt->fetchColumn());
    }

    /**
     * Test removing a journey (DELETE).
     */
    public function testDeleteJourney(): void
    {
        // Create a temporary journey to delete
        $this->pdo->prepare("INSERT INTO journey (depart, destination) VALUES ('Bordeaux', 'Nantes')")->execute();
        $id = $this->pdo->lastInsertId();

        // Simulate deletion
        $stmt = $this->pdo->prepare("DELETE FROM journey WHERE id = :id");
        $result = $stmt->execute(['id' => $id]);

        // Assertion 1: Check if the delete query executed successfully
        $this->assertTrue($result);

        // Assertion 2: Verify that the record no longer exists
        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM journey WHERE id = :id");
        $checkStmt->execute(['id' => $id]);
        
        $this->assertEquals(0, $checkStmt->fetchColumn());
    }
}