<?php
require_once './config/Database.php';

class User extends Database {

    private $tabel = "users";

    // CREATE
    public function tambah($nama, $email, $password) {
        $query = "INSERT INTO $this->tabel (nama, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $nama, $email, $password);
        return $stmt->execute();
    }

    // READ ALL
    public function bacaSemua() {
        $query = "SELECT * FROM $this->tabel ORDER BY id ASC";
        return $this->conn->query($query);
    }

    // READ BY ID
    public function bacaOlehId($id) {
        $query = "SELECT * FROM $this->tabel WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE
    public function ubah($id, $nama, $email) {
        $query = "UPDATE $this->tabel SET nama = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $nama, $email, $id);
        return $stmt->execute();
    }

    // DELETE
    public function hapus($id) {
        $query = "DELETE FROM $this->tabel WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>