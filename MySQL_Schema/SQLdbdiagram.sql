Table Voucher{
  Catalog_number VARCHAR(4) [primary key] 
  Intertidal_sitename INT [ref: > Intertidal_sitename.Site_number]
  Region INT [ref: > Region.Region_number]
  Sampler INT [ref: > Sampler.Sampler_number]
  Date VARCHAR(20) [note: "/*WILL BE TURNED INTO DATATYPE: DATE, LATER*/"]
  Voucher_name VARCHAR(50), [note: "/*identity when vouchered */"]
  Genus_Spp VARCHAR(50), [note: "/*labb identity*/"]
  Notes VARCHAR(200) [note: "DEFAULT 'No Notes'"] 
  Habitat VARCHAR(200) [note: "DEFAULT 'No Info'"] 
  Transect VARCHAR(35) 
  Binder_Letter VARCHAR(1)
  Page_Num INT
}

TABLE Intertidal_sitename{
Site_number INT [primary key]
Intertidal_sitename VARCHAR(30) UNIQUE
}

TABLE Region{
Region_number int [primary key] 
Region VARCHAR(75) UNIQUE
}

TABLE Sampler{
Sampler_number INT [primary key]
Sampler VARCHAR(40) UNIQUE
}

TABLE Images{
Catalog_number VARCHAR(4) [primary key]
Scanned VARCHAR(40) 
Scan_Link VARCHAR(175)

}

ref: Voucher.Catalog_number > Images.Catalog_number