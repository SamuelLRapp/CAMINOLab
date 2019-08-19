import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.HashMap;

public class CSVtoSQLTemplate
{
	public static void main(String[] args) throws FileNotFoundException
	{

    HashMap<String, Integer> Region = new HashMap<>();
    HashMap<String, Integer> Site = new HashMap<>();
    HashMap<String, Integer> Sampler = new HashMap<>();

    boolean FoundImage = true;

		//https://www.mkyong.com/java/how-to-read-and-parse-csv-file-in-java/ 
    //https://www.baeldung.com/java-buffered-reader
        String VouchercsvFile = "datasets/algae_checklist_2019_0814 - Copy4.csv";
        BufferedReader br = null;

        String ImagecsvFile = "datasets/Photo_Links_Sheet.csv";
        BufferedReader im = null;

        String Voucherline = ""; //prepping a string to read a csv line
        String ImageLine = "";
        String cvsSplitBy = ",";  // use comma as separator

        String[] ImageRow = new String[10];

         try {
            br = new BufferedReader(new FileReader(VouchercsvFile));
            im = new BufferedReader(new FileReader(ImagecsvFile));

            im.readLine(); //skips the first two lines in google sheets.
            im.readLine();

            while ((Voucherline = br.readLine()) != null) 
            {
            	String[] VoucherRow = new String[12]; 
              VoucherRow = Voucherline.split(cvsSplitBy);
              /*string array that stores each comma seperated part of the csv seperatly. 
				      VoucherRow[1]=site name, VoucherRow[2]=date_collected, etc*/
			       	//this way I can make seperate entries/table INSERTs more easily and controlled


                int length = VoucherRow[6].length();//VoucherRow[6] is the catalog number, in the Prionitis Excel Subset
             if(length == 4 && !VoucherRow[6].equals("NULL")) //if the Catalog number is the correct length
              {
                if(HashTableContains(Region, VoucherRow[4]) == false) //If region found new value
                { 
                System.out.println("INSERT INTO Region(Region) VALUES(" + "'" + VoucherRow[4] + "');"); //no need to specifiy Primary Key because it is auto incrementing
                }  

                if(HashTableContains(Site, VoucherRow[0]) ==false)
                {
                System.out.println("INSERT INTO Intertidal_sitename(Intertidal_sitename) VALUES(" + "'" + VoucherRow[0] + "');");
                }

                if(HashTableContains(Sampler, VoucherRow[2]) == false)
                {
                System.out.println("INSERT INTO Sampler(Sampler) VALUES(" + "'" + VoucherRow[2] + "');");
                }

                int regionNum =  HashTableUniqueInt(Region, VoucherRow[4]);
                int siteNum = HashTableUniqueInt(Site, VoucherRow[0]);
                int samplerNum = HashTableUniqueInt(Sampler, VoucherRow[2]);

                System.out.println("INSERT INTO Voucher(Catalog_number, Intertidal_sitename, Region, Sampler, Date, Voucher_name, Genus_Spp, Notes, Habitat, Transect, Binder_Letter, Page_Num) VALUES(" + "'" + VoucherRow[6] + "'," + siteNum + ", " + regionNum + ", " + samplerNum + ", '" + VoucherRow[1] + "', '" + VoucherRow[3] + "', '" + VoucherRow[5] + "', '" + VoucherRow[9] + "', '" + VoucherRow[11] + "', '" + VoucherRow[10] + "', '" + VoucherRow[8] + "', " + VoucherRow[7] + ");");
                 // //one is date_collected, voucher name = 3, genus = 5, notes = 10(out of bounds...)//I could just put the notes in index 9 and the scanned column in index 10, Letter=8, Page = 7
                String Nothing = new String("NULL");
  
          boolean NoMoreImages = false; 

          if(FoundImage == true) //boolean value, starts true
          { 
          //not equals nuLl!
          ImageLine = im.readLine();
           
          if (ImageLine == null) //The scanner has read every line of the google sheets file
            {
            NoMoreImages = true;
            }
            else
            {
            ImageRow = ImageLine.split(cvsSplitBy); 
            }
          
          }
           
          String Image_Catalog_Num = "";

if(NoMoreImages == false)
{
           if (ImageRow[0].length() == 8) //catalog number + .jpeg = 8 characters
              {
                  Image_Catalog_Num = ImageRow[0].substring(0, 4);
              }

           if(Image_Catalog_Num.equals(VoucherRow[6])) //if we find matching catalog numbers
                {
                  FoundImage = true; //we can go to a new line if Image CSV
                  System.out.println("INSERT INTO Images(Catalog_number, Scanned, Scan_Link) VALUES(" + "'" + VoucherRow[6] + "','" + VoucherRow[12] + "', '" + ImageRow[2] + "');");
                } 
                else
                {
                  System.out.println("INSERT INTO Images(Catalog_number, Scanned) VALUES(" + "'" + VoucherRow[6] + "','" + VoucherRow[12] + "');");
                  FoundImage = false;
                }
 }

          }

    }

      } 
        catch (FileNotFoundException e) 
        {
            e.printStackTrace();
        }
         catch (IOException e) 
         {
            e.printStackTrace();
        } finally 
            {
            if (br != null) 
                {
                try {
                    br.close();
                     } 
                catch (IOException e) 
                    {
                    e.printStackTrace();
                     }
            }
        }

    }

    public static int HashTableUniqueInt(HashMap<String, Integer> Hash, String Str)
     {
        int index;
        if(Hash.containsKey(Str))
        {
            int num = Hash.get(Str);
     //       System.out.println("Hashsize:" + Hash.size());
            return num;  
        }
        else
        {
           index = Hash.size()+1;
           Hash.put(Str, index);
        }

         //System.out.println("Hashsize-new:" + Hash.size());
        return index; 
     }

     public static boolean HashTableContains(HashMap<String, Integer> Hash, String Str)
     {
        if(Hash.containsKey(Str))
        {
        return true;
        }
        return false;
     }
}
