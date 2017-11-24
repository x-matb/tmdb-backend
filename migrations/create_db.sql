CREATE TABLE Movies (
  id INT NOT NULL PRIMARY KEY,
  name VARCHAR(255),
  image VARCHAR(255),
  release_date DATE,
  overview TEXT
);
CREATE INDEX name_index on Movies (name);