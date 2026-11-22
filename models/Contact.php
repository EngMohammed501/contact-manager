<?php
declare(strict_types=1);

class Contact
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id, name, email, phone, created_at FROM contacts ORDER BY id DESC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, email, phone, created_at FROM contacts WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        return $contact ?: null;
    }

    public function create(string $name, string $email, string $phone): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO contacts (name, email, phone) VALUES (:name, :email, :phone)'
        );
        return $stmt->execute([
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ]);
    }

    public function update(int $id, string $name, string $email, string $phone): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE contacts SET name = :name, email = :email, phone = :phone WHERE id = :id'
        );
        return $stmt->execute([
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM contacts WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}