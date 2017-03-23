-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  nimi varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL
);

CREATE TABLE Askare(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  nimi varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  tehty boolean DEFAULT FALSE,
  description varchar(400),
  added DATE,
  deadline DATE
);
