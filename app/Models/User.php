<?php

namespace App\Models;
use App\Core\BaseModel;
use DateTime;
abstract class User extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    const ROLE_FORMATEUR = 'formateur';
    const ROLE_ETUDIANT = 'etudiant';

    protected ?int $id = null;
    protected string $username;
    protected string $email;
    protected string $passwordHash;
    protected string $role;
    protected ?DateTime $createdAt = null;

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        return $result ?: null;
    }
    public function createUser(array $data): int
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
            unset($data['password']);
        }

        if (!isset($data['role'])) {
            $data['role'] = self::ROLE_ETUDIANT;
        }

        return $this->create($data);
    }

    public function updatePassword(int $id, string $newPassword): bool
    {
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->update($id, ['password_hash' => $passwordHash]);
    }

    public function verifyPassword(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }
    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return null;
        }

        if ($this->verifyPassword($password, $user['password_hash'])) {
            unset($user['password_hash']);
            return $user;
        }

        return null;
    }
}