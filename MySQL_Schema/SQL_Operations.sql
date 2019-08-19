/*Playing with the data below*/


DROP TABLE Voucher;
DROP TABLE REGION;
DROP TABLE Intertidal_sitename;
DROP Table Sampler;
DROP TABLE IMAGES;

SELECT * FROM Voucher;
SELECT * FROM REGION;
SELECT * FROM Intertidal_sitename;
SELECT * FROM SAMPLER;
Select * from Images;

Delete from voucher;
Delete from region;
Delete from Intertidal_sitename;
DELETE FROM SAMPLER;

SET FOREIGN_KEY_CHECKS=0; /*turn foreign keys ooff-- SET FOREIGN_KEY_CHECKS=1; turn it back on*/
SET FOREIGN_KEY_CHECKS=1;

/*ALTER TABLE Region AUTO_INCREMENT=2;*/

SELECT TABLE_NAME  /*what tables are in the database*/
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='Prionitistest';


SELECT VOUCHER.CATALOG_NUMBER, VOUCHER.GENUS_SPP,  SAMPLER.SAMPLER, region.region, Intertidal_sitename.Intertidal_sitename, Images.Scan_Link
From Voucher
join SAMPLER 
on SAMPLER.SAMPLER_NUMBER = VOUCHER.SAMPLER
join REGION
on VOUCHER.REGION = REGION.REGION_NUMBER
join Intertidal_sitename
on voucher.Intertidal_sitename=Intertidal_sitename.Site_number
join Images
on images.catalog_number = Voucher.catalog_number
WHERE region.region like '%%' and  Intertidal_sitename.Intertidal_sitename like '%%' and voucher.genus_spp like '%%'
ORDER BY VOUCHER.CATALOG_NUMBER;

select * 
from voucher;
