<?php

class Activite {
    private int $id;
    private string $titre;
    private ?string $description;
    private ?string $date_activite;
    private ?string $heure;
    private ?string $type_activite;
    private ?int $espace_id;

    public function __construct(
        string $titre,
        ?string $description = null,
        ?string $date_activite = null,
        ?string $heure = null,
        ?string $type_activite = null,
        ?int $espace_id = null
    ) {
        $this->titre = $titre;
        $this->description = $description;
        $this->date_activite = $date_activite;
        $this->heure = $heure;
        $this->type_activite = $type_activite;
        $this->espace_id = $espace_id;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getDateActivite(): ?string {
        return $this->date_activite;
    }

    public function getHeure(): ?string {
        return $this->heure;
    }

    public function getTypeActivite(): ?string {
        return $this->type_activite;
    }

    public function getEspaceId(): ?int {
        return $this->espace_id;
    }

    // Setters
    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function setTitre(string $titre): self {
        $this->titre = $titre;
        return $this;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function setDateActivite(?string $date_activite): self {
        $this->date_activite = $date_activite;
        return $this;
    }

    public function setHeure(?string $heure): self {
        $this->heure = $heure;
        return $this;
    }

    public function setTypeActivite(?string $type_activite): self {
        $this->type_activite = $type_activite;
        return $this;
    }

    public function setEspaceId(?int $espace_id): self {
        $this->espace_id = $espace_id;
        return $this;
    }
}

?>
