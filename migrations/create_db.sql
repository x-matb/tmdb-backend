CREATE TABLE Movies (
  id INT NOT NULL PRIMARY KEY,
  name VARCHAR(255),
  image VARCHAR(255),
  release_date DATE,
  overview TEXT
);
CREATE INDEX name_index on Movies (name);

CREATE TABLE Genres (
  id INT NOT NULL PRIMARY KEY,
  name VARCHAR(255)
);

CREATE TABLE MoviesGenres (
  movie_id INT NOT NULL,
  genre_id INT NOT NULL,
  FOREIGN KEY (movie_id) REFERENCES Movies(id) ON DELETE CASCADE,
  FOREIGN KEY (genre_id) REFERENCES Genres(id) ON DELETE CASCADE
);