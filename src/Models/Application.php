<?php

namespace Models;

use PDO;
use PDOException;
use Exception;

class Application
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createApplication($data)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Applications (user_id, offer_id, apply_cv, apply_coverletter, apply_message, apply_status)
                VALUES (:user_id, :offer_id, :apply_cv, :apply_coverletter, :apply_message, :apply_status)
            ");
            $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':offer_id', $data['offer_id'], PDO::PARAM_INT);
            $stmt->bindValue(':apply_cv', $data['apply_cv']);
            $stmt->bindValue(':apply_coverletter', $data['apply_coverletter']);
            $stmt->bindValue(':apply_message', $data['apply_message']);
            $stmt->bindValue(':apply_status', $data['apply_status']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de la candidature : " . $e->getMessage());
        }
    }

    public function getApplicationsByUserId($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Applications WHERE user_id = :user_id");
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des candidatures : " . $e->getMessage());
        }
    }

    public function getApplicationById($application_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Applications WHERE application_id = :application_id");
            $stmt->bindValue(':application_id', $application_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de la candidature : " . $e->getMessage());
        }
    }

    public function updateApplication($application_id, $data)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE Applications
                SET apply_cv = :apply_cv, apply_coverletter = :apply_coverletter, apply_message = :apply_message, apply_status = :apply_status
                WHERE application_id = :application_id
            ");
            $stmt->bindValue(':application_id', $application_id, PDO::PARAM_INT);
            $stmt->bindValue(':apply_cv', $data['apply_cv']);
            $stmt->bindValue(':apply_coverletter', $data['apply_coverletter']);
            $stmt->bindValue(':apply_message', $data['apply_message']);
            $stmt->bindValue(':apply_status', $data['apply_status']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de la candidature : " . $e->getMessage());
        }
    }

    public function deleteApplication($application_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Applications WHERE application_id = :application_id");
            $stmt->bindValue(':application_id', $application_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la candidature : " . $e->getMessage());
        }
    }
}