# Documentation Base de Données — SAE 2.03

Auteur : Nicolas Varachaud
Date : 2026-05-07

## 1. Présentation

La base de données `SAE203` héberge l'ensemble des données de la plateforme VOD : films, catégories, profils utilisateurs et favoris.

Elle est composée de **4 tables** :
- `Category` — les genres de films
- `Movie` — les films du catalogue
- `Profile` — les profils utilisateurs
- `Favorite` — table de liaison entre les profils et leurs films favoris

Le modèle complet est visible dans le fichier `SAE203.loo` (Looping) et la capture d'écran `looping_capture.png`.

## 2. Justifications des choix

### Tables et clés primaires
- Toutes les clés primaires sont des entiers auto-incrémentés (`INT(11) AUTO_INCREMENT`). Cette pratique est standard MySQL et évite à l'admin de gérer manuellement les identifiants.
- La table `Favorite` utilise une **clé primaire composite** (`id_profile`, `id_movie`) car un favori est défini de manière unique par le couple profil+film.

### Types de données
| Type SQL | Utilisé pour | Pourquoi |
|---|---|---|
| `INT(11)` | Clés primaires, ids, durées, années, âges | Standard pour les valeurs numériques |
| `VARCHAR(255)` | Noms, titres, URLs, noms de fichiers | Limite standard MySQL, suffisant pour la plupart des chaînes |
| `TEXT` | `Movie.description` | Synopsis pouvant dépasser 255 caractères |
| `TINYINT(1)` | `Movie.is_featured` | Booléen 0/1, plus économe qu'un INT |

### Charset
Toutes les tables utilisent `utf8` pour gérer les accents (Comédie, Fantaisie, Émilie...).

### Clés étrangères
- `Movie.id_category` → `Category.id` (un film a une catégorie)
- `Favorite.id_profile` → `Profile.id` (intégrité référentielle)
- `Favorite.id_movie` → `Movie.id` (intégrité référentielle)

## 3. Cardinalités

### Movie ↔ Category
- Un film appartient à **exactement une** catégorie : `(1,1)` côté Movie.
- Une catégorie peut contenir **0 ou plusieurs** films : `(0,n)` côté Category.
- Implémentation : clé étrangère `id_category` dans la table Movie.

### Profile ↔ Movie (via Favorite)
- Un profil peut avoir **0 ou plusieurs** films favoris : `(0,n)` côté Profile.
- Un film peut être favori chez **0 ou plusieurs** profils : `(0,n)` côté Movie.
- Cette relation **plusieurs-à-plusieurs** nécessite une **table de liaison** : `Favorite`.
- Implémentation : table `Favorite` avec clé primaire composite `(id_profile, id_movie)`.

## 4. Requêtes SQL par itération

### Itération 1 — [APP] Liste des films
Récupère la liste des films avec uniquement les informations strictement nécessaires (id, titre, image), conformément à l'ATTENTION de la spec.

```sql
SELECT id, name, image FROM Movie
```

### Itération 2 — [ADMIN] Ajout d'un film
Insertion d'un film à partir des données du formulaire admin.

```sql
INSERT INTO Movie (name, year, length, description, director, id_category, image, trailer, min_age)
VALUES (:name, :year, :length, :description, :director, :id_category, :image, :trailer, :min_age)
```

### Itération 3 — [APP] Détail d'un film
Récupération du détail d'un film avec le nom de sa catégorie. Utilisation d'un `JOIN` pour faire la liaison entre les tables Movie et Category.

```sql
SELECT Movie.id, Movie.name, year, length, description, director, image, trailer, min_age, Category.name AS category
FROM Movie
JOIN Category ON Movie.id_category = Category.id
WHERE Movie.id = :id
```

### Itération 4 — [APP] Films groupés par catégorie
Récupère les films triés par catégorie. Le groupage est fait côté PHP avec une boucle `foreach` qui range chaque film dans son tableau de catégorie.

```sql
SELECT Movie.id, Movie.name, Movie.image, Category.name AS category
FROM Movie
JOIN Category ON Movie.id_category = Category.id
ORDER BY Category.name
```

### Itération 5 — [ADMIN] Ajout d'un profil
**Modification de la base** : création de la table `Profile`.

