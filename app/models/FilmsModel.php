<?php
class Films
{
    private PDO $bdd;
    private PDOStatement $addFilm;
    private PDOStatement $delFilm;
    private PDOStatement $getFilm;
    private PDOStatement $getAllFilms;

    function __construct()
    {
        $this->bdd = new PDO("mysql:host=bdd;dbname=app_database", "root", "root");

        $this->addFilm = $this->bdd->prepare("INSERT INTO `Films`(nom, date_sortie, genre, auteur) VALUES (:nom, :date_sortie, :genre, :auteur)");

        $this->delFilm = $this->bdd->prepare("DELETE FROM `Films` WHERE `Films` .`id` = :id;");

        $this->getFilm = $this->bdd->prepare("SELECT * FROM `Films` WHERE `Films`.`id` = :id;");

        $this->getAllFilms = $this->bdd->prepare("SELECT * FROM `Films` LIMIT :limit");
    }

    public function add(string $nom, DateTime $date_sortie, string $genre, string $auteur): void
    {
        $this->addFilm->bindValue("nom", $nom);
        $this->addFilm->bindValue("date_sortie", $date_sortie);
        $this->addFilm->bindValue("genre", $genre);
        $this->addFilm->bindValue("auteur", $auteur);
        $this->addFilm->execute();
    }

    public function del(int $id): void
    {
        $this->delFilm->bindValue("id", $id, PDO::PARAM_INT);
        $this->delFilm->execute();
    }
    public function get($id): FilmsEntity | NULL
    {
        $this->getFilm->bindValue("id", $id, PDO::PARAM_INT);
        $this->getFilm->execute();
        $rawFilm = $this->getFilm->fetch();

        // Si le produit n'existe pas, je renvoie NULL
        if (!$rawFilm) {
            return NULL;
        }
        return new FilmsEntity(
            $rawFilm["nom"],
            new DateTime($rawFilm["date_sortie"]),
            $rawFilm["genre"],
            $rawFilm["auteur"]
        );
    }

    public function getAll(int $limit = 50): array
    {
        $this->getAllFilms->bindValue("limit", $limit, PDO::PARAM_INT);
        $this->getAllFilms->execute();
        $rawFilms = $this->getAllFilms->fetchAll();

        $FilmsEntity = [];
        foreach ($rawFilms as $rawFilm) {
            $FilmsEntity[] = new FilmsEntity(
                $rawFilm["nom"],
                new DateTime($rawFilm["date_sortie"]),
                $rawFilm["genre"],
                $rawFilm["auteur"],
                $rawFilm["id"]
            );
        }
        return $FilmsEntity;
    }
}

class FilmsEntity
{
    private int $id;
    private string $nom;
    private DateTime $date_sortie;
    private string $genre;
    private string $auteur;


    private const NAME_MIN_LEGTH = 3;

    function __construct(string $nom, DateTime $date_sortie, string $genre, string $auteur, int $id = NULL)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->date_sortie = $date_sortie;
        $this->genre = $genre;
        $this->auteur = $auteur;
    }

    public function setNom(string $nom)
    {
        if (strlen($nom) < $this::NAME_MIN_LEGTH) {
            throw new Error("name is too short, minimum length is " . $this::NAME_MIN_LEGTH);
        }
        $this->nom = $nom;
    }
    public function setDateSortie(DateTime $date_sortie)
    {
        $this->date_sortie = $date_sortie;
    }
    public function setGenre(string $genre)
    {
        $this->genre = $genre;
    }
    public function setAuteur(string $auteur)
    {
        $this->auteur = $auteur;
    }

    public function getNom()
    {
        return $this->nom;
    }
    public function getGenre()
    {
        return $this->genre;
    }
    public function getAuteur()
    {
        return $this->auteur;
    }
    public function getDateSortie()
    {
        return $this->date_sortie;
    }
    public function getId(): int
    {
        return $this->id;
    }

    
}
