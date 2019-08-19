

CREATE TABLE Voucher(
Catalog_number VARCHAR(4) PRIMARY KEY,
Intertidal_sitename INT,
Region INT,
Sampler INT, 
Date VARCHAR(20)/*WILL BE TURNED INTO DATATYPE: DATE or date, or datetime LATER*/, 
Voucher_name VARCHAR(50), /*identity when vouchered */
Genus_Spp VARCHAR(100), /*lab identity*/
Notes VARCHAR(200) DEFAULT 'No Notes',
Habitat VARCHAR(200) DEFAULT 'No Info', /*have to remove all "'" info from that excel data*/
Transect VARCHAR(50),
Binder_Letter VARCHAR(5),
Page_Num INT
);


CREATE TABLE Intertidal_sitename(
Site_number INT PRIMARY KEY AUTO_INCREMENT,
Intertidal_sitename VARCHAR(40) UNIQUE
);

CREATE TABLE Region(
Region_number int PRIMARY KEY AUTO_INCREMENT,
Region VARCHAR(75) UNIQUE
);

CREATE TABLE Sampler(
Sampler_number INT PRIMARY KEY AUTO_INCREMENT,
Sampler VARCHAR(40) UNIQUE
);

CREATE TABLE Images(
Catalog_number VARCHAR(4) PRIMARY KEY,
Scanned VARCHAR(40), /*should correct the excel file to only have Y/NULL in it. so varcharr can be 3 not 20*/
Scan_Link Varchar(175) DEFAULT 'No Scan'
);


ALTER TABLE Images
ADD FOREIGN KEY (Catalog_number)
REFERENCES Voucher(Catalog_number) 
ON DELETE CASCADE; /*USE CASCADE BC THE FOREIGN KEY IS A PRIMARY KEY*/

ALTER TABLE Voucher /*Foreign key relations between tables*/
ADD FOREIGN KEY (Intertidal_sitename)
REFERENCES Intertidal_sitename(Site_number)
ON DELETE SET NULL;

ALTER TABLE Voucher
ADD FOREIGN KEY(Region)
REFERENCES Region(Region_number)
ON DELETE SET NULL;

ALTER TABLE Voucher
ADD FOREIGN KEY(Sampler) 
REFERENCES Sampler(Sampler_number) 
ON DELETE SET NULL;

/*Creating the structure/relationships above*/



