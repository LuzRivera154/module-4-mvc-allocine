<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Films</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .items {
            display: flex;
            background: green;
            text-align: center;
            width: 15rem;
  height: 10rem;
        }
    </style>
</head>

<body>
    <h2>Films</h2>
    <section class="container">
        <?php foreach ($films as $film): ?>
            <div class="items">
                <p>Nombre: <?= $film->getNom() ?></p>
                <p>Date sortie: <?= $film->getDateSortie()->format('Y-m-d') ?></p>
                <p>Genre: <?= $film->getGenre() ?></p>
                <p>Auteur: <?= $film->getAuteur() ?></p>
            </div>
        <? endforeach; ?>
    </section>
</body>

</html>