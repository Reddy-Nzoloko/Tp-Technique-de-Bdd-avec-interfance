-- les premières tables de la Bdd 
-- 1. STRUCTURE ORGANISATIONNELLE (Multi-Hôpital)
CREATE TABLE Organisation (
    idOrganisation INT AUTO_INCREMENT PRIMARY KEY, -
    nomOrganisation VARCHAR(100) NOT NULL 
);

CREATE TABLE Site (
    idSite INT AUTO_INCREMENT PRIMARY KEY, 
    nomSite VARCHAR(100) NOT NULL,
    idOrganisation INT REFERENCES Organisation(idOrganisation) ON DELETE CASCADE 

CREATE TABLE Service (
    idService INT AUTO_INCREMENT PRIMARY KEY, 
    nomService VARCHAR(100) NOT NULL,
    idSite INT REFERENCES Site(idSite) ON DELETE CASCADE, 
    codePrefixe VARCHAR(5) 
);

-- la vue pour notre selection
CREATE VIEW vue_structure_complete AS
SELECT 
    o.idOrganisation,
    o.nomOrganisation,
    si.idSite,
    si.nomSite,
    se.idService,
    se.nomService,
    se.codePrefixe
FROM Organisation o
LEFT JOIN Site si ON o.idOrganisation = si.idOrganisation
LEFT JOIN Service se ON si.idSite = se.idSite;