```sql
CREATE TABLE Profile (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  avatar VARCHAR(255) DEFAULT NULL,
  min_age INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

Insertion d'un profil :
```sql
INSERT INTO Profile (name, min_age) VALUES (:name, :min_age)
```

### Itération 6 — [APP] Sélection d'un profil
Récupère la liste de tous les profils, triés par nom.

```sql
SELECT id, name, avatar, min_age FROM Profile ORDER BY name
```

### Itération 7 — [APP] Filtrage par âge du profil
La requête de l'itération 4 est complétée avec une clause `WHERE` filtrant sur `min_age` pour ne conserver que les films adaptés à l'âge du profil sélectionné.

```sql
SELECT Movie.id, Movie.name, Movie.image, Category.name AS category
FROM Movie
JOIN Category ON Movie.id_category = Category.id
WHERE Movie.min_age <= :age
ORDER BY Category.name
```

### Itération 8 — [ADMIN] Modification d'un profil
Mise à jour des informations d'un profil existant.

```sql
UPDATE Profile SET name = :name, min_age = :min_age WHERE id = :id
```

### Itération 9 — [APP] Ajout d'un film aux favoris
**Modification de la base** : création de la table de liaison `Favorite`.

```sql
CREATE TABLE Favorite (
  id_profile INT(11) NOT NULL,
  id_movie INT(11) NOT NULL,
  PRIMARY KEY (id_profile, id_movie),
  FOREIGN KEY (id_profile) REFERENCES Profile(id),
  FOREIGN KEY (id_movie) REFERENCES Movie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

Vérification qu'un favori n'existe pas déjà avant insertion :
```sql
SELECT id_profile FROM Favorite WHERE id_profile = :id_profile AND id_movie = :id_movie
```

Si pas trouvé, insertion :
```sql
INSERT INTO Favorite (id_profile, id_movie) VALUES (:id_profile, :id_movie)
```

Lecture des favoris d'un profil (avec JOIN pour récupérer les infos des films) :
```sql
SELECT Movie.id, Movie.name, Movie.image
FROM Favorite
JOIN Movie ON Favorite.id_movie = Movie.id
WHERE Favorite.id_profile = :id_profile
ORDER BY Movie.name
```

### Itération 10 — [APP] Retrait d'un favori
Suppression d'un favori spécifique.

```sql
DELETE FROM Favorite WHERE id_profile = :id_profile AND id_movie = :id_movie
```

### Itération 11 — [APP] Films mis en avant
**Modification de la base** : ajout d'une colonne `is_featured` à la table Movie.

```sql
ALTER TABLE Movie ADD COLUMN is_featured TINYINT(1) NOT NULL DEFAULT 0
```

Récupération des films marqués comme mis en avant et adaptés à l'âge du profil :
```sql
SELECT id, name, image, description
FROM Movie
WHERE is_featured = 1 AND min_age <= :age
ORDER BY name
```

### Itération 12 — [APP] Statistiques
Cinq requêtes simples pour calculer chacune des métriques affichées sur la page de statistiques.

Nombre total de profils :
```sql
SELECT COUNT(*) AS cnt FROM Profile
```

Nombre total de films :
```sql
SELECT COUNT(*) AS cnt FROM Movie
```

Nombre de favoris par profil (la moyenne est calculée ensuite en PHP avec une boucle `foreach`) :
```sql
SELECT id_profile, COUNT(*) AS cnt FROM Favorite GROUP BY id_profile
```

Nombre de fois où chaque film est en favori (le maximum est calculé en PHP avec une boucle `foreach`) :
```sql
SELECT Movie.name AS name, COUNT(*) AS cnt
FROM Favorite
JOIN Movie ON Favorite.id_movie = Movie.id
GROUP BY Movie.id, Movie.name
```

Nombre de favoris par catégorie (le maximum est calculé en PHP) :
```sql
SELECT Category.name AS name, COUNT(*) AS cnt
FROM Favorite
JOIN Movie ON Favorite.id_movie = Movie.id
JOIN Category ON Movie.id_category = Category.id
GROUP BY Category.id, Category.name
```

## 5. Résumé des modifications successives de la base

| Itération | Modification |
|---|---|
| Itér. 1 (départ) | Tables `Category` et `Movie` fournies par le starter |
| Itér. 5 | Création de la table `Profile` |
| Itér. 9 | Création de la table de liaison `Favorite` |
| Itér. 11 | Ajout de la colonne `is_featured` (TINYINT) à la table `Movie` |

## 6. Capture du modèle Looping

Voir le fichier `looping_capture.png` du dossier.

Le fichier `.loo` natif de Looping est également fourni : `SAE203.loo`.
