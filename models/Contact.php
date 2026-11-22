<?php
class Contact
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM contacts ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $name, string $email, string $phone): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO contacts (name, email, phone) VALUES (:name, :email, :phone)'
        );
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone]);
    }

    public function update(int $id, string $name, string $email, string $phone): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE contacts SET name = :name, email = :email, phone = :phone WHERE id = :id'
        );
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM contacts WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}