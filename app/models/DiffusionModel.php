<?php
class Diffusion
{
    private PDO $bdd;
    private PDOStatement $addFilmDiffusion;
    private PDOStatement $delFilmDiffusion;
    private PDOStatement $getFilmDiffusion;
    private PDOStatement $getAllFilmsDiffusions;

    function __construct()
    {
        $this->bdd = new PDO("mysql:host=lamp-mysql;dbname=app_database", "root", "root");

        $this->addFilmDiffusion = $this->bdd->prepare("INSERT INTO `Diffusion`(film_id, date_diffusion) VALUES (:film_id, :date_diffusion)");

        $this->delFilmDiffusion = $this->bdd->prepare("DELETE FROM `Diffusion` WHERE `Diffusion` .`id` = :id;");

        $this->getFilmDiffusion = $this->bdd->prepare("SELECT * FROM `Diffusion` WHERE `Diffusion`.`id` = :id;");

        $this->getAllFilmsDiffusions = $this->bdd->prepare("SELECT * FROM `Diffusion` LIMIT :limit");
    }

    public function add(int $film_id, DateTime $date_diffusion): void
    {
        $this->addFilmDiffusion->bindValue("film_id", $film_id);
        $this->addFilmDiffusion->bindValue("date_diffusion", $date_diffusion);
        $this->addFilmDiffusion->execute();
    }

    public function del(int $id): void
    {
        $this->delFilmDiffusion->bindValue("id", $id, PDO::PARAM_INT);
        $this->delFilmDiffusion->execute();
    }
    public function get($film_id): DiffusionEntity | NULL
    {
        $this->getFilmDiffusion->bindValue("film_id", $film_id, PDO::PARAM_INT);
        $this->getFilmDiffusion->execute();
        $rawFilm = $this->getFilmDiffusion->fetch();

        // Si le produit n'existe pas, je renvoie NULL
        if (!$rawFilm) {
            return NULL;
        }
        return new DiffusionEntity(
            $rawFilm["id"],
            $rawFilm["film_id"],
            $rawFilm["date_diffusion"]
        );
    }

    public function getAll(int $limit = 50): array
    {
        $this->getAllFilmsDiffusions->bindValue("limit", $limit, PDO::PARAM_INT);
        $this->getAllFilmsDiffusions->execute();
        $rawFilms = $this->getAllFilmsDiffusions->fetchAll();

        $DiffusionEntity = [];
        foreach ($rawFilms as $rawFilm) {
            $DiffusionEntity[] = new DiffusionEntity(
                $rawFilm["id"],
                $rawFilm["film_id"],
                $rawFilm["date_diffusion"],
            );
        }
        return $DiffusionEntity;
    }
}


class DiffusionEntity
{
    public function __construct(
        private int $id,
        private int $film_id,
        private DateTime $date_diffusion
    ) {}

    //Setters
    public function setDateDifussion(DateTime $date_diffusion)
    {
        $this->date_diffusion = $date_diffusion;
    }
    public function setFilmId(int $film_id)
    {
        $this->film_id = $film_id;
    }
    //Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getFilmDiffusionId(int $film_id)
    {
        return $this->film_id;
    }
    public function getDateDiffusion(DateTime $date_diffusion)
    {
        return $this->date_diffusion;
    }
}
