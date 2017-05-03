-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  nimi varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  salasana varchar(50) NOT NULL
);


CREATE TABLE Kategoria (
id SERIAL PRIMARY KEY,
nimi varchar(50) NOT NULL,
kuvaus varchar(400),
lisays DATE,
kayttaja_id INTEGER REFERENCES Kayttaja(id)
);

CREATE TABLE Askare(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  nimi varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  --status boolean DEFAULT FALSE,
  kuvaus varchar(400),
  lisays DATE,
  deadline DATE
);


CREATE TABLE AskareenKategoria(
kategoria_id INTEGER REFERENCES Kategoria(id),
askare_id INTEGER REFERENCES Askare(id)
);


