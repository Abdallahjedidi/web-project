<?php

class Espace {
    private int $id;
    private string $nom;
    private string $description;
    private string $adresse;
    private string $ville;
    private float $superficie;
    private string $statut;
    private ?string $image; 

    public function __construct(
        string $nom,
        string $description,
        string $adresse,
        string $ville,
        float $superficie,
        string $statut,
        ?string $image = null
    ) {
        $this->nom = $nom;
        $this->description = $description;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->superficie = $superficie;
        $this->statut = $statut;
        $this->image = $image;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function getVille(): string {
        return $this->ville;
    }

    public function getSuperficie(): float {
        return $this->superficie;
    }

    public function getStatut(): string {
        return $this->statut;
    }

public function getImage(): string
{
    return $this->image ?? '';
}


    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;
        return $this;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function setAdresse(string $adresse): self {
        $this->adresse = $adresse;
        return $this;
    }

    public function setVille(string $ville): self {
        $this->ville = $ville;
        return $this;
    }

    public function setSuperficie(float $superficie): self {
        $this->superficie = $superficie;
        return $this;
    }

    public function setStatut(string $statut): self {
        $this->statut = $statut;
        return $this;
    }

    public function setImage(string $image): self {
        $this->image = $image;
        return $this;
    }
}

?>
