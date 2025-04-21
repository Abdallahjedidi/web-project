<?php

class Reserver {
    private int $id;
    private int $activite_id;
    private int $utilisateur_id;
    private string $email;
    private string $numtlf;
    private ?string $date_inscription;

    public function __construct(
        int $activite_id,
        int $utilisateur_id,
        string $email,
        string $numtlf,
        ?string $date_inscription = null
    ) {
        $this->activite_id = $activite_id;
        $this->utilisateur_id = $utilisateur_id;
        $this->email = $email;
        $this->numtlf = $numtlf;
        $this->date_inscription = $date_inscription;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getActiviteId(): int {
        return $this->activite_id;
    }

    public function getUtilisateurId(): int {
        return $this->utilisateur_id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getNumtlf(): string {
        return $this->numtlf;
    }

    public function getDateInscription(): ?string {
        return $this->date_inscription;
    }

    // Setters
    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function setActiviteId(int $activite_id): self {
        $this->activite_id = $activite_id;
        return $this;
    }

    public function setUtilisateurId(int $utilisateur_id): self {
        $this->utilisateur_id = $utilisateur_id;
        return $this;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function setNumtlf(string $numtlf): self {
        $this->numtlf = $numtlf;
        return $this;
    }

    public function setDateInscription(?string $date_inscription): self {
        $this->date_inscription = $date_inscription;
        return $this;
    }
}

?>
