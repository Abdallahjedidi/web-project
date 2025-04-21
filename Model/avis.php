<?php
class Avis
{
    private $id;
    private $id_event;
    private $name;
    private $description;
    private $reported_at;

   
    public function __construct($id = null, $id_event = null, $name = null, $description = null, $reported_at = null)
    {
        $this->id = $id;
        $this->id_event = $id_event;
        $this->name = $name;
        $this->description = $description;
        $this->reported_at = $reported_at;
    }

   
    public function getId() { return $this->id; }
    public function getIdEvent() { return $this->id_event; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getReportedAt() { return $this->reported_at; }

    public function setId($id) { $this->id = $id; }
    public function setIdEvent($id_event) { $this->id_event = $id_event; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setReportedAt($reported_at) { $this->reported_at = $reported_at; }
}
?>
