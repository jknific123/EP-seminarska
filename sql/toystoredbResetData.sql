USE toystoredb;

-- za lazje vstavljanje
SET FOREIGN_KEY_CHECKS = 0;
-- resetiramo vse tabele
TRUNCATE uporabnik;
TRUNCATE narocilo;
TRUNCATE artikel;
TRUNCATE artikelnarocilo;

-- vstavljanje nekaj zacetnih uporabnikov.

-- za varnost so gesla hashana. #TODO HASH
INSERT INTO uporabnik(uporabnik_ime, uporabnik_priimek, uporabnik_email, uporabnik_geslo, uporabnik_naslov, uporabnik_vrsta) 
VALUES ("Nika", "Kralj", "nikak@gmail.com", "geslo123", "Kanal 100", "administrator");

INSERT INTO uporabnik(uporabnik_ime, uporabnik_priimek, uporabnik_email, uporabnik_geslo, uporabnik_naslov, uporabnik_vrsta) 
VALUES ("Gašper", "Kirbiš", "kirba@gmail.com", "geslo1234", "Trojica 123", "stranka");

INSERT INTO uporabnik(uporabnik_ime, uporabnik_priimek, uporabnik_email, uporabnik_geslo, uporabnik_naslov, uporabnik_vrsta) 
VALUES ("Jernej", "Knific", "knifo@gmail.com", "geslo12345", "Slovenski naslov 99", "prodajalec");

-- vstavljanje nekaj zacetnik artiklov.

INSERT INTO artikel(artikel_ime, artikel_cena, artikel_opis)
VALUES("Lego kocka 1", 14.4, "Prvi set, 100 kock v kompletu rdeče barve");

INSERT INTO artikel(artikel_ime, artikel_cena, artikel_opis)
VALUES("Tovornjaček", 9.99, "Igračka, nosljivost: 7 kg, velika prikolica za frnikule");

INSERT INTO artikel(artikel_ime, artikel_cena, artikel_opis)
VALUES("Herkules", 9.99, "Figura, premikajoče roke in noge, lesena");

