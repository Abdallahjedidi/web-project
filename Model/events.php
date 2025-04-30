<?php
class event {
    private $id;
    private $title;
    private $description;
    private $date;
    private $location;
    private $organizer_id;
    private $image;
    private $latitude;
    private $longitude;

    public function setid($id) {
        $this->id = $id;
    }

    public function settitle($title) {
        $this->title = $title;
    }

    public function setdescription($description) {
        $this->description = $description;
    }

    public function setdate($date) {
        $this->date = $date;
    }

    public function setlocation($location) {
        $this->location = $location;
    }

    public function setorganizer_id($organizer_id) {
        $this->organizer_id = $organizer_id;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function getid() {
        return $this->id;
    }

    public function gettitle() {
        return $this->title;
    }

    public function getdescription() {
        return $this->description;
    }

    public function getdate() {
        return $this->date;
    }

    public function getlocation() {
        return $this->location;
    }

    public function getorganizer_id() {
        return $this->organizer_id;
    }

    public function getImage() {
        return $this->image;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }
}
?>
