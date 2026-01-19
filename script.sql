-- les premières tables de la Bdd 
-- 1. STRUCTURE ORGANISATIONNELLE (Multi-Hôpital)
CREATE TABLE Organisation (
    idOrganisation INT AUTO_INCREMENT PRIMARY KEY, -- [cite: 60, 78]
    nomOrganisation VARCHAR(100) NOT NULL -- [cite: 60, 79]
);

CREATE TABLE Site (
    idSite INT AUTO_INCREMENT PRIMARY KEY, -- [cite: 61, 83]
    nomSite VARCHAR(100) NOT NULL, -- [cite: 61, 84]
    idOrganisation INT REFERENCES Organisation(idOrganisation) ON DELETE CASCADE -- [cite: 61, 85]
);

CREATE TABLE Service (
    idService INT AUTO_INCREMENT PRIMARY KEY, -- [cite: 62, 89]
    nomService VARCHAR(100) NOT NULL, -- [cite: 62, 90]
    idSite INT REFERENCES Site(idSite) ON DELETE CASCADE, -- [cite: 62, 91]
    codePrefixe VARCHAR(5) -- Ajout Pro pour les tickets (ex: 'CARD')
);
