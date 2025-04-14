<?php
class User
{
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $password;
    private string $role;

    public function __construct($id = null, $nom = '', $prenom = '', $email = '', $password = '', $role = 'user')
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role ?? 'user';
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRole(): string { return $this->role; }

    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setRole(string $role): void {
        if (in_array($role, ['admin', 'user'])) {
            $this->role = $role;
        } else {
            throw new InvalidArgumentException("Rôle invalide");
        }
    }
}
?>
